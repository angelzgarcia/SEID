<?php
    require_once __DIR__ . '/../../../config.php';
    require_once DOC_ROOT . 'acceso_director/functions/database.php';
    session_start();

    $sql = 'SELECT * FROM sucursales';
    $query = $conn -> query($sql);
    $sucursales = [];
    if ($query) $sucursales = $query -> fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once '../modules/head.php' ?>
<body>
    <?php require_once '../modules/header.php' ?>

    <?php require_once '../modules/sidebar.php' ?>

    <main class="main-content director-main">

        <!-- CREAR CREDENCIAL -->
        <div class="form-create-container">
            <h1>
                Añadir vendedor
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m160-419 101-101-101-101L59-520l101 101Zm540-21 100-160 100 160H700Zm-220-40q-50 0-85-35t-35-85q0-51 35-85.5t85-34.5q51 0 85.5 34.5T600-600q0 50-34.5 85T480-480Zm0-160q-17 0-28.5 11.5T440-600q0 17 11.5 28.5T480-560q17 0 28.5-11.5T520-600q0-17-11.5-28.5T480-640Zm0 40ZM0-240v-63q0-44 44.5-70.5T160-400q13 0 25 .5t23 2.5q-14 20-21 43t-7 49v65H0Zm240 0v-65q0-65 66.5-105T480-450q108 0 174 40t66 105v65H240Zm560-160q72 0 116 26.5t44 70.5v63H780v-65q0-26-6.5-49T754-397q11-2 22.5-2.5t23.5-.5Zm-320 30q-57 0-102 15t-53 35h311q-9-20-53.5-35T480-370Zm0 50Z"/></svg>
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


    <!-- ALERTS -->
    <?php
        if (!empty($_SESSION['swal'])) echo $_SESSION['swal'];

        unset($_SESSION['errors']);
        unset($_SESSION['swal']);
        session_destroy();
    ?>
</body>
</html>
