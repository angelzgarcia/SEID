<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST')
redirect();

require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../config.php';
foreach (glob(__DIR__ . "/helpers/*.php") as $helper)
    require_once $helper;

match ($_POST['accion']) {
    'guardar' => store(),
    'actualizar' => update(),
    'modificar' => changeStatus(),
    default => redirect()
};

function redirect()
{
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}

function index()
{
    return require_once MATRIX_DOC_ROOT . 'views/inventario/index.php';
}

function store()
{
    $data = [];
    $errors = [];
    $olds = [];
    $unfillable = ['precio_mayoreo' => '', 'cantidad_minima_mayoreo' => '', 'vencimiento' => ''];

    $vencimiento = isset($_POST['vencimiento']) ? clearEntry($_POST['vencimiento']) : null;
    unset($_POST['vencimiento']);
    unset($_POST['accion']);

    $_POST['categoria'] ? $_POST['categoria'] = decryptValue($_POST['categoria'], SECRETKEY) : '';
    $_POST['marca'] ? $_POST['marca'] = decryptValue($_POST['marca'], SECRETKEY) : '';

    foreach($_POST as $key => $request) {
        $data[$key] = clearEntry($request) ?: null;
        $olds[$key] = $request ?: '';

        if (!array_key_exists($key, $unfillable))
            if (!isset($data[$key]))
                $errors[$key] = "El campo " . str_replace(['-','_'], ' ', $key) . " es obligatorio";
    }

    $_SESSION['olds'] = $olds;

    $file = $_FILES['imagen'];

    !$file['tmp_name'] ? $errors['imagen'] = "La imagen es obligatoria" : '';

    if (count($errors) === ((count($_POST) + 1) - count($unfillable))) {
        $_SESSION['swal'] = swal('warning', '¡Completa los campos obligatorios!');
        redirect();
    }

    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        redirect();
    }

    // C R E A R   S L U G
    $slug = createSlug($data['nombre']);

    // G U A R D A R   I M A G E N
    $http_path = HTTP_URL . 'imgs_productos/';
    $doc_path = DOC_ROOT . 'imgs_productos/';

    $date = date('mY');
    $file_name = createSlug(basename($file['name']), true);
    $img_name = "{$date}_{$slug}_{$file_name}";
    storeImage($file, $img_name, $doc_path);

    // C O N V E R T I R   I M A G E N   A  .webp
    $webp_img_name = createWebpImage($img_name, $doc_path);
    if ($webp_img_name) unlink("$doc_path$img_name");


    $index_data = array_values($data);
    array_push($index_data, "$http_path$webp_img_name", $slug);

    $types = '';
    $type_map = [
        'integer' => 'i',
        'double'  => 'd',
        'float'   => 'd',
        'string'  => 's',
        'NULL'    => 's',
        'null'    => 's',
    ];

    foreach ($index_data as &$value) {
        if ($value === null) $value = '';
        $types .= $type_map[gettype($value)] ?? 's';
    }

    $sql = '
        INSERT INTO productos (
            id_categoria_fk_producto,
            id_marca_fk_producto,
            codigo_barras_producto,
            nombre_producto,
            unidad_compra_producto,
            unidad_venta_producto,
            stock_producto,
            factor_conversion,
            precio_costo_producto,
            precio_venta_producto,
            aplica_mayoreo,
            cantidad_minima_mayoreo_producto,
            precio_mayoreo_producto,
            imagen_producto,
            slug_producto
        )
        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ';
    global $conn;
    $query = $conn -> prepare($sql);

    if (!$query) {
        destroyImage($webp_img_name);
        $_SESSION['swal'] = swal('error', 'Error al añadir el producto.');
        redirect();
    }

    $params = array_map(fn(&$value) => $value, $index_data);
    $query -> bind_param($types, ...$params);

    if (!$query -> execute()) {
        destroyImage($webp_img_name);
        $query -> close();

        $_SESSION['swal'] = swal('error', '¡Ocurrió un error!' . $query -> error);
        redirect();
    }

    $_SESSION['swal'] = swal('success', '¡Producto añadido exitosamente!');
    $query -> close();

    unset($_SESSION['olds']);
    unset($_SESSION['errors']);
    redirect();
}

