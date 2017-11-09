
$('#guardarUser').click(function (e) {
    e.preventDefault();
    var tokken = $('input[name="_token"]').val();
    var nombre=$('input[name="nombre"]').val();
    var cedula=$('input[name="email"]').val();
    var correo=$('input[name="correo"]').val();
    var empresa=$('select[name="empresa"]').val();
    var rol=$('select[name="rol"]').val();

    $.ajax({
        url : "usuarios",
        data : {nombre: nombre, email: cedula, correo: correo, empresa: empresa, rol: rol, _token: tokken},
        type : 'POST',
        success:function (respuesta) {
            // console.log(respuesta);
            swal({
                    title: "Usuario creado con exito!",
                    //text: "",
                    type: "success",
                    confirmButtonText: "Ok",
                    closeOnConfirm: false
                },
                function(isConfirm){
                    if (isConfirm) {
                        location.reload();
                    }
                });
            $('#nombre').val('');
            $('#cedula').val('');
            $('#correo').val('');
            $('#usuarios').hide();
            location.href = '/usuarios';
        },
        error:function (error) {
            var errores = JSON.parse(error.responseText);
         // console.log(errores);
            if (errores.lenght == 0) {
                swal({
                    title: "Se ha producido un error",
                    // text: "You will not be able to recover this imaginary file!",
                    type: "error",
                    confirmButtonText: "Ok",
                    closeOnConfirm: true
                });
            }
            else{
                if(errores.nombre){
                    $('#errorNombre').html(errores.nombre);
                }
                else{
                    $('#errorNombre').html('');
                }
                if(errores.email){
                    $('#errorCedula').html(errores.email);
                }
                else{
                    $('#errorCedula').html('');
                }
                if(errores.correo){
                    $('#errorCorreo').html(errores.correo);
                }
                else{
                    $('#errorCorreo').html('');
                }
                if(errores.empresa){
                    $('#errorEmpresa').html(errores.empresa);
                }
                else{
                    $('#errorEmpresa').html('');
                }
                if(errores.rol){
                    $('#errorRol').html(errores.rol);
                }
                else{
                    $('#errorRol').html('');
                }

            }
        }
    });
});
