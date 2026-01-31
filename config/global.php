<?php
/**
 * Variables globales de BD y proyecto.
 * Los valores se leen de .env (raíz del proyecto). Ver .env.example.
 */
require_once __DIR__ . '/load_env.php';

define('DB_HOST',     getenv('DB_HOST')     ?: 'localhost');
define('DB_NAME',     getenv('DB_NAME')     ?: 'pauny');
define('DB_USERNAME', getenv('DB_USERNAME') ?: 'root');
define('DB_PASSWORD', getenv('DB_PASSWORD') ?: '');
define('DB_ENCODE',   getenv('DB_ENCODE')   ?: 'utf8');
define('PRO_NOMBRE',  getenv('PRO_NOMBRE')  ?: '');
?>
