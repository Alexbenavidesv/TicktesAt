
function agregarTema() {
    var fila="<tr> <td><input type='text' id='temas' name='temas[]' class='form-control'> </td> <td> <input id='manual' name='manual[]' type='file'> </td> </tr>";

    $("#temas").append(fila);
}

function eliminarTema() {
    var trs=$("#temas tr").length;
    if(trs>2)
    {
        $("#temas tr:last").remove();
    }
}

function agregarModulo() {
    var nombreModulo=$('#nombreModulo').val();
    var temas=$('#temas').val();

    if(nombreModulo!=''){

    }
    else{
        $('#errorModulo').html('<b>Debes ingresar un nombre para el modulo</b>');

    }

}