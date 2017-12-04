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
   <link rel="stylesheet" href="/css/login.css" type="text/css" media="all" />
</head>
<body>
<div class="container">



        <h1 style="margin-top: -0.4%;">Cambiar contraseña</h1>


    <div class="contact-form">
        <div class="profile-pic" style="margin-top: -8%;">
            <img src="/img/llave.png" alt="User Icon" width="155px" height="155px"/>
        </div>

        <form>
        <div class="signin">


                {{ csrf_field() }}



                    <div class="col-md-12">
                        <div id="error1" style="color: red; font-weight: bold;"></div>
                        <input id="pass1" type="password" class="login-field" name="pass1"  autofocus placeholder="Nueva contraseña" style="margin-bottom: 20px" >

                        <label class="login-field-icon fui-user" for="login-name"></label>

                    </div>


                    <div class="col-md-12" style="margin-top: 4%">
                        <div id="error2" style="color: red; font-weight: bold;"></div>
                        <input id="pass2" type="password" class="login-field" name="pass2"   placeholder="Confirmar contraseña" style="margin-bottom: 20px" >

                        <label class="login-field-icon fui-lock" for="login-pass"></label>

                    </div>

                <br><br>
            <div class="row">

                <div class="col-md-6">
                    <button class="btn btn-success btn-large btn-block" type="button"  id="cambiarPass" style="background-color: limegreen; width: 90%;" >Cambiar</button>
                </div>

                <div class="col-md-6">
                    <button class="btn btn-danger btn-large btn-block" type="button"  id="cancelarPass" style="background-color: red; width: 90%;">Cancelar</button>
                </div>



            </div>

        </div>
        </form>
        </div>

    </div>
</div>

</body>
</html>

    @endsection