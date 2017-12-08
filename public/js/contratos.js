function Modulo(id, modulo){
    var id = id;
    var modul = modulo;
    var tds='';
    var filas = $('#fila tr').length;

    if (filas==0) {
       tds+='<tr id="fila'+id+'"><td><input type="hidden" class="clase" name="idmodulo[]" value="'+id+'"></td><td><input class="form-control" type="text" name="nombremodulo[]" value="'+modul+'"></td><td><input type="number" class="form-control clase1 clase2" min="1" name="horasmodulo[]" onmouseover="sumar()"></td><td><select class="form-control" name="tipopago[]"><option value="1">PAGADO</option><option value="2">POR PAGAR</option><option value="3">CORTESIA</option></select></td><td><button type="button" class="btn btn-danger" style="width: 100%" onclick="quitar('+id+')"><i class="fa fa-minus"></i></button></td></tr>'; 
       $('#fila').append(tds);
    }else if (filas>0) {
        var vector = [];
        var variable = '';
        $('.clase').each(function() {
          variable = $(this).val();
          vector.push(variable); 
        });  
        var validador='';
        for (var i = 0; i < vector.length; i++) {
            if (id==vector[i]) {
                validador = '1';
            }
         } 

         if (validador=='1') {
         }else {
             tds+='<tr id="fila'+id+'"><td><input type="hidden" class="clase" name="idmodulo[]" value="'+id+'"></td><td><input class="form-control" type="text" name="nombremodulo[]" value="'+modul+'"></td><td><input type="number" class="form-control clase1 clase2" min="1" name="horasmodulo[]" onmouseover="sumar()"></td><td><select class="form-control" name="tipopago[]"><option value="1">PAGADO</option><option value="2">POR PAGAR</option><option value="3">CORTESIA</option></select></td><td><button type="button" class="btn btn-danger" style="width: 100%" onclick="quitar('+id+')"><i class="fa fa-minus"></i></button></td></tr>'; 
             $('#fila').append(tds);
         }
    }
}

function sumar(){
$('.clase2').change(function(event) {
      var horas_total = 0
      $('.clase2').each(
        function(index, value) {
          if ( $.isNumeric( $(this).val() ) ){
            horas_total = horas_total + eval($(this).val());
        }
       } 
      );
    $("#inputTotal").val(horas_total);
});
}




function quitar(id){
    $('#fila'+id).remove();
}




$('#guardarContrato').click(function(event) {
    var empresa = $('#empresa').val();
    var filas = $('#fila tr').length;
    var validador='';
    if (empresa==null) {
        $('#errorempresacon').html('Debe escoger una empresa');
        //event.preventDefault();
        validador = '1';
    }else {
       $('#errorempresacon').html('');
       validador = '0'; 
    }

    if (filas==0) {
        $('#errorfilas').html('Debe escoger por lo menos un modulo');
        //event.preventDefault();
        validador='1';
    }else {
        $('.clase1').each(function() {
          var valor = $(this).val();
          if (valor=='') {
              $('#errorfilas').html('Debe llenar las horas de los modulos seleccionados');
              //event.preventDefault();
              validador='1';
          }else {
              $('#errorfilas').html('');
              validador='0';
          }
      });
    }


    if (validador=='0') {
        var tokkk = $('input[name="_token"]').val();
        var dattt = new FormData($('#formcontrato')[0]);

        $.ajax({
            url: 'guardarContrato',
            type: 'POST',
            headers: {'X-CSRF-TOKEN':tokkk},
            data: dattt,
            contentType: false,
            processData: false,
            success: function(res){
            if (res=='ok') {
                var url = window.location.href;
                swal({
                    title: "Contrado guardado con exito",
                    type: "success",
                    confirmButtonText: "Ok",
                    closeOnConfirm: false
                  },
                  function(isConfirm){
                    if (isConfirm) {
                      location.reload();
                    }
                  });
                  $(location).attr('href', url);
            }else {
                swal({
                  title: "La empresa tiene un contrato activo actualmente",
                  type: "error",
                  confirmButtonText: "Ok",
                  closeOnConfirm: true
                });
              }
            }
        });  
    }
});


