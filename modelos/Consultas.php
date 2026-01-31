<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Consultas
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}




	

public function rpt_direcciones_view($Persona_idPersona)
{
    $sql = "
    SELECT  
		d.imagen,
        d.idDireccion,
        c.descripcion AS ciudad,
        d.direccion,
        d.latitud AS lat,
        d.longitud AS lng,
        MAX(CASE WHEN ar.diaSemana='lunes'     THEN v.nombreReferencia END) AS lunes,
        MAX(CASE WHEN ar.diaSemana='martes'    THEN v.nombreReferencia END) AS martes,
        MAX(CASE WHEN ar.diaSemana='miercoles' THEN v.nombreReferencia END) AS miercoles,
        MAX(CASE WHEN ar.diaSemana='jueves'    THEN v.nombreReferencia END) AS jueves,
        MAX(CASE WHEN ar.diaSemana='viernes'   THEN v.nombreReferencia END) AS viernes,
        MAX(CASE WHEN ar.diaSemana='sabado'    THEN v.nombreReferencia END) AS sabado,
        MAX(CASE WHEN ar.diaSemana='domingo'   THEN v.nombreReferencia END) AS domingo
    FROM direccion d
    JOIN ciudad2 c ON c.code = d.Ciudad_idCiudad
    LEFT JOIN direccion_asignacion_ruta ar ON ar.Direccion_idDireccion = d.idDireccion
    LEFT JOIN vehiculo v ON v.idVehiculo = ar.Vehiculo_idVehiculo
    WHERE d.Persona_idPersona = '$Persona_idPersona'
    GROUP BY d.idDireccion
    ORDER BY ciudad, direccion
    ";

    return ejecutarConsulta($sql);
}



	public function rpt_ajustes_detalleProd($idProduccion)
	{
		$sql="SELECT idProduccionDetalle as Item, producciondetalle.Produccion_idProduccion, Articulo_idArticulo, articulo.descripcion, 
		Deposito_idDeposito,cantidad,cantidadReal
			from producciondetalle, articulo 
			where producciondetalle.Articulo_idArticulo = articulo.idArticulo and  producciondetalle.Produccion_idProduccion =  '$idProduccion';
            ";
		return ejecutarConsulta($sql);
	} 
	public function rpt_precioventa($idArticulo)  
	{
		$sql="SELECT a.idArticulo, g.descripcion AS Descripcion ,p.precio AS Precio, idPrecio, precio, p.usuarioIns, p.usuarioMod,
		p.fechaMod,p.fechaIns
				FROM articulo a
				JOIN precio p ON a.idArticulo = p.Articulo_idArticulo 
				JOIN grupopersona g ON g.idGrupoPersona = p.GrupoPersona_idGrupoPersona
				WHERE p.Articulo_idArticulo = '$idArticulo' and g.inactivo = 0 ORDER BY p.idPrecio ASC"; 
		return ejecutarConsulta($sql);
	}
	public function ajuste_actualizar_precio($precio,$idPrecio)
	{
		$usuarioname = $_SESSION['login'];
		$sql="UPDATE precio p set p.precio = '$precio', p.usuarioMod= '$usuarioname', p.fechaMod = NOW()
		WHERE p.idPrecio = '$idPrecio'";
		return ejecutarConsulta($sql);
	}
	
	public function registrosRepartidor()
	{
		$sql="SELECT count(*) as cantidadRegistrada, usuarioInsercion, COUNT(CASE WHEN DATE(fechaInsercion) = CURDATE() THEN 1 ELSE NULL END) AS cantidadRegistradaHoy  from direccion where usuarioInsercion not in ( ' ADMIN ', 'admin' ) group by usuarioInsercion;";
		return ejecutarConsulta($sql);
	}


	public function rptventasArticulo($fecha_inicio,$fecha_fin, $cliente)
	{
		$sql="CALL SP_ListadoVentasArticulo('$cliente','1','$fecha_inicio','$fecha_fin')";
		return ejecutarConsulta($sql);
	}


	public function rptrecibosDetalle($fecha_inicio,$fecha_fin, $cliente)
	{
		$sql="CALL SP_ListadoRecibosDetalle('$cliente','1','$fecha_inicio','$fecha_fin')";
		return ejecutarConsulta($sql);
	}
	

	public function rptrecibosDetalle2($fecha_inicio,$fecha_fin, $cliente)
	{
		$sql="CALL SP_ListadoRecibosDetalle2('$cliente','1','$fecha_inicio','$fecha_fin')";
		return ejecutarConsulta($sql);
	}

	public function rptncventas($fecha_inicio,$fecha_fin, $cliente)
	{
		$sql="CALL SP_ListadoNotasCredito('$cliente','1','$fecha_inicio','$fecha_fin')";
		return ejecutarConsulta($sql);
	}	

	public function comprasfecha($fecha_inicio,$fecha_fin)
	{
		$sql="SELECT DATE(i.fecha_hora) as fecha,u.nombre as usuario, p.nombre as proveedor,i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,i.total_compra,i.impuesto,i.estado FROM ingreso i INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN usuario u ON i.idusuario=u.idusuario WHERE DATE(i.fecha_hora)>='$fecha_inicio' AND DATE(i.fecha_hora)<='$fecha_fin'";
		return ejecutarConsulta($sql);		
	}

	public function ventasfechacliente($fecha_inicio,$fecha_fin,$idcliente)
	{
		$sql="SELECT DATE(v.fecha_hora) as fecha,u.nombre as usuario, p.nombre as cliente,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE DATE(v.fecha_hora)>='$fecha_inicio' AND DATE(v.fecha_hora)<='$fecha_fin' AND v.idcliente='$idcliente'";
		return ejecutarConsulta($sql);		
	}


	public function rpt_libro_ventas_avanzado1($fecha_inicio,$fecha_fin,$proceso)
	{
		$sql="CALL SP_Hechauka_VentasRG('$fecha_inicio','$fecha_fin')";
		return ejecutarConsulta($sql);		
	}	


	public function rpt_libro_compras_avanzado1($fecha_inicio,$fecha_fin,$proceso)
	{
		$sql="CALL SP_Hechauka_ComprasRG('$fecha_inicio','$fecha_fin')";
		return ejecutarConsulta($sql);		
	}	
		

	public function totalcomprahoy()
	{
		$sql="SELECT IFNULL(SUM(total_compra),0) as total_compra FROM ingreso WHERE DATE(fecha_hora)=curdate()";
		return ejecutarConsulta($sql);
	}

	public function totalventahoy()
	{
		$sql="SELECT IFNULL(SUM(total_venta),0) as total_venta FROM venta WHERE DATE(fecha_hora)=curdate()";
		return ejecutarConsulta($sql);
	}

	public function comprasultimos_10dias()
	{
		$sql="SELECT CONCAT(DAY(fecha_hora),'-',MONTH(fecha_hora)) as fecha,SUM(total_compra) as total FROM ingreso GROUP by fecha_hora ORDER BY fecha_hora DESC limit 0,10";
		return ejecutarConsulta($sql);
	}

	public function top_10_articulos()
	{
		$sql="SELECT * from articulo order by idArticulo desc limit 10";
		return ejecutarConsulta($sql);
	}

	public function top_10_articulos_vendidos()
	{
		$sql="select Articulo_idArticulo, sum(cantidad) as Cantidad_Vendida from detalleventa, venta where venta.idVenta = detalleventa.idDetalleVenta group by Articulo_idArticulo limit 10";
		return ejecutarConsulta($sql);
	}

	public function articulos_vendidos()
	{
		$sql="SELECT Articulo_idArticulo, F_NOMBRE_ARTICULO(detalleventa.Articulo_idArticulo) as n, 
		sum(cantidad) as cantidad 
		from detalleventa, venta 
		where venta.idVenta = detalleventa.idDetalleVenta 
		group by Articulo_idArticulo
		order by cantidad desc";
		return ejecutarConsulta($sql); 
	}
 
	public function rpt_asiento_detalle($idAsiento)   
	{
		$sql="SELECT b.ano as ProcesoDesc,c.descripcion as cuentaContableDesc,d.descripcion as cuentaCorrienteDesc,(CASE tipoMovimiento
	         WHEN 1 THEN 'Debito'
	         ELSE 'Credito'
	      END) as tipoMovimientoDesc,(CASE tipoMovimiento
	         WHEN 1 THEN importe
	         ELSE 0
	      END) as Debito,
	      (CASE tipoMovimiento
	         WHEN 2 THEN importe
	         ELSE 0
	      END) as Credito,a.nroCheque,a.nroComprobante,f.descripcion as concepto
			from asientodetalle a 
			left outer join proceso b on a.Proceso_idProceso=b.idProceso
			left outer join cuentacontable c on a.CuentaContable_idCuentaContable=c.idCuentaContable
			left outer join cuentacorriente d on a.CuentaCorriente_idCuentaCorriente=d.idCuentaCorriente
			left outer join concepto f on a.Concepto_idConcepto=f.idConcepto  
			where a.Asiento_idAsiento= '$idAsiento' and a.inactivo=0"; 	
			return ejecutarConsulta($sql);   	
	}




	public function actualizarMontoCierre($item,$montoCierre)
	{
		$sql="UPDATE detallehabilitacion set montoCierre = '$montoCierre' WHERE idDetalleHabilitacion = '$item' ";
		return ejecutarConsulta($sql);
	}



	public function actualizarMontoApertura($item,$montoApertura)
	{
		$sql="UPDATE detallehabilitacion set montoApertura = '$montoApertura' WHERE idDetalleHabilitacion = '$item' ";
		return ejecutarConsulta($sql);
	}




	public function rpt_asiento_detalle_vista($idCompra)   
	{
		$sql="CALL SP_GenerarAsientoVista('$idCompra', 'admin', '1')"; 	
			return ejecutarConsulta($sql);   	
	}


	public function rpt_vehiculo_detalle($idPersona)   
	{
		$sql="SELECT a.matricula,a.anhoVehiculo,a.vencimientoMatricula,a.comentarioHabilitacion, (CASE tipoVehiculo
	         WHEN 1 THEN 'Particular'
	         WHEN 2 THEN 'Laboral'
	         	         ELSE 'OTROS' 
	      END) as tipoVehiculo
			from vehiculo a 
			where a.Persona_idPersona= '$idPersona' "; 	
			return ejecutarConsulta($sql);	 	 
	}

	public function rpt_documento_detalle($idPersona)   
	{
		$sql="SELECT a.imagenCIFrontal,a.imagenCITrasera,a.comentarioCi,a.estadoCi,a.vencimientoCi,a.imagenLicenciaConducirFrontal,a.imagenLicenciaConducirTrasera
		/*,a.comentarioLicenciaConducir,a.estadoLicenciaConducir,a.vencimientoLicenciaConducir,a.imagenAntecedentePolicial,a.comentarioAntecedente,a.estadoAntecedente,a.vencimientoAntecedente,a.inactivo*/
			from documentopersonal a  
			where a.Persona_idPersona= '$idPersona' ";   	
			return ejecutarConsulta($sql);	 	 
	}


	public function rpt_telefono_detalle($idPersona)   
	{
		$sql="SELECT (CASE TipoDireccion_Telefono_idTipoDireccion_Telefono
	         WHEN 1 THEN 'Particular'
	         WHEN 2 THEN 'Laboral'
	         	         ELSE 'OTROS' 
	      END) as TipoDireccion_Telefono_idTipoDireccion_Telefono,a.telefono,a.fechaModificacion,a.fechaInsercion, a.usuarioInsercion
			from telefono a 
			where a.Persona_idPersona= '$idPersona' and a.inactivo=0 "; 	
			return ejecutarConsulta($sql);	 	 
	}	


	public function rpt_direccion_detalle($idPersona)   
	{
		$sql="SELECT callePrincipal,
					 calleTransversal,
					 nroCasa,
					 fechaInsercion,
		(CASE TipoDireccion_Telefono_idTipoDireccion_Telefono
	         WHEN 1 THEN 'Particular'
	         WHEN 2 THEN 'Laboral'
	         	         ELSE 'OTROS' 
	      END) as TipoDireccion_Telefono_idTipoDireccion_Telefono,
	      longitud,
	      latitud
			from direccion a 
			where a.Persona_idPersona= '$idPersona' and a.inactivo=0 "; 	
			return ejecutarConsulta($sql);	 	 
	}	


	public function top_10_articulos_comprados()
	{
		$sql="select Articulo_idArticulo, sum(cantidad) as Cantidad_Comprada from compra, detallecompra where compra.idCompra = detallecompra.idDetalleCompra group by Articulo_idArticulo limit 10";
		return ejecutarConsulta($sql);
	}

	public function rpt_ventas_habilitacion($habilitacion)
	{
		$sql="SELECT venta.idVenta, Habilitacion_idHabilitacion ,cliente.idCliente, cliente.razonSocial, cliente.nombreComercial,venta.totalImpuesto,  venta.total , venta.inactivo as vi, venta.saldo as saldo, venta.tipo_comprobante as tipo_comprobante
		from cliente, venta 
		where venta.Cliente_idCliente = cliente.idCliente and Habilitacion_idHabilitacion = '$habilitacion' and venta.inactivo = 0";
		return ejecutarConsulta($sql);
	}

	public function rpt_recibos_fecha($fi,$ff)
	{
		$sql="SELECT recibo.inactivo , recibo.Habilitacion_idHabilitacion,  IDRECIBO, razonSocial, recibo.USUARIO as usuario, recibo.FECHARECIBO, recibo.TOTAL 
from recibo,cliente 
where cliente.idCliente = recibo.CLIENTE_IDCLIENTE and recibo.FECHARECIBO 
between '$fi' and '$ff' and recibo.INACTIVO = 0 and F_ESTADO_RECIBO_FACTURAS(recibo.IDRECIBO) = 0;";
		return ejecutarConsulta($sql);
	}

	public function rpt_ventas_fecha($fi,$ff)
	{
		$sql="SELECT *, venta.idVenta, Habilitacion_idHabilitacion ,cliente.idCliente, cliente.razonSocial, cliente.nombreComercial,venta.totalImpuesto,  venta.total, venta.inactivo as vi
			from cliente, venta 
			where venta.Cliente_idCliente = cliente.idCliente and fechaFactura between '$fi' and '$ff'";
		return ejecutarConsulta($sql);
	}

	public function rpt_ventas_fecha_giftCard($fi,$ff)
	{
		$sql="SELECT *, venta.idVenta, Habilitacion_idHabilitacion ,cliente.idCliente, cliente.razonSocial, cliente.celular, cliente.nombreComercial, F_NOMBRE_CLIENTE(clienteGiftCard) ncg, F_NRO_CLIENTE(clienteGiftCard) nucg, venta.giftCard, venta.nroGiftCard  ,venta.totalImpuesto,  venta.total, venta.inactivo as vi
			from cliente, venta 
			where venta.Cliente_idCliente = cliente.idCliente and fechaFactura between '$fi' and '$ff' and venta.giftCard > 0;";
		return ejecutarConsulta($sql);
	}

	public function rpt_cobros_fecha($fi,$ff)
	{
		$sql="SELECT terminopago.descripcion, detallerecibo.FORMAPAGO_IDFORMAPAGO, sum(monto) as total
		from detallerecibo, recibo, terminopago
		where 
		recibo.IDRECIBO = detallerecibo.RECIBO_IDRECIBO and 
		terminopago.idTerminoPago = detallerecibo.FORMAPAGO_IDFORMAPAGO 
		and recibo.FECHARECIBO between '$fi' and '$ff' and 
		recibo.INACTIVO = 0 and 
		detallerecibo.INACTIVO = 0 and 
		F_ESTADO_RECIBO_FACTURAS(recibo.idRecibo) = 0 
		group by detallerecibo.FORMAPAGO_IDFORMAPAGO;";
		return ejecutarConsulta($sql);
	}


	public function rpt_ventas_fecha_activos($fi,$ff)
	{
		$sql="SELECT venta.idVenta, Habilitacion_idHabilitacion ,cliente.idCliente, cliente.razonSocial, cliente.nombreComercial,venta.totalImpuesto,  venta.total, venta.inactivo as vi
			from cliente, venta 
			where venta.Cliente_idCliente = cliente.idCliente and fechaFactura between '$fi' and '$ff' and venta.inactivo = 0";
		return ejecutarConsulta($sql);
	}
	
	public function rpt_ventas_fecha_deposito($fi,$ff,$deposito)
	{
		$sql="SELECT venta.idVenta, Habilitacion_idHabilitacion ,cliente.idCliente, cliente.razonSocial, cliente.nombreComercial,venta.totalImpuesto,  venta.total, venta.inactivo as vi
			from cliente, venta 
			where venta.Cliente_idCliente = cliente.idCliente and fechaFactura between '$fi' and '$ff' and Deposito_idDeposito = '$deposito'";
		return ejecutarConsulta($sql);
	}


	public function rpt_ventas_detalle($idVenta)
	{
		$sql="SELECT idDetalleVenta as Item, Venta_idVenta, Articulo_idArticulo, nombre, descripcion, precio, cantidad, total 
		from detalleventa, articulo 
		where detalleventa.Articulo_idArticulo = articulo.idArticulo and  Venta_idVenta = '$idVenta'";
		return ejecutarConsulta($sql);
	}

	public function rpt_ordenCompras_detalle($idOrdenCompra) 
	{
		$sql="SELECT 
idDetalleOrdenCompra as Item, OrdenCompra_idOrdenCompra, Articulo_idArticulo, nombre, detalleordencompra.descripcion, precio, descuento ,cantidad, total 
from detalleordencompra, articulo 
where detalleordencompra.Articulo_idArticulo = articulo.idArticulo and  OrdenCompra_idOrdenCompra = '$idOrdenCompra'";
		return ejecutarConsulta($sql);
	}

	public function rpt_habilitacion_detalle($Habilitacion_idHabilitacion) 
	{
		$sql="SELECT 
idDetalleHabilitacion as Item, detallehabilitacion.Habilitacion_idHabilitacion, moneda.descripcion as Moneda_idMoneda, detallemoneda.descripcion as Denominacion_idDenominacion, detallehabilitacion.montoApertura, detallehabilitacion.montoCierre, detallehabilitacion.estado 
from detallehabilitacion, habilitacion , moneda , detallemoneda
where detallehabilitacion.Habilitacion_idHabilitacion = habilitacion.idHabilitacion 
and detallemoneda.Moneda_idMoneda=moneda.idMoneda and detallehabilitacion.Moneda_idMoneda=moneda.idMoneda and detallehabilitacion.Denominacion_idDenominacion=detallemoneda.idDetalleMoneda and  detallehabilitacion.Habilitacion_idHabilitacion = '$Habilitacion_idHabilitacion' ";
		return ejecutarConsulta($sql);
	}	
	
	public function rpt_ordenVentas_detalle($idOrdenVenta)
	{
		$sql="SELECT idDetalleOrdenVenta as Item, OrdenVenta_idOrdenVenta, Articulo_idArticulo, nombre, articulo.descripcion, precio, descuento ,cantidad, total 
		from detalleordenventa, articulo 
		where detalleordenventa.Articulo_idArticulo = articulo.idArticulo and  OrdenVenta_idOrdenVenta = '$idOrdenVenta'";
		return ejecutarConsulta($sql);
	}
	
	public function rpt_ordenVentas_detalle2($idOrdenVenta)
	{
		$sql="SELECT idDetalleVenta as Item, Venta_idVenta as OrdenVenta_idOrdenVenta, Articulo_idArticulo, nombre, articulo.descripcion, precio ,cantidad, total 
		from detalleventa as detalleordenventa, articulo 
		where detalleordenventa.Articulo_idArticulo = articulo.idArticulo and  Venta_idVenta = '$idOrdenVenta';";
		return ejecutarConsulta($sql);
	}

	public function rpt_notacreditoventa_detalle($idNotaCreditoVenta)  
	{
		$sql="SELECT b.nombre,a.cantidad,a.devuelve,a.totalNeto,a.total
				from notacreditoventadetalle a, articulo b
				where a.Articulo_idArticulo=b.idArticulo and a.inactivo=0 and a.NotaCreditoVenta_idNotaCreditoventa='$idNotaCreditoVenta'";
		return ejecutarConsulta($sql);
	}	 	

	public function rpt_notacreditocompra_detalle($idNotaCreditoCompra)  
	{ 
		$sql="SELECT b.nombre,a.cantidad,a.devuelve,a.totalNeto,a.total
				from notacreditocompradetalle a, articulo b
				where a.Articulo_idArticulo=b.idArticulo and a.inactivo=0 and a.NotaCreditoCompra_idNotaCreditoCompra='$idNotaCreditoCompra'";
		return ejecutarConsulta($sql);
	}	 	
	
	public function rpt_comodato($idPersona)  
	{
		$sql="SELECT b.nombre,a.cantidad,c.descripcion
				from stock a, articulo b, deposito c
				where a.Articulo_idArticulo=b.idArticulo and a.Persona_idPersona='$idPersona' and a.inactivo=0
				  and a.Deposito_idDeposito = c.idDeposito and a.cantidad > 0"; 
		return ejecutarConsulta($sql);
	}	 

	public function rpt_direcciones($idPersona)  
	{
		$sql="SELECT d.imagen, c.descripcion as descripcion , d.direccion as direccion,d.latitud as latitud, d.idDireccion,
		d.longitud as longitud, domingo , lunes , martes , miercoles , jueves , viernes ,sabado , v.nombreReferencia as vehiculo 
		FROM persona p 
		JOIN direccion d ON d.Persona_idPersona = p.idPersona
		JOIN ciudad2 c ON c.code = d.Ciudad_idCiudad
		JOIN vehiculo v ON v.idVehiculo = d.Vehiculo_idVehiculo
		WHERE p.idPersona = '$idPersona'"; 
		return ejecutarConsulta($sql);
	}

	public function rpt_movimiento_stock($idMovimientoStock)  
	{
		$sql="SELECT b.nombre,a.cantidad,a.precio,a.total
				from movimientostockdetalle a, articulo b
				where a.Articulo_idArticulo=b.idArticulo and a.MovimientoStock_idMovimientoStock='$idMovimientoStock' and a.inactivo=0";
		return ejecutarConsulta($sql);
	}	 	

	public function rpt_cobros_detalle($idVenta)
	{
		$sql="SELECT *, venta.idVenta as idVenta, detallerecibo.monto as monto, recibo.FECHARECIBO as fecha from venta,recibo, detallerecibofacturas, detallerecibo, terminopago where venta.idVenta = detallerecibofacturas.VENTA_IDVENTA
		and detallerecibofacturas.RECIBO_IDRECIBO = recibo.IDRECIBO and detallerecibofacturas.RECIBO_IDRECIBO = detallerecibo.RECIBO_IDRECIBO and 
		venta.idVenta='$idVenta' and terminopago.idTerminoPago = detallerecibo.FORMAPAGO_IDFORMAPAGO and detallerecibo.inactivo = 0";
		return ejecutarConsulta($sql);
	}

	public function rpt_pagos_detalle_todos($idCompra)
	{
		$sql="SELECT 
compra.idCompra as idCompra, detallepago.monto as monto, 
pago.FECHAPAGO as fecha, descripcion 
from compra,
pago, 
detallepagofacturas, 
detallepago, 
formapago 
where 
compra.idCompra = detallepagofacturas.COMPRA_IDCOMPRA
and detallepagofacturas.PAGO_IDPAGO = pago.IDPAGO 
and detallepagofacturas.PAGO_IDPAGO = detallepago.PAGO_IDPAGO and 
compra.idCompra='$idCompra' and formapago.idFormaPago = detallepago.FORMAPAGO_IDFORMAPAGO and detallepago.inactivo = 0 group by detallepago.FORMAPAGO_IDFORMAPAGO";
		return ejecutarConsulta($sql);
	}


	public function rpt_cobros_detalle_recibo($idRecibo)
	{
		$sql="SELECT *, r.IDRECIBO as idRecibo, dr.monto as monto from recibo r 
			JOIN detallerecibo dr ON r.IDRECIBO = dr.RECIBO_IDRECIBO
			JOIN formapago fp ON fp.idFormaPago = dr.FORMAPAGO_IDFORMAPAGO
			WHERE IDRECIBO = '$idRecibo' and dr.inactivo = 0";
		return ejecutarConsulta($sql);
	}


	public function rpt_cobros_detalle_pago($idRecibo)
	{
		$sql="SELECT *, pago.idPago as idPago, detallepago.MONTO as monto, formapago.idFormaPago from compra, pago, detallepagofacturas, detallepago, formapago
where compra.idCompra = detallepagofacturas.COMPRA_IDCOMPRA and detallepagofacturas.PAGO_IDPAGO = pago.idPago and detallepagofacturas.PAGO_IDPAGO = detallepago.PAGO_IDPAGO
and pago.idPago = '$idRecibo' and formapago.idFormaPago = detallepago.FORMAPAGO_IDFORMAPAGO and detallepago.INACTIVO = 0;";
		return ejecutarConsulta($sql);
	}
	
	public function rpt_cuentasAPagar($fechai, $fechaf, $orden, $proveedor)
	{
		$sql="CALL SP_CuentasAPagar('$proveedor')";
		return ejecutarConsulta($sql);
	}
	

	public function rpt_movimientos($fechai, $fechaf, $orden, $proveedor)
	{
		if ($proveedor == null || $proveedor  == '%%'){
			$sql = "select *, formapago.descripcion as fp,
			CASE
	    		WHEN Empleado_idEmpleado > 0 THEN (select razonSocial from persona where idPersona = Empleado_idEmpleado)
	    		WHEN Empleado_idEmpleado = 0 THEN ''
			END nombreComercial,movimiento.descripcion as md,DATE_FORMAT(movimiento.fechaTransaccion, '%d/%m/%Y') as fechaTrn , concepto.descripcion as nc, movimiento.inactivo as mi 
			from movimiento, concepto , formapago where formapago.idFormaPago = TerminoPago_idTerminoPago and  movimiento.inactivo = 0 and movimiento.concepto = concepto.idConcepto AND  date(movimiento.fechaTransaccion)  between '$fechai' and '$fechaf'  
			  ";	

		  }
		  else{
			$sql = "select *, formapago.descripcion as fp,
			CASE
	    		WHEN Empleado_idEmpleado > 0 THEN (select razonSocial from persona where idPersona = Empleado_idEmpleado)
	    		WHEN Empleado_idEmpleado = 0 THEN ''
			END nombreComercial,movimiento.descripcion as md,DATE_FORMAT(movimiento.fechaTransaccion, '%d/%m/%Y') as fechaTrn , concepto.descripcion as nc, movimiento.inactivo as mi 
			from movimiento, concepto, formapago where formapago.idFormaPago = TerminoPago_idTerminoPago and movimiento.inactivo = 0 and movimiento.concepto = concepto.idConcepto AND  date(movimiento.fechaTransaccion)  between '$fechai' and '$fechaf' and Empleado_idEmpleado =  $proveedor
			  ";	

		  }	
		  return ejecutarConsulta($sql);
	}
	public function rpt_cuentasAPagarAvanzado($fechai, $fechaf, $orden, $proveedor)
	{
		$sql="CALL SP_CuentasAPagarCompleto('$proveedor')";
		return ejecutarConsulta($sql);
	}


	public function rpt_cuentasACobrar($fechai, $fechaf, $orden, $cliente)
	{
		$sql="CALL SP_CuentasACobrar('$cliente')";  
		return ejecutarConsulta($sql);
	}

	public function rpt_cuentasACobrarPorCliente($fechai, $fechaf, $orden, $cliente)
	{
		$sql="CALL SP_CuentasACobrarPorCliente('$cliente')"; 
		return ejecutarConsulta($sql);
	}

	public function rpt_compras_habilitacion($habilitacion)
	{
		$sql="SELECT compra.idCompra, Habilitacion_idHabilitacion ,proveedor.idProveedor, proveedor.razonSocial, proveedor.nombreComercial,compra.totalImpuesto,  compra.total , compra.inactivo as vi
			from proveedor, compra 
			where compra.Proveedor_idProveedor = proveedor.idProveedor and Habilitacion_idHabilitacion = '$habilitacion'";
		return ejecutarConsulta($sql);
	}


	public function rpt_compras_fecha($fi,$ff)
	{
		$sql="SELECT compra.idCompra, Habilitacion_idHabilitacion ,proveedor.idProveedor, proveedor.razonSocial, proveedor.nombreComercial,compra.totalImpuesto,  compra.total , compra.inactivo as vi
			from proveedor, compra 
			where compra.Proveedor_idProveedor = proveedor.idProveedor and fechaFactura between '$fi' and '$ff'";
		return ejecutarConsulta($sql);
	}

	public function rpt_compras_detalle($idCompra)
	{
		$sql="SELECT idDetalleCompra as Item, Compra_idCompra, Articulo_idArticulo, nombre, articulo.descripcion, precio, cantidad, total, descuento
			from detallecompra, articulo 
			where detallecompra.Articulo_idArticulo = articulo.idArticulo and  Compra_idCompra = '$idCompra'";
		return ejecutarConsulta($sql);
	}

	public function rpt_ajustes_detalle($idAjusteStock)
	{
		$sql="SELECT idajustestockdetalle as Item, ajustestockdetalle.AjusteStock_idAjusteStock, Articulo_idArticulo, articulo.descripcion, Deposito_idDeposito,cantidad,cantidadReal
			from ajustestockdetalle, articulo 
			where ajustestockdetalle.Articulo_idArticulo = articulo.idArticulo and  ajustestockdetalle.AjusteStock_idAjusteStock = '$idAjusteStock'";
		return ejecutarConsulta($sql);
	}

	public function rpt_nc_detalle($idNotaCredito)
	{
		$sql="
		SELECT *, 
		F_NOMBRE_ARTICULO(Articulo_idArticulo) as nombre, 
		F_DESCRIPCION_ARTICULO(Articulo_idArticulo) as descripcion
		from notacreditocompradetalle WHERE  NotaCreditoCompra_idNotaCreditoCompra = '$idNotaCredito'";
				return ejecutarConsulta($sql);
	}

	public function rpt_ncv_detalle($idNotaCredito)
	{
		$sql="
		SELECT *, 
		F_NOMBRE_ARTICULO(Articulo_idArticulo) as nombre, 
		F_DESCRIPCION_ARTICULO(Articulo_idArticulo) as descripcion
		from notacreditoventadetalle WHERE  NotaCreditoVenta_idNotaCreditoVenta = '$idNotaCredito'";
				return ejecutarConsulta($sql);
	}


	public function rpt_inventario_deposito($idDeposito)
	{
		$sql="SELECT *,a.nombre as na, c.nombre as nc, SUM(cantidad) as stock 
FROM stock s JOIN articulo a ON s.Articulo_idArticulo = a.idArticulo
LEFT JOIN categoria c ON c.idCategoria = a.Categoria_idCategoria
WHERE s.Deposito_idDeposito = '$idDeposito' and a.inactivo = 0 and s.inactivo = 0 and s.cantidad and a.tipoArticulo in ('PRODUCTO')
GROUP BY a.idArticulo, s.Deposito_idDeposito";
		#$sql="SELECT *,articulo.nombre as na, categoria.nombre as nc FROM stock,articulo, categoria where articulo.Categoria_idCategoria = categoria.idCategoria and stock.Articulo_idArticulo = articulo.idArticulo and stock.cantidad <> 0 and stock.Deposito_idDeposito = '$idDeposito'";
		return ejecutarConsulta($sql);
	}

	public function rpt_inventario_deposito_ajuste($idDeposito)
	{
		$sql="SELECT *,articulo.nombre as na, categoria.nombre as nc FROM stock,articulo, categoria where articulo.Categoria_idCategoria = categoria.idCategoria and stock.Articulo_idArticulo = articulo.idArticulo  and stock.Deposito_idDeposito = '$idDeposito' and articulo.inactivo = 0";
		return ejecutarConsulta($sql);
	}

	public function rpt_inventario_deposito_deposito($idDeposito)
	{
		$sql="SELECT *,articulo.nombre as na, categoria.nombre as nc FROM stock,articulo, categoria where articulo.Categoria_idCategoria = categoria.Categoria_idCategoria and stock.Articulo_idArticulo = articulo.idArticulo  and stock.Deposito_idDeposito = '$idDeposito'";
		return ejecutarConsulta($sql);
	}

	public function ajuste_actualizar($cantidad,$articulo,$deposito)
	{
		$sql="UPDATE stock set Cantidad = '$cantidad' WHERE Articulo_idArticulo = '$articulo' and Deposito_idDeposito = '$deposito'";
		return ejecutarConsulta($sql);
	}

	
	public function ajuste_actualizar_clientedetalle($cantidad,$id)
	{
		$sql="UPDATE clientedetalle set Cantidad = '$cantidad' WHERE idclientedetalle = '$id'";
		return ejecutarConsulta($sql);
	}


	public function rpt_arqueo_caja($habilitacion)
	{
		$sql="SELECT HABILITACION_IDHABILITACION as habilitacion, FECHARECIBO, recibo.USUARIOINSERCION,formapago.descripcion,moneda.descripcion as moneda, 
					sum(detallerecibo.MONTO/detallerecibo.tasaCambio) as total,sum(detallerecibo.MONTO) as totalgs, 
					formapago.idFormaPago as id
				FROM recibo, detallerecibo, formapago , moneda
				where  
				recibo.IDRECIBO = detallerecibo.RECIBO_IDRECIBO and 
				formapago.idFormaPago = detallerecibo.FORMAPAGO_IDFORMAPAGO and moneda.idMoneda=detallerecibo.Moneda_idMoneda and 
				HABILITACION_IDHABILITACION = '$habilitacion' and F_ESTADO_RECIBO_FACTURAS(recibo.IDRECIBO) = 0
				 group by formapago.idFormaPago,moneda.descripcion
                ORDER BY `recibo`.`FECHATRANSACCION` DESC;";
		return ejecutarConsulta($sql);
	}



	public function rpt_arqueo_caja_cobranzas_movimientos($habilitacion)
	{
		$sql="SELECT 
					t.usuario,
					t.formaPago,
					SUM(t.total)   AS total
				FROM (
					SELECT 
						r.USUARIO                               AS usuario,
						fp.descripcion                          AS formaPago,
						fp.tipo                                 AS tipoFormaPago,
						m.descripcion                           AS moneda,
						SUM(dr.MONTO / dr.tasaCambio)           AS total,
						SUM(dr.MONTO)                           AS totalgs
					FROM recibo r
					INNER JOIN detallerecibo dr ON r.IDRECIBO = dr.RECIBO_IDRECIBO
					INNER JOIN formapago fp ON fp.idFormaPago = dr.FORMAPAGO_IDFORMAPAGO
					INNER JOIN moneda m ON m.idMoneda = dr.Moneda_idMoneda
					INNER JOIN habilitacion h ON r.HABILITACION_IDHABILITACION = h.idhabilitacion
					WHERE 
						(h.idhabilitacion ) = '$habilitacion'
						AND F_ESTADO_RECIBO_FACTURAS(r.IDRECIBO) = 0
					GROUP BY r.USUARIO, fp.descripcion, fp.tipo, m.descripcion
					UNION ALL
					SELECT 
						m.usuario                               AS usuario,
						f.descripcion                           AS formaPago,
						f.tipo                                  AS tipoFormaPago,
						'Guaranies'                             AS moneda,
						SUM(m.monto)                            AS total,
						SUM(m.monto)                            AS totalgs
					FROM movimiento m
					INNER JOIN concepto c ON c.idConcepto = m.concepto
					INNER JOIN formapago f ON f.idFormaPago = m.TerminoPago_idTerminoPago
					INNER JOIN habilitacion h ON m.habilitacion = h.idhabilitacion
					WHERE 
						m.inactivo = 0
						AND c.tipo = 'I'
						AND (h.idhabilitacion ) = '$habilitacion'
					GROUP BY m.usuario, f.descripcion, f.tipo
				) t
				GROUP BY t.usuario, t.formaPago
				ORDER BY t.usuario, t.formaPago;";
		return ejecutarConsulta($sql);
	}






	public function rpt_arqueo_caja_fechas($fi, $ff)
	{
		$sql = "SELECT 
					formapago.descripcion,recibo.USUARIO,
					moneda.descripcion AS moneda, 
					SUM(detallerecibo.MONTO / detallerecibo.tasaCambio) AS total,
					SUM(detallerecibo.MONTO) AS totalgs, 
					formapago.idFormaPago AS id
				FROM recibo
				INNER JOIN detallerecibo ON recibo.IDRECIBO = detallerecibo.RECIBO_IDRECIBO
				INNER JOIN formapago ON formapago.idFormaPago = detallerecibo.FORMAPAGO_IDFORMAPAGO
				INNER JOIN moneda ON moneda.idMoneda = detallerecibo.Moneda_idMoneda
				INNER JOIN habilitacion h ON recibo.HABILITACION_IDHABILITACION = h.idhabilitacion
				WHERE 
					DATE(h.fechaApertura) BETWEEN '$fi' AND '$ff'
					AND F_ESTADO_RECIBO_FACTURAS(recibo.IDRECIBO) = 0
				GROUP BY formapago.idFormaPago, moneda.descripcion, recibo.USUARIO order by recibo.USUARIO, id";
		
		return ejecutarConsulta($sql);
	}



	public function rpt_arqueo_caja_cobranzas_movimientos_fechas($fi, $ff)
	{
		$sql = "SELECT 
					t.usuario,
					t.formaPago,
					SUM(t.total)   AS total
				FROM (
					SELECT 
						r.USUARIO                               AS usuario,
						fp.descripcion                          AS formaPago,
						fp.tipo                                 AS tipoFormaPago,
						m.descripcion                           AS moneda,
						SUM(dr.MONTO / dr.tasaCambio)           AS total,
						SUM(dr.MONTO)                           AS totalgs
					FROM recibo r
					INNER JOIN detallerecibo dr ON r.IDRECIBO = dr.RECIBO_IDRECIBO
					INNER JOIN formapago fp ON fp.idFormaPago = dr.FORMAPAGO_IDFORMAPAGO
					INNER JOIN moneda m ON m.idMoneda = dr.Moneda_idMoneda
					INNER JOIN habilitacion h ON r.HABILITACION_IDHABILITACION = h.idhabilitacion
					WHERE 
						DATE(h.fechaApertura) BETWEEN '$fi' AND '$ff'
						AND F_ESTADO_RECIBO_FACTURAS(r.IDRECIBO) = 0
					GROUP BY r.USUARIO, fp.descripcion, fp.tipo, m.descripcion
					UNION ALL
					SELECT 
						m.usuario                               AS usuario,
						f.descripcion                           AS formaPago,
						f.tipo                                  AS tipoFormaPago,
						'Guaranies'                             AS moneda,
						SUM(m.monto)                            AS total,
						SUM(m.monto)                            AS totalgs
					FROM movimiento m
					INNER JOIN concepto c ON c.idConcepto = m.concepto
					INNER JOIN formapago f ON f.idFormaPago = m.TerminoPago_idTerminoPago
					INNER JOIN habilitacion h ON m.habilitacion = h.idhabilitacion
					WHERE 
						m.inactivo = 0
						AND c.tipo = 'I'
						AND DATE(h.fechaApertura) BETWEEN '$fi' AND '$ff'
					GROUP BY m.usuario, f.descripcion, f.tipo
				) t
				GROUP BY t.usuario, t.formaPago
				ORDER BY t.usuario, t.formaPago;";
		
		return ejecutarConsulta($sql);
	}








	public function rpt_cabecera($habilitacion)
	{
		$sql="SELECT caja.nombre, deposito.descripcion, usuario.login, habilitacion.fechaApertura from usuario, habilitacion, caja, deposito where idCaja = Caja_idCaja and idDeposito = Deposito_idDeposito and habilitacion.usuario_ins = idusuario AND habilitacion.idHabilitacion = '$habilitacion'";
		return ejecutarConsulta($sql);
	}


		public function rpt_arqueo_caja_denominacion($habilitacion)
	{
		$sql="SELECT habilitacion.idhabilitacion as habilitacion, fechaApertura, habilitacion.Usuario_idUsuario,
	    moneda.descripcion as moneda, 
		detallemoneda.descripcion  as denominacion , detallehabilitacion.montoApertura as cantidad, 
		detallehabilitacion.montoCierre as cantidadCierre, 
        sum(detallehabilitacion.montoApertura*detallemoneda.descripcion) as total ,
        sum(detallehabilitacion.montoCierre*detallemoneda.descripcion) as totalCierre
		FROM    moneda, habilitacion   ,detallehabilitacion , detallemoneda  
		where  
		  moneda.idMoneda=detallehabilitacion.Moneda_idMoneda and 
		habilitacion.idhabilitacion = '$habilitacion' and detallehabilitacion.estado = 0 and
        detallehabilitacion.Habilitacion_idHabilitacion = habilitacion.idHabilitacion   and 
        detallemoneda.idDetalleMoneda = detallehabilitacion.Denominacion_idDenominacion  
		 group by habilitacion.idhabilitacion,fechaApertura, habilitacion.Usuario_idUsuario, 
				  moneda.descripcion,
				  moneda.descripcion,detallemoneda.descripcion,detallehabilitacion.montoApertura,
				  detallehabilitacion.montoCierre
		ORDER BY `habilitacion`.`fechaApertura` DESC;";
		return ejecutarConsulta($sql);
	}


	public function rpt_arqueo_caja_denominacion_fechas($fi, $ff)
{
    $sql = "SELECT 
                habilitacion.idhabilitacion as habilitacion, 
                fechaApertura, 
                habilitacion.Usuario_idUsuario,
                moneda.descripcion as moneda, 
                detallemoneda.descripcion  as denominacion, 
                detallehabilitacion.montoApertura as cantidad, 
                detallehabilitacion.montoCierre as cantidadCierre, 
                sum(detallehabilitacion.montoApertura*detallemoneda.descripcion) as total,
                sum(detallehabilitacion.montoCierre*detallemoneda.descripcion) as totalCierre
            FROM moneda
            JOIN detallehabilitacion ON moneda.idMoneda = detallehabilitacion.Moneda_idMoneda
            JOIN habilitacion ON detallehabilitacion.Habilitacion_idHabilitacion = habilitacion.idHabilitacion
            JOIN detallemoneda ON detallemoneda.idDetalleMoneda = detallehabilitacion.Denominacion_idDenominacion
            WHERE detallehabilitacion.estado = 0
              AND DATE(habilitacion.fechaApertura) BETWEEN '$fi' AND '$ff'
            GROUP BY habilitacion.idhabilitacion, fechaApertura, habilitacion.Usuario_idUsuario, 
                     moneda.descripcion, detallemoneda.descripcion, 
                     detallehabilitacion.montoApertura, detallehabilitacion.montoCierre
            ORDER BY habilitacion.fechaApertura DESC";
    
    return ejecutarConsulta($sql);
}


	public function rpt_arqueo_caja_pago($habilitacion)
	{
		$sql="SELECT HABILITACION_IDHABILITACION as habilitacion, FECHAPAGO, 
					 pago.USUARIO,formapago.descripcion,moneda.descripcion as moneda, 
					 sum(detallepago.MONTO/pago.tasaCambio) as total,sum(detallepago.MONTO) as totalGs, formapago.idFormaPago as id
				FROM pago, detallepago, formapago, moneda
				where  
				pago.IDPAGO = detallepago.PAGO_IDPAGO and 
				formapago.idFormaPago = detallepago.FORMAPAGO_IDFORMAPAGO and moneda.idMoneda=pago.MONEDA_IDMONEDA
				and HABILITACION_IDHABILITACION = '$habilitacion'
				group by formapago.idFormaPago,moneda.descripcion 
                ORDER BY `pago`.`FECHATRANSACCION` DESC;";
		return ejecutarConsulta($sql);
	}

