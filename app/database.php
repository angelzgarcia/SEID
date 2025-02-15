<?php

    const SERVERNAME = "localhost";
    const USERNAME = "root";
    const PASSWORD = "";
    const DBNAME = "seid";

    $conn;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DBNAME);

    if ($conn -> connect_error) die("Error de conexión: {$conn->connect_error}");

    $conn -> set_charset("utf8");


    function simpleQuery($query, $params = [], $types = '')
    {
        global $conn;
        $result = $conn -> prepare($query);

        if (!empty($params)) $result -> bind_param($types, ...$params);

        if ($result -> execute())  {
            $result -> close();
            return true;
        }
        
        $result -> close();
        return false;
    }
