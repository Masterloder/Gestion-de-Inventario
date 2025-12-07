<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="theme-color" content="#712cf9" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
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
    @include('components.graficas')


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/chart.js') }}" ></script>
   <script>document.addEventListener("DOMContentLoaded", function () {

    // --- Configuración de Gráficas ---
    
    // Opciones generales de la plantilla (ajustadas para Chart.js v4+)
    var gradientChartOptionsConfiguration = {
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#f5f5f5',
                titleColor: '#333',
                bodyColor: '#666',
                displayColors: false,
            }
        },
        responsive: true,
        scales: {
            y: {
                grid: { color: 'rgba(255,255,255,0.1)', borderDash: [2, 2] },
                ticks: { color: '#9a9a9a', padding: 10, beginAtZero: true }
            },
            x: {
                grid: { drawBorder: false, display: false },
                ticks: { color: '#9a9a9a', padding: 20 }
            }
        }
    };

    // --- Gráfica 1: Movimientos Generales (Dinámica con Filtro) ---
    // **CORRECCIÓN DE ÁMBITO (SCOPE) HECHA CORRECTAMENTE**
    const ctxBig1 = document.getElementById("chartBig1").getContext("2d");
    let chartBig1Instance = null;
    
    // Función para obtener y dibujar los datos de Movimientos
    function loadMovimientosChart(periodo) {
        // Llama a la ruta que creaste en el DashboardController
        fetch(`/dashboard/movimientos-periodo?periodo=${periodo}`)
            .then(response => {
                // Si la respuesta no es OK, arroja un error
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(dataMovimientos => {
                
                // Destruir la instancia anterior si existe
                if (chartBig1Instance) {
                    chartBig1Instance.destroy();
                }

                // Gradientes (deben crearse cada vez que se re-dibuja)
                var gradientStrokeEntradas = ctxBig1.createLinearGradient(0, 230, 0, 50);
                gradientStrokeEntradas.addColorStop(1, 'rgba(225,78,202,0.2)');
                gradientStrokeEntradas.addColorStop(0, 'rgba(225,78,202,0)');
                var gradientStrokeSalidas = ctxBig1.createLinearGradient(0, 230, 0, 50);
                gradientStrokeSalidas.addColorStop(1, 'rgba(31,142,241,0.2)'); 
                gradientStrokeSalidas.addColorStop(0, 'rgba(31,142,241,0)');

                chartBig1Instance = new Chart(ctxBig1, {
                    type: 'line',
                    data: {
                        labels: dataMovimientos.labels, 
                        datasets: [
                            {
                                label: "Entradas",
                                fill: true,
                                backgroundColor: gradientStrokeEntradas,
                                borderColor: '#e14eca',
                                data: dataMovimientos.entradas, 
                                tension: 0.4,
                                pointBackgroundColor: '#e14eca',
                            },
                            {
                                label: "Salidas",
                                fill: true,
                                backgroundColor: gradientStrokeSalidas,
                                borderColor: '#1f8ef1',
                                data: dataMovimientos.salidas, 
                                tension: 0.4,
                                pointBackgroundColor: '#1f8ef1',
                            }
                        ]
                    },
                    options: gradientChartOptionsConfiguration
                });
            })
            .catch(error => console.error('Error al cargar movimientos por periodo:', error));
    }

    // Manejar el evento de clic en los botones de período
    document.querySelectorAll('.btn-group-toggle label').forEach(label => {
        label.addEventListener('click', function() {
            // Se asegura de que el elemento input existe y tiene el atributo
            const periodo = this.querySelector('input').getAttribute('data-periodo');
            loadMovimientosChart(periodo);
        });
    });

    // --- Gráfica 2: Top 5 Materiales (chartBarBlue) ---
    function loadTopMaterialesChart() {
        // Los datos se pasan directamente desde Blade para una carga inicial estática
        // **AJUSTE 1: Cambio de 'topMateriales' a 'top_materiales' para seguir el estándar snake_case de Blade (si se usa)**
        const dataTopMateriales = @json($chartData['topMateriales']); // Usando camelCase como tú lo definiste.
        const ctx3 = document.getElementById("chartBarBlue").getContext("2d");

        new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: dataTopMateriales.labels, 
                datasets: [
                    {
                        label: "Total Entradas",
                        backgroundColor: '#00d6b4', 
                        data: dataTopMateriales.entradas,
                        barPercentage: 0.5,
                    },
                    {
                        label: "Total Salidas",
                        backgroundColor: '#e14eca', 
                        data: dataTopMateriales.salidas,
                        barPercentage: 0.5,
                    }
                ]
            },
            options: gradientChartOptionsConfiguration
        });
    }

    // --- Gráfica 3: Top 5 Trabajadores (chartLineGreen -> Barras) ---
    function loadTopTrabajadoresChart() {
        // **AJUSTE 2: Cambio de 'topTrabajadores' a 'top_trabajadores' para seguir el estándar snake_case de Blade (si se usa)**
        const dataTopTrabajadores = @json($chartData['topTrabajadores']); // Usando camelCase como tú lo definiste.
        const ctx4 = document.getElementById("chartLineGreen").getContext("2d");

        new Chart(ctx4, {
            type: 'bar', 
            data: {
                labels: dataTopTrabajadores.labels, 
                datasets: [
                    {
                        label: "Movimientos Realizados",
                        backgroundColor: '#1f8ef1', 
                        data: dataTopTrabajadores.data,
                        barPercentage: 0.8,
                    }
                ]
            },
            options: gradientChartOptionsConfiguration
        });
    }

    // --- Carga Inicial de las Gráficas ---
    loadMovimientosChart('año'); // Carga la gráfica principal por defecto con el año
    loadTopMaterialesChart();
    loadTopTrabajadoresChart();
});
</script>
</body>

</html>