<?php 
if (strlen(session_id()) < 1) 
  session_start();

require_once "../modelos/Compra.php";

$compra=new Compra();

$idcompra=isset($_POST["idcompra"])? limpiarCadena($_POST["idcompra"]):"";
$Proveedor_idProveedor=isset($_POST["Proveedor_idProveedor"])? limpiarCadena($_POST["Proveedor_idProveedor"]):"";
$Habilitacion_idHabilitacion=isset($_POST["Habilitacion_idHabilitacion"])? limpiarCadena($_POST["Habilitacion_idHabilitacion"]):"";
$Deposito_idDeposito=isset($_POST["Deposito_idDeposito"])? limpiarCadena($_POST["Deposito_idDeposito"]):"";
$TerminoPago_idTerminoPago=isset($_POST["TerminoPago_idTerminoPago"])? limpiarCadena($_POST["TerminoPago_idTerminoPago"]):"";
$tipo_comprobante=isset($_POST["tipo_comprobante"])? limpiarCadena($_POST["tipo_comprobante"]):"";
$nroFactura=isset($_POST["nroFactura"])? limpiarCadena($_POST["nroFactura"]):"";
$fechaFactura=isset($_POST["fechaFactura"])? limpiarCadena($_POST["fechaFactura"]):"";
$fechaVencimiento=isset($_POST["fechaVencimiento"])? limpiarCadena($_POST["fechaVencimiento"]):"";
$timbrado=isset($_POST["timbrado"])? limpiarCadena($_POST["timbrado"]):"";
$vtoTimbrado=isset($_POST["vtoTimbrado"])? limpiarCadena($_POST["vtoTimbrado"]):"";
$usuarioInsercion=isset($_POST["usuarioInsercion"])? limpiarCadena($_POST["usuarioInsercion"]):"";

//esto se corrigio y guarda bien.
$totalNeto=isset($_POST["totalImpuesto"])? limpiarCadena($_POST["totalImpuesto"]):"";
$total=isset($_POST["total_compra"])? limpiarCadena($_POST["total_compra"]):"";
$totalImpuesto=isset($_POST["total_compran"])? limpiarCadena($_POST["total_compran"]):"";


