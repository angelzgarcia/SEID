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

$busqueda = clearEntry($_POST['producto'] ?? '') ?: null;

$sql = '
    SELECT p.*, m.nombre_marca, c.nombre_categoria
    FROM productos AS p
    INNER JOIN marcas AS m ON m.id_marca = p.id_marca_fk_producto
    INNER JOIN categorias AS c ON c.id_categoria = p.id_categoria_fk_producto
    WHERE codigo_barras_producto = ?
    OR nombre_producto LIKE ?
    ORDER BY nombre_producto ASC
';

$productos = simpleQuery($sql, [is_numeric($busqueda) ? $busqueda : '', "%$busqueda%"], 'is', true);

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

<?php else:
    foreach($productos as $producto): ?>

    <div class="content-product-found">
        <div class="product-header">
            <div class="product-img">
                <!-- <img src="https://www.hubspot.com/hs-fs/hubfs/Shell_logo.svg.png?width=450&height=417&name=Shell_logo.svg.png" alt="product image"> -->
                <img src="<?=$producto['imagen_producto'] ?? '' ?>" alt="product image">
            </div>

            <div class="product-name">
                <p><?=$producto['nombre_producto'] ?? 'Unknown product'?></p>

                <span>
                    💲<?=$producto['precio_venta_producto'] ?? 'NaN'?>.°° c/<?=$producto['unidad_venta_producto'] ?? 'uknown'?>
                </span>
            </div>

            <div class="add-remove-btns">
                <button type="button" class="remove-btn">➖</button>
                <input type="text" id="product-quantity" autocomplete="off">
                <button type="button" class="add-btn">➕</button>
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
                    <div>
                        <p> Se vende por:</p>
                        <strong>📦 <span><?=$producto['unidad_venta_producto'] ?? 'uknown'?></span></strong>
                    </div>

                    <div>
                        <p>Precio al por mayor:</p>

                        <?php $precio_mayoreo = $producto['precio_mayoreo_producto'] ?? 0; ?>
                        <strong>
                            <?= $precio_mayoreo > 0 ? "💲<span>$precio_mayoreo</span>" : '<span>No aplica</span>'?>
                        </strong>
                    </div>

                    <div>
                        <p>Cantidad mínima aplicable a mayoreo:</p>

                        <?php $cantidad_minima_mayoreo = $producto['cantidad_minima_mayoreo_producto'] ?? 0; ?>
                        <strong>
                            <?= $cantidad_minima_mayoreo > 0 ? "#️⃣<span>$cantidad_minima_mayoreo</span>" : '<span>No aplica</span>'?>
                        </strong>
                    </div>

                    <div>
                        <p>Marca:</p>
                        <strong>📑 <span><?=$producto['nombre_marca']?></span></strong>
                    </div>

                    <div>
                        <p>Categoría:</p>
                        <strong>📑 <span><?=$producto['nombre_categoria']?></span></strong>
                    </div>

                    <div>
                        <p>Codigo de barras:</p>
                        <strong>🏷️ <span><?=$producto['codigo_barras_producto']?></span></strong>
                    </div>
                </div>
            </details>
        </div>
    </div>

<?php endforeach;
endif; ?>
