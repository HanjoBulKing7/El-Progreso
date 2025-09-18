<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('img/galletas.ico') }}">
    <title>{{ config('app.name', 'Galletas') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>

    <!-- Alertas -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    
    <!-- Calendario -->
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/messages/messages.es-es.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

    <!-- Estilos Propios -->
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
    <link rel="stylesheet" href="{{ asset('sidebar/css/style.css') }}">

    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
</head>
<body>
    <div>
        @guest
            <!-- Contenido para usuarios NO autenticados -->
            <main>
                @yield('content')
            </main>
        @else
            <!-- Contenido para usuarios autenticados -->
            <div class="wrapper d-flex align-items-stretch">
                <nav id="sidebar" class="active">
                    <div class="p-4 pt-5">
                        @if(Auth::user()->urlfoto && Auth::check())
                        <a href="{{ route('home') }}" class="img logo rounded-circle mb-5" style="background-image: url('/img/usuarios/{{ Auth::user()->id }}/{{ Auth::user()->urlfoto }}');"></a>
                        @else
                        <a href="{{ route('home') }}" class="img logo rounded-circle mb-5" style="background-image: url('/img/user_login.png');"></a>
                        @endif
                        <ul class="list-unstyled components mb-5">
                            <li class="active">
                                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">{{ Auth::user()->name." ".Auth::user()->apepat." " }}</a>
                                <ul class="collapse list-unstyled" id="homeSubmenu">
                                    @if(Auth::user()->fktiporol == 1)
                                    <li>
                                        <a href="{{ route('register') }}">{{ __('Registrar usuario') }}</a>
                                    </li>
                                    @endif
                                    <li>
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            {{ __('Cerrar Sesión') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="{{ route('home') }}">Menú</a>
                            </li>
                            <li>
                                <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Paginas</a>
                                <ul class="collapse list-unstyled" id="pageSubmenu">
                                    @if(Auth::user()->fktiporol == 1)
                                    <li>
                                        <a href="{{ url('usuarios') }}">Usuarios</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('productos') }}">Productos</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('proveedores') }}">Proveedores</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('vehiculos') }}">Vehiculo</a>
                                    </li>
                                    @endif
                                    <li>
                                        <a href="{{ url('tiendas') }}">Tienda</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('rutas') }}">Ruta</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('gastos') }}">Gastos</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('ventas') }}">Ventas</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="{{ url('rutas') }}">Rutas</a>
                            </li>
                            <li>
                                <a href="{{ url('ventas') }}">Ventas</a>
                            </li>
                        </ul>

                        <div class="footer">
                            <!-- Footer content -->
                        </div>
                    </div>
                </nav>

                <div id="content">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <div class="container-fluid">
                            <button type="button" id="sidebarCollapse" class="btn btn-primary">
                                <i class="fas fa-bars"></i>
                                <span class="sr-only">Toggle Menu</span>
                            </button>
                            <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <i class="fas fa-bars"></i>
                            </button>
                        </div>
                    </nav>

                    <main>
                        @yield('content')
                    </main>
                </div>
            </div>
        @endguest

        @yield('scripts')
    </div>

    <!-- Scripts del sidebar (solo para usuarios autenticados) -->
    @auth
    <script src="{{ asset('sidebar/js/main.js') }}"></script>
    @endauth

    <!-- DataTable -->
    <link href="{{ asset('datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet">
    <script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <link href="{{ asset('datatable/css/buttons.dataTables.min.css') }}" rel="stylesheet">
    <script src="{{ asset('datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('datatable/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('datatable/js/jszip.min.js') }}"></script>
    <script src="{{ asset('datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('datatable/js/datetime.js') }}"></script>

</body>
</html>