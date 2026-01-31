<?php 
require_once "../modelos/TipoImpuesto.php";

$TipoImpuesto=new TipoImpuesto();

$idTipoImpuesto=isset($_POST["idTipoImpuesto"])? limpiarCadena($_POST["idTipoImpuesto"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$porcentajeImpuesto=isset($_POST["porcentajeImpuesto"])? limpiarCadena($_POST["porcentajeImpuesto"]):"";

$CuentaContable_mercaderiaId=isset($_POST["CuentaContable_mercaderiaId"])? limpiarCadena($_POST["CuentaContable_mercaderiaId"]):"";
$CuentaContable_ventasMercaderiasId=isset($_POST["CuentaContable_ventasMercaderiasId"])? limpiarCadena($_POST["CuentaContable_ventasMercaderiasId"]):"";
$CuentaContable_costoMercaderiaId=isset($_POST["CuentaContable_costoMercaderiaId"])? limpiarCadena($_POST["CuentaContable_costoMercaderiaId"]):"";
$CuentaContable_impuestoId=isset($_POST["CuentaContable_impuestoId"])? limpiarCadena($_POST["CuentaContable_impuestoId"]):"";
$CuentaContable_servicioId=isset($_POST["CuentaContable_servicioId"])? limpiarCadena($_POST["CuentaContable_servicioId"]):"";
$CuentaContable_notaCreditoId=isset($_POST["CuentaContable_notaCreditoId"])? limpiarCadena($_POST["CuentaContable_notaCreditoId"]):"";
$CuentaContable_comprasId=isset($_POST["CuentaContable_comprasId"])? limpiarCadena($_POST["CuentaContable_comprasId"]):"";


switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idTipoImpuesto)){
			$rspta=$TipoImpuesto->insertar($descripcion,$porcentajeImpuesto, $CuentaContable_mercaderiaId,$CuentaContable_ventasMercaderiasId, $CuentaContable_costoMercaderiaId,$CuentaContable_impuestoId,$CuentaContable_servicioId, $CuentaContable_notaCreditoId, $CuentaContable_comprasId);
			echo $rspta ? "Impuesto registrado" : "Impuesto no se pudo registrar";
		}
		else {
			$rspta=$TipoImpuesto->editar($idTipoImpuesto,$descripcion,$porcentajeImpuesto, $CuentaContable_mercaderiaId,$CuentaContable_ventasMercaderiasId, $CuentaContable_costoMercaderiaId,$CuentaContable_impuestoId,$CuentaContable_servicioId, $CuentaContable_notaCreditoId, $CuentaContable_comprasId);
			echo $rspta ? "Impuesto actualizado" : "Impuesto no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$TipoImpuesto->desactivar($idTipoImpuesto);
 		echo $rspta ? "Impuesto Desactivada" : "Impuesto no se puede desactivar";
	break;

	case 'activar':
		$rspta=$TipoImpuesto->activar($idTipoImpuesto);
 		echo $rspta ? "Impuesto activada" : "Impuesto no se puede activar";
	break;

	case 'mostrar':
		$rspta=$TipoImpuesto->mostrar($idTipoImpuesto);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$TipoImpuesto->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idTipoImpuesto.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idTipoImpuesto.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idTipoImpuesto.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idTipoImpuesto.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->descripcion,
 				"2"=>$reg->porcentajeImpuesto,
 				"3"=>$reg->porcentajeRegimenTurismo,
 				"4"=>$reg->ccMercaderias,
 				"5"=>$reg->cccostoMercaderias,
 				"6"=>$reg->ccventasMercaderias,
 				"7"=>$reg->cciva,
 				"8"=>$reg->ccservicios,
 				"9"=>$reg->ccnc,
 				"10"=>$reg->cccompras,
 				"11"=>$reg->ccrt,
 				"12"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
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
}
?>