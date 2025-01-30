<!DOCTYPE html>
<html lang="es">
<?php require_once __DIR__ . '/head.php' ?>
<body>
    <?php require_once __DIR__ . '/header.php' ?>

    <div class="container">
        <h1>Inicio de Sesión</h1>
        <form id="qr-form" action="./auth/iniciar-sesion.php" method="POST">
            <label for="email">Correo electrónico:</label>
            <input type="text" id="email" name="email" placeholder="Ingrese su correo electrónico" required>

            <label for="pass">Contraseña</label>
            <input type="password" id="pass" name="pass" placeholder="Ingrese su contraseña" required>

            <input type="submit" value="Acceder">
        </form>
    </div>

    <?php require_once __DIR__ . 'footer.php' ?>

    <!-- <script>
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
    </script> -->
</body>
</html>
