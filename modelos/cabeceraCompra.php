<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class cabeceraCompra
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
	//Implementamos un método para editar registros
	public function editar($idCompra,$Persona_idPersona,$Deposito_idDeposito,$TerminoPago_idTerminoPago,$tipoCompra,$tipo_comprobante,$nroFactura,$fechaFactura,$fechaVencimiento,$timbrado,$vtoTimbrado,$Moneda_idMoneda,$tasaCambio,$tasaCambioBases,$totalImpuesto,$total,$totalNeto,$saldo,$CentroCosto_idCentroCosto) 
	{ 
		session_start(); 
		$usuario = $_SESSION['login']; 

			$sql="UPDATE `compra` SET Persona_idPersona = '$Persona_idPersona', Deposito_idDeposito = '$Deposito_idDeposito', TerminoPago_idTerminoPago = '$TerminoPago_idTerminoPago', tipoCompra = '$tipoCompra', tipo_comprobante = '$tipo_comprobante', nroFactura = '$nroFactura', fechaFactura = '$fechaFactura', timbrado = '$timbrado', vtoTimbrado = '$vtoTimbrado', CentroCosto_idCentroCosto = '$CentroCosto_idCentroCosto' , usuarioModificacion = '$usuario' , fechaModificacion= now() WHERE idCompra='$idCompra'";  
		return ejecutarConsulta($sql);     
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idCompra)
	{
		$sql="UPDATE compra SET inactivo=1 WHERE idCompra='$idCompra'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idCompra)
	{
		$sql="UPDATE compra SET inactivo=0 WHERE idCompra='$idCompra'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idCompra)
	{
		$sql="SELECT * FROM compra WHERE idCompra='$idCompra'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT a.idCompra,a.nroFactura,b.nombreComercial,a.fechaTransaccion,c.descripcion,a.fechaFactura,a.total,a.inactivo
				from compra a
				left outer join persona b on a.Persona_idPersona=b.idPersona 
				left outer join deposito c on  a.Deposito_idDeposito = c.idDeposito";
		return ejecutarConsulta($sql);	 	 
	}
	//Implementar un método para listar los registros y mostrar en el select    
	public function selectCompra()
	{
		$sql="SELECT * FROM compra where inactivo=0";
		return ejecutarConsulta($sql);		
	}

 

}

?>