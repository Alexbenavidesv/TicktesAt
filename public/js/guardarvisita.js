$('#btnvisita').click(function(event) {
	var fechayhora =  $('#fechayhoravis').val();
	var lugarvis  = $('#lugarvis').val();
	var nombrepar = $('#nombrepar').val();

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

	if (nombrepar == '') {
		$('#errornombrepar').html('Debe llenar estos campos');
		event.preventDefault();
	}else {
		$('#errornombrepar').html('');
	}
});