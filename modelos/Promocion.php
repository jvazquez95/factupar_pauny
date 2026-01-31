<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Promocion
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($descripcion, $fechaInicio, $fechaFin, $tipoPromocion,$tipoDescuento1, 
							 $Articulo_idArticuloDescuento1, $desde1, $hasta1, $descuentoPorcentualDescuento1, $descuentoGsDescuento1, 
							 $Articulo_idArticuloPunto2, $cantidadPuntos2, $Articulo_idArticulo3, $FormaPago_idFormaPago3, $descuentoPorcentual3, 
							 $descuentoGs3,$Banco_idBanco3, $Articulo_idArticulo4, $precioGs4, $ventaMaxima4, 
							 $Articulo_idArticulo5, $precioGsPrecio_l5, $puntos5, $Articulo_idArticulo6, $precioGsPrecio_l6,
							 $puntos6, $porcentaje6, $Sucursal_idSucursal1, $Sucursal_idSucursal2, $Sucursal_idSucursal3, 
							 $Sucursal_idSucursal4, $Sucursal_idSucursal5, $Sucursal_idSucursal6  )
	{

		session_start();
		$usuario = $_SESSION['login'];
		$sql="INSERT INTO promocion ( descripcion, fechaInicio, fechaFin, tipoPromocion, inactivo, usuarioInsercion, fechaInsercion )
		VALUES ('$descripcion','$fechaInicio' ,'$fechaFin','$tipoPromocion','0','$usuario', now())";
		$newIdPromocion =  ejecutarConsulta_retornarID($sql);
	

		$num_elementos=0;
		$sw=true;

		if ($tipoPromocion == 'promocionPorDescuento') {
	

			while ($num_elementos < count($tipoDescuento1))
			{

				$sql_detalle = "	
								

						INSERT INTO `descuento`
						(
						`Promocion_idPromocion`,
						`tipoDescuento`,
						`desde`,
						`hasta`,
						`Articulo_idArticulo`,
						`descuentoGs`,
						`descuentoPorcentual`,
						`Sucursal_idSucursal`)   
						VALUES
						(
						'$newIdPromocion',
						'$tipoDescuento1[$num_elementos]',
						'$desde1[$num_elementos]',
						'$hasta1[$num_elementos]',
						'$Articulo_idArticuloDescuento1[$num_elementos]',
						'$descuentoGsDescuento1[$num_elementos]',
						'$descuentoPorcentualDescuento1[$num_elementos]',
						'$Sucursal_idSucursal1[$num_elementos]'
						);



								";
				ejecutarConsulta($sql_detalle) or $sw = false;
				$num_elementos=$num_elementos + 1;
			}


		}


		if ($tipoPromocion == 'promocionPorPuntos') {
			
						while ($num_elementos < count($Articulo_idArticuloPunto2))
			{

				$sql_detalle = "



									INSERT INTO `punto`
									(
									`Articulo_idArticulo`,
									`cantidadPuntos`,
									`Promocion_idPromocion`,
									`Sucursal_idSucursal`)
									VALUES
									('$Articulo_idArticuloPunto2[$num_elementos]', 
									'$cantidadPuntos2[$num_elementos]', 
									'$newIdPromocion',
									'$Sucursal_idSucursal2[$num_elementos]');






				";
				ejecutarConsulta($sql_detalle) or $sw = false;
				$num_elementos=$num_elementos + 1;
			}

		}


		if ($tipoPromocion == 'promocionPorFormaPago') {
		
			while ($num_elementos < count($Articulo_idArticulo3))
			{

				$sql_detalle = "



						INSERT INTO `descuentoporformapago`
						(
						`Promocion_idPromocion`,
						`FormaPago_idFormaPago`,
						`descuentoGs`,
						`descuentoPorcentual`,
						`Articulo_idArticulo`,
						`Banco_idBanco`,
						`Sucursal_idSucursal`)
						VALUES
						(
							'$newIdPromocion',
							'$FormaPago_idFormaPago3[$num_elementos]', 
							'$descuentoGs3[$num_elementos]', 
							'$descuentoPorcentual3[$num_elementos]', 
							'$Articulo_idArticulo3[$num_elementos]', 
							'$Banco_idBanco3[$num_elementos]',
							'$Sucursal_idSucursal3[$num_elementos]'	

						);




				";
				ejecutarConsulta($sql_detalle) or $sw = false;
				$num_elementos=$num_elementos + 1;
			}


		}


		if ($tipoPromocion == 'promocionPorTiempoLimitado') {
			

			while ($num_elementos < count($Articulo_idArticulo4))
			{

				$sql_detalle = "


						INSERT INTO `precioportiempolimitado`
						(
						`Promocion_idPromocion`,
						`Articulo_idArticulo`,
						`precioGs`,
						`ventaMaxima`,
						`Sucursal_idSucursal`)
						VALUES
						(	
						'$newIdPromocion',
						'$Articulo_idArticulo4[$num_elementos]',
						'$precioGs4[$num_elementos]',
						'$ventaMaxima4[$num_elementos]',
						'$Sucursal_idSucursal4[$num_elementos]'	
						);



				";
				ejecutarConsulta($sql_detalle) or $sw = false;
				$num_elementos=$num_elementos + 1;
			}

		}


		if ($tipoPromocion == 'promocionPorPrecioPunto') {
		
			while ($num_elementos < count($idarticulo))
			{

				$sql_detalle = "INSERT INTO `detalleventa`
								(
								`Venta_idVenta`,
								`Articulo_idArticulo`,
								`cantidad`,
								`precio`,
								`impuesto`,
								`totalNeto`,
								`total`,
								`inactivo`,
								`Sucursal_idSucursal`)
								VALUES
								(
								'$idventanew',
								'$idarticulo[$num_elementos]',
								'$cantidad[$num_elementos]',
								'$precioVenta[$num_elementos]',
								'$impuesto[$num_elementos]',
								'$netov',
								'$totalv',
								0,	
								'$Sucursal_idSucursal5[$num_elementos]')";
				ejecutarConsulta($sql_detalle) or $sw = false;
				$num_elementos=$num_elementos + 1;
			}

		}

		if ($tipoPromocion == 'promocionPorPrecioPack') {
		
			while ($num_elementos < count($Articulo_idArticulo6))
			{

				$sql_detalle = "INSERT INTO `preciopack`
								(
								`Articulo_idArticulo`,
								`cantidad`,
								`precio`,
								`Promocion_idPromocion`,
								`porcentaje`, 
								`Sucursal_idSucursal`)
								VALUES
								( 
								'$Articulo_idArticulo6[$num_elementos]',
								'$puntos6[$num_elementos]',
								'$precioGsPrecio_l6[$num_elementos]',
								'$newIdPromocion',
								'$porcentaje6[$num_elementos]',
								'$Sucursal_idSucursal6[$num_elementos]'
								/*'$Articulo_idArticulo6[$num_elementos]',
								'$cantidad[$num_elementos]',
								'$puntos6[$num_elementos]',
								'$puntos6[$num_elementos]',
								'$Sucursal_idSucursal6[$num_elementos]' */
							   )";
				ejecutarConsulta($sql_detalle) or $sw = false;
				$num_elementos=$num_elementos + 1;
			}

		}



		return $sw;







	}

	//Implementamos un método para editar registros
	public function editar($idPromocion,$descripcion, $fechaInicio, $fechaFin, $tipoPromocion, $Articulo_idArticuloDescuento1, $desde1, $hasta1, $descuentoPorcentualDescuento1, $descuentoGsDescuento1, $Articulo_idArticuloPunto2, $cantidadPuntos2, $Articulo_idArticulo3, $FormaPago_idFormaPago3, $descuentoPorcentual3, $descuentoGs3,$Banco_idBanco3, $Articulo_idArticulo4, $precioGs4, $ventaMaxima4, $Articulo_idArticulo5, $precioGsPrecio_l5, $puntos5, $Sucursal_idSucursal1)
	{
		$usuario = $_SESSION['login'];
		$sql="UPDATE promocion SET descripcion='$descripcion', fechaInicio='$fechaInicio', fechaFin = '$fechaFin', tipoPromocion = '$tipoPromocion', usuarioModificacion = '$usuario', fechaModificacion = now() WHERE idPromocion='$idPromocion'";
		ejecutarConsulta($sql);
	}


	//Implementamos un método para desactivar categorías
	public function desactivar($idPromocion)
	{
		$sql="UPDATE promocion SET inactivo=1 WHERE idPromocion='$idPromocion'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idPromocion)
	{
		$sql="UPDATE promocion SET inactivo=0 WHERE idPromocion='$idPromocion'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idPromocion)
	{
		$sql="SELECT * FROM promocion WHERE idPromocion='$idPromocion'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * from promocion";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros
	public function listarFiltrado1($idProveedor,$marca,$grupo,$categoria,$sucursal)
	{
		$sql="SELECT idArticulo, descripcion, 1 as tipo,inactivo as inactivo  
		from articulo  
		where ( Marca_idMarca='$marca' or '$marca'='%%' ) 
		and  ( Categoria_idCategoria='$categoria' or '$categoria'='%%' )
		and  ( GrupoArticulo_idGrupoArticulo='$grupo' or '$grupo'='%%' ) 
		and idArticulo in ( select Articulo_idArticulo 
						    from articulo_proveedor 
						    where (Persona_idPersona='$idProveedor' or '$idProveedor'='%%') 
		and idArticulo in (select Articulo_idArticulo 
						   from Deposito_Sucursal_Articulo where (Sucursal_idSucursal = '$sucursal' or '$sucursal' = '%%' ))				     )  ";
		
		return ejecutarConsulta($sql);		
	}	

	//Implementar un método para listar los registros
	public function listarFiltrado4($idProveedor,$marca,$grupo,$categoria,$precio,$ventamax,$sucursal)
	{
		$sql="SELECT idArticulo, descripcion, '$precio' as precio, '$ventamax' as ventamax, 1 as tipo,inactivo as inactivo  
		from articulo where (Marca_idMarca='$marca' or '$marca'='%%' ) and  (Categoria_idCategoria='$categoria' or '$categoria'='%%' )
		and  (GrupoArticulo_idGrupoArticulo='$grupo' or '$grupo'='%%' ) 
		and idArticulo in (select Articulo_idArticulo from articulo_proveedor where (Persona_idPersona='$idProveedor' or '$idProveedor'='%%')  ) 
		and idArticulo in (select Articulo_idArticulo 
						   from Deposito_Sucursal_Articulo where (Sucursal_idSucursal = '$sucursal' or '$sucursal' = '%%' ))	 ";
		return ejecutarConsulta($sql);		
	}	

	public function listarDetallePromocionPorDescuento($idPromocion)
	{
		$sql="SELECT * from descuento where Promocion_idPromocion = '$idPromocion'";
		return ejecutarConsulta($sql);		
	}


	public function listarDetallePromocionPorPuntos($idPromocion)
	{
		$sql="SELECT * from descuento where Promocion_idPromocion = '$idPromocion'";
		return ejecutarConsulta($sql);		
	}

	public function listarDetallePromocionPorFormaPago($idPromocion)
	{
		$sql="SELECT * from descuento where Promocion_idPromocion = '$idPromocion'";
		return ejecutarConsulta($sql);		
	}

	public function listarDetallePromocionPorTiempoLimitado($idPromocion)
	{
		$sql="SELECT * from descuento where Promocion_idPromocion = '$idPromocion'";
		return ejecutarConsulta($sql);		
	}

	public function listarDetallePromocionPorPrecioPunto($idPromocion)
	{
		$sql="SELECT * from descuento where Promocion_idPromocion = '$idPromocion'";
		return ejecutarConsulta($sql);		
	}
	
	public function listarDetallePromocionPorPrecioPack($idPromocion)
	{
		$sql="SELECT * from preciopack where Promocion_idPromocion = '$idPromocion'";
		return ejecutarConsulta($sql);		
	}


	//Implementar un método para listar los registros y mostrar en el select
	public function selectpromocion()
	{
		$sql="SELECT * FROM promocion where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>