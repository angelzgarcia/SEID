

let productos = JSON.parse(localStorage.getItem('productos')) || [];
let orderPriceValue = parseFloat(localStorage.getItem('orderPriceValue')) || 0.00;

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


    // <-- DISPLAY DE LA CANTIDAD DE PRODUCTOS ENVIADOS POR MATRIZ -->
    updateProductsOrderCount();
});



// <--!      R E T R A S O   E N   L A S   P E T I C I O N E S   D E   B U S Q U E D A     !-->
let time = null;
function busqueda() {
    clearTimeout(time);
    time = setTimeout(() => {
        buscar();
    }, 600);
}




// <--!      F I L T R O S   D E    B U S Q U E D A     !-->
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

            tippy('[title]', {
                content: (reference) => {
                    const title = reference.getAttribute('title');
                    reference.removeAttribute('title');
                    return title;
                },
                theme: 'light',
                arrow: true,
                animation: 'scale',
                delay: [500, 100],
            });
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




// <--!     M O S T R A R   A C C I O N E S   D E   C A D A   R E G I S T R O       !-->
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



// <--      C A M B I A R   S T A T U S       -->
$(document).on('click', '.status-btn ', function() {
    let productId = $(this).data('id');

    if (!productId) return;

    Swal.fire({
        title: "¿Cambiar status?",
        toast: true,
        icon: "question",
        position: 'center',
        iconColor: 'white',
        showCancelButton: true,
        showConfirmButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: 'Cancelar',
        confirmButtonText: "Sí, cambiar",
        customClass: {
            popup: 'colored-toast',
        },
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '../../functions/crud_producto.php',
                method: 'POST',
                data: { p: productId, accion: 'status' },
                dataType: 'json',
                success: function(response) {
                    try {
                        let res = response;

                        if (res.status === 'success') {
                            Toast.fire({
                                icon: 'success',
                                title: res.message,
                                timer: 1000
                            });
                            setTimeout(() => {
                                window.location.reload()
                            }, 1000);
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: res.message
                            });
                        }
                    } catch (error) {
                        Toast.fire({
                            icon: 'error',
                            title: res.message
                        });
                    }

                },
                error: (xhr, status, error) => {
                    console.error("Error al cargar el producto:", error);

                    Toast.fire({
                        icon: "error",
                        title: "¡No se encontró el producto!"
                    });
                }
            });

        } else {
            Toast.fire({
                icon: "info",
                title: "Operación cancelada",
                timer: 3000
            });
        }
    });
});





// <--!      V A L I D A R    U N I D A D E S    D E L   S T O C K      !-->
function validarUnidades(input) {
    input.value = input.value.replace(/^0+|[^0-9]/g, '');
}




// <--!      V E N T A N A S    M O D A L E S       !-->

// <--      CERRAR MODAL        -->
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


