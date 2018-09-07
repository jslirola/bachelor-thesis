@extends('front.layout')

@section('title', 'Panel de Usuario')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active" aria-current="page">Panel de Usuario</li>
@endsection

@section('content')
<div class="row">
	<div class="col-sm-12">

		<div class="card mb-3">
		  <h5 class="card-header">Datos personales</h5>
		  <div class="card-body">

			<form>
			  <div class="form-group">
				<div class="row">
					<div class="col">
						<label for="formGroupExampleInput">Nombre</label>
						<input type="text" class="form-control" placeholder="Introduzca su nombre" value="{{ Auth::user()->nombreUsuario }}">
					</div>
					<div class="col">
						<label for="formGroupExampleInput">Apellidos</label>
						<input type="text" class="form-control" placeholder="Introduzca sus Apellidos" value="{{ Auth::user()->ApellidosUsuario }}">
					</div>
				</div>		  	
			  </div>
			  <div class="form-group">
				<div class="row">
					<div class="col">
						<label for="formGroupExampleInput">DNI</label>
						<input type="text" class="form-control" value="{{ Auth::user()->dniUsuario }}" disabled="">
					</div>
					<div class="col">
						<label for="formGroupExampleInput">Teléfono</label>
						<input type="text" class="form-control" placeholder="Introduzca su teléfono" value="{{ Auth::user()->telefonoUsuario }}">
					</div>
				</div>		  	
			  </div>		  
			  <div class="form-group">
			    <label for="formGroupExampleInput2">Email</label>
			    <input type="email" class="form-control" id="formGroupExampleInput2" placeholder="Introduzca su email" value="{{ Auth::user()->emailUsuario }}">
			  </div>

			@if (!Auth::user()->hasRolBackend())
			   
			  <div class="form-group">
				<label for="formGroupExampleInput">Titulación</label>
				<input type="text" class="form-control" placeholder="No se ha registrado en ninguna titulación" value="{{ $study }}" disabled="">
			  </div>
			  <div class="form-group">
				<div class="row">
					<div class="col">
						<label for="formGroupExampleInput">TFG/TFM Asignado</label>
						<input type="text" class="form-control" value="{{ $project }}" disabled="">

					</div>
					<div class="col">
						<label for="formGroupExampleInput">Tutor/es</label>
						<input type="text" class="form-control" value="{{ $tutor }}" disabled="">
					</div>
				</div>		  	
			  </div>

			@endif

				<button type="submit" class="btn btn-primary">Guardar</button>

			</form>

		  </div>
		</div>		  

	</div>
</div>
@endsection