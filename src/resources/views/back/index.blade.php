@extends('back.layout')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Backend</li>
@endsection

@section('content')

<canvas class="my-4" id="myChart" width="900" height="220"></canvas>

<h3>Estadísticas del curso actual</h3>
<div class="table-responsive">
<table class="table table-striped">
  <tbody>
    <tr>
      <th scope="row">Número total de usuarios</th>
      <td>{{ $s+$t+$co+$ce}}</td>
    </tr>
    <tr>
      <th scope="row">Número de alumnos</th>
      <td>{{ $s }}</td>
    </tr>
    <tr>
      <th scope="row">Número de tutores</th>
      <td>{{ $t }}</td>
    </tr>
    <tr>
      <th scope="row">Número de coordinadores</th>
      <td>{{ $co }}</td>
    </tr>
    <tr>
      <th scope="row">Número de administradores de centros</th>
      <td>{{ $ce }}</td>
    </tr>    
  </tbody>
</table>

<h3>Estadísticas globales</h3>
<div class="table-responsive">
<table class="table table-striped">
  <tbody>
    <tr>
      <th scope="row">Número total de usuarios</th>
      <td>{{ $s_t+$t_t+$co_t+$ce_t}}</td>
    </tr>
    <tr>
      <th scope="row">Número de alumnos</th>
      <td>{{ $s_t }}</td>
    </tr>
    <tr>
      <th scope="row">Número de tutores</th>
      <td>{{ $t_t }}</td>
    </tr>
    <tr>
      <th scope="row">Número de coordinadores</th>
      <td>{{ $co_t }}</td>
    </tr>
    <tr>
      <th scope="row">Número de administradores de centros</th>
      <td>{{ $ce_t }}</td>
    </tr>    
  </tbody>
</table>
</div>

@endsection

@section('footerScripts')
@parent
    <!-- Graphs -->
    <script src="{{ asset('js/Chart.min.js') }}"></script>
    <script>
      var ctx = document.getElementById("myChart");
      var color = Chart.helpers.color;
      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ["Alumno", "Tutor", "Coordinador de titulación", "Administrador de centro"],
          datasets: [{
            data: [{{ $s }}, {{ $t }}, {{ $co }}, {{ $ce }}],
            lineTension: 0,
            backgroundColor: '#2462a7',

            pointBackgroundColor: '#007bff'
          }]
        },
        options: {
          responsive: true,
          legend: {
            position: 'top',
          },
          title: {
            display: true,
            text: 'Número de usuarios del curso actual según su rol'
          },
          legend: {
            display: false,
          },
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: false
              }
            }]
          },                 
        }        
       
      });
    </script>
@endsection