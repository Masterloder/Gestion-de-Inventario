

(() => {
  'use strict'

  // Obtener canvas
  const ctx = document.getElementById('myChart')
  const ctxMovimientos = document.getElementById('movimientosChart').getContext('2d');

  // Decodifica los datos pasados desde el controlador
  const chartData = JSON.parse('{!! $data_mensual !!}');
  
  new Chart(ctxMovimientos, {
    type: 'line', // Línea o 'bar'
    data: {
      labels: chartData.labels,
      datasets: chartData.datasets,
    },
    options: {
      responsive: true,
      scales: {
        y: { beginAtZero: true }
      }
    }
  });

  // Crear selector si no existe (se inserta antes del canvas)
  let selector = document.getElementById('timeRange')
  if (!selector) {
    selector = document.createElement('select')
    selector.id = 'timeRange'
    selector.style.marginBottom = '10px'
    selector.innerHTML = `
      <option value="semana">Semana</option>
      <option value="mes">Mes</option>
      <option value="año">Año</option>
    `
    ctx.parentNode.insertBefore(selector, ctx)
  }

  // Configuración inicial (semana)
  const initial = datasets.semana

  // Crear chart
  const myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: initial.labels,
      datasets: [{
        data: initial.data,
        lineTension: 0,
        backgroundColor: 'transparent',
        borderColor: '#007bff',
        borderWidth: 4,
        pointBackgroundColor: '#007bff'
      }]
    },
    options: {
      plugins: {
        legend: {
          display: false
        },
        tooltip: {
          boxPadding: 3
        }
      }
    }
  })

  // Función para actualizar el gráfico
  function updateChart(range) {
    const payload = datasets[range] || datasets.semana
    myChart.data.labels = payload.labels
    myChart.data.datasets[0].data = payload.data
    myChart.update()
  }

  // Escuchar cambios del selector
  selector.addEventListener('change', (e) => {
    updateChart(e.target.value)
  })

  // (Opcional) Exponer funciones globalmente para control desde código
  window.dashboardChart = {
    updateChart
  }
})()