function update()
{
    unset($_POST['accion']);
    $data = [];
    $errors = [];
    $olds = [];
    $unfillable = ['stock_producto' => '', 'imagen' => ''];

    $id = (int)clearEntry(decryptValue($_GET['p'] ?? '', SECRETKEY)) ?: null;
    if (!$id) redirect();

    $sql = '
        SELECT *
        FROM productos
        WHERE id_producto = ?
        LIMIT 1
    ';
    $producto_actual = simpleQuery($sql, [$id], 'i', true)[0] ?: false;
    if (!$producto_actual) {
        $_SESSION['swal'] = swal('error', '¡El producto no existe!');
        redirect();
    }

    $sql = '
        SELECT id_lote_vencimiento
        FROM lotes_vencimientos
        WHERE id_producto_fk_lote_vencimiento = ?
        LIMIT 1
    ';

    if (empty(simpleQuery($sql, [$id], 'i', true)) || !isset($_POST['stock_producto']) ) $unfillable['vencimiento'] = '';
    if ((int)$_POST['aplica_mayoreo'] === 0) {
        $unfillable['precio_mayoreo_producto'] = '';
        $unfillable['cantidad_minima_mayoreo_producto'] = '';
    }

    $cambios = false;

    foreach($_POST as $key => $request) {
        $data[$key] = is_numeric($request) ?
            (strpos($request, '.') !== false ? (float)$request :
            (int)$request) : (clearEntry($request) ?: null);

        $request ? $olds[$key] = $request : '';

        if (!isset($data[$key]) && !array_key_exists($key, $unfillable))
            $errors[$key] = "El campo " . str_replace(['-','_', 'producto'], ' ', $key) . " es obligatorio";

        if (isset($producto_actual[$key]) && $producto_actual[$key] != $data[$key] && !array_key_exists($key, $unfillable))
            $cambios = true;
    }

    $_SESSION['olds'] = $olds;

    if (!$cambios && !$_FILES['imagen']['name']) {
        $_SESSION['swal'] = swal('success', '¡No se detectaron cambios!');
        redirect();
    }

    if (!array_key_exists('vencimiento', $unfillable) && !isset($data['vencimiento'])) {
        $_SESSION['swal'] = swal('info', '¡Este producto requiere fecha de vencimiento!', '', 4000);
        redirect();
    }

    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        redirect();
    }

    $sql = '
        SELECT nombre_producto
        FROM productos
        WHERE id_producto != ?
        AND (nombre_producto = ? OR codigo_barras_producto = ?)
    ';

    if (simpleQuery($sql, [$id, $data['nombre_producto'], (int)$data['codigo_barras_producto']], 'isi')) {
        $_SESSION['swal'] = swal('warning', '¡Ya existe el producto ingresado!');
        redirect();
    }

    if (count($errors) === (count($_POST) + 1) - count($unfillable)) {
        $_SESSION['swal'] = swal('error', '¡No puedes dejar vaciós los campos!', '', 4000);
        redirect();
    }

    $file_assoc = $_FILES['imagen'];
    $file = $file_assoc['tmp_name'] ?: null;
    $file_name = $file_assoc['name'] ?: null;


    unset($_SESSION['olds']);
    unset($_SESSION['errors']);
    redirect();
}

function changeStatus()
{

}

function createWebpImage($filename, $doc_path)
{
    $imagen = imagecreatefromjpeg("$doc_path$filename");
    $new_filename = str_replace(['.jpg', 'jpeg'], '.webp', $filename);

    imagewebp($imagen, "$doc_path$new_filename", 70);
    imagedestroy($imagen);

    return $new_filename;
}

function storeImage($file, $img_name, $doc_path)
{
    $file_name = basename($file['name']);

    if (strlen($file_name) > 70) {
        $_SESSION['swal'] = swal('warning', '¡El nombre de la imagen es demasiado largo!');
        redirect();
    }

    $is_an_image = getimagesize($file['tmp_name']);
    if (!$is_an_image) {
        $_SESSION['swal'] = swal('info', '¡El fichero no es una imagen!', '', 4000);
        redirect();
    }

    $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $file_size = $file['size'];
    $max_size = 3;


    if ($file_size / (1024 * 1024) > $max_size) {
        $_SESSION['swal'] = swal('warning', "¡Max. {$max_size}MB por imagen!", '', 4000);
        redirect();
    }

    if ($file_type !== 'jpg' && $file_type !== 'jpeg') {
        $_SESSION['swal'] = swal('warning', "¡Solo imagenes JPG, O JPEG!", '', 4000);
        redirect();
    }

    if (file_exists("$doc_path$file_name")) {
        $_SESSION['swal'] = swal('warning', '¡Ya existe una imagen con este nombre!', '', 4000);
        redirect();
    }

    if (!move_uploaded_file($file['tmp_name'], "$doc_path$img_name")) {
        $_SESSION['swal'] = swal('error', "Error al procesar la imagen");
        redirect();
    }
}

function destroyImage($file_name)
{
    $path = DOC_ROOT . 'imgs_productos/';
    if (file_exists("$path$file_name"))
        unlink("$path$file_name");
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

