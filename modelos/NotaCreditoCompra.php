<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
Class NotaCreditoCompra
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($Proveedor_idProveedor,$Habilitacion_idHabilitacion,$Deposito_idDeposito,$TerminoPago_idTerminoPago,$tipo_comprobante,$nroFactura,$fechaFactura,$timbrado,$vtoTimbrado,$totalImpuesto,$total,$totalNeto,$usuarioInsercion,$imagen,$Compra_idCompra,$idarticulo,$cantidad,$costo,$impuesto,$importe_detalle,$tipopago,$nroReferencia, $tasaCambio, $tasaCambioBases, $Moneda_idMoneda)
	{

		$usuario = $_SESSION['login'];
			$sql = "INSERT INTO `notacreditocompra`
									( 
									`Persona_idPersona`, 
									`usuario`, 
									`Habilitacion_idHabilitacion`, 
									`Deposito_idDeposito`, 
									/*`TerminoPago_idTerminoPago`,*/ 
									`tipoComprobante`, 
									`nroFactura`, 
									`fechaTransaccion`, 
									`fecha`, 
									`timbrado`, 
									`vtoTimbrado`, 
									`totalImpuesto`, 
									`total` , 
									`subTotal`,
									`usuarioInsercion` , 
									`inactivo`,
									`imagen`,
									`tasaCambio`,
									`tasaCambioBases`,
									`Compra_idCompra`,
									`Moneda_idMoneda`
									
									) 
									VALUES 
									(
									'$Proveedor_idProveedor',
									'$usuario',
									'$Habilitacion_idHabilitacion',
									'$Deposito_idDeposito',/*
									'$TerminoPago_idTerminoPago',
									*/'$tipo_comprobante',
									'$nroFactura',
									now(),
									'$fechaFactura',
									'$timbrado',
									'$vtoTimbrado',
									'$totalImpuesto',
									'$total',
									'$totalNeto',
									'$usuario',
									0,
									'$imagen',
									'$tasaCambio',
									'$tasaCambioBases',
									'0',
									'$Moneda_idMoneda'
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
	
			$sql_detalle = "INSERT INTO `notacreditocompradetalle`
							(
							`NotaCreditoCompra_idNotaCreditoCompra`,
							`Articulo_idArticulo`,
							`cantidad`,
							`costo`,
							/*`devuelve`,*/
							`totalNeto`,
							`total`,
							`inactivo`,
							`ultimo`
							)
							VALUES
							(
							'$idcompranew',
							'$idarticulo[$num_elementos]',
							'$cantidad[$num_elementos]',
							'$costo[$num_elementos]',
							/*'$impuesto[$num_elementos]',*/
							'$netov',
							'$totalv',
							0,
							1
							)";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;			
			}else{


			$sql_detalle = "INSERT INTO `notacreditocompradetalle`
							(
							`NotaCreditoCompra_idNotaCreditoCompra`,
							`Articulo_idArticulo`,
							`cantidad`,
							`costo`,
							/*`devuelve`,*/
							`totalNeto`,
							`total`,
							`inactivo`,
							`ultimo`
							)
							VALUES
							(
							'$idcompranew',
							'$idarticulo[$num_elementos]',
							'$cantidad[$num_elementos]',
							'$costo[$num_elementos]',
							/*'$impuesto[$num_elementos]',*/
							'$netov',
							'$totalv',
							0,
							0
							)";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;

			}

		}

	/*	if ($sw==true and $TerminoPago_idTerminoPago == 0) {
			$sql_pago_detalle = "INSERT INTO `pago`(`PROVEEDOR_IDPROVEEDOR`, `USUARIO`, `HABILITACION_IDHABILITACION`, `NROPAGO`, `FECHATRANSACCION`, `FECHAPAGO`, `TOTAL`, `INACTIVO`)

			VALUES ('$Proveedor_idProveedor', '$usuario', '$Habilitacion_idHabilitacion', 0, now(), '$fechaFactura', '$total', 0)";
			$idpago = ejecutarConsulta_retornarID($sql_pago_detalle) or $sw = false;
		}


		if ($sw==true and $TerminoPago_idTerminoPago == 0) {

			$sql_pago_detalle_factura = "INSERT INTO `pagodetallefacturas`(`PAGO_IDPAGO`, `COMPRA_IDCOMPRA`, `MONTOAPLICADO`, `INACTIVO`) 

			VALUES ('$idpago', '$idcompranew', '$total', 0)";
			ejecutarConsulta($sql_pago_detalle_factura) or $sw = false;
		}

		$contador = 0;
		if ($sw==true and $TerminoPago_idTerminoPago == 0) {
			while ($contador < count($importe_detalle)) {
				$sql_detalle_factura_pago = "INSERT INTO `detallepago`( `PAGO_IDPAGO`, `FORMAPAGO_IDFORMAPAGO`, `BANCO_IDBANCO`, `NROCHEQUE`, `MONTO`, `INACTIVO`) 
				VALUES ('$idpago','$tipopago[$contador]', 1, '$nroReferencia[$contador]', '$importe_detalle[$contador]',0)";
				ejecutarConsulta($sql_detalle_factura_pago) or $sw = false;
				$contador++;
			}
		}


		$sumador=0;
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
		}
*/

		return $sw;
	}




	//Implementamos un método para anular la venta
	public function autorizarCompra($idCompra)
	{
		$sql="UPDATE compra SET estado=1 WHERE idCompra='$idCompra'";
		return ejecutarConsulta($sql);
	}

	
	//Implementamos un método para anular la venta
	public function anular($idventa)
	{
		$sql="UPDATE venta SET inactivo=1 WHERE idventa='$idventa'";
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
		$sql="SELECT *, F_NOMBRE_ARTICULO(Articulo_idArticulo) as na from detalleordencompra where  OrdenCompra_idOrdenCompra = '$idOrdenCompra';";
		return ejecutarConsulta($sql);
	}


	public function listarDetalleCompra($idOrdenCompra)
	{
		$sql="SELECT *, F_NOMBRE_ARTICULO(Articulo_idArticulo) as na from detallecompra where  Compra_idCompra = '$idOrdenCompra';";
		return ejecutarConsulta($sql);
	}


	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT a.idNotaCreditoCompra,a.nroDevolucion,a.nroFactura,c.razonSocial,a.tipoComprobante,a.fechaTransaccion,a.total as totalC,a.inactivo, a.Compra_idCompra, a.saldo
			from notacreditocompra a,persona c,habilitacion d
			where a.Persona_idPersona=c.idPersona and a.Habilitacion_idhabilitacion=d.idHabilitacion;";
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


	//Implementar un método para listar los registros
	public function selectOC()
	{
		$sql="

		SELECT 
			idOrdenCompra, Deposito_idDeposito, 
			fecha, 
			terminopago.descripcion AS tpd, 
			persona.razonSocial as rs, 
			totalImpuesto, 
			subTotal, 
			total, 
			ordencompra.usuarioInsercion as ocui, 
			ordencompra.usuarioModificacion as ocum, 
			ordencompra.fechaModificacion, 
			ordencompra.fechaInsercion, 
			ordencompra.inactivo as oci,
			deposito.descripcion as dd,
			sucursal.nombre as ds,
			sucursal.direccion as direccion,
			sucursal.telefono as telefono,
			sucursal.correo as correo,
			sucursal.ciudad as ciudad
		from 
			ordencompra, terminopago, persona, deposito, sucursal 
		where 
			sucursal.idSucursal = deposito.Sucursal_idSucursal and
			deposito.idDeposito = ordencompra.Deposito_idDeposito and
			ordencompra.Persona_idPersona = persona.idPersona and 
			ordencompra.TerminoPago_idTerminoPago = terminopago.idTerminoPago and 
			ordencompra.recibido = 1 and F_ESTADO_HACER_PEDIDO(HacerPedido_idHacerPedido) > 3;

		";
		return ejecutarConsulta($sql);		
	}


	//Implementar un método para listar los registros
	public function selectCompra()
	{
		$sql="SELECT *, F_NOMBRE_CLIENTE(Persona_idPersona) as np from compra where inactivo = 0";
		return ejecutarConsulta($sql);		
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function datosOC($id)
	{

		$sql="SELECT * FROM ordencompra where idOrdenCompra = '$id' ";


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
	
	
}
?>