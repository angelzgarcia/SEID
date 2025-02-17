<?php
    require_once __DIR__ . '/../app/config.php';
    session_start();

    const SELLER_ACCESS = ' | Punto de venta | ';

    define('SELLER_DOC_ROOT', DOC_ROOT . 'acceso_vendedor/');
    define('SELLER_HTTP_URL', HTTP_URL . 'acceso_vendedor/');

    define('SELLER_DOC_VIEWS', SELLER_DOC_ROOT . 'views/');
    define('SELLER_HTTP_VIEWS', SELLER_HTTP_URL . 'views/');

    define('SELLER_FNS', SELLER_HTTP_URL . 'functions/');
