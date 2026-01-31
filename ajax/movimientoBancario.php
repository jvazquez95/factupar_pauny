<?php 
require_once "../modelos/movimientoBancario.php";

$movimientoBancario=new movimientoBancario();

$idMovimientoBancario=isset($_POST["idMovimientoBancario"])? limpiarCadena($_POST["idMovimientoBancario"]):"";
$ano=isset($_POST["ano"])? limpiarCadena($_POST["ano"]):"";
$mes=isset($_POST["mes"])? limpiarCadena($_POST["mes"]):"";
$Moneda_idMoneda=isset($_POST["Moneda_idMoneda"])? limpiarCadena($_POST["Moneda_idMoneda"]):"";
$nroCuenta=isset($_POST["nroCuenta"])? limpiarCadena($_POST["nroCuenta"]):"";
$Banco_idBanco=isset($_POST["Banco_idBanco"])? limpiarCadena($_POST["Banco_idBanco"]):"";
$nroSecuencia=isset($_POST["nroSecuencia"])? limpiarCadena($_POST["nroSecuencia"]):"";
$fechaMovimiento=isset($_POST["fechaMovimiento"])? limpiarCadena($_POST["fechaMovimiento"]):"";
$nroOrden=isset($_POST["nroOrden"])? limpiarCadena($_POST["nroOrden"]):"";
$beneficiario=isset($_POST["beneficiario"])? limpiarCadena($_POST["beneficiario"]):"";
$Importe=isset($_POST["Importe"])? limpiarCadena($_POST["Importe"]):"";
$tipoMovimiento=isset($_POST["tipoMovimiento"])? limpiarCadena($_POST["tipoMovimiento"]):"";
$concepto=isset($_POST["concepto"])? limpiarCadena($_POST["concepto"]):"";
$nroDocumento=isset($_POST["nroDocumento"])? limpiarCadena($_POST["nroDocumento"]):"";
$fechaCobro=isset($_POST["fechaCobro"])? limpiarCadena($_POST["fechaCobro"]):"";
$fechaEmision=isset($_POST["fechaEmision"])? limpiarCadena($_POST["fechaEmision"]):"";
$fechaAnulacion=isset($_POST["fechaAnulacion"])? limpiarCadena($_POST["fechaAnulacion"]):"";
$situacion=isset($_POST["situacion"])? limpiarCadena($_POST["situacion"]):"";
$CentroCosto_idCentroCosto=isset($_POST["CentroCosto_idCentroCosto"])? limpiarCadena($_POST["CentroCosto_idCentroCosto"]):"";
$Persona_idPersonaPersonal=isset($_POST["Persona_idPersonaPersonal"])? limpiarCadena($_POST["Persona_idPersonaPersonal"]):"";
$cargo=isset($_POST["cargo"])? limpiarCadena($_POST["cargo"]):"";
$indicadorSueldo=isset($_POST["indicadorSueldo"])? limpiarCadena($_POST["indicadorSueldo"]):"";
$mesSueldo=isset($_POST["mesSueldo"])? limpiarCadena($_POST["mesSueldo"]):"";
 

switch ($_GET["op"]){
	case 'guardaryeditar':   
		if (empty($idMovimientoBancario)){
			$rspta=$movimientoBancario->insertar($ano,$mes,$Moneda_idMoneda,$nroCuenta,$Banco_idBanco,$nroSecuencia,$fechaMovimiento,$nroOrden,$beneficiario,$Importe,$tipoMovimiento,$concepto,$nroDocumento,$fechaCobro,$fechaEmision,$fechaAnulacion,$situacion,$CentroCosto_idCentroCosto,$Persona_idPersonaPersonal,$cargo,$indicadorSueldo,$mesSueldo);
			echo $rspta ? "Movimiento bancario registrado" : "Movimiento bancario no se pudo registrar";  
		}
		else {
			$rspta=$movimientoBancario->editar($idMovimientoBancario,$ano,$mes,$Moneda_idMoneda,$nroCuenta,$Banco_idBanco,$nroSecuencia,$fechaMovimiento,$nroOrden,$beneficiario,$Importe,$tipoMovimiento,$concepto,$nroDocumento,$fechaCobro,$fechaEmision,$fechaAnulacion,$situacion,$CentroCosto_idCentroCosto,$Persona_idPersonaPersonal,$cargo,$indicadorSueldo,$mesSueldo);
			echo $rspta ? "Movimiento bancario actualizado" : "Movimiento bancario no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$movimientoBancario->desactivar($idMovimientoBancario);
 		echo $rspta ? "Movimiento bancario Desactivado" : "Movimiento bancario no se puede desactivar";
	break;

	case 'activar':
		$rspta=$movimientoBancario->activar($idMovimientoBancario);
 		echo $rspta ? "Movimiento bancario activado" : "Movimiento bancario no se puede activar";
	break;

	case 'mostrar':
		$rspta=$movimientoBancario->mostrar($idMovimientoBancario);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$movimientoBancario->listar(); 
 		//Vamos a declarar un array
 		$data= Array();
 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idMovimientoBancario.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idMovimientoBancario.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idMovimientoBancario.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idMovimientoBancario.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->ano,
 				"2"=>$reg->mes,
 				"3"=>$reg->Moneda,    
 				"4"=>$reg->nroCuentaMovimiento,  
 				"5"=>$reg->Banco,         
 				"6"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
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

	case 'selectBanco':
		require_once "../modelos/Banco.php";  
		$idBanco = new Banco();
		$rspta = $idBanco->listar();

		while ($reg = $rspta->fetchObject()) 
				{
				echo '<option value=' . $reg->idBanco . '>' . $reg->descripcion . '</option>';
				}
	break;
 
	case 'selectCentroCosto':  
		require_once "../modelos/centroDeCostos.php";   
		$idCentroCosto = new CentroDeCostos(); 
		$rspta = $idCentroCosto->listar();

		while ($reg = $rspta->fetchObject())  
				{
				echo '<option value=' . $reg->idCentroCosto . '>' . $reg->descripcion . '</option>';
				}
	break;
 
	case 'selectPersonaPersonal':  
		require_once "../modelos/Persona.php"; 
		$idPersonaF = new Persona();
		$rspta = $idPersonaF->selectFuncionario();

		while ($reg = $rspta->fetchObject())
				{
				echo '<option value=' . $reg->idPersona . '>' . $reg->razonSocial . '</option>';
				}
	break;
}
?>