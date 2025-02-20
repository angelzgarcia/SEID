<?php require_once __DIR__ . '/../../config.php' ?>
<?php require_once __DIR__ . '/../../database.php' ?>
<?php require_once __DIR__ . '/../../functions/helpers/encrypt.php' ?>
<?php $page_name = ACCESO . 'Inventario' ?>
<?php
    $sql = '
        SELECT p.stock_producto, p.id_producto, v.*
        FROM productos AS p
        LEFT JOIN lotes_vencimientos AS v
        ON p.id_producto = v.id_producto_fk_lote_vencimiento
    ';
    $products = simpleQuery($sql) ?: [];

    if (!empty($products)) {
        $count_products = count($products);

        $count_out_stock_products = 0;
        array_map(function($product) use (&$count_out_stock_products) {
            if ((int)$product['stock_producto'] === 0)
                $count_out_stock_products++;
        }, $products);


        $count_few_stock_products = 0;
        array_map(function($product) use (&$count_few_stock_products) {
            if ((int)$product['stock_producto'] <= 50)
                $count_few_stock_products++;
        }, $products);


        $count_close_expiration_products = 0;
        $curr_date = new DateTime();
        $curr_day = (int) $curr_date -> format('d');
        $curr_month = (int) $curr_date -> format('m');

        foreach ($products as $product) {
            if (!empty($product['fecha_vencimiento'])) {
                $expired_date = DateTime::createFromFormat('Y-m-d', $product['fecha_vencimiento']);
                if ($expired_date) {
                    $expired_day = (int) $expired_date -> format('d');
                    $expired_month = (int) $expired_date -> format('m');

                    if ($expired_day <= $curr_day && $expired_month === $curr_month + 1)
                        $count_close_expiration_products++;
                }
            }
        }
    }
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
            <form action="" class="subsidiaries-filter">
                <input type="text" list="sucursales" name="sucursal_datalist" id="sucursal_datalist" placeholder="Buscar sucursal...">
                <datalist id="sucursales">
                    <option value="Sucursal 1">Sucursal 1</option>
                    <option value="Sucursal 2">Sucursal 2</option>
                    <option value="Sucursal 3">Sucursal 3</option>
                    <option value="Sucursal 3">Sucursal 3</option>
                    <option value="Sucursal 3">Sucursal 3</option>
                    <option value="Sucursal 3">Sucursal 3</option>
                    <option value="Sucursal 3">Sucursal 3</option>
                    <option value="Sucursal 3">Sucursal 3</option>
                    <option value="Sucursal 3">Sucursal 3</option>
                    <option value="Sucursal 3">Sucursal 3</option>
                    <option value="Sucursal 3">Sucursal 3</option>
                    <option value="Sucursal 3">Sucursal 3</option>
                    <option value="Sucursal 3">Sucursal 3</option>
                    <option value="Sucursal 3">Sucursal 3</option>
                    <option value="Sucursal 3">Sucursal 3</option>
                    <option value="Sucursal 3">Sucursal 3</option>
                    <option value="Sucursal 3">Sucursal 3</option>
                    <option value="Sucursal 3">Sucursal 3</option>
                    <option value="Sucursal 3">Sucursal 3</option>
                    <option value="Sucursal 3">Sucursal 3</option>
                    <option value="Sucursal 3">Sucursal 3</option>
                    <option value="Sucursal 3">Sucursal 3</option>
                </datalist>

                <select name="sucursal_select" class="crud-header-select sucursal-select">
                    <option disabled selected>Todas las sucursales</option>
                    <option value="">Sucursal 1 Sucursal 1Sucursal 1 Sucursal 1</option>
                    <option value="">Sucursal 2</option>
                    <option value="">Sucursal 3</option>
                    <option value="">Sucursal 3</option>
                    <option value="">Sucursal 3</option>
                    <option value="">Sucursal 3</option>
                    <option value="">Sucursal 3</option>
                    <option value="">Sucursal 3</option>
                    <option value="">Sucursal 3</option>
                    <option value="">Sucursal 3</option>
                    <option value="">Sucursal 3</option>
                    <option value="">Sucursal 3</option>
                    <option value="">Sucursal 3</option>
                    <option value="">Sucursal 3</option>
                    <option value="">Sucursal 3</option>
                    <option value="">Sucursal 3</option>
                    <option value="">Sucursal 3</option>
                    <option value="">Sucursal 3</option>
                    <option value="">Sucursal 3</option>
                    <option value="">Sucursal 3</option>
                    <option value="">Sucursal 3</option>
                    <option value="">Sucursal 3</option>
                    <option value="">Sucursal 3</option>
                    <option value="">Sucursal 3</option>
                    <option value="">Sucursal 3</option>
                    <option value="">Sucursal 3</option>
                    <option value="">Sucursal 3</option>
                    <option value="">Sucursal 3</option>
                    <option value="">Sucursal 3</option>
                    <option value="">Sucursal 3</option>
                    <option value="">Sucursal 3</option>
                    <option value="">Sucursal 3</option>
                    <option value="">Sucursal 3</option>
                    <option value="">Sucursal 3</option>
                </select>
            </form>

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

        <!-- CRUD -->
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
                        <select name="" class="crud-header-select">
                            <option selected disabled>Ordenar por</option>
                            <option value="">Ver todos</option>
                            <option value="">Menor stock</option>
                            <option value="">Mayor stock</option>
                            <option value="">Próximo a vencer</option>
                            <option value="">A - Z</option>
                            <option value="">Z - A</option>
                        </select>
                    </div>
                    <a href="<?= MATRIX_HTTP_VIEWS ?>inventario/create" class="crud-add-btn">
                        Añadir producto
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M440-120v-320H120v-80h320v-320h80v320h320v80H520v320h-80Z"/></svg>
                    </a>
                </div>

                <!-- HEADER INTERMEDIO -->
                <div class="crud-middle-header">
                    <div class="details">
                        <div class="summary">
                            <p>Total de productos</p>
                            <span><?= $count_products ?: 0 ?></span>
                        </div>
                        <div class="summary">
                            <p>Productos sin stock</p>
                            <span><?= $count_out_stock_products ?: 0 ?></span>
                        </div>
                        <div class="summary">
                            <p>Productos con bajo inventario</p>
                            <span><?= $count_few_stock_products ?: 0 ?></span>
                        </div>
                        <div class="summary">
                            <p>Productos próximos a vencer</p>
                            <span><?= $count_close_expiration_products ?: 0 ?></span>
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
                        <input type="text" id="searcher" placeholder="Buscar productos..." autocomplete="off" onkeyup="busqueda($('#searcher').val());">

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

    <script src="<?= MATRIX_HTTP_URL ?>resources/inventory.js"></script>
</body>
</html>
