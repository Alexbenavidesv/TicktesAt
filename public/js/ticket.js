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

/*
function filtrarTicket(id) {
	var numero=$('#filtroNumero').val();
	var prioridad_=$('#filtroPrioridad').val();
	var consultor_=$('#filtroConsultor').val();
	var estado=$('#filtroEstado').val();
	var empresa=$('#filtroEmpresa').val();
	var tipo_=$('#filtroTipo').val();
	var modulo_=$('#filtroModulo').val();
    var tokken = $('input[name="_token"]').val();


	if(id==0){
		var url='filtrar_tickets';
	}
    if(id==1){
        var url='filtrar_tickets2';
    }
	$.ajax({
		url: url,
		type: 'GET',
        headers: {'X-CSRF-TOKEN':tokken},
        data: {numero:numero,prioridad_:prioridad_,consultor_:consultor_,estado:estado,empresa:empresa,tipo_:tipo_,modulo:modulo_},
		success: function (respuesta) {
			if(respuesta!="OK") {
                $('#contenidoTickets').html(respuesta);
            }

        }
	});

}*/

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

    if(numero!='' || prioridad_!=null || consultor_!=null || estado!=null || empresa!=null || tipo_!=null || modulo_!=null || inicio!='' || fin_!=''){
        $('#formFiltros').submit();
	}else{
        event.preventDefault();
	}
});

