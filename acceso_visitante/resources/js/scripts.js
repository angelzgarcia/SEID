

const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3200,
    iconColor: 'white',
    timerProgressBar: true,
    customClass: {
        popup: 'colored-toast',
    },
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});

$(document).on('keyup', '#token', function() {
    let $tokenInput = $(this);

    if ($tokenInput.val().length > 4) {
        $tokenInput.val($tokenInput.val().slice(0, 4));
    }
});


// <!-- I N S E R T A R   V A L O R   D E L   Q R   E N   E L   I N P U T -->
function onScanSuccess(decodedText, decodedResult) {
    document.getElementById('qr_code').value = decodedText;
}


// <!-- L E E R   Q R   C O N   C Á M A R A -->
function startScanning() {
    const qrReaderElement = document.getElementById("qr-reader");

    const html5QrCode = new Html5Qrcode("qr-reader");

    navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
        .then(() => {
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
        })
        .catch(err => {
            Toast.fire({
                icon: "warning",
                title: "Concede permisos a la cámara para escanear tu código QR"
            });
        });
}


document.addEventListener("DOMContentLoaded", function() {
    startScanning();

    if (!window.QrScanner) {
        console.error("QrScanner no se ha cargado correctamente.");
        return;
    }

    // <!-- O B T E N E R   Q R ,   I N S E R T A R   V A L O R   E   I M A G E N -->
    document.getElementById('qr-input-file').addEventListener('change', async function(event) {
        const reader = new FileReader();
        const file = event.target.files[0];
        if (!file) return;

        try {
            reader.readAsDataURL(file);
            reader.onload = function(e) {
                document.getElementById('qr-reader').innerHTML = `<img src="${e.target.result}" alt="QR Preview">`;
                document.getElementById('qr-reader').style.backgroundImage = 'none';
            };

            const result = await QrScanner.scanImage(file);
            document.getElementById('qr_code').value = result;

        } catch (err) {
            Toast.fire({
                icon: "warning",
                title: "Formato no válido"
            });
        }
    });
});
