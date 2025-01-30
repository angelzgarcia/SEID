<?php
    require_once __DIR__ . '/../functions/database.php';
    session_start();

    $sql = 'SELECT * FROM sucursales';
    $query = $conn -> query($sql);
    $sucursales = [];
    if ($query) $sucursales = $query -> fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once __DIR__ . '/modules/head.php' ?>
<body>
    <?php require_once __DIR__ . '/modules/header.php' ?>

    <!-- CREAR CREDENCIAL -->
    <div class="form-create-container">
        <h1>Crear credencial</h1>
        <form id="" action="../functions/create_credential.php" method="POST" autocomplete="off">
            <!-- NOMBRES -->
            <div class='message-error'>
                <?= isset($_SESSION['errors']) ? $_SESSION['errors']['nombres'] : '' ?>
            </div>
            <label for="nombres">Nombres</label>
            <input type="text" name="nombres" placeholder="Ingrese los nombre del usuario" >

            <!-- APELLIDOS -->
            <div class='message-error'>
                <?= isset($_SESSION['errors']) ? $_SESSION['errors']['apellidos'] : '' ?>
            </div>
            <label for="apellidos">Apellidos</label>
            <input type="text" name="apellidos" placeholder="Ingrese los apellidos del usuario" >

            <!-- CURP -->
            <div class='message-error'>
                <?= isset($_SESSION['errors']) ? $_SESSION['errors']['curp'] : '' ?>
            </div>
            <label for="curp">CURP</label>
            <input type="text" name="curp" placeholder="Ingrese el curp del usuario" >

            <!-- TELEFONO -->
            <div class='message-error'>
                <?= isset($_SESSION['errors']) ? $_SESSION['errors']['telefono'] : '' ?>
            </div>
            <label for="telefono">Telefoto</label>
            <input type="text" name="telefono" placeholder="Ingrese el telefono del usuario" >

            <!-- CORREO -->
            <div class='message-error'>
                <?= isset($_SESSION['errors']) ? $_SESSION['errors']['correo'] : '' ?>
            </div>
            <label for="correo">Correo</label>
            <input type="text" name="correo" placeholder="Ingrese el correo del usuario" >

            <!-- SUCURSAL -->
            <div class='message-error'>
                <?= isset($_SESSION['errors']) ? $_SESSION['errors']['id_sucursal'] : '' ?>
            </div>
            <label for="sucursal">Sucursal</label>
            <select name="id_sucursal" id="sucursal">
                <option disabled selected>Seleccione la sucursal asignada a este usuario</option>
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

            <!-- NIVEL DE USUARIO -->
            <div class='message-error'>
                <?= isset($_SESSION['errors']) ? $_SESSION['errors']['usuario_nivel'] : '' ?>
            </div>
            <label for="nivel_usuario">Nivel de usuario</label>
            <select name="usuario_nivel" id="usuario_nivel">
                <option disabled selected>Asigne el nivel de permisos del usuario</option>
                <option value="<?= 1 ?>">Director</option>
                <option value="<?= 2 ?>">Matriz</option>
                <option value="<?= 3 ?>">Vendedor</option>
            </select>

            <!-- ENVIAR -->
            <input type="submit" value="Registrar">
            <input type="hidden" name="accion" value="crear">
        </form>
    </div>

    <?php require_once __DIR__ . '/modules/footer.php' ?>

    <!-- ALERTS -->
    <?php
        if (!empty($_SESSION['swal'])) echo $_SESSION['swal'];

        unset($_SESSION['errors']);
        unset($_SESSION['swal']);
        session_destroy();
    ?>
</body>
</html>
