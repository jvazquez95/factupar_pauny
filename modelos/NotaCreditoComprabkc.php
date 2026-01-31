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
	public function insertar(
		$Compra_idCompra,
		$Persona_idPersona,
		$Habilitacion_idhabilitacion,
		$tipoComprobante,
		$nroDevolucion,
		$nroFactura,
		$fechaTransaccion,
		$timbrado,
		$vtoTimbrado,
		$totalImpuesto,
		$totalC,
		$subTotal,
		
		$Articulo_idArticulo,
		$cantidad,
		$devuelve,
		$totalNeto,
		$total){ 
		session_start();
		$usuario = $_SESSION['login'];

		$sql="
			INSERT INTO `notacreditocompra`
			(`Compra_idCompra`,
			`Persona_idPersona`,
			`Habilitacion_idhabilitacion`,
			`usuario`,
			`tipoComprobante`,
			`nroDevolucion`,
			`nroFactura`,
			`fechaTransaccion`,
			`fechaVencimiento`,
			`timbrado`,
			`vtoTimbrado`,
			`totalImpuesto`,
			`total`,
			`subTotal`,
			`usuarioInsercion`,
			`inactivo`)  
			VALUES
			(
			'$Compra_idCompra', 
			'$Persona_idPersona',
			'$Habilitacion_idhabilitacion',
			'$usuario',
			'$tipoComprobante',
			'$nroDevolucion',
			'$nroFactura',
			'$fechaTransaccion',
			'$fechaVencimiento',
			'$timbrado',
			'$vtoTimbrado',
			'$totalImpuesto', 
			'$totalC',
			'$subTotal',
			'$usuario',    
			0 
			)";


		$nuevoId = ejecutarConsulta_retornarID($sql);
		$num_elementosTipoPersona=0;
		$sw=true;
		
		while ($num_elementosTipoPersona < count($Articulo_idArticulo))
		{

			$sql_detalle = "INSERT INTO `gigante`.`notacreditocompradetalle`
			(`NotaCreditoCompra_idNotaCreditoCompra`,
			`Articulo_idArticulo`,
			`cantidad`,
			`devuelve`,
			`totalNeto`,
			`total`,
			`inactivo`) 
			VALUES 
			(
			'$nuevoId',
			'$Articulo_idArticulo[$num_elementosTipoPersona]',
			'$cantidad[$num_elementosTipoPersona]',
			'$devuelve[$num_elementosTipoPersona]',
			'$totalNeto[$num_elementosTipoPersona]',
			'$total[$num_elementosTipoPersona]',
			0
			)"; 

			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementosTipoPersona=$num_elementosTipoPersona + 1;
		}

		return $sw;

	}

	//Implementamos un método para editar registros
	public function editar(
	$idNotaCreditoCompra,
	$Compra_idCompra,
	$Persona_idPersona,
	$Habilitacion_idhabilitacion,
	$tipoComprobante,
	$nroDevolucion,
	$nroFactura,
	$fechaTransaccion,
	$fechaVencimiento,
	$timbrado,
	$vtoTimbrado,
	$totalImpuesto,
	$totalC,
	$subTotal,

	$Articulo_idArticulo,
	$cantidad,
	$devuelve,
	$totalNeto,
	$total,
	$idNotaCreditoCompraDetalle
	)  
	{
		session_start();
		$usuario = $_SESSION['login'];
		$sw=true;
		$sql="UPDATE notacreditocompra SET  Compra_idCompra='$Compra_idCompra', Persona_idPersona='$Persona_idPersona',Habilitacion_idhabilitacion='$Habilitacion_idhabilitacion',tipoComprobante='$tipoComprobante',nroDevolucion='$nroDevolucion',nroFactura='$nroFactura',fechaTransaccion='$fechaTransaccion',fechaVencimiento='$fechaVencimiento',timbrado='$timbrado',vtoTimbrado='$vtoTimbrado',totalImpuesto='$totalImpuesto',total='$totalC',subTotal='$subTotal', fechaModificacion = now(), usuarioModificacion='$usuario' WHERE idNotaCreditoCompra='$idNotaCreditoCompra'";
			ejecutarConsulta($sql) or $sw = false;
 
		$num_elementos=0;
		//$sw=true;
		if ($sw == true) {
				
					while ($num_elementos < count($cantidad))
					{
						if ($idNotaCreditoCompraDetalle[$num_elementos] == 0) {
							$sql_detalle = "INSERT INTO `gigante`.`notacreditocompradetalle`
							(
							`NotaCreditoCompra_idNotaCreditoCompra`,
							`Articulo_idArticulo`,
							`cantidad`,
							`devuelve`,
							`totalNeto`,
							`total`,
							`inactivo`) 
							VALUES
							(
							'$idNotaCreditoCompra',
							'$Articulo_idArticulo[$num_elementos]', 
							'$cantidad[$num_elementos]',
							'$devuelve[$num_elementos]',
							'$totalNeto[$num_elementos]',
							'$total[$num_elementos]',
							0
							)"; 
							ejecutarConsulta($sql_detalle) or $sw = false;
							$num_elementos=$num_elementos + 1;
				

						}else{
							$sql_detalle = "UPDATE `gigante`.`notacreditocompradetalle`
								SET
								`Articulo_idArticulo` = '$Articulo_idArticulo[$num_elementos]',
								`cantidad` = '$cantidad[$num_elementos]',
								`devuelve` = '$devuelve[$num_elementos]',
								`totalNeto` = '$totalNeto[$num_elementos]',
								`total` = '$total[$num_elementos]',
								`fechaModificacion` = now()
								WHERE `idNotaCreditoCompraDetalle` = '$idNotaCreditoCompraDetalle[$num_elementos]' and `NotaCreditoCompra_idNotaCreditoCompra`='$idNotaCreditoCompra'";
							ejecutarConsulta($sql_detalle) or $sw = false;				
							$num_elementos=$num_elementos + 1;
						}
					}
		}
		
		return $sw;		
	}


	//Implementamos un método para eliminar categorías
	public function activar($idNotaCreditoCompra)
	{
		$sql="UPDATE notacreditocompra set inactivo = 0 WHERE idNotaCreditoCompra='$idNotaCreditoCompra'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para eliminar categorías
	public function desactivar($idPersona)
	{
		$sql="UPDATE notacreditocompra set inactivo = 1 WHERE idNotaCreditoCompra='$idNotaCreditoCompra'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idNotaCreditoCompra)
	{
		$sql="SELECT a.idNotaCreditoCompra,a.Compra_idCompra,a.Persona_idPersona,a.Habilitacion_idhabilitacion,a.usuario,a.tipoComprobante,a.nroDevolucion,a.nroFactura,a.fechaTransaccion,a.fechaVencimiento,a.timbrado,a.vtoTimbrado,a.totalImpuesto,a.total as totalC,a.subTotal,a.inactivo
			from notacreditocompra a WHERE idNotaCreditoCompra='$idNotaCreditoCompra'";
		return ejecutarConsultaSimpleFila($sql);
	}
	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT a.idNotaCreditoCompra,a.nroDevolucion,a.nroFactura,c.razonSocial,a.tipoComprobante,a.fechaTransaccion,a.total as totalC,a.inactivo
			from notacreditocompra a,compra b,persona c,habilitacion d
			where a.Compra_idCompra=b.idCompra and a.Persona_idPersona=c.idPersona and a.Habilitacion_idhabilitacion=d.idHabilitacion";
		return ejecutarConsulta($sql);		 
	}

	public function listarDetalleNotaCreditoCompra($idNotaCreditoCompra) 
	{
		$sql="SELECT  a.idNotaCreditoCompraDetalle,b.idArticulo,b.nombre,a.cantidad,a.devuelve,a.totalNeto,a.total
		from notacreditocompradetalle a, articulo  b 
		where a.Articulo_idArticulo=b.idArticulo
		and a.NotaCreditoCompra_idNotaCreditoCompra= '$idNotaCreditoCompra' and a.inactivo = 0";
		return ejecutarConsulta($sql);		
	}
	
	//Implementamos un método para desactivar registros
	public function desactivarDetalleNotaCreditoCompra($idNotaCreditoCompraDetalle)
	{
		$sql="UPDATE notacreditocompradetalle SET inactivo = 1 WHERE idNotaCreditoCompraDetalle='$idNotaCreditoCompraDetalle'";
		return ejecutarConsulta($sql); 
	}

	public function selectProveedor() 
	{
		$sql="SELECT * from persona, persona_tipopersona,tipopersona 
				where persona.idPersona = persona_tipopersona.Persona_idPersona and tipopersona.idTipoPersona = persona_tipopersona.TipoPersona_idTipoPersona and persona_tipopersona.inactivo = 0 and persona_tipopersona.TipoPersona_idTipoPersona = 2";
		return ejecutarConsulta($sql);		  
	}

	public function selectHabilitacion() 
	{
		$sql="SELECT *
			from habilitacion a, usuario b
			where a.Usuario_idUsuario = b.idUsuario"; 
		return ejecutarConsulta($sql);		
	}

	public function selectCompra() 
	{
		$sql="SELECT * from compra where inactivo = 0"; 
		return ejecutarConsulta($sql);		
	}

	public function selectArticulo() 
	{
		$sql="SELECT * from articulo"; 
		return ejecutarConsulta($sql);		
	}

}

?>