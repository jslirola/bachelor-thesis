@extends('front.layout')

@section('title', 'Iniciar sesión')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active" aria-current="page">Iniciar sesión</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">

                <div class="card mb-3">
                  <h5 class="card-header">Acceda al sistema</h5>
                  <div class="card-body">

                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('loginUsuario') ? ' has-error' : '' }}">
                            <label for="loginUsuario" class="col-md-4 control-label">Login</label>

                            <div class="col-md-6">
                                <input id="loginUsuario" type="text" class="form-control" name="loginUsuario" value="{{ old('loginUsuario') }}" required autofocus>

                                @if ($errors->has('emailUsuario'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('emailUsuario') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('hashUsuario') ? ' has-error' : '' }}">
                            <label for="hashUsuario" class="col-md-4 control-label">Contraseña</label>

                            <div class="col-md-6">
                                <input id="hashUsuario" type="password" class="form-control" name="hashUsuario" required>

                                @if ($errors->has('hashUsuario'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('hashUsuario') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Recordar mis datos
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Iniciar sesión
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            </div>
                        </div>
                    </form>
                 </div>
                </div>
            </div>
        </div>
    </div>
@endsection
