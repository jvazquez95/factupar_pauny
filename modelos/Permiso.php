<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Permiso
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	
	//Implementar un método para listar los registros (compatible con BD sin migración)
	public function listar()
	{
		$sql = "SELECT * FROM permiso ORDER BY nombre";
		return ejecutarConsulta($sql);
	}

	/** Lista permisos con categoría para UI agrupada */
	public function listarPorCategoria()
	{
		$sql = "SELECT p.idpermiso, p.nombre, p.descripcion, p.archivo, p.id_categoria, c.nombre AS categoria_nombre, c.orden 
			FROM permiso p 
			LEFT JOIN permiso_categoria c ON c.id = p.id_categoria 
			ORDER BY COALESCE(c.orden,999), c.nombre, p.nombre";
		return ejecutarConsulta($sql);
	}

	/** Lista categorías */
	public function listarCategorias()
	{
		$sql = "SELECT * FROM permiso_categoria ORDER BY orden, nombre";
		return ejecutarConsulta($sql);
	}
}

?>