$('#guardarLimite').click(function () {

    var tokken = $('input[name="_token"]').val();
    var porconfirmar=$('input[name="porconfirmarLimite"]').val();
    var pendiente=$('input[name="pendientesLimite"]').val();
    var empresa=$('select[name="empresaLimite"]').val();
//alert(empresa);
    if(empresa!=null){
        $('#errorEm').html('');
        if((porconfirmar<0 || pendiente<0) || (porconfirmar=='' && pendiente=='') ){
            $('#errorT').html('Ingrese valores validos');
        }else{
            $('#errorT').html('');

            if(porconfirmar==0 && pendiente==0){
                $('#errorT').html('Ingrese por lo menos uno de los dos valores');
            }else{
                $('#errorT').html('');

                $.ajax({
                    url: '/guardarLimite',
                    type: 'POST',
                    data: {empresa:empresa,pendiente:pendiente,porconfirmar:porconfirmar, _token: tokken},
                    success: function (res) {
                        if(res=='OK'){
                            swal({
                                    title: "Parametro asignado con exito!",
                                    type: "success",
                                    confirmButtonText: "Ok",
                                    closeOnConfirm: false
                                },
                                function(isConfirm){
                                    if (isConfirm) {
                                        location.reload();
                                    }
                                });
                            location.reload();
                        }
                    }
                });

            }
        }
    }
    else {
        $('#errorEm').html('Debe seleccionar una empresa');
    }



});

function editarLimite(id) {

    var tokken = $('input[name="_token"]').val();
    var porconfirmar=$('#editarPorconfirmarLimite'+id).val();
    var pendiente=$('#editarPendientesLimite'+id).val();
    var id=$('#idLimite'+id).val();

var url='limiteEditar';

    if((porconfirmar<0 || pendiente<0) || (porconfirmar=='' && pendiente=='') ){
        $('#errorT'+id).html('Ingrese valores validos');
    }else{
        $('#errorT'+id).html('');

        if(porconfirmar==0 && pendiente==0){
            $('#errorT'+id).html('Ingrese por lo menos uno de los dos valores');
        }else{
            $('#errorT'+id).html('');

            $.ajax({
                url: url,
                type: 'POST',
                data: {id:id,pendiente:pendiente,porconfirmar:porconfirmar, _token: tokken},
                success: function (res) {
                    if(res=='OK'){
                        swal({
                                title: "Parametros editados con exito!",
                                type: "success",
                                confirmButtonText: "Ok",
                                closeOnConfirm: false
                            },
                            function(isConfirm){
                                if (isConfirm) {
                                    location.reload();
                                }
                            });
                        location.reload();
                    }
                }
            });

        }
    }

}
