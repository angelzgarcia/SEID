let productos = JSON.parse(localStorage.getItem('selectedProducts')) || [];

document.addEventListener('DOMContentLoaded', () => {
    //  <-- SE CARGAN LOS PORDUCTOS -->
    busqueda();


    //  <-- SE LIMPIA EL BUSCADOR -->
    const erase = document.getElementById('erase-search');
    if (erase)
        erase.addEventListener('click', () => {
            document.getElementById('searcher').value = '';
            busqueda();
        });


    // <-- SE ORDENAN LOS PRODUCTOS -->
    document.getElementById('order-by-products').addEventListener('change', busqueda);


    // <-- DISPLAY CANTIDAD DE PRODUCTOS ENVIADOS POR MATRIZ -->
    const circle = document.getElementById('count-list-products-circle');
    const span = document.querySelector('#count-list-products-circle span');
    if (productos.length > 0) {
        circle.style.display = 'flex'
        span.innerHTML = productos.length;
    } else {
        circle.style.display = 'none'
    }
});

// <- SE PONE UN RETRASO A LAS PETICIONES ->
let time = null;
function busqueda() {
    clearTimeout(time);
    time = setTimeout(() => {
        buscar();
    }, 600);
}

function buscar() {
    const busqueda = document.getElementById('searcher').value;
    const sucursal = document.getElementById('sucursal_datalist').value;
    const orderBy = document.getElementById('order-by-products').value;

    const params = { "busqueda": busqueda, "sucursal": sucursal, "order_by": orderBy };

    $.ajax({
        data: params,
        type: 'POST',
        url: '../../functions/buscar_productos.php',
        success: data => {
            document.getElementById('products-container').innerHTML = data;
        },
        error: (xhr, status, error) => {
            document.getElementById('products-container').innerHTML = `
                <div class="registers-empty">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M40.1 467.1l-11.2 9c-3.2 2.5-7.1 3.9-11.1 3.9C8 480 0 472 0 462.2L0 192C0 86 86 0 192 0S384 86 384 192l0 270.2c0 9.8-8 17.8-17.8 17.8c-4 0-7.9-1.4-11.1-3.9l-11.2-9c-13.4-10.7-32.8-9-44.1 3.9L269.3 506c-3.3 3.8-8.2 6-13.3 6s-9.9-2.2-13.3-6l-26.6-30.5c-12.7-14.6-35.4-14.6-48.2 0L141.3 506c-3.3 3.8-8.2 6-13.3 6s-9.9-2.2-13.3-6L84.2 471c-11.3-12.9-30.7-14.6-44.1-3.9zM160 192a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm96 32a32 32 0 1 0 0-64 32 32 0 1 0 0 64z"/></svg>
                    <p>LO SENTIMOS. NO SE PUDIERON CARGAR CORRECTAMENTE LOS PRODUCTOS.</p>
                </div>
            `;
            console.error('Error al buscar productos:', error);
        }
    });
}


//  <!--  M O S T R A R   A C C I O N E S   D E   C A D A   R E G I S T R O  -->
$(document).on('click', '.menu-toggle', function() {
    const $container = $(this).closest('.register-actions-menu-container');
    const $frame = $container.closest('.register-frame');
    $container.toggleClass('active');
    $frame.toggleClass('active');

    $('.register-actions-menu-container').not($container).removeClass('active');
    $('.register-frame').not($frame).removeClass('active');

    const windowWidth = $(window).width();
    const containerPos = $container.offset().left + $container.outerWidth();

    if (containerPos > windowWidth - 100) {
        $container.addClass('inverted');
    } else {
        $container.removeClass('inverted');
    }
});


function validarUnidades(input) {
    input.value = input.value.replace(/^0+|[^0-9]/g, '');
    validarBoton();
}


