<?php require_once __DIR__ . '/../../config.php' ?>
<?php $page_name = ACCESO . 'Historial de ventas' ?>

<!DOCTYPE html>
<html lang="en">
<?php require_once MATRIX_DOC_VIEWS . "modules/head.php" ?>
<body>

    <?php require_once MATRIX_DOC_VIEWS . "/modules/header.php" ?>

    <?php require_once MATRIX_DOC_VIEWS . "/modules/sidebar.php" ?>

    <main class="main-content matriz-content inventory-content">

        <!-- FILTRAR INVENTARIOS POR SUCURSAL -->
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
        <div class="crud-container">
            <!-- CRUD HEADER -->
            <div class="crud-header">
                <!-- HEADER SUPERIOR -->
                <div class="crud-top-header">
                    <div class="crud-tittle">
                        <h1>Historial</h1>
                        <p>Consulte sus ventas generales y por sucursal</p>
                    </div>
                    <div class="crud-order-by">
                        <select name="" id="">
                            <option selected disabled>Ordenar por</option>
                            <option value="">Fecha</option>
                            <option value="">Mayor venta</option>
                            <option value="">Menor venta</option>
                        </select>
                    </div>
                </div>

                <!-- HEADER INTERMEDIO -->
                <div class="crud-middle-header">
                    <div class="details">
                        <div class="summary">
                            <p>Productos vendidos</p>
                            <span>5062</span>
                        </div>
                        <div class="summary">
                            <p>Ingresos generados</p>
                            <span>$381,515,159,455</span>
                        </div>
                        <div class="summary">
                            <p>Ventas de hoy</p>
                            <span>108</span>
                        </div>
                        <div class="summary">
                            <p>N° de ventas</p>
                            <span>1711</span>
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

            <!-- ULTIMAS VENTAS -->
            <div class="crud-grid crud-grid-last-sales-history">
                <div class="last-sales-history">
                    <h2>Ventas</h2>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame register-frame-sale">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link register-link-sale">
                        <div class="register-details">
                            <div class="header-register header-last-sale">
                                <p>Fecha</p>
                                <span><?=  $fecha_ab ?></span>
                            </div>

                            <div class="body-register sale-history-register-body">
                                <!-- <img src="https://http2.mlstatic.com/D_NQ_NP_639610-MLM76545318391_052024-O.webp" alt="product-img"> -->
                                <div class="quantities">
                                    <p>
                                        Folio
                                        <span>248510</span>
                                    </p>
                                    <p>
                                        Productos
                                        <span>17</span>
                                    </p>
                                    <p>
                                        Total
                                        <span>$589</span>
                                    </p>
                                    <p>
                                        Sucursal
                                        <span>EDO. MEX. CARMELO PÉREZCARMELO PÉREZ</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame register-frame-sale">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link register-link-sale">
                        <div class="register-details">
                            <div class="header-register header-last-sale">
                                <p>Fecha</p>
                                <span><?=  $fecha_ab ?></span>
                            </div>

                            <div class="body-register sale-history-register-body">
                                <!-- <img src="https://http2.mlstatic.com/D_NQ_NP_639610-MLM76545318391_052024-O.webp" alt="product-img"> -->
                                <div class="quantities">
                                    <p>
                                        Folio
                                        <span>248510</span>
                                    </p>
                                    <p>
                                        Productos
                                        <span>17</span>
                                    </p>
                                    <p>
                                        Total
                                        <span>$589</span>
                                    </p>
                                    <p>
                                        Sucursal
                                        <span>EDO. MEX. CARMELO PÉREZCARMELO PÉREZ</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame register-frame-sale">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link register-link-sale">
                        <div class="register-details">
                            <div class="header-register header-last-sale">
                                <p>Fecha</p>
                                <span><?=  $fecha_ab ?></span>
                            </div>

                            <div class="body-register sale-history-register-body">
                                <!-- <img src="https://http2.mlstatic.com/D_NQ_NP_639610-MLM76545318391_052024-O.webp" alt="product-img"> -->
                                <div class="quantities">
                                    <p>
                                        Folio
                                        <span>248510</span>
                                    </p>
                                    <p>
                                        Productos
                                        <span>17</span>
                                    </p>
                                    <p>
                                        Total
                                        <span>$589</span>
                                    </p>
                                    <p>
                                        Sucursal
                                        <span>EDO. MEX. CARMELO PÉREZCARMELO PÉREZ</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame register-frame-sale">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link register-link-sale">
                        <div class="register-details">
                            <div class="header-register header-last-sale">
                                <p>Fecha</p>
                                <span><?=  $fecha_ab ?></span>
                            </div>

                            <div class="body-register sale-history-register-body">
                                <!-- <img src="https://http2.mlstatic.com/D_NQ_NP_639610-MLM76545318391_052024-O.webp" alt="product-img"> -->
                                <div class="quantities">
                                    <p>
                                        Folio
                                        <span>248510</span>
                                    </p>
                                    <p>
                                        Productos
                                        <span>17</span>
                                    </p>
                                    <p>
                                        Total
                                        <span>$589</span>
                                    </p>
                                    <p>
                                        Sucursal
                                        <span>EDO. MEX. CARMELO PÉREZCARMELO PÉREZ</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame register-frame-sale">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link register-link-sale">
                        <div class="register-details">
                            <div class="header-register header-last-sale">
                                <p>Fecha</p>
                                <span><?=  $fecha_ab ?></span>
                            </div>

                            <div class="body-register sale-history-register-body">
                                <!-- <img src="https://http2.mlstatic.com/D_NQ_NP_639610-MLM76545318391_052024-O.webp" alt="product-img"> -->
                                <div class="quantities">
                                    <p>
                                        Folio
                                        <span>248510</span>
                                    </p>
                                    <p>
                                        Productos
                                        <span>17</span>
                                    </p>
                                    <p>
                                        Total
                                        <span>$589</span>
                                    </p>
                                    <p>
                                        Sucursal
                                        <span>EDO. MEX. CARMELO PÉREZCARMELO PÉREZ</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame register-frame-sale">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link register-link-sale">
                        <div class="register-details">
                            <div class="header-register header-last-sale">
                                <p>Fecha</p>
                                <span><?=  $fecha_ab ?></span>
                            </div>

                            <div class="body-register sale-history-register-body">
                                <!-- <img src="https://http2.mlstatic.com/D_NQ_NP_639610-MLM76545318391_052024-O.webp" alt="product-img"> -->
                                <div class="quantities">
                                    <p>
                                        Folio
                                        <span>248510</span>
                                    </p>
                                    <p>
                                        Productos
                                        <span>17</span>
                                    </p>
                                    <p>
                                        Total
                                        <span>$589</span>
                                    </p>
                                    <p>
                                        Sucursal
                                        <span>EDO. MEX. CARMELO PÉREZCARMELO PÉREZ</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame register-frame-sale">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link register-link-sale">
                        <div class="register-details">
                            <div class="header-register header-last-sale">
                                <p>Fecha</p>
                                <span><?=  $fecha_ab ?></span>
                            </div>

                            <div class="body-register sale-history-register-body">
                                <!-- <img src="https://http2.mlstatic.com/D_NQ_NP_639610-MLM76545318391_052024-O.webp" alt="product-img"> -->
                                <div class="quantities">
                                    <p>
                                        Folio
                                        <span>248510</span>
                                    </p>
                                    <p>
                                        Productos
                                        <span>17</span>
                                    </p>
                                    <p>
                                        Total
                                        <span>$589</span>
                                    </p>
                                    <p>
                                        Sucursal
                                        <span>EDO. MEX. CARMELO PÉREZCARMELO PÉREZ</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame register-frame-sale">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link register-link-sale">
                        <div class="register-details">
                            <div class="header-register header-last-sale">
                                <p>Fecha</p>
                                <span><?=  $fecha_ab ?></span>
                            </div>

                            <div class="body-register sale-history-register-body">
                                <!-- <img src="https://http2.mlstatic.com/D_NQ_NP_639610-MLM76545318391_052024-O.webp" alt="product-img"> -->
                                <div class="quantities">
                                    <p>
                                        Folio
                                        <span>248510</span>
                                    </p>
                                    <p>
                                        Productos
                                        <span>17</span>
                                    </p>
                                    <p>
                                        Total
                                        <span>$589</span>
                                    </p>
                                    <p>
                                        Sucursal
                                        <span>EDO. MEX. CARMELO PÉREZCARMELO PÉREZ</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame register-frame-sale">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link register-link-sale">
                        <div class="register-details">
                            <div class="header-register header-last-sale">
                                <p>Fecha</p>
                                <span><?=  $fecha_ab ?></span>
                            </div>

                            <div class="body-register sale-history-register-body">
                                <!-- <img src="https://http2.mlstatic.com/D_NQ_NP_639610-MLM76545318391_052024-O.webp" alt="product-img"> -->
                                <div class="quantities">
                                    <p>
                                        Folio
                                        <span>248510</span>
                                    </p>
                                    <p>
                                        Productos
                                        <span>17</span>
                                    </p>
                                    <p>
                                        Total
                                        <span>$589</span>
                                    </p>
                                    <p>
                                        Sucursal
                                        <span>EDO. MEX. CARMELO PÉREZCARMELO PÉREZ</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame register-frame-sale">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link register-link-sale">
                        <div class="register-details">
                            <div class="header-register header-last-sale">
                                <p>Fecha</p>
                                <span><?=  $fecha_ab ?></span>
                            </div>

                            <div class="body-register sale-history-register-body">
                                <!-- <img src="https://http2.mlstatic.com/D_NQ_NP_639610-MLM76545318391_052024-O.webp" alt="product-img"> -->
                                <div class="quantities">
                                    <p>
                                        Folio
                                        <span>248510</span>
                                    </p>
                                    <p>
                                        Productos
                                        <span>17</span>
                                    </p>
                                    <p>
                                        Total
                                        <span>$589</span>
                                    </p>
                                    <p>
                                        Sucursal
                                        <span>EDO. MEX. CARMELO PÉREZCARMELO PÉREZ</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame register-frame-sale">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link register-link-sale">
                        <div class="register-details">
                            <div class="header-register header-last-sale">
                                <p>Fecha</p>
                                <span><?=  $fecha_ab ?></span>
                            </div>

                            <div class="body-register sale-history-register-body">
                                <!-- <img src="https://http2.mlstatic.com/D_NQ_NP_639610-MLM76545318391_052024-O.webp" alt="product-img"> -->
                                <div class="quantities">
                                    <p>
                                        Folio
                                        <span>248510</span>
                                    </p>
                                    <p>
                                        Productos
                                        <span>17</span>
                                    </p>
                                    <p>
                                        Total
                                        <span>$589</span>
                                    </p>
                                    <p>
                                        Sucursal
                                        <span>EDO. MEX. CARMELO PÉREZCARMELO PÉREZ</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame register-frame-sale">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link register-link-sale">
                        <div class="register-details">
                            <div class="header-register header-last-sale">
                                <p>Fecha</p>
                                <span><?=  $fecha_ab ?></span>
                            </div>

                            <div class="body-register sale-history-register-body">
                                <!-- <img src="https://http2.mlstatic.com/D_NQ_NP_639610-MLM76545318391_052024-O.webp" alt="product-img"> -->
                                <div class="quantities">
                                    <p>
                                        Folio
                                        <span>248510</span>
                                    </p>
                                    <p>
                                        Productos
                                        <span>17</span>
                                    </p>
                                    <p>
                                        Total
                                        <span>$589</span>
                                    </p>
                                    <p>
                                        Sucursal
                                        <span>EDO. MEX. CARMELO PÉREZCARMELO PÉREZ</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame register-frame-sale">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link register-link-sale">
                        <div class="register-details">
                            <div class="header-register header-last-sale">
                                <p>Fecha</p>
                                <span><?=  $fecha_ab ?></span>
                            </div>

                            <div class="body-register sale-history-register-body">
                                <!-- <img src="https://http2.mlstatic.com/D_NQ_NP_639610-MLM76545318391_052024-O.webp" alt="product-img"> -->
                                <div class="quantities">
                                    <p>
                                        Folio
                                        <span>248510</span>
                                    </p>
                                    <p>
                                        Productos
                                        <span>17</span>
                                    </p>
                                    <p>
                                        Total
                                        <span>$589</span>
                                    </p>
                                    <p>
                                        Sucursal
                                        <span>EDO. MEX. CARMELO PÉREZCARMELO PÉREZ</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame register-frame-sale">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link register-link-sale">
                        <div class="register-details">
                            <div class="header-register header-last-sale">
                                <p>Fecha</p>
                                <span><?=  $fecha_ab ?></span>
                            </div>

                            <div class="body-register sale-history-register-body">
                                <!-- <img src="https://http2.mlstatic.com/D_NQ_NP_639610-MLM76545318391_052024-O.webp" alt="product-img"> -->
                                <div class="quantities">
                                    <p>
                                        Folio
                                        <span>248510</span>
                                    </p>
                                    <p>
                                        Productos
                                        <span>17</span>
                                    </p>
                                    <p>
                                        Total
                                        <span>$589</span>
                                    </p>
                                    <p>
                                        Sucursal
                                        <span>EDO. MEX. CARMELO PÉREZCARMELO PÉREZ</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame register-frame-sale">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link register-link-sale">
                        <div class="register-details">
                            <div class="header-register header-last-sale">
                                <p>Fecha</p>
                                <span><?=  $fecha_ab ?></span>
                            </div>

                            <div class="body-register sale-history-register-body">
                                <!-- <img src="https://http2.mlstatic.com/D_NQ_NP_639610-MLM76545318391_052024-O.webp" alt="product-img"> -->
                                <div class="quantities">
                                    <p>
                                        Folio
                                        <span>248510</span>
                                    </p>
                                    <p>
                                        Productos
                                        <span>17</span>
                                    </p>
                                    <p>
                                        Total
                                        <span>$589</span>
                                    </p>
                                    <p>
                                        Sucursal
                                        <span>EDO. MEX. CARMELO PÉREZCARMELO PÉREZ</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame register-frame-sale">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link register-link-sale">
                        <div class="register-details">
                            <div class="header-register header-last-sale">
                                <p>Fecha</p>
                                <span><?=  $fecha_ab ?></span>
                            </div>

                            <div class="body-register sale-history-register-body">
                                <!-- <img src="https://http2.mlstatic.com/D_NQ_NP_639610-MLM76545318391_052024-O.webp" alt="product-img"> -->
                                <div class="quantities">
                                    <p>
                                        Folio
                                        <span>248510</span>
                                    </p>
                                    <p>
                                        Productos
                                        <span>17</span>
                                    </p>
                                    <p>
                                        Total
                                        <span>$589</span>
                                    </p>
                                    <p>
                                        Sucursal
                                        <span>EDO. MEX. CARMELO PÉREZCARMELO PÉREZ</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame register-frame-sale">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link register-link-sale">
                        <div class="register-details">
                            <div class="header-register header-last-sale">
                                <p>Fecha</p>
                                <span><?=  $fecha_ab ?></span>
                            </div>

                            <div class="body-register sale-history-register-body">
                                <!-- <img src="https://http2.mlstatic.com/D_NQ_NP_639610-MLM76545318391_052024-O.webp" alt="product-img"> -->
                                <div class="quantities">
                                    <p>
                                        Folio
                                        <span>248510</span>
                                    </p>
                                    <p>
                                        Productos
                                        <span>17</span>
                                    </p>
                                    <p>
                                        Total
                                        <span>$589</span>
                                    </p>
                                    <p>
                                        Sucursal
                                        <span>EDO. MEX. CARMELO PÉREZCARMELO PÉREZ</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame register-frame-sale">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link register-link-sale">
                        <div class="register-details">
                            <div class="header-register header-last-sale">
                                <p>Fecha</p>
                                <span><?=  $fecha_ab ?></span>
                            </div>

                            <div class="body-register sale-history-register-body">
                                <!-- <img src="https://http2.mlstatic.com/D_NQ_NP_639610-MLM76545318391_052024-O.webp" alt="product-img"> -->
                                <div class="quantities">
                                    <p>
                                        Folio
                                        <span>248510</span>
                                    </p>
                                    <p>
                                        Productos
                                        <span>17</span>
                                    </p>
                                    <p>
                                        Total
                                        <span>$589</span>
                                    </p>
                                    <p>
                                        Sucursal
                                        <span>EDO. MEX. CARMELO PÉREZCARMELO PÉREZ</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame register-frame-sale">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link register-link-sale">
                        <div class="register-details">
                            <div class="header-register header-last-sale">
                                <p>Fecha</p>
                                <span><?=  $fecha_ab ?></span>
                            </div>

                            <div class="body-register sale-history-register-body">
                                <!-- <img src="https://http2.mlstatic.com/D_NQ_NP_639610-MLM76545318391_052024-O.webp" alt="product-img"> -->
                                <div class="quantities">
                                    <p>
                                        Folio
                                        <span>248510</span>
                                    </p>
                                    <p>
                                        Productos
                                        <span>17</span>
                                    </p>
                                    <p>
                                        Total
                                        <span>$589</span>
                                    </p>
                                    <p>
                                        Sucursal
                                        <span>EDO. MEX. CARMELO PÉREZCARMELO PÉREZ</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </main>
</body>
</html>
