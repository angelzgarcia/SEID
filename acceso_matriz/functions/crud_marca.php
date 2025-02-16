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

    $brand = clearEntry($_POST['nombre']) ?: null;
    $descripcion = clearEntry($_POST['descripcion']) ?: null;
    $file_name = $_FILES['imagen'];
    $file = $file_name['tmp_name'] ?: null;

    $http_path = HTTP_URL . 'imgs_marcas/';
    $doc_path = DOC_ROOT . 'imgs_marcas/';

    $olds['nombre'] = $brand;
    $olds['descripcion'] = $descripcion;
    $_SESSION['olds'] = $olds;

    $sql = 'SELECT id_marca FROM marcas WHERE nombre_marca = ?';

    if (simpleQuery($sql,[$brand],'s')) {
        $_SESSION['swal'] = swal("warning", "¡La marca ya existe!");
        redirect();
    }

    if (!isset($brand) && !isset($descripcion) && !isset($file)) {
        $_SESSION['swal'] = swal("warning", "¡Los campos son obligatorios!");
        redirect();
    }

    $expresion_regular = '/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/';

    if (!isset($brand)) {
        $errors['nombre'] = 'El nombre de la marca es obligatorio';
    } else {
        validateStringMinLenght($brand, 4) ? $errors['nombre'] = 'Mínimo 4 caracteres' : '';
        validateStringMaxLenght($brand, 40) ? $errors['nombre'] = 'Máximo 40 caracteres' : '';
        !validateStringCharts($expresion_regular, $brand) ? $errors['nombre'] = 'Solo se permiten letras' : '';
    }

    if (!isset($descripcion)) {
        $errors['descripcion'] = 'La descripción de la marca es obligatoria';
    } else {
        validateStringMinLenght($descripcion, 10) ? $errors['descripcion'] = 'Mínimo 10 caracteres' : '';
        validateStringMaxLenght($descripcion, 100) ? $errors['descripcion'] = 'Máximo 100 caracteres' : '';
        !validateStringCharts($expresion_regular, $descripcion) ? $errors['descripcion'] = 'Solo se permiten letras' : '';
    }

    !isset($file)
        ? $errors['imagen'] = 'La imagen de la marca es obligatoria'
        : ((strlen($file_name['name']) > 40) ? $errors['imagen'] = 'El nombre de la imagen es demasiado largo' : '');

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        redirect();
    }

    $file_resolution = getimagesize($file);

    if (!$file_resolution) {
        $_SESSION['swal'] = swal("warning", "¡El fichero no es una imagen!");
        redirect();
    }

    $file_width = $file_resolution[0];
    $file_heigth = $file_resolution[1];

    // if ($file_width !== 720 && $file_heigth !== 720) {
    //     $_SESSION['swal'] = swal("warning", "¡Sube una imagen de (720px)×(720px)!");
    //     redirect();
    // }

    $file_size = (int)$file_name['size'];

    if ($file_size / (1024 * 1024) > 2) {
        $_SESSION['swal'] = swal("warning", "¡Max. 2MB por imagen!");
        redirect();
    }

    $file_name = basename($file_name['name']);
    $file_type = strtolower(pathinfo("$http_path$file_name", PATHINFO_EXTENSION));

    if ($file_type !== 'jpg' && $file_type !== 'jpeg') {
        $_SESSION['swal'] = swal("warning", "¡Solo se permiten imagenes JPG o JPEG!");
        redirect();
    }

    $date = date('mY');
    $slug = createSlug($brand);
    $file_name = createSlug($file_name, true);
    $img_path = "{$date}_{$slug}_{$file_name}";

    if (!move_uploaded_file($file, "$doc_path$img_path")) {
        $_SESSION['swal'] = swal("error", "Lo sentimos, ¡Hubo un error al subir la imagen!");
        redirect();
    }

    $img_path = "$http_path$img_path";

    $sql = 'INSERT INTO marcas (nombre_marca, descripcion_marca, imagen_marca, slug_marca) VALUES (?, ?, ?, ?)';

    $_SESSION['swal'] = (!simpleQuery($sql, [$brand, $descripcion, $img_path, $slug], 'ssss')) ?
    swal("error", "¡Ocurrió un error. Contacta con soporte!") :
    swal("success", "¡marca añadida exitosamente!");

    unset($_SESSION['olds']);
    unset($_SESSION['errors']);
    redirect();
}

