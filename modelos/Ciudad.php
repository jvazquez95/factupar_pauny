<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Ciudad
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($descripcion,$Pais_idPais)
	{
		session_start();	
		$usuario = $_SESSION['login'];
		$sql="INSERT INTO ciudad ( descripcion, inactivo, fechaInsercion, usuarioInsercion, Pais_idPais)
		VALUES ('$descripcion',0, now(),'$usuario','$Pais_idPais')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idCiudad,$descripcion,$Pais_idPais)
	{
		session_start();	
		$usuario = $_SESSION['login'];
		$sql="UPDATE ciudad SET descripcion='$descripcion', Pais_idPais='$Pais_idPais', usuarioModificacion = '$usuario', fechaModificacion=now() WHERE idCiudad='$idCiudad'";
		return ejecutarConsulta($sql);
	}
 
	//Implementamos un método para desactivar categorías
	public function desactivar($idCiudad)
	{
		$sql="UPDATE ciudad SET inactivo=1 WHERE idCiudad='$idCiudad'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idCiudad)
	{
		$sql="UPDATE ciudad SET inactivo=0 WHERE idCiudad='$idCiudad'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idCiudad)
	{
		$sql="SELECT * FROM ciudad WHERE idCiudad='$idCiudad'";
		return ejecutarConsultaSimpleFila($sql); 
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT a.idCiudad,a.descripcion,b.nombre as Pais_idPais,a.inactivo
		      FROM ciudad a LEFT OUTER JOIN paises b 
			  on a.Pais_idPais=b.idPais";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function selectCiudad()
	{
		$sql="SELECT * FROM ciudad where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>