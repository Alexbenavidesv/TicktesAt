/**
 * Created by Alex on 27/11/2017.
 */

var modulos=$('#modulosContrato');

var datos=[];

modulos.change(function () {

if(modulos.val()!=null){

    var html='';
    var vector=modulos.val();


        for (var i = 0; i < vector.length; i++) {
            var nombre=vector[i].split('-');

            if(datos.length>0){
             var pos=datos.indexOf(nombre[1]);
             if(!(pos>=0)){
                 datos.push(nombre[1]);
             }

            }else{
                datos.push(nombre[1]);
            }

            html+='<div class="col-md-3">' +
                    '<div class="panel panel-success">'+
                    '<div class="panel-heading text-center">'+
                     '<b> Modulo '+nombre[1]+'</b>'+
                     '</div>'+
                    '<div class="panel-body">'+
                    '<label for="">Cantidad de horas </label>'+
                    '<label for="" style="color: red;" id="errorHoras'+i+'"></label>'+
                    '<input type="number" min="1" id="horas'+i+'"class="form-control" placeholder="Horas">'+
                    '<br>'+
                    '<label for="">Tipo pago</label>'+
                    '<select  id="tipoPago'+i+'" class="form-control">'+
                    '<option value="Pagadas">Pagadas</option>'+
                    '<option value="Por pagar">Por pagar</option>'+
                    '<option value="Cortesia">Cortesia</option>'+
                '</select>'+
                '</div>'+
                '</div> ' +
                '</div>';
        }

    $('#listModulos').html(
     html
    );

    $('#boton').html(
        '<div><button type="button" class="btn btn-success" onclick="guardarContrato()"><i class="fa fa-save"></i> Guardar</button></div>'
    );
alert(datos);
}
else{
    $('#listModulos').html('');
    $('#boton').html('');
}


});

function seleccionarModulo(id) {
    $('#modulo'+id).css('display','none');
}

function deseleccionarModulo(id) {
    $('#menos'+id).css('display','none');
    $('#mas'+id).css('display','inline');
    $('#panel'+id).css('display','none');
}

function guardarContrato() {
    var vector=modulos.val();

    for (var i = 0; i < vector.length; i++) {
        var horas = $('#horas'+i).val();

        if(horas!=''){
            $('#errorHoras'+i).html('');
        }
        else{
            $('#errorHoras'+i).html('Debes agregar las horas');
        }

    }


}


