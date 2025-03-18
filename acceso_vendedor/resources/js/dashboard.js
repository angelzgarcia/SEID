
let saleInProgress = JSON.parse(localStorage.getItem('saleInProgress')) || [];


// <!-- C A R G A R   E S T A D O   I N I C I A L   D E L   S I S T E M A -->
document.addEventListener("DOMContentLoaded", function ()
{
    const resizer = document.querySelector(".resizer");
    const leftPanel = document.querySelector(".sale-details-container");
    const rightPanel = document.querySelector(".product_search-products-list-container");
    const container = document.querySelector(".point-of-sale-grid-container");


    // <!-- R E S I Z E S A B L E    W I N D O W S -->
    resizer.addEventListener("mousedown", (event) => {
        document.body.style.userSelect = "none";

        document.addEventListener("mousemove", resize);
        document.addEventListener("mouseup", () => {
            document.removeEventListener("mousemove", resize);

            document.body.style.userSelect = "";
        }, { once: true });
    });
    const resize = (event) => {
        let newLeftWidth = event.clientX - container.offsetLeft;
        let totalWidth = container.clientWidth;

        let leftPercentage = (newLeftWidth / totalWidth) * 100;
        leftPercentage = Math.max(25, Math.min(leftPercentage, 70));

        container.style.gridTemplateColumns = `${leftPercentage}% 4px auto`;
    }


    // <!-- V A L I D A R   C A M P O:   P A G Ó   C O N -->
    function validarPrecios(input) {
        let cursorPos = input.selectionStart;
        let longitudAntes = input.value.length;

        input.value = input.value.replace(/^0+(\d)/, '$1')
                                .replace(/[^0-9.]/g, '')
                                .replace(/(\..*)\./g, '$1')
                                .replace(/^(\d+\.\d{2})\d+$/, '$1');

        if (input.value === "0") input.value = "";

        if (input.value.startsWith('.')) input.value = '';
    }


    // <!-- S W E E T   A L E R T   P A Y M E N T -->
    const payButton = document.getElementById('pay-button');

    payButton.addEventListener('click', () => {
        let timerInterval;
        const totalPay = document.getElementById('total_payment').textContent;

        Swal.fire({
            title: "Cargando...",
            timer: 500,
            timerProgressBar: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            toast: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            showConfirmButton: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
                const timer = Swal.getPopup().querySelector("b");

                timerInterval = setInterval(() => {
                    if (timer) {
                        timer.textContent = `${Swal.getTimerLeft()}`;
                    }
                }, 100);
            },
            willClose: () => {
                clearInterval(timerInterval);
            }
        }).then(() => {
            Swal.fire({
                title: "Finalizar venta ✅",
                focusConfirm: false,
                allowOutsideClick: false,
                showCancelButton: true,
                confirmButtonText: `
                    <span class="swal-custom-text">Pagar</span>
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                        <path d="M560-440q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35ZM280-320q-33 0-56.5-23.5T200-400v-320q0-33 23.5-56.5T280-800h560q33 0 56.5 23.5T920-720v320q0 33-23.5 56.5T840-320H280Zm80-80h400q0-33 23.5-56.5T840-480v-160q-33 0-56.5-23.5T760-720H360q0 33-23.5 56.5T280-640v160q33 0 56.5 23.5T360-400Zm440 240H120q-33 0-56.5-23.5T40-240v-440h80v440h680v80ZM280-400v-320 320Z"/>
                    </svg>
                `,
                cancelButtonText: `
                    <span class="swal-custom-text">Cancelar</span>
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m336-280 144-144 144 144 56-56-144-144 144-144-56-56-144 144-144-144-56 56 144 144-144 144 56 56ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
                `,
                buttonsStyling: true,
                customClass: {
                    confirmButton: "swal-custom-btn swal-pay-btn",
                    cancelButton: "swal-custom-btn swal-cancel-btn"
                },
                html: `
                    <div class="swal-custom-form">
                        <fieldset>
                            <legend>Pagó con:</legend>
                            <input id="swal-pay" class="swal2-input" onInput="validarPrecios(this)" placeholder="💲">
                        </fieldset>

                        <div>
                            <h2>Total:</h2>
                            <p id="swal-total">💲${parseFloat(totalPay)}.°°</p>
                        </div>

                        <div>
                            <h2>Su cambio:</h2>
                            <p id="swal-change">💲0.00.°°</p>
                        </div>
                    </div>
                `,
                didOpen: () => {
                    const inputPago = document.getElementById('swal-pay');
                    const cambioSpan = document.getElementById('swal-change');

                    inputPago.addEventListener('input', () => {
                        let pago = parseFloat(inputPago.value) || 0;
                        let cambio = pago - parseFloat(totalPay);

                        cambioSpan.textContent = cambio >= 0 ? `💲${cambio}.°°` : '💲0.00.°°';
                    });
                },
                preConfirm: () => {
                    return [
                        document.getElementById("swal-pay").value,
                    ];
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    if (result.value) Swal.fire(JSON.stringify(localStorage.getItem('saleInProgress')));

                } else {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        iconColor: 'white',
                        timerProgressBar: true,
                        customClass: {
                            popup: 'colored-toast',
                        },
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: "info",
                        title: "Operación cancelada"
                    });
                }
            });
        });
    });


    // <!-- L O G O S -->
    withoutSearch();


    // <!-- M O S T R A R   L I S T A   D E   P R O D U C T O S   D E   L A   V E N T A   E N   C U R S O -->
    showProductsList();


    // <!-- R E S U M E N   D E   L A   V E N T A -->
    showTotalPaymentAndCountProductsList();
});


