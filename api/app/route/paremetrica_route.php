<?php
use App\Lib\Auth,
    App\Lib\Response,
    App\Validation\TestValidation,
    App\Middleware\AuthMiddleware;



$app->group('/parametrica/', function () {


	$this->post('getVersion', function ($req, $res, $args) {
		$clase='parametrica';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->getVersion($req->getParsedBody()))
					);
    });

	$this->post('getPaises', function ($req, $res, $args) {
		$clase='parametrica';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->getPaises($req->getParsedBody()))
					);
    });
	


	$this->post('getCiudades', function ($req, $res, $args) {
		$clase='parametrica';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->getCiudades($req->getParsedBody()))
					);
    });




	$this->post('getCiudadesPais', function ($req, $res, $args) {
		$clase='parametrica';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->getCiudadesPais($req->getParsedBody()))
					);
    });





	$this->post('getMarcas', function ($req, $res, $args) {
		$clase='parametrica';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->getMarcas($req->getParsedBody()))
					);
    });




	$this->post('getModelos', function ($req, $res, $args) {
		$clase='parametrica';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->getModelos($req->getParsedBody()))
					);
    });





	$this->post('getModelosMarcas', function ($req, $res, $args) {
		$clase='parametrica';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->getModelosMarcas($req->getParsedBody()))
					);
    });





});



