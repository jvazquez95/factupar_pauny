<?php
use App\Lib\Auth,
    App\Lib\Response,
    App\Validation\TestValidation,
    App\Middleware\AuthMiddleware;



$app->group('/mermas/', function () {

	$this->get('consulta', function ($req, $res, $args) {
		$clase='mermas';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->consulta($req->getParsedBody()))
					);
    });
	

		$this->post('sincronizacion', function ($req, $res, $args) {
		$clase='mermas';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->sincronizacion($req->getParsedBody()))
					);
    });


		$this->get('mermas', function ($req, $res, $args) {
		$clase='mermas';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->mermas($req->getParsedBody()))
					);
    });

	$this->post('anulacion', function ($req, $res, $args) {
	$clase='mermas';
	return $res->withHeader('Content-type', 'application/json')
			->write(
				json_encode($this->model->$clase->anulacion($req->getParsedBody()))
				);
	});
});



