<nav class="navbar navbar-expand navbar-primary bg-primary padding-3">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-bs-toggle="dropdown" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="/"> <img src="{{ asset('images/Logos/Logotipo.png') }}" width="200" height="50" class="d-inline-block align-left img-fluid " alt="Logo"></a>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
    <ul class="navbar-nav justify-content-end mr-auto mt-2 mt-lg-0 align-right">
      <li class="nav-item active">
        <a class="nav-link" href="/">Bienvenido </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/Inicio_de_sesion">Inicio de sesión</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/registro">Registrarse</a>
      </li>

    </ul>
  </div>
  <div class="px-5 dropdown align-right img-fluid">
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Dropdown</a>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="#">Action</a></li>
        <li><a class="dropdown-item" href="#">Another action</a></li>
        <li>
          <hr class="dropdown-divider">
        </li>
        <li class="nav-item">
          <a class="dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
          </form>
        </li>
      </ul>
    </li>


    </ul>
  </div>
</nav>