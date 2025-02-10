<?php require_once __DIR__ . '/../../config.php' ?>
<?php $page_name = ACCESO . 'Inventario' ?>

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
        <div class="crud-container incidences-container">
            <!-- CRUD HEADER -->
            <div class="crud-header">
                <!-- HEADER SUPERIOR -->
                <div class="crud-top-header">
                    <div class="crud-tittle">
                        <h1>Incidencias</h1>
                        <p>Consulte y de seguimiento a incidencias de las sucursales</p>
                    </div>
                    <div class="crud-order-by">
                        <select name="" id="">
                            <option selected disabled>Ordenar por</option>
                            <option value="">Ver todas</option>
                            <option value="">Resueltas</option>
                            <option value="">En proceso</option>
                            <option value="">Pendientes</option>
                            <option value="">Más recientes</option>
                        </select>
                    </div>
                </div>

                <!-- HEADER INTERMEDIO -->
                <div class="crud-middle-header">
                    <div class="details">
                        <div class="summary">
                            <p>N° incidencias</p>
                            <span>12</span>
                        </div>
                        <div class="summary">
                            <p>Incidencias resueltas</p>
                            <span>9</span>
                        </div>
                        <div class="summary">
                            <p>Incidencias pendientes</p>
                            <span>3</span>
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
                        <input type="text" name="" id="" placeholder="Buscar incidencia.....">
                        <button type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/></svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- GUIA DE COLORES DE INCIDENCIAS -->
            <div class="incidences-status-colors">
                <div class="pending-incident">
                    <div class="pending-incident-circle"><div></div></div>
                    <p>Pendientes</p>
                </div>

                <div class="in-progress-incident">
                    <div class="in-progress-incident-circle"><div></div></div>
                    <p>En proceso</p>
                </div>

                <div class="resolved-incident">
                    <div class="resolved-incident-circle"><div></div></div>
                    <p>Resueltas</p>
                </div>
            </div>

            <!-- LISTA DE REGISTROS -->
            <div class="crud-grid incidences-grid">
                                <!-- MARCO DEL REGISTRO -->
                                <div class="register-frame progress">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link">
                        <div class="register-details">
                            <div class="header-register">
                                <p>Titulo de la incidencia Titulo de la incidencia Titulo de la incidencia</p>
                                <span><?= $fecha ?></span>
                            </div>

                            <div class="body-register">
                                <div class="quantities incidence-details">
                                    <p>
                                        <span>Descripción:</span>
                                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Reprehenderit maxime, sequi accusantium rerum,
                                        assumenda animi consectetur iusto fugit vel repellat sed nulla. Nesciunt at dicta commodi neque ut architecto sequi.
                                    </p>
                                    <div>
                                        <p>
                                            Sucursal
                                            <span class="capitalize">
                                                Emiliano Zapata, 10 de Mayo, Ciudad de México, CDMX
                                            <span>
                                        </p>
                                        <p>
                                            Usuario
                                            <span>Director</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                
                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame resolved">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link">
                        <div class="register-details">
                            <div class="header-register">
                                <p>Titulo de la incidencia Titulo de la incidencia Titulo de la incidencia</p>
                                <span><?= $fecha ?></span>
                            </div>

                            <div class="body-register">
                                <div class="quantities incidence-details">
                                    <p>
                                        <span>Descripción:</span>
                                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Reprehenderit maxime, sequi accusantium rerum,
                                        assumenda animi consectetur iusto fugit vel repellat sed nulla. Nesciunt at dicta commodi neque ut architecto sequi.
                                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Reprehenderit maxime, sequi accusantium rerum,
                                        assumenda animi consectetur iusto fugit vel repellat sed nulla. Nesciunt at dicta commodi neque ut architecto sequi.
                                    </p>
                                    <div>
                                        <p>
                                            Sucursal
                                            <span class="capitalize">
                                                Emiliano Zapata, 10 de Mayo, Ciudad de México, CDMX
                                            <span>
                                        </p>
                                        <p>
                                            Usuario
                                            <span>Director</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame resolved">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link">
                        <div class="register-details">
                            <div class="header-register">
                                <p>Titulo de la incidencia Titulo de la incidencia Titulo de la incidencia</p>
                                <span><?= $fecha ?></span>
                            </div>

                            <div class="body-register">
                                <div class="quantities incidence-details">
                                    <p>
                                        <span>Descripción:</span>
                                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Reprehenderit maxime, sequi accusantium rerum,
                                        assumenda animi consectetur iusto fugit vel repellat sed nulla. Nesciunt at dicta commodi neque ut architecto sequi.
                                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Reprehenderit maxime, sequi accusantium rerum,
                                        assumenda animi consectetur iusto fugit vel repellat sed nulla. Nesciunt at dicta commodi neque ut architecto sequi.
                                    </p>
                                    <div>
                                        <p>
                                            Sucursal
                                            <span class="capitalize">
                                                Emiliano Zapata, 10 de Mayo, Ciudad de México, CDMX
                                            <span>
                                        </p>
                                        <p>
                                            Usuario
                                            <span>Director</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame pending">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link">
                        <div class="register-details">
                            <div class="header-register">
                                <p>Titulo de la incidencia Titulo de la incidencia Titulo de la incidencia</p>
                                <span><?= $fecha ?></span>
                            </div>

                            <div class="body-register">
                                <div class="quantities incidence-details">
                                    <p>
                                        <span>Descripción:</span>
                                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Reprehenderit maxime, sequi accusantium rerum,
                                        assumenda animi consectetur iusto fugit vel repellat sed nulla. Nesciunt at dicta commodi neque ut architecto sequi.
                                    </p>
                                    <div>
                                        <p>
                                            Sucursal
                                            <span class="capitalize">
                                                Emiliano Zapata, 10 de Mayo, Ciudad de México, CDMX
                                            <span>
                                        </p>
                                        <p>
                                            Usuario
                                            <span>Director</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame pending">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link">
                        <div class="register-details">
                            <div class="header-register">
                                <p>Titulo de la incidencia Titulo de la incidencia Titulo de la incidencia</p>
                                <span><?= $fecha ?></span>
                            </div>

                            <div class="body-register">
                                <div class="quantities incidence-details">
                                    <p>
                                        <span>Descripción:</span>
                                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Reprehenderit maxime, sequi accusantium rerum,
                                        assumenda animi consectetur iusto fugit vel repellat sed nulla. Nesciunt at dicta commodi neque ut architecto sequi.
                                    </p>
                                    <div>
                                        <p>
                                            Sucursal
                                            <span class="capitalize">
                                                Emiliano Zapata, 10 de Mayo, Ciudad de México, CDMX
                                            <span>
                                        </p>
                                        <p>
                                            Usuario
                                            <span>Director</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame progress">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link">
                        <div class="register-details">
                            <div class="header-register">
                                <p>Titulo de la incidencia Titulo de la incidencia Titulo de la incidencia</p>
                                <span><?= $fecha ?></span>
                            </div>

                            <div class="body-register">
                                <div class="quantities incidence-details">
                                    <p>
                                        <span>Descripción:</span>
                                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Reprehenderit maxime, sequi accusantium rerum,
                                        assumenda animi consectetur iusto fugit vel repellat sed nulla. Nesciunt at dicta commodi neque ut architecto sequi.
                                    </p>
                                    <div>
                                        <p>
                                            Sucursal
                                            <span class="capitalize">
                                                Emiliano Zapata, 10 de Mayo, Ciudad de México, CDMX
                                            <span>
                                        </p>
                                        <p>
                                            Usuario
                                            <span>Director</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame resolved">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link">
                        <div class="register-details">
                            <div class="header-register">
                                <p>Titulo de la incidencia Titulo de la incidencia Titulo de la incidencia</p>
                                <span><?= $fecha ?></span>
                            </div>

                            <div class="body-register">
                                <div class="quantities incidence-details">
                                    <p>
                                        <span>Descripción:</span>
                                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Reprehenderit maxime, sequi accusantium rerum,
                                        assumenda animi consectetur iusto fugit vel repellat sed nulla. Nesciunt at dicta commodi neque ut architecto sequi.
                                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Reprehenderit maxime, sequi accusantium rerum,
                                        assumenda animi consectetur iusto fugit vel repellat sed nulla. Nesciunt at dicta commodi neque ut architecto sequi.
                                    </p>
                                    <div>
                                        <p>
                                            Sucursal
                                            <span class="capitalize">
                                                Emiliano Zapata, 10 de Mayo, Ciudad de México, CDMX
                                            <span>
                                        </p>
                                        <p>
                                            Usuario
                                            <span>Director</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- MARCO DEL REGISTRO -->
                <div class="register-frame pending">
                    <!-- DETALLES -->
                    <a href="" class="register-details-link">
                        <div class="register-details">
                            <div class="header-register">
                                <p>Titulo de la incidencia Titulo de la incidencia Titulo de la incidencia</p>
                                <span><?= $fecha ?></span>
                            </div>

                            <div class="body-register">
                                <div class="quantities incidence-details">
                                    <p>
                                        <span>Descripción:</span>
                                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Reprehenderit maxime, sequi accusantium rerum,
                                        assumenda animi consectetur iusto fugit vel repellat sed nulla. Nesciunt at dicta commodi neque ut architecto sequi.
                                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Reprehenderit maxime, sequi accusantium rerum,
                                        assumenda animi consectetur iusto fugit vel repellat sed nulla. Nesciunt at dicta commodi neque ut architecto sequi.
                                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Reprehenderit maxime, sequi accusantium rerum,
                                        assumenda animi consectetur iusto fugit vel repellat sed nulla. Nesciunt at dicta commodi neque ut architecto sequi.
                                        assumenda animi consectetur iusto fugit vel repellat sed nulla. Nesciunt at dicta commodi neque ut architecto sequi.
                                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Reprehenderit maxime, sequi accusantium rerum,
                                        assumenda animi consectetur iusto fugit vel repellat sed nulla. Nesciunt at dicta commodi neque ut architecto sequi.
                                    </p>
                                    <div>
                                        <p>
                                            Sucursal
                                            <span class="capitalize">
                                                Emiliano Zapata, 10 de Mayo, Ciudad de México, CDMX
                                            <span>
                                        </p>
                                        <p>
                                            Usuario
                                            <span>Director</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </main>

</body>
</html>
