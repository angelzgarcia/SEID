<?php
require_once __DIR__ . '/../config.php';
require_once MATRIX_DOC_FNS . 'helpers/clear.php';
require_once MATRIX_DOC_FNS . 'helpers/swal.php';

if (isset($_GET['file'])) {
    $archivo = clearEntry($_GET['file'] ?? '') ?? null;
    $path = DOC_ROOT . "imgs_qrcodes/{$archivo}";

    if (file_exists($path)) {
        $info = pathinfo($archivo);
        $extension = strtolower($info['extension']);
        $filename = $info['filename'];

        if ($extension === 'webp') {
            $webp_image = imagecreatefromwebp($path);

            if (!$webp_image) {
                $_SESSION['swal'] = swal('error', '¡No se pudo procesar el fichero!');
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }

            header('Content-Type: image/png');
            header('Content-Disposition: attachment; filename="' . $filename . '.png"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');

            imagepng($webp_image);
            imagedestroy($webp_image);
            exit;

        } else {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($archivo) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($path));
            readfile($path);
            exit;
        }
    } else {
        $_SESSION['swal'] = swal('error', '¡No se pudo descargar el archivo!');
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
