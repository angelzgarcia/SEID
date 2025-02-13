<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    redirect();

session_start();
require_once __DIR__ . '/../database.php';
foreach (glob(__DIR__ . "/helpers/*.php") as $helper)
    require_once $helper;

match($_POST['accion']) {
    'guardar' => store(),
    'actualizar' => update(),
    'eliminar' => destroy(),
    default => redirect(),
};

function redirect()
{
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}

function store()
{
    global $conn;
   $category = $_POST['nombre'] ?: null;

    if ($category === null) {
        $_SESSION['swal'] = swal("error", "¡El campo es obligatorio!");
        redirect();
    }

    $expresion_regular = '/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/';
    if (!preg_match($expresion_regular, $category)){
        $_SESSION['swal'] = swal('warning', '¡Solo se permiten letras!');
        redirect();
    }

    if (strlen($category) > 50) {
        $_SESSION['swal'] = swal('warning', '¡Máximo 40 caracteres!');
        redirect();
    }

    $sql = '
        SELECT * FROM categorias
        WHERE nombre_categoria = ?
    ';
    if (!simpleQuery($sql,[$category],'s')) {
        $_SESSION['swal'] = swal("warning", "¡La categoría ya existe!");
        redirect();
    }

    $sql = 'INSERT INTO categorias (nombre_categoria) VALUES (?)';
    if (!simpleQuery($sql, [$category], 's')) {
        $_SESSION['swal'] = swal("error", "¡Ocurrió un error. Contacta con soporte!");
        redirect();
    }

    $_SESSION['swal'] = swal("success", "¡Categoría añadida exitosamente!");
    redirect();
}

function update()
{
    echo "metodo update";
}

function destroy()
{

}

