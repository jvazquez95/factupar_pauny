<?php 
if (strlen(session_id()) < 1) 
  session_start();

require_once "../modelos/Recibo.php";

$recibo=new Recibo();
$lcliente=isset($_POST["lcliente"])? limpiarCadena($_POST["lcliente"]):"";
$lidVenta=isset($_POST["lidVenta"])? limpiarCadena($_POST["lidVenta"]):"";
$idRecibo=isset($_POST["idRecibo"])? limpiarCadena($_POST["idRecibo"]):"";
$lcuota=isset($_POST["lcuota"])? limpiarCadena($_POST["lcuota"]):"";

$IDRECIBO=isset($_POST["IDRECIBO"])? limpiarCadena($_POST["IDRECIBO"]):"";
$CLIENTE_IDCLIENTE=isset($_POST["Cliente_idCliente"])? limpiarCadena($_POST["Cliente_idCliente"]):"";
$HABILITACION_IDHABILITACION=isset($_POST["Habilitacion_idHabilitacion"])? limpiarCadena($_POST["Habilitacion_idHabilitacion"]):"";
$NRORECIBO=isset($_POST["nroRecibo"])? limpiarCadena($_POST["nroRecibo"]):"";
$FECHARECIBO=isset($_POST["FECHARECIBO"])? limpiarCadena($_POST["FECHARECIBO"]):"";
$TOTAL=isset($_POST["total_ventan"])? limpiarCadena($_POST["total_ventan"]):"";
$Moneda_idMoneda=isset($_POST["Moneda_idMoneda"])? limpiarCadena($_POST["Moneda_idMoneda"]):"";
$tasaCambio=isset($_POST["tasaCambio"])? limpiarCadena($_POST["tasaCambio"]):"";
$tasaCambioBases=isset($_POST["tasaCambioBases"])? limpiarCadena($_POST["tasaCambioBases"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($IDRECIBO)){
			$rspta=$recibo->insertar($CLIENTE_IDCLIENTE,$HABILITACION_IDHABILITACION,$NRORECIBO,$FECHARECIBO,$TOTAL, $Moneda_idMoneda, $tasaCambio, $tasaCambioBases, $_POST['Venta_idVenta'],$_POST['montoAplicado'],$_POST['nroCuota'], $_POST['tipopago'], $_POST['nroReferencia'], $_POST['importe_detalle'], $_POST['banco']);

			//$rspta=$recibo->insertar($idcliente,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_recibo,$_POST["idarticulo"],$_POST["cantidad"],$_POST["precio_recibo"],$_POST["descuento"]);
			
			echo $rspta ? "recibo registrado" : "No se pudieron registrar todos los datos de la recibo";
		}
		else {
			echo "error";
		}
	break;

	case 'anular':
		$rspta=$recibo->anular($idRecibo);
 		echo $rspta ? "recibo anulado" : "recibo no se puede anular";
	break;

	case 'mostrar':
		$rspta=$recibo->mostrar($idrecibo);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listarDetalle':
		//Recibimos el idingreso
		$id=$_GET['id'];

		$rspta = $recibo->listarDetalle($id);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio recibo</th>
                                    <th>Descuento</th>
                                    <th>Subtotal</th>
                                </thead>';

		while ($reg = $rspta->fetchObject())
				{
					echo '<tr class="filas"><td></td><td>'.$reg->nombre.'</td><td>'.$reg->cantidad.'</td><td>'.$reg->precio_recibo.'</td><td>'.$reg->descuento.'</td><td>'.$reg->subtotal.'</td></tr>';
					$total=$total+($reg->precio_recibo*$reg->cantidad-$reg->descuento);
				}
		echo '<tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><h4 id="total">S/.'.$total.'</h4><input type="hidden" name="total_recibo" id="total_recibo"></th> 
                                </tfoot>';
	break;

	case 'listar':
		$habilitacion=$_REQUEST["habilitacion"];
		$rspta=$recibo->listar($habilitacion);
 		//Vamos a declarar un array
 		$data= Array();

		$url='../reportes/exRecibo.php?idRecibo=';
 		
 		while ($reg=$rspta->fetchObject()){
 		/*	if($reg->dd=='TICKET'){
 				$url='../reportes/exTicket.php?id=';
 			}
 			else{
 				$url='../reportes/exFactura.php?id=';
 			}
 		//$url='../reportes/exTicket.php?id=';*/
 			$data[]=array(
 				"0"=>((!$reg->INACTIVOD)?'</i></button><a target="_blank" href="'.$url.$reg->IDRECIBO.'"> <button class="btn btn-info"><i class="fa fa-print"></i></button>':
 					''),
 				"1"=>$reg->IDRECIBO,
 				"2"=>$reg->HABILITACION_IDHABILITACION,
 				"3"=>$reg->FECHARECIBO,
 				"4"=>utf8_encode($reg->nc),
 				"5"=>$reg->USUARIO,
 				"6"=>number_format($reg->TOTAL,0, ',', '.'),
 				"7"=>'<button class="btn btn-success" onclick="mostrarDetalleCobro('.$reg->IDRECIBO.')">Ver detalle de cobro <i class="fa fa-pencil"></i></button>',
 				"8"=>(!$reg->INACTIVOD)?'<span class="label bg-green">Activado</span>':
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

	case 'listarArticulosrecibo':
		require_once "../modelos/Articulo.php";
		$articulo=new Articulo();

		$rspta=$articulo->listarActivosrecibo();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idArticulo.',\''.$reg->na.'\',\''.$reg->preciorecibo.'\',\''.$reg->pi.'\')"><span class="fa fa-plus"></span></button>',
 				"1"=>$reg->na,
 				"2"=>$reg->ad,
 				"3"=>$reg->cn,
 				"4"=>$reg->codigoBarra,
 				"5"=>$reg->preciorecibo,
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
		$rspta=$recibo->habilitacion();
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'ultimo':
		$rspta=$recibo->ultimo();
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;


	case 'selectFacturasCliente':
		require_once "../modelos/Recibo.php";
		$recibo = new Recibo();
		echo '<option value="000">Seleccione una opcion</option>';

		$rspta = $recibo->listarFacturasPendientes($lcliente);

		while ($reg = $rspta->fetchObject())
				{
				echo '<option value=' . $reg->idVenta . '> Numero de factura: ' . $reg->nroFactura   . ' Fecha de factura: ' . $reg->fechaFactura  . ' Cantidad de cuotas: ' . $reg->cuotas .' Saldo pendiente: ' . $reg->saldo .'</option>';
				}
	break;


	case 'selectCuotasVenta':
		require_once "../modelos/Recibo.php";
		$recibo = new Recibo();
		echo '<option value="000">Seleccione una opcion</option>';

		$rspta = $recibo->listarCuotasVenta($lidVenta);

		while ($reg = $rspta->fetchObject())
				{
				echo '<option value=' . $reg->nroCuota . '>Nro. de cuota' . $reg->nroCuota   . ' Fecha de vencimiento: ' . $reg->fechaVencimiento  . ' MOnto de cuota:' . $reg->monto .' Saldo pendiente: ' . $reg->saldo .'</option>';
				}
	break;

	case 'montoCuota':
		require_once "../modelos/Recibo.php";
		$rspta =$recibo->montoCuota($lidVenta, $lcuota);
		echo json_encode($rspta);
	break;


}

?>


