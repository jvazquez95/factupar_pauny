<?php 
if (strlen(session_id()) < 1) 
  session_start();

require_once "../modelos/VentaRemision.php"; 

$ordenVenta=new VentaRemision(); 

$idOrdenVenta=isset($_POST["idOrdenVenta"])? limpiarCadena($_POST["idOrdenVenta"]):"";
$Persona_idPersona=isset($_POST["Persona_idPersona"])? limpiarCadena($_POST["Persona_idPersona"]):"";
$Habilitacion_idHabilitacion=isset($_POST["Habilitacion_idHabilitacion"])? limpiarCadena($_POST["Habilitacion_idHabilitacion"]):"";
$Deposito_idDeposito=isset($_POST["Deposito_idDeposito"])? limpiarCadena($_POST["Deposito_idDeposito"]):"";
$TerminoPago_idTerminoPago=isset($_POST["TerminoPago_idTerminoPago"])? limpiarCadena($_POST["TerminoPago_idTerminoPago"]):"";
$fecha=isset($_POST["fecha"])? limpiarCadena($_POST["fecha"]):"";
$tipo=isset($_POST["tipo"])? limpiarCadena($_POST["tipo"]):"";
$formaEntrega=isset($_POST["formaEntrega"])? limpiarCadena($_POST["formaEntrega"]):"";
$fechaEntrega=isset($_POST["fechaEntrega"])? limpiarCadena($_POST["fechaEntrega"]):"";


switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idOrdenVenta)){
			$rspta=$ordenVenta->insertar($Persona_idPersona,$Habilitacion_idHabilitacion,$Deposito_idDeposito,$TerminoPago_idTerminoPago,$fecha,$_POST["idarticulo"],$_POST["cantidad"],$_POST["precioVenta"],$_POST["descuento"],$_POST["impuesto"],$_POST["capital"],$_POST["interes"], $tipo, $formaEntrega, $fechaEntrega);
			
			echo $rspta ? "ordenVenta registrada" : "No se pudieron registrar todos los datos de la ordenVenta";
		}
		else {
		}
	break;

	case 'anular':
		$rspta=$ordenVenta->anular($idOrdenVenta);
 		echo $rspta ? "ordenVenta anulada" : "ordenVenta no se puede anular";
	break;

	case 'mostrar':
		$rspta=$ordenVenta->mostrar($idOrdenVenta);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listarDetalle':
		//Recibimos el idingreso
		$id=$_GET['id'];

		$rspta = $ordenVenta->listarDetalle($id);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio ordenVenta</th>
                                    <th>Descuento</th>
                                    <th>Subtotal</th>
                                </thead>';

		while ($reg = $rspta->fetchObject())
				{
					echo '<tr class="filas"><td></td><td>'.$reg->nombre.'</td><td>'.$reg->cantidad.'</td><td>'.$reg->precio_ordenVenta.'</td><td>'.$reg->descuento.'</td><td>'.$reg->subtotal.'</td></tr>';
					$total=$total+($reg->precio_ordenVenta*$reg->cantidad-$reg->descuento);
				}
		echo '<tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><h4 id="total">S/.'.$total.'</h4><input type="hidden" name="total_ordenVenta" id="total_ordenVenta"></th> 
                                </tfoot>';
	break;

	case 'listar':
		$habilitacion=$_REQUEST["habilitacion"];
		$rspta=$ordenVenta->listar($habilitacion);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			if($reg->dd=='TICKET'){
 				$url='../reportes/exTicket.php?id=';
 			}
 			else{
 				$url='../reportes/exFactura.php?id=';
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
			
			if ($reg->formaEntrega == 1) {
 				$formaEntrega = 'En el Local';
 			}
			if ($reg->formaEntrega == 2) {
 				$formaEntrega = 'Delivery';
 			}
			
			if ($reg->tipo == 1) {
 				$tipo = 'Normal';
 			}
			if ($reg->tipo == 2) {
 				$tipo = 'Presupuesto';
 			}
			
 		//$url='../reportes/exTicket.php?id=';
			$url='../reportes/rptOv.php?idOrdenVenta=';
 			$data[]=array(
 				"0"=>((!$reg->ovi)?'<a target="_blank" href="'.$url.$reg->idOrdenVenta.'"> <button class="btn btn-info"><i class="fa fa-file"></i></button></a>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idOrdenVenta.')"><i class="fa fa-eye"></i></button>'),
 				"1"=>$reg->idOrdenVenta,
 				"2"=>$reg->fecha,
 				"3"=>$reg->rs,
 				"4"=>$reg->Habilitacion_idHabilitacion,
 				"5"=>$reg->Deposito_idDeposito,
 				"6"=>$reg->tpd,
 				"7"=>$formaEntrega,
 				"8"=>$tipo,
 				"9"=>$reg->total,
 				"10"=>$reg->ovui,
 				"11"=>$reg->ovum,
 				"12"=>'<button class="btn btn-primary" onclick="mostrarDetalleordenVenta('.$reg->idOrdenVenta.')">Ver detalle de ordenVenta <i class="fa fa-pencil"></i></button>',
 				"13"=>(!$reg->ovi)?'<span class="label bg-green">Aceptado</span>':
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
	
	case 'listarAFacturar':
		$habilitacion=$_REQUEST["habilitacion"];
		$rspta=$ordenVenta->listarAFacturar($habilitacion);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			if($reg->dd=='TICKET'){
 				$url='../reportes/exTicket.php?id=';
 			}
 			else{
 				$url='../reportes/exFacturaFormRemision.php?id=';
 			}

 			if ($reg->TerminoPago_idTerminoPago == 0) {
 				$tipo = 'CONTADO';
 			}else{
 				$tipo = 'CREDITO';
 			}

 			if ($reg->facturado == 1) {
 				$facturado = 1;
 			}else{
 				$facturado = 0;
 			}
			
			if ($reg->vi == 1) {
 				$saldo = 0;
 			}else{
 				$saldo = $reg->saldo;
 			}
			if ($reg->formaEntrega == 1) {
 				$formaEntrega = 'En el Local';
 			}
			if ($reg->formaEntrega == 2) {
 				$formaEntrega = 'Delivery';
 			}
 		$urlPagare='../reportes/exPagare.php?id=';
			
 			$data[]=array(
 				"0"=>
				'<button class="btn btn-warning" onclick="generarFactura(\''.$reg->idOrdenVenta.'\',\''.$reg->Deposito_idDeposito.'\', \''.$reg->TerminoPago_idTerminoPago.'\',\''.$reg->ovui.'\',\''.$reg->idPersona.'\',\''.$reg->contado.'\')"> Generar Remision</button>'.
				(((!$reg->ovi)?'':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idOrdenVenta.')"><i class="fa fa-eye"></i></button>')
					) 
					,
 				"1"=>$reg->idOrdenVenta,
 				"2"=>$reg->fecha,
 				"3"=>($reg->rs),
 				"4"=>$reg->Habilitacion_idHabilitacion,
 				"5"=>$reg->Deposito_idDeposito,
 				"6"=>$reg->tpd,
 				"7"=>$formaEntrega,
 				"8"=>$reg->fechaEntrega,
 				"9"=>$reg->total,
 				"10"=>$reg->ovui,
 				"11"=>$reg->ovum,
 				"12"=>'<button class="btn btn-success" onclick="mostrarExtracto('.$reg->idPersona.')">Generar Extracto <i class="fa fa-pencil"></i></button><br><br><button class="btn btn-primary" onclick="mostrarDetalleordenVenta('.$reg->idOrdenVenta.')">Ver detalle de ordenVenta <i class="fa fa-pencil"></i></button>',
 				"13"=>(!$reg->ovi)?'<span class="label bg-green">Aceptado</span>':
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



	case 'listarDetalleOrdenVenta':
		//Recibimos el idingreso
		$id=$_GET['id'];

		$rspta = $ordenVenta->listarDetalleOrdenVenta($id);
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
						while ($reg = $rspta->fetchObject()) {
							$maxRemisionable = ($reg->stock_real <= $reg->cantidadRemision)
								? $reg->stock_real
								: $reg->cantidadRemision;
						
							echo '<tr class="filas" id="fila'.$cont.'">
							<td>
								<input type="hidden" name="interes[]" id="interes[]" value="'.$reg->interes.'">
								<input type="hidden" name="capital[]" id="capital[]" value="'.$reg->capital.'">
								<input type="hidden" name="saldoStock[]" id="saldoStock[]" value="'.$reg->cantidadStock.'">
								
								<button type="button" class="btn btn-danger" onclick="eliminarDetalle('.$cont.')">X</button>
							</td>
						
							<td><input type="hidden" name="idarticulo[]" id="idarticulo[]" value="'.$reg->Articulo_idArticulo.'">'.$reg->na.'</td>
							<input type="hidden" name="cant_max[]" id="cant_max[]" value="'.$reg->cantidadRemision.'" readonly>
							<input type="hidden" name="VentaDetalle_idVentaDetalle[]" id="VentaDetalle_idVentaDetalle[]" value="'.$reg->idDetalleVenta.'" >
						
							<td class="align-middle">
								<input  type="number"
										name="cantidad[]"
										id="cantidad[]"
										value="'.$reg->cantidadRemision.'"
										min="0"
										max="'.$maxRemisionable.'"
										step="1"
										onblur="modificarSubototales()"
										style="width:80px"
								>
						
								<div style="font-size:90%;margin-top:4px">
									Cantidad pendiente de remisión:&nbsp;
									<span class="badge badge-warning"
										style="background:#ffc107;color:#212529;font-weight:600;">
										'.$reg->cantidadRemision.'
									</span><br>
									Máx. remisionable según stock:&nbsp;
									<span class="badge badge-success"
										style="background:#28a745;color:#fff;font-weight:600;">
										'.$reg->stock_real.'
									</span>
								</div>
							</td>
						
							<td><input type="hidden" name="precioVenta[]" onblur="modificarSubototales()"  id="precioVenta[]"  value="'.$reg->precio.'">'.$reg->precio.'</td>
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


	case 'listarFacturados':
		$habilitacion=$_REQUEST["habilitacion"];
		$rspta=$ordenVenta->listarFacturadosDirecta($habilitacion);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			if($reg->dd=='TICKET'){
 				$url='../reportes/exTicket.php?id=';
 			}
 			else{
 				$url='../reportes/exFacturaFormRemision.php?id=';
 			}

 			if ($reg->TerminoPago_idTerminoPago == 0) {
 				$tipo = 'CONTADO';
 			}else{
 				$tipo = 'CREDITO';
 			}

 			if ($reg->facturado == 1) {
 				$facturado = 1;
 			}else{
 				$facturado = 0;
 			}
			
			if ($reg->vi == 1) {
 				$saldo = 0;
 			}else{
 				$saldo = $reg->saldo;
 			}
			if ($reg->formaEntrega == 1) {
 				$formaEntrega = 'En el Local';
 			}
			if ($reg->formaEntrega == 2) {
 				$formaEntrega = 'Delivery';
 			}
 		$urlPagare='../reportes/exPagare.php?id=';
			
 			$data[]=array(
 				"0"=>
				''.
				(((!$reg->ovi)?'<a target="_blank" href="'.$url.$reg->idOrdenVenta.'"> <button class="btn btn-info"><i class="fa fa-print">Factura</i></button></a><a target="_blank" href="'.$urlPagare.$reg->idOrdenVenta.'"> <button class="btn btn-info"><i class="fa fa-file-pdf-o">Pagaré</i></button></a>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idOrdenVenta.')"><i class="fa fa-eye"></i></button>')
					)
					,
 				"1"=>$reg->idOrdenVenta,
 				"2"=>$reg->fecha,
 				"3"=>($reg->rs),
 				"4"=>$reg->Habilitacion_idHabilitacion,
 				"5"=>$reg->Deposito_idDeposito,
 				"6"=>$reg->tpd,
 				"7"=>$formaEntrega,
 				"8"=>$reg->fechaEntrega,
 				"9"=>$reg->total,
 				"10"=>$reg->ovui,
 				"11"=>$reg->ovum,
 				"12"=>'<button class="btn btn-primary" onclick="mostrarDetalleordenVenta('.$reg->idOrdenVenta.')">Ver detalle de ordenVenta <i class="fa fa-pencil"></i></button>',
 				"13"=>(!$reg->ovi)?'<span class="label bg-green">Aceptado</span>':
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





	case 'listarFacturados1':
		$habilitacion=$_REQUEST["habilitacion"];
		$rspta=$ordenVenta->listarFacturados($habilitacion);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			if($reg->dd=='TICKET'){
 				$url='../reportes/exTicket.php?id=';
 			}
 			else{
 				$url='../reportes/exFacturaDuplicado.php?id=';
 			}

 			if ($reg->TerminoPago_idTerminoPago == 0) {
 				$tipo = 'CONTADO';
 			}else{
 				$tipo = 'CREDITO';
 			}

 			if ($reg->facturado == 1) {
 				$facturado = 1;
 			}else{
 				$facturado = 0;
 			}
			
			if ($reg->vi == 1) {
 				$saldo = 0;
 			}else{
 				$saldo = $reg->saldo;
 			}
			if ($reg->formaEntrega == 1) {
 				$formaEntrega = 'En el Local';
 			}
			if ($reg->formaEntrega == 2) {
 				$formaEntrega = 'Delivery';
 			}
 		$urlPagare='../reportes/exPagare.php?id=';
			
 			$data[]=array(
 				"0"=>
				''.
				(((!$reg->ovi)?'<a target="_blank" href="'.$url.$reg->idOrdenVenta.'"> <button class="btn btn-info"><i class="fa fa-print">Factura</i></button></a><a target="_blank" href="'.$urlPagare.$reg->idOrdenVenta.'"> <button class="btn btn-info"><i class="fa fa-file-pdf-o">Pagaré</i></button></a>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idOrdenVenta.')"><i class="fa fa-eye"></i></button>')
					)
					,
 				"1"=>$reg->idOrdenVenta,
 				"2"=>$reg->fecha,
 				"3"=>($reg->rs),
 				"4"=>$reg->Habilitacion_idHabilitacion,
 				"5"=>$reg->Deposito_idDeposito,
 				"6"=>$reg->tpd,
 				"7"=>$formaEntrega,
 				"8"=>$reg->fechaEntrega,
 				"9"=>$reg->total,
 				"10"=>$reg->ovui,
 				"11"=>$reg->ovum,
 				"12"=>'<button class="btn btn-primary" onclick="mostrarDetalleordenVenta('.$reg->idOrdenVenta.')">Ver detalle de ordenVenta <i class="fa fa-pencil"></i></button>',
 				"13"=>(!$reg->ovi)?'<span class="label bg-green">Aceptado</span>':
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
				echo '<option value=' . $reg->IDBANCO . '>' . $reg->DESCRIPCION . '</option>';
				}
	break;

	case 'listarArticulosordenVenta':
		require_once "../modelos/Articulo.php";
		$articulo=new Articulo();

		$rspta=$articulo->listarActivosordenVenta();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			$capital = $reg->precioTL2;
 			$interes = $reg->precioTL - $reg->precioTL2;

 			$data[]=array(
 				"0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idArticulo.',\''.$reg->na.'\',\''.$reg->precioLista.'\',\''.$reg->pi.'\',\''.$capital.'\',\''.$interes.'\',\''.$reg->stock.'\')"><span class="fa fa-plus"></span></button>',
 				"1"=>$reg->na,
 				"2"=>$reg->cn,
 				"3"=>$reg->codigoBarra,
 				"4"=>$reg->precioLista,
 				"5"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px' >"
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	break;


	case 'selectArticulosordenVenta':
		require_once "../modelos/Articulo.php";
		$articulo=new Articulo();

		$rspta=$articulo->listarActivosordenVenta();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
			echo '<option value=' .$reg->idArticulo. '>' .$reg->na. '</option>';
 		}

	break;



	case 'habilitacion':
		$rspta=$ordenVenta->habilitacion();
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'ultimo':
		$rspta=$ordenVenta->ultimo();
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;


	case 'cambiarPersonaGiftCard':
		$rspta=$ordenVenta->cambiarPersonaGiftCard($idOrdenVenta,$clienteGiftCard);
 		echo $rspta ? "El cambio se proceso correctamente" : "El cambio no se pudo procesar";
	break;

	case 'cambiarNroGiftCard':
		$rspta=$ordenVenta->cambiarNroGiftCard($idOrdenVenta,$nroGiftCard);
 		echo $rspta ? "El cambio se proceso correctamente" : "El cambio no se pudo procesar";
	break;


}

?>


