<?php
require_once "../modelos/cargaHabilitacion.php";


$habilitacion = new Habilitacion();

$idhabilitacion=isset($_POST['idhabilitacion'])?limpiarCadena($_POST['idhabilitacion']):"";
$Caja_idCaja=isset($_POST['Caja_idCaja'])?limpiarCadena($_POST['Caja_idCaja']):"";
$Usuario_idUsuario=isset($_POST['Persona_idPersona'])?limpiarCadena($_POST['Persona_idPersona']):"";
$fechaApertura=isset($_POST['fechaApertura'])?limpiarCadena($_POST['fechaApertura']):"";
$montoApertura=isset($_POST['montoApertura'])?limpiarCadena($_POST['montoApertura']):"";
$montoCierre=isset($_POST['montoCierre'])?limpiarCadena($_POST['montoCierre']):"";
$moneda=isset($_POST['CtaCte'])?limpiarCadena($_POST['CtaCte']):""; 
 

switch ($_GET['op']) {
	case 'guardaryeditar':
		if (empty($idhabilitacion)) {
			$rspta=$habilitacion->insertar($Caja_idCaja, $Usuario_idUsuario, $fechaApertura, $montoApertura, $montoCierre, $_POST["cantidad"], $_POST["idDetalleMoneda"], $_POST["idMoneda"]);
			echo $rspta ? "habilitacion registrada" : "habilitacion no se pudo registrar";
		}
		else
		{
			$rspta=$habilitacion->editar($idhabilitacion,$Caja_idCaja,$Usuario_idUsuario, $montoApertura, $montoCierre );
			echo $rspta ? "habilitacion actualizada" : "habilitacion no se pudo editar";

		}
		break;
	
	case 'mostrar':
		$rspta=$habilitacion->mostrar($idhabilitacion);
		//codificar el resultado utilizando json
		echo json_encode($rspta);
		break;
	
	case 'cerrar':

		$rspta=$habilitacion->cerrar($idhabilitacion);
		//codificar el resultado utilizando json
		echo $rspta ? "habilitacion cerrada" : "habilitacion no se pudo cerrar";
		break;

	case 'habilitar':
		$rspta=$habilitacion->habilitar($idhabilitacion);
 		echo $rspta ? "Habilitado" : "No se puede habilitar";
	break;


	case 'listar':
	
		$rspta=$habilitacion->listar();
		$data = Array();
		while ($reg=$rspta->fetchObject()) {
			$data[]=array(
 				"0"=>($reg->estado)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idhabilitacion.')">Editar <i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="cerrar('.$reg->idhabilitacion.')">Cerrar <i class="fa fa-sign-out"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar1('.$reg->idhabilitacion.')">Ver  <i class="fa fa-eye"></i></button>',
 				"1"=>$reg->idhabilitacion,
				"2"=>$reg->Caja_idCaja,
				"3"=>$reg->nu,
				"4"=>$reg->fechaApertura,
				"5"=>$reg->fechaCierre,
				"6"=>$reg->montoApertura,
				"7"=>$reg->montoCierre,
				"8"=>($reg->estado)?'<span class="label bg-green">Habilitado</span>':
 				'<span class="label bg-red">Cerrado</span>'
			);

		}
		$result = array(
			"sEcho"=>1,
			"iTotalRecords"=>count($data),
			"iTotalDisplayRecords"=>count($data),
			"aaData"=>$data
		);

		echo json_encode($result);

		break;

	case 'generarPedido':
		$idProveedor=$_REQUEST["idProveedor"];
		$Denominacion_Denominacion=$_REQUEST["Denominacion_DenominacionD1"];
		$Moneda_idMoneda=$_REQUEST["Moneda_idMoneda"];
		$cantidad=$_REQUEST["fi"];
		
		$rspta=$habilitacion->generarPedido($idProveedor, $Denominacion_Denominacion, $Moneda_idMoneda, $cantidad);
 		
 		echo $rspta ? "Habilitacion Generada" : "Error al generar, intente nuevamente";

	break;		


case "selectDenominacion":

/*	$rspta = $persona->selectDenominacion($_POST['id']);
		echo json_encode($rspta);   */

	$rspta = $habilitacion->selectDenominacion($_POST['id']);
		echo '<thead style="background-color:#A9D0F5">
                    <th>Opciones</th>
                    <th>ID</th>
                    <th>Codigo Moneda</th>
                    <th>Denominacion</th>
                    <th>Cantidad</th>
                    <th>Nombre Moneda</th>
                </thead>';
        $contT = 0;
		while ($reg = $rspta->fetchObject())
				{
					echo '<tr class="filasContacto" id="filaContacto'.$contT.'">
					<td><button type="button" class="btn btn-danger" onclick="eliminarDetallePersonaContacto(\''.$contT.'\',\''.$reg->idMoneda.'\')">X</button>
					</td><td><input type="hidden" name="idDetalleMoneda[]"  value="'.$reg->idDetalleMoneda.'">'.$reg->idDetalleMoneda.'</td>
					</td><td><input type="hidden" name="idMoneda[]"  value="'.$reg->idMoneda.'">'.$reg->idMoneda.'</td>
					</td><td><input type="hidden" name="denominacion[]"  value="'.$reg->denominacion.'">'.$reg->denominacion.'</td>
					</td><td><input type="number" name="cantidad[]"  value="0"></td>
					</td><td><input type="text" name="moneda[]" readonly  value="'.$reg->moneda.'" ></td>'; 
					$contT++;															}		

	break;	


case 'mostrarDetalleMoneda':

		require_once "../modelos/Moneda.php";
		$moneda = new Moneda();
		$monedaD1=$_GET["id"];
 

		$rspta=$moneda->mostrarDetalleMoneda($monedaD1);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

		 			$data[]=array(

		 				"0"=>$reg->moneda,
		 				"1"=>$reg->denominacion,
		 				"2"=>"<input type='number' name='cantidad[]' id='cantidad[]' value='0' >"
		 				);
		} 
		 
		 $results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;



	case 'listarHacerHabilitacion':
		$idProveedor=$_REQUEST["idProveedor"];
		$fi=$_REQUEST["fi"];
		$ff=$_REQUEST["ff"];
		$estado=$_REQUEST["estado"];
		$Moneda_idMoneda=$_REQUEST["Moneda_idMoneda"];
		$rspta=$habilitacion->listarHacerHabilitacion($idProveedor, $fi, $ff, $estado, $Moneda_idMoneda);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 		$url='../reportes/exTicket.php?id=';
 			$data[]=array(
 				"0"=>((!$reg->hpi)?'<button class="btn btn-primary" onclick="mostrarDetalle('.$reg->idhabilitacion.',\''.$reg->tipo.'\')">Ver detalle <i class="fa fa-pencil"></i></button>':
 					''),
 				"1"=>$reg->idhabilitacion,
 				"2"=>$reg->caja,	
 				"3"=>utf8_encode($reg->np),
 				"4"=>$reg->fechaApertura,
 				"5"=>$reg->fechaCierre,
 				"6"=>$reg->moneda,
 				"7"=>$reg->denominacion,
 				"8"=>$reg->montoA,
 				"9"=>$reg->montoC,
 				"10"=>(!$reg->hpi)?'<span class="label bg-green">Abierto</span>':
 				'<span class="label bg-red">Cerrado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;	

	case "selectUsuario":
		require_once "../modelos/Usuario.php";
		$usuario = new Usuario();

		$rspta = $usuario->selectUsuario();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idusuario. '>' .$reg->nombre. '</option>';
		}

		break;

	case "selectCaja":
		require_once "../modelos/Caja.php";
		$caja = new Caja();

		$rspta = $caja->selectCaja();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idcaja. '>' .$reg->nc.' - '. $reg->ns .'</option>';
		}

		break;

	case "selectDeposito":
		require_once "../modelos/Deposito.php";
		$caja = new Deposito();

		$rspta = $caja->selectDeposito();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idDeposito. '>' .$reg->descripcion .'</option>';
		}

		break;
}


?>