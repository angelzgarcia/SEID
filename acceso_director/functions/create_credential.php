<?php

require '../../qrlib/barcode.php';
require '../../vendor/autoload.php';
require_once 'database.php';
require_once './helpers/encrypt.php';
require_once './helpers/swal.php';
require_once './helpers/clear.php';

use Zxing\QrReader;


if ($_SERVER['REQUEST_METHOD'] === 'POST')
    match ($_POST['accion']) {
        'crear' => create(),
        'ver' => show(),
        'editar' => edit(),
        'actualizar' => update(),
        'eliminar' => destroy(),
        default => throw new \Exception("Acción no válida")
    };
else
    redirect();

function redirect()
{
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}

function create()
{
    session_start();
    global $conn;

    $pass = bin2hex(random_bytes(15));
    $data = [
        'usuario_nivel' => (int)$_POST['usuario_nivel'] ? encryptValue(clearEntry($_POST['usuario_nivel']), SECRETKEY) : null ,
        'nombres' => clearEntry($_POST['nombres']) ?: null,
        'apellidos' => clearEntry($_POST['apellidos']) ?: null,
        'curp' => clearEntry($_POST['curp']) ?: null,
        'telefono' => clearEntry($_POST['telefono']) ?: null,
        'correo' => clearEntry($_POST['correo']) ?: null,
        'pass' => $pass,
        'token_verificacion' => encryptValue('999', SECRETKEY),
        'id_sucursal' => clearEntry($_POST['id_sucursal']) ?: null,
    ];

    $errors = [];
    $keys = array_keys($data);

    


    foreach ($data as $key => $dato)
        if (!$dato)
            $errors[$key] = "El campo " . str_replace(['-', '_'], ' ', $key) . " es obligatorio";


    if(!empty($errors)) {
        if (count($errors) === count($data)-2) {
            $_SESSION['swal'] = swal('warning', 'Los campos son obligatorios');
            redirect();
        }
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

    $options = [
        'version' => 5,
        'scale' => 10,
        'errorCorrectionLevel' => 'H',
    ];

    $generator = new barcode_generator();
    $image = $generator->render_image('qr', $credential_id, $options);

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


