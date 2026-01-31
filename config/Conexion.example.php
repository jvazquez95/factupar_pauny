<?php
/**
 * Ejemplo de configuración de conexión a la base de datos.
 * Copiar este archivo como Conexion.php y ajustar host, usuario y contraseña.
 */
require_once __DIR__ . "/global.php";
ini_set('memory_limit', '-1');

$conexion = null;
try {
	$conexion = new PDO(
		'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8',
		DB_USERNAME,
		DB_PASSWORD,
		array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")
	);
} catch (PDOException $e) {
	$conexion = null;
}

if (!function_exists('ejecutarConsulta')) {
	function ejecutarConsulta($sql) {
		global $conexion;
		if (!isset($conexion) || $conexion === null) return false;
		try {
			return $conexion->query($sql);
		} catch (Exception $e) {
			return false;
		}
	}

	function ejecutarConsultaSimpleFila($sql) {
		global $conexion;
		if (!isset($conexion) || $conexion === null) return false;
		try {
			$query = $conexion->query($sql);
			return $query ? $query->fetch(PDO::FETCH_ASSOC) : false;
		} catch (Exception $e) {
			return false;
		}
	}

	function ejecutarConsulta_retornarID($sql) {
		global $conexion;
		if (!isset($conexion) || $conexion === null) return 0;
		try {
			$conexion->query($sql);
			return (int) $conexion->lastInsertId();
		} catch (Exception $e) {
			return 0;
		}
	}

	function limpiarCadena($str) {
		return htmlspecialchars(trim($str));
	}
}
