@extends('back.layout')

@section('title', 'Listado de Centros')

@section('customCSS')
@parent
    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tables.css') }}" rel="stylesheet">
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('administrator') }}">Backend</a></li>
    <li class="breadcrumb-item active" aria-current="page">Centros</li>
@endsection

@section('content')

<a href="{{ route('newcenter') }}" class="btn btn-success btn-sm mb-3">Añadir nuevo</a>

<div class="row">
  <div class="col">
  <label for="searchByName">Filtrar por nombre</label>
    <input type="text" class="form-control form-control-sm" id="searchByName">
  </div>
  <div class="col mb-3">
    <label for="searchByAdmin">Filtrar por administrador</label>
    <input type="text" class="form-control form-control-sm" id="searchByAdmin">
  </div>
</div>

<div class="table-responsive">
<table id="centers" class="table table-striped table-sm">
  <thead>
    <tr>
      <th></th>
      <th>#</th>
      <th>Nombre</th>
      <th>Teléfono</th>
      <th>Dirección</th>
      <th class="text-center">Titulaciones</th>
      <th>Administrador</th>
    </tr>
  </thead>
  <tbody>
@foreach ($centers as $center)
  <tr>
      <td></td>
      <td>{{ $center->idCentro }}</td>
      <td>{{ $center->nombreCentro }}</td>
      <td>{{ $center->telefonoCentro }}</td>
      <td>{{ $center->direccionCentro }}</td>
      <td class="text-center"><a href="#" class="more-details">{{ count($center->getStudies()) }}</a></td>
      <td>{{ $center->isManaged() ? $center->admin->user->getFullName() : "-" }}</td>            
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

    function format ( d ) {
      var div = $('<div/>')
          .addClass( 'loading' )
          .text( 'Cargando ...' );
   
      $.ajax( {
          url: '{{ route("getStudiesByCenter")}}',
          data: {
              center: d.id
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

        var oTable = $('table#centers').DataTable({
            "columns": [
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ''
                },
                { "data": "id", "visible": false },
                { "data": "name" },
                { "data": "phone" },
                { "data": "address" },
                { "data": "studies" },
                { "data": "admin" }
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
        $('input#searchByAdmin').keyup( function() { oTable.columns(6).search($(this).val()).draw(); } );
        $('#freeProjects').click( function() { 
          var val = $(this).is(':checked') ? "No" : "";
          oTable.columns(5).search(val).draw(); 
        });

        $('#centers tbody').on('click', 'td.details-control, tr td a.more-details', function (e) {
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