<?php 


require_once "../modelos/Consultas.php";

$consulta=new Consultas();

switch ($_GET["op"]){
	



	case 'registrosRepartidor':

		$rspta=$consulta->registrosRepartidor();
		
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
		$url='../reportes/exRecibo.php?idRecibo=';
		$date = date_create($reg->Fecha);
 			$data[]=array(
 				"0"=>$reg->usuarioInsercion,
 				"1"=>$reg->cantidadRegistrada,
 				"2"=>$reg->cantidadRegistradaHoy
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;




	case 'rpt_ajuste_detalleProd':
		$idProduccion=$_REQUEST["idProduccion"];

		$rspta=$consulta->rpt_ajustes_detalleProd($idProduccion);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			$data[]=array(
 				"0"=>$reg->Produccion_idProduccion,
 				"1"=>$reg->Articulo_idArticulo,
 				"2"=>utf8_encode($reg->descripcion),
 				"3"=>$reg->Deposito_idDeposito,
 				"4"=>number_format($reg->cantidad,0, ',', '.'),
 				"5"=>number_format($reg->cantidadReal,0, ',', '.'),
				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;	

	case 'rptrecibosDetalle':
		$fecha_inicio=$_REQUEST["f_i"];
		$fecha_fin=$_REQUEST["f_f"];
		$cliente=$_REQUEST["cliente"];

		$rspta=$consulta->rptrecibosDetalle($fecha_inicio,$fecha_fin, $cliente);
		
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
		$url='../reportes/exRecibo.php?idRecibo=';
		$date = date_create($reg->Fecha);
 			$data[]=array(
 				"0"=>$reg->idRecibo. ' - '. '<a target="_blank" href="'.$url.$reg->idRecibo.'"> <button class="btn btn-info"><i class="fa fa-print">Recibo</i></button>',
 				"1"=>$reg->nombreComercial,
 				"2"=>$reg->nroDocumento,
 				"3"=>$reg->nroHabilitacion,
				"4"=>$reg->fechaRecibo,
				"5"=>$reg->fechaFactura,
				"6"=>$reg->fechaCuota,
				"7"=>$reg->nroCuota,
				"8"=>number_format($reg->montoCuota,0, ',', '.'),
				"9"=>number_format($reg->montoPagado,0, ',', '.'),
				"10"=>$reg->diasAtraso,
				"11"=>$reg->Termino,
				"12"=>$reg->nroOficial,
				"13"=>$reg->usuario,
				"14"=>$reg->cobrador,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;


	case 'rptrecibosDetalle2':
		$fecha_inicio=$_REQUEST["f_i"];
		$fecha_fin=$_REQUEST["f_f"];
		$cliente=$_REQUEST["cliente"];

		$rspta=$consulta->rptrecibosDetalle2($fecha_inicio,$fecha_fin, $cliente);
		
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
		$url='../reportes/exRecibo.php?idRecibo=';
		$date = date_create($reg->Fecha);
 			$data[]=array(
 				"0"=>$reg->idRecibo. ' - '. '<a target="_blank" href="'.$url.$reg->idRecibo.'"> <button class="btn btn-info"><i class="fa fa-print">Recibo</i></button>',
 				"1"=>($reg->nombreComercial),
 				"2"=>$reg->nroDocumento,
 				"3"=>$reg->nroHabilitacion,
				"4"=>$reg->fechaRecibo,
				"5"=>$reg->fechaFactura,
				"6"=>$reg->fechaCuota,
				"7"=>$reg->nroCuota,
				"8"=> number_format($reg->montoCuota,0, ',', '.'),
				"9"=> number_format($reg->montoPagado,0, ',', '.'),
				"10"=>$reg->diasAtraso,
				"11"=>$reg->Termino,
				"12"=>$reg->nroOficial,
				"13"=>$reg->usuario,
				"14"=>$reg->fopago, 
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);


	break;



	case 'rptventasArticulo':
		$fecha_inicio=$_REQUEST["f_i"];
		$fecha_fin=$_REQUEST["f_f"];
		$cliente=$_REQUEST["cliente"];

		$rspta=$consulta->rptventasArticulo($fecha_inicio,$fecha_fin, $cliente);
		
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){


 				$url='../reportes/exFacturaForm.php?id=';

		$date = date_create($reg->Fecha);
 			$data[]=array(
 				"0"=>$reg->idVenta. ' - '. '<a target="_blank" href="'.$url.$reg->idVenta.'"> <button class="btn btn-info"><i class="fa fa-print">Factura</i></button>',
 				"1"=> ($reg->nombreComercial),
 				"2"=>$reg->nroDocumento,
 				"3"=>$reg->nroFactura,
				"4"=>$reg->fechaTransaccion,
				"5"=>$reg->fechaVencimiento,
				"6"=>$reg->timbrado,
				"7"=>$reg->termino,
				"8"=>$reg->moneda,
				"9"=> ($reg->descripcion),
				"10"=>$reg->cantidad,
				"11"=>$reg->precio,
				"12"=>$reg->total,
				"13"=> ($reg->vendedor),
				"14"=> ($reg->usuario),
				"15"=> ($reg->cobrador),
				"16"=> ($reg->proveedor),
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	


	case 'rptncventas':
		$fecha_inicio=$_REQUEST["f_i"];
		$fecha_fin=$_REQUEST["f_f"];
		$cliente=$_REQUEST["cliente"];
		
		$url='../reportes/exNotaCreditoVentaDuplicado.php?id=';

		$rspta=$consulta->rptncventas($fecha_inicio,$fecha_fin, $cliente);
		
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

		$date = date_create($reg->Fecha);
 			$data[]=array(
 				"0"=>'<a target="_blank" href="'.$url.$reg->idNotaCreditoVenta.'"> <button class="btn btn-info"><i class="fa fa-print"></i></button></a>'.$reg->idNotaCreditoVenta,
 				"1"=>$reg->nombreComercial,
 				"2"=>$reg->nroDocumento,
 				"3"=>$reg->nroFactura,
				"4"=>$reg->fechaTransaccion,
				"5"=>$reg->fechaVencimiento,
				"6"=>$reg->timbrado,
				"7"=>$reg->termino,
				"8"=>$reg->moneda,
				"9"=>$reg->total,
				"10"=>$reg->montoCuota,
				"11"=>$reg->entrega,
				"12"=>$reg->vendedor,
				"13"=>$reg->cobrador,
				"14"=>$reg->usuario,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break; 	




case 'rpt_libro_ventas_avanzado1':
		$fi=$_REQUEST["fecha_inicio"];
		$ff=$_REQUEST["fecha_fin"];
		$proceso=$_REQUEST["proceso"];

		$rspta=$consulta->rpt_libro_ventas_avanzado1($fi,$ff,$proceso);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 		$lla = substr((($reg->Proveedor)),0,30);
		$lla = str_replace(array('[\', \']'), '', $lla);
    	$lla = preg_replace('/\[.*\]/U', '', $lla);
    	$lla = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $lla);
    	$lla = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $lla );
    	$lla = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , ' ', $lla);

    	$tot1 = number_format($reg->Gravada10, 0, ',', '.');
    	$tot2 = number_format($reg->IVA10, 0, ',', '.');
    	$tot3 = number_format($reg->Gravada5, 0, ',', '.');
    	$tot4 = number_format($reg->IVA5, 0, ',', '.');
    	$tot5 = number_format($reg->Exento, 0, ',', '.');
    	$tott = number_format($reg->Gravada10, 0, '.', ',') + number_format($reg->IVA10, 0, '.', ',') + 
    			number_format($reg->Gravada5, 0, '.', ',') + number_format($reg->IVA5, 0, '.', ',') + number_format($reg->Exento, 0, '.', ',');
		$data[]=array(
 				"0"=>"1",
 				"1"=>$reg->AA,			
 				"2"=>utf8_decode($reg->RUC),
 				"3"=>$lla,
 				"4"=>utf8_decode($reg->tipo),
 				"5"=>date("d/m/Y", strtotime($reg->Fecha)),
				"6"=>$reg->Timbrado,	
 				"7"=>$reg->Nro,
 				"8"=>number_format($reg->Gravada10, 0, ',', ''),
 				"9"=>number_format($reg->Gravada5, 0, ',', ''),
 				"10"=>number_format($reg->Exento, 0, ',', ''),
 				"11"=>number_format($reg->Gravada10+$reg->IVA10+$reg->Gravada5+$reg->IVA5+$reg->Exento, 0, ',', ''),
 				//"11"=>number_format($tott, 0, '.', ','),
 				"12"=>"1", 
 				"13"=>"N",
 				"14"=>"S",
 				"15"=>"N",	
 				"16"=>"N",
 				"17"=>"N",	

 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;	

	
case 'rpt_libro_compras_avanzado1':
		$fi=$_REQUEST["fecha_inicio"];
		$ff=$_REQUEST["fecha_fin"];
		$proceso=$_REQUEST["proceso"];

		$rspta=$consulta->rpt_libro_compras_avanzado1($fi,$ff,$proceso);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 		$lla = substr((utf8_decode($reg->Proveedor)),0,30);
		$lla = str_replace(array('[\', \']'), '', $lla);
    	$lla = preg_replace('/\[.*\]/U', '', $lla);
    	$lla = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $lla);
    	$lla = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $lla );
    	$lla = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , ' ', $lla);

    	$tot1 = number_format($reg->Gravada10, 0, ',', '.');
    	$tot2 = number_format($reg->IVA10, 0, ',', '.');
    	$tot3 = number_format($reg->Gravada5, 0, ',', '.');
    	$tot4 = number_format($reg->IVA5, 0, ',', '.');
    	$tot5 = number_format($reg->Exento, 0, ',', '.');
    	$tott = number_format($reg->Gravada10, 0, '.', ',') + number_format($reg->IVA10, 0, '.', ',') + 
    			number_format($reg->Gravada5, 0, '.', ',') + number_format($reg->IVA5, 0, '.', ',') + number_format($reg->Exento, 0, '.', ',');
		$data[]=array(
 				"0"=>"1",
 				"1"=>$reg->AA,			
 				"2"=>utf8_decode($reg->RUC),
 				"3"=>$lla,
 				"4"=>utf8_decode($reg->tipo),
 				"5"=>date("d/m/Y", strtotime($reg->Fecha)),
				"6"=>$reg->Timbrado,	
 				"7"=>$reg->Nro,
 				"8"=>number_format($reg->Gravada10, 0, ',', ''),
 				"9"=>number_format($reg->Gravada5, 0, ',', ''),
 				"10"=>number_format($reg->Exento, 0, ',', ''),
 				"11"=>number_format($reg->Gravada10+$reg->IVA10+$reg->Gravada5+$reg->IVA5+$reg->Exento, 0, ',', ''),
 				//"11"=>number_format($tott, 0, '.', ','),
 				"12"=>"1", 
 				"13"=>"N",
 				"14"=>"S",
 				"15"=>"N",	
 				"16"=>"N",
 				"17"=>"N",	

 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;	


	
	case 'comprasfecha':
		$fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];

		$rspta=$consulta->comprasfecha($fecha_inicio,$fecha_fin);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>$reg->fecha,
 				"1"=>$reg->usuario,
 				"2"=>$reg->proveedor,
 				"3"=>$reg->tipo_comprobante,
 				"4"=>$reg->serie_comprobante.' '.$reg->num_comprobante,
 				"5"=>number_format($reg->total_compra, 0, ',', '.'),
 				"6"=>number_format($reg->impuesto,0, ',', '.'),
 				"7"=>($reg->estado=='Aceptado')?'<span class="label bg-green">Aceptado</span>':
 				'<span class="label bg-red">Anulado</span>',
 				"8"=>$reg->total_compra,

 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'rpt_cobros_fecha':
		$fi=$_REQUEST["fi"];
		$ff=$_REQUEST["ff"];

		$rspta=$consulta->rpt_cobros_fecha($fi,$ff);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>$reg->FORMAPAGO_IDFORMAPAGO,
 				"1"=>$reg->descripcion,
 				"2"=>number_format($reg->total,0, ',', '.'),
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;


	case 'rpt_recibos_fecha':
		$fi=$_REQUEST["fi"];
		$ff=$_REQUEST["ff"];

		$rspta=$consulta->rpt_recibos_fecha($fi,$ff);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>$reg->IDRECIBO,
 				"1"=>$reg->Habilitacion_idHabilitacion,
 				"2"=>$reg->razonSocial,
 				"3"=>$reg->usuario,
 				"4"=>$reg->FECHARECIBO,
 				"5"=>number_format($reg->TOTAL,0, ',', '.'),
 				"6"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>',
 				"7"=>'<button class="btn btn-primary" onclick="mostrar('.$reg->IDRECIBO.')">Ver detalle de venta <i class="fa fa-pencil"></i></button>',

 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
	
	case 'rptrecibos':
		$fecha_inicio=$_REQUEST["f_i"];
		$fecha_fin=$_REQUEST["f_f"];

		$rspta=$consulta->rptrecibos($fecha_inicio,$fecha_fin);
		
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

		$date = date_create($reg->Fecha);
 			$data[]=array(
 				"0"=>$reg->idRecibo,
 				"1"=>utf8_encode($reg->nombreComercial),
 				"2"=>$reg->nroDocumento,
 				"3"=>$reg->nroFactura,
				"4"=>$reg->fechaTransaccion,
				"5"=>$reg->total,
				"6"=>$reg->usuario,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'rptrecibosAnulados':
		$fecha_inicio=$_REQUEST["f_i"];
		$fecha_fin=$_REQUEST["f_f"];

		$rspta=$consulta->rptrecibosAnulados($fecha_inicio,$fecha_fin);
		
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

		$date = date_create($reg->Fecha);
 			$data[]=array(
 				"0"=>$reg->idRecibo,
 				"1"=>$reg->nombreComercial,
 				"2"=>$reg->nroDocumento,
 				"3"=>$reg->nroFactura,
				"4"=>$reg->fechaTransaccion,
				"5"=>$reg->total,
				"6"=>$reg->usuario,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break; 
	

	
	
	case 'rptpagos':
		$fecha_inicio=$_REQUEST["f_i"];
		$fecha_fin=$_REQUEST["f_f"];

		$rspta=$consulta->rptpagos($fecha_inicio,$fecha_fin);
		
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

		$date = date_create($reg->Fecha);
 			$data[]=array(
 				"0"=>$reg->idPago,
 				"1"=>$reg->nombreComercial,
 				"2"=>$reg->nroDocumento,
 				"3"=>$reg->nroFactura,
				"4"=>$reg->fechaTransaccion,
				"5"=>$reg->total,
				"6"=>$reg->usuario,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;  
	
	case 'rptpagosAnulados':
		$fecha_inicio=$_REQUEST["f_i"];
		$fecha_fin=$_REQUEST["f_f"];

		$rspta=$consulta->rptpagosAnulados($fecha_inicio,$fecha_fin);
		
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

		$date = date_create($reg->Fecha);
 			$data[]=array(
 				"0"=>$reg->idPago,
 				"1"=>$reg->nombreComercial,
 				"2"=>$reg->nroDocumento,
 				"3"=>$reg->nroFactura,
				"4"=>$reg->fechaTransaccion,
				"5"=>$reg->total,
				"6"=>$reg->usuario,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break; 

	case 'ventasfechacliente':
		$fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];
		$idcliente=$_REQUEST["idcliente"];

		$rspta=$consulta->ventasfechacliente($fecha_inicio,$fecha_fin,$idcliente);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>$reg->fecha,
 				"1"=>$reg->usuario,
 				"2"=>$reg->cliente,
 				"3"=>$reg->tipo_comprobante,
 				"4"=>$reg->serie_comprobante.' '.$reg->num_comprobante,
 				"5"=>number_format($reg->total_venta,0, ',', '.'),
 				"6"=>number_format($reg->impuesto,0, ',', '.'),
 				"7"=>($reg->estado=='Aceptado')?'<span class="label bg-green">Aceptado</span>':
 				'<span class="label bg-red">Anulado</span>',
 				"8"=>$reg->total_venta,

 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'rpt_ventas_habilitacion':
		$habilitacion=$_REQUEST["habilitacion"];

		$rspta=$consulta->rpt_ventas_habilitacion($habilitacion);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 	
 			if ($reg->tipo_comprobante == 0) {
 				$tipo = 'CONTADO';
 			}else{
 				$tipo = 'CREDITO';
 			}

 			$data[]=array(
 				"0"=>$reg->idVenta,
 				"1"=>$reg->Habilitacion_idHabilitacion,
 				"2"=>$reg->idCliente,
 				"3"=>$reg->razonSocial,
 				"4"=>$reg->nombreComercial,
 				"5"=>$tipo,
 				"6"=>number_format($reg->totalImpuesto,0, ',', '.'),
 				"7"=>number_format($reg->total,0, ',', '.'),
 				"8"=>number_format($reg->saldo,0, ',', '.'),
 				"9"=>(!$reg->vi)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>',
 				"10"=>'<button class="btn btn-primary" onclick="mostrar('.$reg->idVenta.')">Ver detalle de venta <i class="fa fa-pencil"></i></button>',
 				"11"=>$reg->total,

 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;


	case 'rpt_ventas_fecha':
		$fi=$_REQUEST["fi"];
		$ff=$_REQUEST["ff"];

		$rspta=$consulta->rpt_ventas_fecha($fi,$ff);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>$reg->idVenta,
 				"1"=>$reg->Habilitacion_idHabilitacion,
 				"2"=>$reg->idCliente,
 				"3"=>$reg->razonSocial,
 				"4"=>$reg->nombreComercial,
 				"5"=>number_format($reg->total/11,0, ',', '.'),
 				"6"=>number_format($reg->total,0, ',', '.'),
 				"7"=>(!$reg->vi)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>',
 				"8"=>'<button class="btn btn-primary" onclick="mostrar('.$reg->idVenta.')">Ver detalle de venta <i class="fa fa-pencil"></i></button>',
 				"9"=>'<button class="btn btn-success" onclick="mostrarDetalleCobro('.$reg->idVenta.')">Ver detalle de cobro <i class="fa fa-pencil"></i></button>',
 				"10"=>$reg->total,

 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;


	case 'rpt_ventas_fecha_giftCard':
		$fi=$_REQUEST["fi"];
		$ff=$_REQUEST["ff"];

		$rspta=$consulta->rpt_ventas_fecha_giftCard($fi,$ff);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 		if ($reg->vi == 0) {

				$data[]=array(
 				"0"=>$reg->idVenta,
 				"1"=>$reg->Habilitacion_idHabilitacion,
 				"2"=>$reg->fechaFactura,
 				"3"=>$reg->idCliente,
 				"4"=>$reg->razonSocial,
 				"5"=>$reg->celular,
 				"6"=>$reg->ncg,
 				"7"=>$reg->nucg,
 				"8"=>$reg->nroGiftCard,
 				"9"=>number_format($reg->total/11,0, ',', '.'),
 				"10"=>number_format($reg->total,0, ',', '.'),
 				"11"=>(!$reg->vi)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>',
 				"12"=>'<button class="btn btn-primary" onclick="mostrar('.$reg->idVenta.')">Ver detalle de venta <i class="fa fa-pencil"></i></button>',
 				"13"=>'<button class="btn btn-success" onclick="mostrarDetalleCobro('.$reg->idVenta.')">Ver detalle de cobro <i class="fa fa-pencil"></i></button>',
 				"14"=>$reg->total,

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


	case 'rpt_ventas_fecha_activos':
		$fi=$_REQUEST["fi"];
		$ff=$_REQUEST["ff"];

		$rspta=$consulta->rpt_ventas_fecha_activos($fi,$ff);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>$reg->idVenta,
 				"1"=>$reg->Habilitacion_idHabilitacion,
 				"2"=>$reg->idCliente,
 				"3"=>$reg->razonSocial,
 				"4"=>$reg->nombreComercial,
 				"5"=>number_format($reg->total/11,0, ',', '.'),
 				"6"=>number_format($reg->total,0, ',', '.'),
 				"7"=>(!$reg->vi)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>',
 				"8"=>'<button class="btn btn-primary" onclick="mostrar('.$reg->idVenta.')">Ver detalle de venta <i class="fa fa-pencil"></i></button>',
 				"9"=>$reg->total,

 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'rpt_recibos_habilitacion':
		$habilitacion=$_REQUEST["habilitacion"];

		$rspta=$consulta->rpt_recibos_habilitacion($habilitacion);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 		$Color = 'red'; 
 			if ($reg->idc == 0) {
 				$cliente = '<span class="label bg-'.$Color.'">'.$reg->nombreComercial.'</span>';
 			}else{
 				$cliente = $reg->nombreComercial;
 			}

 			$data[]=array(
 				"0"=>$reg->nro,
 				"1"=>$reg->idVenta,
 				"2"=>$reg->HABILITACION_IDHABILITACION,
 				"3"=>$cliente,
 				"4"=>$reg->USUARIO,
 				"5"=>$reg->FECHARECIBO,
 				"6"=>number_format($reg->TOTAL,0, ',', '.')
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;



	case 'rpt_movimiento_fecha_concepto_egreso':
		$fi=$_REQUEST["fi"];
		$ff=$_REQUEST["ff"];
		$concepto=$_REQUEST["concepto"];

		$rspta=$consulta->rpt_movimiento_fecha_concepto_egreso($fi,$ff,$concepto);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>$reg->idMovimiento,
 				"1"=>$reg->habilitacion,
 				"2"=>$reg->usuario,
 				"3"=>$reg->fa,
 				"4"=>$reg->concepto,
 				"5"=>$reg->cd,
 				"6"=>$reg->tipo,
 				"7"=>$reg->md,
 				"8"=>number_format($reg->monto,0, ',', '.'),
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'rpt_movimiento_fecha_concepto_ingreso':
		$fi=$_REQUEST["fi"];
		$ff=$_REQUEST["ff"];
		$concepto=$_REQUEST["concepto"];

		$rspta=$consulta->rpt_movimiento_fecha_concepto_ingreso($fi,$ff,$concepto);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>$reg->idMovimiento,
 				"1"=>$reg->habilitacion,
 				"2"=>$reg->usuario,
 				"3"=>$reg->fa,
 				"4"=>$reg->concepto,
 				"5"=>$reg->cd,
 				"6"=>$reg->tipo,
 				"7"=>$reg->md,
 				"8"=>number_format($reg->monto,0, ',', '.'),
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;


	case 'rpt_ventas_fecha_deposito':
		$fi=$_REQUEST["fi"];
		$ff=$_REQUEST["ff"];
		$deposito=$_REQUEST["deposito"];

		$rspta=$consulta->rpt_ventas_fecha_deposito($fi,$ff,$deposito);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>$reg->idVenta,
 				"1"=>$reg->Habilitacion_idHabilitacion,
 				"2"=>$reg->idCliente,
 				"3"=>$reg->razonSocial,
 				"4"=>$reg->nombreComercial,
 				"5"=>number_format($reg->totalImpuesto,0, ',', '.'),
 				"6"=>number_format($reg->total,0, ',', '.'),
 				"7"=>(!$reg->vi)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>',
 				"8"=>'<button class="btn btn-primary" onclick="mostrar('.$reg->idVenta.')">Ver detalle de venta <i class="fa fa-pencil"></i></button>',
 				"9"=>$reg->total,

 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	
	case 'rpt_ventas_detalle':
		$idVenta=$_REQUEST["idVenta"];

		$rspta=$consulta->rpt_ventas_detalle($idVenta);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			$data[]=array(
 				"0"=>$reg->Venta_idVenta,
 				"1"=>$reg->Articulo_idArticulo,
 				"2"=>$reg->nombre,
 				"3"=>$reg->descripcion,
 				"4"=>number_format($reg->precio,0, ',', '.'),
 				"5"=>number_format($reg->cantidad,0, ',', '.'),
 				"6"=>number_format($reg->total,0, ',', '.'),
 				"7"=>$reg->precio,
 				"8"=>$reg->total,

 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'rpt_ordenCompras_detalle':
		$OrdenCompra_idOrdenCompra=$_REQUEST["OrdenCompra_idOrdenCompra"];

		$rspta=$consulta->rpt_ordenCompras_detalle($OrdenCompra_idOrdenCompra);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			$data[]=array(
 				"0"=>$reg->OrdenCompra_idOrdenCompra,
 				"1"=>$reg->Item,
 				"2"=>$reg->Articulo_idArticulo,
 				"3"=>utf8_encode($reg->nombre),
 				"4"=>utf8_encode($reg->descripcion),
 				"5"=>number_format($reg->cantidad,0, ',', '.'),
 				"6"=>number_format($reg->precio,0, ',', '.'),
 				"7"=>number_format($reg->descuento,0, ',', '.'),
 				"8"=>number_format($reg->precio*$reg->cantidad,0, ',', '.'),
 				"9"=>$reg->precio,
 				"10"=>$reg->total,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;


	case 'rpt_habilitacion_detalle':
		$idHabilitacion=$_REQUEST["idHabilitacion"];

		$rspta=$consulta->rpt_habilitacion_detalle($idHabilitacion);
 		//Vamos a declarar un array
 		$data= Array(); 

 		while ($reg=$rspta->fetchObject()){

 			$data[]=array(
 				"0"=>$reg->Habilitacion_idHabilitacion,
 				"1"=>$reg->Item,
 				"2"=>$reg->Moneda_idMoneda,
 				"3"=>$reg->Denominacion_idDenominacion,
 				"4"=>'<input type="text" class="input-sm" id="'.$reg->Item.'"  onblur="actualizarMontoApertura(this, \''.$reg->Item.'\',\''.$reg->Item.'\')" style="width:100%;" value="'.$reg->montoApertura.'" /><font color = white></font>',
 				"5"=>'<input type="text" class="input-sm" id="'.$reg->Item.'"  onblur="actualizarMontoCierre(this, \''.$reg->Item.'\',\''.$reg->Item.'\')" style="width:100%;" value="'.$reg->montoCierre.'" /><font color = white></font>',
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;




	case 'actualizarMontoApertura':
		$item=$_REQUEST["item"];
		$montoApertura=$_REQUEST["montoApertura"];

		$rspta=$consulta->actualizarMontoApertura($item,$montoApertura);
 		//Vamos a declarar un array
 		$data= Array();

 		/*while ($reg=$rspta->fetchObject()){

 			$data[]=array(
 				"0"=>$reg->idArticulo,
 				"1"=>$reg->na,
 				"2"=>$reg->nc,
 				"3"=>$reg->Cantidad,
 				"4"=>$reg->Cantidad,
 				"5"=>$reg->precioVenta,
 				"6"=>$reg->precioVenta * $reg->Cantidad,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
*/
	break;



	case 'actualizarMontoCierre':
		$item=$_REQUEST["item"];
		$montoCierre=$_REQUEST["montoCierre"];

		$rspta=$consulta->actualizarMontoCierre($item,$montoCierre);
 		//Vamos a declarar un array
 		$data= Array();

 		/*while ($reg=$rspta->fetchObject()){

 			$data[]=array(
 				"0"=>$reg->idArticulo,
 				"1"=>$reg->na,
 				"2"=>$reg->nc,
 				"3"=>$reg->Cantidad,
 				"4"=>$reg->Cantidad,
 				"5"=>$reg->precioVenta,
 				"6"=>$reg->precioVenta * $reg->Cantidad,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
*/
	break;


	case 'rpt_ordenVentas_detalle':
		$OrdenVenta_idOrdenVenta=$_REQUEST["OrdenVenta_idOrdenVenta"];

		$rspta=$consulta->rpt_ordenVentas_detalle($OrdenVenta_idOrdenVenta);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			$data[]=array(
 				"0"=>$reg->OrdenVenta_idOrdenVenta,
 				"1"=>$reg->Item,
 				"2"=>$reg->Articulo_idArticulo,
 				"3"=>$reg->nombre,
 				"4"=>$reg->descripcion,
 				"5"=>number_format($reg->cantidad,0, ',', '.'),
 				"6"=>number_format($reg->precio,0, ',', '.'),
 				"7"=>number_format($reg->descuento,0, ',', '.'),
 				"8"=>number_format($reg->total,0, ',', '.'),
 				"9"=>$reg->precio,
 				"10"=>$reg->total,

 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
	
	case 'rpt_ordenVentas_detalle2':
		$OrdenVenta_idOrdenVenta=$_REQUEST["OrdenVenta_idOrdenVenta"];

		$rspta=$consulta->rpt_ordenVentas_detalle2($OrdenVenta_idOrdenVenta);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			$data[]=array(
 				"0"=>$reg->OrdenVenta_idOrdenVenta,
 				"1"=>$reg->Item,
 				"2"=>$reg->Articulo_idArticulo,
 				"3"=>$reg->nombre,
 				"4"=>$reg->descripcion,
 				"5"=>number_format($reg->cantidad,0, ',', '.'),
 				"6"=>number_format($reg->precio,0, ',', '.'),
 				"7"=>number_format($reg->descuento,0, ',', '.'),
 				"8"=>number_format($reg->total,0, ',', '.'),
 				"9"=>$reg->precio,
 				"10"=>$reg->total,

 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'rpt_asiento_detalle': 
		$Asiento_idAsiento=$_REQUEST["Asiento_idAsiento"];

		$rspta=$consulta->rpt_asiento_detalle($Asiento_idAsiento);
 		//Vamos a declarar un array
 		$data= Array(); 

 		while ($reg=$rspta->fetchObject()){
 				//b.nroCheque,a.nroComprobante,a.concepto 
 			$data[]=array(
 				"0"=>$reg->ProcesoDesc,
 				"1"=>$reg->cuentaContableDesc,
 				"2"=>$reg->cuentaCorrienteDesc,
 				"3"=>$reg->tipoMovimientoDesc,
 				"4"=>number_format($reg->Debito,0, ',', '.'),
 				"5"=>number_format($reg->Credito,0, ',', '.'),   
 				"6"=>$reg->nroCheque,
 				"7"=>$reg->nroComprobante,
 				"8"=>$reg->concepto,

 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results); 

	break;	



	case 'rpt_asiento_detalle_vista': 
		$Asiento_idAsiento=$_REQUEST["idCompra"];

		$rspta=$consulta->rpt_asiento_detalle_vista($Asiento_idAsiento);
 		//Vamos a declarar un array
 		$data= Array(); 

 		while ($reg=$rspta->fetchObject()){
 				//b.nroCheque,a.nroComprobante,a.concepto 
 			$data[]=array(
 				"0"=>$reg->ProcesoDesc,
 				"1"=>$reg->cuentaContableDesc,
 				"2"=>$reg->cuentaCorrienteDesc,
 				"3"=>$reg->tipoMovimientoDesc,
 				"4"=>number_format($reg->Debito,0, ',', '.'),
 				"5"=>number_format($reg->Credito,0, ',', '.'),   
 				"6"=>$reg->nroCheque,
 				"7"=>$reg->nroComprobante,
 				"8"=>$reg->concepto,

 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results); 

	break;	


	case 'rpt_vehiculo_detalle': 
		$Persona_idPersona=$_REQUEST["Persona_idPersona"];

		$rspta=$consulta->rpt_vehiculo_detalle($Persona_idPersona);
 		//Vamos a declarar un array
 		$data= Array(); 

 		while ($reg=$rspta->fetchObject()){
 				//b.nroCheque,a.nroComprobante,a.concepto 
 			$data[]=array(
 				"0"=>$reg->matricula,
 				"1"=>$reg->anhoVehiculo,
 				"2"=>$reg->vencimientoMatricula,
 				"3"=>$reg->comentarioHabilitacion,	
 				"4"=>$reg->tipoVehiculo,	
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results); 

	break;		


	case 'rpt_telefono_detalle': 
		$Persona_idPersona=$_REQUEST["idPersona"];

		$rspta=$consulta->rpt_telefono_detalle($Persona_idPersona);
 		//Vamos a declarar un array
 		$data= Array(); 

 		while ($reg=$rspta->fetchObject()){
 				//b.nroCheque,a.nroComprobante,a.concepto 
 			$data[]=array(
 				"0"=>$reg->TipoDireccion_Telefono_idTipoDireccion_Telefono,
 				"1"=>$reg->telefono,
 				"2"=>$reg->usuarioInsercion,
 				"3"=>$reg->fechaInsercion,		
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results); 

	break;	

	case 'rpt_direccion_detalle': 
		$Persona_idPersona=$_REQUEST["Persona_idPersona"];

		$rspta=$consulta->rpt_direccion_detalle($Persona_idPersona);
 		//Vamos a declarar un array
 		$data= Array(); 

 		while ($reg=$rspta->fetchObject()){
 				//b.nroCheque,a.nroComprobante,a.concepto 
 			$data[]=array(
 				"0"=>$reg->callePrincipal,
 				"1"=>$reg->calleTransversal,
 				"2"=>$reg->nroCasa,
 				"3"=>$reg->fechaInsercion,	
 				"4"=>$reg->TipoDireccion_Telefono_idTipoDireccion_Telefono,
				"5"=>$reg->longitud,
				"6"=>$reg->latitud,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results); 

	break;		

	case 'rpt_documento_detalle': 
		$Persona_idPersona=$_REQUEST["Persona_idPersona"];

		$rspta=$consulta->rpt_documento_detalle($Persona_idPersona);
 		//Vamos a declarar un array
 		$data= Array();  
 
 		while ($reg=$rspta->fetchObject()){
 				//b.nroCheque,a.nroComprobante,a.concepto 
 			$data[]=array(
 				"0"=>$reg->imagenCIFrontal,
 				"1"=>$reg->imagenCITrasera,
 				"2"=>$reg->comentarioCi,
 				"3"=>$reg->estadoCi,
 				"4"=>$reg->vencimientoCi,	
 				"5"=>$reg->imagenLicenciaConducirFrontal,
 				"6"=>$reg->imagenLicenciaConducirTrasera,
 			/*	"7"=>$reg->comentarioLicenciaConducir,
 				"8"=>$reg->estadoLicenciaConducir,
 				"9"=>$reg->vencimientoLicenciaConducir,
 				"10"=>$reg->imagenAntecedentePolicial,
 				"11"=>$reg->comentarioAntecedente,
 				"12"=>$reg->estadoAntecedente,
 				"13"=>$reg->vencimientoAntecedente,*/
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results); 

	break;		


	case 'rpt_notacreditoventa_detalle':
		$NotaCreditoVenta_idNotaCreditoventa=$_REQUEST["NotaCreditoVenta_idNotaCreditoventa"];

		$rspta=$consulta->rpt_notacreditoventa_detalle($NotaCreditoVenta_idNotaCreditoventa);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 				//b.nroCheque,a.nroComprobante,a.concepto 
 			$data[]=array(
 				"0"=>$reg->nombre,
 				"1"=>$reg->cantidad,
 				"2"=>$reg->devuelve, 
 				"3"=>number_format($reg->totalNeto,0, ',', '.'),
 				"4"=>number_format($reg->total,0, ',', '.'),   
 				); 
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;	

	case 'rpt_notacreditocompra_detalle':
		$NotaCreditoCompra_idNotaCreditoCompra=$_REQUEST["NotaCreditoCompra_idNotaCreditoCompra"];

		$rspta=$consulta->rpt_notacreditocompra_detalle($NotaCreditoCompra_idNotaCreditoCompra);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 				//b.nroCheque,a.nroComprobante,a.concepto 
 			$data[]=array(
 				"0"=>$reg->nombre,
 				"1"=>$reg->cantidad,
 				"2"=>$reg->devuelve, 
 				"3"=>number_format($reg->totalNeto,0, ',', '.'),
 				"4"=>number_format($reg->total,0, ',', '.'),   
 				);  
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;	 


	case 'rpt_comodato':
		$Persona_idPersona=$_REQUEST["idPersona"];

		$rspta=$consulta->rpt_comodato($Persona_idPersona);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 				//b.nroCheque,a.nroComprobante,a.concepto 
 			$data[]=array(
 				"0"=>$reg->nombre,
 				"1"=>$reg->descripcion,
 				"2"=>number_format($reg->cantidad,0, ',', '.'),   
 				); 
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;		

	case 'rpt_precioventa':
		$idArticulo=$_REQUEST["idArticulo"];

		$rspta=$consulta->rpt_precioventa($idArticulo);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 				//b.nroCheque,a.nroComprobante,a.concepto 
 			$data[]=array(
 				"0"=>$reg->idArticulo,
 				"1"=>$reg->Descripcion,
 				"2"=>'<input type="text" class="input-xs" id="'.$reg->idPrecio.'" onblur="ajuste_actualizar_precio(this, \''.$reg->idPrecio.'\',\''.$reg->precio.'\')" style="width:100%;" value="'.$reg->precio.'" /><font color = white></font>',
 				"3"=>$reg->Sucursal,
 				"4"=>$reg->usuarioIns,
 				"5"=>$reg->fechaIns,
 				"6"=>$reg->usuarioMod,
 				"7"=>$reg->fechaMod,
 				); 
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

case 'rpt_direcciones_view':
    $Persona_idPersona = $_GET["idPersona"];
    $rspta = $consulta->rpt_direcciones_view($Persona_idPersona);
    
    $data = array();

    while ($reg = $rspta->fetchObject()) {
        $data[] = array(
            "0" => $reg->ciudad,
            "1" => $reg->direccion,
            "2" => $reg->lat,
            "3" => $reg->lng,
            "4" => $reg->lunes ?? '',
            "5" => $reg->martes ?? '',
            "6" => $reg->miercoles ?? '',
            "7" => $reg->jueves ?? '',
            "8" => $reg->viernes ?? '',
            "9" => $reg->sabado ?? '',
            "10" => $reg->domingo ?? '',
            "11" => $reg->idDireccion ?? '',
            "12" => $reg->imagen ?? ''
        );
    }

    $results = array(
        "sEcho" => 1,
        "iTotalRecords" => count($data),
        "iTotalDisplayRecords" => count($data),
        "aaData" => $data
    );

    echo json_encode($results);
break;


	case 'rpt_direcciones':
		$Persona_idPersona=$_REQUEST["idPersona"];

		$rspta=$consulta->rpt_direcciones($Persona_idPersona);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 				//b.nroCheque,a.nroComprobante,a.concepto 
 			$data[]=array(
 				"0"=>$reg->descripcion,
 				"1"=>$reg->direccion . '<br><a href="https://www.google.com/maps/?q='.$reg->latitud.','.$reg->longitud.'" target="_blank" class="btn btn-secondary">Navegar</a>' .  '<br><a href="https://www.mineraqua.com.py/mineraqua/files/direcciones/'.$reg->imagen.'" target="_blank" class="btn btn-primary">Ver Imagen</a>',
 				"2"=>$reg->latitud,
 				"3"=>$reg->longitud,
 				"4"=>(!$reg->lunes)?
 				'<span class="label bg-green">No</span><input type="checkbox" id="cbox1" onclick="marcarDias(this,\''.$reg->idDireccion.'\', 1, \'LUNES\');"> </label><br>':
 				'<span class="label bg-red">Si</span><input type="checkbox" id="cbox1" checked onclick="marcarDias(this,\''.$reg->idDireccion.'\', 0, \'LUNES\');">  </label><br>',
 				"5"=>(!$reg->martes)?
 				'<span class="label bg-green">No</span><input type="checkbox" id="cbox1" onclick="marcarDias(this,\''.$reg->idDireccion.'\', 1, \'MARTES\');"> </label><br>':
 				'<span class="label bg-red">Si</span><input type="checkbox" id="cbox1" checked onclick="marcarDias(this,\''.$reg->idDireccion.'\', 0, \'MARTES\');">  </label><br>',
 				"6"=>(!$reg->miercoles)?
 				'<span class="label bg-green">No</span><input type="checkbox" id="cbox1" onclick="marcarDias(this,\''.$reg->idDireccion.'\', 1, \'MIERCOLES\');"> </label><br>':
 				'<span class="label bg-red">Si</span><input type="checkbox" id="cbox1" checked onclick="marcarDias(this,\''.$reg->idDireccion.'\', 0, \'MIERCOLES\');">  </label><br>',
 				"7"=>(!$reg->jueves)?
 				'<span class="label bg-green">No</span><input type="checkbox" id="cbox1" onclick="marcarDias(this,\''.$reg->idDireccion.'\', 1, \'JUEVES\');"> </label><br>':
 				'<span class="label bg-red">Si</span><input type="checkbox" id="cbox1" checked onclick="marcarDias(this,\''.$reg->idDireccion.'\', 0, \'JUEVES\');">  </label><br>',
 				"8"=>(!$reg->viernes)?
 				'<span class="label bg-green">No</span><input type="checkbox" id="cbox1" onclick="marcarDias(this,\''.$reg->idDireccion.'\', 1, \'VIERNES\');"> </label><br>':
 				'<span class="label bg-red">Si</span><input type="checkbox" id="cbox1" checked onclick="marcarDias(this,\''.$reg->idDireccion.'\', 0, \'VIERNES\');">  </label><br>',
 				"9"=>(!$reg->sabado)?
 				'<span class="label bg-green">No</span><input type="checkbox" id="cbox1" onclick="marcarDias(this,\''.$reg->idDireccion.'\', 1, \'SABADO\');"> </label><br>':
 				'<span class="label bg-red">Si</span><input type="checkbox" id="cbox1" checked onclick="marcarDias(this,\''.$reg->idDireccion.'\', 0, \'SABADO\');">  </label><br>',
 				"10"=>(!$reg->domingo)?
 				'<span class="label bg-green">No</span><input type="checkbox" id="cbox1" onclick="marcarDias(this,\''.$reg->idDireccion.'\', 1, \'DOMINGO\');"> </label><br>':
 				'<span class="label bg-red">Si</span><input type="checkbox" id="cbox1" checked onclick="marcarDias(this,\''.$reg->idDireccion.'\', 0, \'DOMINGO\');">  </label><br>',
				"11" => $reg->vehiculo
					. ' <button class="btn btn-warning btn-sm" '
					. '     data-toggle="modal" data-target="#modalVehiculo" '
					. '     onclick="asignarVehiculo(' . $reg->idDireccion . ')">'
					. '     Cambiar</button>',
				"12"=>(!$reg->inactivo)?''.
 					' <button class="btn btn-danger btn-xs" onclick="desactivarDireccion('.$reg->idDireccion.')"><i class="fa fa-close"></i></button>':
 					''.
 					'',
 				); 
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;


	case 'desactivar':
		$rspta=$consulta->desactivarDireccion($idDireccion);
 		echo $rspta ? "Direccion Desactivado" : "Direccion no se puede desactivar";
	break;



	case 'rpt_movimiento_stock':
		$MovimientoStock_idMovimientoStock=$_REQUEST["MovimientoStock_idMovimientoStock"];

		$rspta=$consulta->rpt_movimiento_stock($MovimientoStock_idMovimientoStock);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 				//b.nroCheque,a.nroComprobante,a.concepto 
 			$data[]=array(
 				"0"=>$reg->nombre,
 				"1"=>$reg->cantidad,
 				"2"=>number_format($reg->precio,0, ',', '.'),
 				"3"=>number_format($reg->total,0, ',', '.'),   
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;	

	case 'rpt_cobros_detalle':
		$idVenta=$_REQUEST["idVenta"];

		$rspta=$consulta->rpt_cobros_detalle($idVenta);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			$data[]=array(
 				"0"=>$reg->idVenta,
 				"1"=>$reg->idTerminoPago,
 				"2"=>$reg->descripcion,
 				"3"=>number_format($reg->monto,0, ',', '.'),
 				"4"=>$reg->fecha,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;


	case 'rpt_pagos_detalle_todos':
		$idCompra=$_REQUEST["idCompra"];

		$rspta=$consulta->rpt_pagos_detalle_todos($idCompra);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			$data[]=array(
 				"0"=>$reg->idCompra,
 				"1"=>$reg->idTerminoPago,
 				"2"=>$reg->descripcion,
 				"3"=>$reg->fecha,
 				"4"=>number_format($reg->monto,0, ',', '.'),
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;


	case 'rpt_cobros_detalle_recibo':
		$idRecibo=$_REQUEST["idRecibo"];

		$rspta=$consulta->rpt_cobros_detalle_recibo($idRecibo);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			$data[]=array(
 				"0"=>$reg->VENTA_IDVENTA,
 				"1"=>$reg->idFormaPago,
 				"2"=>$reg->descripcion,
 				"3"=>number_format($reg->monto,0, ',', '.'),

 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;


	case 'rpt_cobros_detalle_pago':
		$idRecibo=$_REQUEST["idPago"];

		$rspta=$consulta->rpt_cobros_detalle_pago($idRecibo);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			$data[]=array(
 				"0"=>$reg->COMPRA_IDCOMPRA,
 				"1"=>$reg->idFormaPago,
 				"2"=>$reg->descripcion,
 				"3"=>number_format($reg->monto,0, ',', '.'),

 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
	
	case 'rpt_cuentasAPagar':
		$proveedor=$_REQUEST["proveedor"];
		$orden=$_REQUEST["orden"];
		$fechai=$_REQUEST["fechai"];
		$fechaf=$_REQUEST["fechaf"];

		$rspta=$consulta->rpt_cuentasAPagar($fechai, $fechaf, $orden, $proveedor);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			$data[]=array(
 				"0"=>$reg->nombreComercial,
 				"1"=>$reg->razonSocial,
 				"2"=>$reg->nroDocumento,
				"3"=>$reg->fechaFactura,
				"4"=>$reg->fechaVencimiento,
				"5"=>$reg->termino,
				"6"=>$reg->nroFactura,
				"7"=>number_format($reg->totalFactura,0, ',', '.'),
 				"8"=>number_format($reg->saldoFactura,0, ',', '.'),
				"9"=>$reg->nroCuota,
				"10"=>number_format($reg->monto,0, ',', '.'),
				"11"=>number_format($reg->saldo,0, ',', '.'),
				"12"=>$reg->diasVencido,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'rpt_movimientos':
		$proveedor=$_REQUEST["proveedor"];
		$orden=$_REQUEST["orden"];
		$fechai=$_REQUEST["fechai"];
		$fechaf=$_REQUEST["fechaf"];

		$rspta=$consulta->rpt_movimientos($fechai, $fechaf, $orden, $proveedor);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			$data[]=array(
				
 				"0"=>$reg->idMovimiento,
				"1"=>$reg->habilitacion,
				"2"=>$reg->fechaTrn,
				"3"=>$reg->nombreComercial,
				"4"=>$reg->md,
				"5"=>$reg->nc. '- Funcionario: '. $reg->nombreComercial,
				"6"=>$reg->usuario,
				"7"=>number_format($reg->cantidad,0,',','.'),
				"8"=>number_format($reg->precioUnitario,0,',','.'),
				"9"=>number_format($reg->monto,0,',','.'),
				"10"=>$reg->fp,
				"11"=>(!$reg->mi)?'<span class="label bg-green">Habilitado</span>':
 				'<span class="label bg-red">Cerrado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;	


	case 'rpt_cuentasAPagarAvanzado':
		$proveedor=$_REQUEST["proveedor"];
		$orden=$_REQUEST["orden"];
		$fechai=$_REQUEST["fechai"];
		$fechaf=$_REQUEST["fechaf"];

		$rspta=$consulta->rpt_cuentasAPagarAvanzado($fechai, $fechaf, $orden, $proveedor);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			$data[]=array(
 				"0"=>$reg->nombreComercial,
 				"1"=>$reg->razonSocial,
 				"2"=>$reg->nroDocumento,
				"3"=>$reg->fechaFactura,
				"4"=>$reg->fechaVencimiento,
				"5"=>$reg->termino,
				"6"=>$reg->nroFactura,
				"7"=>number_format($reg->totalFactura,0, ',', '.'),
 				"8"=>number_format($reg->saldoFactura,0, ',', '.'),
				"9"=>$reg->nroCuota,
				"10"=>number_format($reg->monto,0, ',', '.'),
				"11"=>number_format($reg->saldo,0, ',', '.'),
				"12"=>$reg->diasVencido,
				"13"=>$reg->origen,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;



	case 'rpt_cuentasACobrar':  
		$cliente=$_REQUEST["cliente"];
		$orden=$_REQUEST["orden"];
		$fechai=$_REQUEST["fechai"];
		$fechaf=$_REQUEST["fechaf"];

		$rspta=$consulta->rpt_cuentasACobrar($fechai, $fechaf, $orden, $cliente);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			if ($reg->termino == 'CREDITO') {
 	 			$data[]=array(
 				"0"=>($reg->nombreComercial),
 				"1"=>($reg->razonSocial),
 				"2"=>$reg->nroDocumento,
				"3"=>$reg->fechaFactura,
				"4"=>$reg->fechaVencimiento,
				"5"=>$reg->termino,
				"6"=>$reg->nroFactura,
				"7"=>number_format($reg->totalFactura,0, ',', '.'),
 				"8"=>number_format($reg->saldoFactura,0, ',', '.'),
				"9"=>$reg->nroCuota,
				"10"=>number_format($reg->monto,0, ',', '.'),
				"11"=>number_format($reg->saldo,0, ',', '.'),
				"12"=>$reg->diasVencido,
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
 

	case 'rpt_cuentasACobrarPorCliente':  
		$cliente=$_REQUEST["cliente"];
		$orden=$_REQUEST["orden"];
		$fechai=$_REQUEST["fechai"];
		$fechaf=$_REQUEST["fechaf"];

		$rspta=$consulta->rpt_cuentasACobrarPorCliente($fechai, $fechaf, $orden, $cliente);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 		 
 	 			$data[]=array(
 				"0"=>utf8_encode($reg->nombreComercial),
 				"1"=>utf8_encode($reg->razonSocial),
 				"2"=>$reg->nroDocumento,
				"3"=>number_format($reg->totalFactura,0, ',', '.'),
 				"4"=>number_format($reg->saldoFactura,0, ',', '.'),
				"5"=>number_format($reg->monto,0, ',', '.'),
				"6"=>number_format($reg->saldo,0, ',', '.'),
 				);			
 			 

 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'rpt_compras_habilitacion':
		$habilitacion=$_REQUEST["habilitacion"];

		$rspta=$consulta->rpt_compras_habilitacion($habilitacion);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			$condicion = 'CONTADO';

 			$data[]=array(
 				"0"=>$reg->idCompra,
 				"1"=>$reg->Habilitacion_idHabilitacion,
 				"2"=>$reg->idProveedor,
 				"3"=>$reg->razonSocial,
 				"4"=>$reg->nombreComercial,
 				"5"=>$condicion,
 				"6"=>number_format($reg->totalImpuesto,0, ',', '.'),
 				"7"=>number_format($reg->total,0, ',', '.'),
 				"8"=>(!$reg->vi)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>',
 				"9"=>'<button class="btn btn-primary" onclick="mostrar('.$reg->idCompra.')">Ver detalle de compra <i class="fa fa-pencil"></i></button>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;


	case 'rpt_compras_fecha':
		$fi=$_REQUEST["fi"];
		$ff=$_REQUEST["ff"];

		$rspta=$consulta->rpt_compras_fecha($fi,$ff);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>$reg->idCompra,
 				"1"=>$reg->Habilitacion_idHabilitacion,
 				"2"=>$reg->idProveedor,
 				"3"=>$reg->razonSocial,
 				"4"=>$reg->nombreComercial,
 				"5"=>number_format($reg->totalImpuesto,0, ',', '.'),
 				"6"=>number_format($reg->total,0, ',', '.'),
 				"7"=>(!$reg->vi)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>',

 				"8"=>'<button class="btn btn-primary" onclick="mostrar('.$reg->idCompra.')">Ver detalle de compra <i class="fa fa-pencil"></i></button>',
 				"9"=>$reg->total,

 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	

	case 'rpt_tapasVentas':
		$fi=$_REQUEST["fi"];
		$ff=$_REQUEST["ff"];

		$rspta=$consulta->rpt_tapasVentas($fi,$ff);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>$reg->descripcion,
 				"1"=>number_format($reg->cantidad,0, ',', '.'),
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;



	case 'rpt_recaudaciones_gastos':
		$fi=$_REQUEST["fi"];
		$ff=$_REQUEST["ff"];

		$rspta=$consulta->rpt_recaudaciones_gastos($fi,$ff);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>$reg->descripcion,
 				"1"=>number_format($reg->total,0, ',', '.'),
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;


	case 'rpt_compras_detalle':
		$idCompra=$_REQUEST["idCompra"];

		$rspta=$consulta->rpt_compras_detalle($idCompra);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			$data[]=array(
 				"0"=>$reg->Compra_idCompra,
 				"1"=>$reg->Articulo_idArticulo,
 				"2"=>utf8_encode($reg->nombre),
 				"3"=>utf8_encode($reg->descripcion),
 				"4"=>number_format($reg->precio,0, ',', '.'),
 				"5"=>number_format($reg->descuento,0, ',', '.'). ' %',
 				"6"=>number_format($reg->cantidad,0, ',', '.'),
 				"7"=>number_format($reg->total - ( (($reg->precio*$reg->cantidad) * $reg->descuento) / 100 ),0, ',', '.'),
 				"8"=>$reg->precio,
 				"9"=>$reg->total,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;



	case 'rpt_ajuste_detalle':
		$idAjusteStock=$_REQUEST["idAjusteStock"];

		$rspta=$consulta->rpt_ajustes_detalle($idAjusteStock);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			$data[]=array(
 				"0"=>$reg->AjusteStock_idAjusteStock,
 				"1"=>$reg->Articulo_idArticulo,
 				"2"=>utf8_encode($reg->descripcion),
 				"3"=>$reg->Deposito_idDeposito,
 				"4"=>number_format($reg->cantidad,0, ',', '.'),
 				"5"=>number_format($reg->cantidadReal,0, ',', '.'),
				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;	

	case 'rpt_nc_detalle':
		$idNotaCredito=$_REQUEST["idNotaCredito"];

		$rspta=$consulta->rpt_nc_detalle($idNotaCredito);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			$data[]=array(
 				"0"=>$reg->idNotaCreditoCompraDetalle,
 				"1"=>$reg->Articulo_idArticulo,
 				"2"=>utf8_encode($reg->nombre),
 				"3"=>utf8_encode($reg->descripcion),
 				"4"=>number_format($reg->costo,0, ',', '.'),
 				"5"=>number_format($reg->cantidad,0, ',', '.'),
 				"6"=>number_format($reg->total,0, ',', '.'),
 				"7"=>$reg->precio,
 				"8"=>$reg->total,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;


	case 'rpt_ncv_detalle':
		$idNotaCredito=$_REQUEST["idNotaCredito"];

		$rspta=$consulta->rpt_ncv_detalle($idNotaCredito);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			$data[]=array(
 				"0"=>$reg->idNotaCreditoVentaDetalle,
 				"1"=>$reg->Articulo_idArticulo,
 				"2"=>utf8_encode($reg->nombre),
 				"3"=>utf8_encode($reg->descripcion),
 				"4"=>number_format($reg->precio,0, ',', '.'),
 				"5"=>number_format($reg->cantidad,0, ',', '.'),
 				"6"=>number_format($reg->total,0, ',', '.'),
 				"7"=>$reg->precio,
 				"8"=>$reg->total,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;


	case 'rpt_inventario_deposito':
		$idDeposito=$_REQUEST["idDeposito"];

		$rspta=$consulta->rpt_inventario_deposito($idDeposito);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			$data[]=array(
 				"0"=>$reg->idArticulo,
 				"1"=>$reg->na,
 				"2"=>$reg->nc,
 				"3"=>number_format($reg->stock,0, ',', '.'),
 				"4"=>number_format($reg->costo,0, ',', '.'),
 				"5"=>number_format($reg->costo * $reg->stock,0, ',', '.'),
 				"6"=>$reg->costo,
 				"7"=>$reg->costo * $reg->stock,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'rpt_inventario_deposito_ajuste':
		$idDeposito=$_REQUEST["idDeposito"];

		$rspta=$consulta->rpt_inventario_deposito_ajuste($idDeposito);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			$data[]=array(
 				"0"=>$reg->idArticulo,
 				"1"=>$reg->codigo,
 				"2"=>$reg->na,
 				"3"=>$reg->nc,
 				"4"=>$reg->Cantidad,
 				"5"=>'<input type="text" class="input-sm" id="'.$reg->idArticulo.'" ondblclick="refresh(this)" onblur="actualizar(this, \''.$reg->idArticulo.'\',\''.$reg->Deposito_idDeposito.'\')" style="width:100%;" value="'.$reg->Cantidad.'" /><font color = white></font>',
 				"6"=>number_format($reg->precioVenta,0, ',', '.'),
 				"7"=>number_format($reg->precioVenta * $reg->Cantidad,0, ',', '.'),
 				"8"=>$reg->precioVenta,
 				"9"=>$reg->precioVenta * $reg->Cantidad,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'rpt_inventario_deposito_consulta':
		$idDeposito=$_REQUEST["idDeposito"];

		$rspta=$consulta->rpt_inventario_deposito_consulta($idDeposito);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			$data[]=array(
 				"0"=>$reg->idArticulo,
 				"1"=>$reg->na,
 				"2"=>$reg->nc,
 				"3"=>$reg->Cantidad,
 				"4"=>number_format($reg->precioVenta,0, ',', '.'),
 				"5"=>number_format($reg->precioVenta * $reg->Cantidad,0, ',', '.'),
 				"6"=>$reg->precioVenta,
 				"7"=>$reg->precioVenta * $reg->Cantidad,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'ajuste_actualizar_precio':
		
		$precio=$_REQUEST["precio"];
		$idPrecio=$_REQUEST["idPrecio"];

		$rspta=$consulta->ajuste_actualizar_precio($precio,$idPrecio);
 		//Vamos a declarar un array
 		$data= Array();

	break;
	
	case 'ajuste_actualizar':
		$cantidad=$_REQUEST["cantidad"];
		$articulo=$_REQUEST["articulo"];
		$deposito=$_REQUEST["deposito"];

		$rspta=$consulta->ajuste_actualizar($cantidad,$articulo,$deposito);
 		//Vamos a declarar un array
 		$data= Array();

 		/*while ($reg=$rspta->fetchObject()){

 			$data[]=array(
 				"0"=>$reg->idArticulo,
 				"1"=>$reg->na,
 				"2"=>$reg->nc,
 				"3"=>$reg->Cantidad,
 				"4"=>$reg->Cantidad,
 				"5"=>$reg->precioVenta,
 				"6"=>$reg->precioVenta * $reg->Cantidad,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
*/
	break;


case 'ajuste_actualizar_clientedetalle':
		$cantidad=$_REQUEST["cantidad"];
		$id=$_REQUEST["id"];

		$rspta=$consulta->ajuste_actualizar_clientedetalle($cantidad,$id);
 		//Vamos a declarar un array
 		$data= Array();

 		/*while ($reg=$rspta->fetchObject()){

 			$data[]=array(
 				"0"=>$reg->idArticulo,
 				"1"=>$reg->na,
 				"2"=>$reg->nc,
 				"3"=>$reg->Cantidad,
 				"4"=>$reg->Cantidad,
 				"5"=>$reg->precioVenta,
 				"6"=>$reg->precioVenta * $reg->Cantidad,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
*/
	break;


	case "selectDeposito":
		require_once "../modelos/Caja.php";
		$caja = new Caja();

		$rspta = $caja->selectCaja();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idDEposito. '>' .$reg->descripcion.'</option>';
		}

		break;


	case "selectArticulo":
		require_once "../modelos/Articulo.php";
		$caja = new Articulo();

		$rspta = $caja->listar();
		echo '<option value="todos">Todos los productos.</option>';

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idArticulo. '>' .$reg->na.'</option>';
		}

		break;



	case 'rpt_arqueo_caja':
		$habilitacion=$_REQUEST["habilitacion"];

		$rspta=$consulta->rpt_arqueo_caja($habilitacion);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			$data[]=array(
 				"0"=>$reg->habilitacion,
 				"1"=>$reg->descripcion,
 				"2"=>number_format($reg->total,0, ',', '.'),
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;


	case 'rpt_clientes_paquetes':
		$idCliente=$_REQUEST["idCliente"];

		$rspta=$consulta->rpt_clientes_paquetes($idCliente);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			$data[]=array(
 				"0"=>$reg->idCliente,
 				"1"=>$reg->razonSocial,
 				"2"=>number_format($reg->cantidad,0, ',', '.'),
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'consumirOrden':
		$idEmpleado=$_REQUEST["idEmpleado"];

		$rspta=$consulta->consumir_servicios($idEmpleado);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			$data[]=array(
 				"0"=>$reg->idOrdenConsumisionDetalle,
 				"1"=>$reg->nc,
 				"2"=>$reg->sge,
 				"3"=>$reg->fi,
 				"4"=>$reg->ff,
 				"5"=>$reg->PAQUETE,
 				"6"=>$reg->SERVICIO,
 				"7"=>$reg->comision,
 				"8"=>$reg->a,
 				"9"=>$reg->b,
 				"10"=>$reg->cantidad,
 				"11"=>'<input type="text" class="input-sm" id="'.$reg->idOrdenConsumisionDetalle.'"  onblur="actualizar(this)" style="width:100%;" value="'.$reg->cantidadrestante.'" /><font color = white></font>',
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'orden_actualizar':
	
		$cantidad=$_REQUEST["cantidad"];
		$lid=$_REQUEST["lid"];

		$rspta=$consulta->orden_actualizar($cantidad,$lid);
 		//Vamos a declarar un array
 		$data= Array();

 		/*while ($reg=$rspta->fetchObject()){

 			$data[]=array(
 				"0"=>$reg->idArticulo,
 				"1"=>$reg->na,
 				"2"=>$reg->nc,
 				"3"=>$reg->Cantidad,
 				"4"=>$reg->Cantidad,
 				"5"=>$reg->precioVenta,
 				"6"=>$reg->precioVenta * $reg->Cantidad,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
*/
	break;




	case 'rpt_clienteDetalle_ajuste':
		$Cliente_idCliente=$_REQUEST["Cliente_idCliente"];

		$rspta=$consulta->rpt_clienteDetalle_ajuste($Cliente_idCliente);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			$data[]=array(
 				"0"=>$reg->idclientedetalle,
 				"1"=>$reg->Venta_idVenta,
 				"2"=>$reg->ff,
 				"3"=>$reg->nombreComercial,
 				"4"=>$reg->npaquete,
 				"5"=>$reg->nservicio,
 				"6"=>$reg->cantidad,
 				"7"=>'<input type="text" class="input-sm" id="'.$reg->idclientedetalle.'" ondblclick="refresh(this)" onblur="actualizar(this, \''.$reg->id.'\',\''.$reg->idclientedetalle.'\')" style="width:100%;" value="'.$reg->cantidad.'" /><font color = white></font>',
 				"8"=>$reg->giftcard,
 				"9"=>$reg->saldo,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'rpt_consumisiones_cliente':
		$Cliente_idCliente=$_REQUEST["idCliente"];

		$rspta=$consulta->rpt_consumisiones_cliente(0,0,$Cliente_idCliente);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			$data[]=array(
 				"0"=>$reg->idclientedetalle,
 				"1"=>$reg->nc,
 				"2"=>$reg->na,
 				"3"=>$reg->ns,
 				"4"=>$reg->Venta_idVenta,
 				"5"=>$reg->fechaFactura,
 				"6"=>$reg->fecha_inicial,
 				"7"=>$reg->fecha_final,
 				"8"=>$reg->ne,
 				"9"=>$reg->cantidadUtilizada,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;


	case 'rpt_ordenesConsumisionDetalle_d':
		$fi=$_REQUEST["fi"];
		$ff=$_REQUEST["ff"];
		$idCliente=$_REQUEST["idCliente"];
		$idPaquete=$_REQUEST["idPaquete"];
		$idServicio=$_REQUEST["idServicio"];

		$rspta=$consulta->rpt_ordenesConsumisionDetalle_d($fi,$ff,$idCliente,$idPaquete,$idServicio);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){


 			if ($reg->cantidadUtilizada > 0) {
 				$utilizado = '<span class="badge badge-success">Uso parcial</span>';
 			}

 			if ($reg->cantidadUtilizada == $reg->cantidad) {
 				$utilizado = '<span class="badge badge-success">Utilizado</span>';
 			}

 			if ($reg->cantidadUtilizada == 0) {
 				$utilizado = '<span class="badge badge-info">Pendiente de uso</span>';
 			}

 			$data[]=array(
 				"0"=>$reg->idOrdenConsumision,
 				"1"=>$reg->idOrdenConsumisionDetalle,
 				"2"=>$reg->fechaCarga,
 				"3"=>$reg->cliente, 
 				"4"=>$reg->paquete,
 				"5"=>$reg->servicio,
 				"6"=>$reg->cantidad,
 				"7"=>$utilizado,
 				"8"=>$reg->fecha_inicial,
 				"9"=>$reg->fecha_final,
 				"10"=>$reg->atiende,
 				"11"=>$reg->Usuario,
 				"12"=>$reg->idVenta,
 				"13"=>$reg->saldo,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;



	case 'rpt_producto_x_fecha_x_orden':
		$fi=$_REQUEST["fi"];
		$ff=$_REQUEST["ff"];
		$idEmpleado=$_REQUEST["idEmpleado"];
		$idArticulo=$_REQUEST["idArticulo"];

		$rspta=$consulta->rpt_producto_x_fecha_x_orden($fi,$ff, $idEmpleado, $idArticulo);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){


 			$data[]=array(
 				"0"=>$reg->idOrdenConsumision,
 				"1"=>$reg->idOrdenConsumisionDetalle,
 				"2"=>$reg->idVenta,
 				"3"=>$reg->fechaVenta,
 				"4"=>$reg->NombreCliente, 
 				"5"=>$reg->na,
 				"6"=>number_format($reg->comision,0, ',', '.'),
 				"7"=>number_format($reg->PrecioVenta,0, ',', '.'),
 				"8"=>number_format($reg->saldo,0, ',', '.'),
 				"9"=>$reg->Vendedor
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'rpt_producto_x_fecha_x_orden_d':
		$fi=$_REQUEST["fi"];
		$ff=$_REQUEST["ff"];
		$idEmpleado=$_REQUEST["idEmpleado"];
		$idArticulo=$_REQUEST["idArticulo"];

		$rspta=$consulta->rpt_producto_x_fecha_x_orden_d($fi,$ff, $idEmpleado, $idArticulo);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){


 			$data[]=array(
 				"0"=>$reg->idOrdenConsumision,
 				"1"=>$reg->idOrdenConsumisionDetalle,
 				"2"=>$reg->idVenta,
 				"3"=>$reg->fechaVenta,
 				"4"=>$reg->NombreCliente, 
 				"5"=>$reg->na,
 				"6"=>number_format($reg->comision,0, ',', '.'),
 				"7"=>number_format($reg->PrecioVenta,0, ',', '.'),
 				"8"=>number_format($reg->saldo,0, ',', '.'),
 				"9"=>$reg->Vendedor
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
	
	case 'hechaukaCompras':
		$fecha_inicio=$_REQUEST["f_i"];
		$fecha_fin=$_REQUEST["f_f"];

		$rspta=$consulta->hechaukaCompras($fecha_inicio,$fecha_fin);
		
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

		$date = date_create($reg->Fecha);
 			$data[]=array(
 				"0"=>2,
 				"1"=>$reg->RUC,
 				"2"=>$reg->DV,
 				"3"=>$reg->Proveedor,
				"4"=>$reg->Timbrado,
				"5"=>$reg->Tipo,
				"6"=>$reg->Nro,
				"7"=>date_format($date, 'd/m/Y'),
				"8"=>$reg->Gravada10,
				"9"=>$reg->IVA10,
				"10"=>$reg->Gravada5,
				"11"=>$reg->IVA5,
				"12"=>$reg->Exento,
				"13"=>0,
				"14"=>$reg->ContCred,
				"15"=>$reg->Cuota,
				"16"=>$reg->Gravada10+$reg->Gravada5+$reg->Exento,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	break;
	
	case 'hechaukaVentas':
		$fecha_inicio=$_REQUEST["f_i"];
		$fecha_fin=$_REQUEST["f_f"];

		$rspta=$consulta->hechaukaVentas($fecha_inicio,$fecha_fin);
		
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

		$date = date_create($reg->Fecha);
 			$data[]=array(
 				"0"=>2,
 				"1"=>$reg->RUC,
 				"2"=>$reg->DV,
 				"3"=>$reg->Proveedor,
				"4"=>$reg->Tipo,
				"5"=>$reg->Nro,
				"6"=>date_format($date, 'd/m/Y'),
				"7"=>$reg->Gravada10,
				"8"=>$reg->IVA10,
				"9"=>$reg->Gravada5,
				"10"=>$reg->IVA5,
				"11"=>$reg->Exento,
				"12"=>$reg->Gravada10+$reg->IVA10+$reg->Gravada5+$reg->IVA5+$reg->Exento,
				"13"=>$reg->ContCred,
				"14"=>$reg->Cuota,
				"15"=>$reg->Timbrado,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'rptordenventas':
		$fecha_inicio=$_REQUEST["f_i"];
		$fecha_fin=$_REQUEST["f_f"];
		$url='../reportes/rptOv.php?idOrdenVenta=';
		$rspta=$consulta->rptordenventas($fecha_inicio,$fecha_fin);
		
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
		
		$date = date_create($reg->Fecha);
 			$data[]=array(
 				"0"=>((!$reg->ovi)?'<a target="_blank" href="'.$url.$reg->idOrdenVenta.'"> <button class="btn btn-info"><i class="fa fa-file"></i></button></a>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idOrdenVenta.')"><i class="fa fa-eye"></i></button>'),
 				"1"=>$reg->nombreComercial,
 				"2"=>$reg->nroDocumento,
 				"3"=>$reg->nroFactura,
				"4"=>$reg->fecha,
				"5"=>$reg->termino,
				"6"=>$reg->moneda,
				"7"=>$reg->total,
				"8"=>$reg->montoCuota, 
				"9"=>$reg->montoCuota,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;  

 
	
	case 'rptventas':
		$fecha_inicio=$_REQUEST["f_i"];
		$fecha_fin=$_REQUEST["f_f"];

		$rspta=$consulta->rptventas($fecha_inicio,$fecha_fin);
		
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			if ($reg->Remision == 'S') {
 				$remision = "<span class='label bg-green'>REMISION:SI</span>";
 			}else{
 				$remision = "";	
 			}

		$date = date_create($reg->Fecha);
 			$data[]=array(
 				"0"=>$reg->idVenta."<br>$remision",
 				"1"=>utf8_encode($reg->nombreComercial),
 				"2"=>utf8_encode($reg->nroDocumento),
 				"3"=>$reg->nroFactura,
				"4"=>$reg->fechaTransaccion,
				"5"=>$reg->fechaVencimiento,
				"6"=>$reg->timbrado,
				"7"=>$reg->termino,
				"8"=>$reg->moneda,
				"9"=>number_format($reg->total),
				"10"=>number_format($reg->montoCuota),
				"11"=>$reg->vendedor,
				"12"=>$reg->usuario,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;  
	
	case 'rptventasAnuladas':
		$fecha_inicio=$_REQUEST["f_i"];
		$fecha_fin=$_REQUEST["f_f"];

		$rspta=$consulta->rptventasAnuladas($fecha_inicio,$fecha_fin);
		
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

		$date = date_create($reg->Fecha);
 			$data[]=array(
 				"0"=>$reg->idVenta,
 				"1"=>$reg->nombreComercial,
 				"2"=>$reg->nroDocumento,
 				"3"=>$reg->nroFactura,
				"4"=>$reg->fechaTransaccion,
				"5"=>$reg->fechaVencimiento,
				"6"=>$reg->timbrado,
				"7"=>$reg->termino,
				"8"=>$reg->moneda,
				"9"=>$reg->total,
				"10"=>$reg->montoCuota,
				"11"=>$reg->vendedor,
				"12"=>$reg->usuario,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;


	case 'selectCuentaContableLibroDiario':  
		require_once "../modelos/cuentaContable.php";  
		$idCuentaContable = new cuentaContable();
		$rspta = $idCuentaContable->listarparaLibroDiario();

		while ($reg = $rspta->fetchObject())  
				{
				echo '<option value=' . $reg->idCuentaContable . '>' . $reg->descripcion . '</option>';
				}
	break;

      
	case 'libroDiario':
		$fecha_inicio=$_REQUEST["f_i"];
		$fecha_fin=$_REQUEST["f_f"];

		$cuenta_inicio=$_REQUEST["c_i"];
		$cuenta_fin=$_REQUEST["c_f"];

		$rspta=$consulta->libroDiario($fecha_inicio,$fecha_fin,$cuenta_inicio,$cuenta_fin);
		
 		//Vamos a declarar un array
 		$data= Array();
 		while ($reg=$rspta->fetchObject()){

		//date = date_create($reg->fechaAsiento);
 			$data[]=array(
 				"0"=>$reg->idAsiento,
 				"1"=>$reg->fechaAsiento, 
 				"2"=>$reg->comentario,
 				"3"=>$reg->cuentaContableDesc,
				"4"=>$reg->tipoMovimientoDesc,
				"5"=>number_format($reg->Debito,0, ',', '.'),
				"6"=>number_format($reg->Credito,0, ',', '.'),
 				); 
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
     
	case 'libroMayor':
		$fecha_inicio=$_REQUEST["f_i"];
		$fecha_fin=$_REQUEST["f_f"];

		$cuenta_inicio=$_REQUEST["c_i"];
		$cuenta_fin=$_REQUEST["c_f"];

		$rspta=$consulta->libroMayor($fecha_inicio,$fecha_fin,$cuenta_inicio,$cuenta_fin);
		
 		//Vamos a declarar un array
 		$data= Array();
 		while ($reg=$rspta->fetchObject()){

		//date = date_create($reg->fechaAsiento);
 			$data[]=array(
 				"0"=>$reg->cuentaContableDesc,
 				"1"=>$reg->fechaAsiento, 
 				"2"=>$reg->idAsiento, 
 				"3"=>$reg->comentario, 
				"4"=>$reg->tipoMovimientoDesc,
				"5"=>number_format($reg->Debito,0, ',', '.'),
				"6"=>number_format($reg->Credito,0, ',', '.'),
 				); 
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;	

case 'balance':
		$fecha_inicio=$_REQUEST["f_i"];
		$fecha_fin=$_REQUEST["f_f"];

		$cuenta_inicio=$_REQUEST["c_i"];
		$cuenta_fin=$_REQUEST["c_f"];

		$rspta=$consulta->balance($cuenta_inicio,$cuenta_fin,$fecha_inicio,$fecha_fin);
		
 		//Vamos a declarar un array
 		$data= Array();
 		while ($reg=$rspta->fetchObject()){

		//date = date_create($reg->fechaAsiento);
 			$data[]=array(
 				"0"=>$reg->cuentaContableDesc,
 				"1"=>$reg->nroCuentaContable, 
 				"2"=>$reg->nroCuentaContable, 
 				"3"=>number_format($reg->saldoAnterior,0, ',', '.'),
 				"4"=>number_format($reg->saldoActual,0, ',', '.'),
				"5"=>$reg->tipoMovimientoDesc,
				"6"=>number_format($reg->debitoAcumulado,0, ',', '.'),
				"7"=>number_format($reg->creditoAcumulado,0, ',', '.'),
				"8"=>number_format($reg->debito,0, ',', '.'),
				"9"=>number_format($reg->credito,0, ',', '.'),
 				); 
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;


case 'GeneraBalance':
		$fecha_inicio=$_REQUEST["f_i"];
		$fecha_fin=$_REQUEST["f_f"];

		$cuenta_inicio=$_REQUEST["c_i"];
		$cuenta_fin=$_REQUEST["c_f"];

		$rspta=$consulta->GeneraBalance($cuenta_inicio,$cuenta_fin,$fecha_inicio,$fecha_fin);
		
 		//Vamos a declarar un array
 		$data= Array();
 		while ($reg=$rspta->fetchObject()){

		//date = date_create($reg->fechaAsiento);
 			$data[]=array(
 				"0"=>$reg->cuentaContableDesc,
 				"1"=>$reg->nroCuentaContable, 
 				"2"=>$reg->nroCuentaContable, 
 				"3"=>number_format($reg->saldoAnterior,0, ',', '.'),
 				"4"=>number_format($reg->saldoActual,0, ',', '.'),
				"5"=>$reg->tipoMovimientoDesc,
				"6"=>number_format($reg->debitoAcumulado,0, ',', '.'),
				"7"=>number_format($reg->creditoAcumulado,0, ',', '.'),
				"8"=>number_format($reg->debito,0, ',', '.'),
				"9"=>number_format($reg->credito,0, ',', '.'),
 				); 
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;	

case 'GeneraAgrupacionCuentasContables':
		$fecha_inicio=$_REQUEST["f_i"];
		$fecha_fin=$_REQUEST["f_f"];

		$cuenta_inicio=$_REQUEST["c_i"];
		$cuenta_fin=$_REQUEST["c_f"];

		$rspta=$consulta->generaAgrupacionCuentasContables($fecha_inicio,$fecha_fin,$cuenta_inicio,$cuenta_fin);
		
 		//Vamos a declarar un array
 		$data= Array();
 		while ($reg=$rspta->fetchObject()){

		//date = date_create($reg->fechaAsiento);
 			$data[]=array(
 				"0"=>$reg->cuentaContableDesc,
 				"1"=>$reg->nroCuentaContable, 
 				"2"=>$reg->nivel, 
				"3"=>number_format($reg->Debito,0, ',', '.'),
				"4"=>number_format($reg->Credito,0, ',', '.'),
 				); 
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;	

case 'agrupacionCuentasContables':
		$fecha_inicio=$_REQUEST["f_i"];
		$fecha_fin=$_REQUEST["f_f"];

		$cuenta_inicio=$_REQUEST["c_i"];
		$cuenta_fin=$_REQUEST["c_f"];

		$rspta=$consulta->agrupacionCuentasContables($fecha_inicio,$fecha_fin,$cuenta_inicio,$cuenta_fin);
		
 		//Vamos a declarar un array
 		$data= Array();
 		while ($reg=$rspta->fetchObject()){

		//date = date_create($reg->fechaAsiento);
 			$data[]=array(
 				"0"=>$reg->cuentaContableDesc,
 				"1"=>$reg->nroCuentaContable, 
 				"2"=>$reg->nivel, 
				"3"=>number_format($reg->Debito,0, ',', '.'),
				"4"=>number_format($reg->Credito,0, ',', '.'),
 				); 
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

eak;	

case 'maestroSaldos':

		$cuenta_inicio=$_REQUEST["c_i"];
		$cuenta_fin=$_REQUEST["c_f"];

		$rspta=$consulta->maestroSaldos($cuenta_inicio,$cuenta_fin);
		
 		//Vamos a declarar un array
 		$data= Array();
 		while ($reg=$rspta->fetchObject()){

		//date = date_create($reg->fechaAsiento);
 			$data[]=array(
 				"0"=>$reg->cuentaContableDesc,
 				"1"=>$reg->nroCuentaContable, 
 				"2"=>$reg->nroCuentaContable, 
				"3"=>number_format($reg->saldoAnterior,0, ',', '.'),
				"4"=>number_format($reg->saldoActual,0, ',', '.'),
				"5"=>number_format($reg->debeAcumulado,0, ',', '.'),
				"6"=>number_format($reg->haberAcumulado,0, ',', '.'),
				"7"=>number_format($reg->debitoAnterior,0, ',', '.'),
				"8"=>number_format($reg->creditoAnterior,0, ',', '.'),								
 				); 
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;	


case 'GenerarMaestroSaldos':

		$cuenta_inicio=$_REQUEST["c_i"];
		$cuenta_fin=$_REQUEST["c_f"];

		$rspta=$consulta->GenerarMaestroSaldos($cuenta_inicio,$cuenta_fin);
		
 		//Vamos a declarar un array
 		$data= Array();
 		while ($reg=$rspta->fetchObject()){

		//date = date_create($reg->fechaAsiento);
 			$data[]=array(
 				"0"=>$reg->cuentaContableDesc,
 				"1"=>$reg->nroCuentaContable, 
 				"2"=>$reg->nroCuentaContable, 
				"3"=>number_format($reg->saldoAnterior,0, ',', '.'),
				"4"=>number_format($reg->saldoActual,0, ',', '.'),
				"5"=>number_format($reg->debeAcumulado,0, ',', '.'),
				"6"=>number_format($reg->haberAcumulado,0, ',', '.'),
				"7"=>number_format($reg->debitoAnterior,0, ',', '.'),
				"8"=>number_format($reg->creditoAnterior,0, ',', '.'),								
 				); 
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;		
 
	case 'libroCompras':
		$fecha_inicio=$_REQUEST["f_i"];
		$fecha_fin=$_REQUEST["f_f"];

		$rspta=$consulta->libroCompras($fecha_inicio,$fecha_fin);
		
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

		$date = date_create($reg->Fecha);
 			$data[]=array(
 				"0"=>$reg->Nro,
 				"1"=>date_format($date, 'd/m/Y'),
 				"2"=>$reg->Proveedor,
 				"3"=>$reg->RUC,
				"4"=>$reg->Timbrado,
				"5"=>$reg->Gravada10,
				"6"=>$reg->Gravada5,
				"7"=>$reg->IVA10,
				"8"=>$reg->IVA5,
				"9"=>$reg->Exento,
				"10"=>$reg->Total,
				"11"=>number_format($reg->Gravada10USD, 4, ",", "."),
				"12"=>number_format($reg->Gravada5USD, 4, ",", "."),
				"13"=>number_format($reg->IVA10USD, 4, ",", "."),
				"14"=>number_format($reg->IVA5USD, 4, ",", "."),
				"15"=>number_format($reg->ExentoUSD, 4, ",", "."),
				"16"=>number_format($reg->TotalUSD, 4, ",", "."),
				"17"=>$reg->TasaCambio,
				"18"=>$reg->Tipo,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	break;

		
	case 'libroVentas':
		$fecha_inicio=$_REQUEST["f_i"];
		$fecha_fin=$_REQUEST["f_f"];

		$rspta=$consulta->libroVentas($fecha_inicio,$fecha_fin);
		
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

		$date = date_create($reg->Fecha);
 			$data[]=array(
 				"0"=>$reg->Nro,
 				"1"=>date_format($date, 'd/m/Y'),
 				"2"=>$reg->Proveedor,
 				"3"=>$reg->RUC,
				"4"=>$reg->Timbrado,
				"5"=>$reg->Gravada10,
				"6"=>$reg->Gravada5,
				"7"=>$reg->IVA10,
				"8"=>$reg->IVA5,
				"9"=>$reg->Exento,
				"10"=>$reg->Total,
				"11"=>$reg->TasaCambio,
				"12"=>$reg->Tipo,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;



}
?>