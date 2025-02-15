
<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    redirect();

session_start();
require_once __DIR__ . '/../database.php';
foreach (glob(__DIR__ . "/helpers/*.php") as $helper)
    require_once $helper;

match ($_POST['accion']) {
    'guardar' => add(),
    'actualizar' => update(),
    'eliminar' => destroy(),
    default => redirect(),
};


function redirect()
{
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}
function add()
{
    $olds = [];
    $errors = [];


    $nombre = clearEntry($_POST['nombre']) ?: null;
    $descripcion = clearEntry($_POST['descripcion']) ?: null;

    $olds['nombre'] = $nombre;
    $olds['descripcion'] = $descripcion;
    $_SESSION['olds'] = $olds;

    if (!isset($nombre) && !isset($descripcion)) {
        $_SESSION['swal'] = swal("error", "¡Los campos son obligatorios!");
        redirect();
    }

    !isset($nombre) ? $errors['nombre'] = 'El nombre de la marca es obligatorio' : '';
    !isset($descripcion) ? $errors['descripcion'] = 'La descripción de la marca es obligatoria' : '';

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        redirect();
    }

    if (strlen($nombre) < 4) {
        $_SESSION['swal'] = swal("info", "¡Mínimo 4 caracteres de nombre!");
        redirect();
    }

    if (strlen($descripcion) < 10) {
        $_SESSION['swal'] = swal("info", "¡Mínimo 10 caracteres de descripción!");
        redirect();
    }

    $expresion_regular = '/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/';
    if (!preg_match($expresion_regular, $nombre) || !preg_match($expresion_regular, $descripcion)) {
        $_SESSION['swal'] = swal('warning', '¡Solo se permiten letras!');
        redirect();
    }

    if (strlen($nombre) > 50) {
        $_SESSION['swal'] = swal('warning', '¡Máximo 40 caracteres!');
        redirect();
    }

    if (strlen($descripcion) > 250) {
        $_SESSION['swal'] = swal('warning', '¡Máximo 250 caracteres!');
        redirect();
    }

    $sql = '
        SELECT * FROM marcas
        WHERE nombre_marca = ?
    ';
    if (!simpleQuery($sql, [$nombre], 's')) {
        $_SESSION['swal'] = swal("warning", "¡La marca ya existe!");
        redirect();
    }

    $status = 1;

    $sql = 'INSERT INTO marcas (nombre_marca, descripcion_marca, status_marca) VALUES (?, ?, ?)';
    if (!simpleQuery($sql, [$nombre, $descripcion, $status], 'ssi')) {
        $_SESSION['swal'] = swal("error", "¡Ocurrió un error. Contacta con soporte!");
        redirect();
    }

    $_SESSION['swal'] = swal("success", "¡Marca añadida exitosamente!");
    unset($_SESSION['olds']);
    unset($_SESSION['errors']);
    redirect();
}
