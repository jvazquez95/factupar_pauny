<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Clase
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($descripcion)
	{
		session_start();	
		$usuario = $_SESSION['login'];
		$sql="INSERT INTO clase ( descripcion, inactivo, fechaInsercion, usuarioInsercion)
		VALUES ('$descripcion',0, now(),'$usuario')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idClase,$descripcion)
	{
		session_start();	
		$usuario = $_SESSION['login'];
		$sql="UPDATE clase 
			SET 
			descripcion='$descripcion',
			usuarioModificacion = '$usuario', 
			fechaModificacion=now() 
			WHERE idClase='$idClase'";

		return ejecutarConsulta($sql);
	}
 
	//Implementamos un método para desactivar categorías
	public function desactivar($idClase)
	{
		$sql="UPDATE clase SET inactivo=1 WHERE idClase='$idClase'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idClase)
	{
		$sql="UPDATE clase SET inactivo=0 WHERE idClase='$idClase'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idClase)
	{
		$sql="SELECT * FROM clase WHERE idClase='$idClase'";
		return ejecutarConsultaSimpleFila($sql); 
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT *
		      FROM clase";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function selectClase()
	{
		$sql="SELECT * FROM clase where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>