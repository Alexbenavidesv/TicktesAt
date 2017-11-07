$('#guardar').click(function(e){
	e.preventDefault();
	var descripcion = $('#desc').val();
	var evidencia1 = $('#ev1').val();
	var evidencia2 = $('#ev2').val();
	var evidencia3 = $('#ev3').val();
	var token = $('input[name="_token"]').val();
	//alert(descripcion);

	$.ajax({
		url: '',
		type: 'POST',
		data: {
			_token: token,
			descripcion: descripcion,
			evidencia1: evidencia1,
			evidencia2: evidencia2,
			evidencia3: evidencia3
		},
		success: function(res){
			if (res=='ok') {
				var url = window.location.href;
				alert('Ticket generado con exito');
    			$(location).attr('href', url);
			}else {
				$('#mensaje').html('Error al generar el Ticket');
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

			if(errores.evidencia1){
				$('#error2').html(errores.evidencia1);
			}else{
				$('#error2').html('');
			}
		}
	});
});



    <script src="{{ asset('js/ticket.js') }}"></script>