<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Estado
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
		$sql="INSERT INTO estado (descripcion, usuarioIns, inactivo, fechaIns) VALUES ('$descripcion','$usuario',0,now())";
		return ejecutarConsulta($sql);        
	}

	//Implementamos un método para editar registros
	public function editar($idEstado, $descripcion)
	{
		session_start();
		$usuario = $_SESSION['login']; 
		$sql="UPDATE `estado` SET descripcion='$descripcion',fechaMod= now(), usuarioMod = '$usuario' WHERE idEstado='$idEstado'";
		return ejecutarConsulta($sql);   
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idEstado)
	{
		$sql="UPDATE estado SET inactivo=1 WHERE idEstado='$idEstado'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idEstado)
	{
		$sql="UPDATE estado SET inactivo=0 WHERE idEstado='$idEstado'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idEstado)
	{
		$sql="SELECT * FROM estado WHERE idEstado='$idEstado'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM estado";
		return ejecutarConsulta($sql);		
	}
	
	//Implementar un método para listar los registros y mostrar en el select
	public function selectEstado()
	{
		$sql="SELECT * FROM estado where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>