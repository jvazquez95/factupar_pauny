<?php 
require_once "../modelos/TipoMovimiento.php";

$tipoMovimiento=new TipoMovimiento();

$idTipoMovimiento=isset($_POST["idTipoMovimiento"])? limpiarCadena($_POST["idTipoMovimiento"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

 
switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idTipoMovimiento)){
			$rspta=$tipoMovimiento->insertar($descripcion);
			echo $rspta ? "tipoMovimiento registrado" : "tipoMovimiento no se pudo registrar";
		}
		else {
			$rspta=$tipoMovimiento->editar($idTipoMovimiento,$descripcion);
			echo $rspta ? "tipoMovimiento actualizado" : "tipoMovimiento no se pudo actualizar";
		}
	break;

	case 'mostrar':
		$rspta=$tipoMovimiento->mostrar($idTipoMovimiento);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'desactivar':
		$rspta=$tipoMovimiento->desactivar($idTipoMovimiento);
 		echo $rspta ? "tipoMovimiento Desactivado" : "tipoMovimiento no se puede desactivar";
	break;

	case 'activar':
		$rspta=$tipoMovimiento->activar($idTipoMovimiento);
 		echo $rspta ? "tipoMovimiento activado" : "tipoMovimiento no se puede activar";
	break;


	case 'listar':
		$rspta=$tipoMovimiento->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idTipoMovimiento.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idTipoMovimiento.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idTipoMovimiento.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idTipoMovimiento.')"><i class="fa fa-check"></i></button>',
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

	case "selectTipoMovimiento":

		$rspta = $tipoMovimiento->selectTipoMovimiento();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idTipoMovimiento. '>' .$reg->descripcion. '</option>';
		}

		break;
	

}
?>