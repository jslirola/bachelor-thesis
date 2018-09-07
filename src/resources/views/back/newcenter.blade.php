@extends('back.layout')

@section('title', 'Nuevo Centro')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('administrator') }}">Backend</a></li>
    <li class="breadcrumb-item"><a href="{{ route('centers') }}">Centros</a></li>
    <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
@endsection

@section('content')

{{ Form::open(array('route' => array('centers'))) }}
<div class="form-group">
{{ Form::label('nombreCentro', 'Nombre:') }}
{{ Form::text('nombreCentro', null, ['class' => 'form­-control', 'required']) }}
</div>
<div class="form-group">
{{ Form::label('direccionCentro', 'Dirección:') }}
{{ Form::text('direccionCentro', null, ['class' => 'form­-control']) }}
</div>
<div class="form-group">
{{ Form::label('telefonoCentro', 'Teléfono:') }}
{{ Form::text('telefonoCentro', null, ['class' => 'form­-control']) }}
</div>
<div class="form-group">
{{ Form::submit('Crear centro', array('class' => 'btn btn-primary btn-sm')) }}
</div>
{!! Form::close() !!}

@endsection