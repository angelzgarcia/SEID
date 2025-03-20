<?php require_once __DIR__ . '/../../config.php' ?>
<?php $page_name = ACCESO . 'Personal' ?>

<!DOCTYPE html>
<html lang="en">
<?php require_once MATRIX_DOC_VIEWS . "modules/head.php" ?>
<body>

    <?php require_once MATRIX_DOC_VIEWS . "/modules/header.php" ?>

    <?php require_once MATRIX_DOC_VIEWS . "/modules/sidebar.php" ?>

    <main class="main-content matriz-content inventory-content">

        <!-- FILTRAR PERSONAL POR SUCURSAL -->
        <div class="searcher-links">
            <div class="subsidiaries-filter" autocomplete="off">
                <input
                    type="text" list="sucursales" name="sucursal_datalist" id="sucursal_datalist" placeholder="Buscar sucursal..."
                    onkeyup="busqueda();"
                >
                <datalist id="sucursales">
                    <?php if (!empty($sucursales)):

                        foreach ($sucursales as $suc):
                            $sucursal_name = ucwords($suc['nombre_sucursal']); ?>
                            <option value="<?= $sucursal_name ?>"  data-id="<?= encryptValue($suc['id_sucursal'], SECRETKEY) ?>">
                                <?= $sucursal_name ?>
                            </option>
                        <?php endforeach;

                    endif; ?>
                </datalist>

                <select name="sucursal_select" class="crud-header-select sucursal-select">
                    <?php if (empty($sucursales)): ?>

                        <option selected disabled>
                            No hay sucursales registradas
                        </option>

                    <?php else: ?>

                        <option value="" class="font-extrabold">
                            Todas las sucursales
                        </option>

                        <?php foreach ($sucursales as $suc): ?>
                            $sucursal_name = ucwords($suc['nombre_sucursal']); ?>
                            <option value="<?= $sucursal_name ?>">
                                <?= $sucursal_name ?>
                            </option>
                        <?php endforeach;

                    endif; ?>
                </select>
            </div>
        </div>

        <!-- CRUD -->
        <div class="crud-container">
            <!-- CRUD HEADER -->
            <div class="crud-header">
                <!-- HEADER SUPERIOR -->
                <div class="crud-top-header">
                    <div class="crud-tittle">
                        <div class="title-shortcut-inventory">
                            <h1>
                                personal
                                <a class="shortcut-link-btn <?= strpos($_SERVER['PHP_SELF'], 'credenciales/index') ? 'active' : '' ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M41 7C31.6-2.3 16.4-2.3 7 7S-2.3 31.6 7 41l72 72c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9L41 7zM599 7L527 79c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l72-72c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0zM7 505c9.4 9.4 24.6 9.4 33.9 0l72-72c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L7 471c-9.4 9.4-9.4 24.6 0 33.9zm592 0c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-72-72c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l72 72zM320 256a64 64 0 1 0 0-128 64 64 0 1 0 0 128zM212.1 336c-2.7 7.5-4.1 15.6-4.1 24c0 13.3 10.7 24 24 24l176 0c13.3 0 24-10.7 24-24c0-8.4-1.4-16.5-4.1-24c-.5-1.4-1-2.7-1.6-4c-9.4-22.3-29.8-38.9-54.3-43c-3.9-.7-7.9-1-12-1l-80 0c-4.1 0-8.1 .3-12 1c-.8 .1-1.7 .3-2.5 .5c-24.9 5.1-45.1 23-53.4 46.5zM175.8 224a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm-26.5 32C119.9 256 96 279.9 96 309.3c0 14.7 11.9 26.7 26.7 26.7l56.1 0c8-34.1 32.8-61.7 65.2-73.6c-7.5-4.1-16.2-6.4-25.3-6.4l-69.3 0zm368 80c14.7 0 26.7-11.9 26.7-26.7c0-29.5-23.9-53.3-53.3-53.3l-69.3 0c-9.2 0-17.8 2.3-25.3 6.4c32.4 11.9 57.2 39.5 65.2 73.6l56.1 0zM464 224a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"></path></svg>
                                </a>
                            </h1>
                        </div>

                        <p>
                            Consulte y gestione a los usuarios registrados
                        </p>
                    </div>

                    <div class="crud-order-by">
                        <select name="order-by-order" class="crud-header-select" id="order-by-order">
                            <option selected disabled>Ordenar por</option>
                            <option value="">Más recientes</option>
                            <option value="">Más antiguos</option>
                            <option value="">Activos</option>
                            <option value="">Inactivos</option>
                            <option value="">A - Z</option>
                            <option value="">Z - A</option>
                        </select>
                    </div>

                    <a href="<?= MATRIX_HTTP_VIEWS ?>credenciales/create" class="crud-add-btn">
                        Añadir usuario
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M440-120v-320H120v-80h320v-320h80v320h320v80H520v320h-80Z"/></svg>
                    </a>
                </div>

                <!-- HEADER INTERMEDIO -->
                <div class="crud-middle-header">
                    <div class="details">
                        <div class="summary">
                            <p>Usuarios registrados</p>
                            <span>52</span>
                        </div>
                        <div class="summary">
                            <p>Directores</p>
                            <span>09</span>
                        </div>
                        <div class="summary">
                            <p>Vendedores</p>
                            <span>43</span>
                        </div>
                    </div>
                </div>

                <!-- HEADER INFERIOR -->
                <div class="crud-bottom-header">
                    <form action="" class="delete-all-form">
                        <input type="checkbox" name="" id="">
                        <p>Seleccionar todo</p>

                        <select name="" class="crud-header-select">
                            <option value="">Acciones</option>
                            <option value="">Eliminar registros</option>
                        </select>
                    </form>

                    <!-- BUSCADOR -->
                    <div class="crud-searcher">
                        <input
                            type="text" id="searcher" placeholder="Buscar usuario..." autocomplete="off"
                            onkeyup="busqueda();">

                        <span id="erase-search">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                                <path d="m456-320 104-104 104 104 56-56-104-104 104-104-56-56-104 104-104-104-56 56 104 104-104 104 56 56Zm-96 160q-19 0-36-8.5T296-192L80-480l216-288q11-15 28-23.5t36-8.5h440q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H360ZM180-480l180 240h440v-480H360L180-480Zm400 0Z" />
                            </svg>
                        </span>

                        <button type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                                <path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- LISTA DE REGISTROS -->
            <div class="crud-grid">

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link open-register-details-modal">
                        <div class="register-details">
                            <div class="header-register user-header-info">
                                <p>Nombres del usuario</p>
                                <span>Apellidos del usuario</span>
                            </div>

                            <div class="body-register">
                                <img src="https://http2.mlstatic.com/D_NQ_NP_639610-MLM76545318391_052024-O.webp" alt="product-img">

                                <div class="quantities">
                                    <p>
                                        Teléfono
                                        <span>5617523128</span>
                                    </p>
                                    <p>
                                        Correo
                                        <span>usuario_prueba392@gmail.com</span>
                                    </p>
                                    <p>
                                        Sucursal
                                        <span>Jardín Balbuena, CDMX</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>

                    <!-- ACCIONES -->
                    <div class="register-actions-menu-container">
                        <button class="menu-toggle" title="Opciones">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M120-240v-80h520v80H120Zm664-40L584-480l200-200 56 56-144 144 144 144-56 56ZM120-440v-80h400v80H120Zm0-200v-80h520v80H120Z"/></svg>
                        </button>

                        <div class="register-actions">
                            <!-- EDITAR USUARIO -->
                            <a href="" title="Actualizar datos del usuario">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-120v-170l527-526q12-12 27-18t30-6q16 0 30.5 6t25.5 18l56 56q12 11 18 25.5t6 30.5q0 15-6 30t-18 27L330-120H160Zm80-80h56l393-392-28-29-29-28-392 393v56Zm560-503-57-57 57 57Zm-139 82-29-28 57 57-28-29ZM560-120q74 0 137-37t63-103q0-36-19-62t-51-45l-59 59q23 10 36 22t13 26q0 23-36.5 41.5T560-200q-17 0-28.5 11.5T520-160q0 17 11.5 28.5T560-120ZM183-426l60-60q-20-8-31.5-16.5T200-520q0-12 18-24t76-37q88-38 117-69t29-70q0-55-44-87.5T280-840q-45 0-80.5 16T145-785q-11 13-9 29t15 26q13 11 29 9t27-13q14-14 31-20t42-6q41 0 60.5 12t19.5 28q0 14-17.5 25.5T262-654q-80 35-111 63.5T120-520q0 32 17 54.5t46 39.5Z"/></svg>
                            </a>

                            <!-- CAMBIAS STATUS -->
                            <form
                                action="<?= MATRIX_HTTP_URL ?>functions/crud_credencial?p=<?=''?>"
                                class="status-btn <?= '' === 0 ? 'inactive-btn' : 'active-btn' ?>"
                                method="POST"
                                title="Cambiar status"
                                data-id="<?=''?>"
                            >
                                <input type="hidden" name="accion" value="modificar">

                                <button type="button" title="Cambiar status">
                                    <?php if( '' === 0): ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-240q-100 0-170-70T40-480q0-100 70-170t170-70h400q100 0 170 70t70 170q0 100-70 170t-170 70H280Zm0-80h400q66 0 113-47t47-113q0-66-47-113t-113-47H280q-66 0-113 47t-47 113q0 66 47 113t113 47Zm0-40q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35Zm200-120Z"/></svg>
                                    <?php else: ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-240q-100 0-170-70T40-480q0-100 70-170t170-70h400q100 0 170 70t70 170q0 100-70 170t-170 70H280Zm0-80h400q66 0 113-47t47-113q0-66-47-113t-113-47H280q-66 0-113 47t-47 113q0 66 47 113t113 47Zm400-40q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35ZM480-480Z"/></svg>
                                    <?php endif; ?>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <script src="<?= MATRIX_HTTP_URL ?>resources/js/credentials.js"></script>

    <script src="<?=MATRIX_HTTP_URL?>resources/js/tooltips.js"></script>
</body>
</html>
