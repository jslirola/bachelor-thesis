@extends('back.layout')

@section('title', $center->nombreCentro . ' -  Listado de Titulaciones')

@section('customCSS')
@parent
    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tables.css') }}" rel="stylesheet">
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('administrator') }}">Backend</a></li>
    <li class="breadcrumb-item"><a href="{{ route('centers') }}">Centros</a></li>
    <li class="breadcrumb-item">{{ $center->nombreCentro }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Titulaciones</li>
@endsection

@section('content')

<a href="#" data-project="{{ route('newcenterstudy', ['id' => $id]) }}" class="btn btn-success btn-sm mb-3 newstudy">Añadir nueva</a>
<a href="#" data-topic="{{ route('newtopic', ['id' => $id]) }}" class="btn btn-secondary btn-sm mb-3 newtopic">Añadir tema</a>

<div class="row">
  <div class="col">
  <label for="searchByName">Filtrar por nombre</label>
    <input type="text" class="form-control form-control-sm" id="searchByName">
  </div>
  <div class="col mb-3">
    <label for="searchByType">Filtrar por tipo</label>
    <select class="form-control form-control-sm" id="searchByType">
      <option value="">Todos</option>
      <option>Grado</option> 
      <option>Máster</option> 
    </select>
  </div>
  <div class="col mb-3">
    <label for="searchByTopic">Filtrar por temas</label>
    <select class="form-control form-control-sm" id="searchByTopic">
      <option value="">Todos</option>
      @foreach ($topics as $t)
      <option>{{ $t->topic->titulo }}</option>
      @endforeach
    </select>
  </div>  
</div>

<div class="table-responsive">
<table id="students" class="table table-striped table-sm">
  <thead>
    <tr>
      <th>Nombre</th>
      <th>Tipo</th>
      <th class="text-center">Temas de clasificación</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
@foreach ($studies as $s)
  <tr>
      <td>{{ $s->study->nombreTitulacion }}</td>
      <td>{{ App\Models\Titulacion::getTypeName($s->study->tipoTitulacion) }}</td>
      <td class="text-center">
        @foreach ($s->study->topics as $t)
        <span class="badge badge-secondary">{{ $t->topic->titulo }}</span>
        @endforeach
      </td>
      <td><a href="#" class="editstudy" data-study="{{ route('editstudy', ['id' => $id, 's_id' => $s->study->idTitulacion]) }}">Editar</a></td>            
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
        <h5 class="modal-title">Añadir titulación</h5>
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

<!-- Modal -->
<div class="modal fade" id="myEditModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar titulación</h5>
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

<!-- Modal -->
<div class="modal fade" id="myTopicModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Añadir/Asignar tema</h5>
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
        $('input#searchByName').keyup( function() { oTable.columns(0).search($(this).val()).draw(); } );
        $('select#searchByType').change( function() { oTable.columns(1).search($(this).val()).draw(); } );
        $('select#searchByTopic').change( function() { oTable.columns(2).search($(this).val()).draw(); } );

        $('.newstudy').on('click',function(e){
          e.preventDefault();
          var dst = $(this).data('project'); 
          $('.modal-body').load(dst, function(){
            $('#myModal').modal({show:true});
          });
        }); 

        $('.editstudy').on('click',function(e){
          e.preventDefault();
          var dst = $(this).data('study'); 
          $('.modal-body').load(dst, function(){
            $('#myEditModal').modal({show:true});
          });
        });

        $('.newtopic').on('click',function(e){
          e.preventDefault();
          var dst = $(this).data('topic'); 
          $('.modal-body').load(dst, function(){
            $('#myTopicModal').modal({show:true});
          });
        }); 
    } );
    </script>    
@endsection