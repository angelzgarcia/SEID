<?php
require_once '../database.php';

global $conn;
session_start();
$secretKey = 'your-secret-key';

function decryptValue($encryptedId, $secretKey) {
    [$ciphertext, $iv] = explode('::', base64_decode($encryptedId), 2);
    $iv = base64_decode($iv);
    return openssl_decrypt($ciphertext, 'aes-256-cbc', $secretKey, 0, $iv);
}

date_default_timezone_set('America/Mexico_City');

$qr_code = isset($_POST['qr_code']) ? trim($_POST['qr_code']) : '';
$token = isset($_POST['token']) ? trim($_POST['token']) : '';

if (empty($qr_code) || empty($token)) {
    die("Código QR o token no proporcionado.");
}

$credential_id = (int)decryptValue($qr_code, $secretKey);

if (!$credential_id || intval($credential_id) <= 0) {
    die("ID no válido.");
}

$stmt = $conn -> prepare("SELECT nivel_usuario FROM credenciales WHERE id_credencial = ?");
$stmt -> bind_param("i", $credential_id);
$stmt -> execute();
$result = $stmt -> get_result();

if ($result -> num_rows === 0) {
    die("Registro no encontrado.");
}

$row = $result -> fetch_assoc();
$nivel_usuario = (int)decryptValue($row['nivel_usuario'], $secretKey);

$_SESSION['credential_id'] = $credential_id;
$_SESSION['id_credencial'] = $credential_id;
$_SESSION['nivel_usuario'] = $nivel_usuario;

$stmt = $conn -> prepare("SELECT nombres_credencial, apellidos_credencial, token_verificacion FROM credenciales WHERE id_credencial = ?");
$stmt -> bind_param("i", $credential_id);
$stmt -> execute();
$result = $stmt -> get_result();

if ($result->num_rows === 0) {
    die("Registro no encontrado.");
}

$row = $result -> fetch_assoc();
$user_name = $row['nombre_credencial'];
$encryptedToken = $row['token_verificacion'];
$last_name = $row['apellidos_credencial'];

$decryptedToken = decryptValue($encryptedToken, $secretKey);
// $descryptlastname = decryptValue($last_name, $secretKey);

if ($decryptedToken !== $token) {
    header('Location: ../views/login-qr.php');
    exit();
}

switch ($nivel_usuario) {
    case 1:
        header('Location: ../../acceso_matriz/views/Dashboard.php');
        $conn -> close();
        exit();
    case 2:
        $conn -> close();
        header('Location: ../../acceso_director/views/Dashboard.php');
        exit();
    case 3:
        $conn -> close();
        header('Location: ../../acceso_vendedor/views/Dashboard.php');
        exit();
    default:
        $conn -> close();
        $errorMensaje = "Nivel de usuario no válido.";
        header('Location: ../login.php?error=' . urlencode($errorMensaje));
        exit();
}





// SEGUNDA ASIGNACION


// Obtener la hora actual y restar una hora
// $now = new DateTime();
// $now->sub(new DateInterval('PT1H')); // Restar 1 hora
// $now_formatted = $now->format('Y-m-d H:i:s');
// $now_hour = $now->format('H:i:s'); // Solo la hora y minutos

// // Consultar el estado del registro y verificar el token
// $stmt = $conn->prepare("SELECT nombre_credencial, caducidad_credencial, estatus_credencial, token_verificacion FROM credenciales WHERE id_credencial = ?");
// $stmt->bind_param("i", $credential_id);
// $stmt->execute();
// $result = $stmt->get_result();

// if ($result->num_rows === 0) {
//     die("Registro no encontrado.");
// }

// $row = $result->fetch_assoc();
// $name = $row['nombre_credencial'];
// $validity = $row['caducidad_credencial'];
// $status = $row['estatus_credencial'];
// $encryptedToken = $row['token_verificacion'];

// // Desencriptar el token almacenado
// $decryptedToken = decryptValue($encryptedToken, $secretKey);

// // Verificar si el token ingresado coincide con el token almacenado
// if ($decryptedToken !== $token) {
//     die("Token incorrecto.");
// }

// // Verificar si la validez y el estado permiten registrar
// if ($status !== 1 || $validity < date('d-m-Y')) {
//     die("El registro no está activo o la fecha ha pasado.");
// }

// // Consultar si ya existe un registro de entrada para hoy
// $stmt = $conn->prepare("SELECT id, hora_entrada, hora_salida FROM registros WHERE credential_id = ? AND fecha = CURDATE()");
// $stmt->bind_param("i", $credential_id);
// $stmt->execute();
// $result = $stmt->get_result();

// if ($result->num_rows === 0) {
//     // No hay registro para hoy, se debe crear uno
//     $stmt = $conn->prepare("INSERT INTO registros (credential_id, fecha, hora_entrada) VALUES (?, CURDATE(), ?)");
//     $stmt->bind_param("is", $credential_id, $now_formatted);
//     $stmt->execute();

