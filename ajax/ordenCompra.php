<?php 
if (strlen(session_id()) < 1) 
  session_start();

require_once "../modelos/OrdenCompra.php";

$ordenCompra=new ordenCompra();

$idOrdenCompra=isset($_POST["idOrdenCompra"])? limpiarCadena($_POST["idOrdenCompra"]):"";
$Persona_idPersona=isset($_POST["Persona_idPersona"])? limpiarCadena($_POST["Persona_idPersona"]):"";
$Habilitacion_idHabilitacion=isset($_POST["Habilitacion_idHabilitacion"])? limpiarCadena($_POST["Habilitacion_idHabilitacion"]):"";
$Deposito_idDeposito=isset($_POST["Deposito_idDeposito"])? limpiarCadena($_POST["Deposito_idDeposito"]):"";
$TerminoPago_idTerminoPago=isset($_POST["TerminoPago_idTerminoPago"])? limpiarCadena($_POST["TerminoPago_idTerminoPago"]):"";
$fecha=isset($_POST["fecha"])? limpiarCadena($_POST["fecha"]):"";


switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idOrdenCompra)){
			$rspta=$ordenCompra->insertar($Persona_idPersona,$Habilitacion_idHabilitacion,$Deposito_idDeposito,$TerminoPago_idTerminoPago,$fecha,$_POST["idarticulo"],$_POST["cantidad"],$_POST["precioVenta"],$_POST["descuento"],$_POST["impuesto"]);
			
			echo $rspta ? "ordenCompra registrada" : "No se pudieron registrar todos los datos de la ordenCompra";
		}
		else {
		}
	break;

	case 'anular':
		$rspta=$ordenCompra->anular($idOrdenCompra);
 		echo $rspta ? "ordenCompra anulada" : "ordenCompra no se puede anular";
	break;

	case 'mostrar':
		$rspta=$ordenCompra->mostrar($idOrdenCompra);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listarDetalle':
		//Recibimos el idingreso
		$id=$_GET['id'];

		$rspta = $ordenCompra->listarDetalle($id);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio ordenCompra</th>
                                    <th>Descuento</th>
                                    <th>Subtotal</th>
                                </thead>';

		while ($reg = $rspta->fetchObject())
				{
					echo '<tr class="filas"><td></td><td>'.$reg->nombre.'</td><td>'.$reg->cantidad.'</td><td>'.$reg->precio_ordenCompra.'</td><td>'.$reg->descuento.'</td><td>'.$reg->subtotal.'</td></tr>';
					$total=$total+($reg->precio_ordenCompra*$reg->cantidad-$reg->descuento);
				}
		echo '<tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><h4 id="total">S/.'.$total.'</h4><input type="hidden" name="total_ordenCompra" id="total_ordenCompra"></th> 
                                </tfoot>';
	break;

	case 'listar':
		$habilitacion=$_REQUEST["habilitacion"];
		$rspta=$ordenCompra->listar($habilitacion);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
			$url='../reportes/rptOc.php?idOrdenCompra=';
			$whatsapp = 'https://api.whatsapp.com/send?phone=595'.$reg->celular.'&text=Buenas Sr/a '. $reg->cn .', ingrese al siguiente link para poder visualizar o descargar su orden de compra: https://robsa.com.py/gigante/reportes/rptOc.php?idOrdenCompra='.$reg->idOrdenCompra. ' Saludos.';
			$data[]=array(
 				"0"=>'<a target="_blank" href="'.$url.$reg->idOrdenCompra.'"> <button class="btn btn-info"><i class="fa fa-file"></i></button></a><a target="_blank" href="'.$whatsapp.'"> <button class="btn btn-success"><i class="fa fa-whatsapp"></i></button></a>',
 				"1"=>$reg->idOrdenCompra,
 				"2"=>$reg->fecha,
 				"3"=>$reg->rs,
 				"4"=>$reg->ds,
 				"5"=>$reg->dd,
 				"6"=>$reg->tpd,
 				"7"=>$reg->totalImpuesto,
 				"8"=>$reg->subTotal,
 				"9"=>$reg->total,
 				"10"=>$reg->ocui,
 				"11"=>$reg->ocum,
 				"12"=>'<button class="btn btn-primary" onclick="mostrarDetalleordenCompra('.$reg->idOrdenCompra.')">Ver Detalle de Orden de Compra <i class="fa fa-pencil"></i></button>',
 				"13"=>(!$reg->oci)?'<span class="label bg-green">Aceptado</span>':
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
		$rspta=$ordenCompra->listarAFacturar($habilitacion);
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
				'<button class="btn btn-warning" onclick="generarFactura(\''.$reg->idOrdenCompra.'\',\''.$reg->Deposito_idDeposito.'\', \''.$reg->idTerminoPago.'\',\''.$reg->ovui.'\',\''.$reg->idPersona.'\')"> Generar Factura</button>'.
				(((!$reg->ovi)?'<a target="_blank" href="'.$url.$reg->idOrdenCompra.'"> <button class="btn btn-info"><i class="fa fa-file"></i></button></a>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idOrdenCompra.')"><i class="fa fa-eye"></i></button>')
					)
					,
 				"1"=>$reg->idOrdenCompra,
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
 				"12"=>'<button class="btn btn-primary" onclick="mostrarDetalleordenCompra('.$reg->idOrdenCompra.')">Ver detalle de ordenCompra <i class="fa fa-pencil"></i></button>',
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

	case 'listarArticulosordenCompra':
		require_once "../modelos/Articulo.php";
		$articulo=new Articulo();

		$rspta=$articulo->listarActivosordenCompra();
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


	case 'selectArticulosordenCompra':
		require_once "../modelos/Articulo.php";
		$articulo=new Articulo();

		$rspta=$articulo->listarActivosordenCompra();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
			echo '<option value=' .$reg->idArticulo. '>' .$reg->na. '</option>';
 		}

	break;



	case 'habilitacion':
		$rspta=$ordenCompra->habilitacion();
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'ultimo':
		$rspta=$ordenCompra->ultimo();
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;


	case 'cambiarPersonaGiftCard':
		$rspta=$ordenCompra->cambiarPersonaGiftCard($idOrdenCompra,$clienteGiftCard);
 		echo $rspta ? "El cambio se proceso correctamente" : "El cambio no se pudo procesar";
	break;

	case 'cambiarNroGiftCard':
		$rspta=$ordenCompra->cambiarNroGiftCard($idOrdenCompra,$nroGiftCard);
 		echo $rspta ? "El cambio se proceso correctamente" : "El cambio no se pudo procesar";
	break;


}

?>


