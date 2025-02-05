<?php require_once __DIR__ . '/config.php' ?>
<!DOCTYPE html>
<html lang="es">
<?php require_once DOC_ROOT . 'acceso_visitante/views/modules/head.php'; ?>
<body class="visitante-body">
    <?php require_once DOC_ROOT . 'acceso_visitante/views/modules/header.php'; ?>

    <main class="index-main">
        <section id="home" class="hero-section">
            <div class="container">
                <h1>Sistema Empresarial Integral</h1>
                <p>"La solución integral que optimiza tu negocio, conecta tus operaciones y potencia tu productividad."</p>
            </div>
        </section>

        <section class="features-section">
            <div class="container container-features">
                <h2 class="text-center mb-5">Características del Sistema</h2>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <div><i class="bi bi-person-plus"></i>
                                Gestión de Catálogos
                                </div>
                            </div>
                            <div class="card-body">
                                <p><i class="bi bi-person-plus"></i> .</p>
                                <p><i class="bi bi-calendar-check"></i> .</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                            <div>
                                <i class="bi bi-person-badge"></i>
                            Registro y monitoreo de incidencias.
                            </div>
                            </div>
                            <div class="card-body">
                                <p><i class="bi bi-person-badge"></i> Administración de horarios.</p>
                                <p><i class="bi bi-journal"></i> Control de evaluaciones.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <div><i class="bi bi-clipboard"></i>
                            Generacion de reportes finacieros y operativos
                            </div>
                            </div>
                            <div class="card-body">
                                <p><i class="bi bi-clipboard"></i> Gestión de actividades.</p>
                                <p><i class="bi bi-folder-check"></i> Reportes y estadísticas.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Botón -->
                    <div class="text-center my-4 login-button">
                        <a href="./auth/views/login-qr.php" class="btn btn-primary btn-lg" role="button">
                            <i class="bi bi-arrow-right"></i> Iniciar sesión
                        </a>
                        <button onclick="location.href='./auth/views/login.php'" class="btn mt-3" style="background-color: indigo; color:white;"><i class="bi bi-arrow-right"></i> Login con correo</button>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include DOC_ROOT . 'acceso_visitante/views/modules/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
