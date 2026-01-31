<?php
use App\Lib\Auth,
    App\Lib\Response,
    App\Validation\TestValidation,
    App\Middleware\AuthMiddleware;



$app->group('/categoria/', function () {


	$this->get('getRubro', function ($req, $res, $args) {
		$clase='categoria';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->getRubro())
					);
    });



	$this->get('get', function ($req, $res, $args) {
		$clase='categoria';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->getCategoria())
					);
    });

    $this->get('get/{id}', function ($req, $res, $args) {
		$clase='categoria';

		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode( $this->model->$clase->getCategoriaID($args['id'] )[0]  ) 
 					);
    });


    $this->get('get/categoriaRubro/{id}', function ($req, $res, $args) {
		$clase='categoria';

		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode( $this->model->$clase->getCategoriaRubro($args['id'] )[0]  ) 
 					);
    });


    $this->get('get/comercioRubro/{id}', function ($req, $res, $args) {
		$clase='categoria';

		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode( $this->model->$clase->getComercioRubro($args['id'] )[0]  ) 
 					);
    });


    $this->get('get/productoRubro/{id}', function ($req, $res, $args) {
		$clase='categoria';

		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode( $this->model->$clase->getProductoRubro($args['id'] )[0]  ) 
 					);
    });


});



