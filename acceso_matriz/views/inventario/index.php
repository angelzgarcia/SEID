<?php require_once __DIR__ . '/../../config.php' ?>
<?php $page_name = ACCESO . 'Inventario' ?>

<!DOCTYPE html>
<html lang="en">
<?php require_once MATRIX_DOC_VIEWS . "modules/head.php" ?>
<body>

    <?php require_once MATRIX_DOC_VIEWS . "/modules/header.php" ?>

    <?php require_once MATRIX_DOC_VIEWS . "/modules/sidebar.php" ?>

    <main class="main-content matriz-content inventory-content">

        <!-- FILTRAR INVENTARIOS POR SUCURSAL -->
        <div class="searcher-links">
            <form action="" class="subsidiaries-filter flex w-full gap-5">
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

                <select name="sucursal_select" id="sucursal_select">
                    <option disabled selected>Todas las sucursales</option>
                    <option value="">Sucursal 1 Sucursal 1</option>
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
                        <h1>inventario</h1>
                        <p>Consulte y gestiones su invetario</p>
                    </div>
                    <div class="crud-order-by">
                        <select name="" id="">
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
            <div class="crud-grid">
                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link">
                        <div class="register-details">
                            <div class="header-register">
                                <p>Nombre del producto</p>
                                <span>Legendary WhitetailsLegendary</span>
                            </div>

                            <div class="body-register">
                                <img src="https://http2.mlstatic.com/D_NQ_NP_639610-MLM76545318391_052024-O.webp" alt="product-img">
                                <div class="quantities">
                                    <p>
                                        Costo por unidad
                                        <span>$227</span>
                                    </p>
                                    <p>
                                        Precio sugerido
                                        <span>$289</span>
                                    </p>
                                    <p>
                                        Unidades
                                        <span>116</span>
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
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link">
                        <div class="register-details">
                            <div class="header-register">
                                <p>Nombre del producto</p>
                                <span>WhitetailsLegendary</span>
                            </div>

                            <div class="body-register">
                                <img src="https://http2.mlstatic.com/D_NQ_NP_639610-MLM76545318391_052024-O.webp" alt="product-img">
                                <div class="quantities">
                                    <p>
                                        Costo por unidad
                                        <span>$227</span>
                                    </p>
                                    <p>
                                        Precio sugerido
                                        <span>$289</span>
                                    </p>
                                    <p>
                                        Unidades
                                        <span>116</span>
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
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link">
                        <div class="register-details">
                            <div class="header-register">
                                <p>Nombre del productoNombre del productoNombre del productoNombre del productoNombre del productoNombre del productoNombre del producto</p>
                                <span>Legendary WhitetailsLegendary WhitetailsLegendary WhitetailsLegendary WhitetailsLegendary WhitetailsLegendary WhitetailsLegendary WhitetailsLegendary Whitetails</span>
                            </div>

                            <div class="body-register">
                                <img src="https://http2.mlstatic.com/D_NQ_NP_639610-MLM76545318391_052024-O.webp" alt="product-img">
                                <div class="quantities">
                                    <p>
                                        Costo por unidad
                                        <span>$227</span>
                                    </p>
                                    <p>
                                        Precio sugerido
                                        <span>$289</span>
                                    </p>
                                    <p>
                                        Unidades
                                        <span>116</span>
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
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link">
                        <div class="register-details">
                            <div class="header-register">
                                <p>Nombre del producto</p>
                                <span>Legendary WhitetailsLegendary</span>
                            </div>

                            <div class="body-register">
                                <img src="https://http2.mlstatic.com/D_NQ_NP_639610-MLM76545318391_052024-O.webp" alt="product-img">
                                <div class="quantities">
                                    <p>
                                        Costo por unidad
                                        <span>$227</span>
                                    </p>
                                    <p>
                                        Precio sugerido
                                        <span>$289</span>
                                    </p>
                                    <p>
                                        Unidades
                                        <span>116</span>
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
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link">
                        <div class="register-details">
                            <div class="header-register">
                                <p>Nombre del producto</p>
                                <span>WhitetailsLegendary</span>
                            </div>

                            <div class="body-register">
                                <img src="https://http2.mlstatic.com/D_NQ_NP_639610-MLM76545318391_052024-O.webp" alt="product-img">
                                <div class="quantities">
                                    <p>
                                        Costo por unidad
                                        <span>$227</span>
                                    </p>
                                    <p>
                                        Precio sugerido
                                        <span>$289</span>
                                    </p>
                                    <p>
                                        Unidades
                                        <span>116</span>
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
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link">
                        <div class="register-details">
                            <div class="header-register">
                                <p>Nombre del productoNombre del productoNombre del productoNombre del productoNombre del productoNombre del productoNombre del producto</p>
                                <span>Legendary WhitetailsLegendary WhitetailsLegendary WhitetailsLegendary WhitetailsLegendary WhitetailsLegendary WhitetailsLegendary WhitetailsLegendary Whitetails</span>
                            </div>

                            <div class="body-register">
                                <img src="https://http2.mlstatic.com/D_NQ_NP_639610-MLM76545318391_052024-O.webp" alt="product-img">
                                <div class="quantities">
                                    <p>
                                        Costo por unidad
                                        <span>$227</span>
                                    </p>
                                    <p>
                                        Precio sugerido
                                        <span>$289</span>
                                    </p>
                                    <p>
                                        Unidades
                                        <span>116</span>
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
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link">
                        <div class="register-details">
                            <div class="header-register">
                                <p>Nombre del producto</p>
                                <span>Legendary WhitetailsLegendary</span>
                            </div>

                            <div class="body-register">
                                <img src="https://http2.mlstatic.com/D_NQ_NP_639610-MLM76545318391_052024-O.webp" alt="product-img">
                                <div class="quantities">
                                    <p>
                                        Costo por unidad
                                        <span>$227</span>
                                    </p>
                                    <p>
                                        Precio sugerido
                                        <span>$289</span>
                                    </p>
                                    <p>
                                        Unidades
                                        <span>116</span>
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
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link">
                        <div class="register-details">
                            <div class="header-register">
                                <p>Nombre del producto</p>
                                <span>WhitetailsLegendary</span>
                            </div>

                            <div class="body-register">
                                <img src="https://http2.mlstatic.com/D_NQ_NP_639610-MLM76545318391_052024-O.webp" alt="product-img">
                                <div class="quantities">
                                    <p>
                                        Costo por unidad
                                        <span>$227</span>
                                    </p>
                                    <p>
                                        Precio sugerido
                                        <span>$289</span>
                                    </p>
                                    <p>
                                        Unidades
                                        <span>116</span>
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
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link">
                        <div class="register-details">
                            <div class="header-register">
                                <p>Nombre del productoNombre del productoNombre del productoNombre del productoNombre del productoNombre del productoNombre del producto</p>
                                <span>Legendary WhitetailsLegendary WhitetailsLegendary WhitetailsLegendary WhitetailsLegendary WhitetailsLegendary WhitetailsLegendary WhitetailsLegendary Whitetails</span>
                            </div>

                            <div class="body-register">
                                <img src="https://http2.mlstatic.com/D_NQ_NP_639610-MLM76545318391_052024-O.webp" alt="product-img">
                                <div class="quantities">
                                    <p>
                                        Costo por unidad
                                        <span>$227</span>
                                    </p>
                                    <p>
                                        Precio sugerido
                                        <span>$289</span>
                                    </p>
                                    <p>
                                        Unidades
                                        <span>116</span>
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
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </main>

</body>
</html>
