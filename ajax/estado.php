<?php 
require_once "../modelos/Estado.php";

$estado=new Estado();

$idEstado=isset($_POST["idEstado"])? limpiarCadena($_POST["idEstado"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idEstado)){
			$rspta=$estado->insertar($descripcion);
			echo $rspta ? "Estado registrado" : "Estado no se pudo registrar";  
		}
		else {
			$rspta=$estado->editar($idEstado,$descripcion);
			echo $rspta ? "Estado actualizado" : "Estado no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$estado->desactivar($idEstado);
 		echo $rspta ? "Estado Desactivado" : "Estado no se puede desactivar";
	break;

	case 'activar':
		$rspta=$estado->activar($idEstado);
 		echo $rspta ? "Estado activado" : "Estado no se puede activar";
	break;

	case 'mostrar':
		$rspta=$estado->mostrar($idEstado);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$estado->listar();
 		//Vamos a declarar un array
 		$data= Array();
 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idEstado.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idEstado.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idEstado.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idEstado.')"><i class="fa fa-check"></i></button>',
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


}
?>