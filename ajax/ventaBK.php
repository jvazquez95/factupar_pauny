<?php 
if (strlen(session_id()) < 1) 
  session_start();

require_once "../modelos/Venta.php";

$venta=new Venta();

$idVenta=isset($_POST["idVenta"])? limpiarCadena($_POST["idVenta"]):"";
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
$total=isset($_POST["total_venta"])? limpiarCadena($_POST["total_venta"]):"";
$totalNeto=isset($_POST["total_ventan"])? limpiarCadena($_POST["total_ventan"]):"";
$cuotas=isset($_POST["cuotas"])? limpiarCadena($_POST["cuotas"]):"";
$giftCard=isset($_POST["giftCard"])? limpiarCadena($_POST["giftCard"]):"";
$nroGiftCard=isset($_POST["nroGiftCard"])? limpiarCadena($_POST["nroGiftCard"]):"";
$clienteGiftCard=isset($_POST["clienteGiftCard"])? limpiarCadena($_POST["clienteGiftCard"]):"";
$Empleado_idEmpleado=isset($_POST["Empleado_idEmpleado"])? limpiarCadena($_POST["Empleado_idEmpleado"]):"";
$OrdenVenta_idOrdenVenta=isset($_POST["OrdenVenta_idOrdenVenta"])? limpiarCadena($_POST["OrdenVenta_idOrdenVenta"]):"";
$Moneda_idMoneda=isset($_POST["Moneda_idMoneda"])? limpiarCadena($_POST["Moneda_idMoneda"]):"";
$tasaCambio=isset($_POST["tasaCambio"])? limpiarCadena($_POST["tasaCambio"]):"";
$tasaCambioBases=isset($_POST["tasaCambioBases"])? limpiarCadena($_POST["tasaCambioBases"]):"";
$entrega=isset($_POST["entrega"])? limpiarCadena($_POST["entrega"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idVenta)){
			$rspta=$venta->insertar($entrega, $Moneda_idMoneda, $tasaCambio, $tasaCambioBases,$Cliente_idCliente,$Habilitacion_idHabilitacion,$Deposito_idDeposito,$TerminoPago_idTerminoPago,$tipo_comprobante,$nroFactura,$fechaFactura,$fechaVencimiento,$timbrado,$vtoTimbrado,$totalImpuesto,$total,$totalNeto,$usuarioInsercion,$serie,$cuotas,$giftCard,$nroGiftCard,$clienteGiftCard,$Empleado_idEmpleado,$OrdenVenta_idOrdenVenta,$_POST["idarticulo"],$_POST["descripcion"],$_POST["cantidad"],$_POST["precioVenta"],$_POST["impuesto"],$_POST["TipoImpuesto_idTipoImpuesto"],$_POST["importe_detalle"],$_POST["tipopago"], $_POST["nroReferencia"], $_POST["capital"], $_POST["interes"], $_POST["descuento"], $_POST["banco"]);


			//$rspta=$venta->insertar($idcliente,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_venta,$_POST["idarticulo"],$_POST["cantidad"],$_POST["precio_venta"],$_POST["descuento"]);
			
			echo $rspta ? "Venta registrada" : "No se pudieron registrar todos los datos de la venta";
		}
		else {
		}
	break;

	case 'anular':
		$rspta=$venta->anular($idVenta);
 		echo $rspta ? "Venta anulada" : "Venta no se puede anular";
	break;

	case 'anularOV':
		$rspta=$venta->anularOV($idVenta);
 		echo $rspta ? "Orden de Venta anulada" : "Orden de Venta no se puede anular";
	break;

	case 'mostrar':
		$rspta=$venta->mostrar($idventa);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;



	case 'listarDetalleOrdenVenta':
		//Recibimos el idingreso
		$id=$_GET['id'];

		$rspta = $venta->listarDetalleOrdenVenta($id);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio Venta</th>
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
										<input type="hidden" name="precioVenta[]" onblur="modificarSubototales()"  id="precioVenta[]"  value="'.$reg->precio.'">'.$reg->precio.'
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
                                    <th><h4 id="total1">Gs. 0.00</h4><input type="hidden" name="total_ventan" id="total_ventan"></th>
                                    <th><h4 id="total2">Gs. 0.00</h4><input type="hidden" name="total_venta" id="total_venta"></th> 
                                </tfoot>';
	break;



	case 'listarDetalle':
		//Recibimos el idingreso
		$id=$_GET['id'];

		$rspta = $venta->listarDetalle($id);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio Venta</th>
                                    <th>Descuento</th>
                                    <th>Subtotal</th>
                                </thead>';

		while ($reg = $rspta->fetchObject())
				{
					echo '<tr class="filas"><td></td><td>'.$reg->nombre.'</td><td>'.$reg->cantidad.'</td><td>'.$reg->precio_venta.'</td><td>'.$reg->descuento.'</td><td>'.$reg->subtotal.'</td></tr>';
					$total=$total+($reg->precio_venta*$reg->cantidad-$reg->descuento);
				}
		echo '<tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><h4 id="total">S/.'.$total.'</h4><input type="hidden" name="total_venta" id="total_venta"></th> 
                                </tfoot>';
	break;

	case 'listar':
		$habilitacion=$_REQUEST["habilitacion"];
		$rspta=$venta->listar($habilitacion);
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
 				"0"=>((!$reg->vi)?'<a target="_blank" href="'.$url.$reg->idVenta.'"> <button class="btn btn-info"><i class="fa fa-print"></i></button></a>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idVenta.')"><i class="fa fa-eye"></i></button>'),
 				"1"=>$reg->idVenta,
 				"2"=>$reg->vh,
 				"3"=>$reg->fechaFactura,
 				"4"=>utf8_encode($reg->cn),
 				"5"=>$reg->usuario,
 				"6"=>$reg->dd,
 				"7"=>$reg->serie.'-'.$reg->nroFactura,
 				"8"=>$tipo,
 				"9"=>'<button class="btn btn-primary" onclick="mostrarDetalleVenta('.$reg->idVenta.')">Ver detalle de venta <i class="fa fa-pencil"></i></button>',
 				"10"=>'<button class="btn btn-success" onclick="mostrarDetalleCobro('.$reg->idVenta.')">Ver detalle de cobro <i class="fa fa-pencil"></i></button>',
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

	case 'listarArticulosVenta':

		$Persona_idPersona = $_REQUEST['Persona_idPersona'];
		$Sucursal_idSucursal = $_REQUEST['Sucursal_idSucursal'];
		$TerminoPago_idTerminoPago = $_REQUEST['terminoPago'];
		$buscar_art = $_REQUEST['buscar_art'];
		$parametro = '';//$_REQUEST['parametro'];
		require_once "../modelos/Articulo.php";
		$articulo=new Articulo();

		$rspta=$articulo->listarActivosVenta($Persona_idPersona, $Sucursal_idSucursal, $TerminoPago_idTerminoPago, $parametro, $buscar_art);
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


	case 'listarActivosVentaPromociones':
		require_once "../modelos/Articulo.php";
		$articulo=new Articulo();

		$rspta=$articulo->listarActivosVentaPromociones();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
			echo '<option value=' .$reg->idArticulo. '>' .$reg->nombre. '</option>';
 		}

	break;



	case 'selectArticulosVenta':
		require_once "../modelos/Articulo.php";
		$articulo=new Articulo();

		$rspta=$articulo->listarActivosVenta();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
			echo '<option value=' .$reg->idArticulo. '>' .$reg->na. '</option>';
 		}

	break;



	case 'habilitacion':
		$rspta=$venta->habilitacion($_POST['tipoDocumento']);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;


	case 'habilitacion2':
		$rspta=$venta->habilitacion2();
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;


	case 'ultimo':
		$rspta=$venta->ultimo();
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;


	case 'cambiarPersonaGiftCard':
		$rspta=$venta->cambiarPersonaGiftCard($idVenta,$clienteGiftCard);
 		echo $rspta ? "El cambio se proceso correctamente" : "El cambio no se pudo procesar";
	break;

	case 'cambiarNroGiftCard':
		$rspta=$venta->cambiarNroGiftCard($idVenta,$nroGiftCard);
 		echo $rspta ? "El cambio se proceso correctamente" : "El cambio no se pudo procesar";
	break;

	case "selectVenta":

		$rspta = $venta->selectVenta();
			echo "<option value='999'>Selccione una opcion</option>" ;
		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idVenta. '><strong>Razon Social: </strong>' .$reg->np. ' Total: ' .$reg->total. ' Nro. Factura: ' .$reg->serie .'-'. $reg->nroFactura. '</option>';
		}

		break;


	case 'datosVenta':
		$rspta=$venta->datosVenta($_GET['id']);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listarDetalleVenta':
		//Recibimos el idingreso
		$id=$_GET['id'];

		$rspta = $venta->listarDetalleVenta($id);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio Venta</th>
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

case 'listarproductosCodigo':


		$idPersona = $_POST['Persona_idPersona'];
		$terminoPago = $_POST['terminoPago'];
		$idArticulo = $_POST['idArticulo'];



		$rspta=$venta->listarproductosCodigo($idPersona, $terminoPago, $idArticulo);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);

break;

}

?>


