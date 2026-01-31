<?php 
require_once "../modelos/MovimientoPersonal.php";

$movimientoPersonal=new MovimientoPersonal();

$idMovimientoPersonal=isset($_POST["idMovimientoPersonal"])? limpiarCadena($_POST["idMovimientoPersonal"]):"";
$Legajo_idLegajo=isset($_POST["Legajo_idLegajo"])? limpiarCadena($_POST["Legajo_idLegajo"]):"";
$TipoMovimiento_idTipoMovimiento=isset($_POST["TipoMovimiento_idTipoMovimiento"])? limpiarCadena($_POST["TipoMovimiento_idTipoMovimiento"]):"";
$fechaTransaccion=isset($_POST["fechaTransaccion"])? limpiarCadena($_POST["fechaTransaccion"]):"";
$fechaInicio=isset($_POST["fechaInicio"])? limpiarCadena($_POST["fechaInicio"]):"";
$fechaFin=isset($_POST["fechaFin"])? limpiarCadena($_POST["fechaFin"]):"";
$nroComprobante=isset($_POST["nroComprobante"])? limpiarCadena($_POST["nroComprobante"]):"";
$esIngreso=isset($_POST["esIngreso"])? limpiarCadena($_POST["esIngreso"]):"";
$esSalida=isset($_POST["esSalida"])? limpiarCadena($_POST["esSalida"]):"";
$esCambioDato=isset($_POST["esCambioDato"])? limpiarCadena($_POST["esCambioDato"]):"";

 
switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idMovimientoPersonal)){
			$rspta=$movimientoPersonal->insertar($Legajo_idLegajo,$TipoMovimiento_idTipoMovimiento,$fechaTransaccion,$fechaInicio,$fechaFin,$nroComprobante,$esIngreso,$esSalida,$esCambioDato);
			echo $rspta ? "movimientoPersonal registrado" : "movimientoPersonal no se pudo registrar";
		}
		else {
			$rspta=$movimientoPersonal->editar($idMovimientoPersonal,$Legajo_idLegajo,$TipoMovimiento_idTipoMovimiento,$fechaTransaccion,$fechaInicio,$fechaFin,$nroComprobante,$esIngreso,$esSalida,$esCambioDato);
			echo $rspta ? "movimientoPersonal actualizado" : "movimientoPersonal no se pudo actualizar";
		}
	break;

	case 'mostrar':
		$rspta=$movimientoPersonal->mostrar($idMovimientoPersonal);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'desactivar':
		$rspta=$movimientoPersonal->desactivar($idMovimientoPersonal);
 		echo $rspta ? "movimientoPersonal Desactivado" : "movimientoPersonal no se puede desactivar";
	break;

	case 'activar':
		$rspta=$movimientoPersonal->activar($idMovimientoPersonal);
 		echo $rspta ? "movimientoPersonal activado" : "movimientoPersonal no se puede activar";
	break;


	case 'listar':
		$rspta=$movimientoPersonal->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){


 			if ($reg->esIngreso) {
 				$esIngreso = 'SI';
 			}else{
 				$esIngreso = 'NO';
 			}


 			if ($reg->esSalida) {
 				$esSalida = 'SI';
 			}else{
 				$esSalida = 'NO';
 			}


 			if ($reg->esCambioDato) {
 				$esCambioDato = 'SI';
 			}else{
 				$esCambioDato = 'NO';
 			}


 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idMovimientoPersonal.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idMovimientoPersonal.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idMovimientoPersonal.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idMovimientoPersonal.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombreLegajo,
 				"2"=>$reg->nombreTipoMovimiento,
 				"3"=>$reg->fechaTransaccion,
 				"4"=>$reg->fechaInicio,
 				"5"=>$reg->fechaFin,
 				"6"=>$reg->nroComprobante,
 				"7"=>$esIngreso,
 				"8"=>$esSalida,
 				"9"=>$esCambioDato,
 				"10"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case "selectMovimientoPersonal":

		$rspta = $movimientoPersonal->selectMovimientoPersonal();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idMovimientoPersonal. '>' .$reg->descripcion. '</option>';
		}

		break;
	

}
?>