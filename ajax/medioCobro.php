<?php 
require_once "../modelos/MedioCobro.php";

$medioCobro=new MedioCobro();

$idMedioCobro=isset($_POST["idMedioCobro"])? limpiarCadena($_POST["idMedioCobro"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

 
switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idMedioCobro)){
			$rspta=$medioCobro->insertar($descripcion);
			echo $rspta ? "medioCobro registrado" : "medioCobro no se pudo registrar";
		}
		else {
			$rspta=$medioCobro->editar($idMedioCobro,$descripcion);
			echo $rspta ? "medioCobro actualizado" : "medioCobro no se pudo actualizar";
		}
	break;

	case 'mostrar':
		$rspta=$medioCobro->mostrar($idMedioCobro);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'desactivar':
		$rspta=$medioCobro->desactivar($idMedioCobro);
 		echo $rspta ? "medioCobro Desactivado" : "medioCobro no se puede desactivar";
	break;

	case 'activar':
		$rspta=$medioCobro->activar($idMedioCobro);
 		echo $rspta ? "medioCobro activado" : "medioCobro no se puede activar";
	break;


	case 'listar':
		$rspta=$medioCobro->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idMedioCobro.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idMedioCobro.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idMedioCobro.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idMedioCobro.')"><i class="fa fa-check"></i></button>',
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

	case "selectMedioCobro":

		$rspta = $medioCobro->selectMedioCobro();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idMedioCobro. '>' .$reg->descripcion. '</option>';
		}

		break;
	

}
?>