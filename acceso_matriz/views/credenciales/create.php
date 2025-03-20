<?php require_once __DIR__ . '/../../config.php' ?>
<?php require_once MATRIX_DOC_ROOT . 'database.php' ?>
<?php require_once MATRIX_DOC_FNS . 'helpers/encrypt.php' ?>

<?php $page_name = ACCESO . 'Añadir usuario' ?>

<?php $sucursales = simpleQuery('SELECT id_sucursal, nombre_sucursal FROM sucursales ORDER BY nombre_sucursal ASC') ?: []; ?>

<!DOCTYPE html>
<html lang="en">
<?php require_once MATRIX_DOC_VIEWS . "modules/head.php" ?>
<body>
    <?php require_once MATRIX_DOC_VIEWS . "/modules/header.php" ?>

    <?php require_once MATRIX_DOC_VIEWS . "/modules/sidebar.php" ?>

    <main class="main-content matriz-content">
        <!-- CREAR CREDENCIAL -->
        <div class="form-create-container">
            <div class="form-header">
                <h1>Añadir personal</h1>

                <!-- ACCESOS DIRECTOS -->
                <div class="shortcuts-links">
                    <a href="./index" title="Personal" class="shortcut-link-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M41 7C31.6-2.3 16.4-2.3 7 7S-2.3 31.6 7 41l72 72c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9L41 7zM599 7L527 79c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l72-72c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0zM7 505c9.4 9.4 24.6 9.4 33.9 0l72-72c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L7 471c-9.4 9.4-9.4 24.6 0 33.9zm592 0c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-72-72c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l72 72zM320 256a64 64 0 1 0 0-128 64 64 0 1 0 0 128zM212.1 336c-2.7 7.5-4.1 15.6-4.1 24c0 13.3 10.7 24 24 24l176 0c13.3 0 24-10.7 24-24c0-8.4-1.4-16.5-4.1-24c-.5-1.4-1-2.7-1.6-4c-9.4-22.3-29.8-38.9-54.3-43c-3.9-.7-7.9-1-12-1l-80 0c-4.1 0-8.1 .3-12 1c-.8 .1-1.7 .3-2.5 .5c-24.9 5.1-45.1 23-53.4 46.5zM175.8 224a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm-26.5 32C119.9 256 96 279.9 96 309.3c0 14.7 11.9 26.7 26.7 26.7l56.1 0c8-34.1 32.8-61.7 65.2-73.6c-7.5-4.1-16.2-6.4-25.3-6.4l-69.3 0zm368 80c14.7 0 26.7-11.9 26.7-26.7c0-29.5-23.9-53.3-53.3-53.3l-69.3 0c-9.2 0-17.8 2.3-25.3 6.4c32.4 11.9 57.2 39.5 65.2 73.6l56.1 0zM464 224a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"></path></svg>
                    </a>

                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-120q-75 0-140.5-28.5t-114-77q-48.5-48.5-77-114T120-480q0-75 28.5-140.5t77-114q48.5-48.5 114-77T480-840v80q-117 0-198.5 81.5T200-480q0 117 81.5 198.5T480-200v80Zm160-160-56-57 103-103H360v-80h327L584-624l56-56 200 200-200 200Z"/></svg>

                    <a title="Añadir usuario" class="shortcut-link-btn <?= strpos($_SERVER['PHP_SELF'], 'credenciales/create') ? 'active' : '' ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M440-120v-320H120v-80h320v-320h80v320h320v80H520v320h-80Z"/></svg>
                    </a>
                </div>
            </div>

            <form class="form-create" action="<?=MATRIX_FNS?>crud_credencial.php" method="POST" autocomplete="off">
                <!-- NOMBRES -->
                <fieldset>
                    <legend>
                        Nombres *
                        <p class='message-error'>
                            <?= $_SESSION['errors']['nombres'] ?? '' ?>
                        </p>
                    </legend>

                    <input type="text" name="nombres" placeholder="Ingrese los nombre del usuario" value="<?= $_SESSION['olds']['nombres'] ?? '' ?>">
                </fieldset>

                <!-- APELLIDOS -->
                <fieldset>
                    <legend>
                        Apellidos *
                        <p class='message-error'>
                            <?= $_SESSION['errors']['apellidos'] ?? '' ?>
                        </p>
                    </legend>

                    <input type="text" name="apellidos" placeholder="Ingrese los apellidos del usuario" value="<?= $_SESSION['olds']['apellidos'] ?? '' ?>">
                </fieldset>

                <!-- CURP -->
                <fieldset>
                    <legend>
                        CURP *
                        <p class='message-error'>
                            <?= $_SESSION['errors']['curp'] ?? '' ?>
                        </p>
                    </legend>

                    <input type="text" name="curp" placeholder="Ingrese el curp del usuario" value="<?= $_SESSION['olds']['curp'] ?? '' ?>">
                </fieldset>

                <!-- TELEFONO -->
                <fieldset>
                    <legend>
                        Teléfono *
                        <p class='message-error'>
                            <?= $_SESSION['errors']['telefono'] ?? '' ?>
                        </p>
                    </legend>

                    <input type="text" name="telefono" placeholder="Ingrese el telefono del usuario" value="<?= $_SESSION['olds']['telefono'] ?? '' ?>">
                </fieldset>

                <!-- CORREO -->
                <fieldset>
                    <legend>
                        Correo electrónico *
                        <p class='message-error'>
                            <?= $_SESSION['errors']['correo'] ?? '' ?>
                        </p>
                    </legend>

                    <input type="text" name="correo" placeholder="Ingrese el correo del usuario" value="<?= $_SESSION['olds']['correo'] ?? '' ?>">
                </fieldset>

                <!-- SUCURSAL -->
                <fieldset class="field-select">
                    <legend>
                        Sucursal *
                        <p class='message-error'>
                            <?= $_SESSION['errors']['id_sucursal'] ?? '' ?>
                        </p>
                    </legend>

                    <input type="hidden" name="id_sucursal" value="">
                    <select name="id_sucursal" id="sucursal">
                        <?php if (empty($sucursales)): ?>

                            <option disabled selected>No hay sucursales registradas</option>

                        <?php else: ?>
                            <?php $old_sucursal = $_SESSION['olds']['id_sucursal'] ?? ''; ?>

                            <option
                                disabled
                                <?= !$old_sucursal ?  'selected' : ''?>
                            >
                                Asigne al vendedor en una sucursal
                            </option>

                            <?php foreach ($sucursales as $sucursal): ?>
                                <option
                                    value="<?= encryptValue($sucursal['id_sucursal'], SECRETKEY) ?>"
                                    <?= ($old_sucursal && $old_sucursal === $sucursal['id_sucursal']) ?  'selected' : ''?>
                                >
                                    <?= ucwords($sucursal['nombre_sucursal']); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
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

    <?php require_once MATRIX_DOC_VIEWS . 'credenciales/show_credential_modal.php' ?>

    <?php
        if (isset($_SESSION['swal'])) {
            echo $_SESSION['swal'];
            unset($_SESSION['swal']);
        }

        unset($_SESSION['errors']);
        unset($_SESSION['olds']);
    ?>


    <script>
        // <--      ABRIR MODAL        -->
        $(document).ready(function () {
            const $newUserAuthInfo = $('.newUserAuthInfo');
            const $modalContainer = $('.modal-container');

            if ($newUserAuthInfo.length && $modalContainer.length) {
                $newUserAuthInfo.addClass('show').removeClass('hide');
                $modalContainer.addClass('show').removeClass('hide');
            }
        });


        // <--      CERRAR MODAL        -->
        $(document).on('click', '.close-modal', function() {
            let modal = $(this).closest('.modal-background');
            let modalContainer = modal.find('.modal-container');

            modal.addClass('hide').removeClass('show');
            modal.removeClass('newUserAuthInfo');
            modalContainer.addClass('hide').removeClass('show');

            setTimeout(() => {
                modal.removeClass('show');
                modalContainer.removeClass('show');
            }, 300);
        });


        // <--      DESCARGAR QR        -->
        $(document).on('click', '#download-qr-button', function() {
            const qrPath = $(this).data('qr-path');

            if (!qrPath) return;

            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                iconColor: 'white',
                timerProgressBar: true,
                customClass: {
                    popup: 'colored-toast',
                },
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });

            try {
                window.location.href = '<?=MATRIX_FNS?>descargar_archivo.php?file=' + qrPath;

                setTimeout(() => {
                    Toast.fire({
                        icon: 'success',
                        title: '¡Archivo descargado!'
                    })
                }, 2000);

            } catch (e) {
                console.log(e);

                Toast.fire({
                    icon: 'erorr',
                    title: '¡No se pudo atender la petición!'
                });
            }
        });
    </script>
</body>
</html>
