$(document).ready(function(){
        /**
         * Funcion para añadir una nueva columna en la tabla
         */
        $("#add").click(function(){
            var nuevaFila="<tr>";
            nuevaFila+="<td><input type='text' name='nombrepar[]' id='nombrepar' class='form-control' placeholder='Nombre del participante'></td>"
            nuevaFila+="<td><input type='text' name='cedulapar[]' id='cedulapar' class='form-control' placeholder='Cedula del participante'></td>"
            nuevaFila+="<td><input type='text' name='cargopar[]' id='cargopar' class='form-control' placeholder='Cargo del participante'></td>"
            nuevaFila+="<td><input type='text' name='telefonopar[]' id='telefonopar' class='form-control' placeholder='Telefono del participante'></td>"
            nuevaFila+="<td><input type='text' name='correopar[]' id='correopar' class='form-control' placeholder='Correo del participante'></td>"
            nuevaFila+="<td><input type='text' name='observacionpar[]' id='observacionpar' class='form-control' placeholder='Observación'></td>"
            nuevaFila+="</tr>";
            $("#tabla").append(nuevaFila);
        });

        /**
         * Funcion para eliminar la ultima columna de la tabla.
         * Si unicamente queda una columna, esta no sera eliminada
         */
        $("#del").click(function(){
            // Obtenemos el total de columnas (tr) del id "tabla"
            var trs=$("#tabla tr").length;
            if(trs>1)
            {
                // Eliminamos la ultima columna
                $("#tabla tr:last").remove();
            }
        });
    });