<!DOCTYPE html>
<html lang="eS">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
    <link rel="stylesheet" href="{{ asset(path: 'css/formulario.css') }}">
    <style>
        /* Contenedor principal para dividir la pantalla */
        .main-wrapper {
            display: flex;
            min-height: 100vh;
            width: 100%;
            /* Mantenemos tu fondo original aquí */
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

        /* Lado del Formulario (Rojo) */
        .form-section {
            flex: 1;
            /* Ocupa el otro 50% */
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* Mantenemos tu estilo de tarjeta "Glassmorphism" */
        .login-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }

        

        /* Clase que aplicaremos al input cuando falle */
        .input-error {
            border-color: #ff4d4d !important;
            background-color: rgba(255, 77, 77, 0.1) !important;
        }

        /* Estilo del mensaje de texto */
        .error-message {
            color: #000000;
            font-size: 12px;
            margin-top: 5px;
            opacity: 90%;
            display: block;
            min-height: 15px;
            /* Evita que el diseño de la tarjeta salte */
            font-weight: 600;
        }

        /* Cuando el input tiene foco O cuando tiene la clase has-content */
        .input-wrapper input:focus+label,
        .input-wrapper input.has-content+label {
            top: -10px;
            /* Ajusta este valor según tu diseño */
            font-size: 12px;
            color: #ffffff;
            /* O el color que prefieras para el texto arriba */
            transform: translateY(-50%);
            /* Si usas transform para centrar */
        }

        /* El overlay ahora cubre absolutamente todo */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.7);
            /* Fondo un poco más oscuro */
            backdrop-filter: blur(10px);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 99999;
            /* Valor máximo para estar sobre todo */
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 20px;
            text-align: center;
            width: 90%;
            max-width: 400px;
            position: relative;
            overflow: hidden;
            /* Para la barra de progreso */
        }

        /* Barra de progreso de 10 segundos */
        .progress-bar {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 5px;
            background: #ff4d4d;
            width: 100%;
            animation: timer 10s linear forwards;
        }

        .photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Esto hace que la foto llene el cuadro sin deformarse */
            display: block;
        }

        @keyframes timer {
            from {
                width: 100%;
            }

            to {
                width: 0%;
            }
        }

        /* Animación de entrada */
        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Ajuste para móviles */
        @media (max-width: 900px) {
            .main-wrapper {
                flex-direction: column;
            }

            .collage-section {
                display: none;
                /* Ocultamos el collage en móviles para dar prioridad al login */
            }
        }
    </style>
</head>

<body>
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