<?php $_views_route = HTTP_URL . 'acceso_director/views/' ?>
<aside class="sidebar-content">

    <!-- SIDEBAR WIDTH FULL -->
    <div class="sidebar-full">

        <div class="minimize minimize-btn">
            <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 -960 960 960"  fill="#e8eaed"><path d="m136-80-56-56 264-264H160v-80h320v320h-80v-184L136-80Zm344-400v-320h80v184l264-264 56 56-264 264h184v80H480Z"/></svg>
        </div>

        <div class="admin-profile-access">
            <div class="admin-picture">
                <img src="<?= HTTP_URL ?>acceso_director/storage/imgs/uploads/avatars/avatar-m2.jpg" alt="profile-picture">
            </div>
            <h2>
                <?= 'Admin name lastname' ?>
            </h2>
        </div>

        <div class="date-name-branch">
            <strong><?= $fecha ?></strong>
            <h1>
                SUCURSAL <?= 'EDOMEX - CARMELO PÉREZ' ?>
            </h1>
        </div>

        <div class="sidebar-links">
            <!-- INVENTARIO -->
            <details>
                <summary>inventario</summary>
                <div class="links">
                    <a href="">
                        <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 -960 960 960"  fill="#e8eaed"><path d="M200-80q-33 0-56.5-23.5T120-160v-451q-18-11-29-28.5T80-680v-120q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v120q0 23-11 40.5T840-611v451q0 33-23.5 56.5T760-80H200Zm0-520v440h560v-440H200Zm-40-80h640v-120H160v120Zm200 280h240v-80H360v80Zm120 20Z"/></svg>
                        Consultar stock
                    </a>
                </div>
            </details>

            <!-- VENTAS -->
            <details>
                <summary>ventas</summary>
                <div class="links">
                    <a href="">
                        <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 -960 960 960"  fill="#e8eaed"><path d="M240-80q-50 0-85-35t-35-85v-120h120v-560l60 60 60-60 60 60 60-60 60 60 60-60 60 60 60-60 60 60 60-60v680q0 50-35 85t-85 35H240Zm480-80q17 0 28.5-11.5T760-200v-560H320v440h360v120q0 17 11.5 28.5T720-160ZM360-600v-80h240v80H360Zm0 120v-80h240v80H360Zm320-120q-17 0-28.5-11.5T640-640q0-17 11.5-28.5T680-680q17 0 28.5 11.5T720-640q0 17-11.5 28.5T680-600Zm0 120q-17 0-28.5-11.5T640-520q0-17 11.5-28.5T680-560q17 0 28.5 11.5T720-520q0 17-11.5 28.5T680-480ZM240-160h360v-80H200v40q0 17 11.5 28.5T240-160Zm-40 0v-80 80Z"/></svg>
                        Consultar historial
                    </a>
                </div>
            </details>

            <!-- VENDEDORES -->
            <details>
                <summary>vendedores</summary>
                <div class="links">
                    <a href="">
                        <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 -960 960 960"  fill="#e8eaed"><path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17-62.5t47-43.5q60-30 124.5-46T480-440q67 0 131.5 16T736-378q30 15 47 43.5t17 62.5v112H160Zm320-400q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm160 228v92h80v-32q0-11-5-20t-15-14q-14-8-29.5-14.5T640-332Zm-240-21v53h160v-53q-20-4-40-5.5t-40-1.5q-20 0-40 1.5t-40 5.5ZM240-240h80v-92q-15 5-30.5 11.5T260-306q-10 5-15 14t-5 20v32Zm400 0H320h320ZM480-640Z"/></svg>
                        Consultar vendedores
                    </a>
                    <a href="<?= $_views_route ?>credenciales/create">
                        <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 -960 960 960"  fill="#e8eaed"><path d="M440-280h80v-160h160v-80H520v-160h-80v160H280v80h160v160ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z"/></svg>
                        Añadir vendedor
                    </a>
                </div>
            </details>

            <!-- INDICENCIAS -->
            <details>
                <summary>incidencias</summary>
                <div class="links">
                    <a href="">
                        <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 -960 960 960"  fill="#e8eaed"><path d="M467-360Zm-24 80ZM320-440h80v-120q0-33 23.5-56.5T480-640v-80q-66 0-113 47t-47 113v120ZM160-120q-33 0-56.5-23.5T80-200v-80q0-33 23.5-56.5T160-360h40v-200q0-117 81.5-198.5T480-840q117 0 198.5 81.5T760-560v43q-10-2-19.5-2.5T720-520q-11 0-20.5.5T680-517v-43q0-83-58.5-141.5T480-760q-83 0-141.5 58.5T280-560v200h187q-9 19-15 39t-9 41H160v80h283q3 21 9 41t15 39H160Zm560 80q-83 0-141.5-58.5T520-240q0-83 58.5-141.5T720-440q83 0 141.5 58.5T920-240q0 83-58.5 141.5T720-40Zm0-80q11 0 18-7t7-18q0-11-7-18t-18-7q-11 0-18 7t-7 18q0 11 7 18t18 7Zm-18-76h37v-10q0-11 5.5-19.5T758-242q14-12 22-23t8-31q0-29-19-46.5T720-360q-23 0-41.5 13.5T652-310l32 14q3-12 12.5-21t23.5-9q15 0 23.5 7.5T752-296q0 11-6 18.5T732-262q-6 6-12.5 12T708-236q-3 6-4.5 12t-1.5 14v14Z"/></svg>
                        Consultar incidencias internas
                    </a>
                    <a href="">
                        <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 -960 960 960"  fill="#e8eaed"><path d="M467-360Zm-24 80ZM320-440h80v-120q0-33 23.5-56.5T480-640v-80q-66 0-113 47t-47 113v120ZM160-120q-33 0-56.5-23.5T80-200v-80q0-33 23.5-56.5T160-360h40v-200q0-117 81.5-198.5T480-840q117 0 198.5 81.5T760-560v43q-10-2-19.5-2.5T720-520q-11 0-20.5.5T680-517v-43q0-83-58.5-141.5T480-760q-83 0-141.5 58.5T280-560v200h187q-9 19-15 39t-9 41H160v80h283q3 21 9 41t15 39H160Zm560 80q-83 0-141.5-58.5T520-240q0-83 58.5-141.5T720-440q83 0 141.5 58.5T920-240q0 83-58.5 141.5T720-40Zm-72-100 112-112v92h40v-160H640v40h92L620-168l28 28Z"/></svg>
                        Crear incidencia externa
                    </a>
                </div>
            </details>

            <!-- REPORTES -->
            <details>
                <summary>reportes</summary>
                <div class="links">
                    <a href="">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M760-120H200q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120ZM200-640h560v-120H200v120Zm100 80H200v360h100v-360Zm360 0v360h100v-360H660Zm-80 0H380v360h200v-360Z"/></svg>
                        Consultar estadísticas
                    </a>
                </div>
            </details>

        </div>

    </div>

    <!-- SIDEBAR WIDTH MINIMIZED -->
    <div class="sidebar-minimized">

        <div class="minimize minimize-btn">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M120-120v-320h80v184l504-504H520v-80h320v320h-80v-184L256-200h184v80H120Z"/></svg>
        </div>

        <div class="sidebar-links">
            <!-- INVENTARIO -->
            <div class="link">
                <a href="">
                    <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 -960 960 960"  fill="#e8eaed"><path d="M200-80q-33 0-56.5-23.5T120-160v-451q-18-11-29-28.5T80-680v-120q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v120q0 23-11 40.5T840-611v451q0 33-23.5 56.5T760-80H200Zm0-520v440h560v-440H200Zm-40-80h640v-120H160v120Zm200 280h240v-80H360v80Zm120 20Z"/></svg>
                </a>
            </div>
            <!-- VENTAS -->
            <div class="link">
                <a href="">
                    <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 -960 960 960"  fill="#e8eaed"><path d="M240-80q-50 0-85-35t-35-85v-120h120v-560l60 60 60-60 60 60 60-60 60 60 60-60 60 60 60-60 60 60 60-60v680q0 50-35 85t-85 35H240Zm480-80q17 0 28.5-11.5T760-200v-560H320v440h360v120q0 17 11.5 28.5T720-160ZM360-600v-80h240v80H360Zm0 120v-80h240v80H360Zm320-120q-17 0-28.5-11.5T640-640q0-17 11.5-28.5T680-680q17 0 28.5 11.5T720-640q0 17-11.5 28.5T680-600Zm0 120q-17 0-28.5-11.5T640-520q0-17 11.5-28.5T680-560q17 0 28.5 11.5T720-520q0 17-11.5 28.5T680-480ZM240-160h360v-80H200v40q0 17 11.5 28.5T240-160Zm-40 0v-80 80Z"/></svg>
                </a>
            </div>
            <!-- VENDEDORES -->
            <div class="link">
                <a href="">
                    <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 -960 960 960"  fill="#e8eaed"><path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17-62.5t47-43.5q60-30 124.5-46T480-440q67 0 131.5 16T736-378q30 15 47 43.5t17 62.5v112H160Zm320-400q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm160 228v92h80v-32q0-11-5-20t-15-14q-14-8-29.5-14.5T640-332Zm-240-21v53h160v-53q-20-4-40-5.5t-40-1.5q-20 0-40 1.5t-40 5.5ZM240-240h80v-92q-15 5-30.5 11.5T260-306q-10 5-15 14t-5 20v32Zm400 0H320h320ZM480-640Z"/></svg>
                </a>
            </div>
            <!-- INCIDENCIAS -->
            <div class="link">
                <a href="">
                    <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 -960 960 960"  fill="#e8eaed"><path d="M467-360Zm-24 80ZM320-440h80v-120q0-33 23.5-56.5T480-640v-80q-66 0-113 47t-47 113v120ZM160-120q-33 0-56.5-23.5T80-200v-80q0-33 23.5-56.5T160-360h40v-200q0-117 81.5-198.5T480-840q117 0 198.5 81.5T760-560v43q-10-2-19.5-2.5T720-520q-11 0-20.5.5T680-517v-43q0-83-58.5-141.5T480-760q-83 0-141.5 58.5T280-560v200h187q-9 19-15 39t-9 41H160v80h283q3 21 9 41t15 39H160Zm560 80q-83 0-141.5-58.5T520-240q0-83 58.5-141.5T720-440q83 0 141.5 58.5T920-240q0 83-58.5 141.5T720-40Zm0-80q11 0 18-7t7-18q0-11-7-18t-18-7q-11 0-18 7t-7 18q0 11 7 18t18 7Zm-18-76h37v-10q0-11 5.5-19.5T758-242q14-12 22-23t8-31q0-29-19-46.5T720-360q-23 0-41.5 13.5T652-310l32 14q3-12 12.5-21t23.5-9q15 0 23.5 7.5T752-296q0 11-6 18.5T732-262q-6 6-12.5 12T708-236q-3 6-4.5 12t-1.5 14v14Z"/></svg>
                </a>
            </div>
            <!-- REPORTES -->
            <div class="link">
                <a href="">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M760-120H200q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120ZM200-640h560v-120H200v120Zm100 80H200v360h100v-360Zm360 0v360h100v-360H660Zm-80 0H380v360h200v-360Z"/></svg>
                </a>
            </div>
        </div>

    </div>

</aside>

<!-- RESIZING SIDEBAR -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const minimizeBtns = document.querySelectorAll('.minimize-btn'); 
        const sidebarFull = document.querySelector('.sidebar-full');
        const sidebarMinimized = document.querySelector('.sidebar-minimized');

        minimizeBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                if (sidebarFull.classList.contains('minimized')) {
                    document.documentElement.style.setProperty('--sidebar-width', '250px');
                    sidebarFull.classList.remove('minimized');
                    sidebarMinimized.classList.remove('visible');
                } else {
                    document.documentElement.style.setProperty('--sidebar-width', '70px');
                    sidebarFull.classList.add('minimized');
                    sidebarMinimized.classList.add('visible');
                }
            });
        });
    });
</script>
