<?php
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
            'dns'  => 'mysql:host=192.168.0.110;dbname=pauny',
            'user' => 'root',
            'pass' => 'Factupar2020!A'
        ]
    ],
];
