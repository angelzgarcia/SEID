<?php
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../config.php';
foreach (glob(__DIR__ . "/helpers/*.php") as $helper) require_once $helper;

if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    return;

match ($_POST['accion']) {
    'guardar' => store(),
    default => exit,
};

function store()
{
    unset($_POST['accion']);

    $productos = $_POST['productos'] ?? [];
    $sucursal_id = decryptValue($_POST['sucursal'] ?? '', SECRETKEY) ?: null;
    $order_value = (float)($_POST['orderValue'] ?? 0);

    if (!is_array($productos)) {
        echo json_encode(['status' => 'error', 'message' => 'Error: la información no ha llegado como se esperaba']);
        exit;
    }

    if (empty($productos) || !$sucursal_id) {
        echo json_encode(['status' => 'error', 'message' => 'Error: pedido vacío o sucursal no válida']);
        exit;
    }

    startTransaction();
    $sql = '
        INSERT INTO pedidos_sucursales (id_sucursal_destino_fk_pedido_sucursal, valor_total_pedido_sucursal)
        VALUES(?, ?)
    ';

    if (!simpleQuery($sql, [(int)$sucursal_id, $order_value], 'id')) {
        rollbackTransaction();
        echo json_encode(['status' => 'error', 'message' => 'Error: No se pudo insertar el pedido']);
        exit;
    }

    global $conn;
    $id_pedido_sucursal = $conn -> insert_id;

    if (!$id_pedido_sucursal) {
        rollbackTransaction();
        echo json_encode(['status' => 'error', 'message' => 'Error: Sucursal no válida']);
        exit;
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

        if (!$stock_disponible) {
            echo json_encode(['status' => 'error', 'message' => "No se pudo validar el stock de un producto"]);
            exit;
        }

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
            echo json_encode(['status' => 'error', 'message' => "¡Datos no válidos en un producto!"]);
            exit;
        }

        if (!simpleQuery($sql, [$id_pedido_sucursal, (int)$product_id, $product_quantity, $product_price], 'iiid')) {
            rollbackTransaction();
            echo json_encode(['status' => 'error', 'message' => "¡No se pudo registrar un producto!: "]);
            exit;
        }

        $new_stock = $stock_disponible - $product_quantity;
        if (!simpleQuery($sql_update_stock, [$new_stock, $product_id], 'ii')) {
            rollbackTransaction();
            echo json_encode(['status' => 'error', 'message' => "¡No se pudo actualizar el stock!: "]);
            exit;
        }
    }

    commitTransaction();
    echo json_encode(['status' => 'success', 'message' => "¡Pedido procesado!"]);
    exit;
}



function edit()
{

}

function changeStatus()
{

}
