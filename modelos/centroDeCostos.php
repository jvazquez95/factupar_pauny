<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class CentroDeCostos
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
		$sql="INSERT INTO `centrocosto`(`descripcion`, `inactivo`, `usuarioInsercion`, `fechaInsercion`) VALUES ('$descripcion', 0,'$usuario', now())";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idCentroCosto, $descripcion)
	{
		session_start();
		$usuario = $_SESSION['login']; 			
		$sql="UPDATE `centrocosto` SET `descripcion`='$descripcion',`fechaModificacion`= now() , usuarioModificacion ='$usuario' WHERE `idCentroCosto`='$idCentroCosto'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idCentroCosto)
	{
		$sql="UPDATE centrocosto SET inactivo=1 WHERE idCentroCosto='$idCentroCosto'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idCentroCosto)
	{
		$sql="UPDATE centrocosto SET inactivo=0 WHERE idCentroCosto='$idCentroCosto'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idCentroCosto)
	{
		$sql="SELECT * FROM centrocosto WHERE idCentroCosto='$idCentroCosto'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM centrocosto"; 
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM centrocosto where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>