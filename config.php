
<?php

    const PAGE_NAME = 'Sistema Empresarial Integral | DENEDIG';
    const APP_NAME = 'SEID';

    define('HTTP_URL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/' . APP_NAME . '/');

    define('DOC_ROOT', __DIR__ . '/'); 

    $formatter = new IntlDateFormatter(
        'es_MXN',
        IntlDateFormatter::FULL,
        IntlDateFormatter::FULL,
        'America/Mexico_City',
        IntlDateFormatter::GREGORIAN,
        'EEEE, d \'de\' MMMM \'de\' YYYY HH:mm:ss'
    );

    $fecha = $formatter -> format(time());
