
function editarUsuario(id_user) {

    var tokken = $('input[name="_token"]').val();
    var nombre=$('input[name="nombreEditar"]').val();
    var cedula=$('input[name="emailEditar"]').val();
    var correo=$('input[name="correoEditar"]').val();
    var empresa=$('select[name="empresaEditar"]').val();
    var rol=$('select[name="rolEditar"]').val();

    $.ajax({
        url : "editar_usuario",
        data : {nombre: nombre, email: cedula, correo: correo, empresa: empresa, rol: rol, id_user: id_user, _token: tokken},
        type : 'POST',
        success:function (respuesta) {
             console.log(respuesta);
            swal({
                    title: "Usuario actualizado con exito!",
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
            $('#nombreEditar').val('');
            $('#cedulaEditar').val('');
            $('#correoEditar').val('');
            $('#usuariosEditar').hide();
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
                    $('#errorNombreEditar').html(errores.nombre);
                }
                else{
                    $('#errorNombreEditar').html('');
                }
                if(errores.email){
                    $('#errorCedulaEditar').html(errores.email);
                }
                else{
                    $('#errorCedulaEditar').html('');
                }
                if(errores.correo){
                    $('#errorCorreoEditar').html(errores.correo);
                }
                else{
                    $('#errorCorreoEditar').html('');
                }
                if(errores.empresa){
                    $('#errorEmpresaEditar').html(errores.empresa);
                }
                else{
                    $('#errorEmpresaEditar').html('');
                }
                if(errores.rol){
                    $('#errorRolEditar').html(errores.rol);
                }
                else{
                    $('#errorRolEditar').html('');
                }

            }
        }
    });
}
