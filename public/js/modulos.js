var i=1;

function agregarTema() {

    var fila="<tr> <td><input type='text' name='temas[]' id='tema"+i+"'class='form-control'> </td> <td> <input name='manuales[]' id='manual"+i+"' type='file'> </td> </tr>";

    $("#temas").append(fila);
    i++;
}

function eliminarTema() {
    var trs=$("#temas tr").length;
    if(trs>2)
    {
        $("#temas tr:last").remove();
        i--;
    }
}

function agregarModulo() {
    var nombreModulo=$('#nombreModulo').val();
    var total=$("#temas tr").length-1;
    var temas=[];
    var manual=[];
    var i=0,j=0;


    if(nombreModulo!='') {

        $('#errorModulo').html('');

        for (i = 0; i < total; i++) {
            if ($('#tema' + i).val() != '') {
                temas.push($('#tema' + i).val());

                if($('#manual'+i).val()!=''){
                    var ext = $('#manual'+i).val().substring($('#manual'+i).val().lastIndexOf("."));
                    if((ext=='.zip' || ext=='.ZIP')){
                        $('#errorManuales').html('');

                        var size=($('#manual'+i)[0].files[0].size)/1024/1024;
                        if(size>4){
                            $('#errorManuales').html('Maximo un archivo de 4 MB');
                            return false;
                        }else{
                            $('#errorManuales').html('');
                            manual.push($('#manual'+i).val());
                        }


                    }else{
                        $('#errorManuales').html('Solo se permiten adjuntar archivos .zip');

                        return false;
                    }

                }
                else{
                    manual.push('-');
                }

                j++;
            }
        }

        if (j == total) {
            $('#errorTemas').html('');
            var datos = new FormData($('#newModulo')[0]);
            var tokken = $('input[name="_token"]').val();

            $.ajax({
                url : "guardar_modulo",
                type: 'POST',
                headers: {'X-CSRF-TOKEN':tokken},
                data: datos,
                processData: false,
                contentType: false,
                success: function (res) {
                    if(res=='OK') {
                        swal({
                                title: "Se ha agregado el modulo al sistema con exito!",
                                // text: "You will not be able to recover this imaginary file!",
                                //timer: 3000,
                                type: "success",
                                confirmButtonText: "Ok",
                                closeOnConfirm: false
                            },
                            function (isConfirm) {
                                if (isConfirm) {
                                    location.reload();
                                    //window.location.href = "consultartickets";
                                }
                            });

                    }
                    window.location.href = "/modulos";
                }
            });



        }
        else {
            $('#errorTemas').html('Debes ingresar todos los temas');
        }
    }
    else{
        $('#errorModulo').html('<b>Debes ingresar un nombre para el modulo</b>');

    }



}