<?php
require_once 'database.php';
require_once './helpers/encrypt.php';
require_once './helpers/swal.php';
require_once './helpers/clear.php';

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

    $usuario_nivel = (int)$_POST['usuario_nivel'] ? encryptValue($_POST['usuario_nivel'], SECRETKEY) : null;
    $nombres = $_POST['nombres'] ?: null;
    $apellidos = $_POST['apellidos'] ?: null;
    $curp = $_POST['curp'] ?: null;
    $telefono = $_POST['telefono'] ?: null;
    $correo = $_POST['correo'] ?: null;
    $id_sucursal = (int)$_POST['id_sucursal'] ?: null;

    // $pass = encryptValue(bin2hex(random_bytes(5)), $secretKey);
    $pass = bin2hex(random_bytes(15));
    $data = [
        'usuario_nivel' => clearEntry($usuario_nivel),
        'nombres' => clearEntry($nombres),
        'apellidos' => clearEntry($apellidos),
        'curp' => clearEntry($curp),
        'telefono' => clearEntry($telefono),
        'correo' => clearEntry($correo),
        'pass' => $pass,
        'token_verificacion' => encryptValue('999', SECRETKEY),
        'id_sucursal' => clearEntry($id_sucursal),
    ];

    $errors = [];
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
        [$id_sucursal],
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
        'isssssssi',
        ...$index_arr
    );

    if ($query -> execute()) {
        $_SESSION['swal'] = swal('success', '¡Credencial creada con éxito!');
        $query -> close();
        redirect();
    }

    $_SESSION['swal'] = swal('error', '¡Ocurrió un error!');
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


