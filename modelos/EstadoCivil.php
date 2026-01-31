<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class EstadoCivil
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
		$sql="INSERT INTO estadocivil ( descripcion, inactivo, fechaInsercion, usuarioInsercion)
		VALUES ('$descripcion',0, now(),'$usuario')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idEstadoCivil,$descripcion)
	{
		session_start();	
		$usuario = $_SESSION['login'];
		$sql="UPDATE estadocivil 
			SET 
			descripcion='$descripcion',
			usuarioModificacion = '$usuario', 
			fechaModificacion=now() 
			WHERE idEstadoCivil='$idEstadoCivil'";

		return ejecutarConsulta($sql);
	}
 
	//Implementamos un método para desactivar categorías
	public function desactivar($idEstadoCivil)
	{
		$sql="UPDATE estadocivil SET inactivo=1 WHERE idEstadoCivil='$idEstadoCivil'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idEstadoCivil)
	{
		$sql="UPDATE estadocivil SET inactivo=0 WHERE idEstadoCivil='$idEstadoCivil'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idEstadoCivil)
	{
		$sql="SELECT * FROM estadocivil WHERE idEstadoCivil='$idEstadoCivil'";
		return ejecutarConsultaSimpleFila($sql); 
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT *
		      FROM estadocivil";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function selectEstadoCivil()
	{
		$sql="SELECT * FROM estadocivil where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>