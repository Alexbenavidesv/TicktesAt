<!DOCTYPE html>
<html>

<body>
@if($visitapdf[0]->tipo=='Consultoría' || $visitapdf[0]->tipo=='Presentación')
<table border="" style="text-align: center; font-family: Helvetica;">
	<tr>
		<td width="130px">
			<img src="./img/zues.PNG" width="150px" height="65px">
		</td>
		<td>
			<table style="font-size: 10px; text-align: center; font-family: Helvetica;">
			<tr>
			<td><h1 style="text-align: center; margin-left: 250px">Registro de visita</h1></td>
			</tr>
			</table>
			
		</td>
	</tr>
	<tr>
		<td><hr style="border: 0.3px solid #000;" width="700%"></td>
	</tr>
	</table>

	<table style="font-size: 12px; font-family: Helvetica;  width: 400%;">
	<tr>
		<td>
		<b>Datos de la visita</b>
		</td>
	</tr><br><br>

	<tr>
		<td width="5%">
		Cliente visitado:
		</td>

		<td width="10px"><b>{{$visitapdf[0]->cliente}}</b></td>

		<td width="5%">
		Fecha de la visita: 
		</td>

		<td width="150px" colspan="3"><b>{{$visitapdf[0]->fecha}}</b></td>
		
		<td width="5%">Quien visita</td>
		<td><b>{{$visitapdf[0]->consultor}}</b></td>
	</tr>
	<tr>
		<td width="5%">
		Tipo de visita:
		</td>

		<td width="120px"><b>{{$visitapdf[0]->tipo}}</b></td>

		<td width="1%">
		Lugar de la visita: 
		</td>

		<td width="190px" colspan="3"><b>{{$visitapdf[0]->lugar}}</b></td>

		<td width="5%">Estado Interes</td>
		<td><b>{{$visitapdf[0]->satisfaccion}}</b></td>
	</tr>
	<tr>
		<td width="5%">
		Telefono del cliente:
		</td>

		<td width="120px"><b>{{$visitapdf[0]->telefono}}</b></td>
	</tr>
	</table>
	<div>
	<table style="font-size: 12px; font-family: Helvetica; text-align: center; width: 100%; background-color: #C1D9F9">
		<tr>
			<td width="5%">
			<b>Motivo de la visita:</b>
			</td>

			<td width="120px"></td>
		</tr>
	</table>
	<table style="font-size: 12px; font-family: Helvetica; text-align: center; width: 100%">
		<tr>
			<td width="120px">{{$visitapdf[0]->motivo}}</td>
		</tr>
	</table>
	<table style="font-size: 12px; font-family: Helvetica; text-align: center; text-align: center; width: 100%; background-color: #C1D9F9">
		<tr>
			<td width="5%">
			<b>Información recolectada en la visita:</b>
			</td>

			<td width="120px"></td>
		</tr>
	</table>
	<table style="font-size: 12px; font-family: Helvetica; text-align: center; width: 100%">
		<tr>
			<td width="120px">{{$visitapdf[0]->recoleccion}}</td>
		</tr>
	</table><br><br><br>
	<table style="font-size: 10px; font-family: Helvetica;  width: 100%; text-align: center">
		<tr style=" text-align: center;">
			<td style=" text-align: center;">Copyright &copy; 2017 Desarrollado por ATSoluciones SAS</td>
		</tr>
	</table>





@elseif ($visitapdf[0]->tipo=='Capacitación')






