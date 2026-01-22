<style>
    :root {
        --sidebar-width: 250px;
        --sidebar-collapsed-offset: 50px;
    }

    /* --- SIDEBAR OPTIMIZADO --- */
    /* Se usa una clase fija para evitar que el contenido "salte" */
    .sidebar-custom {
        width: var(--sidebar-width);
        height: 100vh;
        position: fixed;
        left: calc(-1 * (var(--sidebar-width) - 10px));
        /* Deja una pequeña pestaña visible */
        top: 0;
        z-index: 1050;
        background: #212529;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    }

    .sidebar-custom:hover {
        left: 0;
        box-shadow: 5px 0 15px rgba(0, 0, 0, 0.3);
    }

    /* Ajuste para el contenido principal */
    .main-content {
        transition: margin-left 0.3s ease;
        margin-left: 0;
        width: 100%;
        padding-top: 20px;
    }

    /* --- NOTIFICACIONES --- */
    .unread-notif {
        background-color: #f0f7ff !important;
        border-left: 4px solid #0d6efd !important;
        transition: background 0.3s;
    }

    .notificacion-link:hover {
        background-color: #e9ecef !important;
    }

    .extra-small {
        font-size: 0.75rem;
    }

    .text-wrap-custom {
        white-space: normal;
        max-width: 220px;
    }

    /* Badge flotante corregido */
    #badge-notificaciones {
        font-size: 0.65rem;
        padding: 0.35em 0.5em;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand me-4" href="{{ url('/panel_de_control') }}">
            <img src="{{ asset('images/Logos/logotipoInver.png') }}" width="200" height="60" class="d-inline-block align-middle img-fluid" alt="Logo">
        </a>

        <div class="d-flex align-items-center ms-auto">
            @can('admin-only')
            <div class="dropdown me-3">
                <a class="nav-link position-relative" href="#" id="NotificacionesBarra" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell fs-5 text-white"></i>
                    @php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
                    @if($unreadCount > 0)
                    <span id="badge-notificaciones" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $unreadCount }}
                    </span>
                    @endif
                </a>

                <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="NotificacionesBarra" style="width: 320px; max-height: 450px; overflow-y: auto;">
                    <li class="dropdown-header border-bottom d-flex justify-content-between align-items-center pb-2">
                        <span class="fw-bold">Notificaciones</span>
                        <a href="{{ route('notificaciones.marcarLeidas') }}" class="btn btn-sm btn-link text-primary p-0 text-decoration-none extra-small">Marcar todo</a>
                    </li>

                    <div id="contenedor-notificaciones">
                        @forelse(auth()->user()->notifications as $notification)
                        <li>
                            <a href="javascript:void(0)"
                                class="dropdown-item notificacion-link py-2 {{ $notification->read_at ? 'opacity-50' : 'unread-notif' }}"
                                data-id="{{ $notification->id }}">
                                <div class="d-flex align-items-start">
                                    <div class="me-3">
                                        <i class="bi {{ $notification->data['icono'] ?? 'bi-info-circle' }} {{ $notification->data['color'] ?? 'text-primary' }} fs-5"></i>
                                    </div>
                                    <div class="text-wrap-custom">
                                        <div class="fw-bold small text-dark">{{ $notification->data['titulo'] }}</div>
                                        <div class="text-muted extra-small mb-1">{{ $notification->data['mensaje'] }}</div>
                                        <div class="text-primary extra-small">
                                            <i class="bi bi-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        @empty
                        <li class="p-4 text-center text-muted small">
                            <i class="bi bi-bell-slash d-block fs-3 mb-2 opacity-50"></i>
                            No tienes notificaciones
                        </li>
                        @endforelse
                    </div>
                </ul>
            </div>
            @endcan

            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="UsuarioBarra" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('images/Usuarios/Usuario.jpg') }}" alt="User" width="32" height="32" class="rounded-circle me-2 border border-secondary" />
                    <span class="d-none d-sm-flex flex-column align-items-start me-1">
                        <strong class="lh-1" style="font-size: 0.85rem;"> {{ Auth::user()->firstname }}</strong>
                        <small class="text-white-50 text-lowercase" style="font-size: 0.7rem;">{{ Auth::user()->rol }}</small>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow" aria-labelledby="UsuarioBarra">
                    @can('admin-only')
                    <li><a class="dropdown-item" href="{{ url('/configuracion') }}"><i class="bi bi-gear me-2"></i>Configuración</a></li>
                    @endcan

                    <li><a class="dropdown-item" href="{{ url('/Perfil') }}"><i class="bi bi-person me-2"></i>Perfil</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        // Manejo de clicks en notificaciones (Delegación de eventos)
        const contenedorNotif = document.getElementById('contenedor-notificaciones');

        if (contenedorNotif) {
            contenedorNotif.addEventListener('click', function(e) {
                const link = e.target.closest('.notificacion-link');

                // Si no es un link o ya está leída, no hacemos nada
                if (!link || !link.classList.contains('unread-notif')) return;

                e.preventDefault();
                const notificationId = link.dataset.id;

                // Petición al servidor
                fetch(`/notificaciones/leer/${notificationId}`, {
                        method: 'GET', // O POST si tu ruta en Laravel lo requiere
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            // Actualizar UI: quitar estado de "no leído"
                            link.classList.remove('unread-notif');
                            link.classList.add('opacity-50');

                            // Actualizar el Badge
                            const badge = document.getElementById('badge-notificaciones');
                            if (badge) {
                                let count = parseInt(badge.innerText);
                                if (count > 1) {
                                    badge.innerText = count - 1;
                                } else {
                                    badge.remove();
                                }
                            }
                        }
                    })
                    .catch(error => console.error('Error al procesar notificación:', error));
            });
        }

        // Auto-mostrar Modal de Alerta si existe sesión
        @if(session('error') || session('success'))
        const modalEl = document.getElementById('alertModal');
        if (modalEl) {
            const alertModal = new bootstrap.Modal(modalEl);
            alertModal.show();
        }
        @endif
    });
</script>