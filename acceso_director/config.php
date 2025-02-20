<?php
    require_once __DIR__ . '/../app/config.php';
    session_start();

    const DIRECTOR_ACCESS = ' | DIRECTOR | ';

    define('DIRECTOR_DOC_ROOT', DOC_ROOT . 'acceso_director/');
    define('DIRECTOR_HTTP_URL', HTTP_URL . 'acceso_director/');

    define('DIRECTOR_DOC_VIEWS', DIRECTOR_DOC_ROOT . 'views/');
    define('DIRECTOR_HTTP_VIEWS', DIRECTOR_HTTP_URL . 'views/');

    define('DIRECTOR_FNS', DIRECTOR_HTTP_URL . 'functions/');

