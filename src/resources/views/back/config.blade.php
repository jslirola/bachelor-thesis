@extends('back.layout')

@section('customCSS')
@parent
  <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
@endsection

@section('title', 'Configuración')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('administrator') }}">Backend</a></li>
    <li class="breadcrumb-item active" aria-current="page">Configuración</li>
@endsection

@section('content')

{{ Form::open(array('route' => array('config'))) }}
<div class="form-group">
{{ Form::label('anyoConfig', 'Año del sistema:') }}
{{ Form::select('anyoConfig', $anyos, $conf->anyo_actual, ['class' => 'form­-control']) }}

{{ Form::label('convConfig', 'Convocatoria del sistema:') }}
{{ Form::select('convConfig', $conv, $conf->conv_actual, ['class' => 'form­-control']) }}
</div>
<h5>Fechas para solicitar la defensa de trabajos</h5>
<div class="form-group">
{{ Form::label('fechaIniDefensa', 'Inicio:') }}
{{ Form::text('fechaIniDefensa', $conf->getFechaIniDefensa(), ['class' => 'form­-control']) }}

{{ Form::label('fechaFinDefensa', 'Fin:') }}
{{ Form::text('fechaFinDefensa', $conf->getFechaFinDefensa(), ['class' => 'form­-control']) }}
</div>
<div class="form-group">
{{ Form::submit('Guardar cambios', array('class' => 'btn btn-primary btn-sm')) }}
</div>

{!! Form::close() !!}

@endsection

@section('footerScripts')
@parent

  <script src="{{ asset('js/jquery-ui.js') }}"></script>
  <script src="{{ asset('js/datepicker-es.js') }}"></script>
  <script>
	function getDatepicker(from_id, to_id) {
		from = $(from_id)
		.datepicker({
			dateFormat: 'dd/mm/yy',
			changeMonth: true,
			firstDay: 1
		})
		.on( "change", function() {
		  to.datepicker( "option", "minDate", this.value );
		}),
		to = $(to_id).datepicker({
			dateFormat: 'dd/mm/yy',
			changeMonth: true,
			firstDay: 1
		})
		.on( "change", function() {
		from.datepicker( "option", "maxDate", this.value );
		});
  	}  	
	$( function() {
		getDatepicker("#fechaIniPreasignacion", "#fechaFinPreasignacion");
		getDatepicker("#fechaIniAsignacion", "#fechaFinAsignacion");
		getDatepicker("#fechaIniDefensa", "#fechaFinDefensa");
	});
  </script>
@endsection