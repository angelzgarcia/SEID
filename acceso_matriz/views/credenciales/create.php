<?php require_once __DIR__ . '/../../config.php' ?>
<?php $page_name = ACCESO . 'Añadir sucursal' ?>

<!DOCTYPE html>
<html lang="en">
<?php require_once MATRIX_DOC_VIEWS . "modules/head.php" ?>
<body>

    <?php require_once MATRIX_DOC_VIEWS . "/modules/header.php" ?>

    <?php require_once MATRIX_DOC_VIEWS . "/modules/sidebar.php" ?>

    <main class="main-content matriz-content">
        <!-- CREAR CREDENCIAL -->
        <div class="form-create-container">
            <h1 class="!normal-case">
                Añadir Director de Sucursal
                <!-- <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-480q81 0 169-16.5T800-540v400q-60 27-146 43.5T480-80q-88 0-174-16.5T160-140v-400q63 27 151 43.5T480-480Zm240 280v-230q-50 14-115.5 22T480-400q-59 0-124.5-8T240-430v230q50 18 115 29t125 11q60 0 125-11t115-29ZM480-880q66 0 113 47t47 113q0 66-47 113t-113 47q-66 0-113-47t-47-113q0-66 47-113t113-47Zm0 240q33 0 56.5-23.5T560-720q0-33-23.5-56.5T480-800q-33 0-56.5 23.5T400-720q0 33 23.5 56.5T480-640Zm0-80Zm0 425Z"/></svg> -->
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h168q14-36 44-58t68-22q38 0 68 22t44 58h168q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm280-670q13 0 21.5-8.5T510-820q0-13-8.5-21.5T480-850q-13 0-21.5 8.5T450-820q0 13 8.5 21.5T480-790ZM200-246q54-53 125.5-83.5T480-360q83 0 154.5 30.5T760-246v-514H200v514Zm280-194q58 0 99-41t41-99q0-58-41-99t-99-41q-58 0-99 41t-41 99q0 58 41 99t99 41ZM280-200h400v-10q-42-35-93-52.5T480-280q-56 0-107 17.5T280-210v10Zm200-320q-25 0-42.5-17.5T420-580q0-25 17.5-42.5T480-640q25 0 42.5 17.5T540-580q0 25-17.5 42.5T480-520Zm0 17Z"/></svg>
            </h1>

            <form class="form-create" action="../../functions/crud_credential.php" method="POST" autocomplete="off">
                <!-- NOMBRES -->
                <fieldset>
                    <legend>Nombres *</legend>
                    <p class='message-error'>
                        <?= $_SESSION['errors']['nombres'] ?? '' ?>
                    </p>
                    <input type="text" name="nombres" placeholder="Ingrese los nombre del usuario" >
                </fieldset>

                <!-- APELLIDOS -->
                <fieldset>
                    <legend>Apellidos *</legend>
                    <p class='message-error'>
                        <?= $_SESSION['errors']['apellidos'] ?? '' ?>
                    </p>
                    <input type="text" name="apellidos" placeholder="Ingrese los apellidos del usuario" >
                </fieldset>

                <!-- CURP -->
                <fieldset>
                    <legend>CURP *</legend>
                    <p class='message-error'>
                        <?= $_SESSION['errors']['curp'] ?? '' ?>
                    </p>
                    <input type="text" name="curp" placeholder="Ingrese el curp del usuario" >
                </fieldset>

                <!-- TELEFONO -->
                <fieldset>
                    <legend>Teléfono *</legend>
                    <p class='message-error'>
                        <?= $_SESSION['errors']['telefono'] ?? '' ?>
                    </p>
                    <input type="text" name="telefono" placeholder="Ingrese el telefono del usuario" >
                </fieldset>

                <!-- CORREO -->
                <fieldset>
                    <legend>Correo electrónico *</legend>
                    <p class='message-error'>
                        <?= $_SESSION['errors']['correo'] ?? '' ?>
                    </p>
                    <input type="text" name="correo" placeholder="Ingrese el correo del usuario" >
                </fieldset>

                <!-- SUCURSAL -->
                <fieldset class="field-select">
                    <legend>Sucursal *</legend>
                    <p class='message-error'>
                        <?= $_SESSION['errors']['id_sucursal'] ?? '' ?>
                    </p>
                    <select name="id_sucursal" id="sucursal">
                        <option disabled selected>Asigne al vendedor a una sucursal</option>
                        <?php
                            foreach ($sucursales as $sucursal) {
                                ?>
                                    <option value="<?= $sucursal['id_sucursal'] ?>">
                                        <?= $sucursal['nombre_sucursal']; ?>
                                    </option>
                                <?php
                            }
                        ?>
                    </select>
                </fieldset>

                <!-- NIVEL DE USUARIO -->
                <!-- <fieldset class="field-select">
                    <legend>Nivel del usuario *</legend>
                    <p class='message-error'>
                        <?= $_SESSION['errors']['usuario_nivel'] ?? '' ?>
                    </p>
                    <select name="usuario_nivel" id="usuario_nivel">
                        <option disabled selected>Asigne el nivel de permisos del usuario</option>
                        <option value="<?= '1' ?>">Matriz</option>
                        <option value="<?= '2' ?>">Director</option>
                        <option value="<?= '3' ?>">Vendedor</option>
                    </select>
                </fieldset> -->

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
