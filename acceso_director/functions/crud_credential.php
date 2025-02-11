<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    redirect();

require_once 'database.php';
require_once '../../qrlib/barcode.php';
foreach(glob(__DIR__ . '/helpers/*.php') as $helper)
    require_once $helper;

match ($_POST['accion']) {
    'crear' => create(),
    'ver' => show(),
    'editar' => edit(),
    'actualizar' => update(),
    'eliminar' => destroy(),
    default => redirect()
};

function redirect()
{
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}

function create()
{
    session_start();
    global $conn;

    $token = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
    $pass = bin2hex(random_bytes(15));
    $nivel_usuario = '3';

    $data = [
        'usuario_nivel' => encryptValue(clearEntry($nivel_usuario), SECRETKEY) ?? null,
        'nombres' => clearEntry($_POST['nombres'] ?? ''),
        'apellidos' => clearEntry($_POST['apellidos'] ?? ''),
        'curp' => clearEntry($_POST['curp'] ?? ''),
        'telefono' => clearEntry($_POST['telefono'] ?? ''),
        'correo' => clearEntry($_POST['correo'] ?? ''),
        'pass' => $pass,
        'token_verificacion' => encryptValue($token, SECRETKEY),
        'id_sucursal' => clearEntry($_POST['id_sucursal'] ?? ''),
    ];

    $errors = [];

    // VALIDAR CAMPOS VACÍOS
    foreach ($data as $key => $dato)
        if (!$dato)
            $errors[$key] = "El campo " . str_replace(['-', '_'], ' ', $key) . " es obligatorio";

    // VALIDAR SI HAY ERRORES
    if (count($errors) === count($data)-3) {
        $_SESSION['swal'] = swal('warning', 'Los campos son obligatorios');
        redirect();
    }

    // VALIDAR EL FORMATO DE LOS CAMPOS
    !validateNames($data['nombres']) ? $errors['nombres'] = 'Solo se permiten letras y espacios' : '';

    !validateLastNames($data['apellidos']) ? $errors['apellidos'] = 'Solo se permiten letras y espacios' : '';

    !validateEmail($data['correo']) ? $errors['correo'] = 'Correo electrónico no válido' : '';

    !validateCellPhone($data['telefono']) ? $errors['telefono'] = 'Número de teléfono no válido' : '';

    !validateCurp($data['curp']) ? $errors['curp'] = 'CURP no válido' : '';

    !validateUserLevel((int)$data['usuario_nivel']) ? $errors['usuario_nivel'] = 'Nivel de usuario no permitido' : '';

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        redirect();
    }

    if (!simpleQuery(
        'SELECT * FROM sucursales WHERE id_sucursal = ?',
        [$data['id_sucursal']],
    'i'
    )) {
        $_SESSION['swal'] = swal('error', '¡Sucursal no válida!');
        redirect();
    }

    // CREAR CREDENCIAL
    $index_arr = array_values($data);
    $sql = '
        INSERT INTO credenciales (
            nivel_usuario,
            nombres_credencial,
            apellidos_credencial,
            curp_credencial,
            telefono_credencial,
            correo_inicio,
            pass_inicio,
            token_verificacion,
            id_sucursal
        )
        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)
    ';
    $query = $conn -> prepare($sql);
    $query -> bind_param(
        'ssssssssi',
        ...$index_arr
    );


    if (!$query -> execute()) {
        $_SESSION['swal'] = swal('error', '¡Ocurrió al registrar la credencial!');
        $query -> close();
        redirect();
    }

    $credential_id = $query -> insert_id;
    $qrs_path = __DIR__ . '/../storage/imgs/qrcodes/';
    $qr_png_name = "qr_$credential_id.png";
    $qr_png_path = "{$qrs_path}{$qr_png_name}";

    if (!file_exists($qrs_path))
        mkdir($qrs_path, 0777, true);

    // CREAR QR CON EL ID DE LA CREDENCIAL ANTES CREADA
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
        $query -> close();
        redirect();
    }

    $horaActual = new DateTime();
    $horaActual -> modify('-1 hour');
    $formatDateTime = $horaActual -> format('Y-m-d H:i:s');

    // CREAR REGISTRO DEL QR ANTES CREADO
    $sql = "
        INSERT INTO qr_codes (id_credencial_qr_codes, file_path, created_at)
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE
        file_path = VALUES(file_path),
        created_at = VALUES(created_at)
    ";
    $query = $conn -> prepare($sql);
    $query -> bind_param('iss', $credential_id, $qr_png_name, $formatDateTime);

    if (!$query -> execute()) {
        $_SESSION['swal'] = swal('error', '¡Error al crear el QR!');
        $query -> close();
        redirect();
    }

    $_SESSION['swal'] = swal('success', '¡Credencial y QR creados con éxito!', '', 4000);
    $query -> close();
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

// $validateNames = fn($nombre) =>
//     !empty($nombres) && preg_match("/^[a-zA-Z\s]+$/", $nombre);

// $validateLastNames = fn($apellidos) =>
//     !empty($apellidos) && preg_match("/^[a-zA-Z\s]+$/", $apellidos);

// $validateEmail = fn($correo) =>
//     !empty($correo) && filter_var($correo, FILTER_VALIDATE_EMAIL) !== false;

// $validateCellPhone = fn($telefono) =>
//     !empty($telefono) && preg_match('/^\+?[0-9]{1,4}?[-.\s]?[0-9]{1,15}$/', $telefono);

// $validateCurp = fn($curp) =>
//     !empty($curp) && preg_match('/^[A-Z]{4}[0-9]{6}[A-Z]{6}[0-9]{2}[A-Z]{1}[0-9]{1}$/', $curp);

// $validateUserLevel = fn($nivel) =>
//     !empty($nivel) && is_numeric($nivel) && $nivel >= 1 && $nivel <= 3;


