@extends('layouts.app2')

@section('content')


    <div class="container">
        <body>
        <div class="login">
            <div class="login-screen">
                <div class="app-title">
                    <h1>Cambiar contraseña</h1>
                </div>

<div class="login-form">
    <form>
        {{ csrf_field() }}

        <div class="form-group" style="margin-bottom: 5%;">

            <div class="col-md-12">
                <div id="error1" style="color: red"></div>
                <input id="pass1" type="text" class="login-field" name="pass1"  autofocus placeholder="Nueva contraseña" style="margin-bottom: 20px" >

                <label class="login-field-icon fui-user" for="login-name"></label>

            </div>
        </div>


        <div class="form-group">

            <div class="col-md-12">
                <div id="error2" style="color: red"></div>
                <input id="pass2" type="text" class="login-field" name="pass2"   placeholder="Confirmar contraseña" style="margin-bottom: 20px" >

                <label class="login-field-icon fui-user" for="login-name"></label>

            </div>
        </div>



    </form>
    <button class="btn btn-success btn-large btn-block id" id="cambiarPass" style="background-color: limegreen" >Cambiar</button>
    <button class="btn btn-danger btn-large btn-block"  id="cancelarPass" style="background-color: red">Cancelar</button>
</div>
            </div>
        </div>
        </body>
    </div>
    @endsection