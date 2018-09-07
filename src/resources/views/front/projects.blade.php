@extends('front.layout')

@section('title', 'Trabajos')

@section('customCSS')
@parent
    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tables.css') }}" rel="stylesheet">
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active" aria-current="page">Listado de Trabajos</li>
@endsection

@section('content')
<div class="row">

	<div class="col-sm-12">

		<div class="card mb-3">
		  <h5 class="card-header">Búsqueda de trabajos</h5>
		  <div class="card-body">

			<form>
			  <div class="row">
			    <div class="col">
					<label for="searchByName">Filtrar por título</label>
			    	<input type="email" class="form-control form-control-sm" id="searchByName">
			    </div>
			    <div class="col">
			    	<label for="searchByStudy">Filtrar por titulación</label>
			    	<select class="form-control form-control-sm" id="searchByStudy">
			    		<option value="" selected="">Todas</option> 
					@foreach (\App\Models\Titulacion::getStudiesToSelect() as $k => $v)
			  			<option>{{ $v }}</option>
					@endforeach
			    	</select>
			    </div>
			  </div>

			  <div class="form-check mb-3 mt-2">
				<input type="checkbox" class="form-check-input form-control-sm" id="freeProjects">
			    <label class="form-check-label" for="freeProjects">Mostrar únicamente trabajos no asignados</label>
			  </div>

			</form>

			<div class="table-responsive">
			<table id="projects" class="table table-striped table-sm">
			  <thead>
			    <tr>
			      <th></th>
			      <th>Título</th>
			      <th>Descripción</th>
			      <th>Titulación</th>
			      <th>Tutor(es)</th>
			      <th>Asignado</th>
			      <th>@if(Auth::user()) Alumno(s) @endif</th>
			    </tr>
			  </thead>
			  <tbody>
			@foreach ($projects as $p)
			  <tr>
			  	  <td></td>
			      <td><a href="#" class="more-details">{{ $p->project->tituloTrabajo}}</a></td>
			      <td>{{ $p->project->detalleTrabajo}}</td>
			      <td>{{ $p->study->getFullName()}}</td>
			      <td> {{ $p->getUsers($p->study->idTitulacion, $p->project->idTrabajo)}}</td>
			      <td>@if(App\Models\Asigna::isAssigned($p->project->idTrabajo)) Si @else No @endif</td>
			      <td>@if(Auth::user()) @if(App\Models\Asigna::isAssigned($p->project->idTrabajo)) {{ $p->project->assignments->user->getFullName() }} @else - @endif @else Disponible a usuarios registrados @endif </td>
			  </tr>
			@endforeach
			  </tbody>
			</table>
			</div>

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
		    // `d` is the original data object for the row
		    return '<table id="table-small" class="table table-striped table-sm">'+
		        '<tr>'+
		            '<td><strong>Asignado:</strong></td>'+
		            '<td>'+d.assigned+'</td>'+
		            '<td><strong>Alumno:</strong></td>'+
		            '<td>'+d.student+'</td>'+
		        '</tr>'+
		        '<tr>'+
		            '<td colspan=4><strong>Descripción:</strong></td>'+
		        '</tr>'+
		        '<tr>'+
		            '<td colspan=4>'+d.details+'</td>'+
		        '</tr>'+
		    '</table>';
		}

		$(document).ready( function () {

		    var oTable = $('#projects').DataTable({
		        "columns": [
		            {
		                "className":      'details-control',
		                "orderable":      false,
		                "data":           null,
		                "defaultContent": ''
		            },
		            { "data": "title" },
		            { "data": "details", "visible": false },
		            { "data": "study" },
		            { "data": "tutor" },
		            { "data": "assigned", "visible": false },
		            { "data": "student", "visible": false }
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
		    $('input#searchByName').keyup( function() { oTable.columns(1).search($(this).val()).draw(); } );
		    $('select#searchByStudy').change( function() { oTable.columns(3).search($(this).val()).draw(); } );
		    $('#freeProjects').click( function() { 
		    	var val = $(this).is(':checked') ? "No" : "";
		    	oTable.columns(5).search(val).draw(); 
		    });

		    $('#projects tbody').on( 'click', 'tr td.details-control, tr td a.more-details', function (e) {
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
		    } );

		} );
    </script>    
@endsection