$tasaCambio=isset($_POST["tasaCambio"])? limpiarCadena($_POST["tasaCambio"]):"";
$tasaCambioBases=isset($_POST["tasaCambioBases"])? limpiarCadena($_POST["tasaCambioBases"]):"";
$Moneda_idMoneda=isset($_POST["Moneda_idMoneda"])? limpiarCadena($_POST["Moneda_idMoneda"]):"";
$cuotas=isset($_POST["cuotas"])? limpiarCadena($_POST["cuotas"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";
$CentroCosto_idCentroCosto=isset($_POST["CentroCosto_idCentroCosto"])? limpiarCadena($_POST["CentroCosto_idCentroCosto"]):"";
$OrdenCompra_idOrdenCompra=isset($_POST["OrdenCompra_idOrdenCompra"])? limpiarCadena($_POST["OrdenCompra_idOrdenCompra"]):"";
$HacerPedido_idHacerPedido=isset($_POST["HacerPedido_idHacerPedido"])? limpiarCadena($_POST["HacerPedido_idHacerPedido"]):"";
$tipoCompra=isset($_POST["tipoCompra"])? limpiarCadena($_POST["tipoCompra"]):"";



switch ($_GET["op"]){
	case 'guardaryeditar':

		if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
		{
			$imagen=$_POST["imagenactual"];
		}
		else 
		{
			$ext = explode(".", $_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
			{
				$imagen = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/compras/" . $imagen);
			}
		}


		if (empty($idcompra)){
			$rspta=$compra->insertar($tipoCompra, $OrdenCompra_idOrdenCompra, $HacerPedido_idHacerPedido, $CentroCosto_idCentroCosto, $Proveedor_idProveedor,$Habilitacion_idHabilitacion,$Deposito_idDeposito,$TerminoPago_idTerminoPago,$tipo_comprobante,$nroFactura,$fechaFactura,
				$fechaVencimiento,$timbrado,$vtoTimbrado,$totalImpuesto,$total,$totalNeto,$usuarioInsercion,$cuotas,$imagen,$_POST["idarticulo"],$_POST["descripcion"],$_POST["cantidad"],$_POST["costo"],
				$_POST["impuesto"], $_POST["TipoImpuesto_idTipoImpuesto"] ,$_POST["importe_detalle"],$_POST["tipopago"], $_POST["nroReferencia"], $tasaCambio, $tasaCambioBases, $Moneda_idMoneda, $_POST["descuento"], $_POST["devolver"]);
			//$rspta=$compra->insertar($Proveedor_idProveedor,$Habilitacion_idHabilitacion,$Deposito_idDeposito,$TerminoPago_idTerminoPago,$tipo_comprobante,$nroFactura,$fechaFactura,$fechaVencimiento,$timbrado,$vtoTimbrado,$totalImpuesto,$total,$totalNeto,$usuarioInsercion,$_POST["idarticulo"],$_POST["cantidad"],$_POST["preciocompra"],$_POST["impuesto"],$_POST["importe_detalle"],$_POST["tipopago"], $_POST["nroReferencia"]);

			//$rspta=$compra->insertar($idcliente,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_compra,$_POST["idarticulo"],$_POST["cantidad"],$_POST["precio_compra"],$_POST["descuento"]);
			
			echo $rspta ? "compra registrada" : "No se pudieron registrar todos los datos de la compra";
		}
		else {
		}
	break;

	case 'anular':
		$rspta=$compra->anular($idcompra);
 		echo $rspta ? "compra anulada" : "compra no se puede anular";
	break;

	case 'mostrar':
		$rspta=$compra->mostrar($idcompra);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;


	case 'listarDetalleOrdenCompra':
		//Recibimos el idingreso
		//Seria la tabla de las ordenes de compras ya recibidas.
		$id=$_GET['id'];

		$rspta = $compra->listarDetalleOrdenCompra($id);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio Compra</th>
                                    <th>Descuento</th>
                                    <th>Impuesto</th>
                                    <th>Total Neto</th>
                                    <th>Subtotal</th>
                                </thead>';

				        $contPrecio = 0;
						while ($reg = $rspta->fetchObject())
								{
								
									$devolver = $reg->faltante+$reg->devuelta;

											echo '<tr class="filas" id="fila'.$contPrecio.'">
						<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('.$contPrecio.')">X</button>
						</td><td><input type="hidden" name="idarticulo[]" id="idarticulo[]" value="'.$reg->Articulo_idArticulo.'">'.$reg->na.'</td>
						<td><input type="hidden" name="devolver[]" id="devolver[]" value="'.$devolver.'"><input type="number" name="cantidad[]" onblur="modificarSubototales()" id="cantidad[]" value="'.$reg->cantidadRecibida.'"></td>
				<td><input type="text" name="costo[]" onblur="modificarSubototales()"  id="costo[]"  value="'.$reg->precio.'"><br>Ult. comra: '.$reg->costoUltimaCompra.' Diferencia: '. ($reg->precio - $reg->costoUltimaCompra) .'</td>
						<td><input type="number" id="descuento[]" name="descuento[]" onblur="modificarSubototales()" value="'.$reg->descuento.'"></td>
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



	case 'listarDetalleCompra':
		//Recibimos el idingreso
		$id=$_GET['id'];

		$rspta = $compra->listarDetalleCompra($id);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio Compra</th>
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
						<td><input type="number" name="cantidad[]" onblur="modificarSubototales()" id="cantidad[]" value="'.($reg->devolver * -1).'"></td>
						<td><input type="text" name="costo[]" onblur="modificarSubototales()"  id="costo[]"  value="'.$reg->precio.'"></td>
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




	case 'listarDetalle':
		//Recibimos el idingreso
		$id=$_GET['id'];

		$rspta = $compra->listarDetalle($id);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio compra</th>
                                    <th>Descuento</th>
                                    <th>Subtotal</th>
                                </thead>';

		while ($reg = $rspta->fetchObject())
				{
					echo '<tr class="filas"><td></td><td>'.$reg->nombre.'</td><td>'.$reg->cantidad.'</td><td>'.$reg->precio_compra.'</td><td>'.$reg->descuento.'</td><td>'.$reg->subtotal.'</td></tr>';
					$total=$total+($reg->precio_compra*$reg->cantidad-$reg->descuento);
				}
		echo '<tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><h4 id="total">S/.'.$total.'</h4><input type="hidden" name="total_compra" id="total_compra"></th> 
                                </tfoot>';
	break;

	case 'listar':
		$rspta=$compra->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 		$url='../reportes/exTicket.php?id='; 			
 			if ($reg->tipo_comprobante == 1) {
 				$tipo = 'FACTURA';
 			}else{
 				$tipo = 'TICKET';
 			}

 			if ($reg->tipoCompra == 1) {
 				$tipo2 = 'Mercaderia';
 			}else{
 				$tipo2 = 'Gasto';
 			}

			$url='../reportes/exFacturaWebWhatsapp.php?id=';


 			$datos = "Nombre: ". $reg->nombre . "<br>Fecha de Factura: " . $reg->fechaFactura . "<br>Nro de Factura: " . $reg->nroFactura . "<br>Total: " . number_format($reg->total,2,',','.');

 			$data[]=array(
 				"0"=>"<a href='../files/compras/".$reg->imagen."' target='_blank'>Imagen Compra</a>",
 				"1"=>(!$reg->inactivo)?'<button class="btn btn-danger btn-xs" onclick="irAnularCompra( \''.$reg->idCompra.'\', \''.$datos.'\')"><i class="fa fa-close"></i></button>'.$reg->idCompra:
 					$reg->idCompra,
 				"2"=>$reg->deposito,
 				"3"=>$reg->terminoPago,
 				"4"=>$reg->nombre,
 				"5"=>$reg->fechaFactura,
 				"6"=>$reg->nroFactura,
 				"7"=>$reg->timbrado,
 				"8"=>$reg->vtoTimbrado,
 				"9"=>$reg->moneda,
 				"10"=>number_format($reg->totalImpuesto,2,',','.'),
 				"11"=>number_format($reg->totalNeto,2,',','.'),
 				"12"=>number_format($reg->total,2,',','.'),
 				"13"=>$reg->usuario,
 				"14"=>$reg->fechaTransaccion,
 				"15"=>$tipo,
 				"16"=>$tipo2,
 				"17"=>'
 							<button class="btn btn-primary" onclick="mostrarDetalleCompra('.$reg->idCompra.')">Ver detalle de compra <i class="fa fa-eye"></i></button><br><br>
 							<button class="btn btn-warning" onclick="mostrarDetalleAsiento('.$reg->idCompra.')">Previsualizar Asiento <i class="fa fa-eye"></i></button><br><br>
 							<button class="btn btn-info" onclick="mostrarDetalleFacturaCompra('.$reg->idCompra.')">Reporte PDF <i class="fa fa-book"></i></button>',
 				"18"=>'<button class="btn btn-success" onclick="mostrarDetallePago('.$reg->idCompra.')">Ver detalle de pago <i class="fa fa-eye"></i></button>',
 				"19"=>(!$reg->inactivo)?'<span class="label bg-green">Aceptado</span>':
 				'<span class="label bg-red">Anulado</span>',
 				"20"=>"<a href='../files/compras/".$reg->imagen."' target='_blank'>Imagen Compra</a>",

 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;





	case 'listarAutorizacionMercaderias':
		$rspta=$compra->listarAutorizacion();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			/*if($reg->tipo_comprobante=='Ticket'){
 				$url='../reportes/exTicket.php?id=';
 			}
 			else{
 				$url='../reportes/exFactura.php?id=';
 			}*/

 		$url='../reportes/exTicket.php?id=';
 			
 			if ($reg->tipo_comprobante == 1) {
 				$tipo = 'FACTURA';
 			}else{
 				$tipo = 'TICKET';
 			}

 			if ($reg->tipoCompra == 1) {



 			$data[]=array(
 				"0"=>'<button class="btn btn-success" onclick="mostrarDetalle('.$reg->idCompra.')">Analizar Compra compra <i class="fa fa-check"></i><br></button><button class="btn btn-primary" onclick="autorizarCompra('.$reg->idCompra.')">Autorizar compra <i class="fa fa-check"></i></button>',
 				"1"=>$reg->idCompra,
 				"2"=>$reg->Habilitacion_idHabilitacion,
 				"3"=>$reg->fechaFactura,
 				"4"=>$reg->cn,
 				"5"=>$reg->usuario,
 				"6"=>$tipo,
 				"7"=>$reg->nroFactura,
 				"8"=>number_format($reg->total,0,',','.'),
 				"9"=>'<button class="btn btn-primary" onclick="mostrarDetalleCompra('.$reg->idCompra.')">Ver detalle de compra <i class="fa fa-pencil"></i></button>',
 				"10"=>'<button class="btn btn-success" onclick="mostrarDetallePago('.$reg->idCompra.')">Ver detalle de pago <i class="fa fa-pencil"></i></button>',
 				"11"=>(!$reg->ci)?'<span class="label bg-green">Aceptado</span>':
 				'<span class="label bg-red">Anulado</span>',
 				"12"=>"<img src='../files/compras/".$reg->imagen."' height='50px' width='50px' >",

 				);
 		}
 				
 			}


 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);




	break;






	case 'listarAutorizacionGastos':
		$rspta=$compra->listarAutorizacion();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			/*if($reg->tipo_comprobante=='Ticket'){
 				$url='../reportes/exTicket.php?id=';
 			}
 			else{
 				$url='../reportes/exFactura.php?id=';
 			}*/

 		$url='../reportes/exTicket.php?id=';
 			
 			if ($reg->tipo_comprobante == 1) {
 				$tipo = 'FACTURA';
 			}else{
 				$tipo = 'TICKET';
 			}

 			if ($reg->tipoCompra == 2) {



	 			$data[]=array(
	 				"0"=>'<button class="btn btn-success" onclick="mostrarDetalle('.$reg->idCompra.')">Analizar Compra compra <i class="fa fa-check"></i><br></button><button class="btn btn-primary" onclick="autorizarCompra('.$reg->idCompra.')">Autorizar compra <i class="fa fa-check"></i></button>',
	 				"1"=>$reg->idCompra,
	 				"2"=>$reg->Habilitacion_idHabilitacion,
	 				"3"=>$reg->fechaFactura,
	 				"4"=>$reg->cn,
	 				"5"=>$reg->usuario,
	 				"6"=>$tipo,
	 				"7"=>$reg->nroFactura,
	 				"8"=>number_format($reg->total,0,',','.'),
	 				"9"=>'<button class="btn btn-primary" onclick="mostrarDetalleCompra('.$reg->idCompra.')">Ver detalle de compra <i class="fa fa-pencil"></i></button>',
	 				"10"=>'<button class="btn btn-success" onclick="mostrarDetallePago('.$reg->idCompra.')">Ver detalle de pago <i class="fa fa-pencil"></i></button>',
	 				"11"=>(!$reg->ci)?'<span class="label bg-green">Aceptado</span>':
	 				'<span class="label bg-red">Anulado</span>',
	 				"12"=>"<img src='../files/compras/".$reg->imagen."' height='50px' width='50px' >",

	 				);
	 		}


 				
 			}


	 		$results = array(
	 			"sEcho"=>1, //Información para el datatables
	 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
	 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
	 			"aaData"=>$data);
	 		echo json_encode($results);

	break;










	case 'autorizarCompra':
		
		$idCompra=  $_REQUEST['idCompra'];
		
		//$ti= 2; //$_REQUEST['ti'];
		session_start();
		$User = $_SESSION['login'];

		$rspta=$compra->autorizarCompra($idCompra);
 		$data= 1;
 		echo json_encode($data);

	break;



	case 'datosCompra':
		$rspta=$compra->datosCompra($_GET['id']);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'datosOC':
		$rspta=$compra->datosOC($_GET['id']);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;


	case 'selectProveedor':
		require_once "../modelos/Proveedor.php";
		$persona = new Proveedor();

		$rspta = $persona->listarActivos();

		while ($reg = $rspta->fetchObject())
				{
				echo '<option value=' . $reg->idProveedor . '>' . $reg->razonSocial . ' ' . $reg->nombreComercial  . ' ' . $reg->nroDocumento .' ' . $reg->celular .'</option>';
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

	case 'listarArticulosCompra':


		$rspta=$compra->listarActivoscompra();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idArticulo.',\''.$reg->nombre.'\',\''.$reg->costo.'\',\''.$reg->idTipoImpuesto.'\',\''.$reg->pi.'\')"><span class="fa fa-plus"></span></button>',
 				"1"=>utf8_encode($reg->na),
 				"2"=>utf8_encode($reg->ad),
 				"3"=>$reg->cn,
 				"4"=>$reg->codigoBarra,
 				"5"=>$reg->costo,
 				"6"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px' >"
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	break;

	case 'habilitacion':
		$rspta=$compra->habilitacion();
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'ultimo':
		$rspta=$compra->ultimo();
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;



	case "selectOC":

		$rspta = $compra->selectOC();
			echo "<option value='999'>Selccione una opcion</option>" ;
		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idOrdenCompraRecibido. '><strong>Razon Social: </strong>' .$reg->rs. '<strong>Factura: </strong>' .$reg->nroCompra. ' Termino de pago: ' .$reg->tpd. ' Sucursal: ' .$reg->ds. ' Deposito: ' .$reg->dd. ' Total: ' .$reg->total. '</option>';
		}

		break;



	case "selectCompra":

		$rspta = $compra->selectCompra();
			echo "<option value='999'>Selccione una opcion</option>" ;
		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idCompra. '><strong>Razon Social: </strong>' .$reg->np. ' Total: ' .$reg->total. '</option>';
		}

		break;



	case "selectCompraPorCentroDeCosto":



		$rspta = $compra->selectCompraPorCentroDeCosto($_POST['id']);
			echo "<option value='999'>Selccione una opcion</option>" ;
		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idCompra. '><strong>Razon Social: </strong>' .$reg->np. ' Total: ' .$reg->total. '</option>';
		}

		break;










case 'mostrarDetalle1':
		$id=$_REQUEST["id"];

		$rspta=$compra->mostrarDetalle1($id);


 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

		 			$data[]=array(

		 				"0"=>$reg->Articulo_idArticulo,
		 				"1"=>utf8_encode($reg->descripcion),
		 				"2"=>$reg->cantidad,
		 				"3"=>$reg->devuelta+$reg->faltante,
		 				"4"=>number_format($reg->precio, 2, ",", "."),
		 				);
		}
		 
		 $results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;



