<?php 
require_once "../modelos/Deposito.php";

$deposito=new Deposito();

$idDeposito=isset($_POST["idDeposito"])? limpiarCadena($_POST["idDeposito"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$Sucursal_idSucursal=isset($_POST["Sucursal_idSucursal"])? limpiarCadena($_POST["Sucursal_idSucursal"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idDeposito)){
			$rspta=$deposito->insertar($Sucursal_idSucursal,$descripcion);
			echo $rspta ? "Deposito registrado" : "Deposito no se pudo registrar";
		}
		else {
			$rspta=$deposito->editar($idDeposito,$Sucursal_idSucursal,$descripcion);
			echo $rspta ? "Deposito actualizado" : "Deposito no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$deposito->desactivar($idDeposito);
 		echo $rspta ? "Deposito Desactivado" : "Deposito no se puede desactivar";
	break;

	case 'activar':
		$rspta=$deposito->activar($idDeposito);
 		echo $rspta ? "Deposito activado" : "Deposito no se puede activar";
	break;

	case 'mostrar':
		$rspta=$deposito->mostrar($idDeposito);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$deposito->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idDeposito.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idDeposito.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idDeposito.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idDeposito.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->descripcion,
 				"2"=>$reg->nombre,
 				"3"=>$reg->vehiculo,
 				"4"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
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

	case "selectDeposito":

		$rspta = $deposito->selectDeposito();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idDeposito. '>' .$reg->descripcion. '</option>';
		}

	break;

	//selectSucursalXDeposito
	case "selectSucursalXDeposito":
		$depositoD1=$_REQUEST["depositoD1"];
		$rspta = $deposito->selectSucursalXDeposito($depositoD1);
		echo json_encode($rspta);

	break;

	case "selectDepositoTodos":

		$rspta = $deposito->selectDeposito();

			echo '<option value="999">Todos</option>';


		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idDeposito. '>' .$reg->descripcion. '</option>';
		}

	break;





	case "selectSucursal":
		require_once "../modelos/Sucursal.php";
		$sucursal = new Sucursal();

		$rspta = $sucursal->selectSucursal();

		while ($reg = $rspta->fetchObject())
				{
					echo '<option value=' . $reg->idSucursal . '>' . $reg->nombre . '</option>';
				}
	break;

	case "selectVehiculo":
		require_once "../modelos/Deposito.php";
		$sucursal = new Deposito(); 

		$rspta = $sucursal->selectVehiculo();

		while ($reg = $rspta->fetchObject())
				{
					echo '<option value=' . $reg->idVehiculo . '>' . $reg->vehiculo . '</option>';
				}
	break;

}
?>