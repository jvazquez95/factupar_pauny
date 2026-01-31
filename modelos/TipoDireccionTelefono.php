<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class TipoDireccionTelefono
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($descripcion, $tipo)
	{
		$sql="INSERT INTO tipodireccion_telefono (descripcion, tipo, inactivo)
		VALUES ('$descripcion', '$tipo',0)";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idTipoDireccion_Telefono,$descripcion,$tipo)
	{
		$sql="UPDATE tipodireccion_telefono SET descripcion='$descripcion',tipo='$tipo' WHERE idTipoDireccion_Telefono='$idTipoDireccion_Telefono'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idTipoDireccion_Telefono)
	{
		$sql="UPDATE tipodireccion_telefono SET inactivo=1 WHERE idTipoDireccion_Telefono='$idTipoDireccion_Telefono'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idTipoDireccion_Telefono)
	{
		$sql="UPDATE tipodireccion_telefono SET inactivo=0 WHERE idTipoDireccion_Telefono='$idTipoDireccion_Telefono'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idTipoDireccion_Telefono)
	{
		$sql="SELECT * FROM tipodireccion_telefono WHERE idTipoDireccion_Telefono='$idTipoDireccion_Telefono'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM tipodireccion_telefono";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function selectTipoDireccionTelefono()
	{
		$sql="SELECT * FROM tipodireccion_telefono where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>