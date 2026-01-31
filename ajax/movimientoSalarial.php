<?php 
require_once "../modelos/MovimientoSalarial.php";

$movimientoSalarial = new MovimientoSalarial();

$idMovimientoSalarial=isset($_POST["idMovimientoSalarial"])? limpiarCadena($_POST["idMovimientoSalarial"]):"";
$Legajo_idLegajo=isset($_POST["Legajo_idLegajo"])? limpiarCadena($_POST["Legajo_idLegajo"]):"";
$ConceptoSalario_idConceptoSalario=isset($_POST["ConceptoSalario_idConceptoSalario"])? limpiarCadena($_POST["ConceptoSalario_idConceptoSalario"]):"";
$TipoSalario_idTipoSalario=isset($_POST["TipoSalario_idTipoSalario"])? limpiarCadena($_POST["TipoSalario_idTipoSalario"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$monto=isset($_POST["monto"])? limpiarCadena($_POST["monto"]):"";
$fechaMovimientoSalarial=isset($_POST["fechaMovimientoSalarial"])? limpiarCadena($_POST["fechaMovimientoSalarial"]):"";


 
switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idMovimientoSalarial)){
			$rspta=$movimientoSalarial->insertar($Legajo_idLegajo,$ConceptoSalario_idConceptoSalario,$TipoSalario_idTipoSalario,$descripcion,$monto,$fechaMovimientoSalarial);
			echo $rspta ? "movimientoSalarial registrado" : "movimientoSalarial no se pudo registrar";
		}
		else {
			$rspta=$movimientoSalarial->editar($idMovimientoSalarial,$Legajo_idLegajo,$ConceptoSalario_idConceptoSalario,$TipoSalario_idTipoSalario,$descripcion,$monto,$fechaMovimientoSalarial);
			echo $rspta ? "movimientoSalarial actualizado" : "movimientoSalarial no se pudo actualizar";
		}
	break;

	case 'mostrar':
		$rspta=$movimientoSalarial->mostrar($idMovimientoSalarial);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'desactivar':
		$rspta=$movimientoSalarial->desactivar($idMovimientoSalarial);
 		echo $rspta ? "movimientoSalarial Desactivado" : "movimientoSalarial no se puede desactivar";
	break;

	case 'activar':
		$rspta=$movimientoSalarial->activar($idMovimientoSalarial);
 		echo $rspta ? "movimientoSalarial activado" : "movimientoSalarial no se puede activar";
	break;


	case 'listar':
		$rspta=$movimientoSalarial->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idMovimientoSalarial.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idMovimientoSalarial.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idMovimientoSalarial.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idMovimientoSalarial.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombreLegajo,
 				"2"=>$reg->nombreConceptoSalario,
 				"3"=>$reg->nombreTipoSalario,
 				"4"=>$reg->descripcion,
 				"5"=>number_format($reg->monto),
 				"6"=>$reg->fechaMovimientoSalarial,
 				"7"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
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

	case "selectMovimientoSalarial":

		$rspta = $movimientoSalarial->selectMovimientoSalarial();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idMovimientoSalarial. '>' .$reg->descripcion. '</option>';
		}

		break;
	

}
?>