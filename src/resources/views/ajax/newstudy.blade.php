{{ Form::open(array('route' => array('getstudies', $id))) }}
<div class="form-group">
	<label for="nombreTitulacion">Nombre:</label>
	<input type="text" name="nombreTitulacion" class="form-control" id="nombreTitulacion">
</div>
<div class="form-group">
	<label for="tipoTitulacion">Tipo:</label>
	<select name="tipoTitulacion" class="form-control" id="tipoTitulacion">
		<option value="1">Grado</option>
		<option value="2">Máster</option>
	</select>
</div>
<div class="form-group text-right">
{{ Form::submit('Crear titulación', array('class' => 'btn btn-primary btn-sm')) }}
</div>
{!! Form::close() !!}