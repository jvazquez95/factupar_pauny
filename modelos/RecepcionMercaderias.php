<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
Class RecepcionMercaderias
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($Persona_idPersona,$Habilitacion_idHabilitacion,$Deposito_idDeposito,$TerminoPago_idTerminoPago,$fecha,$idarticulo,$cantidad,$precioVenta,$descuento,$impuesto)
	{
		$usuario = $_SESSION['login'];
		$sql="INSERT INTO `ordenventa`
									(
									`Persona_idPersona`,
									`TerminoPago_idTerminoPago`,
									`Habilitacion_idHabilitacion`,
									`Deposito_idDeposito`, `fecha`, `usuarioInsercion`)
									VALUES
									(
									'$Persona_idPersona',
									'$TerminoPago_idTerminoPago',
									'$Habilitacion_idHabilitacion',
									'$Deposito_idDeposito',
									'$fecha',
									'$usuario'
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
							`inactivo`)
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
							0	
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

	public function mostrarDetalle($OrdenCompra_idOrdenCompra)
	{
		$sql="SELECT idDetalleOrdenCompra, OrdenCompra_idOrdenCompra, nombre, detalleordencompra.descripcion, idArticulo, codigoBarra, codigoAlternativo as codSap ,cantidad,cantidadPendiente , cantidadRecibida, faltante, devuelta, comentario from detalleordencompra, articulo where idArticulo = Articulo_idArticulo AND OrdenCompra_idOrdenCompra = '$OrdenCompra_idOrdenCompra';";
		return ejecutarConsulta($sql);
	}





	public function mostrarDetalleRecibido($OrdenCompra_idOrdenCompra)
	{
		$sql="
			SELECT 
			idDetalleOrdenCompraRecibido, 
			OrdenCompraRecibido_idOrdenCompraRecibido, 
			nombre, 
			detalleordencomprarecibido.descripcion, 
			idArticulo, 
			codigoBarra, 
			codigoAlternativo as codSap,
			cantidad,
			cantidadRecibida, 
			faltante, 
			devuelta, 
			comentario 
			from detalleordencomprarecibido, articulo where idArticulo = Articulo_idArticulo AND OrdenCompraRecibido_idOrdenCompraRecibido = '$OrdenCompra_idOrdenCompra'

		";
		return ejecutarConsulta($sql);
	}




	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT 
			ordencompra.HacerPedido_idHacerPedido,
			recibido,
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
			sucursal.nombre as ds
		from 
			ordencompra, terminopago, persona, deposito, sucursal 
		where 
			sucursal.idSucursal = deposito.Sucursal_idSucursal and
			deposito.idDeposito = ordencompra.Deposito_idDeposito and
			ordencompra.Persona_idPersona = persona.idPersona and 
			ordencompra.TerminoPago_idTerminoPago = terminopago.idTerminoPago and recibido in (0,1) and verificado = 0";
		return ejecutarConsulta($sql);		
	}



	//Implementar un método para listar los registros
	public function listarTerminados()
	{
		$sql="SELECT 
			ordencompra.HacerPedido_idHacerPedido,
			recibido,
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
			sucursal.nombre as ds
		from 
			ordencompra, terminopago, persona, deposito, sucursal 
		where 
			sucursal.idSucursal = deposito.Sucursal_idSucursal and
			deposito.idDeposito = ordencompra.Deposito_idDeposito and
			ordencompra.Persona_idPersona = persona.idPersona and 
			ordencompra.TerminoPago_idTerminoPago = terminopago.idTerminoPago and recibido in (0,1) and verificado = 1";
		return ejecutarConsulta($sql);		
	}


	//Implementar un método para listar los registros
	public function listarCierre()
	{
		$sql="SELECT 
			nroCompra,
			recibido,
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
			sucursal.nombre as ds
		from 
			ordencomprarecibido, terminopago, persona, deposito, sucursal 
		where 
			sucursal.idSucursal = deposito.Sucursal_idSucursal and
			deposito.idDeposito = ordencomprarecibido.Deposito_idDeposito and
			ordencomprarecibido.Persona_idPersona = persona.idPersona and 
			ordencomprarecibido.TerminoPago_idTerminoPago = terminopago.idTerminoPago  and ordencomprarecibido.recibido = 1";
		return ejecutarConsulta($sql);		
	}






	//Implementar un método para listar los registros
	public function listarRecibidos()
	{
		$sql="SELECT 
			nroCompra, 
			recibido,
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
			sucursal.nombre as ds
		from 
			ordencomprarecibido, terminopago, persona, deposito, sucursal 
		where 
			sucursal.idSucursal = deposito.Sucursal_idSucursal and
			deposito.idDeposito = ordencomprarecibido.Deposito_idDeposito and
			ordencomprarecibido.Persona_idPersona = persona.idPersona and 
			ordencomprarecibido.TerminoPago_idTerminoPago = terminopago.idTerminoPago and recibido in (1,2)";
		return ejecutarConsulta($sql);		
	}





	//recibido
		public function confirmarRecepcionRecibido($idOrdenCompra, $nroFacturaCompra, $Moneda_idMoneda, $tasaCambio, $tasaCambioBases)
	{
		$usuario = $_SESSION['login'];

		$sql="UPDATE ordencomprarecibido SET recibido='1',  nroCompra ='$nroFacturaCompra', usuarioModificacion='$usuario', fechaConfirmacion = now() WHERE idOrdenCompraRecibido='$idOrdenCompra'";

		return ejecutarConsulta($sql);
	}


	public function actualizarCantidadRecibidaRecibido($cantidadRecibida, $idDetalleOrdenCompra)
	{
		$usuario = $_SESSION['login'];

		$sql="UPDATE detalleordencomprarecibido SET cantidadRecibida='$cantidadRecibida', usuarioModificacion='$usuario' WHERE idDetalleOrdenCompraRecibido='$idDetalleOrdenCompra'";

		return ejecutarConsulta($sql);


	}


	public function actualizarFaltanteRecibido($faltante, $idDetalleOrdenCompra)
	{
		$usuario = $_SESSION['login'];

		$sql="UPDATE detalleordencomprarecibido SET faltante='$faltante', usuarioModificacion='$usuario' WHERE idDetalleOrdenCompraRecibido='$idDetalleOrdenCompra'";

		return ejecutarConsulta($sql);


	}



	public function actualizarDevueltaRecibido($devuelta, $idDetalleOrdenCompra)
	{
		$usuario = $_SESSION['login'];

		$sql="UPDATE detalleordencompra SET devuelta='$devuelta', usuarioModificacion='$usuario' WHERE idDetalleOrdenCompra='$idDetalleOrdenCompra'";

		return ejecutarConsulta($sql);

	}



	public function actualizarComentarioRecibido($comentario, $idDetalleOrdenCompra)
	{
		$usuario = $_SESSION['login'];

		$sql="UPDATE detalleordencomprarecibido SET comentario='$comentario', usuarioModificacion='$usuario' WHERE idDetalleOrdenCompraRecibido='$idDetalleOrdenCompra'";

		return ejecutarConsulta($sql);

	}





	//Original
	public function confirmarRecepcion($idOrdenCompra, $nroFacturaCompra, $Moneda_idMoneda, $tasaCambio, $tasaCambioBases)
	{
		$usuario = $_SESSION['login'];

		$sql="CALL SP_GenerarOrdenCompraRecibido('$idOrdenCompra', '$nroFacturaCompra', '$Moneda_idMoneda', '$tasaCambio', '$tasaCambioBases', '$usuario');";

		return ejecutarConsulta($sql);
	}


	public function actualizarCantidadRecibida($cantidadRecibida, $idDetalleOrdenCompra)
	{
		$usuario = $_SESSION['login'];

		$sql="UPDATE detalleordencompra SET cantidadRecibida='$cantidadRecibida', usuarioModificacion='$usuario' WHERE idDetalleOrdenCompra='$idDetalleOrdenCompra'";

		return ejecutarConsulta($sql);
	}


	public function actualizarFaltante($faltante, $idDetalleOrdenCompra)
	{
		$usuario = $_SESSION['login'];

		$sql="UPDATE detalleordencompra SET faltante='$faltante', usuarioModificacion='$usuario' WHERE idDetalleOrdenCompra='$idDetalleOrdenCompra'";

		return ejecutarConsulta($sql);


	}



	public function actualizarDevuelta($devuelta, $idDetalleOrdenCompra)
	{
		$usuario = $_SESSION['login'];

		$sql="UPDATE detalleordencompra SET devuelta='$devuelta', usuarioModificacion='$usuario' WHERE idDetalleOrdenCompra='$idDetalleOrdenCompra'";

		return ejecutarConsulta($sql);

	}



	public function actualizarComentario($comentario, $idDetalleOrdenCompra)
	{
		$usuario = $_SESSION['login'];

		$sql="UPDATE detalleordencompra SET comentario='$comentario', usuarioModificacion='$usuario' WHERE idDetalleOrdenCompra='$idDetalleOrdenCompra'";

		return ejecutarConsulta($sql);

	}



	public function autorizarCierre($id)
	{
		$usuario = $_SESSION['login'];

		$sql="UPDATE ordencomprarecibido SET recibido=2, usuarioConfirmacion='$usuario', fechaConfirmacion = now() WHERE idOrdenCompraRecibido='$id'";

		return ejecutarConsulta($sql);
	}

	

	public function listarAFacturar($habilitacion)
	{
		$sql="SELECT persona.idPersona as idPersona, idOrdenVenta, Deposito_idDeposito, Habilitacion_idHabilitacion, fecha, terminopago.descripcion AS tpd, persona.razonSocial as rs, totalImpuesto, subTotal, total, ordenventa.usuarioInsercion as ovui, ordenventa.usuarioModificacion as ovum, ordenventa.inactivo as ovi, ordenventa.facturado
			from ordenventa, terminopago, persona 
			where ordenventa.Persona_idPersona = persona.idPersona and ordenventa.TerminoPago_idTerminoPago = terminopago.idTerminoPago";
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




	//DISEÑADO PRINCIPALMENTE PARA 
	public function rpt_notarecepcion_cabecera($id)
	{

		$sql="
			SELECT *, 
				F_NOMBRE_PERSONA(Persona_idPersona) as np, 
				F_NOMBRE_SUCURSAL_X_DEPOSITO(Sucursal_idSucursal) as ns, 
				F_NOMBRE_DEPOSITO(Deposito_idDeposito) as nd, 
				fecha, 
				nroCompra, 
				F_NOMBRE_TERMINO_PAGO( TerminoPago_idTerminoPago ) as ntp, 
				fechaConfirmacion, usuarioConfirmacion  
			from ordencomprarecibido
			where recibido = 1 AND idOrdenCompraRecibido = '$id';
		";


		return ejecutarConsulta($sql);
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function rpt_notarecepcion_detalle($id)
	{

		$sql="
			SELECT idDetalleOrdenCompraRecibido, 
				Articulo_idArticulo ,
				descripcion, 
				precio, 
				descuento, 
				cantidad as cantidadSolicitada, 
				cantidadRecibida, faltante as cantidadFaltante,
				devuelta,
				comentario
			FROM detalleordencomprarecibido
			where OrdenCompraRecibido_idOrdenCompraRecibido = '$id';
		";


		return ejecutarConsulta($sql);
	}







}
?>