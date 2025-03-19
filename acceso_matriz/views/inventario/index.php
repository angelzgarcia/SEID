<?php require_once __DIR__ . '/../../config.php' ?>
<?php require_once MATRIX_DOC_ROOT . '/database.php' ?>
<?php require_once MATRIX_DOC_FNS . 'helpers/encrypt.php' ?>
<?php require_once MATRIX_DOC_FNS . 'helpers/clear.php' ?>
<?php $page_name = ACCESO . 'Inventario' ?>

<?php
    //  P R O D U C T O S   C O N   V E N C I M I E N T O
    $sql = '
        SELECT p.stock_producto, p.id_producto, GROUP_CONCAT(v.fecha_vencimiento ORDER BY v.fecha_vencimiento ASC) AS fechas_vencimiento
        FROM productos AS p
        LEFT JOIN lotes_vencimientos AS v
        ON p.id_producto = v.id_producto_fk_lote_vencimiento
        GROUP BY p.id_producto
    ';

    $products = simpleQuery($sql) ?: [];
    $count_products = count($products);

    $count_out_stock_products = 0;
    $count_few_stock_products = 0;
    $count_close_expiration_products = 0;
    $curr_date = new DateTime();
    $curr_day = (int) $curr_date -> format('d');
    $curr_month = (int) $curr_date -> format('m');

    foreach ($products as $product) {
        $stock = (int)$product['stock_producto'];

        if ($stock === 0) $count_out_stock_products++;
        if ($stock > 0 && $stock <= 50) $count_few_stock_products++;

        $fechas_vencimiento = $product['fechas_vencimiento'] ? explode(',', $product['fechas_vencimiento']) : [];
        foreach ($fechas_vencimiento as $fecha) {
            $expired_date = DateTime::createFromFormat('Y-m-d', $fecha);
            if ($expired_date) {
                $expired_day = (int)$expired_date -> format('d');
                $expired_month = (int)$expired_date -> format('m');

                if ($expired_day <= $curr_day && $expired_month === $curr_month + 1) $count_close_expiration_products++;
            }
        }
    }

    //  S U C U R S A L E S
    $sql = 'SELECT id_sucursal, nombre_sucursal FROM sucursales ORDER BY nombre_sucursal ASC';
    $sucursales = simpleQuery($sql) ?: [];
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once MATRIX_DOC_VIEWS . "modules/head.php" ?>
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
                    <?php if (!empty($sucursales)): ?>
                        <?php foreach ($sucursales as $suc): ?>
                            <option value="<?= ucwords(clearEntry($suc['nombre_sucursal'])) ?>">
                                <?= ucwords($suc['nombre_sucursal']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
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
                            <option value="<?= clearEntry($suc['nombre_sucursal']) ?>">
                                <?= ucwords($suc['nombre_sucursal']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="categories-brands">
                <a href=" <?= MATRIX_HTTP_VIEWS.'inventario/categorias/index'?>">
                    Categorías
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M80-140v-320h320v320H80Zm80-80h160v-160H160v160Zm60-340 220-360 220 360H220Zm142-80h156l-78-126-78 126ZM863-42 757-148q-21 14-45.5 21t-51.5 7q-75 0-127.5-52.5T480-300q0-75 52.5-127.5T660-480q75 0 127.5 52.5T840-300q0 26-7 50.5T813-204L919-98l-56 56ZM660-200q42 0 71-29t29-71q0-42-29-71t-71-29q-42 0-71 29t-29 71q0 42 29 71t71 29ZM320-380Zm120-260Z"/></svg>
                </a>
                <a href="<?= MATRIX_HTTP_VIEWS.'inventario/marcas/index'?>">
                    Marcas
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M864-40 741-162q-18 11-38.5 16.5T660-140q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 23-6 43.5T797-218L920-96l-56 56ZM220-140q-66 0-113-47T60-300q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm0-80q33 0 56.5-23.5T300-300q0-33-23.5-56.5T220-380q-33 0-56.5 23.5T140-300q0 33 23.5 56.5T220-220Zm440 0q33 0 56.5-23.5T740-300q0-33-23.5-56.5T660-380q-33 0-56.5 23.5T580-300q0 33 23.5 56.5T660-220ZM220-580q-66 0-113-47T60-740q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm440 0q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm-440-80q33 0 56.5-23.5T300-740q0-33-23.5-56.5T220-820q-33 0-56.5 23.5T140-740q0 33 23.5 56.5T220-660Zm440 0q33 0 56.5-23.5T740-740q0-33-23.5-56.5T660-820q-33 0-56.5 23.5T580-740q0 33 23.5 56.5T660-660ZM220-300Zm0-440Zm440 0Z"/></svg>
                </a>
            </div>
        </div>

        <!-- CRUD CONTAINER -->
        <div class="crud-container">
            <!-- CRUD HEADER -->
            <div class="crud-header">
                <!-- HEADER SUPERIOR -->
                <div class="crud-top-header">
                    <div class="crud-tittle">
                        <div class="title-shortcut-inventory">
                            <h1>
                                inventario
                                <a class="shortcut-link-btn <?= strpos($_SERVER['PHP_SELF'], 'inventario/index') ? 'active' : '' ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M440-183v-274L200-596v274l240 139Zm80 0 240-139v-274L520-457v274Zm-80 92L160-252q-19-11-29.5-29T120-321v-318q0-22 10.5-40t29.5-29l280-161q19-11 40-11t40 11l280 161q19 11 29.5 29t10.5 40v318q0 22-10.5 40T800-252L520-91q-19 11-40 11t-40-11Zm200-528 77-44-237-137-78 45 238 136Zm-160 93 78-45-237-137-78 45 237 137Z"/></svg>
                                </a>
                            </h1>
                        </div>
                        <p>Consulte y gestiones su invetario</p>
                    </div>

                    <div class="crud-order-by">
                        <select name="order-by-products" class="crud-header-select" id="order-by-products">
                            <option selected disabled> Ordenar por </option>

                            <option value="ultimos">
                                Últimos añadidos
                            </option>

                            <option value="menor_stock">
                                Menor stock
                            </option>

                            <option value="mayor_stock">
                                Mayor stock
                            </option>

                            <option value="vencimiento">
                                Próximo a vencer
                            </option>

                            <option value="az">
                                A - Z
                            </option>

                            <option value="za">
                                Z - A
                            </option>
                        </select>
                    </div>

                    <div class="shipping-add-btns flex gap-3">
                        <div
                            class="branch-shipping open-order-modal"
                            data-target=".order-modal"
                        >
                            <div class="count-list-products-circle" id="count-list-products-circle"><span></span></div>

                            <button type="button" title="Ver pedido">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M240-160q-50 0-85-35t-35-85H40v-440q0-33 23.5-56.5T120-800h560v160h120l120 160v200h-80q0 50-35 85t-85 35q-50 0-85-35t-35-85H360q0 50-35 85t-85 35Zm0-80q17 0 28.5-11.5T280-280q0-17-11.5-28.5T240-320q-17 0-28.5 11.5T200-280q0 17 11.5 28.5T240-240ZM120-360h32q17-18 39-29t49-11q27 0 49 11t39 29h272v-360H120v360Zm600 120q17 0 28.5-11.5T760-280q0-17-11.5-28.5T720-320q-17 0-28.5 11.5T680-280q0 17 11.5 28.5T720-240Zm-40-200h170l-90-120h-80v120ZM360-540Z"/></svg>
                            </button>
                        </div>

                        <a href="<?= MATRIX_HTTP_VIEWS ?>inventario/create" class="crud-add-btn">
                            Añadir producto
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M440-120v-320H120v-80h320v-320h80v320h320v80H520v320h-80Z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- HEADER INTERMEDIO -->
                <div class="crud-middle-header">
                    <div class="details">
                        <div class="summary">
                            <p>Total de productos</p>
                            <span><?= $count_products ?? 0 ?></span>
                        </div>
                        <div class="summary">
                            <p>Productos sin stock</p>
                            <span><?= $count_out_stock_products ?? 0 ?></span>
                        </div>
                        <div class="summary">
                            <p>Productos con bajo inventario</p>
                            <span><?= $count_few_stock_products ?? 0 ?></span>
                        </div>
                        <div class="summary">
                            <p>Productos próximos a vencer</p>
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
                            type="text" id="searcher" placeholder="Buscar productos..." autocomplete="off"
                            onkeyup="busqueda();"
                        >

                        <span id="erase-search">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m456-320 104-104 104 104 56-56-104-104 104-104-56-56-104 104-104-104-56 56 104 104-104 104 56 56Zm-96 160q-19 0-36-8.5T296-192L80-480l216-288q11-15 28-23.5t36-8.5h440q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H360ZM180-480l180 240h440v-480H360L180-480Zm400 0Z"/></svg>
                        </span>

                        <button type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/></svg>
                        </button>
                    </div>
                </div>
            </div>


            <!-- LISTA DE REGISTROS -->
            <div class="crud-grid" id="products-container">

                <!-- R E G I S T R O S   D E S D E    J Q U E R Y -->

            </div>
        </div>

    </main>

    <?php require_once MATRIX_DOC_VIEWS . 'inventario/show_order_modal.php' ?>

    <?php require_once MATRIX_DOC_VIEWS . 'inventario/show_modal.php' ?>

    <!-- TOOLTIPS -->
    <script src="<?=MATRIX_HTTP_URL?>resources/js/tooltips.js"></script>

    <script src="<?= MATRIX_HTTP_URL ?>resources/js/inventory.js"></script>
</body>
</html>
