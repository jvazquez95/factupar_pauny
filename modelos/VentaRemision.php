<?php 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
Class VentaRemision
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
 


/* --------------------------------------------------------------------------
   Inserta una remisión de venta y sus detalles
---------------------------------------------------------------------------*/
public function insertar(
    $entrega,               $Moneda_idMoneda,  $tasaCambio,     $tasaCambioBases,
    $Cliente_idCliente,     $Habilitacion_idHabilitacion,
    $Deposito_idDeposito,   $TerminoPago_idTerminoPago,
    $tipo_comprobante,      $nroFactura,       $fechaFactura,
    $fechaVencimiento,      $timbrado,         $vtoTimbrado,
    $totalImpuesto,         $total,            $totalNeto,
    $usuarioInsercion,      $serie,            $cuotas,
    $giftCard,              $nroGiftCard,      $clienteGiftCard,
    $Empleado_idEmpleado,   $OrdenVenta_idOrdenVenta,
    $VentaDetalle_idVentaDetalle,
    $cant_max,              $idarticulo,       $descripcion,
    $cantidad,              $saldoStock,       $precioVenta,    $impuesto,
    $idImpuesto,            $importe_detalle,  $tipopagodetalle,
    $nroReferencia,         $capital,          $interes,
    $descuento,             $banco,            $importe_detalle_pagado,
    $moneda,                $tasa,             $regalia
) {
    /* Utilidades internas ─────────────────────────────────────────────── */
    $n = fn($v) => floatval(str_replace(',', '.', $v ?? 0));  // número (float)
    $i = fn($v) => intval($v ?? 0);                           // entero
    $f = fn($v) => number_format($v, 2, '.', '');             // formateo MySQL

    $usuario = $_SESSION['login'] ?? 'SYS';

    /* ───────── CABECERA ───────── */
    $sqlCab = "INSERT INTO ventaRemision (
                  entrega, Cliente_idCliente, usuario, Habilitacion_idHabilitacion,
                  Deposito_idDeposito, TerminoPago_idTerminoPago, tipo_comprobante,
                  nroFactura, fechaTransaccion, fechaFactura, fechaVencimiento,
                  timbrado, vtoTimbrado, totalImpuesto, total, totalNeto,
                  usuarioInsercion, inactivo, serie, cuotas, giftCard, nroGiftCard,
                  clienteGiftCard, vendedor, OrdenVenta_idOrdenVenta, Venta_idVenta,
                  Moneda_idMoneda, tasaCambio, tasaCambioBases, regalia
               ) VALUES (
                  '$entrega', '$Cliente_idCliente', '$usuario', '$Habilitacion_idHabilitacion',
                  '$Deposito_idDeposito', '$TerminoPago_idTerminoPago', '$tipo_comprobante',
                  '$nroFactura', NOW(), '$fechaFactura', '$fechaVencimiento',
                  '$timbrado', '$vtoTimbrado', '$totalImpuesto', '$total',
                  '$totalNeto', '$usuario', 0, '$serie', '$cuotas',
                  '$giftCard', '$nroGiftCard', '$clienteGiftCard', '$Empleado_idEmpleado',
                  '$OrdenVenta_idOrdenVenta', '$OrdenVenta_idOrdenVenta', '$Moneda_idMoneda',
                  '$tasaCambio', '$tasaCambioBases', '$regalia'
               )";

    $idRemision = ejecutarConsulta_retornarID($sqlCab);

    /* ───────── DETALLE ───────── */
    $total_capital = 0.0;
    $total_interes = 0.0;
    $ultimoIndex   = count($idarticulo) - 1;

    for ($idx = 0; $idx <= $ultimoIndex; $idx++) {

        /* Normalizar entradas */
        $cant       = $i($cantidad[$idx]);
        $sStock     = $i($saldoStock[$idx]);       // ← NUEVO
        $precio     = $n($precioVenta[$idx]);
        $impPorc    = $n($impuesto[$idx]);
        $descPorc   = $n($descuento[$idx]);
        $interesU   = $n($interes[$idx]);
        $capitalU   = $n($capital[$idx]);
        $cantMax    = $i($cant_max[$idx]);

        /* Cálculos */
        $totalLinea = $cant * $precio;
        $netoLinea  = $totalLinea * $impPorc / 100;
        $precioDesc = $precio - ($precio * $descPorc / 100);
        $precioSinI = ($precio - $interesU) - ($descPorc / 100 * ($precio - $interesU));
        $l_interes  = ($precioDesc - $precioSinI) * $cant;
        $l_capital  = $precioSinI * $cant;

        $total_capital += $l_capital;
        $total_interes += $l_interes;

        /* Saldo de unidades si aplica */
        $saldoCantidad = ($VentaDetalle_idVentaDetalle[$idx] > 0)
                         ? $cantMax - $cant
                         : 0;

        /* Marca de último */
        $esUltimo = ($idx === $ultimoIndex) ? 1 : 0;

        /* Inserción de detalle */
        $sqlDet = "INSERT INTO ventaRemisionDetalle (
                       Remision_idRemision, Articulo_idArticulo, cantidad, saldoStock,
                       precio, impuesto, descuento, totalNeto, total, inactivo,
                       TipoImpuesto_idTipoImpuesto, descripcion, ultimo,
                       capital, interes, saldoCantidad, VentaDetalle_idVentaDetalle
                   ) VALUES (
                       '$idRemision',
                       '{$idarticulo[$idx]}',
                       '$cant',
                       '$sStock',
                       '" . $f($precio) . "',
                       '$impPorc',
                       '$descPorc',
                       '" . $f($netoLinea) . "',
                       '" . $f($totalLinea) . "',
                       0,
                       '{$idImpuesto[$idx]}',
                       '{$descripcion[$idx]}',
                       '$esUltimo',
                       '" . $f($l_capital) . "',
                       '" . $f($l_interes) . "',
                       '$saldoCantidad',
                       '{$VentaDetalle_idVentaDetalle[$idx]}'
                   )";

        ejecutarConsulta($sqlDet);
    }

    /* Si necesitas actualizar la cabecera con $total_capital / $total_interes, hazlo aquí */

    return $idRemision;
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

	public function listarDetalleOrdenVenta($id)
	{


	$sql="SELECT
    dv.*,
    F_NOMBRE_ARTICULO(dv.Articulo_idArticulo)                             AS na,

    /* cantidad pendiente de remisión */
    dv.cantidad
      - IFNULL((
          SELECT SUM(vrd.cantidad)
          FROM   ventaRemisionDetalle vrd
          JOIN   ventaRemision        vr  ON vr.idRemision = vrd.Remision_idRemision
          WHERE  vr.Venta_idVenta      = '$id' 
            AND  vrd.Articulo_idArticulo = dv.Articulo_idArticulo
        ), 0)                                                             AS cant_max,

    /* stock real = cantidadStock + stock del usuario SOLO si el artículo es 9 */
    dv.cantidadStock
      + CASE
          WHEN dv.Articulo_idArticulo = 9 THEN
            IFNULL((
               SELECT SUM(st.cantidad)
               FROM   stockTercerizados st
               WHERE  st.Persona_idPersona = v.Cliente_idCliente
            ), 0)
          ELSE dv.cantidad
      - IFNULL((
          SELECT SUM(vrd.cantidad)
          FROM   ventaRemisionDetalle vrd
          JOIN   ventaRemision        vr  ON vr.idRemision = vrd.Remision_idRemision
          WHERE  vr.Venta_idVenta      = '$id' 
            AND  vrd.Articulo_idArticulo = dv.Articulo_idArticulo
        ), 0)
        END                                                              AS stock_real
FROM detalleventa dv, venta v
WHERE dv.Venta_idVenta = '$id'      -- la venta que te interesa
  AND dv.Venta_idVenta > 0 and v.idVenta = dv.Venta_idVenta;"; 
		return ejecutarConsulta($sql);
	}

	public function listarAFacturar($habilitacion)
	{
		$sql="SELECT persona.idPersona as idPersona, idVenta as idOrdenVenta, v.Deposito_idDeposito, v.Habilitacion_idHabilitacion, 
					v.fechaTransaccion as fecha, terminopago.descripcion AS tpd, persona.razonSocial as rs, v.totalImpuesto, 
			        v.totalNeto, v.total, v.usuarioInsercion as ovui, v.usuarioModificacion as ovum, v.inactivo as ovi, 1 as facturado, 
			        v.formaEntrega, v.fechaTransaccion
		from venta as v, terminopago, persona 
		where v.Cliente_idCliente = persona.idPersona and v.TerminoPago_idTerminoPago = terminopago.idTerminoPago 
			and v.inactivo = 0  and v.remision='S' and F_PENDIENTE_REMISION(idVenta) > 0
		ORDER BY idVenta DESC LIMIT 100;";
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
		$sql="SELECT persona.idPersona as idPersona, idRemision as idOrdenVenta, v.Deposito_idDeposito, v.Habilitacion_idHabilitacion, v.fechaTransaccion as fecha, terminopago.descripcion AS tpd, persona.razonSocial as rs, v.totalImpuesto, v.totalNeto, v.total, v.usuarioInsercion as ovui, v.usuarioModificacion as ovum, v.inactivo as ovi, 1 as facturado, v.formaEntrega
			from ventaRemision as v, terminopago, persona
			where v.Cliente_idCliente = persona.idPersona and v.TerminoPago_idTerminoPago = terminopago.idTerminoPago and v.inactivo = 0  ORDER BY idRemision DESC LIMIT 100;";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para anular la venta
	public function anularRemison($idVenta)
	{
		$sw=true;
		$sql="UPDATE ventaRemision SET inactivo='1' WHERE idRemision='$idVenta'";
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
		$sql="SELECT v.idventa,DATE(v.fecha_hora) as fecha,v.idcliente,p.nombre as cliente,u.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado 
			FROM ventaRemision v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idRemision='$idventa'";
		return ejecutarConsultaSimpleFila($sql);
	}


	public function listarDetalleRemision($id)
	{
		$sql="select *, F_NOMBRE_ARTICULO( Articulo_idArticulo ) as na from ventaRemisionDetalle where ventaRemisionDetalle.Remision_idRemision = '$id'" ;
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
		$sql="SELECT *, tipodocumento.descripcion as dd ,ventaRemision.Inactivo as vi, persona.razonSocial as cn, venta.Habilitacion_idHabilitacion as vh 
		from ventaRemision, persona,tipodocumento where ventaRemision.tipo_comprobante = tipodocumento.idTipoDocumento and ventaRemision.Cliente_idCliente = persona.idPersona and ventaRemision.Habilitacion_idHabilitacion  = '$habilitacion' order by ventaRemision.idRemision";
		return ejecutarConsulta($sql);		
	}

	public function ventacabecera($idVenta){
		//$sql="SELECT v.idventa,v.idcliente,p.nombre as cliente,p.direccion,p.tipo_documento,p.num_documento,p.email,p.telefono,v.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,date(v.fecha_hora) as fecha,v.impuesto,v.total_venta FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
		
		$sql="SELECT *,Cliente.razonSocial as nombreCliente, Cliente.nroDocumento as ruc from ventaRemision, cliente WHERE  cliente.idCliente = ventaRemision.Cliente_idCliente and Habilitacion_idHabilitacion = '$idVenta'";

		return ejecutarConsulta($sql);
	}

	public function habilitacioncabecera($habilitacion){
		//$sql="SELECT v.idventa,v.idcliente,p.nombre as cliente,p.direccion,p.tipo_documento,p.num_documento,p.email,p.telefono,v.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,date(v.fecha_hora) as fecha,v.impuesto,v.total_venta FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
		
		$sql="SELECT * from habilitacion, usuario where usuario.idusuario = habilitacion.Usuario_idUsuario and idhabilitacion = '$habilitacion';";

		return ejecutarConsulta($sql);
	}


	public function ventacabeceraWebNC($id){
		//$sql="SELECT v.idventa,v.idcliente,p.nombre as cliente,p.direccion,p.tipo_documento,p.num_documento,p.email,p.telefono,v.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,date(v.fecha_hora) as fecha,v.impuesto,v.total_venta FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
		
		$sql="SELECT *,persona.razonSocial as nombreCliente, persona.nroDocumento as ruc, persona.direccion as cd,  '1567190-9' as fe, (total*-1) as total from notacreditoventa, persona WHERE  persona.idPersona = notacreditoventa.Persona_idPersona and idNotaCreditoVenta  = '$id'";

		return ejecutarConsulta($sql);
	}



	public function ventacabeceraWeb($idVenta){
		//$sql="SELECT v.idventa,v.idcliente,p.nombre as cliente,p.direccion,p.tipo_documento,p.num_documento,p.email,p.telefono,v.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,date(v.fecha_hora) as fecha,v.impuesto,v.total_venta FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
		
		$sql="SELECT *,persona.razonSocial as nombreCliente,(case when regalia = 'N' then 'NO' else 'SI' end) as regalia, persona.nroDocumento as ruc, persona.direccion as cd,  '999999-9' as fe, entrega,marca.descripcion as marcaVehiculo,
		modelo.descripcion as modeloVehiculo, k.nombre as nombreChofer
		from ventaRemision 
			left outer join habilitacion on habilitacion.idHabilitacion = ventaRemision.Habilitacion_idHabilitacion
			left outer join usuario k on k.idUsuario = habilitacion.Usuario_idUsuario
			left outer join persona on  persona.idPersona = ventaRemision.Cliente_idCliente 
			left outer join deposito on deposito.idDeposito = ventaRemision.Deposito_idDeposito 
			left outer join vehiculo on deposito.Vehiculo_idVehiculo = vehiculo.idVehiculo
			left outer join marca on vehiculo.MarcaVehiculo_idMarcaVehiculo= marca.idMarca
			left outer join modelo on vehiculo.MarcaVehiculo_idMarcaVehiculo = modelo.Marca_idMarca and modelo.idModelo = vehiculo.Modelo_idModelo

		where idRemision  = '$idVenta'";

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
			ventaRemision.nroFactura,
			ventaRemision.serie,
			ventaRemision.fechaFactura
			FROM ventaRemision,habilitacion, caja,sucursal, deposito, documentocajero
			where
            ventaRemision.Habilitacion_idHabilitacion = habilitacion.idHabilitacion
            and
		    ventaRemision.idRemision = '$venta' and 
			caja.idcaja = habilitacion.Caja_idCaja and 
			caja.Sucursal_idSucursal = sucursal.idsucursal and deposito.Sucursal_idSucursal = sucursal.idSucursal and documentocajero.Usuario_idUsuario = habilitacion.Usuario_idUsuario limit 1;";


		return ejecutarConsulta($sql);
	}

            


	public function detalleventahabilitacion($habilitacion){
		//$sql="SELECT v.idventa,v.idcliente,p.nombre as cliente,p.direccion,p.tipo_documento,p.num_documento,p.email,p.telefono,v.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,date(v.fecha_hora) as fecha,v.impuesto,v.total_venta FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
		
		$sql="select venta.idVenta, venta.saldo, F_NOMBRE_CLIENTE(venta.Cliente_idCliente) as nc, F_NOMBRE_ARTICULO( detalleventa.Articulo_idArticulo ) as descripcion, detalleventa.precio as precio, detalleventa.cantidad as cantidad, (detalleventa.precio * detalleventa.cantidad) as totalItem, venta.total as totalVenta 
			from detalleventa, venta where venta.idVenta = detalleventa.Venta_idVenta and venta.Habilitacion_idHabilitacion ='$habilitacion';
		";

		return ejecutarConsulta($sql);
	}


	public function ventadetalle($idVenta){

		$sql="SELECT *, articulo.nombre as descripcionarticulo  FROM ventaRemisionDetalle, articulo WHERE ventaRemisionDetalle.Articulo_idArticulo = articulo.idarticulo and Remision_idRemision='$idVenta'";
		return ejecutarConsulta($sql);
	}


	public function ventadetalleNC($id){

		$sql="SELECT *, articulo.nombre as descripcionarticulo, (cantidad * -1) as cantidad, (total * -1) as total, (totalNeto * -1) as totalNeto  FROM notacreditoventadetalle, articulo WHERE notacreditoventadetalle.Articulo_idArticulo = articulo.idarticulo and NotaCreditoVenta_idNotaCreditoventa='$id'";
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
				 caja.Sucursal_idSucursal = sucursal.idsucursal and documentocajero.inactivo=0 and 
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

	public function rpt_remisionGentileza($fechai,$fechaf)
	{
		$sql="SELECT idRemision, 
				nombreComercial, 
				nroDocumento, 
				serie, 
				nroFactura, 
				fechaTransaccion, 
				fechaVencimiento, 
				timbrado, 
				TerminoPago_idTerminoPago, 
				Moneda_idMoneda, 
				F_DESCRIPCION_ARTICULO( Articulo_idArticulo ) articulo, 
				cantidad, 
				precio, (cantidad*precio) total, 
				ventaRemision.usuario as vendedor, 
				ventaRemision.usuario, '' as vendedorAsignado, 
				'' as proveedor   
				from persona, ventaRemision, 
				ventaRemisionDetalle 
				where Cliente_idCliente = idPersona and 
				idRemision = Remision_idRemision 
				and regalia = 'S' 
				and fechaFactura >= '$fechai' and fechaFactura <= '$fechaf' and ventaRemision.inactivo = 0";
		return ejecutarConsulta($sql);
	}



	public function rpt_cuentas_a_cobrar($fechai,$fechaf,$cliente,$orden) 
	{
		if ($orden==0){
			$orden1 = 'p.idPersona,fechaVencimiento';
		}	
		else{
			$orden1 = 'p.idPersona,fechaFactura';	
		}
		
		if ($cliente == ''){	 
			/*Consulta sin Cliente marcado */
			$sql="SELECT p.nombreComercial, p.razonSocial, p.nroDocumento, c.nroFactura, c.total as totalFactura, c.saldo as saldoFactura, 
				IFNULL(dcc.nroCuota,0) as nroCuota, IFNULL(dcc.monto,c.total) as monto , IFNULL(dcc.saldo, c.saldo) as saldo, fechaFactura, dcc.fechaVencimiento, tp.descripcion as termino
				, DATEDIFF(dcc.fechaVencimiento, NOW()) as diasVencido
				FROM detalleventacuotas dcc 
				JOIN venta c 
				ON c.idVenta = dcc.Venta_idVenta
				JOIN persona p
				ON p.idPersona = c.Cliente_idCliente
				JOIN terminopago tp
				ON tp.idTerminoPago = c.TerminoPago_idTerminoPago
				WHERE c.inactivo = 0 and dcc.inactivo = 0
				AND dcc.saldo <> 0  and dcc.fechaVencimiento between '$fechai' and '$fechaf' 
				
				UNION
				SELECT p.nombreComercial, p.razonSocial, p.nroDocumento, c.nroFactura, c.total, c.saldo as saldoFactura, IFNULL(dcc.nroCuota,0) as nroCuota, IFNULL(dcc.monto,c.total) as monto , 
				IFNULL(dcc.saldo, c.saldo) as saldo, c.fechaFactura, c.fechaVencimiento, tp.descripcion as termino, DATEDIFF(c.fechaVencimiento, NOW()) as diasVencido
				FROM 
				venta c 
				LEFT JOIN detalleventacuotas dcc 
				ON c.idVenta = dcc.Venta_idVenta
				JOIN persona p
				ON p.idPersona = c.Cliente_idCliente
				JOIN terminopago tp
				ON tp.idTerminoPago = c.TerminoPago_idTerminoPago
				WHERE c.inactivo = 0 and cuotas = 0 and dcc.fechaVencimiento between '$fechai' and '$fechaf' 
				AND c.saldo <> 0
				ORDER BY  '{$orden1}' 
				  ";
			return ejecutarConsulta($sql); 
		}else{
			/*Consulta para Cliente marcado */
			$sql="SELECT p.nombreComercial, p.razonSocial, p.nroDocumento, c.nroFactura, c.total as totalFactura, c.saldo as saldoFactura, 
			IFNULL(dcc.nroCuota,0) as nroCuota, IFNULL(dcc.monto,c.total) as monto , IFNULL(dcc.saldo, c.saldo) as saldo, fechaFactura, dcc.fechaVencimiento, tp.descripcion as termino
			, DATEDIFF(dcc.fechaVencimiento, NOW()) as diasVencido
			FROM detalleventacuotas dcc 
			JOIN venta c 
			ON c.idVenta = dcc.Venta_idVenta
			JOIN persona p
			ON p.idPersona = c.Cliente_idCliente
			JOIN terminopago tp
			ON tp.idTerminoPago = c.TerminoPago_idTerminoPago
			WHERE c.inactivo = 0 and dcc.inactivo = 0 and dcc.fechaVencimiento between '$fechai' and '$fechaf' 
			AND idPersona = '$cliente'
			AND dcc.saldo <> 0 
			UNION
			SELECT p.nombreComercial, p.razonSocial, p.nroDocumento, c.nroFactura, c.total, c.saldo as saldoFactura, IFNULL(dcc.nroCuota,0) as nroCuota, IFNULL(dcc.monto,c.total) as monto , 
			IFNULL(dcc.saldo, c.saldo) as saldo, c.fechaFactura, c.fechaVencimiento, tp.descripcion as termino, DATEDIFF(c.fechaVencimiento, NOW()) as diasVencido
			FROM 
			venta c 
			LEFT JOIN detalleventacuotas dcc 
			ON c.idVenta = dcc.Venta_idVenta
			JOIN persona p
			ON p.idPersona = c.Cliente_idCliente
			JOIN terminopago tp
			ON tp.idTerminoPago = c.TerminoPago_idTerminoPago
			WHERE c.inactivo = 0 and cuotas = 0  and dcc.fechaVencimiento between '$fechai' and '$fechaf' 
			AND idPersona = '$cliente'
			AND c.saldo <> 0
			ORDER BY  '{$orden1}' ";
			return ejecutarConsulta($sql); 	
		}	     
	}
}
?>