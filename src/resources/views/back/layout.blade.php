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

    <title>{{ env('APP_NAME') }} | @yield('title', 'Admin')</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    @section('customCSS')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    @show

  </head>

  <body>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="{{ route('index') }}">{{ env('APP_NAME') }}</a>
      <input class="form-control form-control-dark w-100" type="text" placeholder="" aria-label="" style="background-color: #343a40" disabled>
      <ul class="navbar-nav border-right border-secondary px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="{{ route('dashboard') }}">Mi cuenta{{ (Auth::user()->nombreUsuario) ? ' (' . Auth::user()->nombreUsuario . ')' : '' }}</a>
        </li>
      </ul>
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="{{ route('logout') }}">Cerrar sesión</a>
        </li>
      </ul>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <span>Sistema</span>
              <a class="d-flex align-items-center text-muted" href="#">
                <span data-feather="plus-circle"></span>
              </a>
            </h6>
            <ul class="nav flex-column mb-2">
              <li class="nav-item">
                <a class="nav-link{{ Request::route()->getName() == 'administrator' ? ' active' : '' }}" href="{{ route('administrator') }}">
                  <span data-feather="file-text"></span>
                  Backend
                </a>
              </li>
              @if (Auth::user()->hasRolGeneral())
              <li class="nav-item">
                <a class="nav-link{{ Request::route()->getName() == 'config' ? ' active' : '' }}" href="{{ route('config') }}">
                  <span data-feather="file-text"></span>
                  Configuración
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="file-text"></span>
                  Importar usuarios
                </a>
              </li>
              @endif
            </ul>

            @if (Auth::user()->hasRolGeneral())

            <!-- Admin General -->

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <span>Centros</span>
              <a class="d-flex align-items-center text-muted" href="#">
                <span data-feather="plus-circle"></span>
              </a>
            </h6>
            <ul class="nav flex-column mb-2">
              <li class="nav-item">
                <a class="nav-link{{ Request::route()->getName() == 'centers' ||  Request::route()->getName() == 'newcenter' ? ' active' : '' }}" href="{{ route('centers') }}">
                  <span data-feather="file-text"></span>
                  Gestión
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link{{ Request::route()->getName() == 'newstudy' ? ' active' : '' }}" href="{{ route('newstudy') }}">
                  <span data-feather="file-text"></span>
                  Añadir titulación
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link{{ Request::route()->getName() == 'newdepartment' ? ' active' : '' }}" href="{{ route('newdepartment') }}">
                  <span data-feather="file-text"></span>
                  Añadir departamento
                </a>
              </li>
            </ul>

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <span>Admin. de Centros</span>
              <a class="d-flex align-items-center text-muted" href="#">
                <span data-feather="plus-circle"></span>
              </a>
            </h6>
            <ul class="nav flex-column mb-2">
              <li class="nav-item">
                <a class="nav-link{{ Request::route()->getName() == 'centeradmins' || Request::route()->getName() == 'newcenteradmin' ? ' active' : '' }}" href="{{ route('centeradmins') }}">
                  <span data-feather="file-text"></span>
                  Gestión
                </a>
              </li>
            </ul>            
            @endif

            @if (Auth::user()->hasRolAdmCentro())

            <!-- Admin de Centro -->

              @if (Auth::user()->getCentersManaged()->count() > 0)

                @foreach (Auth::user()->getCentersManaged() as $i)
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                  <span>{{ $i->center->nombreCentro }}</span>
                  <a class="d-flex align-items-center text-muted" href="#">
                    <span data-feather="plus-circle"></span>
                  </a>
                </h6>
                <ul class="nav flex-column mb-2">
                  <li class="nav-item">
                    <a class="nav-link{{ Request::route()->getName() == 'editcenter' ? ' active' : '' }}" href="{{ route('editcenter', $i->center->idCentro) }}">
                      <span data-feather="file-text"></span>
                      Modificar datos
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link{{ Request::route()->getName() == 'getstudies' ? ' active' : '' }}" href="{{ route('getstudies', $i->center->idCentro) }}">
                      <span data-feather="file-text"></span>
                      Titulaciones
                    </a>
                  </li>
                </ul>
                @endforeach

              @else

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">No administra centros</h6>

              @endif

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <span>Coord. de Titulación</span>
              <a class="d-flex align-items-center text-muted" href="#">
                <span data-feather="plus-circle"></span>
              </a>
            </h6>
            <ul class="nav flex-column mb-2">
              <li class="nav-item">
                <a class="nav-link{{ Request::route()->getName() == 'studyadmins' ? ' active' : '' }}" href="{{ route('studyadmins') }}">
                  <span data-feather="file-text"></span>
                  Listado
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link{{ Request::route()->getName() == 'newstudyadmin' ? ' active' : '' }}" href="{{ route('newstudyadmin') }}">
                  <span data-feather="file-text"></span>
                  Añadir nuevo
                </a>
              </li>
            </ul>      

            @endif

            @if (Auth::user()->hasRolCoordinador())

            <!-- Coordinador de Titulación -->

              @if (Auth::user()->getStudiesManaged()->count() > 0)

                @foreach (Auth::user()->getStudiesManaged() as $i)
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                  <span>{{ $i->study->getFullName() }}</span>
                  <a class="d-flex align-items-center text-muted" href="#">
                    <span data-feather="plus-circle"></span>
                  </a>
                </h6>
                <ul class="nav flex-column mb-2">
                  <li class="nav-item">
                    <a class="nav-link{{ Request::route()->getName() == 'studystudents' || Request::route()->getName() == 'newstudent' ? ' active' : '' }}" href="{{ route('studystudents', $i->study->idTitulacion) }}">
                      <span data-feather="file-text"></span>
                      Gestión de alumnos
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link{{ Request::route()->getName() == 'studytutors' || Request::route()->getName() == 'newtutor' ? ' active' : '' }}" href="{{ route('studytutors', $i->study->idTitulacion) }}">
                      <span data-feather="file-text"></span>
                      Gestión de tutores
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link{{ Request::route()->getName() == 'studycourts' ? ' active' : '' }}" href="{{ route('studycourts', $i->study->idTitulacion) }}">
                      <span data-feather="file-text"></span>
                      Gestión de tribunales
                    </a>
                  </li>
                </ul>
                @endforeach

              @else

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">No coordina titulaciones</h6>

              @endif

            @endif

            @if (Auth::user()->hasRolTutor())

              <!-- Tutor -->

              @if (Auth::user()->getStudiesTaught()->count() > 0)

                @foreach (Auth::user()->getStudiesTaught() as $i)
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                  <span>{{ $i->study->getFullName() }}</span>
                  <a class="d-flex align-items-center text-muted" href="#">
                    <span data-feather="plus-circle"></span>
                  </a>
                </h6>
                <ul class="nav flex-column mb-2">
                  <li class="nav-item">
                    <a class="nav-link{{ ((Request::route()->getName() == 'projects' || Request::route()->getName() == 'newproject') && Request::route('id') == $i->study->idTitulacion ? ' active' : '') }}" href="{{ route('projects', ['id' => $i->study->idTitulacion]) }}">
                      <span data-feather="file-text"></span>
                      Gestión de trabajos
                    </a>
                  </li>
                </ul>
                @endforeach

              @else

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">No imparte titulaciones</h6>

              @endif

            @endif

          </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">


        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Inicio</a></li>
            @yield('breadcrumb')
          </ol>
        </nav>

          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">@yield('title', 'Administración')</h1>
          </div>

          @if(!empty($error))
          <div class="alert alert-danger" role="alert">
            <strong>Error:</strong> {{ $error }}
          </div>
          @endif

          @if(!empty($success))
          <div class="alert alert-success" role="alert">
            <strong>Resultado:</strong> {{ $success }}
          </div>
          @endif

          @yield('content')

        </main>
      </div>
    </div>

    @section('footerScripts')
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <!-- Icons -->
    <script src="{{ asset('js/feather.min.js') }}"></script>
    <script>
      feather.replace()
    </script>

    @show
  </body>

</html>
@endif