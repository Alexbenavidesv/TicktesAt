$('#respuestaupdt').click(function(en) {
	//en.preventDefault();
	var respuestaupdtt = $('#respuupdt').val();
	var evidenciaupdt = $('#evidenciaedit').val();
	var cerrarupdt = $('#finalizadores').val();
	var respuestaupdtnv = $('#respuupdtnv').val();
	var exten = evidenciaupdt.substring(evidenciaupdt.lastIndexOf("."));
	//alert(respuestaupdtt);
	if (respuestaupdtt == '') {
		$('#errordescrespuesta').html('Debe añadir una descripción');
		en.preventDefault();		
	}else {
		$('#errordescrespuesta').html('');
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

