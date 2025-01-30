<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Escolar</title>
    <link rel="stylesheet" href="/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <!-- Llamada al header -->
    <?php include 'header.php'; ?>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container">
            <h1>Sistema Escolar</h1>
            <p>"Facilitamos la administración de estudiantes, docentes y actividades escolares."</p>
        </div>
    </section>

    <!-- Características -->
    <section class="features-section">
        <div class="container">
            <h2 class="text-center mb-5">Características del Sistema</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <i class="bi bi-person-plus"></i> Gestión de Estudiantes
                        </div>
                        <div class="card-body">
                            <p><i class="bi bi-person-plus"></i> Registro de estudiantes.</p>
                            <p><i class="bi bi-calendar-check"></i> Seguimiento de asistencia.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <i class="bi bi-person-badge"></i> Gestión de Docentes
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
                            <i class="bi bi-clipboard"></i> Gestión Escolar
                        </div>
                        <div class="card-body">
                            <p><i class="bi bi-clipboard"></i> Gestión de actividades.</p>
                            <p><i class="bi bi-folder-check"></i> Reportes y estadísticas.</p>
                        </div>
                    </div>
                </div>
                <!-- Botón -->
                <div class="text-center my-4">
                    <a href="login.php" class="btn btn-primary btn-lg" role="button">
                        <i class="bi bi-arrow-right"></i> Iniciar sesión
                    </a>
                </div>

            </div>
        </div>
        <button onclick="location.href='login_correo.php'" class="btn mt-3" style="color: #f8f9fa;">Login con correo</button>
    </section>

    <!-- Llamada al footer -->
    <?php include 'footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
