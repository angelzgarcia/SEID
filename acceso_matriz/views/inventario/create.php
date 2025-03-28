<?php require_once __DIR__ . '/../../config.php' ?>
<?php require_once MATRIX_DOC_ROOT . 'database.php' ?>
<?php require_once MATRIX_DOC_FNS . 'helpers/encrypt.php' ?>

<?php $page_name = ACCESO . 'Añadir producto' ?>

<?php
    $sql_categorias = 'SELECT id_categoria, nombre_categoria FROM categorias WHERE status_categoria = 0 ORDER BY nombre_categoria ASC';
    $categorias = simpleQuery($sql_categorias, [], '', true) ?: [];

    $sql_marcas = 'SELECT id_marca, nombre_marca FROM marcas WHERE status_marca = 0 ORDER BY nombre_marca ASC';
    $marcas = simpleQuery($sql_marcas) ?: [];
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
                <h1>Añadir producto 📦</h1>

                <!-- ACCESOS DIRECTOS -->
                <div class="shortcuts-links">
                    <a href="./index" title="Inventario" class="shortcut-link-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M440-183v-274L200-596v274l240 139Zm80 0 240-139v-274L520-457v274Zm-80 92L160-252q-19-11-29.5-29T120-321v-318q0-22 10.5-40t29.5-29l280-161q19-11 40-11t40 11l280 161q19 11 29.5 29t10.5 40v318q0 22-10.5 40T800-252L520-91q-19 11-40 11t-40-11Zm200-528 77-44-237-137-78 45 238 136Zm-160 93 78-45-237-137-78 45 237 137Z"/></svg>
                    </a>

                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-120q-75 0-140.5-28.5t-114-77q-48.5-48.5-77-114T120-480q0-75 28.5-140.5t77-114q48.5-48.5 114-77T480-840v80q-117 0-198.5 81.5T200-480q0 117 81.5 198.5T480-200v80Zm160-160-56-57 103-103H360v-80h327L584-624l56-56 200 200-200 200Z"/></svg>

                    <a title="Añadir producto" class="shortcut-link-btn <?= strpos($_SERVER['PHP_SELF'], 'inventario/create') ? 'active' : '' ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M440-120v-320H120v-80h320v-320h80v320h320v80H520v320h-80Z"/></svg>
                    </a>
                </div>
            </div>

            <form class="form-create" action="<?= MATRIX_FNS ?>crud_producto" method="POST" autocomplete="off" enctype="multipart/form-data">
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
                                    <?= isset($_SESSION['olds']['categoria']) && (int)$_SESSION['olds']['categoria'] === (int)$categoria['id_categoria'] ? 'selected' : '' ?>
                                >
                                    <?= ucfirst($categoria['nombre_categoria']) ?>
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
                                    <?= isset($_SESSION['olds']['marca']) && (int)$_SESSION['olds']['marca'] === (int)$marca['id_marca'] ? 'selected' : '' ?>
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
                            <?= $_SESSION['errors']['codigo_barras'] ?? '' ?>
                        </p>
                    </legend>

                    <input
                        type="text"
                        name="codigo_barras"
                        placeholder="Ingrese el codigo de barras" value="<?= $_SESSION['olds']['codigo_barras'] ?? '' ?>"
                        oninput="validarCodigoBarras(this)"
                    >
                </fieldset>

                <!-- NOMBRE -->
                <fieldset>
                    <legend>
                        Nombre *
                        <p class='message-error'>
                            <?= $_SESSION['errors']['nombre'] ?? '' ?>
                        </p>
                    </legend>

                    <input type="text" name="nombre" placeholder="Ingrese el nombre del producto" value="<?= $_SESSION['olds']['nombre'] ?? '' ?>">
                </fieldset>

                <!-- UNIDAD DE MEDIDA DE COMPRA -->
                <fieldset>
                    <legend>
                        Unidad de compra *
                        <p class='message-error'>
                            <?= $_SESSION['errors']['unidad_compra'] ?? '' ?>
                        </p>
                    </legend>

                    <input type="radio" name="unidad_compra" checked value="" class="hidden">
                    <select name="unidad_compra" id="unidad_compra">
                        <option selected disabled>Seleccione la unidad de compra</option>
                        <option <?= isset($_SESSION['olds']['unidad_compra']) && $_SESSION['olds']['unidad_compra'] === 'pieza' ? 'selected' : '' ?> value="pieza">Pieza</option>
                        <option <?= isset($_SESSION['olds']['unidad_compra']) && $_SESSION['olds']['unidad_compra'] === 'paquete' ? 'selected' : '' ?> value="paquete">Paquete</option>
                        <option <?= isset($_SESSION['olds']['unidad_compra']) && $_SESSION['olds']['unidad_compra'] === 'caja' ? 'selected' : '' ?> value="caja">Caja</option>
                        <!-- <option value="saco">Saco</option>
                        <option value="bulto">Bulto</option>
                        <option value="rollo">Rollo</option>
                        <option value="botella">Botella</option>
                        <option value="lata">Lata</option>
                        <option value="kg">Kilogramos</option>
                        <option value="gramo">Gramos</option>
                        <option value="tonelada">Toneladas</option>
                        <option value="litro">Litros</option>
                        <option value="mililitro">Mililitros</option>
                        <option value="metro">Metros</option>
                        <option value="centimetro">Centímetros</option>
                        <option value="milimetro">Milímetros</option> -->
                    </select>
                </fieldset>

                <!-- UNIDAD DE MEDIDA DE VENTA -->
                <fieldset>
                    <legend>
                        Unidad de venta *
                        <p class='message-error'>
                            <?= $_SESSION['errors']['unidad_venta'] ?? '' ?>
                        </p>
                    </legend>

                    <input type="radio" name="unidad_venta" checked value="" class="hidden">
                    <select name="unidad_venta" id="unidad_venta">
                        <option selected disabled>Seleccione la unidad de venta</option>
                        <option <?= isset($_SESSION['olds']['unidad_venta']) && $_SESSION['olds']['unidad_venta'] === 'pieza' ? 'selected' : '' ?> value="pieza">Pieza</option>
                        <option <?= isset($_SESSION['olds']['unidad_venta']) && $_SESSION['olds']['unidad_venta'] === 'paquete' ? 'selected' : '' ?> value="paquete">Paquete</option>
                        <option <?= isset($_SESSION['olds']['unidad_venta']) && $_SESSION['olds']['unidad_venta'] === 'caja' ? 'selected' : '' ?> value="caja">Caja</option>
                    </select>
                </fieldset>

                <!-- STOCK -->
                <fieldset>
                    <legend>
                        Stock *
                        <p class='message-error'>
                            <?= $_SESSION['errors']['stock'] ?? '' ?>
                        </p>
                    </legend>

                    <strong><small id="stockLabel">Cantidad de las unidades de compra</small></strong>
                    <input type="number" id="stock" name="stock" value="<?= $_SESSION['olds']['stock'] ?? '' ?>"  placeholder="Ingrese el stock inicial" oninput="validarUnidades(this)">
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
                        <input type="number" id="cantidad_conversion" placeholder="Ej. 50 si una caja tiene 50 piezas" oninput="validarUnidades(this)">
                        <input type="hidden" name="factor_conversion" value="<?= $_SESSION['olds']['factor_conversion'] ?? '' ?>" id="factor_conversion">
                    </div>
                </fieldset>

                <!-- PRECIO COSTO -->
                <fieldset>
                    <legend>
                        Precio de Costo *💲
                        <p class='message-error'>
                            <?= $_SESSION['errors']['precio_costo'] ?? '' ?>
                        </p>
                    </legend>

                    <input type="text" id="precio_costo" name="precio_costo" value="<?= $_SESSION['olds']['precio_costo'] ?? '' ?>" placeholder="Ingrese el precio de costo" oninput="validarPrecios(this)">
                </fieldset>

                <!-- PRECIO VENTA -->
                <fieldset>
                    <legend>
                        Precio de Venta *💲
                        <p class='message-error'>
                            <?= $_SESSION['errors']['precio_venta'] ?? '' ?>
                        </p>
                    </legend>

                    <input type="text" id="precio_venta" name="precio_venta" value="<?= $_SESSION['olds']['precio_venta'] ?? '' ?>" placeholder="Ingrese el precio de venta" oninput="validarPrecios(this)">
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
                        <div class="flex gap-2 items-center">
                            <input
                                type="radio"
                                name="aplica_mayoreo"
                                value="0"
                                <?= isset($_SESSION['olds']['aplica_mayoreo']) && $_SESSION['olds']['aplica_mayoreo']  === 'si' ? 'checked' : '' ?>
                            >
                            <span>Sí</span>
                        </div>

                        <div class="flex gap-2 items-center">
                            <input
                                type="radio"
                                name="aplica_mayoreo"
                                value="1"
                                <?= !isset($_SESSION['olds']['aplica_mayoreo']) || $_SESSION['olds']['aplica_mayoreo'] === 'no' ? 'checked' : '' ?>
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
                            <?= $_SESSION['errors']['cantidad_minima_mayoreo'] ?? '' ?>
                        </p>
                    </legend>

                    <input type="text" id="cantidad_minima_mayoreo" name="cantidad_minima_mayoreo" value="<?= $_SESSION['olds']['cantidad_minima_mayoreo'] ?? '' ?>" placeholder="Ingrese la cantidad mínima aplicable a mayoreo" oninput="validarPrecios(this)">
                </fieldset>

                <!-- PRECIO MAYOREO -->
                <fieldset style="display: none;" id="wholesale-price">
                    <legend>
                        Precio al por mayor *💲
                        <p class='message-error'>
                            <?= $_SESSION['errors']['precio_mayoreo'] ?? '' ?>
                        </p>
                    </legend>

                    <input type="text" id="precio_mayoreo" name="precio_mayoreo" value="<?= $_SESSION['olds']['precio_mayoreo'] ?? '' ?>" placeholder="Ingrese el precio de mayoreo" oninput="validarPrecios(this)">
                </fieldset>

                <!-- VENCIMIENTO -->
                <fieldset>
                    <legend>
                        Vencimiento
                        <p class='message-error'>
                            <?= $_SESSION['errors']['vencimiento'] ?? '' ?>
                        </p>
                    </legend>

                    <input type="text" id="datepicker" name="vencimiento" class="search-order-by-date" placeholder="Buscar pedidos por fecha">
                </fieldset>

                <!-- IMAGEN -->
                <fieldset>
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
                </fieldset>

                <input type="hidden" name="accion" value="guardar">

                <!-- ENVIAR FORMULARIO -->
                <button type="submit" class="form-btn">
                    guardar
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M713-600 600-713l56-57 57 57 141-142 57 57-198 198ZM200-120v-640q0-33 23.5-56.5T280-840h240v80H280v518l200-86 200 86v-278h80v400L480-240 200-120Zm80-640h240-240Z"></path></svg>
                </button>
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

    <script src="<?=MATRIX_HTTP_URL?>resources/js/tooltips.js"></script>

    <script src="<?= MATRIX_HTTP_URL ?>resources/js/product_form.js"></script>
</body>
</html>
