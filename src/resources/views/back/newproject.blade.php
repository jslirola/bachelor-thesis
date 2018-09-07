@extends('back.layout')

@section('title', 'Nuevo Trabajo')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('administrator') }}">Backend</a></li>
    <li class="breadcrumb-item"><a href="{{ route('projects', ['id' => $id]) }}">Trabajos</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $study }}</li>
    <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
@endsection

@section('content')

{{ Form::open(array('route' => array('projects', $id))) }}
<div class="form-group">
{{ Form::label('tituloTrabajo', 'Título:') }}
{{ Form::text('tituloTrabajo', null, ['class' => 'form­-control', 'required']) }}
</div>
<div class="form-group">
{{ Form::label('detalleTrabajo', 'Descripción:') }}
<textarea id="detalleTrabajo" name="detalleTrabajo" class="form-control"></textarea>
</div>
<div class="form-group">
{{ Form::label('propuestaAlumno', 'Propuesto por alumno:') }}
{{ Form::select('propuestaAlumno', [0 => "No", 1 => "Si"]) }}
</div>
<div id="cotutor" class="form-group d-none">
{{ Form::label('idCotutor', 'Cotutor:') }}
<select id="idCotutor" name="idCotutor">
<option value="">Seleccione uno</option>  
@foreach ($users as $u)
<option value="{{ $u->user->idUsuario }}">{{ $u->user->getFullName() }}</option>
@endforeach
</select>
</div>
<div class="form-group">
{{ Form::submit('Crear trabajo', array('class' => 'btn btn-primary btn-sm')) }}
<a href="#" class="btn btn-info btn-sm addtutor">Añadir cotutor</a>
</div>
{!! Form::close() !!}

<div class="alert alert-warning" role="alert">
	<strong>Aviso:</strong> Si ya existe el trabajo, puede asignarle temas de clasificación en el siguiente formulario.
</div>

<h3>Asignar temas</h3>

{{ Form::open(array('route' => array('projects', $id))) }}
<div class="form-group">
{{ Form::label('idTrabajo', 'Trabajo:') }}
<select id="idTrabajo" name="idTrabajo">
@foreach (App\Models\Dirige::where(['anyo' => App\Models\Config::getCurrentYear(), 'idTitulacion' => $id, 'idTutor' => Auth::user()->idUsuario])->groupBy('idTrabajo')->get() as $p)
<option value="{{ $p->project->idTrabajo }}">{{ $p->project->tituloTrabajo }}</option>
@endforeach
</select>
</div>
<div class="form-group">
{{ Form::label('temaTrabajo', 'Temas:') }}
<select id="temaTrabajo" name="temaTrabajo">
@foreach (App\Models\Tiene::where(['idTitulacion' => $id])->get() as $t)
<option value="{{ $t->topic->idTema }}">{{ $t->topic->titulo }}</option>
@endforeach
</select>
</div>
<div class="form-group">
{{ Form::submit('Asignar temas', array('class' => 'btn btn-primary btn-sm')) }}
</div>
{!! Form::close() !!}

@endsection

@section('footerScripts')
@parent
    <script>

    $(document).ready( function () {
     
        $('.addtutor').on('click',function(e){
          e.preventDefault();
          $(this).hide();
          $('#cotutor').removeClass('d-none'); 
        }); 

    } );
    </script>    
@endsection