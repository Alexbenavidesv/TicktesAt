@extends('layouts.app2')

@section('content')


        <!DOCTYPE html>
<html>
<head>

    <!-- For-Mobile-Apps -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="User Icon Login Form Widget Responsive, Login Form Web Template, Flat Pricing Tables, Flat Drop-Downs, Sign-Up Web Templates, Flat Web Templates, Login Sign-up Responsive Web Template, Smartphone Compatible Web Template, Free Web Designs for Nokia, Samsung, LG, Sony Ericsson, Motorola Web Design" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!-- //For-Mobile-Apps -->
    <!-- Style --> <link rel="stylesheet" href="/css/login.css" type="text/css" media="all" />
</head>
<body>
<div class="container">

    <div class="contact-form">




        <div class="profile-pic" style="margin-top: -8%;">
            <img src="/img/1.png" alt="User Icon" width="155px" height="155px"/>
        </div>


        <div class="signin">

            <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                    <div class="col-md-12">
                        <input id="email" type="text" class="login-field" name="email" value="{{ old('email') }}" required autofocus placeholder="Usuario" >

                        <label class="login-field-icon fui-user" for="login-name"></label>

                        @if ($errors->has('email'))
                            <span class="help-block" style="color: black;">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>


                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                    <div class="col-md-12" style="margin-top: 4%">
                        <input type="password" name="password" class="login-field" value="" placeholder="Contraseña" id="password" required>
                        <label class="login-field-icon fui-lock" for="login-pass"></label>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <br><br>
                <input type="submit" value="Ingresar" />
            </form>
        </div>

    </div>
</div>

</body>
</html>


@endsection
