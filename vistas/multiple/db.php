<?php
if (file_exists(__DIR__ . '/../../config/load_env.php')) { require __DIR__ . '/../../config/load_env.php'; }
$dbHost = getenv('DB_HOST') ?: 'localhost';
$dbName = getenv('DB_NAME_MESA') ?: 'mesaentrada';
$dbUser = getenv('DB_USERNAME') ?: 'root';
$dbPass = getenv('DB_PASSWORD') ?: '';
$conexion = new PDO('mysql:host=' . $dbHost . ';dbname=' . $dbName, $dbUser, $dbPass);
$setnames = $conexion->prepare("SET NAMES 'utf8mb4'");
$setnames->execute();

?>