function update()
{
    $olds = [];
    $errors = [];

    $id = decryptValue($_GET['c'], SECRETKEY);
    $brand = clearEntry($_POST['nombre']) ?: null;
    $descripcion = clearEntry($_POST['descripcion']) ?: null;
    $file_name = $_FILES['imagen'];

    $file = $file_name['tmp_name'] ?: null;

    $http_route = !$file ? '' : HTTP_URL . 'imgs_marcas/';
    $doc_route = !$file ? '' : DOC_ROOT . 'imgs_marcas/';

    $file_size = !$file ? '' : (int)$file_name['size'];
    $file_resolution = !$file ? '' : getimagesize($file);
    $file_width = !$file ? '' : $file_resolution[0];
    $file_height = !$file ? '' : $file_resolution[1];
    $file_name = !$file ? '' : basename($file_name['name']);
    $file_type = !$file ? '' : strtolower(pathinfo("$http_route$file_name", PATHINFO_EXTENSION));


    $olds['nombre'] = $brand;
    $olds['descripcion'] = $descripcion;
    $_SESSION['olds'] = $olds;

    if (!isset($brand) && !isset($descripcion)) {
        $_SESSION['swal'] = swal("error", "¡Los campos son obligatorios!");
        redirect();
    }

    $expresion_regular = '/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/';

    if (!isset($brand)) {
        $errors['nombre'] = 'El nombre de la marca es obligatorio';
    } else {
        validateStringMinLenght($brand, 4) ? $errors['nombre'] = 'Mínimo 4 caracteres' : '';
        validateStringMaxLenght($brand, 40) ? $errors['nombre'] = 'Máximo 40 caracteres' : '';
        !validateStringCharts($expresion_regular, $brand) ? $errors['nombre'] = 'Solo se permiten letras' : '';
    }

    if (!isset($descripcion)) {
        $errors['descripcion'] = 'La descripción de la marca es obligatoria';
    } else {
        validateStringMinLenght($descripcion, 10) ? $errors['descripcion'] = 'Mínimo 10 caracteres de descripción' : '';
        validateStringMaxLenght($descripcion, 100) ? $errors['descripcion'] = 'Máximo 100 caracteres de descripción' : '';
        !validateStringCharts($expresion_regular, $descripcion) ? $errors['descripcion'] = 'Solo se permiten letras' : '';
    }

    (strlen($file_name) > 40) ? $errors['imagen'] = 'El nombre de la imagen es demasiado largo' : '';

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        redirect();
    }

    global $conn;
    $sql = 'SELECT nombre_marca FROM marcas WHERE id_marca = ?';
    $query = $conn -> prepare($sql);
    $query -> bind_param('i', $id);

    if (!$query-> execute()) {
        $_SESSION['swal'] = swal("error", "¡Ocurrió un error al buscar la marca!");
        redirect();
    }

    if ($file) {
        if (!$file_resolution) {
            $_SESSION['swal'] = swal("warning", "¡El fichero no es una imagen!");
            redirect();
        }

        if ($file_width > 720 && $file_height > 720) {
            $_SESSION['swal'] = swal("warning", "¡Solo se permiten imagenes de (720px)×(720px)!", '', 4000);
            redirect();
        }

        if ($file_type != 'jpg' && $file_type != 'jpeg') {
            $_SESSION['swal'] = swal("warning", "¡Solo se permiten imagenes JPG o JPEG!");
            redirect();
        }

        if ($file_size / (1024 * 1024) > 2) {
            $_SESSION['swal'] = swal("warning", "¡Max. 2MB por imagen!");
            redirect();
        }

        $date = date('mY');
        $slug = createSlug($brand);
        $file_name = createSlug($file_name, true);

        $image_path = "{$date}_{$slug}_{$file_name}";

        if (file_exists("$doc_route$image_path")) {
            $_SESSION['swal'] = swal("info", "¡La imagen ya está vinculada a una marca!", '', 4000);
            redirect();
        }

        if (!move_uploaded_file($file, "$doc_route$image_path")) {
            $_SESSION['swal'] = swal("error", "Lo sentimos, ¡No se pudo guardar la imagen!");
            redirect();
        }


        $image_path = "$http_route$image_path";
    }

    $nombre_actual = $query -> get_result() -> fetch_assoc()['nombre_marca'];
    $query -> close();

    if ($nombre_actual !== $brand) {
        $sql = '
            SELECT * FROM marcas
            WHERE nombre_marca = ?
            AND id_marca != ?
        ';
        $query = $conn -> prepare($sql);
        $query -> bind_param('si', $brand, $id);
        $query -> execute();
        $result = $query -> get_result() -> fetch_assoc();
        $query -> close();

        if (!empty($result)) {
            $_SESSION['swal'] = swal("warning", "¡La marca ya existe!");
            redirect();
        }

        if (!$file) {
            $sql = 'UPDATE marcas SET nombre_marca = ?, descripcion_marca = ? WHERE id_marca = ?';
            $params = [$brand, $descripcion, $id];
            $types = 'ssi';
        } else {
            $sql = 'UPDATE marcas SET nombre_marca = ?, descripcion_marca = ?, imagen_marca = ? WHERE id_marca = ?';
            $params = [$brand, $descripcion, $image_path, $id];
            $types = 'sssi';
        }

    } else {
        if (!$file) {
            $sql = 'UPDATE marcas SET descripcion_marca = ? WHERE id_marca = ?';
            $params = [$descripcion, $id];
            $types = 'si';
        } else {
            $sql = 'UPDATE marcas SET descripcion_marca = ?, imagen_marca = ? WHERE id_marca = ?';
            $params = [$descripcion, $image_path, $id];
            $types = 'ssi';
        }
    }

    $_SESSION['swal'] = !simpleQuery($sql, $params, $types) ?
    swal("error", "¡Ocurrió un error al actualizar la marca!") :
    swal("success", "¡marca actualizada exitosamente!");

    unset($_SESSION['olds']);
    unset($_SESSION['errors']);
    redirect();
}

