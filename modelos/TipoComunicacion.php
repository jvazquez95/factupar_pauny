<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class TipoComunicacion
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
		$sql="INSERT INTO tipocomunicacion ( descripcion, inactivo, fechaInsercion, usuarioInsercion)
		VALUES ('$descripcion',0, now(),'$usuario')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idTipoComunicacion,$descripcion)
	{
		session_start();	
		$usuario = $_SESSION['login'];
		$sql="UPDATE tipocomunicacion 
			SET 
			descripcion='$descripcion',
			usuarioModificacion = '$usuario', 
			fechaModificacion=now() 
			WHERE idTipoComunicacion='$idTipoComunicacion'";

		return ejecutarConsulta($sql);
	}
 
	//Implementamos un método para desactivar categorías
	public function desactivar($idTipoComunicacion)
	{
		$sql="UPDATE tipocomunicacion SET inactivo=1 WHERE idTipoComunicacion='$idTipoComunicacion'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idTipoComunicacion)
	{
		$sql="UPDATE tipocomunicacion SET inactivo=0 WHERE idTipoComunicacion='$idTipoComunicacion'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idTipoComunicacion)
	{
		$sql="SELECT * FROM tipocomunicacion WHERE idTipoComunicacion='$idTipoComunicacion'";
		return ejecutarConsultaSimpleFila($sql); 
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT *
		      FROM tipocomunicacion";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function selectTipoComunicacion()
	{
		$sql="SELECT * FROM tipocomunicacion where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>