<?php

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../database.php';
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

    (!empty($_GET['c']) && $_GET['accion'] === 'detalles') ? show() : redirect();

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
    $olds = [];
    $errors = [];

    $category = clearEntry($_POST['nombre']) ?: null;
    $descripcion = clearEntry($_POST['descripcion']) ?: null;
    $file_name = $_FILES['imagen'];
    $file = $file_name['tmp_name'] ?: null;

    $http_path = HTTP_URL . 'imgs_categorias/';
    $doc_path = DOC_ROOT . 'imgs_categorias/';

    $olds['nombre'] = $category;
    $olds['descripcion'] = $descripcion;
    $_SESSION['olds'] = $olds;

    $sql = 'SELECT id_categoria FROM categorias WHERE nombre_categoria = ?';

    if (simpleQuery($sql,[$category],'s')) {
        $_SESSION['swal'] = swal("warning", "¡La categoría ya existe!");
        redirect();
    }

    if (!isset($category) && !isset($descripcion) && !isset($file)) {
        $_SESSION['swal'] = swal("warning", "¡Los campos son obligatorios!");
        redirect();
    }

    if (!isset($category)) {
        $errors['nombre'] = 'El nombre de la categoría es obligatorio';
    } else {
        inputMinLenght($category, 4) ? $errors['nombre'] = 'Mínimo 4 caracteres' : '';
        inputMaxLenght($category, 40) ? $errors['nombre'] = 'Máximo 40 caracteres' : '';
        !onlyLetters($category) ? $errors['nombre'] = 'Solo se permiten letras' : '';
    }

    if (!isset($descripcion)) {
        $errors['descripcion'] = 'La descripción de la categoría es obligatoria';
    } else {
        inputMinLenght($descripcion, 10) ? $errors['descripcion'] = 'Mínimo 10 caracteres' : '';
        inputMaxLenght($descripcion, 100) ? $errors['descripcion'] = 'Máximo 100 caracteres' : '';
        !onlyLetters($descripcion) ? $errors['descripcion'] = 'Solo se permiten letras' : '';
    }

    !isset($file)
        ? $errors['imagen'] = 'La imagen de la categoría es obligatoria'
        : ((strlen($file_name['name']) > 60) ? $errors['imagen'] = 'El nombre de la imagen es demasiado largo' : '');

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

    if ($file_width > 720 && $file_heigth > 720) {
        $_SESSION['swal'] = swal("warning", "¡Sube una imagen de (720px)×(720px) o menor!");
        redirect();
    }

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
    $slug = createSlug($category);
    $file_name = createSlug($file_name, true);
    $img_path = "{$date}_{$slug}_{$file_name}";

    if (!move_uploaded_file($file, "$doc_path$img_path")) {
        $_SESSION['swal'] = swal("error", "Lo sentimos, ¡Hubo un error al subir la imagen!");
        redirect();
    }

    $img_path = "$http_path$img_path";

    $sql = 'INSERT INTO categorias (nombre_categoria, descripcion_categoria, imagen_categoria, slug_categoria) VALUES (?, ?, ?, ?)';

    $_SESSION['swal'] = (!simpleQuery($sql, [$category, $descripcion, $img_path, $slug], 'ssss')) ?
        swal("error", "¡Ocurrió un error. Contacta con soporte!") :
        swal("success", "¡Categoría añadida exitosamente!");

    unset($_SESSION['olds']);
    unset($_SESSION['errors']);
    redirect();
}


function show()
{
    try {
        header('Content-Type: application/json');

        $id = clearEntry(decryptValue($_GET['c'] ?? '', SECRETKEY)) ?: null;

        if (!$id) throw new Exception('¡Categoría no válida!');

        $sql = '
            SELECT *
            FROM categorias
            WHERE id_categoria = ?
            ORDER BY id_categoria DESC
        ';

        $category = simpleQuery($sql, [(int)$id], 'i', true) ?: null;
        if (!$category) throw new Exception('¡Categoría no encontrada!');

        $category = $category[0];
        $http_path = HTTP_URL . 'imgs_categorias/';
        $doc_path = DOC_ROOT . 'imgs_categorias';
        $files_paths_history_root = glob("{$doc_path}/*_{$category['slug_categoria']}_*", GLOB_NOSORT) ?? 0;

        if (count($files_paths_history_root) > 1) {
            usort($files_paths_history_root, fn($a, $b) => filemtime($b) - filemtime($a));

            $files_names = array_map(fn($f) => $http_path . basename($f), array_slice($files_paths_history_root, 0, 3));

            $category['images'] = $files_names;
        }

        echo json_encode($category);
        exit;
    } catch (Exception $e) {
        redirect_json($e -> getMessage(), 'warning');
    }
}

