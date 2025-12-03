<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container"> 
        <a class="navbar-brand" href="{{ asset('/panel_de_control') }}">
            <img src="{{ asset('images/Logos/logotipoInver.png') }}" 
                 class="d-inline-block align-middle img-fluid" 
                 alt="Logo" 
                 style="max-height: 60px;">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav"> 
            
            <ul class="navbar-nav ms-auto me-lg-3"> <li class="nav-item">
                    <a class="nav-link text-uppercase" href="#">Persona</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase" href="#">Institución</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase" href="#">Administración Pública</a>
                </li>
            </ul>

            <a href="{{ asset("/registro") }}" class="btn btn-primary btn-md text-uppercase">
                Registro
            </a>
        </div>
        
    </div>
</nav>