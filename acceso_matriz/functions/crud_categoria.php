<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    redirect();

session_start();
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../database.php';
foreach (glob(__DIR__ . "/helpers/*.php") as $helper)
    require_once $helper;

match($_POST['accion']) {
    'guardar' => store(),
    'actualizar' => update(),
    'modificar' => changeStatus(),
    default => redirect(),
};

function redirect()
{
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}

function store()
{
    $olds = [];
    $errors = [];

    $category = clearEntry($_POST['nombre']) ?: null;
    $descripcion = clearEntry($_POST['descripcion']) ?: null;
    $path = DOC_ROOT . 'imgs_categorias/';

    $file_name = $_FILES['imagen'];
    $file = $file_name['tmp_name'];

    $file_resolution = getimagesize($file);
    if (!$file_resolution) {
        $_SESSION['swal'] = swal("warning", "¡El fichero no es una imagen!");
        redirect();
    }

    $file_size = (int)$file_name['size'];
    if ($file_size / (1024 * 1024) > 2) {
        $_SESSION['swal'] = swal("warning", "¡Max. 2MB por imagen!");
        redirect();
    }

    $file_name = basename($file_name['name']);
    $file_type = strtolower(pathinfo("$path$file_name", PATHINFO_EXTENSION));
    if ($file_type !== 'jpg' && $file_type !== 'jpeg') {
        $_SESSION['swal'] = swal("warning", "¡Solo se permiten imagenes JPG o JPEG!");
        redirect();
    }

    $file_width = $file_resolution[0];
    $file_heigth = $file_resolution[1];


    $olds['nombre'] = $category;
    $olds['descripcion'] = $descripcion;
    $_SESSION['olds'] = $olds;

    if (!isset($category) && !isset($descripcion)) {
        $_SESSION['swal'] = swal("error", "¡Los campos son obligatorios!");
        redirect();
    }

    !isset($category) ? $errors['nombre'] = 'El nombre de la categoría es obligatorio' : '';
    !isset($descripcion) ? $errors['descripcion'] = 'La descripción de la categoría es obligatoria' : '';

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        redirect();
    }

    if (strlen($category) < 4) {
        $_SESSION['swal'] = swal("info", "¡Mínimo 4 caracteres de nombre!");
        redirect();
    }

    if (strlen($descripcion) < 10) {
        $_SESSION['swal'] = swal("info", "¡Mínimo 10 caracteres de descripción!");
        redirect();
    }

    $expresion_regular = '/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/';
    if (!preg_match($expresion_regular, $category) || !preg_match($expresion_regular, $descripcion)){
        $_SESSION['swal'] = swal('warning', '¡Solo se permiten letras!');
        redirect();
    }

    if (strlen($category) > 50) {
        $_SESSION['swal'] = swal('warning', '¡Máximo 40 caracteres!');
        redirect();
    }

    if (strlen($descripcion) > 250) {
        $_SESSION['swal'] = swal('warning', '¡Máximo 250 caracteres!');
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

    $sql = 'INSERT INTO categorias (nombre_categoria, descripcion_categoria) VALUES (?, ?)';
    if (!simpleQuery($sql, [$category, $descripcion], 'ss'))
        $_SESSION['swal'] = swal("error", "¡Ocurrió un error. Contacta con soporte!");
    else
        $_SESSION['swal'] = swal("success", "¡Categoría añadida exitosamente!");

    unset($_SESSION['olds']);
    unset($_SESSION['errors']);
    redirect();
}

