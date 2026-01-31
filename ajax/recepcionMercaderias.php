<?php 
if (strlen(session_id()) < 1) 
  session_start();

require_once "../modelos/RecepcionMercaderias.php";

$recepcionMercaderias=new RecepcionMercaderias();

$idrecepcionMercaderias=isset($_POST["idrecepcionMercaderias"])? limpiarCadena($_POST["idrecepcionMercaderias"]):"";
$Persona_idPersona=isset($_POST["Persona_idPersona"])? limpiarCadena($_POST["Persona_idPersona"]):"";
$Habilitacion_idHabilitacion=isset($_POST["Habilitacion_idHabilitacion"])? limpiarCadena($_POST["Habilitacion_idHabilitacion"]):"";
$Deposito_idDeposito=isset($_POST["Deposito_idDeposito"])? limpiarCadena($_POST["Deposito_idDeposito"]):"";
$TerminoPago_idTerminoPago=isset($_POST["TerminoPago_idTerminoPago"])? limpiarCadena($_POST["TerminoPago_idTerminoPago"]):"";
$fecha=isset($_POST["fecha"])? limpiarCadena($_POST["fecha"]):"";


switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idrecepcionMercaderias)){
			$rspta=$recepcionMercaderias->insertar($Persona_idPersona,$Habilitacion_idHabilitacion,$Deposito_idDeposito,$TerminoPago_idTerminoPago,$fecha,$_POST["idarticulo"],$_POST["cantidad"],$_POST["precioVenta"],$_POST["descuento"],$_POST["impuesto"]);
			
			echo $rspta ? "recepcionMercaderias registrada" : "No se pudieron registrar todos los datos de la recepcionMercaderias";
		}
		else {
		}
	break;

	case 'anular':
		$rspta=$recepcionMercaderias->anular($idrecepcionMercaderias);
 		echo $rspta ? "recepcionMercaderias anulada" : "recepcionMercaderias no se puede anular";
	break;

	case 'mostrar':
		$rspta=$recepcionMercaderias->mostrar($idrecepcionMercaderias);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listarDetalle':
		//Recibimos el idingreso
		$id=$_GET['id'];

		$rspta = $recepcionMercaderias->listarDetalle($id);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio recepcionMercaderias</th>
                                    <th>Descuento</th>
                                    <th>Subtotal</th>
                                </thead>';

		while ($reg = $rspta->fetchObject())
				{
					echo '<tr class="filas"><td></td><td>'.$reg->nombre.'</td><td>'.$reg->cantidad.'</td><td>'.$reg->precio_recepcionMercaderias.'</td><td>'.$reg->descuento.'</td><td>'.$reg->subtotal.'</td></tr>';
					$total=$total+($reg->precio_recepcionMercaderias*$reg->cantidad-$reg->descuento);
				}
		echo '<tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><h4 id="total">S/.'.$total.'</h4><input type="hidden" name="total_recepcionMercaderias" id="total_recepcionMercaderias"></th> 
                                </tfoot>';
	break;


