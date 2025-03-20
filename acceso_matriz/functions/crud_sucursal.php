
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

    (!empty($_GET['s']) && $_GET['accion'] === 'detalles') ? show() : redirect_json('¡Datos incompletos!');

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
    $data = [];

    $data = array_map(fn($value) => clearEntry($value) ?: null, $_POST);

    $empty_fields = array_filter($data, fn($value) => empty($value));
    foreach($empty_fields as $key => $value)
        $errors[$key] = "El campo " . str_replace(['_, -'], ' ', $key) . " es obligatorio";

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
    $_SESSION['swal'] = (!simpleQuery($sql, $index_data, 'sss'))
        ? swal("error", "¡Ocurrió un error. Contacta con soporte!")
        : swal("success", "¡Sucursal añadida exitosamente!");

    unset($_SESSION['olds']);
    unset($_SESSION['errors']);
    redirect();
}


function show()
{
    try {
        header('Content-Type: application/json');

        $id = clearEntry(decryptValue($_GET['s'] ?? '', SECRETKEY)) ?: null;

        if (!$id) redirect_json('¡Sucursal no válida!');

        $sql = '
            SELECT *
            FROM sucursales
            WHERE id_sucursal = ?
            ORDER BY id_sucursal DESC
        ';

        $sucursal = simpleQuery($sql, [(int)$id], 'i', true)[0] ?: null;
        if (!$sucursal) redirect_json('¡Sucursal no encontrada!');

        echo json_encode($sucursal);
        exit;
    } catch (Exception $e) {
        redirect_json($e -> getMessage(), 'warning');
    }
}


function update()
{
    unset($_POST['accion']);

    $olds = [];
    $errors = [];

    $id = (int)clearEntry(decryptValue($_GET['s'], SECRETKEY));
    if (!$id) redirect();

    $nombre = clearEntry($_POST['nombre']) ?: null;
    $direccion = clearEntry($_POST['direccion']) ?: null;
    $telefono = (string)clearEntry($_POST['telefono']) ?: null;

    $sql = '
        SELECT id_sucursal
        FROM sucursales
        WHERE (nombre_sucursal = ?
            OR direccion_sucursal = ?
            OR telefono_sucursal = ?)
        AND id_sucursal != ?
    ';

    if (simpleQuery($sql, [$nombre, $direccion, $telefono, $id], 'sssi')) {
        $_SESSION['swal'] = swal('warning', '¡Hay datos vinculados a otra sucursal!');
        redirect();
    }

    $_SESSION['olds'] = $_POST;

    if (!isset($nombre) && !isset($direccion) && !isset($telefono)) {
        $_SESSION['swal'] = swal("warning", "¡Los campos son obligatorios!");
        redirect();
    }

    if (!isset($nombre)) {
        $errors['nombre'] = 'El nombre de la sucursal es obligatorio';
    } else {
        inputMinLenght($nombre, 4) ? $errors['nombre'] = 'Mínimo 4 caracteres' : '';
        inputMaxLenght($nombre, 40) ? $errors['nombre'] = 'Máximo 40 caracteres' : '';
        !onlyLetters($nombre) ? $errors['nombre'] = 'Solo se permiten letras' : '';
    }

    if (!isset($direccion)) {
        $errors['direccion'] = 'La direccion de la sucursal es obligatoria';
    } else {
        inputMinLenght($direccion, 10) ? $errors['direccion'] = 'Mínimo 10 caracteres' : '';
        inputMaxLenght($direccion, 100) ? $errors['direccion'] = 'Máximo 80 caracteres de direccion' : '';
        !onlyLetters($direccion) ? $errors['direccion'] = 'Solo se permiten letras' : '';
    }

    if (!validateCellPhone($telefono) ? $errors['telefono'] = 'El formato del teléfono es incorrecto' : '');

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        redirect();
    }

    $sql = '
        UPDATE sucursales
        SET nombre_sucursal = ?, direccion_sucursal = ?, telefono_sucursal = ?
        WHERE id_sucursal = ?
    ';

    $_SESSION['swal'] = !simpleQuery($sql, [$nombre, $direccion, $telefono, $id], 'sssi') ?
        swal("error", "¡Ocurrió un error al actualizar la sucursal!") :
        swal("success", "¡Sucursal actualizada exitosamente!");

    unset($_SESSION['olds']);
    unset($_SESSION['errors']);
    redirect();
}



function changeStatus()
{
    try {
        header('Content-Type: application/json');

        $id = (int)decryptValue($_POST['s'] ?? '', SECRETKEY) ?? '';
        if (!$id) redirect_json('¡Sucursal no válida!');

        $sql = 'SELECT status_sucursal FROM sucursales WHERE id_sucursal = ?';

        $branch = simpleQuery($sql, [$id], 'i', true)[0] ?? null;
        if (!$branch) redirect_json('¡Sucursales no encontrada!');

        $current_status = (int)$branch['status_sucursal'];
        $new_status = ($current_status === 0) ? 1 : 0;

        $sql = 'UPDATE sucursales SET status_sucursal = ? WHERE id_sucursal = ?';

        !simpleQuery($sql, [$new_status, $id], 'ii')
            ? redirect_json('¡No se pudo actualizar el status!', 'error')
            : redirect_json('¡Status actualizado!', 'success');

    } catch (Exception $e) {
        redirect_json($e -> getMessage(), 'warning');
    }
}




