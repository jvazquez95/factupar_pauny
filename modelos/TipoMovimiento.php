<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class TipoMovimiento
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
		$sql="INSERT INTO tipomovimiento ( descripcion, inactivo, fechaInsercion, usuarioInsercion)
		VALUES ('$descripcion',0, now(),'$usuario')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idTipoMovimiento,$descripcion)
	{
		session_start();	
		$usuario = $_SESSION['login'];
		$sql="UPDATE tipomovimiento 
			SET 
			descripcion='$descripcion',
			usuarioModificacion = '$usuario', 
			fechaModificacion=now() 
			WHERE idTipoMovimiento='$idTipoMovimiento'";

		return ejecutarConsulta($sql);
	}
 
	//Implementamos un método para desactivar categorías
	public function desactivar($idTipoMovimiento)
	{
		$sql="UPDATE tipomovimiento SET inactivo=1 WHERE idTipoMovimiento='$idTipoMovimiento'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idTipoMovimiento)
	{
		$sql="UPDATE tipomovimiento SET inactivo=0 WHERE idTipoMovimiento='$idTipoMovimiento'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idTipoMovimiento)
	{
		$sql="SELECT * FROM tipomovimiento WHERE idTipoMovimiento='$idTipoMovimiento'";
		return ejecutarConsultaSimpleFila($sql); 
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT *
		      FROM tipomovimiento";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function selectTipoMovimiento()
	{
		$sql="SELECT * FROM tipomovimiento where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>