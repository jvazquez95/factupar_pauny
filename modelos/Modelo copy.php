<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Modelo
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($descripcion,$Marca_idMarca)
	{
		session_start();	
		$usuario = $_SESSION['login'];
		$sql="INSERT INTO modelo ( descripcion, inactivo, Marca_idMarca)
		VALUES ('$descripcion',0,'$Marca_idMarca')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idModelo,$descripcion,$Marca_idMarca)
	{
		session_start();	
		$usuario = $_SESSION['login'];
		$sql="UPDATE modelo SET descripcion='$descripcion', Marca_idMarca='$Marca_idMarca', fechaModificacion=now() WHERE idModelo='$idModelo'";
		return ejecutarConsulta($sql);
	} 
 
	//Implementamos un método para desactivar categorías
	public function desactivar($idModelo)
	{
		$sql="UPDATE modelo SET inactivo=1 WHERE idModelo='$idModelo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idModelo)
	{
		$sql="UPDATE modelo SET inactivo=0 WHERE idModelo='$idModelo'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idModelo)
	{
		$sql="SELECT * FROM modelo WHERE idModelo='$idModelo'";
		return ejecutarConsultaSimpleFila($sql); 
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT a.idModelo,a.descripcion,b.descripcion as Marca_idMarca,a.inactivo
		      FROM modelo a LEFT OUTER JOIN marca b 
			  on a.Marca_idMarca=b.idMarca";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function selectMarca()
	{
		$sql="SELECT * FROM marca where inactivo=0";
		return ejecutarConsulta($sql);		
	}
	
	//Implementar un método para listar los registros y mostrar en el select
	public function selectMarcaVehiculo()
	{
		$sql="SELECT * FROM marca where tipoMarca='vehiculo' and inactivo=0";
		return ejecutarConsulta($sql);		
	}	
}

?>