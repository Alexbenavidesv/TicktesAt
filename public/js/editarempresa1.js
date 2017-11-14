function editarEmpresa(idempre){
	//alert('message?: DOMString');
	var nombrempree = $('#nempre'+idempre).val();
	var nittempree = $('#nitempre'+idempre).val();
	var idempreupdt = idempre;
	var tokkenn = $('input[name="_token"]').val();
	//alert(idempreupdt);

	$.ajax({
		url: 'editarEmpresa',
		type: 'POST',
		data: {nombre: nombrempree, nit: nittempree, idempre: idempreupdt, _token: tokkenn},
		success: function(respu){
			if (respu=='ok') {
				var url = window.location.href;
				swal({
			        title: "Empresa editada",
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
    			  $(nombrempree).val('');
    			  $(nittempree).val('');
    			  $('#editarempre'+idempre).hide();
				  location.href = '/empresas';
			}else {
				swal({
		          title: "Ha ocurrido un error",
		          // text: "You will not be able to recover this imaginary file!",
		          type: "error",
		          confirmButtonText: "Ok",
		          closeOnConfirm: true
		        });
				$('#errornombreupdt'+idempre).html('');
				$('#errornitupdt'+idempre).html('');
			}
		},
		error: function(respu){
			var erroress = JSON.parse(respu.responseText);

			if(erroress.nombre){
				$('#errornombreupdt'+idempre).html(erroress.nombre);
			}else{
				$('#errornombreupdt'+idempre).html('');
			}

			if(erroress.nit){
				$('#errornitupdt'+idempre).html(erroress.nit);
			}else{
				$('#errornitupdt'+idempre).html('');
			}
		}
	});
}
