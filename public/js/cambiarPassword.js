/**
 * Created by Alex on 08/11/2017.
 */

    $("#cambiarPass").click(function(){
        var pass1 = $('#pass1').val();
        var pass2 = $('#pass2').val();
        var token = $('input[name="_token"]').val();
        $.ajax({
            url: 'cambiar_password',
            type: 'POST',
            data: {
                pass1: pass1,
                pass2: pass2,
                _token: token
            },
            success: function(res){
                if (res=='OK') {
                    swal({
                            title: "Contraseña cambiada con exito!",
                            text: "Para el proximo inicio de sesión debe hacerlo con la nueva contraseña",
                            type: "success",
                            confirmButtonText: "Ok",
                            closeOnConfirm: false
                        },
                        function(isConfirm){
                            if (isConfirm) {
                                location.href="/";
                            }
                        });
                    location.href ="/";
                }
                else{
                    $('#mensaje').html('Error al cambiar la contraseña');
                    $('#error1').html('');
                    $('#error2').html('');
                }
            },
            error: function(res){
                var errores = JSON.parse(res.responseText);

                if(errores.pass1){
                    $('#error1').html(errores.pass1);
                }else{
                    $('#error1').html('');
                }

                if(errores.pass2){
                    $('#error2').html(errores.pass2);
                }else {
                    $('#error2').html('');
                }
            }
        });

    });

    $('#cancelarPass').click(function(){
        $.ajax({
            url: 'cambiar_pass',
            type: 'GET',
            success: function(res){
                if (res=="OK") {
                    $(location).attr('href', '/');
                }
                else {
                    $('#mensaje').html('Ha ocurrido un error');
                    $('#error1').html('');
                    $('#error2').html('');
                }
            }
        });
    });
