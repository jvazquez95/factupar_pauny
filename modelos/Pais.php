<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Pais
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre,$bandera,$codCelular)
	{
		session_start();
		$usuario = $_SESSION['login'];
		$sql="INSERT INTO paises (nombre, usuarioIns, bandera, codCelular, inactivo, fechaIns ) VALUES ('$nombre','$usuario','$bandera','$codCelular',0,now())";
		return ejecutarConsulta($sql);        
	}

	//Implementamos un método para editar registros
	public function editar($idPais,$nombre,$bandera,$codCelular)
	{
		session_start();
		$usuario = $_SESSION['login']; 
		$sql="UPDATE paises SET nombre='$nombre',fechaMod= now(), usuarioMod = '$usuario', bandera = '$bandera' , codCelular= '$codCelular' WHERE idPais='$idPais'";
		return ejecutarConsulta($sql);   
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idPais)
	{
		$sql="UPDATE paises SET inactivo=1 WHERE idPais='$idPais'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idPais)
	{
		$sql="UPDATE paises SET inactivo=0 WHERE idPais='$idPais'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idPais)
	{
		$sql="SELECT idPais,nombre,bandera,codCelular FROM paises WHERE idPais='$idPais'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT idPais,nombre,bandera,codCelular,inactivo
			  FROM paises";
		return ejecutarConsulta($sql);	 	 
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function selectPais()
	{
		$sql="SELECT *, nombre as descripcion FROM pais where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>