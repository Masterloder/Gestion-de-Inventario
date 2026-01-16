<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Corvisucre</title>
    <link rel="stylesheet" href="{{ asset('css/formulario.css') }}">
    <style>
        /* Reset y Distribución Principal */
        body, html { margin: 0; padding: 0; height: 100%; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; overflow: hidden; }
        
        .main-wrapper {
            display: flex;
            height: 100vh;
            width: 100%;
        }

        /* SECCIÓN IZQUIERDA (Zona Roja): Formulario */
        .left-section {
            flex: 1.4; /* Más ancho para la card */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .login-card {
            width: 100%;
            max-width: 550px; /* Card más ancha solicitada */
            padding: 45px;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        }

        .login-header h2 { margin: 0; color: #1e3a8a; font-size: 2rem; }
        .login-header p { color: #64748b; margin-bottom: 30px; }

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
            opacity: 0.3; /* Efecto de fondo */
        }

        .collage-item {
            background: rgba(255, 255, 255, 0.2);
            height: 200px;
            border-radius: 20px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .floating-logo {
            position: absolute;
            z-index: 10;
            max-width: 300px;
            filter: drop-shadow(0 10px 20px rgba(0,0,0,0.2));
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
            .right-section { display: none; }
            .left-section { flex: 1; }
        }
    </style>
</head>
<body>

    @include('components.notificacion-modal')

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
                                <input type="text" id="firstname" name="firstname" required oninput="this.value = this.value.replace(/[0-9]/g, '')">
                                <label for="firstname">Nombre</label>
                            </div>
                            <span class="error-message" id="firstNameError"></span>
                        </div>
                        <div class="form-group" style="flex: 1;">
                            <div class="input-wrapper">
                                <input type="text" id="lastname" name="lastname" required oninput="this.value = this.value.replace(/[0-9]/g, '')">
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
            </div>
        </section>

        <section class="right-section">
            <img src="{{ asset('/public/images/Logos/logo_corvisucre.png') }}" alt="Logo Corvisucre" class="floating-logo">
            
            <div class="collage-container">
                <div class="collage-item"></div>
                <div class="collage-item"></div>
                <div class="collage-item"></div>
                <div class="collage-item"></div>
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
            const emailRegex = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z0-9]{2,}$/;
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
            inp.addEventListener('keypress', (e) => { if (/\d/.test(e.key)) e.preventDefault(); });
        });
    </script>
</body>
</html>