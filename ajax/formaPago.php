<?php 
require_once "../modelos/FormaPago.php";

$fp=new FormaPago();

$idFormaPago=isset($_POST["idFormaPago"])? limpiarCadena($_POST["idFormaPago"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$tipo=isset($_POST["tipo"])? limpiarCadena($_POST["tipo"]):"";
$CuentaContable_idCuentaContable=isset($_POST["CuentaContable_idCuentaContable"])? limpiarCadena($_POST["CuentaContable_idCuentaContable"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idFormaPago)){
			$rspta=$fp->insertar($descripcion,$tipo,$CuentaContable_idCuentaContable);
			echo $rspta ? "fp registrada" : "fp no se pudo registrar";
		}
		else {
			$rspta=$fp->editar($idFormaPago,$descripcion,$tipo,$CuentaContable_idCuentaContable);
			echo $rspta ? "fp actualizada" : "fp no se pudo actualizar";
		}
	break;

	case 'mostrar':
		$rspta=$fp->mostrar($idFormaPago);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'desactivar':
		$rspta=$fp->desactivar($idFormaPago);
 		echo $rspta ? "fp Desactivado" : "fp no se puede desactivar";
	break;

	case 'activar':
		$rspta=$fp->activar($idFormaPago);
 		echo $rspta ? "fp activado" : "fp no se puede activar";
	break;


	case 'listar':
		$rspta=$fp->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idFormaPago.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idFormaPago.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idFormaPago.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idFormaPago.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->descripcion,
 				"2"=>$reg->tipo,
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

	case "selectFormaPago":

		$rspta = $fp->selectFormaPago();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idFormaPago. '>' .$reg->descripcion. '</option>';
		}

		break;

}
?>