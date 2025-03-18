<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    redirect();

require_once __DIR__ . '/../config.php';
require_once MATRIX_DOC_ROOT . 'database.php';
require_once DOC_ROOT . 'qrlib/barcode.php';
foreach (glob(__DIR__ . "/helpers/*.php") as $helper)
    require_once $helper;

match ($_POST['accion']) {
    'crear' => store(),
    'ver' => show(),
    'editar' => edit(),
    'actualizar' => update(),
    'eliminar' => destroy(),
    default => redirect()
};

function redirect()
{
    $redirect_ulr = $_SERVER['HTTP_REFERER'] ?? MATRIX_HTTP_VIEWS . 'dashboard';
    header("Location: $redirect_ulr");
    exit;
}

function store()
{
    unset($_POST['accion']);

    $olds = $_POST;
    $errors = [];

    // VALIDAR CAMPOS VACÍOS
    $data = array_map(fn($value) => clearEntry($value) ?: null, $_POST);
    foreach ($_POST as $key => $dato) {
        $olds[$key] = $dato;

        if (!$dato)
            $errors[$key] = "El campo " . str_replace(['-', '_'], ' ', $key) . " es obligatorio";
    }

    $_SESSION['olds'] = $olds;

    // VALIDAR SI HAY ERRORES
    if (count($errors) === count($_POST)) {
        $_SESSION['swal'] = swal('warning', '¡Los campos son obligatorios!');
        redirect();
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        redirect();
    }

    // VALIDAR EL FORMATO DE LOS CAMPOS
    !validateNames($_POST['nombres']) ? $errors['nombres'] = 'Solo se permiten letras y espacios' : '';

    !validateLastNames($_POST['apellidos']) ? $errors['apellidos'] = 'Solo se permiten letras y espacios' : '';

    !validateEmail($_POST['correo']) ? $errors['correo'] = 'Correo electrónico no válido' : '';

    !validateCellPhone($_POST['telefono']) ? $errors['telefono'] = 'Número de teléfono no válido' : '';

    // !validateCurp($post_data['curp']) ? $errors['curp'] = 'CURP no válido' : '';

    // !validateUserLevel((int)$_POST['usuario_nivel']) ? $errors['usuario_nivel'] = 'Nivel de usuario no permitido' : '';

    $token = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
    $pass = generarPassword();
    $nivel_usuario = '3';
    $status_credencial = 1;

    $post_data = [
        'sucursal' => (int)clearEntry(decryptValue($_POST['id_sucursal'] ?? '', SECRETKEY) ?? '') ?? null,
        'usuario_nivel' => encryptValue(clearEntry($nivel_usuario), SECRETKEY) ?? null,
        'nombres' => clearEntry($_POST['nombres'] ?? ''),
        'apellidos' => clearEntry($_POST['apellidos'] ?? ''),
        'curp' => clearEntry(encryptValue($_POST['curp'] ?? '', SECRETKEY) ?? '') ?? null,
        'telefono' => clearEntry(encryptValue($_POST['telefono'] ?? '', SECRETKEY) ?? '') ?? null,
        'correo_electronico' => clearEntry(encryptValue($_POST['correo'] ?? '', SECRETKEY) ?? '') ?? null,
        'pass' => encryptValue($pass, SECRETKEY) ?? null,
        'token_verificacion' => encryptValue($token, SECRETKEY) ?? null,
        'status_credencial' => (int)$status_credencial,
    ];

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        redirect();
    }

    if (!simpleQuery('
        SELECT id_sucursal
        FROM sucursales
        WHERE id_sucursal = ?
    ', [$post_data['sucursal']],'i')) {
        $_SESSION['swal'] = swal('error', '¡Sucursal no válida!');
        redirect();
    }

    if (simpleQuery('
        SELECT id_credencial
        FROM credenciales WHERE telefono_credencial = ?
    ', [$post_data['telefono']], 's')) {
        $_SESSION['swal'] = swal('warning', '¡Número telefónico ya vinculado!');
        redirect();
    }

    if (simpleQuery('
        SELECT id_credencial
        FROM credenciales WHERE correo_inicio = ?
    ', [$post_data['correo_electronico']], 's')) {
        $_SESSION['swal'] = swal('warning', '¡Correo electrónico ya vinculado!');
        redirect();
    }

    if (simpleQuery('
        SELECT id_credencial
        FROM credenciales WHERE curp_credencial = ?
    ', [$post_data['curp']], 's')) {
        $_SESSION['swal'] = swal('warning', '¡CURP ya vinculado!');
        redirect();
    }

    $index_arr = array_values($post_data);

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

function edit()
{

}

function update()
{

}

function destroy()
{

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

function validateNames($nombre) {
    return !empty($nombre) ? preg_match("/^[a-zA-Z\s]+$/", $nombre) : true;
}

function validateLastNames($apellidos) {
    return !empty($apellidos) ? preg_match("/^[a-zA-Z\s]+$/", $apellidos) : true;
}

function validateEmail($correo) {
    return !empty($correo) ? filter_var($correo, FILTER_VALIDATE_EMAIL) !== false : true;
}

function validateCellPhone($telefono) {
    return !empty($telefono) ? preg_match('/^\+?[0-9]{1,4}?[-.\s]?[0-9]{1,15}$/', $telefono) : true;
}

function validateCurp($curp) {
    return !empty($curp) ? preg_match('/^[A-Z]{4}[0-9]{6}[HM]{1}[A-Z]{2}[A-Z]{3}[0-9A-Z]{1}[0-9]{1}$/', strtoupper($curp)) : true;
}

function validateUserLevel($nivel) {
    return !empty($nivel) ? is_numeric($nivel) && $nivel >= 1 && $nivel <= 3 : true;
}
