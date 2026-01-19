<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Seguridad</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-lg">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-slate-800">Protege tu cuenta</h2>
            <p class="text-slate-500 mt-2">Selecciona 3 preguntas diferentes para la recuperación de tu contraseña.</p>
        </div>
        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <strong>¡Uy! Algo salió mal:</strong>
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form action="{{ route('security.store') }}" method="POST" id="securityForm">
            @csrf

            @for ($i = 1; $i <= 3; $i++)
                <div class="mb-6 p-4 border border-slate-100 rounded-lg bg-slate-50">
                <label class="block text-slate-700 font-semibold mb-2">Pregunta de Seguridad #{{ $i }}</label>

                <select name="questions[]" class="question-select w-full p-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none mb-3" required>
                    <option value="" disabled selected>-- Elige una pregunta --</option>
                    @foreach($questionsList as $question)
                    <option value="{{ $question->id }}">{{ $question->question }}</option>
                    @endforeach
                </select>

                <input type="text"
                    name="answers[]"
                    class="w-full p-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none"
                    placeholder="Escribe tu respuesta aquí..."
                    maxlength="30"
                    required>
    </div>
    @endfor

    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg transition-all shadow-md">
        Guardar Configuración
    </button>
    </form>
    </div>

    <script>
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('question-select')) {
                const allSelects = document.querySelectorAll('.question-select');
                const selectedValues = Array.from(allSelects).map(s => s.value).filter(v => v !== "");

                allSelects.forEach(select => {
                    const options = select.querySelectorAll('option');
                    options.forEach(option => {
                        // Si la opción está seleccionada en OTRO select, la deshabilitamos en este
                        if (option.value !== "" && selectedValues.includes(option.value) && select.value !== option.value) {
                            option.disabled = true;
                            option.classList.add('text-gray-300');
                        } else {
                            option.disabled = false;
                            option.classList.remove('text-gray-300');
                        }
                    });
                });
            }
        });
    </script>
</body>

</html>