//  <--     MODAL PARA AÑADIR PRODUCTOS A UN PEDIDO     -->
$(document).on('click', '.add-stock-btn', function() {
    let id = $(this).data('product-id') || '';
    let name = $(this).data('product-name') || '';
    let stock = parseInt($(this).data('product-stock'),10) || 0;
    let buy = $(this).data('product-buy-type') || '';
    let price = $(this).data('product-sale-price') || 0.00;

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
                buy: buy,
                price: parseFloat(price),
            };
        }
    }).then((result) => {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 1200,
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
            let existingProduct = productos.find(p => p.name === result.value.name);

            (existingProduct) ? existingProduct.quantity += result.value.quantity : productos.push(result.value);

            orderPriceValue += result.value.quantity * result.value.price;
            localStorage.setItem('orderPriceValue', orderPriceValue.toFixed(2));
            localStorage.setItem('productos', JSON.stringify(productos));

            updateProductsOrderCount();

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


// <--      MODAL ORDEN EN CURSO        -->
$(document).on('click', '.open-order-modal ', function() {
    if (productos.length < 1) {
        Swal.fire({
            title: "No se han añadido productos al pedido....",
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
        });
        return;
    }

    const orderValue = document.getElementById('order-price-value');

    let modalClass = $(this).data('target');
    let modal = $(modalClass);
    let modalContainer = modal.find('.modal-container');

    modal.addClass('show').removeClass('hide');
    modalContainer.addClass('show').removeClass('hide');

    //  MOSTRAR LISTA DE PRODUCTOS
    showProductList();

    //  AÑADIR CANTIDAD DE PRODUCTO EN LA LISTA
    $(document).off('click', '.increase-product').on('click', '.increase-product', function() {
        let productCard = $(this).closest('.shipping-product-card');
        let name = productCard.data('name');
        const totalProducts = document.querySelector('.total-products-order-count');

        productos.forEach(producto => {
            if (producto.name == name) {
                producto.quantity++;
                orderPriceValue += producto.price;
                orderValue.innerHTML = orderPriceValue;
            }
        });

        localStorage.setItem('orderPriceValue', orderPriceValue.toFixed(2));
        localStorage.setItem('productos', JSON.stringify(productos));

        totalProducts.innerHTML = productos.reduce((acc, p) => acc + p.quantity, 0);

        showProductList();
    });

    //  DESCONTAR PRODUCTO EN LA LISTA
    $(document).off('click', '.decrease-product').on('click', '.decrease-product', function() {
        let productCard = $(this).closest('.shipping-product-card');
        let name = productCard.data('name');
        const totalProducts = document.querySelector('.total-products-order-count');

        productos.forEach(producto => {
            if (producto.name == name && producto.quantity > 1) {
                producto.quantity--;
                orderPriceValue -= producto.price;
                orderValue.innerHTML = orderPriceValue;
            }
        });

        localStorage.setItem('orderPriceValue', orderPriceValue.toFixed(2));
        localStorage.setItem('productos', JSON.stringify(productos));
        totalProducts.innerHTML = productos.reduce((acc, p) => acc + p.quantity, 0);

        showProductList();
    });

    //  ELIMINAR PRODUCTO DE LA LISTA
    $(document).on('click', '.remove-product', function() {
        let productCard = $(this).closest('.shipping-product-card');
        let name = productCard.data('name');

        let productToRemove = productos.find(p => p.name === name);
        if (!productToRemove) return;

        let productTotalValue = parseFloat(productToRemove.price) * parseInt(productToRemove.quantity, 0);
        orderPriceValue -= productTotalValue;

        orderPriceValue = Math.max(orderPriceValue, 0);
        orderValue.innerHTML = orderPriceValue.toFixed(2);

        productos = productos.filter(producto => producto.name != name);

        localStorage.setItem('productos', JSON.stringify(productos));
        localStorage.setItem('orderPriceValue', orderPriceValue.toFixed(2));

        showProductList();

        const circle = document.getElementById('count-list-products-circle');
        const span = document.querySelector('#count-list-products-circle span');
        const totalProducts = document.querySelector('.total-products-order-count');

        if (productos.length > 0) {
            let uniqueProducst = [...new Set(productos.map(p => p.name.toLowerCase().trim()))];

            circle.style.display = 'flex';
            span.innerHTML = uniqueProducst.length;

            totalProducts.innerHTML = productos.reduce((acc, p) => acc + p.quantity, 0);

        } else if (productos.length < 1) {
            circle.style.display = 'none';

            modal.addClass('hide').removeClass('show');
            modalContainer.addClass('hide').removeClass('show');

            producos = [];
            orderPriceValue = 0.00;
            localStorage.removeItem('productos');
            localStorage.removeItem('orderPriceValue');
        }
    });
});

//  MOSTRAR LA LISTA DE PRODUCTOS AÑADIDOS
function showProductList() {
    let groupedProducts = productos.reduce((acc, producto) => {
        let key = producto.name;

        if (!acc[key]) acc[key] = { ...producto };

        else acc[key].quantity += producto.quantity;

        return acc;
    }, {});

    document.getElementById('grid-list').innerHTML = Object.values(groupedProducts).map(producto => `
        <div class="shipping-product-card" data-id="${producto.id}" data-name="${producto.name}">
            <div class="product-details">
                <p>${producto.name}</p>
                <span class="product-quantity">
                    ${producto.quantity} ${producto.quantity === 1 ? producto.buy : producto.buy + 's'}
                </span>
                <input type="hidden" value="${producto.id}">
            </div>

            <div class="actions-btns">
                <button type="button" class="decrease-product" title="Descontar producto">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                        <path d="M200-440v-80h560v80H200Z"/>
                    </svg>
                </button>

                <button type="button" class="increase-product" title="Añadir producto">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                        <path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"/>
                    </svg>
                </button>

                <button type="button" class="remove-product" title="Quitar producto">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                        <path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/>
                    </svg>
                </button>
            </div>
        </div>
    `).reverse().join('');
}

// ACTUALIZAR CONTADORRES DE PRODUCTOS
function updateProductsOrderCount() {
    const circle = document.getElementById('count-list-products-circle');
    const span = document.querySelector('#count-list-products-circle span');
    const totalProducts = document.querySelector('.total-products-order-count');
    const orderValue = document.getElementById('order-price-value');

    if (!totalProducts) return;

    if (productos.length > 0) {
        totalProducts.innerHTML = productos.reduce((acc, p) => acc + p.quantity, 0);

        let uniqueProducst = [...new Set(productos.map(p => p.name.toLowerCase().trim()))];

        circle.style.display = 'flex';
        span.innerHTML = uniqueProducst.length;

        orderValue.innerHTML = orderPriceValue;

    } else {
        circle.style.display = 'none';
    }
}

// <--      ENVIAR Y PROCESAR PEDIDO MATRIZ => SUCURSAL        -->
$(document).on('click', '#send-order-btn', function() {
    let modal = $(this).closest('.modal-background');
    let modalContainer = modal.find('.modal-container');
    let branchSelected = $('#select-destination-branch').val();
    let branchSelectedId = $('#select-destination-branch option:selected').data('branch-id');
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 2000,
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

    if (!branchSelected || !branchSelectedId) {
        Toast.fire({
            icon: "warning",
            title: "¡No se ha seleccionado una sucursal!"
        });
        return;
    }

    Swal.fire({
        showCancelButton: true,
        confirmButtonText: "Confirmar orden",
        cancelButtonText: "Cancelar",
        reverseButtons: true,
        cancelButtonColor: 'red',
        buttonsStyling: true,
        confirmButtonText: `
            <span class="swal-custom-text">Confirmar orden</span>
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-160q-50 0-85-35t-35-85H60l18-80h113q17-19 40-29.5t49-10.5q26 0 49 10.5t40 29.5h167l84-360H262l17-80h441l-37 160h117l120 160-40 200h-80q0 50-35 85t-85 35q-50 0-85-35t-35-85H400q0 50-35 85t-85 35Zm357-280h193l4-21-74-99h-95l-28 120Zm-17-280-84 360 2-7 82-353ZM140-440v-120H40l140-200v120h100L140-440Zm140 200q17 0 28.5-11.5T320-280q0-17-11.5-28.5T280-320q-17 0-28.5 11.5T240-280q0 17 11.5 28.5T280-240Zm400 0q17 0 28.5-11.5T720-280q0-17-11.5-28.5T680-320q-17 0-28.5 11.5T640-280q0 17 11.5 28.5T680-240Z"/></svg>
        `,
        cancelButtonText: `
            <span class="swal-custom-text">Cancelar</span>
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m336-280 144-144 144 144 56-56-144-144 144-144-56-56-144 144-144-144-56 56 144 144-144 144 56 56ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
        `,
        html: `
            <div class="swal-custom-form !p-1 min-w-full text-black">
                <fieldset>
                    <legend >Sucursal de destino:</legend>
                </fieldset>
                <h3 class="!text-5xl">
                    ${branchSelected}
                </h3>
            </div>
        `,
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            url: '../../functions/crud_pedido.php',
            method: 'POST',
            data: { productos: productos, orderValue: orderPriceValue, sucursal: branchSelectedId, accion: 'guardar' },
            success: function(response) {
                try {
                    var res = response;

                    if (res.status === 'success') {
                        modal.addClass('hide').removeClass('show');
                        modalContainer.addClass('hide').removeClass('show');

                        productos = [];
                        orderPriceValue = 0.00;
                        localStorage.removeItem('productos');
                        localStorage.removeItem('orderPriceValue');

                        updateProductsOrderCount();
                        showProductList();

                        Toast.fire({
                            icon: res.status,
                            title: res.message
                        }).then(() => { busqueda() });
                    } else if (res.status === 'warning') {
                        Toast.fire({
                            position: 'center',
                            html:
                                "<div class='flex gap-3 flex-col justify-start items-center'>" +
                                    "<h3 class='flex gap-1.5 text-black mb-6 text-center text-4xl'>" +
                                        res.message +
                                    "</h3>" +
                                    "<strong class='text-black w-full flex items-start gap-2'>" +
                                        "<span>📌</span>" +
                                        res.p_name +
                                    "</strong>" +
                                    "<strong class='text-black w-full flex items-center gap-2'>" +
                                        "<span>🛒</span>" +
                                        res.p_add +
                                    "</strong>" +
                                    "<strong class='text-black w-full flex items-center gap-2'>" +
                                        "<span>📦</span>" +
                                        res.p_stock +
                                    "</strong>" +
                                "</div>",
                            toast: false,
                            timer: 5000,
                        });
                    } else {
                        Toast.fire({
                            icon: res.status,
                            title: res.message,
                        });
                    }
                } catch (e) {
                    console.error("Error al procesar la respuesta", e);
                    Toast.fire({
                        icon: "error",
                        title: "¡No se pudo resolver la respuesta del servidor!"
                    });
                }
            },
            error: function() {
                Swal.fire("Error", "No se pudo enviar el pedido", "error");
            }
        });
    } else {
        Toast.fire({
            icon: "info",
            title: "Operación cancelada"
        });
    }
    });
});