//  <!-- MODAL PARA AÑADIR PRODUCTOS A UN PEDIDO -->
let selectedProducts = JSON.parse(localStorage.getItem('selectedProducts')) || [];
$(document).on('click', '.add-stock-btn', function() {
    let id = $(this).data('product-id') || '';
    let name = $(this).data('product-name') || '';
    let stock = parseInt($(this).data('product-stock'),10) || 0;

    Swal.fire({
        title: "Añadir al pedido 📦",
        focusConfirm: false,
        allowOutsideClick: false,
        showCancelButton: true,
        confirmButtonText: `
            <span class="swal-custom-text">Añadir</span>
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M640-640h120-120Zm-440 0h338-18 14-334Zm16-80h528l-34-40H250l-34 40Zm184 270 80-40 80 40v-190H400v190Zm182 330H200q-33 0-56.5-23.5T120-200v-499q0-14 4.5-27t13.5-24l50-61q11-14 27.5-21.5T250-840h460q18 0 34.5 7.5T772-811l50 61q9 11 13.5 24t4.5 27v196q-19-7-39-11t-41-4v-122H640v153q-35 20-61 49.5T538-371l-58-29-160 80v-320H200v440h334q8 23 20 43t28 37Zm138 0v-120H600v-80h120v-120h80v120h120v80H800v120h-80Z"/></svg>
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
            <div class="swal-custom-form scf-stock">
                <fieldset>
                    <legend>Cantidad a enviar:</legend>
                    <input id="swal-stock" class="swal2-input" onInput="validarUnidades(this)" placeholder="Añada la cantidad al pedido en curso">

                    <div>
                        <h2
                            id="insufficient-stock"
                            style="color: red; font-size:medium; margin-block-start:1rem; display: none;"
                        >
                            ¡Existencias insuficientes!
                        </h2>
                    </div>
                </fieldset>
            </div>
        `,
        didOpen: () => {
            const inputStock = document.getElementById('swal-stock');
            const insufficientStockErrorMessage = document.getElementById('insufficient-stock');
            const confirmButton = Swal.getConfirmButton();

            function validarBoton() {
                let newStock = parseInt(inputStock.value, 10) || 0;

                confirmButton.disabled = (newStock < 1 || isNaN(newStock) || newStock > stock) ? true : false;

                insufficientStockErrorMessage.style.display = (newStock > stock) ? 'block' : 'none';
            }

            validarBoton();
            inputStock.addEventListener('input', validarBoton);
        },
        preConfirm: () => {
            return {
                name: name,
                id: id,
                quantity: parseInt(document.getElementById('swal-stock').value,10),
            };
        }
    }).then((result) => {
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

        if (result.isConfirmed) {
            selectedProducts.push(result.value);
            localStorage.setItem('selectedProducts', JSON.stringify(selectedProducts));
            const circle = document.querySelector('#count-list-products-circle span');
            circle.innerHTML = selectedProducts.length;

            Toast.fire({
                icon: "success",
                title: "¡Producto añadido!"
            });
        } else {
            Toast.fire({
                icon: "info",
                title: "Operación cancelada"
            });
        }
    });
});


// <--  C E R R A R   M O D A L -->
$(document).on('click', '.close-modal', function() {
    let modal = $(this).closest('.modal-background');
    let modalContainer = modal.find('.modal-container');

    modal.addClass('hide').removeClass('show');
    modalContainer.addClass('hide').removeClass('show');

    setTimeout(() => {
        modal.removeClass('show');
        modalContainer.removeClass('show');
    }, 300);
});

// <--  M O D A L   O R D E N   E N   C U R S O  -->
$(document).on('click', '.open-order-modal ', function() {
    let modalClass = $(this).data('target');
    let modal = $(modalClass);
    let modalContainer = modal.find('.modal-container');

    modal.addClass('show').removeClass('hide');
    modalContainer.addClass('show').removeClass('hide');
});

// <--  M O D A L   V E R   D E T A L L E S   D E   U N   R E G I S T R O  -->
$(document).on('click', '.open-register-details-modal ', function() {
    let modalClass = $(this).data('target');
    let modal = $(modalClass);
    let modalContainer = modal.find('.modal-container');

    modal.addClass('show').removeClass('hide');
    modalContainer.addClass('show').removeClass('hide');

    let productId = $(this).data('id');

    $.ajax({
        url: '../../functions/crud_producto.php',
        method: 'GET',
        data: {p: productId},
        success: function(data) {

            $('.product-name').text(data.nombre_producto);

        },
        error: (xhr, status, error) => {
            console.error("Error al cargar el producto:", error);

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
                icon: "error",
                title: "¡No se encontró el producto!"
            });
        }
    });
});
