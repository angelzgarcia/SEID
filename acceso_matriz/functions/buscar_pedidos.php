<?php
require_once __DIR__ . '/../config.php';
require_once MATRIX_DOC_FNS . 'helpers/encrypt.php';
require_once MATRIX_DOC_FNS . 'helpers/clear.php';
require_once MATRIX_DOC_ROOT . 'database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    redirect();

function redirect()
{
    $redirect_ulr = $_SERVER['HTTP_REFERER'] ?? MATRIX_HTTP_VIEWS . 'dashboard';
    header("Location: $redirect_ulr");
    exit;
}

$busqueda = clearEntry($_POST['busqueda'] ?? '') ?: null;
$sucursal = $_POST['sucursal'] ? (int)decryptValue($_POST['sucursal'], SECRETKEY) : null;
$fecha = clearEntry($_POST['fecha'] ?? '') ?: null;
$orden = clearEntry($_POST['order_by'] ?? '') ?: null;

$pedidos = [];

$conditions = [];
$params = [];
$types = '';

$sql = "
    SELECT
        ps.id_pedido_sucursal,
        ps.id_sucursal_origen_fk_pedido_sucursal,
        ps.id_sucursal_destino_fk_pedido_sucursal,
        ps.valor_total_pedido_sucursal,
        ps.status_pedido_sucursal,
        ps.created_at,
        ps.updated_at,
        s.id_sucursal,
        s.nombre_sucursal,
        JSON_ARRAYAGG(
            JSON_OBJECT(
                'id_producto', p.id_producto,
                'nombre', p.nombre_producto,
                'unidad_compra', p.unidad_compra_producto,
                'cantidad', psd.cantidad_producto_pedido_sucursal_detalle,
                'precio_venta_matriz', psd.precio_venta_producto_pedido_sucursal_detalle,
                'stock_matriz', p.stock_producto,
                'stock_sucursal', COALESCE(pds.cantidad_producto, 0),
                'precio_venta_sucursal', COALESCE(pds.precio_venta, psd.precio_venta_producto_pedido_sucursal_detalle)
            )
        ) AS productos
    FROM pedidos_sucursales ps
    INNER JOIN sucursales s
        ON s.id_sucursal = ps.id_sucursal_destino_fk_pedido_sucursal
    INNER JOIN pedidos_sucursales_detalles psd
        ON ps.id_pedido_sucursal = psd.id_pedido_sucursal_fk_pedido_sucursal_detalle
    INNER JOIN productos p
        ON p.id_producto = psd.id_producto_fk_pedido_sucursal_detalle
    LEFT JOIN productos_sucursales pds
        ON pds.id_producto_fk_producto_sucursal = p.id_producto
        AND pds.id_sucursal_fk_producto_sucursal = s.id_sucursal
";

if ($sucursal) {
    $conditions[] = "ps.id_sucursal_origen_fk_pedido_sucursal = ? OR ps.id_sucursal_destino_fk_pedido_sucursal = ?";
    array_push($params, $sucursal, $sucursal);
    $types .= 'ii';
}

if ($fecha) {
    $conditions[] = "ps.created_at LIKE ?";
    array_push($params, "%$fecha%");
    $types .= 's';
}

if ($busqueda) {
    $conditions[] = "ps.folio_pedido_sucursal LIKE ?";
    array_push($params, "%$busqueda%");
    $types .= 's';
}

if (!empty($conditions)) { $sql .= " WHERE " . implode(" AND ", $conditions); }

$sql .= '
    GROUP BY
        ps.id_pedido_sucursal,
        ps.id_sucursal_origen_fk_pedido_sucursal,
        ps.id_sucursal_destino_fk_pedido_sucursal,
        ps.valor_total_pedido_sucursal,
        ps.status_pedido_sucursal,
        ps.created_at,
        ps.updated_at,
        s.id_sucursal,
        s.nombre_sucursal
';

$orden = match ($orden) {
    'pendientes' => 'ps.status_pedido_sucursal = "pendiente" DESC, ps.id_pedido_sucursal ASC',
    'aprobados' => 'ps.status_pedido_sucursal = "aprobado" DESC, ps.id_pedido_sucursal DESC',
    'modificados' => 'ps.status_pedido_sucursal = "modificado" DESC, ps.id_pedido_sucursal DESC',
    'rechazados' => 'ps.status_pedido_sucursal = "rechazado" DESC, ps.id_pedido_sucursal DESC',
    'recibidos' => 'ps.status_pedido_sucursal = "recibido" DESC, ps.id_pedido_sucursal DESC',
    default => 'ps.id_pedido_sucursal DESC'
};

