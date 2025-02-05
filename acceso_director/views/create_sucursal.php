<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar sucursal</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            margin-top: 5% !important;
            max-width: 600px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #0056b3;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="password"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #0056b3;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #003d80;
        }
        #qr-reader {
            width: 100%;
            margin-top: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <br>
    <div class="container">
        <h1>Agregar sucursal</h1>
        <form id="" action="../functions/create_sucursal.php" method="POST">
            <!-- NOMBRE -->
            <div class='message-error'>
                <?= isset($_SESSION['errors']) ? $_SESSION['errors']['nombre'] : '' ?>
            </div>
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" placeholder="Ingrese el nombre de la sucursal" >

            <!-- DIRECCION -->
            <div class='message-error'>
                <?= isset($_SESSION['errors']) ? $_SESSION['errors']['direccion'] : '' ?>
            </div>
            <label for="direccion">Direccion</label>
            <input type="text" name="direccion" placeholder="Ingrese la direccion de la sucursal" >

            <input type="hidden" name="accion" value="crear">
            <!-- ENVIAR -->
            <input type="submit" value="Registrar">
        </form>
    </div>
    <?php
        if (isset($_SESSION['swal'])) {
            echo $_SESSION['swal'];

            session_unset();
            session_destroy();
        }
    ?>
</body>
</html>
