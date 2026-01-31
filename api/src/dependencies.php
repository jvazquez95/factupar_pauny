<?php

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], Monolog\Logger::DEBUG));
    return $logger;
};

// Database
$container['db'] = function($c){
    $connectionString = $c->get('settings')['connectionString'];
    
    $pdo = new PDO($connectionString['dns'], $connectionString['user'], $connectionString['pass'],array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
   // $pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY);


    return $pdo; 
};

// Models
$container['model'] = function($c){
    return (object)[
        'mermas' => new App\Model\MermasModel($c->db),
        'usuario' => new App\Model\UsuarioModel($c->db),
        'categoria' => new App\Model\CategoriaModel($c->db),
        'auth' => new App\Model\AuthModel($c->db),
        'producto' => new App\Model\ProductoModel($c->db),
        'parametrica' => new App\Model\ParametricaModel($c->db),
    ];
};

