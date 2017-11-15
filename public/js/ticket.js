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




