<?php require_once __DIR__ . '/../config.php' ?>
<?php $page_name = SELLER_ACCESS . 'Dashboard' ?>

<!DOCTYPE html>
<html lang="en">
<?php require_once SELLER_DOC_VIEWS . "modules/head.php" ?>
<body>

    <?php require_once SELLER_DOC_VIEWS . "modules/header.php" ?>

    <main class="main-content seller-content">
        <div class="dashboard-container seller-dashboard">

            <div class="point-of-sale-grid-container">
                <!-- DETALLES DE LA VENTA -->
                <div class="sale-details-container">

                </div>

                <!-- RESIZESABLE -->
                <div class="resizer"></div>

                <!-- BUSCADOR Y LISTA DE PRODUCTOS -->
                <div class="searcher-products-list-container">
                    <!-- BUSCADOR -->
                    <div class="searcher">
                        <input type="text" id="searcher" autocomplete="off" placeholder="Buscar productos....">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M864-40 741-162q-18 11-38.5 16.5T660-140q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 23-6 43.5T797-218L920-96l-56 56ZM220-140q-66 0-113-47T60-300q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm0-80q33 0 56.5-23.5T300-300q0-33-23.5-56.5T220-380q-33 0-56.5 23.5T140-300q0 33 23.5 56.5T220-220Zm440 0q33 0 56.5-23.5T740-300q0-33-23.5-56.5T660-380q-33 0-56.5 23.5T580-300q0 33 23.5 56.5T660-220ZM220-580q-66 0-113-47T60-740q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm440 0q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm-440-80q33 0 56.5-23.5T300-740q0-33-23.5-56.5T220-820q-33 0-56.5 23.5T140-740q0 33 23.5 56.5T220-660Zm440 0q33 0 56.5-23.5T740-740q0-33-23.5-56.5T660-820q-33 0-56.5 23.5T580-740q0 33 23.5 56.5T660-660ZM220-300Zm0-440Zm440 0Z"/></svg>
                        </span>
                    </div>

                    <!-- LISTA DE RESULTADOS -->
                    <div class="products-list">

                        <div class="content-product-found">
                            <div class="product-header">
                                <div class="product-img">
                                    <img src="https://www.hubspot.com/hs-fs/hubfs/Shell_logo.svg.png?width=450&height=417&name=Shell_logo.svg.png" alt="product image">
                                </div>

                                <div class="product-name">
                                    <p>Camiseta clown 100% algodón color negro Camiseta clown 100% algodón color negro</p>
                                    <span>
                                        💲176.°° c/u
                                    </span>
                                </div>

                                <div class="add-remove-btns">
                                    <button type="button" class="remove-btn">➖</button>
                                    <input type="text" id="product-quantity" autocomplete="off">
                                    <button type="button" class="add-btn">➕</button>
                                </div>
                            </div>

                            <div class="product-footer">
                                <div class="is-not-wholesale">
                                    <span>No aplica mayoreo</span>
                                </div>

                                <div class="stock">
                                    <span>Existencias:</span>
                                    <span>#️⃣162</span>
                                </div>
                            </div>

                            <div class="product-details">
                                <details>
                                    <summary>Detalles del producto</summary>
                                    <div class="details">
                                        <div>
                                            <p> Se vende por:</p>
                                            <strong>📦 <span>caja</span></strong>
                                        </div>

                                        <div>
                                            <p>Precio al por mayor:</p>
                                            <strong>💲<span>149</span></strong>
                                        </div>

                                        <div>
                                            <p>Cantidad mínima aplicable a mayoreo:</p>
                                            <strong>#️⃣ <span>5</span></strong>
                                        </div>

                                        <div>
                                            <p>Marca:</p>
                                            <strong>📑 <span>Legendary Whitetails</span></strong>
                                        </div>

                                        <div>
                                            <p>Categoría:</p>
                                            <strong>📑 <span>Legendary Whitetails Legendary Whitetails</span></strong>
                                        </div>

                                        <div>
                                            <p>Codigo de barras:</p>
                                            <strong>🏷️ <span>051987124515482</span></strong>
                                        </div>
                                    </div>
                                </details>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- RESUMEN DE LA VENTA -->
                <div class="sale-summary-container">

                </div>
            </div>

        </div>
    </main>

    <!-- R E S I Z E S A B L E -->
    <script>
        const resizer = document.querySelector(".resizer");
        const leftPanel = document.querySelector(".sale-details-container");
        const rightPanel = document.querySelector(".searcher-products-list-container");
        const container = document.querySelector(".point-of-sale-grid-container");

        resizer.addEventListener("mousedown", (event) => {
            document.addEventListener("mousemove", resize);
            document.addEventListener("mouseup", () => {
                document.removeEventListener("mousemove", resize);
            });
        });

        function resize(event) {
            let newLeftWidth = event.clientX - container.offsetLeft;
            let totalWidth = container.clientWidth;

            let leftPercentage = (newLeftWidth / totalWidth) * 100;
            leftPercentage = Math.max(25, Math.min(leftPercentage, 70));

            container.style.gridTemplateColumns = `${leftPercentage}% 4px auto`;
        }
    </script>

    <!-- R E Z I E   O B S E R V E R -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const productHeader = document.querySelector(".searcher-products-list-container");
            const addRemoveBtns = document.querySelector(".add-remove-btns");

            const observer = new ResizeObserver(entries => {
                for (let entry of entries) {
                    if (entry.contentRect.width < 400) {
                        addRemoveBtns.classList.add("compact");
                    } else {
                        addRemoveBtns.classList.remove("compact");
                    }
                }
            });

            observer.observe(productHeader);
        });
    </script>
</body>
</html>
