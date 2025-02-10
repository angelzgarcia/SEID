<?php require_once __DIR__ . '/../../config.php' ?>
<?php $page_name = ACCESO . 'Añadir sucursal' ?>

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
                Añadir sucursal
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-200h80v-320h480v320h80v-426L480-754 160-626v426Zm-80 80v-560l400-160 400 160v560H640v-320H320v320H80Zm280 0v-80h80v80h-80Zm80-120v-80h80v80h-80Zm80 120v-80h80v80h-80ZM240-520h480-480Z"/></svg>
            </h1>

            <form class="form-create sucursal-create" action="../../functions/crud_credential.php" method="POST" autocomplete="off">
                <!-- NOMBRE -->
                <fieldset>
                    <legend>Nombre *</legend>
                    <p class='message-error'>
                        <?= $_SESSION['errors']['nombre'] ?? '' ?>
                    </p>

                    <input type="text" name="nombre" placeholder="Ingrese el nombre de la sucursal" >
                </fieldset>

                <!-- DIRECCION -->
                <fieldset>
                    <legend>Dirección *</legend>
                    <p class='message-error'>
                        <?= $_SESSION['errors']['direccion'] ?? '' ?>
                    </p>

                    <input type="text" name="direccion" placeholder="Ingrese la dirección de la sucursal" >
                </fieldset>

                <!-- TELÉFONO -->
                <fieldset>
                    <legend>Teléfono *</legend>
                    <p class='message-error'>
                        <?= $_SESSION['errors']['telefono'] ?? '' ?>
                    </p>

                    <input type="text" name="telefono" placeholder="Ingrese el telefono de la sucursal" >
                </fieldset>

                <input type="hidden" name="accion" value="crear">

                <!-- ENVIAR FORMULARIO -->
                <button type="submit" class="form-btn">
                    guardar
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M840-680v480q0 33-23.5 56.5T760-120H200q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h480l160 160Zm-80 34L646-760H200v560h560v-446ZM480-240q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35ZM240-560h360v-160H240v160Zm-40-86v446-560 114Z"/></svg>
                </button>
            </form>
        </div>
    </main>
</body>
</html>