case 'mostrarDetalle2':
		$id=$_REQUEST["id"];

		$rspta=$compra->mostrarDetalle2($id);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

		 			$data[]=array(

		 				"0"=>$reg->Articulo_idArticulo,
		 				"1"=>utf8_encode($reg->descripcion),
		 				"2"=>$reg->cantidadC,
		 				"3"=>number_format($reg->precioC, 2, ",", "."),
		 				);
		}
		 
		 $results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;


case 'mostrarDetalleNC':
		$id=$_REQUEST["id"];

		$rspta=$compra->mostrarDetalleNC($id);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

		 			$data[]=array(

		 				"0"=>$reg->Articulo_idArticulo,
		 				"1"=>utf8_encode($reg->descripcion),
		 				"2"=>$reg->cantidadNC,
		 				"3"=>number_format($reg->precioNC, 2, ",", "."),
		 				);
		}
		 
		 $results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;


case 'mostrarDetalle3':
		$id=$_REQUEST["id"];

		$rspta=$compra->mostrarDetalle3($id);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 				if ($reg->imagen) {
 					$imagen = $reg->imagen;
 				}else{
 					$imagen = '1.png';
 				}

		 			$data[]=array(

		 				"0"=>"<img src='../files/compras/".$imagen."' height='1000px' width='1000px' >"
		 				);
		}
		 
		 $results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;


