<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
Class Compra
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar( $tipoCompra, $OrdenCompra_idOrdenCompra, $HacerPedido_idHacerPedido,$CentroCosto_idCentroCosto, $Proveedor_idProveedor,$Habilitacion_idHabilitacion,$Deposito_idDeposito,$TerminoPago_idTerminoPago,$tipo_comprobante,$nroFactura,$fechaFactura,$fechaVencimiento,$timbrado,$vtoTimbrado,$totalImpuesto,$total,$totalNeto,$usuarioInsercion,$cuotas,$imagen,$idarticulo,$descripcion,$cantidad,$costo,$impuesto,$idTipoImpuesto,$importe_detalle,$tipopago,$nroReferencia, $tasaCambio, $tasaCambioBases, $Moneda_idMoneda, $descuento, $devolver)
	{
		$usuario = $_SESSION['login'];
			$sql = "INSERT INTO `compra`
									( 
									`Persona_idPersona`, 
									`usuario`, 
									`Habilitacion_idHabilitacion`, 
									`Deposito_idDeposito`, 
									`TerminoPago_idTerminoPago`, 
									`tipo_comprobante`, 
									`nroFactura`, 
									`fechaTransaccion`, 
									`fechaFactura`, 
									`fechaVencimiento`, 
									`timbrado`, 
									`vtoTimbrado`, 
									`totalImpuesto`, 
									`total` , 
									`totalNeto`,
									`usuarioInsercion` , 
									`inactivo`,
									`cuotas`,
									`imagen`,
									`tasaCambio`,
									`tasaCambioBases`,
									`Moneda_idMoneda`,
									`CentroCosto_idCentroCosto`,
									`OrdenCompra_idOrdenCompra`,
									`tipoCompra`,
									`HacerPedido_idHacerPedido`
									
									) 
									VALUES 
									(
									'$Proveedor_idProveedor',
									'$usuario',
									'$Habilitacion_idHabilitacion',
									'$Deposito_idDeposito',
									'$TerminoPago_idTerminoPago',
									'$tipo_comprobante',
									'$nroFactura',
									now(),
									'$fechaFactura',
									'$fechaVencimiento',
									'$timbrado',
									'$vtoTimbrado',
									'$totalImpuesto',
									'$total',
									'$totalNeto',
									'$usuario',
									0,
									'$cuotas',
									'$imagen',
									'$tasaCambio',
									'$tasaCambioBases',
									'$Moneda_idMoneda',
									'$CentroCosto_idCentroCosto',
									'$OrdenCompra_idOrdenCompra',
									'$tipoCompra',
									'$HacerPedido_idHacerPedido'
								)";



		//return ejecutarConsulta($sql);


		$idcompranew=ejecutarConsulta_retornarID($sql);

		$num_elementos=0;
		$sw=true;
		$ultimo = count($idarticulo) - 1;
		while ($num_elementos < count($idarticulo))
		{
			$totalv = $cantidad[$num_elementos] * $costo[$num_elementos];
			$netov = ( $totalv * $impuesto[$num_elementos] ) / 100;
			
			if ($num_elementos == $ultimo) {
		
			$sql_detalle = "INSERT INTO `detallecompra`
							(
							`Compra_idCompra`,
							`Articulo_idArticulo`,
							`cantidad`,
							`precio`,
							`impuesto`,
							`totalNeto`,
							`total`,
							`inactivo`,
							`TipoImpuesto_idTipoImpuesto`,
							`descripcion`,
							`ultimo`,
							`descuento`,
							`devolver`
							)
							VALUES
							(
							'$idcompranew',
							'$idarticulo[$num_elementos]',
							'$cantidad[$num_elementos]',
							'$costo[$num_elementos]',
							'$impuesto[$num_elementos]',
							'$netov',
							'$totalv',
							0,
							'$idTipoImpuesto[$num_elementos]',
							'$descripcion[$num_elementos]',	
							'1',	
							'descuento',
							'$devolver[$num_elementos]'	
							)";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;		
			}else{

			$sql_detalle = "INSERT INTO `detallecompra`
							(
							`Compra_idCompra`,
							`Articulo_idArticulo`,
							`cantidad`,
							`precio`,
							`impuesto`,
							`totalNeto`,
							`total`,
							`inactivo`,
							`TipoImpuesto_idTipoImpuesto`,
							`descripcion`,
							`ultimo`,
							`descuento`,
							`devolver`
							)
							VALUES
							(
							'$idcompranew',
							'$idarticulo[$num_elementos]',
							'$cantidad[$num_elementos]',
							'$costo[$num_elementos]',
							'$impuesto[$num_elementos]',
							'$netov',
							'$totalv',
							0,
							'$idTipoImpuesto[$num_elementos]',
							'$descripcion[$num_elementos]',	
							'0',	
							'$descuento[$num_elementos]',	
							'$devolver[$num_elementos]'	
							)";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;			
			}

		}


		//Se aplica aprobacion automatica de compras
		$sql_detalle = "UPDATE compra set estado = 1 where idCompra = '$idcompranew'";
		ejecutarConsulta($sql_detalle) or $sw = false;


		if ($sw==true and $TerminoPago_idTerminoPago == 1) {
			$sql_pago_detalle = "INSERT INTO `pago`(`PROVEEDOR_IDPROVEEDOR`, `USUARIO`, `HABILITACION_IDHABILITACION`, `NROPAGO`, `FECHATRANSACCION`, `FECHAPAGO`, `TOTAL`, `INACTIVO`)

			VALUES ('$Proveedor_idProveedor', '$usuario', '$Habilitacion_idHabilitacion', 0, now(), '$fechaFactura', '$total', 0)";
			$idpago = ejecutarConsulta_retornarID($sql_pago_detalle) or $sw = false;
		}


		if ($sw==true and $TerminoPago_idTerminoPago == 1) {

			$sql_pago_detalle_factura = "INSERT INTO `detallepagofacturas`(`PAGO_IDPAGO`, `COMPRA_IDCOMPRA`, `MONTOAPLICADO`, `INACTIVO`) 
			VALUES ('$idpago', '$idcompranew', '$total', 0)";
			ejecutarConsulta($sql_pago_detalle_factura) or $sw = false;
		}

		$contador = 0;
		if ($sw==true and $TerminoPago_idTerminoPago == 1) {
			while ($contador < count($importe_detalle)) {
				$sql_detalle_factura_pago = "INSERT INTO `detallepago`( `PAGO_IDPAGO`, `FORMAPAGO_IDFORMAPAGO`, `BANCO_IDBANCO`, `NROCHEQUE`, `MONTO`, `INACTIVO`) 
				VALUES ('$idpago','$tipopago[$contador]', 1, '$nroReferencia[$contador]', '$importe_detalle[$contador]',0)";
				ejecutarConsulta($sql_detalle_factura_pago) or $sw = false;
				$contador++;
			}
		}


		/*$sumador=0;
		$monto_a_aplicar=0;
		if ($sw==true and $TerminoPago_idTerminoPago == 2 and $cuotas == 1) {
			while ($sumador < count($importe_detalle)) {
				$monto_a_aplicar = $monto_a_aplicar + $importe_detalle[$sumador];
				$sumador++;
			}
		}


		if ($sw==true and $TerminoPago_idTerminoPago == 2 and $cuotas == 1) {
			$sql_pago_detalle = "INSERT INTO `pago`(`PROVEEDOR_IDPROVEEDOR`, `USUARIO`, `HABILITACION_IDHABILITACION`, `NROPAGO`, `FECHATRANSACCION`, `FECHAPAGO`, `TOTAL`, `INACTIVO`)

			VALUES ('$Proveedor_idProveedor', '$usuario', '$Habilitacion_idHabilitacion', 0, now(), '$fechaFactura', '$monto_a_aplicar', 0)";
			$idpago = ejecutarConsulta_retornarID($sql_pago_detalle) or $sw = false;
		}


		if ($sw==true and $TerminoPago_idTerminoPago == 2 and $cuotas == 1) {

			$sql_pago_detalle_factura = "INSERT INTO `PagoDetalleFacturas`(`PAGO_IDPAGO`, `COMPRA_IDCOMPRA`, `MONTOAPLICADO`, `INACTIVO`) 

			VALUES ('$idpago', '$idcompranew', '$monto_a_aplicar', 0)";
			ejecutarConsulta($sql_pago_detalle_factura) or $sw = false;
		}
		$contador = 0;
		if ($sw==true and $TerminoPago_idTerminoPago == 2 and $cuotas == 1) {
			while ($contador < count($importe_detalle)) {
				$sql_detalle_factura_pago = "INSERT INTO `detallepago`( `PAGO_IDPAGO`, `FORMAPAGO_IDFORMAPAGO`, `BANCO_IDBANCO`, `NROCHEQUE`, `MONTO`, `INACTIVO`) 
				VALUES ('$idpago','$tipopago[$contador]', 1, '$nroReferencia[$contador]', '$importe_detalle[$contador]',0)";
				ejecutarConsulta($sql_detalle_factura_pago) or $sw = false;
				$contador++;
			}
		}*/


		return $sw;
	}




	//Implementamos un método para anular la venta
	public function autorizarCompra($idCompra)
	{
		$sql="UPDATE compra SET estado=1 WHERE idCompra='$idCompra'";
		return ejecutarConsulta($sql);
	}

	
	//Implementamos un método para anular la venta
	public function anular($idCompra)
	{
		$sql="UPDATE compra SET inactivo=1 WHERE idCompra='$idCompra'";
		return ejecutarConsulta($sql);
	}


	public function listarActivosCompra()
	{
		$sql="SELECT *,articulo.nombre as na, articulo.descripcion as ad , categoria.nombre as cn, tipoimpuesto.porcentajeImpuesto as pi 
		FROM articulo, categoria, tipoimpuesto 
		WHERE articulo.Categoria_idCategoria = categoria.idCAtegoria and 
		articulo.TipoImpuesto_idTipoImpuesto = tipoimpuesto.idTipoImpuesto;";
		return ejecutarConsulta($sql);		
	}



	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idventa)
	{
		$sql="SELECT v.idventa,DATE(v.fecha_hora) as fecha,v.idcliente,p.nombre as cliente,u.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
		return ejecutarConsultaSimpleFila($sql);
	}


	public function listarDetalle($idventa)
	{
		$sql="SELECT dv.idventa,dv.idarticulo,a.nombre,dv.cantidad,dv.precio_venta,dv.descuento,(dv.cantidad*dv.precio_venta-dv.descuento) as subtotal FROM detalle_venta dv inner join articulo a on dv.idarticulo=a.idarticulo where dv.idventa='$idventa'";
		return ejecutarConsulta($sql);
	}

	public function listarDetalleOrdenCompra($idOrdenCompra)
	{
		$sql="SELECT *, F_NOMBRE_ARTICULO(Articulo_idArticulo) as na, F_COSTO_UTLIMA_COMPRA( Articulo_idArticulo ) as costoUltimaCompra from detalleordencomprarecibido where  OrdenCompraRecibido_idOrdenCompraRecibido = '$idOrdenCompra' and cantidadRecibida > 0;";
		return ejecutarConsulta($sql);
	}


	public function listarDetalleCompra($idOrdenCompra)
	{
		$sql="SELECT *, F_NOMBRE_ARTICULO(Articulo_idArticulo) as na from detallecompra where  Compra_idCompra = '$idOrdenCompra' and F_DEVOLVER_COMPRA( '$idOrdenCompra', Articulo_idArticulo ) > 0";
		return ejecutarConsulta($sql);
	}


	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT *, 
		F_NOMBRE_PERSONA( Persona_idPersona ) as nombre, 
		usuario, F_NOMBRE_SUCURSAL_X_DEPOSITO(Deposito_idDeposito) as deposito, 
		F_NOMBRE_TERMINO_PAGO( TerminoPago_idTerminoPago ) as terminoPago,
		fechaFactura,
		nroFactura,
		F_NRO_TIMBRADO( timbrado ) AS timbrado,
		vtoTimbrado,
		F_NOMBRE_MONEDA( Moneda_idMoneda ) as moneda,
		totalImpuesto,
		totalNeto,
		total,
		usuarioInsercion,
		fechaTransaccion,
		imagen,
		tipoCompra,
		TipoGasto_idTipoGasto,
		tipo_comprobante
		from compra where inactivo = 0 order by idCompra desc";
		return ejecutarConsulta($sql);		
	}


	//Implementar un método para listar los registros
	public function listarAutorizacion()
	{
		$sql="SELECT *, persona.razonSocial as cn, compra.inactivo as ci from compra, persona where compra.Persona_idPersona = persona.idPersona and compra.inactivo = 0 and compra.estado = 0";
		return ejecutarConsulta($sql);		
	}


	public function ventacabecera($idVenta){
		//$sql="SELECT v.idventa,v.idcliente,p.nombre as cliente,p.direccion,p.tipo_documento,p.num_documento,p.email,p.telefono,v.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,date(v.fecha_hora) as fecha,v.impuesto,v.total_venta FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
		
		$sql="SELECT *,Cliente.razonSocial as nombreCliente, Cliente.nroDocumento as ruc from venta, cliente WHERE  cliente.idCliente = venta.Cliente_idCliente and idVenta = '$idVenta'";

		return ejecutarConsulta($sql);
	}


	public function ventadetalle($idVenta){
		//$sql="SELECT a.nombre as articulo,a.codigo,d.cantidad,d.precio_venta,d.descuento,(d.cantidad*d.precio_venta-d.descuento) as subtotal FROM detalle_venta d INNER JOIN articulo a ON d.idarticulo=a.idarticulo WHERE d.idventa='$idventa'";
		
		//$sql="SELECT *,F_NOMBRE_PRODUCTO(venta_det.ID_PRODSERV) as np, venta_det.CANTIDAD AS VC FROM venta_det, prod_serv WHERE venta_det.ID_PRODSERV = prod_serv.ID_PRODSERV and ID_VENTA_CAB = '$idventa'";
		//return ejecutarConsulta($sql);

		$sql="SELECT *, articulo.descripcion as descripcionarticulo  FROM detalleventa, articulo WHERE detalleventa.Articulo_idArticulo = articulo.idarticulo and venta_idVenta='$idVenta'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function habilitacion()
	{
		$user = $_SESSION['idusuario'];

		$sql="SELECT
				habilitacion.estado, 
				habilitacion.Usuario_idUsuario, 
				idhabilitacion, 
				deposito.idDeposito as dp, 
				date(fechaApertura) as fecha, 
				Documento_idTipoDocumento as tipoDocumento, 
				serie, 
				RIGHT(CONCAT('000000', ltrim(rtrim(replace(numeroActual+1,'','')))),6) as a, 
				fechaEntrega, 
				timbrado, 
				deposito.descripcion as deposito, 
				sucursal.nombre as sucursal 


				FROM habilitacion, caja,sucursal, deposito, documentocajero
				where
				 habilitacion.Usuario_idUsuario = '$user' and 
				 caja.idcaja = habilitacion.Caja_idCaja and 
				 caja.Sucursal_idSucursal = sucursal.idsucursal and 
				 habilitacion.estado = 1 and deposito.Sucursal_idSucursal = sucursal.idSucursal and documentocajero.Usuario_idUsuario = habilitacion.Usuario_idUsuario ";


		return ejecutarConsultaSimpleFila($sql);
	}


	public function mostrarDetalle1($id)
	{
		$sql="CALL SP_ComparacionCompra('$id')";
		return ejecutarConsulta($sql);
	}


	public function mostrarDetalle2($id)
	{
		$sql="CALL  SP_ComparacionCompra('$id')";
		return ejecutarConsulta($sql);
	}


	public function mostrarDetalleNC($id)
	{
		$sql="CALL  SP_ComparacionCompra('$id')";
		return ejecutarConsulta($sql);
	}

	public function mostrarDetalle3($id)
	{
		$sql="select * from compra where idCompra = '$id'";
		return ejecutarConsulta($sql);
	}


	public function mostrarDetalle4($id)
	{
		$sql="select * from notacreditocompra where Compra_idCompra = '$id'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros
	public function selectOC()
	{
		$sql="

		SELECT 
			nroCompra,
			idOrdenCompraRecibido, Deposito_idDeposito, 
			fecha, 
			terminopago.descripcion AS tpd, 
			persona.razonSocial as rs, 
			totalImpuesto, 
			subTotal, 
			total, 
			ordencomprarecibido.usuarioInsercion as ocui, 
			ordencomprarecibido.usuarioModificacion as ocum, 
			ordencomprarecibido.fechaModificacion, 
			ordencomprarecibido.fechaInsercion, 
			ordencomprarecibido.inactivo as oci,
			deposito.descripcion as dd,
			sucursal.nombre as ds,
			sucursal.direccion as direccion,
			sucursal.telefono as telefono,
			sucursal.correo as correo,
			sucursal.ciudad as ciudad
		from 
			ordencomprarecibido, terminopago, persona, deposito, sucursal 
		where 
			sucursal.idSucursal = deposito.Sucursal_idSucursal and
			deposito.idDeposito = ordencomprarecibido.Deposito_idDeposito and
			ordencomprarecibido.Persona_idPersona = persona.idPersona and 
			ordencomprarecibido.TerminoPago_idTerminoPago = terminopago.idTerminoPago and 
			ordencomprarecibido.recibido = 2 and ordencomprarecibido.comprado = 0;

		";
		return ejecutarConsulta($sql);		
	}


	//Implementar un método para listar los registros
	public function selectCompra()
	{
		$sql="SELECT *, F_NOMBRE_CLIENTE(Persona_idPersona) as np from compra where inactivo = 0";
		return ejecutarConsulta($sql);		
	}



	//Implementar un método para listar los registros
	public function selectCompraPorCentroDeCosto($idCentroDeCosto)
	{
		$sql="SELECT *, F_NOMBRE_CLIENTE(Persona_idPersona) as np from compra where inactivo = 0 and CentroCosto_idCentroCosto = '$idCentroDeCosto'";
		return ejecutarConsulta($sql);		
	}



	


	//Implementar un método para mostrar los datos de un registro a modificar
	public function datosOC($id)
	{

		$sql="SELECT * FROM ordencomprarecibido where idOrdenCompraRecibido = '$id' ";


		return ejecutarConsultaSimpleFila($sql);
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function datosCompra($id)
	{

		$sql="SELECT * FROM compra where idCompra = '$id' ";


		return ejecutarConsultaSimpleFila($sql);
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function ultimo()
	{
		$sql="select max(nroFactura) as maximo from venta where venta.tipo_comprobante = 2";


		return ejecutarConsultaSimpleFila($sql);
	}
	
	public function cantidadHoy()
	{
		$sql="select COUNT(*) AS cantidad, SUM(total * tasaCambio) as total from compra where inactivo = 0 and MONTH(fechaTransaccion) = MONTH(curDate())";

return ejecutarConsulta($sql);
	}
	
	
}
?>