<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
Class Recibo
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($CLIENTE_IDCLIENTE,$HABILITACION_IDHABILITACION,$NRORECIBO,$FECHARECIBO,$TOTAL, $Moneda_idMoneda, $tasaCambio, $tasaCambioBases,$Venta_idVenta,$montoAplicado, $nroCuota,$tipopago, $nroReferencia,$importe_detalle, $banco)
	{
		$usuario = $_SESSION['login'];
		$sql="INSERT INTO `recibo`
							(
							`CLIENTE_IDCLIENTE`,
							`USUARIO`,
							`HABILITACION_IDHABILITACION`,
							`NRORECIBO`,
							`FECHATRANSACCION`,
							`FECHARECIBO`,
							`TOTAL`,
							`USUARIOINSERCION`,
							`INACTIVO`,
							`MONEDA_IDMONEDA`,
							`TASACAMBIO`,
							`TASACAMBIOBASES`
							)
							VALUES
							(
							'$CLIENTE_IDCLIENTE',
							'$usuario',
							'$HABILITACION_IDHABILITACION',
							0,
							now(),
							'$FECHARECIBO',
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

		while ($num_elementos < count($Venta_idVenta))
		{
			$sql_detalle = "INSERT INTO `detallerecibofacturas`(`RECIBO_IDRECIBO`, `VENTA_IDVENTA`, `MONTOAPLICADO`, `INACTIVO`,`CUOTA` )
							VALUES
							(
							'$idrecibonew',
							'$Venta_idVenta[$num_elementos]',
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

					$sql_detalle_factura_pago = "INSERT INTO `detallerecibo`( `RECIBO_IDRECIBO`, `FORMAPAGO_IDFORMAPAGO`, `BANCO_IDBANCO`, `NROCHEQUE`, `MONTO`, `INACTIVO`, `ultimo`,`Moneda_idMoneda`) 
					VALUES 
					('$idrecibonew','$tipopago[$contador]', '$banco[$contador]', '$nroReferencia[$contador]', '$importe_detalle[$contador]',0,1, '$Moneda_idMoneda')";
					ejecutarConsulta($sql_detalle_factura_pago) or $sw = false;
					$contador++;					
					
				}else{

					$sql_detalle_factura_pago = "INSERT INTO `detallerecibo`( `RECIBO_IDRECIBO`, `FORMAPAGO_IDFORMAPAGO`, `BANCO_IDBANCO`, `NROCHEQUE`, `MONTO`, `INACTIVO`, `ultimo`, `Moneda_idMoneda`) 
					VALUES 
					('$idrecibonew','$tipopago[$contador]', 1, '$nroReferencia[$contador]', '$importe_detalle[$contador]',0,0, '$Moneda_idMoneda')";
					ejecutarConsulta($sql_detalle_factura_pago) or $sw = false;
					$contador++;

				}


			

			}
		}

		return $sw;
	}

	
	//Implementamos un método para anular la venta
	public function anular($idRecibo)
	{
		$sql="CALL sp_anular_recibo('$idRecibo')";
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
		$sql="select  F_ESTADO_RECIBO_FACTURAS(IDRECIBO) AS INACTIVOD,IDRECIBO, HABILITACION_IDHABILITACION, FECHARECIBO, persona.razonSocial as nc, USUARIO, TOTAL, recibo.INACTIVO from recibo, persona where persona.idPersona = CLIENTE_IDCLIENTE and HABILITACION_IDHABILITACION = '$HABILITACION_IDHABILITACION'";
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
	public function rpt_recibo_cabecera($idRecibo)
	{
		$sql="
		SELECT dc.timbrado, s.direccion as direccionSucursal, s.nombre as sucursal, s.telefono as telefonoSucursal,  recibo.*, persona.*, u.nombre as cajero, s.correo from recibo 
		JOIN persona ON recibo.CLIENTE_IDCLIENTE = persona.idPersona 
		JOIN usuario u ON u.login = recibo.USUARIO
		JOIN habilitacion h on h.idhabilitacion = recibo.HABILITACION_IDHABILITACION
		JOIN caja c ON c.idcaja = h.Caja_idCaja
        LEFT JOIN documentocajero dc ON dc.Usuario_idUsuario = u.idusuario and dc.Documento_idTipoDocumento = 1
		JOIN sucursal s ON s.idSucursal = c.Sucursal_idSucursal
		WHERE idRecibo = '$idRecibo'

		";
		return ejecutarConsulta($sql);		
	}


	//Implementar un método para listar los registros
	public function rpt_recibo_detalle($idRecibo)
	{
		$sql="SELECT *, IFNULL(CONCAT(CUOTA, '/', cuotas),'1/1') AS impCuota, CONCAT(v.serie, '-', v.nroFactura) AS nroOficial  from detallerecibofacturas dr JOIN venta v ON v.idVenta = dr.VENTA_IDVENTA where  RECIBO_IDRECIBO  = '$idRecibo'";
		return ejecutarConsulta($sql);		
	}


	//Implementar un método para listar los registros
	public function rpt_recibo_detalle_pago($idRecibo)
	{
		$sql="SELECT dp.*, 
fp.*, 
cp.*, b.descripcion as descripcionbanco, p.fechaTransaccion, u.nombre as usuario from detallerecibo dp 
		JOIN formapago fp
		ON dp.FORMAPAGO_IDFORMAPAGO = fp.idFormaPago
		JOIN recibo p ON p.idRecibo = dp.Recibo_idRecibo
		LEFT JOIN usuario u on u.login = p.usuario
		LEFT JOIN chequetercero cp 
		ON dp.NROCHEQUE = cp.idChequeTercero
		LEFT JOIN banco b ON b.idBanco = cp.Banco_idBanco
        where  RECIBO_IDRECIBO = '$idRecibo'";
		return ejecutarConsulta($sql);		
	}




	//Implementar un método para listar los registros
	public function rpt_recibo_detalle_pago_factura($idVenta)
	{
		$sql="SELECT dp.*, 
fp.*, 
cp.*, b.descripcion as descripcionbanco, p.fechaTransaccion, u.nombre as usuario, drf.MONTOAPLICADO from detallerecibo dp 
		JOIN formapago fp
		ON dp.FORMAPAGO_IDFORMAPAGO = fp.idFormaPago
		JOIN recibo p ON p.idRecibo = dp.Recibo_idRecibo
		LEFT JOIN usuario u on u.login = p.usuario
		LEFT JOIN chequetercero cp 
		ON dp.NROCHEQUE = cp.idChequeTercero
		LEFT JOIN banco b 
		ON b.idBanco = cp.Banco_idBanco
		LEFT JOIN detallerecibofacturas drf ON dp.RECIBO_IDRECIBO = drf.RECIBO_IDRECIBO
        where  drf.Venta_idVenta  = '$idVenta' and drf.inactivo = 0;";
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


	public function listarFacturasPendientes($lcliente)
	{
		$sql="SELECT idVenta, nroFactura, fechaFactura, cuotas, sum(detalleventacuotas.saldo) as saldo from venta, detalleventacuotas where venta.idVenta = detalleventacuotas.Venta_idVenta and venta.Cliente_idCliente = '$lcliente' and detalleventacuotas.saldo >0 and venta.inactivo = 0 group by idVenta";
		return ejecutarConsulta($sql);
	}


	public function listarCuotasVenta($lidVenta)
	{
		$sql="SELECT nroCuota, fechaVencimiento, monto, saldo from detalleventacuotas where Venta_idVenta = '$lidVenta' and saldo> 0;";
		return ejecutarConsulta($sql);
	}
	

	public function montoCuota($lidVenta, $lcuota)
	{
		$sql="SELECT saldo from detalleventacuotas where Venta_idVenta = '$lidVenta' and nroCuota = '$lcuota' and saldo> 0;";
		return ejecutarConsultaSimpleFila($sql);
	}


	
}
?>