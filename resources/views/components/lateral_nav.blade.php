<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid">

        <a class="navbar-brand me-4" href="{{ asset('/panel_de_control') }}">
            <img src="{{ asset('images/Logos/logotipoInver.png') }}" width="200" height="60" class="d-inline-block align-middle img-fluid" alt="Logo">
        </a>
        <div class="d-none d-lg-flex mx-auto col-lg-5">
            <form class="d-flex w-100" role="search">
                <div class="input-group">
                    <span class="input-group-text bg-secondary border-0 text-white">
                        <i class="bi bi-search"></i> </span>
                    <input class="form-control me-2 bg-secondary text-white border-0" type="search" placeholder="Search" aria-label="Search">
                </div>
            </form>
        </div>

        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuLateral" aria-controls="menuLateral" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="d-flex align-items-center ms-auto">

            <a href="#" class="text-white me-3 d-none d-md-block" title="Notificaciones">
                <i class="bi bi-bell fs-5"></i>
            </a>
            <a href="#" class="text-white me-3 d-none d-md-block" title="Mensajes">
                <i class="bi bi-envelope fs-5"></i>
            </a>

            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('images/Usuarios/Usuario.jpg') }}" alt="Usuario" width="32" height="32" class="rounded-circle me-2" />
                    <strong class="d-none d-sm-inline">Administrador</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser">
                    <li><a class="dropdown-item" href="#">Configuración</a></li>
                    <li><a class="dropdown-item" href="{{ asset('profile') }}">Perfil</a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li>
                        <a class="dropdown-item" href="{{ asset('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</nav>