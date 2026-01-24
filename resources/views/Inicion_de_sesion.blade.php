<!DOCTYPE html>
<html lang="eS">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
    <link rel="stylesheet" href="{{ asset(path: 'css/formulario.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        /* 1. Estructura General del Login */
        .main-wrapper {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        .collage-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .brand-logo {
            width: 220px;
            margin-bottom: 30px;
            filter: drop-shadow(0px 4px 10px rgba(0, 0, 0, 0.2));
        }

        .photo-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            width: 80%;
            max-width: 500px;
        }

        .photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
            display: block;
        }

        .form-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }

        /* 2. BLINDAJE PARA EL MODAL DE AYUDA (helpModal) */
        /* Esto asegura que sea ancho y con texto oscuro */
        #helpModal .modal-dialog {
            max-width: 750px !important;
        }

        #helpModal .modal-content {
            background: white !important;
            border-radius: 20px !important;
            max-width: none !important;
            /* Quita el límite de 400px del error */
            padding: 0 !important;
            text-align: left !important;
        }

        #helpModal .modal-header {
            background: #1e293b;
            color: white;
            border-radius: 20px 20px 0 0;
        }

        #helpModal .info-card {
            background: #f8fafc !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 12px;
            padding: 20px;
            height: 100%;
        }

        #helpModal h4,
        #helpModal h6,
        #helpModal p,
        #helpModal strong,
        #helpModal span {
            color: #1e293b !important;
        }

        #helpModal .manual-container {
            background: #ffffff;
            border: 1px solid #06b6d4;
            border-radius: 12px;
            padding: 15px 20px;
        }

        #helpModal .btn-download {
            border: 1px solid #ef4444;
            color: #ef4444 !important;
            padding: 6px 15px;
            border-radius: 6px;
            text-decoration: none;
        }

        /* 3. Validaciones de Inputs */
        .input-error {
            border-color: #ff4d4d !important;
            background-color: rgba(255, 77, 77, 0.1) !important;
        }

        .error-message {
            color: #ffffff;
            font-size: 11px;
            margin-top: 5px;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="modal fade" id="helpModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center gap-2">
                    <i class="bi bi-info-circle-fill"></i> Información del Sistema
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <h3 class="fw-bold mb-1" style="color: #2563eb;">Gestión de Inventario</h3>
                    <span class="badge bg-light text-dark border">Versión 1.0.0 (2026)</span>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="info-card">
                            <h6 class="fw-bold mb-2"><i class="bi bi-cpu"></i> Stack Tecnológico</h6>
                            <p class="small mb-1"><strong>Framework:</strong> Laravel 12</p>
                            <p class="small mb-1"><strong>Interfaz:</strong> Bootstrap 5</p>
                            <p class="small mb-0"><strong>Servidor:</strong> XAMPP</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-card">
                            <h6 class="fw-bold mb-2"><i class="bi bi-code-slash"></i> Desarrollo</h6>
                            <p class="small text-muted mb-0">Programador Principal:</p>
                            <p class="fw-bold mb-0">BR. YEFFERSON CARABALLO</p>
                        </div>
                    </div>
                </div>

                <div class="manual-container mt-4 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-file-earmark-pdf-fill text-danger fs-2"></i>
                        <div>
                            <h6 class="mb-0 fw-bold">Manual de Usuario</h6>
                            <p class="small text-muted mb-0">Guía completa en PDF</p>
                        </div>
                    </div>
                    <a href="{{ asset('docs/manual_usuario.pdf') }}" class="btn-download" download>
                        <i class="bi bi-download"></i> Descargar
                    </a>
                </div>
            </div>

            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-primary rounded-pill px-5" data-bs-dismiss="modal" style="background: #2563eb; border: none;">Entendido</button>
            </div>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <div class="main-wrapper">
        <div class="collage-section">

            <div class="logo-container">
                <img src="{{ asset(path: 'images/Logos/logo_corvisucre.png') }}" alt="Logo Empresa" class="brand-logo">
            </div>

            <div class="photo-grid">
                <div class="photo item-1"><img src="{{ asset('images/collage/imagen1.png') }}" alt="Obra 1"></div>
                <div class="photo item-2"><img src="{{ asset('images/collage/imagen2.png') }}" alt="Obra 2"></div>
                <div class="photo item-3"><img src="{{ asset('images/collage/imagen3.png') }}" alt="Obra 3"></div>
                <div class="photo item-4"><img src="{{ asset('images/collage/imagen4.png') }}" alt="Obra 4"></div>
            </div>
        </div>

        @include('components.notificacion-modal')
        <div class="form-section">
            <div class="login-card">
                <div class="login-header">
                    <h2>Bienvenido</h2>
                    <p>Inicia sesión en tu cuenta</p>
                </div>
                <form method="POST" action="{{ route('login.post') }}" class="login-form" id="loginForm" autocomplete="off" novalidate>
                    @csrf
                    <div class="form-group">
                        <div class="input-wrapper">
                            <input type="email" id="email" name="email" required maxlength="70" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z0-9]{2,}$" autocomplete="none">
                            <label for="email">Dirección de Correo Electrónico</label>
                            <span class="focus-border"></span>
                        </div>
                        <span class="error-message" id="emailError"></span>
                    </div>

                    <div class="form-group">
                        <div class="input-wrapper">
                            <input type="password" id="password" name="password" required minlength="8" maxlength="20">
                            <label for="password">Contraseña</label>
                            <span class="focus-border"></span>
                        </div>
                        <span class="error-message" id="passwordError"></span>
                    </div>

                    <div class="form-options " style="justify-content: center;">
                        <a href="{{ route('password.request') }}" class="forgot-password">¿Olvidaste tu contraseña?</a>
                    </div>

                    <button type="submit" class="login-btn btn">
                        <span class="btn-text">Iniciar sesión</span>
                        <span class="btn-loader"></span>
                    </button>
                </form>

                <div class="signup-link">
                    <p>No tienes una cuenta? <a href="/registro">Regístrate</a></p>
                    <p><a href="#" data-bs-toggle="modal" data-bs-target="#helpModal" class="text-white-50 small text-decoration-none">
                            <i class="bi bi-question-circle"></i> Ayuda del sistema
                        </a></p>
                </div>

                </form>

            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const loginForm = document.getElementById('loginForm');
            const emailInput = document.getElementById('email');

            // Función para mostrar el error personalizado
            const showError = (input, errorId, message) => {
                const errorSpan = document.getElementById(errorId);
                errorSpan.textContent = message;
                input.classList.add('input-error');
            };

            // Función para limpiar el error
            const clearError = (input, errorId) => {
                const errorSpan = document.getElementById(errorId);
                errorSpan.textContent = '';
                input.classList.remove('input-error');
            };

            // Validación en tiempo real para Email
            emailInput.addEventListener('input', () => {
                if (emailInput.validity.valid) {
                    clearError(emailInput, 'emailError');
                } else {
                    if (emailInput.validity.valueMissing) {
                        showError(emailInput, 'emailError', 'La dirección de correo es obligatoria.');
                    } else {
                        showError(emailInput, 'emailError', 'Ingresa un formato válido (ejemplo@correo.com).');
                    }
                }
            });


            // Al hacer clic en el botón "Iniciar sesión"
            loginForm.addEventListener('submit', (e) => {
                if (!loginForm.checkValidity()) {
                    e.preventDefault(); // Detiene el envío
                    // Disparamos los mensajes si intentan enviar vacío
                    emailInput.dispatchEvent(new Event('input'));
                }
            });
        });
    </script>

</body>

</html>