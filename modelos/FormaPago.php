<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class FormaPago
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($descripcion, $tipo, $CuentaContable_idCuentaContable)
	{


		$usuario = $_SESSION['login'];
		$sql="INSERT INTO formapago ( descripcion, tipo, usuarioInsercion, CuentaContable_idCuentaContable)
		VALUES ('$descripcion','$tipo' ,'$usuario', '$CuentaContable_idCuentaContable')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idFormaPago,$descripcion, $tipo, $CuentaContable_idCuentaContable)
	{
		$usuario = $_SESSION['login'];
		$sql="UPDATE formapago SET descripcion='$descripcion', tipo='$tipo', usuarioModificacion = '$usuario',  CuentaContable_idCuentaContable = '$CuentaContable_idCuentaContable' WHERE idFormaPago='$idFormaPago'";
		return ejecutarConsulta($sql);
	}


	//Implementamos un método para desactivar categorías
	public function desactivar($idFormaPago)
	{
		$sql="UPDATE formapago SET inactivo=1 WHERE idFormaPago='$idFormaPago'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idFormaPago)
	{
		$sql="UPDATE formapago SET inactivo=0 WHERE idFormaPago='$idFormaPago'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idFormaPago)
	{
		$sql="SELECT * FROM formapago WHERE idFormaPago='$idFormaPago'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * from formapago";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function selectFormaPago()
	{
		$sql="SELECT * FROM formapago where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>