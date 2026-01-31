<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Articulo
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	} 

	//Implementamos un método para insertar registros
	public function insertar($CuentaContable_idCuentaContable,$nombre,$descripcion,$codigo,$codigoBarra,$codigoAlternativo,$tipoArticulo,$GrupoArticulo_idGrupoArticulo,$Categoria_idCategoria,$Categoria_idCategoriaPadre,$TipoImpuesto_idTipoImpuesto,$Unidad_idUnidad,$Unidad_idUnidadCompra,$precioVenta,$usuarioInsercion,$imagen, $comisionp, $comisiongs ,$Persona_idPersona,$Marca_idMarca,$cantidadCaja,$pesoBruto,$pesoLiquido,$cantidadPiso,$cantidadPalet,$regimenTurismo,$balanza,$ventasKl,$costo, $idarticulo, $idarticulon , $cantidad, $comisionpp,$comisiongsp, $Sucursal_idSucursal, $GrupoPersona_idGrupoPersona, $precio,$margen,$Persona_idPersona_detalle, $prioridad, $codigoProveedor,$descontinuado,$precioCompra, $idArticulo_Proveedor, $codigoBarra_detalle, $descripcionCodigoBarra_detalle, $Unidad_idUnidad_detalle
		,$Articulo_idArticulo, $Canje, $cantidadMateriaPrima )
	{

		//comision = comision por servicoio tecnico y comisionp = comision por venta

		$precioVenta= str_replace('.','',$precioVenta);
		$comisiongs= str_replace('.','',$comisiongs);

		$sql="INSERT INTO `articulo`
									(`nombre`,
									`descripcion`,
									`codigo`,
									`codigoAlternativo`,
									`tipoArticulo`,
									`CuentaContable_idCuentaContable`,
									`GrupoArticulo_idGrupoArticulo`,
									`Categoria_idCategoria`,
									`Categoria_idCategoriaPadre`,
									`TipoImpuesto_idTipoImpuesto`,
									`precioVenta`,
									`usuarioInsercion`,
									`inactivo`,
									`imagen`,
									`comisionp`,
									`comision`,
									`Persona_idPersona`,
									`Marca_idMarca`,
									`cantidadCaja`,
									`pesoBruto`,
									`pesoLiquido`,
									`cantidadPiso`,
									`cantidadPalet`,
									`regimenTurismo`,
									`balanza`,
									`ventasKl`,
									`costo`
									)
									VALUES
									(UPPER('$nombre'),
									UPPER('$descripcion'),
									'$codigo',
									'$codigoAlternativo',
									'$tipoArticulo',
									'$CuentaContable_idCuentaContable',
									'$GrupoArticulo_idGrupoArticulo',
									'$Categoria_idCategoria',
									'$Categoria_idCategoriaPadre',
									'$TipoImpuesto_idTipoImpuesto',
									'$precioVenta',
									'$usuarioInsercion',
									0,
									'$imagen',
									'$comisionp',
									'$comisiongs',
									'$Persona_idPersona',
									'$Marca_idMarca',
									'$cantidadCaja',
									'$pesoBruto',
									'$pesoLiquido',
									'$cantidadPiso',
									'$cantidadPalet',
									'$regimenTurismo',
									'$balanza',
									'$ventasKl',
									'$costo'
								)";


		$id=ejecutarConsulta_retornarID($sql);

		$num_elementos=0;
		if ($id>0) {
		$sw=true;
		}else{
		$sw=false;
		}

 

		if ( is_array( $precio ) && $id > 0 ) {

				while ($num_elementos < count($precio))
				{

					$sql_detalle = "INSERT INTO `precio`
									(
										`Articulo_idArticulo`,
										`Sucursal_idSucursal`,
										`GrupoPersona_idGrupoPersona`,
										`margen`,
										`precio`,
										`inactivo`,
										`UsuarioIns`
									)
								
									VALUES
									(
										'$id',
										'$Sucursal_idSucursal[$num_elementos]',
										'$GrupoPersona_idGrupoPersona[$num_elementos]',
										'$margen[$num_elementos]',
										'$precio[$num_elementos]',
										0, 
										'$usuarioInsercion'
									)";
					ejecutarConsulta($sql_detalle) or $sw = false;
					$num_elementos=$num_elementos + 1;
				}

		}


		if ( is_array( $Canje ) && $sw = true  ) {

				$num_elementos=0;

				while ($num_elementos < count($Canje))
				{

					if ( $cantidadMateriaPrima[$num_elementos] > 0 ) {

						$sql_detalle = "INSERT INTO `detallearticulo`
										(
											`Articulo_idArticulo`,
											`Articulo_idArticuloDet`,
											`canje`,
											`cantidad`,
											`inactivo`,
											`usuarioInsercion`
										)
									
										VALUES
										(
											'$id',  
											'$Articulo_idArticulo[$num_elementos]',
											'$Canje[$num_elementos]',
											'$cantidadMateriaPrima[$num_elementos]',
											0, 
											'$usuarioInsercion'
										)";
						ejecutarConsulta($sql_detalle) or $sw = false;
						$num_elementos=$num_elementos + 1;   
					}	
				}

		}  

		if ( is_array( $idArticulo_Proveedor ) && $sw = true ) {

				$num_elementos=0;
				

				while ($num_elementos < count($idArticulo_Proveedor))
				{

											$sql_detalle = "INSERT INTO `articulo_proveedor`
															(
																`Articulo_idArticulo`,
																`Persona_idPersona`,
																`prioridad`,
																`codigoProveedor`,
																`descontinuado`,
																`precioCompra`
															)
															VALUES
															(
																'$id',
																'$Persona_idPersona_detalle[$num_elementos]',
																'$prioridad[$num_elementos]',
																'$codigoProveedor[$num_elementos]',
																'$descontinuado[$num_elementos]',
																'$precioCompra[$num_elementos]'
															)";
					ejecutarConsulta($sql_detalle) or $sw = false;
					$num_elementos=$num_elementos + 1;
				}

		}



		if ( is_array( $descripcionCodigoBarra_detalle ) && $sw = true ) {

				$num_elementos=0;
				

				while ($num_elementos < count($descripcionCodigoBarra_detalle))
				{

											$sql_detalle = "INSERT INTO `articulo_codigobarra`
															(
																`Articulo_idArticulo`,
																`codigoBarra`,
																`descripcion`,
																`Unidad_idUnidad`
															)
															VALUES
															(
																'$id',
																'$codigoBarra_detalle[$num_elementos]',
																'$descripcionCodigoBarra_detalle[$num_elementos]',
																'$Unidad_idUnidad_detalle[$num_elementos]'
															)";
					ejecutarConsulta($sql_detalle) or $sw = false;
					$num_elementos=$num_elementos + 1;
				}

		}


		return $sw;


	}

	//Implementamos un método para editar registros
	public function editar($CuentaContable_idCuentaContable,$idArticulo, $nombre,$descripcion,$codigo,$codigoBarra,$codigoAlternativo,$tipoArticulo,$GrupoArticulo_idGrupoArticulo,$Categoria_idCategoria,$Categoria_idCategoriaPadre,$TipoImpuesto_idTipoImpuesto,$Unidad_idUnidad,$Unidad_idUnidadCompra,$precioVenta,$usuarioModificacion,$imagen,$comisiongs,$comisionp,$Persona_idPersona,$Marca_idMarca,$cantidadCaja,$pesoBruto,$pesoLiquido,$cantidadPiso,$cantidadPalet,$regimenTurismo,$balanza,$ventasKl,$costo,$Sucursal_idSucursal, $GrupoPersona_idGrupoPersona, $precio,$margen,$idPrecio,$Persona_idPersona_detalle, $prioridad, $codigoProveedor,$descontinuado,$precioCompra, $idArticulo_Proveedor, 
		$Articulo_idArticulo, $Canje, $cantidadMateriaPrima, $idArticulo_Detalle, $codigoBarra_detalle = array(), $descripcionCodigoBarra_detalle = array(), $Unidad_idUnidad_detalle = array(), $cantidad_detalle = array(), $idArticulo_Codigo = array() )
	{ 
		$sw=true;

		$usuario = $_SESSION['login'];

		$precioVenta= str_replace('.','',$precioVenta);
		$comisiongs= str_replace('.','',$comisiongs);
		$sql="UPDATE `articulo`
									SET
									`nombre` = UPPER('$nombre'),
									`descripcion` = UPPER('$descripcion'),
									`codigo` = '$codigo',
									`codigoBarra` = '$codigoBarra',
									`codigoAlternativo` = '$codigoAlternativo',
									`tipoArticulo` = '$tipoArticulo',
									`CuentaContable_idCuentaContable` = '$CuentaContable_idCuentaContable',
									`GrupoArticulo_idGrupoArticulo` = '$GrupoArticulo_idGrupoArticulo',
									`Categoria_idCategoria` = '$Categoria_idCategoria',
									`Categoria_idCategoriaPadre` = '$Categoria_idCategoriaPadre',
									`TipoImpuesto_idTipoImpuesto` = '$TipoImpuesto_idTipoImpuesto',
									`Unidad_idUnidad` = '$Unidad_idUnidad',
									`Unidad_idUnidadCompra` = '$Unidad_idUnidadCompra',
									`precioVenta` = '$precioVenta',
									`fechaModificacion` = now(),
									`usuarioModificacion` = '$usuario',
									`imagen` = '$imagen',
									`comision` = '$comisiongs',
									`Persona_idPersona` = '$Persona_idPersona',
									`Marca_idMarca` = '$Marca_idMarca',
									`comisionp` = '$comisionp',
									`cantidadCaja` = '$cantidadCaja',
									`pesoBruto` = '$pesoBruto',
									`pesoLiquido` = '$pesoLiquido',
									`cantidadPiso` = '$cantidadPiso',
									`cantidadPalet` = '$cantidadPalet',
									`regimenTurismo` = '$regimenTurismo',
									`balanza` = '$balanza',
									`ventasKl` = '$ventasKl',
									`costo` = '$costo'
									WHERE `idArticulo` = '$idArticulo';
									";
		ejecutarConsulta($sql) or $sw = false;


		$num_elementos=0;
		//$sw=true;

if ( is_array( $precio ) && $sw = true ) {
					while ($num_elementos < count($precio))
					{
						if ($idPrecio[$num_elementos] == 0) {
									$sql_detalle = "INSERT INTO `precio`
													(
														`Articulo_idArticulo`,
														`Sucursal_idSucursal`,
														`GrupoPersona_idGrupoPersona`,
														`margen`,
														`precio`,
														`inactivo`,
														`UsuarioIns`
													)
													VALUES
													(
														'$idArticulo',
														'$Sucursal_idSucursal[$num_elementos]',
														'$GrupoPersona_idGrupoPersona[$num_elementos]',
														'$margen[$num_elementos]',
														'$precio[$num_elementos]',
														0, 
														'$usuario'
													)";
							ejecutarConsulta($sql_detalle) or $sw = false;
							$num_elementos=$num_elementos + 1;
				

						}else{

							$sql_detalle = "UPDATE `precio`	SET
												`Sucursal_idSucursal` = '$Sucursal_idSucursal[$num_elementos]',
												`GrupoPersona_idGrupoPersona` = '$GrupoPersona_idGrupoPersona[$num_elementos]',
												`margen` = '$margen[$num_elementos]', 
												`usuarioMod` = '$usuario', 
												`precio` = '$precio[$num_elementos]' 
												WHERE `idPrecio` = '$idPrecio[$num_elementos]'";
							ejecutarConsulta($sql_detalle) or $sw = false;
				

							$num_elementos=$num_elementos + 1;
						}
					}
		}
		
		$num_elementos=0;
		//$sw=true;
if ( is_array( $idArticulo_Proveedor ) && $sw = true ) {
				
					while ($num_elementos < count($idArticulo_Proveedor))
					{
						if ($idArticulo_Proveedor[$num_elementos] == 0) {
									$sql_detalle = "INSERT INTO `articulo_proveedor`
													(
														`Articulo_idArticulo`,
														`Persona_idPersona`,
														`prioridad`,
														`codigoProveedor`,
														`descontinuado`,
														`precioCompra`
													)
													VALUES
													(
														'$idArticulo',
														'$Persona_idPersona_detalle[$num_elementos]',
														'$prioridad[$num_elementos]',
														'$codigoProveedor[$num_elementos]',
														'$descontinuado[$num_elementos]',
														'$precioCompra[$num_elementos]'
													)";
							ejecutarConsulta($sql_detalle) or $sw = false;
							$num_elementos=$num_elementos + 1;
				

						}else{

							$sql_detalle = "UPDATE `articulo_proveedor`	SET
												`prioridad` = '$prioridad[$num_elementos]',
												`codigoProveedor` = '$codigoProveedor[$num_elementos]',
												`descontinuado` = '$descontinuado[$num_elementos]',
												`precioCompra` = '$precioCompra[$num_elementos]' 
												WHERE `idArticulo_Proveedor` = '$idArticulo_Proveedor[$num_elementos]'";
							ejecutarConsulta($sql_detalle) or $sw = false;
				

							$num_elementos=$num_elementos + 1;
						}
					}
		}

		$num_elementos=0; 
		//$sw=true;
		if ( is_array( $Canje ) && $sw = true ) {

				while ($num_elementos < count($Canje))
				{

					if ( $idArticulo_Detalle[$num_elementos] ==  0 ) {
 
						$sql_detalle = "INSERT INTO `detallearticulo`
										(
											`Articulo_idArticulo`,
											`Articulo_idArticuloDet`,
											`canje`,
											`cantidad`,
											`inactivo`,
											`usuarioInsercion`
										)
									
										VALUES
										(
											'$idArticulo',  
											'$Articulo_idArticulo[$num_elementos]',
											'$Canje[$num_elementos]',
											'$cantidadMateriaPrima[$num_elementos]',
											0, 
											'$usuarioInsercion'
										)";
						ejecutarConsulta($sql_detalle) or $sw = false;
						$num_elementos=$num_elementos + 1;   
					}else{	
							$sql_detalle = "UPDATE `detallearticulo`	SET
												`cantidad` = '$cantidadMateriaPrima[$num_elementos]'
												WHERE `idArticulo_Detalle` = '$idArticulo_Detalle[$num_elementos]'";
							ejecutarConsulta($sql_detalle) or $sw = false;

						$num_elementos=$num_elementos + 1;
					}	
				}
		}

		// Códigos de barras: insertar nuevos, actualizar existentes
		$num_elementos = 0;
		if ( is_array( $codigoBarra_detalle ) && $sw === true ) {
			$codigoBarra_detalle = array_values($codigoBarra_detalle);
			$descripcionCodigoBarra_detalle = is_array($descripcionCodigoBarra_detalle) ? array_values($descripcionCodigoBarra_detalle) : array();
			$Unidad_idUnidad_detalle = is_array($Unidad_idUnidad_detalle) ? array_values($Unidad_idUnidad_detalle) : array();
			$cantidad_detalle = is_array($cantidad_detalle) ? array_values($cantidad_detalle) : array();
			$idArticulo_Codigo = is_array($idArticulo_Codigo) ? array_values($idArticulo_Codigo) : array();
			while ( $num_elementos < count($codigoBarra_detalle) ) {
				$cb = isset($codigoBarra_detalle[$num_elementos]) ? trim($codigoBarra_detalle[$num_elementos]) : '';
				$desc = isset($descripcionCodigoBarra_detalle[$num_elementos]) ? trim($descripcionCodigoBarra_detalle[$num_elementos]) : '';
				$unidad = isset($Unidad_idUnidad_detalle[$num_elementos]) ? $Unidad_idUnidad_detalle[$num_elementos] : 0;
				$cant = isset($cantidad_detalle[$num_elementos]) ? $cantidad_detalle[$num_elementos] : 1;
				$idCodigo = isset($idArticulo_Codigo[$num_elementos]) ? $idArticulo_Codigo[$num_elementos] : 0;
				if ( $idCodigo == 0 || $idCodigo === '' ) {
					$sql_detalle = "INSERT INTO `articulo_codigobarra`
						(`Articulo_idArticulo`, `codigoBarra`, `descripcion`, `Unidad_idUnidad`, `cantidadDefecto`, `inactivo`)
						VALUES ('$idArticulo', '" . addslashes($cb) . "', '" . addslashes($desc) . "', '$unidad', '$cant', 0)";
					ejecutarConsulta($sql_detalle) or $sw = false;
				} else {
					$sql_detalle = "UPDATE `articulo_codigobarra` SET
						`codigoBarra` = '" . addslashes($cb) . "',
						`descripcion` = '" . addslashes($desc) . "',
						`Unidad_idUnidad` = '$unidad',
						`cantidadDefecto` = '$cant',
						`inactivo` = 0
						WHERE `idarticulo_codigoBarra` = '$idCodigo' AND `Articulo_idArticulo` = '$idArticulo'";
					ejecutarConsulta($sql_detalle) or $sw = false;
				}
				$num_elementos++;
			}
		}

		return $sw;


	}


	public function guardarNombre($idArticulo,$nombre)
	{
		$sql="UPDATE articulo SET nombre='$nombre' WHERE idArticulo='$idArticulo'";
		return ejecutarConsulta($sql);
	}



	//Implementamos un método para desactivar registros
	public function desactivar($idArticulo)
	{
		$sql="UPDATE articulo SET inactivo='1' WHERE idArticulo='$idArticulo'";
		return ejecutarConsulta($sql);
	}


	//Implementamos un método para desactivar registros
	public function desactivarArticuloProveedor($x)
	{
		$sql="UPDATE articulo_proveedor SET inactivo='1' WHERE idArticulo_Proveedor='$x'";

		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivarPrecio($x)
	{
		$sql="UPDATE precio SET inactivo='1' WHERE idPrecio='$x'";
		return ejecutarConsulta($sql);
	}


	//Implementamos un método para desactivar registros
	public function desactivarMateriaPrima($x)
	{
		$sql="UPDATE detallearticulo SET inactivo='1' WHERE idArticulo_Detalle='$x'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivarArticuloCodigo($x)
	{
		$sql="UPDATE articulo_codigobarra SET inactivo='1' WHERE idarticulo_codigoBarra='$x'";
		return ejecutarConsulta($sql);
	}

	
	//Implementamos un método para activar registros
	public function activar($idArticulo)
	{
		$sql="UPDATE articulo SET inactivo='0' WHERE idArticulo='$idArticulo'";
		return ejecutarConsulta($sql);
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function buscar_articulo_cb($codigoBarra)
	{
		$sql="CALL SP_ListarPreciosPorArticuloCodigoBarras(1, 1, 1, '$codigoBarra', 1, 1);";
		return ejecutarConsultaSimpleFila($sql);
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idArticulo)
	{
		$sql="SELECT * FROM articulo WHERE idArticulo='$idArticulo'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listarOriginal($x)
	{
		$x = '%'.$x.'%';

		$sql="SELECT *, articulo.nombre as na, articulo.descripcion as da, grupoarticulo.nombre as nga, articulo.inactivo as ea, marca.descripcion as md,
		F_NOMBRE_PERSONA(articulo.Persona_idPersona) as nprov,
		F_NOMBRE_UNIDAD(articulo.Unidad_idUnidadCompra) AS NUC, F_NOMBRE_UNIDAD(articulo.Unidad_idUnidad) as NUV,
		COALESCE(s.stock, 0) as stock, articulo.imagen as ai
		FROM articulo
		JOIN grupoarticulo ON grupoarticulo.idGrupoArticulo = articulo.GrupoArticulo_idGrupoArticulo
		JOIN marca ON articulo.Marca_idMarca = marca.idMArca
		LEFT JOIN (SELECT SUM(cantidad) as stock, Articulo_idArticulo FROM stock GROUP BY Articulo_idArticulo) AS s ON s.Articulo_idArticulo = articulo.idArticulo
		WHERE (articulo.nombre like '$x' OR articulo.descripcion like '$x' OR articulo.codigoBarra like '$x' OR articulo.codigo like '$x')
		ORDER BY articulo.inactivo ASC, articulo.idArticulo DESC";
		return ejecutarConsulta($sql);	 	
	}

	public function listarDetallePrecio($idArticulo)
	{
		$sql="SELECT *,
sucursal.nombre as sn, grupopersona.descripcion as gpn from precio, sucursal, grupopersona where precio.Sucursal_idSucursal = sucursal.idSucursal and precio.GrupoPersona_idGrupoPersona = grupopersona.idGrupoPersona and Articulo_idArticulo = '$idArticulo' and precio.inactivo = 0";
		return ejecutarConsulta($sql);		
	}

	public function listarDetalleMateriaPrima($idArticulo)
	{
		$sql="SELECT detallearticulo.idArticulo_Detalle as idArticulo_Detalle, detallearticulo.Articulo_idArticulo as Articulo_idArticulo,
articulo.nombre as sn, detallearticulo.canje as canje, detallearticulo.cantidad as cantidad
from detallearticulo, articulo 
where detallearticulo.Articulo_idArticuloDet = articulo.idArticulo and detallearticulo.Articulo_idArticulo = '$idArticulo' and detallearticulo.inactivo = 0

 ";
		return ejecutarConsulta($sql);		
	}

	public function listarDetalleArticuloProveedor($idArticulo)
	{
		$sql="SELECT *, F_NOMBRE_ARTICULO(Articulo_idArticulo) as na, F_NOMBRE_PERSONA(Persona_idPersona) as np from articulo_proveedor where Articulo_idArticulo = '$idArticulo' and articulo_proveedor.inactivo = 0";
		return ejecutarConsulta($sql);		
	}


	public function listarDetalleCodigoBarras($idArticulo)
	{
		$sql="SELECT *, F_NOMBRE_UNIDAD(Unidad_idUnidad) as nu from articulo_codigobarra where Articulo_idArticulo ='$idArticulo' and inactivo = 0";
		return ejecutarConsulta($sql);		
	}


	//Implementar un método para listar los registros
	public function listar_reporte()
	{
		$sql="SELECT *,articulo.nombre as na, categoria.nombre as nc  FROM articulo, categoria, stock where articulo.Categoria_idCategoria = categoria.idCategoria and articulo.idArticulo = stock.Articulo_idArticulo";

		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros activos
	public function listarActivos()
	{
		$sql="SELECT * FROM articulo WHERE inactivo=0";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros activos, su último precio y el stock (vamos a unir con el último registro de la tabla detalle_ingreso)
	public function listarActivosCompra()
	{
		$sql="SELECT *,articulo.nombre as na, articulo.descripcion as ad , categoria.nombre as cn, tipoimpuesto.porcentajeImpuesto as pi 
		FROM articulo, categoria, tipoimpuesto 
		WHERE articulo.Categoria_idCategoria = categoria.idCAtegoria and 
		articulo.TipoImpuesto_idTipoImpuesto = tipoimpuesto.idTipoImpuesto";
		return ejecutarConsulta($sql);		
	}


	public function listarActivosProductosInternos()
	{
		$sql="SELECT * from articulo where articulo.tipoArticulo = 'PRODUCTO_INTERNO' and inactivo = 0";
		return ejecutarConsulta($sql);		
	}

	public function selectArticulos()
	{
		$sql="SELECT * from articulo where inactivo = 0";
		return ejecutarConsulta($sql); 	 	
	}


	public function listarActivosVenta($Persona_idPersona, $Sucursal_idSucursal, $TerminoPago_idTerminoPago, $parametro, $buscar_art)
	{
		$sql="CALL SP_ListarPrecios3('$Persona_idPersona', null, '$TerminoPago_idTerminoPago', '%$buscar_art%')";
		return ejecutarConsulta($sql);		
	}

	public function detalle($idArticulo)
	{
		$sql="SELECT * from paquetedetalle where Articulo_idArticulo ='$idArticulo'";
		return ejecutarConsulta($sql);		
	}

	public function ajuste_actualizar_gs($comision,$paquete,$servicio)
	{
		$sql="UPDATE paquetedetalle set comision = '$comision' WHERE idpaqueteDetalle = '$paquete'";
		return ejecutarConsulta($sql);
	}

	public function ajuste_actualizar_p($comisionP,$paquete,$servicio)
	{
		$sql="UPDATE paquetedetalle set comisionp = '$comisionP' WHERE idpaqueteDetalle = '$paquete'";
		return ejecutarConsulta($sql);
	}


	public function actualizarOrden($id,$orden)
	{
		$sql="UPDATE articulo set orden = '$orden' WHERE idArticulo = '$id'";
		return ejecutarConsulta($sql);
	}

	public function ajuste_actualizar_c($cantidad,$paquete,$servicio)
	{
		$sql="UPDATE paquetedetalle set cantidad = '$cantidad' WHERE idpaqueteDetalle = '$paquete'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function validarCodigo($codigo)
	{

		$sql="SELECT count(codigo) as cantidad from articulo where codigo = '$codigo'";


		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function validarCodigoBarra($codigo)
	{

		$sql="SELECT count(codigoBarra) as cantidad from articulo_codigobarra where codigoBarra = '$codigo'";


		return ejecutarConsultaSimpleFila($sql);
	}



}

?>