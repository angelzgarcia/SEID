<?php

    const SITE_NAME = 'Sistema Empresarial Integral | DENEDIG';
    const APP_NAME = 'SEID';

    define('HTTP_URL', ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/' . APP_NAME . '/');

    define('DOC_ROOT', __DIR__ . '/../');

    $formatter = new IntlDateFormatter(
        'es_MX',
        IntlDateFormatter::FULL,
        IntlDateFormatter::FULL,
        'America/Mexico_City',
        IntlDateFormatter::GREGORIAN,
        'EEEE, d \'de\' MMMM \'de\' YYYY HH:mm:ss'
    );

    $formatter_abreviado = new IntlDateFormatter(
        'es_MX',
        IntlDateFormatter::NONE,
        IntlDateFormatter::SHORT,
        'America/Mexico_City',
        IntlDateFormatter::GREGORIAN,
        'dd MMM HH:mm'
    );

    $timestamp = time();

    $fecha = $formatter -> format($timestamp);
    $fecha_ab = $formatter_abreviado -> format($timestamp);
