<?php require_once __DIR__ . '/../../../config.php' ?>
<?php require_once MATRIX_DOC_ROOT . '/database.php' ?>
<?php require_once MATRIX_DOC_FNS . 'helpers/encrypt.php' ?>
<?php require_once MATRIX_DOC_FNS . 'helpers/clear.php' ?>
<?php $page_name = ACCESO . ' Sucursales | Pedidos' ?>

<?php
    //  S U C U R S A L E S
    $sql = 'SELECT id_sucursal, nombre_sucursal FROM sucursales ORDER BY nombre_sucursal ASC';
    $sucursales = simpleQuery($sql) ?: [];

?>

<!DOCTYPE html>
<html lang="en">
<?php require_once MATRIX_DOC_VIEWS . "modules/head.php" ?>
<style>
    .swal2-popup.swal2-toast.swal2-icon-question.swal2-show {
        display: flex !important;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
    }
</style>
<body>

    <?php require_once MATRIX_DOC_VIEWS . "/modules/header.php" ?>

    <?php require_once MATRIX_DOC_VIEWS . "/modules/sidebar.php" ?>

    <main class="main-content matriz-content inventory-content">

        <!-- FILTRAR INVENTARIOS POR SUCURSAL -->
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

        <!-- CRUD CONTAINER -->
        <div class="crud-container branches-orders-container">
            <!-- CRUD HEADER -->
            <div class="crud-header">
                <!-- HEADER SUPERIOR -->
                <div class="crud-top-header">
                    <!-- ACCESOS DIRECTOS -->
                    <div class="crud-tittle">
                        <div class="title-shortcut-inventory">
                            <h1>
                                Pedidos
                                <a class="shortcut-link-btn <?= strpos($_SERVER['PHP_SELF'], 'sucursales/pedidos/index') ? 'active' : '' ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m40-240 20-80h220l-20 80H40Zm80-160 20-80h260l-20 80H120Zm623 240 20-160 29-240 10-79-59 479ZM240-80q-33 0-56.5-23.5T160-160h583l59-479H692l-11 85q-2 17-15 26.5t-30 7.5q-17-2-26.5-14.5T602-564l9-75H452l-11 84q-2 17-15 27t-30 8q-17-2-27-15t-8-30l9-74H220q4-34 26-57.5t54-23.5h80q8-75 51.5-117.5T550-880q64 0 106.5 47.5T698-720h102q36 1 60 28t19 63l-60 480q-4 30-26.5 49.5T740-80H240Zm220-640h159q1-33-22.5-56.5T540-800q-35 0-55.5 21.5T460-720Z"/></svg>
                                </a>
                            </h1>

                            <svg xmlns="http://www.w3.org/2000/svg" height="25px" viewBox="0 -960 960 960" width="25px" fill="#111111c2"><path d="M480-120q-75 0-140.5-28.5t-114-77q-48.5-48.5-77-114T120-480q0-75 28.5-140.5t77-114q48.5-48.5 114-77T480-840v80q-117 0-198.5 81.5T200-480q0 117 81.5 198.5T480-200v80Zm160-160-56-57 103-103H360v-80h327L584-624l56-56 200 200-200 200Z"/></svg>

                            <a href="../index" title="Sucursales" class="shortcut-link-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M240-40q-50 0-85-35t-35-85q0-50 35-85t85-35q14 0 26 3t23 8l57-71q-28-31-39-70t-5-78l-81-27q-17 25-43 40t-58 15q-50 0-85-35T0-580q0-50 35-85t85-35q50 0 85 35t35 85v8l81 28q20-36 53.5-61t75.5-32v-87q-39-11-64.5-42.5T360-840q0-50 35-85t85-35q50 0 85 35t35 85q0 42-26 73.5T510-724v87q42 7 75.5 32t53.5 61l81-28v-8q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35q-32 0-58.5-15T739-515l-81 27q6 39-5 77.5T614-340l57 70q11-5 23-7.5t26-2.5q50 0 85 35t35 85q0 50-35 85t-85 35q-50 0-85-35t-35-85q0-20 6.5-38.5T624-232l-57-71q-41 23-87.5 23T392-303l-56 71q11 15 17.5 33.5T360-160q0 50-35 85t-85 35ZM120-540q17 0 28.5-11.5T160-580q0-17-11.5-28.5T120-620q-17 0-28.5 11.5T80-580q0 17 11.5 28.5T120-540Zm120 420q17 0 28.5-11.5T280-160q0-17-11.5-28.5T240-200q-17 0-28.5 11.5T200-160q0 17 11.5 28.5T240-120Zm240-680q17 0 28.5-11.5T520-840q0-17-11.5-28.5T480-880q-17 0-28.5 11.5T440-840q0 17 11.5 28.5T480-800Zm0 440q42 0 71-29t29-71q0-42-29-71t-71-29q-42 0-71 29t-29 71q0 42 29 71t71 29Zm240 240q17 0 28.5-11.5T760-160q0-17-11.5-28.5T720-200q-17 0-28.5 11.5T680-160q0 17 11.5 28.5T720-120Zm120-420q17 0 28.5-11.5T880-580q0-17-11.5-28.5T840-620q-17 0-28.5 11.5T800-580q0 17 11.5 28.5T840-540ZM480-840ZM120-580Zm360 120Zm360-120ZM240-160Zm480 0Z"/></svg>
                            </a>
                        </div>

                        <p>
                            Consulte y gestiones pedidos de reabastecimiento de cada sucursal
                        </p>
                    </div>

                    <!-- ORDENAMIENTO -->
                    <div class="crud-order-by">
                        <select name="order-by-order" class="crud-header-select" id="order-by-order">
                            <option selected disabled> Ordenar por </option>
                            <option value="recientes">
                                Más recientes
                            </option>
                            <option value="pendientes">
                                Pendientes
                            </option>
                            <option value="aprobados">
                                Aprobados
                            </option>
                            <option value="rechazados">
                                Rechazados
                            </option>
                            <option value="modificados">
                                Modificados
                            </option>
                            <option value="recibidos">
                                Recibidos
                            </option>
                        </select>
                    </div>

                    <!-- BUSCAR PEDIDO POR FECHA -->
                    <input type="text" id="datepicker" class="search-order-by-date" placeholder="Buscar pedidos por fecha" oninput="buscar()">
                </div>

                <!-- HEADER INTERMEDIO -->
                <div class="crud-middle-header">
                    <div class="details">
                        <div class="summary">
                            <p>N° de pedidos</p>
                            <span><?= $count_products ?? 0 ?></span>
                        </div>
                        <div class="summary">
                            <p>Pendientes</p>
                            <span><?= $count_out_stock_products ?? 0 ?></span>
                        </div>
                        <div class="summary">
                            <obva>Aprobados</p>
                            <span><?= $count_few_stock_products ?? 0 ?></span>
                        </div>
                        <div class="summary">
                            <p>Rechazados</p>
                            <span><?= $count_close_expiration_products ?? 0 ?></span>
                        </div>
                        <div class="summary">
                            <p>Recibidos</p>
                            <span><?= $count_close_expiration_products ?? 0 ?></span>
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
                            type="text" id="searcher" placeholder="Buscar pedido..." autocomplete="off"
                            onkeyup="busqueda();">

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

            <!-- GUIA DE COLORES STATUS DE PEDIDOS -->
            <div class="status-colors">
                <div class="status order-pending">
                    <div class="status-circle order-pending-circle"><div></div></div>
                    <p>Pendiente</p>
                </div>

                <div class="status order-aproved">
                    <div class="status-circle order-aproved-circle"><div></div></div>
                    <p>Aprobado</p>
                </div>

                <div class="status order-rejected">
                    <div class="status-circle order-rejected-circle"><div></div></div>
                    <p>Rechazado</p>
                </div>

                <div class="status order-modify">
                    <div class="status-circle order-modify-circle"><div></div></div>
                    <p>Modificado</p>
                </div>

                <div class="status order-received">
                    <div class="status-circle order-received-circle"><div></div></div>
                    <p>Recibido</p>
                </div>
            </div>

            <!-- LISTA DE REGISTROS -->
            <div class="crud-grid orders-crud" id="orders-container">

                <!--  SE ISNERTAN LOS PEDIDOS CON JQUERY  -->

            </div>
        </div>

    </main>

    <script src="<?= MATRIX_HTTP_URL ?>resources/js/orders.js"></script>
</body>
</html>
