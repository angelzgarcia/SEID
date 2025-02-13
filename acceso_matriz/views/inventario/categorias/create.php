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
        <div class="form-create-container">
            <h1>
                Añadir categoria
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m260-520 220-360 220 360H260ZM700-80q-75 0-127.5-52.5T520-260q0-75 52.5-127.5T700-440q75 0 127.5 52.5T880-260q0 75-52.5 127.5T700-80Zm-580-20v-320h320v320H120Zm580-60q42 0 71-29t29-71q0-42-29-71t-71-29q-42 0-71 29t-29 71q0 42 29 71t71 29Zm-500-20h160v-160H200v160Zm202-420h156l-78-126-78 126Zm78 0ZM360-340Zm340 80Z"/></svg>
            </h1>

            <form class="form-create category-add" action="<?= MATRIX_FNS ?>crud_categoria.php" method="POST" autocomplete="off">
                <!-- NOMBRE -->
                <fieldset>
                    <legend>Nombre *</legend>
                    <p class='message-error'>
                        <?= $_SESSION['errors']['nombre'] ?? '' ?>
                    </p>

                    <input type="text" name="nombre" placeholder="Ingrese el nombre de la categoria" value="<?= $_SESSION['olds']['nombre'] ?? '' ?>">
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
</body>
</html>
