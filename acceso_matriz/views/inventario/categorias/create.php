<?php require_once __DIR__ . '/../../../config.php' ?>
<?php $page_name = ACCESO . 'Añadir categoria' ?>

<!DOCTYPE html>
<html lang="en">
<?php require_once MATRIX_DOC_VIEWS . "modules/head.php" ?>
<body>
    <?php require_once MATRIX_DOC_VIEWS . "/modules/header.php" ?>

    <?php require_once MATRIX_DOC_VIEWS . "/modules/sidebar.php" ?>

    <main class="main-content matriz-content">
        <!-- CREAR PRODUCTO -->
        <div class="form-create-container form-category-create-container">
            <div class="form-header category-form-header">
                <h1>Añadir categoría</h1>

                <!-- ACCESOS DIRECTOS -->
                <div class="shortcuts-links">
                    <a href="../index" title="Inventario">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M440-183v-274L200-596v274l240 139Zm80 0 240-139v-274L520-457v274Zm-80 92L160-252q-19-11-29.5-29T120-321v-318q0-22 10.5-40t29.5-29l280-161q19-11 40-11t40 11l280 161q19 11 29.5 29t10.5 40v318q0 22-10.5 40T800-252L520-91q-19 11-40 11t-40-11Zm200-528 77-44-237-137-78 45 238 136Zm-160 93 78-45-237-137-78 45 237 137Z"/></svg>
                    </a>

                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-120q-75 0-140.5-28.5t-114-77q-48.5-48.5-77-114T120-480q0-75 28.5-140.5t77-114q48.5-48.5 114-77T480-840v80q-117 0-198.5 81.5T200-480q0 117 81.5 198.5T480-200v80Zm160-160-56-57 103-103H360v-80h327L584-624l56-56 200 200-200 200Z"/></svg>
                    </span>

                    <a href="index.php" title="Categorías">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m260-520 220-360 220 360H260ZM700-80q-75 0-127.5-52.5T520-260q0-75 52.5-127.5T700-440q75 0 127.5 52.5T880-260q0 75-52.5 127.5T700-80Zm-580-20v-320h320v320H120Zm580-60q42 0 71-29t29-71q0-42-29-71t-71-29q-42 0-71 29t-29 71q0 42 29 71t71 29Zm-500-20h160v-160H200v160Zm202-420h156l-78-126-78 126Zm78 0ZM360-340Zm340 80Z"/></svg>
                    </a>
                </div>
            </div>

            <form class="form-create category-add" action="<?= MATRIX_FNS ?>crud_categoria" method="POST" autocomplete="off" enctype="multipart/form-data">
                <!-- NOMBRE -->
                <fieldset class="category-field-name">
                    <legend>Nombre *</legend>
                    <p class='message-error'>
                        <?= $_SESSION['errors']['nombre'] ?? '' ?>
                    </p>

                    <input type="text" name="nombre" placeholder="Ingrese el nombre de la categoria" value="<?= $_SESSION['olds']['nombre'] ?? '' ?>">
                </fieldset>


                <!-- DESCRIPCIÓN -->
                <fieldset class="category-field-description">
                    <legend>Descripción *</legend>
                    <p class='message-error'>
                        <?= $_SESSION['errors']['descripcion'] ?? '' ?>
                    </p>

                    <textarea name="descripcion" rows="4" placeholder="Ingrese la descripcion de la categoría"><?=$_SESSION['olds']['descripcion'] ?? ''?></textarea>
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
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M713-600 600-713l56-57 57 57 141-142 57 57-198 198ZM200-120v-640q0-33 23.5-56.5T280-840h240v80H280v518l200-86 200 86v-278h80v400L480-240 200-120Zm80-640h240-240Z"/></svg>
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
