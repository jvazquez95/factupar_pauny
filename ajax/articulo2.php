<?php 
require_once "../modelos/Articulo2.php";
session_start();
$articulo=new Articulo2();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$idArticulo=isset($_POST["idArticulo"])? limpiarCadena($_POST["idArticulo"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$nombreArticulo=isset($_POST["nombreArticulo"])? limpiarCadena($_POST["nombreArticulo"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$codigo=isset($_POST["codigo"])? limpiarCadena($_POST["codigo"]):"";
$codigoBarra=isset($_POST["codigoBarra"])? limpiarCadena($_POST["codigoBarra"]):"";
$codigoBarras=isset($_POST["codigoBarras"])? limpiarCadena($_POST["codigoBarras"]):"";
$codigoAlternativo=isset($_POST["codigoAlternativo"])? limpiarCadena($_POST["codigoAlternativo"]):"";
$tipoArticulo=isset($_POST["tipoArticulo"])? limpiarCadena($_POST["tipoArticulo"]):"";
$GrupoArticulo_idGrupoArticulo=isset($_POST["GrupoArticulo_idGrupoArticulo"])? limpiarCadena($_POST["GrupoArticulo_idGrupoArticulo"]):"";
$Categoria_idCategoria=isset($_POST["Categoria_idCategoriaD"])? limpiarCadena($_POST["Categoria_idCategoriaD"]):"";
$Categoria_idCategoriaPadre=isset($_POST["Categoria_idCategoria"])? limpiarCadena($_POST["Categoria_idCategoria"]):"";
$TipoImpuesto_idTipoImpuesto=isset($_POST["TipoImpuesto_idTipoImpuesto"])? limpiarCadena($_POST["TipoImpuesto_idTipoImpuesto"]):"";
$Unidad_idUnidadCompra=isset($_POST["Unidad_idUnidadCompra"])? limpiarCadena($_POST["Unidad_idUnidadCompra"]):"";
$Unidad_idUnidad=isset($_POST["Unidad_idUnidad"])? limpiarCadena($_POST["Unidad_idUnidad"]):"";
$precioVenta=isset($_POST["precioVenta"])? limpiarCadena($_POST["precioVenta"]):"";
$usuarioInsercion=$_SESSION['login'];
$usuarioModificacion=isset($_POST["usuarioModificacion"])? limpiarCadena($_POST["usuarioModificacion"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";
$comisiongs=isset($_POST["comisiongs"])? limpiarCadena($_POST["comisiongs"]):"";
$comisionp=isset($_POST["comisionp"])? limpiarCadena($_POST["comisionp"]):"";
$Persona_idPersona=isset($_POST["Persona_idPersona"])? limpiarCadena($_POST["Persona_idPersona"]):"";
$Marca_idMarca=isset($_POST["Marca_idMarca"])? limpiarCadena($_POST["Marca_idMarca"]):"";
$CuentaContable_idCuentaContable=isset($_POST["CuentaContable_idCuentaContable"])? limpiarCadena($_POST["CuentaContable_idCuentaContable"]):"";
$cantidadCaja=isset($_POST["cantidadCaja"])? limpiarCadena($_POST["cantidadCaja"]):"";
$pesoBruto=isset($_POST["pesoBruto"])? limpiarCadena($_POST["pesoBruto"]):"";
$pesoLiquido=isset($_POST["pesoLiquido"])? limpiarCadena($_POST["pesoLiquido"]):"";
$cantidadPiso=isset($_POST["cantidadPiso"])? limpiarCadena($_POST["cantidadPiso"]):"";
$cantidadPalet=isset($_POST["cantidadPalet"])? limpiarCadena($_POST["cantidadPalet"]):"";
$regimenTurismo=isset($_POST["regimenTurismo"])? limpiarCadena($_POST["regimenTurismo"]):"";
$balanza=isset($_POST["balanza"])? limpiarCadena($_POST["balanza"]):"";
$ventasKl=isset($_POST["ventasKl"])? limpiarCadena($_POST["ventasKl"]):"";
$costo=isset($_POST["costo"])? limpiarCadena($_POST["costo"]):"";
$afectaCompra=isset($_POST["afectaCompra"])? limpiarCadena($_POST["afectaCompra"]):"";
$afectaVenta=isset($_POST["afectaVenta"])? limpiarCadena($_POST["afectaVenta"]):"";


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
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/articulos/" . $imagen);
			}
		}
		if (empty($idArticulo)){
			if ($tipoArticulo == 'PAQUETE') {
				$rspta=$articulo->insertar($CuentaContable_idCuentaContable,  strtoupper($nombre),strtoupper($descripcion),$codigo,$codigoBarra,$codigoAlternativo,$tipoArticulo,$GrupoArticulo_idGrupoArticulo,$Categoria_idCategoria,$Categoria_idCategoriaPadre,$TipoImpuesto_idTipoImpuesto,$Unidad_idUnidad,$Unidad_idUnidadCompra,$precioVenta,$usuarioInsercion,$imagen, $comisionp, $comisiongs , $Persona_idPersona,$Marca_idMarca, $cantidadCaja,$pesoBruto,$pesoLiquido,$cantidadPiso,$cantidadPalet,$regimenTurismo,$balanza,$ventasKl,$costo,$afectaCompra,$afectaVenta, $_POST["idarticulo"], $_POST["idarticulon"], $_POST["cantidad"], $_POST["comisionpp"],$_POST["comisiongsp"],$_POST["Sucursal_idSucursal"],$_POST["GrupoPersona_idGrupoPersona"],$_POST["precio"],$_POST["margen"],$_POST["Persona_idPersona_detalle"], $_POST["prioridad_detalle"], $_POST["codigoProveedor_detalle"],$_POST["descontinuado_detalle"],$_POST["precioCompra_detalle"],$_POST["idArticulo_Proveedor"], $_POST['codigoBarra_detalle'], $_POST['descripcionCodigoBarra_detalle'], $_POST['Unidad_idUnidad_detalle'], 
					$_POST['Articulo_idArticulo'], $_POST['Canje'], $_POST['cantidadMateriaPrima'], $_POST['afectaCompra'], $_POST['afectaVenta']); 
				echo $rspta ? "Artículo registrado" : "Artículo no se pudo registrar";
			}else{
				$rspta=$articulo->insertar($CuentaContable_idCuentaContable,$nombre,$descripcion,$codigo,$codigoBarra,$codigoAlternativo,$tipoArticulo,$GrupoArticulo_idGrupoArticulo,$Categoria_idCategoria,$Categoria_idCategoriaPadre,$TipoImpuesto_idTipoImpuesto,$Unidad_idUnidad,$Unidad_idUnidadCompra,$precioVenta,$usuarioInsercion,$imagen, $comisionp, $comisiongs, $Persona_idPersona,$Marca_idMarca, $cantidadCaja,$pesoBruto,$pesoLiquido,$cantidadPiso,$cantidadPalet,$regimenTurismo,$balanza,$ventasKl, $costo,$afectaCompra,$afectaVenta ,0, 0, 0, 0,0,$_POST["Sucursal_idSucursal"],$_POST["GrupoPersona_idGrupoPersona"],$_POST["precio"],$_POST["margen"],$_POST["Persona_idPersona_detalle"], $_POST["prioridad_detalle"], $_POST["codigoProveedor_detalle"],$_POST["descontinuado_detalle"],$_POST["precioCompra_detalle"],$_POST["idArticulo_Proveedor"], $_POST['codigoBarra_detalle'], $_POST['descripcionCodigoBarra_detalle'], $_POST['Unidad_idUnidad_detalle'],  
					$_POST['Articulo_idArticulo'], $_POST['Canje'], $_POST['cantidadMateriaPrima'], $_POST['afectaCompra'], $_POST['afectaVenta']); 
				echo $rspta ? "Artículo registrado" : "Artículo no se pudo registrar";				
			}
		}
		else {
			$rspta=$articulo->editar($CuentaContable_idCuentaContable,$idArticulo, $nombre,$descripcion,$codigo,$codigoBarra,$codigoAlternativo,$tipoArticulo,$GrupoArticulo_idGrupoArticulo,$Categoria_idCategoria,$Categoria_idCategoriaPadre,$TipoImpuesto_idTipoImpuesto,$Unidad_idUnidad,$Unidad_idUnidadCompra,$precioVenta,$usuarioModificacion,$imagen,$comisiongs,$comisionp, $Persona_idPersona,$Marca_idMarca,$cantidadCaja,$pesoBruto,$pesoLiquido,$cantidadPiso,$cantidadPalet,$regimenTurismo,$balanza,$ventasKl,$costo,$afectaCompra,$afectaVenta,$_POST["Sucursal_idSucursal"],$_POST["GrupoPersona_idGrupoPersona"],$_POST["precio"],$_POST["margen"],$_POST["idPrecio"],$_POST["Persona_idPersona_detalle"], $_POST["prioridad_detalle"], $_POST["codigoProveedor_detalle"],$_POST["descontinuado_detalle"],$_POST["precioCompra_detalle"],$_POST["idArticulo_Proveedor"],$_POST['afectaCompra'], $_POST['afectaVenta']);
			echo $rspta ? "Artículo actualizado" : "Artículo no se pudo actualizar";
		}
	break; 


	case 'guardarNombre':
		$rspta=$articulo->guardarNombre($idArticulo, $nombreArticulo);
 		echo $rspta ? "Artículo editado" : "Artículo no se puede editar";
	break;


	case 'desactivar':
		$rspta=$articulo->desactivar($idArticulo);
 		echo $rspta ? "Artículo Desactivado" : "Artículo no se puede desactivar";
	break;



	case 'desactivarArticuloProveedor':
		$rspta=$articulo->desactivarArticuloProveedor($_REQUEST['idArticulo_Proveedor']);
 		echo $rspta ? " Desactivado" : "Proveedor no se puede desactivar";
	break;


	case 'desactivarArticuloCodigo':
		$rspta=$articulo->desactivarArticuloCodigo($_REQUEST['idArticulo_Codigo']);
 		echo $rspta ? " Desactivado" : "Codigo no se puede desactivar";
	break;


	case 'desactivarPrecio':
		$rspta=$articulo->desactivarPrecio($_REQUEST['idPrecio']);
 		echo $rspta ? "Precio Desactivado" : "Precio no se puede desactivar";
	break;

	case 'desactivarMateriaPrima':
		$rspta=$articulo->desactivarMateriaPrima($_REQUEST['idArticulo_Detalle']);
 		echo $rspta ? " Desactivado" : " no se puede desactivar";
	break;


	case 'activar':
		$rspta=$articulo->activar($idArticulo);
 		echo $rspta ? "Artículo activado" : "Artículo no se puede activar";
	break;

	case 'mostrar':
		$rspta=$articulo->mostrar($idArticulo);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;




	case 'buscar_articulo_cb':
		$rspta=$articulo->buscar_articulo_cb($codigoBarras);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;



	case 'listarDetallePrecio':
		//Recibimos el idingreso
		$idArticulo=$_GET['idArticulo'];

				$rspta = $articulo->listarDetallePrecio($idArticulo);
						echo '<thead style="background-color:#A9D0F5">
													<th>Opciones</th>
				                              		<th>Sucursal</th>
				                                    <th>Grupo Persona</th>
				                                    <th>Margen</th>
				                                    <th>Precio</th>
				                                </thead>';
				        $contPrecio = 0;
						while ($reg = $rspta->fetchObject())
								{
									echo '<tr class="filaPrecio" id="filaPrecio'.$contPrecio.'">
										<td><button type="button" class="btn btn-danger" onclick="eliminarDetallePrecio(\''.$contPrecio.'\',\''.$reg->idPrecio.'\')">X</button>
										</td><td><input type="hidden" name="Sucursal_idSucursal[]" id="Sucursal_idSucursal[]" value="'.$reg->Sucursal_idSucursal.'">'.$reg->sn.'</td>
										</td><td><input type="hidden" name="GrupoPersona_idGrupoPersona[]" id="GrupoPersona_idGrupoPersona[]" value="'.$reg->GrupoPersona_idGrupoPersona.'">'.$reg->gpn.'</td>
										</td><td><input type="text" name="margen[]" id="margen[]" value="'.$reg->margen.'"></td>
										</td><td><input type="text" name="precio[]" id="precio[]" value="'.$reg->precio.'"></td>
										</td><td><input type="hidden" name="idPrecio[]" id="idPrecio[]" value="'.$reg->idPrecio.'"></td>';


									$contPrecio++;
									
								}
						echo '<tfoot>
				                       				<th>Opciones</th>
				                              		<th>Sucursal</th>
				                                    <th>Grupo Persona</th>
				                                    <th>Margen</th>
				                                    <th>Precio</th>
				                                </tfoot>';

	break;



	case 'listarDetalleMateriaPrima':
		//Recibimos el idingreso
		$idArticulo=$_GET['idArticulo'];

				$rspta = $articulo->listarDetalleMateriaPrima($idArticulo);
						echo '<thead style="background-color:#A9D0F5">
													<th>Opciones</th>
				                              		<th>Articulo</th>
				                                    <th>Canje</th>
				                                    <th>Cantidad</th>
				                                    <th>Compra</th>
				                                    <th>Venta</th>
				                                </thead>';  
				        $contMateriaPrima = 0;
						while ($reg = $rspta->fetchObject()) 
								{
									echo '<tr class="filaMateriaPrima" id="filaMateriaPrima'.$contMateriaPrima.'">
										<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleMateriaPrima(\''.$contMateriaPrima.'\',\''.$reg->idArticulo_Detalle.'\')">X</button>
										</td><td><input type="hidden" name="Articulo_idArticulo[]" id="Articulo_idArticulo[]" value="'.$reg->Articulo_idArticulo.'">'.$reg->sn.'</td>   
										</td><td><input type="hidden" name="Canje[]" id="Canje[]" value="'.$reg->canje.'">'.$reg->canje.'</td>
										</td><td><input type="text" name="cantidadMateriaPrima[]" id="cantidadMateriaPrima[]" value="'.$reg->cantidad.'"></td>
										</td><td><input type="text" name="compra_compraid[]" id="compra_compraid[]" value="'.$reg->afectaCompra.'"></td>
										</td><td><input type="text" name="venta_ventaid[]" id="venta_ventaid[]" value="'.$reg->afectaVenta.'"></td>
										</td><td><input type="hidden" name="idArticulo_Detalle[]" id="idArticulo_Detalle[]" value="'.$reg->idArticulo_Detalle.'"></td>';


									$contMateriaPrima++;
									
								}
						echo '<tfoot>
				                       				<th>Opciones</th>
				                              		<th>Articulo</th>
				                                    <th>Canje</th>
				                                    <th>Cantidad</th>
				                                    <th>Compra</th>
				                                    <th>Venta</th>
				                                </tfoot>';

	break;

	case 'listarDetalleArticuloProveedor':
		//Recibimos el idingreso
		$idArticulo=$_GET['idArticulo'];

				$rspta = $articulo->listarDetalleArticuloProveedor($idArticulo);
						echo '<thead style="background-color:#A9D0F5">
													<th>Opciones</th>
				                              		<th>Proveedor</th>
				                                    <th>Codigo SAP</th>
				                                    <th>Precio compra</th>
				                                    <th>Prioridad</th>
				                                    <th>Descontinuado?</th>
				                                </thead>';
				        $contProveedor = 0;
						while ($reg = $rspta->fetchObject())
								{

								if ($reg->descontinuado == 1) {
									$nd = 'SI';
								}else{
									$nd = 'NO';

								}


									echo '<tr class="filaProveedor" id="filaProveedor'.$contProveedor.'">
										<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleProveedor(\''.$contProveedor.'\',\''.$reg->idArticulo_Proveedor.'\')">X</button>
										</td><td><input type="hidden" name="Persona_idPersona_detalle[]" id="Persona_idPersona_detalle[]" value="'.$reg->Persona_idPersona.'">'.$reg->np.'</td>
										</td><td><input type="hidden" name="codigoProveedor_detalle[]" id="codigoProveedor_detalle[]" value="'.$reg->codigoProveedor.'">'.$reg->codigoProveedor.'</td>
										</td><td><input type="text" name="precioCompra_detalle[]" id="precioCompra_detalle[]" value="'.$reg->precioCompra.'"></td>
										</td><td><input type="text" name="prioridad_detalle[]" id="prioridad_detalle[]" value="'.$reg->prioridad.'"></td>
 										<td><select id="descontinuado_d1" name="descontinuado_d1" >
						                              <option value="1" selected>Si</option>
						                              <option value="2" selected>No</option>
						                            </select></td>
										</td><td><input type="hidden" name="idArticulo_Proveedor[]" id="idArticulo_Proveedor[]" value="'.$reg->idArticulo_Proveedor.'"></td>';
									$contProveedor++;
						
								}
						echo '<tfoot>
				                       				<th>Opciones</th>
				                              		<th>Sucursal</th>
				                                    <th>Grupo Persona</th>
				                                    <th>Precio</th>
				                                </tfoot>';

	break;






	case 'listarDetalleCodigoBarras':
		//Recibimos el idingreso
		$idArticulo=$_GET['idArticulo'];

				$rspta = $articulo->listarDetalleCodigoBarras($idArticulo);
						echo '<thead style="background-color:#A9D0F5">
													<th>Opciones</th>
				                              		<th>Unidad de Medida</th>
				                                    <th>Cantidad</th>
				                                    <th>Descripcion</th>
				                                    <th>Codigo de Barras</th>
				                                </thead>';
				        $contCodigoBarra = 0;
						while ($reg = $rspta->fetchObject())
								{
							echo '<tr class="filaCodigoBarra" id="filaCodigoBarra'.$contCodigoBarra.'">
									<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleCodigoBarra(\''.$contCodigoBarra.'\',\''.$reg->idarticulo_codigoBarra.'\')">X</button>
									</td><td><input type="hidden" name="Unidad_idUnidad_detalle[]" id="Unidad_idUnidad_detalle[]" value="'.$reg->Unidad_idUnidad.'">'.$reg->nu.'</td>
									</td><td><input type="hidden" name="cantidad_detalle[]" id="cantidad_detalle[]" value="'.$reg->descripcion.'">'.$reg->cantidadDefecto.'</td>
									</td><td><input type="hidden" name="descripcionCodigoBarra_detalle[]" id="descripcionCodigoBarra_detalle[]" value="'.$reg->descripcion.'">'.$reg->descripcion.'</td>
									</td><td><input type="text" name="codigoBarra_detalle[]" id="codigoBarra_detalle[]" value="'.$reg->codigoBarra.'"></td>
									</td><td><input type="hidden" name="idArticulo_Codigo[]" id="idArticulo_Codigo[]" value="'.$reg->idarticulo_codigoBarra.'"></td>';


									$contCodigoBarra++;
									
								}
						echo '<tfoot>
													<th>Opciones</th>
				                              		<th>Unidad de Medida</th>
				                                    <th>Cantidad</th>
				                                    <th>Descripcion</th>
				                                    <th>Codigo de Barras</th>
				                                </tfoot>';

 

	case 'listar':

		require 'serverside.php';

 
		$table_data->get('articulo_data','idArticulo',array('idArticulo','idArticulo','na','da','nprov','md','nga', 'codigoBarra','codigo','codigoAlternativo','tipoArticulo','NUC','NUV','comision', 'comisionp','TipoImpuesto_idTipoImpuesto','precioVenta','usuarioInsercion','imagen','descontinuado','idArticulo'));


	break;


	case 'listarOriginal':

		
		$rspta=$articulo->listarOriginal( $_GET['x'] );
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			if ($reg->ai) {
 				$ai = $reg->ai;
 			}else{
 				$ai = 'noimage.png';
 			}

 			$data[]=array(
 				"0"=>(!$reg->ea)?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idArticulo.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->idArticulo.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idArticulo.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary btn-xs" onclick="activar('.$reg->idArticulo.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->idArticulo,
 				"2"=>utf8_encode($reg->na),
 				"3"=>utf8_encode($reg->da),
 				"4"=>utf8_encode($reg->nprov),
 				"5"=>$reg->md,
 				"6"=>$reg->nga,
 				"7"=>$reg->codigoBarra,
 				"8"=>$reg->codigo,
 				"9"=>$reg->codigoAlternativo,
 				"10"=>$reg->tipoArticulo,
 				"11"=>$reg->NUC,
 				"12"=>$reg->NUV,
 				"13"=>number_format($reg->comision,0,',','.'),
 				"14"=>$reg->comisionp,
 				"15"=>$reg->TipoImpuesto_idTipoImpuesto,
 				"16"=>number_format($reg->precioVenta,0,',','.'),
 				"17"=>number_format($reg->stock,2,',','.'),
 				"18"=>$reg->usuarioInsercion,
 				"19"=>"<img src='../files/articulos/".$ai."' height='50px' width='50px' >",
 				"20"=>(!$reg->descontinuado)?
 				'<span class="label bg-green">No</span><input type="checkbox" id="cbox1" onclick="descontinuar(this,\''.$reg->idArticulo.'\');"> Descontinuar</label><br>':
 				'<span class="label bg-red">Si</span><input type="checkbox" id="cbox1" checked onclick="descontinuar(this,\''.$reg->idArticulo.'\');"> Continuar </label><br>',
 				"21"=>(!$reg->ea)?
 				'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>$_GET['sEcho'], //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;



	case "selectCategoria":
		require_once "../modelos/Categoria.php";
		$categoria = new Categoria();

		$rspta = $categoria->select();

		while ($reg = $rspta->fetchObject())
				{
					echo '<option value=' . $reg->idCategoria . '>' . $reg->nombre . '</option>';
				}
	break;

	case "selectCategoriaTodos":
		require_once "../modelos/Categoria.php";
		$categoria = new Categoria();

		$rspta = $categoria->select();
		echo '<option value="%%">Todos...</option>';	
		while ($reg = $rspta->fetchObject())
				{
					echo '<option value=' . $reg->idCategoria . '>' . $reg->nombre . '</option>';
				}
	break;


    
	case "selectCategoriaDetalle":
		require_once "../modelos/Categoria.php";
		$Categoria_idCategoria=$_GET['Categoria_idCategoria']; 
		$categoria = new Categoria(); 

		$rspta = $categoria->selectDetCat($Categoria_idCategoria);

		while ($reg = $rspta->fetchObject())  
				{
					echo '<option value=' . $reg->idCategoria . '>' . $reg->nombre . '</option>';
				}
	break;	 	

	case "selectGrupo":
		require_once "../modelos/GrupoArticulo.php";
		$grupo = new GrupoArticulo();

		$rspta = $grupo->select();

		while ($reg = $rspta->fetchObject())
				{
					echo '<option value=' . $reg->idGrupoArticulo . '>' . $reg->nombre . '</option>';
				}
	break;


	case "selectGrupoTodos":
		require_once "../modelos/GrupoArticulo.php";
		$grupo = new GrupoArticulo();

		$rspta = $grupo->select();
		echo '<option value="%%">Todos...</option>';	
		while ($reg = $rspta->fetchObject())
				{
					echo '<option value=' . $reg->idGrupoArticulo . '>' . $reg->nombre . '</option>';
				}
	break;	

	case "selectImpuesto":
		require_once "../modelos/TipoImpuesto.php";
		$impuesto = new TipoImpuesto();

		$rspta = $impuesto->select();

		while ($reg = $rspta->fetchObject())
				{
					echo '<option value=' . $reg->idTipoImpuesto . '>' . $reg->descripcion .  '</option>';
				}
	break;

	case "selectUnidad":
		require_once "../modelos/Unidad.php";
		$unidad = new Unidad();

		$rspta = $unidad->select();

		while ($reg = $rspta->fetchObject())
				{
					echo '<option value=' . $reg->idUnidad . '>' . $reg->descripcion . '</option>';
				}
	break;


	case "selectArticulos":

		$rspta = $articulo->selectArticulos();

		while ($reg = $rspta->fetchObject()) 
				{
					echo '<option value=' . $reg->idArticulo . '>' . $reg->nombre . '</option>';
				}
	break;	

	case "listarActivosProductosInternos":

		$rspta = $articulo->listarActivosProductosInternos();

		while ($reg = $rspta->fetchObject())
				{
					echo '<option value=' . $reg->idArticulo . '>' . $reg->nombre . '</option>';
				}
	break;

	case 'detalle':
		$idArticulo=$_REQUEST["idArticulo"];

		$rspta=$articulo->detalle($idArticulo);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			$data[]=array(
 				"0"=>$reg->nombre,
 				"1"=>$reg->cantidad,
 				"2"=>'<input type="text" class="input-sm" id="'.$reg->idpaqueteDetalle.'" ondblclick="refresh(this)" onblur="actualizarC(this, \''.$reg->idpaqueteDetalle.'\',\''.$reg->Articulo_idArticulo_Servicio.'\')" style="width:100%;" value="'.$reg->cantidad.'" /><font color = white></font>',
 				"3"=>number_format($reg->comision,0,',','.'),
 				"4"=>'<input type="text" class="input-sm" id="'.$reg->idpaqueteDetalle.'" ondblclick="refresh(this)" onblur="actualizarGs(this, \''.$reg->idpaqueteDetalle.'\',\''.$reg->Articulo_idArticulo_Servicio.'\')" style="width:100%;" value="'.$reg->comision.'" /><font color = white></font>',
 				"5"=>$reg->comisionp,
 				"6"=>'<input type="text" class="input-sm" id="'.$reg->idpaqueteDetalle.'" ondblclick="refresh(this)" onblur="actualizarP(this, \''.$reg->idpaqueteDetalle.'\',\''.$reg->Articulo_idArticulo_Servicio.'\')" style="width:100%;" value="'.$reg->comisionp.'" /><font color = white></font>',
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;


	case 'ajuste_actualizar_gs':
		$comision=$_REQUEST["comision"];
		$paquete=$_REQUEST["paquete"];
		$servicio=$_REQUEST["servicio"];

		$rspta=$articulo->ajuste_actualizar_gs($comision,$paquete,$servicio);
 		//Vamos a declarar un array
 		$data= Array();

 		/*
 		*/
	break;


	case 'ajuste_actualizar_p':
		$comisionP=$_REQUEST["comisionP"];
		$paquete=$_REQUEST["paquete"];
		$servicio=$_REQUEST["servicio"];

		$rspta=$articulo->ajuste_actualizar_p($comisionP,$paquete,$servicio);
 		//Vamos a declarar un array
 		$data= Array();

 		/*
		*/
	break;

	case 'ajuste_actualizar_c':
		$cantidad=$_REQUEST["cantidad"];
		$paquete=$_REQUEST["paquete"];
		$servicio=$_REQUEST["servicio"];

		$rspta=$articulo->ajuste_actualizar_c($cantidad,$paquete,$servicio);
 		//Vamos a declarar un array
 		$data= Array();

 		/*
		*/
	break;

	case 'listarActivosProductosInternos':
		require_once "../modelos/Articulo.php";
		$articulo=new Articulo();

		$rspta=$articulo->listarActivosProductosInternos();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idArticulo.',\''.$reg->na.'\',\''.$reg->precioVenta.'\',\''.$reg->pi.'\')"><span class="fa fa-plus"></span></button>',
 				"1"=>$reg->na,
 				"2"=>$reg->ad,
 				"3"=>$reg->cn,
 				"4"=>$reg->codigoBarra,
 				"5"=>$reg->precioVenta,
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


	case 'validarCodigo':
		$rspta=$articulo->validarCodigo($_POST['codigo']);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'validarCodigoBarra':
		$rspta=$articulo->validarCodigoBarra($_POST['codigo']);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;


}
?>