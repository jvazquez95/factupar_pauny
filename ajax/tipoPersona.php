<?php 
require_once "../modelos/TipoPersona.php";

$tipopersona=new TipoPersona();

$idTipoPersona=isset($_POST["idTipoPersona"])? limpiarCadena($_POST["idTipoPersona"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idTipoPersona)){
			$rspta=$tipopersona->insertar($descripcion);
			echo $rspta ? "tipopersona registrada" : "tipopersona no se pudo registrar";
		}
		else {
			$rspta=$tipopersona->editar($idTipoPersona, $descripcion);
			echo $rspta ? "tipopersona actualizada" : "tipopersona no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$tipopersona->desactivar($idTipoPersona);
 		echo $rspta ? "tipopersona Desactivada" : "tipopersona no se puede desactivar";
	break;

	case 'activar':
		$rspta=$tipopersona->activar($idTipoPersona);
 		echo $rspta ? "tipopersona activada" : "tipopersona no se puede activar";
	break;

	case 'mostrar':
		$rspta=$tipopersona->mostrar($idTipoPersona);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$tipopersona->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idTipoPersona.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idTipoPersona.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idTipoPersona.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idTipoPersona.')"><i class="fa fa-check"></i></button>',
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

	case 'select':

		$rspta = $tipopersona->select();

		while ($reg = $rspta->fetchObject())
				{
				echo '<option value=' . $reg->idTipoPersona . '>' . $reg->descripcion . '</option>';
				}
	break;
	
	case 'selectTipoPersona':

		$rspta = $tipopersona->selectTipoPersona();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idTipoPersona. '>' .$reg->descripcion. '</option>';
		}

		break;

}
?>