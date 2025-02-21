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

        //  I S   S I M P L E    S E L E C T
        if (empty($params)) {
            try {
                $result = $conn -> query($query) -> fetch_all(MYSQLI_ASSOC);
                return !empty($result) ? $result : false;
            } catch (\Throwable $th) { return false; }
        }

        //  I S   P A R A M S    Q U E R Y
        try {
            $result = $conn -> prepare($query);
            $result -> bind_param($types, ...$params);
            $result -> execute();
            //  I S   S E L E C T   Q U E R Y
            if ($result -> affected_rows === -1 || $result -> field_count > 0) {
                $rows = $result -> get_result() -> fetch_all(MYSQLI_ASSOC);
                $result -> close();

                return !empty($rows)
                    ? ($with_results ? $rows : true)
                    : false;
            }

            //   I S   /   U P D A T E   /  I N S E R T   /  D E L E T E  /  Q U E R Y
            $result -> close();
            return true;

        } catch (\Throwable $th) { return false; }
    }
