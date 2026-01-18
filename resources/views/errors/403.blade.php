<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Restringido</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="max-w-md w-full bg-white shadow-lg rounded-lg p-8 text-center">
        <div class="flex justify-center mb-6">
            <div class="bg-red-100 p-4 rounded-full">
                <svg class="h-12 w-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
        </div>

        <h1 class="text-3xl font-bold text-gray-800 mb-2">Acceso Denegado</h1>
        <p class="text-gray-600 mb-6">
            Lo sentimos, aún **no tienes autorización** para ingresar a esta sección.
        </p>
        
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
            <p class="text-sm text-blue-700">
                Por favor, <strong>comunícate con el administrador del sistema</strong> para solicitar los permisos necesarios.
            </p>
        </div>

        <a href="{{ url('/') }}" class="inline-block bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition duration-300">
            Volver al Inicio
        </a>
    </div>
</body>
</html>