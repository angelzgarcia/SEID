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


    function simpleQuery($query, $params = [], $types = '', $with_results = false)
    {
        global $conn;

        // IS SIMPLE SELECT
        if (empty($params)) {
            try {
                $result = $conn -> query($query) -> fetch_all(MYSQLI_ASSOC);
                return !empty($result) ? $result : false;
            } catch (\Throwable $th) { return false; }
        }

        // IS PARAMS QUERY
        try {
            $result = $conn -> prepare($query);
            $result -> bind_param($types, ...$params);
            $result -> execute();
            // IS SELECT QUERY
            if ($result -> affected_rows === -1 || $result -> field_count > 0) {
                $rows = $result -> get_result() -> fetch_all(MYSQLI_ASSOC);
                $result -> close();

                return !empty($rows)
                    ? ($with_results ? $rows : true)
                    : false;
            }

            // IS / UPDATE / INSERT / DELETE / QUERY
            $result -> close();
            return true;

        } catch (\Throwable $th) { return false; }
    }
