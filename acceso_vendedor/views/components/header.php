
<header class="header">
    <nav class="navbar">
        <!-- LOGO --> <!-- SIDEBAR OPEN BUTTON -->
        <div class="brand-logo-sidebar-button">
            <button id="sidebar-open-button">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg>
            </button>

            <img src="https://www.hubspot.com/hs-fs/hubfs/Shell_logo.svg.png?width=450&height=417&name=Shell_logo.svg.png" alt="brand-logo">
        </div>

        <!-- ENLACES -->
        <div class="nav-links-container">
            <div class="nav-links">
                <ul class="nav-links-list">
                    <li>
                        <a href="<?= SELLER_HTTP_VIEWS ?>dashboard" class="<?= strpos($_SERVER['PHP_SELF'], 'dashboard.php') ? 'active' : '' ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M360-160v-240h240v240H360Zm80-80h80v-80h-80v80ZM88-440l-48-64 440-336 160 122v-82h120v174l160 122-48 64-392-299L88-440Zm392 160Z"/></svg>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="<?= strpos($_SERVER['PHP_SELF'], 'notificaciones/create.php') ? 'active' : '' ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M80-560q0-100 44.5-183.5T244-882l47 64q-60 44-95.5 111T160-560H80Zm720 0q0-80-35.5-147T669-818l47-64q75 55 119.5 138.5T880-560h-80ZM160-200v-80h80v-280q0-83 50-147.5T420-792v-28q0-25 17.5-42.5T480-880q25 0 42.5 17.5T540-820v28q80 20 130 84.5T720-560v280h80v80H160Zm320-300Zm0 420q-33 0-56.5-23.5T400-160h160q0 33-23.5 56.5T480-80ZM320-280h320v-280q0-66-47-113t-113-47q-66 0-113 47t-47 113v280Z"/></svg>
                            <span>notificaciones</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="<?= strpos($_SERVER['PHP_SELF'], 'ajustes/create.php') ? 'active' : '' ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m370-80-16-128q-13-5-24.5-12T307-235l-119 50L78-375l103-78q-1-7-1-13.5v-27q0-6.5 1-13.5L78-585l110-190 119 50q11-8 23-15t24-12l16-128h220l16 128q13 5 24.5 12t22.5 15l119-50 110 190-103 78q1 7 1 13.5v27q0 6.5-2 13.5l103 78-110 190-118-50q-11 8-23 15t-24 12L590-80H370Zm70-80h79l14-106q31-8 57.5-23.5T639-327l99 41 39-68-86-65q5-14 7-29.5t2-31.5q0-16-2-31.5t-7-29.5l86-65-39-68-99 42q-22-23-48.5-38.5T533-694l-13-106h-79l-14 106q-31 8-57.5 23.5T321-633l-99-41-39 68 86 64q-5 15-7 30t-2 32q0 16 2 31t7 30l-86 65 39 68 99-42q22 23 48.5 38.5T427-266l13 106Zm42-180q58 0 99-41t41-99q0-58-41-99t-99-41q-59 0-99.5 41T342-480q0 58 40.5 99t99.5 41Zm-2-140Z"/></svg>
                            <span>ajustes</span>
                        </a>
                    </li>
                    <li>
                        <form action="<?= HTTP_URL ?>auth/logout" class="logout-form">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z"/></svg>
                            <button type="submit" class="capitalize">
                                cerrar sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
            <!-- PERFIL -->
            <div class="profile-access">
                <p>
                    <?=$auth_user ? "{$auth_user['nombres_credencial']} {$auth_user['apellidos_credencial']}" : 'Uknown user'?>
                </p>

                <a href="" class="<?= strpos($_SERVER['PHP_SELF'], 'inventario/create.php') ? 'active' : '' ?>">
                    <img src="<?= HTTP_URL ?>imgs_avatars/avatar-m5.jpg" alt="profile-picture">
                </a>
            </div>
        </div>
    </nav>
</header>