$sql .= " ORDER BY $orden";

$pedidos = simpleQuery($sql, $params, $types, true) ?: [];

$status_pedido_map = [
    'recibido' => 'received',
    'aprobado' => 'aproved',
    'modificado' => 'modify',
    'rechazado' => 'rejected',
    'default' => 'pending'
];

if ($busqueda && empty($pedidos) || $fecha && empty($pedidos) ): ?>

    <div class="registers-empty">
        <animated-icons
            src="https://animatedicons.co/get-icon?name=search&style=minimalistic&token=12e9ffab-e7da-417f-a9d9-d7f67b64d808"
            trigger="loop"
            attributes='{"variationThumbColour":"#536DFE","variationName":"Two Tone","variationNumber":2,"numberOfGroups":2,"backgroundIsGroup":false,"strokeWidth":1,"defaultColours":{"group-1":"#000000","group-2":"#536DFE","background":"#FFFFFF"}}'
            height="200"
            width="200"
        >
        </animated-icons>
        <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M40.1 467.1l-11.2 9c-3.2 2.5-7.1 3.9-11.1 3.9C8 480 0 472 0 462.2L0 192C0 86 86 0 192 0S384 86 384 192l0 270.2c0 9.8-8 17.8-17.8 17.8c-4 0-7.9-1.4-11.1-3.9l-11.2-9c-13.4-10.7-32.8-9-44.1 3.9L269.3 506c-3.3 3.8-8.2 6-13.3 6s-9.9-2.2-13.3-6l-26.6-30.5c-12.7-14.6-35.4-14.6-48.2 0L141.3 506c-3.3 3.8-8.2 6-13.3 6s-9.9-2.2-13.3-6L84.2 471c-11.3-12.9-30.7-14.6-44.1-3.9zM160 192a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm96 32a32 32 0 1 0 0-64 32 32 0 1 0 0 64z"/></svg> -->
        <p>NO SE ENCONTRARON COINCIDENCIAS.</p>
    </div>

<?php elseif (!$busqueda && empty($pedidos)): ?>

    <div class="registers-empty">
        <animated-icons
            src="https://animatedicons.co/get-icon?name=search&style=minimalistic&token=12e9ffab-e7da-417f-a9d9-d7f67b64d808"
            trigger="loop"
            attributes='{"variationThumbColour":"#536DFE","variationName":"Two Tone","variationNumber":2,"numberOfGroups":2,"backgroundIsGroup":false,"strokeWidth":1,"defaultColours":{"group-1":"#000000","group-2":"#536DFE","background":"#FFFFFF"}}'
            height="200"
            width="200"
        >
        </animated-icons>
        <p>AÚN NO HAY PEDIDOS REGISTRADOS.</p>
    </div>

