<?php
if (file_exists(__DIR__ . '/../../config/load_env.php')) { require __DIR__ . '/../../config/load_env.php'; }
$dbHost = getenv('DB_HOST') ?: 'localhost';
$dbName = getenv('DB_NAME_SPA') ?: 'spa';
$dbUser = getenv('DB_USERNAME') ?: 'root';
$dbPass = getenv('DB_PASSWORD') ?: '';
$connection = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName) or die(mysqli_connect_error());
?>