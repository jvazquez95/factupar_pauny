<?php 
require_once "../modelos/Cheque.php";

$cheque=new Cheque();

$idCheque=isset($_POST["idCheque"])? limpiarCadena($_POST["idCheque"]):"";
$fechaEmision=isset($_POST["fechaEmision"])? limpiarCadena($_POST["fechaEmision"]):"";
$fechaCobro=isset($_POST["fechaCobro"])? limpiarCadena($_POST["fechaCobro"]):"";
$Banco_idBanco=isset($_POST["Banco_idBanco"])? limpiarCadena($_POST["Banco_idBanco"]):"";
$Moneda_idMoneda=isset($_POST["Moneda_idMoneda"])? limpiarCadena($_POST["Moneda_idMoneda"]):"";
$tipoCheque=isset($_POST["tipoCheque"])? limpiarCadena($_POST["tipoCheque"]):"";
$nroCheque=isset($_POST["nroCheque"])? limpiarCadena($_POST["nroCheque"]):"";
$firmante=isset($_POST["firmante"])? limpiarCadena($_POST["firmante"]):"";
$emisor=isset($_POST["emisor"])? limpiarCadena($_POST["emisor"]):"";
$cliente=isset($_POST["cliente"])? limpiarCadena($_POST["cliente"]):"";
$monto=isset($_POST["montoCh"])? limpiarCadena($_POST["montoCh"]):"";
$comentario=isset($_POST["comentario"])? limpiarCadena($_POST["comentario"]):"";
$fechaConfirmacion=isset($_POST["fechaConfirmacion"])? limpiarCadena($_POST["fechaConfirmacion"]):"";
$fechaRechazo=isset($_POST["fechaRechazo"])? limpiarCadena($_POST["fechaRechazo"]):"";
$estado=isset($_POST["estado"])? limpiarCadena($_POST["estado"]):"";
$Banco_idBancoCh=isset($_POST["Banco_idBancoCh"])? limpiarCadena($_POST["Banco_idBancoCh"]):"";
$Moneda_idMonedaCh=isset($_POST["Moneda_idMonedaCh"])? limpiarCadena($_POST["Moneda_idMonedaCh"]):"";
$destinatario=isset($_POST["destinatario"])? limpiarCadena($_POST["destinatario"]):"";
$nroChequeCh=isset($_POST["nroChequeCh"])? limpiarCadena($_POST["nroChequeCh"]):"";
$nroCuenta=isset($_POST["nroCuenta"])? limpiarCadena($_POST["nroCuenta"]):"";
$idChequeEmitido=isset($_POST["idChequeEmitido"])? limpiarCadena($_POST["idChequeEmitido"]):"";
$inicio=isset($_POST["inicio"])? limpiarCadena($_POST["inicio"]):"";
$fin=isset($_POST["fin"])? limpiarCadena($_POST["fin"]):"";
$CuentaCorriente_idCuentaCorriente=isset($_POST["CuentaCorriente_idCuentaCorriente"])? limpiarCadena($_POST["CuentaCorriente_idCuentaCorriente"]):"";
$fechaInicial=isset($_POST["fechaInicial"])? limpiarCadena($_POST["fechaInicial"]):"";
$fechaFinal=isset($_POST["fechaFinal"])? limpiarCadena($_POST["fechaFinal"]):"";
$tipoCheque=isset($_POST["tipoCheque"])? limpiarCadena($_POST["tipoCheque"]):"";
$tipoFecha=isset($_POST["tipoFecha"])? limpiarCadena($_POST["tipoFecha"]):"";


switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idCheque)){
			$rspta=$cheque->insertar($fechaEmision ,$fechaCobro ,$Banco_idBanco ,$Moneda_idMoneda ,$tipoCheque ,$nroCheque ,$firmante ,$cliente ,$monto ,$comentario ,$fechaConfirmacion ,$fechaRechazo ,$nroCuenta,$estado);
			echo $rspta ? "cheque registrada" : "cheque no se pudo registrar";
		}
		else {
			$rspta=$cheque->editar($idCheque, $fechaEmision ,$fechaCobro ,$Banco_idBanco ,$Moneda_idMoneda ,$tipoCheque ,$nroCheque ,$firmante ,$cliente ,$monto ,$comentario ,$fechaConfirmacion ,$fechaRechazo ,$nroCuenta,$estado );
			echo $rspta ? "cheque actualizada" : "cheque no se pudo actualizar";
		}
	break;


	case 'guardar':


		if (empty($idChequeEmitido)) {
						$rspta=$cheque->insertarr($destinatario, $nroChequeCh, $nroCuenta, $Banco_idBancoCh, $Moneda_idMonedaCh, $monto, $fechaCobro, $tipoCheque, $comentario);
			//echo json_encode( array('respuesta' => $rspta));
			echo $rspta;
		}else{
			$rspta=$cheque->editarrr($idChequeEmitido, $destinatario, $nroChequeCh, $nroCuenta, $Banco_idBancoCh, $Moneda_idMonedaCh, $monto, $fechaCobro, $tipoCheque, $comentario);
			//echo json_encode( array('respuesta' => $rspta));
			echo $rspta;	
		}


	break;

	case 'generar':
			$rspta=$cheque->generar($Banco_idBancoCh, $CuentaCorriente_idCuentaCorriente, $inicio, $fin, $tipoCheque);
			echo $rspta;
		


	break;


	case 'guardarChequeRecibido':

			$rspta=$cheque->insertarrr($emisor, $nroChequeCh, $nroCuenta, $Banco_idBancoCh, $Moneda_idMonedaCh, $monto, $fechaCobro, $tipoCheque, $comentario);
			//echo json_encode( array('respuesta' => $rspta));
			echo $rspta;
	break;


	case 'mostrar':
		$rspta=$cheque->mostrar($idCheque);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'desactivar':
		$rspta=$cheque->desactivar($idCheque);
 		echo $rspta ? "cheque Desactivado" : "cheque no se puede desactivar";
	break;

	case 'activar':
		$rspta=$cheque->activar($idCheque);
 		echo $rspta ? "cheque activado" : "cheque no se puede activar";
	break;


	case 'rechazar':
		$rspta=$cheque->rechazar($idCheque);
 		echo $rspta ? "cheque rechazado" : "cheque no se puede rechazar";
	break;

	case 'confirmar':
		$rspta=$cheque->confirmar($idCheque);
 		echo $rspta ? "cheque confirmado" : "cheque no se puede confirmar";
	break;



	case 'listar':
		$rspta=$cheque->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-danger" onclick="desactivar('.$reg->idCheque.')"><i class="fa fa-close"></i></button>'.'<br> <br><button class="btn btn-danger" onclick="rechazar('.$reg->idCheque.')"><i class="fa fa-close">Rechazar</i></button>'.'<br><br> <button class="btn btn-primary" onclick="confirmar('.$reg->idCheque.')"><i class="fa fa-check"></i>Confirmar</button>':'',
 				"1"=>$reg->fechaEmision,
 				"2"=>$reg->fechaCobro,
 				"3"=>$reg->Banco_idBanco,
 				"4"=>$reg->Moneda_idMoneda,
 				"5"=>$reg->tipoCheque,
 				"6"=>$reg->nroCheque,
 				"7"=>$reg->firmante,
 				"8"=>$reg->cliente,
 				"9"=>$reg->monto,
 				"10"=>$reg->comentario,
 				"11"=>$reg->fechaConfirmacion,
 				"12"=>$reg->fechaRechazo,
 				"13"=>$reg->usuarioInsercion,
 				"14"=>$reg->fechaInsercions,
 				"15"=>$reg->UsuarioModificacion,
 				"16"=>$reg->fechaModificacion,
 				"17"=>$reg->estado,
 				"18"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
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




	case 'rpt_cheques_tipo':
		$rspta=$cheque->rpt_cheques_tipo($fechaInicial, $fechaFinal, $tipoCheque, $tipoFecha);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			if ($reg->cobrado == 0) {
 				$cobrado = 'Cheque por cobrar';
 			}

 			if ($reg->cobrado == 1) {
 				$cobrado = 'Cheque cobrado';
 			}


 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-danger" onclick="desactivar('.$reg->idChequeEmitido.')"><i class="fa fa-close"></i></button>'.'<br> <br><button class="btn btn-danger" onclick="rechazar('.$reg->idChequeEmitido.')"><i class="fa fa-close">Rechazar</i></button>'.'<br><br> <button class="btn btn-primary" onclick="confirmar('.$reg->idChequeEmitido.')"><i class="fa fa-check"></i>Confirmar Cobro</button>':'',
 				"1"=>$reg->nroCheque,
 				"2"=>$reg->monto,
 				"3"=>$reg->moneda,
 				"4"=>$reg->banco,
 				"5"=>$reg->nroCuenta,
 				"6"=>$reg->destinatario,
 				"7"=>$reg->tipoCh,
 				"8"=>$reg->fechaEmision,
 				"9"=>$reg->fechaCobro,
 				"10"=>$reg->fechaInsercion,
 				"11"=>$reg->cuentaCorriente,
 				"12"=>$cobrado,
 				"13"=>$reg->comentario,
 				"14"=>$reg->estado,
 				"15"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
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





	case "selectcheque":

		$rspta = $cheque->selectcheque();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idChequeEmitido. '>' .$reg->nroCheque. '</option>';
		}

		break;


	case "selectChequesPendientes":

		$rspta = $cheque->selectChequesPendientes($_POST['Banco_idBanco'],$_POST['Moneda_idMoneda']);
			echo '<option value="0">Seleccione cheque para aplicar</option>';
		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idChequeEmitido. '>Banco: ' .$reg->nb.'Numero de cheque: ' .$reg->nroCheque. ' - Cuenta Corriente: ' .$reg->ccnc. ' Moneda: '. $reg->nm .'</option>';
		}

		break;


	case "selectChequesPendientesRecibidos":

		$rspta = $cheque->selectChequesPendientesRecibidos();
			echo '<option value="0">Seleccione cheque para aplicar</option>';
		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idChequeTercero. '>' .$reg->nroCheque. ' - Paguese a nombre de: ' .$reg->destinatario. '</option>';
		}

		break;


	case 'importe':
		$rspta=$cheque->importe($_POST['idCheque']);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'importeRecibidos':
		$rspta=$cheque->importeRecibidos($_POST['idCheque']);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;





	case 'selectCuentaCorriente':  
		$rspta = $cheque->selectCuentaCorriente();

		while ($reg = $rspta->fetchObject())  
				{
				echo '<option value=' . $reg->idCuentaCorriente . '>' . $reg->descripcion . '</option>';
				} 
	break;



	case 'selectCuentaCorrienteBanco':  
		$rspta = $cheque->selectCuentaCorrienteBanco($_POST['Banco_idBanco']);

		while ($reg = $rspta->fetchObject())  
				{
				echo '<option value=' . $reg->idCuentaCorriente . '>' . $reg->descripcion . '</option>';
				} 
	break;





}
?>