<?php require_once __DIR__ . '/../../../config.php' ?>
<?php require_once MATRIX_DOC_ROOT . 'database.php' ?>
<?php require_once MATRIX_DOC_ROOT . 'functions/helpers/encrypt.php' ?>
<?php $page_name = ACCESO . 'Editar categoria' ?>

<?php
    $id = htmlspecialchars(trim($_GET['c']));
    $id_categoria = decryptValue($id, SECRETKEY);

    $sql = 'SELECT * FROM categorias WHERE id_categoria = ?';

    $categoria = simpleQuery($sql, [$id_categoria], 'i', true);

    if (empty($categoria)) {
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    }
    $categoria = $categoria[0];
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once MATRIX_DOC_VIEWS . "modules/head.php" ?>
<body>
    <?php require_once MATRIX_DOC_VIEWS . "/modules/header.php" ?>

    <?php require_once MATRIX_DOC_VIEWS . "/modules/sidebar.php" ?>

    <main class="main-content matriz-content">
        <!-- CREAR PRODUCTO -->
        <div class="form-create-container form-category-create-container">
            <div class="form-header w-[86%] m-auto">
                <h1>Editar categoría</h1>

                <!-- ACCESOS DIRECTOS -->
                <div class="shortcuts-links">
                    <a href="../index" title="Inventario" class="shortcut-link-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M440-183v-274L200-596v274l240 139Zm80 0 240-139v-274L520-457v274Zm-80 92L160-252q-19-11-29.5-29T120-321v-318q0-22 10.5-40t29.5-29l280-161q19-11 40-11t40 11l280 161q19 11 29.5 29t10.5 40v318q0 22-10.5 40T800-252L520-91q-19 11-40 11t-40-11Zm200-528 77-44-237-137-78 45 238 136Zm-160 93 78-45-237-137-78 45 237 137Z"/></svg>
                    </a>

                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-120q-75 0-140.5-28.5t-114-77q-48.5-48.5-77-114T120-480q0-75 28.5-140.5t77-114q48.5-48.5 114-77T480-840v80q-117 0-198.5 81.5T200-480q0 117 81.5 198.5T480-200v80Zm160-160-56-57 103-103H360v-80h327L584-624l56-56 200 200-200 200Z"/></svg>

                    <a href="index.php" title="Categorías" class="shortcut-link-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m260-520 220-360 220 360H260ZM700-80q-75 0-127.5-52.5T520-260q0-75 52.5-127.5T700-440q75 0 127.5 52.5T880-260q0 75-52.5 127.5T700-80Zm-580-20v-320h320v320H120Zm580-60q42 0 71-29t29-71q0-42-29-71t-71-29q-42 0-71 29t-29 71q0 42 29 71t71 29Zm-500-20h160v-160H200v160Zm202-420h156l-78-126-78 126Zm78 0ZM360-340Zm340 80Z"/></svg>
                    </a>

                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-120q-75 0-140.5-28.5t-114-77q-48.5-48.5-77-114T120-480q0-75 28.5-140.5t77-114q48.5-48.5 114-77T480-840v80q-117 0-198.5 81.5T200-480q0 117 81.5 198.5T480-200v80Zm160-160-56-57 103-103H360v-80h327L584-624l56-56 200 200-200 200Z"/></svg>

                    <a title="Editar categoría" class="shortcut-link-btn <?= strpos($_SERVER['PHP_SELF'], 'categorias/edit') ? 'active' : '' ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-120v-170l527-526q12-12 27-18t30-6q16 0 30.5 6t25.5 18l56 56q12 11 18 25.5t6 30.5q0 15-6 30t-18 27L330-120H160Zm80-80h56l393-392-28-29-29-28-392 393v56Zm560-503-57-57 57 57Zm-139 82-29-28 57 57-28-29ZM560-120q74 0 137-37t63-103q0-36-19-62t-51-45l-59 59q23 10 36 22t13 26q0 23-36.5 41.5T560-200q-17 0-28.5 11.5T520-160q0 17 11.5 28.5T560-120ZM183-426l60-60q-20-8-31.5-16.5T200-520q0-12 18-24t76-37q88-38 117-69t29-70q0-55-44-87.5T280-840q-45 0-80.5 16T145-785q-11 13-9 29t15 26q13 11 29 9t27-13q14-14 31-20t42-6q41 0 60.5 12t19.5 28q0 14-17.5 25.5T262-654q-80 35-111 63.5T120-520q0 32 17 54.5t46 39.5Z"/></svg>
                    </a>
                </div>
            </div>

            <form class="form-create category-add" action="<?= MATRIX_FNS ?>crud_categoria.php?c=<?= $id ?>" method="POST" autocomplete="off" enctype="multipart/form-data">
                <!-- NOMBRE -->
                <fieldset class="category-field-name">
                    <legend>
                        Nombre *
                        <p class='message-error'>
                            <?= $_SESSION['errors']['nombre'] ?? '' ?>
                        </p>
                    </legend>

                    <input type="text" name="nombre" placeholder="Ingrese el nombre de la categoria" value="<?= ucfirst($categoria['nombre_categoria']) ?: ($_SESSION['olds']['nombre'] ?? ''); ?>">
                </fieldset>


                <!-- DESCRIPCIÓN -->
                <fieldset class="category-field-description">
                    <legend>
                        Descripción *
                        <p class='message-error'>
                            <?= $_SESSION['errors']['descripcion'] ?? '' ?>
                        </p>
                    </legend>

                    <textarea name="descripcion" rows="4" placeholder="Ingrese la descripcion de la categoría"><?= ucfirst($categoria['descripcion_categoria']) ?: ($_SESSION['olds']['descripcion'] ?? ''); ?></textarea>
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

                    <span class="font-medium text-gray-500"><small>Imgen actual</small></span>
                    <div class="current-image-container">
                        <img src="<?= $categoria['imagen_categoria'] ?>" alt="Imagen actual">
                    </div>
                </fieldset>

                <input type="hidden" name="accion" value="actualizar">

                <!-- ENVIAR FORMULARIO -->
                <button type="submit" class="form-btn">
                    Actualizar
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M382-320 155-547l57-57 170 170 366-366 57 57-423 423ZM200-160v-80h560v80H200Z"/></svg>
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