function update()
{
    $olds = [];
    $errors = [];

    $category = clearEntry($_POST['nombre']) ?: null;
    $descripcion = clearEntry($_POST['descripcion']) ?: null;
    // $imagen = clearEntry($_POST['descripcion']) ?: null;
    $id = decryptValue($_GET['c'], SECRETKEY);

    $olds['nombre'] = $category;
    $olds['descripcion'] = $descripcion;
    $_SESSION['olds'] = $olds;

    unset($_SESSION['olds']);
    unset($_SESSION['errors']);

    if (!isset($category) && !isset($descripcion)) {
        $_SESSION['swal'] = swal("error", "¡Los campos son obligatorios!");
        redirect();
    }

    !isset($category) ? $errors['nombre'] = 'El nombre de la categoría es obligatorio' : '';
    !isset($descripcion) ? $errors['descripcion'] = 'La descripción de la categoría es obligatoria' : '';

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        redirect();
    }

    if (strlen($category) < 4) {
        $_SESSION['swal'] = swal("info", "¡Mínimo 4 caracteres de nombre!");
        redirect();
    }

    if (strlen($descripcion) < 10) {
        $_SESSION['swal'] = swal("info", "¡Mínimo 10 caracteres de descripción!");
        redirect();
    }

    $expresion_regular = '/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/';
    if (!preg_match($expresion_regular, $category) || !preg_match($expresion_regular, $descripcion)){
        $_SESSION['swal'] = swal('warning', '¡Solo se permiten letras!');
        redirect();
    }

    if (strlen($category) > 50) {
        $_SESSION['swal'] = swal('warning', '¡Máximo 40 caracteres!');
        redirect();
    }

    if (strlen($descripcion) > 250) {
        $_SESSION['swal'] = swal('warning', '¡Máximo 250 caracteres!');
        redirect();
    }

    global $conn;
    $sql = 'SELECT nombre_categoria FROM categorias WHERE id_categoria = ?';
    $query = $conn -> prepare($sql);
    $query -> bind_param('i', $id);

    if (!$query-> execute()) {
        $_SESSION['swal'] = swal("error", "¡Ocurrió un error al buscar la categoría!");
        redirect();
    }

    $nombre_actual = $query -> get_result() -> fetch_assoc()['nombre_categoria'];
    $query -> close();

    if ($nombre_actual !== $category) {
        $sql = '
            SELECT * FROM categorias
            WHERE nombre_categoria = ?
            AND id_categoria != ?
        ';
        $query = $conn -> prepare($sql);
        $query -> bind_param('si', $category, $id);
        $query -> execute();
        $result = $query -> get_result() -> fetch_assoc();
        $query -> close();

        if (!empty($result)) {
            $_SESSION['swal'] = swal("warning", "¡La categoría ya existe!");
            redirect();
        }

        $sql = 'UPDATE categorias SET nombre_categoria = ?, descripcion_categoria = ? WHERE id_categoria = ?';
        $params = [$category, $descripcion, $id];
        $types = 'ssi';
    } else {
        $sql = 'UPDATE categorias SET descripcion_categoria = ? WHERE id_categoria = ?';
        $params = [$descripcion, $id];
        $types = 'si';
    }

    if (!simpleQuery($sql, $params, $types))
        $_SESSION['swal'] = swal("error", "¡Ocurrió un error al actualizar la categoría!");
    else
        $_SESSION['swal'] = swal("success", "¡Categoría actualizada exitosamente!");

    redirect();
}

function changeStatus()
{
    $id = decryptValue($_GET['c'], SECRETKEY);

    global $conn;
    $sql = '
        SELECT * FROM categorias
        WHERE id_categoria = ?
    ';
    $query = $conn -> prepare($sql);
    $query -> bind_param('i', $id);

    if (!$query -> execute()) {
        $_SESSION['swal'] = swal("warning", "¡No se encontró la categoría!");
        redirect();
    }

    $category = $query -> get_result() -> fetch_assoc();
    $query -> close();

    $current_status = (int)$category['status_categoria'];
    $new_status = ($current_status === 0) ? 1 : 0;

    $sql = '
        UPDATE categorias
        SET status_categoria = ?
        WHERE id_categoria = ?
    ';
    $query = $conn -> prepare($sql);
    $query -> bind_param('ii', $id, $new_status);

    !$query -> execute()
    ?
    $_SESSION['swal'] = swal("error", "¡No se pudo actualizar el status!")
    :
    $_SESSION['swal'] = swal("success", "¡Status actualizo!");

    $query -> close();
    redirect();
}

