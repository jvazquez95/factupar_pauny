<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class CategoriaCliente
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($descripcion,$CuentaContable_idCuentaContable)
	{
		$sql="INSERT INTO categoriaCliente (descripcion, CuentaContable_idCuentaContable)
		VALUES ('$descripcion', '$CuentaContable_idCuentaContable')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idCategoriaCliente,$descripcion,$CuentaContable_idCuentaContable)
	{
		$sql="UPDATE categoriaCliente SET descripcion='$descripcion',CuentaContable_idCuentaContable='$CuentaContable_idCuentaContable' WHERE idCategoriaCliente='$idCategoriaCliente'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idCategoriaCliente)
	{
		$sql="UPDATE categoriaCliente SET inactivo=1 WHERE idCategoriaCliente='$idCategoriaCliente'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idCategoriaCliente)
	{
		$sql="UPDATE categoriaCliente SET inactivo=0 WHERE idCategoriaCliente='$idCategoriaCliente'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idCategoriaCliente)
	{
		$sql="SELECT * FROM categoriaCliente WHERE idCategoriaCliente='$idCategoriaCliente'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM categoriaCliente";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM categoriacliente where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>