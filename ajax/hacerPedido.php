<?php 
if (strlen(session_id()) < 1) 
  session_start();

require_once "../modelos/HacerPedido.php";

$hacerPedido=new HacerPedido();

$idVenta=isset($_POST["idVenta"])? limpiarCadena($_POST["idVenta"]):"";
$Cliente_idCliente=isset($_POST["Cliente_idCliente"])? limpiarCadena($_POST["Cliente_idCliente"]):"";
$Habilitacion_idHabilitacion=isset($_POST["Habilitacion_idHabilitacion"])? limpiarCadena($_POST["Habilitacion_idHabilitacion"]):"";
$Deposito_idDeposito=isset($_POST["Deposito_idDeposito"])? limpiarCadena($_POST["Deposito_idDeposito"]):"";
$TerminoPago_idTerminoPagoCabecera=isset($_POST["TerminoPago_idTerminoPagoCabecera"])? limpiarCadena($_POST["TerminoPago_idTerminoPagoCabecera"]):"";
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



switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idVenta)){
			$rspta=$venta->insertar($Cliente_idCliente,$Habilitacion_idHabilitacion,$Deposito_idDeposito,$TerminoPago_idTerminoPagoCabecera,$tipo_comprobante,$nroFactura,$fechaFactura,$fechaVencimiento,$timbrado,$vtoTimbrado,$totalImpuesto,$total,$totalNeto,$usuarioInsercion,$serie,$cuotas,$giftCard,$nroGiftCard,$clienteGiftCard,$Empleado_idEmpleado,$_POST["idarticulo"],$_POST["cantidad"],$_POST["precioVenta"],$_POST["impuesto"],$_POST["importe_detalle"],$_POST["tipopago"], $_POST["nroReferencia"]);


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

	case 'mostrar':
		$rspta=$venta->mostrar($idventa);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
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



	case 'generarCierreCosto':
		$CentroCosto_idCentroCosto=$_REQUEST["CentroCosto_idCentroCosto"];
		$rspta=$hacerPedido->generarCierreCosto($CentroCosto_idCentroCosto);
 		
 		echo $rspta ? "Pedido Generado" : "Error al generar, intente nuevamente";

	break;


	case 'generarPedido':
		$idProveedor=$_REQUEST["idProveedor"];
		$meses=$_REQUEST["meses"];
		$Sucursal_idSucursal=$_REQUEST["Sucursal_idSucursal"];
		$tipo=$_REQUEST["tipo"];
		
		$rspta=$hacerPedido->generarPedido($idProveedor, $meses, $Sucursal_idSucursal, $tipo);
 		
 		echo $rspta ? "Pedido Generado" : "Error al generar, intente nuevamente";

	break;



	case 'generarPedidoArticulo':
		$idHacerPedido=$_REQUEST["idHacerPedido"];
		$Sucursal_idSucursal=$_REQUEST["Sucursal_idSucursal"];
		$Articulo_idArticulo=$_REQUEST["Articulo_idArticulo"];
		
		$rspta=$hacerPedido->generarPedidoArticulo($idHacerPedido, $Articulo_idArticulo, $Sucursal_idSucursal);
 		
 		echo $rspta ? "Pedido Generado" : "Error al generar, intente nuevamente";

	break;



	case 'generarPedidoArticuloD2':
		$idOrdenCompra=$_REQUEST["idOrdenCompra"];
		$Articulo_idArticulo=$_REQUEST["Articulo_idArticulo"];
		
		$rspta=$hacerPedido->generarPedidoArticuloD2($idOrdenCompra, $Articulo_idArticulo);
 		
 		echo $rspta ? "Pedido Generado" : "Error al generar, intente nuevamente";

	break;


	case 'generarOc':
		$idHacerPedido=$_REQUEST["idHacerPedido"];
		
		$rspta=$hacerPedido->generarOC($idHacerPedido);
 		
 		echo $rspta ? 1 : 2;

	break;


case 'mostrarDetalleProveedor':
		$idArticulo=$_REQUEST["idArticulo"];
		$idSucursal=$_REQUEST["idSucursal"];

		$rspta=$hacerPedido->mostrarDetalleProveedor($idArticulo,$idSucursal);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

		 			$data[]=array(

		 				"0"=>$reg->periodo,
		 				"1"=>$reg->venta,
		 				"2"=>$reg->devolucion,
		 				"3"=>number_format($reg->costo, 0, ",", "."),
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
		$idArticulo=$_REQUEST["idArticulo"];
		$idSucursal=$_REQUEST["idSucursal"];

		$rspta=$hacerPedido->mostrarDetalle2($idArticulo);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){


 					if ($reg->precioAnterior > $reg->precioNuevo) {
 						$color = 'red';
 					}else{
 						$color = 'black';
 					}

		 			$data[]=array(

		 				"0"=>$reg->usuario,
		 				"1"=>"<font color = ".$color.">".number_format($reg->precioAnterior, 2, ",", ".")."</font>",
		 				"2"=>number_format($reg->precioNuevo, 2, ",", "."),
		 				"3"=>$reg->fecha,
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
		$idArticulo=$_REQUEST["idArticulo"];
		$idSucursal=$_REQUEST["idSucursal"];

		$rspta=$hacerPedido->mostrarDetalle3($idArticulo);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

		 			$data[]=array(

		 				"0"=>$reg->fechaTransaccion,
		 				"1"=>$reg->fechaFactura,
		 				"2"=>$reg->nroFactura,
		 				"3"=>$reg->ns,
		 				"4"=>$reg->cantidad,
		 				"5"=>$reg->devolucion,
		 				"6"=>number_format($reg->costo, 2, ",", "."),
		 				"7"=>number_format($reg->descuento, 2, ",", "."),
		 				"8"=>number_format($reg->subtotal, 2, ",", "."),
		 				);
		}
		 
		 $results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;





case 'mostrarDetalleProrrateo':
		$id=$_REQUEST["id"];
		$tipo=1;//$_REQUEST["tipo"];

		$rspta=$hacerPedido->mostrarDetalleProrrateo($id);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){


 			$data[]=array(
 				"0"=>$reg->nombreComercial,
 				"1"=>$reg->idCompra,
 				"2"=>$reg->nroFactura,
 				"3"=>number_format($reg->totalFactura, 2, ",", "."),
 				"4"=>number_format($reg->totalMercaderiaPorProveedor, 2, ",", "."),
 				"5"=>number_format($reg->gastoCompartido, 2, ",", "."),
 				"6"=>number_format($reg->gastosPorProveedor, 2, ",", "."),
 				"7"=>number_format($reg->costoGlobal, 2, ",", "."),
 				"8"=>number_format($reg->costoParticular, 2, ",", "."),
 				"9"=>number_format($reg->costoProrrateado, 2, ",", "."),
 				"10"=>number_format($reg->PorcentajeProrrateo, 2, ",", ".") 
 				);

 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;






case 'mostrarDetalle':
		$idHacerPedido=$_REQUEST["idHacerPedido"];
		$tipo=1;//$_REQUEST["tipo"];

		$rspta=$hacerPedido->mostrarDetalle($idHacerPedido, $tipo);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){





 			$data[]=array(
 				"0"=>$reg->idHacerPedidoDetalle,
 				"1"=>$reg->categoria,
 				"2"=>$reg->grupo,
 				"3"=>$reg->idArticulo,
 				"4"=>$reg->pkSucursal,
 				"5"=>'<i class="fa fa-barcode" style="font-size:24px;color:red"></i>'.$reg->codigoBarra,
 				"6"=>$reg->codigoAlternativo,
 				"7"=>$reg->ns,
				"8"=>'<input  type="checkbox" id="cbox1" onclick="descontinuar(this,\''.$reg->idArticulo.'\');"> Descontinuar</label><br>',
				"9"=>'<button class="btn btn-primary" onclick="editarNombre('.$reg->idArticulo.',\''.utf8_encode($reg->productos).'\')"><i class="fa fa-pencil"></i></button>'.' '.utf8_encode($reg->productos),
				"10"=>'<input class="text-right" type="text" name="StockPromedio[]"  style="width:100%;" onblur="actualizarCantidadCaja(this,\''.$reg->idArticulo.'\')"  id="StockPromedio[]" style="width:100%;" value="'.$reg->cantidadCaja.'" />',
				"11"=>'<input class="text-right" type="text" name="margen[]" id="margen'.$reg->idHacerPedidoDetalle.'" onblur="actualizarMargen(this,\''.$reg->idArticulo.'\',\''.$reg->pkSucursal.'\',\''.$reg->margen.'\')" style="width:100%;" value="'.$reg->margen.'" />',
				"12"=>$reg->aRecibir,
				"13"=>'<input class="text-right" type="text" name="StockPromedio[]" id="StockPromedio[]" onblur="actualizarPedido(this,\''.$reg->idHacerPedidoDetalle.'\')" style="width:100%;" value="'.$reg->pedidos.'" />',
 				"14"=>$reg->promedioMes,
 				"15"=>$reg->stock,
 				"16"=>$reg->stockMinimo,
 				"17"=>$reg->stockMaximo,
 				"18"=>number_format($reg->costoUltimaCompra, 2, ",", "."),
 				"19"=>number_format($reg->costo, 2, ",", "."),
 				"20"=>number_format($reg->precio, 2, ",", "."),
 				"21"=>number_format($reg->precioVenta, 2, ",", "."),
 				"22"=>number_format($reg->precio - $reg->costo, 2, ",", "."),
 				);

 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;





case 'mostrarDetalleCierreCosto':
		$id=$_REQUEST["id"];
		$tipo=1;//$_REQUEST["tipo"];

		$rspta=$hacerPedido->mostrarDetalleCierreCosto($id);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){


 			$data[]=array(
 				"0"=>$reg->idcierrecostodetalle,
 				"1"=>$reg->fechaFactura,
 				"2"=>$reg->Compra_idCompra,
 				"3"=>$reg->np,
 				"4"=>$reg->nroFactura,
 				"5"=>$reg->total,
 				"6"=>'Valor actual: '. ($reg->tipoCompra + 1) .'<br><input type="radio" name="test'.$reg->idcierrecostodetalle.'" id="cbox1" onchange="facturapormercaderia(this,\''.$reg->idcierrecostodetalle.'\', 0);"> Factura por Mercaderia</label><br><input type="radio" name="test'.$reg->idcierrecostodetalle.'" id="cbox1" onchange="facturaporgastoparticular(this,\''.$reg->idcierrecostodetalle.'\', 1);"> Factura por Gasto Particular</label><br><input type="radio" name="test'.$reg->idcierrecostodetalle.'" id="cbox1" onchange="facturaporgastogeneral(this,\''.$reg->idcierrecostodetalle.'\', 2);"> Factura por gasto general</label><br>',
"7"=>'<input type="text" name="Compra_idCompraAsignada[]" onclick="buscarFactura(this,\''.$reg->idcierrecostodetalle.'\')"  style="width:100%;" onblur="actualizarCompraAsignada(this,\''.$reg->idcierrecostodetalle.'\')"  id="Compra_idCompraAsignada'.$reg->idcierrecostodetalle.'" style="width:100%;" value="'.$reg->Compra_idCompraAsignada.'" />',
"8"=>'<input type="text" name="comentario[]"  style="width:100%;" onblur="actualizarComentario(this,\''.$reg->idcierrecostodetalle.'\')"  id="comentario[]" style="width:100%;" value="'.$reg->comentario.'" />',
					);

 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;









	case 'listar':
		$idProveedor=$_REQUEST["idProveedor"];
		$fi=$_REQUEST["fi"];
		$ff=$_REQUEST["ff"];
		$estado=$_REQUEST["estado"];
		$Sucursal_idSucursal=$_REQUEST["Sucursal_idSucursal"];
		$rspta=$hacerPedido->listar($idProveedor, $fi, $ff, $estado, $Sucursal_idSucursal);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 		$url='../reportes/exTicket.php?id=';
 			$data[]=array(
 				"0"=>((!$reg->hpi)?'<button class="btn btn-primary" onclick="mostrarDetalle('.$reg->idHacerPedido.',\''.$reg->tipo.'\')">Ver detalle <i class="fa fa-pencil"></i></button>':
 					''),
 				"1"=>$reg->idHacerPedido,
 				"2"=>utf8_encode($reg->np),
 				"3"=>$reg->fecha,
 				"4"=>$reg->total,
 				"5"=>$reg->usuarioInsercion,
 				"6"=>$reg->fechaInsercion,
 				"7"=>$reg->usuarioModificacion,
 				"8"=>$reg->fechaModificacion,
 				"9"=>'<button class="btn btn-primary" onclick="mostrarDetalle('.$reg->idHacerPedido.',\''.$reg->tipo.'\')">Ver detalle <i class="fa fa-pencil"></i></button>',
 				"10"=>(!$reg->hpi)?'<span class="label bg-green">Aceptado</span>':
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


	case 'listarCierreCosto':
		$CentroCosto_idCentroCosto=$_REQUEST["CentroCosto_idCentroCosto"];


		$rspta=$hacerPedido->listarCierreCosto($CentroCosto_idCentroCosto);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-primary" onclick="mostrarDetalle('.$reg->idcierrecosto.')">Ver detalle <i class="fa fa-pencil"></i></button>':'',
 				"1"=>$reg->idcierrecosto,
 				"2"=>utf8_encode($reg->ncc),
 				"3"=>$reg->fechaTransaccion,
 				"4"=>$reg->usuarioInsercion,
 				"5"=>$reg->fechaModificacion,
 				"6"=>$reg->usuarioModificacion,
 				"7"=>'<button class="btn btn-primary" onclick="mostrarDetalle('.$reg->idcierrecosto.')">Ver detalle <i class="fa fa-pencil"></i></button>',
 				"8"=>(!$reg->inactivo)?'<span class="label bg-green">Aceptado</span>':
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


	case 'actualizarComentario':
		
		$comentario=  $_REQUEST['comentario'];
		$idcierrecostodetalle= $_REQUEST['idcierrecostodetalle'];
		
		//$ti= 2; //$_REQUEST['ti'];
		session_start();
		$User = $_SESSION['login'];

		$rspta=$hacerPedido->actualizarComentario($comentario, $idcierrecostodetalle);
 		//$data= 1;
 		echo json_encode($rspta);

	break;


	case 'actualizarRadio':
		
		$x=  $_REQUEST['x'];
		$idcierrecostodetalle= $_REQUEST['idcierrecostodetalle'];
		
		//$ti= 2; //$_REQUEST['ti'];
		session_start();
		$User = $_SESSION['login'];

		$rspta=$hacerPedido->actualizarRadio($x, $idcierrecostodetalle);
 		//$data= 1;
 		echo json_encode($rspta);

	break;



	case 'actualizarCompraAsignada':
		
		$idCompraAsignada=  $_REQUEST['idCompraAsignada'];
		$idcierrecostodetalle= $_REQUEST['idcierrecostodetalle'];
		
		//$ti= 2; //$_REQUEST['ti'];
		session_start();
		$User = $_SESSION['login'];

		$rspta=$hacerPedido->actualizarCompraAsignada($idCompraAsignada, $idcierrecostodetalle);
 		//$data= 1;
 		echo json_encode($rspta);

	break;




	case 'actualizarCantidadCaja':
		
		$cantidadCaja=  $_REQUEST['cantidad'];
		$Articulo_idArticulo= $_REQUEST['Articulo_idArticulo'];
		
		//$ti= 2; //$_REQUEST['ti'];
		session_start();
		$User = $_SESSION['login'];

		$rspta=$hacerPedido->actualizarCantidadCaja($cantidadCaja, $Articulo_idArticulo);
 		//$data= 1;
 		echo json_encode($rspta);

	break;


	case 'actualizarNombreProducto':
		
		$nombre=  $_REQUEST['nombre'];
		$Articulo_idArticulo= $_REQUEST['Articulo_idArticulo'];
		
		//$ti= 2; //$_REQUEST['ti'];
		session_start();
		$User = $_SESSION['login'];

		$rspta=$hacerPedido->actualizarNombreProducto($nombre, $Articulo_idArticulo);
 		$data= 1;
 		echo json_encode($data);

	break;

	case 'actualizarPedido':
		
		$cantidad=  $_REQUEST['cantidad'];
		$idHacerPedidoDetalle= $_REQUEST['idHacerPedidoDetalle'];
		
		//$ti= 2; //$_REQUEST['ti'];
		session_start();
		$User = $_SESSION['login'];

		$rspta=$hacerPedido->actualizarPedido($cantidad, $idHacerPedidoDetalle);
 		$data= 1;
 		echo json_encode($data);

	break;


	case 'actualizarMargen':
		
		$Articulo_idArticulo =  $_REQUEST['Articulo_idArticulo'];
		$Sucursal_idSucursal =  $_REQUEST['Sucursal_idSucursal'];
		$margen =  $_REQUEST['margen'];
		
		//$ti= 2; //$_REQUEST['ti'];
		session_start();
		$User = $_SESSION['login'];

		$rspta=$hacerPedido->actualizarMargen($Articulo_idArticulo, $Sucursal_idSucursal, $margen);
 		$data= 1;
 		echo json_encode($data);

	break;


	case 'descontinuar':
		
		$check=  $_REQUEST['check'];
		$idArticulo= $_REQUEST['idArticulo'];
		

		$rspta=$hacerPedido->descontinuar($check, $idArticulo);
 		$data= 1;
 		echo json_encode($data);

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
				echo '<option value=' . $reg->IDBANCO . '>' . $reg->DESCRIPCION . '</option>';
				}
	break;

	case 'listarArticulosVenta':

		$Persona_idPersona = $_REQUEST['Persona_idPersona'];
		require_once "../modelos/Articulo.php";
		$articulo=new Articulo();

		$rspta=$articulo->listarActivosVenta($Persona_idPersona);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idArticulo.',\''.$reg->na.'\',\''.$reg->precioLista.'\',\''.$reg->pi.'\')"><span class="fa fa-plus"></span></button>',
 				"1"=>$reg->na,
 				"2"=>$reg->ad,
 				"3"=>$reg->cn,
 				"4"=>$reg->codigoBarra,
 				"5"=>$reg->precioLista,
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
		$rspta=$venta->habilitacion();
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


}

?>


