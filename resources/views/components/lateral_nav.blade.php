<style>
    /* Estado colapsado: se esconde a la izquierda */
.sidebar-collapsed {
    width: 60px; /* Ancho mínimo para que se vea una pestaña o iconos */
    transition: all 0.3s ease-in-out;
    overflow: hidden;
    position: fixed;
    z-index: 1050;
    left: -50px; /* Esconde casi toda la barra */
}

/* El área sensible: cuando el mouse se acerca al borde izquierdo */
.sidebar-collapsed:hover {
    left: 0;
    width: 250px; /* Ancho real de tu sidebar */
    box-shadow: 5px 0 15px rgba(0,0,0,0.3);
}

/* Ajuste del contenido principal cuando la barra está colapsada */
.sidebar-collapsed ~ .main-content {
    margin-left: 0 !important;
    width: 100%;
}
</style>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand me-4" href="{{ url('/panel_de_control') }}">
            <img src="{{ asset('images/Logos/logotipoInver.png') }}" width="200" height="60" class="d-inline-block align-middle img-fluid" alt="Logo">
        </a>

        <div class="d-flex align-items-center ms-auto justify-content-end p-3">
            <li class="nav-item dropdown list-unstyled me-3">
                <a class="nav-link" href="#" id="NotificacionesBarra" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell fs-5 text-white"></i>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span id="badge-notificaciones" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="NotificacionesBarra" style="width: 300px; max-height: 400px; overflow-y: auto;">
                    <li class="dropdown-header border-bottom">Historial de Notificaciones</li>
                    <div id="contenedor-notificaciones">
                        @forelse(auth()->user()->notifications as $notification)
                        <li>
                            <a href="#" class="dropdown-item notificacion-link {{ $notification->read_at ? 'opacity-50' : 'unread-notif bg-light border-start border-primary border-4' }}"
                                data-id="{{ $notification->id }}">
                                <div class="d-flex align-items-center">
                                    <i class="bi {{ $notification->data['icono'] ?? 'bi-info-circle' }} {{ $notification->data['color'] ?? 'text-primary' }} fs-4 me-3"></i>
                                    <div style="white-space: normal;">
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
                    </div>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-center small text-primary fw-bold" href="{{ route('notificaciones.marcarLeidas') }}">Marcar todas como leídas</a></li>
                </ul>
            </li>

            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="UsuarioBarra" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('images/Usuarios/Usuario.jpg') }}" alt="Usuario" width="32" height="32" class="rounded-circle me-2" />
                    <span class="d-none d-sm-flex flex-column align-items-start">
                        <strong>{{ Auth::user()->name }}</strong>
                        <small class="text-white-50 text-lowercase">{{ strtolower(Auth::user()->rol) }}</small>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="UsuarioBarra">
                    <li><a class="dropdown-item" href="{{ url('/configuracion') }}">Configuración</a></li>
                    <li><a class="dropdown-item" href="{{ url('/Perfil') }}">Perfil</a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li>
                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar Sesión</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Lógica de Notificaciones
    document.querySelectorAll('.notificacion-link').forEach(link => {
        link.addEventListener('click', function(e) {
            if (!this.classList.contains('unread-notif')) return;
            
            e.preventDefault();
            const elemento = this;
            const notificationId = elemento.dataset.id;

            fetch(`/notificaciones/leer/${notificationId}`, {
                method: 'GET',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => {
                if (response.ok) {
                    elemento.classList.remove('unread-notif', 'bg-light', 'border-primary', 'border-4');
                    elemento.classList.add('opacity-50');
                    const badge = document.getElementById('badge-notificaciones');
                    if (badge) {
                        let count = parseInt(badge.innerText);
                        count > 1 ? badge.innerText = count - 1 : badge.remove();
                    }
                }
            }).catch(error => console.error('Error:', error));
        });
    });

    // Lógica del Modal de Alerta
    @if(session('error') || session('success'))
        const modalEl = document.getElementById('alertModal');
        if (modalEl) {
            const alertModal = new bootstrap.Modal(modalEl);
            alertModal.show();
        }
    @endif
});
</script>