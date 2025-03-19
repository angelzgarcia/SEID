<?php require_once __DIR__ . '/../../../config.php' ?>
<?php require_once MATRIX_DOC_ROOT . 'database.php' ?>
<?php require_once MATRIX_DOC_ROOT . 'functions/helpers/encrypt.php' ?>
<?php require_once MATRIX_DOC_ROOT . 'functions/helpers/swal.php' ?>

<?php $page_name = ACCESO . 'Inventario | Categorias ' ?>

<?php
    $sql = '
        SELECT COUNT(*) AS total_categorias,
        SUM(CASE WHEN status_categoria = 0 THEN 1 ELSE 0 END) AS categorias_activas
        FROM categorias
    ';

    $categories_collector = simpleQuery($sql)[0] ?? ['total_categorias' => 0, 'categorias_activas' => 0];

    $count_categories = $categories_collector['total_categorias'];
    $count_enable_categories = $categories_collector['categorias_activas'];
    $count_disable_categories = $count_categories - $count_enable_categories;
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
                    <!-- ACCESOS DIRECTOS -->
                    <div class="crud-tittle">
                        <div class="title-shortcut-inventory">
                            <h1>
                                Categorías
                                <a class="shortcut-link-btn <?= strpos($_SERVER['PHP_SELF'], 'categorias/index') ? 'active' : '' ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#111"><path d="m260-520 220-360 220 360H260ZM700-80q-75 0-127.5-52.5T520-260q0-75 52.5-127.5T700-440q75 0 127.5 52.5T880-260q0 75-52.5 127.5T700-80Zm-580-20v-320h320v320H120Zm580-60q42 0 71-29t29-71q0-42-29-71t-71-29q-42 0-71 29t-29 71q0 42 29 71t71 29Zm-500-20h160v-160H200v160Zm202-420h156l-78-126-78 126Zm78 0ZM360-340Zm340 80Z"/></svg>
                                </a>
                            </h1>

                            <svg xmlns="http://www.w3.org/2000/svg" height="25px" viewBox="0 -960 960 960" width="25px" fill="#111111c2"><path d="M480-120q-75 0-140.5-28.5t-114-77q-48.5-48.5-77-114T120-480q0-75 28.5-140.5t77-114q48.5-48.5 114-77T480-840v80q-117 0-198.5 81.5T200-480q0 117 81.5 198.5T480-200v80Zm160-160-56-57 103-103H360v-80h327L584-624l56-56 200 200-200 200Z"/></svg>

                            <a href="../index" title="Inventario" class="shortcut-link-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M440-183v-274L200-596v274l240 139Zm80 0 240-139v-274L520-457v274Zm-80 92L160-252q-19-11-29.5-29T120-321v-318q0-22 10.5-40t29.5-29l280-161q19-11 40-11t40 11l280 161q19 11 29.5 29t10.5 40v318q0 22-10.5 40T800-252L520-91q-19 11-40 11t-40-11Zm200-528 77-44-237-137-78 45 238 136Zm-160 93 78-45-237-137-78 45 237 137Z"/></svg>
                            </a>
                        </div>
                        <p>Consulte y gestione las categorias de los productos</p>
                    </div>

                    <div class="crud-order-by">
                        <select name="order-by-categories" class="crud-header-select" id="order-by-categories">
                            <option selected disabled>Ordenar por</option>
                            <option value="recientes">Más recientes</option>
                            <option value="antiguas">Más antiguas</option>
                            <option value="az">A - Z</option>
                            <option value="za">Z - A</option>
                        </select>
                    </div>
                    <a href="<?= MATRIX_HTTP_VIEWS ?>inventario/categorias/create" class="crud-add-btn">
                        Añadir categoría
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M440-120v-320H120v-80h320v-320h80v320h320v80H520v320h-80Z"/></svg>
                    </a>
                </div>

                <!-- HEADER INTERMEDIO -->
                <div class="crud-middle-header">
                    <div class="details">
                        <div class="summary">
                            <p>N° de categorías</p>
                            <span><?= $count_categories ?? 0 ?></span>
                        </div>
                    </div>

                    <div class="details">
                        <div class="summary">
                            <p>Categorías activas</p>
                            <span><?= $count_enable_categories ?? 0 ?></span>
                        </div>
                    </div>

                    <div class="details">
                        <div class="summary">
                            <p>Categorías inactivas</p>
                            <span><?= $count_disable_categories ?? 0 ?></span>
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
                            type="text" id="searcher" placeholder="Buscar categoria..." autocomplete="off"
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
            <div class="crud-grid crud-grid-category" id="categories-container">

                    <!--  REGISTROS DESDE JQUERY  -->

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
    ?>

    <?php require_once MATRIX_DOC_VIEWS . 'inventario/categorias/show_modal.php' ?>

    <!-- TOOLTIPS -->
    <script src="<?=MATRIX_HTTP_URL?>resources/js/tooltips.js"></script>

    <script src="<?= MATRIX_HTTP_URL ?>resources/js/categories.js"></script>
</body>
</html>
