<?php require_once __DIR__ . '/../../config.php' ?>
<?php require_once MATRIX_DOC_ROOT . '/database.php' ?>
<?php require_once MATRIX_DOC_FNS . 'helpers/encrypt.php' ?>
<?php require_once MATRIX_DOC_FNS . 'helpers/clear.php' ?>

<?php $page_name = ACCESO . 'Personal' ?>

<?php
    $sql = '
        SELECT COUNT(*) AS total_credenciales,
        SUM(CASE WHEN status_credencial = 0 THEN 1 ELSE 0 END) AS credenciales_activas
        FROM credenciales
    ';

    $branches_collector = simpleQuery($sql)[0] ?? ['total_credenciales' => 0, 'credenciales_activas' => 0];

    $count_credentials = $branches_collector['total_credenciales'];
    $count_enable_credentials = $branches_collector['credenciales_activas'];
    $count_disable_credentials = $count_credentials - $count_enable_credentials;

    $sql = 'SELECT id_sucursal, nombre_sucursal FROM sucursales WHERE status_sucursal = 0 ORDER BY nombre_sucursal ASC';
    $sucursales = simpleQuery($sql) ?: [];
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once MATRIX_DOC_VIEWS . "modules/head.php" ?>
<body>

    <?php require_once MATRIX_DOC_VIEWS . "/modules/header.php" ?>

    <?php require_once MATRIX_DOC_VIEWS . "/modules/sidebar.php" ?>

    <main class="main-content matriz-content inventory-content">

        <!-- FILTRAR PERSONAL POR SUCURSAL -->
        <div class="searcher-links">
            <div class="subsidiaries-filter" autocomplete="off">
                <input
                    type="text" list="sucursales" name="sucursal_datalist" id="sucursal_datalist" placeholder="Buscar sucursal..."
                    onkeyup="busqueda();"
                >

                <datalist id="sucursales">
                    <?php if (!empty($sucursales)):

                        foreach ($sucursales as $suc):
                            $sucursal_name = ucwords($suc['nombre_sucursal']); ?>

                            <option value="<?= $sucursal_name ?>"  data-id="<?= encryptValue($suc['id_sucursal'], SECRETKEY) ?>">
                                <?= $sucursal_name ?>
                            </option>
                        <?php endforeach;

                    endif; ?>
                </datalist>

                <select name="sucursal_select" class="crud-header-select sucursal-select">
                    <?php if (empty($sucursales)): ?>

                        <option selected disabled>
                            No hay sucursales registradas
                        </option>

                    <?php else: ?>

                        <option value="" class="font-extrabold">
                            Todas las sucursales
                        </option>

                        <?php foreach ($sucursales as $suc): ?>
                            $sucursal_name = ucwords($suc['nombre_sucursal']); ?>
                            <option value="<?= $sucursal_name ?>">
                                <?= $sucursal_name ?>
                            </option>
                        <?php endforeach;

                    endif; ?>
                </select>
            </div>
        </div>

        <!-- CRUD -->
        <div class="crud-container">
            <!-- CRUD HEADER -->
            <div class="crud-header">
                <!-- HEADER SUPERIOR -->
                <div class="crud-top-header">
                    <div class="crud-tittle">
                        <div class="title-shortcut-inventory">
                            <h1>
                                personal
                                <a class="shortcut-link-btn <?= strpos($_SERVER['PHP_SELF'], 'credenciales/index') ? 'active' : '' ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M41 7C31.6-2.3 16.4-2.3 7 7S-2.3 31.6 7 41l72 72c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9L41 7zM599 7L527 79c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l72-72c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0zM7 505c9.4 9.4 24.6 9.4 33.9 0l72-72c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L7 471c-9.4 9.4-9.4 24.6 0 33.9zm592 0c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-72-72c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l72 72zM320 256a64 64 0 1 0 0-128 64 64 0 1 0 0 128zM212.1 336c-2.7 7.5-4.1 15.6-4.1 24c0 13.3 10.7 24 24 24l176 0c13.3 0 24-10.7 24-24c0-8.4-1.4-16.5-4.1-24c-.5-1.4-1-2.7-1.6-4c-9.4-22.3-29.8-38.9-54.3-43c-3.9-.7-7.9-1-12-1l-80 0c-4.1 0-8.1 .3-12 1c-.8 .1-1.7 .3-2.5 .5c-24.9 5.1-45.1 23-53.4 46.5zM175.8 224a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm-26.5 32C119.9 256 96 279.9 96 309.3c0 14.7 11.9 26.7 26.7 26.7l56.1 0c8-34.1 32.8-61.7 65.2-73.6c-7.5-4.1-16.2-6.4-25.3-6.4l-69.3 0zm368 80c14.7 0 26.7-11.9 26.7-26.7c0-29.5-23.9-53.3-53.3-53.3l-69.3 0c-9.2 0-17.8 2.3-25.3 6.4c32.4 11.9 57.2 39.5 65.2 73.6l56.1 0zM464 224a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"></path></svg>
                                </a>
                            </h1>
                        </div>

                        <p>
                            Consulte y gestione a los usuarios registrados
                        </p>
                    </div>

                    <div class="crud-order-by">
                        <select name="order-by-credentials" class="crud-header-select" id="order-by-credentials">
                            <option selected disabled>Ordenar por</option>
                            <option value="">Más recientes</option>
                            <option value="">Más antiguos</option>
                            <option value="">Activos</option>
                            <option value="">Inactivos</option>
                            <option value="">A - Z</option>
                            <option value="">Z - A</option>
                        </select>
                    </div>

                    <a href="<?= MATRIX_HTTP_VIEWS ?>credenciales/create" class="crud-add-btn">
                        Añadir usuario
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M440-120v-320H120v-80h320v-320h80v320h320v80H520v320h-80Z"/></svg>
                    </a>
                </div>

                <!-- HEADER INTERMEDIO -->
                <div class="crud-middle-header">
                    <div class="details">
                        <div class="summary">
                            <p>Usuarios registrados</p>
                            <span><?=$count_credentials ?? 0?></span>
                        </div>

                        <!-- <div class="summary">
                            <p>Administradores</p>
                            <span>09</span>
                        </div> -->

                        <div class="summary">
                            <p>Vendedores</p>
                            <span><span><?=$count_sellers ?? 0?></span></span>
                        </div>

                        <div class="summary">
                            <p>Usuarios activos</p>
                            <span><?=$count_enable_credentials ?? 0?></span>
                        </div>

                        <div class="summary">
                            <p>Usuarios inactivos</p>
                            <span><?=$count_disable_credentials ?? 0?></span>
                        </div>
                    </div>
                </div>

                <!-- HEADER INFERIOR -->
                <div class="crud-bottom-header">
                    <form action="" class="delete-all-form">
                        <input type="checkbox" name="" id="">
                        <p>Seleccionar todo</p>

                        <select name="" class="crud-header-select">
                            <option value="">Acciones</option>
                            <option value="">Eliminar registros</option>
                        </select>
                    </form>

                    <!-- BUSCADOR -->
                    <div class="crud-searcher">
                        <input
                            type="text" id="searcher" placeholder="Buscar usuario..." autocomplete="off"
                            onkeyup="busqueda();"
                        >

                        <span id="erase-search">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                                <path d="m456-320 104-104 104 104 56-56-104-104 104-104-56-56-104 104-104-104-56 56 104 104-104 104 56 56Zm-96 160q-19 0-36-8.5T296-192L80-480l216-288q11-15 28-23.5t36-8.5h440q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H360ZM180-480l180 240h440v-480H360L180-480Zm400 0Z" />
                            </svg>
                        </span>

                        <button type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                                <path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- LISTA DE REGISTROS -->
            <div class="crud-grid" id="credentials-container">

                <!--  -->

            </div>
        </div>
    </main>

    <script src="<?= MATRIX_HTTP_URL ?>resources/js/credentials.js"></script>

    <script src="<?=MATRIX_HTTP_URL?>resources/js/tooltips.js"></script>
</body>
</html>
