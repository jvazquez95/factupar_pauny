<?php
use App\Lib\Auth,
    App\Lib\Response,
    App\Validation\EmpleadoValidation,
    App\Middleware\AuthMiddleware;

$app->group('/auth/', function () {
    $this->post('autenticar', function ($req, $res, $args) {
        $parametros = $req->getParsedBody();        
        
        return $res->withHeader('Content-type', 'application/json')
                   ->write(
                     json_encode($this->model->auth->autenticar($parametros['email'], $parametros['clave']))
                   );
    });



    $this->post('autenticarGoogle', function ($req, $res, $args) {
        $parametros = $req->getParsedBody();        
        
        return $res->withHeader('Content-type', 'application/json')
                   ->write(
                     json_encode($this->model->auth->autenticarGoogle( $parametros['token'] ))
                   );
    });



    $this->post('obtenerDatos', function ($req, $res, $args) {
        $parametros = $req->getParsedBody();        
        
        return $res->withHeader('Content-type', 'application/json')
                   ->write(
                     json_encode($this->model->auth->obtenerDatos( $parametros['token'] ))
                   );
    });



});