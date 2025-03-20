<?php require_once __DIR__ . '/../../../config.php' ?>
<?php require_once MATRIX_DOC_ROOT . 'database.php' ?>
<?php require_once MATRIX_DOC_ROOT . 'functions/helpers/encrypt.php' ?>
<?php require_once MATRIX_DOC_ROOT . 'functions/helpers/swal.php' ?>

<?php $page_name = ACCESO . 'Inventario | Marcas ' ?>

<?php
    $sql = '
        SELECT COUNT(*) AS total_marcas,
        SUM(CASE WHEN status_marca = 0 THEN 1 ELSE 0 END) AS marcas_activas
        FROM marcas
    ';

    $brands_collector = simpleQuery($sql)[0] ?? ['total_marcas' => 0, 'marcas_activas' => 0];

    $count_brands = $brands_collector['total_marcas'];
    $count_enable_brands = $brands_collector['marcas_activas'];
    $count_disable_brands = $count_brands - $count_enable_brands;
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once MATRIX_DOC_VIEWS . "modules/head.php" ?>
<body>

    <?php require_once MATRIX_DOC_VIEWS . "/modules/header.php" ?>

    <?php require_once MATRIX_DOC_VIEWS . "/modules/sidebar.php" ?>

    <main class="main-content matriz-content inventory-content">
        <!-- CRUD -->
        <div class="crud-container">
            <!-- CRUD HEADER -->
            <div class="crud-header">
                <!-- HEADER SUPERIOR -->
                <div class="crud-top-header">
                    <div class="crud-tittle">
                        <div class="title-shortcut-inventory">
                            <h1>
                                Marcas
                                <a class="shortcut-link-btn <?= strpos($_SERVER['PHP_SELF'], 'marcas/index') ? 'active' : '' ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M864-40 741-162q-18 11-38.5 16.5T660-140q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 23-6 43.5T797-218L920-96l-56 56ZM220-140q-66 0-113-47T60-300q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm0-80q33 0 56.5-23.5T300-300q0-33-23.5-56.5T220-380q-33 0-56.5 23.5T140-300q0 33 23.5 56.5T220-220Zm440 0q33 0 56.5-23.5T740-300q0-33-23.5-56.5T660-380q-33 0-56.5 23.5T580-300q0 33 23.5 56.5T660-220ZM220-580q-66 0-113-47T60-740q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm440 0q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm-440-80q33 0 56.5-23.5T300-740q0-33-23.5-56.5T220-820q-33 0-56.5 23.5T140-740q0 33 23.5 56.5T220-660Zm440 0q33 0 56.5-23.5T740-740q0-33-23.5-56.5T660-820q-33 0-56.5 23.5T580-740q0 33 23.5 56.5T660-660ZM220-300Zm0-440Zm440 0Z"/></svg>
                                </a>
                            </h1>

                            <svg xmlns="http://www.w3.org/2000/svg" height="25px" viewBox="0 -960 960 960" width="25px" fill="#111111c2"><path d="M480-120q-75 0-140.5-28.5t-114-77q-48.5-48.5-77-114T120-480q0-75 28.5-140.5t77-114q48.5-48.5 114-77T480-840v80q-117 0-198.5 81.5T200-480q0 117 81.5 198.5T480-200v80Zm160-160-56-57 103-103H360v-80h327L584-624l56-56 200 200-200 200Z"/></svg>

                            <a href="../index" title="Inventario" class="shortcut-link-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M440-183v-274L200-596v274l240 139Zm80 0 240-139v-274L520-457v274Zm-80 92L160-252q-19-11-29.5-29T120-321v-318q0-22 10.5-40t29.5-29l280-161q19-11 40-11t40 11l280 161q19 11 29.5 29t10.5 40v318q0 22-10.5 40T800-252L520-91q-19 11-40 11t-40-11Zm200-528 77-44-237-137-78 45 238 136Zm-160 93 78-45-237-137-78 45 237 137Z"/></svg>
                            </a>
                        </div>
                        <p>Consulte y gestione las marcas de los productos</p>
                    </div>

                    <div class="crud-order-by">
                        <select name="order-by-brands" class="crud-header-select" id="order-by-brands">
                            <option selected disabled>Ordenar por</option>
                            <option value="">Ver todos</option>
                            <option value="">A - Z</option>
                            <option value="">Z - A</option>
                        </select>
                    </div>
                    <a href="<?= MATRIX_HTTP_VIEWS ?>inventario/marcas/create" class="crud-add-btn">
                        Añadir marca
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M440-120v-320H120v-80h320v-320h80v320h320v80H520v320h-80Z"/></svg>
                    </a>
                </div>

                <!-- HEADER INTERMEDIO -->
                <div class="crud-middle-header">
                    <div class="details">
                        <div class="summary">
                            <p>N° de marca</p>
                            <span><?= $count_brands ?? 0 ?></span>
                        </div>
                    </div>

                    <div class="details">
                        <div class="summary">
                            <p>Marcas activas</p>
                            <span><?= $count_enable_brands ?? 0 ?></span>
                        </div>
                    </div>

                    <div class="details">
                        <div class="summary">
                            <p>Marcas inactivas</p>
                            <span><?= $count_disable_brands ?? 0 ?></span>
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
                            type="text" id="searcher" placeholder="Buscar marca..." autocomplete="off"
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
            <div class="crud-grid crud-grid-category" id="brands-container">

                <!-- SE INCRUSTAN LOS REGISTROS CON JQUERY -->

            </div>
        </div>
    </main>

    <!-- CAMBIAR STATUS -->
    <?= swal('question', '¿Estás seguro de realizar esta acción?', 'confirm_status') ?>

    <?php
        if (isset($_SESSION['swal'])) {
            echo $_SESSION['swal'];
            unset($_SESSION['swal']);
        }

        unset($_SESSION['olds']);
        unset($_SESSION['errors']);
    ?>

    <?php require_once MATRIX_DOC_VIEWS . 'inventario/marcas/show_modal.php' ?>

    <script src="<?=MATRIX_HTTP_URL?>resources/js/tooltips.js"></script>

    <script src="<?= MATRIX_HTTP_URL ?>resources/js/brands.js"></script>
</body>
</html>
