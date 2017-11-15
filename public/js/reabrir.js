/**
 * Created by Alex on 15/11/2017.
 */

function reabrir(id_ticket) {
    swal({
        title: '¿Desea volver abrir el ticket?',
        text: "El ticket #"+id_ticket+" volverá a estar en estado pendiente",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, abrir!',
        cancelButtonText: 'No, Cancelar!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
    }).then(function () {
        $.ajax({
           url: 'reabrir_ticket/'+id_ticket,
           type:'GET',
            success: function (respuesta) {
                swal(
                    'Operación exitosa!',
                    'El ticket #'+respuesta+" ha pasado a estado pendiente",
                    'success'
                );

                location.href = '/consultartickets';
            },
            error: function () {
                
            }
        });

    }, function (dismiss) {
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if (dismiss === 'cancel') {
            swal(
                'Cancelado',
                'Operación cancelada :)',
                'error'
            )
        }
    })
}