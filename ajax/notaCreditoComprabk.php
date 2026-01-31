<?php 
require_once "../modelos/NotaCreditoCompra.php";

$notaCreditoCompra=new notaCreditoCompra();  

$idNotaCreditoCompra=isset($_POST["idNotaCreditoCompra"])? limpiarCadena($_POST["idNotaCreditoCompra"]):"";
$Compra_idCompra=isset($_POST["Compra_idCompra"])? limpiarCadena($_POST["Compra_idCompra"]):"";
$Persona_idPersona=isset($_POST["Persona_idPersona"])? limpiarCadena($_POST["Persona_idPersona"]):"";
$Habilitacion_idhabilitacion=isset($_POST["Habilitacion_idhabilitacion"])? limpiarCadena($_POST["Habilitacion_idhabilitacion"]):"";
$tipoComprobante=isset($_POST["tipoComprobante"])? limpiarCadena($_POST["tipoComprobante"]):"";
$nroDevolucion=isset($_POST["nroDevolucion"])? limpiarCadena($_POST["nroDevolucion"]):"";
$nroFactura=isset($_POST["nroFactura"])? limpiarCadena($_POST["nroFactura"]):""; 
$fechaTransaccion=isset($_POST["fechaTransaccion"])? limpiarCadena($_POST["fechaTransaccion"]):"";  
$fechaVencimiento=isset($_POST["fechaVencimiento"])? limpiarCadena($_POST["fechaVencimiento"]):"";  
$timbrado=isset($_POST["timbrado"])? limpiarCadena($_POST["timbrado"]):"";  
$vtoTimbrado=isset($_POST["vtoTimbrado"])? limpiarCadena($_POST["vtoTimbrado"]):"";  
$totalImpuesto=isset($_POST["totalImpuesto"])? limpiarCadena($_POST["totalImpuesto"]):"";  
$totalC=isset($_POST["totalC"])? limpiarCadena($_POST["totalC"]):"";  
$subTotal=isset($_POST["subTotal"])? limpiarCadena($_POST["subTotal"]):"";  

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idNotaCreditoCompra)){
			$rspta=$notaCreditoCompra->insertar(
				$Compra_idCompra,
				$Persona_idPersona,
				$Habilitacion_idhabilitacion,
				$tipoComprobante,
				$nroDevolucion,
				$nroFactura,
				$fechaTransaccion,
				$fechaVencimiento,
				$timbrado,
				$vtoTimbrado,
				$totalImpuesto,
				$totalC,
				$subTotal, 

				$_POST["Articulo_idArticulo"],
				$_POST["cantidad"],
				$_POST["devuelve"],
				$_POST["totalNeto"],
				$_POST["total"]
			);
			echo $rspta ? "Nota de Credito Compra registrado" : "Nota de Credito Compra no se pudo registrar";
		}
		else {
			$rspta=$notaCreditoCompra->editar($idNotaCreditoCompra,$Compra_idCompra,$Persona_idPersona,$Habilitacion_idhabilitacion,$tipoComprobante,$nroDevolucion,$nroFactura,$fechaTransaccion,$fechaVencimiento,$timbrado,$vtoTimbrado,$totalImpuesto,$totalC,$subTotal,$_POST["Articulo_idArticulo"],$_POST["cantidad"],$_POST["devuelve"],$_POST["totalNeto"],$_POST["total"],$_POST["idNotaCreditoCompraDetalle"]) ;
			echo $rspta ? "Nota de Credito Compra actualizado" : "Nota de Credito Compra no se pudo actualizar";
		}
	break;


	case 'listarDetalleNotaCreditoCompra':
		//Recibimos el idingreso
		$idNotaCreditoCompra=$_GET['idNotaCreditoCompra'];

				$rspta = $notaCreditoCompra->listarDetalleNotaCreditoCompra($idNotaCreditoCompra); 
						echo '<thead style="background-color:#A9D0F5">
                                                      <th>Opciones</th>
                                                      <th>Articulo</th>
                                                      <th>Cantidad</th>
                                                      <th>Devuelve</th>
                                                      <th>Total Neto</th>
                                                      <th>Total</th>      
				                                </thead>';
				        $contPrecio = 0;
						while ($reg = $rspta->fetchObject())
						{
							echo '<tr class="filasTP" id="filaTP'.$contPrecio.'">
								<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleNotaCreditoCompra('.$contPrecio.')">X</button> 
								</td><td><input type="hidden" name="Articulo_idArticulo[]" id="Articulo_idArticulo[]" value="'.$reg->idArticulo.'">'.$reg->nombre.'</td>
								</td><td><input type="number" name="cantidad[]" id="cantidad[]" value="'.$reg->cantidad.'"></td>
								</td><td><input type="number" name="devuelve[]" id="devuelve[]" value="'.$reg->devuelve.'"></td> 
								</td><td><input type="number" name="totalNeto[]" id="totalNeto[]" value="'.$reg->totalNeto.'"></td> 
								</td><td><input type="number" name="total[]" id="total[]" value="'.$reg->total.'"></td>
								</td><td><input type="hidden" name="idNotaCreditoCompraDetalle[]" id="idNotaCreditoCompraDetalle[]" value="'.$reg->idNotaCreditoCompraDetalle.'"></td>'; 

							$contPrecio++;
									
						}
						echo '<tfoot>
                                  <th>Opciones</th>
                                  <th>Articulo</th>
                                  <th>Cantidad</th>
                                  <th>Devuelve</th>
                                  <th>Total Neto</th>
                                  <th>Total</th>       
                        	</tfoot>';

	break;	

	case 'desactivar':
		$rspta=$notaCreditoCompra->desactivar($idNotaCreditoCompra);
 		echo $rspta ? "Nota de Credito Compra Desactivado" : "Nota de Credito Compra no se puede desactivar";
	break;

	case 'activar':
		$rspta=$notaCreditoCompra->activar($idNotaCreditoCompra);
 		echo $rspta ? "Nota de Credito Compra activado" : "Nota de Credito Compra no se puede activar";
	break;

	case 'mostrar':
		$rspta=$notaCreditoCompra->mostrar($idNotaCreditoCompra);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'desactivarDetalleNotaCreditoCompra':
		$rspta=$notaCreditoCompra->desactivarDetalleNotaCreditoCompra($_REQUEST['idNotaCreditoCompraDetalle']);
 		echo $rspta ? "Detalle Desactivado" : "Detalle no se puede desactivar";
	break;	

	case 'listar':
		$rspta=$notaCreditoCompra->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idNotaCreditoCompra.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->idNotaCreditoCompra.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idNotaCreditoCompra.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary btn-xs" onclick="activar('.$reg->idNotaCreditoCompra.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nroDevolucion,
 				"2"=>$reg->nroFactura,
 				"3"=>$reg->razonSocial,
 				"4"=>$reg->tipoComprobante,
 				"5"=>$reg->fechaTransaccion,
 				"6"=>$reg->totalC,
 				"7"=>'<button class="btn btn-primary" onclick="mostrarDetalleNotaCreditoCompra('.$reg->idNotaCreditoCompra.')">Ver detalle <i class="fa fa-pencil"></i></button>',
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

	case "selectProveedor":

		$rspta = $notaCreditoCompra->selectProveedor();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idPersona. '>' .$reg->razonSocial. '</option>';
		}

		break;

	case "selectHabilitacion":

		$rspta = $notaCreditoCompra->selectHabilitacion();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idhabilitacion. '>' .$reg->nombre. '</option>';
		}

		break;
  
	case "selectCompra":

		$rspta = $notaCreditoCompra->selectCompra();

			echo '<option value="0">Seleccione una compra</option>';


		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idCompra. '>' .$reg->nroFactura. ' Fecha factura: ' . $reg->fechaFactura . '</option>';
		}

		break;  

	case "selectArticulo":

		$rspta = $notaCreditoCompra->selectArticulo();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idArticulo. '>' .$reg->nombre. '</option>';
		}

		break;  


}
?>