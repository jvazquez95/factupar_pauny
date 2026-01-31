<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Unidad
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($descripcion, $cantidad)
	{
		$sql="INSERT INTO unidad (descripcion,inactivo, cantidad)
		VALUES ('$descripcion', 0, '$cantidad')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idUnidad,$descripcion, $cantidad)
	{
		$sql="UPDATE unidad SET descripcion='$descripcion', cantidad = '$cantidad' WHERE idUnidad='$idUnidad'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idUnidad)
	{
		$sql="UPDATE unidad SET inactivo=1 WHERE idUnidad='$idUnidad'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idUnidad)
	{
		$sql="UPDATE unidad SET inactivo=0 WHERE idUnidad='$idUnidad'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idUnidad)
	{
		$sql="SELECT * FROM unidad WHERE idUnidad='$idUnidad'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM unidad";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM unidad where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>