public function rpt_aruqeo_caja_movimiento_ingreso($habilitacion) {
    $sql = "SELECT
                F_NOMBRE_PERSONA(Empleado_idEmpleado)        AS cliente,
                m.idMovimiento,
                c.descripcion                                AS Descripcion,
                m.descripcion                                AS md,
                c.tipo                                       AS Tipo,
                'Guaranies'                                  AS moneda,
                m.monto                                      AS Total,
                m.monto                                      AS TotalGs,
                f.idFormaPago,
                f.descripcion                                AS formaPago,
                f.tipo                                       AS tipoFormaPago
            FROM  movimiento m
            JOIN  concepto   c ON c.idConcepto = m.concepto
            JOIN  formapago  f ON f.idFormaPago = m.TerminoPago_idTerminoPago
            WHERE m.inactivo    = 0
              AND m.habilitacion= '$habilitacion'
              AND c.tipo        = 'I'";
    return ejecutarConsulta($sql);
}


public function rpt_aruqeo_caja_movimiento_ingreso_fechas($fi, $ff) {
    $sql = "SELECT
	m.usuario,
                F_NOMBRE_PERSONA(m.Empleado_idEmpleado)      AS cliente,
                m.idMovimiento,
                c.descripcion                                AS Descripcion,
                m.descripcion                                AS md,
                c.tipo                                       AS Tipo,
                'Guaranies'                                  AS moneda,
                sum(m.monto)                                      AS Total,
                sum(m.monto)                                      AS TotalGs,
                f.idFormaPago,
                f.descripcion                                AS formaPago,
                f.tipo                                       AS tipoFormaPago
            FROM  movimiento m
            JOIN  concepto       c ON c.idConcepto = m.concepto
            JOIN  formapago      f ON f.idFormaPago = m.TerminoPago_idTerminoPago
            JOIN  habilitacion   h ON m.habilitacion = h.idhabilitacion
            WHERE m.inactivo = 0
              AND DATE(h.fechaApertura) BETWEEN '$fi' AND '$ff'
              AND c.tipo = 'I'  group by m.usuario, c.idConcepto, cliente, f.tipo order by usuario";
    
    return ejecutarConsulta($sql);
}



