<?php

use chillerlan\QRCode\QRCode;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Configuración de la base de datos
$servername = "localhost";
$username = "u880452948_Conejo";
$password = "Jjn8econ[9";
$dbname = "u880452948_S_Escolar";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Configurar la zona horaria en PHP
date_default_timezone_set('America/Mexico_City');

// Opcional: Configurar el conjunto de caracteres a utf8mb4 para manejar caracteres especiales
$conn->set_charset("utf8mb4");

require_once 'phpqrcode/qrlib.php'; // Asegúrate de tener la biblioteca PHP QR Code en el directorio adecuado

// Definir el límite máximo de estudiantes
$max_estudiantes = 1000;

// Verificar el número total de estudiantes registrados para la escuela
$id_escuela = isset($_POST['id_escuela']) ? intval($_POST['id_escuela']) : 0;
$query_estudiantes = "SELECT COUNT(*) as total_estudiantes FROM credenciales WHERE nivel_usuario = 7 AND id_escuela = $id_escuela";
$result_estudiantes = $conn->query($query_estudiantes);
$total_estudiantes = 0; // Inicializar la variable

if ($result_estudiantes && $row_estudiantes = $result_estudiantes->fetch_assoc()) {
    $total_estudiantes = $row_estudiantes['total_estudiantes'];
}

// Verificar si se ha alcanzado el límite de 1000 estudiantes
if ($total_estudiantes >= $max_estudiantes) {
    echo "No se pueden agregar más estudiantes. Se ha alcanzado el límite de $max_estudiantes estudiantes.";
    exit;
}

// Función para encriptar un valor
function encryptValue($value, $secretKey) {
    $iv = random_bytes(16); // Vector de inicialización aleatorio
    $ciphertext = openssl_encrypt($value, 'aes-256-cbc', $secretKey, 0, $iv);
    return base64_encode($ciphertext . '::' . base64_encode($iv));
}

// Función para desencriptar un valor
function decryptValue($encryptedValue, $secretKey) {
    list($ciphertext, $iv) = explode('::', base64_decode($encryptedValue), 2);
    $iv = base64_decode($iv);
    return openssl_decrypt($ciphertext, 'aes-256-cbc', $secretKey, 0, $iv);
}

// Definir una clave secreta para la encriptación
$secretKey = 'your-secret-key'; // Usa una clave secreta segura

