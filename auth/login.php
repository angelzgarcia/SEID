<?php // INICIO DE SESION CON CORREO Y CONTRASEÑA
require_once 'database.php';
function decryptValue($encryptedValue, $secretKey) {
    [$ciphertext, $iv] = explode('::', base64_decode($encryptedValue), 2);
    $iv = base64_decode($iv);
    return openssl_decrypt($ciphertext, 'aes-256-cbc', $secretKey, 0, $iv);
}

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $pass = $_POST['pass'] ?? '';

    global $conn;
    $secretKey = 'your-secret-key';

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
        $nivelUsuario = (int)decryptValue($row['nivel_usuario'], $secretKey);

        if ($pass === $hash_pass) {
            $_SESSION['id_usuario'] = $row['id_credencial'];
            $_SESSION['correo_usuario'] = $row['correo_inicio'];

            switch ($nivelUsuario) {
                case 1:
                    header('Location: ../acceso_matriz/views/dashboard.php');
                    exit();
                case 2:
                    header('Location: ../acceso_director/views/dashboard.php');
                    exit();
                case 3:
                    header('Location: ../acceso_vendedor/views/dashboard.php');
                    exit();
                default:
                    $errorMensaje = "Nivel de usuario no válido.";
                    header('Location: ./views/login.php?error=' . urlencode($errorMensaje));
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

