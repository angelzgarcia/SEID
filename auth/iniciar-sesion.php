<?php
// INICIO DE SESION CON CORREO Y CONTRASEÑA
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'database.php';

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $pass = $_POST['pass'] ?? '';

    global $conn;

    $sqlUsuario = "
        SELECT *
        FROM credenciales
        WHERE correo_inicio = ?
    ";
    $stmtUsuario = $conn -> prepare($sqlUsuario);
    $stmtUsuario -> bind_param("s", $email);
    $stmtUsuario -> execute();
    $resultUsuario = $stmtUsuario -> get_result();

    if ($resultUsuario -> num_rows === 1) {
        $row = $resultUsuario -> fetch_assoc();
        $hash_pass = $row['pass_inicio'];
        $nivelUsuario = $row['nivel_usuario'];

        if ($pass === $hash_pass) {
            $_SESSION['id_usuario'] = $row['id_credencial'];
            $_SESSION['correo_usuario'] = $row['correo_inicio'];

            switch ($nivelUsuario) {
                case 1:
                    header('Location: ../acceso_director/views/Dashboard.php');
                    exit();
                case 2:
                    header('Location: ../acceso_matriz/views/Dashboard.php');
                    exit();
                case 3:
                    header('Location: ../acceso_vendedor/views/Dashboard.php');
                    exit();
                default:
                    $errorMensaje = "Nivel de usuario no válido.";
                    header('Location: ../login.php?error=' . urlencode($errorMensaje));
                    exit();
            }
        } else {
            $errorMensaje = "La contraseña es incorrecta. Por favor, intenta nuevamente.";
            echo $errorMensaje;
        }
    } else {
        $errorMensaje = "Usuario no encontrado.";
        echo $errorMensaje;
    }
} else {
    $errorMensaje = "Acceso no autorizado.";
    header('Location: ../login.php?error=' . urlencode($errorMensaje));
    exit();
}
