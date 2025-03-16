
let productosContainer = document.getElementById('products-list');

document.addEventListener("DOMContentLoaded", function () {

    // <!-- R E S I Z E S A B L E    W I N D O W S -->
    const resizer = document.querySelector(".resizer");
    const leftPanel = document.querySelector(".sale-details-container");
    const rightPanel = document.querySelector(".name_product_searcher-products-list-container");
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


    // <!-- R E Z I E   O B S E R V E R --> (products buttons)
    const productHeaders = document.querySelectorAll(".product-header");

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
        const totalPay = document.getElementById('total-pay').textContent;

        Swal.fire({
            title: "Cargando...",
            timer: 700,
            timerProgressBar: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            toast: true,
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
                    if (result.value) Swal.fire(JSON.stringify(result.value));

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

    productosContainer.innerHTML = `
        <div class="min-h-full items-center justify-center">
            <div class="denedig-logo">
                <img src="../../imgs_denedig/logo-denedig.png" alt="denedig logo">
                <img src="../../imgs_denedig/denedig.webp" alt="denedig logo">
            </div>
        </div>
    `;
});


// <!-- BUSCAR PRODUCTOS POR CODIGO DE BARRAS O NOMBRE SOLO AL PRESIONAR ENTER -->
$(document).on('keydown', '#name_product_searcher', function(event) {
    let producto = document.getElementById('name_product_searcher').value.trim() || '';

    if (event.key === 'Enter') {
        event.preventDefault();
        buscar();

    } else if (producto === '') {
        productosContainer.innerHTML = `
            <div class="min-h-full items-center justify-center">
                <div class="denedig-logo">
                    <img src="../../imgs_denedig/logo-denedig.png" alt="denedig logo">
                    <img src="../../imgs_denedig/denedig.webp" alt="denedig logo">
                </div>
            </div>
        `;
    }
});

function buscar()
{
    let producto = document.getElementById('name_product_searcher').value.trim() || '';

    if (producto !== '') {
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

        const params = { "producto": producto };

        $.ajax({
            data: params,
            type: 'POST',
            url: '../functions/buscar_productos.php',
            success: data => {
                productosContainer.innerHTML = data;
            },
            error: (xhr, status, error) => {
                productosContainer.innerHTML = errorMessage;

                console.error('Error al buscar los productos:', error);
            }
        })
    }
}

