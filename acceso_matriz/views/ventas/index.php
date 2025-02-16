<?php require_once __DIR__ . '/../../config.php' ?>
<?php $page_name = ACCESO . 'Ventas' ?>

<!DOCTYPE html>
<html lang="en">
<?php require_once MATRIX_DOC_VIEWS . "modules/head.php" ?>
<body>

    <?php require_once MATRIX_DOC_VIEWS . "/modules/header.php" ?>

    <?php require_once MATRIX_DOC_VIEWS . "/modules/sidebar.php" ?>

    <main class="main-content matriz-content inventory-content">

        <!-- FILTRAR INVENTARIOS POR SUCURSAL -->
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

            <select name="" class="crud-header-select sucursal-select">
                <option disabled selected>Todas las sucursales</option>
                <option value="">Sucursal 1 Sucursal 1</option>
                <option value="">Sucursal 2</option>
                <option value="">Sucursal 3</option>
            </select>
        </form>

        <!-- CRUD -->
        <div class="crud-container curd-history-sales-container">
            <!-- CRUD HEADER -->
            <div class="crud-header">
                <!-- HEADER SUPERIOR -->
                <div class="crud-top-header">
                    <div class="crud-tittle">
                        <h1>Historial</h1>
                        <p>Consulte sus ventas generales y por sucursal</p>
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
                            <span>$381,515,159,455.°°</span>
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

            <!-- ULTIMAS VENTAS -->
            <div class="crud-element">
                <div class="last-sales-history">
                    <h2>Últimas ventas</h2>
                    <a href="<?= MATRIX_HTTP_VIEWS ?>ventas/historial" class="text-black font-black">
                        Ver todo
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"/></svg>
                    </a>
                </div>
                <div class="crud-grid crud-grid-last-sales">
                    <!-- MARCO DEL REGISTRO -->
                    <div class="register-frame register-frame-last-sales">
                        <!-- DETALLES -->
                        <a href="" class="register-details-link register-link-last-sale">
                            <div class="register-details">
                                <div class="header-register header-last-sale">
                                    <p>Fecha</p>
                                    <span><?=  $fecha_ab ?></span>
                                </div>

                                <div class="body-register">
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
                    <div class="register-frame register-frame-last-sales">
                        <!-- DETALLES -->
                        <a href="" class="register-details-link register-link-last-sale">
                            <div class="register-details">
                                <div class="header-register header-last-sale">
                                    <p>Fecha</p>
                                    <span><?=  $fecha_ab ?></span>
                                </div>

                                <div class="body-register">
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
                    <div class="register-frame register-frame-last-sales">
                        <!-- DETALLES -->
                        <a href="" class="register-details-link register-link-last-sale">
                            <div class="register-details">
                                <div class="header-register header-last-sale">
                                    <p>Fecha</p>
                                    <span><?=  $fecha_ab ?></span>
                                </div>

                                <div class="body-register">
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
                    <div class="register-frame register-frame-last-sales">
                        <!-- DETALLES -->
                        <a href="" class="register-details-link register-link-last-sale">
                            <div class="register-details">
                                <div class="header-register header-last-sale">
                                    <p>Fecha</p>
                                    <span><?=  $fecha_ab ?></span>
                                </div>

                                <div class="body-register">
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
                    <div class="register-frame register-frame-last-sales">
                        <!-- DETALLES -->
                        <a href="" class="register-details-link register-link-last-sale">
                            <div class="register-details">
                                <div class="header-register header-last-sale">
                                    <p>Fecha</p>
                                    <span><?=  $fecha_ab ?></span>
                                </div>

                                <div class="body-register">
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
                    <div class="register-frame register-frame-last-sales">
                        <!-- DETALLES -->
                        <a href="" class="register-details-link register-link-last-sale">
                            <div class="register-details">
                                <div class="header-register header-last-sale">
                                    <p>Fecha</p>
                                    <span><?=  $fecha_ab ?></span>
                                </div>

                                <div class="body-register">
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

            <!-- PRODUCTOS MAS VENDIDOS -->
            <div class="crud-element">
                <h2>Productos más vendidos</h2>
                <div class="crud-grid crud-grid-best-sales">
                    <div class="registers-frames-container">
                        <!-- MARCO DEL REGISTRO -->
                        <div class="register-frame">
                            <!-- DETALLES -->
                            <a href="" class="register-details-link register-link-best-sales">
                                <div class="register-details">
                                    <div class="header-register">
                                        <p>Camiseta 100% algodón</p>
                                        <span>Legendary Whitetails</span>
                                    </div>

                                    <div class="body-register">
                                        <img src="https://http2.mlstatic.com/D_NQ_NP_639610-MLM76545318391_052024-O.webp" alt="product-img">
                                        <div class="quantities">
                                            <p>
                                                Unidades vendidas
                                                <span>179</span>
                                            </p>
                                            <p>
                                                Unidades en stock
                                                <span>116</span>
                                            </p>
                                            <p>
                                                Precio sugerido
                                                <span>$289</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- MARCO DEL REGISTRO -->
                        <div class="register-frame">
                            <!-- DETALLES -->
                            <a href="" class="register-details-link register-link-best-sales">
                                <div class="register-details">
                                    <div class="header-register">
                                        <p>Camiseta 100% algodón</p>
                                        <span>Legendary Whitetails</span>
                                    </div>

                                    <div class="body-register">
                                        <img src="https://http2.mlstatic.com/D_NQ_NP_639610-MLM76545318391_052024-O.webp" alt="product-img">
                                        <div class="quantities">
                                            <p>
                                                Unidades vendidas
                                                <span>179</span>
                                            </p>
                                            <p>
                                                Unidades en stock
                                                <span>116</span>
                                            </p>
                                            <p>
                                                Precio sugerido
                                                <span>$289</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- MARCO DEL REGISTRO -->
                        <div class="register-frame">
                            <!-- DETALLES -->
                            <a href="" class="register-details-link register-link-best-sales">
                                <div class="register-details">
                                    <div class="header-register">
                                        <p>Camiseta 100% algodón</p>
                                        <span>Legendary Whitetails</span>
                                    </div>

                                    <div class="body-register">
                                        <img src="https://http2.mlstatic.com/D_NQ_NP_639610-MLM76545318391_052024-O.webp" alt="product-img">
                                        <div class="quantities">
                                            <p>
                                                Unidades vendidas
                                                <span>179</span>
                                            </p>
                                            <p>
                                                Unidades en stock
                                                <span>116</span>
                                            </p>
                                            <p>
                                                Precio sugerido
                                                <span>$289</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- GRAFICA -->
                    <div class="chart best-selling-products-chart">
                        <canvas id="best_sellings_products_chart"></canvas>
                    </div>
                </div>
            </div>

            <!-- TOTAL DE VENTAS POR PERIODO -->
            <div class="crud-element">
                <h2>Total de ventas</h2>
                <div class="sales-per-period">
                    <div class="sales-charts-grid-period">
                        <!-- VENTAS DE LA SEMANA BARRAS -->
                        <div class="sales-chart daily-sales-per-week-bar-chart">
                            <canvas id="daily_sales_per_week_bar_chart"></canvas>
                        </div>

                        <!-- VENTAS MENSUALES LINEAS -->
                        <div class="sales-chart daily-sales-per-month-line-chart">
                            <canvas id="daily_sales_per_month_line_chart"></canvas>
                        </div>

                        <!-- VENTAS DEL AÑO LINEAS -->
                        <div class="sales-chart daily-sales-per-year-chart">
                            <canvas id="daily_sales_per_year_chart"></canvas>
                        </div>

                        <!-- VENTAS POR PERIODO PASTEL -->
                        <div class="sales-chart daily-sales-per-period-chart">
                            <canvas id="daily_sales_per_period_chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- VENTAS POR TIPO -->
            <div class="crud-element">
                <h2>Ventas por tipo</h2>
                <div class="sales-types">
                    <div class="sales-per-type-chart">
                        <canvas id="sales_per_type_chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- GRAFICAS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?= MATRIX_HTTP_URL ?>resources/scripts.js"></script>
</body>
</html>
