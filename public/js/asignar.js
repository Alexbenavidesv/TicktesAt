
function asignar(id_ticket) {
    var id=id_ticket;
    var prio="#prioridad"+id;
    var errprio="#errorPrioridad"+id;
    var cons="#consultor"+id;
    var errcons="#errorConsultor"+id;
    var tip="#tipo"+id;
    var errtip="#errorTipo"+id;
    var tick="#id_ticket"+id;

    var tokken = $('input[name="_token"]').val();
    var prioridad=$(prio).val();
    var consultor=$(cons).val();
    var tipo=$(tip).val();
    var id_ticket_=$(tick).val();

    $.ajax({
        url : "asignarTicket",
        data : {prioridad: prioridad, consultor: consultor,tipo:tipo,id_ticket: id_ticket_, _token: tokken},
        type : 'POST',
        success:function (respuesta) {
            swal({
                    title: "Asignación realizada con exito!",
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
            $(errprio).html('');
            $(errcons).html('');
            $(errtip).html('');
            $(prio).val('')
            $(cons).val('')
            $(tip).val('')
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
                if(errores.consultor){
                    $(errcons).html(errores.consultor);
                }
                else{
                    $(errcons).html('');
                }
                if(errores.prioridad){
                    $(errprio).html(errores.prioridad);
                }
                else{
                    $(errprio).html('');
                }
                if(errores.tipo){
                    $(errtip).html(errores.tipo);
                }
                else{
                    $(errtip).html('');
                }


            }
        }
    });
}
