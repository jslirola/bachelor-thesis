@extends('back.layout')

@section('title', 'Nueva Titulación')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('administrator') }}">Backend</a></li>
    <li class="breadcrumb-item"><a href="{{ route('centers') }}">Centros</a></li>
    <li class="breadcrumb-item active" aria-current="page">Nueva titulación</li>
@endsection

@section('content')

{{ Form::open(array('route' => array('newstudy'))) }}
<div class="form-group">
{{ Form::label('nombreTitulacion', 'Nombre:') }}
{{ Form::text('nombreTitulacion', null, ['class' => 'form­-control', 'required']) }}
</div>
<div class="form-group">
{{ Form::label('tipoTitulacion', 'Tipo:') }}
{{ Form::select('tipoTitulacion', [1 => "Grado", 2 => "Máster"]) }}
</div>
<div class="form-group">
{{ Form::label('centroTitulacion', 'Centro:') }}
{{ Form::select('centroTitulacion', $centers) }}
</div>
<div class="form-group">
{{ Form::submit('Crear titulación', array('class' => 'btn btn-primary btn-sm')) }}
</div>
{!! Form::close() !!}

<div class="alert alert-warning" role="alert">
	<strong>Aviso:</strong> Si ya existe la titulación, puede asignarla directamente al centro en el siguiente formulario.
</div>

<h3>Asignar titulación</h3>

{{ Form::open(array('route' => array('newstudy'))) }}
<div class="form-group">
{{ Form::label('asignarTitulacion', 'Titulación:') }}
{{ Form::select('asignarTitulacion', $studies, null, ['class' => 'form­-control']) }}
</div>
<div class="form-group">
{{ Form::label('centroTitulacion', 'Centro:') }}
{{ Form::select('centroTitulacion', $centers) }}
</div>
<div class="form-group">
{{ Form::submit('Asignar titulación', array('class' => 'btn btn-primary btn-sm')) }}
</div>
{!! Form::close() !!}

@endsection