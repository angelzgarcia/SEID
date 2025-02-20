<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    redirect();

function redirect()
{
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/helpers/encrypt.php';
require_once __DIR__ . '/../database.php';

$busqueda = $_POST['busqueda'] ?: '';

$sql = "
    SELECT p.*, c.nombre_categoria, c.id_categoria, m.nombre_marca, m.id_marca
    FROM productos AS p
    INNER JOIN categorias AS c
    INNER JOIN marcas AS m
    ON p.id_categoria_fk_producto = c.id_categoria
    AND p.id_marca_fk_producto = m.id_marca
    WHERE (p.nombre_producto LIKE ?)
    OR (p.codigo_barras_producto LIKE ?)
    OR (c.nombre_categoria LIKE ?)
    OR (m.nombre_marca LIKE ?)
";

$param = "%$busqueda%";
$productos = simpleQuery($sql, [&$param, &$param, &$param, &$param], 'ssss', true);

if ($busqueda && empty($productos)): ?>

    <div class="registers-empty">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M40.1 467.1l-11.2 9c-3.2 2.5-7.1 3.9-11.1 3.9C8 480 0 472 0 462.2L0 192C0 86 86 0 192 0S384 86 384 192l0 270.2c0 9.8-8 17.8-17.8 17.8c-4 0-7.9-1.4-11.1-3.9l-11.2-9c-13.4-10.7-32.8-9-44.1 3.9L269.3 506c-3.3 3.8-8.2 6-13.3 6s-9.9-2.2-13.3-6l-26.6-30.5c-12.7-14.6-35.4-14.6-48.2 0L141.3 506c-3.3 3.8-8.2 6-13.3 6s-9.9-2.2-13.3-6L84.2 471c-11.3-12.9-30.7-14.6-44.1-3.9zM160 192a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm96 32a32 32 0 1 0 0-64 32 32 0 1 0 0 64z"/></svg>
        <p>NO SE ENCONTRARON COINCIDENCIAS.</p>
    </div>

<?php elseif (!$busqueda && empty($productos)): ?>

    <div class="registers-empty">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M40.1 467.1l-11.2 9c-3.2 2.5-7.1 3.9-11.1 3.9C8 480 0 472 0 462.2L0 192C0 86 86 0 192 0S384 86 384 192l0 270.2c0 9.8-8 17.8-17.8 17.8c-4 0-7.9-1.4-11.1-3.9l-11.2-9c-13.4-10.7-32.8-9-44.1 3.9L269.3 506c-3.3 3.8-8.2 6-13.3 6s-9.9-2.2-13.3-6l-26.6-30.5c-12.7-14.6-35.4-14.6-48.2 0L141.3 506c-3.3 3.8-8.2 6-13.3 6s-9.9-2.2-13.3-6L84.2 471c-11.3-12.9-30.7-14.6-44.1-3.9zM160 192a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm96 32a32 32 0 1 0 0-64 32 32 0 1 0 0 64z"/></svg>
        <p>AÚN NO HAY PRODUCTOS REGISTRADOS.</p>
    </div>

<?php else:

    foreach ($productos as $producto): ?>
        <!--  MARCO DEL REGISTRO -->
        <div class="register-frame">
            <!-- DETALLES -->
            <a href="" class="register-details-link">
                <div class="register-details">
                    <div class="header-register">
                        <p><?= $producto['nombre_producto'] ?: '' ?></p>
                        <span><?= $producto['nombre_marca'] ?: '' ?></span>
                        <span><?= $producto['nombre_categoria'] ?: '' ?></span>
                    </div>

                    <div class="body-register">
                        <img src="<?= $producto['imagen_producto'] ?: '' ?>" alt="product image">

                        <div class="quantities">
                            <p>
                                <?=
                                    match($producto['unidad_compra_producto'] ?: '') {
                                        'pieza' => 'Costo de compra por unidad',
                                        'paquete' => 'Costo de compra por paquete',
                                        'caja' => 'Costo de compra por caja',
                                    };
                                ?>
                                <span>$<?= $producto['precio_costo_producto'] ?></span>
                            </p>
                            <p>
                                Precio de venta:
                                <span>$<?= $producto['precio_venta_producto'] ?></span>
                            </p>
                            <p>
                                Exsitencias:
                                <span>
                                    <?php $stock = $producto['stock_producto'] ?>
                                    <span>
                                        <?= $stock ?>
                                        <?= $stock === 1 ? "{$producto['unidad_compra_producto']}" : "{$producto['unidad_compra_producto']}s" ?>
                                    </span>
                                    /
                                    <span>
                                        <?= (int)$producto['factor_conversion'] * (int)$producto['stock_producto'] ?>
                                        <?= $stock === 1 ? "{$producto['unidad_venta_producto']}" : "{$producto['unidad_venta_producto']}s" ?>
                                    </span>
                                </span>
                            </p>
                            <p>
                                Codigo de barras:
                                <span><?= $producto['codigo_barras_producto'] ?></span>
                            </p>
                        </div>
                    </div>
                </div>
            </a>

            <?php $p = encryptValue($producto['id_producto'], SECRETKEY) ?>
            <?php $status = (int)$producto['status_producto'] ?>

            <!-- ACCIONES -->
            <div class="register-actions">
                <a href="./edit?p=<?=$p?>" title="Editar producto">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-120v-170l527-526q12-12 27-18t30-6q16 0 30.5 6t25.5 18l56 56q12 11 18 25.5t6 30.5q0 15-6 30t-18 27L330-120H160Zm80-80h56l393-392-28-29-29-28-392 393v56Zm560-503-57-57 57 57Zm-139 82-29-28 57 57-28-29ZM560-120q74 0 137-37t63-103q0-36-19-62t-51-45l-59 59q23 10 36 22t13 26q0 23-36.5 41.5T560-200q-17 0-28.5 11.5T520-160q0 17 11.5 28.5T560-120ZM183-426l60-60q-20-8-31.5-16.5T200-520q0-12 18-24t76-37q88-38 117-69t29-70q0-55-44-87.5T280-840q-45 0-80.5 16T145-785q-11 13-9 29t15 26q13 11 29 9t27-13q14-14 31-20t42-6q41 0 60.5 12t19.5 28q0 14-17.5 25.5T262-654q-80 35-111 63.5T120-520q0 32 17 54.5t46 39.5Z"/></svg>
                </a>

                <a href="./edit_stock?p=<?=$p?>" class="add-stock-btn" title="Reabastecer stock">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M40-160v-80h200v-80H80v-80h160v-80H122v-80h118v-118l-78-168 72-34 94 200h464l-78-166 72-34 94 200v520H40Zm440-280h160q17 0 28.5-11.5T680-480q0-17-11.5-28.5T640-520H480q-17 0-28.5 11.5T440-480q0 17 11.5 28.5T480-440ZM320-240h480v-360H320v360Zm0 0v-360 360Z"/></svg>
                </a>

                <form action="<?= MATRIX_HTTP_URL ?>functions/crud_producto?p=<?=$p?>" class="status-btn <?= $status === 0 ? 'inactive-btn' : 'active-btn' ?>" data-id="<?=$p?>" method="POST" title="Cambiar status">
                    <input type="hidden" name="accion" value="modificar">

                    <button type="button" title="Cambiar status">
                        <?php if( $status === 0): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-240q-100 0-170-70T40-480q0-100 70-170t170-70h400q100 0 170 70t70 170q0 100-70 170t-170 70H280Zm0-80h400q66 0 113-47t47-113q0-66-47-113t-113-47H280q-66 0-113 47t-47 113q0 66 47 113t113 47Zm0-40q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35Zm200-120Z"/></svg>
                        <?php else: ?>
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-240q-100 0-170-70T40-480q0-100 70-170t170-70h400q100 0 170 70t70 170q0 100-70 170t-170 70H280Zm0-80h400q66 0 113-47t47-113q0-66-47-113t-113-47H280q-66 0-113 47t-47 113q0 66 47 113t113 47Zm400-40q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35ZM480-480Z"/></svg>
                        <?php endif; ?>
                    </button>
                </form>
            </div>
        </div>
    <?php endforeach;

endif;?>
