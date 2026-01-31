<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
Class Venta
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}


	//Implementamos un método para insertar registros
	public function insertar($Direccion_idDireccion, $entrega, $Moneda_idMoneda, $tasaCambio, $tasaCambioBases,$Cliente_idCliente,$Habilitacion_idHabilitacion,$Deposito_idDeposito,$TerminoPago_idTerminoPago,$tipo_comprobante,$nroFactura,$fechaFactura,$fechaVencimiento,$timbrado,$vtoTimbrado,$totalImpuesto,$total,$totalNeto,$usuarioInsercion,$serie,$cuotas,$giftCard,$nroGiftCard,$clienteGiftCard,$Empleado_idEmpleado,$OrdenVenta_idOrdenVenta,$idarticulo,$descripcion,$cantidad,$cantidadStock,$precioVenta,$impuesto,$idImpuesto,$importe_detalle,$tipopagodetalle,$nroReferencia,$capital, $interes, $descuento,$banco,$importe_detalle_pagado,$moneda,$tasa,$remision)
	{
		$usuario = $_SESSION['login'];

		if ($Cliente_idCliente > 0) {
			

		$sql="INSERT INTO `venta`
									(
									`entrega`,
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
									`clienteGiftCard`,
									`vendedor`,
									`OrdenVenta_idOrdenVenta`,
									`Moneda_idMoneda`,
									`tasaCambio`,
									`tasaCambioBases`,
									`remision`,
									`Direccion_idDireccion`
									)
									VALUES
									(
									'$entrega',
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
									'$clienteGiftCard',
									'$Empleado_idEmpleado',
									'$OrdenVenta_idOrdenVenta',
									'$Moneda_idMoneda',
									'$tasaCambio',
									'$tasaCambioBases',
									'$remision',
									'$Direccion_idDireccion'
								)";

		//return ejecutarConsulta($sql);


	    $idventanew=ejecutarConsulta_retornarID($sql);

		$num_elementos=0;
		$sw=true;
		$ultimo = count($idarticulo) - 1;
		
		$total_capital = 0;
		$total_interes = 0;
		while ($num_elementos < count($idarticulo))
		{
			$totalv = $cantidad[$num_elementos] * $precioVenta[$num_elementos];
			$netov = ( $totalv * $impuesto[$num_elementos] ) / 100;
			
			// multiplica cantidad * capital e interes para insertar en el detalle
			//$l_capital = $cantidad[$num_elementos] * ( $capital[$num_elementos] - $descuento[$num_elementos] );
			//$l_interes = $cantidad[$num_elementos] * ( $interes[$num_elementos] - $descuento[$num_elementos] );

			//totaliza para posteriormente insertar en la cabecera.
			//$total_capital =+ $l_capital;
			//$total_interes =+ $l_interes;

			//se verifica si es el ultimo elemento


			//calculo de nuevo interes
			//   tl = l_interes -> precio con interes
			
			//JUNIOR$preciocinteres = $precioVenta[$num_elementos] - ( ( $descuento[$num_elementos] * $precioVenta[$num_elementos] ) / 100 );
			$preciocinteres = 0;//$precioVenta[$num_elementos] - ((( $descuento[$num_elementos]/ 100) * $precioVenta[$num_elementos] ));
			//	 tl2 = l_capital -> precio sin interes
			//JUNIOR$preciosinteres = ( $precioVenta[$num_elementos] - $interes[$num_elementos] ) - ( ( $descuento[$num_elementos] * ( $precioVenta[$num_elementos] - $interes[$num_elementos] )  ) / 100 );
			
			$auxpreciosininteres = 0;//$precioVenta[$num_elementos] - $interes[$num_elementos] ;
			$preciosinteres = 0;//$auxpreciosininteres - (($descuento[$num_elementos]/ 100) * $auxpreciosininteres ) ;
			//	 tl -tl2 = interes
			$l_interes = 0;//($preciocinteres - $preciosinteres)* $cantidad[$num_elementos];
			$l_capital = 0;//$preciosinteres  * $cantidad[$num_elementos];


			//totaliza para posteriormente insertar en la cabecera.
			$total_capital = $total_capital + $l_capital;
			$total_interes = $total_interes + $l_interes;

			if ($num_elementos == $ultimo) {
				


			$sql_detalle = "INSERT INTO `detalleventa`
							(
							`Venta_idVenta`,
							`Articulo_idArticulo`,
							`cantidad`,
							`cantidadRemision`,
							`cantidadStock`,
							`precio`,
							`impuesto`,
							`descuento`,
							`totalNeto`,
							`total`,
							`inactivo`,	
							`TipoImpuesto_idTipoImpuesto`,
							`descripcion`,
							`ultimo`,
							`capital`,
							`interes`
							)
							VALUES
							(
							'$idventanew',
							'$idarticulo[$num_elementos]',
							'$cantidad[$num_elementos]',
							'$cantidad[$num_elementos]',
							'$cantidadStock[$num_elementos]',
							'$precioVenta[$num_elementos]',
							'$impuesto[$num_elementos]',
							'$descuento[$num_elementos]',
							'$netov',
							'$totalv',
							0,	
							'$idImpuesto[$num_elementos]',
							'$descripcion[$num_elementos]',
							'1',
							'$l_capital',
							'$l_interes'
							)";


			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;

			}else{



			$sql_detalle = "INSERT INTO `detalleventa`
							(
							`Venta_idVenta`,
							`Articulo_idArticulo`,
							`cantidad`,
							`cantidadRemision`,
							`cantidadStock`,
							`precio`,
							`impuesto`,
							`descuento`,
							`totalNeto`,
							`total`,
							`inactivo`,	
							`TipoImpuesto_idTipoImpuesto`,
							`descripcion`,
							`ultimo`,
							`capital`,
							`interes`
							)
							VALUES
							(
							'$idventanew',
							'$idarticulo[$num_elementos]',
							'$cantidad[$num_elementos]',
							'$cantidad[$num_elementos]',
							'$cantidadStock[$num_elementos]',
							'$precioVenta[$num_elementos]',
							'$impuesto[$num_elementos]',
							'$descuento[$num_elementos]',
							'$netov',
							'$totalv',
							0,	
							'$idImpuesto[$num_elementos]',
							'$descripcion[$num_elementos]',
							'0',
							'$l_capital',
							'$l_interes'
							)";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;

			}

		}

		//actualizar cabecera
		/*
		if ($sw == true) {

			$sql_update_cabecera = "UPDATE venta SET totalCapital = '$total_capital', totalInteres = '$total_interes' WHERE idVenta = '$idventanew' ";
			ejecutarConsulta($sql_update_cabecera) or $sw = false;
			
		}
		*/


		//Cuando es pago al contado el cobro se aplica automaticamente 
		// if ($sw==true and $TerminoPago_idTerminoPago == 1) {
		// 	$sql_pago_detalle = "INSERT INTO `recibo`(`CLIENTE_IDCLIENTE`, `USUARIO`, `HABILITACION_IDHABILITACION`, `NRORECIBO`, `FECHATRANSACCION`, `FECHARECIBO`, `TOTAL`, `USUARIOINSERCION`, `INACTIVO`)

		// 	VALUES ('$Cliente_idCliente', '$usuario', '$Habilitacion_idHabilitacion', 0, now(), '$fechaFactura', '$total', '$usuario', 0)";
		// 	$idrecibo = ejecutarConsulta_retornarID($sql_pago_detalle) or $sw = false;
		// }


		// if ($sw==true and $TerminoPago_idTerminoPago == 1) {

		// 	$sql_pago_detalle_factura = "INSERT INTO `detallerecibofacturas`(`RECIBO_IDRECIBO`, `VENTA_IDVENTA`, `MONTOAPLICADO`, `CUOTA`, `INACTIVO`) 

		// 	VALUES ('$idrecibo', '$idventanew', '$total',1 , 0)";
		// 	ejecutarConsulta($sql_pago_detalle_factura) or $sw = false;
		// }
		// $contador = 0;
		// if ($sw==true and $TerminoPago_idTerminoPago == 1) {
		// $ultimo = count($tipopagodetalle) - 1;
			
		// 	while ($contador < count($tipopagodetalle)) {

		// 		$importeGs= $importe_detalle_pagado[$contador] * $tasa[$contador]; 
		// 		if ($contador == $ultimo) {

		// 		$sql_detalle_factura_pago = "INSERT INTO `detallerecibo`( `RECIBO_IDRECIBO`, `FORMAPAGO_IDFORMAPAGO`, `BANCO_IDBANCO`, `NROCHEQUE`, `MONTO`, `INACTIVO`, `ultimo`,`Moneda_idMoneda`,`tasaCambio`) 
		// 		VALUES ('$idrecibo','$tipopagodetalle[$contador]', '$banco[$contador]', '$nroReferencia[$contador]', 
		// 			'$importeGs',0,1,'$moneda[$contador]','$tasa[$contador]')";
		// 		ejecutarConsulta($sql_detalle_factura_pago) or $sw = false;
		// 		$contador++;

		// 		}else{

		// 		$sql_detalle_factura_pago = "INSERT INTO `detallerecibo`( `RECIBO_IDRECIBO`, `FORMAPAGO_IDFORMAPAGO`, `BANCO_IDBANCO`, `NROCHEQUE`, `MONTO`, `INACTIVO`, `ultimo`,`Moneda_idMoneda`,`tasaCambio`) 
		// 		VALUES ('$idrecibo','$tipopagodetalle[$contador]', 1, '$nroReferencia[$contador]', 
		// 			'$importeGs',0,0,'$moneda[$contador]','$tasa[$contador]')";
		// 		ejecutarConsulta($sql_detalle_factura_pago) or $sw = false;
		// 		$contador++;

		// 		}

		// 	}
		// }

		//Se hace el cobro total o parcial si el termino de pago es a credito y SI la cuota es IGUAL a 1. Si la cuota es mayor a 1 no se aplica ningun cobro automatico, se debe ir al modulo de recibos.
		
		
		
		
		$sumador=0;
		$monto_a_aplicar=0;
		if ($sw==true and $TerminoPago_idTerminoPago == 12) {
			while ($sumador < count($importe_detalle)) {
				$monto_a_aplicar = $monto_a_aplicar + $importe_detalle[$sumador];
				$sumador++;
			}
		}

		if ($sw==true and $TerminoPago_idTerminoPago == 12) {
			$sql_pago_detalle = "INSERT INTO `recibo`(`CLIENTE_IDCLIENTE`, `USUARIO`, `HABILITACION_IDHABILITACION`, `NRORECIBO`, `FECHATRANSACCION`, `FECHARECIBO`, `TOTAL`, `USUARIOINSERCION`, `INACTIVO`, `MONEDA_IDMONEDA`, `TASACAMBIO`, `TASACAMBIOBASES`)

			VALUES ('$Cliente_idCliente', '$usuario', '$Habilitacion_idHabilitacion', 0, now(), '$fechaFactura', '$monto_a_aplicar', '$usuario', 0,'$Moneda_idMoneda','$tasaCambio','$tasaCambioBases')";

			$idrecibo = ejecutarConsulta_retornarID($sql_pago_detalle) or $sw = false;
		}


		if ($sw==true and $TerminoPago_idTerminoPago == 12 ) {

			$sql_pago_detalle_factura = "INSERT INTO `detallerecibofacturas`(`RECIBO_IDRECIBO`, `VENTA_IDVENTA`, `MONTOAPLICADO`, `INACTIVO`, `CUOTA`) 

			VALUES ('$idrecibo', '$idventanew', '$monto_a_aplicar', 0, 1)";
			ejecutarConsulta($sql_pago_detalle_factura) or $sw = false;
		}
		$contador = 0;
		if ($sw==true and $TerminoPago_idTerminoPago == 12) {
			while ($contador < count($importe_detalle)) {
				$sql_detalle_factura_pago = "INSERT INTO `detallerecibo`( `RECIBO_IDRECIBO`, `FORMAPAGO_IDFORMAPAGO`, `BANCO_IDBANCO`, `NROCHEQUE`, `MONTO`, `INACTIVO`, `Moneda_idMoneda`) 
				VALUES ('$idrecibo','$tipopagodetalle[$contador]', 1, '$nroReferencia[$contador]', '$importe_detalle[$contador]',0, '$Moneda_idMoneda')";
				ejecutarConsulta($sql_detalle_factura_pago) or $sw = false;
				$contador++;
			}
		}
		
		
		
		
		
		
		
		
		$sumador=0;
		$monto_a_aplicar=0;
		if ($sw==true and $TerminoPago_idTerminoPago == 1) {
			while ($sumador < count($importe_detalle)) {
				$monto_a_aplicar = $monto_a_aplicar + $importe_detalle[$sumador];
				$sumador++;
			}
		}

		if ($sw==true and $TerminoPago_idTerminoPago == 1) {
			$sql_pago_detalle = "INSERT INTO `recibo`(`CLIENTE_IDCLIENTE`, `USUARIO`, `HABILITACION_IDHABILITACION`, `NRORECIBO`, `FECHATRANSACCION`, `FECHARECIBO`, `TOTAL`, `USUARIOINSERCION`, `INACTIVO`, `MONEDA_IDMONEDA`, `TASACAMBIO`, `TASACAMBIOBASES`)

			VALUES ('$Cliente_idCliente', '$usuario', '$Habilitacion_idHabilitacion', 0, now(), '$fechaFactura', '$monto_a_aplicar', '$usuario', 0,'$Moneda_idMoneda','$tasaCambio','$tasaCambioBases')";

			$idrecibo = ejecutarConsulta_retornarID($sql_pago_detalle) or $sw = false;
		}


		if ($sw==true and $TerminoPago_idTerminoPago == 1 ) {

			$sql_pago_detalle_factura = "INSERT INTO `detallerecibofacturas`(`RECIBO_IDRECIBO`, `VENTA_IDVENTA`, `MONTOAPLICADO`, `INACTIVO`, `CUOTA`) 

			VALUES ('$idrecibo', '$idventanew', '$monto_a_aplicar', 0, 0)";
			ejecutarConsulta($sql_pago_detalle_factura) or $sw = false;
		}
		$contador = 0;
		if ($sw==true and $TerminoPago_idTerminoPago == 1) {
			while ($contador < count($importe_detalle)) {
				$sql_detalle_factura_pago = "INSERT INTO `detallerecibo`( `RECIBO_IDRECIBO`, `FORMAPAGO_IDFORMAPAGO`, `BANCO_IDBANCO`, `NROCHEQUE`, `MONTO`, `INACTIVO`, `Moneda_idMoneda`) 
				VALUES ('$idrecibo','$tipopagodetalle[$contador]', 1, '$nroReferencia[$contador]', '$importe_detalle[$contador]',0, '$Moneda_idMoneda')";
				ejecutarConsulta($sql_detalle_factura_pago) or $sw = false;
				$contador++;
			}
		}

	}


		return $idventanew;;
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



	
	//Implementamos un método para anular la venta
	public function anularOV($idVenta)
	{
		$sw=true;
		$sql="UPDATE ordenventa SET inactivo='1' WHERE idOrdenVenta='$idVenta'";
		ejecutarConsulta($sql) or $sw = false;

		/*if ($sw==true) {
			$sql2="UPDATE detallerecibofacturas SET inactivo='1' WHERE VENTA_IDVENTA ='$idVenta'";
			ejecutarConsulta($sql2) or $sw = false;
		}*/

		return $sw;

	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idventa)
	{
		$sql="SELECT v.idventa,DATE(v.fecha_hora) as fecha,v.idcliente,p.nombre as cliente,u.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
		return ejecutarConsultaSimpleFila($sql);
	}


	public function listarDetalleOrdenVenta($id)
	{
		$sql="select *, F_NOMBRE_ARTICULO( Articulo_idArticulo ) as na from detalleordenventa where detalleordenventa.OrdenVenta_idOrdenVenta = '$id'" ;
		return ejecutarConsulta($sql);
	}

	public function listarDetalle($idventa)
	{
		$sql="SELECT dv.idventa,dv.idarticulo,a.nombre,dv.cantidad,dv.precio_venta,dv.descuento,(dv.cantidad*dv.precio_venta-dv.descuento) as subtotal FROM detalle_venta dv inner join articulo a on dv.idarticulo=a.idarticulo where dv.idventa='$idventa'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros
	public function listar($habilitacion)
	{
		$sql="SELECT *, tipodocumento.descripcion as dd ,venta.Inactivo as vi, persona.razonSocial as cn, venta.Habilitacion_idHabilitacion as vh 
		from venta, persona,tipodocumento where venta.tipo_comprobante = tipodocumento.idTipoDocumento and venta.Cliente_idCliente = persona.idPersona and venta.Habilitacion_idHabilitacion  = '$habilitacion' order by venta.idVenta";
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


	public function ventacabeceraWebNC($id){
		//$sql="SELECT v.idventa,v.idcliente,p.nombre as cliente,p.direccion,p.tipo_documento,p.num_documento,p.email,p.telefono,v.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,date(v.fecha_hora) as fecha,v.impuesto,v.total_venta FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
		
		$sql="SELECT *,persona.razonSocial as nombreCliente, persona.nroDocumento as ruc, persona.direccion as cd,  '80028600-6' as fe, (total*-1) as total from notacreditoventa, persona WHERE  persona.idPersona = notacreditoventa.Persona_idPersona and idNotaCreditoVenta  = '$id'";

		return ejecutarConsulta($sql);
	}


	public function rpt_movimiento($id){
		//$sql="SELECT v.idventa,v.idcliente,p.nombre as cliente,p.direccion,p.tipo_documento,p.num_documento,p.email,p.telefono,v.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,date(v.fecha_hora) as fecha,v.impuesto,v.total_venta FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
		
		$sql="SELECT tipo , razonSocial, nroDocumento, date(fechaApertura) as fecha, monto, concepto.descripcion,  month(fechaApertura) mes, year(fechaApertura) anho
from movimiento, persona, habilitacion, concepto
where movimiento.concepto = concepto.idConcepto and Empleado_idEmpleado = idPersona and idhabilitacion = habilitacion and idMovimiento = '$id'";

		return ejecutarConsulta($sql);
	}



	public function ventacabeceraWeb($idVenta){
		//$sql="SELECT v.idventa,v.idcliente,p.nombre as cliente,p.direccion,p.tipo_documento,p.num_documento,p.email,p.telefono,v.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,date(v.fecha_hora) as fecha,v.impuesto,v.total_venta FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
		
		$sql="SELECT *,persona.razonSocial as nombreCliente, persona.nroDocumento as ruc, persona.direccion as cd,  '80028600-6' as fe, entrega, totalNeto, descripcion as condicion, direccionVenta('$idVenta') as dir
from venta, persona, terminopago
WHERE  persona.idPersona = venta.Cliente_idCliente and idTerminoPago = TerminoPago_idTerminoPago and idVenta  = '$idVenta'";

		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function cabeceraWeb($venta)
	{

		$sql="SELECT
			sucursal.ciudad as ciudad,
			sucursal.direccion,
			sucursal.correo,
			sucursal.telefono,
			sucursal.nombre,
			documentocajero.timbrado as timbrado,
			documentocajero.nroAutorizacion as nroAutorizacion,
			documentocajero.fechaEntrega as vencimiento,
			venta.nroFactura,
			venta.serie,
			venta.fechaFactura
			FROM venta,habilitacion, caja,sucursal, deposito, documentocajero
			where
            venta.Habilitacion_idHabilitacion = habilitacion.idHabilitacion
            and
		    venta.idVenta = '$venta' and 
			caja.idcaja = habilitacion.Caja_idCaja and 
			caja.Sucursal_idSucursal = sucursal.idsucursal and deposito.Sucursal_idSucursal = sucursal.idSucursal and documentocajero.Usuario_idUsuario = habilitacion.Usuario_idUsuario limit 1;";


		return ejecutarConsulta($sql);
	}

            


	public function detalleventahabilitacion($habilitacion){
		//$sql="SELECT v.idventa,v.idcliente,p.nombre as cliente,p.direccion,p.tipo_documento,p.num_documento,p.email,p.telefono,v.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,date(v.fecha_hora) as fecha,v.impuesto,v.total_venta FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
		
		$sql="select venta.idVenta, venta.saldo, F_NOMBRE_CLIENTE(venta.Cliente_idCliente) as nc, F_NOMBRE_ARTICULO( detalleventa.Articulo_idArticulo ) as descripcion, detalleventa.precio as precio, detalleventa.cantidad as cantidad, (detalleventa.precio * detalleventa.cantidad) as totalItem, venta.total as totalVenta from detalleventa, venta where venta.idVenta = detalleventa.Venta_idVenta and venta.Habilitacion_idHabilitacion ='$habilitacion';
		";

		return ejecutarConsulta($sql);
	}


	public function ventadetalle($idVenta){

		$sql="SELECT *, articulo.nombre as descripcionarticulo  FROM detalleventa, articulo WHERE detalleventa.Articulo_idArticulo = articulo.idarticulo and Venta_idVenta='$idVenta'";
		return ejecutarConsulta($sql);
	}


	public function ventadetalleNC($id){

		// NOTA: `notacreditoventadetalle` no guarda el % IVA en muchas instalaciones.
		// Tomamos el porcentaje desde `articulo.TipoImpuesto_idTipoImpuesto -> tipoimpuesto.porcentajeImpuesto`
		// para poder desglosar correctamente IVA 5% / 10% / Exentas en el reporte.
		$sql="
			SELECT
				notacreditoventadetalle.*,
				articulo.nombre as descripcionarticulo,
				tipoimpuesto.porcentajeImpuesto as impuesto,
				(cantidad * -1) as cantidad,
				(total * -1) as total,
				(totalNeto * -1) as totalNeto
			FROM notacreditoventadetalle
			JOIN articulo ON notacreditoventadetalle.Articulo_idArticulo = articulo.idarticulo
			LEFT JOIN tipoimpuesto ON articulo.TipoImpuesto_idTipoImpuesto = tipoimpuesto.idTipoImpuesto
			WHERE NotaCreditoVenta_idNotaCreditoventa='$id'";
		return ejecutarConsulta($sql);
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function habilitacion($tipodocumento)
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
			habilitacion.usuario_ins as usuario_ins,
                documentocajero.Documento_idTipoDocumento


				FROM habilitacion, caja,sucursal, deposito, documentocajero
				where
				 habilitacion.Usuario_idUsuario = '$user' and 
				 caja.idcaja = habilitacion.Caja_idCaja and 
				 caja.Sucursal_idSucursal = sucursal.idsucursal and 
				 habilitacion.estado = 1 and deposito.Sucursal_idSucursal = sucursal.idSucursal and documentocajero.Usuario_idUsuario = habilitacion.Usuario_idUsuario and Documento_idTipoDocumento = '$tipodocumento'";


		return ejecutarConsultaSimpleFila($sql);
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function habilitacion2()
	{
		$user = $_SESSION['idusuario'];

		$sql="SELECT
				habilitacion.estado, 
				habilitacion.Usuario_idUsuario, 
				idhabilitacion, 
				deposito.idDeposito as dp, 
				date(fechaApertura) as fecha, 
				deposito.descripcion as deposito, 
				sucursal.nombre as sucursal,
				habilitacion.usuario_ins as usuario_ins

				FROM habilitacion, caja,sucursal, deposito
				where
				 habilitacion.Usuario_idUsuario = '$user' and 
				 caja.idcaja = habilitacion.Caja_idCaja and 
				 caja.Sucursal_idSucursal = sucursal.idsucursal and 
				 habilitacion.estado = 1 and deposito.Sucursal_idSucursal = sucursal.idSucursal";


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




	//Implementar un método para mostrar los datos de un registro a modificar
	public function listarproductosCodigo($idPersona, $terminoPago, $idArticulo)
	{
		$sql="CALL SP_ListarPreciosPorArticuloId('".$idPersona."', null, '".$terminoPago."', '".$idArticulo."', 1, 1)";


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
	public function selectVenta()
	{
		$sql="SELECT *, F_NOMBRE_CLIENTE(Cliente_idCliente) as np from venta where inactivo = 0";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function datosVenta($id)
	{

		$sql="SELECT * FROM venta where idVenta = '$id' ";


		return ejecutarConsultaSimpleFila($sql);
	}


	public function listarDetalleVenta($idVenta)
	{
		$sql="SELECT *, F_NOMBRE_ARTICULO(Articulo_idArticulo) as na from detalleventa where  Venta_idVenta = '$idVenta';";
		return ejecutarConsulta($sql);
	}
	
	public function cantidadHoy($vendedor)
	{
		$sql="select COUNT(*) AS cantidad, SUM(total * tasaCambio) as total from venta where inactivo = 0 and MONTH(fechaTransaccion) = MONTH(curDate()) AND vendedor = '$vendedor'";
		return ejecutarConsulta($sql);
	}
	
	public function cantidadHoyA()
	{
		$sql="select COUNT(*) AS cantidad, SUM(total * tasaCambio) as total from venta where inactivo = 0 and MONTH(fechaTransaccion) = MONTH(curDate())";
		return ejecutarConsulta($sql);
	}

	public function rptCuentasACobrar($fechai, $fechaf, $orden, $cliente)
	{ 
		$sql="CALL SP_CuentasACobrar('$cliente')";
		return ejecutarConsulta($sql);
	}


	public function rpt_cuentas_a_cobrar($fechai,$fechaf,$cliente,$orden) 
	{
			$sql = "SELECT razonSocial, nroDocumento,fechaFactura, venta.usuario, serie, nroFactura,nroCuota, detalleventacuotas.monto, detalleventacuotas.saldo, detalleventacuotas.fechaVencimiento as fvc
			from detalleventacuotas, venta, persona 
			where idPersona = venta.Cliente_idCliente and 
			Venta_idVenta = idVenta and 
			Cliente_idCliente = '$cliente' and 
			detalleventacuotas.saldo > 0 and venta.inactivo = 0 order by fvc asc";
			return ejecutarConsulta($sql); 	
     
	}

	public function rpt_remisiones_pendientes($fechai,$fechaf,$cliente,$orden) 
	{
			$sql = "SELECT idVenta, fechaFactura, venta.usuario, serie, nroFactura, cantidad, cantidadRemision, Cliente_idCliente, descripcion, nroDocumento, razonSocial
			from venta, detalleventa, persona where idPersona = venta.Cliente_idCliente and   venta.Remision = 'S' and venta.idVenta = Venta_idVenta and cantidadRemision > 0 and Cliente_idCliente = '$cliente'";
			return ejecutarConsulta($sql); 	
     
	}


	public function sumarImpresiones($id)
	{
		$sql="CALL SP_impresion_cant('$id')";
		return ejecutarConsulta($sql);
	}


}
?>