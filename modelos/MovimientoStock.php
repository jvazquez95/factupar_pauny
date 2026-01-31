<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class MovimientoStock
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar(
		$Deposito_idDepositoOrigen,
		$Deposito_idDepositoDestino,
		$comentario,
		$fechaTransaccion,
		$totalC,
		$cantidadTotal,
  
		$Articulo_idArticulo,
		$cantidad,
		$precio,
		$total){
		session_start();
		$usuario = $_SESSION['login'];

		$sql="
			INSERT INTO `movimientostock`
			(
			`usuario`,
			`Deposito_idDepositoOrigen`,
			`Deposito_idDepositoDestino`,
			`comentario`,
			`fechaTransaccion`,
			`total`,
			`cantidadTotal`,
			`usuarioInsercion`,
			`inactivo`,
			`estado`)  
			VALUES
			(
			'$usuario',
			'$Deposito_idDepositoOrigen',
			'$Deposito_idDepositoDestino',
			'comentario',
			now(),
			'$totalC',
			'$cantidadTotal',
			'$usuario', 
			0,
			1
			)"; 


		$nuevoId = ejecutarConsulta_retornarID($sql);
	
		$num_elementosTipoPersona=0;
		$sw=true; 
		$ultimo = count($cantidad) - 1;
		while ($num_elementosTipoPersona < count($cantidad))
		{

			if ($num_elementos == $ultimo) {
	
			$sql_detalle = "INSERT INTO `movimientostockdetalle`
			(`MovimientoStock_idMovimientoStock`,
			`Articulo_idArticulo`,
			`cantidad`,
			`precio`,
			`total`,
			`inactivo`, 
			`ultimo`) 
			VALUES
			(
			'$nuevoId',
			'$Articulo_idArticulo[$num_elementosTipoPersona]',
			'$cantidad[$num_elementosTipoPersona]',
			'$precio[$num_elementosTipoPersona]',
			'$total[$num_elementosTipoPersona]',
			0,
			1 
			)";


			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementosTipoPersona=$num_elementosTipoPersona + 1;

			}else{

			$sql_detalle = "INSERT INTO `movimientostockdetalle`
			(`MovimientoStock_idMovimientoStock`,
			`Articulo_idArticulo`,
			`cantidad`,
			`precio`,
			`total`,
			`inactivo`, 
			`ultimo`) 
			VALUES
			(
			'$nuevoId',
			'$Articulo_idArticulo[$num_elementosTipoPersona]',
			'$cantidad[$num_elementosTipoPersona]',
			'$precio[$num_elementosTipoPersona]',
			'$total[$num_elementosTipoPersona]',
			0,
			0
			)";


			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementosTipoPersona=$num_elementosTipoPersona + 1;

			}

		}
 
		return $sw;

	}


	//Implementamos un método para editar registros
	public function editar(	
		$idMovimientoStock, 	
		$Deposito_idDepositoOrigen,
		$Deposito_idDepositoDestino,
		$comentario,
		$fechaTransaccion,
		$totalC,
		$cantidadTotal,

		$Articulo_idArticulo,
		$cantidad,
		$precio,
		$total,
		$idMovimientoStockDetalle)  
	{
		$sw=true;
		$sql="UPDATE movimientostock SET  Deposito_idDepositoOrigen='$Deposito_idDepositoOrigen', Deposito_idDepositoDestino='$Deposito_idDepositoDestino',comentario='$comentario',fechaTransaccion='$fechaTransaccion',total='$totalC',cantidadTotal='$cantidadTotal', fechaModificacion = now() WHERE idMovimientoStock='$idMovimientoStock'";
		ejecutarConsulta($sql) or $sw = false;

		$num_elementos=0;

		if ($sw == true) {
				
					while ($num_elementos < count($cantidad))
					{
						if ($idMovimientoStockDetalle[$num_elementos] == 0) {
							$sql_detalle = "INSERT INTO `movimientostockdetalle`
							(`MovimientoStock_idMovimientoStock`,
							`Articulo_idArticulo`,
							`cantidad`,
							`precio`,
							`total`,
							`inactivo`,
							`fechaModificacion`) 
							VALUES
							(
							'$idMovimientoStock',
							'$Articulo_idArticulo[$num_elementos]',
							'$cantidad[$num_elementos]',
							'$precio[$num_elementos]',
							'$total[$num_elementos]', 
							0,
							now()
							)";

							ejecutarConsulta($sql_detalle) or $sw = false;
							$num_elementos=$num_elementos + 1;

						}else{

							$sql_detalle = "UPDATE `movimientostockdetalle`	SET
												`Articulo_idArticulo` = '$Articulo_idArticulo[$num_elementos]',`cantidad` = '$cantidad[$num_elementos]',`precio` = '$precio[$num_elementos]', `total` = '$total[$num_elementos]', `fechaModificacion` = now()    
												WHERE `idMovimientoStockDetalle` = '$idMovimientoStockDetalle[$num_elementos]' and `MovimientoStock_idMovimientoStock` = '$idMovimientoStock'";
							ejecutarConsulta($sql_detalle) or $sw = false;		 		    
							$num_elementos=$num_elementos + 1;
						}
					}
		}
		
		return $sw;		 
	}

	//Implementamos un método para eliminar categorías
	public function activar($idMovimientoStock)
	{
		$sql="UPDATE movimientostock set inactivo = 0 WHERE idMovimientoStock='$idMovimientoStock'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para eliminar categorías
	public function desactivar($idMovimientoStock)
	{
		$sql="UPDATE movimientostock set inactivo = 1, estado=4 WHERE idMovimientoStock='$idMovimientoStock' where inactivo=0";
		return ejecutarConsulta($sql);
	}


	//Implementamos un método para enviar a transito
	public function enviarTransito($idMovimientoStock)
	{
		$sql="UPDATE movimientostock set estado = 2 WHERE idMovimientoStock='$idMovimientoStock' where estado=1 and inactivo=0";
		return ejecutarConsulta($sql);
	}

		//Implementamos un método para recibir de transito
	public function recibirTransito($idMovimientoStock)
	{
		$sql="UPDATE movimientostock set estado = 3 WHERE idMovimientoStock='$idMovimientoStock' where estado=2 and inactivo=0";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idMovimientoStock)
	{
		$sql="SELECT * FROM movimientostock WHERE idMovimientoStock='$idMovimientoStock'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para filtrar los registros 
	public function filtrar($Deposito_idDeposito_Origen,$Deposito_idDeposito_Destino, $fi, $ff, $estado)
	{
		$sql="SELECT m.idMovimientoStock, m.usuario, d1.descripcion AS Deposito_idDepositoOrigen, d2.descripcion AS Deposito_idDepositoDestino, comentario, fechaTransaccion, SUM(md.total) AS total, SUM(md.cantidad) AS cantidad, m.inactivo
			FROM movimientostock m JOIN movimientostockdetalle md ON m.idMovimientoStock = md.MovimientoStock_idMovimientoStock
			JOIN deposito d1 ON d1.idDeposito = Deposito_idDepositoOrigen
			JOIN deposito d2 ON d2.idDeposito = Deposito_idDepositoDestino
			and date(m.fechaTransaccion) between '$fi' and '$ff' 
			and  (m.Deposito_idDepositoOrigen= '$Deposito_idDeposito_Origen' or '$Deposito_idDeposito_Origen'=999) 
			and  (m.Deposito_idDepositoDestino= '$Deposito_idDeposito_Destino' or '$Deposito_idDeposito_Destino'=999) 
			and  (m.estado= '$estado' or '$estado'=999) 
			GROUP BY idMovimientoStock";
		return ejecutarConsulta($sql);		
	}   	

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT m.idMovimientoStock, m.usuario, d1.descripcion AS Deposito_idDepositoOrigen, d2.descripcion AS Deposito_idDepositoDestino, comentario, fechaTransaccion, SUM(md.total) AS total, SUM(md.cantidad) AS cantidad, m.inactivo
FROM movimientostock m JOIN movimientostockdetalle md ON m.idMovimientoStock = md.MovimientoStock_idMovimientoStock
JOIN deposito d1 ON d1.idDeposito = Deposito_idDepositoOrigen
JOIN deposito d2 ON d2.idDeposito = Deposito_idDepositoDestino
GROUP BY idMovimientoStock";
		return ejecutarConsulta($sql);		
	}   

	public function detalle($idMovimientoStock)
	{
		$sql="SELECT a.idMovimientoStockDetalle,b.nombre,a.cantidad,a.precio,a.total
			from movimientostockdetalle a, articulo b
			where a.Articulo_idArticulo=b.idArticulo and a.MovimientoStock_idMovimientoStock = '$idMovimientoStock' and a.inactivo = 0";
		return ejecutarConsulta($sql);		
	} 



	public function listarDetalleMovimientoStock($idMovimientoStock)   
	{
		$sql="SELECT a.idMovimientoStockDetalle,b.idArticulo,b.nombre,a.cantidad,a.precio,a.total
		from movimientostockdetalle a, articulo b
		where a.Articulo_idArticulo=b.idArticulo and a.MovimientoStock_idMovimientoStock = '$idMovimientoStock' and a.inactivo = 0";
		return ejecutarConsulta($sql);		
	}	

	public function selectDepositoOrigen()
	{
		$sql="SELECT * from deposito where inactivo=0"; 
		return ejecutarConsulta($sql);		
	}

	public function selectDepositoOrigenHabilitacion()
	{
		$sql="SELECT deposito.idDeposito,deposito.descripcion
				from habilitacion 
				join caja on habilitacion.Caja_idCaja = caja.idCaja
				join deposito on deposito.idDeposito=caja.Deposito_idDeposito 
				where habilitacion.estado=1 and caja.inactivo=0 and deposito.inactivo=0
				group by  deposito.idDeposito,deposito.descripcion "; 
		return ejecutarConsulta($sql);		
	}	

	public function selectDepositoDestino()
	{
		$sql="SELECT * from deposito where inactivo=0"; 
		return ejecutarConsulta($sql);		
	}

	public function selectDepositoDestinoHabilitacion()
	{
		$sql="SELECT deposito.idDeposito,deposito.descripcion
				from habilitacion 
				join caja on habilitacion.Caja_idCaja = caja.idCaja
				join deposito on deposito.idDeposito=caja.Deposito_idDeposito 
				where habilitacion.estado=1 and caja.inactivo=0 and deposito.inactivo=0
				group by  deposito.idDeposito,deposito.descripcion "; 
		return ejecutarConsulta($sql);		
	}

	public function selectArticulo()
	{
		$sql="SELECT * from articulo where inactivo=0";  
		return ejecutarConsulta($sql);	  	
	}

	//Implementamos un método para desactivar registros
	public function desactivarDetalleMovimientoStock($idMovimientoStockDetalle)
	{
		$sql="UPDATE movimientostockdetalle SET inactivo = 1 WHERE idMovimientoStockDetalle='$idMovimientoStockDetalle'";
		return ejecutarConsulta($sql);
	}


	//Implementar un método para listar los registros
	public function rpt_op_cabecera($idMovimientoStock)
	{
		$sql="

		SELECT *, 
F_NOMBRE_DEPOSITO(Deposito_idDepositoOrigen) as origen, 
F_NOMBRE_SUCURSAL_X_DEPOSITO(Deposito_idDepositoOrigen) as sucursal_origen, 
F_NOMBRE_DEPOSITO(Deposito_idDepositoDestino) as destino,  
F_NOMBRE_SUCURSAL_X_DEPOSITO(Deposito_idDepositoDestino) as sucursal_destino
from movimientostock WHERE idMovimientoStock = '$idMovimientoStock';";
		return ejecutarConsulta($sql);		
	}


	//Implementar un método para listar los registros
	public function rpt_op_detalle($idMovimientoStock)
	{
		$sql="SELECT * from detallepagofacturas, compra where compra.idCompra = detallepagofacturas.COMPRA_IDCOMPRA AND  PAGO_IDPAGO   = '$idPago';";
		return ejecutarConsulta($sql);		
	}


	//Implementar un método para listar los registros
	public function rpt_movimiento_stock($idMovimientoStock)
	{
		$sql="SELECT codigoBarra, codigoAlternativo, idArticulo, descripcion, cantidad, movimientostockdetalle.precio, movimientostockdetalle.cantidad, movimientostockdetalle.total 
				from movimientostockdetalle, articulo 
				where articulo.idArticulo = movimientostockdetalle.Articulo_idArticulo AND MovimientoStock_idMovimientoStock = '$idMovimientoStock'";
		return ejecutarConsulta($sql);		
	}


}

?>