$('#guardar').click(function(e){
	e.preventDefault();
	var token = $('input[name="_token"]').val();
	var tokken = $('input[name="_token"]').val();
  	var datos = new FormData($('#formulario')[0]);
	//alert(descripcion);

	$.ajax({
		url: 'guardar_ticket',
		type: 'POST',
		headers: {'X-CSRF-TOKEN':tokken},
	    type : 'POST',
	    data: datos,
	    contentType: false,
	    processData: false,
		success: function(res){
			if (res=='ok') {
				var url = window.location.href;
				swal({
			        title: "Ticket añadido con exito",
			        // text: "You will not be able to recover this imaginary file!",
			        type: "success",
			        confirmButtonText: "Ok",
			        closeOnConfirm: false
			      },
			      function(isConfirm){
			        if (isConfirm) {
			          location.reload();
			        }
			      });
    			$(location).attr('href', url+'consultartickets');
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