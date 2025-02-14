<?php require_once __DIR__ . '/../../config.php' ?>
<?php $page_name = ACCESO . 'Añadir producto' ?>

<!DOCTYPE html>
<html lang="en">
<?php require_once MATRIX_DOC_VIEWS . "modules/head.php" ?>
<body>
    <?php require_once MATRIX_DOC_VIEWS . "/modules/header.php" ?>

    <?php require_once MATRIX_DOC_VIEWS . "/modules/sidebar.php" ?>

    <main class="main-content matriz-content">
        <!-- CREAR PRODUCTO -->
        <div class="form-create-container">
            <h1>
                Añadir producto
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m260-520 220-360 220 360H260ZM700-80q-75 0-127.5-52.5T520-260q0-75 52.5-127.5T700-440q75 0 127.5 52.5T880-260q0 75-52.5 127.5T700-80Zm-580-20v-320h320v320H120Zm580-60q42 0 71-29t29-71q0-42-29-71t-71-29q-42 0-71 29t-29 71q0 42 29 71t71 29Zm-500-20h160v-160H200v160Zm202-420h156l-78-126-78 126Zm78 0ZM360-340Zm340 80Z"/></svg>
            </h1>

            <form class="form-create" action="<?= MATRIX_FNS ?>crud_producto" method="POST" autocomplete="off" enctype="multipart/form-data">
                <!-- CATEGORIA -->
                <fieldset class="field-select">
                    <legend>
                        Categoría
                        <p class='message-error'>
                            <?= $_SESSION['errors']['categoria'] ?? '' ?>
                        </p>
                    </legend>

                    <input type="hidden" name="categoria" value="">
                    <select name="categoria">
                        <option selected disabled>Seleccione la categoría del producto</option>
                        <option value="cat1">Categoría 1</option>
                        <option value="">Categoría 2</option>
                        <option value="">Categoría 3</option>
                        <option value="">Categoría 4</option>
                        <option value="">Categoría 5</option>
                    </select>
                </fieldset>

                <!-- MARCA -->
                <fieldset class="field-select">
                    <legend>
                        Marca
                        <p class='message-error'>
                            <?= $_SESSION['errors']['marca'] ?? '' ?>
                        </p>
                    </legend>

                    <input type="hidden" name="marca" value="">
                    <select name="marca">
                        <option selected disabled>Seleccione la marca del producto</option>
                        <option value="">Marca 1</option>
                        <option value="">Marca 2</option>
                        <option value="">Marca 3</option>
                        <option value="">Marca 4</option>
                    </select>
                </fieldset>

                <!-- CODIGO DE BARRAS -->
                <fieldset>
                    <legend>
                        Codigo de barras
                        <p class='message-error'>
                            <?= $_SESSION['errors']['codigo_barras'] ?? '' ?>
                        </p>
                    </legend>

                    <input type="text" name="codigo_barras" placeholder="Ingrese el codigo de barras" >
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
                        <option value="pieza">Pieza</option>
                        <option value="paquete">Paquete</option>
                        <option value="caja">Caja</option>
                        <option value="saco">Saco</option>
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
                        <option value="milimetro">Milímetros</option>
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
                        <option value="pieza">Pieza</option>
                        <option value="paquete">Paquete</option>
                        <option value="caja">Caja</option>
                        <option value="saco">Saco</option>
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
                        <option value="milimetro">Milímetros</option>
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

                    <strong><small id="stockLabel">Cantidad de las unidad de compra</small></strong>
                    <input type="number" id="stock" name="stock" step="0.01" placeholder="Ingrese el stock inicial" oninput="validarNumero(this)">
                </fieldset>

                <!-- FACTOR DE CONVERSION -->
                <fieldset id="conversion_extra" style="display: none;">
                    <legend>
                        Factor de conversión *
                        <p class='message-error'>
                            <?= $_SESSION['errors']['factor_conversion'] ?? '' ?>
                        </p>
                    </legend>

                    <small>¿Cuántas unidades de venta hay en una unidad de compra?</small>
                    <div class="flex flex-col justify-between">
                        <p id="conversion_result" class="font-black"></p>
                        <input type="number" id="cantidad_conversion" step="0.01" placeholder="Ej. 25 si un bulto tiene 25 kg">
                        <input type="hidden" name="factor_conversion" id="factor_conversion">
                    </div>
                </fieldset>

                <!-- PRECIO COSTO -->
                <fieldset>
                    <legend>
                        Precio de Costo *
                        <p class='message-error'>
                            <?= $_SESSION['errors']['precio_costo'] ?? '' ?>
                        </p>
                    </legend>

                    <input type="text" id="precio_costo" name="precio_costo" step="0.01" placeholder="Ingrese el precio de costo" oninput="validarNumero(this)">
                </fieldset>

                <!-- PRECIO VENTA -->
                <fieldset>
                    <legend>
                        Precio de Venta *
                        <p class='message-error'>
                            <?= $_SESSION['errors']['precio_venta'] ?? '' ?>
                        </p>
                    </legend>

                    <input type="text" id="precio_venta" name="precio_venta" step="0.01" placeholder="Ingrese el precio de venta" oninput="validarNumero(this)">
                </fieldset>

                <!-- PRECIO MAYOREO -->
                <fieldset>
                    <legend>
                        Precio de Mayoreo
                        <p class='message-error'>
                            <?= $_SESSION['errors']['precio_mayoreo'] ?? '' ?>
                        </p>
                    </legend>

                    <input type="text" id="precio_mayoreo" name="precio_mayoreo" step="0.01" placeholder="Ingrese el precio de mayoreo" oninput="validarNumero(this)">
                </fieldset>

                <!-- VENCIMIENTO -->
                <fieldset>
                    <legend>
                        Vencimiento
                        <p class='message-error'>
                            <?= $_SESSION['errors']['vencimiento'] ?? '' ?>
                        </p>
                    </legend>

                    <input type="date" name="vencimiento" class="uppercase">
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
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m720-120 160-160-56-56-64 64v-167h-80v167l-64-64-56 56 160 160ZM560 0v-80h320V0H560ZM240-160q-33 0-56.5-23.5T160-240v-560q0-33 23.5-56.5T240-880h280l240 240v121h-80v-81H480v-200H240v560h240v80H240Zm0-80v-560 560Z"/></svg>
                </button>
            </form>
        </div>
    </main>

    <!-- SWEET ALERT -->
    <?php
        if (isset($_SESSION['swal']))
            echo $_SESSION['swal'];

        session_unset();
        session_destroy();
    ?>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const unidadCompra = document.getElementById("unidad_compra");
            const unidadVenta = document.getElementById("unidad_venta");
            const conversionExtra = document.getElementById("conversion_extra");
            const cantidadConversion = document.getElementById("cantidad_conversion");
            const factorConversion = document.getElementById("factor_conversion");
            const conversionResult = document.getElementById("conversion_result");
            const stockLabel = document.getElementById("stockLabel");

            // Unidades que requieren conversión manual
            const unidadesConversión = ["bulto", "rollo", "saco", "paquete", "caja"];

            // Manejar cambio en unidad de compra
            unidadCompra.addEventListener("change", function() {
                let selectedCompra = unidadCompra.value;

                // Si la unidad de compra requiere conversión, mostrar el campo
                if (unidadesConversión.includes(selectedCompra)) {
                    conversionExtra.style.display = "block";
                } else {
                    conversionExtra.style.display = "none";
                    cantidadConversion.value = "";
                    factorConversion.value = "";
                    conversionResult.textContent = "";
                }

                stockLabel.textContent = `Cantidad de ${selectedCompra}s en stock`;
            });

            // Manejar cambio en unidad de venta
            unidadVenta.addEventListener("change", calcularFactorConversion);
            cantidadConversion.addEventListener("input", calcularFactorConversion);

            function calcularFactorConversion() {
                let selectedCompra = unidadCompra.value;
                let selectedVenta = unidadVenta.value;
                let cantidad = parseFloat(cantidadConversion.value);

                if (!cantidad || cantidad <= 0) {
                    factorConversion.value = "";
                    conversionResult.textContent = "";
                    return;
                }

                let factor = 1; // Valor por defecto

                // Casos específicos de conversión
                if (selectedCompra === "bulto" && selectedVenta === "kg") {
                    factor = cantidad;
                } else if (selectedCompra === "bulto" && selectedVenta === "gramo") {
                    factor = cantidad * 1000;
                } else if (selectedCompra === "rollo" && selectedVenta === "metro") {
                    factor = cantidad;
                } else if (selectedCompra === "rollo" && selectedVenta === "centimetro") {
                    factor = cantidad * 100;
                } else if (selectedCompra === "saco" && selectedVenta === "kg") {
                    factor = cantidad;
                } else if (selectedCompra === "saco" && selectedVenta === "gramo") {
                    factor = cantidad * 1000;
                } else if (selectedCompra === "caja" && selectedVenta === "pieza") {
                    factor = cantidad;
                }

                factorConversion.value = factor;
                conversionResult.textContent = `1 ${selectedCompra} = ${factor} ${selectedVenta}s`;
            }
        });
    </script>

    <!-- VISTA PREVIA DEL INPUT FILE -->
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
