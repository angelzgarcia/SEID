<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: /login.php");
    exit();
}

function verificarRol($rolesPermitidos) {
    if (!in_array($_SESSION['rol'], $rolesPermitidos)) {
        header("Location: /acceso_denegado.php"); // Página de error si no tiene permiso
        exit();
    }
}
