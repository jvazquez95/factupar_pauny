<?php 
require_once "../modelos/Clase.php";

$clase=new Clase();

$idClase=isset($_POST["idClase"])? limpiarCadena($_POST["idClase"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

 
switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idClase)){
			$rspta=$clase->insertar($descripcion);
			echo $rspta ? "clase registrado" : "clase no se pudo registrar";
		}
		else {
			$rspta=$clase->editar($idClase,$descripcion);
			echo $rspta ? "clase actualizado" : "clase no se pudo actualizar";
		}
	break;

	case 'mostrar':
		$rspta=$clase->mostrar($idClase);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'desactivar':
		$rspta=$clase->desactivar($idClase);
 		echo $rspta ? "clase Desactivado" : "clase no se puede desactivar";
	break;

	case 'activar':
		$rspta=$clase->activar($idClase);
 		echo $rspta ? "clase activado" : "clase no se puede activar";
	break;


	case 'listar':
		$rspta=$clase->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idClase.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idClase.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idClase.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idClase.')"><i class="fa fa-check"></i></button>',
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

	case "selectClase":

		$rspta = $clase->selectClase();

			echo '<option value="">Seleccione una opcion</option>';
		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idClase. '>' .$reg->descripcion. '</option>';
		}

		break;
	

}
?>