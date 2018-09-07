@extends('front.layout')

@section('title', 'Inicio')

@section('content')
<div class="row">
	<div class="col-sm-12">

		<div class="card mb-3">

			<h5 class="card-header">Portal de Gestión de Trabajos de Fin de Grado y Trabajos de Fin de Máster</h5>

			<div class="row">
			  <div class="col-sm-6">
			    <div class="card m-2">
				  <img class="card-img-top" src="{{ asset('img/thesis.jpg') }}" alt="Estudiantes">
				  <div class="card-body">
				    <h5 class="card-title">Estudiantes</h5>
				    <p class="card-text">Consulte los proyectos disponibles, solicite la asignación de uno de ellos, dedique tiempo en su desarrollo y finalmente defiéndalo ante un tribunal.</p>
				  </div>
				</div>
			  </div>

			  <div class="col-sm-6">
			    <div class="card m-2">
				  <img class="card-img-top" src="{{ asset('img/teacher.png') }}" alt="Docentes">
				  <div class="card-body">
				    <h5 class="card-title">Docentes</h5>
				    <p class="card-text">Gestione los usuarios, centros, titulaciones, departamentos, trabajos, tribunales, estadísticas y configure las fechas del sistema con facilidad.</p>
				  </div>
				</div>
			  </div>
			</div>

		</div>

	</div>
</div>
@endsection

@section('footerScripts')
@parent
<script src="app.js"></script>
@endsection