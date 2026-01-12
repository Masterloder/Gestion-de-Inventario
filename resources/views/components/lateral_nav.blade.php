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



        <div class="d-flex align-items-center ms-auto justify-content-end bewteen-gap-3 p-3">
            <!-- Modal de Notificación -->
            <li class="nav-item dropdown list-unstyled me-3">
                <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell fs-5 text-white "></i>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ auth()->user()->unreadNotifications->count() }}
                    </span>
                    @endif
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="navbarDropdown" style="width: 600px; max-height: 400px; overflow-y: auto;">
                    <li class="dropdown-header border-bottom">Historial de Notificaciones</li>

                    @forelse(auth()->user()->notifications as $notification)
                    <li>
                        <a href="#" class="dropdown-item notificacion-link {{ $notification->read_at ? '' : 'unread-notif bg-light border-start border-primary border-4' }}"
                            data-id="{{ $notification->id }}">
                            <div class="d-flex align-items-center">
                                <i class="bi {{ $notification->data['icono'] }} {{ $notification->data['color'] }} fs-4 me-3"></i>
                                <div>
                                    <div class="fw-bold small">{{ $notification->data['titulo'] }}</div>
                                    <div class="text-muted extra-small">{{ $notification->data['mensaje'] }}</div>
                                    <small class="text-primary" style="font-size: 0.7rem;">{{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    @empty
                    <li class="p-3 text-center text-muted small">No tienes notificaciones</li>
                    @endforelse

                    <li><a class="dropdown-item text-center small text-primary fw-bold" href="{{ route('notificaciones.marcarLeidas') }}">Marcar todas como leídas</a></li>
                </ul>
            </li>
            <script>
                document.querySelectorAll('.notificacion-link').forEach(link => {
                    link.addEventListener('click', function(e) {
                        // 1. Verificamos si la notificación ya está marcada como leída localmente
                        // Si no tiene la clase 'unread-notif', significa que ya se leyó y no hacemos nada.
                        if (!this.classList.contains('unread-notif')) {
                            return;
                        }

                        e.preventDefault();

                        const elemento = this;
                        const notificationId = elemento.dataset.id;

                        // Evitamos que se procese dos veces mientras se espera al servidor
                        elemento.classList.remove('unread-notif');

                        fetch(`/notificaciones/leer/${notificationId}`, {
                                method: 'GET',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                            .then(response => {
                                if (response.ok) {
                                    // ÉXITO: Solo modificamos ESTE elemento
                                    elemento.classList.add('opacity-50');
                                    elemento.classList.remove('bg-light', 'border-primary', 'border-4');

                                    // Actualizamos el contador solo si existe el badge
                                    const badge = document.querySelector('.badge.bg-danger');
                                    if (badge) {
                                        let count = parseInt(badge.innerText);
                                        if (count > 1) {
                                            badge.innerText = count - 1;
                                        } else {
                                            badge.remove();
                                        }
                                    }
                                } else {
                                    // Si hubo error en el servidor, restauramos la clase para que el usuario pueda reintentar
                                    elemento.classList.add('unread-notif');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                elemento.classList.add('unread-notif');
                            });
                    });
                });
            </script>



            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('images/Usuarios/Usuario.jpg') }}" alt="Usuario" width="32" height="32" class="rounded-circle me-2" />
                    <span class="d-none d-sm-flex flex-column align-items-start">
                        <strong>{{ Auth::user()->name }}</strong>
                        <small class="text-white text-lowercase">{{ strtolower(Auth::user()->rol) }}</small>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser">
                    <li><a class="dropdown-item" href="{{ asset('configuracion') }}">Configuración</a></li>
                    <li><a class="dropdown-item" href="{{ asset('Perfil') }}">Perfil</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
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