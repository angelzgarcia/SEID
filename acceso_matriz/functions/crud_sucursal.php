
<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    redirect();

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../database.php';
foreach (glob(__DIR__ . "/helpers/*.php") as $helper)
    require_once $helper;

match($_POST['accion'] ?? '') {
    'guardar' => store(),
    'actualizar' => update(),
    'modificar' => changeStatus(),
    default => redirect(),
};

function redirect()
{
    $redirect_ulr = $_SERVER['HTTP_REFERER'] ?? MATRIX_HTTP_VIEWS . 'dashboard';
    header("Location: $redirect_ulr");
    exit;
}

function store()
{
    unset($_POST['accion']);

    $olds = $_POST;
    $errors = [];
    $data = [];

    $data = array_map(fn($value) => clearEntry($value) ?: null, $_POST);

    $empty_fields = array_filter($data, fn($value) => empty($value));
    foreach($empty_fields as $key => $value) {
        $errors[$key] = "El campo " . str_replace(['_, -'], ' ', $key) . " es obligatorio";
    }

    if (count($errors) === count($olds)) {
        $_SESSION['swal'] = swal('warning', '¡Los campos son obligatorios!');
        redirect();
    }

    $_SESSION['olds'] = $olds;
    $fields_length_rules = [
        'nombre' => [5, 50],
        'direccion' => [10, 180],
        'telefono' => [7, 15]
    ];

    (!empty($data['telefono']) && !validateCellPhone($data['telefono'])) ? $errors['telefono'] = 'Número telefónico no válido' : '';

    foreach($fields_length_rules as $field => [$min, $max]) {
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

    $sql = '
        SELECT nombre_sucursal, direccion_sucursal, telefono_sucursal
        FROM sucursales
        WHERE nombre_sucursal = ?
        OR direccion_sucursal = ?
        OR telefono_sucursal = ?
    ';

    $branch_exists = simpleQuery($sql, [$data['nombre'], $data['direccion'], $data['telefono']], 'sss', true)[0] ?? null;

    if ($branch_exists) {
        if ($branch_exists['nombre_sucursal'] === $data['nombre'])
            $_SESSION['swal'] = swal('warning', '¡Ya existe una sucursal con ese nombre!');

        if ($branch_exists['direccion_sucursal'] === $data['direccion'])
            $_SESSION['swal'] = swal('warning', '¡Ya exite una sucursal con esa dirección!');

        if ($branch_exists['telefono_sucursal'] === (string)$data['telefono'])
            $_SESSION['swal'] = swal('warning', '¡Ya existe una sucursal con ese teléfono!');

        redirect();
    }

    $sql = '
        INSERT INTO sucursales (nombre_sucursal, direccion_sucursal, telefono_sucursal)
        VALUES (?, ?, ?)
    ';

    $index_data = array_values($data);
    $_SESSION['swal'] = (!simpleQuery($sql, $index_data, 'sss')) ?
            swal("error", "¡Ocurrió un error. Contacta con soporte!") :
            swal("success", "¡Sucursal añadida exitosamente!");

    unset($_SESSION['olds']);
    unset($_SESSION['errors']);
    redirect();
}

function update()
{
    $olds = [];
    $errors = [];


    unset($_SESSION['olds']);
    unset($_SESSION['errors']);
    redirect();
}

function changeStatus()
{
    $id = (int)decryptValue($_GET['m'], SECRETKEY);
    if (!$id) redirect();

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





