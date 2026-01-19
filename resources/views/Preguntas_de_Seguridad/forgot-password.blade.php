<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Cuenta</title>
    <link rel="stylesheet" href="{{ asset('css/formulario.css') }}">
    <style>
        body { background: #1a202c; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
        .recovery-card {
            background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 20px;
            padding: 40px; width: 100%; max-width: 400px; text-align: center; color: white;
        }
        .form-control { width: 100%; padding: 12px; margin: 20px 0; border-radius: 10px; border: none; }
        .btn-recovery { background: #4a90e2; color: white; width: 100%; padding: 12px; border: none; border-radius: 10px; font-weight: bold; cursor: pointer; }
    </style>
</head>
<body>
    <div class="recovery-card">
        <h3>Recuperar Contraseña</h3>
        <p>Introduce tu correo para ver tus preguntas de seguridad.</p>
        
        <form action="{{ route('password.recovery.checkEmail') }}" method="POST">
            @csrf
            <input type="email" name="email" class="form-control" placeholder="ejemplo@correo.com" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z0-9]{2,}$" maxlength="35" required>
            <button type="submit" class="btn-recovery">Continuar</button>
        </form>
        
        <div style="margin-top: 20px;">
            <a href="{{ route('login') }}" style="color: #cbd5e0; font-size: 0.9rem;">Volver al inicio</a>
        </div>
    </div>
</body>
</html>