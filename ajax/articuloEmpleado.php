<?php
require_once "../modelos/ArticuloEmpleado.php";
$articuloEmpleado=new ArticuloEmpleado();

$idArticuloEmpleado=isset($_POST['idArticuloEmpleado'])?limpiarCadena($_POST['idArticuloEmpleado']):"";
$Empleado_idEmpleado=isset($_POST['Empleado_idEmpleado'])?limpiarCadena($_POST['Empleado_idEmpleado']):"";
$Articulo_idArticulo=isset($_POST['Articulo_idArticulo'])?limpiarCadena($_POST['Articulo_idArticulo']):"";
$Deposito_idDeposito=isset($_POST['Deposito_idDeposito'])?limpiarCadena($_POST['Deposito_idDeposito']):"";
$tipo=isset($_POST['tipo'])?limpiarCadena($_POST['tipo']):"";
$cantidad=isset($_POST['cantidad'])?limpiarCadena($_POST['cantidad']):"";

switch ($_GET['op']) {
	case 'guardaryeditar':
		if (empty($idArticuloEmpleado)) {
			$rspta=$articuloEmpleado->insertar($Empleado_idEmpleado, $Articulo_idArticulo,$Deposito_idDeposito,$tipo,$cantidad);
			echo $rspta ? "Transaccion registrada" : "Transaccion no se pudo registrar";
		}
		else
		{
			$rspta=$articuloEmpleado->editar($idArticuloEmpleado,$descripcion, $monto,$idConcepto,$habilitacion);
			echo $rspta ? "articuloEmpleado actualizada" : "articuloEmpleado no se pudo editar";

		}
		break;
	
	case 'mostrar':
		$rspta=$articuloEmpleado->mostrar($idArticuloEmpleado);
		//codificar el resultado utilizando json
		echo json_encode($rspta);
		break;
	
	case 'desactivar':
		$rspta=$articuloEmpleado->desactivar($idArticuloEmpleado);
 		echo $rspta ? "articuloEmpleado Desactivado" : "articuloEmpleado no se puede desactivar";
	break;

	case 'activar':
		$rspta=$articuloEmpleado->activar($idArticuloEmpleado);
 		echo $rspta ? "articuloEmpleado activado" : "articuloEmpleado no se puede activar";
	break;


case 'listar':
		$rspta=$articuloEmpleado->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
				"0"=>(!$reg->aei)?''.
 					' <button class="btn btn-danger" onclick="cerrar('.$reg->idArticuloEmpleado.')">Anular articuloEmpleado <i class="fa fa-sign-out"></i></button>':'',
 				"1"=>$reg->idArticuloEmpleado,
				"2"=>$reg->ne,
				"3"=>$reg->na,
				"4"=>$reg->nd,
				"5"=>$reg->tipo,
				"6"=>$reg->cantidad,
				"7"=>$reg->fechaTransaccion,
				"8"=>$reg->UsuarioIns,
				"9"=>(!$reg->aei)?'<span class="label bg-green">Activo</span>':
 				'<span class="label bg-red">Anulado</span>'
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
		require_once "../modelos/concepto.php";
		$concepto = new Concepto();

		$rspta = $concepto->select();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idConcepto. '>' .$reg->descripcion. '</option>';
		}

		break;

}


?>