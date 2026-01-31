<?php 
require_once "../modelos/Articulo.php";
session_start();
$articulo=new Articulo();

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
				$rspta=$articulo->insertar($CuentaContable_idCuentaContable,  strtoupper($nombre),strtoupper($descripcion),$codigo,$codigoBarra,$codigoAlternativo,$tipoArticulo,$GrupoArticulo_idGrupoArticulo,$Categoria_idCategoria,$Categoria_idCategoriaPadre,$TipoImpuesto_idTipoImpuesto,$Unidad_idUnidad,$Unidad_idUnidadCompra,$precioVenta,$usuarioInsercion,$imagen, $comisionp, $comisiongs , $Persona_idPersona,$Marca_idMarca, $cantidadCaja,$pesoBruto,$pesoLiquido,$cantidadPiso,$cantidadPalet,$regimenTurismo,$balanza,$ventasKl,$costo, $_POST["idarticulo"], $_POST["idarticulon"], $_POST["cantidad"], $_POST["comisionpp"],$_POST["comisiongsp"],$_POST["Sucursal_idSucursal"],$_POST["GrupoPersona_idGrupoPersona"],$_POST["precio"],$_POST["margen"],$_POST["Persona_idPersona_detalle"], $_POST["prioridad_detalle"], $_POST["codigoProveedor_detalle"],$_POST["descontinuado_detalle"],$_POST["precioCompra_detalle"],$_POST["idArticulo_Proveedor"], $_POST['codigoBarra_detalle'], $_POST['descripcionCodigoBarra_detalle'], $_POST['Unidad_idUnidad_detalle'],
					$_POST['Articulo_idArticulop'], $_POST['Canje'], $_POST['cantidadMateriaPrima']);
				echo $rspta ? "Artículo registrado" : "Artículo no se pudo registrar";
			}else{
				$rspta=$articulo->insertar($CuentaContable_idCuentaContable,$nombre,$descripcion,$codigo,$codigoBarra,$codigoAlternativo,$tipoArticulo,$GrupoArticulo_idGrupoArticulo,$Categoria_idCategoria,$Categoria_idCategoriaPadre,$TipoImpuesto_idTipoImpuesto,$Unidad_idUnidad,$Unidad_idUnidadCompra,$precioVenta,$usuarioInsercion,$imagen, $comisionp, $comisiongs, $Persona_idPersona,$Marca_idMarca, $cantidadCaja,$pesoBruto,$pesoLiquido,$cantidadPiso,$cantidadPalet,$regimenTurismo,$balanza,$ventasKl, $costo ,0, 0, 0, 0,0,$_POST["Sucursal_idSucursal"],$_POST["GrupoPersona_idGrupoPersona"],$_POST["precio"],$_POST["margen"],$_POST["Persona_idPersona_detalle"], $_POST["prioridad_detalle"], $_POST["codigoProveedor_detalle"],$_POST["descontinuado_detalle"],$_POST["precioCompra_detalle"],$_POST["idArticulo_Proveedor"], $_POST['codigoBarra_detalle'], $_POST['descripcionCodigoBarra_detalle'], $_POST['Unidad_idUnidad_detalle'],
			$_POST['Articulo_idArticulop'], $_POST['Canje'], $_POST['cantidadMateriaPrima']);
				echo $rspta ? "Artículo registrado" : "Artículo no se pudo registrar";				
			}
		}
		else {
			$codigoBarra_detalle = isset($_POST['codigoBarra_detalle']) ? $_POST['codigoBarra_detalle'] : array();
			$descripcionCodigoBarra_detalle = isset($_POST['descripcionCodigoBarra_detalle']) ? $_POST['descripcionCodigoBarra_detalle'] : array();
			$Unidad_idUnidad_detalle = isset($_POST['Unidad_idUnidad_detalle']) ? $_POST['Unidad_idUnidad_detalle'] : array();
			$cantidad_detalle = isset($_POST['cantidad_detalle']) ? $_POST['cantidad_detalle'] : array();
			$idArticulo_Codigo = isset($_POST['idArticulo_Codigo']) ? $_POST['idArticulo_Codigo'] : array();
			$rspta=$articulo->editar($CuentaContable_idCuentaContable,$idArticulo, $nombre,$descripcion,$codigo,$codigoBarra,$codigoAlternativo,$tipoArticulo,$GrupoArticulo_idGrupoArticulo,$Categoria_idCategoria,$Categoria_idCategoriaPadre,$TipoImpuesto_idTipoImpuesto,$Unidad_idUnidad,$Unidad_idUnidadCompra,$precioVenta,$usuarioModificacion,$imagen,$comisiongs,$comisionp, $Persona_idPersona,$Marca_idMarca,$cantidadCaja,$pesoBruto,$pesoLiquido,$cantidadPiso,$cantidadPalet,$regimenTurismo,$balanza,$ventasKl,$costo,$_POST["Sucursal_idSucursal"],$_POST["GrupoPersona_idGrupoPersona"],$_POST["precio"],$_POST["margen"],$_POST["idPrecio"],$_POST["Persona_idPersona_detalle"], $_POST["prioridad_detalle"], $_POST["codigoProveedor_detalle"],$_POST["descontinuado_detalle"],$_POST["precioCompra_detalle"],$_POST["idArticulo_Proveedor"],$_POST['Articulo_idArticulop'], $_POST['Canje'], $_POST['cantidadMateriaPrima'],$_POST["idArticulo_Detalle"], $codigoBarra_detalle, $descripcionCodigoBarra_detalle, $Unidad_idUnidad_detalle, $cantidad_detalle, $idArticulo_Codigo);
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
				                                </thead>';  
				        $contMateriaPrima = 0;
						while ($reg = $rspta->fetchObject()) 
								{
									echo '<tr class="filaMateriaPrima" id="filaMateriaPrima'.$contMateriaPrima.'">
										<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleMateriaPrima(\''.$contMateriaPrima.'\',\''.$reg->idArticulo_Detalle.'\')">X</button>
										</td><td><input type="hidden" name="Articulo_idArticulop[]" id="Articulo_idArticulop[]" value="'.$reg->Articulo_idArticulo.'">'.$reg->sn.'</td>   
										</td><td><input type="hidden" name="Canje[]" id="Canje[]" value="'.$reg->canje.'">'.$reg->canje.'</td>
										</td><td><input type="text" name="cantidadMateriaPrima[]" id="cantidadMateriaPrima[]" value="'.$reg->cantidad.'"></td>
										</td><td><input type="hidden" name="idArticulo_Detalle[]" id="idArticulo_Detalle[]" value="'.$reg->idArticulo_Detalle.'"></td>';


									$contMateriaPrima++;
									
								}
						echo '<tfoot>
				                       				<th>Opciones</th>
				                              		<th>Articulo</th>
				                                    <th>Canje</th>
				                                    <th>Cantidad</th>
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
		//Recibimos el idArticulo
		$idArticulo = isset($_GET['idArticulo']) ? $_GET['idArticulo'] : '';

		$rspta = $articulo->listarDetalleCodigoBarras($idArticulo);
		$contCodigoBarra = 0;

		// Solo generar filas del tbody (sin thead ni tfoot). Si la consulta falló, $rspta puede ser false
		if ($rspta !== false) {
			while ($reg = $rspta->fetchObject())
		{
			echo '<tr class="filaCodigoBarra" id="filaCodigoBarra'.$contCodigoBarra.'">
					<td>
						<button type="button" class="btn btn-danger btn-xs" onclick="eliminarDetalleCodigoBarra(\''.$contCodigoBarra.'\',\''.$reg->idarticulo_codigoBarra.'\')" title="Eliminar">
							<i class="fa fa-trash"></i>
						</button>
					</td>
					<td>
						<input type="hidden" name="Unidad_idUnidad_detalle[]" value="'.$reg->Unidad_idUnidad.'">
						<strong>'.htmlspecialchars($reg->nu).'</strong>
					</td>
					<td>
						<input type="hidden" name="cantidad_detalle[]" value="'.$reg->cantidadDefecto.'">
						'.htmlspecialchars($reg->cantidadDefecto).'
					</td>
					<td>
						<input type="hidden" name="descripcionCodigoBarra_detalle[]" value="'.htmlspecialchars($reg->descripcion).'">
						'.htmlspecialchars($reg->descripcion).'
					</td>
					<td>
						<input type="text" name="codigoBarra_detalle[]" class="form-control input-sm" value="'.htmlspecialchars($reg->codigoBarra).'" placeholder="Código de barras">
						<input type="hidden" name="idArticulo_Codigo[]" value="'.$reg->idarticulo_codigoBarra.'">
					</td>
				</tr>';
			$contCodigoBarra++;
			}
		}

		// Si no hay registros, mostrar mensaje
		if ($contCodigoBarra == 0) {
			echo '<tr><td colspan="5" class="text-center text-muted"><i class="fa fa-info-circle"></i> No hay códigos de barras registrados</td></tr>';
		}
	break;










	case 'listar':

		require 'serverside.php';
 
		$table_data->get('articulo_data','idArticulo',array('idArticulo','idArticulo','na','da','nprov','md','nga', 'codigoBarra','codigo','codigoAlternativo','tipoArticulo','NUC','NUV','comision', 'comisionp','TipoImpuesto_idTipoImpuesto','precioVenta','usuarioInsercion','imagen','descontinuado','idArticulo'));


	break;


	case 'listarOriginal':
		$x = isset($_GET['x']) ? $_GET['x'] : '';
		$rspta = $articulo->listarOriginal($x);
		$data = array();
		if (!$rspta) {
			echo json_encode(array("sEcho" => 1, "iTotalRecords" => 0, "iTotalDisplayRecords" => 0, "aaData" => array()));
			break;
		}
		while ($reg = $rspta->fetchObject()) {
			if ($reg->ai) {
				$ai = $reg->ai;
			}else{
				$ai = 'noimage.png';
			}

			// Botones de acción mejorados
			$botonesAccion = '';
			if (!$reg->ea) {
				$botonesAccion = '<div class="btn-group-vertical btn-group-sm" role="group">
					<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idArticulo.')" title="Editar">
						<i class="fa fa-pencil"></i>
					</button>
					<button class="btn btn-danger btn-sm" onclick="desactivar('.$reg->idArticulo.')" title="Desactivar">
						<i class="fa fa-close"></i>
					</button>
				</div>';
			} else {
				$botonesAccion = '<div class="btn-group-vertical btn-group-sm" role="group">
					<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idArticulo.')" title="Editar">
						<i class="fa fa-pencil"></i>
					</button>
					<button class="btn btn-primary btn-sm" onclick="activar('.$reg->idArticulo.')" title="Activar">
						<i class="fa fa-check"></i>
					</button>
				</div>';
			}

			// Imagen mejorada con estilo profesional
			$imagen = '<div class="articulo-imagen-container">
				<img src="../files/articulos/'.$ai.'" 
					 class="articulo-imagen" 
					 alt="'.htmlspecialchars($reg->na).'"
					 onerror="this.src=\'../files/articulos/noimage.png\'">
			</div>';

			// Botón de precios (precio por artículo y categoría)
			$botonPrecios = '<button class="btn btn-info btn-sm btn-block" 
								onclick="mostrarDetallePrecio('.$reg->idArticulo.')" 
								title="Precios por artículo y categoría">
								<i class="fa fa-dollar-sign"></i> Precios
							</button>';

			// Estado mejorado
			$estado = (!$reg->ea) ? 
				'<span class="label label-success"><i class="fa fa-check-circle"></i> Activo</span>' : 
				'<span class="label label-danger"><i class="fa fa-times-circle"></i> Inactivo</span>';

			// Descontinuado mejorado
			$descontinuado = (!$reg->descontinuado) ?
				'<span class="label label-success">No</span><br>
				 <label class="checkbox-inline" style="margin-top:5px;">
					<input type="checkbox" onclick="descontinuar(this,\''.$reg->idArticulo.'\');"> Descontinuar
				 </label>' :
				'<span class="label label-danger">Sí</span><br>
				 <label class="checkbox-inline" style="margin-top:5px;">
					<input type="checkbox" checked onclick="descontinuar(this,\''.$reg->idArticulo.'\');"> Continuar
				 </label>';

			// Array con índices numéricos para que DataTables reciba columnas en orden (0=Acciones, 1=ID, ... 22=Estado)
			$orden_val = isset($reg->orden) ? $reg->orden : '';
			$data[] = array(
				$botonesAccion,
				'<strong>'.$reg->idArticulo.'</strong><br><input type="text" class="form-control input-sm" id="'.$reg->idArticulo.'" ondblclick="refresh(this)" onblur="actualizarOrden(this, \''.$reg->idArticulo.'\')" style="width:100%; margin-top:5px;" value="'.htmlspecialchars($orden_val).'" placeholder="Orden">',
				'<strong>'.htmlspecialchars($reg->na).'</strong>',
				htmlspecialchars($reg->da ? $reg->da : '-'),
				$botonPrecios,
				htmlspecialchars($reg->nprov ? $reg->nprov : '-'),
				htmlspecialchars($reg->md ? $reg->md : '-'),
				htmlspecialchars($reg->nga ? $reg->nga : '-'),
				'<code>'.htmlspecialchars($reg->codigoBarra ? $reg->codigoBarra : '-').'</code>',
				'<code>'.htmlspecialchars($reg->codigo ? $reg->codigo : '-').'</code>',
				'<code>'.htmlspecialchars($reg->codigoAlternativo ? $reg->codigoAlternativo : '-').'</code>',
				'<span class="label label-default">'.htmlspecialchars($reg->tipoArticulo).'</span>',
				htmlspecialchars($reg->NUC ? $reg->NUC : '-'),
				htmlspecialchars($reg->NUV ? $reg->NUV : '-'),
				number_format($reg->comision,0,',','.'),
				$reg->comisionp ? $reg->comisionp.'%' : '-',
				htmlspecialchars($reg->TipoImpuesto_idTipoImpuesto ? $reg->TipoImpuesto_idTipoImpuesto : '-'),
				'<strong class="text-success">'.number_format($reg->precioVenta,0,',','.').'</strong>',
				'<span class="badge badge-info">'.number_format($reg->stock,2,',','.').'</span>',
				htmlspecialchars($reg->usuarioInsercion ? $reg->usuarioInsercion : '-'),
				$imagen,
				$descontinuado,
				$estado
			);
		}
 		$sEcho = isset($_GET['sEcho']) ? (int)$_GET['sEcho'] : 1;
 		$results = array(
 			"sEcho" => $sEcho,
 			"iTotalRecords" => count($data),
 			"iTotalDisplayRecords" => count($data),
 			"aaData" => $data
 		);
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

	case "selectArticulosTodos":

		$rspta = $articulo->selectArticulos();
		echo '<option value="%%">Todos...</option>';

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



	case 'actualizarOrden':
		$id=$_REQUEST["id"];
		$orden=$_REQUEST["orden"];


		$rspta=$articulo->actualizarOrden($id,$orden);
 		//Vamos a declarar un array
 		$data= Array();

 		/*
 		*/
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

	case 'kpisResumen':
		$total_articulos = 0;
		$total_activos = 0;
		$stock_total = 0;
		$sin_stock = 0;
		$rspta = @ejecutarConsulta("SELECT idArticulo, inactivo FROM articulo");
		if ($rspta) {
			while ($reg = $rspta->fetchObject()) {
				$total_articulos++;
				if (isset($reg->inactivo) && $reg->inactivo == 0) $total_activos++;
			}
		}
		$rs = @ejecutarConsulta("SELECT SUM(cantidad) as total_stock FROM stock");
		if ($rs && ($r = $rs->fetchObject())) $stock_total = (float)($r->total_stock ?: 0);
		$rs = @ejecutarConsulta("SELECT COUNT(*) as total FROM (SELECT a.idArticulo FROM articulo a LEFT JOIN stock s ON a.idArticulo = s.Articulo_idArticulo WHERE a.inactivo = 0 GROUP BY a.idArticulo HAVING COALESCE(SUM(s.cantidad),0)=0) t");
		if ($rs && ($r = $rs->fetchObject())) $sin_stock = (int)($r->total ?: 0);
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode(array('total_articulos' => $total_articulos, 'total_activos' => $total_activos, 'stock_total' => $stock_total, 'sin_stock' => $sin_stock));
	break;

	case 'kpisCategorias':
		$labels = array();
		$data = array();
		$rspta = @ejecutarConsulta("
			SELECT c.nombre, COUNT(a.idArticulo) as cantidad
			FROM categoria c
			LEFT JOIN articulo a ON c.idCategoria = a.Categoria_idCategoria AND a.inactivo = 0
			WHERE c.inactivo = 0
			GROUP BY c.idCategoria, c.nombre
			ORDER BY cantidad DESC
		");
		if ($rspta) {
			while ($reg = $rspta->fetchObject()) {
				$labels[] = $reg->nombre;
				$data[] = (int)$reg->cantidad;
			}
		}
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode(array('labels' => $labels, 'data' => $data));
	break;

	case 'kpisVentas':
		$desde = isset($_GET['desde']) ? $_GET['desde'] : date('Y-m-d', strtotime('-30 days'));
		$hasta = isset($_GET['hasta']) ? $_GET['hasta'] : date('Y-m-d');
		$top_labels = array();
		$top_cantidad = array();
		$top_total = array();
		$dia_labels = array();
		$dia_cantidad = array();
		$dia_total = array();
		
		$rspta_top = @ejecutarConsulta("
			SELECT a.nombre, SUM(dv.cantidad) as cantidad_vendida, SUM(dv.total) as total_vendido
			FROM detalleventa dv
			JOIN venta v ON dv.Venta_idVenta = v.idVenta
			JOIN articulo a ON dv.Articulo_idArticulo = a.idArticulo
			WHERE DATE(v.fecha_hora) BETWEEN '".addslashes($desde)."' AND '".addslashes($hasta)."'
			GROUP BY a.idArticulo, a.nombre
			ORDER BY cantidad_vendida DESC
			LIMIT 10
		");
		if ($rspta_top) {
			while($reg = $rspta_top->fetchObject()) {
				$top_labels[] = substr($reg->nombre, 0, 20) . (strlen($reg->nombre) > 20 ? '...' : '');
				$top_cantidad[] = (float)$reg->cantidad_vendida;
				$top_total[] = (float)$reg->total_vendido;
			}
		}
		
		$rspta_dia = @ejecutarConsulta("
			SELECT DATE(v.fecha_hora) as fecha, SUM(dv.cantidad) as cantidad, SUM(dv.total) as total
			FROM detalleventa dv
			JOIN venta v ON dv.Venta_idVenta = v.idVenta
			WHERE DATE(v.fecha_hora) BETWEEN '".addslashes($desde)."' AND '".addslashes($hasta)."'
			GROUP BY DATE(v.fecha_hora)
			ORDER BY fecha ASC
		");
		if ($rspta_dia) {
			while($reg = $rspta_dia->fetchObject()) {
				$dia_labels[] = date('d/m', strtotime($reg->fecha));
				$dia_cantidad[] = (float)$reg->cantidad;
				$dia_total[] = (float)$reg->total;
			}
		}
		
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode(array(
			'top_labels' => $top_labels,
			'top_cantidad' => $top_cantidad,
			'top_total' => $top_total,
			'dia_labels' => $dia_labels,
			'dia_cantidad' => $dia_cantidad,
			'dia_total' => $dia_total
		));
	break;

	case 'kpisBajoStock':
		$rspta = @ejecutarConsulta("
			SELECT a.idArticulo, a.nombre, COALESCE(SUM(s.cantidad), 0) as stock
			FROM articulo a
			LEFT JOIN stock s ON a.idArticulo = s.Articulo_idArticulo
			WHERE a.inactivo = 0
			GROUP BY a.idArticulo, a.nombre
			HAVING COALESCE(SUM(s.cantidad), 0) < 10
			ORDER BY stock ASC
			LIMIT 20
		");
		
		$hay_datos = false;
		if ($rspta) {
		while($reg = $rspta->fetchObject()) {
			$hay_datos = true;
			$estado_class = $reg->stock == 0 ? 'danger' : 'warning';
			$estado_badge = $reg->stock == 0 ? 'red' : 'yellow';
			$estado_text = $reg->stock == 0 ? 'Sin Stock' : 'Bajo Stock';
			echo '<tr class="'.$estado_class.'">';
			echo '<td>'.htmlspecialchars($reg->nombre).'</td>';
			echo '<td><span class="badge bg-'.$estado_badge.'">'.number_format($reg->stock, 2, ',', '.').'</span></td>';
			echo '<td><span class="label label-'.$estado_class.'">'.$estado_text.'</span></td>';
			echo '</tr>';
		}
		}
		if (!$hay_datos) {
			echo '<tr><td colspan="3" class="text-center text-muted"><i class="fa fa-check-circle"></i> No hay artículos con bajo stock</td></tr>';
		}
	break;

	case 'kpisSinMovimiento':
		$dias = isset($_GET['dias']) ? (int)$_GET['dias'] : 90;
		$rspta = @ejecutarConsulta("
			SELECT a.idArticulo, a.nombre, a.precioVenta, COALESCE(SUM(s.cantidad), 0) as stock
			FROM articulo a
			LEFT JOIN detalleventa dv ON a.idArticulo = dv.Articulo_idArticulo
			LEFT JOIN venta v ON dv.Venta_idVenta = v.idVenta AND v.fecha_hora >= DATE_SUB(NOW(), INTERVAL ".(int)$dias." DAY)
			LEFT JOIN stock s ON a.idArticulo = s.Articulo_idArticulo
			WHERE a.inactivo = 0 AND v.idVenta IS NULL
			GROUP BY a.idArticulo, a.nombre, a.precioVenta
			ORDER BY a.nombre
			LIMIT 20
		");
		
		$hay_datos = false;
		if ($rspta) {
		while($reg = $rspta->fetchObject()) {
			$hay_datos = true;
			echo '<tr>';
			echo '<td>'.htmlspecialchars($reg->nombre).'</td>';
			echo '<td><strong>'.number_format($reg->precioVenta, 0, ',', '.').'</strong></td>';
			echo '<td><span class="badge bg-info">'.number_format($reg->stock, 2, ',', '.').'</span></td>';
			echo '</tr>';
		}
		}
		if (!$hay_datos) {
			echo '<tr><td colspan="3" class="text-center text-muted"><i class="fa fa-check-circle"></i> Todos los artículos tienen movimiento</td></tr>';
		}
	break;

	case 'exportarKPIs':
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename="kpis_articulos_'.date('Y-m-d').'.xls"');
		
		echo '<table border="1">';
		echo '<tr><th colspan="3">KPIs de Artículos - '.date('d/m/Y').'</th></tr>';
		echo '<tr><th>Métrica</th><th>Valor</th></tr>';
		
		$rspta_total = $articulo->listarActivos();
		$total_articulos = 0;
		$total_activos = 0;
		while($reg = $rspta_total->fetchObject()) {
			$total_articulos++;
			if ($reg->inactivo == 0) $total_activos++;
		}
		
		$rspta_stock = ejecutarConsulta("SELECT SUM(cantidad) as total_stock FROM stock");
		$stock_total = 0;
		if ($reg_stock = $rspta_stock->fetchObject()) {
			$stock_total = $reg_stock->total_stock ? $reg_stock->total_stock : 0;
		}
		
		echo '<tr><td>Total de Artículos</td><td>'.$total_articulos.'</td></tr>';
		echo '<tr><td>Artículos Activos</td><td>'.$total_activos.'</td></tr>';
		echo '<tr><td>Stock Total</td><td>'.number_format($stock_total, 2, ',', '.').'</td></tr>';
		echo '</table>';
	break;


}
?>