function Ver(id){
    $('#ocultarcontrato'+id).css('display', '');
    $('#vercontrato'+id).css('display', 'none');
    //alert(id);
    $('#contenidocontrato'+id).css('display', '');
}


function Ocultar(id){
    $('#ocultarcontrato'+id).css('display', 'none');
    $('#vercontrato'+id).css('display', '');
    $('#contenidocontrato'+id).css('display', 'none');
}

function editar(id){




   var token = $('input[name="_token"]').val();
    var data = new FormData($('#editadohoras'+id)[0]);

        $.ajax({
            url: '/editarHoras',
            type: 'POST',
            headers: {'X-CSRF-TOKEN':token},
            data: data,
            contentType: false,
            processData: false,
            success: function(res){
               // console.log(res);
            if (res=='ok') {
                var url = window.location.href;
                swal({
                    title: "Horas editadas con exito",
                    type: "success",
                    confirmButtonText: "Ok",
                    closeOnConfirm: false
                  },
                  function(isConfirm){
                    if (isConfirm) {
                      location.reload();
                    }
                  });
                  $(location).attr('href', url);
            }else {
                swal({
                  title: "Error al editar las horas",
                  type: "error",
                  confirmButtonText: "Ok",
                  closeOnConfirm: true
                });
              }
            }
        });
}



$('#filtroContratos').click(function () {

    var tipo=$('#tipoContrato_').val();
    var empresa=$('#empresaContrato_').val();

    if(tipo!='' || empresa!=null){
        $( "#filtrosContratos" ).submit();
    }

});

$('#filtroContratosLimpiar').click(function () {
    location.href='/contratos';
});



function agregarModuloContrato(id) {
    $('#nmodulo'+id).css('display','none');
    $('#cnmodulo'+id).css('display','inline');
    $('#modulosExtra'+id).addClass('alert alert-info');

    var idcontrato=$('#idcontrato'+id).val();

    $.ajax({
        url: '/modulos_contrato',
        data:{id_contrato:idcontrato} ,
        type: 'GET',
        success: function (res) {
             var cont=res.length;
             var html='<div class="row text-center" style="font-weight: bold; color: black;">' +
                 '<div class="col-md-4">' +
                 'Módulo'+
                 '</div>' +
                 '<div class="col-md-4">' +
                 'Horas'+
                 '</div>' +
                 '<div class="col-md-4">' +
                 'Tipo pago'+
                 '</div>' +
                 '</div>  ';
             for(var i=0;i<cont;i++){
                 html+='<div class="row">' +
                     '<div class="col-md-4">' +
                     '<input type="hidden" class="form-control" name="idNuevosModulos[]" value="'+ res[i].id +'">' +
                     '<input type="text" class="form-control"  value="'+ res[i].nombre +'" readonly>' +
                     '</div>' +
                     '<div class="col-md-4">' +
                     '<input type="number" name="horasNuevosModulos[]" value="0" min="1" class="form-control">' +
                     '</div>' +
                     '<div class="col-md-4">' +
                     '<select name="nuevoTipoPago[]" class="form-control" id="">'+
                     '<option value="1">PAGADO</option>'+
                     '<option value="2">POR PAGAR</option>'+
                     '<option value="3">CORTESIA</option>'+
                     '</select>' +
                     '</div>' +
                     '</div>';
             }
            $('#modulosExtra'+id).html(html);
        }

    });
}



function cancelarAgregarModulos(id) {
    $('#cnmodulo'+id).css('display','none');
    $('#nmodulo'+id).css('display','inline');
    $('#modulosExtra'+id).removeClass('alert alert-info');
    $('#modulosExtra'+id).html('');
}


 


