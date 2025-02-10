<?php require_once __DIR__ . '/../../config.php' ?>
<?php $page_name = ACCESO . 'Personal' ?>

<!DOCTYPE html>
<html lang="en">
<?php require_once MATRIX_DOC_VIEWS . "modules/head.php" ?>
<body>

    <?php require_once MATRIX_DOC_VIEWS . "/modules/header.php" ?>

    <?php require_once MATRIX_DOC_VIEWS . "/modules/sidebar.php" ?>

    <main class="main-content matriz-content inventory-content">

        <!-- FILTRAR INVENTARIOS POR SUCURSAL -->
        <form action="" class="subsidiaries-filter">
            <select name="" id="">
                <option disabled selected>Todas las sucursales</option>
                <option value="">Sucursal 1 Sucursal 1</option>
                <option value="">Sucursal 2</option>
                <option value="">Sucursal 3</option>
            </select>
        </form>

        <!-- CRUD -->
        <div class="crud-container">
            <!-- CRUD HEADER -->
            <div class="crud-header">
                <!-- HEADER SUPERIOR -->
                <div class="crud-top-header">
                    <div class="crud-tittle">
                        <h1>personal</h1>
                        <p>Consulte y gestione a los usuarios registrados</p>
                    </div>
                    <div class="crud-order-by">
                        <select name="" id="">
                            <option selected disabled>Ordenar por</option>
                            <option value="">Ver todos</option>
                            <option value="">Directores</option>
                            <option value="">Vendedores</option>
                            <option value="">Más recientes</option>
                            <option value="">A - Z</option>
                            <option value="">Z - A</option>
                        </select>
                    </div>
                    <a href="<?= MATRIX_HTTP_VIEWS ?>credenciales/create" class="crud-add-btn">
                        Añadir director
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

                        <select name="" id="">
                            <option value="">Acciones</option>
                            <option value="">Eliminar registros</option>
                        </select>

                    </form>

                    <form action="" class="crud-searcher">
                        <input type="text" name="" id="" placeholder="Buscar usuario.....">
                        <button type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/></svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- LISTA DE REGISTROS -->
            <div class="crud-grid">
                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link">
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
                    <div class="register-actions">
                        <a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-120v-170l527-526q12-12 27-18t30-6q16 0 30.5 6t25.5 18l56 56q12 11 18 25.5t6 30.5q0 15-6 30t-18 27L330-120H160Zm80-80h56l393-392-28-29-29-28-392 393v56Zm560-503-57-57 57 57Zm-139 82-29-28 57 57-28-29ZM560-120q74 0 137-37t63-103q0-36-19-62t-51-45l-59 59q23 10 36 22t13 26q0 23-36.5 41.5T560-200q-17 0-28.5 11.5T520-160q0 17 11.5 28.5T560-120ZM183-426l60-60q-20-8-31.5-16.5T200-520q0-12 18-24t76-37q88-38 117-69t29-70q0-55-44-87.5T280-840q-45 0-80.5 16T145-785q-11 13-9 29t15 26q13 11 29 9t27-13q14-14 31-20t42-6q41 0 60.5 12t19.5 28q0 14-17.5 25.5T262-654q-80 35-111 63.5T120-520q0 32 17 54.5t46 39.5Z"/></svg>
                        </a>
                        <form action="" class="destroy-btn">
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link">
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
                    <div class="register-actions">
                        <a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-120v-170l527-526q12-12 27-18t30-6q16 0 30.5 6t25.5 18l56 56q12 11 18 25.5t6 30.5q0 15-6 30t-18 27L330-120H160Zm80-80h56l393-392-28-29-29-28-392 393v56Zm560-503-57-57 57 57Zm-139 82-29-28 57 57-28-29ZM560-120q74 0 137-37t63-103q0-36-19-62t-51-45l-59 59q23 10 36 22t13 26q0 23-36.5 41.5T560-200q-17 0-28.5 11.5T520-160q0 17 11.5 28.5T560-120ZM183-426l60-60q-20-8-31.5-16.5T200-520q0-12 18-24t76-37q88-38 117-69t29-70q0-55-44-87.5T280-840q-45 0-80.5 16T145-785q-11 13-9 29t15 26q13 11 29 9t27-13q14-14 31-20t42-6q41 0 60.5 12t19.5 28q0 14-17.5 25.5T262-654q-80 35-111 63.5T120-520q0 32 17 54.5t46 39.5Z"/></svg>
                        </a>
                        <form action="" class="destroy-btn">
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link">
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
                    <div class="register-actions">
                        <a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-120v-170l527-526q12-12 27-18t30-6q16 0 30.5 6t25.5 18l56 56q12 11 18 25.5t6 30.5q0 15-6 30t-18 27L330-120H160Zm80-80h56l393-392-28-29-29-28-392 393v56Zm560-503-57-57 57 57Zm-139 82-29-28 57 57-28-29ZM560-120q74 0 137-37t63-103q0-36-19-62t-51-45l-59 59q23 10 36 22t13 26q0 23-36.5 41.5T560-200q-17 0-28.5 11.5T520-160q0 17 11.5 28.5T560-120ZM183-426l60-60q-20-8-31.5-16.5T200-520q0-12 18-24t76-37q88-38 117-69t29-70q0-55-44-87.5T280-840q-45 0-80.5 16T145-785q-11 13-9 29t15 26q13 11 29 9t27-13q14-14 31-20t42-6q41 0 60.5 12t19.5 28q0 14-17.5 25.5T262-654q-80 35-111 63.5T120-520q0 32 17 54.5t46 39.5Z"/></svg>
                        </a>
                        <form action="" class="destroy-btn">
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link">
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
                    <div class="register-actions">
                        <a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-120v-170l527-526q12-12 27-18t30-6q16 0 30.5 6t25.5 18l56 56q12 11 18 25.5t6 30.5q0 15-6 30t-18 27L330-120H160Zm80-80h56l393-392-28-29-29-28-392 393v56Zm560-503-57-57 57 57Zm-139 82-29-28 57 57-28-29ZM560-120q74 0 137-37t63-103q0-36-19-62t-51-45l-59 59q23 10 36 22t13 26q0 23-36.5 41.5T560-200q-17 0-28.5 11.5T520-160q0 17 11.5 28.5T560-120ZM183-426l60-60q-20-8-31.5-16.5T200-520q0-12 18-24t76-37q88-38 117-69t29-70q0-55-44-87.5T280-840q-45 0-80.5 16T145-785q-11 13-9 29t15 26q13 11 29 9t27-13q14-14 31-20t42-6q41 0 60.5 12t19.5 28q0 14-17.5 25.5T262-654q-80 35-111 63.5T120-520q0 32 17 54.5t46 39.5Z"/></svg>
                        </a>
                        <form action="" class="destroy-btn">
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link">
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
                    <div class="register-actions">
                        <a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-120v-170l527-526q12-12 27-18t30-6q16 0 30.5 6t25.5 18l56 56q12 11 18 25.5t6 30.5q0 15-6 30t-18 27L330-120H160Zm80-80h56l393-392-28-29-29-28-392 393v56Zm560-503-57-57 57 57Zm-139 82-29-28 57 57-28-29ZM560-120q74 0 137-37t63-103q0-36-19-62t-51-45l-59 59q23 10 36 22t13 26q0 23-36.5 41.5T560-200q-17 0-28.5 11.5T520-160q0 17 11.5 28.5T560-120ZM183-426l60-60q-20-8-31.5-16.5T200-520q0-12 18-24t76-37q88-38 117-69t29-70q0-55-44-87.5T280-840q-45 0-80.5 16T145-785q-11 13-9 29t15 26q13 11 29 9t27-13q14-14 31-20t42-6q41 0 60.5 12t19.5 28q0 14-17.5 25.5T262-654q-80 35-111 63.5T120-520q0 32 17 54.5t46 39.5Z"/></svg>
                        </a>
                        <form action="" class="destroy-btn">
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link">
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
                    <div class="register-actions">
                        <a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-120v-170l527-526q12-12 27-18t30-6q16 0 30.5 6t25.5 18l56 56q12 11 18 25.5t6 30.5q0 15-6 30t-18 27L330-120H160Zm80-80h56l393-392-28-29-29-28-392 393v56Zm560-503-57-57 57 57Zm-139 82-29-28 57 57-28-29ZM560-120q74 0 137-37t63-103q0-36-19-62t-51-45l-59 59q23 10 36 22t13 26q0 23-36.5 41.5T560-200q-17 0-28.5 11.5T520-160q0 17 11.5 28.5T560-120ZM183-426l60-60q-20-8-31.5-16.5T200-520q0-12 18-24t76-37q88-38 117-69t29-70q0-55-44-87.5T280-840q-45 0-80.5 16T145-785q-11 13-9 29t15 26q13 11 29 9t27-13q14-14 31-20t42-6q41 0 60.5 12t19.5 28q0 14-17.5 25.5T262-654q-80 35-111 63.5T120-520q0 32 17 54.5t46 39.5Z"/></svg>
                        </a>
                        <form action="" class="destroy-btn">
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link">
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
                    <div class="register-actions">
                        <a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-120v-170l527-526q12-12 27-18t30-6q16 0 30.5 6t25.5 18l56 56q12 11 18 25.5t6 30.5q0 15-6 30t-18 27L330-120H160Zm80-80h56l393-392-28-29-29-28-392 393v56Zm560-503-57-57 57 57Zm-139 82-29-28 57 57-28-29ZM560-120q74 0 137-37t63-103q0-36-19-62t-51-45l-59 59q23 10 36 22t13 26q0 23-36.5 41.5T560-200q-17 0-28.5 11.5T520-160q0 17 11.5 28.5T560-120ZM183-426l60-60q-20-8-31.5-16.5T200-520q0-12 18-24t76-37q88-38 117-69t29-70q0-55-44-87.5T280-840q-45 0-80.5 16T145-785q-11 13-9 29t15 26q13 11 29 9t27-13q14-14 31-20t42-6q41 0 60.5 12t19.5 28q0 14-17.5 25.5T262-654q-80 35-111 63.5T120-520q0 32 17 54.5t46 39.5Z"/></svg>
                        </a>
                        <form action="" class="destroy-btn">
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link">
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
                    <div class="register-actions">
                        <a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-120v-170l527-526q12-12 27-18t30-6q16 0 30.5 6t25.5 18l56 56q12 11 18 25.5t6 30.5q0 15-6 30t-18 27L330-120H160Zm80-80h56l393-392-28-29-29-28-392 393v56Zm560-503-57-57 57 57Zm-139 82-29-28 57 57-28-29ZM560-120q74 0 137-37t63-103q0-36-19-62t-51-45l-59 59q23 10 36 22t13 26q0 23-36.5 41.5T560-200q-17 0-28.5 11.5T520-160q0 17 11.5 28.5T560-120ZM183-426l60-60q-20-8-31.5-16.5T200-520q0-12 18-24t76-37q88-38 117-69t29-70q0-55-44-87.5T280-840q-45 0-80.5 16T145-785q-11 13-9 29t15 26q13 11 29 9t27-13q14-14 31-20t42-6q41 0 60.5 12t19.5 28q0 14-17.5 25.5T262-654q-80 35-111 63.5T120-520q0 32 17 54.5t46 39.5Z"/></svg>
                        </a>
                        <form action="" class="destroy-btn">
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link">
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
                    <div class="register-actions">
                        <a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-120v-170l527-526q12-12 27-18t30-6q16 0 30.5 6t25.5 18l56 56q12 11 18 25.5t6 30.5q0 15-6 30t-18 27L330-120H160Zm80-80h56l393-392-28-29-29-28-392 393v56Zm560-503-57-57 57 57Zm-139 82-29-28 57 57-28-29ZM560-120q74 0 137-37t63-103q0-36-19-62t-51-45l-59 59q23 10 36 22t13 26q0 23-36.5 41.5T560-200q-17 0-28.5 11.5T520-160q0 17 11.5 28.5T560-120ZM183-426l60-60q-20-8-31.5-16.5T200-520q0-12 18-24t76-37q88-38 117-69t29-70q0-55-44-87.5T280-840q-45 0-80.5 16T145-785q-11 13-9 29t15 26q13 11 29 9t27-13q14-14 31-20t42-6q41 0 60.5 12t19.5 28q0 14-17.5 25.5T262-654q-80 35-111 63.5T120-520q0 32 17 54.5t46 39.5Z"/></svg>
                        </a>
                        <form action="" class="destroy-btn">
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </main>

</body>
</html>
