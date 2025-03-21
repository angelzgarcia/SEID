<?php

require_once __DIR__ . '/../config.php';
require_once MATRIX_DOC_ROOT . 'database.php';
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

    (!empty($_GET['p']) && $_GET['accion'] === 'detalles') ? show() : redirect_json('¡Datos incompletos!');

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
    $data = [];
    $errors = [];
    $olds = [];
    $unfillable = ['aplica_mayoreo' => '', 'precio_mayoreo' => '', 'cantidad_minima_mayoreo' => '', 'vencimiento' => ''];
    if ((int)$_POST['aplica_mayoreo'] === 1)
        unset($unfillable['aplica_mayoreo']);

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

    $data['aplica_mayoreo'] = (int)$_POST['aplica_mayoreo'];
    // var_dump($data, $_POST);exit;

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

    $sql = 'SELECT id_producto FROM productos WHERE nombre_producto = ? OR codigo_barras_producto = ?';
    $producto = simpleQuery($sql, [&$_POST['nombre'], (int)$_POST['codigo_barras']], 'si');
    if ($producto) {
        $_SESSION['swal'] = swal('info', '¡Está duplicando este producto!', '', 4000);
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

    foreach ($index_data as &$value)
        $types .= $type_map[gettype($value)] ?? 's';

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

    $params = array_map(fn(&$value) => $value, $index_data);

    if ($vencimiento) {
        startTransaction();

        if (!simpleQuery($sql, $params, $types)) {
            rollbackTransaction();
            destroyImage($webp_img_name);

            $_SESSION['swal'] = swal('error', 'Error al añadir el producto.');
            redirect();
        }

        global $conn;
        $id_producto = $conn -> insert_id;

        $sql = 'INSERT INTO lotes_vencimientos (id_producto_fk_lote_vencimiento, fecha_vencimiento) VALUES (?, ?) ';

        if (!simpleQuery($sql, [$id_producto, $vencimiento], 'is')) {
            rollbackTransaction();
            destroyImage($webp_img_name);

            $_SESSION['swal'] = swal('error', '¡Hubo problemas al registrar la fecha de vencimiento!.');
            redirect();
        }

        commitTransaction();

    } elseif (!simpleQuery($sql, $params, $types)) {
        destroyImage($webp_img_name);
        $_SESSION['swal'] = swal('error', 'Error al añadir el producto.');
        redirect();
    }

    $_SESSION['swal'] = swal('success', '¡Producto añadido exitosamente!');

    unset($_SESSION['olds']);
    unset($_SESSION['errors']);
    redirect();
}


function show()
{
    try {
        header('Content-Type: application/json');

        $id = clearEntry(decryptValue($_GET['p'] ?? '', SECRETKEY)) ?: null;
        if (!$id) redirect_json("¡Producto no encontrado!");

        $sql = '
            SELECT
                p.*, c.nombre_categoria,
                m.nombre_marca,
                GROUP_CONCAT(CONCAT(v.fecha_vencimiento, "|", v.created_at) SEPARATOR ",") AS lotes
            FROM productos AS p
            INNER JOIN categorias AS c ON p.id_categoria_fk_producto = c.id_categoria
            INNER JOIN marcas AS m ON p.id_marca_fk_producto = m.id_marca
            LEFT JOIN lotes_vencimientos AS v ON v.id_producto_fk_lote_vencimiento = p.id_producto
            WHERE id_producto = ?
            GROUP BY p.id_producto
            ORDER BY v.fecha_vencimiento ASC
        ';
        $product = simpleQuery($sql, [(int)$id], 'i', true) ?: null;
        if (!$product) {
            redirect_json("Producto no encontrado");
        }

        $product = $product[0];
        if ($product['lotes']) {
            $lotesArray = array_map(function ($lote) {
                return explode('|', $lote);
            }, explode(',', $product['lotes']));

            usort($lotesArray, function ($a, $b) {
                return strtotime($a[0]) - strtotime($b[0]);
            });

            $product['lotes'] = $lotesArray;
        } else {
            $product['lotes'] = [];
        }


        $http_path = HTTP_URL . 'imgs_productos/';
        $doc_path = DOC_ROOT . 'imgs_productos';
        $files_paths_history_root = glob("{$doc_path}/*_{$product['slug_producto']}_*", GLOB_NOSORT) ?? 0;

        if (count($files_paths_history_root) > 1) {
            usort($files_paths_history_root, fn($a, $b) => filemtime($b) - filemtime($a));

            $files_names = array_map(fn($f) => $http_path . basename($f), array_slice($files_paths_history_root, 0, 3));

            $product['images'] = $files_names;
        }

        header('Content-Type: application/json');
        echo json_encode($product);
        exit;
    } catch (Exception $e) {
        redirect_json($e -> getMessage(), 'warning');
    }
}


