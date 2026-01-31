<?php 
require_once "../modelos/MovimientoStock.php"; 

$movimientoStock=new MovimientoStock();

$idMovimientoStock=isset($_POST["idMovimientoStock"])? limpiarCadena($_POST["idMovimientoStock"]):"";
$Deposito_idDepositoOrigen=isset($_POST["Deposito_idDepositoOrigen"])? limpiarCadena($_POST["Deposito_idDepositoOrigen"]):"";
$Deposito_idDepositoDestino=isset($_POST["Deposito_idDepositoDestino"])? limpiarCadena($_POST["Deposito_idDepositoDestino"]):"";
$fechaTransaccion=isset($_POST["fechaTransaccion"])? limpiarCadena($_POST["fechaTransaccion"]):"";
$totalC=isset($_POST["totalC"])? limpiarCadena($_POST["totalC"]):"";
$cantidadTotal=isset($_POST["cantidadTotal"])? limpiarCadena($_POST["cantidadTotal"]):""; 
$comentario=isset($_POST["comentario"])? limpiarCadena($_POST["comentario"]):""; 

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idMovimientoStock)){
			$rspta=$movimientoStock->insertar(
				$Deposito_idDepositoOrigen,
				$Deposito_idDepositoDestino,
				$comentario,
				$fechaTransaccion,
				$totalC,
				$cantidadTotal,

				$_POST["Articulo_idArticulo"],
				$_POST["cantidad"],
				$_POST["precio"],
				$_POST["total"]    
			);
			echo $rspta ? "Movimiento de Stock registrado" : "Movimiento de Stock no se pudo registrar";
		}
		else {
			$rspta=$movimientoStock->editar($idMovimientoStock,$Deposito_idDepositoOrigen,$Deposito_idDepositoDestino,$comentario,$fechaTransaccion,$totalC,$cantidadTotal,$_POST["Articulo_idArticulo"],$_POST["cantidad"],$_POST["precio"],$_POST["total"],$_POST["idMovimientoStockDetalle"]);
			echo $rspta ? "Movimiento de Stock actualizado" : "Movimiento de Stock no se pudo actualizar"; 
		}
	break;

	case 'listarDetalleMovimientoStock':
		//Recibimos el idingreso
		$idMovimientoStock=$_GET['idMovimientoStock'];

				$rspta = $movimientoStock->listarDetalleMovimientoStock($idMovimientoStock); 
						echo '<thead style="background-color:#A9D0F5">
                                                      <th>Opciones</th>
                                                      <th>Articulo</th>
                                                      <th>Cantidad</th>
                                                      <th>Precio</th>
                                                      <th>Total</th>    
				                                </thead>';
				        $contPrecio = 0;
						while ($reg = $rspta->fetchObject())
						{
							echo '<tr class="filasTP" id="filaTP'.$contPrecio.'">
								<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleMovimientoStock('.$contPrecio.')">X</button> 
								</td><td><input type="hidden" name="Articulo_idArticulo[]" id="Articulo_idArticulo[]" value="'.$reg->idArticulo.'">'.$reg->nombre.'</td>
								</td><td><input type="text" name="cantidad[]" id="cantidad[]" value="'.$reg->cantidad.'"></td> 
								</td><td><input type="text" name="precio[]" id="precio[]" value="'.$reg->precio.'"></td> 
								</td><td><input type="text" name="total[]" id="total[]" value="'.$reg->total.'"></td>
								</td><td><input type="hidden" name="idMovimientoStockDetalle[]" id="idMovimientoStockDetalle[]" value="'.$reg->idMovimientoStockDetalle.'"></td>';

							$contPrecio++;
									
						}
						echo '<tfoot>
	                              <th>Opciones</th>
	                              <th>Articulo</th>
	                              <th>Cantidad</th>
	                              <th>Precio</th>
	                              <th>Total</th>  
                        	</tfoot>';

	break;

	case 'detalle':
		$idArticulo=$_REQUEST["idMovimientoStock"];

		$rspta=$movimientoStock->detalle($idMovimientoStock);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 
 			$data[]=array( 
 				"0"=>$reg->nombre,
 				"1"=>$reg->cantidad,
 				"2"=>$reg->precio,
 				"3"=>$reg->total,				 				
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
		$rspta=$movimientoStock->desactivar($idMovimientoStock);
 		echo $rspta ? "Movimiento de Stock Desactivado" : "Movimiento no se puede desactivar";
	break;

	case 'enviarTransito':
		$rspta=$movimientoStock->enviarTransito($idMovimientoStock);
 		echo $rspta ? "Movimiento de Stock enviado" : "Movimiento no se puede enviar";
	break;	

	case 'recibirTransito':
		$rspta=$movimientoStock->recibirTransito($idMovimientoStock);
 		echo $rspta ? "Movimiento de Stock enviado" : "Movimiento no se puede enviar";
	break;		

	case 'activar':
		$rspta=$movimientoStock->activar($idMovimientoStock);
 		echo $rspta ? "Movimiento de Stock activado" : "Artículo no se puede activar";
	break;

	case 'desactivarDetalleMovimientoStock':
		$rspta=$movimientoStock->desactivarDetalleMovimientoStock($_REQUEST['idMovimientoStockDetalle']);
 		echo $rspta ? "Detalle Desactivado" : "Detalle no se puede desactivar";
	break;

	case 'mostrar':
		$rspta=$movimientoStock->mostrar($idMovimientoStock);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;


	case 'filtrar':
		$Deposito_idDeposito_Origen=$_REQUEST["Deposito_idDeposito_Origen"];
		$fi=$_REQUEST["fi"];
		$ff=$_REQUEST["ff"];
		$estado=$_REQUEST["estado"];
		$Deposito_idDeposito_Destino=$_REQUEST["Deposito_idDeposito_Destino"]; 
		$rspta=$movimientoStock->filtrar($Deposito_idDeposito_Origen,$Deposito_idDeposito_Destino, $fi, $ff, $estado);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 
 		$url='../reportes/exTicket.php?id=';
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idMovimientoStock.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->idMovimientoStock.')"><i class="fa fa-close"></i></button>'.'<a target="_blank" href="'.$url.$reg->idMovimientoStock.'"> <button class="btn btn-success btn-xs"><i class="fa fa-print"></i></button>':
 					'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idMovimientoStock.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary btn-xs" onclick="activar('.$reg->idMovimientoStock.')"><i class="fa fa-check"></i></button>'.'<a target="_blank" href="'.$url.$reg->idMovimientoStock.'"> <button class="btn btn-success btn-xs"><i class="fa fa-print"></i></button>',
 				"1"=>'<button class="btn btn-primary" onclick="recibirTransito('.$reg->idMovimientoStock.')">Aprobar<i class="fa fa-pencil"></i></button>',		
 				"2"=>$reg->Deposito_idDepositoOrigen,
 				"3"=>$reg->Deposito_idDepositoDestino,
 				"4"=>$reg->fechaTransaccion,				 				
 				"5"=>$reg->cantidad, 				 				
 				"6"=>$reg->total, 	
 				"7"=>'<button class="btn btn-primary" onclick="enviarTransito('.$reg->idMovimientoStock.')">Enviar<i class="fa fa-pencil"></i></button>',
 				"8"=>'<button class="btn btn-primary" onclick="mostrarDetalleMovimientoStockDetalle('.$reg->idMovimientoStock.')">Ver detalle<i class="fa fa-pencil"></i></button>',			 				

 				(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>'
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
		$rspta=$movimientoStock->listar();
 		//Vamos a declarar un array
 		$data= Array();
			$url='../reportes/rptMovimientoStock.php?id=';
 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idMovimientoStock.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->idMovimientoStock.')"><i class="fa fa-close"></i></button>'.'<a target="_blank" href="'.$url.$reg->idMovimientoStock.'"> <button class="btn btn-success btn-xs"><i class="fa fa-print"></i></button>':
 					'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idMovimientoStock.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary btn-xs" onclick="activar('.$reg->idMovimientoStock.')"><i class="fa fa-check"></i></button>'.'<a target="_blank" href="'.$url.$reg->idMovimientoStock.'"> <button class="btn btn-success btn-xs"><i class="fa fa-print"></i></button>',
 				"1"=>'<button class="btn btn-primary" onclick="recibirTransito('.$reg->idMovimientoStock.')">Aprobar<i class="fa fa-pencil"></i></button>',		
 				"2"=>$reg->Deposito_idDepositoOrigen,
 				"3"=>$reg->Deposito_idDepositoDestino,
 				"4"=>$reg->fechaTransaccion,				 				
 				"5"=>$reg->cantidad, 				 				
 				"6"=>$reg->total, 	
 				"7"=>'<button class="btn btn-primary" onclick="enviarTransito('.$reg->idMovimientoStock.')">Enviar<i class="fa fa-pencil"></i></button>',			 				
 				"8"=>'<button class="btn btn-primary" onclick="mostrarDetalleMovimientoStockDetalle('.$reg->idMovimientoStock.')">Ver detalle<i class="fa fa-pencil"></i></button>',
 				(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case "selectDepositoOrigen":

		$rspta = $movimientoStock->selectDepositoOrigen();
		echo '<option value="999">Todas</option>';
		while ($reg = $rspta->fetchObject()) {

			echo '<option value=' .$reg->idDeposito. '>' .$reg->descripcion. '</option>';
		}

		break;

	case "selectDepositoOrigenHabilitacion":

		$rspta = $movimientoStock->selectDepositoOrigenHabilitacion();
		echo '<option value="999">Todas</option>';
		while ($reg = $rspta->fetchObject()) {

			echo '<option value=' .$reg->idDeposito. '>' .$reg->descripcion. '</option>';
		}

		break;		

	case "selectDepositoDestino":

		$rspta = $movimientoStock->selectDepositoDestino();
		echo '<option value="999">Todas</option>';	
		while ($reg = $rspta->fetchObject()) {
			
			echo '<option value=' .$reg->idDeposito. '>' .$reg->descripcion. '</option>';
		}

		break;

	case "selectDepositoDestinoHabilitacion":

		$rspta = $movimientoStock->selectDepositoDestinoHabilitacion();
		echo '<option value="999">Todas</option>';	
		while ($reg = $rspta->fetchObject()) {
			
			echo '<option value=' .$reg->idDeposito. '>' .$reg->descripcion. '</option>';
		}

		break;		 

	case "selectArticulo":

		$rspta = $movimientoStock->selectArticulo();   

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idArticulo. '>' .$reg->nombre. '</option>';
		}

		break;				
}
?>