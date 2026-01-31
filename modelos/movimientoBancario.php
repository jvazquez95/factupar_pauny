<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class movimientoBancario
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($ano,$mes,$Moneda_idMoneda,$nroCuenta,$Banco_idBanco,$nroSecuencia,$fechaMovimiento,$nroOrden,$beneficiario,$Importe,$tipoMovimiento,$concepto,$nroDocumento,$fechaCobro,$fechaEmision,$fechaAnulacion,$situacion,$CentroCosto_idCentroCosto,$Persona_idPersonaPersonal,$cargo,$indicadorSueldo,$mesSueldo)
	{
		session_start();
		$usuario = $_SESSION['login'];
		$sql="INSERT INTO movimientobancario ( 
`ano`,
`mes`,
`Moneda_idMoneda`,
`nroCuenta`,
`Banco_idBanco`,
`nroSecuencia`,
`fechaMovimiento`,
`nroOrden`,
`beneficiario`,
`Importe`,
`tipoMovimiento`,
`concepto`,
`nroDocumento`,
`fechaCobro`,
`fechaEmision`,
`fechaAnulacion`,
`situacion`,
`CentroCosto_idCentroCosto`,
`Persona_idPersonaPersonal`,
`cargo`,
`indicadorSueldo`,
`mesSueldo`,
`usuarioInsercion`,
`fechaInsercion`,
`inactivo`)
 VALUES ('$ano','$mes','$Moneda_idMoneda','$nroCuenta','$Banco_idBanco','$nroSecuencia','$fechaMovimiento','$nroOrden','$beneficiario','$Importe','$tipoMovimiento','$concepto','$nroDocumento','$fechaCobro','$fechaEmision','$fechaAnulacion','$situacion','$CentroCosto_idCentroCosto','$Persona_idPersonaPersonal','$cargo','$indicadorSueldo','$mesSueldo','$usuario',now(),0)";
		return ejecutarConsulta($sql);         
	}

	//Implementamos un método para editar registros
	public function editar($idMovimientoBancario,$ano,$mes,$Moneda_idMoneda,$nroCuenta,$Banco_idBanco,$nroSecuencia,$fechaMovimiento,$nroOrden,$beneficiario,$Importe,$tipoMovimiento,$concepto,$nroDocumento,$fechaCobro,$fechaEmision,$fechaAnulacion,$situacion,$CentroCosto_idCentroCosto,$Persona_idPersonaPersonal,$cargo,$indicadorSueldo,$mesSueldo)
	{ 
		session_start(); 
		$usuario = $_SESSION['login']; 
		$sql="UPDATE `movimientobancario` SET ano='$ano',fechaModificacion= now(), usuarioModificacion = '$usuario', Moneda_idMoneda = '$Moneda_idMoneda' , nroCuenta= '$nroCuenta' , mes= '$mes', Banco_idBanco= '$Banco_idBanco', nroSecuencia= '$nroSecuencia', fechaMovimiento= '$fechaMovimiento', nroOrden= '$nroOrden', beneficiario= '$beneficiario', Importe= '$Importe', tipoMovimiento= '$tipoMovimiento', concepto= '$concepto', nroDocumento= '$nroDocumento', fechaCobro= '$fechaCobro', fechaEmision= '$fechaEmision', fechaAnulacion= '$fechaAnulacion', situacion= '$situacion', CentroCosto_idCentroCosto= '$CentroCosto_idCentroCosto', Persona_idPersonaPersonal= '$Persona_idPersonaPersonal', cargo= '$cargo', indicadorSueldo= '$indicadorSueldo', mesSueldo= '$mesSueldo'  WHERE idMovimientoBancario='$idMovimientoBancario'";
		return ejecutarConsulta($sql);    
	}

	//Implementamos un método para desactivar categorías 
	public function desactivar($idMovimientoBancario)
	{
		$sql="UPDATE movimientobancario SET inactivo=1 WHERE idMovimientoBancario='$idMovimientoBancario'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idMovimientoBancario)
	{
		$sql="UPDATE movimientobancario SET inactivo=0 WHERE idMovimientoBancario='$idMovimientoBancario'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idMovimientoBancario)
	{
		$sql="SELECT * FROM movimientobancario WHERE idMovimientoBancario='$idMovimientoBancario'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT a.idMovimientoBancario,ano,mes,b.descripcion as Moneda,a.nroCuenta as nroCuentaMovimiento,c.descripcion as Banco,a.inactivo
			FROM movimientobancario a, moneda b,banco c
			where a.Moneda_idMoneda = b.idMoneda and a.Banco_idBanco = c.idBanco";
		return ejecutarConsulta($sql);	 	 
	}
	//Implementar un método para listar los registros y mostrar en el select   
	public function select()
	{
		$sql="SELECT * FROM movimientobancario where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>