case 'mostrarDetalle4':
		$id=$_REQUEST["id"];

		$rspta=$compra->mostrarDetalle4($id);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 				if ($reg->imagen) {
 					$imagen = $reg->imagen;
 				}else{
 					$imagen = '1.png';
 				}

		 			$data[]=array(

		 				"0"=>"<img src='../files/notasCreditos/".$imagen."' height='1000px' width='1000px' >"
		 				);
		}
		 
		 $results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;




case 'listarproductos':

if(!empty($_POST["keyword"])) {


$query ="SELECT articulo.*, porcentajeImpuesto FROM articulo, tipoimpuesto where tipoimpuesto.idTipoImpuesto = articulo.TipoImpuesto_idTipoImpuesto and nombre like '%" . $_POST["keyword"] . "%' OR codigoBarra = '".$_POST["keyword"]."' OR codigo = '".$_POST["keyword"]."' ORDER BY nombre LIMIT 0,20";
$result = $conexion->query($query); 


if(!empty($result)) {
?>
<?php
$dataArray = Array();
foreach($result as $p) {
?>


<option onclick="agregarDetalle(<?php echo $p["idArticulo"]; ?>,<?php echo $p["nombre"]; ?>,
								<?php echo $p["precioVenta"]; ?>,
								<?php echo $p["TipoImpuesto_idTipoImpuesto"]?>,
								<?php echo $p["porcentajeImpuesto"]; ?>	)" d-precio="<?php echo $p["precioVenta"]?>" d-impuesto="<?php echo $p["porcentajeImpuesto"]?>" d-idImpuesto="<?php echo $p["TipoImpuesto_idTipoImpuesto"]?>" value="<?php echo $p["idArticulo"]; ?>">
	<?php echo $p["nombre"]; ?>
	<?php echo $p["idArticulo"]; ?>
	<?php echo $p["codigoBarra"]; ?>
</option>

<?php 
}// foreach


}//if

}//keyword

	break;

