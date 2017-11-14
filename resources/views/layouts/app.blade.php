<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/estilo.css" rel="stylesheet">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

    <link href="{{ asset('css/style3.css') }}" rel="stylesheet">
     <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.9.0/sweetalert2.min.css">

    <style>
        .navbar-login
        {
            width: 305px;
            padding: 10px;
            padding-bottom: 0px;
        }

        .navbar-login-session
        {
            padding: 10px;
            padding-bottom: 0px;
            padding-top: 0px;
        }

        .icon-size
        {
            font-size: 87px;
        }
    </style>
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}" >
                        <li class="fa fa-ticket" style="font-size: 1.5em;"></li>
                     <span style="font-weight: bold; font-size: 1.5em;">Tickets</span> <span style="font-weight: bold; font-size: 1.5em; color: deepskyblue;">AT</span>
                    </a>
                </div>



                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if(Auth::check())

                            <?php
                            $user=explode(' ',Auth::user()->name);
                            $user=$user[0];
                            ?>

                            <li class="dropdown">

                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <span class="fa fa-user"></span> 
                                  <strong>  <?php echo $user;?></strong>
                                    <span class="fa fa-chevron-down"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <div class="navbar-login">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <p class="text-center">
                                                        <span class="fa fa-user icon-size"></span>
                                                    </p>
                                                </div>
                                                <div class="col-lg-8">
                                                    <p class="text-left"><strong>{{ Auth::user()->name}}</strong></p>
                                                    <p class="text-left">
                                                        <a href="{{ url('/logout') }} "
                                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="btn btn-danger btn-block">
                                                            Cerrar Sesión
                                                        </a>
                                                    </p>
                                                 <!--   <p class="text-left">
                                                        <a href="#" class="btn btn-primary btn-block btn-sm">Actualizar Datos</a>
                                                    </p>-->
                                                </div>
                                            </div>
                                        </div>
                                           <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>    
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
              <ul class="nav nav-sidebar">
                  @if(Auth::user()->id_rol ==1)
                <li id="btnusuarios"><a href="/usuarios" ><i class="fa fa-address-card" aria-hidden="true"></i> Usuarios</a></li>
                <li id="btnempresas"><a href="/empresas"><i class="fa fa-industry" aria-hidden="true"></i> Empresas</a></li>
                  @endif
                @if(Auth::user()->id_rol ==2)
                <li id="btntickets"><a href="/"><i class="fa fa-ticket" aria-hidden="true"></i> Crear Tickets <span class="sr-only">(current)</span></a></li>
                @endif
                <li id="btnconsultartickets"><a href="/consultartickets"><i class="fa fa-search" aria-hidden="true"></i> Consultar Tickets</a></li>
                @if(Auth::user()->id_rol ==3)
                <li id="btnconsultartickets"><a href="/consultarticketsna"><i class="fa fa-minus-square-o" aria-hidden="true"></i> Tickets no asignados</a></li>
                @endif
              </ul>
            </div>

            @yield('content')

            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="/js/app.js"></script>
    <script src="{{ asset('js/jquery2.0.3.min.js')}}"></script>
    <script>window.jQuery || document.write('<script src="{{ asset("js/jquery2.0.3.min.js")}}"><\/script>')</script>
   <!-- <script src="{{ asset('js/bootstrap.min.js') }}"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.9.0/sweetalert2.min.js"></script>
    <script src="{{ asset('js/usuarios.js') }}"></script>
    <script src="{{ asset('js/ticket.js') }}"></script>
    <script src="{{ asset('js/empresa.js') }}"></script>
    <script src="{{ asset('js/asignar.js') }}"></script>
    <script src="{{ asset('js/inicio.js') }}"></script>
    <script src="{{ asset('js/guardartickets.js') }}"></script>
    <script src="{{ asset('js/editarempresa1.js') }}"></script>
    <script src="{{ asset('js/editarUsuario.js') }}"></script>
</body>
</html>
