<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    redirect();

session_start();
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../config.php';
foreach (glob(__DIR__ . "/helpers/*.php") as $helper)
    require_once $helper;

match ($_POST['accion']) {
    'guardar' => store(),
    'actualizar' => update(),
    'modificar' => destroy(),
    default => redirect()
};

function redirect()
{
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}

function store()
{
    $data = [];
    $errors = [];
    $olds = [];
    $unfillable = ['precio_mayoreo' => '', 'cantidad_minima_mayoreo' => '', 'vencimiento' => ''];

    $vencimiento = !isset($_POST['vencimiento']) ? clearEntry($_POST['vencimiento']) : null;
    unset($_POST['vencimiento']);
    unset($_POST['accion']);

    isset($_POST['categoria']) ? $_POST['categoria'] = decryptValue($_POST['categoria'], SECRETKEY) : '';
    isset($_POST['marca']) ? $_POST['marca'] = decryptValue($_POST['marca'], SECRETKEY) : '';

    foreach($_POST as $key => $request) {
        $data[$key] = clearEntry($request) ?: null;
        $olds[$key] = $request ?: '';

        if ($data['aplica_mayoreo'] === 'si' || !array_key_exists($key, $unfillable))
            if (!isset($data[$key]))
                $errors[$key] = "El campo " . str_replace(['-','_'], ' ', $key) . " es obligatorio";
    }

    $_SESSION['olds'] = $olds;

    $file = $_FILES['imagen']['tmp_name'];
    if ($file) {
        $is_an_image = getimagesize($file);

        if (!$is_an_image) {
            $_SESSION['swal'] = swal('info', '¡El fichero no es una imagen!', '', 4000);
            redirect();
        }
    }

    !$file ? $errors['imagen'] = "La imagen es obligatoria" : '';

    if (count($errors) === ((count($_POST) + 1) - count($unfillable))) {
        $_SESSION['swal'] = swal('warning', '¡Completa los campos obligatorios!');
        redirect();
    }

    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        redirect();
    }

    // G U A R D A R   I M A G E N
    $file_name = basename($_FILES['imagen']['name']);
    storeImage($file, $file_name);

    // C R E A R   S L U G
    $slug = createSlug($data['nombre']);

    $index_data = array_values($data);
    array_push($index_data, $file_name, $slug);

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

    $types = "";
    $type_map = [
        'integer' => 'i',
        'double'  => 'd',
        'float'   => 'd',
        'string'  => 's',
        'NULL'    => 's',
        'null'    => 's',
    ];

    foreach ($index_data as $key => &$value) {
        if ($value === null) {
            $value = '';
        }
        $types .= $type_map[gettype($value)] ?? 's';
    }

    $query = $conn -> prepare($sql);

    if (!$query) {
        destroyImage($file_name);
        $_SESSION['swal'] = swal('error', 'Error al añadir el producto.');
        redirect();
    }

    $params = array_map(fn(&$value) => $value, $index_data);
    $query -> bind_param($types, ...$params);

    if (!$query -> execute()) {
        destroyImage($file_name);
        $query -> close();

        $_SESSION['swal'] = swal('error', '¡Ocurrió un error!' . $query -> error);
        redirect();
    }

    $_SESSION['swal'] = swal('success', '¡Producto añadido exitosamente!');
    $query -> close();
    redirect();
}

function storeImage($file, $file_name)
{
    if (strlen($file_name) > 70) {
        $_SESSION['swal'] = swal('warning', '¡El nombre de la imagen es demasiado largo!');
        redirect();
    }

    $path = DOC_ROOT . 'imgs_productos/';
    $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $file_size = $_FILES['imagen']['size'];
    $max_size = 3;

    // if (file_exists("$path$file_name")) {
    //     $_SESSION['swal'] = swal('warning', '¡Ya existe una imagen con este nombre!', '', 4000);
    //     redirect();
    // }

    if ($file_size / (1024 * 1024) > $max_size) {
        $_SESSION['swal'] = swal('warning', "¡Max. {$max_size}MB por imagen!", '', 4000);
        redirect();
    }

    if ($file_type !== 'jpg' && $file_type !== 'png' && $file_type !== 'jpeg') {
        $_SESSION['swal'] = swal('warning', "¡Solo imagenes JPG, PNG O JPEG!", '', 4000);
        redirect();
    }

    if (!move_uploaded_file($file, "$path$file_name")) {
        $_SESSION['swal'] = swal('error', "Error al procesar la imagen");
        redirect();
    }
}

function destroyImage($file_name)
{
    $path = DOC_ROOT . 'storage/imgs/uploads/';
    if (file_exists("$path$file_name"))
        unlink("$path$file_name");
}

function createSlug($entrada)
{
    $entrada = clearEntry($entrada);

    $acentos = ['á', 'é', 'í', 'ó', 'ú', 'ñ', 'ü'];
    $sinAcentos = ['a', 'e', 'i', 'o', 'u', 'n', 'u'];
    $entrada = str_replace($acentos, $sinAcentos, $entrada);

    $entrada = preg_replace('/[^a-z0-9\s]/', '', $entrada);

    $entrada = preg_replace('/\s+/', '-', $entrada);

    return $entrada;
}

function update()
{

}

function destroy()
{

}
