<?php 
require_once "../modelos/cabeceraCompra.php";

$cabeceraCompra=new cabeceraCompra();
$idCompra=isset($_POST["idCompra"])? limpiarCadena($_POST["idCompra"]):"";
$Persona_idPersona=isset($_POST["Persona_idPersona"])? limpiarCadena($_POST["Persona_idPersona"]):"";
$Deposito_idDeposito=isset($_POST["Deposito_idDeposito"])? limpiarCadena($_POST["Deposito_idDeposito"]):"";
$TerminoPago_idTerminoPago=isset($_POST["TerminoPago_idTerminoPago"])? limpiarCadena($_POST["TerminoPago_idTerminoPago"]):"";
$tipoCompra=isset($_POST["tipoCompra"])? limpiarCadena($_POST["tipoCompra"]):"";
$tipo_comprobante=isset($_POST["tipo_comprobante"])? limpiarCadena($_POST["tipo_comprobante"]):"";
$nroFactura=isset($_POST["nroFactura"])? limpiarCadena($_POST["nroFactura"]):"";
$fechaFactura=isset($_POST["fechaFactura"])? limpiarCadena($_POST["fechaFactura"]):"";
$fechaVencimiento=isset($_POST["fechaVencimiento"])? limpiarCadena($_POST["fechaVencimiento"]):"";
$timbrado=isset($_POST["timbrado"])? limpiarCadena($_POST["timbrado"]):"";
$vtoTimbrado=isset($_POST["vtoTimbrado"])? limpiarCadena($_POST["vtoTimbrado"]):"";
$Moneda_idMoneda=isset($_POST["Moneda_idMoneda"])? limpiarCadena($_POST["Moneda_idMoneda"]):"";
$tasaCambio=isset($_POST["tasaCambio"])? limpiarCadena($_POST["tasaCambio"]):"";
$tasaCambioBases=isset($_POST["tasaCambioBases"])? limpiarCadena($_POST["tasaCambioBases"]):"";
$totalImpuesto=isset($_POST["totalImpuesto"])? limpiarCadena($_POST["totalImpuesto"]):"";
$total=isset($_POST["total"])? limpiarCadena($_POST["total"]):"";
$totalNeto=isset($_POST["totalNeto"])? limpiarCadena($_POST["totalNeto"]):"";
$saldo=isset($_POST["saldo"])? limpiarCadena($_POST["saldo"]):"";
$CentroCosto_idCentroCosto=isset($_POST["CentroCosto_idCentroCosto"])? limpiarCadena($_POST["CentroCosto_idCentroCosto"]):"";
 
switch ($_GET["op"]){
	case 'guardaryeditar': 
		if (empty($idCompra)){
			
			echo $rspta ? "Cabecera Compra registrada" : "Cabecera Compra no se pudo registrar";  
		}
		else {
			$rspta=$cabeceraCompra->editar($idCompra,$Persona_idPersona,$Deposito_idDeposito,$TerminoPago_idTerminoPago,$tipoCompra,$tipo_comprobante,$nroFactura,$fechaFactura,$fechaVencimiento,$timbrado,$vtoTimbrado,$Moneda_idMoneda,$tasaCambio,$tasaCambioBases,$totalImpuesto,$total,$totalNeto,$saldo,$CentroCosto_idCentroCosto); 
			echo $rspta ? "Cabecera Compra actualizada" : "Cabecera Compra no se pudo actualizar"; 
		}
	break;

	case 'desactivar':
		$rspta=$cabeceraCompra->desactivar($idCompra);
 		echo $rspta ? "Cabecera Compra Desactivada" : "Cabecera Compra no se puede desactivar";
	break;

	case 'activar': 
		$rspta=$cabeceraCompra->activar($idCompra);
 		echo $rspta ? "Cabecera Compra activada" : "Cabecera Compra no se puede activar";
	break;

	case 'mostrar':

		$rspta=$cabeceraCompra->mostrar($idCompra);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$cabeceraCompra->listar();
 		//Vamos a declarar un array
 		$data= Array();
 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idCompra.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idCompra.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idCompra.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idCompra.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nroFactura,
 				"2"=>$reg->nombreComercial,
 				"3"=>$reg->fechaTransaccion,
 				"4"=>$reg->descripcion,
 				"5"=>$reg->fechaFactura,
 				"6"=>$reg->total,             
 				"7"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		//var_dump($results);
 		echo json_encode($results);

	break;

	case 'selectPersona':
		require_once "../modelos/Persona.php"; 
		$idPersona = new Persona();
		$rspta = $idPersona->selectProveedor(); 

		while ($reg = $rspta->fetchObject())
				{
				echo '<option value=' . $reg->idPersona . '>' . $reg->razonSocial . '</option>';
				}  
	break;

	case 'selectMoneda':	
		require_once "../modelos/Moneda.php"; 
		$idMoneda = new Moneda();
		$rspta = $idMoneda->select();

		while ($reg = $rspta->fetchObject()) 
				{
				echo '<option value=' . $reg->idMoneda . '>' . $reg->descripcion . '</option>';
				}
	break;
  
 
	case 'selectDeposito':  
		require_once "../modelos/Deposito.php";  
		$idDeposito = new Deposito();
		$rspta = $idDeposito->selectDeposito(); 

		while ($reg = $rspta->fetchObject())
				{
				echo '<option value=' . $reg->idDeposito . '>' . $reg->descripcion . '</option>';
				}  
	break;

	case 'selectCentroCosto':  
		require_once "../modelos/centroDeCostos.php";  
		$idCentroCosto = new CentroDeCostos();
		$rspta = $idCentroCosto->select(); 

		while ($reg = $rspta->fetchObject()) 
				{
				echo '<option value=' . $reg->idCentroCosto . '>' . $reg->descripcion . '</option>';
				}  
	break;	

	case 'selectTerminoPago':  
		require_once "../modelos/TerminoPago.php";  
		$idTerminoPago = new TerminoPago();
		$rspta = $idTerminoPago->selectTerminoPago(); 

		while ($reg = $rspta->fetchObject()) 
				{
				echo '<option value=' . $reg->idTerminoPago . '>' . $reg->descripcion . '</option>';
				}  
	break;	
}
?>