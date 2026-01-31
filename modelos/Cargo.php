<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Cargo
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
		$sql="INSERT INTO cargo ( descripcion, inactivo, fechaInsercion, usuarioInsercion)
		VALUES ('$descripcion',0, now(),'$usuario')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idCargo,$descripcion)
	{
		session_start();	
		$usuario = $_SESSION['login'];
		$sql="UPDATE cargo 
			SET 
			descripcion='$descripcion',
			usuarioModificacion = '$usuario', 
			fechaModificacion=now() 
			WHERE idCargo='$idCargo'";

		return ejecutarConsulta($sql);
	}
 
	//Implementamos un método para desactivar categorías
	public function desactivar($idCargo)
	{
		$sql="UPDATE cargo SET inactivo=1 WHERE idCargo='$idCargo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idCargo)
	{
		$sql="UPDATE cargo SET inactivo=0 WHERE idCargo='$idCargo'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idCargo)
	{
		$sql="SELECT * FROM cargo WHERE idCargo='$idCargo'";
		return ejecutarConsultaSimpleFila($sql); 
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT *
		      FROM cargo";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function selectCargo()
	{
		$sql="SELECT * FROM cargo where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>