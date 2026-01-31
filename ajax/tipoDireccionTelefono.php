<?php 
require_once "../modelos/TipoDireccionTelefono.php";

$tipoDireccionTelefono=new TipoDireccionTelefono();

$idTipoDireccion_Telefono=isset($_POST["idTipoDireccion_Telefono"])? limpiarCadena($_POST["idTipoDireccion_Telefono"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$tipo=isset($_POST["tipo"])? limpiarCadena($_POST["tipo"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idTipoDireccion_Telefono)){
			$rspta=$tipoDireccionTelefono->insertar($descripcion, $tipo);
			echo $rspta ? "tipoDireccionTelefono registrada" : "tipoDireccionTelefono no se pudo registrar";
		}
		else {
			$rspta=$tipoDireccionTelefono->editar($idTipoDireccion_Telefono, $descripcion, $tipo);
			echo $rspta ? "tipoDireccionTelefono actualizada" : "tipoDireccionTelefono no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$tipoDireccionTelefono->desactivar($idTipoDireccion_Telefono);
 		echo $rspta ? "tipoDireccionTelefono Desactivada" : "tipoDireccionTelefono no se puede desactivar";
	break;

	case 'activar':
		$rspta=$tipoDireccionTelefono->activar($idTipoDireccion_Telefono);
 		echo $rspta ? "tipoDireccionTelefono activada" : "tipoDireccionTelefono no se puede activar";
	break;

	case 'mostrar':
		$rspta=$tipoDireccionTelefono->mostrar($idTipoDireccion_Telefono);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$tipoDireccionTelefono->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			
 		if ($reg->tipo == 'D') {
 			$l_tipo = 'Direccion';
 		}

 		if ($reg->tipo == 'T') {
 			$l_tipo = 'Telefono';
 		}

 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idTipoDireccion_Telefono.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idTipoDireccion_Telefono.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idTipoDireccion_Telefono.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idTipoDireccion_Telefono.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->descripcion,
 				"2"=>$l_tipo,
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


	case "selectTipoDireccionTelefono":

		$rspta = $tipoDireccionTelefono->selectTipoDireccionTelefono();
		if ($rspta !== false) {
			while ($reg = $rspta->fetchObject()) {
				$id = isset($reg->idTipoDireccion_Telefono) ? intval($reg->idTipoDireccion_Telefono) : '';
				$desc = isset($reg->descripcion) ? htmlspecialchars($reg->descripcion) : '';
				echo '<option value="' . $id . '">' . $desc . '</option>';
			}
		}

		break;



}
?>