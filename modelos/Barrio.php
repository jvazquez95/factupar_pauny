<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Barrio
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($descripcion, $Ciudad_idCiudad)
	{


		$usuario = $_SESSION['login'];
		$sql="INSERT INTO barrio ( descripcion, Ciudad_idCiudad, usuarioInsercion )
		VALUES ('$descripcion','$Ciudad_idCiudad' ,'$usuario')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idBarrio,$descripcion, $Ciudad_idCiudad)
	{
		$usuario = $_SESSION['login'];
		$sql="UPDATE barrio SET descripcion='$descripcion', Ciudad_idCiudad='$Ciudad_idCiudad', usuarioModificacion = '$usuario' WHERE idBarrio='$idBarrio'";
		return ejecutarConsulta($sql);
	}


	//Implementamos un método para desactivar categorías
	public function desactivar($idBarrio)
	{
		$sql="UPDATE barrio SET inactivo=1 WHERE idBarrio='$idBarrio'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idBarrio)
	{
		$sql="UPDATE barrio SET inactivo=0 WHERE idBarrio='$idBarrio'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idBarrio)
	{
		$sql="SELECT * FROM barrio WHERE idBarrio='$idBarrio'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT *, ciudad.descripcion as nc, barrio.descripcion as nb, barrio.inactivo as bi FROM barrio, ciudad where ciudad.idCiudad = barrio.Ciudad_idCiudad";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function selectBarrio()
	{
		$sql="SELECT * FROM barrio where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>