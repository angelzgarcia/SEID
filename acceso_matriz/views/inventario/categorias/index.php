<?php require_once __DIR__ . '/../../../config.php' ?>
<?php require_once MATRIX_DOC_ROOT . 'database.php' ?>
<?php require_once MATRIX_DOC_ROOT . 'functions/helpers/encrypt.php' ?>
<?php require_once MATRIX_DOC_ROOT . 'functions/helpers/swal.php' ?>

<?php $page_name = ACCESO . 'Inventario | Categorias ' ?>
<?php
    $sql = 'SELECT * FROM categorias';
    $consulta = $conn -> query($sql);

    $categorias = $consulta -> fetch_all(MYSQLI_ASSOC) ?: [];

    if (!empty($categorias)) {
        $count_categorias = count($categorias);

        $categorias_activas = array_filter($categorias, fn($categoria) => (int)$categoria['status_categoria'] === 0 );
        $count_categorias_activas = count($categorias_activas);

        $count_categorias_inactivas = $count_categorias - $count_categorias_activas;
    }
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
                        <select name="" id="">
                            <option selected disabled>Ordenar por</option>
                            <option value="">Ver todos</option>
                            <option value="">A - Z</option>
                            <option value="">Z - A</option>
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
                            <span><?= $count_categorias ?></span>
                        </div>
                    </div>

                    <div class="details">
                        <div class="summary">
                            <p>Categorías activas</p>
                            <span><?= $count_categorias_activas ?></span>
                        </div>
                    </div>

                    <div class="details">
                        <div class="summary">
                            <p>Categorías inactivas</p>
                            <span><?= $count_categorias_inactivas?></span>
                        </div>
                    </div>
                </div>

                <!-- HEADER INFERIOR -->
                <div class="crud-bottom-header">
                    <form action="" class="delete-all-form">
                        <input type="checkbox" name="" id="">
                        <p>Seleccionar todo</p>

                        <select name="" id="">
                            <option value="">Acciones</option>
                            <option value="">Eliminar registros</option>
                        </select>
                    </form>

                    <form action="" class="crud-searcher">
                        <input type="text" name="" id="" placeholder="Buscar producto.....">
                        <button type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/></svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- LISTA DE REGISTROS -->
            <div class="crud-grid crud-grid-category">

                <?php if(empty($categorias)): ?>
                    <div class="registers-empty">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M40.1 467.1l-11.2 9c-3.2 2.5-7.1 3.9-11.1 3.9C8 480 0 472 0 462.2L0 192C0 86 86 0 192 0S384 86 384 192l0 270.2c0 9.8-8 17.8-17.8 17.8c-4 0-7.9-1.4-11.1-3.9l-11.2-9c-13.4-10.7-32.8-9-44.1 3.9L269.3 506c-3.3 3.8-8.2 6-13.3 6s-9.9-2.2-13.3-6l-26.6-30.5c-12.7-14.6-35.4-14.6-48.2 0L141.3 506c-3.3 3.8-8.2 6-13.3 6s-9.9-2.2-13.3-6L84.2 471c-11.3-12.9-30.7-14.6-44.1-3.9zM160 192a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm96 32a32 32 0 1 0 0-64 32 32 0 1 0 0 64z"/></svg>
                        <p>AÚN NO HAY CATEGORÍAS REGISTRADAS.</p>
                    </div>
                <?php else: ?>
                    <?php foreach($categorias as $categoria): ?>
                        <!-- MARCO DEL REGISTRO -->
                        <div class="register-frame category-frame">
                            <!-- DETALLES -->
                            <div href="" class="register-details-link category-details-link">
                                <p>
                                    Nombre:
                                    <span><?= ucfirst($categoria['nombre_categoria']) ?></span>
                                </p>
                                <p>
                                    Descripción:
                                    <span><?= ucfirst($categoria['descripcion_categoria']) ?></span>
                                </p>
                                <p>
                                    Status:
                                    <span><?= (int)$categoria['status_categoria'] === 0 ? 'Activa' : 'Inactiva'; ?></span>
                                </p>
                            </div>

                            <?php $c = encryptValue($categoria['id_categoria'], SECRETKEY) ?>
                            <?php $status = (int)$categoria['status_categoria'] ?>

                            <!-- ACCIONES -->
                            <div class="register-actions">
                                <a href="./edit?c=<?=$c?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-120v-170l527-526q12-12 27-18t30-6q16 0 30.5 6t25.5 18l56 56q12 11 18 25.5t6 30.5q0 15-6 30t-18 27L330-120H160Zm80-80h56l393-392-28-29-29-28-392 393v56Zm560-503-57-57 57 57Zm-139 82-29-28 57 57-28-29ZM560-120q74 0 137-37t63-103q0-36-19-62t-51-45l-59 59q23 10 36 22t13 26q0 23-36.5 41.5T560-200q-17 0-28.5 11.5T520-160q0 17 11.5 28.5T560-120ZM183-426l60-60q-20-8-31.5-16.5T200-520q0-12 18-24t76-37q88-38 117-69t29-70q0-55-44-87.5T280-840q-45 0-80.5 16T145-785q-11 13-9 29t15 26q13 11 29 9t27-13q14-14 31-20t42-6q41 0 60.5 12t19.5 28q0 14-17.5 25.5T262-654q-80 35-111 63.5T120-520q0 32 17 54.5t46 39.5Z"/></svg>
                                </a>

                                <form action="<?= MATRIX_HTTP_URL ?>functions/crud_categoria?c=<?=$c?>" class="status-btn <?= $status === 0 ? 'inactive-btn' : 'active-btn' ?>" data-id="<?=$c?>" method="POST">
                                    <input type="hidden" name="accion" value="modificar">

                                    <button type="button" title="Cambiar status">
                                        <?php if( $status === 0): ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-240q-100 0-170-70T40-480q0-100 70-170t170-70h400q100 0 170 70t70 170q0 100-70 170t-170 70H280Zm0-80h400q66 0 113-47t47-113q0-66-47-113t-113-47H280q-66 0-113 47t-47 113q0 66 47 113t113 47Zm0-40q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35Zm200-120Z"/></svg>
                                        <?php else: ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-240q-100 0-170-70T40-480q0-100 70-170t170-70h400q100 0 170 70t70 170q0 100-70 170t-170 70H280Zm0-80h400q66 0 113-47t47-113q0-66-47-113t-113-47H280q-66 0-113 47t-47 113q0 66 47 113t113 47Zm400-40q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35ZM480-480Z"/></svg>
                                        <?php endif; ?>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <!-- CAMBIAR STATUS -->
                <?= swal('question', '¿Estás seguro de realizar esta acción?', 'confirm_status') ?>

                <?php
                    if (isset($_SESSION['swal'])) {
                        echo $_SESSION['swal'];
                        unset($_SESSION['swal']);
                    }
                ?>
            </div>
        </div>
    </main>

</body>
</html>
