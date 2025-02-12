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
    $olds = [];
    $required = ['nombre', 'tipo_venta', 'stock', 'precio_costo', 'precio_venta', 'imagen'];

    array_pop($_POST);
    foreach($_POST as $key => $request) {
        $data[$key] = clearEntry($request) ?: null;
        $olds[$key] = $request;

        foreach ($required as $requested)
            if ($key === $requested)
                $data[$requested] === null ? $errors[$key] = "El campo " . str_replace(['-','_'], ' ', $key) . " es obligatorio" : '';
    }

    if (count($errors) === count($required)) {
        $_SESSION['swal'] = swal('warning', '¡Completa los campos obligatorios!');
        redirect();
    }

    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        $_SESSION['olds'] = $olds;
        redirect();
    }

    $

}

function update()
{

}

function destroy()
{

}
