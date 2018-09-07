@extends('back.layout')

@section('title', 'Nuevo Administrador de Centro')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('administrator') }}">Backend</a></li>
    <li class="breadcrumb-item"><a href="{{ route('centers') }}">Centros</a></li>
    <li class="breadcrumb-item"><a href="{{ route('centeradmins') }}">Administradores</a></li>
    <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
@endsection

@section('content')

{{ Form::open(array('route' => array('centeradmins'))) }}
<div class="form-group">
{{ Form::label('nombreUsuario', 'Nombre:') }}
{{ Form::text('nombreUsuario', null, ['class' => 'form­-control', 'required']) }}
</div>
<div class="form-group">
{{ Form::label('apellidosUsuario', 'Apellidos:') }}
{{ Form::text('apellidosUsuario', null, ['class' => 'form­-control']) }}
</div>
<div class="form-group">
{{ Form::label('emailUsuario', 'Email:') }}
{{ Form::email('emailUsuario', null, ['class' => 'form­-control', 'required']) }}
</div>
<div class="form-group">
{{ Form::label('centroUsuario', 'Centro:') }}
{{ Form::select('centroUsuario', $centers, null, ['class' => 'form­-control']) }}
</div>
<div class="form-group">
{{ Form::label('telefonoUsuario', 'Teléfono:') }}
{{ Form::text('telefonoUsuario', null, ['class' => 'form­-control']) }}
</div>
<div class="form-group">
{{ Form::label('dniUsuario', 'DNI (login):') }}
{{ Form::text('dniUsuario', null, ['class' => 'form­-control', 'required']) }}
</div>
<div class="form-group">
{{ Form::submit('Crear administrador de centro', array('class' => 'btn btn-primary btn-sm')) }}
</div>
{!! Form::close() !!}

@endsection