/**
 * Created by Alex on 20/11/2017.
 */
function buscarFecha() {
    var fecha =$('.buscarFecha').val();
if(fecha!='') {
    location.href = "/filtro_resumen/" + fecha;
    $('#errorFecha').html('');
}else{
    $('#errorFecha').html('Ingresa una fecha');
}

}