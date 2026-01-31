<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class TipoSalario
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
		$sql="INSERT INTO tiposalario ( descripcion, inactivo, fechaInsercion, usuarioInsercion)
		VALUES ('$descripcion',0, now(),'$usuario')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idTipoSalario,$descripcion)
	{
		session_start();	
		$usuario = $_SESSION['login'];
		$sql="UPDATE tiposalario 
			SET 
			descripcion='$descripcion',
			usuarioModificacion = '$usuario', 
			fechaModificacion=now() 
			WHERE idTipoSalario='$idTipoSalario'";

		return ejecutarConsulta($sql);
	}
 
	//Implementamos un método para desactivar categorías
	public function desactivar($idTipoSalario)
	{
		$sql="UPDATE tiposalario SET inactivo=1 WHERE idTipoSalario='$idTipoSalario'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idTipoSalario)
	{
		$sql="UPDATE tiposalario SET inactivo=0 WHERE idTipoSalario='$idTipoSalario'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idTipoSalario)
	{
		$sql="SELECT * FROM tiposalario WHERE idTipoSalario='$idTipoSalario'";
		return ejecutarConsultaSimpleFila($sql); 
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT *
		      FROM tiposalario";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function selectTipoSalario()
	{
		$sql="SELECT * FROM tiposalario where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>