case 'mostrarDetalle':
		$OrdenCompra_idOrdenCompra=$_REQUEST["OrdenCompra_idOrdenCompra"];

		$rspta=$recepcionMercaderias->mostrarDetalle($OrdenCompra_idOrdenCompra);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			$color = 'black';
 			$background_color = 'white';

 			if ($reg->cantidadRecibida < $reg->cantidadPendiente) {
 				 $color = 'white';
 				 $background_color = 'green';
 			}


 			if ($reg->cantidadRecibida > $reg->cantidadPendiente) {

 				 $color = 'white';
 				 $background_color = 'red';
 
 			}




 			$data[]=array(
 				"0"=>$reg->OrdenCompra_idOrdenCompra,
 				"1"=>$reg->idDetalleOrdenCompra,
 				"2"=>utf8_encode($reg->nombre),
 				"3"=>utf8_encode($reg->descripcion),
 				"4"=>$reg->idArticulo,
 				"5"=>'<i class="fa fa-barcode" style="font-size:24px;color:red"></i>'.$reg->codigoBarra,
 				"6"=>$reg->codSap,
 				"7"=>$reg->cantidad,
 				"8"=>$reg->cantidadPendiente,
				"9"=>'<input class="text-right" style="color:'.$color.';background-color:'.$background_color.'" type="text" name="cantidadRecibida[]" style="width:100%;" onblur="actualizarCantidadRecibida(this,\''.$reg->idDetalleOrdenCompra.'\', \''.$reg->cantidadPendiente.'\')" onkeyup="onKeyUpcantidadRecibida(event, \''.$reg->idDetalleOrdenCompra.'\')" id="cantidadRecibida'.$reg->idDetalleOrdenCompra.'" style="width:100%;" value="'.$reg->cantidadRecibida.'" />',

 				"10"=>'<input class="text-right" onkeyup="onKeyUpFaltante(event, \''.$reg->idDetalleOrdenCompra.'\')"  type="text" name="faltante[]"  style="width:100%;" onblur="actualizarFaltante(this,\''.$reg->idDetalleOrdenCompra.'\')"   id="faltante'.$reg->idDetalleOrdenCompra.'" style="width:100%;" value="'.$reg->faltante.'" />',
 				
 				"11"=>'<input class="text-right"  type="text" onkeyup="onKeyUpDevuelta(event, \''.$reg->idDetalleOrdenCompra.'\')" id="devuelta'.$reg->idDetalleOrdenCompra.'"   style="width:100%;" onblur="actualizarDevuelta(this,\''.$reg->idDetalleOrdenCompra.'\')"  id="devuelta[]" style="width:100%;" value="'.$reg->devuelta.'" />',
 				"12"=>'<input type="text" id="comentario'.$reg->idDetalleOrdenCompra.'" onkeyup="onKeyUpComentario(event, \''.$reg->idDetalleOrdenCompra.'\')" style="width:100%;" onblur="actualizarComentario(this,\''.$reg->idDetalleOrdenCompra.'\')"  id="comentario[]" style="width:100%;" value="'.$reg->comentario.'" />'
 				);

 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;



