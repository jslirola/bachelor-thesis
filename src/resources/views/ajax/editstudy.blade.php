{{ Form::open(array('route' => array('getstudies', $id))) }}
<div class="form-group">
	<label for="nombreTitulacion">Nombre:</label>
	<input type="text" name="nombreTitulacion" class="form-control" id="nombreTitulacion" value="{{ $study->nombreTitulacion }}">
</div>
<div class="form-group">
	<label for="tipoTitulacion">Tipo:</label>
	<select name="tipoTitulacion" class="form-control" id="tipoTitulacion">
		@if ($study->tipoTitulacion == 1)
		<option value="1" selected="selected">Grado</option>
		<option value="2">Máster</option>
		@else
		<option value="1">Grado</option>
		<option value="2" selected="selected">Máster</option>
		@endif
	</select>
</div>
<div class="form-group">
<input type="hidden" name="idTitulacion" value="{{ $study->idTitulacion }}">
{{ Form::submit('Editar titulación', array('class' => 'btn btn-primary btn-sm')) }}
</div>
{!! Form::close() !!}