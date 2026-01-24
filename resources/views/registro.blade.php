<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Corvisucre</title>
    <link rel="stylesheet" href="{{ asset('css/formulario.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        /* Reset y Distribución Principal */
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow: hidden;
        }

        .main-wrapper {
            display: flex;
            height: 100vh;
            width: 100%;
        }

        /* SECCIÓN IZQUIERDA (Zona Roja): Formulario */
        .left-section {
            flex: 1.4;
            /* Más ancho para la card */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .login-card {
            width: 100%;
            max-width: 550px;
            /* Card más ancha solicitada */
            padding: 45px;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        }

        .login-header h2 {
            margin: 0;
            color: #1e3a8a;
            font-size: 2rem;
        }

        .login-header p {
            color: #64748b;
            margin-bottom: 30px;
        }

        /* SECCIÓN DERECHA (Zona Azul): Collage y Logo */
        .right-section {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .collage-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            width: 80%;
            opacity: 0.3;
            /* Efecto de fondo */
        }

        /* Lado del Collage (Azul) */
        .collage-section {
            flex: 1;
            /* Ocupa el 50% */
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

        /* Cuadrícula de fotos para el collage */
        .photo-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            width: 80%;
            max-width: 500px;
        }


        .photo {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            aspect-ratio: 1 / 1;
            background-size: cover;
            background-position: center;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }


        .collage-item {
            background: rgba(255, 255, 255, 0.2);
            height: 200px;
            border-radius: 20px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Esto hace que la foto llene el cuadro sin deformarse */
            display: block;
        }

        .floating-logo {
            position: absolute;
            z-index: 10;
            max-width: 300px;
            filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.2));
        }

        /* Estilos de Error */
        .error-message {
            color: #ef4444;
            font-size: 0.75rem;
            margin-top: 4px;
            display: block;
            font-weight: 500;
            opacity: 0.9;
        }

        @media (max-width: 900px) {
            .right-section {
                display: none;
            }

            .left-section {
                flex: 1;
            }
        }

       /* Corrección de ancho y proporciones para el Registro */
#helpModal .modal-dialog {
    max-width: 750px !important; /* Forzamos el ancho para que no se vea flaco */
}

#helpModal .modal-content {
    background-color: #ffffff !important;
    border-radius: 15px !important;
    border: none !important;
}

#helpModal .modal-header {
    background-color: #212529 !important;
    color: white !important;
    padding: 12px 20px;
}

#helpModal .info-card {
    background: #ffffff !important;
    border: 1px solid #e2e8f0 !important;
    border-radius: 10px !important;
    padding: 20px;
    height: 100%;
    text-align: left !important;
}

/* Forzar que los textos dentro del modal sean oscuros y alineados */
#helpModal h4, #helpModal h6, #helpModal p, #helpModal strong, #helpModal li {
    color: #333 !important;
    text-align: left !important;
}

#helpModal .manual-container {
    background: #ffffff;
    border: 1px solid #0dcaf0;
    border-radius: 10px;
    padding: 15px 25px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

#helpModal .btn-download {
    border: 1px solid #dc3545;
    color: #dc3545 !important;
    padding: 6px 20px;
    border-radius: 6px;
    text-decoration: none;
    white-space: nowrap; /* Evita que el texto "Descargar" se rompa en dos líneas */
}

#helpModal .btn-download:hover {
    background: #dc3545;
    color: white !important;
}
    </style>
</head>

