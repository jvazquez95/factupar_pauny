<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class GrupoArticulo
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre)
	{
		$sql="INSERT INTO grupoarticulo (nombre,inactivo)
		VALUES ('$nombre',0)";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idGrupoArticulo,$nombre)
	{
		$sql="UPDATE grupoarticulo SET nombre='$nombre' WHERE idGrupoArticulo='$idGrupoArticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idGrupoArticulo)
	{
		$sql="UPDATE grupoarticulo SET inactivo=1 WHERE idGrupoArticulo='$idGrupoArticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idGrupoArticulo)
	{
		$sql="UPDATE grupoarticulo SET inactivo=0 WHERE idGrupoArticulo='$idGrupoArticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idGrupoArticulo)
	{
		$sql="SELECT * FROM grupoarticulo WHERE idGrupoArticulo='$idGrupoArticulo'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM grupoarticulo";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM grupoarticulo where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>