<?php
if (file_exists(__DIR__ . '/../../config/load_env.php')) {
    require __DIR__ . '/../../config/load_env.php';
}
$dbHost = getenv('DB_HOST') ?: 'localhost';
$dbName = getenv('DB_NAME') ?: 'pauny';
$dbUser = getenv('DB_USERNAME') ?: 'root';
$dbPass = getenv('DB_PASSWORD') ?: '';

return [
    'settings' => [
        'displayErrorDetails' => true,

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
        ],
        // Configuración de mi APP
        'app_token_name'   => 'APP-TOKEN',
        'connectionString' => [
            'dns'  => 'mysql:host=' . $dbHost . ';dbname=' . $dbName . ';charset=utf8',
            'user' => $dbUser,
            'pass' => $dbPass
        ]
    ],
];
