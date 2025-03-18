<?php require_once __DIR__ . '/../../config.php' ?>

<!DOCTYPE html>
<html lang="es">
<?php require_once VISITOR_DOC_VIEWS . 'components/head.php' ?>
<body>
    <?php require_once VISITOR_DOC_VIEWS . 'components/header.php' ?>

    <main class="index-main">
        <div class="login-container">
            <div-qr-reader-cont>
                <h1>LOGIN QR</h1>

                <div id="qr-reader">
                    <!-- SE RECUPERA LA IMAGEN Y SE INSERTA CON JQUERY -->
                </div>
            </div-qr-reader-cont>

            <div class="login-form-container">
                <h2>
                    Sistema Empresarial Integral
                </h2>

                <form action="<?=HTTP_URL?>auth/login-qr.php" method="POST">
                    <fieldset>
                        <legend>Código QR</legend>

                        <div class="upload-qr-buttons">
                            <input type="text" id="qr_code" name="qr_code" placeholder="Escanee, suba o ingrese su código QR">

                            <label for="qr-input-file" class="file-label">
                                <span>Cargar código QR</span>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M200-400v-80h80v80h-80Zm-80-80v-80h80v80h-80Zm360-280v-80h80v80h-80ZM180-660h120v-120H180v120Zm-60 60v-240h240v240H120Zm60 420h120v-120H180v120Zm-60 60v-240h240v240H120Zm540-540h120v-120H660v120Zm-60 60v-240h240v240H600ZM360-400v-80h-80v-80h160v160h-80Zm40-200v-160h80v80h80v80H400Zm-190-90v-60h60v60h-60Zm0 480v-60h60v60h-60Zm480-480v-60h60v60h-60Zm-50 570v-120H520v-80h120v-120h80v120h120v80H720v120h-80Z"/></svg>
                            </label>
                            <input type="file" id="qr-input-file" accept="image/*">

                            <p>
                                <span></span>
                                    ó
                                <span></span>
                            </p>

                            <button type="button">
                                <span>Escanear código QR</span>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M80-680v-200h200v80H160v120H80Zm0 600v-200h80v120h120v80H80Zm600 0v-80h120v-120h80v200H680Zm120-600v-120H680v-80h200v200h-80ZM700-260h60v60h-60v-60Zm0-120h60v60h-60v-60Zm-60 60h60v60h-60v-60Zm-60 60h60v60h-60v-60Zm-60-60h60v60h-60v-60Zm120-120h60v60h-60v-60Zm-60 60h60v60h-60v-60Zm-60-60h60v60h-60v-60Zm240-320v240H520v-240h240ZM440-440v240H200v-240h240Zm0-320v240H200v-240h240Zm-60 500v-120H260v120h120Zm0-320v-120H260v120h120Zm320 0v-120H580v120h120Z"/></svg>
                            </button>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Token</legend>

                        <input type="text" id="token" name="token" placeholder="Ingrese su token de seguridad de 4 digitos" title="El token debe contener exactamente 4 dígitos.">
                    </fieldset>

                    <button type="submit">
                        <span>Acceder</span>
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M280-400q-33 0-56.5-23.5T200-480q0-33 23.5-56.5T280-560q33 0 56.5 23.5T360-480q0 33-23.5 56.5T280-400Zm0 160q-100 0-170-70T40-480q0-100 70-170t170-70q67 0 121.5 33t86.5 87h352l120 120-180 180-80-60-80 60-85-60h-47q-32 54-86.5 87T280-240Zm0-80q56 0 98.5-34t56.5-86h125l58 41 82-61 71 55 75-75-40-40H435q-14-52-56.5-86T280-640q-66 0-113 47t-47 113q0 66 47 113t113 47Z"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </main>

    <?php require_once VISITOR_DOC_VIEWS . 'components/footer.php' ?>

    <?php
        if (isset($_SESSION['swal'])) {
            echo $_SESSION['swal'];

            unset($_SESSION['swal']);
        }
        unset($_SESSION['olds']);
        unset($_SESSION['errors']);
    ?>

    <!-- CDN - QR READER -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>

    <!-- MODULO LEER IMAGEN DE QR -->
    <script type="module">
        import QrScanner from "https://unpkg.com/qr-scanner@1.4.1/qr-scanner.min.js";
        window.QrScanner = QrScanner;
    </script>

    <script src="<?=HTTP_URL?>acceso_visitante/resources/js/scripts.js"></script>
</body>
</html>
