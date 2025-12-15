<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
    <link rel="stylesheet" href="{{ asset(path: 'css/formulario.css') }}">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h2>Bienvenido</h2>
                <p>Registra tu cuenta <p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('register.post') }}" class="login-form" id="loginForm" novalidate>
                @csrf
                <div class="form-group">
                    <div class="input-wrapper">
                        <input type="email" id="email" name="email" required autocomplete="email">
                        <label for="email">Dirección de Correo Electrónico</label>
                        <span class="focus-border"></span>
                    </div>
                    <span class="error-message" id="emailError"></span>
                </div>
                <div class="form-group">
                    <div class="input-wrapper">
                        <input type="text" id="firsname" name="firsname" required >
                        <label for="firsname">Nombre</label>
                        <span class="focus-border"></span>
                    </div>
                    <span class="error-message" id="firstNameError"></span>
                </div>
                <div class="form-group">
                    <div class="input-wrapper">
                        <input type="text" id="lastname" name="lastname" required >
                        <label for="lastname">Apellido</label>
                        <span class="focus-border"></span>
                    </div>
                    <span class="error-message" id="lastNameError"></span>
                </div>
                <div class="form-group">
                    <div class="input-wrapper password-wrapper">
                        <input type="password" id="password" name="password" required autocomplete="new-password">
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
                        <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
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