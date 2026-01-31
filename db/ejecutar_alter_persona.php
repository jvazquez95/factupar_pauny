<?php
/**
 * Script para crear las columnas apellidos, nombres y nombreFantasia en la tabla persona.
 * Ejecutar UNA SOLA VEZ desde el navegador: http://tu-dominio/pauny/db/ejecutar_alter_persona.php
 * Luego se puede borrar este archivo por seguridad.
 */

header('Content-Type: text/html; charset=utf-8');

require_once __DIR__ . '/../config/Conexion.php';

$mensajes = array();
$ok = true;

// Verificar si las columnas ya existen
$existe_apellidos = false;
try {
	$r = ejecutarConsulta("SHOW COLUMNS FROM persona LIKE 'apellidos'");
	if ($r && $r->fetch()) {
		$existe_apellidos = true;
	}
} catch (Exception $e) {
	$mensajes[] = "Error al verificar: " . $e->getMessage();
	$ok = false;
}

if ($existe_apellidos) {
	$mensajes[] = "Las columnas apellidos, nombres y nombreFantasia ya existen en la tabla persona. No es necesario ejecutar nada.";
} else {
	$sqls = array(
		"ALTER TABLE `persona` ADD COLUMN `apellidos` VARCHAR(250) DEFAULT NULL COMMENT 'Apellidos'",
		"ALTER TABLE `persona` ADD COLUMN `nombres` VARCHAR(250) DEFAULT NULL COMMENT 'Nombres'",
		"ALTER TABLE `persona` ADD COLUMN `nombreFantasia` VARCHAR(250) DEFAULT NULL COMMENT 'Nombre fantasía'"
	);
	foreach ($sqls as $sql) {
		try {
			$resultado = ejecutarConsulta($sql);
			if ($resultado !== false) {
				$mensajes[] = "OK: " . preg_replace('/ADD COLUMN `(\w+)`.+/', 'Columna $1 creada.', $sql);
			} else {
				$mensajes[] = "Error al ejecutar: " . substr($sql, 0, 60) . "...";
				$ok = false;
			}
		} catch (Exception $e) {
			$mensajes[] = "Error: " . $e->getMessage();
			$ok = false;
		}
	}
}

echo "<!DOCTYPE html><html><head><meta charset='utf-8'><title>Alter persona</title></head><body>";
echo "<h1>Crear columnas en tabla persona</h1>";
echo "<ul>";
foreach ($mensajes as $m) {
	echo "<li>" . htmlspecialchars($m) . "</li>";
}
echo "</ul>";
if ($ok && !$existe_apellidos) {
	echo "<p><strong>Listo.</strong> Las columnas apellidos, nombres y nombreFantasia fueron creadas. Ya puede usar el formulario de personas.</p>";
} elseif ($existe_apellidos) {
	echo "<p>No se realizó ningún cambio.</p>";
} else {
	echo "<p><strong>Hubo errores.</strong> Revise que la tabla persona exista y que tenga permisos. Puede ejecutar manualmente el archivo <code>alter_persona_nombres_apellidos.sql</code> en phpMyAdmin.</p>";
}
echo "<p><small>Puede eliminar este archivo (ejecutar_alter_persona.php) después de usarlo.</small></p>";
echo "</body></html>";
