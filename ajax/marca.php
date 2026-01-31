<?php 
require_once "../modelos/Marca.php";

$marca=new Marca();

$idMarca=isset($_POST["idMarca"])? limpiarCadena($_POST["idMarca"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$origen=isset($_POST["origen"])? limpiarCadena($_POST["origen"]):"";
$tipoMarca=isset($_POST["tipoMarca"])? limpiarCadena($_POST["tipoMarca"]):""; 
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idMarca)){
			$rspta=$marca->insertar($descripcion,$origen,$tipoMarca,$imagen);
			echo $rspta ? "marca registrada" : "marca no se pudo registrar";
		}
		else {
			$rspta=$marca->editar($idMarca,$descripcion,$origen,$tipoMarca,$imagen);
			echo $rspta ? "marca actualizada" : "marca no se pudo actualizar";
		}
	break; 

	case 'mostrar':
		$rspta=$marca->mostrar($idMarca);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'desactivar':
		$rspta=$marca->desactivar($idMarca);
 		echo $rspta ? "marca Desactivado" : "marca no se puede desactivar";
	break;

	case 'activar':
		$rspta=$marca->activar($idMarca);
 		echo $rspta ? "marca activado" : "marca no se puede activar";
	break;


	case 'listar':
		$rspta=$marca->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idMarca.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idMarca.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idMarca.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idMarca.')"><i class="fa fa-check"></i></button>',
 				"1"=>utf8_encode($reg->descripcion),
 				"2"=>$reg->origen,
 				"3"=>$reg->tipoMarca,
 				"4"=>$reg->imagen, 
 				"5"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
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

	case "selectMarca":

		$rspta = $marca->selectMarca();
		echo '<option value="%%">Todos...</option>';
		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idMarca. '>' .$reg->descripcion. '</option>';
		}

	break;


	case "selectMarcaTodos":

		$rspta = $marca->selectMarca();
		//echo '<option value="999">Todos...</option>';
		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idMarca. '>' .$reg->descripcion. '</option>';
		}

	break;


}
?>