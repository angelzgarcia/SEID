<?php require_once __DIR__ . '/../config.php' ?>
<?php require_once SELLER_DOC_ROOT . 'database.php' ?>
<?php require_once SELLER_DOCT_FNS . 'helpers/encrypt.php' ?>

<?php $page_name = SELLER_ACCESS . 'Dashboard' ?>

<?php
    $sql =  '
        SELECT p.id_producto, p.*, c.id_categoria, c.nombre_categoria, m.id_marca, m.nombre_marca
        FROM productos AS p
        INNER JOIN categorias AS c ON p.id_categoria_fk_producto = c.id_categoria
        INNER JOIN marcas AS m ON p.id_marca_fk_producto = m.id_marca
    ';

    $query = $conn->query($sql);
    $productos = $query -> fetch_all(MYSQLI_ASSOC) ?: [];
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once SELLER_DOC_VIEWS . "components/head.php" ?>
<body>

    <?php require_once SELLER_DOC_VIEWS . "components/header.php" ?>

    <?php require_once SELLER_DOC_VIEWS . "components/sidebar.php" ?>

    <main class="main-content seller-content">
        <div class="dashboard-container seller-dashboard">

            <div class="point-of-sale-grid-container">
                <!-- DETALLES DE LA VENTA -->
                <div class="sale-details-container">
                    <h1>Venta en curso <span>📋</span></h1>

                    <div class="sale-details">
                        <ul>
                            <li>
                                <div class="sale-product-details">
                                    <div class="sale-product-header">
                                        <p>Camiseta clown 100% algodón color negro</p>
                                        <span>7 piezas</span>
                                    </div>

                                    <div class="sale-product-body">
                                        <div class="unit-price">
                                            <p>Precio unitario:</p>
                                            <span>$153.°°</span>
                                        </div>

                                        <div class="wholesale-price">
                                            <p>Precio al por mayor:</p>
                                            <span>$140.°°</span>
                                        </div>

                                        <div class="subtotal">
                                            <p>Subtotal:</p>
                                            <span>$1020.°°</span>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="sale-product-details">
                                    <div class="sale-product-header">
                                        <p>Camiseta clown 100% algodón color negro</p>
                                        <span>7 piezas</span>
                                    </div>

                                    <div class="sale-product-body">
                                        <div class="unit-price">
                                            <p>Precio unitario:</p>
                                            <span>$153.°°</span>
                                        </div>

                                        <div class="subtotal">
                                            <p>Subtotal:</p>
                                            <span>$1020.°°</span>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="sale-product-details">
                                    <div class="sale-product-header">
                                        <p>Camiseta clown 100% algodón color negro</p>
                                        <span>7 piezas</span>
                                    </div>

                                    <div class="sale-product-body">
                                        <div class="unit-price">
                                            <p>Precio unitario:</p>
                                            <span>$153.°°</span>
                                        </div>

                                        <div class="wholesale-price">
                                            <p>Precio al por mayor:</p>
                                            <span>$140.°°</span>
                                        </div>

                                        <div class="subtotal">
                                            <p>Subtotal:</p>
                                            <span>$1020.°°</span>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="sale-product-details">
                                    <div class="sale-product-header">
                                        <p>Camiseta clown 100% algodón color negro</p>
                                        <span>7 piezas</span>
                                    </div>

                                    <div class="sale-product-body">
                                        <div class="unit-price">
                                            <p>Precio unitario:</p>
                                            <span>$153.°°</span>
                                        </div>

                                        <div class="subtotal">
                                            <p>Subtotal:</p>
                                            <span>$1020.°°</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- RESIZESABLE -->
                <div class="resizer"></div>

                <!-- BUSCADOR Y LISTA DE PRODUCTOS -->
                <div class="searcher-products-list-container">
                    <!-- BUSCADOR -->
                    <div class="searcher">
                        <div class="flex items-center justify-between w-full">
                            <input type="text" id="barcode_product_searcher" autocomplete="off" placeholder="Escanear producto....">

                            <em class="px-2">/</em>

                            <input type="text" id="name_product_searcher" autocomplete="off" placeholder="Buscar producto....">
                        </div>

                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M864-40 741-162q-18 11-38.5 16.5T660-140q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 23-6 43.5T797-218L920-96l-56 56ZM220-140q-66 0-113-47T60-300q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm0-80q33 0 56.5-23.5T300-300q0-33-23.5-56.5T220-380q-33 0-56.5 23.5T140-300q0 33 23.5 56.5T220-220Zm440 0q33 0 56.5-23.5T740-300q0-33-23.5-56.5T660-380q-33 0-56.5 23.5T580-300q0 33 23.5 56.5T660-220ZM220-580q-66 0-113-47T60-740q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm440 0q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm-440-80q33 0 56.5-23.5T300-740q0-33-23.5-56.5T220-820q-33 0-56.5 23.5T140-740q0 33 23.5 56.5T220-660Zm440 0q33 0 56.5-23.5T740-740q0-33-23.5-56.5T660-820q-33 0-56.5 23.5T580-740q0 33 23.5 56.5T660-660ZM220-300Zm0-440Zm440 0Z"/></svg>
                        </span>
                    </div>

                    <!-- LISTA DE RESULTADOS -->
                    <div class="products-list" id="products-list">

                        <!-- SE CARGAN LOS PRODUCTOS CON AJAAX -->

                    </div>
                </div>

                <!-- RESUMEN DE LA VENTA -->
                <div class="sale-summary-container">
                    <div class="total-sale-summary">
                        <p>Total:</p>
                        <p>
                            $<span id="total-pay">50237</span>.°°
                        </p>
                    </div>

                    <div class="total-products-summary">
                        <p>Total de productos:</p>
                        <span>35</span>
                    </div>

                    <div class="pay-confirm-form">
                        <form action="<?= SELLER_HTTP_URL ?>functions/crear_venta" method="POST" autocomplete="off">
                            <button type="button" title="Cobrar" id="pay-button">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m700-300-57-56 84-84H120v-80h607l-83-84 57-56 179 180-180 180Z"/></svg>
                                <!-- <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M560-440q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35ZM280-320q-33 0-56.5-23.5T200-400v-320q0-33 23.5-56.5T280-800h560q33 0 56.5 23.5T920-720v320q0 33-23.5 56.5T840-320H280Zm80-80h400q0-33 23.5-56.5T840-480v-160q-33 0-56.5-23.5T760-720H360q0 33-23.5 56.5T280-640v160q33 0 56.5 23.5T360-400Zm440 240H120q-33 0-56.5-23.5T40-240v-440h80v440h680v80ZM280-400v-320 320Z"/></svg> -->
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m40-240 20-80h220l-20 80H40Zm80-160 20-80h260l-20 80H120Zm623 240 20-160 29-240 10-79-59 479ZM240-80q-33 0-56.5-23.5T160-160h583l59-479H692l-11 85q-2 17-15 26.5t-30 7.5q-17-2-26.5-14.5T602-564l9-75H452l-11 84q-2 17-15 27t-30 8q-17-2-27-15t-8-30l9-74H220q4-34 26-57.5t54-23.5h80q8-75 51.5-117.5T550-880q64 0 106.5 47.5T698-720h102q36 1 60 28t19 63l-60 480q-4 30-26.5 49.5T740-80H240Zm220-640h159q1-33-22.5-56.5T540-800q-35 0-55.5 21.5T460-720Z"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <script src="<?=SELLER_HTTP_URL?>resources/js/components.js"></script>
    <script src="<?=SELLER_HTTP_URL?>resources/js/dashboard.js"></script>

</body>
</html>