public function rpt_aruqeo_caja_movimiento_egreso($habilitacion) {
    $sql = "SELECT
	m.usuario,
F_NOMBRE_PERSONA(m.Empleado_idEmpleado)      AS cliente,
                m.idMovimiento,
                c.descripcion                                AS Descripcion,
                m.descripcion                                AS md,
                c.tipo                                       AS Tipo,
                'Guaranies'                                  AS moneda,
                m.monto                                      AS Total,
                m.monto                                      AS TotalGs,
                f.idFormaPago,
                f.descripcion                                AS formaPago,
                f.tipo                                       AS tipoFormaPago
            FROM  movimiento m
            JOIN  concepto   c ON c.idConcepto = m.concepto
            JOIN  formapago  f ON f.idFormaPago = m.TerminoPago_idTerminoPago
            WHERE m.inactivo    = 0
              AND m.habilitacion= '$habilitacion'
              AND c.tipo        = 'E'  group by m.usuario, c.idConcepto, cliente order by usuario ;";
    return ejecutarConsulta($sql);
}


public function rpt_aruqeo_caja_movimiento_egreso_fechas($fi, $ff) {
    $sql = "SELECT
                F_NOMBRE_PERSONA(m.Empleado_idEmpleado)      AS cliente,
                m.idMovimiento,
                c.descripcion                                AS Descripcion,
                m.descripcion                                AS md,
                c.tipo                                       AS Tipo,
                'Guaranies'                                  AS moneda,
                m.monto                                      AS Total,
                m.monto                                      AS TotalGs,
                f.idFormaPago,
                f.descripcion                                AS formaPago,
                f.tipo                                       AS tipoFormaPago
            FROM  movimiento m
            JOIN  concepto       c ON c.idConcepto = m.concepto
            JOIN  formapago      f ON f.idFormaPago = m.TerminoPago_idTerminoPago
            JOIN  habilitacion   h ON m.habilitacion = h.idhabilitacion
            WHERE m.inactivo = 0
              AND DATE(h.fechaApertura) BETWEEN '$fi' AND '$ff'
              AND c.tipo = 'E'";
    
    return ejecutarConsulta($sql);
}



	public function rpt_recibos_detalle($habilitacion){
		/*$sql="SELECT IDRECIBO, persona.razonSocial, recibo.FECHARECIBO, recibo.TOTAL 
		from recibo, persona where recibo.CLIENTE_IDCLIENTE = persona.idPersona 
		and recibo.INACTIVO = 0 and recibo.HABILITACION_IDHABILITACION = '$habilitacion' and F_ESTADO_RECIBO_FACTURAS(recibo.IDRECIBO) = 0;";
		return ejecutarConsulta($sql);	*/

		$sql="SELECT IDRECIBO,  recibo.FECHARECIBO,persona.razonSocial,moneda.descripcion as moneda, 
					 round(sum(detallerecibo.monto/detallerecibo.tasaCambio),0)  as TOTAL,sum(detallerecibo.monto) as TOTALGS
				from recibo left outer join persona on recibo.CLIENTE_IDCLIENTE = persona.idPersona
				left outer join detallerecibo on detallerecibo.RECIBO_IDRECIBO = recibo.IDRECIBO 
					and detallerecibo.monto>0
				join moneda on detallerecibo.Moneda_idMoneda=moneda.idMoneda 
				where  recibo.INACTIVO = 0 and recibo.HABILITACION_IDHABILITACION = '$habilitacion' and F_ESTADO_RECIBO_FACTURAS(recibo.IDRECIBO) = 0
				group by IDRECIBO,recibo.FECHARECIBO,persona.razonSocial,moneda.descripcion;";
				return ejecutarConsulta($sql);	
	}


	public function rpt_recibos_detalle_dia($habilitacion){
 
		$sql="SELECT IDRECIBO,  recibo.FECHARECIBO,persona.razonSocial,moneda.descripcion as moneda, 
					 round(sum(detallerecibo.monto/detallerecibo.tasaCambio),0)  as TOTAL,sum(detallerecibo.monto) as TOTALGS
				from recibo left outer join persona on recibo.CLIENTE_IDCLIENTE = persona.idPersona
				left outer join detallerecibo on detallerecibo.RECIBO_IDRECIBO = recibo.IDRECIBO 
					and detallerecibo.monto>0
				join moneda on detallerecibo.Moneda_idMoneda=moneda.idMoneda 
				join habilitacion on habilitacion.idHabilitacion = recibo.HABILITACION_IDHABILITACION
				where  recibo.INACTIVO = 0 and recibo.HABILITACION_IDHABILITACION = '$habilitacion' and F_ESTADO_RECIBO_FACTURAS(recibo.IDRECIBO) = 0
				and recibo.idRecibo in (select RECIBO_IDRECIBO 
		    						from detallerecibofacturas 
									where VENTA_IDVENTA in (select idVenta from venta where fechaFactura = habilitacion.fechaApertura ) )
				group by IDRECIBO,recibo.FECHARECIBO,persona.razonSocial,moneda.descripcion;";
				return ejecutarConsulta($sql);	
	}


	public function rpt_recibos_detalle_dia_credito($habilitacion){
 
		$sql="SELECT IDRECIBO,  recibo.FECHARECIBO,persona.razonSocial,moneda.descripcion as moneda, 
					 round(sum(detallerecibo.monto/detallerecibo.tasaCambio),0)  as TOTAL,sum(detallerecibo.monto) as TOTALGS
				from recibo left outer join persona on recibo.CLIENTE_IDCLIENTE = persona.idPersona
				left outer join detallerecibo on detallerecibo.RECIBO_IDRECIBO = recibo.IDRECIBO 
					and detallerecibo.monto>0
				join moneda on detallerecibo.Moneda_idMoneda=moneda.idMoneda 
				join habilitacion on habilitacion.idHabilitacion = recibo.HABILITACION_IDHABILITACION
				where  recibo.INACTIVO = 0 and recibo.HABILITACION_IDHABILITACION = '$habilitacion' and F_ESTADO_RECIBO_FACTURAS(recibo.IDRECIBO) = 0
				and recibo.idRecibo in (select RECIBO_IDRECIBO 
		    						from detallerecibofacturas 
									where VENTA_IDVENTA in (select idVenta from venta where fechaFactura = habilitacion.fechaApertura and venta.TerminoPago_idTerminoPago > 1 ) )

				group by IDRECIBO,recibo.FECHARECIBO,persona.razonSocial,moneda.descripcion;";
				return ejecutarConsulta($sql);	
	}


	public function rpt_remision_sin_factura_sin_regalias($habilitacion){
 
		$sql="SELECT ventaRemision.idRemision,  ventaRemision.fechaTransaccion,persona.razonSocial,moneda.descripcion as moneda , 
					 articulo.descripcion   as nombre ,   (CASE ventaRemision.regalia
	         WHEN 'N' THEN 'NO'
	         ELSE 'SI'
	      END) as regalia, ventaRemisionDetalle.cantidad as cantidad
from ventaRemision 
                left outer join persona on ventaRemision.Cliente_idCliente = persona.idPersona
				left outer join ventaRemisionDetalle on ventaRemisionDetalle.Remision_idRemision = ventaRemision.idRemision
				left outer join articulo on articulo.idArticulo = ventaRemisionDetalle.Articulo_idArticulo
				join moneda on ventaRemision.Moneda_idMoneda=moneda.idMoneda 
				join habilitacion on habilitacion.idHabilitacion = ventaRemision.HABILITACION_IDHABILITACION
				where  ventaRemision.INACTIVO = 0 and ventaRemision.HABILITACION_IDHABILITACION    ='$habilitacion'  
                and ventaRemision.Venta_idVenta  not in (select idVenta from venta where inactivo= 0 ) and regalia = 'N'
				group by ventaRemision.idRemision,  ventaRemision.fechaTransaccion,persona.razonSocial,moneda.descripcion,articulo.descripcion, ventaRemisionDetalle.cantidad";
				return ejecutarConsulta($sql);	
	}


	public function rpt_remision_sin_factura_con_regalias($habilitacion){
 
		$sql="SELECT ventaRemision.idRemision,  ventaRemision.fechaTransaccion,persona.razonSocial,moneda.descripcion as moneda , 
					 articulo.descripcion   as nombre ,   (CASE ventaRemision.regalia
	         WHEN 'N' THEN 'NO'
	         ELSE 'SI'
	      END) as regalia, ventaRemisionDetalle.cantidad as cantidad
from ventaRemision 
                left outer join persona on ventaRemision.Cliente_idCliente = persona.idPersona
				left outer join ventaRemisionDetalle on ventaRemisionDetalle.Remision_idRemision = ventaRemision.idRemision
				left outer join articulo on articulo.idArticulo = ventaRemisionDetalle.Articulo_idArticulo
				join moneda on ventaRemision.Moneda_idMoneda=moneda.idMoneda 
				join habilitacion on habilitacion.idHabilitacion = ventaRemision.HABILITACION_IDHABILITACION
				where  ventaRemision.INACTIVO = 0 and ventaRemision.HABILITACION_IDHABILITACION   ='$habilitacion'    
                and ventaRemision.Venta_idVenta  not in (select idVenta from venta where inactivo= 0 ) and regalia = 'S'
				group by ventaRemision.idRemision,  ventaRemision.fechaTransaccion,persona.razonSocial,moneda.descripcion,articulo.descripcion, ventaRemisionDetalle.cantidad";
				return ejecutarConsulta($sql);	
	}	



	public function rpt_remision_con_factura_sin_regalias($habilitacion){
 
		$sql="SELECT ventaRemision.idRemision,  ventaRemision.fechaTransaccion,persona.razonSocial,moneda.descripcion as moneda , 
					 articulo.descripcion   as nombre ,   (CASE ventaRemision.regalia
	         WHEN 'N' THEN 'NO'
	         ELSE 'SI'
	      END) as regalia, ventaRemisionDetalle.cantidad as cantidad
from ventaRemision 
                left outer join persona on ventaRemision.Cliente_idCliente = persona.idPersona
				left outer join ventaRemisionDetalle on ventaRemisionDetalle.Remision_idRemision = ventaRemision.idRemision
				left outer join articulo on articulo.idArticulo = ventaRemisionDetalle.Articulo_idArticulo
				join moneda on ventaRemision.Moneda_idMoneda=moneda.idMoneda 
				join habilitacion on habilitacion.idHabilitacion = ventaRemision.HABILITACION_IDHABILITACION
				where  ventaRemision.INACTIVO = 0 and ventaRemision.HABILITACION_IDHABILITACION    ='$habilitacion'  
                and ventaRemision.Venta_idVenta    in (select idVenta from venta where inactivo= 0 ) and regalia = 'N'
				group by ventaRemision.idRemision,  ventaRemision.fechaTransaccion,persona.razonSocial,moneda.descripcion,articulo.descripcion, ventaRemisionDetalle.cantidad";
				return ejecutarConsulta($sql);	
	}


	public function rpt_remision_con_factura_con_regalias($habilitacion){
 
		$sql="SELECT ventaRemision.idRemision,  ventaRemision.fechaTransaccion,persona.razonSocial,moneda.descripcion as moneda , 
					 articulo.descripcion   as nombre ,   (CASE ventaRemision.regalia
	         WHEN 'N' THEN 'NO'
	         ELSE 'SI'
	      END) as regalia, ventaRemisionDetalle.cantidad as cantidad
from ventaRemision 
                left outer join persona on ventaRemision.Cliente_idCliente = persona.idPersona
				left outer join ventaRemisionDetalle on ventaRemisionDetalle.Remision_idRemision = ventaRemision.idRemision
				left outer join articulo on articulo.idArticulo = ventaRemisionDetalle.Articulo_idArticulo
				join moneda on ventaRemision.Moneda_idMoneda=moneda.idMoneda 
				join habilitacion on habilitacion.idHabilitacion = ventaRemision.HABILITACION_IDHABILITACION
				where  ventaRemision.INACTIVO = 0 and ventaRemision.HABILITACION_IDHABILITACION   ='$habilitacion'    
                and ventaRemision.Venta_idVenta    in (select idVenta from venta where inactivo= 0 ) and regalia = 'S'
				group by ventaRemision.idRemision,  ventaRemision.fechaTransaccion,persona.razonSocial,moneda.descripcion,articulo.descripcion, ventaRemisionDetalle.cantidad";
				return ejecutarConsulta($sql);	
	}	

	public function rpt_remision_con_factura($habilitacion){ 
 
		$sql="SELECT ventaRemision.idRemision,  ventaRemision.fechaTransaccion,persona.razonSocial,moneda.descripcion as moneda ,  
					 round(sum(ventaRemisionDetalle.total),0)  as TOTAL,sum(ventaRemisionDetalle.total) as TOTALGS
				from ventaRemision left outer join persona on ventaRemision.Cliente_idCliente = persona.idPersona
				left outer join ventaRemisionDetalle on ventaRemisionDetalle.Remision_idRemision = ventaRemision.idRemision
					and ventaRemisionDetalle.precio>0
				join moneda on ventaRemision.Moneda_idMoneda=moneda.idMoneda 
				join habilitacion on habilitacion.idHabilitacion = ventaRemision.HABILITACION_IDHABILITACION
				where  ventaRemision.INACTIVO = 0 and ventaRemision.HABILITACION_IDHABILITACION = '$habilitacion' 
                and ventaRemision.Venta_idVenta   in (select idVenta from venta where inactivo= 0 )
				group by ventaRemision.idRemision,  ventaRemision.fechaTransaccion,persona.razonSocial,moneda.descripcion";
				return ejecutarConsulta($sql);	
	}

	

	public function rpt_ventas_detallado_aplicados($idVenta){
 
		$sql="SELECT d.RECIBO_IDRECIBO, t.descripcion, d2.MONTO from detallerecibofacturas d, detallerecibo d2, formapago t 
				where t.idFormaPago = d2.FORMAPAGO_IDFORMAPAGO and 
				d2.RECIBO_IDRECIBO = d.RECIBO_IDRECIBO and  d.VENTA_IDVENTA = '$idVenta' and d2.MONTO > 0 and d.inactivo = 0 and d2.inactivo = 0";
				return ejecutarConsulta($sql);	
	}





	public function rpt_ventas_detallado($habilitacion){
 
		$sql="SELECT 
				venta.idVenta,  
				venta.fechaTransaccion,
				persona.razonSocial,
				moneda.descripcion as moneda,  
				round(venta.total, 0) as TOTAL,
				venta.total as TOTALGS,
				detalleventa.descripcion as producto, 
				detalleventa.cantidad,
				detalleventa.precio,
				detalleventa.total as totalProducto,
				venta.saldo,
				t.descripcion,
				t.idTerminoPago
			FROM 
				venta 
			LEFT OUTER JOIN 
				persona ON venta.Cliente_idCliente = persona.idPersona
			LEFT OUTER JOIN 
				detalleventa ON detalleventa.Venta_idVenta = venta.idVenta
			JOIN 
				moneda ON venta.Moneda_idMoneda = moneda.idMoneda 
			JOIN 
				habilitacion ON habilitacion.idHabilitacion = venta.HABILITACION_IDHABILITACION
			JOIN
			terminopago t ON t.idTerminoPago = venta.TerminoPago_idTerminoPago
			WHERE  
				venta.INACTIVO = 0 
				AND venta.HABILITACION_IDHABILITACION = '$habilitacion'  
				AND venta.idVenta NOT IN (SELECT notacreditoventa.Venta_idVenta FROM notacreditoventa WHERE notacreditoventa.inactivo = 0) 
			ORDER BY 
				venta.idVenta, 
				detalleventa.descripcion";
				return ejecutarConsulta($sql);	
	}


	public function rpt_ventas_contado_sin_remision($habilitacion){
 
		$sql="SELECT venta.idVenta,  venta.fechaTransaccion,persona.razonSocial,moneda.descripcion as moneda ,  
					 round(sum(detalleventa.total),0)  as TOTAL,sum(detalleventa.total) as TOTALGS
				from venta left outer join persona on venta.Cliente_idCliente = persona.idPersona
				left outer join detalleventa on detalleventa.Venta_idVenta = venta.idVenta
					and detalleventa.precio>0
				join moneda on venta.Moneda_idMoneda=moneda.idMoneda 
				join habilitacion on habilitacion.idHabilitacion = venta.HABILITACION_IDHABILITACION
				where  venta.INACTIVO = 0 and venta.HABILITACION_IDHABILITACION = '$habilitacion'  
				/*and venta.fechaFactura = habilitacion.fechaApertura */ and venta.cuotas = 0
                and venta.idVenta not in (select Venta_idVenta from ventaRemision where inactivo= 0 )
                and venta.idVenta not in (select notacreditoventa.Venta_idVenta from notacreditoventa where notacreditoventa.inactivo=0) 
				group by venta.idVenta,  venta.fechaTransaccion,persona.razonSocial,moneda.descripcion";
				return ejecutarConsulta($sql);	
	}

	public function rpt_ventas_contado_con_remision($habilitacion){
 
		$sql="SELECT venta.idVenta,  venta.fechaTransaccion,persona.razonSocial,moneda.descripcion as moneda, 
					 round(sum(detalleventa.total),0)  as TOTAL,sum(detalleventa.total) as TOTALGS
				from venta left outer join persona on venta.Cliente_idCliente = persona.idPersona
				left outer join detalleventa on detalleventa.Venta_idVenta = venta.idVenta
					and detalleventa.precio>0
				join moneda on venta.Moneda_idMoneda=moneda.idMoneda 
				join habilitacion on habilitacion.idHabilitacion = venta.HABILITACION_IDHABILITACION
				where  venta.INACTIVO = 0 and venta.HABILITACION_IDHABILITACION = '$habilitacion'  
				/*and venta.fechaFactura = habilitacion.fechaApertura */
				 and venta.cuotas = 0
                and venta.idVenta  in (select Venta_idVenta from ventaRemision where inactivo= 0 )
                and venta.idVenta not in (select notacreditoventa.Venta_idVenta from notacreditoventa where notacreditoventa.inactivo=0) 
				group by venta.idVenta,  venta.fechaTransaccion,persona.razonSocial,moneda.descripcion";
				return ejecutarConsulta($sql);	
	}	

	public function rpt_movimiento_stock_habilitacion_entrada($habilitacion){ 
 
		$sql="SELECT m.idMovimientoStock, m.usuario, d1.descripcion AS Deposito_idDepositoOrigen, d2.descripcion AS Deposito_idDepositoDestino, 
			comentario, fechaTransaccion, SUM(md.total) AS total, SUM(md.cantidad) AS cantidad, m.inactivo, ha.idhabilitacion
			FROM movimientostock m JOIN movimientostockdetalle md ON m.idMovimientoStock = md.MovimientoStock_idMovimientoStock
			JOIN deposito d1 ON d1.idDeposito = Deposito_idDepositoOrigen
			JOIN deposito d2 ON d2.idDeposito = Deposito_idDepositoDestino
			JOIN caja ca ON ca.Deposito_idDeposito = d2.idDeposito
			JOIN habilitacion ha ON ha.Caja_idCaja = ca.idcaja and ha.idhabilitacion='$habilitacion' 
			GROUP BY idMovimientoStock, m.usuario, d1.descripcion,d2.descripcion,comentario, fechaTransaccion, m.inactivo, ha.idhabilitacion";
				return ejecutarConsulta($sql);	   
	}	


	public function rpt_movimiento_stock_habilitacion_salida($habilitacion){ 
 
		$sql="SELECT m.idMovimientoStock, m.usuario, d1.descripcion AS Deposito_idDepositoOrigen, d2.descripcion AS Deposito_idDepositoDestino, 
			comentario, fechaTransaccion, SUM(md.total) AS total, SUM(md.cantidad) AS cantidad, m.inactivo, ha.idhabilitacion
			FROM movimientostock m JOIN movimientostockdetalle md ON m.idMovimientoStock = md.MovimientoStock_idMovimientoStock
			JOIN deposito d1 ON d1.idDeposito = Deposito_idDepositoOrigen
			JOIN deposito d2 ON d2.idDeposito = Deposito_idDepositoDestino
			JOIN caja ca ON ca.Deposito_idDeposito = d1.idDeposito
			JOIN habilitacion ha ON ha.Caja_idCaja = ca.idcaja and ha.idhabilitacion='$habilitacion'
			GROUP BY idMovimientoStock, m.usuario, d1.descripcion,d2.descripcion,comentario, fechaTransaccion, m.inactivo, ha.idhabilitacion";
				return ejecutarConsulta($sql);	   
	}	
	public function rpt_ventas_credito_con_remision($habilitacion){
 
		$sql="SELECT venta.idVenta,  venta.fechaTransaccion,persona.razonSocial,moneda.descripcion as moneda, 
					 round(sum(detalleventa.total),0)  as TOTAL,sum(detalleventa.total) as TOTALGS
				from venta left outer join persona on venta.Cliente_idCliente = persona.idPersona
				left outer join detalleventa on detalleventa.Venta_idVenta = venta.idVenta
					and detalleventa.precio>0
				join moneda on venta.Moneda_idMoneda=moneda.idMoneda 
				join habilitacion on habilitacion.idHabilitacion = venta.HABILITACION_IDHABILITACION
				where  venta.INACTIVO = 0 and venta.HABILITACION_IDHABILITACION = '$habilitacion'  
				  and venta.cuotas  > 0 
                and venta.idVenta  in (select Venta_idVenta from ventaRemision where inactivo= 0 )
                and venta.idVenta not in (select notacreditoventa.Venta_idVenta from notacreditoventa where notacreditoventa.inactivo=0) 
				group by venta.idVenta,  venta.fechaTransaccion,persona.razonSocial,moneda.descripcion";
				return ejecutarConsulta($sql);	
	}	


	public function rpt_ventas_credito_sin_remision($habilitacion){
 
		$sql="SELECT venta.idVenta,  venta.fechaTransaccion,persona.razonSocial,moneda.descripcion as moneda, 
					 round(sum(detalleventa.total),0)  as TOTAL,sum(detalleventa.total) as TOTALGS
				from venta left outer join persona on venta.Cliente_idCliente = persona.idPersona
				left outer join detalleventa on detalleventa.Venta_idVenta = venta.idVenta
					and detalleventa.precio>0
				join moneda on venta.Moneda_idMoneda=moneda.idMoneda 
				join habilitacion on habilitacion.idHabilitacion = venta.HABILITACION_IDHABILITACION
				where  venta.INACTIVO = 0 and venta.HABILITACION_IDHABILITACION = '$habilitacion'  
				 and venta.cuotas > 0 
                and venta.idVenta  not in (select Venta_idVenta from ventaRemision where inactivo= 0 )
                and venta.idVenta not in (select notacreditoventa.Venta_idVenta from notacreditoventa where notacreditoventa.inactivo=0) 
				group by venta.idVenta,  venta.fechaTransaccion,persona.razonSocial,moneda.descripcion";
				return ejecutarConsulta($sql);	
	}	

	public function rpt_recibos_detalle_otra_fecha($habilitacion){
	 
		$sql="SELECT IDRECIBO,  recibo.FECHARECIBO,persona.razonSocial,moneda.descripcion as moneda, 
					 round(sum(detallerecibo.monto/detallerecibo.tasaCambio),0)  as TOTAL,sum(detallerecibo.monto) as TOTALGS
				from recibo left outer join persona on recibo.CLIENTE_IDCLIENTE = persona.idPersona
				left outer join detallerecibo on detallerecibo.RECIBO_IDRECIBO = recibo.IDRECIBO 
					and detallerecibo.monto>0
				join moneda on detallerecibo.Moneda_idMoneda=moneda.idMoneda 
				join habilitacion on habilitacion.idHabilitacion = recibo.HABILITACION_IDHABILITACION
				where  recibo.INACTIVO = 0 and recibo.HABILITACION_IDHABILITACION = '$habilitacion' and F_ESTADO_RECIBO_FACTURAS(recibo.IDRECIBO) = 0
				and recibo.idRecibo in (select RECIBO_IDRECIBO 
		    						from detallerecibofacturas 
									where VENTA_IDVENTA in (select idVenta from venta where fechaFactura < habilitacion.fechaApertura and TerminoPago_idTerminoPago = 12) )
									
				group by IDRECIBO,recibo.FECHARECIBO,persona.razonSocial,moneda.descripcion;";
				return ejecutarConsulta($sql);	
	}	

	public function rpt_pagos_detalle($habilitacion){
		$sql="SELECT 
IDPAGO, persona.razonSocial, pago.FECHAPAGO, moneda.descripcion as dm, pago.TOTAL as TOTAL, pago.TOTAL/pago.tasaCambio as TOTALGs 
from pago, persona , moneda , habilitacion 
where pago.PROVEEDOR_IDPROVEEDOR = persona.idPersona 
and pago.INACTIVO = 0 
and pago.HABILITACION_IDHABILITACION = '$habilitacion' and habilitacion.idHabilitacion=$habilitacion and moneda.idMoneda = MONEDA_IDMONEDA ;";
		return ejecutarConsulta($sql);		
	}


	public function rpt_pagos_detalle_dia($habilitacion){
		$sql="SELECT 
IDPAGO, persona.razonSocial, pago.FECHAPAGO, moneda.descripcion as dm, pago.TOTAL as TOTAL, pago.TOTAL/pago.tasaCambio as TOTALGs 
from pago, persona , moneda , habilitacion 
where pago.PROVEEDOR_IDPROVEEDOR = persona.idPersona 
and pago.INACTIVO = 0 
and pago.HABILITACION_IDHABILITACION = '$habilitacion' and habilitacion.idHabilitacion=$habilitacion and moneda.idMoneda = pago.MONEDA_IDMONEDA
and pago.idPago in (select PAGO_IDPAGO 
		    from detallepagofacturas 
			where COMPRA_IDCOMPRA in (select idCompra from compra where fechaFactura = habilitacion.fechaApertura ) );";
		return ejecutarConsulta($sql);		
	}


	public function rpt_pagos_detalle_otro_dia($habilitacion){
		$sql="SELECT 
IDPAGO, persona.razonSocial, pago.FECHAPAGO, moneda.descripcion as dm, pago.TOTAL as TOTAL, pago.TOTAL/pago.tasaCambio as TOTALGs 
from pago, persona , moneda , habilitacion 
where pago.PROVEEDOR_IDPROVEEDOR = persona.idPersona 
and pago.INACTIVO = 0 
and pago.HABILITACION_IDHABILITACION = '$habilitacion' and habilitacion.idHabilitacion=$habilitacion and moneda.idMoneda = pago.MONEDA_IDMONEDA
and pago.idPago in (select PAGO_IDPAGO 
		    from detallepagofacturas 
			where COMPRA_IDCOMPRA in (select idCompra from compra where fechaFactura < habilitacion.fechaApertura ) );";
		return ejecutarConsulta($sql);		
	}

	public function rpt_aruqeo_caja_venta($habilitacion){
		$sql="select articulo.nombre AS descripcion, 
			sum(detalleventa.cantidad) AS Cantidad_X_Articulo, (detalleventa.precio), 
			moneda.descripcion as moneda,
			(detalleventa.precio)  as Total  ,
			((detalleventa.precio/venta.tasaCambio) * sum(detalleventa.cantidad)) as TotalGs, venta.usuario
			from venta, detalleventa, articulo , moneda 
			where venta.idVenta = detalleventa.Venta_idVenta and detalleventa.Articulo_idArticulo = articulo.idArticulo 
			and venta.Habilitacion_idHabilitacion = '$habilitacion' AND venta.inactivo = 0 AND moneda.idMoneda= venta.Moneda_idMoneda and venta.Remision = 'N'
			GROUP by detalleventa.Articulo_idArticulo , detalleventa.precio";
		return ejecutarConsulta($sql);		
	}

	public function rpt_aruqeo_caja_venta_contado($habilitacion){
		$sql="SELECT articulo.nombre AS descripcion, 
			sum(detalleventa.cantidad) AS Cantidad_X_Articulo, (detalleventa.precio), 
			moneda.descripcion as moneda,
			(detalleventa.precio)  as Total  ,
			((detalleventa.precio/venta.tasaCambio) * sum(detalleventa.cantidad)) as TotalGs, venta.usuario
			from venta, detalleventa, articulo , moneda, terminopago 
			where venta.idVenta = detalleventa.Venta_idVenta and detalleventa.Articulo_idArticulo = articulo.idArticulo 
			and venta.Habilitacion_idHabilitacion = '$habilitacion' AND venta.inactivo = 0 AND moneda.idMoneda= venta.Moneda_idMoneda and terminopago.idTerminoPago = venta.TerminoPago_idTerminoPago
			and terminopago.contado = 1 and venta.idVenta not in (select notacreditoventa.Venta_idVenta from notacreditoventa where notacreditoventa.inactivo=0) 
			GROUP by detalleventa.Articulo_idArticulo , detalleventa.precio";
		return ejecutarConsulta($sql);		
	}

		public function rpt_aruqeo_caja_venta_credito($habilitacion){
		$sql="SELECT articulo.nombre AS descripcion, 
			sum(detalleventa.cantidad) AS Cantidad_X_Articulo, (detalleventa.precio), 
			moneda.descripcion as moneda,
			(detalleventa.precio)  as Total  ,
			((detalleventa.precio/venta.tasaCambio) * sum(detalleventa.cantidad)) as TotalGs, venta.usuario
			from venta, detalleventa, articulo , moneda ,  terminopago
			where venta.idVenta = detalleventa.Venta_idVenta and detalleventa.Articulo_idArticulo = articulo.idArticulo 
			and venta.Habilitacion_idHabilitacion = '$habilitacion' AND venta.inactivo = 0 AND moneda.idMoneda= venta.Moneda_idMoneda  and terminopago.idTerminoPago = venta.TerminoPago_idTerminoPago
			and terminopago.contado = 0  and venta.idVenta not in (select notacreditoventa.Venta_idVenta from notacreditoventa where notacreditoventa.inactivo=0) 
			GROUP by detalleventa.Articulo_idArticulo , detalleventa.precio";
		return ejecutarConsulta($sql);		
	}

	public function rpt_aruqeo_caja_compra($habilitacion){
		$sql="SELECT articulo.nombre AS descripcion, 
sum(detallecompra.cantidad) AS Cantidad_X_Articulo, 
sum(detallecompra.precio), moneda.descripcion as moneda,
(sum(detallecompra.precio) * detallecompra.cantidad) as Total,
(sum(detallecompra.precio/compra.tasaCambio) * detallecompra.cantidad) as TotalGs, compra.usuario
from compra, detallecompra, articulo , moneda
where compra.idCompra = detallecompra.Compra_idCompra and 
detallecompra.Articulo_idArticulo = articulo.idArticulo and 
compra.Habilitacion_idHabilitacion = '$habilitacion' and compra.Moneda_idMoneda=moneda.idMoneda 
AND compra.inactivo = 0 GROUP by detallecompra.Articulo_idArticulo;";
		return ejecutarConsulta($sql);		
	}

	public function rpt_arqueo_caja_compra_contado($habilitacion){
		$sql="SELECT articulo.nombre AS descripcion, 
sum(detallecompra.cantidad) AS Cantidad_X_Articulo, 
sum(detallecompra.precio), moneda.descripcion as moneda,
(sum(detallecompra.precio) * detallecompra.cantidad) as Total,
(sum(detallecompra.precio/compra.tasaCambio) * detallecompra.cantidad) as TotalGs, compra.usuario
from compra, detallecompra, articulo , moneda, terminopago 
where compra.idCompra = detallecompra.Compra_idCompra and 
detallecompra.Articulo_idArticulo = articulo.idArticulo and compra.TerminoPago_idTerminoPago = terminopago.idTerminoPago and terminopago.contado =1 and
compra.Habilitacion_idHabilitacion = '$habilitacion' and compra.Moneda_idMoneda=moneda.idMoneda 
AND compra.inactivo = 0 GROUP by detallecompra.Articulo_idArticulo;";
		return ejecutarConsulta($sql);		
	}

	public function rpt_arqueo_caja_compra_credito($habilitacion){
		$sql="SELECT articulo.nombre AS descripcion, 
sum(detallecompra.cantidad) AS Cantidad_X_Articulo, 
sum(detallecompra.precio), moneda.descripcion as moneda,
(sum(detallecompra.precio) * detallecompra.cantidad) as Total,
(sum(detallecompra.precio/compra.tasaCambio) * detallecompra.cantidad) as TotalGs, compra.usuario
from compra, detallecompra, articulo , moneda, terminopago
where compra.idCompra = detallecompra.Compra_idCompra and compra.TerminoPago_idTerminoPago = terminopago.idTerminoPago and terminopago.contado =0 and
detallecompra.Articulo_idArticulo = articulo.idArticulo and 
compra.Habilitacion_idHabilitacion = '$habilitacion' and compra.Moneda_idMoneda=moneda.idMoneda 
AND compra.inactivo = 0 GROUP by detallecompra.Articulo_idArticulo;";
		return ejecutarConsulta($sql);		
	}

	public function rpt_clientes_paquetes($idCliente){
		$sql="SELECT Venta_idVenta,
				giftcard, 
				cliente.idCliente, 
				razonSocial, 
				nroDocumento, 
				celular, 
				Articulo_idArticulo_Servicio, 
				F_NOMBRE_ARTICULO(Articulo_idArticulo_Servicio) AS SERVICIO , 
				Articulo_idArticulo, F_NOMBRE_ARTICULO(Articulo_idArticulo) AS PAQUETE, 
				clientedetalle.cantidad, 
				F_CANTIDAD_PAQUETE(Articulo_idArticulo, Articulo_idArticulo_Servicio) as cantidadTotal
from clientedetalle, cliente, articulo
			where clientedetalle.Cliente_idCliente = cliente.idCliente and
			articulo.idArticulo = clientedetalle.Articulo_idArticulo and clientedetalle.Cliente_idCliente = '$idCliente' and Articulo_idArticulo > 0  and clientedetalle.inactivo = 0
            ";
					return ejecutarConsulta($sql);		
	}

	public function rpt_clientes_servicios($idCliente){
		$sql="SELECT Venta_idVenta,
giftcard, cliente.idCliente, razonSocial, nroDocumento, celular, Articulo_idArticulo_Servicio,F_NOMBRE_ARTICULO(Articulo_idArticulo_Servicio) AS SERVICIO, clientedetalle.cantidad from clientedetalle,cliente, articulo  where clientedetalle.Cliente_idCliente = cliente.idCliente and articulo.idArticulo = clientedetalle.Articulo_idArticulo_Servicio and  Articulo_idArticulo = 0 and cliente.idCliente = '$idCliente'  and clientedetalle.inactivo = 0";
					return ejecutarConsulta($sql);		
	}


	public function consumir_servicios($idEmpleado){
		$sql="SELECT
		idOrdenConsumisionDetalle,
		cliente.nombreComercial nc,
		cliente.razonSocial sgn,
		ordenconsumision.Cliente_idCliente, 
		empleado.idEmpleado,
		empleado.razonSocial as sge,
		OrdenConsumision_idOrdenConsumision, 
		ordenconsumisiondetalle.Articulo_idArticulo,
		ifnull(F_NOMBRE_ARTICULO(ordenconsumisiondetalle.Articulo_idArticulo), 'ES UN SERVICIO') as PAQUETE, 
		clientedetalle.Articulo_idArticulo_Servicio,
		F_NOMBRE_SERVICIO(clientedetalle.Articulo_idArticulo_Servicio) as SERVICIO, 
		(ordenconsumisiondetalle.cantidad - cantidadUtilizada) AS cantidadrestante,
		ordenconsumisiondetalle.cantidad,
		DATE_FORMAT(ordenconsumisiondetalle.fecha_inicial, '%d/%m/%Y') as fi,
		DATE_FORMAT(ordenconsumisiondetalle.fecha_final, '%d/%m/%Y') as ff,
		F_COMISION_PAQUETE_SERVICIO(ordenconsumisiondetalle.Articulo_idArticulo,clientedetalle.Articulo_idArticulo_Servicio,ordenconsumisiondetalle.cantidad) AS comision,
		ordenconsumisiondetalle.Articulo_idArticulo as a,
		clientedetalle.Articulo_idArticulo_Servicio as b
		from 
		ordenconsumisiondetalle, empleado, ordenconsumision, cliente, clientedetalle
		where 
		clientedetalle.idclientedetalle = ordenconsumisiondetalle.Articulo_idArticulo_Servicio and
		ordenconsumision.idOrdenConsumision = ordenconsumisiondetalle.OrdenConsumision_idOrdenConsumision and 
		ordenconsumision.Cliente_idCliente = cliente.idCliente and
		empleado.idEmpleado = ordenconsumisiondetalle.Empleado_IdEmpleado AND ordenconsumisiondetalle.terminado = 0 and ordenconsumision.inactivo = 0 AND ordenconsumisiondetalle.Empleado_IdEmpleado ='$idEmpleado' and ordenconsumisiondetalle.fecha_inicial <= now()";
		return ejecutarConsulta($sql);
	}


	public function orden_actualizar($cantidad,$id)
	{
		$sql="UPDATE ordenconsumisiondetalle set cantidadUtilizada = '$cantidad' WHERE idOrdenConsumisionDetalle = '$id'";
		return ejecutarConsulta($sql);
	}

	public function rpt_extracto_cuotas_cliente($cliente){
		$sql="SELECT cliente.nombreComercial, venta.nroFactura, venta.idVenta , detalleventacuotas.nroCuota,detalleventacuotas.fechaVencimiento, detalleventacuotas.monto, detalleventacuotas.saldo 
		FROM detalleventacuotas, venta, cliente WHERE detalleventacuotas.Venta_idVenta = venta.idVenta and cliente.idCliente = venta.Cliente_idCliente AND cliente.idcliente = '$cliente' and venta.inactivo = 0";
		return ejecutarConsulta($sql);
	}


	public function rpt_extracto_cuotas_cliente_venta($cliente,$venta){
		$sql="SELECT cliente.nombreComercial, recibo.HABILITACION_IDHABILITACION, recibo.USUARIOINSERCION, detallerecibofacturas.VENTA_IDVENTA, 
recibo.IDRECIBO, recibo.FECHARECIBO, detallerecibofacturas.CUOTA,detalleventacuotas.nroCuota, detalleventacuotas.saldo, sum(MONTOAPLICADO) as ma from detalleventacuotas, detallerecibofacturas, recibo, cliente where cliente.idCliente = recibo.CLIENTE_IDCLIENTE and detallerecibofacturas.VENTA_IDVENTA = detalleventacuotas.Venta_idVenta and recibo.IDRECIBO = detallerecibofacturas.RECIBO_IDRECIBO 
and recibo.CLIENTE_IDCLIENTE = '$cliente' and detallerecibofacturas.VENTA_IDVENTA = '$venta' and detalleventacuotas.inactivo = 0 and detallerecibofacturas.inactivo = 0 and recibo.inactivo = 0 group by recibo.IDRECIBO";
		return ejecutarConsulta($sql);
	}


	public function rpt_empleado_comisiones($empleado, $fi, $ff){
	//$fenviar = date_add('$fi', INTERVAL -1 DAY);

		$sql="SELECT * from (
select
DATE_FORMAT(date_add('$fi', INTERVAL -1 DAY), '%d/%m/%Y') as fechaMovimiento,
'ACQUA - SPA' as nc, 
F_COMISIONES_A_LA_FECHA('$empleado', '$fi') as saldo,
'SALDO A LA FECHA' as paquete, 
'' as servicio,
'I' as tipoMovimiento,
F_COMISIONES_A_LA_FECHA('$empleado', '$fi') as importe

union

select 
DATE_FORMAT(date(ordenconsumisiondetalle.fecha_inicial), '%d/%m/%Y') as fechaMovimiento,
cliente.nombreComercial as nc,
F_COMISIONES_A_LA_FECHA('$empleado',  date_add('$fi', INTERVAL -1 DAY)) as saldo,
F_NOMBRE_ARTICULO(ordenconsumisiondetalle.Articulo_idArticulo) as paquete, 
F_NOMBRE_SERVICIO(clientedetalle.Articulo_idArticulo_Servicio) as servicio, 
empleadocomisiones.tipoMovimiento, 
sum(empleadocomisiones.importe) as importe 
from empleadocomisiones, empleado, ordenconsumisiondetalle, ordenconsumision, cliente, clientedetalle
where ordenconsumisiondetalle.OrdenConsumision_idOrdenConsumision = ordenconsumision.idOrdenConsumision and 
cliente.idCliente = ordenconsumision.Cliente_idCliente and
ordenconsumisiondetalle.idOrdenConsumisionDetalle = empleadocomisiones.OrdenConsumisionDetalle_idOrdenConsumisionDetalle 
and empleadocomisiones.Empleado_IdEmpleado = empleado.idEmpleado
and empleadocomisiones.inactivo = 0 and ordenconsumisiondetalle.inactivo = 0 and empleadocomisiones.Empleado_IdEmpleado = '$empleado' and empleadocomisiones.tipoMovimiento = 'I'
and clientedetalle.idclientedetalle = ordenconsumisiondetalle.Articulo_idArticulo_Servicio and date(ordenconsumisiondetalle.fecha_inicial) between '$fi' and '$ff'
group by ordenconsumisiondetalle.idOrdenConsumisionDetalle

UNION

select 
DATE_FORMAT(date(habilitacion.fechaApertura), '%d/%m/%Y') as fechaMovimiento, 
'ACQUA - SPA' as nc, 
'0' as saldo, 
'ACQUA SPA' as paquete, 
empleadocomisiones.descripcion as servicio, 
empleadocomisiones.tipoMovimiento, 
empleadocomisiones.importe as importe 
from empleadocomisiones, movimiento, habilitacion
where empleadocomisiones.inactivo = 0 and movimiento.inactivo = 0 and
empleadocomisiones.Movimiento_idMovimiento = movimiento.idMovimiento and
movimiento.habilitacion = habilitacion.idhabilitacion and
empleadocomisiones.tipoMovimiento = 'E' and 
empleadocomisiones.Empleado_IdEmpleado = '$empleado' and date(habilitacion.fechaApertura) between '$fi' and '$ff'
) AS A";
		return ejecutarConsulta($sql);
	}

	public function rpt_deudas_cobrar(){
		$sql="SELECT F_SALDO_CLIENTE(venta.Cliente_idCliente) as st, venta.fechaFactura, venta.Habilitacion_idHabilitacion, venta.usuario, cliente.nombreComercial, Venta_idVenta, venta.saldo, venta.total from detalleventacuotas, cliente, venta where venta.idVenta = detalleventacuotas.Venta_idVenta and cliente.idCliente = venta.Cliente_idCliente and detalleventacuotas.inactivo = 0 and venta.saldo > 0 and venta.inactivo = 0 group by Venta_idVenta";
		return ejecutarConsulta($sql);
	}


	public function rpt_recibos_habilitacion($habilitacion){
		$sql="SELECT recibo.IDRECIBO as nro, venta.idVenta idVenta,cliente.idCliente as idc, cliente.nombreComercial, recibo.USUARIO, recibo.HABILITACION_IDHABILITACION, recibo.FECHARECIBO, recibo.TOTAL 
from recibo, cliente, detallerecibofacturas, venta 
where recibo.IDRECIBO = detallerecibofacturas.RECIBO_IDRECIBO 
and detallerecibofacturas.VENTA_IDVENTA = venta.idVenta 
and cliente.idCliente = recibo.CLIENTE_IDCLIENTE 
and detallerecibofacturas.INACTIVO = 0 
and recibo.HABILITACION_IDHABILITACION='$habilitacion' group by recibo.idRecibo";
		return ejecutarConsulta($sql);		
	}



	public function recibo_cabecera($idRecibo){
		$sql="SELECT * , IDRECIBO, usuario, FECHARECIBO as a, total, cliente.razonSocial as nombreCliente, cliente.nroDocumento as ruc from recibo, cliente where recibo.CLIENTE_IDCLIENTE = cliente.idCliente and recibo.IDRECIBO = '$idRecibo'";
		return ejecutarConsulta($sql);		
	}

	public function recibo_detalle($idRecibo){
		$sql="SELECT * ,  detallerecibofacturas.VENTA_IDVENTA, venta.nroFactura, MONTOAPLICADO from recibo, detallerecibofacturas, venta where detallerecibofacturas.VENTA_IDVENTA = venta.idVenta and recibo.IDRECIBO = detallerecibofacturas.RECIBO_IDRECIBO and recibo.IDRECIBO = '$idRecibo'";
		return ejecutarConsulta($sql);		
	}

	public function articulos_vendidos_fecha($fi,$ff){
		$sql = "SELECT F_NOMBRE_ARTICULO(Articulo_idArticulo) as na, sum(cantidad) as cantidad 
		from detalleventa, venta where venta.idVenta = detalleventa.Venta_idVenta and venta.inactivo = 0 
		and detalleventa.inactivo = 0 and 
		venta.fechaFactura between '$fi' and '$ff' 
		group by detalleventa.Articulo_idArticulo order by 2 desc";

		return ejecutarConsulta($sql);
	}

