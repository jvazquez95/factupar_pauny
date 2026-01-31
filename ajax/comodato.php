<?php 
require_once "../modelos/Comodato.php";

$ajusteStock=new AjusteStock();  

$Deposito_IdDeposito=isset($_POST["Deposito_IdDeposito"])? limpiarCadena($_POST["Deposito_IdDeposito"]):"";
$comentario=isset($_POST["comentario"])? limpiarCadena($_POST["comentario"]):"";
$fechaTransaccion=isset($_POST["fechaTransaccion"])? limpiarCadena($_POST["fechaTransaccion"]):"";
$costoTotal=isset($_POST["costoTotal"])? limpiarCadena($_POST["costoTotal"]):"";
$cantidadTotal=isset($_POST["cantidadTotal"])? limpiarCadena($_POST["cantidadTotal"]):"";
$idAjusteStock=isset($_POST["idAjusteStock"])? limpiarCadena($_POST["idAjusteStock"]):"";
$idAjusteStockDetalle=isset($_POST["idAjusteStockDetalle"])? limpiarCadena($_POST["idAjusteStockDetalle"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$Direccion_idDireccion=isset($_POST["Direccion_idDireccion"])? limpiarCadena($_POST["Direccion_idDireccion"]):"";
$Cliente_idCliente=isset($_POST["Cliente_idCliente"])? limpiarCadena($_POST["Cliente_idCliente"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";
$compromisoVenta=isset($_POST["compromisoVenta"])? limpiarCadena($_POST["compromisoVenta"]):"";

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
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/comodato/" . $imagen);
			}
		}
		if (empty($idAjusteStock)){
			$rspta=$ajusteStock->insertar(
				$Deposito_IdDeposito,
				$comentario,
				$fechaTransaccion,
				$costoTotal,
				$cantidadTotal, 
				$nombre, 
				$Direccion_idDireccion,
				$Cliente_idCliente,
				$imagen,
				$compromisoVenta,
				$_POST["Articulo_idArticulo"],
				$_POST["cantidad"],
				$_POST["costo"],
				$_POST["subtotal"]
			);
			echo $rspta ? "Comodato registrado" : "Comodato no se pudo registrar";
		} 
		else {
			$rspta=$ajusteStock->editar($idAjusteStock,	$Deposito_IdDeposito, $comentario, $nombre,$compromisoVenta) ;
			echo $rspta ? "Comodato actualizado" : "Comodato no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$ajusteStock->desactivar($idAjusteStock);
 		echo $rspta ? "Comodato Desactivado" : "Comodato no se puede desactivar";
	break;

	case 'desactivarDetalle':
		$rspta=$ajusteStock->desactivarDetalle($idAjusteStockDetalle);
 		echo $rspta ? "Comodato Desactivado" : "Comodato no se puede desactivar";
	break;


	case 'activar':
		$rspta=$ajusteStock->activar($idAjusteStock);
 		echo $rspta ? "Comodato activado" : "Comodato no se puede activar";
	break;

	case 'mostrar':
		$rspta=$ajusteStock->mostrar($idAjusteStock);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;



	case 'listarDetalle':
		//Recibimos el idingreso
		$idAjusteStock=$_GET['idAjusteStock'];

				$rspta = $ajusteStock->listarDetalle($idAjusteStock);
						echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Articulo</th>
                                    <th>Cantidad</th>
				                </thead>';
				        $contT = 0;
						while ($reg = $rspta->fetchObject())
								{
									echo '<tr class="filaT tb_existente" id="filaT'.$contT.'">
									<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleAjusteStock(\''.$contT.'\',\''.$reg->idAjusteStockDetalle.'\')">X</button></td>
									<td><input type="hidden" name="Articulo_idArticulo[]"  value="'.$reg->Articulo_idArticulo.'">'.$reg->na.'</td>
									</td><td><input type="text" name="cantidad[]"  value="'.$reg->cantidad.'"></td>
									</td>';
									$contT++;															}
					echo 	'<tfoot>
                                    <th>Opciones</th>
                                    <th>Tipo de Telefono</th>
                                    <th>Telefono</th>
                                </tfoot>';

	break;



	case 'listarp':
		$rspta=$ajusteStock->listarp();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array( 
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idComodato.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->idComodato.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idComodato.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary btn-xs" onclick="activar('.$reg->idComodato.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->descripcion,
 				"2"=>$reg->fechaTransaccion,
 				"3"=>$reg->Direccion_idDireccion,
 				"4"=>$reg->costoTotal,
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
		$rspta=$ajusteStock->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){ 
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idComodato.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->idComodato.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idComodato.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary btn-xs" onclick="activar('.$reg->idComodato.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->descripcion,
 				"2"=>$reg->fechaTransaccion,
 				"3"=>$reg->direccion,
				"4"=>$reg->razonSocial,
				"5"=>$reg->compromisoVenta,
				"6"=>'<button class="btn btn-primary" onclick="enviarTransito('.$reg->idComodato.')">Confirmar<i class="fa fa-pencil"></i></button>',			 				
 				"7"=>$reg->estado_descripcion
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'enviarTransito': 
		$rspta=$ajusteStock->enviarTransito($idAjusteStock);
 		echo $rspta ? "Registro enviado" : "Registro no se puede enviar";
	break;	


	case "selectDeposito":

		$rspta = $ajusteStock->selectDeposito();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idDeposito. '>' .$reg->descripcion. '</option>';
		}

		break; 
 

	case "selectArticulo":

		$rspta = $ajusteStock->selectArticulo();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idArticulo. '>' .$reg->nombre. '</option>';
		}

		break;  
 

}
?>