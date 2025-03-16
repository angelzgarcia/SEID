<?php

    const SITE_NAME = 'Sistema Empresarial Integral | DENEDIG';
    const APP_NAME = 'SEID';

    define('HTTP_URL', ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
                                                ? 'https'
                                                : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/' . APP_NAME . '/');

    define('DOC_ROOT', __DIR__ . '/../');

    $full_pattern = 'EEEE, d \'de\' MMMM \'de\' YYYY HH:mm:ss';
    $short_pattern = 'dd MMM HH:mm';

    $timestamp = time();

    $createFormattedDate = fn()
        => new IntlDateFormatter(
            'es-ES',
            IntlDateFormatter::FULL,
            IntlDateFormatter::MEDIUM,
            null,
            IntlDateFormatter::GREGORIAN
        );

    $formatted_date = $createFormattedDate();

    $full_current_date = $formatted_date -> format($timestamp);
