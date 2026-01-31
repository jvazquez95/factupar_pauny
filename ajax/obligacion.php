<?php 
require_once "../modelos/Obligacion.php";

$Obligacion=new Obligacion();

$idObligacion=isset($_POST["idObligacion"])? limpiarCadena($_POST["idObligacion"]):"";
$NroObligacion=isset($_POST["NroObligacion"])? limpiarCadena($_POST["NroObligacion"]):"";
$Persona_idPersona=isset($_POST["Persona_idPersona"])? limpiarCadena($_POST["Persona_idPersona"]):"";
$Moneda_idMoneda=isset($_POST["Moneda_idMoneda"])? limpiarCadena($_POST["Moneda_idMoneda"]):"";
$TipoDocumento_idTipoDocumento=isset($_POST["TipoDocumento_idTipoDocumento"])? limpiarCadena($_POST["TipoDocumento_idTipoDocumento"]):"";
$nroDocumento=isset($_POST["nroDocumento"])? limpiarCadena($_POST["nroDocumento"]):"";
$fechaDocumento=isset($_POST["fechaDocumento"])? limpiarCadena($_POST["fechaDocumento"]):"";
$fechaVencimiento=isset($_POST["fechaVencimiento"])? limpiarCadena($_POST["fechaVencimiento"]):"";
$fechaPosiblePago=isset($_POST["fechaPosiblePago"])? limpiarCadena($_POST["fechaPosiblePago"]):"";
$fechadePago=isset($_POST["fechadePago"])? limpiarCadena($_POST["fechadePago"]):"";
$Pago_idPago=isset($_POST["Pago_idPago"])? limpiarCadena($_POST["Pago_idPago"]):"";
$importe=isset($_POST["importe"])? limpiarCadena($_POST["importe"]):"";
$saldo=isset($_POST["saldo"])? limpiarCadena($_POST["saldo"]):""; 

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idObligacion)){
			$rspta=$Obligacion->insertar($NroObligacion,$Persona_idPersona,$Moneda_idMoneda,$TipoDocumento_idTipoDocumento,$nroDocumento,$fechaDocumento,$fechaVencimiento,$fechaPosiblePago,$fechadePago,$Pago_idPago,$importe,$saldo);
			echo $rspta ? "Obligacion registrada" : "Obligacion no se pudo registrar";  
		}
		else {
			$rspta=$Obligacion->editar($idObligacion,$NroObligacion,$Persona_idPersona,$Moneda_idMoneda,$TipoDocumento_idTipoDocumento,$nroDocumento,$fechaDocumento,$fechaVencimiento,$fechaPosiblePago,$fechadePago,$Pago_idPago,$importe,$saldo);
			echo $rspta ? "Obligacion actualizada" : "Obligacion no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$Obligacion->desactivar($idObligacion);
 		echo $rspta ? "Obligacion Desactivada" : "Obligacion no se puede desactivar";
	break;

	case 'activar':
		$rspta=$Obligacion->activar($idObligacion);
 		echo $rspta ? "Obligacion activada" : "Obligacion no se puede activar";
	break;

	case 'mostrar':
		$rspta=$Obligacion->mostrar($idObligacion);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$Obligacion->listar();
 		//Vamos a declarar un array
 		$data= Array();
 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idObligacion.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idObligacion.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idObligacion.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idObligacion.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->NroObligacion,
 				"2"=>$reg->razonSocial,
 				"3"=>$reg->moneda,    
 				"4"=>$reg->tipodocumento,  
 				"5"=>$reg->fechaVencimiento,  
 				"6"=>$reg->fechaPosiblePago, 
 				"7"=>$reg->fechadePago,             
 				"8"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
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

	case 'selectMoneda':
		require_once "../modelos/Moneda.php"; 
		$idMoneda = new Moneda();
		$rspta = $idMoneda->listar();

		while ($reg = $rspta->fetchObject())
				{
				echo '<option value=' . $reg->idMoneda . '>' . $reg->descripcion . '</option>';
				}
	break;
 
	case 'selectPersona':  
		require_once "../modelos/Persona.php";  
		$idPersona = new Persona();
		$rspta = $idPersona->listar();

		while ($reg = $rspta->fetchObject())  
				{
				echo '<option value=' . $reg->idPersona . '>' . $reg->razonSocial . '</option>';
				}
	break;
 
	case 'selectTipoDocumento':  
		require_once "../modelos/TiposDocumentos.php";  
		$idTipoDocumento = new TipoDocumento();
		$rspta = $idTipoDocumento->listar();

		while ($reg = $rspta->fetchObject())  
				{
				echo '<option value=' . $reg->idTipoDocumento . '>' . $reg->descripcion . '</option>';
				}
	break;
 
	case 'selectPago':  
		require_once "../modelos/Pago.php";  
		$idPago = new Pago();
		$rspta = $idPago->listar();

		while ($reg = $rspta->fetchObject())  
				{
				echo '<option value=' . $reg->idPago . '>' . $reg->nroPago . '</option>';
				}
	break;


}
?>