$(function () {
  'use strict'

  // Agregar logo en el dashboard
  $('#logo-container').html('<img src="logo.png" alt="Adelitas Pizza" style="width: 150px;">');

  // Hacer los widgets del dashboard ordenables
  $('.connectedSortable').sortable({
    placeholder: 'sort-highlight',
    connectWith: '.connectedSortable',
    handle: '.card-header, .nav-tabs',
    forcePlaceholderSize: true,
    zIndex: 999999
  })
  $('.connectedSortable .card-header').css('cursor', 'move')

  // Configuración de gráficos de ventas
  var salesChartCanvas = document.getElementById('revenue-chart-canvas').getContext('2d');
  var salesChartData = {
    labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio'],
    datasets: [
      {
        label: 'Ventas de Pizzas',
        backgroundColor: 'rgba(255,99,132,0.9)',
        borderColor: 'rgba(255,99,132,0.8)',
        data: [120, 150, 180, 200, 220, 250, 300]
      },
      {
        label: 'Ventas de Bebidas',
        backgroundColor: 'rgba(54,162,235,1)',
        borderColor: 'rgba(54,162,235,1)',
        data: [80, 100, 120, 140, 160, 180, 200]
      }
    ]
  };
  var salesChartOptions = {
    maintainAspectRatio: false,
    responsive: true,
    legend: { display: true },
    scales: {
      xAxes: [{ gridLines: { display: false } }],
      yAxes: [{ gridLines: { display: false } }]
    }
  };
  var salesChart = new Chart(salesChartCanvas, {
    type: 'bar',
    data: salesChartData,
    options: salesChartOptions
  });

  // Configuración del gráfico de ventas por categoría
  var pieChartCanvas = document.getElementById('sales-chart-canvas').getContext('2d');
  var pieData = {
    labels: ['Pizzas Clásicas', 'Pizzas Especiales', 'Bebidas'],
    datasets: [{
      data: [50, 30, 20],
      backgroundColor: ['#f56954', '#00a65a', '#f39c12']
    }]
  };
  var pieOptions = {
    legend: { display: true },
    maintainAspectRatio: false,
    responsive: true
  };
  var pieChart = new Chart(pieChartCanvas, {
    type: 'doughnut',
    data: pieData,
    options: pieOptions
  });

  // Calendario para seguimiento de pedidos
  $('#calendar').datetimepicker({
    format: 'L',
    inline: true
  });
});
