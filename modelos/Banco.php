<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Banco
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($descripcion,$Moneda_idMoneda,$CuentaContable_idCuentaContable,$nroCuenta,$tipoCuenta)
	{
		session_start();
		$usuario = $_SESSION['login'];
		$sql="INSERT INTO banco (descripcion, usuarioInsercion, Moneda_idMoneda, CuentaContable_idCuentaContable, inactivo, fechaInsercion, nroCuenta, tipoCuenta ) VALUES ('$descripcion','$usuario','$Moneda_idMoneda','$CuentaContable_idCuentaContable',0,now(), '$nroCuenta', '$tipoCuenta')";
		return ejecutarConsulta($sql);        
	}

	//Implementamos un método para editar registros
	public function editar($idBanco, $descripcion,$Moneda_idMoneda,$CuentaContable_idCuentaContable,$nroCuenta,$tipoCuenta)
	{
		session_start();
		$usuario = $_SESSION['login']; 
		$sql="UPDATE `banco` SET descripcion='$descripcion',fechaModificacion= now(), usuarioModificacion = '$usuario', Moneda_idMoneda = '$Moneda_idMoneda' , CuentaContable_idCuentaContable= '$CuentaContable_idCuentaContable' , nroCuenta= '$nroCuenta', tipoCuenta= '$tipoCuenta' WHERE idBanco='$idBanco'";
		return ejecutarConsulta($sql);   
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idBanco)
	{
		$sql="UPDATE banco SET inactivo=1 WHERE idBanco='$idBanco'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idBanco)
	{
		$sql="UPDATE banco SET inactivo=0 WHERE idBanco='$idBanco'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idBanco)
	{
		$sql="SELECT * FROM banco WHERE idBanco='$idBanco'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT banco.idBanco,banco.descripcion,moneda.descripcion as moneda,cuentacontable.descripcion as cuentacontable,nroCuenta,banco.tipoCuenta,banco.inactivo
			  FROM banco, moneda, cuentacontable
			  where banco.Moneda_idMoneda = moneda.idMoneda and cuentacontable.idCuentaContable = banco.CuentaContable_idCuentaContable";
		return ejecutarConsulta($sql);	 	 
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function selectBanco()
	{
		$sql="SELECT * FROM banco where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>