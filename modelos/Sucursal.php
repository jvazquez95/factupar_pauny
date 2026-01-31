<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Sucursal
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre, $direccion = '', $telefono = '', $correo = '', $ciudad = '')
	{
		$sql = "INSERT INTO sucursal (nombre, direccion, telefono, correo, ciudad) VALUES ('$nombre', " .
			(($direccion === null || $direccion === '') ? "NULL" : "'$direccion'") . ", " .
			(($telefono === null || $telefono === '') ? "NULL" : "'$telefono'") . ", " .
			(($correo === null || $correo === '') ? "NULL" : "'$correo'") . ", " .
			(($ciudad === null || $ciudad === '') ? "NULL" : "'$ciudad'") . ")";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idSucursal, $nombre, $direccion = '', $telefono = '', $correo = '', $ciudad = '')
	{
		$sql = "UPDATE sucursal SET nombre='$nombre', direccion=" .
			(($direccion === null || $direccion === '') ? "NULL" : "'$direccion'") . ", telefono=" .
			(($telefono === null || $telefono === '') ? "NULL" : "'$telefono'") . ", correo=" .
			(($correo === null || $correo === '') ? "NULL" : "'$correo'") . ", ciudad=" .
			(($ciudad === null || $ciudad === '') ? "NULL" : "'$ciudad'") . ", fechaModificacion=NOW() WHERE idSucursal='$idSucursal'";
		return ejecutarConsulta($sql);
	}


	//Implementamos un método para desactivar categorías
	public function desactivar($idSucursal)
	{
		$sql="UPDATE sucursal SET inactivo=1 WHERE idSucursal='$idSucursal'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idSucursal)
	{
		$sql="UPDATE sucursal SET inactivo=0 WHERE idSucursal='$idSucursal'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idSucursal)
	{
		$sql="SELECT * FROM sucursal WHERE idSucursal='$idSucursal'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM sucursal";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function selectSucursal()
	{
		$sql="SELECT * FROM sucursal where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>