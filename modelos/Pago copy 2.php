<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
Class Pago
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($Proveedor_idProveedor,$Habilitacion_idHabilitacion,$NROPAGO,$FECHAPAGO,$TOTAL,$Compra_idCompra,$montoAplicado, $nroCuota,$tipopago, $nroReferencia,$importe_detalle, $Moneda_idMoneda, $tasaCambio, $tasaCambioBases, $ChequePropio_idChequePropio)
	{
		$usuario = $_SESSION['login'];
		$sql="INSERT INTO `pago`
							(
							`PROVEEDOR_IDPROVEEDOR`,
							`USUARIO`,
							`HABILITACION_IDHABILITACION`,
							`NROPAGO`,
							`FECHATRANSACCION`,
							`FECHAPAGO`,
							`TOTAL`,
							`USUARIOINSERCION`,
							`inactivo`,
							`MONEDA_IDMONEDA`,
							`TASACAMBIO`,
							`TASACAMBIOBASES`
							
							)
							VALUES
							(
							'$Proveedor_idProveedor',
							'$usuario',
							'$Habilitacion_idHabilitacion',
							0,
							now(),
							'$FECHAPAGO',
							'$TOTAL',
							'$usuario',
							0,
							'$Moneda_idMoneda',
							'$tasaCambio',
							'$tasaCambioBases'
							)
							";

		//return ejecutarConsulta($sql);


		$idrecibonew=ejecutarConsulta_retornarID($sql);

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($Compra_idCompra))
		{
			$sql_detalle = "INSERT INTO `detallepagofacturas`(`PAGO_IDPAGO`, `COMPRA_IDCOMPRA`, `MONTOAPLICADO`, `INACTIVO`,`CUOTA` )
							VALUES
							(
							'$idrecibonew',
							'$Compra_idCompra[$num_elementos]',
							'$montoAplicado[$num_elementos]',
							0,
							'$nroCuota[$num_elementos]'	
							)";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		$contador=0;
		$ultimo = count($tipopago) - 1;
		if ($sw==true) {
			while ($contador < count($tipopago)) {

				if ($contador == $ultimo) {

				$sql_detalle_factura_pago = "INSERT INTO `detallepago`( `PAGO_IDPAGO`, `FORMAPAGO_IDFORMAPAGO`, `BANCO_IDBANCO`, `NROCHEQUE`, `MONTO`, `INACTIVO`, `ultimo`, `ChequePropio_idChequePropio`) 
				VALUES 
				('$idrecibonew','$tipopago[$contador]', 1, '$nroReferencia[$contador]', '$importe_detalle[$contador]',0,1, '$ChequePropio_idChequePropio[$contador]')";
				ejecutarConsulta($sql_detalle_factura_pago) or $sw = false;
				$contador++;
					
				}else{
				$sql_detalle_factura_pago = "INSERT INTO `detallepago`( `PAGO_IDPAGO`, `FORMAPAGO_IDFORMAPAGO`, `BANCO_IDBANCO`, `NROCHEQUE`, `MONTO`, `INACTIVO`, `ultimo`) 
				VALUES 
				('$idrecibonew','$tipopago[$contador]', 1, '$nroReferencia[$contador]', '$importe_detalle[$contador]',0,0)";
				ejecutarConsulta($sql_detalle_factura_pago) or $sw = false;
				$contador++;


				}


			}
		}


		

		return $sw;
	}

	
	//Implementamos un método para anular la venta
	public function anular($idPago)
	{
		$sql="UPDATE pago SET inactivo=1 WHERE idPago='$idPago'";
		return ejecutarConsulta($sql);
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idRecibo)
	{
		$sql="SELECT v.idventa,DATE(v.fecha_hora) as fecha,v.idcliente,p.nombre as cliente,u.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function listarDetalle($idventa)
	{
		$sql="SELECT dv.idventa,dv.idarticulo,a.nombre,dv.cantidad,dv.precio_venta,dv.descuento,(dv.cantidad*dv.precio_venta-dv.descuento) as subtotal FROM detalle_venta dv inner join articulo a on dv.idarticulo=a.idarticulo where dv.idventa='$idventa'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros
	public function listar($HABILITACION_IDHABILITACION)
	{
		//and pago.HABILITACION_IDHABILITACION = '$HABILITACION_IDHABILITACION'
		$sql="SELECT F_ESTADO_PAGO_FACTURAS(IDPAGO) AS INACTIVO, idPago, HABILITACION_IDHABILITACION, FECHAPAGO, persona.razonSocial as nc, USUARIO, TOTAL, pago.inactivo as pci from pago,persona where pago.PROVEEDOR_IDPROVEEDOR = persona.idPersona LIMIT 100
		;";
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

		$sql="SELECT *, articulo.descripcion as descripcionarticulo  FROM detalleventa, articulo WHERE detalleventa.Articulo_idArticulo = articulo.idarticulo and Compra_idCompra='$idVenta'";
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
	public function rpt_op_cabecera($idPago)
	{
		$sql="

		select * from pago, persona WHERE pago.PROVEEDOR_IDPROVEEDOR = persona.idPersona and idPago = '$idPago'

		";
		return ejecutarConsulta($sql);		
	}


	//Implementar un método para listar los registros
	public function rpt_op_detalle($idPago)
	{
		$sql="SELECT * from detallepagofacturas, compra where compra.idCompra = detallepagofacturas.COMPRA_IDCOMPRA AND  PAGO_IDPAGO   = '$idPago';";
		return ejecutarConsulta($sql);		
	}


	//Implementar un método para listar los registros
	public function rpt_op_detalle_pago($idPago)
	{
		$sql="SELECT dp.*, fp.*, cp.*, b.descripcion as descripcionbanco, p.fechaTransaccion, u.nombre as usuario from detallepago dp 
		JOIN formapago fp
		ON dp.FORMAPAGO_IDFORMAPAGO = fp.idFormaPago
		JOIN pago p ON p.idPago = dp.Pago_idPago
		JOIN usuario u on u.login = p.usuario
		LEFT JOIN chequepropio cp 
		ON dp.NROCHEQUE = cp.idChequeEmitido
		LEFT JOIN banco b ON b.idBanco = cp.Banco_idBanco
		where  PAGO_IDPAGO = '$idPago';";
		return ejecutarConsulta($sql);		
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function cabecera($habilitacion)
	{

		$sql="SELECT
			sucursal.ciudad as ciudad,
			sucursal.direccion,
			sucursal.correo,
			sucursal.telefono,
			sucursal.nombre,
			documentocajero.timbrado as timbrado,
			documentocajero.fechaEntrega as vencimiento
			FROM habilitacion, caja,sucursal, deposito, documentocajero
			where
		    habilitacion.idhabilitacion = 5 and 
			caja.idcaja = habilitacion.Caja_idCaja and 
			caja.Sucursal_idSucursal = sucursal.idsucursal  and deposito.Sucursal_idSucursal = sucursal.idSucursal and documentocajero.Usuario_idUsuario = habilitacion.Usuario_idUsuario limit 1";


		return ejecutarConsulta($sql);
	}
            

	//Implementar un método para mostrar los datos de un registro a modificar
	public function ultimo()
	{
		$sql="select max(nroFactura) as maximo from venta where venta.tipo_comprobante = 2";


		return ejecutarConsultaSimpleFila($sql);
	}


	public function selectFacturasProveedor($lProveedor)
	{
		$sql="SELECT *, idCompra, nroFactura, fechaFactura, 1 as  cuotas, compra.saldo, compra.fechaVencimiento
		from compra where  
		compra.Persona_idPersona = '$lProveedor' and compra.saldo >0 and 
		compra.inactivo = 0 group by idCompra";
		return ejecutarConsulta($sql);
	}


	public function listarCuotasCompra($lidCompra)
	{
		$sql="SELECT nroCuota, fechaVencimiento, monto, saldo from detallecompracuotas where Compra_idCompra = '$lidCompra' and saldo> 0;";
		return ejecutarConsulta($sql);
	}
	

	public function montoCuota($lidCompra, $lcuota)
	{
		$sql="SELECT * FROM detallecompracuotas where saldo > 0 and inactivo = 0 and Compra_idCompra='$lidCompra' and nroCuota = '$lcuota'";
		return ejecutarConsultaSimpleFila($sql);
	}



	public function cargarMoneda($lidCompra)
	{
		$sql="SELECT * FROM compra where idCompra = '$lidCompra' ";
		return ejecutarConsultaSimpleFila($sql);
	}


	
}
?>