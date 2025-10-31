<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/CSS/Header.css">
    <title>Gestion de Inventario</title>
</head>
<body>
    <header>   
        @include('components.header')

    </header>
    <h1>Bienvenido a la Gestion de Inventario</h1>
    <p>Esta es la página de bienvenida de la aplicación de gestión de inventario.</p>
    @if(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
        <p>Iniciar sesión</p>
        <a href="/Inicio_de_sesion"><button type="button">Iniciar sesión</button></a>
        <p>Registrarse</p>
        <a href="/registro"><button type="button">Registrarse</button></a>

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>