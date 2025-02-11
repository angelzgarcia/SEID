<?php require_once __DIR__ . '/../../../config.php' ?>
<?php $page_name = ACCESO . 'Inventario' ?>

<!DOCTYPE html>
<html lang="en">
<?php require_once MATRIX_DOC_VIEWS . "modules/head.php" ?>
<body>

    <?php require_once MATRIX_DOC_VIEWS . "/modules/header.php" ?>

    <?php require_once MATRIX_DOC_VIEWS . "/modules/sidebar.php" ?>

    <main class="main-content matriz-content inventory-content">

        <!-- FILTRAR PEDIDOS POR SUCURSAL -->
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

        <!-- CRUD -->
        <div class="crud-container branches-orders-container">
            <!-- CRUD HEADER -->
            <div class="crud-header">
                <!-- HEADER SUPERIOR -->
                <div class="crud-top-header">
                    <div class="crud-tittle">
                        <h1>Pedidos</h1>
                        <p>Consulte y gestiones pedidos de reabastecimiento de cada sucursal</p>
                    </div>

                    <div class="crud-order-by">
                        <select name="" id="">
                            <option selected disabled>Ordenar por</option>
                            <option value="">Todos</option>
                            <option value="">Más recientes</option>
                            <option value="">Aprobados</option>
                            <option value="">Rechazados</option>
                        </select>
                    </div>
                </div>

                <!-- HEADER INTERMEDIO -->
                <div class="crud-middle-header">
                    <div class="details">
                        <div class="summary">
                            <p>N° pedidos</p>
                            <span>519</span>
                        </div>
                        <div class="summary">
                            <p>En espera</p>
                            <span>7</span>
                        </div>
                        <div class="summary">
                            <p>Rechazados</p>
                            <span>19</span>
                        </div>
                        <div class="summary">
                            <p>Aprobados</p>
                            <span><?=519-19-7?></span>
                        </div>
                    </div>
                </div>

                <!-- HEADER INFERIOR -->
                <div class="crud-bottom-header !justify-end">
                    <form action="" class="crud-searcher">
                        <input type="text" name="" id="" placeholder="Buscar sucursal.....">
                        <button type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/></svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- GUIA DE COLORES STATUS DE PEDIDOS -->
            <div class="status-colors">
                <div class="status order-received">
                    <div class="status-circle order-received-circle"><div></div></div>
                    <p>En espera</p>
                </div>

                <div class="status order-rejected">
                    <div class="status-circle order-rejected-circle"><div></div></div>
                    <p>Rechazados</p>
                </div>

                <div class="status order-aproved">
                    <div class="status-circle order-aproved-circle"><div></div></div>
                    <p>Aprovados</p>
                </div>
            </div>

            <!-- LISTA DE REGISTROS -->
            <div class="crud-grid orders-crud">

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame order-frame recived-order-frame">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link">
                        <div class="register-details h-full">
                            <div class="header-register">
                                <p>Nombre de la sucursal</p>
                                <span><?= $fecha ?></span>
                            </div>

                            <div class="text-start w-full">
                                Detalles del pedido:
                            </div>

                            <div class="body-register">
                                <div class="quantities">
                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>

                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>

                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>

                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- ACCIONES -->
                    <div class="register-actions">
                        <form action="" class="aproved-btn">
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M268-240 42-466l57-56 170 170 56 56-57 56Zm226 0L268-466l56-57 170 170 368-368 56 57-424 424Zm0-226-57-56 198-198 57 56-198 198Z"/></svg>
                            </button>
                        </form>

                        <a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-120v-170l527-526q12-12 27-18t30-6q16 0 30.5 6t25.5 18l56 56q12 11 18 25.5t6 30.5q0 15-6 30t-18 27L330-120H160Zm80-80h56l393-392-28-29-29-28-392 393v56Zm560-503-57-57 57 57Zm-139 82-29-28 57 57-28-29ZM560-120q74 0 137-37t63-103q0-36-19-62t-51-45l-59 59q23 10 36 22t13 26q0 23-36.5 41.5T560-200q-17 0-28.5 11.5T520-160q0 17 11.5 28.5T560-120ZM183-426l60-60q-20-8-31.5-16.5T200-520q0-12 18-24t76-37q88-38 117-69t29-70q0-55-44-87.5T280-840q-45 0-80.5 16T145-785q-11 13-9 29t15 26q13 11 29 9t27-13q14-14 31-20t42-6q41 0 60.5 12t19.5 28q0 14-17.5 25.5T262-654q-80 35-111 63.5T120-520q0 32 17 54.5t46 39.5Z"/></svg>
                        </a>

                        <form action="" class="destroy-btn">
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M873-88 609-352 495-238 269-464l56-58 170 170 56-56-414-414 56-58 736 736-56 56ZM269-238 43-464l56-56 170 170 56 56-56 56Zm452-226-56-56 196-196 58 54-198 198ZM607-578l-56-56 86-86 56 56-86 86Z"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame order-frame rejected-order-frame">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link">
                        <div class="register-details h-full">
                            <div class="header-register">
                                <p>Nombre de la sucursal</p>
                                <span><?= $fecha ?></span>
                            </div>

                            <div class="text-start w-full">
                                Detalles del pedido:
                            </div>

                            <div class="body-register">
                                <div class="quantities">
                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>

                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>

                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- ACCIONES -->
                    <div class="register-actions">
                        <form action="" class="aproved-btn">
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M268-240 42-466l57-56 170 170 56 56-57 56Zm226 0L268-466l56-57 170 170 368-368 56 57-424 424Zm0-226-57-56 198-198 57 56-198 198Z"/></svg>
                            </button>
                        </form>

                        <a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-120v-170l527-526q12-12 27-18t30-6q16 0 30.5 6t25.5 18l56 56q12 11 18 25.5t6 30.5q0 15-6 30t-18 27L330-120H160Zm80-80h56l393-392-28-29-29-28-392 393v56Zm560-503-57-57 57 57Zm-139 82-29-28 57 57-28-29ZM560-120q74 0 137-37t63-103q0-36-19-62t-51-45l-59 59q23 10 36 22t13 26q0 23-36.5 41.5T560-200q-17 0-28.5 11.5T520-160q0 17 11.5 28.5T560-120ZM183-426l60-60q-20-8-31.5-16.5T200-520q0-12 18-24t76-37q88-38 117-69t29-70q0-55-44-87.5T280-840q-45 0-80.5 16T145-785q-11 13-9 29t15 26q13 11 29 9t27-13q14-14 31-20t42-6q41 0 60.5 12t19.5 28q0 14-17.5 25.5T262-654q-80 35-111 63.5T120-520q0 32 17 54.5t46 39.5Z"/></svg>
                        </a>

                        <form action="" class="destroy-btn">
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M873-88 609-352 495-238 269-464l56-58 170 170 56-56-414-414 56-58 736 736-56 56ZM269-238 43-464l56-56 170 170 56 56-56 56Zm452-226-56-56 196-196 58 54-198 198ZM607-578l-56-56 86-86 56 56-86 86Z"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame order-frame recived-order-frame">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link">
                        <div class="register-details h-full">
                            <div class="header-register">
                                <p>Nombre de la sucursal</p>
                                <span><?= $fecha ?></span>
                            </div>

                            <div class="text-start w-full">
                                Detalles del pedido:
                            </div>

                            <div class="body-register">
                                <div class="quantities">
                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>
                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>
                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>
                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>
                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- ACCIONES -->
                    <div class="register-actions">
                        <form action="" class="aproved-btn">
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M268-240 42-466l57-56 170 170 56 56-57 56Zm226 0L268-466l56-57 170 170 368-368 56 57-424 424Zm0-226-57-56 198-198 57 56-198 198Z"/></svg>
                            </button>
                        </form>

                        <a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-120v-170l527-526q12-12 27-18t30-6q16 0 30.5 6t25.5 18l56 56q12 11 18 25.5t6 30.5q0 15-6 30t-18 27L330-120H160Zm80-80h56l393-392-28-29-29-28-392 393v56Zm560-503-57-57 57 57Zm-139 82-29-28 57 57-28-29ZM560-120q74 0 137-37t63-103q0-36-19-62t-51-45l-59 59q23 10 36 22t13 26q0 23-36.5 41.5T560-200q-17 0-28.5 11.5T520-160q0 17 11.5 28.5T560-120ZM183-426l60-60q-20-8-31.5-16.5T200-520q0-12 18-24t76-37q88-38 117-69t29-70q0-55-44-87.5T280-840q-45 0-80.5 16T145-785q-11 13-9 29t15 26q13 11 29 9t27-13q14-14 31-20t42-6q41 0 60.5 12t19.5 28q0 14-17.5 25.5T262-654q-80 35-111 63.5T120-520q0 32 17 54.5t46 39.5Z"/></svg>
                        </a>

                        <form action="" class="destroy-btn">
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M873-88 609-352 495-238 269-464l56-58 170 170 56-56-414-414 56-58 736 736-56 56ZM269-238 43-464l56-56 170 170 56 56-56 56Zm452-226-56-56 196-196 58 54-198 198ZM607-578l-56-56 86-86 56 56-86 86Z"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame order-frame aproved-order-frame">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link">
                        <div class="register-details h-full">
                            <div class="header-register">
                                <p>Nombre de la sucursal</p>
                                <span><?= $fecha ?></span>
                            </div>

                            <div class="text-start w-full">
                                Detalles del pedido:
                            </div>

                            <div class="body-register">
                                <div class="quantities">
                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>

                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- ACCIONES -->
                    <div class="register-actions">
                        <form action="" class="aproved-btn">
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M268-240 42-466l57-56 170 170 56 56-57 56Zm226 0L268-466l56-57 170 170 368-368 56 57-424 424Zm0-226-57-56 198-198 57 56-198 198Z"/></svg>
                            </button>
                        </form>

                        <a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-120v-170l527-526q12-12 27-18t30-6q16 0 30.5 6t25.5 18l56 56q12 11 18 25.5t6 30.5q0 15-6 30t-18 27L330-120H160Zm80-80h56l393-392-28-29-29-28-392 393v56Zm560-503-57-57 57 57Zm-139 82-29-28 57 57-28-29ZM560-120q74 0 137-37t63-103q0-36-19-62t-51-45l-59 59q23 10 36 22t13 26q0 23-36.5 41.5T560-200q-17 0-28.5 11.5T520-160q0 17 11.5 28.5T560-120ZM183-426l60-60q-20-8-31.5-16.5T200-520q0-12 18-24t76-37q88-38 117-69t29-70q0-55-44-87.5T280-840q-45 0-80.5 16T145-785q-11 13-9 29t15 26q13 11 29 9t27-13q14-14 31-20t42-6q41 0 60.5 12t19.5 28q0 14-17.5 25.5T262-654q-80 35-111 63.5T120-520q0 32 17 54.5t46 39.5Z"/></svg>
                        </a>

                        <form action="" class="destroy-btn">
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M873-88 609-352 495-238 269-464l56-58 170 170 56-56-414-414 56-58 736 736-56 56ZM269-238 43-464l56-56 170 170 56 56-56 56Zm452-226-56-56 196-196 58 54-198 198ZM607-578l-56-56 86-86 56 56-86 86Z"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame order-frame aproved-order-frame">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link">
                        <div class="register-details h-full">
                            <div class="header-register">
                                <p>Nombre de la sucursal</p>
                                <span><?= $fecha ?></span>
                            </div>

                            <div class="text-start w-full">
                                Detalles del pedido:
                            </div>

                            <div class="body-register">
                                <div class="quantities">
                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>

                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>
                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>
                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>
                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>
                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- ACCIONES -->
                    <div class="register-actions">
                        <form action="" class="aproved-btn">
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M268-240 42-466l57-56 170 170 56 56-57 56Zm226 0L268-466l56-57 170 170 368-368 56 57-424 424Zm0-226-57-56 198-198 57 56-198 198Z"/></svg>
                            </button>
                        </form>

                        <a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-120v-170l527-526q12-12 27-18t30-6q16 0 30.5 6t25.5 18l56 56q12 11 18 25.5t6 30.5q0 15-6 30t-18 27L330-120H160Zm80-80h56l393-392-28-29-29-28-392 393v56Zm560-503-57-57 57 57Zm-139 82-29-28 57 57-28-29ZM560-120q74 0 137-37t63-103q0-36-19-62t-51-45l-59 59q23 10 36 22t13 26q0 23-36.5 41.5T560-200q-17 0-28.5 11.5T520-160q0 17 11.5 28.5T560-120ZM183-426l60-60q-20-8-31.5-16.5T200-520q0-12 18-24t76-37q88-38 117-69t29-70q0-55-44-87.5T280-840q-45 0-80.5 16T145-785q-11 13-9 29t15 26q13 11 29 9t27-13q14-14 31-20t42-6q41 0 60.5 12t19.5 28q0 14-17.5 25.5T262-654q-80 35-111 63.5T120-520q0 32 17 54.5t46 39.5Z"/></svg>
                        </a>

                        <form action="" class="destroy-btn">
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M873-88 609-352 495-238 269-464l56-58 170 170 56-56-414-414 56-58 736 736-56 56ZM269-238 43-464l56-56 170 170 56 56-56 56Zm452-226-56-56 196-196 58 54-198 198ZM607-578l-56-56 86-86 56 56-86 86Z"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame order-frame rejected-order-frame">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link">
                        <div class="register-details h-full">
                            <div class="header-register">
                                <p>Nombre de la sucursal</p>
                                <span><?= $fecha ?></span>
                            </div>

                            <div class="text-start w-full">
                                Detalles del pedido:
                            </div>

                            <div class="body-register">
                                <div class="quantities">
                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>

                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>

                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>
                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- ACCIONES -->
                    <div class="register-actions">
                        <form action="" class="aproved-btn">
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M268-240 42-466l57-56 170 170 56 56-57 56Zm226 0L268-466l56-57 170 170 368-368 56 57-424 424Zm0-226-57-56 198-198 57 56-198 198Z"/></svg>
                            </button>
                        </form>

                        <a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-120v-170l527-526q12-12 27-18t30-6q16 0 30.5 6t25.5 18l56 56q12 11 18 25.5t6 30.5q0 15-6 30t-18 27L330-120H160Zm80-80h56l393-392-28-29-29-28-392 393v56Zm560-503-57-57 57 57Zm-139 82-29-28 57 57-28-29ZM560-120q74 0 137-37t63-103q0-36-19-62t-51-45l-59 59q23 10 36 22t13 26q0 23-36.5 41.5T560-200q-17 0-28.5 11.5T520-160q0 17 11.5 28.5T560-120ZM183-426l60-60q-20-8-31.5-16.5T200-520q0-12 18-24t76-37q88-38 117-69t29-70q0-55-44-87.5T280-840q-45 0-80.5 16T145-785q-11 13-9 29t15 26q13 11 29 9t27-13q14-14 31-20t42-6q41 0 60.5 12t19.5 28q0 14-17.5 25.5T262-654q-80 35-111 63.5T120-520q0 32 17 54.5t46 39.5Z"/></svg>
                        </a>

                        <form action="" class="destroy-btn">
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M873-88 609-352 495-238 269-464l56-58 170 170 56-56-414-414 56-58 736 736-56 56ZM269-238 43-464l56-56 170 170 56 56-56 56Zm452-226-56-56 196-196 58 54-198 198ZM607-578l-56-56 86-86 56 56-86 86Z"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame order-frame recived-order-frame">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link">
                        <div class="register-details h-full">
                            <div class="header-register">
                                <p>Nombre de la sucursal</p>
                                <span><?= $fecha ?></span>
                            </div>

                            <div class="text-start w-full">
                                Detalles del pedido:
                            </div>

                            <div class="body-register">
                                <div class="quantities">
                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>

                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>
                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>
                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>
                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>
                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- ACCIONES -->
                    <div class="register-actions">
                        <form action="" class="aproved-btn">
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M268-240 42-466l57-56 170 170 56 56-57 56Zm226 0L268-466l56-57 170 170 368-368 56 57-424 424Zm0-226-57-56 198-198 57 56-198 198Z"/></svg>
                            </button>
                        </form>

                        <a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-120v-170l527-526q12-12 27-18t30-6q16 0 30.5 6t25.5 18l56 56q12 11 18 25.5t6 30.5q0 15-6 30t-18 27L330-120H160Zm80-80h56l393-392-28-29-29-28-392 393v56Zm560-503-57-57 57 57Zm-139 82-29-28 57 57-28-29ZM560-120q74 0 137-37t63-103q0-36-19-62t-51-45l-59 59q23 10 36 22t13 26q0 23-36.5 41.5T560-200q-17 0-28.5 11.5T520-160q0 17 11.5 28.5T560-120ZM183-426l60-60q-20-8-31.5-16.5T200-520q0-12 18-24t76-37q88-38 117-69t29-70q0-55-44-87.5T280-840q-45 0-80.5 16T145-785q-11 13-9 29t15 26q13 11 29 9t27-13q14-14 31-20t42-6q41 0 60.5 12t19.5 28q0 14-17.5 25.5T262-654q-80 35-111 63.5T120-520q0 32 17 54.5t46 39.5Z"/></svg>
                        </a>

                        <form action="" class="destroy-btn">
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M873-88 609-352 495-238 269-464l56-58 170 170 56-56-414-414 56-58 736 736-56 56ZM269-238 43-464l56-56 170 170 56 56-56 56Zm452-226-56-56 196-196 58 54-198 198ZM607-578l-56-56 86-86 56 56-86 86Z"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame order-frame aproved-order-frame">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link">
                        <div class="register-details h-full">
                            <div class="header-register">
                                <p>Nombre de la sucursal</p>
                                <span><?= $fecha ?></span>
                            </div>

                            <div class="text-start w-full">
                                Detalles del pedido:
                            </div>

                            <div class="body-register">
                                <div class="quantities">
                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>

                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>

                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>

                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>

                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>

                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>

                                    <div class="order-product">
                                        <ol>
                                            <li>
                                                <p>
                                                    Camiseta 100% algodón color negro talla M
                                                </p>
                                                <span>17 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en sucursal:
                                                </p>
                                                <span>10 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Stock en almacén:
                                                </p>
                                                <span>524 unidades</span>
                                            </li>
                                            <li>
                                                <p>
                                                    Precio en sucursal:
                                                </p>
                                                <span>$54</span>
                                            </li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- ACCIONES -->
                    <div class="register-actions">
                        <form action="" class="aproved-btn">
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M268-240 42-466l57-56 170 170 56 56-57 56Zm226 0L268-466l56-57 170 170 368-368 56 57-424 424Zm0-226-57-56 198-198 57 56-198 198Z"/></svg>
                            </button>
                        </form>

                        <a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-120v-170l527-526q12-12 27-18t30-6q16 0 30.5 6t25.5 18l56 56q12 11 18 25.5t6 30.5q0 15-6 30t-18 27L330-120H160Zm80-80h56l393-392-28-29-29-28-392 393v56Zm560-503-57-57 57 57Zm-139 82-29-28 57 57-28-29ZM560-120q74 0 137-37t63-103q0-36-19-62t-51-45l-59 59q23 10 36 22t13 26q0 23-36.5 41.5T560-200q-17 0-28.5 11.5T520-160q0 17 11.5 28.5T560-120ZM183-426l60-60q-20-8-31.5-16.5T200-520q0-12 18-24t76-37q88-38 117-69t29-70q0-55-44-87.5T280-840q-45 0-80.5 16T145-785q-11 13-9 29t15 26q13 11 29 9t27-13q14-14 31-20t42-6q41 0 60.5 12t19.5 28q0 14-17.5 25.5T262-654q-80 35-111 63.5T120-520q0 32 17 54.5t46 39.5Z"/></svg>
                        </a>

                        <form action="" class="destroy-btn">
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M873-88 609-352 495-238 269-464l56-58 170 170 56-56-414-414 56-58 736 736-56 56ZM269-238 43-464l56-56 170 170 56 56-56 56Zm452-226-56-56 196-196 58 54-198 198ZM607-578l-56-56 86-86 56 56-86 86Z"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </main>

</body>
</html>
