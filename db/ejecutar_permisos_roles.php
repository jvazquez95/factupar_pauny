<?php
/**
 * Ejecuta la migración permisos_roles_migration.sql contra la BD del proyecto.
 * Uso: php ejecutar_permisos_roles.php   (desde la raíz del proyecto: php db/ejecutar_permisos_roles.php)
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

$baseDir = dirname(__DIR__);
chdir($baseDir);
require_once $baseDir . '/config/Conexion.php';

if (!isset($conexion) || $conexion === null) {
    die("Error: No se pudo conectar a la base de datos. Revise config/Conexion.php y que el servidor MySQL esté accesible.\n");
}

$sqlFile = $baseDir . '/db/permisos_roles_migration.sql';
if (!is_readable($sqlFile)) {
    die("Error: No se encuentra o no se puede leer db/permisos_roles_migration.sql\n");
}

$sql = file_get_contents($sqlFile);
// Quitar comentarios de línea (-- ...) y bloques /* */, partir por ; manteniendo solo sentencias no vacías
$sql = preg_replace('/--[^\n]*/m', '', $sql);
$sql = preg_replace('/\/\*.*?\*\//s', '', $sql);
$sentencias = array_filter(array_map('trim', explode(';', $sql)));

$ok = 0;
$skip = 0;
$fail = 0;

foreach ($sentencias as $i => $stmt) {
    $stmt = trim($stmt);
    if ($stmt === '') continue;
    if (strlen($stmt) < 10) continue; // descarte líneas sueltas
    try {
        $conexion->exec($stmt);
        $ok++;
        echo "OK #" . ($ok + $skip + $fail) . ": " . substr(str_replace("\n", " ", $stmt), 0, 70) . "...\n";
    } catch (PDOException $e) {
        $msg = $e->getMessage();
        // Omitir errores "ya existe" para hacer la migración idempotente
        if (strpos($msg, 'Duplicate column') !== false || strpos($msg, 'already exists') !== false || strpos($msg, '1060') !== false || strpos($msg, '1050') !== false) {
            $skip++;
            echo "SKIP (ya existe): " . substr($stmt, 0, 50) . "...\n";
        } else {
            $fail++;
            echo "ERROR: " . $msg . "\n  SQL: " . substr($stmt, 0, 100) . "...\n";
        }
    }
}

echo "\n--- Resumen: OK=$ok, Omitidos=$skip, Errores=$fail ---\n";
if ($fail > 0) {
    exit(1);
}
echo "Migración finalizada correctamente.\n";
