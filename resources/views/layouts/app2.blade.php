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
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.9.0/sweetalert2.min.css">

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


                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}" >
                    <li class="fa fa-ticket" style="font-size: 1.5em;"></li>
                    <span style="font-weight: bold; font-size: 1.5em; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif;">Tickets</span> <span style="font-weight: bold; font-size: 1.5em; color: deepskyblue; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif;">AT</span>
                </a>
            </div>


        </div>
    </nav>
    @yield('content')
</div>

<!-- Scripts -->
<script src="/js/app.js"></script>
<script src="{{ asset('js/jquery2.0.3.min.js')}}"></script>
<script>window.jQuery || document.write('<script src="{{ asset("js/jquery2.0.3.min.js")}}"><\/script>')</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.9.0/sweetalert2.min.js"></script>
<script src="{{ asset('js/usuarios.js') }}"></script>
<script src="{{ asset('js/cambiarPassword.js') }}"></script>
</body>
</html>