public function rpt_clienteDetalle_ajuste($Cliente_idCliente)
	{
		if ($Cliente_idCliente == -1) {
			$sql="SELECT *, DATE_FORMAT(fechaFactura, '%d/%m/%Y') as ff  , cliente.nombreComercial, Articulo_idArticulo as paquete, F_NOMBRE_ARTICULO(Articulo_idArticulo) as npaquete, Articulo_idArticulo_Servicio as servicio, F_NOMBRE_SERVICIO(Articulo_idArticulo_Servicio) as nservicio, cantidad, clientedetalle.giftcard , clientedetalle.idclientedetalle as id from clientedetalle, cliente, venta where clientedetalle.Venta_idVenta = venta.idVenta and cliente.idCliente = clientedetalle.Cliente_idCliente and clientedetalle.Cliente_idCliente >= '$Cliente_idCliente' and venta.inactivo = 0";
		}else{
		$sql="SELECT *, DATE_FORMAT(fechaFactura, '%d/%m/%Y') as ff, cliente.nombreComercial, Articulo_idArticulo as paquete, F_NOMBRE_ARTICULO(Articulo_idArticulo) as npaquete, Articulo_idArticulo_Servicio as servicio, F_NOMBRE_SERVICIO(Articulo_idArticulo_Servicio) as nservicio, cantidad, clientedetalle.giftcard , clientedetalle.idclientedetalle as id from clientedetalle, cliente, venta where clientedetalle.Venta_idVenta = venta.idVenta and cliente.idCliente = clientedetalle.Cliente_idCliente and clientedetalle.Cliente_idCliente = '$Cliente_idCliente' and venta.inactivo = 0;";
		}
		return ejecutarConsulta($sql);
	}

	public function rpt_movimiento_fecha_concepto_egreso($fi,$ff, $concepto)
	{
		if ($concepto == 0) {
		$sql="SELECT *, date(habilitacion.fechaApertura) as fa, concepto.descripcion as cd, movimiento.descripcion as md 
		from movimiento, concepto, habilitacion 
		where movimiento.concepto = concepto.idConcepto and 
		habilitacion.idhabilitacion = movimiento.habilitacion and 
	    movimiento.inactivo = 0 and
	    concepto.tipo = 'E' and
		date(habilitacion.fechaApertura) between  '$fi' AND '$ff'";
		return ejecutarConsulta($sql);			
	}else{
		$sql="SELECT *, date(habilitacion.fechaApertura) as fa, concepto.descripcion as cd, movimiento.descripcion as md 
		from movimiento, concepto, habilitacion 
		where movimiento.concepto = concepto.idConcepto and 
		habilitacion.idhabilitacion = movimiento.habilitacion and
	    movimiento.inactivo = 0 and
	    concepto.idConcepto = '$concepto' and 
	    concepto.tipo = 'E' and
		date(habilitacion.fechaApertura) between  '$fi' AND '$ff'";
		return ejecutarConsulta($sql);
	}
	}

	public function rpt_movimiento_fecha_concepto_ingreso($fi,$ff, $concepto)
	{



		if ($concepto == 0) {
		$sql="SELECT *, date(habilitacion.fechaApertura) as fa, concepto.descripcion as cd, movimiento.descripcion as md 
		from movimiento, concepto, habilitacion 
		where movimiento.concepto = concepto.idConcepto and 
		habilitacion.idhabilitacion = movimiento.habilitacion and 
	    movimiento.inactivo = 0 and
	    concepto.tipo = 'I' and
		date(habilitacion.fechaApertura) between  '$fi' AND '$ff'";
		return ejecutarConsulta($sql);			
	}else{
		$sql="SELECT *, date(habilitacion.fechaApertura) as fa, concepto.descripcion as cd, movimiento.descripcion as md 
		from movimiento, concepto, habilitacion 
		where movimiento.concepto = concepto.idConcepto and 
		habilitacion.idhabilitacion = movimiento.habilitacion and
	    movimiento.inactivo = 0 and
	    concepto.idConcepto = '$concepto' and 
	    concepto.tipo = 'I' and
		date(habilitacion.fechaApertura) between  '$fi' AND '$ff'";
		return ejecutarConsulta($sql);
	}

	}

	

	public function rpt_tapasVentas($fi,$ff)
	{

		$sql="SELECT descripcion, ifnull(sum(cantidad),0) + 2313 as cantidad 
		from detallecompra, compra 
		where compra.inactivo = 0 and Articulo_idArticulo = 15 and idCompra = Compra_idCompra AND compra.fechaFactura between '$fi' and '$ff'
		union
		SELECT descripcion, ifnull(sum(cantidad),0) * -1 as cantidad 
		from detalleventa, venta 
		where idVenta = Venta_idVenta and venta.inactivo = 0 and Articulo_idArticulo in (11,1) AND venta.Remision = 'N' and venta.fechaFactura > '20230628' and venta.fechaFactura between '$fi' and '$ff' group by Articulo_idArticulo
		union
		SELECT CONCAT(articulo.descripcion,' = ', 'REMISION') AS descripcion, ifnull(sum(cantidad),0) * -1 as cantidad 
		from ventaRemisionDetalle, ventaRemision, articulo
		where idArticulo = Articulo_idArticulo and idRemision = Remision_idRemision and ventaRemision.inactivo = 0 and Articulo_idArticulo in (11,1)  and ventaRemision.fechaFactura > '20230628' and ventaRemision.fechaFactura between '$fi' and '$ff' group by Articulo_idArticulo;";
		return ejecutarConsulta($sql);

	}



	public function rpt_recaudaciones_gastos($fi,$ff)
	{

		$sql="SELECT 'RECIBOS' as descripcion, sum(total) as total from recibo where F_ESTADO_RECIBO_FACTURAS(recibo.idRecibo) = 0 and recibo.INACTIVO = 0 and recibo.FECHARECIBO between '$fi' and '$ff'
        union
select 'PAGOS A PROVEEDORES' as descripcion, sum(total)*-1 as total from pago where pago.inactivo = 0 and pago.FECHAPAGO between '$fi' and '$ff'
		union
select 'MOVIMIENTOS DE EGRESOS(GASTOS)' as descripcion, (sum(movimiento.monto) * -1) as total from movimiento, concepto, habilitacion where movimiento.concepto = concepto.idConcepto and concepto.tipo = 'E' 
		and movimiento.habilitacion = habilitacion.idhabilitacion and date(habilitacion.fechaApertura) between '$fi' and '$ff' and movimiento.inactivo = 0 and concepto.idConcepto <> 5;
        
        ";
		return ejecutarConsulta($sql);

	}


	public function rpt_consumisiones_cliente($fi,$ff, $idCliente)
	{

		$sql="


	SELECT 
	idclientedetalle, 
	F_NOMBRE_CLIENTE( venta.Cliente_idCliente ) nc, 
	F_NOMBRE_ARTICULO( ordenconsumisiondetalle.Articulo_idArticulo ) as na, 
	F_NOMBRE_SERVICIO( clientedetalle.Articulo_idArticulo_Servicio ) ns, 
	Venta_idVenta, 
	venta.fechaFactura,
	fecha_inicial, 
	fecha_final, 
	F_NOMBRE_EMPLEADO( ordenconsumisiondetalle.Empleado_IdEmpleado ) as ne,
	clientedetalle.cantidad as restante, 
	cantidadUtilizada 
	from 
	clientedetalle, ordenconsumisiondetalle, venta where
	venta.idVenta = clientedetalle.Venta_idVenta 
	and ordenconsumisiondetalle.Articulo_idArticulo_Servicio = clientedetalle.idclientedetalle 
	and clientedetalle.Cliente_idCliente = '$idCliente'
	and ordenconsumisiondetalle.cantidad = ordenconsumisiondetalle.cantidadUtilizada
	and ordenconsumisiondetalle.inactivo = 0
	and clientedetalle.inactivo = 0
	order by fecha_inicial asc


		";
		return ejecutarConsulta($sql);
	}


	public function rpt_ordenesConsumisionDetalle_d($fi,$ff, $idCliente, $idPaquete,$idServicio)
	{

		$sql="

		SELECT  
			idOrdenConsumision,
			idOrdenConsumisionDetalle,
			ordenconsumision.fechaConsumision as fechaCarga,
			F_NOMBRE_CLIENTE( ordenconsumision.Cliente_idCliente ) as cliente, 
			F_NOMBRE_SERVICIO( clientedetalle.Articulo_idArticulo ) as paquete,
			F_NOMBRE_SERVICIO( clientedetalle.Articulo_idArticulo_Servicio ) as servicio,  
			ordenconsumisiondetalle.cantidad,
			ordenconsumisiondetalle.cantidadUtilizada,
			fecha_inicial, 
			fecha_final, 
			F_NOMBRE_EMPLEADO(ordenconsumision.Empleado_IdEmpleado) as Usuario,
			F_NOMBRE_EMPLEADO(ordenconsumisiondetalle.Empleado_IdEmpleado) as atiende,
			venta.idVenta,
			venta.saldo
			from ordenconsumisiondetalle, ordenconsumision, clientedetalle, venta

			where 
			clientedetalle.Venta_idVenta = venta.idVenta and
			ordenconsumision.idOrdenConsumision = ordenconsumisiondetalle.OrdenConsumision_idOrdenConsumision 
			and clientedetalle.idclientedetalle = ordenconsumisiondetalle.Articulo_idArticulo_Servicio
			and ordenconsumision.Cliente_idCliente = '$idCliente' 
			and clientedetalle.Articulo_idArticulo = '$idPaquete' 
			and clientedetalle.idclientedetalle = '$idServicio'  
			and ordenconsumisiondetalle.fecha_inicial between '$fi' and '$ff';
		";
		return ejecutarConsulta($sql);
	}



	public function rpt_producto_x_fecha_x_orden($fi,$ff, $idEmpleado, $idArticulo)
	{


		if ($idArticulo == 'todos') {
	$sql="
		SELECT idOrdenConsumision, 
		idOrdenConsumisionDetalle, 
		F_NOMBRE_CLIENTE(venta.Cliente_idCLiente) as NombreCliente,
		venta.fechaFactura, 
		ordenconsumisiondetalle.fecha_inicial, 
		ordenconsumisiondetalle.fecha_final, 
		clientedetalle.Articulo_idArticulo, 
		F_NOMBRE_ARTICULO(detalleventa.Articulo_idArticulo) as na, 
		clientedetalle.Articulo_idArticulo_Servicio,
		F_NOMBRE_SERVICIO(clientedetalle.Articulo_idArticulo_Servicio), 
		detalleventa.precio as PrecioVenta,
		sum(F_COMISION_PAQUETE_SERVICIO(clientedetalle.Articulo_idArticulo,clientedetalle.Articulo_idArticulo_Servicio, ordenconsumisiondetalle.cantidad)) as comision,
		empleado.nombreComercial as NombreEmpleado,
		venta.saldo,
		venta.vendedor as Vendedor,
		venta.idVenta,
		venta.fechaFactura as fechaVenta,
        venta.idVenta as idVenta
		from ordenconsumision, ordenconsumisiondetalle, clientedetalle, venta, empleado, detalleventa
		where ordenconsumision.idOrdenConsumision = ordenconsumisiondetalle.OrdenConsumision_idOrdenConsumision 
		and ordenconsumisiondetalle.Articulo_idArticulo_Servicio = clientedetalle.idclientedetalle 
		and venta.idVenta = clientedetalle.Venta_idVenta 
		and clientedetalle.Articulo_idArticulo = detalleventa.Articulo_idArticulo
		and empleado.idEmpleado = ordenconsumisiondetalle.Empleado_IdEmpleado 
		and venta.idVenta = detalleventa.Venta_idVenta
		and date(venta.fechaFactura) between '$fi' and '$ff' 
		group by venta.idVenta, ordenconsumisiondetalle.Articulo_idArticulo;			
		";
	


		}else{

	$sql="
		SELECT idOrdenConsumision, 
		idOrdenConsumisionDetalle, 
		F_NOMBRE_CLIENTE(venta.Cliente_idCLiente) as NombreCliente,
		venta.fechaFactura, 
		ordenconsumisiondetalle.fecha_inicial, 
		ordenconsumisiondetalle.fecha_final, 
		clientedetalle.Articulo_idArticulo, 
		F_NOMBRE_ARTICULO(detalleventa.Articulo_idArticulo) as na, 
		clientedetalle.Articulo_idArticulo_Servicio,
		F_NOMBRE_SERVICIO(clientedetalle.Articulo_idArticulo_Servicio), 
		detalleventa.precio as PrecioVenta,
		sum(F_COMISION_PAQUETE_SERVICIO(clientedetalle.Articulo_idArticulo,clientedetalle.Articulo_idArticulo_Servicio, ordenconsumisiondetalle.cantidad)) as comision,
		empleado.nombreComercial as NombreEmpleado,
		venta.saldo,
		venta.vendedor as Vendedor,
		venta.idVenta,
		venta.fechaFactura as fechaVenta,
        venta.idVenta as idVenta
		from ordenconsumision, ordenconsumisiondetalle, clientedetalle, venta, empleado, detalleventa
		where ordenconsumision.idOrdenConsumision = ordenconsumisiondetalle.OrdenConsumision_idOrdenConsumision 
		and ordenconsumisiondetalle.Articulo_idArticulo_Servicio = clientedetalle.idclientedetalle 
		and venta.idVenta = clientedetalle.Venta_idVenta 
		and empleado.idEmpleado = ordenconsumisiondetalle.Empleado_IdEmpleado 
		and clientedetalle.Articulo_idArticulo = detalleventa.Articulo_idArticulo
		and venta.idVenta = detalleventa.Venta_idVenta
		and detalleventa.Articulo_idArticulo = '$idArticulo' 
		and date(venta.fechaFactura) between '$fi' and '$ff' 
		group by venta.idVenta, ordenconsumisiondetalle.Articulo_idArticulo;			
		";
	

		}


		return ejecutarConsulta($sql);
	}


	public function rpt_producto_x_fecha_x_orden_d($fi,$ff, $idEmpleado, $idArticulo)
	{


		if ($idArticulo == 'todos') {


		$sql="
		SELECT idOrdenConsumision, 
		idOrdenConsumisionDetalle, 
		F_NOMBRE_CLIENTE(venta.Cliente_idCLiente) as NombreCliente,
		venta.fechaFactura, 
		ordenconsumisiondetalle.fecha_inicial, 
		ordenconsumisiondetalle.fecha_final, 
		clientedetalle.Articulo_idArticulo, 
		F_NOMBRE_ARTICULO(detalleventa.Articulo_idArticulo) as na, 
		clientedetalle.Articulo_idArticulo_Servicio,
		F_NOMBRE_SERVICIO(clientedetalle.Articulo_idArticulo_Servicio), 
		detalleventa.precio as PrecioVenta,
		F_COMISION_PAQUETE_SERVICIO(clientedetalle.Articulo_idArticulo,clientedetalle.Articulo_idArticulo_Servicio, ordenconsumisiondetalle.cantidadUtilizada) as comision,
		empleado.nombreComercial as NombreEmpleado,
		venta.saldo,
		empleado.nombreComercial as Vendedor,
		venta.idVenta,
		venta.fechaFactura as fechaVenta,
        venta.idVenta as idVenta
		from ordenconsumision, ordenconsumisiondetalle, clientedetalle, venta, empleado, detalleventa
		where ordenconsumision.idOrdenConsumision = ordenconsumisiondetalle.OrdenConsumision_idOrdenConsumision 
		and ordenconsumisiondetalle.Articulo_idArticulo_Servicio = clientedetalle.idclientedetalle 
		and venta.idVenta = clientedetalle.Venta_idVenta 
		and empleado.idEmpleado = ordenconsumisiondetalle.Empleado_IdEmpleado 
		and venta.idVenta = detalleventa.Venta_idVenta
		and ordenconsumisiondetalle.cantidadUtilizada > 0
		and clientedetalle.Articulo_idArticulo = detalleventa.Articulo_idArticulo
		and date(venta.fechaFactura) between '$fi' and '$ff' ;						
		";

		}else{


		$sql="
		SELECT idOrdenConsumision, 
		idOrdenConsumisionDetalle, 
		F_NOMBRE_CLIENTE(venta.Cliente_idCLiente) as NombreCliente,
		venta.fechaFactura, 
		ordenconsumisiondetalle.fecha_inicial, 
		ordenconsumisiondetalle.fecha_final, 
		clientedetalle.Articulo_idArticulo, 
		F_NOMBRE_ARTICULO(detalleventa.Articulo_idArticulo) as na, 
		clientedetalle.Articulo_idArticulo_Servicio,
		F_NOMBRE_SERVICIO(clientedetalle.Articulo_idArticulo_Servicio), 
		detalleventa.precio as PrecioVenta,
		F_COMISION_PAQUETE_SERVICIO(clientedetalle.Articulo_idArticulo,clientedetalle.Articulo_idArticulo_Servicio, ordenconsumisiondetalle.cantidadUtilizada) as comision,
		empleado.nombreComercial as NombreEmpleado,
		venta.saldo,
		empleado.nombreComercial as Vendedor,
		venta.idVenta,
		venta.fechaFactura as fechaVenta,
        venta.idVenta as idVenta
		from ordenconsumision, ordenconsumisiondetalle, clientedetalle, venta, empleado, detalleventa
		where ordenconsumision.idOrdenConsumision = ordenconsumisiondetalle.OrdenConsumision_idOrdenConsumision 
		and ordenconsumisiondetalle.Articulo_idArticulo_Servicio = clientedetalle.idclientedetalle 
		and venta.idVenta = clientedetalle.Venta_idVenta 
		and empleado.idEmpleado = ordenconsumisiondetalle.Empleado_IdEmpleado 
		and venta.idVenta = detalleventa.Venta_idVenta
		and clientedetalle.Articulo_idArticulo = detalleventa.Articulo_idArticulo
		and ordenconsumisiondetalle.cantidadUtilizada > 0
		and detalleventa.Articulo_idArticulo = '$idArticulo' 
		and date(venta.fechaFactura) between '$fi' and '$ff' ;						
		";

		}
		return ejecutarConsulta($sql);
	}
	
	public function hechaukaCompras($fecha_inicio,$fecha_fin)
	{
		$sql="CALL SP_Hechauka_Compras('$fecha_inicio','$fecha_fin')";
		return ejecutarConsulta($sql);
	}
	
	public function hechaukaVentas($fecha_inicio,$fecha_fin)
	{
		$sql="CALL SP_Hechauka_Ventas('$fecha_inicio','$fecha_fin')";
		return ejecutarConsulta($sql);
	}

	public function libroDiario($fecha_inicio,$fecha_fin,$cuenta_inicio,$cuenta_fin)
	{

		if ($cuenta_inicio == null && $cuenta_fin == null){
			$sql="SELECT a.idAsiento ,a.fechaAsiento as fechaAsiento,a.comentario,c.descripcion as cuentaContableDesc,(CASE tipoMovimiento
	         WHEN 1 THEN 'Debito'
	         ELSE 'Credito'
	      END) as tipoMovimientoDesc,(CASE tipoMovimiento
	         WHEN 1 THEN importe
	         ELSE 0
	      END) as Debito,
	      (CASE tipoMovimiento
	         WHEN 2 THEN importe
	         ELSE 0
	      END) as Credito,b.Concepto_idConcepto  
			from asiento a 
			join asientodetalle b on a.idAsiento=b.Asiento_idAsiento 
			left outer join cuentacontable c on b.CuentaContable_idCuentaContable=c.idCuentaContable
			where a.fechaAsiento between '$fecha_inicio' and '$fecha_fin' and a.inactivo=0";
			return ejecutarConsulta($sql);
		}
		else{
			$sql="SELECT a.idAsiento ,a.fechaAsiento as fechaAsiento,a.comentario,c.descripcion as cuentaContableDesc,(CASE tipoMovimiento
	         WHEN 1 THEN 'Debito'
	         ELSE 'Credito'
	      END) as tipoMovimientoDesc,(CASE tipoMovimiento
	         WHEN 1 THEN importe
	         ELSE 0
	      END) as Debito,
	      (CASE tipoMovimiento
	         WHEN 2 THEN importe
	         ELSE 0
	      END) as Credito,b.Concepto_idConcepto  
			from asiento a 
			join asientodetalle b on a.idAsiento=b.Asiento_idAsiento
			left outer join cuentacontable c on b.CuentaContable_idCuentaContable=c.idCuentaContable 
			where a.fechaAsiento between '$fecha_inicio' and '$fecha_fin' and a.inactivo=0 and c.idCuentaContable between '$cuenta_inicio' and '$cuenta_fin'";
			return ejecutarConsulta($sql);			
		}	

	}	
	


	public function libroMayor($fecha_inicio,$fecha_fin,$cuenta_inicio,$cuenta_fin)
	{ 

		if ($cuenta_inicio == null && $cuenta_fin == null){
			$sql="SELECT a.idAsiento ,a.fechaAsiento as fechaAsiento,a.comentario,c.descripcion as cuentaContableDesc,(CASE tipoMovimiento
	         WHEN 1 THEN 'Debito'
	         ELSE 'Credito'
	      END) as tipoMovimientoDesc,(CASE tipoMovimiento
	         WHEN 1 THEN importe
	         ELSE 0
	      END) as Debito,
	      (CASE tipoMovimiento
	         WHEN 2 THEN importe
	         ELSE 0
	      END) as Credito,b.Concepto_idConcepto  
			from asiento a 
			join asientodetalle b on a.idAsiento=b.Asiento_idAsiento 
			join cuentacontable c on b.CuentaContable_idCuentaContable=c.idCuentaContable
			where a.fechaAsiento between '$fecha_inicio' and '$fecha_fin' and a.inactivo=0 
			order by c.idCuentaContable,a.fechaAsiento,a.idAsiento";
			return ejecutarConsulta($sql);
		}
		else{
			$sql="SELECT c.descripcion as cuentaContableDesc,a.fechaAsiento as fechaAsiento,a.idAsiento ,a.comentario,(CASE tipoMovimiento
	         WHEN 1 THEN 'Debito'
	         ELSE 'Credito'
	      END) as tipoMovimientoDesc,(CASE tipoMovimiento
	         WHEN 1 THEN importe
	         ELSE 0
	      END) as Debito,
	      (CASE tipoMovimiento
	         WHEN 2 THEN importe
	         ELSE 0
	      END) as Credito,b.concepto  
			from asiento a 
			join asientodetalle b on a.idAsiento=b.Asiento_idAsiento
			join cuentacontable c on b.CuentaContable_idCuentaContable=c.idCuentaContable 
			where a.fechaAsiento between '$fecha_inicio' and '$fecha_fin' and a.inactivo=0 and c.idCuentaContable between '$cuenta_inicio' and '$cuenta_fin'
			order by c.idCuentaContable,a.fechaAsiento,a.idAsiento";
			return ejecutarConsulta($sql);			
		}	

	}

	public function balance($cuenta_inicio,$cuenta_fin,$fecha_inicio,$fecha_fin)
	{
		$usuario = 'admin';
		$sql="CALL SP_Balance('$cuenta_inicio','$cuenta_fin','$fecha_inicio','$fecha_fin')";
		return ejecutarConsulta($sql);
	}	

	public function balanceReporte($cuenta_inicio,$cuenta_fin,$fecha_inicio,$fecha_fin)
	{
		$usuario = 'admin';
		$sql="	SELECT b.descripcion as cuentaContableDesc,b.nroCuentaContable,b.nroCuentaContable,
				ifnull(a.saldoAnterior,0) as saldoAnterior,ifnull(a.saldoActual,0) as saldoActual,
				ifnull(a.debitoAcumulado,0) as debitoAcumulado,ifnull(a.creditoAcumulado,0) as creditoAcumulado,
				ifnull(a.debito,0) as debito,ifnull(a.credito,0) as credito,b.nivel
				from cuentacontable b left outer join balancecontable a
				on   a.CuentaContable_idCuentaContable =  b.idCuentaContable  and a.inactivo=0 and b.inactivo=0 and a.fecha =  '$fecha_fin'
				where b.nroCuentaContable<>'0'
				order by nroCuentaContable";
		return ejecutarConsulta($sql);
	}	


	public function GeneraBalance($cuenta_inicio,$cuenta_fin,$fecha_inicio,$fecha_fin)
	{
		$usuario = 'admin';
		$sql="CALL SP_GeneraBalance('$cuenta_inicio','$cuenta_fin','$fecha_inicio','$fecha_fin')";
		return ejecutarConsulta($sql);
	}		

	public function agrupacionCuentasContables($fecha_inicio,$fecha_fin,$cuenta_inicio,$cuenta_fin)
	{
		$usuario = 'admin';
		$sql="CALL SP_CuentasContablesAgrupadas('$fecha_inicio','$fecha_fin','$cuenta_inicio','$cuenta_fin')";
		return ejecutarConsulta($sql);
	}

	public function maestroSaldos($cuenta_inicio,$cuenta_fin)
	{
		$usuario = 'admin';
		$sql="CALL SP_MaestroSaldos('$cuenta_inicio','$cuenta_fin')";
		return ejecutarConsulta($sql);
	}

	public function GenerarMaestroSaldos($cuenta_inicio,$cuenta_fin)
	{
		$usuario = 'admin';
		$sql="CALL SP_GeneraMaestroSaldos('$cuenta_inicio','$cuenta_fin')";
		return ejecutarConsulta($sql);
	}	

	public function GeneraAgrupacionCuentasContables($fecha_inicio,$fecha_fin,$cuenta_inicio,$cuenta_fin)
	{
		$usuario = 'admin';
		$sql="CALL SP_GeneraCuentasContablesAgrupadas('$fecha_inicio','$fecha_fin','$cuenta_inicio','$cuenta_fin')";
		return ejecutarConsulta($sql);
	}

	public function rptordenventas($fecha_inicio,$fecha_fin)
	{
		$usuario = 'admin';
		$sql="CALL SP_ListadoOrdenesVentas('1','$usuario','$fecha_inicio','$fecha_fin')";
		return ejecutarConsulta($sql);
	}
	
 

	public function rptventas($fecha_inicio,$fecha_fin)
	{
		$sql="CALL SP_ListadoVentas('1','1','$fecha_inicio','$fecha_fin')";
		return ejecutarConsulta($sql);
	}
	

	
	public function rptventasAnuladas($fecha_inicio,$fecha_fin)
	{
		$sql="CALL SP_ListadoVentasAnuladas('1','1','$fecha_inicio','$fecha_fin')";
		return ejecutarConsulta($sql);
	}
	
	public function rptpagos($fecha_inicio,$fecha_fin)
	{
		$sql="CALL SP_ListadoPagos('1','1','$fecha_inicio','$fecha_fin')";
		return ejecutarConsulta($sql);
	}
	
	public function rptpagosAnulados($fecha_inicio,$fecha_fin)
	{
		$sql="CALL SP_ListadoPagosAnulados('1','1','$fecha_inicio','$fecha_fin')";
		return ejecutarConsulta($sql);
	}
	
	public function rptrecibosAnulados($fecha_inicio,$fecha_fin)
	{
		$sql="CALL SP_ListadoRecibosAnulados('1','1','$fecha_inicio','$fecha_fin')";
		return ejecutarConsulta($sql);
	}
	
	public function rptrecibos($fecha_inicio,$fecha_fin)
	{
		$sql="SELECT idRecibo, p.nombreComercial, p.nroDocumento, v.USUARIOINSERCION as usuario, v.Habilitacion_idHabilitacion as nroFactura, v.fechaTransaccion, v.total, p.cobrador
			FROM recibo v
			LEFT JOIN persona p ON p.idPersona = v.CLIENTE_IDCLIENTE
			JOIN detallerecibofacturas drv ON drv.RECIBO_IDRECIBO = v.IDRECIBO
			JOIN venta ve ON ve.idVenta = drv.VENTA_IDVENTA
			WHERE v.inactivo = 0 
			and v.fechaTransaccion BETWEEN '$fecha_inicio' and '$fecha_fin'
			GROUP BY idRecibo";
		return ejecutarConsulta($sql);
	}
	

	public function libroCompras($fecha_inicio,$fecha_fin)
	{
		$sql="CALL SP_Hechauka_Compras('$fecha_inicio','$fecha_fin')";
		return ejecutarConsulta($sql);
	}
	
	public function libroVentas($fecha_inicio,$fecha_fin)
	{
		$sql="CALL SP_Hechauka_Ventas('$fecha_inicio','$fecha_fin')";
		return ejecutarConsulta($sql);
	}





}

?>
