@if(!empty($error))

<div class="alert alert-danger" role="alert">
<strong>Error:</strong> {{ $error }}
</div>

@else

<div id="tutor_error" class="alert alert-danger d-none" role="alert">
<strong>Error:</strong> {{ __('messages.error_unavailable_tutors') }}
</div>

<div id="step1">

	<div class="form-group">
		<label for="idAlumnoTribunal">Alumno:</label>
		<select class="form-control" id="idAlumnoTribunal">
			@foreach ($students as $s)
			<option value="{{ $s->user->idUsuario }}">{{ $s->user->getFullName() }}</option>
			@endforeach
		</select>
	</div>

	<div class="form-group text-right">
		<button id="getStep2" class="btn btn-primary btn-sm">Seleccionar miembros del tribunal</button>
	</div>	

	<div id="result"> <select id="base" class="d-none"></select> </div>

</div>

<div id="step2" class="d-none">

	<div id="student_info" class="alert alert-warning" role="alert">
	<strong>Aviso:</strong> {{ __('messages.advice_omitted_tutor') }} <span id="student_name"></span>
	</div>	

	{{ Form::open(array('route' => array('studycourts', $id), 'id' => 'court_form')) }}
	<div class="row">
		<div class="col">
			<label for="tutor1">Tutor:</label>
			<select name="tutor1" class="form-control" id="tutor1">
			</select>
		</div>
		<div class="col">
			<label for="rol1">Rol:</label>
			<select name="rol1" class="form-control" id="rol1">
				<option value="1" selected="selected">Presidente</option>
				<option value="2">Secretario</option>
				<option value="3">Primer Vocal</option>
				<option value="4">Segundo Vocal</option>
				<option value="5">Tercero Vocal</option>
			</select>
		</div>
	</div>
	<div class="row mt-2">
		<div class="col">
			<label for="tutor2">Tutor:</label>
			<select name="tutor2" class="form-control" id="tutor2">
			</select>
		</div>
		<div class="col">
			<label for="rol2">Rol:</label>
			<select name="rol2" class="form-control" id="rol2">
				<option value="1">Presidente</option>
				<option value="2" selected="selected">Secretario</option>
				<option value="3">Primer Vocal</option>
				<option value="4">Segundo Vocal</option>
				<option value="5">Tercero Vocal</option>
			</select>
		</div>
	</div>
	<div class="row mt-2">
		<div class="col">
			<label for="tutor3">Tutor:</label>
			<select name="tutor3" class="form-control" id="tutor3">
			</select>
		</div>
		<div class="col">
			<label for="rol3">Rol:</label>
			<select name="rol3" class="form-control" id="rol3">
				<option value="1">Presidente</option>
				<option value="2">Secretario</option>
				<option value="3" selected="selected">Primer Vocal</option>
				<option value="4">Segundo Vocal</option>
				<option value="5">Tercero Vocal</option>
			</select>
		</div>
	</div>
	<div class="form-group text-right mt-3">
	<input type="hidden" id="idAlumno" name="idAlumno">
	{{ Form::submit('Crear tribunal', array('class' => 'btn btn-primary btn-sm', 'id' => 'court_generate')) }}
	</div>
	{!! Form::close() !!}

</div>

<script>

$(document).ready( function () {

    $('#getStep2').on('click',function(e){
      e.preventDefault();
      $("#tutor_error").addClass('d-none');
      $.ajax( {
          url: '{{ route("getAvailableTutors")}}',
          data: {
              student: $("select#idAlumnoTribunal").val()
          },
          method: 'post',
          dataType: 'json',
          success: function ( json ) {
          	if(Object.keys(json.html).length > 2) { // Minimun 3 users
				$.each(json.html,function(key, value) {
				    $("select#tutor1").append('<option value=' + key + '>' + value + '</option>');
				    $("select#tutor2").append('<option value=' + key + '>' + value + '</option>');
				    $("select#tutor3").append('<option value=' + key + '>' + value + '</option>');
				});
				$('span#student_name').html($("select#idAlumnoTribunal option:selected").first().text() + '.');
				$('input#idAlumno').val($("select#idAlumnoTribunal").val());
				$("#step1").hide();
				$("#step2").removeClass('d-none');
			} else {
				$("#tutor_error").removeClass('d-none');
			}
          }
      });
    }); 

    $('#court_generate').on('click',function(e){
      e.preventDefault();
      if(areEqual($('select#tutor1').val(), $('select#tutor2').val(), $('select#tutor3').val())) {
      	alert('Un tutor no puede pertenecer a dos cargos distintos.');
      } else if (areEqual($('select#rol1').val(), $('select#rol2').val(), $('select#rol3').val())) {
      	alert('No se pueden repetir los cargos en el tribunal.');
      } else {
      	$("form#court_form").submit();
      }
  	});

});


function areEqual(a,b,c) {
    return (a==b || a==c || b==c);
}


</script>    

@endif
