@extends('back.layout')

@section('title', 'Nuevo Departamento')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('administrator') }}">Backend</a></li>
    <li class="breadcrumb-item"><a href="{{ route('centers') }}">Centros</a></li>
    <li class="breadcrumb-item active" aria-current="page">Nuevo departamento</li>
@endsection

@section('content')

{{ Form::open(array('route' => array('newdepartment'))) }}
<div class="form-group">
{{ Form::label('nombreDepartamento', 'Nombre:') }}
<input class="form­-control" required="" name="nombreDepartamento" value="" id="nombreDepartamento" type="text">
</div>
<div class="form-group">
{{ Form::label('webDepartamento', 'Web:') }}
<input class="form­-control" required="" name="webDepartamento" value="" id="webDepartamento" type="text">
</div>
<div class="form-group">
{{ Form::submit('Crear departamento', array('class' => 'btn btn-primary btn-sm')) }}
</div>
{!! Form::close() !!}

@endsection