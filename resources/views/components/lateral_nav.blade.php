<nav class="navbar navbar-expand-lb navbar-primary bg-primary">
  <div class="container-fluid bg-primary ">
    <a class="navbar-brand bg-primary " href="{{ asset('panel_control') }} "> <img src="{{ asset('images/Logos/Logotipo.png') }}" width="200" height="50" class="d-inline-block align-left img-fluid " alt="Logo"></a>
    <div class="dropdown">
                <a
                    href="#"
                    class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <img
                        src="{{asset('images/Usuarios/Usuario.jpg')}}"
                        alt=""
                        width="32"
                        height="32"
                        class="rounded-circle me-2" />
                    <strong>Administrador</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                    <li><a class="dropdown-item" href="#">Configuración</a></li>
                    <li><a class="dropdown-item" href="{{ asset('/Perfil') }}">Perfil</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
    <button class="navbar-toggler" type="button"
      data-bs-toggle="offcanvas"
      data-bs-target="#menuLateral">
      <span class="navbar-toggler-icon"></span>
    </button>
  </div>
</nav>