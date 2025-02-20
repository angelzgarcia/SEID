
document.addEventListener('DOMContentLoaded', () => {
    // <!-- C A R G A R   P R O D U C T O S -->
    busqueda('');

    // <!-- L I M P I A R   B U S Q U E D A -->
    const erase = document.getElementById('erase-search');
    const search = document.getElementById('searcher');

    if (erase && search) {
        erase.addEventListener('click', () => {
            search.value = '';
            buscar(search.value);
        });
    }
});


// <!-- B U S C A D O R -->

let time = null;

function busqueda(busqueda)
{
    clearTimeout(time);
    time = setTimeout(() => {
        buscar(busqueda);
    }, 500);
}

function buscar(busqueda)
{
    var params = { "busqueda": busqueda };
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

