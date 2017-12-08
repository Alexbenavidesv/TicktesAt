$('#btnvisita').click(function(event) {
	var fechayhora =  $('#fechayhoravis').val();
	var lugarvis  = $('#lugarvis').val();
	var nombrepar = $('#nombrepar').val();
	var displaymotivo = $('#motivovis').css("display");
	var displayrecoleccion = $('#recoleccionvis').css("display");
	var displaytelefono = $('#clientefuttel').css("display");
	var motivovis = $('#motivovistext').val();
	var recoleccionvis = $('#recoleccionvistext').val();
	var prospectcliente = $('#futurocliente').val();
	var prospecttelcliente = $('#telfuturocliente').val();
	var nomclientenuevo = $('#nomclientenuevo').val();
	var nitclientenuevo = $('#nitclientenuevo').val();
	var estadovisita = $('#estadovis').val();
	var noexiste = $('#noexiste').val();
	

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
			$('#motivovis').html('');
		}

		if (recoleccionvis=='') {
			$('#errorrecoleccionvis').html('Debe ingresar los datos recolectados en la visita');
			event.preventDefault();			
		}else {
			$('#errorrecoleccionvis').html('');
		}

		if (noexiste==1) {
			if (nomclientenuevo=='') {
				$('#errcliennow').html('Debe ingresar el nombre del nuevo cliente');
				event.preventDefault();
			}else {
				$('#errcliennow').html('');
			}

			if (nitclientenuevo=='') {
				$('#errcliennownit').html('Debe ingresar el nit del nuevo cliente');
				event.preventDefault();
			}else {
				$('#errcliennownit').html('');
			}
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
			$('#motivovis').html('');
		}

		if (recoleccionvis=='') {
			$('#errorrecoleccionvis').html('Debe ingresar los datos recolectados en la visita');
			event.preventDefault();			
		}else {
			$('#errorrecoleccionvis').html('');
		}

		if (noexiste==1) {
			if (nomclientenuevo=='') {
				$('#errcliennow').html('Debe ingresar el nombre del nuevo cliente');
				event.preventDefault();
			}else {
				$('#errcliennow').html('');
			}

			if (nitclientenuevo=='') {
				$('#errcliennownit').html('Debe ingresar el nit del nuevo cliente');
				event.preventDefault();
			}else {
				$('#errcliennownit').html('');
			}
		}

		if (prospecttelcliente=='') {
			$('#errortelclientenvis').html('Debe ingresar el telefono del cliente visitado');
			event.preventDefault();
		}else {
			$('#errortelclientenvis').html('');
		}
	}

	if (tipovisita=='Soporte') {
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
			$('#motivovis').html('');
		}

		if (recoleccionvis=='') {
			$('#errorrecoleccionvis').html('Debe ingresar los datos recolectados en la visita');
			event.preventDefault();			
		}else {
			$('#errorrecoleccionvis').html('');
		}

	}

	if (tipovisita=='Capacitación') {
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