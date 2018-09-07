@extends('back.layout')

@section('title', $study->nombreTitulacion . ' - Tribunales')

@section('customCSS')
@parent
    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tables.css') }}" rel="stylesheet">
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('administrator') }}">Backend</a></li>
    <li class="breadcrumb-item">Titulaciones</li>
    <li class="breadcrumb-item">{{ $study->nombreTitulacion }} </li>
    <li class="breadcrumb-item active" aria-current="page">Tribunales</li>
@endsection

@section('content')

@if (!App\Models\Config::isDefensaAvailable())
<a href="#" data-court="{{ route('newcourt', $study->idTitulacion) }}" class="btn btn-success btn-sm mb-3 newcourt">Añadir nuevo</a>
@else
<div class="alert alert-warning" role="alert">
  <strong>Aviso:</strong> {{ __('messages.error_disabled_court') }}
</div>
@endif

<div class="row">
  <div class="col">
  <label for="searchByName">Filtrar por título</label>
    <input type="text" class="form-control form-control-sm" id="searchByName">
  </div>
  <div class="col mb-3">
    <label for="searchByEmail">Filtrar por alumno</label>
    <input class="form-control form-control-sm" id="searchByStudent">
  </div>
</div>

<div class="table-responsive">
<table id="courts" class="table table-striped table-sm">
  <thead>
    <tr>
      <th></th>
      <th>Número</th>
      <th>Trabajo</th>
      <th>Alumno</th>      
      <th class="text-center">Convocatoria</th>
      <th class="text-center">Acciones</th>
    </tr>
  </thead>
  <tbody>
@foreach ($users as $user)
  <tr>
      <td></td>
      <td >{{ $user->numero }}</td>
      <td>{{ App\Models\Trabajo::getProjectByCourt($user->anyo, $user->convocatoria, $user->numero)->first()->tituloTrabajo }}</td>
      <td>{{ App\Models\Trabajo::getStudentByCourt($user->anyo, $user->convocatoria, $user->numero)->first()->user->getFullName() }}</td>
      <td class="text-center">{{ App\Models\Config::getConvName($user->convocatoria) }}</td>      
      <td class="text-center">
        @if (App\Models\Evalua::hasScore($user->anyo, $user->idTitulacion, $user->numero))
        -
        @else
        <a href="#" class="setscore" data-project="{{ route('setscore', ['id' => $study->idTitulacion, 'num' => $user->numero]) }}">Evaluar</a>
        @endif
      </td>      
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
        <h5 class="modal-title">Añadir tribunal</h5>
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

<!-- Modal Evaluation -->
<div class="modal fade" id="myModalEvaluation" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Evaluar trabajo</h5>
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

    function format ( d ) {
      var div = $('<div/>')
          .addClass( 'loading' )
          .text( 'Cargando ...' );
   
      $.ajax( {
          url: '{{ route("getCourtMembers")}}',
          data: {
              num: d.id
          },
          method: 'post',
          dataType: 'json',
          success: function ( json ) {
              div
                  .html( json.html )
                  .removeClass( 'loading' );
          }
      } );
   
      return div;
    }

    $(document).ready( function () {

        var oTable = $('table#courts').DataTable({
          "columns": [
              {
                  "className":      'details-control',
                  "orderable":      false,
                  "data":           null,
                  "defaultContent": ''
              },
              { "data": "id"},
              { "data": "project" },
              { "data": "student" },
              { "data": "conv" },              
              { "data": "actions" }
          ],          
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
        $('input#searchByName').keyup( function() { oTable.columns(2).search($(this).val()).draw(); } );
        $('input#searchByStudent').keyup( function() { oTable.columns(3).search($(this).val()).draw(); } );

        $('.setscore').on('click',function(e){
          e.preventDefault();
          var dst = $(this).data('project'); 
          $('.modal-body').load(dst, function(){
            $('#myModalEvaluation').modal({show:true});
          });
        }); 

        $('.newcourt').on('click',function(e){
          e.preventDefault();
          var dst = $(this).data('court'); 
          $('.modal-body').load(dst, function(){
            $('#myModal').modal({show:true});
          });
        }); 

        $('#courts tbody').on('click', 'td.details-control, tr td a.more-details', function (e) {
            e.preventDefault();
            var tr = $(this).closest('tr');
            var row = oTable.row( tr );
         
            if ( row.child.isShown() ) {
                row.child.hide();
                tr.removeClass('details');
            }
            else {
                row.child( format(row.data()) ).show();
                tr.addClass('details');
            }
        });

    } );
    </script>    
@endsection