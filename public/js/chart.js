document.addEventListener("DOMContentLoaded", function () {

    // Opciones generales para limpiar los gráficos (sin ejes molestos)
    var gradientChartOptionsConfiguration = {
        maintainAspectRatio: false,
        legend: { display: false },
        tooltips: {
            backgroundColor: '#f5f5f5',
            titleFontColor: '#333',
            bodyFontColor: '#666',
            displayColors: false,
        },
        responsive: true,
        scales: {
            y: {
                grid: { color: 'rgba(255,255,255,0.1)', borderDash: [2, 2] },
                ticks: { color: '#9a9a9a', padding: 10 }
            },
            x: {
                grid: { drawBorder: false, display: false },
                ticks: { color: '#9a9a9a', padding: 20 }
            }
        }
    };

    // 1. GRÁFICO GRANDE (Performance)
    var ctx = document.getElementById("chartBig1").getContext("2d");
    var gradientStroke = ctx.createLinearGradient(0, 230, 0, 50);
    gradientStroke.addColorStop(1, 'rgba(225,78,202,0.2)'); // Rosa suave
    gradientStroke.addColorStop(0, 'rgba(225,78,202,0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
            datasets: [{
                label: "Performance",
                fill: true,
                backgroundColor: gradientStroke,
                borderColor: '#e14eca', // Rosa neón
                borderWidth: 2,
                borderDash: [],
                borderDashOffset: 0.0,
                pointBackgroundColor: '#e14eca',
                pointBorderColor: 'rgba(255,255,255,0)',
                pointHoverBackgroundColor: '#e14eca',
                pointBorderWidth: 20,
                pointHoverRadius: 4,
                pointHoverBorderWidth: 15,
                pointRadius: 4,
                data: @json($chartData['performance']), // Datos de Laravel
                tension: 0.4 // Curva suave
            }]
        },
        options: gradientChartOptionsConfiguration
    });

    // 2. GRÁFICO IZQ (Shipments - Rosa)
    var ctx2 = document.getElementById("chartLinePurple").getContext("2d");
    new Chart(ctx2, {
        type: 'line',
        data: {
            labels: ['JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
            datasets: [{
                label: "Shipments",
                fill: true,
                borderColor: '#e14eca',
                borderWidth: 2,
                pointRadius: 4,
                pointBackgroundColor: '#e14eca',
                data: @json($chartData['shipments']),
                tension: 0.4
            }]
        },
        options: gradientChartOptionsConfiguration
    });

    // 3. GRÁFICO CENTRO (Ventas - Barras Azules)
    var ctx3 = document.getElementById("chartBarBlue").getContext("2d");
    new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: ['USA', 'GER', 'AUS', 'UK', 'RO', 'BR'],
            datasets: [{
                label: "Sales",
                fill: true,
                backgroundColor: '#1f8ef1', // Azul
                borderColor: '#1f8ef1',
                borderWidth: 2,
                data: @json($chartData['dailySales']),
                barPercentage: 0.4, // Ancho de las barras
            }]
        },
        options: gradientChartOptionsConfiguration
    });

    // 4. GRÁFICO DERECHO (Tasks - Verde)
    var ctx4 = document.getElementById("chartLineGreen").getContext("2d");
    new Chart(ctx4, {
        type: 'line',
        data: {
            labels: ['JUL', 'AUG', 'SEP', 'OCT', 'NOV'],
            datasets: [{
                label: "Tasks",
                fill: true,
                borderColor: '#00d6b4', // Verde Neón
                borderWidth: 2,
                pointRadius: 4,
                pointBackgroundColor: '#00d6b4',
                data: @json($chartData['tasks']),
                tension: 0.4
            }]
        },
        options: gradientChartOptionsConfiguration
    });
});