// <!--  L O G O S    D E N E D I G -->
function withoutSearch()
{
    document.getElementById('products-list').innerHTML = `
        <div class="min-h-full items-center justify-center">
            <div class="denedig-logo">
                <img src="../../imgs_denedig/logo-denedig.png" alt="denedig logo">
                <img src="../../imgs_denedig/denedig.webp" alt="denedig logo">
            </div>
        </div>
    `;
}


// <!--  C O L O R   D E   F O N D O   D E L   I N P U T   D E   E S C A N E O -->
function setInputStatusColor(status)
{
    let barcodeInput = document.getElementById('product_scan');
    barcodeInput.classList.add(status);

    let timeColor = null;
    clearTimeout(timeColor);

    timeColor = setTimeout(() => {
        barcodeInput.classList.remove(status);
    }, 400);
}


// <!--  R E F R E S C A R   I N P U T   D E    E S C A N E O -->
function  refreshProductScanInput(withTimeout = false)
{
    let productScanInput = document.getElementById('product_scan');
    let productSearchInput = document.getElementById('product_search');

    productScanInput.value = '';

    if (withTimeout) {
        let time = null;
        clearTimeout(time);

        time = setTimeout(() => {
            productSearchInput.classList.remove('disabled');
            productSearchInput.removeAttribute('disabled');
        }, 1000);

    } else {
        $(productScanInput).trigger($.Event('keydown', { key: 'Enter' }));
    }
}


