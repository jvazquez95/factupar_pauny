<?php
use App\Lib\Auth,
    App\Lib\Response,
    App\Validation\TestValidation,
    App\Middleware\AuthMiddleware;



$app->group('/parametrica/', function () {

	$this->get('consulta', function ($req, $res, $args) {
		$clase='parametrica';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->consulta($req->getParsedBody()))
					);
    });
	

		$this->post('sincronizacionProveedor', function ($req, $res, $args) {
		$clase='parametrica';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->sincronizacionProveedor($req->getParsedBody()))
					);
    });


		$this->post('sincronizacionCategoria', function ($req, $res, $args) {
		$clase='parametrica';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->sincronizacionCategoria($req->getParsedBody()))
					);
    });


		$this->post('sincronizacionCompra', function ($req, $res, $args) {
		$clase='parametrica';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->sincronizacionCompra($req->getParsedBody()))
					);
    });

		$this->get('mermas', function ($req, $res, $args) {
		$clase='parametrica';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->mermas($req->getParsedBody()))
					);
    });

	$this->post('anulacion', function ($req, $res, $args) {
	$clase='parametrica';
	return $res->withHeader('Content-type', 'application/json')
			->write(
				json_encode($this->model->$clase->anulacion($req->getParsedBody()))
				);
	});
});



