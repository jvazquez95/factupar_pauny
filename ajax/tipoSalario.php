<?php 
require_once "../modelos/TipoSalario.php";

$tipoSalario=new TipoSalario();

$idTipoSalario=isset($_POST["idTipoSalario"])? limpiarCadena($_POST["idTipoSalario"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

 
switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idTipoSalario)){
			$rspta=$tipoSalario->insertar($descripcion);
			echo $rspta ? "tipoSalario registrado" : "tipoSalario no se pudo registrar";
		}
		else {
			$rspta=$tipoSalario->editar($idTipoSalario,$descripcion);
			echo $rspta ? "tipoSalario actualizado" : "tipoSalario no se pudo actualizar";
		}
	break;

	case 'mostrar':
		$rspta=$tipoSalario->mostrar($idTipoSalario);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'desactivar':
		$rspta=$tipoSalario->desactivar($idTipoSalario);
 		echo $rspta ? "tipoSalario Desactivado" : "tipoSalario no se puede desactivar";
	break;

	case 'activar':
		$rspta=$tipoSalario->activar($idTipoSalario);
 		echo $rspta ? "tipoSalario activado" : "tipoSalario no se puede activar";
	break;


	case 'listar':
		$rspta=$tipoSalario->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idTipoSalario.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idTipoSalario.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idTipoSalario.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idTipoSalario.')"><i class="fa fa-check"></i></button>',
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

	case "selectTipoSalario":

		$rspta = $tipoSalario->selectTipoSalario();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idTipoSalario. '>' .$reg->descripcion. '</option>';
		}

		break;
	

}
?>