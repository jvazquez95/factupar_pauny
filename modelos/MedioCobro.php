<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class MedioCobro
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
		$sql="INSERT INTO mediocobro ( descripcion, inactivo, fechaInsercion, usuarioInsercion)
		VALUES ('$descripcion',0, now(),'$usuario')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idMedioCobro,$descripcion)
	{
		session_start();	
		$usuario = $_SESSION['login'];
		$sql="UPDATE mediocobro 
			SET 
			descripcion='$descripcion',
			usuarioModificacion = '$usuario', 
			fechaModificacion=now() 
			WHERE idMedioCobro='$idMedioCobro'";

		return ejecutarConsulta($sql);
	}
 
	//Implementamos un método para desactivar categorías
	public function desactivar($idMedioCobro)
	{
		$sql="UPDATE mediocobro SET inactivo=1 WHERE idMedioCobro='$idMedioCobro'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idMedioCobro)
	{
		$sql="UPDATE mediocobro SET inactivo=0 WHERE idMedioCobro='$idMedioCobro'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idMedioCobro)
	{
		$sql="SELECT * FROM mediocobro WHERE idMedioCobro='$idMedioCobro'";
		return ejecutarConsultaSimpleFila($sql); 
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT *
		      FROM mediocobro";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function selectMedioCobro()
	{
		$sql="SELECT * FROM mediocobro where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>