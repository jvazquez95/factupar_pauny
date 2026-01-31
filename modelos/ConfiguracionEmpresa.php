<?php
require "../config/Conexion.php";

class ConfiguracionEmpresa
{
	public function __construct()
	{
	}

	/** Escapar comilla simple para SQL */
	private static function esc($str)
	{
		if ($str === null || $str === '') return $str;
		return str_replace("'", "''", $str);
	}

	/** Crear tabla e insertar fila id=1 si no existen */
	public function asegurarTabla()
	{
		$sql1 = "CREATE TABLE IF NOT EXISTS configuracion_empresa (
			id int(11) NOT NULL AUTO_INCREMENT,
			nombre_empresa varchar(200) DEFAULT NULL,
			ruc varchar(50) DEFAULT NULL,
			direccion varchar(255) DEFAULT NULL,
			telefono varchar(50) DEFAULT NULL,
			email varchar(100) DEFAULT NULL,
			logo_ruta varchar(255) DEFAULT NULL,
			color_primario varchar(20) DEFAULT '#007bff',
			fecha_modificacion datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY (id)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8";
		ejecutarConsulta($sql1);
		$sql2 = "INSERT IGNORE INTO configuracion_empresa (id, nombre_empresa, ruc, direccion, telefono, email, logo_ruta, color_primario) VALUES (1, '', '', NULL, NULL, NULL, 'files/logo/logo.png', '#007bff')";
		ejecutarConsulta($sql2);
	}

	public function obtener()
	{
		try {
			$this->asegurarTabla();
		} catch (Exception $e) {
			return null;
		}
		$sql = "SELECT * FROM configuracion_empresa WHERE id = 1";
		$r = ejecutarConsultaSimpleFila($sql);
		return $r !== false ? $r : null;
	}

	public function actualizar($nombre_empresa, $ruc, $direccion, $telefono, $email, $logo_ruta, $color_primario)
	{
		try {
			$this->asegurarTabla();
		} catch (Exception $e) {
			return false;
		}
		$nombre_empresa = self::esc($nombre_empresa);
		$ruc = self::esc($ruc);
		$direccion = self::esc($direccion);
		$telefono = self::esc($telefono);
		$email = self::esc($email);
		$color_primario = self::esc($color_primario);
		$logo_ruta = self::esc($logo_ruta);

		if ($logo_ruta === null || $logo_ruta === '') {
			$logo_sql = "logo_ruta";
		} else {
			$logo_sql = "'" . $logo_ruta . "'";
		}
		$sql = "UPDATE configuracion_empresa SET nombre_empresa='$nombre_empresa', ruc='$ruc', direccion='$direccion', telefono='$telefono', email='$email', logo_ruta=$logo_sql, color_primario='$color_primario', fecha_modificacion=NOW() WHERE id=1";
		try {
			$q = ejecutarConsulta($sql);
			return $q !== false;
		} catch (Exception $e) {
			return false;
		}
	}

	public function actualizarLogo($logo_ruta)
	{
		$logo_ruta = self::esc($logo_ruta);
		$sql = "UPDATE configuracion_empresa SET logo_ruta='$logo_ruta', fecha_modificacion=NOW() WHERE id=1";
		return ejecutarConsulta($sql) !== false;
	}
}
