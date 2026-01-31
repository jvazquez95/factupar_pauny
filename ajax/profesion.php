<?php 
require_once "../modelos/Profesion.php";

$profesion=new Profesion();

$idProfesion=isset($_POST["idProfesion"])? limpiarCadena($_POST["idProfesion"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

 
switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idProfesion)){
			$rspta=$profesion->insertar($descripcion);
			echo $rspta ? "profesion registrado" : "profesion no se pudo registrar";
		}
		else {
			$rspta=$profesion->editar($idProfesion,$descripcion);
			echo $rspta ? "profesion actualizado" : "profesion no se pudo actualizar";
		}
	break;

	case 'mostrar':
		$rspta=$profesion->mostrar($idProfesion);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'desactivar':
		$rspta=$profesion->desactivar($idProfesion);
 		echo $rspta ? "profesion Desactivado" : "profesion no se puede desactivar";
	break;

	case 'activar':
		$rspta=$profesion->activar($idProfesion);
 		echo $rspta ? "profesion activado" : "profesion no se puede activar";
	break;


	case 'listar':
		$rspta=$profesion->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idProfesion.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idProfesion.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idProfesion.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idProfesion.')"><i class="fa fa-check"></i></button>',
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

	case "selectProfesion":

		$rspta = $profesion->selectProfesion();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idProfesion. '>' .$reg->descripcion. '</option>';
		}

		break;
	

}
?>