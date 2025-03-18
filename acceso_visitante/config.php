<?php

    require_once __DIR__ . '/../app/config.php';

    session_start();

    define('VISITOR_DOC_ROOT', DOC_ROOT . 'acceso_visitante/');
    define('VISITOR_HTTP_URL', HTTP_URL . 'acceso_visitante/');

    define('VISITOR_DOC_VIEWS', VISITOR_DOC_ROOT . 'views/');
    define('VISITOR_HTTP_VIEWS', VISITOR_HTTP_URL . 'views/');

    define('VISITOR_FNS', VISITOR_HTTP_URL . 'functions/');
    define('VISITOR_DOCT_FNS', VISITOR_DOC_ROOT . 'functions/');
