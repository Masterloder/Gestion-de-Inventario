/* globals Chart:false */

(() => {
  'use strict'

  // Obtener canvas
  const ctx = document.getElementById('myChart')

  if (!ctx) return
  // Datos de ejemplo para semana, mes y año
  const datasets = {
    semana: {
      labels: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
      data: [12000, 21345, 18483, 24003, 23489, 24092, 25530]
    },
    mes: {
      // Últimos 6 meses como ejemplo; ajustar según necesites
      labels: ['Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre'],
      data: [75000, 82000, 90000, 87000, 94000, 98000]
    },
    año: {
      // Últimos 12 meses como ejemplo; ajustar según necesites
      labels: ['2020', '2021', '2022', '2023', '2024', '2025'],
      data: [65000, 70000, 72000, 68000, 75000, 80000]
    }
  }

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
