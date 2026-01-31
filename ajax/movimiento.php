<?php
require_once "../modelos/Movimiento.php";
$movimiento=new Movimiento();

$idMovimiento=isset($_POST['idMovimiento'])?limpiarCadena($_POST['idMovimiento']):"";
$descripcion=isset($_POST['descripcion'])?limpiarCadena($_POST['descripcion']):"";
$monto=isset($_POST['monto'])?limpiarCadena($_POST['monto']):"";
$idConcepto=isset($_POST['idConcepto'])?limpiarCadena($_POST['idConcepto']):"";
$habilitacion=isset($_POST['habilitacion'])?limpiarCadena($_POST['habilitacion']):"";
$Empleado_idEmpleado=isset($_POST['Cliente_idCliente'])?limpiarCadena($_POST['Cliente_idCliente']):"";
$TerminoPago_idTerminoPago=isset($_POST['TerminoPago_idTerminoPago'])?limpiarCadena($_POST['TerminoPago_idTerminoPago']):"";
$precioUnitario=isset($_POST['precioUnitario'])?limpiarCadena($_POST['precioUnitario']):"";
$cantidad=isset($_POST['cantidad'])?limpiarCadena($_POST['cantidad']):"";

switch ($_GET['op']) {
	case 'guardaryeditar':
		if (empty($idMovimiento)) {
			$rspta=$movimiento->insertar($descripcion, $monto,$idConcepto,$habilitacion,$Empleado_idEmpleado,$TerminoPago_idTerminoPago, $cantidad, $precioUnitario);
			echo $rspta ? "movimiento registrado" : "Movimiento no se pudo registrar";
		}
		else
		{
			$rspta=$movimiento->editar($idMovimiento,$descripcion, $monto,$idConcepto,$habilitacion, $cantidad, $precioUnitario);
			echo $rspta ? "movimiento actualizada" : "movimiento no se pudo editar";

		}
		break;
	
	case 'mostrar':
		$rspta=$movimiento->mostrar($idMovimiento);
		//codificar el resultado utilizando json
		echo json_encode($rspta);
		break;
	
	case 'desactivar':
		$rspta=$movimiento->desactivar($idMovimiento);
 		echo $rspta ? "Movimiento Desactivado" : "Movimiento no se puede desactivar";
	break;

	case 'activar':
		$rspta=$movimiento->activar($idMovimiento);
 		echo $rspta ? "Movimiento activado" : "Movimiento no se puede activar";
	break;


case 'listar':
 


		$habilitacion = $_REQUEST['habilitacion'];
		$rspta=$movimiento->listar($habilitacion);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
"0"=>(!$reg->mi)?''.
 					' <button class="btn btn-danger" onclick="cerrar('.$reg->idMovimiento.')">Anular movimiento <i class="fa fa-sign-out"></i></button> <button class="btn btn-primary" onclick="reporte('.$reg->idMovimiento.')">Imprimir comprobante <i class="fa fa-sign-out"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar1('.$reg->idMovimiento.')">Ver  <i class="fa fa-eye"></i></button>',
 				"1"=>$reg->idMovimiento,
				"2"=>$reg->habilitacion,
				"3"=>$reg->fechaTransaccion,
				"4"=>$reg->md,
				"5"=>$reg->nc,
				"6"=>$reg->usuario,
				"7"=>number_format($reg->cantidad,0,',','.') ,
				"8"=>number_format($reg->precioUnitario,0,',','.') ,
				"9"=>number_format($reg->monto,0,',','.') . ' | ' . $reg->dfp,
				"10"=>(!$reg->mi)?'<span class="label bg-green">Habilitado</span>':
 				'<span class="label bg-red">Cerrado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case "selectConcepto":
		require_once "../modelos/Concepto.php";
		$concepto = new Concepto();

		$rspta = $concepto->select();
			echo '<option value="0">Todos los conceptos</option>';

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idConcepto. '>' .$reg->descripcion. '</option>';
		}

		break;

}


?>