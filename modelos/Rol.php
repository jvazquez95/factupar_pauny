<?php 
require "../config/Conexion.php";

Class Rol
{
	public function __construct() {}

	/** Lista todos los roles */
	public function listar()
	{
		$sql = "SELECT * FROM rol ORDER BY nombre";
		return ejecutarConsulta($sql);
	}

	/** Devuelve array de id_permiso para un rol (para aplicar rol a usuario) */
	public function listarIdPermisosPorRol($id_rol)
	{
		$sql = "SELECT id_permiso FROM rol_permiso WHERE id_rol = '" . (int)$id_rol . "'";
		$rs = ejecutarConsulta($sql);
		$ids = array();
		if ($rs) {
			while ($row = $rs->fetchObject()) {
				$ids[] = (int)$row->id_permiso;
			}
		}
		return $ids;
	}
}
?>