function update()
{
    $olds = [];
    $errors = [];

    $id = (int)decryptValue($_GET['c'] ?? '', SECRETKEY);
    if (!$id) redirect();

    $sql = 'SELECT * FROM categorias WHERE id_categoria = ?';
    $categoria = simpleQuery($sql, [$id], 'i', true)[0] ?: null;
    $cambios = false;

    if ($categoria['nombre_categoria'] !== strtolower($_POST['nombre']) || $categoria['descripcion_categoria'] !== strtolower($_POST['descripcion']))
        $cambios = true;

    if (!$cambios && !$_FILES['imagen']['name']) {
        $_SESSION['swal'] = swal('success', '¡No se detectaron cambios!');
        redirect();
    }

    $category = clearEntry($_POST['nombre']) ?: null;
    $descripcion = clearEntry($_POST['descripcion']) ?: null;
    $file_name = $_FILES['imagen'];

    $file = $file_name['tmp_name'] ?: null;

    $http_route = !$file ? '' : HTTP_URL . 'imgs_categorias/';
    $doc_route = !$file ? '' : DOC_ROOT . 'imgs_categorias/';

    $file_size = !$file ? '' : (int)$file_name['size'];
    $file_resolution = !$file ? '' : getimagesize($file);
    $file_width = !$file ? '' : $file_resolution[0];
    $file_height = !$file ? '' : $file_resolution[1];
    $file_name = !$file ? '' : basename($file_name['name']);
    $file_type = !$file ? '' : strtolower(pathinfo("$http_route$file_name", PATHINFO_EXTENSION));

    $olds['nombre'] = $category;
    $olds['descripcion'] = $descripcion;
    $_SESSION['olds'] = $olds;

    if (!isset($category) && !isset($descripcion)) {
        $_SESSION['swal'] = swal("error", "¡Los campos son obligatorios!");
        redirect();
    }

    if (!isset($category)) {
        $errors['nombre'] = 'El nombre de la categoría es obligatorio';
    } else {
        inputMinLenght($category, 4) ? $errors['nombre'] = 'Mínimo 4 caracteres' : '';
        inputMaxLenght($category, 40) ? $errors['nombre'] = 'Máximo 40 caracteres' : '';
        !onlyLetters($category) ? $errors['nombre'] = 'Solo se permiten letras' : '';
    }

    if (!isset($descripcion)) {
        $errors['descripcion'] = 'La descripción de la categoría es obligatoria';
    } else {
        inputMinLenght($descripcion, 10) ? $errors['descripcion'] = 'Mínimo 10 caracteres de descripción' : '';
        inputMaxLenght($descripcion, 100) ? $errors['descripcion'] = 'Máximo 100 caracteres de descripción' : '';
        !onlyLetters($descripcion) ? $errors['descripcion'] = 'Solo se permiten letras' : '';
    }

    (strlen($file_name) > 60) ? $errors['imagen'] = 'El nombre de la imagen es demasiado largo' : '';

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        redirect();
    }

    $sql = 'SELECT nombre_categoria FROM categorias WHERE id_categoria = ?';
    $nombre_actual = simpleQuery($sql, [$id], 'i', true)[0]['nombre_categoria'];

    if (empty($nombre_actual)) {
        $_SESSION['swal'] = swal("error", "¡Ocurrió un error al buscar la categoría!");
        redirect();
    }

    // VALIDAR IMAGEN
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
        $slug = createSlug($category);
        $file_name = createSlug($file_name, true);

        $image_path = "{$date}_{$slug}_{$file_name}";

        if (file_exists("$doc_route$image_path")) {
            $_SESSION['swal'] = swal("info", "¡La imagen ya está vinculada a una categoría!", '', 4000);
            redirect();
        }

        if (!move_uploaded_file($file, "$doc_route$image_path")) {
            $_SESSION['swal'] = swal("error", "Lo sentimos, ¡No se pudo guardar la imagen!");
            redirect();
        }


        $image_path = "$http_route$image_path";
    }

    if ($nombre_actual !== $category) {
        $sql = '
            SELECT * FROM categorias
            WHERE nombre_categoria = ?
            AND id_categoria != ?
        ';

        if (simpleQuery($sql, [$category, $id], 'si')) {
            $_SESSION['swal'] = swal("warning", "¡La categoría ya existe!");
            redirect();
        }

        if (!$file) {
            $sql = 'UPDATE categorias SET nombre_categoria = ?, descripcion_categoria = ? WHERE id_categoria = ?';
            $params = [$category, $descripcion, $id];
            $types = 'ssi';
        } else {
            $sql = 'UPDATE categorias SET nombre_categoria = ?, descripcion_categoria = ?, imagen_categoria = ? WHERE id_categoria = ?';
            $params = [$category, $descripcion, $image_path, $id];
            $types = 'sssi';
        }

    } else {
        if (!$file) {
            $sql = 'UPDATE categorias SET descripcion_categoria = ? WHERE id_categoria = ?';
            $params = [$descripcion, $id];
            $types = 'si';
        } else {
            $sql = 'UPDATE categorias SET descripcion_categoria = ?, imagen_categoria = ? WHERE id_categoria = ?';
            $params = [$descripcion, $image_path, $id];
            $types = 'ssi';
        }
    }

    $_SESSION['swal'] = !simpleQuery($sql, $params, $types) ?
    swal("error", "¡Ocurrió un error al actualizar la categoría!") :
    swal("success", "¡Categoría actualizada exitosamente!");

    unset($_SESSION['olds']);
    unset($_SESSION['errors']);
    redirect();
}


function changeStatus()
{
    try {
        header('Content-Type: application/json');

        $id = (int)decryptValue($_POST['c'] ?? '', SECRETKEY) ?? '';
        if (!$id) redirect_json('¡Categoria no válida!');

        $sql = 'SELECT status_categoria FROM categorias WHERE id_categoria = ?';

        $category = simpleQuery($sql, [$id], 'i', true)[0] ?? null;

        if (!$category) redirect_json('¡Categoria no encontrada!');

        $current_status = (int)$category['status_categoria'];
        $new_status = ($current_status === 0) ? 1 : 0;

        $sql = '
            UPDATE categorias
            SET status_categoria = ?
            WHERE id_categoria = ?
        ';

        !simpleQuery($sql, [(int)$new_status, $id], 'ii')
            ? redirect_json('¡No se pudo actualizar el status!', 'error')
            : redirect_json('¡Status actualizado!', 'success');

    } catch (Exception $e) {
        redirect_json($e -> getMessage(), 'warning');
    }
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
