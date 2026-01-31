<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class TipoPersona
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($descripcion)
	{
		$sql="INSERT INTO tipopersona ( descripcion, inactivo)
		VALUES ( '$descripcion',0)";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idTipoPersona,$descripcion)
	{
		$sql="UPDATE tipopersona SET =descripcion='$descripcion' WHERE idTipoPersona='$idTipoPersona'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idTipoPersona)
	{
		$sql="UPDATE tipopersona SET inactivo=1 WHERE idTipoPersona='$idTipoPersona'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idTipoPersona)
	{
		$sql="UPDATE tipopersona SET inactivo=0 WHERE idTipoPersona='$idTipoPersona'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idTipoPersona)
	{
		$sql="SELECT * FROM tipopersona WHERE idTipoPersona='$idTipoPersona'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM tipopersona";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM tipopersona where inactivo=0";
		return ejecutarConsulta($sql);		
	}
	public function selectTipoPersona()
	{
		$sql="SELECT * FROM tipopersona where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>