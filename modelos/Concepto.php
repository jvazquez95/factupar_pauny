<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Concepto
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($descripcion,$tipo,$CtaCorriente)
	{
		$sql="INSERT INTO `concepto` (`descripcion`,`tipo`,`inactivo`,`CtaCorriente`)	VALUES('$descripcion','$tipo',0,'$CtaCorriente')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idConcepto, $descripcion, $tipo,$CtaCorriente)
	{
		$sql="UPDATE `concepto` SET `descripcion` = '$descripcion',`tipo` = '$tipo', `CtaCorriente` = '$CtaCorriente'  WHERE `idConcepto` = '$idConcepto'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idConcepto)
	{
		$sql="UPDATE concepto SET inactivo=1 WHERE idConcepto='$idConcepto'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idConcepto)
	{
		$sql="UPDATE concepto SET inactivo=0 WHERE idConcepto='$idConcepto'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idConcepto)
	{
		$sql="SELECT * FROM concepto WHERE idConcepto='$idConcepto'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM concepto";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM concepto where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>