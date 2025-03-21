<?php
require_once __DIR__ . '/../config.php';
require_once SELLER_DOC_ROOT . 'database.php';
require_once SELLER_DOCT_FNS . 'helpers/encrypt.php';
require_once SELLER_DOCT_FNS . 'helpers/clear.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    redirect();

function redirect()
{
    $redirect_ulr = $_SERVER['HTTP_REFERER'] ?? SELLER_HTTP_VIEWS . 'dashboard';
    header("Location: $redirect_ulr");
    exit;
}

$product_search = clearEntry($_POST['product_search'] ?? '') ?: null;
$product_scan = clearEntry($_POST['product_scan'] ?? '') ?: null;

$sql = 'SELECT p.* ';

$conditions = '';
$types = '';
$params = [];

if ($product_search) {
    $sql .= '
        , m.nombre_marca, c.nombre_categoria
        FROM productos AS p
        INNER JOIN marcas AS m ON m.id_marca = p.id_marca_fk_producto
        INNER JOIN categorias AS c ON c.id_categoria = p.id_categoria_fk_producto
    ';

    $conditions = ' WHERE nombre_producto LIKE ? OR codigo_barras_producto = ?';
    $types = 'si';

    array_push($params, "%$product_search%", (int)$product_search);

} else if ($product_scan) {
    $sql .= 'FROM productos AS p';
    $conditions = ' WHERE codigo_barras_producto = ?';
    $types = 'i';
    array_push($params, (int)$product_scan);
}

$sql .= $product_search ? "$conditions ORDER BY nombre_producto ASC" : $conditions;

$productos = simpleQuery($sql, $params, $types, true);

if (empty($productos)): ?>

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

<?php elseif ($product_scan):

    echo json_encode($productos[0]);

else:
    foreach($productos as $producto): ?>

    <div class="content-product-found">
        <div class="product-header">
            <div class="product-img">
                <img src="<?=$producto['imagen_producto'] ?? '' ?>" alt="product image">
            </div>

            <div class="product-name">
                <p><?=$producto['nombre_producto'] ?? 'Unknown product'?></p>

                <span>
                    💲<?=$producto['precio_venta_producto'] ?? 'NaN'?>.°° c / <?=$producto['unidad_venta_producto'] ?? 'uknown'?>
                </span>
            </div>

            <div class="add-remove-btns">
                <?php $product_barcode = $producto['codigo_barras_producto'] ?>

                <button type="button" class="remove-btn" data-barcode="<?=$product_barcode?>">➖</button>
                <input type="text" id="product-quantity" autocomplete="off" data-barcode="<?=$product_barcode?>">
                <button type="button" class="add-btn" data-barcode="<?=$product_barcode?>">➕</button>
            </div>
        </div>

        <div class="product-footer">
            <?php $aplica_mayoreo = $producto['aplica_mayoreo'] ?? true?>

            <div class="<?=!$aplica_mayoreo ? 'is-wholesale' : 'is-not-wholesale'?>">
                <span><?=!$aplica_mayoreo ? 'Aplica mayoreo' : 'No aplica mayoreo' ?></span>
            </div>

            <div class="stock">
                <span>Existencias:</span>
                <span><?=$producto['stock_producto'] ?? 'NaN'?></span>
            </div>
        </div>

        <div class="product-details">
            <details>
                <summary>Detalles del producto</summary>

                <div class="details">
                    <!-- UNIDAD DE VENTA -->
                    <div>
                        <p> Se vende por:</p>
                        <strong>
                            <span><?=$producto['unidad_venta_producto'] ?? 'uknown'?></span>📦
                        </strong>
                    </div>

                    <!-- PRECIO AL POR MAYOR -->
                    <div>
                        <p>Precio al por mayor:</p>

                        <?php $precio_mayoreo = $producto['precio_mayoreo_producto'] ?? 0; ?>
                        <strong>
                            <?=
                                $precio_mayoreo > 0
                                    ? <<<HTML
                                            <span>$precio_mayoreo</span>💲
                                        HTML
                                    : <<<HTML
                                            <span>No aplica</span>🚫
                                        HTML
                            ?>
                        </strong>
                    </div>

                    <!-- CANTIDAD APLICABLE A MAYOREO -->
                    <div>
                        <p>Cantidad mínima aplicable a mayoreo:</p>

                        <?php $cantidad_minima_mayoreo = $producto['cantidad_minima_mayoreo_producto'] ?? 0; ?>
                        <strong>
                            <?=
                                $cantidad_minima_mayoreo > 0
                                    ? <<<HTML
                                            <span>$cantidad_minima_mayoreo</span>#️⃣
                                        HTML
                                    : <<<HTML
                                            <span>No aplica</span>🚫
                                        HTML
                            ?>
                        </strong>
                    </div>

                    <!-- MARCA -->
                    <div>
                        <p>Marca:</p>

                        <strong>
                            <span><?=$producto['nombre_marca']?></span>📌
                        </strong>
                    </div>

                    <!-- CATEGORIA -->
                    <div>
                        <p>Categoría:</p>

                        <strong>
                            <span><?=$producto['nombre_categoria']?></span>📌
                        </strong>
                    </div>

                    <!-- CODIGO DE BARRAS -->
                    <div>
                        <p>Codigo de barras:</p>

                        <strong>
                            <span><?=$producto['codigo_barras_producto']?></span>
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M40-120v-200h80v120h120v80H40Zm680 0v-80h120v-120h80v200H720ZM160-240v-480h80v480h-80Zm120 0v-480h40v480h-40Zm120 0v-480h80v480h-80Zm120 0v-480h120v480H520Zm160 0v-480h40v480h-40Zm80 0v-480h40v480h-40ZM40-640v-200h200v80H120v120H40Zm800 0v-120H720v-80h200v200h-80Z"/></svg>
                        </strong>
                    </div>
                </div>
            </details>
        </div>
    </div>

<?php endforeach;
endif; ?>
