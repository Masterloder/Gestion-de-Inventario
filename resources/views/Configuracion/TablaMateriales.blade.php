<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="theme-color" content="#712cf9" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuracion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.25.0/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sidebars.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        main {
            margin-top: -12px;
            padding: auto;
        }

        .bi {
            display: inline-block;
            width: 1rem;
            height: 1rem;
        }

        /*
 * Sidebar
 */

        @media (min-width: 768px) {
            .sidebar .offcanvas-lg {
                position: -webkit-sticky;
                position: sticky;
                top: 48px;
            }

            .navbar-search {
                display: block;
            }
        }

        .sidebar .nav-link {
            font-size: .875rem;
            font-weight: 500;
        }

        .sidebar .nav-link.active {
            color: #2470dc;
        }

        .sidebar-heading {
            font-size: .75rem;
        }

        /*
 * Navbar
 */

        .navbar-brand {
            padding-top: .75rem;
            padding-bottom: .75rem;
            background-color: rgba(0, 0, 0, .25);
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .25);
        }

        .navbar .form-control {
            padding: .75rem 1rem;
        }
    </style>
</head>

<body>
    @include('components.lateral_nav')

    @include('Configuracion.components.tabla-materiales')



    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.25.0/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/chart.js') }}"></script>
    <script>
        // Instancias de los modales de Bootstrap 5
        const b_modalEdicion = new bootstrap.Modal('#modalEdicion');
        const b_modalEliminar = new bootstrap.Modal('#modalEliminar');

        function llenarModalEdicion(material) {
            // 1. Cambiamos la URL del formulario dinámicamente
            document.getElementById('formEdicion').action = `/materiales/${material.id}`;

            // 2. Llenamos los inputs simples
            document.getElementById('edit_nombre').value = material.nombre;
            document.getElementById('edit_descripcion').value = material.descripcion || '';

            // 3. Llenamos los Pseudo-Selects (Dropdowns)
            if (material.unidad_medida) {
                updateEditField('Unidad', material.unidad_medida_id, material.unidad_medida.nombre_unidad);
            }

            b_modalEdicion.show();
        }

        function updateEditField(tipo, id, texto) {
            document.getElementById('btnEdit' + tipo).innerText = texto;
            document.getElementById('hiddenEdit' + tipo).value = id;
        }

        function confirmarEliminacion(id, nombre) {
            document.getElementById('formEliminar').action = `/materiales/${id}`;
            document.getElementById('nombreEliminar').innerText = nombre;
            b_modalEliminar.show();
        }


        function abrirModalEdicion(material) {
    // 1. Definir la ruta de envío (Action del Formulario)
    // Asumiendo que tu ruta es /materiales/{id}
    const form = document.getElementById('formEdicion');
    form.action = `/materiales/${material.id}`;

    // 2. Llenar inputs de texto simples
    document.getElementById('edit_nombre').value = material.nombre;
    document.getElementById('edit_descripcion').value = material.descripcion || '';

    // 3. Llenar los Pseudo-Selects (Dropdowns de Bootstrap 5)
    // Para la Unidad de Medida
    if (material.unidad_medida) {
        document.getElementById('btnEditUnidad').innerText = material.unidad_medida.nombre_unidad;
        document.getElementById('hiddenEditUnidad').value = material.unidad_medida_id;
    }

    // Para la Categoría General
    if (material.categoria) {
        document.getElementById('btnEditCategoria').innerText = material.categoria.nombre_categoria;
        document.getElementById('hiddenEditCategoria').value = material.categoria_id;
    }

    // 4. Mostrar el modal usando la API de Bootstrap 5
    const modalE = new bootstrap.Modal(document.getElementById('modalEdicion'));
    modalE.show();
}
    </script>
</body>

</html>