<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Copia
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($descripcion,$Proceso_idProceso) 
	{
		session_start();
		$usuario = $_SESSION['login'];
		$sql="INSERT INTO copia (descripcion,Proceso_idProceso, usuarioInsercion, inactivo, fechaInsercion ) VALUES ('$descripcion','$Proceso_idProceso','$usuario',0,now() )";
		return ejecutarConsulta($sql);        
	}

	//Implementamos un método para editar registros
	public function editar($idCopia,$descripcion,$Proceso_idProceso)
	{
		session_start();
		$usuario = $_SESSION['login'];  
		$sql="UPDATE `copia` SET descripcion='$descripcion', Proceso_idProceso= '$Proceso_idProceso',fechaModificacion= now(), usuarioModificacion = '$usuario' WHERE idCopia='$idCopia'";
		return ejecutarConsulta($sql);   
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idCopia)
	{
		$sql="UPDATE copia SET inactivo=1 WHERE idCopia='$idCopia'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idCopia)
	{
		$sql="UPDATE copia SET inactivo=0 WHERE idCopia='$idCopia'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idCopia)
	{
		$sql="SELECT * FROM copia WHERE idCopia='$idCopia'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT copia.idCopia,copia.descripcion,proceso.ano as Proceso,copia.inactivo
			  FROM copia, proceso
			  where copia.Proceso_idProceso = proceso.idProceso";
		return ejecutarConsulta($sql);	 	 
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM copia where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>