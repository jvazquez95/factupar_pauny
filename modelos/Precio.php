<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Precio
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($Articulo_idArticulo,$CategoriaCliente_idCategoriaCliente,$precio)
	{
		$sql="INSERT INTO `precio`(`Articulo_idArticulo`, `CategoriaCliente_idCategoriaCliente`, `precio`) VALUES ('$Articulo_idArticulo','$CategoriaCliente_idCategoriaCliente','$precio')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idPrecio,$Articulo_idArticulo,$CategoriaCliente_idCategoriaCliente,$precio)
	{
		$sql="UPDATE `precio` SET `Articulo_idArticulo`='$Articulo_idArticulo',`CategoriaCliente_idCategoriaCliente`='$CategoriaCliente_idCategoriaCliente',`precio`='$precio',`fechaModificacion`=now() WHERE idPrecio = '$idPrecio' ";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idPrecio)
	{
		$sql="UPDATE precio SET inactivo=1 WHERE idPrecio ='$idPrecio' ";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idPrecio)
	{
		$sql="UPDATE precio SET inactivo=0 WHERE idPrecio ='$idPrecio' ";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idPrecio)
	{
		$sql="SELECT * from precio WHERE  idPrecio = '$idPrecio'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
$sql="SELECT *,precio.inactivo as i, categoriaCliente.descripcion as cd, articulo.nombre as na FROM precio, categoriaCliente, articulo WHERE precio.Articulo_idArticulo = articulo.idArticulo and precio.CategoriaCliente_idCategoriaCliente = categoriaCliente.idCategoriaCliente";
		return ejecutarConsulta($sql);	
	}

/*	public function listar()
	{
		$sql="SELECT *, categoriaCliente.descripcion as cd, articulo.nombre as na FROM precio, categoriaCliente, articulo WHERE precio.Articulo_idArticulo = articulo.idArticulo and precio.CategoriaCliente_idCategoriaCliente = categoriaCliente.idCategoriaCliente";
		return ejecutarConsulta($sql);		
	}*/	
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM precio where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>