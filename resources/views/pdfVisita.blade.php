<!DOCTYPE html>
<html>
<head>
	<title>Resultado de Imagenología</title>
</head>
<body>
<table border="" style="text-align: center; font-family: Helvetica;">
		<tr>
			<td width="130px">
				<img src="./img/zues.PNG" width="150px" height="65px">
			</td>
			<td>
				<table style="font-size: 10px; text-align: center; font-family: Helvetica; border: 1px solid #000">
				<tr>
				<h1 style="text-align: center; margin-left: 150px">Registro de visitas</h1>
				</table>
				</tr>
			</td>
		</tr>
		<tr>
			<td><hr style="border: 0.3px solid #000;" width="700px"></td>
		</tr>
	</table>

	<table style="font-size: 12px; font-family: Helvetica;">
		<tr>
			<td>
			<b>Datos de la visita</b>
			</td>
		</tr><br><br>

		<tr>
			<td width="5%">
			Empresa visitada:
			</td>

			<td width="10px"><b>{{$visitapdf[0]->empresa}}</b></td>

			<td width="1%">
			Fecha de la visita: 
			</td>

			<td width="150px" colspan="3"><b>{{$visitapdf[0]->fecha}}</b></td>
			
			<td>Quien visita</td>
			<td><b>{{$visitapdf[0]->consultor}}</b></td>
		</tr>
		<tr>
			<td width="5%">
			Motivo de la visita:
			</td>

			<td width="120px"><b>{{$visitapdf[0]->tipo}}</b></td>

			<td width="1%">
			Lugar de la visita: 
			</td>

			<td width="190px" colspan="3"><b>{{$visitapdf[0]->lugar}}</b></td>
		</tr>
		</table>
		<div>
		<table style="width:100%; border: 1px solid black;
			    border-collapse: collapse;">
		  <tr style="border: 1px solid black;
			    border-collapse: collapse;">
		    <th style="border: 1px solid black;
			    border-collapse: collapse;">Nombre</th>
		    <th styborder: 1px solid black;
			    border-collapse: collapse;>Cedula</th> 
		    <th style="border: 1px solid black;
			    border-collapse: collapse;">Cargo</th>
		    <th style="border: 1px solid black;
		    border-collapse: collapse;">Telefono</th>
		    <th style="border: 1px solid black;
		    border-collapse: collapse;">Correo</th>
		    <th style="border: 1px solid black;
		    border-collapse: collapse;">Observación</th>
		    <th style="border: 1px solid black;
		    border-collapse: collapse; width: 120px">Firma</th>
		  </tr>
		  @foreach($visitados as $v)
		  <tr style="border: 1px solid black;
			    border-collapse: collapse;">
		    <td style="border: 1px solid black;
			    border-collapse: collapse;">{{$v->nombre}}</td>
		    <td style="border: 1px solid black;
			    border-collapse: collapse;">{{$v->identificacion}}</td>
		    <td style="border: 1px solid black;
			    border-collapse: collapse;">{{$v->cargo}}</td>
			<td style="border: 1px solid black;
			    border-collapse: collapse;">{{$v->telefono}}</td>
			<td style="border: 1px solid black;
			    border-collapse: collapse;">{{$v->correo}}</td>
			<td style="border: 1px solid black;
			    border-collapse: collapse;">Observación</td>
			<td style="border: 1px solid black;
			    border-collapse: collapse; width: 120px"></td>    
		  </tr>
		  @endforeach
		</table>


	</div>
	

	<table style="font-size: 10px; font-family: Helvetica;  width: 100%; text-align: center">
		<tr style=" text-align: center;">
			<td style=" text-align: center;">Copyright &copy; 2017 Desarrollado por ATSoluciones SAS</td>
		</tr>
	</table>
</table>
</body>
</html>