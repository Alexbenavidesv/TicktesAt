$('#guardar').click(function(e){
	e.preventDefault();
	var tokken = $('input[name="_token"]').val();
  	var datos = new FormData($('#formulario')[0]);
	//alert(descripcion);

	$.ajax({
		url: 'guardar_ticket',
		type: 'POST',
		headers: {'X-CSRF-TOKEN':tokken},
	    data: datos,
	    contentType: false,
        processData: false,
		success: function(res){
			if (res!=null) {
				var url = window.location.href;
				swal({
			        title: "Ticket añadido con exito, el numero de su Ticket es:"+' '+res,
			        // text: "You will not be able to recover this imaginary file!",
			        //timer: 3000,
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
    			  //$(location).attr('href', url+'consultartickets');
    			  $('#desc').val('');
    			  $('#ev1').val('');
    			  $('#ev2').val('');
    			  $('#ev3').val('');
			}else {
				swal({
		          title: "Ha ocurrido un error",
		          // text: "You will not be able to recover this imaginary file!",
		          type: "error",
		          confirmButtonText: "Ok",
		          closeOnConfirm: true
		        });
				$('#error1').html('');
				$('#error2').html('');
				$('#error3').html('');
				$('#error4').html('');
			}
		},
		error: function(res){
			var errores = JSON.parse(res.responseText);


            if(errores.descripcion){
                $('#error1').html(errores.descripcion);
            }else{
                $('#error1').html('');
            }

            if(errores.moduloTicket){
                $('#errorModuloTicket').html(errores.moduloTicket);
            }else{
                $('#errorModuloTicket').html('');
            }

			if(errores.evidencia1){
				$('#error2').html(errores.evidencia1);
			}else{
				$('#error2').html('');
			}

			if(errores.evidencia2){
				$('#error3').html(errores.evidencia2);
			}else{
				$('#error3').html('');
			}

			if(errores.evidencia3){
				$('#error4').html(errores.evidencia3);
			}else{
				$('#error4').html('');
			}
		}
	});
});



function vistaPrevia(id){
	var panel = '#contenidoticket'+id;
	var button1 = '#infoticket2'+id;
	var button2 = '#infoticket'+id;
	$(panel).css('display', '');
	$(button1).css('display', '');
	$(button2).css('display', 'none');
}

function vistaPrevia2(id){
	var panel2 = '#contenidoticket'+id;
	var botona = '#infoticket'+id;
	var botonb = '#infoticket2'+id;
	$(panel2).css('display', 'none');
	$(botonb).css('display', 'none');
	$(botona).css('display', '');
}

function verTodo() {
	$('#verTodo').css('display','none');
    $('#cVerTodo').css('display','');
$('.contenidoT').css('display','');
$('.verTicket').css('display','none');

}

function cerrarVerTodo() {
    $('#cVerTodo').css('display','none');
    $('#verTodo').css('display','');
    $('.contenidoT').css('display','none');
    $('.verTicket').css('display','');
}



$('#filtrar').click(function (event) {
    var numero=$('#filtroNumero').val();
    var prioridad_=$('#filtroPrioridad').val();
    var consultor_=$('#filtroConsultor').val();
    var estado=$('#filtroEstado').val();
    var empresa=$('#filtroEmpresa').val();
    var tipo_=$('#filtroTipo').val();
    var modulo_=$('#filtroModulo').val();
    var inicio=$('#filtroFechaInicio').val();
    var fin_=$('#filtroFechaFin').val();

//alert("numero="+numero+"Prioridad="+prioridad_+"COnsultor="+consultor_+"Estado="+estado+"empresa="+empresa+"Tipo="+tipo_+"Modulo="+modulo_+"Inicio="+inicio+"Fin="+fin_);

    if(numero!=0 || prioridad_!=null || consultor_!=null || estado!=null || empresa!=null || tipo_!=null || modulo_!=null || (inicio!='' && fin_!='')){
        $('#formFiltros').submit();
	}else{
        event.preventDefault();
	}
});



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
                    title: "Asignación realizada con exito! ",
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
            $(prio).val('');
            $(cons).val('');
            $(tip).val('');
            $('#asignar'+id_ticket).hide();
            location.href = '/consultartickets';
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





var ticktesMultiples=[];

$('#multipleAsignacion').click(function () {
    ticktesMultiples=[];
	$('.tdMultiple').css('display','');
	$('#multipleAsignacion').css('display','none');
	$('#cancelarMultiple').css('display','');
	$('.checkMultiple').css('display','');
    $('#crearAsignacionMultiple').css('display','');
});

$('#cancelarMultiple').click(function () {
	ticktesMultiples=[];
    $('.tdMultiple').css('display','none');
    $('#cancelarMultiple').css('display','none');
    $('#multipleAsignacion').css('display','');
    $('.checkMultiple').css('display','none');
    $('#crearAsignacionMultiple').css('display','none');
});



$('.checkMultiple').change(function() {

    var dato=$(this).val();

    if($(this).is(":checked")) {

        if(ticktesMultiples.length>0){

            if(!(ticktesMultiples.indexOf(dato)>=0)){
                ticktesMultiples.push(dato);
			}
        }
        else{
            ticktesMultiples.push(dato);
		}

    }
    else{
		var pos=ticktesMultiples.indexOf(dato);
        ticktesMultiples.splice(pos,1);
	}
});

$('#crearAsignacionMultiple1').click(function () {
	if(ticktesMultiples.length>0){

        var prioridad="#prioridadMultiple";
        var errorprioridad="#errorPrioridadMultiple";
        var consultor="#consultorMultiple";
        var errorconsultor="#errorConsultorMultiple";
        var tipo="#tipoMultiple";
        var errortipo="#errorTipoMultiple";


        var tokken = $('input[name="_token"]').val();
        var prioridad=$(prioridad).val();
        var consultor=$(consultor).val();
        var tipo=$(tipo).val();
        var tickets=[];

        for(var i=0;i<ticktesMultiples.length;i++){
        	tickets.push(ticktesMultiples[i]);
		}


        $.ajax({
            url : "asignarTicketMultiple",
            data : {prioridad: prioridad, consultor: consultor,tipo:tipo,tickets: tickets, _token: tokken},
            type : 'POST',
            success:function (respuesta) {

                swal({
                        title: "Asignación realizada con exito! ",
                        type: "success",
                        confirmButtonText: "Ok",
                        closeOnConfirm: false
                    },
                    function(isConfirm){
                        if (isConfirm) {
                            location.reload();
                        }
                    });
                $(errorprioridad).html('');
                $(errorconsultor).html('');
                $(errortipo).html('');
                $(prioridad).val('');
                $(consultor).val('');
                $(tipo).val('');
                $('#crearAsignacionMultiple').hide();
                location.href = '/consultartickets';
            },
            error:function (error) {
                var errores = JSON.parse(error.responseText);
                // console.log(errores);
                if (errores.lenght == 0) {
                    swal({
                        title: "Se ha producido un error",
                        type: "error",
                        confirmButtonText: "Ok",
                        closeOnConfirm: true
                    });
                }
                else{
                    if(errores.consultor){
                        $(errorconsultor).html(errores.consultor);
                    }
                    else{
                        $(errorconsultor).html('');
                    }
                    if(errores.prioridad){
                        $(errorprioridad).html(errores.prioridad);
                    }
                    else{
                        $(errorprioridad).html('');
                    }
                    if(errores.tipo){
                        $(errortipo).html(errores.tipo);
                    }
                    else{
                        $(errortipo).html('');
                    }


                }
            }
        });

	}else{
        swal({
            title: "No se han seleccionado tickets",
            type: "error",
            confirmButtonText: "Ok",
            closeOnConfirm: true
        });
	}

});