function changeStatus()
{
    $id = (int)decryptValue($_GET['c'], SECRETKEY);

    global $conn;
    $sql = '
        SELECT * FROM marcas
        WHERE id_marca = ?
    ';
    $query = $conn -> prepare($sql);
    $query -> bind_param('i', $id);

    if (!$query -> execute()) {
        $_SESSION['swal'] = swal("warning", "¡No se encontró la marca!");
        redirect();
    }

    $brand = $query -> get_result() -> fetch_assoc();
    $query -> close();

    if (!$brand) {
        $_SESSION['swal'] = swal("warning", "¡No se encontró la marca!");
        redirect();
    }

    $current_status = (int)$brand['status_marca'];
    $new_status = ($current_status === 0) ? 1 : 0;

    $sql = '
        UPDATE marcas
        SET status_marca = ?
        WHERE id_marca = ?
    ';
    $query = $conn -> prepare($sql);
    $query -> bind_param('ii', $new_status, $id);

    !$query -> execute()
    ?
    $_SESSION['swal'] = swal("error", "¡No se pudo actualizar el status!")
    :
    $_SESSION['swal'] = swal("success", "¡Status actualizo!");

    $query -> close();
    redirect();
}

function validateStringMaxLenght($string, $lenght)
{
    return strlen($string) > $lenght;
}

function validateStringMinLenght($string, $lenght)
{
    return strlen($string) < $lenght;
}

function validateStringCharts($regex, $string)
{
    return preg_match($regex, $string);
}

function createSlug($string, $is_an_image = false)
{
    $acentos = ['á', 'é', 'í', 'ó', 'ú', 'ñ', 'ü'];
    $sinAcentos = ['a', 'e', 'i', 'o', 'u', 'n', 'u'];

    $string = str_replace($acentos, $sinAcentos, $string);

    $string = !$is_an_image ?
    preg_replace('/[^a-z0-9\s]/', '', $string) :
    preg_replace('/[^a-z0-9.\-_\s]/', '', $string);

    $string = preg_replace('/\s+/', '-', $string);

    return $string;
}
