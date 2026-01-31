<?php 
require_once "../modelos/TerminoPago.php";

$terminoPago=new TerminoPago();

$idTerminoPago=isset($_POST["idTerminoPago"])? limpiarCadena($_POST["idTerminoPago"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$tipo=isset($_POST["tipo"])? limpiarCadena($_POST["tipo"]):"";
$diasVencimiento=isset($_POST["diasVencimiento"])? limpiarCadena($_POST["diasVencimiento"]):"";
$cantidadCuotas=isset($_POST["cantidadCuotas"])? limpiarCadena($_POST["cantidadCuotas"]):"";
$diaPrimeraCuota=isset($_POST["diaPrimeraCuota"])? limpiarCadena($_POST["diaPrimeraCuota"]):"";
$porcentajeInteres=isset($_POST["porcentajeInteres"])? limpiarCadena($_POST["porcentajeInteres"]):"";


switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idTerminoPago)){
			$rspta=$terminoPago->insertar($descripcion,$tipo,$diasVencimiento,$cantidadCuotas,$diaPrimeraCuota,$porcentajeInteres);
			echo $rspta ? "Tipo pago registrado" : "Tipo pago no se pudo registrar";
		}
		else {
			$rspta=$terminoPago->editar($idTerminoPago,$descripcion,$tipo,$diasVencimiento,$cantidadCuotas,$diaPrimeraCuota,$porcentajeInteres);
			echo $rspta ? "Tipo pago actualizado" : "Tipo pago no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$terminoPago->desactivar($idTerminoPago);
 		echo $rspta ? "Tipo pago Desactivada" : "Tipo pago no se puede desactivar";
	break;

	case 'activar':
		$rspta=$terminoPago->activar($idTerminoPago);
 		echo $rspta ? "Tippo pago activada" : "Tipo pago no se puede activar";
	break;

	case 'mostrar':
		$rspta=$terminoPago->mostrar($idTerminoPago);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$terminoPago->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			if ($reg->tipo == 0) {
 			 $tipo = 'INGRESA COMO DINERO';
 			}else{
 			 $tipo = 'NO INGRESA COMO DINERO';
 			}


 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idTerminoPago.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idTerminoPago.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idTerminoPago.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idTerminoPago.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->descripcion,
 				"2"=>$tipo,
 				"3"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
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


	case "selectTerminoPago":

		$rspta = $terminoPago->selectTerminoPago();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idTerminoPago. '>' .$reg->descripcion. '</option>';
		}

		break;


	case "selectTerminoPagoPersona":

		$rspta = $terminoPago->selectTerminoPagoPersona($_POST['idPersona']);

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idTerminoPago. '>' .$reg->descripcion. '</option>';
		}

		break;


	case 'contado':
		$rspta=$terminoPago->contado($idTerminoPago);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;


}
?>