<body>


    @include('components.notificacion-modal')
    <div class="modal fade" id="helpModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-info-circle"></i>
                    <span class="modal-title">Información del Sistema</span>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <h3 class="fw-bold mb-1" style="color: #2563eb;">Gestión de Inventario</h3>
                    <span class="badge rounded-pill bg-light text-secondary border px-3">Versión 1.2.0 (2026)</span>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="info-card">
                            <h6 class="fw-bold mb-3"><i class="bi bi-stack"></i> Stack Tecnológico</h6>
                            <div class="tech-list">
                                <strong>Framework:</strong> Laravel 12<br>
                                <strong>Interfaz:</strong> Bootstrap 5<br>
                                <strong>Servidor/BD:</strong> XAMPP (Apache & MariaDB)<br>
                                <strong>Entorno:</strong> Web Responsive
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="info-card">
                            <h6 class="fw-bold mb-3"><i class="bi bi-code-slash"></i> Desarrollo</h6>
                            <div class="dev-box">
                                <span class="text-muted d-block mb-1" style="font-size: 0.75rem;">Programador Principal:</span>
                                <span class="fw-bold text-dark">BR. YEFFERSON CARABALLO</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="manual-container d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-file-earmark-pdf-fill text-danger fs-3"></i>
                        <div>
                            <h6 class="mb-0 fw-bold text-dark">Manual de Usuario</h6>
                            <p class="small text-muted mb-0">Guía completa de uso en formato PDF</p>
                        </div>
                    </div>
                    <a href="{{ asset('docs/manual_usuario.pdf') }}" class="btn-download" download>
                        <i class="bi bi-download"></i> Descargar
                    </a>
                </div>
            </div>

            <div class="modal-footer border-0 pb-4 justify-content-center">
                <button type="button" class="btn btn-primary rounded-pill px-5 shadow-sm" data-bs-dismiss="modal" style="background-color: #2563eb; border: none;">Entendido</button>
            </div>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <div class="main-wrapper">
        <section class="left-section">
            <div class="login-card">
                <div class="login-header">
                    <h2>Bienvenido</h2>
                    <p>Registra tu cuenta en Corvisucre</p>
                </div>

                <form method="POST" action="{{ route('register.post') }}" id="registrationForm" autocomplete="off" novalidate>
                    @csrf

                    <div class="form-group">
                        <div class="input-wrapper">
                            <input type="email" id="email" name="email" required>
                            <label for="email">Correo Electrónico</label>
                        </div>
                        <span class="error-message" id="emailError"></span>
                    </div>

                    <div style="display: flex; gap: 15px;">
                        <div class="form-group" style="flex: 1;">
                            <div class="input-wrapper">
                                <input type="text" id="firstname" name="firstname" autocomplete="off" required oninput="this.value = this.value.replace(/[0-9]/g, '')">
                                <label for="firstname">Nombre</label>
                            </div>
                            <span class="error-message" id="firstNameError"></span>
                        </div>
                        <div class="form-group" style="flex: 1;">
                            <div class="input-wrapper">
                                <input type="text" id="lastname" name="lastname" required autocomplete="off" oninput="this.value = this.value.replace(/[0-9]/g, '')">
                                <label for="lastname">Apellido</label>
                            </div>
                            <span class="error-message" id="lastNameError"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-wrapper password-wrapper">
                            <input type="password" id="password" name="password" required maxlength="14">
                            <label for="password">Contraseña</label>
                            <button type="button" class="password-toggle" onclick="togglePass('password')">👁️</button>
                        </div>
                        <span class="error-message" id="passwordError"></span>
                    </div>

                    <div class="form-group">
                        <div class="input-wrapper password-wrapper">
                            <input type="password" id="password_confirmation" name="password_confirmation" required maxlength="14">
                            <label for="password_confirmation">Confirmar Contraseña</label>
                            <button type="button" class="password-toggle" onclick="togglePass('password_confirmation')">👁️</button>
                        </div>
                        <span class="error-message" id="confirmError"></span>
                    </div>

                    <button type="submit" class="login-btn btn">Registrarse</button>
                </form>
                <div>
                    <p style="margin-top: 20px; text-align: center; color: #ffffff;">
                        ¿Ya tienes una cuenta?
                        <a href="{{ route('Inicio_sesion') }}" style="color: #3b82f6; text-decoration: none; font-weight: 600;">Inicia sesión</a>
                    </p>
                </div>
                <div style="text-align: center; margin-top: 10px;">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#helpModal" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.85rem;">
                        <i class="bi bi-question-circle"></i> Ayuda del sistema
                    </a>
                </div>
            </div>
        </section>

        <section class="right-section">
            <div class="collage-section">
                <div class="logo-container">
                    <img src="{{ asset(path: 'images/Logos/logo_corvisucre.png') }}" alt="Logo Empresa" class="brand-logo">
                </div>

                <div class="photo-grid">
                    <div class="photo item-3"><img src="{{ asset('images/collage/imagen3.png') }}" alt="Obra 3"></div>
                    <div class="photo item-2"><img src="{{ asset('images/collage/imagen2.png') }}" alt="Obra 2"></div>
                    <div class="photo item-4"><img src="{{ asset('images/collage/imagen4.png') }}" alt="Obra 4"></div>
                    <div class="photo item-1"><img src="{{ asset('images/collage/imagen1.png') }}" alt="Obra 1"></div>
                </div>
            </div>
        </section>
    </div>

    <script>
        function togglePass(id) {
            const el = document.getElementById(id);
            el.type = el.type === 'password' ? 'text' : 'password';
        }

        const form = document.getElementById('registrationForm');

        form.addEventListener('submit', function(e) {
            let isValid = true;

            // Limpiar errores previos
            document.querySelectorAll('.error-message').forEach(s => s.innerText = "");

            const passInput = document.getElementById('password');
            const confirmInput = document.getElementById('password_confirmation');
            const pass = passInput.value;
            const confirm = confirmInput.value;

            // 1. Verificar si están vacíos (NUEVA VALIDACIÓN)
            if (pass.trim() === "") {
                document.getElementById('passwordError').innerText = "La contraseña es obligatoria.";
                isValid = false;
            } else {
                // Si no está vacío, verificar Regex de seguridad
                const passRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]).{8,14}$/;
                if (!passRegex.test(pass)) {
                    document.getElementById('passwordError').innerText = "Debe tener 8-14 caracteres, una mayúscula, un número y un símbolo.";
                    isValid = false;
                }
            }

            if (confirm.trim() === "") {
                document.getElementById('confirmError').innerText = "Debes confirmar tu contraseña.";
                isValid = false;
            } else if (pass !== confirm) {
                // Solo si no está vacío, verificar coincidencia
                document.getElementById('confirmError').innerText = "Las contraseñas no coinciden.";
                isValid = false;
            }

            // Validaciones adicionales (Email y Nombres)
            const email = document.getElementById('email').value;
            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-z0-9]{2,}$/;
            if (!emailRegex.test(email)) {
                document.getElementById('emailError').innerText = "Correo electrónico no válido.";
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
            }
        });

        // Bloqueo de números en nombres
        document.querySelectorAll('#firstname, #lastname').forEach(inp => {
            inp.addEventListener('keypress', (e) => {
                if (/\d/.test(e.key)) e.preventDefault();
            });
        });
    </script>
</body>

</html>