case 'mostrarDetalleRecibido':
		$OrdenCompra_idOrdenCompra=$_REQUEST["OrdenCompra_idOrdenCompra"];

		$rspta=$recepcionMercaderias->mostrarDetalleRecibido($OrdenCompra_idOrdenCompra);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){


 			$data[]=array(
 				"0"=>$reg->idOrdenCompraRecibido_idOrdenCompraRecibido,
 				"1"=>$reg->idDetalleOrdenCompraRecibido,
 				"2"=>utf8_encode($reg->nombre),
 				"3"=>utf8_encode($reg->descripcion),
 				"4"=>$reg->idArticulo,
 				"5"=>'<i class="fa fa-barcode" style="font-size:24px;color:red"></i>'.$reg->codigoBarra,
 				"6"=>$reg->codSap,
 				"7"=>$reg->cantidad,
 				"8"=>'No aplica',
 				"9"=>'<input class="text-right"  type="text" name="cantidadRecibida[]"  style="width:100%;" onblur="actualizarCantidadRecibidaRecibido(this,\''.$reg->idDetalleOrdenCompraRecibido.'\')"  id="cantidadRecibida[]" style="width:100%;" value="'.$reg->cantidadRecibida.'" />',
 				"10"=>'<input class="text-right" type="text" name="faltante[]"  		 style="width:100%;" onblur="actualizarFaltanteRecibido(this,\''.$reg->idDetalleOrdenCompraRecibido.'\')"  id="faltante[]" style="width:100%;" value="'.$reg->faltante.'" />',
 				"11"=>'<input class="text-right" type="text" name="devuelta[]"  		 style="width:100%;" onblur="actualizarDevueltaRecibido(this,\''.$reg->idDetalleOrdenCompraRecibido.'\')"  id="devuelta[]" style="width:100%;" value="'.$reg->devuelta.'" />',
 				"12"=>'<input type="text" name="comentario[]"  		 style="width:100%;" onblur="actualizarComentarioRecibido(this,\''.$reg->idDetalleOrdenCompraRecibido.'\')"  id="comentario[]" style="width:100%;" value="'.$reg->comentario.'" />'
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
		$habilitacion=$_REQUEST["habilitacion"];
		$rspta=$recepcionMercaderias->listar($habilitacion);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){


			$url='../reportes/reprecepcionMercaderias.php?id=';
			$whatsapp = 'https://api.whatsapp.com/send?phone=595'.$reg->celular.'&text=Buenas Sr/a '. $reg->cn .', ingrese al siguiente link para poder visualizar o descargar su orden de compra: https://www.robsa.com.py/intranet/reportes/exFacturaWebWhatsapp.php?hash='.$reg->hash. ' Saludos.';
			$data[]=array(
 				//"0"=>'<a target="_blank" href="'.$url.$reg->idOrdenCompra.'"> <button class="btn btn-info"><i class="fa fa-file"></i></button></a><a target="_blank" href="'.$whatsapp.'"> <button class="btn btn-success"><i class="fa fa-whatsapp"></i></button></a>',
 				"0"=>'<button class="btn btn-primary" onclick="mostrarDetalleOrdenCompra(\''.$reg->idOrdenCompra.'\',\''.$reg->HacerPedido_idHacerPedido.'\')">Recibir mercaderias ---> <i class="fa fa-pencil"></i></button>',
 				"1"=>$reg->idOrdenCompra,
 				"2"=>$reg->fecha,
 				"3"=>utf8_encode($reg->rs),
 				"4"=>utf8_encode($reg->ds),
 				"5"=>$reg->dd,
 				"6"=>$reg->tpd,
 				"7"=>$reg->totalImpuesto,
 				"8"=>$reg->subTotal,
 				"9"=>$reg->total,
 				"10"=>$reg->ocui,
 				"11"=>$reg->ocum,
 				"12"=>'<button class="btn btn-primary" onclick="mostrarDetalleOrdenCompra(\''.$reg->idOrdenCompra.'\',\''.$reg->HacerPedido_idHacerPedido.'\')">Recibir mercaderias ---> <i class="fa fa-pencil"></i></button>',
 				"13"=>(!$reg->oci)?'<span class="label bg-green">Aceptado</span>':
 				'<span class="label bg-red">Anulado</span>');
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;



	case 'listarTerminados':
		$habilitacion=$_REQUEST["habilitacion"];
		$rspta=$recepcionMercaderias->listarTerminados($habilitacion);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){


			$url='../reportes/reprecepcionMercaderias.php?id=';
			$whatsapp = 'https://api.whatsapp.com/send?phone=595'.$reg->celular.'&text=Buenas Sr/a '. $reg->cn .', ingrese al siguiente link para poder visualizar o descargar su orden de compra: https://www.robsa.com.py/intranet/reportes/exFacturaWebWhatsapp.php?hash='.$reg->hash. ' Saludos.';
			$data[]=array(
 				//"0"=>'<a target="_blank" href="'.$url.$reg->idOrdenCompra.'"> <button class="btn btn-info"><i class="fa fa-file"></i></button></a><a target="_blank" href="'.$whatsapp.'"> <button class="btn btn-success"><i class="fa fa-whatsapp"></i></button></a>',
 				"0"=>'<button class="btn btn-primary" onclick="mostrarDetalleOrdenCompra(\''.$reg->idOrdenCompra.'\',\''.$reg->HacerPedido_idHacerPedido.'\')">Recibir mercaderias ---> <i class="fa fa-pencil"></i></button>',
 				"1"=>$reg->idOrdenCompra,
 				"2"=>$reg->fecha,
 				"3"=>utf8_encode($reg->rs),
 				"4"=>utf8_encode($reg->ds),
 				"5"=>$reg->dd,
 				"6"=>$reg->tpd,
 				"7"=>$reg->totalImpuesto,
 				"8"=>$reg->subTotal,
 				"9"=>$reg->total,
 				"10"=>$reg->ocui,
 				"11"=>$reg->ocum,
 				"12"=>'<button class="btn btn-primary" onclick="mostrarDetalleOrdenCompra(\''.$reg->idOrdenCompra.'\',\''.$reg->HacerPedido_idHacerPedido.'\')">Recibir mercaderias ---> <i class="fa fa-pencil"></i></button>',
 				"13"=>(!$reg->oci)?'<span class="label bg-green">Aceptado</span>':
 				'<span class="label bg-red">Anulado</span>');
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;



	case 'listarCierre':
		$habilitacion=$_REQUEST["habilitacion"];
		$rspta=$recepcionMercaderias->listarCierre($habilitacion);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

			$url='../reportes/reprecepcionMercaderias.php?id=';
			$whatsapp = 'https://api.whatsapp.com/send?phone=595'.$reg->celular.'&text=Buenas Sr/a '. $reg->cn .', ingrese al siguiente link para poder visualizar o descargar su orden de compra: https://www.robsa.com.py/intranet/reportes/exFacturaWebWhatsapp.php?hash='.$reg->hash. ' Saludos.';
			$data[]=array(
 				//"0"=>'<a target="_blank" href="'.$url.$reg->idOrdenCompra.'"> <button class="btn btn-info"><i class="fa fa-file"></i></button></a><a target="_blank" href="'.$whatsapp.'"> <button class="btn btn-success"><i class="fa fa-whatsapp"></i></button></a>',
 				"0"=>'<button class="btn btn-primary" onclick="autorizarCierre('.$reg->idOrdenCompraRecibido.')">Autorizar cierre<i class="fa fa-pencil"></i></button>',
 				"1"=>$reg->idOrdenCompraRecibido,
 				"2"=>$reg->nroCompra,
 				"3"=>$reg->fecha,
 				"4"=>utf8_encode($reg->rs),
 				"5"=>utf8_encode($reg->ds),
 				"6"=>$reg->dd,
 				"7"=>$reg->tpd,
 				"8"=>$reg->totalImpuesto,
 				"9"=>$reg->subTotal,
 				"10"=>$reg->total,
 				"11"=>$reg->ocui,
 				"12"=>$reg->ocum,
 				"13"=>'<button class="btn btn-primary" onclick="autorizarCierre('.$reg->idOrdenCompraRecibido.')">Autorizar cierre<i class="fa fa-pencil"></i></button>',
 				"14"=>(!$reg->oci)?'<span class="label bg-green">Aceptado</span>':
 				'<span class="label bg-red">Anulado</span>',
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;




	case 'listarRecibidos':
		$habilitacion=$_REQUEST["habilitacion"];
		$rspta=$recepcionMercaderias->listarRecibidos($habilitacion);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){


 			$url='../reportes/rptNotaRecepcion.php?id=';


 			if ($reg->recibido == 1) {
 				$boton = '<button class="btn btn-warning" onclick="mostrarDetalleOrdenCompraRecibido('.$reg->idOrdenCompraRecibido.')">Recibir mercaderias ---> <i class="fa fa-pencil"></i></button>';
 			}elseif ($reg->recibido == 2){
 				$boton = '<a target="_blank" href="'.$url.$reg->idOrdenCompraRecibido.'"> <button class="btn btn-info">Nota de Recepcion <i class="fa fa-print"></i></button></a>';
 			}



			$whatsapp = 'https://api.whatsapp.com/send?phone=595'.$reg->celular.'&text=Buenas Sr/a '. $reg->cn .', ingrese al siguiente link para poder visualizar o descargar su orden de compra: https://www.robsa.com.py/intranet/reportes/exFacturaWebWhatsapp.php?hash='.$reg->hash. ' Saludos.';
			$data[]=array(
 				//"0"=>'<a target="_blank" href="'.$url.$reg->idOrdenCompra.'"> <button class="btn btn-info"><i class="fa fa-file"></i></button></a><a target="_blank" href="'.$whatsapp.'"> <button class="btn btn-success"><i class="fa fa-whatsapp"></i></button></a>',
 				"0"=>$boton,
 				"1"=>$reg->idOrdenCompraRecibido,
 				"2"=>$reg->nroCompra,
 				"3"=>$reg->fecha,
 				"4"=>utf8_encode($reg->rs),
 				"5"=>utf8_encode($reg->ds),
 				"6"=>$reg->dd,
 				"7"=>$reg->tpd,
 				"8"=>$reg->totalImpuesto,
 				"9"=>$reg->subTotal,
 				"10"=>$reg->total,
 				"11"=>$reg->ocui,
 				"12"=>$reg->ocum,
 				"13"=>$boton,
 				"14"=>(!$reg->oci)?'<span class="label bg-green">Aceptado</span>':
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



	case 'confirmarRecepcionRecibido':
		
		$idOrdenCompra=  $_REQUEST['idOrdenCompra'];
		$nroFacturaCompra=  $_REQUEST['nroFacturaCompra'];
		$Moneda_idMoneda=  $_REQUEST['Moneda_idMoneda'];
		$tasaCambio=  $_REQUEST['tasaCambio'];
		$tasaCambioBases=  $_REQUEST['tasaCambioBases'];
		
		//$ti= 2; //$_REQUEST['ti'];
		session_start();
		$User = $_SESSION['login'];

		$rspta=$recepcionMercaderias->confirmarRecepcionRecibido($idOrdenCompra, $nroFacturaCompra, $Moneda_idMoneda, $tasaCambio, $tasaCambioBases);
 		$data= 1;
 		echo json_encode($data);

	break;



	case 'confirmarRecepcion':
		
		$idOrdenCompra=  $_REQUEST['idOrdenCompra'];
		$nroFacturaCompra=  $_REQUEST['nroFacturaCompra'];
		$Moneda_idMoneda=  $_REQUEST['Moneda_idMoneda'];
		$tasaCambio=  $_REQUEST['tasaCambio'];
		$tasaCambioBases=  $_REQUEST['tasaCambioBases'];
		

		$rspta=$recepcionMercaderias->confirmarRecepcion($idOrdenCompra, $nroFacturaCompra, $Moneda_idMoneda, $tasaCambio, $tasaCambioBases);
 		$data= 1;
 		echo json_encode($data);

	break;


	//recibido
		case 'actualizarCantidadRecibidaRecibido':
		
		$cantidadRecibida=  $_REQUEST['cantidadRecibida'];
		$idDetalleOrdenCompra= $_REQUEST['idDetalleOrdenCompra'];
		
		//$ti= 2; //$_REQUEST['ti'];
		session_start();
		$User = $_SESSION['login'];

		$rspta=$recepcionMercaderias->actualizarCantidadRecibidaRecibido($cantidadRecibida, $idDetalleOrdenCompra);
 		$data= 1;
 		echo json_encode($data);

	break;


	case 'actualizarFaltanteRecibido':
		
		$faltante=  $_REQUEST['faltante'];
		$idDetalleOrdenCompra= $_REQUEST['idDetalleOrdenCompra'];
		
		//$ti= 2; //$_REQUEST['ti'];
		session_start();
		$User = $_SESSION['login'];

		$rspta=$recepcionMercaderias->actualizarFaltanteRecibido($faltante, $idDetalleOrdenCompra);
 		$data= 1;
 		echo json_encode($data);

	break;


	case 'actualizarDevueltaRecibido':
		
		$devuelta=  $_REQUEST['devuelta'];
		$idDetalleOrdenCompra= $_REQUEST['idDetalleOrdenCompra'];
		
		//$ti= 2; //$_REQUEST['ti'];
		session_start();
		$User = $_SESSION['login'];

		$rspta=$recepcionMercaderias->actualizarDevueltaRecibido($devuelta, $idDetalleOrdenCompra);
 		$data= 1;
 		echo json_encode($data);

	break;



	case 'actualizarComentarioRecibido':
		
		$comentario=  $_REQUEST['comentario'];
		$idDetalleOrdenCompra= $_REQUEST['idDetalleOrdenCompra'];
		
		//$ti= 2; //$_REQUEST['ti'];
		session_start();
		$User = $_SESSION['login'];

		$rspta=$recepcionMercaderias->actualizarComentarioRecibido($comentario, $idDetalleOrdenCompra);
 		$data= 1;
 		echo json_encode($data);

	break;



	//original
	case 'actualizarCantidadRecibida':
		
		$cantidadRecibida=  $_REQUEST['cantidadRecibida'];
		$idDetalleOrdenCompra= $_REQUEST['idDetalleOrdenCompra'];
		
		//$ti= 2; //$_REQUEST['ti'];
		session_start();
		$User = $_SESSION['login'];

		$rspta=$recepcionMercaderias->actualizarCantidadRecibida($cantidadRecibida, $idDetalleOrdenCompra);
 		$data= 1;
 		echo json_encode($data);

	break;


	case 'actualizarFaltante':
		
		$faltante=  $_REQUEST['faltante'];
		$idDetalleOrdenCompra= $_REQUEST['idDetalleOrdenCompra'];
		
		//$ti= 2; //$_REQUEST['ti'];
		session_start();
		$User = $_SESSION['login'];

		$rspta=$recepcionMercaderias->actualizarFaltante($faltante, $idDetalleOrdenCompra);
 		$data= 1;
 		echo json_encode($data);

	break;


	case 'actualizarDevuelta':
		
		$devuelta=  $_REQUEST['devuelta'];
		$idDetalleOrdenCompra= $_REQUEST['idDetalleOrdenCompra'];
		
		//$ti= 2; //$_REQUEST['ti'];
		session_start();
		$User = $_SESSION['login'];

		$rspta=$recepcionMercaderias->actualizarDevuelta($devuelta, $idDetalleOrdenCompra);
 		$data= 1;
 		echo json_encode($data);

	break;



	case 'actualizarComentario':
		
		$comentario=  $_REQUEST['comentario'];
		$idDetalleOrdenCompra= $_REQUEST['idDetalleOrdenCompra'];
		
		//$ti= 2; //$_REQUEST['ti'];
		session_start();
		$User = $_SESSION['login'];

		$rspta=$recepcionMercaderias->actualizarComentario($comentario, $idDetalleOrdenCompra);
 		$data= 1;
 		echo json_encode($data);

	break;



	case 'autorizarCierre':
		
		$id = $_REQUEST['id'];
		
		//$ti= 2; //$_REQUEST['ti'];
		session_start();
		$User = $_SESSION['login'];

		$rspta=$recepcionMercaderias->autorizarCierre($id);
 		$data= 1;
 		echo json_encode($data);

	break;	



	case 'listarAFacturar':
		$habilitacion=$_REQUEST["habilitacion"];
		$rspta=$recepcionMercaderias->listarAFacturar($habilitacion);
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
			
 		//$url='../reportes/exTicket.php?id=';
 			$data[]=array(
 				"0"=>
				'<button class="btn btn-warning" onclick="generarFactura(\''.$reg->idrecepcionMercaderias.'\',\''.$reg->Deposito_idDeposito.'\', \''.$reg->idTerminoPago.'\',\''.$reg->ovui.'\',\''.$reg->idPersona.'\')"> Generar Factura</button>'.
				(((!$reg->ovi)?'<a target="_blank" href="'.$url.$reg->idrecepcionMercaderias.'"> <button class="btn btn-info"><i class="fa fa-file"></i></button></a>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idrecepcionMercaderias.')"><i class="fa fa-eye"></i></button>')
					)
					,
 				"1"=>$reg->idrecepcionMercaderias,
 				"2"=>$reg->fecha,
 				"3"=>$reg->rz,
 				"4"=>$reg->Habilitacion_idHabilitacion,
 				"5"=>$reg->Deposito_idDeposito,
 				"6"=>$reg->tpd,
 				"7"=>$reg->totalImpuesto,
 				"8"=>$reg->subTotal,
 				"9"=>$reg->total,
 				"10"=>$reg->ovui,
 				"11"=>$reg->ovum,
 				"12"=>'<button class="btn btn-primary" onclick="mostrarDetallerecepcionMercaderias('.$reg->idrecepcionMercaderias.')">Ver detalle de recepcionMercaderias <i class="fa fa-pencil"></i></button>',
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

	case 'listarArticulosrecepcionMercaderias':
		require_once "../modelos/Articulo.php";
		$articulo=new Articulo();

		$rspta=$articulo->listarActivosrecepcionMercaderias();
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


	case 'selectArticulosrecepcionMercaderias':
		require_once "../modelos/Articulo.php";
		$articulo=new Articulo();

		$rspta=$articulo->listarActivosrecepcionMercaderias();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
			echo '<option value=' .$reg->idArticulo. '>' .$reg->na. '</option>';
 		}

	break;

	case 'habilitacion':
		$rspta=$recepcionMercaderias->habilitacion();
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'ultimo':
		$rspta=$recepcionMercaderias->ultimo();
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;


	case 'cambiarPersonaGiftCard':
		$rspta=$recepcionMercaderias->cambiarPersonaGiftCard($idrecepcionMercaderias,$clienteGiftCard);
 		echo $rspta ? "El cambio se proceso correctamente" : "El cambio no se pudo procesar";
	break;

	case 'cambiarNroGiftCard':
		$rspta=$recepcionMercaderias->cambiarNroGiftCard($idrecepcionMercaderias,$nroGiftCard);
 		echo $rspta ? "El cambio se proceso correctamente" : "El cambio no se pudo procesar";
	break;




}

?>


