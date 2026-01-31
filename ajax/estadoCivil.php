<?php 
require_once "../modelos/EstadoCivil.php";

$estadoCivil=new EstadoCivil();

$idEstadoCivil=isset($_POST["idEstadoCivil"])? limpiarCadena($_POST["idEstadoCivil"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

 
switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idEstadoCivil)){
			$rspta=$estadoCivil->insertar($descripcion);
			echo $rspta ? "Estado Civil registrado" : "Estado Civil no se pudo registrar";
		}
		else {
			$rspta=$estadoCivil->editar($idEstadoCivil,$descripcion);
			echo $rspta ? "Estado Civil actualizado" : "Estado Civil no se pudo actualizar";
		}
	break;

	case 'mostrar':
		$rspta=$estadoCivil->mostrar($idEstadoCivil);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'desactivar':
		$rspta=$estadoCivil->desactivar($idEstadoCivil);
 		echo $rspta ? "Estado Civil Desactivado" : "Estado Civil no se puede desactivar";
	break;

	case 'activar':
		$rspta=$estadoCivil->activar($idEstadoCivil);
 		echo $rspta ? "Estado Civil activado" : "Estado Civil no se puede activar";
	break;


	case 'listar':
		$rspta=$estadoCivil->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idEstadoCivil.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idEstadoCivil.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idEstadoCivil.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idEstadoCivil.')"><i class="fa fa-check"></i></button>',
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

	case "selectEstadoCivil":

		$rspta = $estadoCivil->selectEstadoCivil();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idEstadoCivil. '>' .$reg->descripcion. '</option>';
		}

		break;
	

}
?>