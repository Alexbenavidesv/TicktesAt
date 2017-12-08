$(document).ready(function(){
    /**
     * Funcion para añadir una nueva columna en la tabla
     */
    $("#add").click(function(){
        var nuevaFila="<tr>";
        nuevaFila+="<td><input type='text' name='nombrepar[]' id='nombrepar' class='form-control clase' placeholder='Nombre del participante'></td>"
        nuevaFila+="<td><input type='text' name='cargopar[]' id='cargopar' class='form-control clase1' placeholder='Cargo del participante'></td>"
        nuevaFila+="<td><input type='text' name='telefonopar[]' id='telefonopar' class='form-control clase2' placeholder='Telefono del participante'></td>"
        nuevaFila+="</tr>";
        $("#tabla").append(nuevaFila);
    });

    /**
     * Funcion para eliminar la ultima columna de la tabla.
     * Si unicamente queda una columna, esta no sera eliminada
     */
    $("#del").click(function(){
        // Obtenemos el total de columnas (tr) del id "tabla"
        var trs=$("#tabla tr").length;
        if(trs>2)
        {
            // Eliminamos la ultima columna
            $("#tabla tr:last").remove();
        }
    });
});


$(document).ready(function() {
    $('#tipovis').change(function(event) {
        var tipovis = $('#tipovis').val();
        if (tipovis == 'Presentación' || tipovis == 'Consultoría') {
             $('#motivovis').css("display", "block");
             $('#recoleccionvis').css("display", "block");
             $('#clientefut').css("display", "block");
             $('#satisdiv').css("display", "block");
             $('#clientefuttel').css("display", "block");
             $('#participantes').css("display", "none");
             $('#tabla').css("display", "none");
             $('#visempresa').css("display", "none");
             $('#divmodulovis').css("display", "none");
             $('#divhoras').css("display", "none");
             $('#divcualquiera').css("display", "block");
             $('#otrodiv').css("display", "none");
             $('#divhorasing').css("display", "none");
             $('#visfechahora').css("display", "block");
        }

        if (tipovis == 'Soporte') {
            $('#clientefut').css("display", "none");
            $('#nomclientenuevo').css("display", "none");
            $('#nitclientenuevo').css("display", "none");
            $('#clientefuttel').css("display", "none");
            $('#satisdiv').css("display", "none");
            $('#participantes').css("display", "none");
            $('#tabla').css("display", "none");
            $('#visempresa').css("display", "block");
            $('#motivovis').css("display", "block");
            $('#recoleccionvis').css("display", "block");
            $('#divmodulovis').css("display", "none");
            $('#divhoras').css("display", "none");
            $('#divcualquiera').css("display", "none");
            $('#otrodiv').css("display", "block");
            $('#divhorasing').css("display", "none");
            $('#visfechahora').css("display", "none");

        }

        if (tipovis == 'Capacitación') {
            $('#motivovis').css("display", "none");
            $('#recoleccionvis').css("display", "none");
            $('#clientefut').css("display", "none");
            $('#satisdiv').css("display", "none");
            $('#clientefuttel').css("display", "none");
            $('#participantes').css("display", "block");
            $('#tabla').css("display", "block");
            $('#visempresa').css("display", "block");
            $('#divmodulovis').css("display", "block");
            $('#divhoras').css("display", "block");
            $('#divcualquiera').css("display", "none");
            $('#otrodiv').css("display", "none");
            $('#visfechahora').css("display", "none");
        }
    });
});


$('#enviarevidenciavis').click(function(event) {
    var evidenciavis = $('#evidenciavis').val();
    var resvisible = $('#comentariov').val();
    var resnovisible = $('#comentarionv').val();
    var exte = evidenciavis.substring(evidenciavis.lastIndexOf("."));
    //event.preventDefault();
    //alert(exte);
    if (resvisible=='') {
        $('#errorespvisible').html('Debe ingresar un comentario');
        event.preventDefault();
    }else {
       $('#errorespvisible').html(''); 
    }


    if (exte != '') {
        if (exte!=".jpg" && exte!=".jpeg" && exte!=".png" && exte!=".PNG" && exte!=".JPEG" && exte!=".JPG" && exte!=".rar" && exte!=".zip") {
            $('#errevidenciavis').html('El archivo debe ser .jpg, .jpeg, .png, .rar, .zip');
            event.preventDefault();
        }else{
            $('#errevidenciavis').html('');
        }
    }else {
        $('#errevidenciavis').html('Debe añadir una evidencia');
        event.preventDefault();
    }
});



$(document).ready(function() {
    $('#noexiste').change(function() {
        if($(this).is(":checked")) {
            $(this).attr("value", "1");
            $('#nomclientenuevo').css("display", "block");
            $('#nitclientenuevo').css("display", "block");
            $('#visitado').css("display", "none");
        }else {
            $(this).attr("value", "0");
            $('#nomclientenuevo').css("display", "none");
            $('#nitclientenuevo').css("display", "none");
            $('#visitado').css("display", "block");
        }
    });
});


$('#empresavis').change(function(event) {
    var empresa = $('#empresavis').val();
    $('#modulovis').html('');
    $('#horasmodulo').html('');
    $('#divhorasing').css('display', 'none');

    $.ajax({
        url: '/llamrModulos/'+empresa,
        type: 'GET',
        success: function(res){
            $('#modulovis').append('<option value="">Seleccione el modulo</option>');
            for (var i = 0; i < res.length; i++) {
                
                $('#modulovis').append('<option value="'+res[i].id+'">'+res[i].nombre+'</option>');
            }
        }
    })
});



$('#modulovis').change(function(event) {
    var idmodulo = $('#modulovis').val();
    var idempresa = $('#empresavis').val();
    //alert(idmodulo);
    $('#horasmodulo').html('');
    $('#inghoras').html('');
    $('#divhorasing').css('display', 'none');

    $.ajax({
        url: '/llamarHorasModulo',
        type: 'GET',
        data: {idmodulo: idmodulo, idempresa: idempresa},
        success: function(res){
            $('#horasmodulo').html('<input type="text" class="form-control" value="'+res+'" id="disponible" readonly>');
            $('#divhorasing').css('display', 'block');
        }
    });
});

function Calcular(){
    var fecha1 = moment($('#horainicio').val());
    var fecha2 = moment($('#horafin').val());
    var disponibles = $('#disponible').val();

    var diferencia = fecha2.diff(fecha1, "hours");

    $('#oculto').val(diferencia);
}


function finalizar(id){
    var finalizado = $('#finalizadovis'+id).val();
    var ocultoid = $('#idoculto'+id).val();
    var tok = $('input[name="_token"]').val();
    //alert(tok);
    if (finalizado=='SI') {
        $.ajax({
        url: '/finalizarVisita',
        type: 'POST',
        headers: {'X-CSRF-TOKEN':tok},
        data: {finalizado: finalizado, ocultoid: ocultoid},
        success: function(res){
            if (res=='ok') {
                var url = window.location.href;
                swal({
                    title: "Se ha finalizado la visita",
                    type: "success",
                    confirmButtonText: "Ok",
                    closeOnConfirm: false
                  },
                  function(isConfirm){
                    if (isConfirm) {
                      location.reload();
                      //window.location.href = "consultartickets";
                    }
                  });
                  $(location).attr('href', url);
            }else {
                swal({
                  title: "Ha ocurrido un error",
                  type: "error",
                  confirmButtonText: "Ok",
                  closeOnConfirm: true
                });
            }
        },
      });
    }

    
}