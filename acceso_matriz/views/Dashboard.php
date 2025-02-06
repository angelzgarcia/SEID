<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<body>

    dashboard matriz
    <hr>
    Nivel de usuario:
    <?= $_SESSION['nivel_usuario'] ?>

    <hr>
    ID del usuario:
    <?= $_SESSION['id_credencial'] ?>

    <hr>
    Nombre del usuario:
    <?= $_SESSION['nombres'] ?>

    <hr>
    Apellidos del usuario:
    <?= $_SESSION['apellidos'] ?>

</body>
</html>
