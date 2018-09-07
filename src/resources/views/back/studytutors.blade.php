@extends('back.layout')

@section('title', $study->nombreTitulacion . ' - Tutores')

@section('customCSS')
@parent
    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tables.css') }}" rel="stylesheet">
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('administrator') }}">Backend</a></li>
    <li class="breadcrumb-item">Titulaciones</li>
    <li class="breadcrumb-item">{{ $study->nombreTitulacion }} </li>
    <li class="breadcrumb-item active" aria-current="page">Tutores</li>
@endsection

@section('content')

<a href="{{ route('newtutor', $study->idTitulacion) }}" class="btn btn-success btn-sm mb-3">Añadir nuevo</a>

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
<table id="centeradmins" class="table table-striped table-sm">
  <thead>
    <tr>
      <th>Nombre</th>
      <th>Email</th>
      <th class="text-center">Alumnos</th>
      <!--<th class="text-center">Estado</th>-->
    </tr>
  </thead>
  <tbody>
@foreach ($users as $user)
  <tr>
      <td>{{ $user->user->getFullName() }}</td>
      <td>{{ $user->user->emailUsuario }}</td>
      <td class="text-center">{{ App\Models\Dirige::getNumberProjects($user->user->idUsuario) }}</td>
      <!--<td class="text-center">{{ $user->user->estadoUsuario }}</td>-->
  </tr>
@endforeach
  </tbody>
</table>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Añadir tutor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
    </div>
  </div>
</div>
@endsection

@section('footerScripts')
@parent
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script>

    $(document).ready( function () {

        var oTable = $('table#centeradmins').DataTable({
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
        $('input#searchByName').keyup( function() { oTable.columns(0).search($(this).val()).draw(); } );
        $('input#searchByEmail').keyup( function() { oTable.columns(1).search($(this).val()).draw(); } );

    } );
    </script>    
@endsection