<?php 
require_once "../modelos/TipoLiquidacion.php";

$tipoLiquidacion=new TipoLiquidacion();

$idTipoLiquidacion=isset($_POST["idTipoLiquidacion"])? limpiarCadena($_POST["idTipoLiquidacion"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

 
switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idTipoLiquidacion)){
			$rspta=$tipoLiquidacion->insertar($descripcion);
			echo $rspta ? "tipoLiquidacion registrado" : "tipoLiquidacion no se pudo registrar";
		}
		else {
			$rspta=$tipoLiquidacion->editar($idTipoLiquidacion,$descripcion);
			echo $rspta ? "tipoLiquidacion actualizado" : "tipoLiquidacion no se pudo actualizar";
		}
	break;

	case 'mostrar':
		$rspta=$tipoLiquidacion->mostrar($idTipoLiquidacion);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'desactivar':
		$rspta=$tipoLiquidacion->desactivar($idTipoLiquidacion);
 		echo $rspta ? "tipoLiquidacion Desactivado" : "tipoLiquidacion no se puede desactivar";
	break;

	case 'activar':
		$rspta=$tipoLiquidacion->activar($idTipoLiquidacion);
 		echo $rspta ? "tipoLiquidacion activado" : "tipoLiquidacion no se puede activar";
	break;


	case 'listar':
		$rspta=$tipoLiquidacion->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idTipoLiquidacion.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idTipoLiquidacion.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idTipoLiquidacion.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idTipoLiquidacion.')"><i class="fa fa-check"></i></button>',
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

	case "selectTipoLiquidacion":

		$rspta = $tipoLiquidacion->selecttipoLiquidacion();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idTipoLiquidacion. '>' .$reg->descripcion. '</option>';
		}

		break;
	

}
?>