//     // Mostrar mensaje de éxito para la entrada
//     echo '<div style="
//         padding: 20px;
//         background-color: #d4edda;
//         color: #155724;
//         border: 2px solid #c3e6cb;
//         border-radius: 10px;
//         font-size: 24px;
//         font-weight: bold;
//         text-align: center;
//         margin: 40px 0;
//         box-shadow: 0 4px 8px rgba(0,0,0,0.2);
//         width: 80%;
//         max-width: 600px;
//         margin-left: auto;
//         margin-right: auto;
//         position: relative;
//         top: 20%;
//         background-image: linear-gradient(to right, #d4edda, #c3e6cb);">
//     <strong>¡Entrada registrada correctamente!</strong>
//     </div>';

//     // Enviar notificación a Telegram
//     sendTelegramNotification($name, $now_hour, 'entrada');

//     echo '<script>
//         setTimeout(function() {
//             window.location.href = "entrada-salida.html";
//         }, 5000);
//     </script>';

//     exit();

// } else {
//     // Ya hay un registro para hoy
//     $row = $result->fetch_assoc();

//     if (empty($row['hora_salida'])) {
//         // Verificar el intervalo entre la entrada y la hora actual
//         $last_entrada_time = new DateTime($row['hora_entrada']);
//         $current_time = new DateTime($now_formatted);
//         $interval = $last_entrada_time->diff($current_time);

//         if ($interval->i >= 3) {
//             // Registrar la salida si han pasado más de 3 minutos
//             $stmt = $conn->prepare("UPDATE registros SET hora_salida = ? WHERE credential_id = ? AND fecha = CURDATE()");
//             $stmt->bind_param("si", $now_formatted, $credential_id);
//             $stmt->execute();

//             // Mostrar mensaje de éxito para la salida
//             echo '<div style="
//                 padding: 20px;
//                 background-color: #d4edda;
//                 color: #155724;
//                 border: 2px solid #c3e6cb;
//                 border-radius: 10px;
//                 font-size: 24px;
//                 font-weight: bold;
//                 text-align: center;
//                 margin: 40px 0;
//                 box-shadow: 0 4px 8px rgba(0,0,0,0.2);
//                 width: 80%;
//                 max-width: 600px;
//                 margin-left: auto;
//                 margin-right: auto;
//                 position: relative;
//                 top: 20%;
//                 background-image: linear-gradient(to right, #d4edda, #c3e6cb);
//             ">
//             <strong>¡Salida registrada correctamente!</strong>
//             </div>';

//             // Enviar notificación a Telegram
//             sendTelegramNotification($name, $now_hour, 'salida');

//             echo '<script>
//                     setTimeout(function() {
//                         window.location.href = "entrada-salida.html";
//                     }, 5000);
//                   </script>';
//             exit();
//         } else {
//             // Mostrar mensaje de espera para registrar salida
//             echo '<div style="
//                 padding: 20px;
//                 background-color: #fff3cd;
//                 color: #856404;
//                 border: 2px solid #ffeeba;
//                 border-radius: 10px;
//                 font-size: 24px;
//                 font-weight: bold;
//                 text-align: center;
//                 margin: 40px 0;
//                 box-shadow: 0 4px 8px rgba(0,0,0,0.2);
//                 width: 80%;
//                 max-width: 600px;
//                 margin-left: auto;
//                 margin-right: auto;
//                 position: relative;
//                 top: 20%;
//                 background-image: linear-gradient(to right, #fff3cd, #ffeeba);
//             ">
//             <strong>Esperando a registrar la salida. Por favor, espere un poco más.</strong>
//             </div>';
//             echo '<script>
//                     setTimeout(function() {
//                         window.location.href = "entrada-salida.html";
//                     }, 5000);
//                   </script>';
//             exit();
//         }
//     } else {
//         // Mostrar mensaje de que la salida ya fue registrada
//         echo '<div style="
//             padding: 20px;
//             background-color: #f8d7da;
//             color: #721c24;
//             border: 2px solid #f5c6cb;
//             border-radius: 10px;
//             font-size: 24px;
//             font-weight: bold;
//             text-align: center;
//             margin: 40px 0;
//             box-shadow: 0 4px 8px rgba(0,0,0,0.2);
//             width: 80%;
//             max-width: 600px;
//             margin-left: auto;
//             margin-right: auto;
//             position: relative;
//             top: 20%;
//             background-image: linear-gradient(to right, #f8d7da, #f5c6cb);
//         ">
//         <strong>La salida ya ha sido registrada para hoy.</strong>
//         </div>';
//         echo '<script>
//                 setTimeout(function() {
//                     window.location.href = "entrada-salida.html";
//                 }, 5000);
//               </script>';
//         exit();
//     }
// }

// // Función para enviar notificaciones a Telegram
// function sendTelegramNotification($name, $time, $type) {
//     $botToken = 'your-telegram-bot-token';
//     $chatId = 'your-chat-id';
//     $message = ($type == 'entrada') ? "Entrada registrada para $name a las $time" : "Salida registrada para $name a las $time";
//     $url = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($message);
//     file_get_contents($url);
// }

// // Cerrar la conexión
// $conn->close();
?>
