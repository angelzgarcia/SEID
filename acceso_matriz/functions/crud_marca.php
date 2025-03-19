<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../database.php';
foreach (glob(__DIR__ . "/helpers/*.php") as $helper)
    require_once $helper;

if ($_SERVER['REQUEST_METHOD'] === 'POST')
    match($_POST['accion']) {
        'guardar' => store(),
        'actualizar' => update(),
        default => redirect(),
    };

else if ($_SERVER['REQUEST_METHOD'] === 'GET')
    !$_GET['m']
        ? redirect_json('¡Marca no definida!')
        : match($_GET['accion']) {
            'detalles' => show(),
            'status' => changeStatus(),
            default => redirect_json('¡Acción no válida!', 'warning'),
        };
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

    $data = array_map(fn($field) => clearEntry($field) ?? null, $_POST);

    $empty_fields = array_filter($data, fn($field) => empty($field));

    foreach($empty_fields as $field => $value)
        $errors[$field] = "El campo " . str_replace(['-', '_'], ' ', $field) . " es obligatorio";

    $file_name = $_FILES['imagen'];
    $file = $file_name['tmp_name'] ?: null;

    !isset($file)
        ? $errors['imagen'] = 'La imagen de la marca es obligatoria'
        : ((strlen($file_name['name']) > 60) ? $errors['imagen'] = 'El nombre de la imagen es demasiado largo' : '');

    if (count($olds) + 1 === count($errors)) {
        $_SESSION['swal'] = swal("warning", "¡Los campos son obligatorios!");
        redirect();
    }

    $_SESSION['olds'] = $olds;

    (!empty($data['nombre']) && !onlyLetters($data['nombre']) ? $errors['nombre'] = 'Solo se permiten letras y espacios' : '');

    $fields_length_rules = [
        'nombre' => [4, 40],
        'descripcion' => [10, 150],
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

    $http_path = HTTP_URL . 'imgs_marcas/';
    $doc_path = DOC_ROOT . 'imgs_marcas/';

    $sql = 'SELECT id_marca FROM marcas WHERE nombre_marca = ?';

    if (simpleQuery($sql,[$data['nombre']],'s')) {
        $_SESSION['swal'] = swal("warning", "¡La marca ya existe!");
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
    $slug = createSlug($data['nombre']);
    $file_name = createSlug($file_name, true);
    $img_path = "{$date}_{$slug}_{$file_name}";

    if (!move_uploaded_file($file, "$doc_path$img_path")) {
        $_SESSION['swal'] = swal("error", "Lo sentimos, ¡Hubo un error al subir la imagen!");
        redirect();
    }

    $img_path = "$http_path$img_path";

    $sql = 'INSERT INTO marcas (nombre_marca, descripcion_marca, imagen_marca, slug_marca) VALUES (?, ?, ?, ?)';

    $_SESSION['swal'] = (!simpleQuery($sql, [$data['nombre'], $data['descripcion'], $img_path, $slug], 'ssss')) ?
        swal("error", "¡Ocurrió un error. Contacta con soporte!") :
        swal("success", "¡Marca añadida exitosamente!");

    unset($_SESSION['olds']);
    unset($_SESSION['errors']);
    redirect();
}


function update()
{
    $olds = [];
    $errors = [];

    $id = clearEntry(decryptValue($_GET['m'], SECRETKEY));
    if (!$id) redirect();

    $sql = 'SELECT * FROM marcas WHERE id_marca = ? LIMIT 1';
    $marca_actual = simpleQuery($sql, [$id], 'i', true)[0] ?: [];
    if (!$marca_actual) {
        $_SESSION['swal'] = swal('error', '¡La marca no existe!');
        redirect();
    }

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

    if (!isset($brand)) {
        $errors['nombre'] = 'El nombre de la marca es obligatorio';
    } else {
        inputMinLenght($brand, 4) ? $errors['nombre'] = 'Mínimo 4 caracteres' : '';
        inputMaxLenght($brand, 40) ? $errors['nombre'] = 'Máximo 40 caracteres' : '';
        !onlyLetters($brand) ? $errors['nombre'] = 'Solo se permiten letras' : '';
    }

    if (!isset($descripcion)) {
        $errors['descripcion'] = 'La descripción de la marca es obligatoria';
    } else {
        inputMinLenght($descripcion, 10) ? $errors['descripcion'] = 'Mínimo 10 caracteres de descripción' : '';
        inputMaxLenght($descripcion, 100) ? $errors['descripcion'] = 'Máximo 100 caracteres de descripción' : '';
        !onlyLetters($descripcion) ? $errors['descripcion'] = 'Solo se permiten letras' : '';
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
    swal("success", "¡Marca actualizada exitosamente!");

    unset($_SESSION['olds']);
    unset($_SESSION['errors']);
    redirect();
}


function show()
{
    try {
        header('Content-Type: application/json');

        $id = clearEntry(decryptValue($_GET['m'] ?? '', SECRETKEY)) ?: null;

        if (!$id) throw new Exception('¡Marca no válida!');

        $sql = '
            SELECT *
            FROM marcas
            WHERE id_marca = ?
            ORDER BY id_marca DESC
        ';

        $brand = simpleQuery($sql, [(int)$id], 'i', true) ?: null;
        if (!$brand) throw new Exception('¡Marca no encontrada!');

        $brand = $brand[0];
        $http_path = HTTP_URL . 'imgs_marcas/';
        $doc_path = DOC_ROOT . 'imgs_marcas';
        $files_paths_history_root = glob("{$doc_path}/*_{$brand['slug_marca']}_*", GLOB_NOSORT) ?? 0;

        if (count($files_paths_history_root) > 1) {
            usort($files_paths_history_root, fn($a, $b) => filemtime($b) - filemtime($a));

            $files_names = array_map(fn($f) => $http_path . basename($f), array_slice($files_paths_history_root, 0, 3));

            $brand['images'] = $files_names;
        }

        echo json_encode($brand);
        exit;
    } catch (Exception $e) {
        redirect_json($e -> getMessage(), 'warning');
    }
}


function changeStatus()
{
    try {
        $id = (int)decryptValue($_GET['m'], SECRETKEY);
        if (!$id) throw new Exception('¡Marca no válida!');

        global $conn;
        $sql = '
            SELECT * FROM marcas
            WHERE id_marca = ?
        ';
        $query = $conn -> prepare($sql);
        $query -> bind_param('i', $id);

        if (!$query -> execute()) {
            throw new Exception('¡Marca no encontrada!');
        }

        $brand = $query -> get_result() -> fetch_assoc();
        $query -> close();

        if (!$brand) {
            throw new Exception('¡Marca no encontrada!');
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
        redirect_json('¡No se pudo actualizar el status!', 'error')
        :
        redirect_json('¡Status actualizado!', 'success');

        $query -> close();
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
