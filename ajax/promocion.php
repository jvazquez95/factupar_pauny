<?php 
require_once "../modelos/Promocion.php";

$promocion=new Promocion();

$idPromocion=isset($_POST["idPromocion"])? limpiarCadena($_POST["idPromocion"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$fechaInicio=isset($_POST["fechaInicio"])? limpiarCadena($_POST["fechaInicio"]):"";
$fechaFin=isset($_POST["fechaFin"])? limpiarCadena($_POST["fechaFin"]):"";
$tipoPromocion=isset($_POST["tipoPromocion"])? limpiarCadena($_POST["tipoPromocion"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idPromocion)){
			$rspta=$promocion->insertar(
				$descripcion, $fechaInicio, $fechaFin, $tipoPromocion, $_POST['tipoDescuento1'], 
				$_POST['Articulo_idArticuloDescuento1'], $_POST['desde1'], $_POST['hasta1'], $_POST['descuentoPorcentualDescuento1'], $_POST['descuentoGsDescuento1'], 
				$_POST['Articulo_idArticuloPunto2'], $_POST['cantidadPuntos2'], $_POST['Articulo_idArticulo3'], $_POST['FormaPago_idFormaPago3'], $_POST['descuentoPorcentual3'], 
				$_POST['descuentoGs3'], $_POST['Banco_idBanco3'] , $_POST['Articulo_idArticulo4'], $_POST['precioGs4'], $_POST['ventaMaxima4'], 
				$_POST['Articulo_idArticulo5'], $_POST['precioGsPrecio_l5'], $_POST['puntos5'],$_POST['Articulo_idArticulo6'], $_POST['precioGsPrecio_D6'], 
				$_POST['puntos6'], $_POST['porcentaje6'],$_POST['Sucursal_idSucursalD1'],$_POST['Sucursal_idSucursalD2'] ,$_POST['Sucursal_idSucursalD3'] ,
				$_POST['Sucursal_idSucursalD4'] ,$_POST['Sucursal_idSucursalD5'],$_POST['Sucursal_idSucursalD6']  );
			echo $rspta ? "promocion registrada" : "promocion no se pudo registrar";
		}
		else {
			$rspta=$promocion->editar($idPromocion,$descripcion, $fechaInicio, $fechaFin, $tipoPromocion,  $_POST['tipoDescuento1'], $_POST['Articulo_idArticuloDescuento1'], $_POST['desde1'], $_POST['hasta1'], $_POST['descuentoPorcentualDescuento1'], $_POST['descuentoGsDescuento1'], $_POST['Articulo_idArticuloPunto2'], $_POST['cantidadPuntos2'], $_POST['Articulo_idArticulo3'], $_POST['FormaPago_idFormaPago3'], $_POST['descuentoPorcentual3'], $_POST['descuentoGs3'], $_POST['Banco_idBanco3'] , $_POST['Articulo_idArticulo4'], $_POST['precioGs4'], $_POST['ventaMaxima4'], $_POST['Articulo_idArticulo5'], $_POST['precioGsPrecio_l5'], $_POST['puntos5'],$_POST['Sucursal_idSucursalD1'] );
			echo $rspta ? "promocion actualizada" : "promocion no se pudo actualizar";
		}
	break;

	case 'mostrar':
		$rspta=$promocion->mostrar($idPromocion);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'desactivar':
		$rspta=$promocion->desactivar($idPromocion);
 		echo $rspta ? "promocion Desactivado" : "promocion no se puede desactivar";
	break;

	case 'activar':
		$rspta=$promocion->activar($idPromocion);
 		echo $rspta ? "promocion activado" : "promocion no se puede activar";
	break;


	case 'listar':
		$rspta=$promocion->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idPromocion.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idPromocion.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idPromocion.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idPromocion.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->descripcion,
 				"2"=>$reg->fechaInicio,
 				"3"=>$reg->fechaFin,
 				"4"=>$reg->tipoPromocion,
 				"5"=>$reg->usuarioInsercion,
 				"6"=>$reg->fechaInsersion,
 				"7"=>$reg->usarioModificacion,
 				"8"=>$reg->fechaModificacion,
 				"9"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
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


	case 'listarFiltrado1':
 
		$idProveedor=$_REQUEST["idProveedor"];
		$marca=$_REQUEST["marca"];
		$grupo=$_REQUEST["grupo"];
		$categoria=$_REQUEST["categoria"]; 
		$tipoDescuento=$_REQUEST["tipoDescuento"];
		$desde1=$_REQUEST["desde1"]; 
		$hasta1=$_REQUEST["hasta1"]; 
		$descuentoPorcentaje=$_REQUEST["descuentoPorcentaje"]; 
		$descuentoMonto=$_REQUEST["descuentoMonto"];  
		$sucursal=$_REQUEST["sucursal"]; 

		$rspta=$promocion->listarFiltrado1($idProveedor, $marca, $grupo, $categoria, $sucursal);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 		$url='../reportes/exTicket.php?id=';
 			$data[]=array(
 				"0"=>((!$reg->inactivo)?'<button class="btn btn-danger" onclick="mostrarDetalle('.$reg->idArticulo.',\''.$reg->tipo.'\')">X</button>':
 					''),
 				"1"=> $tipoDescuento, 
 				"2"=> utf8_encode($reg->descripcion), 
 				"3"=> $desde1,
 				"4"=> $hasta1,
 				"5"=> $descuentoPorcentaje,
 				"6"=> $descuentoMonto,
 				"7"=>'<button class="btn btn-primary" onclick="mostrarDetalle('.$reg->idArticulo.',\''.$reg->tipo.'\')">Ver detalle <i class="fa fa-pencil"></i></button>',
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


	case 'listarFiltrado2':
 
		$idProveedor=$_REQUEST["idProveedor"];
		$marca=$_REQUEST["marca"];
		$grupo=$_REQUEST["grupo"];
		$categoria=$_REQUEST["categoria"]; 
		$cantidadPuntos=$_REQUEST["cantidadPuntos"]; 
		$sucursal=$_REQUEST["sucursal"]; 
		$rspta=$promocion->listarFiltrado1($idProveedor, $marca, $grupo, $categoria, $sucursal);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 		$url='../reportes/exTicket.php?id=';
 			$data[]=array(
 				"0"=>((!$reg->inactivo)?'<button class="btn btn-danger" onclick="mostrarDetalle('.$reg->idArticulo.',\''.$reg->tipo.'\')">X</button>':
 					''),
 				"1"=> $reg->idArticulo,
 				"2"=> $cantidadPuntos,
 				"3"=>'<button class="btn btn-primary" onclick="mostrarDetalle('.$reg->idArticulo.',\''.$reg->tipo.'\')">Ver detalle <i class="fa fa-pencil"></i></button>',
 				"4"=>(!$reg->inactivo)?'<span class="label bg-green">Aceptado</span>':
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


	case 'listarFiltrado3':
  
		$idProveedor=$_REQUEST["idProveedor"];
		$marca=$_REQUEST["marca"];
		$grupo=$_REQUEST["grupo"];
		$categoria=$_REQUEST["categoria"]; 
		$formaPago=$_REQUEST["formaPago"]; 
		$banco=$_REQUEST["banco"]; 
		$descuentoPorcentual=$_REQUEST["descuentoPorcentual"]; 
		$descuentoMonto=$_REQUEST["descuentoMonto"]; 
		$sucursal=$_REQUEST["sucursal"]; 
		$rspta=$promocion->listarFiltrado1($idProveedor, $marca, $grupo, $categoria, $sucursal);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 		$url='../reportes/exTicket.php?id=';
 			$data[]=array(
 				"0"=>((!$reg->inactivo)?'<button class="btn btn-danger" onclick="mostrarDetalle('.$reg->idArticulo.',\''.$reg->tipo.'\')">X</button>':
 					''),
 				"1"=> utf8_encode($reg->descripcion), 
 				"2"=> $formaPago,
 				"3"=> $banco,
 				"4"=> $descuentoPorcentual,
 				"5"=> $descuentoMonto,
 				"6"=>'<button class="btn btn-primary" onclick="mostrarDetalle('.$reg->idArticulo.',\''.$reg->tipo.'\')">Ver detalle <i class="fa fa-pencil"></i></button>',
 				"7"=>(!$reg->inactivo)?'<span class="label bg-green">Aceptado</span>':
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

	case 'listarFiltrado4':
		$idProveedor=$_REQUEST["idProveedor"];
		$marca=$_REQUEST["marca"];
		$grupo=$_REQUEST["grupo"];
		$categoria=$_REQUEST["categoria"]; 
		$precio=$_REQUEST["precio"];
		$ventamax=$_REQUEST["ventamax"]; 
		$sucursal=$_REQUEST["sucursal"]; 
		$rspta=$promocion->listarFiltrado4($idProveedor, $marca, $grupo, $categoria,$precio,$ventamax, $sucursal);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 		$url='../reportes/exTicket.php?id=';
 			$data[]=array(
 				"0"=>((!$reg->inactivo)?'<button class="btn btn-danger" onclick="mostrarDetalle('.$reg->idArticulo.',\''.$reg->tipo.'\')">X</button>':
 					''),
 				"1"=> utf8_encode($reg->descripcion), 
 				"2"=>   $precio,
 				"3"=>	$ventamax,
 				"4"=>'<button class="btn btn-primary" onclick="mostrarDetalle('.$reg->idArticulo.',\''.$reg->tipo.'\')">Ver detalle <i class="fa fa-pencil"></i></button>',
 				"5"=>(!$reg->inactivo)?'<span class="label bg-green">Aceptado</span>':
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


	case 'listarFiltrado5':
		$idProveedor=$_REQUEST["idProveedor"];
		$marca=$_REQUEST["marca"];
		$grupo=$_REQUEST["grupo"];
		$categoria=$_REQUEST["categoria"]; 
		$precioD5=$_REQUEST["precioD5"];
		$puntoD5=$_REQUEST["puntoD5"]; 
		$sucursal=$_REQUEST["sucursal"]; 
		$rspta=$promocion->listarFiltrado1($idProveedor, $marca, $grupo, $categoria, $sucursal);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 		$url='../reportes/exTicket.php?id=';
 			$data[]=array(
 				"0"=>((!$reg->inactivo)?'<button class="btn btn-danger" onclick="mostrarDetalle('.$reg->idArticulo.',\''.$reg->tipo.'\')">X</button>':
 					''),
 				"1"=> utf8_encode($reg->descripcion), 
 				"2"=>   $precioD5,
 				"3"=>	$puntoD5,
 				"4"=>'<button class="btn btn-primary" onclick="mostrarDetalle('.$reg->idArticulo.',\''.$reg->tipo.'\')">Ver detalle <i class="fa fa-pencil"></i></button>',
 				"5"=>(!$reg->inactivo)?'<span class="label bg-green">Aceptado</span>':
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


	case 'listarFiltrado6':
		$idProveedor=$_REQUEST["idProveedor"];
		$marca=$_REQUEST["marca"];
		$grupo=$_REQUEST["grupo"];
		$categoria=$_REQUEST["categoria"]; 
		$precioD6=$_REQUEST["precioD6"];
		$puntoD6=$_REQUEST["puntoD6"]; 
		$sucursal=$_REQUEST["sucursal"]; 
		$rspta=$promocion->listarFiltrado1($idProveedor, $marca, $grupo, $categoria, $sucursal);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 		$url='../reportes/exTicket.php?id=';
 			$data[]=array(
 				"0"=>((!$reg->inactivo)?'<button class="btn btn-danger" onclick="mostrarDetalle('.$reg->idArticulo.',\''.$reg->tipo.'\')">X</button>':
 					''),
 				"1"=> utf8_encode($reg->descripcion), 
 				"2"=>   $precioD5,
 				"3"=>	$puntoD5,
 				"4"=>'<button class="btn btn-primary" onclick="mostrarDetalle('.$reg->idArticulo.',\''.$reg->tipo.'\')">Ver detalle <i class="fa fa-pencil"></i></button>',
 				"5"=>(!$reg->inactivo)?'<span class="label bg-green">Aceptado</span>':
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


	case 'listarDetalle':
		//Recibimos el idingreso
		$idPromocion=$_GET['idPromocion'];
		$tipoPromocion=$_GET['tipoPromocion'];

		if ($tipoPromocion == 'promocionPorDescuento') {
				$rspta = $promocion->listarDetallePromocionPorDescuento($idPromocion);
						echo '<thead style="background-color:#A9D0F5">
													<th>Opciones</th>
				                              		<th>Tipo de Descuento</th>
				                                     <th>Articulo</th>
				                                     <th>Desde</th>
				                                     <th>Hasta</th>
				                                     <th>Descuento %</th>
				                                     <th>Descuento GS</th>
				                                </thead>';
				        $contPuntos = 0;
						while ($reg = $rspta->fetchObject())
								{
									echo '<tr class="filaPuntos" id="filaPuntos'.$contPuntos.'">
										<td><button type="button" class="btn btn-danger" onclick="eliminarDetallePuntos('.$contPuntos.')">X</button>
										</td><td><input type="hidden" name="tipoDescuento1[]" id="tipoDescuento1[]" value="'.$reg->tipoDescuento.'">'.$reg->tipoDescuento.'</td>
										</td><td><input type="hidden" name="Articulo_idArticuloDescuento1[]" id="Articulo_idArticuloDescuento1[]" value="'.$reg->Articulo_idArticulo.'">'.$reg->Articulo_idArticulo.'</td>
										</td><td><input type="hidden" name="desde1[]" id="desde1[]" value="'.$reg->desde.'">'.$reg->desde.'</td>
										</td><td><input type="hidden" name="hasta1[]" id="hasta1[]" value="'.$reg->hasta.'">'.$reg->hasta.'</td>
										</td><td><input type="hidden" name="descuentoPorcentualDescuento1[]" id="descuentoPorcentualDescuento1[]" value="'.$reg->descuentoPorcentual.'">'.$reg->descuentoPorcentual.'</td>
										</td><td><input type="hidden" name="descuentoGsDescuento1[]" id="descuentoGsDescuento1[]" value="'.$reg->descuentoGs.'">'.$reg->descuentoGs.'</td>
										</tr>';


									$contPuntos++;
									
								}
						echo '<tfoot>
						<th>Opciones</th>
				                       		<th>Tipo de Descuento</th>
				                           		<th>Articulo</th>
				                           		<th>Desde</th>
				                           		<th>Hasta</th>
				                           		<th>Descuento %</th>
				                           		<th>Descuento GS</th>
				                                </tfoot>';
		}

		if ($tipoPromocion == 'promocionPorPuntos') {
				$rspta = $promocion->listarDetallePromocionPorPuntos($idPromocion);
						echo '<thead style="background-color:#A9D0F5">
													<th>Opciones</th>
				                              		<th>Tipo de Descuento</th>
				                                     <th>Articulo</th>
				                                     <th>Desde</th>
				                                     <th>Hasta</th>
				                                     <th>Descuento %</th>
				                                     <th>Descuento GS</th>
				                                </thead>';
				        $contPuntos = 0;
						while ($reg = $rspta->fetchObject())
								{
									echo '<tr class="filaPuntos" id="filaPuntos'.$contPuntos.'">
										<td><button type="button" class="btn btn-danger" onclick="eliminarDetallePuntos('.$contPuntos.')">X</button>
										</td><td><input type="hidden" name="tipoDescuento1[]" id="tipoDescuento1[]" value="'.$reg->tipoDescuento.'">'.$reg->tipoDescuento.'</td>
										</td><td><input type="hidden" name="Articulo_idArticuloDescuento1[]" id="Articulo_idArticuloDescuento1[]" value="'.$reg->Articulo_idArticulo.'">'.$reg->Articulo_idArticulo.'</td>
										</td><td><input type="hidden" name="desde1[]" id="desde1[]" value="'.$reg->desde.'">'.$reg->desde.'</td>
										</td><td><input type="hidden" name="hasta1[]" id="hasta1[]" value="'.$reg->hasta.'">'.$reg->hasta.'</td>
										</td><td><input type="hidden" name="descuentoPorcentualDescuento1[]" id="descuentoPorcentualDescuento1[]" value="'.$reg->descuentoPorcentual.'">'.$reg->descuentoPorcentual.'</td>
										</td><td><input type="hidden" name="descuentoGsDescuento1[]" id="descuentoGsDescuento1[]" value="'.$reg->descuentoGs.'">'.$reg->descuentoGs.'</td>
										</tr>';


									$contPuntos++;
									
								}
						echo '<tfoot>
						<th>Opciones</th>
				                       		<th>Tipo de Descuento</th>
				                           		<th>Articulo</th>
				                           		<th>Desde</th>
				                           		<th>Hasta</th>
				                           		<th>Descuento %</th>
				                           		<th>Descuento GS</th>
				                                </tfoot>';
		}

		if ($tipoPromocion == 'promocionPorFormaPago') {
				$rspta = $promocion->listarDetallePromocionPorFormaPago($idPromocion);
						echo '<thead style="background-color:#A9D0F5">
													<th>Opciones</th>
				                              		<th>Tipo de Descuento</th>
				                                     <th>Articulo</th>
				                                     <th>Desde</th>
				                                     <th>Hasta</th>
				                                     <th>Descuento %</th>
				                                     <th>Descuento GS</th>
				                                </thead>';
				        $contPuntos = 0;
						while ($reg = $rspta->fetchObject())
								{
									echo '<tr class="filaPuntos" id="filaPuntos'.$contPuntos.'">
										<td><button type="button" class="btn btn-danger" onclick="eliminarDetallePuntos('.$contPuntos.')">X</button>
										</td><td><input type="hidden" name="tipoDescuento1[]" id="tipoDescuento1[]" value="'.$reg->tipoDescuento.'">'.$reg->tipoDescuento.'</td>
										</td><td><input type="hidden" name="Articulo_idArticuloDescuento1[]" id="Articulo_idArticuloDescuento1[]" value="'.$reg->Articulo_idArticulo.'">'.$reg->Articulo_idArticulo.'</td>
										</td><td><input type="hidden" name="desde1[]" id="desde1[]" value="'.$reg->desde.'">'.$reg->desde.'</td>
										</td><td><input type="hidden" name="hasta1[]" id="hasta1[]" value="'.$reg->hasta.'">'.$reg->hasta.'</td>
										</td><td><input type="hidden" name="descuentoPorcentualDescuento1[]" id="descuentoPorcentualDescuento1[]" value="'.$reg->descuentoPorcentual.'">'.$reg->descuentoPorcentual.'</td>
										</td><td><input type="hidden" name="descuentoGsDescuento1[]" id="descuentoGsDescuento1[]" value="'.$reg->descuentoGs.'">'.$reg->descuentoGs.'</td>
										</tr>';


									$contPuntos++;
									
								}
						echo '<tfoot>
						<th>Opciones</th>
				                       		<th>Tipo de Descuento</th>
				                           		<th>Articulo</th>
				                           		<th>Desde</th>
				                           		<th>Hasta</th>
				                           		<th>Descuento %</th>
				                           		<th>Descuento GS</th>
				                                </tfoot>';
		}

		if ($tipoPromocion == 'promocionPorTiempoLimitado') {
				$rspta = $promocion->listarDetallePromocionPorTiempoLimitado($idPromocion);
						echo '<thead style="background-color:#A9D0F5">
													<th>Opciones</th>
				                              		<th>Tipo de Descuento</th>
				                                     <th>Articulo</th>
				                                     <th>Desde</th>
				                                     <th>Hasta</th>
				                                     <th>Descuento %</th>
				                                     <th>Descuento GS</th>
				                                </thead>';
				        $contPuntos = 0;
						while ($reg = $rspta->fetchObject())
								{
									echo '<tr class="filaPuntos" id="filaPuntos'.$contPuntos.'">
										<td><button type="button" class="btn btn-danger" onclick="eliminarDetallePuntos('.$contPuntos.')">X</button>
										</td><td><input type="hidden" name="tipoDescuento1[]" id="tipoDescuento1[]" value="'.$reg->tipoDescuento.'">'.$reg->tipoDescuento.'</td>
										</td><td><input type="hidden" name="Articulo_idArticuloDescuento1[]" id="Articulo_idArticuloDescuento1[]" value="'.$reg->Articulo_idArticulo.'">'.$reg->Articulo_idArticulo.'</td>
										</td><td><input type="hidden" name="desde1[]" id="desde1[]" value="'.$reg->desde.'">'.$reg->desde.'</td>
										</td><td><input type="hidden" name="hasta1[]" id="hasta1[]" value="'.$reg->hasta.'">'.$reg->hasta.'</td>
										</td><td><input type="hidden" name="descuentoPorcentualDescuento1[]" id="descuentoPorcentualDescuento1[]" value="'.$reg->descuentoPorcentual.'">'.$reg->descuentoPorcentual.'</td>
										</td><td><input type="hidden" name="descuentoGsDescuento1[]" id="descuentoGsDescuento1[]" value="'.$reg->descuentoGs.'">'.$reg->descuentoGs.'</td>
										</tr>';


									$contPuntos++;
									
								}
						echo '<tfoot>
						<th>Opciones</th>
				                       		<th>Tipo de Descuento</th>
				                           		<th>Articulo</th>
				                           		<th>Desde</th>
				                           		<th>Hasta</th>
				                           		<th>Descuento %</th>
				                           		<th>Descuento GS</th>
				                                </tfoot>';
		}

		if ($tipoPromocion == 'promocionPorPrecioPunto') {
				$rspta = $promocion->listarDetallePromocionPorPrecioPunto($idPromocion);
						echo '<thead style="background-color:#A9D0F5">
													<th>Opciones</th>
				                              		<th>Tipo de Descuento</th>
				                                     <th>Articulo</th>
				                                     <th>Desde</th>
				                                     <th>Hasta</th>
				                                     <th>Descuento %</th>
				                                     <th>Descuento GS</th>
				                                </thead>';
				        $contPuntos = 0;
						while ($reg = $rspta->fetchObject())
								{
									echo '<tr class="filaPuntos" id="filaPuntos'.$contPuntos.'">
										<td><button type="button" class="btn btn-danger" onclick="eliminarDetallePuntos('.$contPuntos.')">X</button>
										</td><td><input type="hidden" name="tipoDescuento1[]" id="tipoDescuento1[]" value="'.$reg->tipoDescuento.'">'.$reg->tipoDescuento.'</td>
										</td><td><input type="hidden" name="Articulo_idArticuloDescuento1[]" id="Articulo_idArticuloDescuento1[]" value="'.$reg->Articulo_idArticulo.'">'.$reg->Articulo_idArticulo.'</td>
										</td><td><input type="hidden" name="desde1[]" id="desde1[]" value="'.$reg->desde.'">'.$reg->desde.'</td>
										</td><td><input type="hidden" name="hasta1[]" id="hasta1[]" value="'.$reg->hasta.'">'.$reg->hasta.'</td>
										</td><td><input type="hidden" name="descuentoPorcentualDescuento1[]" id="descuentoPorcentualDescuento1[]" value="'.$reg->descuentoPorcentual.'">'.$reg->descuentoPorcentual.'</td>
										</td><td><input type="hidden" name="descuentoGsDescuento1[]" id="descuentoGsDescuento1[]" value="'.$reg->descuentoGs.'">'.$reg->descuentoGs.'</td>
										</tr>';


									$contPuntos++;
									
								}
						echo '<tfoot>
						<th>Opciones</th>
				                       		<th>Tipo de Descuento</th>
				                           		<th>Articulo</th>
				                           		<th>Desde</th>
				                           		<th>Hasta</th>
				                           		<th>Descuento %</th>
				                           		<th>Descuento GS</th>
				                                </tfoot>';
		}

		if ($tipoPromocion == 'promocionPorPrecioPack') {
				$rspta = $promocion->listarDetallePromocionPorPrecioPack($idPromocion);
						echo '<thead style="background-color:#A9D0F5">
													<th>Opciones</th>
				                              		<th>Tipo de Descuento</th>
				                                     <th>Articulo</th>
				                                     <th>Desde</th>
				                                     <th>Hasta</th>
				                                     <th>Descuento %</th>
				                                     <th>Descuento GS</th>
				                                </thead>';
				        $contPuntos = 0;
						while ($reg = $rspta->fetchObject())
								{
									echo '<tr class="filaPuntos" id="filaPuntos'.$contPuntos.'">
										<td><button type="button" class="btn btn-danger" onclick="eliminarDetallePuntos('.$contPuntos.')">X</button>
										</td><td><input type="hidden" name="tipoDescuento1[]" id="tipoDescuento1[]" value="'.$reg->tipoDescuento.'">'.$reg->tipoDescuento.'</td>
										</td><td><input type="hidden" name="Articulo_idArticuloDescuento1[]" id="Articulo_idArticuloDescuento1[]" value="'.$reg->Articulo_idArticulo.'">'.$reg->Articulo_idArticulo.'</td>
										</td><td><input type="hidden" name="desde1[]" id="desde1[]" value="'.$reg->desde.'">'.$reg->desde.'</td>
										</td><td><input type="hidden" name="hasta1[]" id="hasta1[]" value="'.$reg->hasta.'">'.$reg->hasta.'</td>
										</td><td><input type="hidden" name="descuentoPorcentualDescuento1[]" id="descuentoPorcentualDescuento1[]" value="'.$reg->descuentoPorcentual.'">'.$reg->descuentoPorcentual.'</td>
										</td><td><input type="hidden" name="descuentoGsDescuento1[]" id="descuentoGsDescuento1[]" value="'.$reg->descuentoGs.'">'.$reg->descuentoGs.'</td>
										</tr>';


									$contPuntos++;
									
								}
						echo '<tfoot>
						<th>Opciones</th>
				                       		<th>Tipo de Descuento</th>
				                           		<th>Articulo</th>
				                           		<th>Desde</th>
				                           		<th>Hasta</th>
				                           		<th>Descuento %</th>
				                           		<th>Descuento GS</th>
				                                </tfoot>';
		}		


	break;




	case "selectPromocion":

		$rspta = $promocion->selectpromocion();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idPromocion. '>' .$reg->descripcion. '</option>';
		}

		break;

}
?>