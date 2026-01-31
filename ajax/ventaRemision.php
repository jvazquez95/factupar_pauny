<?php 
if (strlen(session_id()) < 1) 
  session_start();

require_once "../modelos/VentaRemision.php";

$ventaRemision=new ventaRemision();
 
$idRemision=isset($_POST["idRemision"])? limpiarCadena($_POST["idRemision"]):"";
$Cliente_idCliente=isset($_POST["Cliente_idCliente"])? limpiarCadena($_POST["Cliente_idCliente"]):"";
$Habilitacion_idHabilitacion=isset($_POST["Habilitacion_idHabilitacion"])? limpiarCadena($_POST["Habilitacion_idHabilitacion"]):"";
$Deposito_idDeposito=isset($_POST["Deposito_idDeposito"])? limpiarCadena($_POST["Deposito_idDeposito"]):"";
$TerminoPago_idTerminoPago=isset($_POST["TerminoPago_idTerminoPago"])? limpiarCadena($_POST["TerminoPago_idTerminoPago"]):"";
$tipo_comprobante=isset($_POST["tipo_comprobante"])? limpiarCadena($_POST["tipo_comprobante"]):"";
$nroFactura=isset($_POST["nroFactura"])? limpiarCadena($_POST["nroFactura"]):"";
$fechaFactura=isset($_POST["fechaFactura"])? limpiarCadena($_POST["fechaFactura"]):"";
$fechaVencimiento=isset($_POST["fechaVencimiento"])? limpiarCadena($_POST["fechaVencimiento"]):"";
$timbrado=isset($_POST["timbrado"])? limpiarCadena($_POST["timbrado"]):"";
$vtoTimbrado=isset($_POST["vtoTimbrado"])? limpiarCadena($_POST["vtoTimbrado"]):"";
$totalImpuesto=isset($_POST["totalImpuesto"])? limpiarCadena($_POST["totalImpuesto"]):"";
$usuarioInsercion=isset($_POST["usuarioInsercion"])? limpiarCadena($_POST["usuarioInsercion"]):"";
$serie=isset($_POST["serie"])? limpiarCadena($_POST["serie"]):"";
$total=isset($_POST["t_detalle12"])? limpiarCadena($_POST["t_detalle12"]):"";
//4$total2=isset($_POST["t_detalle"])? limpiarCadena($_POST["t_detalle"]):"";
//$total =  $_POST["t_detalle"] + $_POST["t_detalle12"];
$totalNeto=isset($_POST["total_venta"])? limpiarCadena($_POST["total_venta"]):"";
$cuotas=isset($_POST["cuotas"])? limpiarCadena($_POST["cuotas"]):"";
$giftCard=isset($_POST["giftCard"])? limpiarCadena($_POST["giftCard"]):"";
$nroGiftCard=isset($_POST["nroGiftCard"])? limpiarCadena($_POST["nroGiftCard"]):"";
$clienteGiftCard=isset($_POST["clienteGiftCard"])? limpiarCadena($_POST["clienteGiftCard"]):"";
$Empleado_idEmpleado=isset($_POST["Empleado_idEmpleado"])? limpiarCadena($_POST["Empleado_idEmpleado"]):"";
$OrdenventaRemision_idOrdenventaRemision=isset($_POST["OrdenVenta_idOrdenVenta"])? limpiarCadena($_POST["OrdenVenta_idOrdenVenta"]):"";
$Moneda_idMoneda=isset($_POST["Moneda_idMoneda"])? limpiarCadena($_POST["Moneda_idMoneda"]):"";
$tasaCambio=isset($_POST["tasaCambio"])? limpiarCadena($_POST["tasaCambio"]):"";
$tasaCambioBases=isset($_POST["tasaCambioBases"])? limpiarCadena($_POST["tasaCambioBases"]):"";
$entrega=isset($_POST["entrega"])? limpiarCadena($_POST["entrega"]):"";
$regalia=isset($_POST["regalia"])? limpiarCadena($_POST["regalia"]):"";
switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idRemision)){
			$rspta=$ventaRemision->insertar($entrega, $Moneda_idMoneda, $tasaCambio, $tasaCambioBases,$Cliente_idCliente,$Habilitacion_idHabilitacion,$Deposito_idDeposito,$TerminoPago_idTerminoPago,$tipo_comprobante,$nroFactura,$fechaFactura,$fechaVencimiento,$timbrado,$vtoTimbrado,$totalImpuesto,$total,$totalNeto,$usuarioInsercion,$serie,$cuotas,$giftCard,$nroGiftCard,$clienteGiftCard,$Empleado_idEmpleado,$OrdenventaRemision_idOrdenventaRemision,$_POST["VentaDetalle_idVentaDetalle"],$_POST["cant_max"],$_POST["idarticulo"],$_POST["descripcion"],$_POST["cantidad"],$_POST["saldoStock"],$_POST["precioventaRemision"],$_POST["impuesto"],$_POST["TipoImpuesto_idTipoImpuesto"],$_POST["importe_detalle"],$_POST["tipopago"], $_POST["nroReferencia"], $_POST["capital"], $_POST["interes"], $_POST["descuento"], $_POST["Banco_idBanco"], $_POST["importe_detalle_pagado"],$_POST['moneda'],$_POST['tasa'],$regalia);
 
			  echo $rspta;
		}
		else {
		}
	break;

	case 'anular':
		$rspta=$ventaRemision->anular($idRemision);
 		echo $rspta ? "ventaRemision anulada" : "ventaRemision no se puede anular";
	break;

	case 'anularOV':
		$rspta=$ventaRemision->anularOV($idRemision);
 		echo $rspta ? "Orden de ventaRemision anulada" : "Orden de ventaRemision no se puede anular";
	break;

	case 'mostrar':
		$rspta=$ventaRemision->mostrar($idRemision);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;



	case 'listarDetalleOrdenventaRemision':
		//Recibimos el idingreso
		$id=$_GET['id'];

		$rspta = $ventaRemision->listarDetalleOrdenventaRemision($id);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio ventaRemision</th>
                                    <th>Descuento</th>
                                    <th>Impuesto</th>
                                    <th>Total Neto</th>
                                    <th>Subtotal</th>
                                </thead>';

				        $cont = 0;
						while ($reg = $rspta->fetchObject())
								{
									echo '<tr class="filas" id="fila'.$cont.'">
									<td>
										<input type="hidden" name="interes[]" id="interes[]" value="'.$reg->interes.'">
										<input type="hidden" name="capital[]" id="capital[]" value="'.$reg->capital.'">
										
										<button type="button" class="btn btn-danger" onclick="eliminarDetalle('.$cont.')">X</button>
									</td>

									<td><input type="hidden" name="idarticulo[]" id="idarticulo[]" value="'.$reg->Articulo_idArticulo.'">'.$reg->na.'</td>
									<td><input type="number" name="cantidad[]" onblur="modificarSubototales()" id="cantidad[]" value="'.$reg->cantidad.'"></td>
									<td>
										<input type="hidden" name="precioventaRemision[]" onblur="modificarSubototales()"  id="precioventaRemision[]"  value="'.$reg->precio.'">'.$reg->precio.'
    								</td>
									<td><input type="number" name="descuento[]" onblur="modificarSubototales()" value="'.$reg->descuento.'" readonly></td>
									<td><input type="hidden" name="impuesto[]" onblur="modificarSubototales()" value="'.$reg->impuesto.'">'.$reg->impuesto.'</td>
									<td><span name="totalN" id="totalN'.$contPrecio.'">'.$reg->totalNeto.'</span></td>
									<td><span name="subtotal" id="subtotal'.$contPrecio.'">'.$reg->total.'</span></td>

    								</tr>';
									$cont++;
									
								}
		echo '<tfoot>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>TOTAL</th>
                                    <th><h4 id="total1">Gs. 0.00</h4><input type="hidden" name="total_venta" id="total_venta"></th>
                                    <th><h4 id="total2">Gs. 0.00</h4><input type="hidden" name="total_ventaRemision" id="total_ventaRemision"></th> 
                                </tfoot>';
	break;



	case 'listarDetalle':
		//Recibimos el idingreso
		$id=$_GET['id'];

		$rspta = $ventaRemision->listarDetalle($id);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio ventaRemision</th>
                                    <th>Descuento</th>
                                    <th>Subtotal</th>
                                </thead>';

		while ($reg = $rspta->fetchObject())
				{
					echo '<tr class="filas"><td></td><td>'.$reg->nombre.'</td><td>'.$reg->cantidad.'</td><td>'.$reg->precio_ventaRemision.'</td><td>'.$reg->descuento.'</td><td>'.$reg->subtotal.'</td></tr>';
					$total=$total+($reg->precio_ventaRemision*$reg->cantidad-$reg->descuento);
				}
		echo '<tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><h4 id="total">S/.'.$total.'</h4><input type="hidden" name="total_ventaRemision" id="total_ventaRemision"></th> 
                                </tfoot>';
	break;

	case 'listar':
		$habilitacion=$_REQUEST["habilitacion"];
		$rspta=$ventaRemision->listar($habilitacion);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			if($reg->dd=='TICKET'){
 				$url='../reportes/exTicket.php?id=';
 			}
 			else{
 				$url='../reportes/exFacturaWebWhatsapp.php?id=';
 			}

 			if ($reg->TerminoPago_idTerminoPago == 0) {
 				$tipo = 'CONTADO';
 			}else{
 				$tipo = 'CREDITO';
 			}

 			if ($reg->vi == 1) {
 				$saldo = 0;
 			}else{
 				$saldo = $reg->saldo;
 			}
 		//$url='../reportes/exTicket.php?id=';
 			$data[]=array(
 				"0"=>((!$reg->vi)?'<a target="_blank" href="'.$url.$reg->idRemision.'"> <button class="btn btn-info"><i class="fa fa-print"></i></button></a>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idRemision.')"><i class="fa fa-eye"></i></button>'),
 				"1"=>$reg->idRemision,
 				"2"=>$reg->vh,
 				"3"=>$reg->fechaFactura,
 				"4"=>utf8_encode($reg->cn),
 				"5"=>$reg->usuario,
 				"6"=>$reg->dd,
 				"7"=>$reg->serie.'-'.$reg->nroFactura,
 				"8"=>$tipo,
 				"9"=>'<button class="btn btn-primary" onclick="mostrarDetalleventaRemision('.$reg->idRemision.')">Ver detalle de ventaRemision <i class="fa fa-pencil"></i></button>',
 				"10"=>'<button class="btn btn-success" onclick="mostrarDetalleCobro('.$reg->idRemision.')">Ver detalle de cobro <i class="fa fa-pencil"></i></button>',
 				"11"=>number_format($reg->total, 2, ',', '.'),
 				"12"=>number_format($saldo, 2, ',', '.'),
 				"13"=>number_format($reg->cuotas, 0, ',', '.'),
 				"14"=>(!$reg->vi)?'<span class="label bg-green">Aceptado</span>':
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

	case 'selectCliente':
		require_once "../modelos/Cliente.php";
		$persona = new Cliente();

		$rspta = $persona->listarActivos();
		echo '<option value="0">Seleccione una opcion</option>';
		while ($reg = $rspta->fetchObject())
		{
			echo '<option value=' . $reg->idCliente . '>' . $reg->razonSocial . ' ' . $reg->nombreComercial  . ' ' . $reg->nroDocumento .'</option>';
		}
	break;


	case 'select':
		require_once "../modelos/TerminoPago.php";
		$tp = new TerminoPago();

		$rspta = $tp->select();

		while ($reg = $rspta->fetchObject())
				{
				echo '<option value=' . $reg->idTerminoPago . '>' . $reg->descripcion .'</option>';
				}
	break;

	case 'selectBanco':
		require_once "../modelos/Banco.php";
		$persona = new Banco();

		$rspta = $persona->listar();

		while ($reg = $rspta->fetchObject())
				{
				echo '<option value=' . $reg->idBanco . '>' . $reg->descripcion . '</option>';
				}
	break;

	case 'listarArticulosventaRemision':

		$Persona_idPersona = $_REQUEST['Persona_idPersona'];
		$Sucursal_idSucursal = $_REQUEST['Sucursal_idSucursal'];
		$TerminoPago_idTerminoPago = $_REQUEST['terminoPago'];
		$buscar_art = $_REQUEST['buscar_art'];
		$parametro = '';//$_REQUEST['parametro'];
		require_once "../modelos/Articulo.php";
		$articulo=new Articulo();

		$rspta=$articulo->listarActivosventaRemision($Persona_idPersona, $Sucursal_idSucursal, $TerminoPago_idTerminoPago, $parametro, $buscar_art);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

		$capital = $p["precioTL2"];
 		$interes = $p["precioTL"] - $p["precioTL2"];
 		$stock = $p["stock"];


 		$data[]=array(
 #"0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idArticulo.',\''.utf8_encode($reg->na).'\',\''.$reg->precioTL.'\',\''.$reg->TipoImpuesto_idTipoImpuesto.'\',\''.$reg->pi.'\',\''.$reg->capital.'\',\''.$interes.'\',\''.$reg->stock.'\')"><span class="fa fa-plus"></span></button>',
"0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idArticulo.',\''.utf8_encode($reg->na).'\',\''.$reg->precioTL.'\',\''.$reg->pi.'\',\''.$reg->capital.'\',\''.$interes.'\',\''.$reg->stock.'\',\''.$reg->descant.'\')"><span class="fa fa-plus"></span></button>', 
 "1"=>utf8_encode($reg->na),
 				"2"=>utf8_encode($reg->cn),
 				"3"=>$reg->codigoBarra,
 				"4"=>$reg->precioTL,
				"5"=>$reg->precioCuotas,
				"6"=>$reg->stock,
				"7"=>$reg->cuotas,
				"8"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px' >"
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	break;


	case 'listarActivosventaRemisionPromociones':
		require_once "../modelos/Articulo.php";
		$articulo=new Articulo();

		$rspta=$articulo->listarActivosventaRemisionPromociones();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
			echo '<option value=' .$reg->idArticulo. '>' .$reg->nombre. '</option>';
 		}

	break;



	case 'selectArticulosventaRemision':
		require_once "../modelos/Articulo.php";
		$articulo=new Articulo();
		$buscar_art = $_REQUEST['Articulo_idArticuloDescuento_l'];
		$rspta=$articulo->listarActivosventaRemision('0',null,'1',0,$buscar_art);
 		//Vamos a declarar un array 
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
			echo '<option value=' .$reg->idArticulo. '>' .$reg->na. '</option>';
 		}

	break;



	case 'habilitacion':
		$rspta=$ventaRemision->habilitacion($_POST['tipoDocumento']);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;


	case 'habilitacion2':
		$rspta=$ventaRemision->habilitacion2();
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;


	case 'ultimo':
		$rspta=$ventaRemision->ultimo();
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;


	case 'cambiarPersonaGiftCard':
		$rspta=$ventaRemision->cambiarPersonaGiftCard($idRemision,$clienteGiftCard);
 		echo $rspta ? "El cambio se proceso correctamente" : "El cambio no se pudo procesar";
	break;

	case 'cambiarNroGiftCard':
		$rspta=$ventaRemision->cambiarNroGiftCard($idRemision,$nroGiftCard);
 		echo $rspta ? "El cambio se proceso correctamente" : "El cambio no se pudo procesar";
	break;

	case "selectventaRemision":

		$rspta = $ventaRemision->selectventaRemision();
			echo "<option value='999'>Selccione una opcion</option>" ;
		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idRemision. '><strong>Razon Social: </strong>' .$reg->np. ' Total: ' .$reg->total. ' Nro. Factura: ' .$reg->serie .'-'. $reg->nroFactura. '</option>';
		}

		break;


	case 'datosventaRemision':
		$rspta=$ventaRemision->datosventaRemision($_GET['id']);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listarDetalleventaRemision':
		//Recibimos el idingreso
		$id=$_GET['id'];

		$rspta = $ventaRemision->listarDetalleventaRemision($id);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio ventaRemision</th>
                                    <th>Descuento</th>
                                    <th>Impuesto</th>
                                    <th>Total Neto</th>
                                    <th>Subtotal</th>
                                </thead>';

				        $contPrecio = 0;
						while ($reg = $rspta->fetchObject())
								{
												echo '<tr class="filas" id="fila'.$contPrecio.'">
							<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('.$contPrecio.')">X</button>
							</td><td><input type="hidden" name="idarticulo[]" id="idarticulo[]" value="'.$reg->Articulo_idArticulo.'">'.$reg->na.'</td>
							<td><input type="number" name="cantidad[]" onblur="modificarSubototales()" id="cantidad[]" value="'.($reg->cantidad * -1).'"></td>
							<td><input type="text" name="precio[]" onblur="modificarSubototales()"  id="precio[]"  value="'.$reg->precio.'">'.$reg->precio.'</td>
							<td><input type="number" name="descuento[]" onblur="modificarSubototales()" value="'.$reg->descuento.'"></td>
							<td><input type="hidden" name="impuesto[]" onblur="modificarSubototales()" value="'.$reg->impuesto.'">'.$reg->impuesto.'</td>
							<td><span name="totalN" id="totalN'.$contPrecio.'">'.$reg->totalNeto.'</span></td>
							<td><span name="subtotal" id="subtotal'.$contPrecio.'">'.$reg->total.'</span></td></tr>';
																$contPrecio++;
									
								}
		echo '<tfoot>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>TOTAL</th>
                                    <th><h4 id="total1">Gs. 0.00</h4><input type="hidden" name="total_compran" id="total_compran"></th>
                                    <th><h4 id="total2">Gs. 0.00</h4><input type="hidden" name="total_compra" id="total_compra"></th> 
                                </tfoot>';
	break;



	case 'listarproductos':

