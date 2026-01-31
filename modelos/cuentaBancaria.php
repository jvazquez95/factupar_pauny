<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class cuentaBancaria
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($Moneda_idMoneda,$Banco_idBanco,$descripcion,$tipoCuenta,$CuentaContable_idCuentaContable)
	{
		session_start();
		$usuario = $_SESSION['login'];
		$sql="INSERT INTO cuentabancaria (`Moneda_idMoneda`,`Banco_idBanco`,`descripcion`,`tipoCuenta`,`CuentaContable_idCuentaContable`,`usuarioInsercion`,`fechaInsercion`,`inactivo`) VALUES ('$Moneda_idMoneda','$Banco_idBanco','$descripcion','$tipoCuenta','$CuentaContable_idCuentaContable','$usuario',now(),0)";
		return ejecutarConsulta($sql);         
	}

	//Implementamos un método para editar registros
	public function editar($idCuentaBancaria,$Moneda_idMoneda,$Banco_idBanco,$descripcion,$tipoCuenta,$CuentaContable_idCuentaContable)
	{ 
		session_start(); 
		$usuario = $_SESSION['login']; 
		$sql="UPDATE `cuentabancaria` SET descripcion='$descripcion',fechaModificacion= now(), usuarioModificacion = '$usuario', Moneda_idMoneda = '$Moneda_idMoneda' , CuentaContable_idCuentaContable= '$CuentaContable_idCuentaContable' , Banco_idBanco= '$Banco_idBanco', tipoCuenta= '$tipoCuenta' WHERE idCuentaBancaria='$idCuentaBancaria'";
		return ejecutarConsulta($sql);    
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idCuentaBancaria)
	{
		$sql="UPDATE cuentabancaria SET inactivo=1 WHERE idCuentaBancaria='$idCuentaBancaria'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idCuentaBancaria)
	{
		$sql="UPDATE cuentabancaria SET inactivo=0 WHERE idCuentaBancaria='$idCuentaBancaria'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idCuentaBancaria)
	{
		$sql="SELECT * FROM cuentabancaria WHERE idCuentaBancaria='$idCuentaBancaria'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT cuentabancaria.idCuentaBancaria,cuentabancaria.descripcion,moneda.descripcion as moneda, cuentacontable.descripcion as cuentacontable,banco.descripcion as banco,cuentabancaria.tipoCuenta,cuentabancaria.inactivo
			FROM cuentabancaria, moneda, cuentacontable,banco
			where cuentabancaria.Moneda_idMoneda = moneda.idMoneda and cuentabancaria.CuentaContable_idCuentaContable = cuentacontable.idCuentaContable 
  			and cuentabancaria.Banco_idBanco = banco.idBanco";
		return ejecutarConsulta($sql);	 	 
	}
	//Implementar un método para listar los registros y mostrar en el select   
	public function select()
	{
		$sql="SELECT * FROM cuentabancaria where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>