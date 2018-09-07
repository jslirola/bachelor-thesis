{{ Form::open(array('route' => array('getstudies', $id))) }}
<div class="row form-group">
	<div class="col">
		<label for="idTitulacion">Titulación:</label>
		<select name="idTitulacion" class="form-control" id="idTitulacion">
	      @foreach ($studies as $s)
	      <option value="{{ $s->study->idTitulacion }}">{{ $s->study->nombreTitulacion }}</option>
	      @endforeach
		</select>
	</div>
	<div class="col">
		<label for="nombreTema">Nombre:</label>
		<input type="text" name="nombreTema" class="form-control" id="nombreTema">
	</div>
</div>
<div class="form-group text-right">
{{ Form::submit('Crear y asignar tema', array('class' => 'btn btn-primary btn-sm')) }}
</div>
{!! Form::close() !!}
<div class="alert alert-warning" role="alert">
  <strong>Aviso:</strong> También puede asociar un tema a la titulación si ya existía.
</div>
{{ Form::open(array('route' => array('getstudies', $id))) }}
<div class="row form-group">
	<div class="col">
		<label for="idTitulacion">Titulación:</label>
		<select name="idTitulacion" class="form-control" id="idTitulacion">
	      @foreach ($studies as $s)
	      <option value="{{ $s->study->idTitulacion }}">{{ $s->study->nombreTitulacion }}</option>
	      @endforeach
		</select>
	</div>
	<div class="col">
		<label for="idTema">Tema:</label>
		<select name="idTema" class="form-control" id="idTema">
	      @foreach ($topics as $t)
	      <option value="{{ $t->topic->idTema }}">{{ $t->topic->titulo }}</option>
	      @endforeach
		</select>	
	</div>
</div>
<div class="form-group text-right">
{{ Form::submit('Asignar tema', array('class' => 'btn btn-primary btn-sm')) }}
</div>
{!! Form::close() !!}