@extends('back.layout')

@section('title', 'Nuevo Alumno')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('administrator') }}">Backend</a></li>
    <li class="breadcrumb-item">Titulaciones</li>
    <li class="breadcrumb-item">{{ $study->nombreTitulacion }} </li>
    <li class="breadcrumb-item">Alumnos</li>
    <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
@endsection

@section('content')

{{ Form::open(array('route' => array('studystudents', $id))) }}
<div class="form-group">
{{ Form::label('nombreUsuario', 'Nombre:') }}
{{ Form::text('nombreUsuario', null, ['class' => 'form­-control', 'required']) }}
</div>
<div class="form-group">
{{ Form::label('apellidosUsuario', 'Apellidos:') }}
{{ Form::text('apellidosUsuario', null, ['class' => 'form­-control']) }}
</div>
<div class="form-group">
{{ Form::label('dniUsuario', 'DNI (login):') }}
{{ Form::text('dniUsuario', null, ['class' => 'form­-control', 'required']) }}
</div>
<div class="form-group">
{{ Form::label('emailUsuario', 'Email:') }}
{{ Form::email('emailUsuario', null, ['class' => 'form­-control', 'required']) }}
</div>
<div class="form-group">
{{ Form::label('telefonoUsuario', 'Teléfono:') }}
{{ Form::text('telefonoUsuario', null, ['class' => 'form­-control']) }}
</div>
<div class="form-group">
{{ Form::submit('Crear alumno', array('class' => 'btn btn-primary btn-sm')) }}
</div>
{!! Form::close() !!}

@endsection