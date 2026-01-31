<?php 
require_once "../modelos/Concepto.php";

$concepto=new Concepto();

$idConcepto=isset($_POST["idConcepto"])? limpiarCadena($_POST["idConcepto"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$tipo=isset($_POST["tipo"])? limpiarCadena($_POST["tipo"]):"";
$CtaCorriente=isset($_POST["CtaCorriente"])? limpiarCadena($_POST["CtaCorriente"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idConcepto)){
			$rspta=$concepto->insertar($descripcion,$tipo,$CtaCorriente);
			echo $rspta ? "concepto registrado" : "concepto no se pudo registrar";
		}
		else {
			$rspta=$concepto->editar($idConcepto,$descripcion,$tipo, $CtaCorriente);
			echo $rspta ? "concepto actualizado" : "concepto no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$concepto->desactivar($idConcepto);
 		echo $rspta ? "concepto Desactivado" : "concepto no se puede desactivar";
	break;

	case 'activar':
		$rspta=$concepto->activar($idConcepto);
 		echo $rspta ? "concepto activado" : "concepto no se puede activar";
	break;

	case 'mostrar':
		$rspta=$concepto->mostrar($idConcepto);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$concepto->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idConcepto.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idConcepto.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idConcepto.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idConcepto.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->descripcion,
 				"2"=>$reg->tipo,
 				"3"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>',
 				"4"=>($reg->CtaCorriente)?'<span class="label bg-green">Si</span>':
 				'<span class="label bg-red">No</span>'
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