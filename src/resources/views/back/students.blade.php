@extends('back.layout')

@section('title', $center . ' -  Listado de Alumnos')

@section('customCSS')
@parent
    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tables.css') }}" rel="stylesheet">
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('administrator') }}">Backend</a></li>
    <li class="breadcrumb-item"><a href="{{ route('students', ['id' => $id]) }}">Alumnos</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $center }}</li>

@endsection

@section('content')

<a href="{{ route('newstudent', ['id' => $id]) }}" class="btn btn-success btn-sm mb-3">Añadir nuevo</a>

<div class="row">
  <div class="col">
  <label for="searchByName">Filtrar por nombre</label>
    <input type="text" class="form-control form-control-sm" id="searchByName">
  </div>
  <div class="col mb-3">
    <label for="searchByEmail">Filtrar por email</label>
    <input class="form-control form-control-sm" id="searchByEmail">
  </div>
</div>

<div class="table-responsive">
<table id="students" class="table table-striped table-sm">
  <thead>
    <tr>
      <th>Fecha de alta</th>      
      <th>Nombre</th>
      <th>Email</th>
      <th class="text-center">TFG/TFM Asignado</th>
      <th class="text-center">Estado</th>
      <th></th>
      <!--<th></th>-->
    </tr>
  </thead>
  <tbody>
@foreach ($students as $s)
  <tr>
      <td>{{ $s->user->fechaRegistro }}</td>
      <td>{{ $s->user->getFullName() }}</td>
      <td>{{ $s->user->emailUsuario }}</td>
      <td class="text-center">@if (App\Models\Asigna::hasProject(App\Models\Config::getCurrentYear(), $s->user->idUsuario)) Si @else No @endif</td>
      <td class="text-center">{{ $s->user->estadoUsuario }}</td>
      <td><a href="#">Editar</a></td>            
      <!--<td><a href="#">Eliminar</a></td>-->
  </tr>
@endforeach
  </tbody>
</table>
</div>

@endsection

@section('footerScripts')
@parent
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script>

    $(document).ready( function () {

        var oTable = $('table#students').DataTable({
          "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
              "sFirst":    "Primero",
              "sLast":     "Último",
              "sNext":     "Siguiente",
              "sPrevious": "Anterior"
            },
            "oAria": {
              "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
              "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
          },
          "dom": 'rtp',
          "ordering": false,
          "info":     true
        });
        $('input#searchByName').keyup( function() { oTable.columns(1).search($(this).val()).draw(); } );
        $('input#searchByEmail').keyup( function() { oTable.columns(2).search($(this).val()).draw(); } );

    } );
    </script>    
@endsection