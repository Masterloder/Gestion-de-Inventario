<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Contraseña | Corvisucre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e1b4b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            color: white;
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .header-icon {
            font-size: 3rem;
            color: #60a5fa;
            margin-bottom: 1rem;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white !important;
            padding: 12px;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: #60a5fa;
            box-shadow: 0 0 10px rgba(96, 165, 250, 0.3);
        }

        .btn-update {
            background: #2563eb;
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-update:hover:not(:disabled) {
            background: #1d4ed8;
            transform: translateY(-2px);
        }

        .rules-list {
            font-size: 0.82rem;
            color: rgba(255, 255, 255, 0.6);
            list-style: none;
            padding: 0;
            margin-top: 15px;
        }

        .rule-item { margin-bottom: 5px; transition: 0.3s; }
        .rule-item i { margin-right: 8px; width: 15px; }
        .rule-valid { color: #4ade80 !important; }
        .rule-invalid { color: #f87171 !important; }
    </style>
</head>
<body>

    <div class="glass-card text-center">
        <div class="header-icon">
            <i class="fas fa-lock-open"></i>
        </div>
        
        <h2 class="fw-bold mb-2">Nueva Contraseña</h2>
        <p class="text-white-50 mb-4">Establece una clave segura para tu cuenta.</p>

        <form id="passwordForm" action="{{ route('password.secure.update') }}" method="POST" autocomplete="off">
            @csrf
            <input type="hidden" name="user_id" value="{{ $userId }}">

            <div class="mb-3 text-start">
                <label class="form-label small fw-bold">Nueva Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-secondary text-info">
                        <i class="fas fa-key"></i>
                    </span>
                    <input type="password" id="password" name="password" 
                           class="form-control" placeholder="8-14 caracteres" maxlength="14" required>
                </div>
            </div>

            <div class="mb-4 text-start">
                <label class="form-label small fw-bold">Confirmar Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-secondary text-info">
                        <i class="fas fa-check-double"></i>
                    </span>
                    <input type="password" id="confirm_password" 
                           class="form-control" placeholder="Repite tu contraseña" maxlength="14" required>
                </div>
            </div>

            <ul class="rules-list text-start">
                <li id="rule-length" class="rule-item"><i class="fas fa-circle-dot"></i> 8 a 14 caracteres</li>
                <li id="rule-special" class="rule-item"><i class="fas fa-circle-dot"></i> Mayúscula, número y símbolo</li>
                <li id="rule-match" class="rule-item"><i class="fas fa-circle-dot"></i> Las contraseñas coinciden</li>
            </ul>

            <button type="submit" id="submitBtn" class="btn btn-primary btn-update w-100 mt-3" disabled>
                Actualizar Contraseña
            </button>
        </form>
    </div>

    <script>
        const password = document.getElementById('password');
        const confirm = document.getElementById('confirm_password');
        const btn = document.getElementById('submitBtn');
        
        const ruleLength = document.getElementById('rule-length');
        const ruleSpecial = document.getElementById('rule-special');
        const ruleMatch = document.getElementById('rule-match');

        function updateStatus(element, isValid, isError = false) {
            if (isValid) {
                element.classList.add('rule-valid');
                element.classList.remove('rule-invalid');
                element.querySelector('i').className = "fas fa-check-circle";
            } else {
                element.classList.remove('rule-valid');
                if(isError) {
                    element.classList.add('rule-invalid');
                    element.querySelector('i').className = "fas fa-times-circle";
                } else {
                    element.classList.remove('rule-invalid');
                    element.querySelector('i').className = "fas fa-circle-dot";
                }
            }
        }

        function validate() {
            const p = password.value;
            const c = confirm.value;

            // 1. Validar longitud (8-14)
            const isLengthValid = p.length >= 8 && p.length <= 14;
            updateStatus(ruleLength, isLengthValid);

            // 2. Validar complejidad (Mayúscula, Número, Especial)
            // Regex: Al menos una A-Z, un 0-9 y un carácter especial
            const hasUpper = /[A-Z]/.test(p);
            const hasNumber = /[0-9]/.test(p);
            const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(p);
            const isComplexValid = hasUpper && hasNumber && hasSpecial;
            updateStatus(ruleSpecial, isComplexValid);

            // 3. Validar coincidencia
            const isMatch = c.length > 0 && p === c;
            // Solo mostramos error rojo si ya empezó a escribir en el segundo input y no coincide
            const showMatchError = c.length > 0 && p !== c;
            updateStatus(ruleMatch, isMatch, showMatchError);

            // Habilitar botón solo si todo es correcto
            btn.disabled = !(isLengthValid && isComplexValid && isMatch);
        }

        password.addEventListener('input', validate);
        confirm.addEventListener('input', validate);
    </script>
</body>
</html>