<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Profesion
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
		$sql="INSERT INTO profesion ( descripcion, inactivo, fechaInsercion, usuarioInsercion)
		VALUES ('$descripcion',0, now(),'$usuario')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idProfesion,$descripcion)
	{
		session_start();	
		$usuario = $_SESSION['login'];
		$sql="UPDATE profesion 
			SET 
			descripcion='$descripcion',
			usuarioModificacion = '$usuario', 
			fechaModificacion=now() 
			WHERE idProfesion='$idProfesion'";

		return ejecutarConsulta($sql);
	}
 
	//Implementamos un método para desactivar categorías
	public function desactivar($idProfesion)
	{
		$sql="UPDATE profesion SET inactivo=1 WHERE idProfesion='$idProfesion'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idProfesion)
	{
		$sql="UPDATE profesion SET inactivo=0 WHERE idProfesion='$idProfesion'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idProfesion)
	{
		$sql="SELECT * FROM profesion WHERE idProfesion='$idProfesion'";
		return ejecutarConsultaSimpleFila($sql); 
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT *
		      FROM profesion";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function selectProfesion()
	{
		$sql="SELECT * FROM profesion where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>