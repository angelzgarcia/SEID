<?php require_once __DIR__ . '/../../config.php' ?>
<?php require_once MATRIX_DOC_ROOT . 'database.php' ?>

<?php $page_name = ACCESO . 'Sucursales ' ?>

<?php
    $sql = '
        SELECT COUNT(*) AS total_sucursales,
        SUM(CASE WHEN status_sucursal = 0 THEN 1 ELSE 0 END) AS sucursales_activas,
        (SELECT nombre_sucursal FROM sucursales ORDER BY id_sucursal ASC LIMIT 1) AS primera_sucursal
        FROM sucursales
    ';

    $branches_collector = simpleQuery($sql)[0] ?? ['total_sucursales' => 0, 'sucursales_activas' => 0, 'primera_sucursal' => ''];

    $count_branches = $branches_collector['total_sucursales'];
    $count_enable_branches = $branches_collector['sucursales_activas'];
    $count_disable_branches = $count_branches - $count_enable_branches;
    $first_branch = $branches_collector['primera_sucursal'];
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once MATRIX_DOC_VIEWS . "modules/head.php" ?>
<body>

    <?php require_once MATRIX_DOC_VIEWS . "/modules/header.php" ?>

    <?php require_once MATRIX_DOC_VIEWS . "/modules/sidebar.php" ?>

    <main class="main-content matriz-content inventory-content">

        <!-- PEDIDOS DE LAS SUCURSALES -->
        <div class="branches-orders">
            <a href="<?= MATRIX_HTTP_VIEWS ?>sucursales/pedidos/index">
                Pedidos
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-160v-516L82-846l72-34 94 202h464l94-202 72 34-78 170v516H160Zm240-280h160q17 0 28.5-11.5T600-480q0-17-11.5-28.5T560-520H400q-17 0-28.5 11.5T360-480q0 17 11.5 28.5T400-440ZM240-240h480v-358H240v358Zm0 0v-358 358Z"/></svg>
            </a>
        </div>

        <!-- CRUD -->
        <div class="crud-container">

            <!-- CRUD HEADER -->
            <div class="crud-header">
                <!-- HEADER SUPERIOR -->
                <div class="crud-top-header">
                    <!-- ACCESOS DIRECTOS -->
                    <div class="crud-tittle">
                        <div class="title-shortcut-inventory">
                            <h1>
                                sucursales
                                <a class="shortcut-link-btn <?= strpos($_SERVER['PHP_SELF'], 'sucursales/index') ? 'active' : '' ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M240-40q-50 0-85-35t-35-85q0-50 35-85t85-35q14 0 26 3t23 8l57-71q-28-31-39-70t-5-78l-81-27q-17 25-43 40t-58 15q-50 0-85-35T0-580q0-50 35-85t85-35q50 0 85 35t35 85v8l81 28q20-36 53.5-61t75.5-32v-87q-39-11-64.5-42.5T360-840q0-50 35-85t85-35q50 0 85 35t35 85q0 42-26 73.5T510-724v87q42 7 75.5 32t53.5 61l81-28v-8q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35q-32 0-58.5-15T739-515l-81 27q6 39-5 77.5T614-340l57 70q11-5 23-7.5t26-2.5q50 0 85 35t35 85q0 50-35 85t-85 35q-50 0-85-35t-35-85q0-20 6.5-38.5T624-232l-57-71q-41 23-87.5 23T392-303l-56 71q11 15 17.5 33.5T360-160q0 50-35 85t-85 35ZM120-540q17 0 28.5-11.5T160-580q0-17-11.5-28.5T120-620q-17 0-28.5 11.5T80-580q0 17 11.5 28.5T120-540Zm120 420q17 0 28.5-11.5T280-160q0-17-11.5-28.5T240-200q-17 0-28.5 11.5T200-160q0 17 11.5 28.5T240-120Zm240-680q17 0 28.5-11.5T520-840q0-17-11.5-28.5T480-880q-17 0-28.5 11.5T440-840q0 17 11.5 28.5T480-800Zm0 440q42 0 71-29t29-71q0-42-29-71t-71-29q-42 0-71 29t-29 71q0 42 29 71t71 29Zm240 240q17 0 28.5-11.5T760-160q0-17-11.5-28.5T720-200q-17 0-28.5 11.5T680-160q0 17 11.5 28.5T720-120Zm120-420q17 0 28.5-11.5T880-580q0-17-11.5-28.5T840-620q-17 0-28.5 11.5T800-580q0 17 11.5 28.5T840-540ZM480-840ZM120-580Zm360 120Zm360-120ZM240-160Zm480 0Z"/></svg>
                                </a>
                            </h1>
                        </div>
                        <p>
                            Consulte y gestiones sus sucursales
                        </p>
                    </div>

                    <div class="crud-order-by">
                        <select name="order-by-branches" class="crud-header-select" id="order-by-branches">
                            <option selected disabled>Ordenar por</option>
                            <option value="">A - Z</option>
                            <option value="">Z - A</option>
                        </select>
                    </div>

                    <a href="<?= MATRIX_HTTP_VIEWS ?>sucursales/create" class="crud-add-btn">
                        Añadir sucursal
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M440-120v-320H120v-80h320v-320h80v320h320v80H520v320h-80Z"/></svg>
                    </a>
                </div>

                <!-- HEADER INTERMEDIO -->
                <div class="crud-middle-header">
                    <div class="details">
                        <div class="summary">
                            <p>N° sucursales</p>
                            <span><?=$count_branches?></span>
                        </div>

                        <div class="summary">
                            <p>Sucursales inactivas</p>
                            <span><?=$count_enable_branches?></span>
                        </div>

                        <div class="summary">
                            <p>Sucursales activas</p>
                            <span><?=$count_disable_branches?></span>
                        </div>

                        <div class="summary">
                            <p>Sucursal más antigua</p>
                            <span class="uppercase"><?=$first_branch?></span>
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

                    <form action="" class="crud-searcher">
                        <input
                            type="text" id="searcher" placeholder="Buscar sucursal..." autocomplete="off"
                            onkeyup="busqueda();"
                        >

                        <span id="erase-search">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m456-320 104-104 104 104 56-56-104-104 104-104-56-56-104 104-104-104-56 56 104 104-104 104 56 56Zm-96 160q-19 0-36-8.5T296-192L80-480l216-288q11-15 28-23.5t36-8.5h440q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H360ZM180-480l180 240h440v-480H360L180-480Zm400 0Z"/></svg>
                        </span>
                        
                        <button type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/></svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- LISTA DE REGISTROS -->
            <div class="crud-grid" id="branches-container">

                <!--  -->

            </div>
        </div>
    </main>

    <?php require_once MATRIX_DOC_VIEWS . 'sucursales/show_modal.php' ?>

    <script src="<?= MATRIX_HTTP_URL ?>resources/js/branches.js"></script>

    <script src="<?=MATRIX_HTTP_URL?>resources/js/tooltips.js"></script>
</body>
</html>
