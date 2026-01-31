<?php 
if (strlen(session_id()) < 1) 
  session_start();

require_once "../modelos/Pago.php";

$pago=new Pago();
$lProveedor=isset($_POST["lProveedor"])? limpiarCadena($_POST["lProveedor"]):"";
$lidCompra=isset($_POST["lidCompra"])? limpiarCadena($_POST["lidCompra"]):"";
$lcuota=isset($_POST["lcuota"])? limpiarCadena($_POST["lcuota"]):"";
$idPago=isset($_POST["idPago"])? limpiarCadena($_POST["idPago"]):"";
$lcuota=isset($_POST["lcuota"])? limpiarCadena($_POST["lcuota"]):"";

$idPago=isset($_POST["idPago"])? limpiarCadena($_POST["idPago"]):"";
$Proveedor_idProveedor=isset($_POST["Proveedor_idProveedor"])? limpiarCadena($_POST["Proveedor_idProveedor"]):"";
$Habilitacion_idHabilitacion=isset($_POST["Habilitacion_idHabilitacion"])? limpiarCadena($_POST["Habilitacion_idHabilitacion"]):"";
$NROPAGO=isset($_POST["NROPAGO"])? limpiarCadena($_POST["NROPAGO"]):"";
$FECHAPAGO=isset($_POST["FECHAPAGO"])? limpiarCadena($_POST["FECHAPAGO"]):"";
$Moneda_idMoneda=isset($_POST["Moneda_idMoneda"])? limpiarCadena($_POST["Moneda_idMoneda"]):"";
$tasaCambio=isset($_POST["tasaCambio"])? limpiarCadena($_POST["tasaCambio"]):"";
$tasaCambioBases=isset($_POST["tasaCambioBases"])? limpiarCadena($_POST["tasaCambioBases"]):"";
$TOTAL=isset($_POST["total_ventan"])? limpiarCadena($_POST["total_ventan"]):"";


switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idPago)){
			$rspta=$pago->insertar($Proveedor_idProveedor,$Habilitacion_idHabilitacion,$NROPAGO,$FECHAPAGO,$TOTAL, $_POST['Compra_idCompra'],$_POST['montoAplicado'],$_POST['nroCuota'], $_POST['tipopago'], $_POST['nroReferencia'], $_POST['importe_detalle'], $Moneda_idMoneda, $tasaCambio, $tasaCambioBases, $_POST['ChequePropio_idChequePropio1'] );

			//$rspta=$pago->insertar($idcliente,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_pago,$_POST["idarticulo"],$_POST["cantidad"],$_POST["precio_pago"],$_POST["descuento"]);
			
			echo $rspta ? "pago registrado" : "No se pudieron registrar todos los datos de la pago";
		}
		else {
			echo "error";
		}
	break;

	case 'anular':
		$rspta=$pago->anular($idPago);
 		echo $rspta ? "pago anulado" : "pago no se puede anular";
	break;

	case 'mostrar':
		$rspta=$pago->mostrar($idPago);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listarDetalle':
		//Recibimos el idingreso
		$id=$_GET['id'];

		$rspta = $pago->listarDetalle($id);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio pago</th>
                                    <th>Descuento</th>
                                    <th>Subtotal</th>
                                </thead>';

		while ($reg = $rspta->fetchObject())
				{
					echo '<tr class="filas"><td></td><td>'.$reg->nombre.'</td><td>'.$reg->cantidad.'</td><td>'.$reg->precio_pago.'</td><td>'.$reg->descuento.'</td><td>'.$reg->subtotal.'</td></tr>';
					$total=$total+($reg->precio_pago*$reg->cantidad-$reg->descuento);
				}
		echo '<tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><h4 id="total">S/.'.$total.'</h4><input type="hidden" name="total_pago" id="total_pago"></th> 
                                </tfoot>';
	break;

	case 'listar':
		$habilitacion=$_REQUEST["habilitacion"];
		$rspta=$pago->listar($habilitacion);
 		//Vamos a declarar un array
 		$data= Array();
			$url='../reportes/rptOp.php?idPago=';

 		while ($reg=$rspta->fetchObject()){
 		/*	if($reg->dd=='TICKET'){
 				$url='../reportes/exTicket.php?id=';
 			}
 			else{
 				$url='../reportes/exFactura.php?id=';
 			}
 		//$url='../reportes/exTicket.php?id=';*/
 			$data[]=array(
 				"0"=>((!$reg->pci)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idPago.')"><i class="fa fa-eye"></i></button><a target="_blank" href="'.$url.$reg->idPago.'"> <button class="btn btn-info"><i class="fa fa-file"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idPago.')"><i class="fa fa-eye"></i></button><a target="_blank" href="'.$url.$reg->idPago.'"> <button class="btn btn-info"><i class="fa fa-file"></i></button>'),
 				"1"=>$reg->idPago,
 				"2"=>$reg->HABILITACION_IDHABILITACION,
 				"3"=>$reg->FECHAPAGO,
 				"4"=>$reg->nc,
 				"5"=>$reg->USUARIO,
 				"6"=>number_format($reg->TOTAL,0, ',', '.'),
 				"7"=>'<button class="btn btn-success" onclick="mostrarDetalleCobro('.$reg->idPago.')">Ver detalle de pago <i class="fa fa-pencil"></i></button>',
 				"8"=>(!$reg->pci)?'<span class="label bg-green">Activado</span>':
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
		echo '<option value="000">Seleccione una opcion</option>';
		while ($reg = $rspta->fetchObject())
		{
			echo '<option value=' . $reg->idCliente . '>' . $reg->razonSocial . ' ' . $reg->nombreComercial  . ' ' . $reg->nroDocumento .' ' . $reg->celular .'</option>';
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

	case 'listarArticulospago':
		require_once "../modelos/Articulo.php";
		$articulo=new Articulo();

		$rspta=$articulo->listarActivospago();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idArticulo.',\''.$reg->na.'\',\''.$reg->preciopago.'\',\''.$reg->pi.'\')"><span class="fa fa-plus"></span></button>',
 				"1"=>$reg->na,
 				"2"=>$reg->ad,
 				"3"=>$reg->cn,
 				"4"=>$reg->codigoBarra,
 				"5"=>$reg->preciopago,
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
		$rspta=$pago->habilitacion();
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'ultimo':
		$rspta=$pago->ultimo();
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;


	case 'selectFacturasProveedor':

		echo '<option value="0">Seleccione una opcion</option>';

		$rspta = $pago->selectFacturasProveedor($lProveedor);

		while ($reg = $rspta->fetchObject())
				{
				echo '<option value=' . $reg->idCompra . '> Numero de factura: ' . $reg->nroFactura   . ' Fecha de factura: ' . $reg->fechaFactura  . ' Fecha de vencimiento ' . $reg->fechaVencimiento .' Saldo pendiente: ' . $reg->saldo .'</option>';
				}
	break;


	case 'selectCuotasCompra':

		echo '<option value="0">Seleccione una opcion</option>';

		$rspta = $pago->listarCuotasCompra($lidCompra);

		while ($reg = $rspta->fetchObject())
				{
				echo '<option value=' . $reg->nroCuota . '>Nro. de cuota' . $reg->nroCuota   . ' Fecha de vencimiento: ' . $reg->fechaVencimiento  . ' Monto de cuota:' . $reg->monto .' Saldo pendiente: ' . $reg->saldo .'</option>';
				}
	break;

	case 'montoCuota':

		$rspta =$pago->montoCuota($lidCompra,$lcuota);
		echo json_encode($rspta);
	break;


	case 'cargarMoneda':
		$rspta=$pago->cargarMoneda($_POST['Compra_idCompra']);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;



}

?>


