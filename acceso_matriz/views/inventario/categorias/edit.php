<?php require_once __DIR__ . '/../../../config.php' ?>
<?php require_once MATRIX_DOC_ROOT . 'database.php' ?>
<?php require_once MATRIX_DOC_ROOT . 'functions/helpers/encrypt.php' ?>
<?php $page_name = ACCESO . 'Editar categoria' ?>

<?php
    $id_categoria = decryptValue($_GET['c'], SECRETKEY);

    $sql = '
        SELECT * FROM categorias
        WHERE id_categoria = ?
    ';
    $query = $conn -> prepare($sql);
    $query -> bind_param('i', $id_categoria);

    if (!$query -> execute()) {
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    }
    
    $categoria = $query -> get_result() -> fetch_assoc();
    if (!$categoria) {
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    }
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
                    <a href="../index" title="Inventario">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M440-183v-274L200-596v274l240 139Zm80 0 240-139v-274L520-457v274Zm-80 92L160-252q-19-11-29.5-29T120-321v-318q0-22 10.5-40t29.5-29l280-161q19-11 40-11t40 11l280 161q19 11 29.5 29t10.5 40v318q0 22-10.5 40T800-252L520-91q-19 11-40 11t-40-11Zm200-528 77-44-237-137-78 45 238 136Zm-160 93 78-45-237-137-78 45 237 137Z"/></svg>
                    </a>
                    
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m321-80-71-71 329-329-329-329 71-71 400 400L321-80Z"/></svg>
                    </span>
    
                    <a href="index.php" title="Categorías">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m260-520 220-360 220 360H260ZM700-80q-75 0-127.5-52.5T520-260q0-75 52.5-127.5T700-440q75 0 127.5 52.5T880-260q0 75-52.5 127.5T700-80Zm-580-20v-320h320v320H120Zm580-60q42 0 71-29t29-71q0-42-29-71t-71-29q-42 0-71 29t-29 71q0 42 29 71t71 29Zm-500-20h160v-160H200v160Zm202-420h156l-78-126-78 126Zm78 0ZM360-340Zm340 80Z"/></svg>
                    </a>
                </div>
            </div>

            <form class="form-create category-add" action="<?= MATRIX_FNS ?>crud_categoria.php?c=<?= encryptValue($categoria['id_categoria'], SECRETKEY) ?>" method="POST" autocomplete="off">
                <!-- NOMBRE -->
                <fieldset class="category-field-name">
                    <legend>Nombre *</legend>
                    <p class='message-error'>
                        <?= $_SESSION['errors']['nombre'] ?? '' ?>
                    </p>

                    <input type="text" name="nombre" placeholder="Ingrese el nombre de la categoria" value="<?= ucfirst($categoria['nombre_categoria']) ?: ($_SESSION['olds']['nombre'] ?? ''); ?>">
                </fieldset>


                <!-- DESCRIPCIÓN -->
                <fieldset class="category-field-description">
                    <legend>Descripción *</legend>
                    <p class='message-error'>
                        <?= $_SESSION['errors']['descripcion'] ?? '' ?>
                    </p>

                    <textarea name="descripcion" rows="4" placeholder="Ingrese la descripcion de la categoría"><?= $categoria['descripcion_categoria'] ?: ($_SESSION['olds']['descripcion'] ?? ''); ?></textarea>
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
</body>
</html>
