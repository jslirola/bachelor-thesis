{{ Form::open(array('route' => array('projects', $id))) }}
<div class="form-group">
{{ Form::label('nombreTrabajo', 'Trabajo:') }}
{{ Form::text('nombreTrabajo', $project, ['class' => 'form­-control', 'disabled' => 'disabled']) }}
</div>
<div class="form-group">
{{ Form::label('idUsuario', 'Alumno:') }}
{{ Form::select('idUsuario', $students, null, ['class' => 'form­-control']) }}
</div>
<div class="form-group">
{{ Form::hidden('idTrabajo', $project_id) }}
{{ Form::submit('Crear asignación', array('class' => 'btn btn-primary btn-sm')) }}
</div>
{!! Form::close() !!}