if(!empty($_POST["keyword"])) {

$idPersona = $_POST['Persona_idPersona'];
$terminoPago = $_POST['terminoPago'];
$articulo = '%' . $_POST['keyword'] . '%';

$query ="CALL SP_ListarPreciosPorArticulo('".$idPersona."', null, '".$terminoPago."', '".$articulo."', 1, 1)";

 
$result = $conexion->query($query); 


if(!empty($result)) {
?>
<?php
$dataArray = Array();
foreach($result as $p) {

 	$descuento = $p["descant"];
 	$capital = $p["precioTL2"];
 	$interes = $p["precioTL"] - $p["precioTL2"];
 	$stock = $p["stock"];
?>

<option onclick="agregarDetalle(<?php echo $p["idArticulo"]; ?>,<?php echo $p["nombre"]; ?>,
								<?php echo $p["precioTL"]; ?>,
								<?php echo $p["TipoImpuesto_idTipoImpuesto"]?>,
								<?php echo $capital ?>,
								<?php echo $interes ?>,
								<?php echo $p["pi"]; ?>,	
								<?php echo $stock; ?>	
														)" d-precio="<?php echo $p["precioTL"]?>" 
														   d-impuesto="<?php echo $p["pi"]?>" 
														   d-idImpuesto="<?php echo $p["TipoImpuesto_idTipoImpuesto"]?>"
														   d-impuesto="<?php echo $p["pi"]?>" 
														   d-capital="<?php echo  $capital  ?>" 
														   d-interes="<?php echo $interes   ?>"
														   d-stock="<?php echo $stock   ?>"
														   d-descuento="<?php echo $descuento   ?>"
														   value="<?php echo $p["idArticulo"]; ?>">
	<?php echo $p["ad"]; ?>
	<?php echo $p["idArticulo"]; ?>
	<?php echo $p["codigoBarra"]; ?>
</option>

<?php 
}// foreach


}//if

}//keyword

	break;





	case 'rpt_remisionGentileza':
		$fecha_inicio=$_REQUEST["f_i"];
		$fecha_fin=$_REQUEST["f_f"];


		$rspta=$ventaRemision->rpt_remisionGentileza($fecha_inicio,$fecha_fin);
		
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){


 				$url='../reportes/exFacturaFormRemision.php?id=';

 			$data[]=array(
 				"0"=>$reg->idRemision. ' - '. '<a target="_blank" href="'.$url.$reg->idRemision.'"> <button class="btn btn-info"><i class="fa fa-print">Ver Remision</i></button>',
 				"1"=>utf8_encode ($reg->nombreComercial),
 				"2"=>$reg->nroDocumento,
 				"3"=>$reg->serie.' - '.$reg->nroFactura,
				"4"=>$reg->fechaTransaccion,
				"5"=>$reg->fechaVencimiento,
				"6"=>$reg->timbrado,
				"7"=>$reg->TerminoPago_idTerminoPago,
				"8"=>$reg->Moneda_idMoneda,
				"9"=>utf8_encode ($reg->articulo),
				"10"=>$reg->cantidad,
				"11"=>number_format($reg->precio),
				"12"=>number_format($reg->total),
				"13"=>utf8_encode ($reg->vendedor),
				"14"=>utf8_encode ($reg->usuario),
				"15"=>utf8_encode ($reg->vendedorAsignado),
				"16"=>utf8_encode ($reg->proveedor),
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;




case 'listarproductosCodigo':


		$idPersona = $_POST['Persona_idPersona'];
		$terminoPago = $_POST['terminoPago'];
		$idArticulo = $_POST['idArticulo'];



		$rspta=$ventaRemision->listarproductosCodigo($idPersona, $terminoPago, $idArticulo);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);

break;

}

?>


