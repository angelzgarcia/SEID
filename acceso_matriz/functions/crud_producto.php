<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    redirect();

session_start();
foreach (glob(__DIR__ . "/helpers/*.php") as $helper)
    require_once $helper;

match ($_POST['accion']) {
    'guardar' => store(),
    'actualizar' => update(),
    'eliminar' => destroy(),
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
    $required = ['nombre', 'tipo_venta', 'stock', 'precio_costo', 'precio_venta', 'imagen'];

    foreach($_POST as $key => $request) {
        $data[$key] = clearEntry($request) ?: null;
        foreach ($required as $requested)
            if ($key === $requested)
                !$data[$requested] ? $errors[$key] = "El campo $key es obligatorio" : '';
    }

    array_pop($data);

    if (count($errors) === count($required)) {
        $_SESSION['swal'] = swal('warning', '¡Completa los campos obligatorios!');
        redirect();
    }

    
}

function update()
{

}

function destroy()
{

}
