<?php require_once __DIR__ . '/../../app/config.php' ?>
<!DOCTYPE html>
<html lang="es">
<?php require_once DOC_ROOT . 'acceso_visitante/views/modules/head.php' ?>
<body>
    <?php require_once DOC_ROOT . 'acceso_visitante/views/modules/header.php' ?>

    <main class="index-main">
        <div class="login-container">
            <div-qr-reader-cont>
                <h1>LOGIN QR</h1>
                <div id="qr-reader"></div> <!-- SCAN QR CAM -->
            </div-qr-reader-cont>

            <div class="login-form-container">
                <h2>
                    Sistema Empresarial Integral
                </h2>
                <form action="../QR/login-qr.php" method="POST">
                    <fieldset>
                        <legend>Codigo QR</legend>
                        <input type="text" id="qr_code" name="qr_code" placeholder="Escanee, suba o ingrese su código QR"> <!-- QR VALUE -->
                        <input type="file" id="qr-input-file" accept="image/*"> <!-- UPLOAD IMAGE QR -->
                    </fieldset>

                    <fieldset>
                        <legend>Token</legend>
                        <input type="password" id="token" name="token" placeholder="Ingrese su token de seguridad de 4 digitos" maxlength="4" pattern="\d{4}" title="El token debe contener exactamente 4 dígitos.">
                    </fieldset>

                    <button type="submit">
                        Acceder
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-400q-33 0-56.5-23.5T200-480q0-33 23.5-56.5T280-560q33 0 56.5 23.5T360-480q0 33-23.5 56.5T280-400Zm0 160q-100 0-170-70T40-480q0-100 70-170t170-70q67 0 121.5 33t86.5 87h352l120 120-180 180-80-60-80 60-85-60h-47q-32 54-86.5 87T280-240Zm0-80q56 0 98.5-34t56.5-86h125l58 41 82-61 71 55 75-75-40-40H435q-14-52-56.5-86T280-640q-66 0-113 47t-47 113q0 66 47 113t113 47Z"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </main>

    <?php require_once DOC_ROOT . 'acceso_visitante/views/modules/footer.php' ?>


    <!-- VALIDAR LONGITUD DEL TOKEN -->
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

    <!-- CDN - LEER QR CON CÁMARA -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
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

            startScanning();
        });
    </script>

    <!-- CDN - LEER IMAGEN DE QR -->
    <script type="module">
        import QrScanner from "https://unpkg.com/qr-scanner@1.4.1/qr-scanner.min.js";

        document.getElementById('qr-input-file').addEventListener('change', async function(event) {
            const file = event.target.files[0];
            if (!file) return;

            try {
                const result = await QrScanner.scanImage(file);
                document.getElementById('qr_code').value = result;
            } catch (err) {
                alert("No se pudo leer el QR: " + err);
            }
        });
    </script>
</body>
</html>