// Procesar datos cuando se recibe una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar y sanitizar los datos del formulario
    $nombre_credencial = isset($_POST['nombre_credencial']) ? htmlspecialchars(trim($_POST['nombre_credencial']), ENT_QUOTES, 'UTF-8') : '';
    $apellidos_credencial = isset($_POST['apellidos_credencial']) ? htmlspecialchars(trim($_POST['apellidos_credencial']), ENT_QUOTES, 'UTF-8') : '';
    $curp_credencial = isset($_POST['curp_credencial']) ? htmlspecialchars(trim($_POST['curp_credencial']), ENT_QUOTES, 'UTF-8') : '';
    $matricula_credencial = isset($_POST['matricula_credencial']) ? htmlspecialchars(trim($_POST['matricula_credencial']), ENT_QUOTES, 'UTF-8') : '';
    $grado_credencial = isset($_POST['grado_credencial']) ? htmlspecialchars(trim($_POST['grado_credencial']), ENT_QUOTES, 'UTF-8') : '';
    $genero = isset($_POST['genero']) ? htmlspecialchars(trim($_POST['genero']), ENT_QUOTES, 'UTF-8') : '';
    $grupo_credencial = isset($_POST['grupo_credencial']) ? htmlspecialchars(trim($_POST['grupo_credencial']), ENT_QUOTES, 'UTF-8') : '';
    $turno_credencial = isset($_POST['turno_credencial']) ? htmlspecialchars(trim($_POST['turno_credencial']), ENT_QUOTES, 'UTF-8') : '';
    $id_escuela = isset($_POST['id_escuela']) ? intval($_POST['id_escuela']) : 0; // Cambia a int
    $validity = isset($_POST['validity_hidden']) ? htmlspecialchars(trim($_POST['validity_hidden']), ENT_QUOTES, 'UTF-8') : '';
    $caducidad_credencial = isset($_POST['caducidad_credencial']) ? htmlspecialchars(trim($_POST['caducidad_credencial']), ENT_QUOTES, 'UTF-8') : '';

    // Encriptar el apellido y el token_verificacion antes de almacenarlos

    $encryptedApellidos = encryptValue($apellidos_credencial, $secretKey);
    $encryptedToken = encryptValue('9999', $secretKey); // Encriptar el token '9999'
    $encryptedCurp = encryptValue($curp_credencial, $secretKey);


    // Definir valores fijos y calculados
    $nivel_usuario = 7; // Definido como número entero 7
    $id_chat = 0; // Cambiado a 0 como campo vacío por defecto (puedes ajustar esto según sea necesario)

    // Usar la fecha proporcionada en el formulario tal cual
    $caducidad_credencial = $validity;

    $estatus_credencial = 1; // Definido como 1 (activo)
    $status = 'activo'; // Asignar un valor al campo status

    // Insertar los datos en la tabla `credenciales`
    $stmt = $conn->prepare("INSERT INTO credenciales (nombre_credencial, apellidos_credencial, curp_credencial, matricula_credencial, nivel_usuario, grado_credencial, grupo_credencial, turno_credencial, id_escuela, id_chat, token_verificacion, caducidad_credencial, estatus_credencial, validity, status, genero) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssissssissssss", $nombre_credencial, $encryptedApellidos, $encryptedCurp,$matricula_credencial, $nivel_usuario, $grado_credencial, $grupo_credencial, $turno_credencial, $id_escuela, $id_chat, $encryptedToken, $caducidad_credencial, $estatus_credencial, $caducidad_credencial, $status, $genero);

    if ($stmt->execute()) {
        // Obtener el ID de la credencial recién insertada
        $credencialId = $stmt->insert_id;

        // Generar el código QR con el ID de la credencial
        $qrData = encryptValue($credencialId, $secretKey); // Encriptar el ID
        $qrDir = 'qrcodes/'; // Carpeta para guardar los códigos QR
        if (!file_exists($qrDir)) {
            mkdir($qrDir, 0777, true); // Crear la carpeta si no existe
        }
        $qrFile = $qrDir . $credencialId . '.png';
        QRCode::png($qrData, $qrFile, QR_ECLEVEL_L, 10);


        // Obtener la hora actual y restar una hora
        $horaActual = new DateTime();
        $horaActual->modify('-1 hour');
        $horaActualFormatted = $horaActual->format('Y-m-d H:i:s');

        // Insertar o actualizar en la tabla `qr_codes`
        $stmt = $conn->prepare("INSERT INTO qr_codes (credential_id, file_path, created_at) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE file_path = VALUES(file_path), created_at = VALUES(created_at)");
        $stmt->bind_param("iss", $credencialId, $qrFile, $horaActualFormatted);

        if ($stmt->execute()) {
            // Mensaje de éxito
            echo '<div style="padding: 20px; border-radius: 8px; background-color: #e7ecfa; color: #004d99; text-align: center; font-size: 1.5rem; font-weight: bold; margin-top: 20px;">';
            echo '<div style="text-align: center; margin-top: 20px; display: flex; justify-content: center; align-items: center;">';
            echo '<div style="display: inline-block; margin: 20px;">';
            echo '<div style="font-size: 5rem; color: #ffffff; background-color: #3498db; padding: 40px; border-radius: 50%; width: 120px; height: 120px; line-height: 120px; text-align: center;">1</div>';
            echo '</div>';
            echo '</div>';
            echo 'Registro creado correctamente y QR generado.<br>';
            echo '<a href="' . $qrFile . '" style="color: #007bff; text-decoration: none; font-weight: bold; font-size: 1.3rem;">Ver QR Code</a><br>';
            echo '<a href="' . $qrFile . '" download="qr_code_' . $credencialId . '.png">';
            echo '<button style="background-color: #007bff; color: white; border: none; padding: 12px 24px; border-radius: 6px; font-size: 1.2rem; cursor: pointer; margin-top: 10px;">Descargar QR</button>';
            echo '</a>';
            echo '</div>';

            // Redirección a otra página
            $otherPage = 'entrada-salida.html'; // Página a la que quieres redirigir
            echo '<div style="padding: 20px; border-radius: 8px; background-color: #f9e79f; color: #6d4c41; text-align: center; font-size: 1.5rem; font-weight: bold; margin-top: 20px;">';
            echo '<div style="text-align: center; margin-top: 20px; display: flex; justify-content: center; align-items: center;">';
            echo '<div style="display: inline-block; margin: 20px;">';
            echo '<div style="font-size: 5rem; color: #e74c3c; background-color: #fceae6; padding: 40px; border-radius: 50%; width: 120px; height: 120px; line-height: 120px; text-align: center;">2</div>';
            echo '</div>';
            echo '</div>';
            echo 'Redirigiendo a la página de entrada-salida...<br>';
            echo '<meta http-equiv="refresh" content="5;url=' . $otherPage . '">';
            echo '</div>';
        } else {
            echo "Error al insertar el QR: " . $stmt->error;
        }
    } else {
        echo "Error al insertar la credencial: " . $stmt->error;
    }

    // Cerrar la declaración
    $stmt->close();
}

// Cerrar la conexión
$conn->close();
?>
