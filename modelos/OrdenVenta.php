<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
Class OrdenVenta
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($Persona_idPersona,$Habilitacion_idHabilitacion,$Deposito_idDeposito,$TerminoPago_idTerminoPago,$fecha,$idarticulo,$cantidad,$precioVenta,$descuento,$impuesto, $capital, $interes, $tipo, $formaEntrega, $fechaEntrega)
	{
		$usuario = $_SESSION['login'];
		$sql="INSERT INTO `ordenventa`
									(
									`Persona_idPersona`,
									`TerminoPago_idTerminoPago`,
									`Habilitacion_idHabilitacion`,
									`Deposito_idDeposito`, `fecha`, `usuarioInsercion`,
									`tipo`,
									`formaEntrega`,
									`fechaEntrega`)
									VALUES
									(
									'$Persona_idPersona',
									'$TerminoPago_idTerminoPago',
									'$Habilitacion_idHabilitacion',
									'$Deposito_idDeposito',
									'$fecha',
									'$usuario',
									'$tipo',
									'$formaEntrega',
									'$fechaEntrega'
									)";

		//return ejecutarConsulta($sql);


		$idov=ejecutarConsulta_retornarID($sql);

		$num_elementos=0;
		$sw=true;
		$l_impuestp = 0;
		while ($num_elementos < count($idarticulo))
		{
			if ($impuesto[$num_elementos] == 5) {
				$l_impuestp = 21;
			}

			if ($impuesto[$num_elementos] == 10) {
				$l_impuestp = 11;
			}

			if ($impuesto[$num_elementos] == 0) {
				$l_impuestp = 1;
			}

			$l_capital = /*$cantidad[$num_elementos] */ $capital[$num_elementos];
			$l_interes = /*$cantidad[$num_elementos] */ $interes[$num_elementos];



			$totalv = $cantidad[$num_elementos] * $precioVenta[$num_elementos];
			$netov = ( $totalv / $l_impuestp);
			$sql_detalle = "INSERT INTO `detalleordenventa`
							(
							`OrdenVenta_idOrdenVenta`,
							`Articulo_idArticulo`,
							`cantidad`,
							`precio`,
							`descuento`,
							`impuesto`,
							`totalNeto`,
							`total`,
							`inactivo`,
							`capital`,
							`interes`

							)
							VALUES
							(
							'$idov',
							'$idarticulo[$num_elementos]',
							'$cantidad[$num_elementos]',
							'$precioVenta[$num_elementos]',
							'$descuento[$num_elementos]',
							'$impuesto[$num_elementos]',
							'$netov',
							'$totalv',
							0,	
							'$l_capital',
							'$l_interes'

							)";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}




		return $sw;
	}

	
	//Implementamos un método para anular la venta
	public function anular($idVenta)
	{
		$sw=true;
		$sql="UPDATE venta SET inactivo='1' WHERE idVenta='$idVenta'";
		ejecutarConsulta($sql) or $sw = false;

		if ($sw==true) {
			$sql2="UPDATE detallerecibofacturas SET inactivo='1' WHERE VENTA_IDVENTA ='$idVenta'";
			ejecutarConsulta($sql2) or $sw = false;
		}

		return $sw;

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

	//Implementar un método para listar los registros
	public function listar($habilitacion)
	{
		
		$usuario = $_SESSION['login'];
		IF ($usuario == 'admin'){
			$sql="SELECT idOrdenVenta, Deposito_idDeposito, Habilitacion_idHabilitacion, fecha, terminopago.descripcion AS tpd, persona.razonSocial as rs, ordenventa.totalImpuesto, ordenventa.subTotal, sum(dov.total) as total, ordenventa.usuarioInsercion as ovui, ordenventa.usuarioModificacion as ovum, ordenventa.inactivo as ovi, ordenventa.formaEntrega, ordenventa.tipo, ordenventa.fechaEntrega
			from ordenventa JOIN terminopago ON ordenventa.TerminoPago_idTerminoPago = terminopago.idTerminoPago
            JOIN persona ON ordenventa.Persona_idPersona = persona.idPersona 
            JOIN detalleordenventa dov ON dov.OrdenVenta_idOrdenVenta = ordenventa.idOrdenVenta
            GROUP BY idOrdenVenta
			ORDER BY idOrdenVenta DESC LIMIT 100";
		}else{
			$sql="SELECT idOrdenVenta, Deposito_idDeposito, Habilitacion_idHabilitacion, fecha, terminopago.descripcion AS tpd, persona.razonSocial as rs, ordenventa.totalImpuesto, ordenventa.subTotal, sum(dov.total) as total, ordenventa.usuarioInsercion as ovui, ordenventa.usuarioModificacion as ovum, ordenventa.inactivo as ovi, ordenventa.formaEntrega, ordenventa.tipo, ordenventa.fechaEntrega
			from ordenventa JOIN terminopago ON ordenventa.TerminoPago_idTerminoPago = terminopago.idTerminoPago
            JOIN persona ON ordenventa.Persona_idPersona = persona.idPersona 
            JOIN detalleordenventa dov ON dov.OrdenVenta_idOrdenVenta = ordenventa.idOrdenVenta
			where ordenventa.usuarioInsercion = '$usuario'
            GROUP BY idOrdenVenta
			ORDER BY idOrdenVenta DESC LIMIT 100";
		
		}
		
		return ejecutarConsulta($sql);		
	}
	
	public function listarAFacturar($habilitacion)
	{
		$sql="SELECT persona.idPersona as idPersona, idOrdenVenta, Deposito_idDeposito, Habilitacion_idHabilitacion, fecha, terminopago.descripcion AS tpd, persona.razonSocial as rs, totalImpuesto, subTotal, sum(dov.total) as total, ordenventa.usuarioInsercion as ovui, ordenventa.usuarioModificacion as ovum, ordenventa.inactivo as ovi, ordenventa.facturado, ordenventa.TerminoPago_idTerminoPago, F_TERMINOPAGO_CONTADO(idTerminoPago) as contado, formaEntrega, fechaEntrega
			from ordenventa JOIN terminopago ON ordenventa.TerminoPago_idTerminoPago = terminopago.idTerminoPago
            JOIN persona ON ordenventa.Persona_idPersona = persona.idPersona 
            JOIN detalleordenventa dov ON dov.OrdenVenta_idOrdenVenta = ordenventa.idOrdenVenta
			where facturado = 0 and ordenventa.tipo = 1 and ordenventa.inactivo = 0 GROUP BY idOrdenVenta ORDER BY idOrdenVenta DESC LIMIT 1000";
		return ejecutarConsulta($sql);
	}

	public function listarFacturados($habilitacion)
	{
		$sql="SELECT persona.idPersona as idPersona, idVenta as idOrdenVenta, v.Deposito_idDeposito, v.Habilitacion_idHabilitacion, v.fechaTransaccion as fecha, terminopago.descripcion AS tpd, persona.razonSocial as rs, v.totalImpuesto, v.totalNeto, v.total, v.usuarioInsercion as ovui, v.usuarioModificacion as ovum, v.inactivo as ovi, 1 as facturado, v.formaEntrega, fechaEntrega
			from venta as v, terminopago, persona, ordenventa ov
			where v.Cliente_idCliente = persona.idPersona and v.TerminoPago_idTerminoPago = terminopago.idTerminoPago and v.inactivo = 0 AND ov.idOrdenVenta = v.OrdenVenta_idOrdenVenta ORDER BY idVenta DESC LIMIT 100;";
		return ejecutarConsulta($sql);
	}



	public function listarFacturadosDirecta($habilitacion)
	{
		$sql="SELECT persona.idPersona as idPersona, idVenta as idOrdenVenta, v.Deposito_idDeposito, v.Habilitacion_idHabilitacion, v.fechaTransaccion as fecha, terminopago.descripcion AS tpd, persona.razonSocial as rs, v.totalImpuesto, v.totalNeto, v.total, v.usuarioInsercion as ovui, v.usuarioModificacion as ovum, v.inactivo as ovi, 1 as facturado, v.formaEntrega
			from venta as v, terminopago, persona
			where v.Cliente_idCliente = persona.idPersona and v.TerminoPago_idTerminoPago = terminopago.idTerminoPago and v.inactivo = 0  ORDER BY idVenta DESC LIMIT 100;";
		return ejecutarConsulta($sql);
	}


	public function ventacabecera($idVenta){
		//$sql="SELECT v.idventa,v.idcliente,p.nombre as cliente,p.direccion,p.tipo_documento,p.num_documento,p.email,p.telefono,v.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,date(v.fecha_hora) as fecha,v.impuesto,v.total_venta FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
		
		$sql="SELECT *,Cliente.razonSocial as nombreCliente, Cliente.nroDocumento as ruc from venta, cliente WHERE  cliente.idCliente = venta.Cliente_idCliente and Habilitacion_idHabilitacion = '$idVenta'";

		return ejecutarConsulta($sql);
	}

	public function habilitacioncabecera($habilitacion){
		//$sql="SELECT v.idventa,v.idcliente,p.nombre as cliente,p.direccion,p.tipo_documento,p.num_documento,p.email,p.telefono,v.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,date(v.fecha_hora) as fecha,v.impuesto,v.total_venta FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
		
		$sql="SELECT * from habilitacion, usuario where usuario.idusuario = habilitacion.Usuario_idUsuario and idhabilitacion = '$habilitacion';";

		return ejecutarConsulta($sql);
	}

	public function detalleventahabilitacion($habilitacion){
		//$sql="SELECT v.idventa,v.idcliente,p.nombre as cliente,p.direccion,p.tipo_documento,p.num_documento,p.email,p.telefono,v.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,date(v.fecha_hora) as fecha,v.impuesto,v.total_venta FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
		
		$sql="select venta.idVenta, venta.saldo, F_NOMBRE_CLIENTE(venta.Cliente_idCliente) as nc, F_NOMBRE_ARTICULO( detalleventa.Articulo_idArticulo ) as descripcion, detalleventa.precio as precio, detalleventa.cantidad as cantidad, (detalleventa.precio * detalleventa.cantidad) as totalItem, venta.total as totalVenta from detalleventa, venta where venta.idVenta = detalleventa.Venta_idVenta and venta.Habilitacion_idHabilitacion ='$habilitacion';
		";

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
				sucursal.nombre as sucursal,
			habilitacion.usuario_ins as usuario_ins


				FROM habilitacion, caja,sucursal, deposito, documentocajero
				where
				 habilitacion.Usuario_idUsuario = '$user' and 
				 caja.idcaja = habilitacion.Caja_idCaja and 
				 caja.Sucursal_idSucursal = sucursal.idsucursal and 
				 habilitacion.estado = 1 and deposito.Sucursal_idSucursal = sucursal.idSucursal and documentocajero.Usuario_idUsuario = habilitacion.Usuario_idUsuario ";


		return ejecutarConsultaSimpleFila($sql);
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
		    habilitacion.idhabilitacion = '$habilitacion' and 
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
	

	
	//Implementamos un método para anular la venta
	public function cambiarPersonaGiftCard($idVenta,$clienteGiftCard)
	{
		$sql="UPDATE venta SET clienteGiftCard='$clienteGiftCard' WHERE idVenta='$idVenta'";

		return ejecutarConsulta($sql);


	}

	//Implementamos un método para anular la venta
	public function cambiarNroGiftCard($idVenta,$nroGiftCard)
	{
		$sql="UPDATE venta SET nroGiftCard='$nroGiftCard' WHERE idVenta='$idVenta'";

		return ejecutarConsulta($sql);


	}
	
		//Implementar un método para listar los registros
	public function rpt_ov_cabecera($idOrdenVenta)
	{
		$sql="

		SELECT 
			idOrdenVenta,
			Deposito_idDeposito,
			fecha,
			terminopago.descripcion AS tpd,
			persona.razonSocial AS rs,
			totalImpuesto,
			subTotal,
			total,
			ordenventa.usuarioInsercion AS ocui,
			ordenventa.usuarioModificacion AS ocum,
			ordenventa.fechaModificacion,
			ordenventa.fechaInsercion,
			ordenventa.inactivo AS oci,
			deposito.descripcion AS dd,
			sucursal.nombre AS ds,
			sucursal.direccion AS direccion,
			sucursal.telefono AS telefono,
			sucursal.correo AS correo,
			sucursal.ciudad AS ciudad,
			persona.nroDocumento as ruc,
			persona.direccion as direccion,
			usuario.nombre as vendedor
            
		FROM
			ordenventa,
			terminopago,
			persona,
			deposito,
			sucursal,
            usuario
            
		WHERE
			sucursal.idSucursal = deposito.Sucursal_idSucursal
				AND deposito.idDeposito = ordenventa.Deposito_idDeposito
				AND ordenventa.Persona_idPersona = persona.idPersona
				AND ordenventa.TerminoPago_idTerminoPago = terminopago.idTerminoPago
                AND usuario.login = ordenventa.usuarioInsercion
				AND idOrdenVenta =  '$idOrdenVenta';

		";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros
	public function rpt_ov_detalle($idOrdenVenta)
	{
		$sql="SELECT codigo, codigoAlternativo, codigoBarra, detalleordenventa.descripcion, cantidad, (precio-(precio*descuento/100)) as precio, (cantidad*(precio-(precio*descuento/100))) as l_subtotal 
from detalleordenventa, articulo 
where articulo.idArticulo = Articulo_idArticulo and OrdenVenta_idOrdenVenta = '$idOrdenVenta';";
		return ejecutarConsulta($sql);		
	}

}
?>