<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class TipoContrato
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
		$sql="INSERT INTO tipocontrato ( descripcion, inactivo, fechaInsercion, usuarioInsercion)
		VALUES ('$descripcion',0, now(),'$usuario')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idTipoContrato,$descripcion)
	{
		session_start();	
		$usuario = $_SESSION['login'];
		$sql="UPDATE tipocontrato 
			SET 
			descripcion='$descripcion',
			usuarioModificacion = '$usuario', 
			fechaModificacion=now() 
			WHERE idTipoContrato='$idTipoContrato'";

		return ejecutarConsulta($sql);
	}
 
	//Implementamos un método para desactivar categorías
	public function desactivar($idTipoContrato)
	{
		$sql="UPDATE tipocontrato SET inactivo=1 WHERE idTipoContrato='$idTipoContrato'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idTipoContrato)
	{
		$sql="UPDATE tipocontrato SET inactivo=0 WHERE idTipoContrato='$idTipoContrato'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idTipoContrato)
	{
		$sql="SELECT * FROM tipocontrato WHERE idTipoContrato='$idTipoContrato'";
		return ejecutarConsultaSimpleFila($sql); 
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT *
		      FROM tipocontrato";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function selectTipoContrato()
	{
		$sql="SELECT * FROM tipocontrato where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>