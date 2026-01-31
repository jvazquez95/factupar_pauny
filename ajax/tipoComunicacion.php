<?php 
require_once "../modelos/TipoComunicacion.php";

$tipoComunicacion=new TipoComunicacion();

$idTipoComunicacion=isset($_POST["idTipoComunicacion"])? limpiarCadena($_POST["idTipoComunicacion"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

 
switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idTipoComunicacion)){
			$rspta=$tipoComunicacion->insertar($descripcion);
			echo $rspta ? "tipoComunicacion registrado" : "tipoComunicacion no se pudo registrar";
		}
		else {
			$rspta=$tipoComunicacion->editar($idTipoComunicacion,$descripcion);
			echo $rspta ? "tipoComunicacion actualizado" : "tipoComunicacion no se pudo actualizar";
		}
	break;

	case 'mostrar':
		$rspta=$tipoComunicacion->mostrar($idTipoComunicacion);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'desactivar':
		$rspta=$tipoComunicacion->desactivar($idTipoComunicacion);
 		echo $rspta ? "tipoComunicacion Desactivado" : "tipoComunicacion no se puede desactivar";
	break;

	case 'activar':
		$rspta=$tipoComunicacion->activar($idTipoComunicacion);
 		echo $rspta ? "tipoComunicacion activado" : "tipoComunicacion no se puede activar";
	break;


	case 'listar':
		$rspta=$tipoComunicacion->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idTipoComunicacion.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idTipoComunicacion.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idTipoComunicacion.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idTipoComunicacion.')"><i class="fa fa-check"></i></button>',
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

	case "selectTipoComunicacion":

		$rspta = $tipoComunicacion->selectTipoComunicacion();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idTipoComunicacion. '>' .$reg->descripcion. '</option>';
		}

		break;
	

}
?>