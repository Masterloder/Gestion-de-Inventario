<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Inventario</title>
</head>
<body>
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
</body>
</html>