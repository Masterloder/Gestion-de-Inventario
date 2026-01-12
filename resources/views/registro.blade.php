<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
    <link rel="stylesheet" href="{{ asset(path: 'css/formulario.css') }}">
</head>
<body>
    @if ($errors->any())
                <div class="notification-container">
                    <div class="notification alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <style>
                    .notification-container {
                        position: fixed;
                        right: 40px;
                        bottom: 30px;
                        z-index: 9999;
                        display: flex;
                        flex-direction: column;
                        align-items: flex-end;
                    }
                    .notification {
                        background: #f8d7da;
                        color: #721c24;
                        border: 1px solid #f5c6cb;
                        border-radius: 6px;
                        padding: 16px 24px;
                        margin-top: 10px;
                        min-width: 300px;
                        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                        font-size: 16px;
                        animation: fadeInUp 0.5s;
                    }
                    @keyframes fadeInUp {
                        from { opacity: 0; transform: translateY(30px);}
                        to { opacity: 1; transform: translateY(0);}
                    }
                </style>
                <script>
                    setTimeout(function() {
                        var notif = document.querySelector('.notification-container');
                        if (notif) notif.style.display = 'none';
                    }, 5000);
                </script>
            @endif
    <div class="login-container">
        
        <div class="login-card">
            <div class="login-header">
                <h2>Bienvenido</h2>
                <p>Registra tu cuenta <p>
            </div>

            
            <form method="POST" action="{{ route('register.post') }}" class="login-form" id="loginForm" >
                @csrf
                <div class="form-group">
                    <div class="input-wrapper">
                        <input type="email" id="email" name="email" required autocomplete="email" maxlength="80">
                        <label for="email">Dirección de Correo Electrónico</label>
                        <span class="focus-border"></span>
                    </div>
                    <span class="error-message" id="emailError"></span>
                </div>
                <div class="form-group">
                    <div class="input-wrapper">
                        <input type="text" id="firsname" name="firsname" required maxlength="20">
                        <label for="firsname">Nombre</label>
                        <span class="focus-border"></span>
                    </div>
                    <span class="error-message" id="firstNameError"></span>
                </div>
                <div class="form-group">
                    <div class="input-wrapper">
                        <input type="text" id="lastname" name="lastname" required maxlength="20">
                        <label for="lastname">Apellido</label>
                        <span class="focus-border"></span>
                    </div>
                    <span class="error-message" id="lastNameError"></span>
                </div>
                <div class="form-group">
                    <div class="input-wrapper password-wrapper">
                        <input type="password" id="password" name="password" required autocomplete="new-password" maxlength="16">
                        <label for="password">Contraseña</label>
                        <button type="button" class="password-toggle" id="passwordConfirmToggle" aria-label="Mostrar contraseña">
                            <span class="eye-icon"></span>
                        </button>
                        <span class="focus-border"></span>
                    </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @else
                        <span class="error-message" id="passwordError"></span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="input-wrapper password-wrapper">
                        <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" maxlength="16">
                        <label for="password_confirmation">Confirmar Contraseña</label>
                        <button type="button" class="password-toggle" id="passwordConfirmToggle" aria-label="Mostrar contraseña">
                            <span class="eye-icon"></span>
                        </button>
                        <span class="focus-border"></span>
                    </div>
                    @error('password_confirmation')
                        <span class="error-message">{{ $message }}</span>
                    @else
                        <span class="error-message" id="passwordConfirmError"></span>
                    @enderror

                <div class="form-options">
                    <label class="remember-wrapper">
                        <input type="checkbox" id="remember" name="remember">
                        <span class="checkbox-label">
                            <span class="checkmark"></span>
                            Recuerdame
                        </span>
                    </label>
                    <a href="#" class="forgot-password">¿Olvidaste tu contraseña?</a>
                </div>

                <button type="submit" class="login-btn btn">
                    <span class="btn-text">Registrarse</span>
                    <span class="btn-loader"></span>
                </button>
            </form>

            <div class="signup-link">
                <p>Ya tienes una cuenta? <a href="/Inicio_de_sesion">Inicia sesión</a></p>
            </div>

        </div>
    </div>

    <script src="{{ asset('form.js') }}"></script>
    <script src="script.js"></script>
</body>
</html>