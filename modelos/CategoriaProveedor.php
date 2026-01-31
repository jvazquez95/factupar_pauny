<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class CategoriaProveedor
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($descripcion,$CuentaContable_idCuentaContable)
	{
		$sql="INSERT INTO categoriaProveedor (descripcion, CuentaContable_idCuentaContable)
		VALUES ('$descripcion', '$CuentaContable_idCuentaContable')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idCategoriaProveedor,$descripcion,$CuentaContable_idCuentaContable)
	{
		$sql="UPDATE categoriaProveedor SET descripcion='$descripcion',CuentaContable_idCuentaContable='$CuentaContable_idCuentaContable' WHERE idCategoriaProveedor='$idCategoriaProveedor'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idCategoriaProveedor)
	{
		$sql="UPDATE categoriaProveedor SET inactivo=1 WHERE idCategoriaProveedor='$idCategoriaProveedor'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idCategoriaProveedor)
	{
		$sql="UPDATE categoriaProveedor SET inactivo=0 WHERE idCategoriaProveedor='$idCategoriaProveedor'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idCategoriaProveedor)
	{
		$sql="SELECT * FROM categoriaProveedor WHERE idCategoriaProveedor='$idCategoriaProveedor'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM categoriaproveedor";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM categoriaproveedor where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>