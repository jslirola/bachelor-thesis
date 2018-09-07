@extends('back.layout')

@section('title', $study . ' -  Listado de Trabajos')

@section('customCSS')
@parent
    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tables.css') }}" rel="stylesheet">
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('administrator') }}">Backend</a></li>
    <li class="breadcrumb-item"><a href="{{ route('projects', ['id' => $id]) }}">Trabajos</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $study }}</li>

@endsection

@section('content')

<a href="{{ route('newproject', ['id' => $id]) }}" class="btn btn-success btn-sm mb-3">Añadir nuevo</a>

<div class="alert alert-warning" role="alert">
  <strong>Aviso:</strong> Solo se mostrarán aquellos elementos relacionados con su usuario.
</div>

<div class="row">
  <div class="col">
  <label for="searchByName">Filtrar por título</label>
    <input type="text" class="form-control form-control-sm" id="searchByName">
  </div>
  <div class="col mb-3">
    <label for="searchByStudent">Filtrar por alumno</label>
    <input class="form-control form-control-sm" id="searchByStudent">
  </div>
</div>

<div class="table-responsive">
<table id="projects" class="table table-striped table-sm">
  <thead>
    <tr>
      <th>Título</th>
      <th class="text-center">Alumno</th>
      <th class="text-center">Temas</th>
      <th class="text-center">Evaluado</th>
      <th></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
@foreach ($projects as $p)
    @php
    $isAssigned = App\Models\Asigna::isAssigned($p->project->idTrabajo)
    @endphp
  <tr>
      <td>{{ $p->project->tituloTrabajo}}</td>
      <td class="text-center">@if($isAssigned) {{ $p->project->assignments->user->getFullName() }} @else - @endif</td>
      <td class="text-center">
        @foreach ($p->project->topics as $t)
        <span class="badge badge-secondary">{{ $t->topic->titulo }}</span>
        @endforeach
      </td>
      <td class="text-center">-</td>
      <td><a href="#">Editar</a></td>            
      <td>@if(!$isAssigned) <a class="assignment" data-project="{{ route('assignproject', ['id' => $p->idTitulacion, 'project' => $p->project->idTrabajo]) }}" href="#">Asignar</a> @endif</td>
  </tr>
@endforeach
  </tbody>
</table>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Asignar trabajo a un alumno</h5>
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

        var oTable = $('table#projects').DataTable({
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
        $('input#searchByStudent').keyup( function() { oTable.columns(1).search($(this).val()).draw(); } );

        $('.assignment').on('click',function(e){
          e.preventDefault();
          var dst = $(this).data('project'); 
          $('.modal-body').load(dst, function(){
            $('#myModal').modal({show:true});
          });
        }); 

    } );
    </script>    
@endsection