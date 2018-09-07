@extends('back.layout')

@section('title', 'Editar Centro')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('administrator') }}">Backend</a></li>
    <li class="breadcrumb-item"><a href="{{ route('centers') }}">Centros</a></li>
    <li class="breadcrumb-item">{{ $center->nombreCentro }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Editar</li>
@endsection

@section('content')

{{ Form::open(array('route' => array('editcenter', $id))) }}
<div class="form-group">
{{ Form::label('nombreCentro', 'Nombre:') }}
{{ Form::text('nombreCentro', $center->nombreCentro, ['class' => 'form­-control', 'required']) }}
</div>
<div class="form-group">
{{ Form::label('direccionCentro', 'Dirección:') }}
{{ Form::text('direccionCentro', $center->direccionCentro, ['class' => 'form­-control']) }}
</div>
<div class="form-group">
{{ Form::label('telefonoCentro', 'Teléfono:') }}
{{ Form::text('telefonoCentro', $center->telefonoCentro, ['class' => 'form­-control']) }}
</div>
<div class="form-group">
{{ Form::submit('Editar centro', array('class' => 'btn btn-primary btn-sm')) }}
</div>
{!! Form::close() !!}

@endsection