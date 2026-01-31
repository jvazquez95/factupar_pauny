<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Moneda
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($descripcion)
	{
		$sql="INSERT INTO `moneda`(`descripcion`, `inactivo`) VALUES ('$descripcion', 0)";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idMoneda, $descripcion)
	{
		$sql="UPDATE `moneda` SET `descripcion`='$descripcion',`fechaModificacion`= now() WHERE `idMoneda`='$idMoneda'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idMoneda)
	{
		$sql="UPDATE moneda SET inactivo=1 WHERE idMoneda='$idMoneda'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idMoneda)
	{
		$sql="UPDATE moneda SET inactivo=0 WHERE idMoneda='$idMoneda'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idMoneda)
	{
		$sql="SELECT * FROM moneda WHERE idMoneda='$idMoneda'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM moneda";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM moneda where inactivo=0";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function selectCotizacion()
	{
		$sql="SELECT * FROM moneda where inactivo=0";
		return ejecutarConsulta($sql);		
	}

}

?>