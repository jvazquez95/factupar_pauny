<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Marca
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($descripcion,$origen,$tipoMarca,$imagen)
	{
		session_start();
		$usuario = $_SESSION['login'];
		$sql="INSERT INTO marca ( descripcion,origen ,tipoMarca ,imagen , inactivo )
		VALUES ('$descripcion','$origen' , '$tipoMarca','$imagen', '0')";
		return ejecutarConsulta($sql); 
	}

	//Implementamos un método para editar registros
	public function editar($idMarca,$descripcion,$origen,$tipoMarca,$imagen)
	{
		session_start();
		$usuario = $_SESSION['login'];
		$sql="UPDATE marca SET descripcion='$descripcion', fechaModificacion = now(), usuarioModificacion = '$usuario' , origen='$origen' , tipoMarca = '$tipoMarca' , imagen='$imagen' WHERE idMarca='$idMarca'";
		return ejecutarConsulta($sql);  
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idMarca)
	{
		$sql="UPDATE marca SET inactivo=1 WHERE idMarca='$idMarca'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idMarca)
	{
		$sql="UPDATE marca SET inactivo=0 WHERE idMarca='$idMarca'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idMarca)
	{
		$sql="SELECT * FROM marca WHERE idMarca='$idMarca'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM marca";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros
	public function listarMarcaVehiculo()
	{
		$sql="SELECT * FROM marca where tipoMarca='vehiculo'";
		return ejecutarConsulta($sql);		
	}	
	//Implementar un método para listar los registros y mostrar en el select
	public function selectmarca()
	{
		$sql="SELECT * FROM marca where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>