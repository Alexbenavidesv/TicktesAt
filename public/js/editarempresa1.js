$('#editarEmpresa').click(function(event) {
	//alert('message?: DOMString');
	var nombrempre = $('#nempre').val();
	var nittempre = $('#nitempre').val();
	var tokkenn = $('input[name="_token"]').val();
	//alert(tokkenn);

	$.ajax({
		url: 'editarEmpresa',
		type: 'POST',
		data: {nombre: nombrempre, nit: nittempre, _token: tokkenn},
		success: function(response){
			
		},
	});
	
});