<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Categoria
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre,$Categoria_idCategoria)
	{
		$sql="INSERT INTO categoria (nombre,Categoria_idCategoria)
		VALUES ('$nombre','$Categoria_idCategoria')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idCategoria,$nombre,$Categoria_idCategoria)
	{
		$sql="UPDATE categoria SET nombre='$nombre',Categoria_idCategoria='$Categoria_idCategoria' WHERE idCategoria='$idCategoria'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idCategoria)
	{
		$sql="UPDATE categoria SET inactivo=1 WHERE idCategoria='$idCategoria'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idCategoria)
	{
		$sql="UPDATE categoria SET inactivo=0 WHERE idCategoria='$idCategoria'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idCategoria)
	{
		$sql="SELECT * FROM categoria WHERE idCategoria='$idCategoria'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM categoria";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		// Categorías "padre" (nivel 1). Las hijas se obtienen con selectDetCat().
		// En la BD se usa Categoria_idCategoria = 0 (o NULL) para indicar que es padre.
		$sql="SELECT * FROM categoria where inactivo=0 AND (Categoria_idCategoria = 0 OR Categoria_idCategoria IS NULL)";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function selectDetCat($Categoria_idCategoria)
	{
		$sql="SELECT * FROM categoria where inactivo=0 and Categoria_idCategoria='$Categoria_idCategoria'";
		return ejecutarConsulta($sql);		 
	}		
}

?>