<?php 
require_once "../modelos/TipoContrato.php";

$tipoContrato=new TipoContrato();

$idTipoContrato=isset($_POST["idTipoContrato"])? limpiarCadena($_POST["idTipoContrato"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

 
switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idTipoContrato)){
			$rspta=$tipoContrato->insertar($descripcion);
			echo $rspta ? "tipoContrato registrado" : "tipoContrato no se pudo registrar";
		}
		else {
			$rspta=$tipoContrato->editar($idTipoContrato,$descripcion);
			echo $rspta ? "tipoContrato actualizado" : "tipoContrato no se pudo actualizar";
		}
	break;

	case 'mostrar':
		$rspta=$tipoContrato->mostrar($idTipoContrato);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'desactivar':
		$rspta=$tipoContrato->desactivar($idTipoContrato);
 		echo $rspta ? "tipoContrato Desactivado" : "tipoContrato no se puede desactivar";
	break;

	case 'activar':
		$rspta=$tipoContrato->activar($idTipoContrato);
 		echo $rspta ? "tipoContrato activado" : "tipoContrato no se puede activar";
	break;


	case 'listar':
		$rspta=$tipoContrato->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idTipoContrato.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idTipoContrato.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idTipoContrato.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idTipoContrato.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->descripcion,
 				"2"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
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

	case "selectTipoContrato":

		$rspta = $tipoContrato->selectTipoContrato();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idTipoContrato. '>' .$reg->descripcion. '</option>';
		}

		break;
	

}
?>