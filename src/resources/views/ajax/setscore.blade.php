@if(!empty($error))

<div class="alert alert-danger" role="alert">
<strong>Error:</strong> {{ $error }}
</div>

@else

{{ Form::open(array('route' => array('studycourts', $id))) }}
<div class="form-group">
	<label for="trabajo">Trabajo:</label>
	<input type="text" name="trabajo" class="form-control" id="trabajo" value="{{ $project->tituloTrabajo }}" readonly="">
</div>
<div class="form-group">
	<label for="scoreProject">Calificación:</label> <input id="myscore" value="5" readonly="">
</div>
<div class="form-group">
	<input type="range" name="scoreProject" class="form-control" id="scoreProject" min="0" max="10" step="0.1" onchange="this.form.myscore.value = this.value;" oninput="this.form.myscore.value = this.value;">
</div>
<div class="form-group text-right">
	<input type="hidden" name="number" value="{{ $number }}">
	<input type="submit" class="btn btn-primary btn-sm" value="Guardar evaluación">
</div>

<script type="text/javascript">
function updateTextInput(val) {
    document.getElementById("myscore").value = val;
}	
</script>
{!! Form::close() !!}
@endif