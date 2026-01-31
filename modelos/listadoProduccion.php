<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
Class InventarioAjuste
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($Cliente_idCliente,$Habilitacion_idHabilitacion,$Deposito_idDeposito,$TerminoPago_idTerminoPago,$tipo_comprobante,$nroFactura,$fechaFactura,$fechaVencimiento,$timbrado,$vtoTimbrado,$totalImpuesto,$total,$totalNeto,$usuarioInsercion,$serie,$cuotas,$giftCard,$nroGiftCard,$clienteGiftCard,$Empleado_idEmpleado,$idarticulo,$cantidad,$precioVenta,$impuesto,$importe_detalle,$tipopago,$nroReferencia)
	{
		$usuario = $_SESSION['login'];
		$sql="INSERT INTO `venta`
									(
									`Cliente_idCliente`,
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
									`total`,
									`totalNeto`,
									`usuarioInsercion`,
									`inactivo`,
									`serie`,
									`cuotas`,
									`giftCard`,
									`nroGiftCard`,
									`clienteGiftCard`,`vendedor`)
									VALUES
									(
									'$Cliente_idCliente',
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
									'$serie',
									'$cuotas',
									'$giftCard',
									'$nroGiftCard',
									'$clienteGiftCard','$Empleado_idEmpleado')";

		//return ejecutarConsulta($sql);


		$idventanew=ejecutarConsulta_retornarID($sql);

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($idarticulo))
		{
			$totalv = $cantidad[$num_elementos] * $precioVenta[$num_elementos];
			$netov = ( $totalv * $impuesto[$num_elementos] ) / 100;
			$sql_detalle = "INSERT INTO `detalleventa`
							(
							`Venta_idVenta`,
							`Articulo_idArticulo`,
							`cantidad`,
							`precio`,
							`impuesto`,
							`totalNeto`,
							`total`,
							`inactivo`)
							VALUES
							(
							'$idventanew',
							'$idarticulo[$num_elementos]',
							'$cantidad[$num_elementos]',
							'$precioVenta[$num_elementos]',
							'$impuesto[$num_elementos]',
							'$netov',
							'$totalv',
							0	
							)";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}


		//Cuando es pago al contado el cobro se aplica automaticamente 
		if ($sw==true and $TerminoPago_idTerminoPago == 0) {
			$sql_pago_detalle = "INSERT INTO `recibo`(`CLIENTE_IDCLIENTE`, `USUARIO`, `HABILITACION_IDHABILITACION`, `NRORECIBO`, `FECHATRANSACCION`, `FECHARECIBO`, `TOTAL`, `USUARIOINSERCION`, `INACTIVO`)

			VALUES ('$Cliente_idCliente', '$usuario', '$Habilitacion_idHabilitacion', 0, now(), '$fechaFactura', '$total', '$usuario', 0)";
			$idrecibo = ejecutarConsulta_retornarID($sql_pago_detalle) or $sw = false;
		}


		if ($sw==true and $TerminoPago_idTerminoPago == 0) {

			$sql_pago_detalle_factura = "INSERT INTO `detallerecibofacturas`(`RECIBO_IDRECIBO`, `VENTA_IDVENTA`, `MONTOAPLICADO`, `INACTIVO`) 

			VALUES ('$idrecibo', '$idventanew', '$total', 0)";
			ejecutarConsulta($sql_pago_detalle_factura) or $sw = false;
		}
		$contador = 0;
		if ($sw==true and $TerminoPago_idTerminoPago == 0) {
			while ($contador < count($importe_detalle)) {
				$sql_detalle_factura_pago = "INSERT INTO `detallerecibo`( `RECIBO_IDRECIBO`, `FORMAPAGO_IDFORMAPAGO`, `BANCO_IDBANCO`, `NROCHEQUE`, `MONTO`, `INACTIVO`) 
				VALUES ('$idrecibo','$tipopago[$contador]', 1, '$nroReferencia[$contador]', '$importe_detalle[$contador]',0)";
				ejecutarConsulta($sql_detalle_factura_pago) or $sw = false;
				$contador++;
			}
		}

		//Se hace el cobro total o parcial si el termino de pago es a credito y SI la cuota es IGUAL a 1. Si la cuota es mayor a 1 no se aplica ningun cobro automatico, se debe ir al modulo de recibos.
		$sumador=0;
		$monto_a_aplicar=0;
		if ($sw==true and $TerminoPago_idTerminoPago == 2 and $cuotas == 1) {
			while ($sumador < count($importe_detalle)) {
				$monto_a_aplicar = $monto_a_aplicar + $importe_detalle[$sumador];
				$sumador++;
			}
		}

		if ($sw==true and $TerminoPago_idTerminoPago == 2 and $cuotas == 1) {
			$sql_pago_detalle = "INSERT INTO `recibo`(`CLIENTE_IDCLIENTE`, `USUARIO`, `HABILITACION_IDHABILITACION`, `NRORECIBO`, `FECHATRANSACCION`, `FECHARECIBO`, `TOTAL`, `USUARIOINSERCION`, `INACTIVO`)

			VALUES ('$Cliente_idCliente', '$usuario', '$Habilitacion_idHabilitacion', 0, now(), '$fechaFactura', '$monto_a_aplicar', '$usuario', 0)";



			$idrecibo = ejecutarConsulta_retornarID($sql_pago_detalle) or $sw = false;
		}


		if ($sw==true and $TerminoPago_idTerminoPago == 2 and $cuotas == 1) {

			$sql_pago_detalle_factura = "INSERT INTO `detallerecibofacturas`(`RECIBO_IDRECIBO`, `VENTA_IDVENTA`, `MONTOAPLICADO`, `INACTIVO`, `CUOTA`) 

			VALUES ('$idrecibo', '$idventanew', '$monto_a_aplicar', 0, 1)";
			ejecutarConsulta($sql_pago_detalle_factura) or $sw = false;
		}
		$contador = 0;
		if ($sw==true and $TerminoPago_idTerminoPago == 2 and $cuotas == 1) {
			while ($contador < count($importe_detalle)) {
				$sql_detalle_factura_pago = "INSERT INTO `detallerecibo`( `RECIBO_IDRECIBO`, `FORMAPAGO_IDFORMAPAGO`, `BANCO_IDBANCO`, `NROCHEQUE`, `MONTO`, `INACTIVO`) 
				VALUES ('$idrecibo','$tipopago[$contador]', 1, '$nroReferencia[$contador]', '$importe_detalle[$contador]',0)";
				ejecutarConsulta($sql_detalle_factura_pago) or $sw = false;
				$contador++;
			}
		}


		return $sw;
	}

	public function generarCierreCosto($CentroCosto_idCentroCosto)
	{
		$usuario = $_SESSION['login'];

		$sql="CALL SP_GenerarCierreCosto( '$CentroCosto_idCentroCosto', '$usuario' )";
		return ejecutarConsulta($sql);


	}	

	//Implementamos un método para anular la venta
	public function autorizarInventario($idAjusteStock,$User)
	{
		$sql="UPDATE ajusteStock SET estado=1, usuarioAprobacion='$User' WHERE idAjusteStock='$idAjusteStock' ";
		return ejecutarConsulta($sql);  
	}	

	//Implementar un método para listar los registros
	public function listarAutorizacion()
	{
		$sql="SELECT *, a.Deposito_idDeposito as cn , ifnull(b.descripcion,'TODOS') as nombreDeposito, a.inactivo as ci 
			  from ajusteStock  a left outer join  deposito b on a.Deposito_idDeposito = b.idDeposito
			  where    a.inactivo = 0 and a.estado = 0";
		return ejecutarConsulta($sql);		
	}

	public function generarPedido($Deposito_idDeposito, $Categoria_idCategoria,$Proveedor_idProveedor,$Marca_idMarca,$Estado_idEstado)
	{
		$usuario = $_SESSION['login'];

		$sql="CALL SP_AjusteInventario('$Deposito_idDeposito', '$usuario', '$Categoria_idCategoria', '$Proveedor_idProveedor','$Marca_idMarca','$Estado_idEstado')";
		return ejecutarConsulta($sql);
	}	


	public function generarPedidoArticulo($idInventarioAjuste, $Articulo_idArticulo, $Sucursal_idSucursal)
	{
		$usuario = $_SESSION['login'];

		$sql="CALL SP_InsertarArticuloInventarioAjuste('$idInventarioAjuste', '$Articulo_idArticulo', '$Sucursal_idSucursal')";
		return ejecutarConsulta($sql);
	}


	public function generarPedidoArticuloD2($idOrdenCompra, $Articulo_idArticulo)
	{
		$usuario = $_SESSION['login'];

		$sql="CALL SP_InsertarArticuloOC('$idOrdenCompra', '$Articulo_idArticulo')";
		return ejecutarConsulta($sql);
	}


	public function generarOC($idInventarioAjuste)
	{
		$usuario = $_SESSION['login'];

		$sql="CALL SP_GenerarOC('$idInventarioAjuste')";
		return ejecutarConsulta($sql);
	}	


	public function actualizarCantidadCaja($cantidadCaja, $idArticulo,$Deposito_idDeposito)
	{
		//$usuario = $_SESSION['login'];

		$sql="UPDATE ajustestockdetalle SET cantidadReal='$cantidadCaja', fechaModificacion=now(), diferencia = cantidad - cantidadReal WHERE Articulo_idArticulo='$idArticulo' and Deposito_idDeposito='$Deposito_idDeposito'";

		return ejecutarConsulta($sql);


	}


	public function actualizarNombreProducto($nombre, $Articulo_idArticulo)
	{
		$usuario = $_SESSION['login'];

		$sql="UPDATE articulo SET nombre='$nombre', usuarioModificacion='$usuario' WHERE idArticulo='$Articulo_idArticulo'";

		return ejecutarConsulta($sql);


	}


	public function actualizarPedido($cantidad, $idInventarioAjusteDetalle)
	{
		$usuario = $_SESSION['login'];

		$sql="UPDATE ajustestockdetalle SET pedidos='$cantidad', usuarioModificacion='$usuario' WHERE idInventarioAjusteDetalle='$idInventarioAjusteDetalle'";

		return ejecutarConsulta($sql);


	}


	public function actualizarMargen($idArticulo, $idSucursal, $margen)
	{
		$usuario = $_SESSION['login'];
		$sql="UPDATE precio SET margen='$margen', usuarioMod='$usuario' WHERE Articulo_idArticulo = '$idArticulo' and Sucursal_idSucursal = '$idSucursal'";

		return ejecutarConsulta($sql);


	}




	public function actualizarCompraAsignada($idCompra, $id)
	{
		$usuario = $_SESSION['login'];

		$sql="UPDATE cierreCostoDetalle SET Compra_idCompraAsignada='$idCompra', usuarioModificacion='$usuario' WHERE idcierrecostodetalle='$id'";

		return ejecutarConsulta($sql);


	}


	public function actualizarComentario($comentario, $id)
	{
		$usuario = $_SESSION['login'];

		$sql="UPDATE cierreCostoDetalle SET comentario='$comentario', usuarioModificacion='$usuario' WHERE idcierrecostodetalle='$id'";

		return ejecutarConsulta($sql);
	}



	public function actualizarRadio($x, $id)
	{
		$usuario = $_SESSION['login'];

		$sql="UPDATE cierreCostoDetalle SET tipoCompra='$x', usuarioModificacion='$usuario' WHERE idcierrecostodetalle='$id'";

		return ejecutarConsulta($sql);
	}



	public function descontinuar($check, $idArticulo)
	{
		$usuario = $_SESSION['login'];


		// if ($check == true) {
		// 	$check = 1;
		// }else{
		// 	$check = 0;
		// }

		$sql="UPDATE articulo SET descontinuado='$check', usuarioModificacion='$usuario' WHERE idArticulo='$idArticulo'";

		return ejecutarConsulta($sql);


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



	public function mostrarDetalleProveedor($idArticulo,$idSucursal)
	{
		$sql="CALL SP_ListarVentas('$idArticulo', '$idSucursal')";
		return ejecutarConsulta($sql);
	}


	public function mostrarDetalleProrrateo($id)
	{
		$sql="CALL ProrrateoPorCentroCosto('$id')";
		return ejecutarConsulta($sql);
	}


	public function mostrarDetalle2($idArticulo)
	{
		$sql="select * from preciohistorico where Articulo_idArticulo = '$idArticulo' order by idPrecioHistorico desc";
		return ejecutarConsulta($sql);
	}

	public function mostrarDetalle3($idArticulo)
	{
		$sql="SELECT 0 as devolucion, F_NOMBRE_SUCURSAL_X_DEPOSITO( c.Deposito_idDeposito ) AS ns,  c.fechaFactura, c.fechaTransaccion, c.nroFactura, dc.cantidad, dc.precio, dc.costo, dc.descuento, c.Deposito_idDeposito, cantidad*precio as subtotal
			FROM detallecompra dc JOIN compra c on c.idCompra = dc.Compra_idCompra
			WHERE Articulo_idArticulo = '$idArticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros
	public function listar($Deposito_idDeposito, $fi, $ff, $estado, $Categoria_idCategoria)
	{
 
		$sql="CALL SP_ListadoProduccion('$estado','$Deposito_idDeposito','$Categoria_idCategoria','$fi','$ff')";
	 	return ejecutarConsulta($sql);		
 	}


	//Implementar un método para listar los registros
	public function listarCierreCosto($CentroCosto_idCentroCosto)
	{
		$sql="select cierreCosto.*, centrocosto.descripcion ncc from cierreCosto, centrocosto where centrocosto.idCentroCosto = CentroCosto_idCentroCosto and CentroCosto_idCentroCosto = '$CentroCosto_idCentroCosto';";
		return ejecutarConsulta($sql);		
	}


	//Implementar un método para listar los registros
	public function mostrarDetalle($idInventarioAjuste)
	{

		 
			$sql="CALL SP_ListarInventarioAjusteDetalle('$idInventarioAjuste')";
		 
		return ejecutarConsulta($sql);		
	}


	//Implementar un método para listar los registros
	public function mostrarDetalleCierreCosto($id)
	{

			$sql="SELECT cierreCostoDetalle.*, F_NOMBRE_PERSONA( Persona_idPersona ) AS np, nroFactura, total, fechaFactura from cierreCostoDetalle, compra where cierreCostoDetalle.Compra_idCompra = idCompra and CierreCosto_idCierreCosto = '$id' order by idCompra asc;";

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

}
?>