<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="Estilo.css">
</head>

<body>
  @session('success')

          
          
          <div class="notification-container">
                <div class="alert alert-success" role="alert">
                  {{ $value }}
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
              box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
              font-size: 16px;
              animation: fadeInUp 0.5s;
            }

            @keyframes fadeInUp {
              from {
                opacity: 0;
                transform: translateY(30px);
              }

              to {
                opacity: 1;
                transform: translateY(0);
              }
            }
          </style>
          <script>
            setTimeout(function() {
              var notif = document.querySelector('.notification-container');
              if (notif) notif.style.display = 'none';
            }, 5000);
          </script>
          @endsession
  @include('components.lateral_nav')
  <main>
    <div class="container-fluid  py-4">
      <div class="p-5 mb-4 bg-light rounded-3">
        <div class="container-fluid py-5">
          

          <h1 class="display-5 fw-bold">Bienvenido, {{ auth()->user()->name}}</h1>
          <p class="col-md-8 fs-4"> Al sistema de Gestion de Inventario<br /></p>
          <a href="/panel_de_control"><button class="btn btn-primary btn-lg" type="button">Panel de Control</button></a>
        </div>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </div>
  </main>

</body>

</html>