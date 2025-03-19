
<?php
require_once __DIR__ . '/../config.php';
require_once MATRIX_DOC_FNS . 'helpers/encrypt.php';
require_once MATRIX_DOC_FNS . 'helpers/clear.php';
require_once MATRIX_DOC_ROOT . 'database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    redirect();

function redirect()
{
    $redirect_ulr = $_SERVER['HTTP_REFERER'] ?? MATRIX_HTTP_VIEWS . 'dashboard';
    header("Location: $redirect_ulr");
    exit;
}

$busqueda = clearEntry($_POST['busqueda'] ?? '') ?: null;
$orden = clearEntry($_POST['order_by'] ?? '') ?: null;

$marcas = [];

$monditions = [];
$params = [];
$types = '';

$sql = "SELECT * FROM marcas";

if ($busqueda) {
    $monditions[] = "(nombre_marca LIKE ? OR descripcion_marca LIKE ?)";
    array_push($params, "%$busqueda%", "%$busqueda%");
    $types .= 'ss';
}

if (!empty($monditions)) { $sql .= " WHERE " . implode(" AND ", $monditions); }

$orden = match ($orden) {
    'recientes' => 'id_marca DESC',
    'antiguas' => 'id_marca ASC',
    'az' => 'nombre_marca ASC',
    'za' => 'nombre_marca DESC',
    default => 'id_marca DESC'
};

$sql .= " ORDER BY $orden LIMIT 14";

$marcas = simpleQuery($sql, $params, $types, true) ?: [];


if ($busqueda && empty($marcas)): ?>

    <div class="registers-empty">
        <animated-icons
            src="https://animatedicons.co/get-icon?name=search&style=minimalistic&token=12e9ffab-e7da-417f-a9d9-d7f67b64d808"
            trigger="loop"
            attributes='{"variationThumbColour":"#536DFE","variationName":"Two Tone","variationNumber":2,"numberOfGroups":2,"backgroundIsGroup":false,"strokeWidth":1,"defaultColours":{"group-1":"#000000","group-2":"#536DFE","background":"#FFFFFF"}}'
            height="200"
            width="200"
        >
        </animated-icons>

        <p>NO SE ENCONTRARON COINCIDENCIAS.</p>
    </div>

<?php elseif (!$busqueda && empty($marcas)): ?>

    <div class="registers-empty">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M40.1 467.1l-11.2 9c-3.2 2.5-7.1 3.9-11.1 3.9C8 480 0 472 0 462.2L0 192C0 86 86 0 192 0S384 86 384 192l0 270.2c0 9.8-8 17.8-17.8 17.8c-4 0-7.9-1.4-11.1-3.9l-11.2-9c-13.4-10.7-32.8-9-44.1 3.9L269.3 506c-3.3 3.8-8.2 6-13.3 6s-9.9-2.2-13.3-6l-26.6-30.5c-12.7-14.6-35.4-14.6-48.2 0L141.3 506c-3.3 3.8-8.2 6-13.3 6s-9.9-2.2-13.3-6L84.2 471c-11.3-12.9-30.7-14.6-44.1-3.9zM160 192a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm96 32a32 32 0 1 0 0-64 32 32 0 1 0 0 64z"/></svg>
        <p>AÚN NO HAY MARCAS REGISTRADOS.</p>
    </div>

<?php else:
    foreach ($marcas as $marca): ?>
        <!-- MARCO DEL REGISTRO -->
        <div class="register-frame category-frame">
            <!-- DETALLES -->
            <div
                class="register-details-link category-details-link open-register-details-modal"
                data-target=".register-details-modal"
                data-id="<?= encryptValue($marca['id_marca'], SECRETKEY) ?>"
            >
                <div class="register-details">
                    <div class="header-register">
                        <p>
                            <span><?= ucfirst($marca['nombre_marca']) ?></span>
                        </p>
                    </div>

                    <div class="body-register category-body-register">
                        <img src="<?= $marca['imagen_marca'] ?? 'https://cdn-icons-png.flaticon.com/512/1440/1440523.png' ?>" alt="brand image" loading="lazy">

                        <div class="quantities">
                            <p>
                                Descripción:
                                <span><?= ucfirst($marca['descripcion_marca']) ?></span>
                            </p>

                            <p>
                                Status:
                                <span><?= (int)$marca['status_marca'] === 0 ? 'Activa' : 'Inactiva'; ?></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <?php $m = encryptValue($marca['id_marca'], SECRETKEY) ?>
            <?php $status = (int)$marca['status_marca'] ?>

            <!-- ACCIONES -->
            <div class="register-actions-menu-container">
                <button class="menu-toggle" title="Opciones">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M120-240v-80h520v80H120Zm664-40L584-480l200-200 56 56-144 144 144 144-56 56ZM120-440v-80h400v80H120Zm0-200v-80h520v80H120Z"/></svg>
                </button>

                <div class="register-actions">
                    <a href="./edit?m=<?=$m?>" title="Editar">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-120v-170l527-526q12-12 27-18t30-6q16 0 30.5 6t25.5 18l56 56q12 11 18 25.5t6 30.5q0 15-6 30t-18 27L330-120H160Zm80-80h56l393-392-28-29-29-28-392 393v56Zm560-503-57-57 57 57Zm-139 82-29-28 57 57-28-29ZM560-120q74 0 137-37t63-103q0-36-19-62t-51-45l-59 59q23 10 36 22t13 26q0 23-36.5 41.5T560-200q-17 0-28.5 11.5T520-160q0 17 11.5 28.5T560-120ZM183-426l60-60q-20-8-31.5-16.5T200-520q0-12 18-24t76-37q88-38 117-69t29-70q0-55-44-87.5T280-840q-45 0-80.5 16T145-785q-11 13-9 29t15 26q13 11 29 9t27-13q14-14 31-20t42-6q41 0 60.5 12t19.5 28q0 14-17.5 25.5T262-654q-80 35-111 63.5T120-520q0 32 17 54.5t46 39.5Z"/></svg>
                    </a>

                    <button
                        type="button"
                        class="status-btn <?= $status === 0 ? 'inactive-btn' : 'active-btn' ?>"
                        title="Cambiar status"
                        data-id="<?=$m?>"
                    >
                        <?php if( $status === 0): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-240q-100 0-170-70T40-480q0-100 70-170t170-70h400q100 0 170 70t70 170q0 100-70 170t-170 70H280Zm0-80h400q66 0 113-47t47-113q0-66-47-113t-113-47H280q-66 0-113 47t-47 113q0 66 47 113t113 47Zm0-40q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35Zm200-120Z"/></svg>
                        <?php else: ?>
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-240q-100 0-170-70T40-480q0-100 70-170t170-70h400q100 0 170 70t70 170q0 100-70 170t-170 70H280Zm0-80h400q66 0 113-47t47-113q0-66-47-113t-113-47H280q-66 0-113 47t-47 113q0 66 47 113t113 47Zm400-40q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35ZM480-480Z"/></svg>
                        <?php endif; ?>
                    </button>
                </div>
            </div>
        </div>
    <?php endforeach;

endif;?>