<table border="" style="font-size: 10px; font-family: Helvetica;  width: 100%; text-align: center">
		<tr>
			<td width="130px">
				<img src="./img/zues.PNG" width="150px" height="65px">
			</td>
			<td>
				<table style="font-size: 10px; text-align: center; font-family: Helvetica; border: 1px solid #000">
				<tr>
				<h1 style="text-align: center; margin-left: 1%; margin-right: 150px">Registro de visitas capacitación</h1>
				</table>
				</tr>
			</td>
		</tr>
		<tr>
			<td><hr style="border: 0.3px solid #000;" width="700%"></td>
		</tr>
	</table>

	<table style="font-size: 12px; font-family: Helvetica;  width: 400%">
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

			<td width="5%">
			Fecha de inicio: 
			</td>
			<td width="150px" colspan="3"><b>{{date_format(date_create($visitapdf[0]->fechainicio), 'Y-m-d g:i A')}}</b></td>
			
			<td  width="5%">Fecha de finalización:</td>
			<td><b>{{date_format(date_create($visitapdf[0]->fechafin), 'Y-m-d g:i A')}}</b></td>
		</tr>
		<tr>
			<td width="5%">
			Motivo de la visita:
			</td>

			<td width="120px"><b>{{$visitapdf[0]->tipo}}</b></td>

			<td width="1%">
			Duraciónde la visita: 
			</td>

			<td width="190px" colspan="3"><b>{{$visitapdf[0]->duracion}} horas</b></td>

			<td>Lugar:</td>
			<td><b>{{$visitapdf[0]->lugar}}</b></td>
		</tr>
		<tr>
			<td>Consultor:</td>
			<td><b>{{$visitapdf[0]->consultor}}</b></td>
			<td>Modulo:</td>
			<td><b>{{$visitapdf[0]->modulo}}</b></td>
		</tr>
		</table>
		<div>
		<table style="width:100%; border: 1px solid black;
			    border-collapse: collapse;">
		  <tr style="border: 1px solid black;
			    border-collapse: collapse; text-align: center; font-size: 12; font-family: Helvetica">
		    <th style="border: 1px solid black;
			    border-collapse: collapse;">Nombre</th>
		    <th style="border: 1px solid black;
			    border-collapse: collapse;">Cargo</th>
		    <th style="border: 1px solid black;
		    border-collapse: collapse;">Telefono</th>
		  </tr>
		  @foreach($visitados as $v)
		  <tr style="border: 1px solid black;
			    border-collapse: collapse; text-align: center; font-size: 10; font-family: Helvetica">
		    <td style="border: 1px solid black;
			    border-collapse: collapse;">{{$v->nombre}}</td>
		    <td style="border: 1px solid black;
			    border-collapse: collapse;">{{$v->cargo}}</td>
			<td style="border: 1px solid black;
			    border-collapse: collapse;">{{$v->telefono}}</td>   
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


@elseif($visitapdf[0]->tipo=='Soporte')


<table border="" style="font-size: 10px; font-family: Helvetica;  width: 100%; text-align: center">
		<tr>
			<td width="130px">
				<img src="./img/zues.PNG" width="150px" height="65px">
			</td>
			<td>
				<table style="font-size: 10px; text-align: center; font-family: Helvetica; border: 1px solid #000">
				<tr>
				<h1 style="text-align: center; margin-left: 1%; margin-right: 150px">Registro de visitas capacitación</h1>
				</table>
				</tr>
			</td>
		</tr>
		<tr>
			<td><hr style="border: 0.3px solid #000;" width="700%"></td>
		</tr>
	</table>

	<table style="font-size: 12px; font-family: Helvetica;  width: 400%">
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

			<td width="5%">
			Fecha de inicio: 
			</td>
			<td width="150px" colspan="3"><b>{{date_format(date_create($visitapdf[0]->fechainicio), 'Y-m-d g:i A')}}</b></td>
			
			<td  width="5%">Fecha de finalización:</td>
			<td><b>{{date_format(date_create($visitapdf[0]->fechafin), 'Y-m-d g:i A')}}</b></td>
		</tr>
		<tr>
			<td width="5%">
			Motivo de la visita:
			</td>

			<td width="120px"><b>{{$visitapdf[0]->tipo}}</b></td>

			<td width="1%">
			Duraciónde la visita: 
			</td>

			<td width="190px" colspan="3"><b>{{$visitapdf[0]->duracion}} horas</b></td>

			<td>Lugar:</td>
			<td><b>{{$visitapdf[0]->lugar}}</b></td>
		</tr>
		<tr>
			<td>Consultor:</td>
			<td><b>{{$visitapdf[0]->consultor}}</b></td>
		</tr>
		</table>

		<table style="font-size: 12px; font-family: Helvetica; text-align: center; width: 100%; background-color: #C1D9F9">
			<tr>
				<td width="5%">
				<b>Motivo de la visita:</b>
				</td>

				<td width="120px"></td>
			</tr>
		</table>
		<table style="font-size: 12px; font-family: Helvetica; text-align: center; width: 100%">
			<tr>
				<td width="120px">{{$visitapdf[0]->motivo}}</td>
			</tr>
		</table>
		<table style="font-size: 12px; font-family: Helvetica; text-align: center; text-align: center; width: 100%; background-color: #C1D9F9">
			<tr>
				<td width="5%">
				<b>Información recolectada en la visita:</b>
				</td>

				<td width="120px"></td>
			</tr>
		</table>
		<table style="font-size: 12px; font-family: Helvetica; text-align: center; width: 100%">
			<tr>
				<td width="120px">{{$visitapdf[0]->recoleccion}}</td>
			</tr>
		</table><br><br><br>

		<table style="font-size: 10px; font-family: Helvetica;  width: 100%; text-align: center">
			<tr style=" text-align: center;">
				<td style=" text-align: center;">Copyright &copy; 2017 Desarrollado por ATSoluciones SAS</td>
			</tr>
		</table>
</table>



@endif
</body>
</html>