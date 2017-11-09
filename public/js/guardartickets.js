$('#guardarRes').click(function(e){
	//e.preventDefault();

	var respuesta = $('#respu').val();
	var eviden = $('#evidencia').val();
	var idticket = $('#idticket').val();
	var ext = eviden.substring(eviden.lastIndexOf("."));

	//alert(ext);
	if (respuesta == '') {
		$('#err1').html('Debe añadir una respuesta');
		e.preventDefault();		
	}

	if (ext != '') {
		if (ext!=".jpg" && ext!=".jpeg" && ext!=".png") {
			$('#err2').html('El archivo debe ser una imagen (.jpg, .jpeg, .png)');
			e.preventDefault();
		}else{
			$('#err2').html('');
		}
	}
});