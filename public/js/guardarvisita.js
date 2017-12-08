$('#btnvisita').click(function(event) {
	var fechayhora =  $('#fechayhoravis').val();
	var lugarvis  = $('#lugarvis').val();
	var nombrepar = $('#nombrepar').val();
	var recoleccionvis = $('#recoleccionvistext').val();
	var prospectcliente = $('#futurocliente').val();
	var prospecttelcliente = $('#telfuturocliente').val();
	var nomclientenuevo = $('#nomclientenuevo').val();
	var nitclientenuevo = $('#nitclientenuevo').val();
	var estadovisita = $('#estadovis').val();
	var empresavis = $('#empresavis').val();
	var fechainicio = $('#fechainicio').val();
	var horainicio = $('#horainicio').val();
	var horafin = $('#horafin').val();
	var oculto = $('#oculto').val();
	var disponibles = $('#disponible').val();
	var viscliente = $('#viscliente').val();
	var iniciosoporte = $('#iniciosoporte').val();
	var finsoporte = $('#finsoporte').val();

	oculto = parseInt(oculto);
	
	

	var tipovisita = $('#tipovis').val();


	if (tipovisita=='Presentación') {
		if (estadovisita=='Programada') {
			if (fechayhora=='') {
				$('#errorfechavis').html('Ingrese hora y fecha de programación de la visita');
				event.preventDefault();
			}else {
				$('#errorfechavis').html('');
			}
		}

		if (viscliente=='') {
			$('#errorclientenvis').html('Debe ingresar el nombre del prospecto visitado');
			event.preventDefault();
		}else {
			$('#errorclientenvis').html('');
		}

		if (lugarvis=='') {
			$('#errorlugarvis').html('Debe ingresar el lugar de la visita');
			event.preventDefault();
		}else {
			$('#errorlugarvis').html('');
		}
		//alert(motivovis);
		if (motivovis=='') {
			$('#errormotivovis').html('Debe ingresar el motivo de la visita');
			event.preventDefault();
		}else {
			$('#errormotivovis').html('');
		}

		if (recoleccionvis=='') {
			$('#errorrecoleccionvis').html('Debe ingresar los datos recolectados en la visita');
			event.preventDefault();			
		}else {
			$('#errorrecoleccionvis').html('');
		}



		if (prospecttelcliente=='') {
			$('#errortelclientenvis').html('Debe ingresar el telefono del cliente visitado');
			event.preventDefault();
		}else {
			$('#errortelclientenvis').html('');
		}
	}


	if (tipovisita=='Consultoría') {
		if (estadovisita=='Programada') {
			if (fechayhora=='') {
				$('#errorfechavis').html('Ingrese hora y fecha de programación de la visita');
				event.preventDefault();
			}else {
				$('#errorfechavis').html('');
			}
		}

		if (lugarvis=='') {
			$('#errorlugarvis').html('Debe ingresar el lugar de la visita');
			event.preventDefault();
		}else {
			$('#errorlugarvis').html('');
		}

		if (motivovis=='') {
			$('#errormotivovis').html('Debe ingresar el motivo de la visita');
			event.preventDefault();
		}else {
			$('#errormotivovis').html('');
		}

		if (recoleccionvis=='') {
			$('#errorrecoleccionvis').html('Debe ingresar los datos recolectados en la visita');
			event.preventDefault();			
		}else {
			$('#errorrecoleccionvis').html('');
		}

		if (viscliente=='') {
			$('#errorclientenvis').html('Debe ingresar el nombre del prospecto visitado');
			event.preventDefault();
		}else {
			$('#errorclientenvis').html('');
		}

		if (prospecttelcliente=='') {
			$('#errortelclientenvis').html('Debe ingresar el telefono del cliente visitado');
			event.preventDefault();
		}else {
			$('#errortelclientenvis').html('');
		}
	}



	if (tipovisita=='Soporte') {
		if (empresavis=='') {
			$('#errorempresavis').html('Debe seleccionar una empresa');
			event.preventDefault();
		}else {
			$('#errorempresavis').html('');
		}

		if (iniciosoporte=='') {
			$('#errorsoporte1').html('Debe seleccionar la hora y fecha de inicio del soporte');
			event.preventDefault();
		}else {
			$('#errorsoporte1').html('');
		}

		if (finsoporte=='') {
			$('#errorsoporte').html('Debe seleccionar la hora y fecha de finalización del soporte');
			event.preventDefault();
		}else {
			$('#errorsoporte').html('');
		}

		if (lugarvis=='') {
			$('#errorlugarvis').html('Debe ingresar el lugar de la visita');
			event.preventDefault();
		}else {
			$('#errorlugarvis').html('');
		}


		if (motivovis=='') {
			$('#errormotivovis').html('Debe ingresar el motivo de la visita');
			event.preventDefault();
		}else {
			$('#errormotivovis').html('');
		}

		if (recoleccionvis=='') {
			$('#errorrecoleccionvis').html('Debe ingresar los datos recolectados en la visita');
			event.preventDefault();			
		}else {
			$('#errorrecoleccionvis').html('');
		}

	}





	if (tipovisita=='Capacitación') {
		//console.log(disponibles);
		console.log(oculto);

		if (disponibles<oculto) {
			$('#errorhoras2').html('las horas ingresadas deben ser menor o igual a las disponibles');
			event.preventDefault();
		}else {
			$('#errorhoras2').html('');
		}

		if (horainicio=='') {
			$('#errorhoras').html('Debe ingresar las fechas de inicio y fin');
			event.preventDefault();
		}else {
			$('#errorhoras').html('');
		}

		if (horafin=='') {
			$('#errorhoras').html('Debe ingresar las fechas de inicio y fin');
			event.preventDefault();
		}else {
			$('#errorhoras').html('');
		}

		if (empresavis=='') {
			$('#errorempresavis').html('Debe seleccionar una empresa');
			event.preventDefault();
		}else {
			$('#errorempresavis').html('');
		}

		if (lugarvis=='') {
			$('#errorlugarvis').html('Debe ingresar el lugar de la visita');
			event.preventDefault();
		}else {
			$('#errorlugarvis').html('');
		}

		var validador;

		$('.clase').each(function(index, el) {
			validador = $(this).val();		
		});

		if (validador=='') {
			$('#errortabla').html('Debe llenar todos estos campos');
			event.preventDefault();
		}else {
			$('#errortabla').html('');
		}

		var validador2;
		$('.clase1').each(function(index, el) {
			validador2 = $(this).val();		
		});

		if (validador2=='') {
			$('#errortabla').html('Debe llenar todos estos campos');
			event.preventDefault();
		}else {
			$('#errortabla').html('');
		}

		var validador3;
		$('.clase2').each(function(index, el) {
			validador3 = $(this).val();		
		});

		if (validador3=='') {
			$('#errortabla').html('Debe llenar todos estos campos');
			event.preventDefault();
		}else {
			$('#errortabla').html('');
		}
	}

	/*if (nombrepar == '') {
		$('#errornombrepar').html('Debe llenar estos campos');
		event.preventDefault();
	}else {
		$('#errornombrepar').html('');
	}*/
});