// <--      MODAL DETALLES DE UN REGISTRO       -->
$(document).on('click', '.open-register-details-modal ', function() {
    let modalClass = $(this).data('target');
    let modal = $(modalClass);
    let modalContainer = modal.find('.modal-container');

    let productId = $(this).data('id');

    $.ajax({
        url: '../../functions/crud_producto.php',
        method: 'GET',
        data: { p: productId, accion: 'detalles' },
        success: function(data) {
            try {
                if (data.status === 'error') {
                    Toast.fire({
                        icon: data.status,
                        title: data.message
                    });

                } else {
                    modal.addClass('show').removeClass('hide');
                    modalContainer.addClass('show').removeClass('hide');

                    $.each(data, function(key, value) {
                        let element = $('.' + key);

                        if (key === 'imagen_producto') {
                            $('.register-fact-image img').attr('src', value);
                        } else if (key === 'lotes') {
                            if (value.length === 0) {
                                $('.lotes').html('<p>No hay fechas de vencimientos para este producto</p>');
                            } else {
                                let lotesHtml = '<ul>';

                                value.forEach(lote => {
                                    let fecha = lote[0];
                                    let creado = lote[1];

                                    lotesHtml += `<li>Vence: ${fecha} | Añadido: ${creado}</li>`;
                                });

                                lotesHtml += '</ul>';
                                $('.lotes').html(lotesHtml);
                            }
                        } else if (key === 'cantidad_minima_mayoreo_producto') {
                            let texto = !value ? 'No aplica' : value;
                            element.text(texto);
                        } else if (key === 'aplica_mayoreo') {
                            let texto = value ? 'No aplica' : 'Aplica';
                            element.text(texto);
                        } else if (key === 'precio_mayoreo_producto') {
                            let texto = (parseInt(value,10) === 0 || !value) ? 'No aplica' : value;
                            element.text(texto);
                        } else if (key === 'status_producto') {
                            let texto = value === 1 ? 'Inactivo' : 'Activo';
                            element.text(texto);
                        } else if (element.length) {
                            element.text(value);
                        }

                        if (data.images && Array.isArray(data.images) && data.images.length > 0) {
                            $('.register-fact.images-history').show();
                            let imagesHtml = '';

                            data.images.forEach(img => {
                                imagesHtml += `<img src="${img}" alt="Imagen de historial" style="max-width: 100px; margin: 5px;">`;
                            });

                            $('.images-history-grid').html(imagesHtml);
                        } else {
                            $('.register-fact.images-history').hide();
                        }
                    });
                }
            } catch(e) {
                Toast.fire({
                    icon: data.status,
                    title: data.message
                });
            }

        },
        error: (xhr, status, error) => {
            console.error("Error al cargar el producto:", error);
            Toast.fire({
                icon: "error",
                title: "¡No se encontró el producto!"
            });
        }
    });
});
