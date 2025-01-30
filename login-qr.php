<!DOCTYPE html>
<html lang="es">
<?php require_once __DIR__ . '/head.php' ?>
<body>
    <?php require_once __DIR__ . '/header.php' ?>

    <div class="container">
        <h1>Inicio de Sesión con QR</h1>
        <form id="qr-form" action="./auth/QR/scan_qr_page.php" method="POST">
            <label for="qr_code">Código QR escaneado:</label>
            <input type="text" id="qr_code" name="qr_code" placeholder="Escanee o ingrese el código QR" required>

            <label for="token">Ingrese su token:</label>
            <input type="password" id="token" name="token" placeholder="Ingrese su token de seguridad" required maxlength="4" pattern="\d{4}" title="El token debe contener exactamente 4 dígitos.">
            <div id="qr-reader"></div>

            <input type="submit" value="Acceder">
        </form>
    </div>

    <?php require_once __DIR__ . 'footer.php' ?>

    <script>
        document.getElementById('qr-form').addEventListener('submit', function(event) {
            const tokenInput = document.getElementById('token');
            const tokenValue = tokenInput.value;

            if (!/^\d{4}$/.test(tokenValue)) {
                event.preventDefault(); // Evita el envío del formulario
                alert("El token debe contener exactamente 4 dígitos.");
                tokenInput.focus();
            }
        });
    </script>

    <script>
        function onScanSuccess(decodedText, decodedResult) {
            document.getElementById('qr_code').value = decodedText;
        }

        function startScanning() {
            const html5QrCode = new Html5Qrcode("qr-reader");
            html5QrCode.start(
                { facingMode: "environment" },
                {
                    fps: 10,
                    qrbox: 250
                },
                onScanSuccess
            ).catch(err => {
                console.error("Error al iniciar el escaneo: ", err);
            });
        }

        window.onload = () => {
            startScanning();
        }
    </script>
</body>
</html>
