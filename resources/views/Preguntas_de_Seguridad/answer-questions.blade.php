<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Identidad | Corvisucre</title>
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
            padding: 20px;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            color: white;
            position: relative;
        }

        /* Estilos del Modal de Error (Overlay) */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(8px);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 99999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-custom {
            background: white;
            padding: 30px;
            border-radius: 20px;
            text-align: center;
            width: 90%;
            max-width: 380px;
            position: relative;
            overflow: hidden;
            color: #333;
            transform: scale(0.8);
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .modal-overlay.active .modal-custom {
            transform: scale(1);
        }

        .progress-bar-timer {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 5px;
            background: #ef4444;
            width: 100%;
        }

        .animate-timer {
            animation: timer-shrink 8s linear forwards;
        }

        @keyframes timer-shrink {
            from {
                width: 100%;
            }

            to {
                width: 0%;
            }
        }

        /* Estilos de Formulario */
        .question-container {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white !important;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: #60a5fa;
            box-shadow: 0 0 10px rgba(96, 165, 250, 0.3);
        }

        .btn-verify {
            background: #2563eb;
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
        }
    </style>
</head>

<body>

    <div id="errorModal" class="modal-overlay">
        <div class="modal-custom shadow-lg">
            <div class="mb-3">
                <i class="fas fa-exclamation-circle text-danger" style="font-size: 3.5rem;"></i>
            </div>
            <h4 class="fw-bold text-dark">Error de Validación</h4>
            <p id="errorMessage" class="text-muted px-2"></p>
            <button onclick="closeModal()" class="btn btn-dark w-100 py-2 mt-2 rounded-3">Entendido</button>
            <div id="timerBar" class="progress-bar-timer"></div>
        </div>
    </div>

    <div class="glass-card text-center">
        <div class="mb-4">
            <i class="fas fa-user-shield text-info" style="font-size: 3rem;"></i>
        </div>

        <h2 class="fw-bold mb-2">Verifica tu identidad</h2>
        <p class="text-white-50 mb-4 small">Responde correctamente para generar tu enlace de recuperación.</p>

        <form action="{{ route('password.security.verifyAnswer') }}" method="POST" id="verifyForm">
            @csrf

            <input type="hidden" name="user_id" value="{{ $user->id }}">

            @foreach($randomQuestions as $index => $item)
            <div class="question-container text-start">
                <label class="form-label text-info fw-semibold mb-2">
                    Pregunta {{ $index + 1 }}:
                </label>
                <p class="mb-3 small fw-bold text-white">{{ $item->question }}</p>

                <input type="hidden" name="question_ids[]" value="{{ $item->id }}">

                <input type="text"
                    name="answers[]"
                    class="form-control"
                    placeholder="Escribe tu respuesta..."
                    required
                    autocomplete="off">
            </div>
            @endforeach

            <div class="d-grid mt-4">
                <button type="submit" id="btnSubmit" class="btn btn-primary btn-verify">
                    <span id="btnText"><i class="fas fa-check-circle me-2"></i>Verificar Respuestas</span>
                    <span id="btnLoader" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>
            </div>
        </form>
    </div>

    <script>
        const modal = document.getElementById('errorModal');
        const timerBar = document.getElementById('timerBar');
        const errorMsg = document.getElementById('errorMessage');

        function openModal(msg) {
            errorMsg.textContent = msg;
            modal.classList.add('active');
            timerBar.classList.add('animate-timer');

            // Auto-cerrar después de 8 segundos
            setTimeout(closeModal, 8000);
        }

        function closeModal() {
            modal.classList.remove('active');
            setTimeout(() => {
                timerBar.classList.remove('animate-timer');
            }, 300);
        }

        // Lógica para capturar errores de Laravel (Session Error)
        @if(session('error'))
        document.addEventListener('DOMContentLoaded', () => {
            openModal("{{ session('error') }}");
        });
        @endif

        // También capturamos errores de validación de Laravel ($errors)
        @if($errors-> any())
        document.addEventListener('DOMContentLoaded', () => {
            openModal("{{ $errors->first() }}");
        });
        @endif
    </script>
</body>

</html>