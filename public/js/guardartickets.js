$('#guardarRes').click(function(e){
	//e.preventDefault();

	var respuesta = $('#respu').val();
	var respuestanv = $('#respunv').val();
	var eviden = $('#evidencia').val();
	var idticket = $('#idticket').val();
	var ext = eviden.substring(eviden.lastIndexOf("."));

	//alert(ext);

  if  ( $("#estadoresp").length > 0 ){
  	if($('#estadoresp').val()=='2'){
  	//	alert("En proceso");
	}else{

        if (respuesta == '') {
            $('#err1').html('Debe añadir una respuesta');
            e.preventDefault();
        }else {
            $('#err1').html('');
        }
	}
    }else{


      if (respuesta == '') {
          $('#err1').html('Debe añadir una respuesta');
          e.preventDefault();
      }else {
          $('#err1').html('');
      }

  }



	if (ext != '') {
		if (ext!=".jpg" && ext!=".jpeg" && ext!=".png" && ext!=".PNG" && ext!=".JPEG" && ext!=".JPG" && ext!=".rar" && ext!=".zip") {
			$('#err2').html('El archivo debe ser .jpg, .jpeg, .png, .rar, .zip');
			e.preventDefault();
		}else{
			$('#err2').html('');
		}
	}
});