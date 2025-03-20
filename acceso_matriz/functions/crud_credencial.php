<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    redirect();

require_once __DIR__ . '/../config.php';
require_once MATRIX_DOC_ROOT . 'database.php';
require_once DOC_ROOT . 'qrlib/barcode.php';
foreach (glob(__DIR__ . "/helpers/*.php") as $helper)
    require_once $helper;

if ($_SERVER['REQUEST_METHOD'] === 'POST')

    match($_POST['accion']) {
        'guardar' => store(),
        'actualizar' => update(),
        'status' => changeStatus(),
        default => redirect(),
    };

else if ($_SERVER['REQUEST_METHOD'] === 'GET')

    (!empty($_GET['c']) && $_GET['accion'] === 'detalles') ? show() : redirect_json('¡Datos incompletos!');

else redirect_json('¡Acceso denegado!', 'error');


function redirect()
{
    $redirect_ulr = $_SERVER['HTTP_REFERER'] ?? MATRIX_HTTP_VIEWS . 'dashboard';
    header("Location: $redirect_ulr");
    exit;
}

function redirect_json($message = '¡Ocurrió un error!', $status = 'error')
{
    header('Content-Type: application/json');

    echo json_encode(['status' => $status, 'message' => $message]);
    exit;
}


function store()
{
    unset($_POST['accion']);

    $olds = $_POST;
    $errors = [];

    $data = array_map(fn($value) => clearEntry($value) ?: null, $_POST);
    $data['id_sucursal'] = $_POST['id_sucursal'] ?? null;

    $empty_fields = array_filter($data, fn($value) => empty($value));

    foreach ($empty_fields as $key => $value)
        $errors[$key] = "El campo " . str_replace(['-', '_'], ' ', $key) . " es obligatorio";

    if (count($errors) === count($olds)) {
        $_SESSION['swal'] = swal('warning', '¡Los campos son obligatorios!');
        redirect();
    }

    $_SESSION['olds'] = $olds;

    (!empty($data['nombres']) && !onlyLetters($data['nombres'])) ? $errors['nombres'] = 'Solo se permiten letras y espacios' : '';

    (!empty($data['apellidos']) && !onlyLetters($data['apellidos'])) ? $errors['apellidos'] = 'Solo se permiten letras y espacios' : '';

    (!empty($data['correo']) && !validateEmail($data['correo'])) ? $errors['correo'] = 'Correo electrónico no válido' : '';

    (!empty($data['telefono']) && !validateCellPhone($data['telefono'])) ? $errors['telefono'] = 'Número de teléfono no válido' : '';

    // (!empty($data['curp']) && !validateCurp($data['curp'])) ? $errors['curp'] = 'CURP no válido' : '';

    // (!empty($data['nivel_usuario']) && !validateUserLevel((int)$data['nivel_usuario'])) ? $errors['nivel_usuario'] = 'Nivel de usuario no permitido' : '';

    $fields_length_rules = [
        'nombres' => [3, 30],
        'apellidos' => [5, 40],
        'telefono' => [7, 15],
        'correo' => [10, 80]
    ];

    foreach ($fields_length_rules as $field => [$min, $max]) {
        if (!empty($data[$field])) {
            if (inputMinLenght($data[$field], $min))
                $errors[$field] = "Mínimo $min caracteres";

            if (inputMaxLenght($data[$field], $max))
                $errors[$field] = "Máximo $max caracteres";
        }
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        redirect();
    }

    $nivel_usuario = encryptValue('3', SECRETKEY) ?? null;
    $pass = generarPassword();
    $token = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
    $status_credencial = '0';

    $generate_data = [
        'nivel_usuario' => $nivel_usuario,
        'pass' => encryptValue($pass, SECRETKEY) ?? null,
        'token_verificacion' => encryptValue($token, SECRETKEY) ?? null,
        'status_credencial' => (int)$status_credencial,
    ];

    $merge_data = [
        'sucursal' => (int)decryptValue($data['id_sucursal'], SECRETKEY) ?? '',
        'nivel_usuario' => $generate_data['nivel_usuario'],
        'nombres' => $data['nombres'],
        'apellidos' => $data['apellidos'],
        'curp' => $data['curp'],
        'telefono' => (string)$data['telefono'],
        'correo_electronico' => $data['correo'],
        'pass' => $generate_data['pass'],
        'token_verificacion' => $generate_data['token_verificacion'],
        'status_credencial' => $generate_data['status_credencial']
    ];

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        redirect();
    }

    if (!simpleQuery('SELECT id_sucursal FROM sucursales WHERE id_sucursal = ?', [$merge_data['sucursal']],'i')) {
        $_SESSION['swal'] = swal('error', '¡Sucursal no válida!');
        redirect();
    }

    $sql = '
        SELECT curp_credencial, telefono_credencial, correo_inicio
        FROM credenciales
        WHERE curp_credencial = ?
        OR telefono_credencial = ?
        OR correo_inicio = ?
    ';

    $credential_exists = simpleQuery($sql, [$merge_data['curp'], $merge_data['telefono']. $merge_data['correo_electronico']], 'sss', true)[0] ?? '';

    if ($credential_exists) {
        if ($credential_exists['curp_credencial'] === $merge_data['curp'])
            $_SESSION['swal'] = swal('warning', '¡CURP ya vinculado!');

        if ($credential_exists['telefono_credencial'] === $merge_data['telefono'])
        $_SESSION['swal'] = swal('warning', '¡Número telefónico ya vinculado!');

        if ($credential_exists['correo_inicio'] === $merge_data['correo_electronico'])
            $_SESSION['swal'] = swal('warning', '¡Correo electrónico ya vinculado!');

        redirect();
    }

    $index_arr = array_values($merge_data);

    // CREAR CREDENCIAL
    startTransaction();

    global $conn;

    $sql = '
        INSERT INTO credenciales (
            id_sucursal_fk_credencial,
            nivel_usuario,
            nombres_credencial,
            apellidos_credencial,
            curp_credencial,
            telefono_credencial,
            correo_inicio,
            pass_inicio,
            token_verificacion,
            status_credencial
        )
        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ';

    if (!simpleQuery($sql, $index_arr, 'issssssssi')) {
        $_SESSION['swal'] = swal('error', '¡Ocurrió un error al registrar al usuario!');
        rollbackTransaction();
        redirect();
    }

    $credential_id = $conn -> insert_id;

    // CREAR QR CON EL ID DE LA CREDENCIAL ANTES CREADA
    $qrs_doc_path = DOC_ROOT . 'imgs_qrcodes/';
    $qrs_http_path = HTTP_URL . 'imgs_qrcodes/';
    $qr_png_name = "qr_$credential_id.png";
    $qr_png_path = "{$qrs_doc_path}{$qr_png_name}";

    if (!file_exists($qrs_doc_path))
        mkdir($qrs_doc_path, 0777, true);

    $generator = new barcode_generator();
    $options = [
        'version' => 5,
        'scale' => 10,
        'errorCorrectionLevel' => 'H',
    ];
    $image = $generator -> render_image('qr', encryptValue($credential_id, SECRETKEY), $options);

    imagepng($image, $qr_png_path);
    imagedestroy($image);

    if (!file_exists($qr_png_path)) {
        $_SESSION['swal'] = swal('error', '¡No se pudo generar el QR!');
        rollbackTransaction();
        redirect();
    }

    $qr_webp_name = createWebpImage($qr_png_name, $qrs_doc_path);
    if (!$qr_webp_name) {
        $_SESSION['swal'] = swal('error', '¡No se pudo generar el QR!');
        destroyImage($qr_png_name);
        rollbackTransaction();
        redirect();
    }

    destroyImage($qr_png_name);

    $horaActual = new DateTime();
    $formatDateTime = $horaActual -> format('Y-m-d H:i:s');

    // CREAR REGISTRO DEL QR ANTES GENERADO
    $sql = "
        INSERT INTO qr_codes (id_credencial_fk_qr_code, file_path, created_at)
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE
        file_path = VALUES(file_path),
        created_at = VALUES(created_at)
    ";

    if (!simpleQuery($sql, [(int)$credential_id, "$qrs_http_path$qr_webp_name", $formatDateTime], 'iss')) {
        $_SESSION['swal'] = swal('error', '¡No se pudo almacenar el QR!');
        rollbackTransaction();
        destroyImage($qr_png_name);
        redirect();
    }

    $_SESSION['swal'] = swal('success', '¡Credencial y QR creados con éxito!', '', 4000);
    $_SESSION['userAuthInfo'] = [
        'qr' => "$qrs_http_path$qr_webp_name",
        'pass' => $pass,
        'token' => $token,
    ];

    unset($_SESSION['olds']);
    unset($_SESSION['errors']);

    commitTransaction();
    redirect();
}

