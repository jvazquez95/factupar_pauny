<?php 
require_once "../modelos/Sucursal.php";

$sucursal=new Sucursal();

$idSucursal=isset($_POST["idSucursal"])? limpiarCadena($_POST["idSucursal"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$correo=isset($_POST["correo"])? limpiarCadena($_POST["correo"]):"";
$ciudad=isset($_POST["ciudad"])? limpiarCadena($_POST["ciudad"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idSucursal)){
			$rspta=$sucursal->insertar($nombre, $direccion, $telefono, $correo, $ciudad);
			echo $rspta ? "Sucursal registrada" : "Sucursal no se pudo registrar";
		}
		else {
			$rspta=$sucursal->editar($idSucursal, $nombre, $direccion, $telefono, $correo, $ciudad);
			echo $rspta ? "Sucursal actualizada" : "Sucursal no se pudo actualizar";
		}
	break;

	case 'mostrar':
		$rspta=$sucursal->mostrar($idSucursal);
 		echo json_encode($rspta);
	break;

	case 'desactivar':
		$rspta=$sucursal->desactivar($idSucursal);
 		echo $rspta ? "Sucursal Desactivada" : "Sucursal no se puede desactivar";
	break;

	case 'activar':
		$rspta=$sucursal->activar($idSucursal);
 		echo $rspta ? "Sucursal activada" : "Sucursal no se puede activar";
	break;

	case 'listar':
		$rspta=$sucursal->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idSucursal.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idSucursal.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idSucursal.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idSucursal.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombre,
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



	case "selectSucursalTodos":

		$rspta = $sucursal->selectSucursal();
			echo '<option value="%%">Todas las sucursales</option>';
		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idSucursal. '>' .$reg->nombre. '</option>';
		}

		break;


	case "selectSucursal":

		$rspta = $sucursal->selectSucursal();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idSucursal. '>' .$reg->nombre. '</option>';
		}

		break;

}
?>