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

// <--!     C A L E N D A R I O   F A L T P I C K R       !-->
flatpickr("#datepicker", {
    dateFormat: "Y-m-d",
    altInput: true,
    altFormat: "F j, Y",
    locale: "es",
});



// <--!     S E   C A R G A N    L O S   P E D I D O S       !-->
document.addEventListener('DOMContentLoaded', function() {
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
    document.getElementById('order-by-order').addEventListener('change', busqueda);
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
    const sucursalInput = document.getElementById('sucursal_datalist').value;
    const orderBy = document.getElementById('order-by-order').value;
    const fecha = document.querySelector('.search-order-by-date').value;

    const option = [...document.querySelectorAll('#sucursales option')].find(opt => opt.value === sucursalInput);
    const sucursal = option ? option.dataset.id : '';

    const params = { "busqueda": busqueda, "sucursal": sucursal, "fecha": fecha, "order_by": orderBy };

    $.ajax({
        data: params,
        type: 'POST',
        url: '../../../functions/buscar_pedidos.php',
        success: data => {
            document.getElementById('orders-container').innerHTML = data;
        },
        error: (xhr, status, error) => {
            document.getElementById('orders-container').innerHTML = `
                <div class="registers-empty">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M40.1 467.1l-11.2 9c-3.2 2.5-7.1 3.9-11.1 3.9C8 480 0 472 0 462.2L0 192C0 86 86 0 192 0S384 86 384 192l0 270.2c0 9.8-8 17.8-17.8 17.8c-4 0-7.9-1.4-11.1-3.9l-11.2-9c-13.4-10.7-32.8-9-44.1 3.9L269.3 506c-3.3 3.8-8.2 6-13.3 6s-9.9-2.2-13.3-6l-26.6-30.5c-12.7-14.6-35.4-14.6-48.2 0L141.3 506c-3.3 3.8-8.2 6-13.3 6s-9.9-2.2-13.3-6L84.2 471c-11.3-12.9-30.7-14.6-44.1-3.9zM160 192a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm96 32a32 32 0 1 0 0-64 32 32 0 1 0 0 64z"/></svg>
                    <p>LO SENTIMOS. NO SE PUDIERON CARGAR CORRECTAMENTE LOS PEDIDOS.</p>
                </div>
            `;
            console.error('Error al buscar los pedidos:', error);
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

    if (containerPos > windowWidth - 100)
        $container.addClass('inverted');
    else
        $container.removeClass('inverted');
});



// <--!     A P R O B A R   O R D E N       !-->
$(document).on('click', '.aproved-order-btn', function() {
    let pedidoID = $(this).data('order-id') || '';
    if (!pedidoID) return;

    const params = { order_id: pedidoID, accion: 'aprobar' };

    Swal.fire({
        showCancelButton: true,
        showConfirmButton: true,
        reverseButtons: true,
        cancelButtonColor: 'red',
        buttonsStyling: true,
        icon: 'question',
        toast: true,
        confirmButtonText: `
            <span class="swal-custom-text">Aprobar</span>
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m344-60-76-128-144-32 14-148-98-112 98-112-14-148 144-32 76-128 136 58 136-58 76 128 144 32-14 148 98 112-98 112 14 148-144 32-76 128-136-58-136 58Zm34-102 102-44 104 44 56-96 110-26-10-112 74-84-74-86 10-112-110-24-58-96-102 44-104-44-56 96-110 24 10 112-74 86 74 84-10 114 110 24 58 96Zm102-318Zm-42 142 226-226-56-58-170 170-86-84-56 56 142 142Z"/></svg>
        `,
        cancelButtonText: `
            <span class="swal-custom-text">Cancelar</span>
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m336-280 144-144 144 144 56-56-144-144 144-144-56-56-144 144-144-144-56 56 144 144-144 144 56 56ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
        `,
        html: `
            <div class="swal-custom-form !p-1 min-w-full text-black">
                <h3 class="!text-5xl !text-center">
                    Aprobar orden
                </h3>
            </div>
        `,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                data: params,
                type: 'POST',
                url: '../../../functions/crud_pedido.php',
                dataType: 'json',
                success: function(response) {
                    try {
                        var res = response;

                        if (res.status === "success") {
                            Toast.fire({
                                icon: res.status,
                                title: res.message
                            }).then(() => { busqueda() });
                        } else {
                            Toast.fire({
                                icon: res.status,
                                title: res.message
                            });
                        }
                    } catch (e) {
                        Toast.fire({
                            icon: res.status,
                            title: res.message
                        })
                    }
                },
                error: (xhr, status, error) => {
                    console.error("Error al cargar la orden:", error);

                    Toast.fire({
                        icon: "error",
                        title: "¡No se pudo aprobar la orden!"
                    });
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



// <--!     R E C H A Z A R   O R D E N       !-->
$(document).on('click', '.rejected-order-btn', function() {
    let pedidoID = $(this).data('order-id') || '';
    if (!pedidoID) return;

    const params = { order_id: pedidoID, accion: 'rechazar' };

    Swal.fire({
        showCancelButton: true,
        showConfirmButton: true,
        reverseButtons: true,
        cancelButtonColor: 'red',
        buttonsStyling: true,
        icon: 'question',
        toast: true,
        confirmButtonText: `
            <span class="swal-custom-text">Rechazar</span>
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q54 0 104-17.5t92-50.5L228-676q-33 42-50.5 92T160-480q0 134 93 227t227 93Zm252-124q33-42 50.5-92T800-480q0-134-93-227t-227-93q-54 0-104 17.5T284-732l448 448Z"/></svg>
        `,
        cancelButtonText: `
            <span class="swal-custom-text">Cancelar</span>
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m336-280 144-144 144 144 56-56-144-144 144-144-56-56-144 144-144-144-56 56 144 144-144 144 56 56ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
        `,
        html: `
            <div class="swal-custom-form !p-1 min-w-full text-black">
                <h3 class="!text-5xl !text-center">
                    Rechazar orden
                </h3>
            </div>
        `,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                data: params,
                type: 'POST',
                url: '../../../functions/crud_pedido.php',
                success: function(response) {
                    try {
                        var res = response;

                        if (res.status === "success") {
                            Toast.fire({
                                icon: res.status,
                                title: res.message
                            }).then(() => { busqueda() });
                        } else {
                            Toast.fire({
                                icon: res.status,
                                title: res.message
                            });
                        }
                    } catch (e) {
                        Toast.fire({
                            icon: res.status,
                            title: res.message
                        })
                    }
                },
                error: (xhr, status, error) => {
                    Toast.fire({
                        icon: "error",
                        title: "¡No se pudo rechazar la orden!"
                    });
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
