<?php 
require_once "../modelos/Asiento.php";

$asiento=new Asiento(); 

$idAsiento=isset($_POST["idAsiento"])? limpiarCadena($_POST["idAsiento"]):"";
$Proceso_idProceso=isset($_POST["Proceso_idProceso"])? limpiarCadena($_POST["Proceso_idProceso"]):"";
$Moneda_idMoneda=isset($_POST["Moneda_idMoneda"])? limpiarCadena($_POST["Moneda_idMoneda"]):"";
$fechaAsiento=isset($_POST["fechaAsiento"])? limpiarCadena($_POST["fechaAsiento"]):"";
$fechaPlanilla=isset($_POST["fechaPlanilla"])? limpiarCadena($_POST["fechaPlanilla"]):"";
$transaccionOrigen=isset($_POST["transaccionOrigen"])? limpiarCadena($_POST["transaccionOrigen"]):"";
$nroOrigen=isset($_POST["nroOrigen"])? limpiarCadena($_POST["nroOrigen"]):""; 
$comentario=isset($_POST["comentario"])? limpiarCadena($_POST["comentario"]):"";  
switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idAsiento)){
			$rspta=$asiento->insertar(
				$Proceso_idProceso,
				$Moneda_idMoneda,
				$fechaAsiento,
				$fechaPlanilla,
				$transaccionOrigen,
				$nroOrigen,
				$comentario, 

				$_POST["item"],
				$_POST["CuentaContable_idCuentaContable"],
				$_POST["CuentaCorriente_idCuentaCorriente"],
				$_POST["tipoMovimiento"],
				$_POST["CentroCosto_idCentroCosto"],
				$_POST["totalImporte"],
				$_POST["tasaCambio"],
				$_POST["tasaCambioBases"],
				$_POST["Concepto_idConcepto"],
				$_POST["tipoComprobante"],
				$_POST["nroComprobante"],
				$_POST["Banco_idBanco"],
				$_POST["nroCheque"] 
			);
			echo $rspta ? "Asiento registrado" : "Asiento no se pudo registrar";
		}
		else {
			$rspta=$asiento->editar($idAsiento,$Proceso_idProceso,$Moneda_idMoneda,$fechaAsiento,$fechaPlanilla,$transaccionOrigen,$nroOrigen,$comentario,$_POST["item"],$_POST["CuentaContable_idCuentaContable"],$_POST["CuentaCorriente_idCuentaCorriente"],$_POST["tipoMovimiento"],$_POST["CentroCosto_idCentroCosto"],$_POST["importeDebito"],$_POST["importeCredito"],$_POST["tasaCambio"],$_POST["tasaCambioBases"],$_POST["Concepto_idConcepto"],$_POST["tipoComprobante"],$_POST["nroComprobante"],$_POST["Banco_idBanco"],$_POST["nroCheque"],$_POST["idAsientoDetalle"]);
			echo $rspta ? "Asiento actualizado" : "Asiento no se pudo actualizar"; 
		}
	break;

	case 'listarDetalleAsiento':
		//Recibimos el idingreso
		$idAsiento=$_GET['idAsiento'];
				$total=0;
				$rspta = $asiento->listarDetalleAsiento($idAsiento); 
						echo '<thead style="background-color:#A9D0F5">
                                                      <th>Opciones</th>
                                                      <th>Item</th>
                                                      <th>Cuenta Contable</th>
                                                      <th>Cuenta Corriente</th>
                                                      <th>Tipo Movimiento</th>
                                                      <th>Centro de Costo</th>
                                                      <th>importe Debito</th>
                                                      <th>importe Credito</th>
                                                      <th>Banco</th>
                                                      <th>Nro de Cheque</th>
                                                      <th>Tasa de Cambio</th>
                                                      <th>Base de Cambio</th>
                                                      <th>Concepto</th>
                                                      <th>Nro de Comprobante</th>    
                                                      <th>Tipo de Comprobante</th>     
				                                </thead>';
				        $contPrecio   = 0;
						while ($reg = $rspta->fetchObject())
						{ 

							echo '<tr class="filasTP" id="filaTP'.$contPrecio.'">
								<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleAsiento('.$contPrecio.')">X</button> 
								</td><td><input type="hidden" name="item[]" id="item[]" value="'.$reg->item.'">'.$reg->item.'</td>
								</td><td><input type="hidden" name="CuentaContable_idCuentaContable[]" id="CuentaContable_idCuentaContable[]" value="'.$reg->idCuentaContable.'">'.$reg->CuentaContableDesc.'</td>
								</td><td><input type="hidden" name="CuentaCorriente_idCuentaCorriente[]" id="CuentaCorriente_idCuentaCorriente[]" value="'.$reg->idCuentaCorriente.'">'.$reg->CuentaCorrienteDesc.'</td>
								</td><td><input type="hidden" name="tipoMovimiento[]" id="tipoMovimiento[]" value="'.$reg->tipoMovimiento.'">'.$reg->tipoMovimientoDesc.'</td>
								</td><td><input type="hidden" name="CentroCosto_idCentroCosto[]" id="CentroCosto_idCentroCosto[]" value="'.$reg->idCentroCosto.'">'.$reg->CentroCostoDesc.'</td>
								</td><td><input type="hidden" name="importeDebito[]" id="importeDebito[]" value="'.$reg->importeDebito.'">'.$reg->importeDebito.'</td>
								</td><td><input type="hidden" name="importeCredito[]" id="importeCredito[]" value="'.$reg->importeCredito.'">'.$reg->importeCredito.'</td>
								</td><td><input type="hidden" name="Banco_idBanco[]" id="Banco_idBanco[]" value="'.$reg->idBanco.'">'.$reg->Banco_idBancoDesc.'</td>
								</td><td><input type="hidden" name="nroCheque[]" id="nroCheque[]" value="'.$reg->nroCheque.'">'.$reg->nroCheque.'</td>
								</td><td><input type="hidden" name="tasaCambio[]" id="tasaCambio[]" value="'.$reg->tasaCambio.'">'.$reg->tasaCambio.'</td>
								</td><td><input type="hidden" name="tasaCambioBases[]" id="tasaCambioBases[]" value="'.$reg->tasaCambioBases.'">'.$reg->tasaCambioBases.'</td> 
								</td><td><input type="hidden" name="Concepto_idConcepto[]" id="Concepto_idConcepto[]" value="'.$reg->Concepto_idConcepto.'">'.$reg->Concepto_idConceptoDesc.'</td>
								</td><td><input type="hidden" name="tipoComprobante[]" id="tipoComprobante[]" value="'.$reg->tipoComprobante.'">'.$reg->tipoComprobante.'</td>
								</td><td><input type="hidden" name="nroComprobante[]" id="nroComprobante[]" value="'.$reg->nroComprobante.'">'.$reg->nroComprobante.'</td>
								</td><td><input type="hidden" name="idAsientoDetalle[]" id="idAsientoDetalle[]" value="'.$reg->idAsientoDetalle.'"></td>
								</td><td><input type="hidden" name="totalDebito[]" id="totalDebito[]" value="'.$reg->totalDebito.'"></td>
								</td><td><input type="hidden" name="totalCredito[]" id="totalCredito[]" value="'.$reg->totalCredito.'"></td> 
								';
							$totalDebito=$reg->totalDebito;
							$totalCredito=$reg->totalCredito;
							$contPrecio++;
									
						}
						echo '<tfoot>
                              <th>Opciones</th>
                              <th>Item</th>
                              <th>Cuenta Contable</th>
                              <th>Cuenta Corriente</th>
                              <th>Tipo Movimiento</th>
                              <th>Centro de Costo</th>
                              <th><id="totalDebito">Total Debito: '.$totalDebito.'</><input type="hidden" name="total_debito" id="total_debito"></th>
                              <th><id="totalCredito">Total Credito: '.$totalCredito.'</><input type="hidden" name="total_credito" id="total_credito"></th>
                              <th>Banco</th>
                              <th>Nro de Cheque</th>
                              <th>Tasa de Cambio</th>
                              <th>Base de Cambio</th>
                              <th>Concepto</th>
                              <th>Nro de Comprobante</th>    
                              <th>Tipo de Comprobante</th>    
                        	</tfoot>';

	break;


	case 'desactivar':
		$rspta=$asiento->desactivar($idAsiento);
 		echo $rspta ? "Asiento Desactivado" : "Artículo no se puede desactivar";
	break;

	case 'activar':
		$rspta=$asiento->activar($idAsiento);
 		echo $rspta ? "Asiento activado" : "Artículo no se puede activar";
	break;

	case 'desactivarDetalleAsiento':
		$rspta=$asiento->desactivarDetalleAsiento($_REQUEST['idAsientoDetalle']);
 		echo $rspta ? "Detalle Desactivado" : "Detalle no se puede desactivar";
	break;

	case 'mostrar':
		$rspta=$asiento->mostrar($idAsiento);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$asiento->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idAsiento.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->idAsiento.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idAsiento.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary btn-xs" onclick="activar('.$reg->idAsiento.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->ano,
 				"2"=>$reg->descripcion,
 				"3"=>$reg->fechaAsiento,
 				"4"=>$reg->fechaPlanilla,
 				"5"=>$reg->transaccionOrigen,
 				"6"=>$reg->nroOrigen,
 				"7"=>'<button class="btn btn-primary" onclick="mostrarDetalleasientoDetalle('.$reg->idAsiento.')">Ver detalle de Asiento <i class="fa fa-pencil"></i></button>',
 				(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
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

	case "selectCuentaCorriente":

		$rspta = $asiento->selectCuentaCorriente();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idCuentaCorriente. '>' .$reg->descripcion. '</option>';
		}

		break;
}
?>