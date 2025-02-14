<?php
    require_once __DIR__ . '/../app/config.php';
    session_start();

    const ACCESO = ' | Matriz | ';

    define('MATRIX_DOC_ROOT', DOC_ROOT . 'acceso_matriz/');
    define('MATRIX_HTTP_URL', HTTP_URL . 'acceso_matriz/');

    define('MATRIX_DOC_VIEWS', MATRIX_DOC_ROOT . 'views/');
    define('MATRIX_HTTP_VIEWS', MATRIX_HTTP_URL . 'views/');

    define('MATRIX_FNS', MATRIX_HTTP_URL . 'functions/');

