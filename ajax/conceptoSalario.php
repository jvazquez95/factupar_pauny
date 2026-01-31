<?php 
require_once "../modelos/ConceptoSalario.php";

$conceptoSalario=new ConceptoSalario();

$idConceptoSalario=isset($_POST["idConceptoSalario"])? limpiarCadena($_POST["idConceptoSalario"]):"";
$TipoLiquidacion_idTipoLiquidacion=isset($_POST["TipoLiquidacion_idTipoLiquidacion"])? limpiarCadena($_POST["TipoLiquidacion_idTipoLiquidacion"]):"";
$porcentaje=isset($_POST["porcentaje"])? limpiarCadena($_POST["porcentaje"]):"";
$esSalario=isset($_POST["esSalario"])? limpiarCadena($_POST["esSalario"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$TipoSalario_idTipoSalario=isset($_POST["TipoSalario_idTipoSalario"])? limpiarCadena($_POST["TipoSalario_idTipoSalario"]):"";
$tipo=isset($_POST["tipo"])? limpiarCadena($_POST["tipo"]):"";


 
switch ($_GET["op"]){
	case 'guardaryeditar':

		if (empty($idConceptoSalario)){
			$rspta=$conceptoSalario->insertar($TipoLiquidacion_idTipoLiquidacion,$porcentaje,$esSalario,$descripcion,$TipoSalario_idTipoSalario,$tipo);
			echo $rspta ? "conceptoSalario registrado" : "conceptoSalario no se pudo registrar";
		}
		else {
			$rspta=$conceptoSalario->editar($idConceptoSalario,$TipoLiquidacion_idTipoLiquidacion,$porcentaje,$esSalario,$descripcion,$TipoSalario_idTipoSalario,$tipo);
			echo $rspta ? "conceptoSalario actualizado" : "conceptoSalario no se pudo actualizar";
		}
	break;

	case 'mostrar':
		$rspta=$conceptoSalario->mostrar($idConceptoSalario);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'desactivar':
		$rspta=$conceptoSalario->desactivar($idConceptoSalario);
 		echo $rspta ? "conceptoSalario Desactivado" : "conceptoSalario no se puede desactivar";
	break;

	case 'activar':
		$rspta=$conceptoSalario->activar($idConceptoSalario);
 		echo $rspta ? "conceptoSalario activado" : "conceptoSalario no se puede activar";
	break;


	case 'listar':
		$rspta=$conceptoSalario->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			if ($reg->esSalario) {
 				$esSalario = 'Si';
 			}else{
 				$esSalario = 'No';
 			}

 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idConceptoSalario.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idConceptoSalario.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idConceptoSalario.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idConceptoSalario.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombreTipoLiquidacion,
 				"2"=>$reg->nombreTipoSalario,
 				"3"=>$reg->porcentaje,
 				"4"=>$esSalario,
 				"5"=>$reg->descripcion,
 				"6"=>$reg->tipo,
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

	case "selectConceptoSalario":

		$rspta = $conceptoSalario->selectConceptoSalario();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idConceptoSalario. '>' .$reg->descripcion. '</option>';
		}

		break;
	

}
?>