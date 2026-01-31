<?php 
require_once "../modelos/Liquidacion.php";

$liquidacion=new Liquidacion();

$idLiquidacion=isset($_POST["idLiquidacion"])? limpiarCadena($_POST["idLiquidacion"]):"";
$periodo=isset($_POST["periodo"])? limpiarCadena($_POST["periodo"]):"";
$fechaInicioPeriodo=isset($_POST["fechaInicioPeriodo"])? limpiarCadena($_POST["fechaInicioPeriodo"]):"";
$fechaFinPeriodo=isset($_POST["fechaFinPeriodo"])? limpiarCadena($_POST["fechaFinPeriodo"]):"";
$fechaApertura=isset($_POST["fechaApertura"])? limpiarCadena($_POST["fechaApertura"]):"";
$TipoLiquidacion_idTipoLiquidacion=isset($_POST["TipoLiquidacion_idTipoLiquidacion"])? limpiarCadena($_POST["TipoLiquidacion_idTipoLiquidacion"]):"";
$Moneda_idMoneda=isset($_POST["Moneda_idMoneda"])? limpiarCadena($_POST["Moneda_idMoneda"]):"";

 
switch ($_GET["op"]){
	case 'guardaryeditar':

		if (empty($idLiquidacion)){
			$rspta=$liquidacion->insertar($periodo,$fechaInicioPeriodo,$fechaFinPeriodo,$fechaApertura,$TipoLiquidacion_idTipoLiquidacion,$Moneda_idMoneda);
			echo $rspta ? "liquidacion registrado" : "liquidacion no se pudo registrar";
		}
		else {
			$rspta=$liquidacion->editar($idLiquidacion,$periodo,$fechaInicioPeriodo,$fechaFinPeriodo,$fechaApertura,$TipoLiquidacion_idTipoLiquidacion,$Moneda_idMoneda);
			echo $rspta ? "liquidacion actualizado" : "liquidacion no se pudo actualizar";
		}
	break;

	case 'mostrar':
		$rspta=$liquidacion->mostrar($idLiquidacion);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'desactivar':
		$rspta=$liquidacion->desactivar($idLiquidacion);
 		echo $rspta ? "liquidacion Desactivado" : "liquidacion no se puede desactivar";
	break;

	case 'activar':
		$rspta=$liquidacion->activar($idLiquidacion);
 		echo $rspta ? "liquidacion activado" : "liquidacion no se puede activar";
	break;


	case 'listar':
		$rspta=$liquidacion->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?''.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idLiquidacion.')"><i class="fa fa-close"></i></button>':
 					''.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idLiquidacion.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->periodo,
 				"2"=>$reg->fechaInicioPeriodo,
 				"3"=>$reg->fechaFinPeriodo,
 				"4"=>$reg->fechaApertura,
 				"5"=>$reg->nombreTipoLiquidacion,
 				"6"=>$reg->nombreMoneda,
 				"7"=>$reg->total,
 				"8"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>',
 				"9"=>'<button class="btn btn-primary" onclick="mostrarDetalle('.$reg->idLiquidacion.')">Ver detalle generado <i class="fa fa-pencil"></i></button>',
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;



	case 'listarCierre':
		$rspta=$liquidacion->listarCierre();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?''.
 					' <button class="btn btn-danger" onclick="autorizarCierre('.$reg->idLiquidacion.')"><i class="fa fa-close">Autorizar cierre</i></button>':
 					''.
 					'',
 				"1"=>$reg->periodo,
 				"2"=>$reg->fechaInicioPeriodo,
 				"3"=>$reg->fechaFinPeriodo,
 				"4"=>$reg->fechaApertura,
 				"5"=>$reg->nombreTipoLiquidacion,
 				"6"=>$reg->nombreMoneda,
 				"7"=>$reg->total,
 				"8"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>',
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;


	case 'autorizarCierre':
		
		$id = $_REQUEST['id'];
		
		//$ti= 2; //$_REQUEST['ti'];
		session_start();
		$User = $_SESSION['login'];

		$rspta=$liquidacion->autorizarCierre($id);
 		$data= 1;
 		echo json_encode($data);

	break;	



	case "selectLiquidacion":

		$rspta = $liquidacion->selectliquidacion();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idLiquidacion. '>' .$reg->descripcion. '</option>';
		}

		break;
	

	case 'mostrarDetalle':
		$rspta=$liquidacion->mostrarDetalle($_GET['idLiquidacion']);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>'',
 				"1"=>$reg->apellido .', '. $reg->nombre,
 				"2"=>$reg->conceptoSalario,
 				"3"=>$reg->tipoSalario,
 				"4"=>number_format($reg->monto, 0, ',', '.')
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;



}
?>