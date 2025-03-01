<?php
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../config.php';
foreach (glob(__DIR__ . "/helpers/*.php") as $helper) require_once $helper;

if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    redirect_json();

match ($_POST['accion']) {
    'editar' => edit(),
    'guardar' => store(),
    'aprobar' => aproved(),
    'rechazar' => rejected(),
    default => redirect_json(),
};

function redirect_json($message = '¡Ocurrió un error!', $status = 'error')
{
    echo json_encode(['status' => $status, 'message' => $message]);
    exit;
}

function store()
{
    unset($_POST['accion']);

    $productos = $_POST['productos'] ?? [];
    $sucursal_id = decryptValue($_POST['sucursal'] ?? '', SECRETKEY) ?: null;
    $order_value = (float)($_POST['orderValue'] ?? 0);

    if (!is_array($productos))
        redirect_json('La información no ha llegado como se esperaba');

    if (empty($productos) || !$sucursal_id)
        redirect_json('Pedido vacío o sucursal no válida');

    startTransaction();
    $sql = '
        INSERT INTO pedidos_sucursales (id_sucursal_destino_fk_pedido_sucursal, valor_total_pedido_sucursal)
        VALUES(?, ?)
    ';

    if (!simpleQuery($sql, [(int)$sucursal_id, $order_value], 'id')) {
        rollbackTransaction();
        redirect_json('No se pudo insertar el pedido');
    }

    global $conn;
    $id_pedido_sucursal = $conn -> insert_id;

    if (!$id_pedido_sucursal) {
        rollbackTransaction();
        redirect_json('Sucursal no válida');
    }

    $sql = '
        INSERT INTO pedidos_sucursales_detalles (
            id_pedido_sucursal_fk_pedido_sucursal_detalle,
            id_producto_fk_pedido_sucursal_detalle,
            cantidad_producto_pedido_sucursal_detalle,
            precio_venta_producto_pedido_sucursal_detalle
        )
        VALUES(?, ?, ?, ?)
    ';

    $sql_validate_stock = '
        SELECT stock_producto
        FROM productos
        WHERE id_producto = ?
    ';

    $sql_update_stock = '
        UPDATE productos SET stock_producto = ?
        WHERE id_producto = ?
    ';

    foreach ($productos as $producto) {
        $product_id = decryptValue($producto['id'] ?? '', SECRETKEY) ?? null;
        $product_quantity = (int)($producto['quantity'] ?? 0);
        $product_price = (float)($producto['price'] ?? 0);

        $stock_disponible = (int)simpleQuery($sql_validate_stock, [(int)$product_id], 'i', true)[0]['stock_producto'];

        if (!$stock_disponible)
            redirect_json('No se pudo validar el stock de un producto');

        if ($stock_disponible < $product_quantity) {
            rollbackTransaction();
            echo json_encode([
                'status' => 'warning',
                'message' => "¡Stock insuficiente! \n",
                'p_name' => ucwords($producto['name']),
                'p_add' => "Se añadió: {$product_quantity}",
                'p_stock' => "Existencias: {$stock_disponible}",
            ]);
            exit;
        }

        if (!$product_id || $product_quantity <= 0 || $product_price <= 0) {
            rollbackTransaction();
            redirect_json('¡Datos no válidos en un producto!');
        }

        if (!simpleQuery($sql, [$id_pedido_sucursal, (int)$product_id, $product_quantity, $product_price], 'iiid')) {
            rollbackTransaction();
            redirect_json('¡Ocurrió un error con un producto!');
        }

        $new_stock = $stock_disponible - $product_quantity;
        if (!simpleQuery($sql_update_stock, [$new_stock, $product_id], 'ii')) {
            rollbackTransaction();
            redirect_json('¡No se pudo actualizar el stock!');
        }
    }

    commitTransaction();
    redirect_json('¡Pedido procesado!', 'success');
}


function edit()
{

}

function aproved()
{
    unset($_POST['accion']);

    $order_id = $_POST['order_id'] ? (int)clearEntry(decryptValue($_POST['order_id'], SECRETKEY)) : null;

    if (!$order_id) redirect_json('¡No se pudo identificar el pedido!');

    $sql = 'UPDATE pedidos_sucursales SET status_pedido_sucursal = ? WHERE id_pedido_sucursal = ?';
    $status = 'aprobado';

    if (!simpleQuery($sql, [&$status, &$order_id], 'si'))
        redirect_json('¡No se pudo aprobar el pedido!');

    redirect_json('¡Orden aprobada!', 'success');
}

function rejected()
{
    unset($_POST['accion']);

    $order_id = $_POST['order_id'] ? (int)clearEntry(decryptValue($_POST['order_id'], SECRETKEY)) : null;

    if (!$order_id) redirect_json('¡No se pudo identificar el pedido!');

    $sql = 'UPDATE pedidos_sucursales SET status_pedido_sucursal = ? WHERE id_pedido_sucursal = ?';
    $status = 'rechazado';

    if (!simpleQuery($sql, [&$status, &$order_id], 'si'))
        redirect_json('¡No se pudo rechazar el pedido!');

    redirect_json('¡Orden rechazada!', 'success');
}

