<?php require_once __DIR__ . '/../config.php'; ?>
<?php $_director_route = DOC_ROOT . 'acceso_director/views'; ?>
<?php $page_name = 'Director Dashboard' ?>

<!DOCTYPE html>
<html lang="en">
<?php require_once "$_director_route/modules/head.php" ?>
<body>

    <?php require_once "$_director_route/modules/header.php" ?>

    <?php require_once "$_director_route/modules/sidebar.php" ?>

    <main class="main-content director-main">
        <div class="dashboard-container director-dashboard">
            CONTEIDO DEL DASHBOARD
        </div>
    </main>

</body>
</html>
