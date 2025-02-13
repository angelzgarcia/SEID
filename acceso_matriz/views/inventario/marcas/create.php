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

            <form class="form-create" action="<?= MATRIX_FNS ?>crud_producto" method="POST" autocomplete="off">
                <!-- CATEGORIA -->
                <fieldset class="field-select">
                    <legend>Categoría</legend>
                    <p class='message-error'>
                        <?= $_SESSION['errors']['categoria'] ?? '' ?>
                    </p>

                    <select name="categoria">
                        <option selected disabled>Seleccione la categoría del producto</option>
                        <option value="">Categoría 1</option>
                        <option value="">Categoría 2</option>
                        <option value="">Categoría 3</option>
                        <option value="">Categoría 4</option>
                        <option value="">Categoría 5</option>
                    </select>
                </fieldset>

                <!-- MARCA -->
                <fieldset class="field-select">
                    <legend>Marca</legend>
                    <p class='message-error'>
                        <?= $_SESSION['errors']['marca'] ?? '' ?>
                    </p>

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
                    <legend>Codigo de barras</legend>
                    <p class='message-error'>
                        <?= $_SESSION['errors']['codigo_barras'] ?? '' ?>
                    </p>

                    <input type="text" name="codigo_barras" placeholder="Ingrese el codigo de barras" >
                </fieldset>

                <!-- NOMBRE -->
                <fieldset>
                    <legend>Nombre *</legend>
                    <p class='message-error'>
                        <?= $_SESSION['errors']['nombre'] ?? '' ?>
                    </p>

                    <input type="text" name="nombre" placeholder="Ingrese el nombre del producto" value="<?= $_SESSION['olds']['nombre'] ?? '' ?>">
                </fieldset>

                <!-- TIPO DE VENTA -->
                <fieldset>
                    <legend>Se vende por *</legend>
                    <p class='message-error'>
                        <?= $_SESSION['errors']['tipo_venta'] ?? '' ?>
                    </p>

                    <div class="type_sales">
                        <input type="radio" name="tipo_venta" checked value="" class="hidden">
                        <div>
                            <input type="radio" name="tipo_venta" class="tipo_venta" value="unidad" onchange="ajustarCampos()">
                            <label for="venta_unidad">Unidad</label>
                        </div>

                        <div>
                            <input type="radio" name="tipo_venta" class="tipo_venta" value="granel" onchange="ajustarCampos()">
                            <label for="venta_granel">Granel</label>
                        </div>

                        <div>
                            <input type="radio" name="tipo_venta" class="tipo_venta" value="paquete" onchange="ajustarCampos()">
                            <label for="venta_paquete">Paquete</label>
                        </div>
                    </div>
                </fieldset>

                <!-- STOCK -->
                <fieldset>
                    <legend>Stock *</legend>
                    <p class='message-error'>
                        <?= $_SESSION['errors']['stock'] ?? '' ?>
                    </p>

                    <small id="stockLabel">Cantidad en unidades</small>
                    <input type="text" id="stock" name="stock" placeholder="Ingrese la cantidad de stock" oninput="validarNumero(this)">
                </fieldset>

                <!-- PRECIO COSTO -->
                <fieldset>
                    <legend>Precio de Costo *</legend>
                    <p class='message-error'>
                        <?= $_SESSION['errors']['precio_costo'] ?? '' ?>
                    </p>

                    <input type="text" id="precio_costo" name="precio_costo" placeholder="Ingrese el precio de costo" oninput="validarNumero(this)">
                </fieldset>


                <!-- PRECIO VENTA -->
                <fieldset>
                    <legend>Precio de Venta *</legend>
                    <p class='message-error'>
                        <?= $_SESSION['errors']['precio_venta'] ?? '' ?>
                    </p>

                    <input type="text" id="precio_venta" name="precio_venta" placeholder="Ingrese el precio de venta" oninput="validarNumero(this)">
                </fieldset>

                <!-- PRECIO MAYOREO -->
                <fieldset>
                    <legend>Precio de Mayoreo</legend>
                    <p class='message-error'>
                        <?= $_SESSION['errors']['precio_mayoreo'] ?? '' ?>
                    </p>

                    <input type="text" id="precio_mayoreo" name="precio_mayoreo" placeholder="Ingrese el precio de mayoreo" oninput="validarNumero(this)">
                </fieldset>

                <!-- VENCIMIENTO -->
                <fieldset>
                    <legend>Vencimiento</legend>
                    <p class='message-error'>
                        <?= $_SESSION['errors']['vencimiento'] ?? '' ?>
                    </p>

                    <input type="date" name="vencimiento" class="uppercase">
                </fieldset>

                <!-- IMAGEN -->
                <fieldset>
                    <legend>Imagen *</legend>

                    <p class="message-error">
                        <?= $_SESSION['errors']['imagen'] ?? '' ?>
                    </p>

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
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M840-680v480q0 33-23.5 56.5T760-120H200q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h480l160 160Zm-80 34L646-760H200v560h560v-446ZM480-240q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35ZM240-560h360v-160H240v160Zm-40-86v446-560 114Z"/></svg>
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

    <!-- AJUSTAR PLACEHOLDER Y LEGEND DEL INPUT STOCK SEGÚN EL TIPO DE VENTA -->
    <script>
        function ajustarCampos() {
            let tipoVenta = document.querySelector('input[name="tipo_venta"]:checked').value;
            let stockInput = document.getElementById("stock");
            let stockLabel = document.getElementById("stockLabel");

            if (tipoVenta === "granel") {
                stockInput.placeholder = "Ingrese la cantidad en kg, g, L, etc.";
                stockLabel.textContent = "Cantidad en peso (kg, g, L, etc.)";
            } else if (tipoVenta === "paquete") {
                stockInput.placeholder = "Ingrese la cantidad de productos por paquete";
                stockLabel.textContent = "Cantidad de productos por paquete";
            } else {
                stockInput.placeholder = "Ingrese la cantidad en unidades";
                stockLabel.textContent = "Cantidad en unidades";
            }
        }

        function validarNumero(input) {
            input.value = input.value.replace(/[^0-9.]/g, '');
        }
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
