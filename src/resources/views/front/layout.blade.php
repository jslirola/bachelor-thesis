@if (App\Models\Config::all()->isEmpty() || App\Models\Config::find(1)->count() == 0)
  {{ __('messages.error_config_not_found') }}
@else
<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <title>{{ env('APP_NAME') }} | @yield('title', 'Inicio')</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    @section('customCSS')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @show

  </head>

  <body>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item{{ (Request::route()->getName() == 'index' ? ' active' : '') }}">
                <a class="nav-link" href="{{ route('index') }}">Inicio <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item{{ (Request::route()->getName() == 'front.projects' ? ' active' : '') }}">
                <a class="nav-link" href="{{ route('front.projects') }}">Listado de Trabajos</a>
              </li>
            </ul>
        </div>
        <div class="mx-auto order-0">
            <a class="navbar-brand mx-auto" href="#">{{ env('APP_NAME') }}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
            <ul class="navbar-nav ml-auto">
              @auth
              <li class="nav-item">
                <a class="nav-link{{ (Request::route()->getName() == 'dashboard' ? ' active' : '') }}" href="{{ route('dashboard') }}">Mi cuenta{{ (Auth::user()->nombreUsuario) ? ' (' . Auth::user()->nombreUsuario . ')' : '' }}</a>
              </li>
              @if (App\Models\Asigna::hasProject(App\Models\Config::getCurrentYear(), Auth::user()->idUsuario))
              <li class="nav-item">
                <a class="nav-link{{ (Request::route()->getName() == 'myproject' ? ' active' : '') }}" href="{{ route('myproject') }}">Mi trabajo</a>
              </li>   
              @endif           
              @if (Auth::user()->hasRolBackend())
              <li class="nav-item">
                <a class="nav-link" href="{{ route('administrator') }}">Administración</a>
              </li>
              @endif
              <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}">Cerrar sesión</a>
              </li>  
              @endauth
              @guest
              <li class="nav-item">
                <a class="nav-link{{ (Request::route()->getName() == 'login' ? ' active' : '') }}" href="{{ route('login') }}">Iniciar sesión</a>
              </li>   
              @endguest  
            </ul>
        </div>
    </nav>

    <main role="main" class="container">

      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          @section('breadcrumb')
          <li class="breadcrumb-item"><a href="{{ route('index') }}">Inicio</a></li>
          @show
        </ol>
      </nav>

      @yield('content')

    </main><!-- /.container -->

    @section('footerScripts')
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    @show

  </body>
</html>
@endif