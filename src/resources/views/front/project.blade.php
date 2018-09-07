@extends('front.layout')

@section('title', 'Mi trabajo')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active" aria-current="page">Mi trabajo</li>
@endsection

@section('content')
<div class="row">

	<div class="col-sm-12">

		<div id="project" class="card">
		  <h5 class="card-header">{{ $project->tituloTrabajo }}</h5>
		  <div class="card-body">
		    <p class="card-text">{{ $project->detalleTrabajo }}</p>
		  </div>
		  <ul class="list-group list-group-flush">
		    <li class="list-group-item list-group-item-light"><strong>Tutor(es):</strong> {{ $tutor }}</li>
		    <li class="list-group-item list-group-item-light"><strong>Tribunal:</strong> @if (isset($court)) {{ $court }} @else - @endif</li>
		    <li class="list-group-item list-group-item-light"><strong>Calificación:</strong> @if (isset($score->calificacion)) {{ $score->calificacion }} @else - @endif</li>
		  </ul>
		  @if ($hasDefense)
		    @if (!isset($score->calificacion))
		  	<a href="#" class="btn btn-dark disabled">Ha solicitado la defensa del trabajo en la próxima convocatoria.</a>
		  	@endif
		  @else

			@if (App\Models\Config::isDefensaAvailable())
			{{ Form::open(array('myproject', 'id' => 'project_form')) }}
			{{ Form::hidden('requestProjectDefense', 1) }}
			{!! Form::close() !!}
			<a id="submit_form" href="#" class="btn btn-success" data-toggle="modal" data-target=".defense-modal">Solicitar defensa en la próxima convocatoria.</a>
			@else
			<a href="#" class="btn btn-success disabled">El periodo para solicitar la defensa del trabajo no está abierto.</a>  
			@endif

		  @endif
		</div>		

	</div>
</div>

<!-- Modal -->
<div class="modal fade defense-modal"tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Confirmación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Esta acción no se puede deshacer, acepte solo cuando esté totalmente seguro de ello.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button id="submit_form" type="button" class="btn btn-primary">Aceptar</button>
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

		$(".defense-modal").on('click', '#submit_form', function(e) {
			e.preventDefault();
			$("#project_form").submit();
		});

    } );
    </script>    
@endsection