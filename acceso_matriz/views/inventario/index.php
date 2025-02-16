<?php require_once __DIR__ . '/../../config.php' ?>
<?php require_once __DIR__ . '/../../database.php' ?>
<?php $page_name = ACCESO . 'Inventario' ?>
<?php
    $sql = 'SELECT * FROM productos ';
    $query = $conn -> query($sql);
    $productos = $query -> fetch_all(MYSQLI_ASSOC) ?: [];


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
                            <span>122</span>
                        </div>
                        <div class="summary">
                            <p>Productos sin stock</p>
                            <span>15</span>
                        </div>
                        <div class="summary">
                            <p>Productos con bajo inventario</p>
                            <span>38</span>
                        </div>
                        <div class="summary">
                            <p>Productos próximos a vencer</p>
                            <span>7</span>
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
                        <input type="text" name="" id="" placeholder="Buscar producto.....">
                        <button type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/></svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- LISTA DE REGISTROS -->
            <div class="crud-grid">

                <?php if (empty($productos)): ?>
                    <div class="registers-empty">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M40.1 467.1l-11.2 9c-3.2 2.5-7.1 3.9-11.1 3.9C8 480 0 472 0 462.2L0 192C0 86 86 0 192 0S384 86 384 192l0 270.2c0 9.8-8 17.8-17.8 17.8c-4 0-7.9-1.4-11.1-3.9l-11.2-9c-13.4-10.7-32.8-9-44.1 3.9L269.3 506c-3.3 3.8-8.2 6-13.3 6s-9.9-2.2-13.3-6l-26.6-30.5c-12.7-14.6-35.4-14.6-48.2 0L141.3 506c-3.3 3.8-8.2 6-13.3 6s-9.9-2.2-13.3-6L84.2 471c-11.3-12.9-30.7-14.6-44.1-3.9zM160 192a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm96 32a32 32 0 1 0 0-64 32 32 0 1 0 0 64z"/></svg>
                        <p>AÚN NO HAY PRODUCTOS REGISTRADOS.</p>
                    </div>
                <?php else: ?>
                    <?php foreach($productos as $producto): ?>
                        <!-- MARCO DEL REGISTRO -->
                        <div class="register-frame">
                            <!-- DETALLES -->
                            <a href="" class="register-details-link">
                                <div class="register-details">
                                    <div class="header-register">
                                        <p><?= $producto['nombre_producto'] ?></p>
                                        <span><?= $producto['marca_producto'] ?? '' ?></span>
                                        <span><?= $producto['categoria_producto'] ?? '' ?></span>
                                    </div>

                                    <div class="body-register">
                                        <!-- <img src="https://http2.mlstatic.com/D_NQ_NP_639610-MLM76545318391_052024-O.webp" alt="product-img"> -->
                                        <img src="<?= HTTP_URL . 'storage/imgs/uploads/' . $producto['imagen_producto'] ?>" alt="product-img">
                                        <div class="quantities">
                                            <p>
                                                <?=
                                                    match($producto['tipo_venta_producto']) {
                                                        'unidad' => 'Costo por unidad',
                                                        'granel' => 'Costo a granel',
                                                        'paquete' => 'Costo por paquete',
                                                    };
                                                ?>
                                                <span>$<?= $producto['precio_costo_producto'] ?></span>
                                            </p>
                                            <p>
                                                Precio sugerido
                                                <span>$<?= $producto['precio_venta_producto'] ?></span>
                                            </p>
                                            <p>
                                                Unidades
                                                <span><?= $producto['stock_producto'] ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <!-- ACCIONES -->
                            <div class="register-actions">
                                <a href="">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-120v-170l527-526q12-12 27-18t30-6q16 0 30.5 6t25.5 18l56 56q12 11 18 25.5t6 30.5q0 15-6 30t-18 27L330-120H160Zm80-80h56l393-392-28-29-29-28-392 393v56Zm560-503-57-57 57 57Zm-139 82-29-28 57 57-28-29ZM560-120q74 0 137-37t63-103q0-36-19-62t-51-45l-59 59q23 10 36 22t13 26q0 23-36.5 41.5T560-200q-17 0-28.5 11.5T520-160q0 17 11.5 28.5T560-120ZM183-426l60-60q-20-8-31.5-16.5T200-520q0-12 18-24t76-37q88-38 117-69t29-70q0-55-44-87.5T280-840q-45 0-80.5 16T145-785q-11 13-9 29t15 26q13 11 29 9t27-13q14-14 31-20t42-6q41 0 60.5 12t19.5 28q0 14-17.5 25.5T262-654q-80 35-111 63.5T120-520q0 32 17 54.5t46 39.5Z"/></svg>
                                </a>
                                <form action="" class="destroy-btn">
                                    <button type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-240q-100 0-170-70T40-480q0-100 70-170t170-70h400q100 0 170 70t70 170q0 100-70 170t-170 70H280Zm0-80h400q66 0 113-47t47-113q0-66-47-113t-113-47H280q-66 0-113 47t-47 113q0 66 47 113t113 47Zm0-40q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35Zm200-120Z"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

            </div>
        </div>
    </main>

</body>
</html>
