<?php 
require_once "../modelos/Unidad.php";

$unidad=new Unidad();

$idUnidad=isset($_POST["idUnidad"])? limpiarCadena($_POST["idUnidad"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$cantidad=isset($_POST["cantidad"])? limpiarCadena($_POST["cantidad"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idUnidad)){
			$rspta=$unidad->insertar($descripcion, $cantidad);
			echo $rspta ? "Unidad registrada" : "Unidad no se pudo registrar";
		}
		else {
			$rspta=$unidad->editar($idUnidad,$descripcion, $cantidad);
			echo $rspta ? "Unidad actualizada" : "Unidad no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$unidad->desactivar($idUnidad);
 		echo $rspta ? "Unidad Desactivada" : "Unidad no se puede desactivar";
	break;

	case 'activar':
		$rspta=$unidad->activar($idUnidad);
 		echo $rspta ? "Unidad activada" : "Unidad no se puede activar";
	break;

	case 'mostrar':
		$rspta=$unidad->mostrar($idUnidad);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$unidad->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idUnidad.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idUnidad.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idUnidad.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idUnidad.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->descripcion,
 				"2"=>$reg->cantidad,
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
}
?>