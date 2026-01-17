<div class="container-fluid">
    <div class="row">
        @include('components.siderbar_panelcontrol')
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-chart">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-sm-6 text-left">
                                        <h5 class="card-category">Registro de Movimientos</h5>
                                        <h2 class="card-title">Materiales</h2>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="btn-group btn-group-toggle float-end" data-toggle="buttons">
                                            <label class="btn btn-sm btn-primary btn-simple active" id="filter-dia">
                                                <input type="radio" name="options" data-periodo="dia">
                                                <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Día</span>
                                            </label>
                                            <label class="btn btn-sm btn-primary btn-simple" id="filter-semana">
                                                <input type="radio" name="options" data-periodo="semana">
                                                <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Semana</span>
                                            </label>
                                            <label class="btn btn-sm btn-primary btn-simple" id="filter-mes">
                                                <input type="radio" name="options" data-periodo="mes">
                                                <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Mes</span>
                                            </label>
                                            <label class="btn btn-sm btn-primary btn-simple active" id="filter-anio">
                                                <input type="radio" name="options" data-periodo="año" checked>
                                                <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Año</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart-area" style="height: 350px;">
                                    <canvas id="chartBig1"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="card card-chart">
                            <div class="card-header">
                                <h5 class="card-category">Entradas y Salidas</h5>
                                <h3 class="card-title"><i class="tim-icons icon-delivery-fast text-info"></i> Top 5 Materiales</h3>
                            </div>
                            <div class="card-body">
                                <div class="chart-area" style="height: 300px;">
                                    <canvas id="chartBarBlue"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12">
                        <div class="card card-chart">
                            <div class="card-header">
                                <h5 class="card-category">Ranking de Actividad</h5>
                                <h3 class="card-title"><i class="tim-icons icon-user-run text-primary"></i> Top 5 Trabajadores</h3>
                            </div>
                            <div class="card-body">
                                <div class="chart-area" style="height: 300px;">
                                    <canvas id="chartLineGreen"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        </main>
    </div>
</div>
<script
    src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js"
    integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp"
    crossorigin="anonymous"
    class="astro-vvvwv3sm"></script>
<script src="dashboard.js" class="astro-vvvwv3sm"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('chartBig1').getContext('2d');
    let miGrafico;

    // 1. Función para crear/actualizar el gráfico
    const renderChart = (labels, entradas, salidas) => {
        if (miGrafico) {
            miGrafico.destroy(); // Destruir instancia previa para evitar errores visuales
        }

        miGrafico = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: "Entradas",
                    borderColor: "#d048b6",
                    borderWidth: 2,
                    fill: true,
                    backgroundColor: 'rgba(208, 72, 182, 0.1)',
                    data: entradas,
                }, {
                    label: "Salidas",
                    borderColor: "#00d6b4",
                    borderWidth: 2,
                    fill: true,
                    backgroundColor: 'rgba(0, 214, 180, 0.1)',
                    data: salidas,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.1)' } },
                    x: { grid: { display: false } }
                },
                plugins: {
                    legend: { display: true, position: 'bottom' }
                }
            }
        });
    };

    // 2. Función para obtener datos vía AJAX
    const fetchMovimientos = (periodo) => {
        fetch(`{{ route('dashboard.movimientos') }}?periodo=${periodo}`)
            .then(response => response.json())
            .then(data => {
                renderChart(data.labels, data.entradas, data.salidas);
            })
            .catch(error => console.error('Error:', error));
    };

    // 3. Eventos de los botones de filtro
    document.querySelectorAll('.btn-group-toggle input').forEach(radio => {
        radio.addEventListener('change', function() {
            const periodo = this.getAttribute('data-periodo');
            fetchMovimientos(periodo);
            
            // Estética: Cambiar clases de botones (Opcional según tu CSS)
            document.querySelectorAll('.btn-group-toggle label').forEach(l => l.classList.remove('active'));
            this.parentElement.classList.add('active');
        });
    });

    // 4. Carga inicial (Usando los datos enviados desde el index del controlador)
    const initialData = @json($chartData['movimientos']);
    renderChart(initialData.labels, initialData.entradas, initialData.salidas);
});
</script>