function update()
{
    unset($_POST['accion']);

    $data = [];
    $errors = [];
    $olds = $_POST;
    $cambios = false;
    $unfillable = ['stock_producto' => '', 'imagen' => '', 'aplica_mayoreo' => '', 'vencimiento' => ''];

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

    $has_expiration = simpleQuery($sql, [$id], 'i', true) ?? '';

    if (!$has_expiration) {
        if ($olds['vencimiento']) {
            $cambios = true;
            unset($unfillable['stock_producto']);
            unset($unfillable['vencimiento']);

        } else if ($olds['stock_producto']) {
            $cambios = true;
            unset($unfillable['stock_producto']);
        }
    } else {
        if (($olds['stock_producto'] || $olds['vencimiento'])) {
            $cambios = true;
            unset($unfillable['vencimiento']);
            unset($unfillable['stock_producto']);
        }
    }

    if ((int)$olds['aplica_mayoreo'] === 1) {
        $unfillable['precio_mayoreo_producto'] = '';
        $unfillable['cantidad_minima_mayoreo_producto'] = '';
    }

    $data = array_map(fn($field) => clearEntry($field) ?: null, $olds);
    $data['aplica_mayoreo'] = (int)$olds['aplica_mayoreo'];

    $keys_map = [
        'categoria' => 'id_categoria_fk_producto',
        'marca' => 'id_marca_fk_producto',
    ];

    $data['categoria'] = (int)decryptValue($olds['categoria'] ?? '', SECRETKEY) ?? '';
    $data['marca'] = (int)decryptValue($olds['marca'] ?? '', SECRETKEY) ?? '';

    if (!$cambios) {
        foreach ($data as $key => $v) {
            if (!array_key_exists($key, $unfillable)) {
                $product_key = $keys_map[$key] ?? $key;

                if (array_key_exists($product_key, $producto_actual)) {
                    if ($producto_actual[$product_key] != $v) {
                        $cambios = true;
                    }
                }
            }
        }
    }

    if (!$cambios && !$_FILES['imagen']['name']) {
        $_SESSION['swal'] = swal('success', '¡No se detectaron cambios!');
        redirect();
    }

    $empty_fields = array_filter(
        $data,
        fn($field, $key) => empty($field) && !array_key_exists($key, $unfillable),
        ARRAY_FILTER_USE_BOTH
    );

    foreach ($empty_fields as $field => $value)
        $errors[$field] = "El campo " . str_replace(['-','_', 'producto'], ' ', $field) . " es obligatorio";

    $_SESSION['olds'] = $olds;

    if (!empty($errors)) {
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

    if (count($errors) === (count($olds) + 1) - count($unfillable)) {
        $_SESSION['swal'] = swal('error', '¡No puedes dejar vaciós los campos!', '', 4000);
        redirect();
    }


    $file_assoc = $_FILES['imagen'];
    $file = $file_assoc['tmp_name'] ?: null;


    if (!$cambios && $file) {
        if (!updateProductImage($producto_actual, $file_assoc)) {
            $_SESSION['swal'] = swal('error', '¡No se pudo actualizar el fichero!', '', 3500);
            redirect();
        }

        $_SESSION['swal'] = swal('success', '¡Imagen actualizada!');

    } else if ($cambios && !$file) {
        if (!updateProduct($data, $producto_actual, $unfillable)) {
            $_SESSION['swal'] = swal('error', '¡No se pudo actualizar el producto!');
            redirect();
        }

        $_SESSION['swal'] = swal('success', '¡Producto actualizado!');

    } else if ($cambios && $file) {
        if (!updateProduct($data, $producto_actual, $unfillable)) {
            $_SESSION['swal'] = swal('error', '¡No se pudo actualizar el producto!');
            redirect();
        }

        if (!updateProductImage($producto_actual, $file_assoc)) {
            $_SESSION['swal'] = swal('error', '¡No se pudo actualizar el fichero!', '', 3500);
            redirect();
        }

        $_SESSION['swal'] = swal('success', '¡Producto actualizado!');
    }

    unset($_SESSION['olds']);
    unset($_SESSION['errors']);
    redirect();
}


function updateProduct($data, $producto_actual, $unfillable)
{
    $keys_map = [
        'categoria' => 'id_categoria_fk_producto',
        'marca' => 'id_marca_fk_producto',
        'codigo_barras_producto' => 'codigo_barras_producto',
        'nombre_producto' => 'nombre_producto',
        'unidad_compra_producto' => 'unidad_compra_producto',
        'unidad_venta_producto' => 'unidad_venta_producto',
        'stock_producto' => 'stock_producto',
        'factor_conversion' => 'factor_conversion',
        'precio_costo_producto' => 'precio_costo_producto',
        'precio_venta_producto' => 'precio_venta_producto',
        'aplica_mayoreo' => 'aplica_mayoreo',
        'cantidad_minima_mayoreo_producto' => 'cantidad_minima_mayoreo_producto',
        'precio_mayoreo_producto' => 'precio_mayoreo_producto',
    ];
    $type_map = [
        'integer' => 'i',
        'double'  => 'd',
        'float'   => 'd',
        'string'  => 's',
        'NULL'    => 's',
        'null'    => 's',
    ];
    $types = '';

    $data = array_filter($data, fn($value, $key) => !array_key_exists($key, $unfillable), ARRAY_FILTER_USE_BOTH);
    $vencimiento = $data['vencimiento'] ?? '';
    if ($vencimiento) unset($data['vencimiento']);
    if ($data['stock_producto']) (int)$data['stock_producto'] += (int)$producto_actual['stock_producto'];

    foreach ($data as $value)
        $types .= $type_map[gettype($value)] ?? 's';

    $set_query = [];
    $params = [];
    foreach($data as $key => $value) {
        if (isset($keys_map[$key])) {
            array_push($set_query, "{$keys_map[$key]} = ?");
            array_push($params, $value);
        }
    }

    array_push($params, $producto_actual['id_producto']);
    $types .= 'i';

    startTransaction();
    if ($vencimiento) {
        $sql = 'INSERT INTO lotes_vencimientos (id_producto_fk_lote_vencimiento, fecha_vencimiento) VALUES (?, ?) ';

        if (!simpleQuery($sql, [$producto_actual['id_producto'], $vencimiento], 'is')) {
            rollbackTransaction();
            return false;
        }
    }

    $sql = '
        UPDATE productos
        SET '. implode(', ', $set_query) . '
        WHERE id_producto = ?
    ';

    if (!simpleQuery($sql, $params, $types)) {
        rollbackTransaction();
        return false;
    }

    commitTransaction();
    return true;
}

function updateProductImage($producto_actual, $file_assoc)
{
    $http_path = HTTP_URL . 'imgs_productos/';
    $doc_path = DOC_ROOT . 'imgs_productos/';

    $slug = $producto_actual['slug_producto'];
    $file_name = $file_assoc['name'];

    $date = date('mY');
    $file_name = createSlug(basename($file_name), true);
    $img_name = "{$date}_{$slug}_{$file_name}";
    storeImage($file_assoc, $img_name, $doc_path);

    // C O N V E R T I R   I M A G E N   A  .webp
    $webp_img_name = createWebpImage($img_name, $doc_path);
    if ($webp_img_name) unlink("$doc_path$img_name");

    $sql = '
        UPDATE productos SET imagen_producto = ?, updated_at = NOW()
        WHERE id_producto = ?
    ';

    if (!simpleQuery($sql, ["$http_path$webp_img_name", $producto_actual['id_producto']], 'si')) {
        destroyImage($webp_img_name);
        return false;
    }else {
        return true;
    }
}


function changeStatus()
{
    try {
        header('Content-Type: application/json');

        $id = (int)decryptValue($_POST['p'] ?? '', SECRETKEY) ?? '';
        if (!$id) redirect_json('¡Producto no válido!');

        $sql = 'SELECT status_producto FROM productos WHERE id_producto = ?';

        $product = simpleQuery($sql, [$id], 'i', true)[0] ?? null;
        if (!$product) redirect_json('¡Producto no encontrado!');

        $current_status = (int)$product['status_producto'];
        $new_status = ($current_status === 0) ? 1 : 0;

        $sql = 'UPDATE productos SET status_producto = ? WHERE id_producto = ?';

        !simpleQuery($sql, [$new_status, $id], 'ii')
            ? redirect_json('¡No se pudo actualizar el status!', 'error')
            : redirect_json('¡Status actualizado!', 'success');

    } catch (Exception $e) {
        redirect_json($e -> getMessage(), 'warning');
    }
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

