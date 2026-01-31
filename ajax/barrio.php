<?php 
require_once "../modelos/Barrio.php";

$barrio=new Barrio();

$idBarrio=isset($_POST["idBarrio"])? limpiarCadena($_POST["idBarrio"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$Ciudad_idCiudad=isset($_POST["Ciudad_idCiudad"])? limpiarCadena($_POST["Ciudad_idCiudad"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idBarrio)){
			$rspta=$barrio->insertar($descripcion,$Ciudad_idCiudad);
			echo $rspta ? "barrio registrada" : "barrio no se pudo registrar";
		}
		else {
			$rspta=$barrio->editar($idBarrio,$descripcion,$Ciudad_idCiudad);
			echo $rspta ? "barrio actualizada" : "barrio no se pudo actualizar";
		}
	break;

	case 'mostrar':
		$rspta=$barrio->mostrar($idBarrio);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'desactivar':
		$rspta=$barrio->desactivar($idBarrio);
 		echo $rspta ? "barrio Desactivado" : "barrio no se puede desactivar";
	break;

	case 'activar':
		$rspta=$barrio->activar($idBarrio);
 		echo $rspta ? "barrio activado" : "barrio no se puede activar";
	break;


	case 'listar':
		$rspta=$barrio->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->bi)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idBarrio.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idBarrio.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idBarrio.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idBarrio.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nb,
 				"2"=>$reg->nc,
 				"3"=>(!$reg->bi)?'<span class="label bg-green">Activado</span>':
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

	case "selectBarrio":

		$rspta = $barrio->selectBarrio();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idBarrio. '>' .$reg->descripcion. '</option>';
		}

		break;

}
?>