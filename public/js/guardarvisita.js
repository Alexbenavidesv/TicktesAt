$('#btnvisita').click(function(event) {
	var fechayhora =  $('#fechayhoravis').val();
	var lugarvis  = $('#lugarvis').val();
	var nombrepar = $('#nombrepar').val();
	var displaymotivo = $('#motivovis').css("display");
	var displayrecoleccion = $('#recoleccionvis').css("display");
	var displaycliente = $('#clientefut').css("display");
	var displaytelefono = $('#clientefuttel').css("display");
	var motivovis = $('#motivovistext').val();
	var recoleccionvis = $('#recoleccionvistext').val();
	var prospectcliente = $('#futurocliente').val();
	var prospecttelcliente = $('#telfuturocliente').val();

	if (displaymotivo=='block') {
		if (motivovis=='') {
			$('#errormotivovis').html('Debe llenar el motivo de la visita');
			event.preventDefault()
		}else {
			$('#errormotivovis').html('');
		}
	}

	if (displayrecoleccion=='block') {
		if (recoleccionvis=='') {
			$('#errorrecoleccionvis').html('Debe llenar los datos recolectados en la visita');
			event.preventDefault()
		}else {
			$('#errorrecoleccionvis').html('');
		}
	}

	if (displaycliente=='block') {
		if (prospectcliente=='') {
			$('#errorclientenvis').html('Debe llenar el nombre del cliente visitado');
			event.preventDefault()
		}else {
			$('#errorclientenvis').html('');
		}
	}

	if (displaytelefono=='block') {
		if (prospecttelcliente=='') {
			$('#errortelclientenvis').html('Debe llenar el telefono del cliente visitado');
			event.preventDefault()
		}else {
			$('#errortelclientenvis').html('');
		}
	}

	if (fechayhora == '') {
		$('#errorfechavis').html('Debe indicar fecha y hora de la visita');
		event.preventDefault();
	}else {
		$('#errorfechavis').html('');
	}

	if (lugarvis == '') {
		$('#errorlugarvis').html('Debe indicar el lugar de la visita');
		event.preventDefault();
	}else {
		$('#errorlugarvis').html('');
	}

	



	/*if (nombrepar == '') {
		$('#errornombrepar').html('Debe llenar estos campos');
		event.preventDefault();
	}else {
		$('#errornombrepar').html('');
	}*/
});