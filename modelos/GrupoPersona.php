<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class GrupoPersona
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($descripcion, $cuentaAnticipo, $cuentaAPagar, $inactivo)
	{
		$usuario = $_SESSION['login'];
		$sql="INSERT INTO `grupopersona`(`descripcion`,`cuentaAnticipo`, `cuentaAPagar`, `usuarioInsercion`, `inactivo`) VALUES ('$descripcion','$cuentaAnticipo','$cuentaAPagar','$usuario',0)";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idGrupoPersona, $descripcion, $cuentaAnticipo, $cuentaAPagar)
	{
		$sql="UPDATE `grupopersona` SET `descripcion`='$descripcion',`cuentaAnticipo`='$cuentaAnticipo',`cuentaAPagar`='$cuentaAPagar',`fechaModificacion`= now() WHERE `idGrupoPersona`='$idGrupoPersona'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idGrupoPersona)
	{
		$sql="UPDATE grupopersona SET inactivo=1 WHERE idGrupoPersona='$idGrupoPersona'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idGrupoPersona)
	{
		$sql="UPDATE grupopersona SET inactivo=0 WHERE idGrupoPersona='$idGrupoPersona'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idGrupoPersona)
	{
		$sql="SELECT * FROM grupopersona WHERE idGrupoPersona='$idGrupoPersona'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM grupopersona";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function selectGrupoPersona()
	{
		$sql="SELECT * FROM grupopersona where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>