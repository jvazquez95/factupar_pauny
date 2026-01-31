<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Contrasena
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($prioridad,$contrasena,$Proceso_idProceso) 
	{
		session_start();
		$usuario = $_SESSION['login'];
		$sql="INSERT INTO contrasena (prioridad,contrasena,Proceso_idProceso, usuarioInsercion, inactivo, fechaInsercion ) VALUES ('$prioridad','$contrasena','$Proceso_idProceso','$usuario',0,now() )";
		return ejecutarConsulta($sql);        
	}

	//Implementamos un método para editar registros
	public function editar($idContrasena,$prioridad,$contrasena,$Proceso_idProceso)
	{
		session_start();
		$usuario = $_SESSION['login']; 
		$sql="UPDATE `contrasena` SET contrasena='$contrasena', prioridad = '$prioridad' , Proceso_idProceso= '$Proceso_idProceso',fechaModificacion= now(), usuarioModificacion = '$usuario' WHERE idContrasena='$idContrasena'";
		return ejecutarConsulta($sql);   
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idContrasena)
	{
		$sql="UPDATE contrasena SET inactivo=1 WHERE idContrasena='$idContrasena'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idContrasena)
	{
		$sql="UPDATE contrasena SET inactivo=0 WHERE idContrasena='$idContrasena'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idContrasena)
	{
		$sql="SELECT * FROM contrasena WHERE idContrasena='$idContrasena'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT contrasena.idContrasena,proceso.ano as Proceso,contrasena.prioridad,contrasena.inactivo
			  FROM contrasena, proceso
			  where contrasena.Proceso_idProceso = proceso.idProceso";
		return ejecutarConsulta($sql);	 	 
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM contrasena where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>