<?php else:
    foreach ($pedidos as $pedido):
        $order_id = encryptValue($pedido['id_pedido_sucursal'], SECRETKEY);
        $status = strtolower($pedido['status_pedido_sucursal']);

        $fecha = new DateTime($pedido['created_at']);
        $fechaFormateada = $formatted_date -> format($fecha);

        $pedido['productos'] = json_decode($pedido['productos'], true);
        $count_productos = count($pedido['productos']); ?>

        <!-- MARCO DEL REGISTRO -->
        <div class="register-frame order-frame <?=$status_pedido_map[$status ?? ''] ?? $status_pedido_map['default']?>-order-frame">
            <!-- DETALLES -->
            <div href="" class="register-details-link">
                <div class="register-details h-full">
                    <!-- FECHA / FOLIO / SUCURSAL -->
                    <div class="header-register order-register-header">
                        <div>
                            <p><?=ucwords($pedido['nombre_sucursal'])?></p>
                            <span><?=$fechaFormateada?></span>
                        </div>

                        <strong>
                            <em>#MS-20250226-00001</em>
                        </strong>
                    </div>

                    <div class="text-start w-full">Detalles del pedido:</div>

                    <!-- DETALLES DEL PEDIDO -->
                    <div class="body-register">
                        <div class="quantities">

                            <?php if ($count_productos <= 3):

                                foreach ($pedido['productos'] as &$producto):
                                    $unidad_compra_producto = $producto['unidad_compra'];
                                    $cantidad_solicitada = $producto['cantidad'];
                                    $stock_sucursal = (int)$producto['stock_sucursal'];
                                    $stock_matriz = (int)$producto['stock_matriz']; ?>

                                    <!-- LISTA DE PRODUCTOS -->
                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p><?= ucwords($producto['nombre']) ?></p>
                                                <span>
                                                    <?= $cantidad_solicitada === 1 ? "$cantidad_solicitada $unidad_compra_producto" : "{$cantidad_solicitada} {$unidad_compra_producto}s" ?>
                                                </span>
                                            </li>
                                            <li>
                                                <p>Stock (sucursal):</p>
                                                <span>
                                                    <?= $stock_sucursal === 1 ? "$stock_sucursal $unidad_compra_producto" : "{$stock_sucursal} {$unidad_compra_producto}s" ?>
                                                </span>
                                            </li>
                                            <li>
                                                <p>Stock (almacén):</p>
                                                <span>
                                                    <?= $stock_matriz === 1 ? "$stock_matriz $unidad_compra_producto" : "{$stock_matriz} {$unidad_compra_producto}s" ?>
                                                </span>
                                            </li>
                                            <li>
                                                <p>Precio de venta (sucursal):</p>
                                                <span>$<?=$producto['precio_venta_sucursal']?>.°°</span>
                                            </li>
                                            <li>
                                                <p>Precio de venta (almacén):</p>
                                                <span>$<?=$producto['precio_venta_matriz']?>.°°</span>
                                            </li>
                                        </ol>
                                    </div>
                                <?php endforeach;

                            else:

                                foreach (array_slice($pedido['productos'], 0, 3) as &$producto):
                                    $unidad_compra_producto = $producto['unidad_compra'];
                                    $cantidad_solicitada = $producto['cantidad'];
                                    $stock_sucursal = (int)$producto['stock_sucursal'];
                                    $stock_matriz = (int)$producto['stock_matriz']; ?>


                                    <!-- LISTA DE PRODUCTOS -->
                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p><?= ucwords($producto['nombre']) ?></p>
                                                <span>
                                                    <?= $cantidad_solicitada === 1 ? "$cantidad_solicitada $unidad_compra_producto" : "{$cantidad_solicitada} {$unidad_compra_producto}s" ?>
                                                </span>
                                            </li>
                                            <li>
                                                <p>Stock (sucursal):</p>
                                                <span>
                                                    <?= $stock_sucursal === 1 ? "$stock_sucursal $unidad_compra_producto" : "{$stock_sucursal} {$unidad_compra_producto}s" ?>
                                                </span>
                                            </li>
                                            <li>
                                                <p>Stock (almacén):</p>
                                                <span>
                                                    <?= $stock_matriz === 1 ? "$stock_matriz $unidad_compra_producto" : "{$stock_matriz} {$unidad_compra_producto}s" ?>
                                                </span>
                                            </li>
                                            <li>
                                                <p>Precio de venta (sucursal):</p>
                                                <span>$<?=$producto['precio_venta_sucursal']?>.°°</span>
                                            </li>
                                            <li>
                                                <p>Precio de venta (almacén):</p>
                                                <span>$<?=$producto['precio_venta_matriz']?>.°°</span>
                                            </li>
                                        </ol>
                                    </div>
                                <?php endforeach; ?>

                                <details>
                                    <summary>Mostrar <?=$count_productos - 3?> más</summary>
                                    <?php foreach (array_slice($pedido['productos'], 3) as &$producto):
                                        $unidad_compra_producto = $producto['unidad_compra'];
                                        $cantidad_solicitada = $producto['cantidad'];
                                        $stock_sucursal = (int)$producto['stock_sucursal'];
                                        $stock_matriz = (int)$producto['stock_matriz']; ?>


                                        <!-- LISTA DE PRODUCTOS -->
                                        <div class="order-product">
                                            <ol>
                                                <li>
                                                    <p><?= ucwords($producto['nombre']) ?></p>
                                                    <span>
                                                        <?= $cantidad_solicitada === 1 ? "$cantidad_solicitada $unidad_compra_producto" : "{$cantidad_solicitada} {$unidad_compra_producto}s" ?>
                                                    </span>
                                                </li>
                                                <li>
                                                    <p>Stock (sucursal):</p>
                                                    <span>
                                                        <?= $stock_sucursal === 1 ? "$stock_sucursal $unidad_compra_producto" : "{$stock_sucursal} {$unidad_compra_producto}s" ?>
                                                    </span>
                                                </li>
                                                <li>
                                                    <p>Stock (almacén):</p>
                                                    <span>
                                                        <?= $stock_matriz === 1 ? "$stock_matriz $unidad_compra_producto" : "{$stock_matriz} {$unidad_compra_producto}s" ?>
                                                    </span>
                                                </li>
                                                <li>
                                                    <p>Precio de venta (sucursal):</p>
                                                    <span>$<?=$producto['precio_venta_sucursal']?>.°°</span>
                                                </li>
                                                <li>
                                                    <p>Precio de venta (almacén):</p>
                                                    <span>$<?=$producto['precio_venta_matriz']?>.°°</span>
                                                </li>
                                            </ol>
                                        </div>
                                    <?php endforeach; ?>
                                </details>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>

                <div class="order-branch-value">
                    <p>Valor del pedido:</p>
                    <span>$<?=$pedido['valor_total_pedido_sucursal']?>.°°</span>
                </div>
            </div>

            <!-- ACCIONES -->
            <div class="register-actions-menu-container">
                <button class="menu-toggle" title="Opciones">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M120-240v-80h520v80H120Zm664-40L584-480l200-200 56 56-144 144 144 144-56 56ZM120-440v-80h400v80H120Zm0-200v-80h520v80H120Z"/></svg>
                </button>

                <div class="register-actions orders-register-actions">
                    <!-- APROBAR PEDIDO -->
                    <button
                        <?php $aproved_btn_disabled = $status === 'aprobado' ? 'disabled' : ''; ?>
                        type="submit"
                        class="aproved-order-btn <?=$aproved_btn_disabled?>"
                        title="<?=$aproved_btn_disabled ? 'Orden aprobada' : 'Aprobar orden'?>"
                        <?=$aproved_btn_disabled?>
                        data-order-id="<?=$order_id?>"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M200-200v-560 454-85 191Zm0 80q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v320h-80v-320H200v560h280v80H200Zm494 40L552-222l57-56 85 85 170-170 56 57L694-80ZM320-440q17 0 28.5-11.5T360-480q0-17-11.5-28.5T320-520q-17 0-28.5 11.5T280-480q0 17 11.5 28.5T320-440Zm0-160q17 0 28.5-11.5T360-640q0-17-11.5-28.5T320-680q-17 0-28.5 11.5T280-640q0 17 11.5 28.5T320-600Zm120 160h240v-80H440v80Zm0-160h240v-80H440v80Z"/></svg>
                    </button>

                    <!-- EDITAR PEDIDO -->
                    <a href="" class="edit-order-btn" title="Editar pedido">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M240-360h280l80-80H240v80Zm0-160h240v-80H240v80Zm-80-160v400h280l-80 80H80v-560h800v120h-80v-40H160Zm756 212q5 5 5 11t-5 11l-36 36-70-70 36-36q5-5 11-5t11 5l48 48ZM520-120v-70l266-266 70 70-266 266h-70ZM160-680v400-400Z"/></svg>
                    </a>

                    <!-- RECHAZAR PEDIDO -->
                    <button
                        <?php $rejected_btn_disabled = $status === 'rechazado' ? 'disabled' : ''; ?>
                        type="submit"
                        class="rejected-order-btn <?=$rejected_btn_disabled?>"
                        title="<?=$rejected_btn_disabled ? 'Orden rechazada' : 'Rechazar orden'?>"
                        <?=$rejected_btn_disabled?>
                        data-order-id="<?=$order_id?>"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m819-28-59-59q-10 3-19.5 5T720-80H240q-50 0-85-35t-35-85v-120h120v-287L27-820l57-57L876-85l-57 57ZM240-160h447l-80-80H200v40q0 17 11.5 28.5T240-160Zm600-73-80-80v-447H313l-73-73v-47l60 60 60-60 60 60 60-60 60 60 60-60 60 60 60-60 60 60 60-60v647Zm-520-87h207L320-527v207Zm155-280-80-80h205v80H475Zm120 120-80-80h85v80h-5Zm85 0q-17 0-28.5-11.5T640-520q0-17 11.5-28.5T680-560q17 0 28.5 11.5T720-520q0 17-11.5 28.5T680-480Zm0-120q-17 0-28.5-11.5T640-640q0-17 11.5-28.5T680-680q17 0 28.5 11.5T720-640q0 17-11.5 28.5T680-600ZM200-160v-80 80Z"/></svg>
                    </button>
                </div>
            </div>
        </div>
    <?php endforeach;
endif;?>
