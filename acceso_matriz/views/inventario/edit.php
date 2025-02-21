<?php require_once __DIR__ . '/../../config.php' ?>
<?php require_once __DIR__ . '/../../database.php' ?>
<?php require_once MATRIX_DOC_ROOT . '/functions/helpers/encrypt.php' ?>
<?php $page_name = ACCESO . 'Editar producto' ?>

<?php
    $sql= 'SELECT id_categoria, nombre_categoria FROM categorias WHERE status_categoria = 0 ORDER BY nombre_categoria ASC';
    $categorias = simpleQuery($sql, [], '', true) ?: [];

    $sql = 'SELECT id_marca, nombre_marca FROM marcas WHERE status_marca = 0 ORDER BY nombre_marca ASC';
    $marcas = simpleQuery($sql) ?: [];

    $id = htmlspecialchars(trim($_GET['p']));
    $id_producto = (int)decryptValue($id, SECRETKEY);

    $sql = '
        SELECT p.*, c.id_categoria, c.nombre_categoria, m.id_marca, m.nombre_marca
        FROM productos AS p
        JOIN categorias AS c
        JOIN marcas AS m
        ON p.id_categoria_fk_producto = c.id_categoria
        AND p.id_marca_fk_producto = m.id_marca
        WHERE id_producto = ?
    ';
    $producto = simpleQuery($sql, [$id_producto], 'i', true) ?: [];

    if (empty($producto)) {
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    }
    $producto = $producto[0];

    $sql = '
        SELECT *
        FROM lotes_vencimientos
        WHERE id_producto_fk_lote_vencimiento = ?
        ORDER BY fecha_vencimiento DESC
        LIMIT 1
    ';

    $lote = simpleQuery($sql, [$id_producto], 'i', true) ?: [];
    if ($lote) $producto['lote'] = $lote[0];
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once MATRIX_DOC_VIEWS . "modules/head.php" ?>
<body>
    <?php require_once MATRIX_DOC_VIEWS . "/modules/header.php" ?>

    <?php require_once MATRIX_DOC_VIEWS . "/modules/sidebar.php" ?>

    <main class="main-content matriz-content">
        <!-- CREAR PRODUCTO -->
        <div class="form-create-container">
            <div class="form-header">
                <h1>Editar producto 📦</h1>

                <!-- ACCESOS DIRECTOS -->
                <div class="shortcuts-links">
                    <a href="./index" title="Inventario" class="shortcut-link-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M440-183v-274L200-596v274l240 139Zm80 0 240-139v-274L520-457v274Zm-80 92L160-252q-19-11-29.5-29T120-321v-318q0-22 10.5-40t29.5-29l280-161q19-11 40-11t40 11l280 161q19 11 29.5 29t10.5 40v318q0 22-10.5 40T800-252L520-91q-19 11-40 11t-40-11Zm200-528 77-44-237-137-78 45 238 136Zm-160 93 78-45-237-137-78 45 237 137Z"/></svg>
                    </a>

                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-120q-75 0-140.5-28.5t-114-77q-48.5-48.5-77-114T120-480q0-75 28.5-140.5t77-114q48.5-48.5 114-77T480-840v80q-117 0-198.5 81.5T200-480q0 117 81.5 198.5T480-200v80Zm160-160-56-57 103-103H360v-80h327L584-624l56-56 200 200-200 200Z"/></svg>

                    <a title="Editar producto" class="shortcut-link-btn <?= strpos($_SERVER['PHP_SELF'], 'inventario/edit') ? 'active' : '' ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-120v-170l527-526q12-12 27-18t30-6q16 0 30.5 6t25.5 18l56 56q12 11 18 25.5t6 30.5q0 15-6 30t-18 27L330-120H160Zm80-80h56l393-392-28-29-29-28-392 393v56Zm560-503-57-57 57 57Zm-139 82-29-28 57 57-28-29ZM560-120q74 0 137-37t63-103q0-36-19-62t-51-45l-59 59q23 10 36 22t13 26q0 23-36.5 41.5T560-200q-17 0-28.5 11.5T520-160q0 17 11.5 28.5T560-120ZM183-426l60-60q-20-8-31.5-16.5T200-520q0-12 18-24t76-37q88-38 117-69t29-70q0-55-44-87.5T280-840q-45 0-80.5 16T145-785q-11 13-9 29t15 26q13 11 29 9t27-13q14-14 31-20t42-6q41 0 60.5 12t19.5 28q0 14-17.5 25.5T262-654q-80 35-111 63.5T120-520q0 32 17 54.5t46 39.5Z"/></svg>
                    </a>
                </div>
            </div>

            <form class="form-create" id="form-editar" action="<?= MATRIX_FNS ?>crud_producto?p=<?=$id?>" method="POST" autocomplete="off" enctype="multipart/form-data">
                <!-- CATEGORIA -->
                <fieldset class="field-select">
                    <legend>
                        Categoría *
                        <p class='message-error'>
                            <?= $_SESSION['errors']['categoria'] ?? '' ?>
                        </p>
                    </legend>

                    <input type="hidden" name="categoria" value="">
                    <select name="categoria">
                        <option selected disabled>Seleccione la categoría del producto</option>
                        <?php if (empty($categorias)): ?>
                            <option disabled>No hay categorías registradas aún</option>
                        <?php else: ?>

                            <?php foreach ($categorias as $categoria): ?>
                                <option
                                    value="<?= encryptValue($categoria['id_categoria'], SECRETKEY) ?>"
                                    <?= isset($_SESSION['olds']['categoria']) && $_SESSION['olds']['categoria'] === $categoria['nombre_categoria'] ? 'selected' : '' ?>
                                    <?= (int)$categoria['id_categoria'] === (int)$producto['id_categoria_fk_producto'] ? 'selected' : '' ?> "
                                >
                                    <?= ucfirst($categoria['nombre_categoria'] ?? '') ?>
                                </option>
                            <?php endforeach; ?>

                        <?php endif; ?>
                    </select>
                </fieldset>

                <!-- MARCA -->
                <fieldset class="field-select">
                    <legend>
                        Marca *
                        <p class='message-error'>
                            <?= $_SESSION['errors']['marca'] ?? '' ?>
                        </p>
                    </legend>

                    <input type="hidden" name="marca" value="">
                    <select name="marca">
                        <option selected disabled>Seleccione la marca del producto</option>
                        <?php if (empty($marcas)): ?>
                            <option disabled>No hay marcas registradas aún</option>
                        <?php else: ?>

                            <?php foreach ($marcas as $marca): ?>
                                <option
                                    value="<?= encryptValue($marca['id_marca'], SECRETKEY) ?>"
                                    <?= isset($_SESSION['olds']['marca']) && $_SESSION['olds']['marca'] === $marca['nombre_marca'] ? 'selected' : '' ?>
                                    <?= (int)$marca['id_marca'] === (int)$producto['id_marca_fk_producto'] ? 'selected' : '' ?> "
                                >
                                    <?= ucfirst($marca['nombre_marca']) ?>
                                </option>
                            <?php endforeach; ?>

                        <?php endif; ?>
                    </select>
                </fieldset>

                <!-- CODIGO DE BARRAS -->
                <fieldset>
                    <legend>
                        Codigo de barras *
                        <p class='message-error'>
                            <?= $_SESSION['errors']['codigo_barras_producto'] ?? '' ?>
                        </p>
                    </legend>

                    <input
                        type="text" name="codigo_barras_producto" placeholder="Ingrese el codigo de barras"
                        value="<?= $_SESSION['olds']['codigo_barras_producto'] ?? $producto['codigo_barras_producto'] ?>"
                        oninput="validarCodigoBarras(this)"
                    >
                </fieldset>

                <!-- NOMBRE -->
                <fieldset>
                    <legend>
                        Nombre *
                        <p class='message-error'>
                            <?= $_SESSION['errors']['nombre_producto'] ?? '' ?>
                        </p>
                    </legend>

                    <input
                        type="text" name="nombre_producto" placeholder="Ingrese el nombre del producto"
                        value="<?= $_SESSION['olds']['nombre_producto'] ?? $producto['nombre_producto'] ?>"
                    >
                </fieldset>

                <!-- UNIDAD DE MEDIDA DE COMPRA -->
                <fieldset>
                    <legend>
                        Unidad de compra *
                        <p class='message-error'>
                            <?= $_SESSION['errors']['unidad_compra_producto'] ?? '' ?>
                        </p>
                    </legend>

                    <input type="radio" name="unidad_compra_producto" checked value="" class="hidden">
                    <select name="unidad_compra_producto" id="unidad_compra">
                        <option selected disabled>Seleccione la unidad de compra</option>
                        <option
                            value="pieza"
                            <?= $producto['unidad_compra_producto'] === 'pieza' ? 'selected' : '' ?>
                            <?= isset($_SESSION['olds']['unidad_compra_producto']) && $_SESSION['olds']['unidad_compra_producto'] === 'pieza' ? 'selected' : '' ?>
                        >
                            Pieza
                        </option>

                        <option
                            value="paquete"
                            <?= $producto['unidad_compra_producto'] === 'paquete' ? 'selected' : '' ?>
                            <?= isset($_SESSION['olds']['unidad_compra_producto']) && $_SESSION['olds']['unidad_compra_producto'] === 'paquete' ? 'selected' : '' ?>
                        >
                            Paquete
                        </option>

                        <option
                            value="caja"
                            <?= $producto['unidad_compra_producto'] === 'caja' ? 'selected' : '' ?>
                            <?= isset($_SESSION['olds']['unidad_compra_producto']) && $_SESSION['olds']['unidad_compra_producto'] === 'caja' ? 'selected' : '' ?>
                        >
                            Caja
                        </option>
                    </select>
                </fieldset>

                <!-- UNIDAD DE MEDIDA DE VENTA -->
                <fieldset>
                    <legend>
                        Unidad de venta *
                        <p class='message-error'>
                            <?= $_SESSION['errors']['unidad_venta_producto'] ?? '' ?>
                        </p>
                    </legend>

                    <input type="radio" name="unidad_venta_producto" checked value="" class="hidden">
                    <select name="unidad_venta_producto" id="unidad_venta">
                        <option selected disabled>Seleccione la unidad de venta</option>
                        <option
                            value="pieza"
                            <?= $producto['unidad_venta_producto'] === 'pieza' ? 'selected' : '' ?>
                            <?= isset($_SESSION['olds']['unidad_venta_producto']) && $_SESSION['olds']['unidad_venta_producto'] === 'pieza' ? 'selected' : '' ?>
                        >
                            Pieza
                        </option>

                        <option
                            value="paquete"
                            <?= $producto['unidad_venta_producto'] === 'paquete' ? 'selected' : '' ?>
                            <?= isset($_SESSION['olds']['unidad_venta_producto']) && $_SESSION['olds']['unidad_venta_producto'] === 'paquete' ? 'selected' : '' ?>
                        >
                            Paquete
                        </option>

                        <option
                            value="caja"
                            <?= $producto['unidad_venta_producto'] === 'caja' ? 'selected' : '' ?>
                            <?= isset($_SESSION['olds']['unidad_venta_producto']) && $_SESSION['olds']['unidad_venta_producto'] === 'caja' ? 'selected' : '' ?>
                        >
                            Caja
                        </option>
                    </select>
                </fieldset>

                <!-- STOCK -->
                <fieldset>
                    <legend>
                        Stock
                        <p class='message-error'>
                            <?= $_SESSION['errors']['stock_producto'] ?? '' ?>
                        </p>
                        <span class="flex gap-2">
                            Existencias acutales:
                            <?php $stock = $producto['stock_producto'] ?>
                            <?php $unidad_compra = $producto['unidad_compra_producto'] ?>
                            <strong>
                                <?= $stock === 1 ? "$stock {$unidad_compra}" : "$stock {$unidad_compra}s" ?>
                            </strong>
                        </span>
                    </legend>

                    <strong><small id="stockLabel">Cantidad de las unidades de compra</small></strong>
                    <input
                        type="number" id="stock" name="stock_producto" placeholder="Añada las nuevas unidades de compra" oninput="validarUnidades(this)"
                        value="<?= $_SESSION['olds']['stock_producto'] ?? '' ?>"
                    >
                </fieldset>

                <!-- FACTOR DE CONVERSION -->
                <fieldset id="conversion_extra" style="display: none;">
                    <legend>
                        Factor de conversión *
                        <p class='message-error'>
                            <?= $_SESSION['errors']['factor_conversion'] ?? '' ?>
                        </p>
                    </legend>

                    <small class="flex gap-1.5">
                        (Especifique cuántas unidades de venta equivalen a una unidad de compra)
                        <span class="p-[3px] bg-red-400 border-[1px] border-red-800 border-solid shadow-lg text-center max-h-max rounded-full" title="Si unna caja contiene 25 pzas., escribe 25">
                            <span class="bg-white rounded-full p-0.5 text-xs">❓</span>
                        </span>
                    </small>

                    <div class="flex flex-col justify-between">
                        <p id="conversion_result" class="font-black"></p>
                        <input
                            type="number" id="cantidad_conversion" placeholder="Ej. 50 si una caja tiene 50 piezas"
                            oninput="validarUnidades(this)"
                            value="<?= $_SESSION['olds']['factor_conversion'] ?? (int)$producto['factor_conversion'] ?>"
                        >
                        <input
                            type="hidden" name="factor_conversion" id="factor_conversion"
                            value="<?= $_SESSION['olds']['factor_conversion'] ?? (int)$producto['factor_conversion'] ?>"
                        >
                    </div>
                </fieldset>

                <!-- PRECIO COSTO -->
                <fieldset>
                    <legend>
                        Precio de Costo *💲
                        <p class='message-error'>
                            <?= $_SESSION['errors']['precio_costo_producto'] ?? '' ?>
                        </p>
                    </legend>

                    <input
                        type="text" id="precio_costo" name="precio_costo_producto" placeholder="Ingrese el precio de costo" oninput="validarPrecios(this)"
                        value="<?= $_SESSION['olds']['precio_costo_producto'] ?? $producto['precio_costo_producto'] ?>"
                    >
                </fieldset>

                <!-- PRECIO VENTA -->
                <fieldset>
                    <legend>
                        Precio de Venta *💲
                        <p class='message-error'>
                            <?= $_SESSION['errors']['precio_venta_producto'] ?? '' ?>
                        </p>
                    </legend>

                    <input
                        type="text" id="precio_venta" name="precio_venta_producto" placeholder="Ingrese el precio de venta"
                        oninput="validarPrecios(this)"
                        value="<?= $_SESSION['olds']['precio_venta_producto'] ?? $producto['precio_venta_producto'] ?>"
                    >
                </fieldset>

                <!-- APLICA MAYOREO -->
                <fieldset>
                    <legend>
                        Aplica venta al por mayor *
                        <p class='message-error'>
                            <?= $_SESSION['errors']['aplica_mayoreo'] ?? '' ?>
                        </p>
                    </legend>

                    <div class="flex justify-start gap-8 items-center">
                        <?php $aplica_mayoreo_registro = $producto['aplica_mayoreo'] ?? null; ?>
                        <?php $aplica_mayoreo_sesion = isset($_SESSION['olds']['aplica_mayoreo']) ? $_SESSION['olds']['aplica_mayoreo'] : null; ?>

                        <div class="flex gap-2 items-center">
                            <input
                                type="radio" name="aplica_mayoreo" value="1"
                                <?php
                                    if (isset($aplica_mayoreo_sesion) && $aplica_mayoreo_sesion === 'si') echo 'checked';
                                    elseif ((int)$aplica_mayoreo_registro === 1 && $aplica_mayoreo_sesion !== 'no') echo 'checked';
                                ?>
                            >
                            <span>Sí</span>
                        </div>

                        <div class="flex gap-2 items-center">
                            <input
                                type="radio" name="aplica_mayoreo" value="0"
                                <?php
                                    if (isset($aplica_mayoreo_sesion) && $aplica_mayoreo_sesion === 'no') echo 'checked';
                                    elseif ((int)$aplica_mayoreo_registro === 0 && $aplica_mayoreo_sesion !== 'si') echo 'checked';
                                ?>
                            >
                            <span>No</span>
                        </div>
                    </div>
                </fieldset>

                <!-- CANTIDAD MINIMA APLICABLE AL POR MAYOR -->
                <fieldset style="display: none;" id="min-quantity-wholesale">
                    <legend>
                        Cantidad mínima aplicable al por mayor *
                        <p class='message-error'>
                            <?= $_SESSION['errors']['cantidad_minima_mayoreo_producto'] ?? '' ?>
                        </p>
                    </legend>

                    <input
                        type="text" id="cantidad_minima_mayoreo_producto" name="cantidad_minima_mayoreo_producto" placeholder="Ingrese la cantidad mínima aplicable a mayoreo"
                        oninput="validarPrecios(this)"
                        value="<?= $_SESSION['olds']['cantidad_minima_mayoreo_producto'] ?? $producto['cantidad_minima_mayoreo_producto'] ?>"
                    >
                </fieldset>

                <!-- PRECIO MAYOREO -->
                <fieldset style="display: none;" id="wholesale-price">
                    <legend>
                        Precio al por mayor *💲
                        <p class='message-error'>
                            <?= $_SESSION['errors']['precio_mayoreo_producto'] ?? '' ?>
                        </p>
                    </legend>

                    <input
                        type="text" id="precio_mayoreo" name="precio_mayoreo_producto" placeholder="Ingrese el precio de mayoreo"
                        oninput="validarPrecios(this)"
                        value="<?= $_SESSION['olds']['precio_mayoreo_producto'] ?? $producto['precio_mayoreo_producto'] ?>"
                    >
                </fieldset>

                <!-- VENCIMIENTO -->
                <fieldset>
                    <legend>
                        Vencimiento del nuevo lote <small><em><strong>(si aplica)</strong></em></small>
                        <?php if (isset($producto['lote'])): ?>
                            <span class="flex gap-2 items-baseline">
                                Vencimiento del último lote:
                                <small><em><strong>
                                    <?= $producto['lote']['fecha_vencimiento'] ?? '' ?>
                                </strong></em></small>
                            </span>
                        <?php endif; ?>

                        <p class='message-error'>
                            <?= $_SESSION['errors']['vencimiento'] ?? '' ?>
                        </p>
                    </legend>


                    <input
                        type="date" name="vencimiento" class="uppercase"
                        value="<?= $_SESSION['olds']['vencimiento'] ?? '' ?>"
                    >
                </fieldset>

                <!-- IMAGEN -->
                <fieldset class="field-image-edit-form">
                    <div>
                        <legend>
                            Imagen *
                            <p class="message-error">
                                <?= $_SESSION['errors']['imagen'] ?? '' ?>
                            </p>
                        </legend>
                    </div>

                    <div class="image-upload-container" onclick="document.getElementById('imagenInput').click()">
                        <img id="previewImg" src="" alt="Vista previa">
                        <span id="uploadText" class="upload-label">Haz click para subir una imagen</span>
                        <input type="file" name="imagen" id="imagenInput" accept="image/*" onchange="mostrarVistaPrevia(event)">
                    </div>

                    <span class="font-medium text-gray-500"><small>Imgen actual</small></span>
                    <div class="current-image-container">
                        <img src="<?= $producto['imagen_producto'] ?>" alt="Imagen actual">
                    </div>
                </fieldset>


                <input type="hidden" name="accion" value="actualizar">

                <!-- ENVIAR FORMULARIO -->
                <!-- RESTABLECER VALORES INICIALES -->
                <fieldset class="form-btns">
                    <button type="button" class="form-btn reset-btn" id="reset-btn" title="Regrese los valores a su estado inicial">
                        Restablecer
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M440-122q-121-15-200.5-105.5T160-440q0-66 26-126.5T260-672l57 57q-38 34-57.5 79T240-440q0 88 56 155.5T440-202v80Zm80 0v-80q87-16 143.5-83T720-440q0-100-70-170t-170-70h-3l44 44-56 56-140-140 140-140 56 56-44 44h3q134 0 227 93t93 227q0 121-79.5 211.5T520-122Z"/></svg>
                    </button>

                    <button type="submit" class="form-btn">
                        guardar
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M713-600 600-713l56-57 57 57 141-142 57 57-198 198ZM200-120v-640q0-33 23.5-56.5T280-840h240v80H280v518l200-86 200 86v-278h80v400L480-240 200-120Zm80-640h240-240Z"></path></svg>
                    </button>
                </fieldset>
            </form>
        </div>
    </main>

    <!-- SWEET ALERT -->
    <?php
        if (isset($_SESSION['swal'])) {
            echo $_SESSION['swal'];
            unset($_SESSION['swal']);
        }

        unset($_SESSION['olds']);
        unset($_SESSION['errors']);
    ?>

    <!-- RESTABLECER VALORES INICIALES -->
    <script>
        document.getElementById('reset-btn').addEventListener('click', () => {
            window.location.reload();
        });
    </script>

    <!-- MOSTRAR CAMPOS PARA MAYOREO -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const radios = document.querySelectorAll('input[name="aplica_mayoreo"]');
            const minQuantityWholesale = document.getElementById('min-quantity-wholesale');
            const wholesalePrice = document.getElementById('wholesale-price');

            function toggleWholesaleFields() {
                const selected = document.querySelector('input[name="aplica_mayoreo"]:checked');

                if (selected && selected.value === '1') {
                    minQuantityWholesale.style.display = 'flex';
                    wholesalePrice.style.display = 'flex';
                } else {
                    minQuantityWholesale.style.display = 'none';
                    wholesalePrice.style.display = 'none';
                }
            }

            toggleWholesaleFields();

            radios.forEach(radio => {
                radio.addEventListener('change', toggleWholesaleFields);
            });
        });
    </script>

    <!-- REEMPLAZAR NUMEROS NEGATIVOS -->
    <script>
        function validarCodigoBarras(input) {
            input.value = input.value.replace(/[^0-9]/g, '');
        }

        function validarUnidades(input) {
            input.value = input.value.replace(/^0+|[^0-9]/g, '');
        }

        function validarPrecios(input) {
            let cursorPos = input.selectionStart;
            let longitudAntes = input.value.length;

            input.value = input.value.replace(/^0+(\d)/, '$1')
                                    .replace(/[^0-9.]/g, '')
                                    .replace(/(\..*)\./g, '$1')
                                    .replace(/^(\d+\.\d{2})\d+$/, '$1');

            if (input.value === "0") input.value = "";

            if (input.value.startsWith('.')) input.value = '';
        }
    </script>

    <!-- FACTOR DE CONVERSION -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const unidadCompra = document.getElementById("unidad_compra");
            const unidadVenta = document.getElementById("unidad_venta");
            const conversionExtra = document.getElementById("conversion_extra");
            const cantidadConversion = document.getElementById("cantidad_conversion");
            const factorConversion = document.getElementById("factor_conversion");
            const conversionResult = document.getElementById("conversion_result");
            const stockLabel = document.getElementById("stockLabel");

            const unidadesConversión = ["paquete", "caja"];

            unidadCompra.addEventListener("change", function() {
                let selectedCompra = unidadCompra.value;
                let selectedVenta = unidadVenta.value;

                if (unidadesConversión.includes(selectedCompra) && selectedCompra !== selectedVenta) {
                    conversionExtra.style.display = "block";
                } else {
                    conversionExtra.style.display = "none";
                    cantidadConversion.value = 1;
                    factorConversion.value = 1;
                    conversionResult.textContent = "";
                }

                stockLabel.textContent = `Cantidad de ${selectedCompra}s en stock`;
            });

            unidadVenta.addEventListener("change", function() {
                unidadCompra.dispatchEvent(new Event("change"));
            });


            unidadVenta.addEventListener("change", calcularFactorConversion);
            cantidadConversion.addEventListener("input", calcularFactorConversion);

            function calcularFactorConversion() {
                let selectedCompra = unidadCompra.value;
                let selectedVenta = unidadVenta.value;
                let cantidad = cantidadConversion.value;

                if (!cantidad || cantidad <= 0) {
                    factorConversion.value = "";
                    conversionResult.textContent = "";
                    return;
                }

                let factor = 1;


                if (selectedCompra === "paquete" && selectedVenta === "pieza") {
                    factor = cantidad;
                } else if (selectedCompra === "caja" && selectedVenta === "pieza") {
                    factor = cantidad;
                } else if (selectedCompra === "pieza" && selectedVenta === "pieza") {
                    factor = 1;
                } else if (selectedCompra === "pieza" && selectedVenta === "pieza") {
                    factor = 1;
                }

                factorConversion.value = factor;
                conversionResult.textContent = `1 ${selectedCompra} = ${factor} ${selectedVenta}s`;
            }
        });
    </script>

    <!-- VISTA PREVIA DE LA IMAGEN -->
    <script>
        function mostrarVistaPrevia(event) {
            const fileInput = event.target;
            const file = fileInput.files[0];
            const previewImg = document.getElementById("previewImg");
            const uploadText = document.getElementById("uploadText");

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewImg.style.display = "block";
                    uploadText.style.display = "none";
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>
