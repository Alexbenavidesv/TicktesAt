
$('#guardarEmpresa').click(function (e) {

    e.preventDefault();
    var tokken = $('input[name="_token"]').val();
    var nombre=$('input[name="nombre"]').val();
    var nit=$('input[name="nit"]').val();

    $.ajax({
        url : "empresas",
        data : {nombre: nombre, nit: nit, _token: tokken},
        type : 'POST',
        success:function (respuesta) {
            // console.log(respuesta);
            swal({
                    title: "Empresa agregada con exito!",
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
            $('#nit').val('');
            $('#empresas').hide();
            location.href = '/empresas';
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
                if(errores.nit){
                    $('#errorNit').html(errores.nit);
                }
                else{
                    $('#errorNit').html('');
                }


            }
        }
    });
});
