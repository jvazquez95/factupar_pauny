<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class TipoLiquidacion
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
		$sql="INSERT INTO tipoliquidacion ( descripcion, inactivo, fechaInsercion, usuarioInsercion)
		VALUES ('$descripcion',0, now(),'$usuario')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idtipoliquidacion,$descripcion)
	{
		session_start();	
		$usuario = $_SESSION['login'];
		$sql="UPDATE tipoliquidacion 
			SET 
			descripcion='$descripcion',
			usuarioModificacion = '$usuario', 
			fechaModificacion=now() 
			WHERE idtipoliquidacion='$idtipoliquidacion'";

		return ejecutarConsulta($sql);
	}
 
	//Implementamos un método para desactivar categorías
	public function desactivar($idtipoliquidacion)
	{
		$sql="UPDATE tipoliquidacion SET inactivo=1 WHERE idtipoliquidacion='$idtipoliquidacion'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idtipoliquidacion)
	{
		$sql="UPDATE tipoliquidacion SET inactivo=0 WHERE idtipoliquidacion='$idtipoliquidacion'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idtipoliquidacion)
	{
		$sql="SELECT * FROM tipoliquidacion WHERE idtipoliquidacion='$idtipoliquidacion'";
		return ejecutarConsultaSimpleFila($sql); 
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT *
		      FROM tipoliquidacion";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function selectTipoLiquidacion()
	{
		$sql="SELECT * FROM tipoliquidacion where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>