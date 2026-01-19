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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
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
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 8px;
            color: rgba(255, 255, 255, 0.9);
        }

        .input-group-text {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #60a5fa;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: #60a5fa;
            color: white;
            box-shadow: 0 0 10px rgba(96, 165, 250, 0.3);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .btn-update {
            background: #2563eb;
            border: none;
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .btn-update:hover:not(:disabled) {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.4);
        }

        .btn-update:disabled {
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        #message {
            font-size: 0.85rem;
            min-height: 1.2rem;
            display: block;
            margin-top: 8px;
        }
        
        .password-hint {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.5);
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="glass-card text-center">
        <div class="header-icon">
            <i class="fas fa-shield-alt"></i>
        </div>
        
        <h2 class="fw-bold mb-2">Restablecer Clave</h2>
        <p class="text-white-50 mb-4">Ingresa tu nueva contraseña de acceso.</p>

        <form id="resetForm" action="{{ route('password.secure.update') }}" method="POST" autocomplete="off">
            @csrf
            <input type="hidden" name="user_id" value="{{ $userId }}">

            <div class="mb-3 text-start">
                <label class="form-label">Nueva Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" id="password" name="password" 
                           class="form-control" placeholder="Mínimo 8 caracteres" maxlength="14" required>
                </div>
            </div>

            <div class="mb-3 text-start">
                <label class="form-label">Confirmar Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-check-double"></i></span>
                    <input type="password" id="confirm_password" 
                           class="form-control" placeholder="Repite la contraseña" maxlength="14" required>
                </div>
                <small id="message" class="text-warning fw-semibold"></small>
            </div>

            <div class="password-hint text-start">
                <ul class="list-unstyled mb-0">
                    <li id="rule-length"><i class="fas fa-circle-info me-1"></i> Mínimo 8 caracteres</li>
                    <li id="rule-match"><i class="fas fa-circle-info me-1"></i> Las contraseñas deben coincidir</li>
                </ul>
            </div>

            <button type="submit" id="submitBtn" class="btn btn-primary btn-update w-100" disabled>
                <i class="fas fa-save me-2"></i>Actualizar Contraseña
            </button>
        </form>
    </div>

    <script>
        const password = document.getElementById('password');
        const confirm = document.getElementById('confirm_password');
        const btn = document.getElementById('submitBtn');
        const msg = document.getElementById('message');
        
        const ruleLength = document.getElementById('rule-length');
        const ruleMatch = document.getElementById('rule-match');

        function validate() {
            const passVal = password.value;
            const confVal = confirm.value;

            // Validación de longitud
            if (passVal.length >= 8) {
                ruleLength.classList.replace('text-white-50', 'text-success');
                ruleLength.querySelector('i').classList.replace('fa-circle-info', 'fa-check-circle');
            } else {
                ruleLength.classList.add('text-white-50');
                ruleLength.querySelector('i').classList.add('fa-circle-info');
            }

            // Validación de coincidencia
            if (confVal.length > 0) {
                if (passVal === confVal) {
                    ruleMatch.classList.add('text-success');
                    ruleMatch.classList.remove('text-danger');
                    msg.textContent = "";
                    
                    if (passVal.length >= 8) {
                        btn.disabled = false;
                    }
                } else {
                    ruleMatch.classList.add('text-danger');
                    ruleMatch.classList.remove('text-success');
                    msg.textContent = "Las contraseñas no coinciden.";
                    btn.disabled = true;
                }
            } else {
                btn.disabled = true;
            }
        }

        password.addEventListener('input', validate);
        confirm.addEventListener('input', validate);
    </script>
</body>
</html>