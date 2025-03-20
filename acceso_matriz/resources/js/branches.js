
const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 2500,
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
    //  <-- SE CARGAN LAS sucursales -->
    busqueda();

    //  <-- SE LIMPIA EL BUSCADOR -->
    const erase = document.getElementById('erase-search');
    if (erase)
        erase.addEventListener('click', () => {
            document.getElementById('searcher').value = '';
            busqueda();
        });


    // <-- SE ORDENAN LAS sucursales -->
    document.getElementById('order-by-branches').addEventListener('change', busqueda);
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
    const orderBy = document.getElementById('order-by-branches').value;

    const params = { "busqueda": busqueda, "order_by": orderBy };

    $.ajax({
        data: params,
        type: 'POST',
        url: '../../functions/buscar_sucursales.php',
        success: data => {
            document.getElementById('branches-container').innerHTML = data;

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
            document.getElementById('branches-container').innerHTML = `
                <div class="registers-empty">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M40.1 467.1l-11.2 9c-3.2 2.5-7.1 3.9-11.1 3.9C8 480 0 472 0 462.2L0 192C0 86 86 0 192 0S384 86 384 192l0 270.2c0 9.8-8 17.8-17.8 17.8c-4 0-7.9-1.4-11.1-3.9l-11.2-9c-13.4-10.7-32.8-9-44.1 3.9L269.3 506c-3.3 3.8-8.2 6-13.3 6s-9.9-2.2-13.3-6l-26.6-30.5c-12.7-14.6-35.4-14.6-48.2 0L141.3 506c-3.3 3.8-8.2 6-13.3 6s-9.9-2.2-13.3-6L84.2 471c-11.3-12.9-30.7-14.6-44.1-3.9zM160 192a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm96 32a32 32 0 1 0 0-64 32 32 0 1 0 0 64z"/></svg>
                    <p>LO SENTIMOS. NO SE PUDIERON CARGAR CORRECTAMENTE LAS sucursales.</p>
                </div>
            `;
            console.error('Error al buscar sucursales:', error);
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
    let brancheId = $(this).data('id');

    if (!brancheId) return;

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
                url: '../../functions/crud_sucursal.php',
                method: 'POST',
                data: { s: brancheId, accion: 'status' },
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
                    console.error("Error al cargar la sucursal:", error);

                    Toast.fire({
                        icon: "error",
                        title: "¡No se encontró la sucursal!"
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
// <--      MODAL DETALLES DE UN REGISTRO       -->
$(document).on('click', '.open-register-details-modal ', function() {
    let modalClass = $(this).data('target');
    let modal = $(modalClass);
    let modalContainer = modal.find('.modal-container');

    let brancheId = $(this).data('id');

    $.ajax({
        url: '../../functions/crud_sucursal.php',
        method: 'GET',
        data: { s: brancheId, accion: 'detalles' },
        success: function(data) {
            console.log(data);

            try {
                if (data.status) {
                    Toast.fire({
                        icon: data.status,
                        title: data.message
                    });

                } else {
                    modal.addClass('show').removeClass('hide');
                    modalContainer.addClass('show').removeClass('hide');

                    $.each(data, function(key, value) {
                        let element = $('.' + key);

                        if (key === 'status_sucursal') {
                            let texto = value === 1 ? 'Inactiva' : 'Activa';
                            element.text(texto);
                        } else if (element) {
                            element.text(value);
                        }
                    });
                }
            } catch (error) {
                Toast.fire({
                    icon: data.status,
                    title: data.message
                });
            }
        },
        error: (xhr, status, error) => {
            console.error("Error al cargar la sucursal:", error);

            Toast.fire({
                icon: "error",
                title: "¡No se encontró la sucursal!"
            });
        }
    });
});
