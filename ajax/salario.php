<?php 
require_once "../modelos/Salario.php";

$salario=new Salario();

$idSalario=isset($_POST["idSalario"])? limpiarCadena($_POST["idSalario"]):"";
$Legajo_idLegajo=isset($_POST["Legajo_idLegajo"])? limpiarCadena($_POST["Legajo_idLegajo"]):"";
$TipoSalario_idTipoSalario=isset($_POST["TipoSalario_idTipoSalario"])? limpiarCadena($_POST["TipoSalario_idTipoSalario"]):"";
$fechaInicio=isset($_POST["fechaInicio"])? limpiarCadena($_POST["fechaInicio"]):"";
$fechaFin=isset($_POST["fechaFin"])? limpiarCadena($_POST["fechaFin"]):"";
$monto=isset($_POST["monto"])? limpiarCadena($_POST["monto"]):"";
$Moneda_idMoneda=isset($_POST["Moneda_idMoneda"])? limpiarCadena($_POST["Moneda_idMoneda"]):"";
$autorizado=isset($_POST["autorizado"])? limpiarCadena($_POST["autorizado"]):"";
$autorizadoPorUsuario=isset($_POST["autorizadoPorUsuario"])? limpiarCadena($_POST["autorizadoPorUsuario"]):"";

 
switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idSalario)){
			$rspta=$salario->insertar($Legajo_idLegajo,$TipoSalario_idTipoSalario,$fechaInicio,$fechaFin,$monto,$Moneda_idMoneda,$autorizado,$autorizadoPorUsuario);
			echo $rspta ? "salario registrado" : "salario no se pudo registrar";
		}
		else {
			$rspta=$salario->editar($idSalario,$Legajo_idLegajo,$TipoSalario_idTipoSalario,$fechaInicio,$fechaFin,$monto,$Moneda_idMoneda,$autorizado,$autorizadoPorUsuario);
			echo $rspta ? "salario actualizado" : "salario no se pudo actualizar";
		}
	break;

	case 'mostrar':
		$rspta=$salario->mostrar($idSalario);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'desactivar':
		$rspta=$salario->desactivar($idSalario);
 		echo $rspta ? "salario Desactivado" : "salario no se puede desactivar";
	break;

	case 'activar':
		$rspta=$salario->activar($idSalario);
 		echo $rspta ? "salario activado" : "salario no se puede activar";
	break;


	case 'listar':
		$rspta=$salario->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idSalario.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idSalario.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idSalario.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idSalario.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombreLegajo,
 				"2"=>$reg->nombreSalario,
 				"3"=>$reg->fechaInicio,
 				"4"=>$reg->fechaFin,
 				"5"=>number_format($reg->monto),
 				"6"=>$reg->nombreMoneda,
 				"7"=>$reg->autorizado,
 				"8"=>$reg->autorizadoPorUsuario,
 				"9"=>$reg->usuarioInsercion,
 				"10"=>$reg->fechaInsercion,
 				"11"=>$reg->usuarioModificacion,
 				"12"=>$reg->fechaModificacion,
 				"13"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
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

	case "selectSalario":

		$rspta = $salario->selectSalario();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idSalario. '>' .$reg->descripcion. '</option>';
		}

		break;
	

}
?>