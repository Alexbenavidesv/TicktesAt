$('#respuestaupdt').click(function(en) {
	var respuestaupdt = $('#respuupdt').val();
	var evidenciaupdt = $('#evidenciaedit').val();
	var cerrarupdt = $('#finalizadores').val();
	var exten = evidenciaupdt.substring(evidenciaupdt.lastIndexOf("."));
	//alert(exten);
	if (respuestaupdt == '') {
		$('#errordescrespuesta').html('Debe añadir una descripción');
		en.preventDefault();		
	}

	if (exten != '') {
		if (exten!=".jpg" && exten!=".jpeg" && exten!=".png" && exten!=".PNG" && exten!=".JPEG" && exten!=".JPG" && exten!="rar" && exten!="zip") {
			$('#errorevidenciares').html('ingrese un archivo valido (.jpg, .jpeg, .png .rar .zip)');
			en.preventDefault();
		}else{
			$('#errorevidenciares').html('');
		}
	}
});

