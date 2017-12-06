$(document).ready(function() {
    $('#reasignar').change(function() {
        if($(this).is(":checked")) {
        	$(this).attr("value", "1");
        	$('#select').css("display", "none");
        	$('#area').css("display", "block");
        }else {
        	$(this).attr("value", "0");
        	$('#select').css("display", "block");
        	$('#area').css("display", "none");
        }
            
    });


    $('#asignarConsultor').change(function() {
        if($(this).is(":checked")) {
            $(this).attr("value", "1");
            $('#select').css("display", "none");
            $('#nuevoConsultor').css("display", "block");
        }else {
            $(this).attr("value", "0");
            $('#select').css("display", "block");
            $('#nuevoConsultor').css("display", "none");
        }

    });

});