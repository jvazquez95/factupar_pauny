<?php
/**
 * Asigna todos los permisos al usuario admin (login='admin' o idusuario=1).
 * Ejecutar una vez: php db/asignar_todos_permisos_admin.php
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

$baseDir = dirname(__DIR__);
chdir($baseDir);
require_once $baseDir . '/config/Conexion.php';

if (!isset($conexion) || $conexion === null) {
    die("Error: No se pudo conectar a la base de datos.\n");
}

// Buscar usuario admin por login o usar idusuario=1
$admin_id = null;
$rs = $conexion->query("SELECT idusuario FROM usuario WHERE login = 'admin' OR idusuario = 1 ORDER BY idusuario ASC LIMIT 1");
if ($rs && $row = $rs->fetch(PDO::FETCH_ASSOC)) {
    $admin_id = (int) $row['idusuario'];
}
if (!$admin_id) {
    die("Error: No se encontró usuario admin (login='admin' o idusuario=1).\n");
}

// Obtener todos los idpermiso
$permisos = array();
$rs = $conexion->query("SELECT idpermiso FROM permiso");
if ($rs) {
    while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
        $permisos[] = (int) $row['idpermiso'];
    }
}
if (empty($permisos)) {
    die("Error: No hay permisos en la tabla permiso.\n");
}

// Eliminar permisos actuales del admin
$conexion->exec("DELETE FROM usuario_permiso WHERE idusuario = $admin_id");

// Insertar todos los permisos
$insertados = 0;
foreach ($permisos as $idp) {
    $conexion->exec("INSERT INTO usuario_permiso (idusuario, idpermiso) VALUES ($admin_id, $idp)");
    $insertados++;
}

echo "OK: Se asignaron $insertados permisos al usuario admin (idusuario=$admin_id).\n";
echo "El usuario admin debe cerrar sesión y volver a entrar para que se apliquen los permisos.\n";
