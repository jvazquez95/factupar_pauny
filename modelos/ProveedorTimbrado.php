<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class ProveedorTimbrado
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($Persona_idPersona, $timbrado, $vtoTimbrado)
	{

		session_start();
		$usuario = $_SESSION['login'];
		$sql="INSERT INTO proveedortimbrado ( Persona_idPersona, timbrado, vtoTimbrado, usuarioInsercion, fechaInsercion )
		VALUES ('$Persona_idPersona','$timbrado' ,'$vtoTimbrado', '$usuario', now())";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idProveedorTimbrado,$Persona_idPersona, $timbrado, $vtoTimbrado)
	{
		session_start();
		$usuario = $_SESSION['login'];
		$sql="UPDATE proveedortimbrado SET Persona_idPersona='$Persona_idPersona', timbrado='$timbrado', vtoTimbrado = '$vtoTimbrado', usuarioModificacion = '$usuario', fechaModificacion = now() WHERE idProveedorTimbrado='$idProveedorTimbrado'";
		return ejecutarConsulta($sql);
	}


	//Implementamos un método para desactivar categorías
	public function desactivar($idProveedorTimbrado)
	{
		$sql="UPDATE proveedortimbrado SET inactivo=1 WHERE idProveedorTimbrado='$idProveedorTimbrado'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idProveedorTimbrado)
	{
		$sql="UPDATE proveedortimbrado SET inactivo=0 WHERE idProveedorTimbrado='$idProveedorTimbrado'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idProveedorTimbrado)
	{
		$sql="SELECT * FROM proveedortimbrado WHERE idProveedorTimbrado='$idProveedorTimbrado'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT *, F_NOMBRE_PERSONA(Persona_idPersona) AS np from proveedortimbrado";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function selectTimbradoProveedor($id)
	{
		$sql="SELECT * FROM proveedortimbrado where inactivo=0 and Persona_idPersona = '$id'";
		return ejecutarConsulta($sql);		
	}



	//Implementar un método para listar los registros y mostrar en el select
	public function selectproveedortimbrado()
	{
		$sql="SELECT * FROM proveedortimbrado where inactivo=0";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function vencimientoTimbrado($idProveedorTimbrado)
	{
		$sql="SELECT  vtoTimbrado from proveedortimbrado where idProveedorTimbrado = '$idProveedorTimbrado'";


		return ejecutarConsultaSimpleFila($sql);
	}




}

?>