// <!--  R E Z I E   O B S E R V E R -->
function resizeButtonsObserver()
{
    const productHeaders = document.querySelectorAll(".product-header");
    console.log(productHeaders);

    productHeaders.forEach(productHeader => {
        const addRemoveBtns = productHeader.querySelector(".add-remove-btns");

        if (!addRemoveBtns) return;

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
}


// <!-- B U S C A D O R   E N   T I E M P O   R E A L  (CODIGO DE BARRAS Y NOMBRE) -->
$(document).on('keyup', '#product_search', function()
{
    let productoName = this.value.trim() || '';
    let productBarcodeInput = document.getElementById('product_scan');

    if (productoName === '' || productoName.length <= 1) {
        productBarcodeInput.classList.remove('disabled');
        productBarcodeInput.removeAttribute('disabled');
        productBarcodeInput.value= '';

        withoutSearch();
    } else {
        productBarcodeInput.classList.add('disabled');
        productBarcodeInput.setAttribute('disabled', 'true');

        busqueda();
    }
});


// <!--  B U S C A R    P O R   C O D I G O   D E   B A R R A S   (AL ACTIVAR LA TECLA ENTER) -->
$(document).on('keydown', '#product_scan', function(event)
{
    let productBarcode = this.value.trim();
    let productSearchInput = document.getElementById('product_search');

    if (event.key === 'Enter')
        if (productBarcode === '' || productBarcode.length <= 1) {
            productSearchInput.classList.remove('disabled');
            productSearchInput.removeAttribute('disabled');
            productSearchInput.value= '';

            withoutSearch();

        } else {
            busqueda(false);
        }
});


// <!--   M O S T R A R   P R O D U C T O S   D E   L A   V E N T A   E N   C U R S O  -->
function showProductsList()
{
    let saleInProgress = JSON.parse(localStorage.getItem('saleInProgress')) || [];
    let productsInProgressList = document.getElementById('products-sale-in-progress-list');
    productsInProgressList.innerHTML = '';

    if (saleInProgress.length < 1) {
        productsInProgressList.innerHTML = `
            <div class="seid-logo">
                <div class="seid-letter"><span>S</span></div>
                <div class="seid-letter"><span>E</span></div>
                <div class="seid-letter"><span>I</span></div>
                <div class="seid-letter"><span>D</span></div>
            </div>
        `;
    }

    saleInProgress.forEach(p => {
        productsInProgressList.innerHTML += `
            <li>
                <div class="sale-product-details">

                <div class="sale-product-body">
                        <div class="sale-product-header">
                            <p>${p.nombre_producto}</p>
                            <span>
                                ${
                                    p.quantity > 1
                                        ? p.quantity + ' ' + p.unidad_venta_producto + 's'
                                        : p.quantity + ' ' + p.unidad_venta_producto
                                }
                            </span>
                        </div>
                        
                        <div class="unit-price">
                            <p>Precio unitario:</p>
                            <span>$${parseFloat(p.precio_venta_producto).toFixed(2)}.°°</span>
                        </div>

                        ${
                            (!Boolean(p.aplica_mayoreo) && p.quantity >= p.cantidad_minima_mayoreo_producto)
                            ?
                                `<div class="wholesale-price">
                                    <p>Precio al por mayor:</p>
                                    <span>$${parseFloat(p.precio_mayoreo_producto).toFixed(2)}.°°</span>
                                </div>`
                            :
                                `<div class="wholesale-price">
                                    <p>Precio al por mayor:</p>
                                    <span>No aplica</span>
                                </div>`
                        }

                        <div class="subtotal">
                            <p>Subtotal:</p>
                            <span>
                                $${
                                    p.subtotal
                                }.°°
                            </span>
                        </div>
                    </div>

                    <div class="add-discount-remove-btns" data-barcode="${p.codigo_barras_producto}">
                        <button type="button" class="remove-btn">🗑️</button>

                        <div class="add-remove-btns">
                            <button type="button" class="discount-btn">➖</button>
                            <button type="button" class="add-btn">➕</button>
                        </div>
                    </div>
                </div>
            </li>
        `;
    })
}


// <!-- A C T U A L I Z A R   E L   S U B T O T A L   D E   C A D A   P R O D U  C T O -->
function updateSubtotalProduct(product)
{
    (!Boolean(product.aplica_mayoreo) && product.quantity >= product.cantidad_minima_mayoreo_producto)
    ?
        product.subtotal = parseFloat(parseInt(product.quantity, 10) * parseFloat(product.precio_mayoreo_producto).toFixed(2)).toFixed(2)
    :
        product.subtotal =  parseFloat(parseInt(product.quantity, 10) * parseFloat(product.precio_venta_producto).toFixed(2)).toFixed(2)
}


// <!-- A C T U A L I Z A R   R E S U M E N   D E   T O T A L E S   D E   L A   V E N T A -->
function showTotalPaymentAndCountProductsList()
{
    let saleInProgressList = JSON.parse(localStorage.getItem('saleInProgress')) || [];

    let {totalProducts, totalPayment} = saleInProgressList.reduce((totals, p) => {
        totals.totalProducts += p.quantity;
        totals.totalPayment += p.quantity * 5;

        return totals;
    }, {totalProducts: 0, totalPayment: 0});

    document.getElementById('total_products').innerHTML = totalProducts;
    document.getElementById('total_payment').innerHTML = totalPayment;
}


// <!--  E L I M I N A R    U N   P R O D U C T O   D E   L A   V E N T A   E N   C U S O  -->
$(document).on('click', '.remove-btn', function() {
    const $barcode = $(this).closest('.add-discount-remove-btns').data('barcode');

    if (!$barcode) return;

    let saleInProgress = localStorage.getItem('saleInProgress');

    if (saleInProgress) {
        let saleArray = JSON.parse(saleInProgress);

        if (Array.isArray(saleArray)) {
            saleArray = saleArray.filter(p => p.codigo_barras_producto !== $barcode);

            localStorage.setItem('saleInProgress', JSON.stringify(saleArray));
        }

        if (saleArray.length < 1) localStorage.removeItem('saleInProgress');
    }


    showProductsList();
    showTotalPaymentAndCountProductsList();
});


// <!--  A Ñ A D I R   U N   P R O D U C T O   D E   L A   V E N T A   E N   C U S O  -->



// <!--  D E S C O N T A R   U N   P R O D U C T O   D E   L A   V E N T A   E N   C U S O  -->



// <!--   R E T R A S O   E N   L A S   P E T I C I O N E S   D E   B U S Q U E D A  -->
let time = null;
function busqueda(withTimeout = true)
{
    if (withTimeout) {
        clearTimeout(time);

        time = setTimeout(() => {
            buscar();
        }, 600);

    } else {
        buscar();
    }
}


// <!--   P E T I C I O N E S   D E   B U S Q U E D A   -->
function buscar()
{
    let product_search = document.getElementById('product_search').value.trim();
    let productScan = document.getElementById('product_scan').value.trim();
    let productosContainer = document.getElementById('products-list');

    if (product_search !== '' || productScan !== '') {
        const errorMessage = `
            <div class="registers-empty">
                <animated-icons
                    src="https://animatedicons.co/get-icon?name=Alert&style=minimalistic&token=4ff92fe8-3f2e-471b-beff-2c28789b1813"
                    trigger="loop"
                    attributes='{"variationThumbColour":"#536DFE","variationName":"Two Tone","variationNumber":2,"numberOfGroups":2,"backgroundIsGroup":false,"strokeWidth":1,"defaultColours":{"group-1":"#000000","group-2":"#536DFE","background":"#FFFFFF"}}'
                    height="120"
                    width="120"
                >
                </animated-icons>

                <p>LO SENTIMOS, OCURRIÓ UN ERROR AL CARGAR LOS PRODUCTOS.</p>
            </div>
        `;

        const params = { "product_search": product_search, "product_scan": productScan };

        $.ajax({
            data: params,
            type: 'POST',
            url: '../functions/buscar_productos.php',
            success: data => {
                let producto = '';

                try { producto = JSON.parse(data); }
                catch (error) { producto = null; }

                // SE ESCANÉO Y NO SE ENCONTRÓ RESULTADO
                if (productScan && !producto) {
                    productosContainer.innerHTML = data;

                    setInputStatusColor('error');
                    refreshProductScanInput(true);
                }

                // SE ESCANÉO Y SE OBTUVO RESULTADO
                if (productScan && producto) {
                    setInputStatusColor('success');

                    let existingProduct = saleInProgress.find(p => p.nombre_producto === producto.nombre_producto);

                    if (existingProduct) {
                        existingProduct.quantity++;

                        updateSubtotalProduct(existingProduct);

                    } else {
                        producto.quantity = 1;

                        updateSubtotalProduct(producto);

                        saleInProgress.push(producto);
                    }

                    localStorage.setItem('saleInProgress', JSON.stringify(saleInProgress));

                    refreshProductScanInput();

                    showProductsList();
                    showTotalPaymentAndCountProductsList();
                }

                // BUSCADOR
                if (product_search) {
                    productosContainer.innerHTML = data;
                    resizeButtonsObserver();
                }

            },
            error: (xhr, status, error) => {
                productosContainer.innerHTML = errorMessage;

                console.error('Error al buscar los productos:', error);
            }
        })
    }
}

