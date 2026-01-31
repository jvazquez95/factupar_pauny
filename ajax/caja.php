<?php 
require_once "../modelos/Caja.php";

$caja=new Caja();

$idcaja=isset($_POST["idcaja"])? limpiarCadena($_POST["idcaja"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$Sucursal_idSucursal=isset($_POST["Sucursal_idSucursal"])? limpiarCadena($_POST["Sucursal_idSucursal"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idcaja)){
			$rspta=$caja->insertar($nombre,$Sucursal_idSucursal);
			echo $rspta ? "Caja registrada" : "Caja no se pudo registrar";
		}
		else {
			$rspta=$caja->editar($idcaja,$nombre,$Sucursal_idSucursal);
			echo $rspta ? "Caja actualizada" : "Caja no se pudo actualizar";
		}
	break;

	case 'mostrar':
		$rspta=$caja->mostrar($idcaja);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'desactivar':
		$rspta=$caja->desactivar($idcaja);
 		echo $rspta ? "Caja Desactivado" : "Caja no se puede desactivar";
	break;

	case 'activar':
		$rspta=$caja->activar($idcaja);
 		echo $rspta ? "Caja activado" : "Caja no se puede activar";
	break;


	case 'listar':
		$rspta=$caja->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->i)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idcaja.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idcaja.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idcaja.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idcaja.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nc,
 				"2"=>$reg->ns,
 				"3"=>(!$reg->i)?'<span class="label bg-green">Activado</span>':
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

	case "selectSucursal":
		require_once "../modelos/Sucursal.php";
		$sucursal = new Sucursal();

		$rspta = $sucursal->select();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idSucursal. '>' .$reg->nombre. '</option>';
		}

		break;

}
?>