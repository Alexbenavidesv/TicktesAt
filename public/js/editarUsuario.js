
function editarUsuario(id_user) {
    var tokken = $('input[name="_token"]').val();
    var nombre=$("#nombreEditar"+id_user).val();
    var cedula=$("#cedulaEditar"+id_user).val();
    var correo=$("#correoEditar"+id_user).val();
    var telefono=$("#telefonoEditar"+id_user).val();
    var empresa=$("#empresaEditar"+id_user).val();
    var rol=$("#rolEditar"+id_user).val();

    $.ajax({
        url : "editar_usuario",
        data : {nombre: nombre, email: cedula, correo: correo, telefono:telefono,empresa: empresa, rol: rol, id_user: id_user, _token: tokken},
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
            $('#nombreEditar'+id_user).val('');
            $('#cedulaEditar'+id_user).val('');
            $('#correoEditar'+id_user).val('');
            $('#usuariosEditar'+id_user).hide();
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
                    $('#errorNombreEditar'+id_user).html(errores.nombre);
                }
                else{
                    $('#errorNombreEditar'+id_user).html('');
                }
                if(errores.email){
                    $('#errorCedulaEditar'+id_user).html(errores.email);
                }
                else{
                    $('#errorCedulaEditar'+id_user).html('');
                }
                if(errores.correo){
                    $('#errorCorreoEditar'+id_user).html(errores.correo);
                }
                else{
                    $('#errorCorreoEditar'+id_user).html('');
                }
                if(errores.empresa){
                    $('#errorEmpresaEditar'+id_user).html(errores.empresa);
                }
                else{
                    $('#errorEmpresaEditar'+id_user).html('');
                }
                if(errores.rol){
                    $('#errorRolEditar'+id_user).html(errores.rol);
                }
                else{
                    $('#errorRolEditar'+id_user).html('');
                }
                if(errores.telefono){
                    $('#errorTelefonoEditar'+id_user).html(errores.telefono);
                }
                else{
                    $('#errorTelefonoEditar'+id_user).html('');
                }

            }
        }
    });
}
