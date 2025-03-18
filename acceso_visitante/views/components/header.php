

<!-- Menú -->
<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container-fluid">
        <div class="offcanvas offcanvas-end offcanvas-custom" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">
                    Menú
                </h5>

                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?=HTTP_URL?>index.php">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#111"><path d="M360-160v-240h240v240H360Zm80-80h80v-80h-80v80ZM88-440l-48-64 440-336 160 122v-82h120v174l160 122-48 64-392-299L88-440Zm392 160Z"/></svg>
                            Inicio
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        
        <a class="navbar-brand" href="https://denedig.online/">
            <img src="<?=HTTP_URL?>imgs_denedig/denedig-removebg-preview.png" alt="Logo Denedig">
        </a>

        <button  style="display: none;" class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar ">
            <span class="navbar-toggler-icon"></span>
        </button>

    </div>
</nav>