case 'listarproductos2':

if(!empty($_POST["keyword"])) {


$query ="SELECT articulo.*, porcentajeImpuesto FROM articulo, tipoimpuesto where tipoimpuesto.idTipoImpuesto = articulo.TipoImpuesto_idTipoImpuesto and nombre like '%" . $_POST["keyword"] . "%' OR codigoBarra = '".$_POST["keyword"]."' OR codigo = '".$_POST["keyword"]."' ORDER BY nombre LIMIT 0,20";
$result = $conexion->query($query); 


if(!empty($result)) {
?>
<?php
$dataArray = Array();
foreach($result as $p) {
?>


<option onclick="agregarDetalle(<?php echo $p["idArticulo"]; ?>,<?php echo $p["nombre"]; ?>,
								<?php echo $p["precioVenta"]; ?>,
								<?php echo $p["TipoImpuesto_idTipoImpuesto"]?>,
								<?php echo $p["porcentajeImpuesto"]; ?>	)" d-precio="<?php echo $p["precioVenta"]?>" d-impuesto="<?php echo $p["porcentajeImpuesto"]?>" d-idImpuesto="<?php echo $p["TipoImpuesto_idTipoImpuesto"]?>" value="<?php echo $p["idArticulo"]; ?>">
	<?php echo $p["nombre"]; ?>
	<?php echo $p["idArticulo"]; ?>
	<?php echo $p["codigoBarra"]; ?>
</option>

<?php 
}// foreach


}//if

}//keyword

	break;


	case 'listarproductos_sc':
		$query ="SELECT * FROM articulo  ORDER BY nombre";
		$result = $conexion->query($query);
		if(!empty($result)) {
		?>
		<?php
		$dataArray = Array();
		foreach($result as $p) {
		?>


		<option d-precio="<?php echo $p["precioVenta"]?>" d-impuesto="<?php echo $p["TipoImpuesto_idTipoImpuesto"]?>" value="<?php echo $p["idArticulo"]; ?>">
			<?php echo $p["nombre"]; ?>
			<?php echo $p["idArticulo"]; ?>
		</option>

		<?php 
		}// foreach


		}//if
	break;




}

?>