function show()
{

}


function update()
{

}



function changeStatus()
{
    try {
        header('Content-Type: application/json');

        $id = (int)decryptValue($_POST['c'] ?? '', SECRETKEY) ?? '';
        if (!$id) redirect_json('¡Credencial no válida!');

        $sql = 'SELECT status_credencial FROM credenciales WHERE id_credencial = ?';

        $brand = simpleQuery($sql, [$id], 'i', true)[0] ?? null;
        if (!$brand) redirect_json('¡Credencial no encontrada!');

        $current_status = (int)$brand['status_credencial'];
        $new_status = ($current_status === 0) ? 1 : 0;

        $sql = 'UPDATE credenciales SET status_credencial = ? WHERE id_credencial = ?';

        !simpleQuery($sql, [$new_status, $id], 'ii')
            ? redirect_json('¡No se pudo actualizar el status!', 'error')
            : redirect_json('¡Status actualizado!', 'success');

    } catch (Exception $e) {
        redirect_json($e -> getMessage(), 'warning');
    }
}


function generarPassword($longitud = 12) {
    $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()-_';
    $bytes = random_bytes($longitud);
    $password = '';

    for ($i = 0; $i < $longitud; $i++)
        $password .= $caracteres[ord($bytes[$i]) % strlen($caracteres)];

    return $password;
}

function createWebpImage($filename, $doc_path)
{
    $imagen = imagecreatefrompng("$doc_path$filename");
    $new_filename = str_replace(['.png', '.jpg', 'jpeg'], '.webp', $filename);

    imagewebp($imagen, "$doc_path$new_filename", 100);
    imagedestroy($imagen);

    return $new_filename ?: false;
}

function destroyImage($file_name)
{
    $path = DOC_ROOT . 'imgs_qrcodes/';

    if (file_exists("$path$file_name"))
        unlink("$path$file_name");
}

function validateUserLevel($nivel) {
    return !empty($nivel) ? is_numeric($nivel) && $nivel >= 1 && $nivel <= 3 : true;
}
