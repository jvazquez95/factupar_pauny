<?php
use App\Lib\Auth,
    App\Lib\Response,
    App\Validation\TestValidation,
    App\Middleware\AuthMiddleware;



$app->group('/producto/', function () {


	//Producto por comercio por rubro
    $this->get('categoria/get/{categoria}', function ($req, $res, $args) {
		$clase='producto';

		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode( $this->model->$clase->getCategoriaProducto($args['categoria'] )  ) 
 					);
    });


	//Producto por comercio por rubro
    $this->get('comercio/rubro/get/{comercio}/{rubro}', function ($req, $res, $args) {
		$clase='producto';

		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode( $this->model->$clase->getComercioRubroProducto($args['comercio'],$args['rubro'] )  ) 
 					);
    });


	//Producto por comercio por rubro
    $this->get('categoria/rubro/get/{categoria}/{rubro}', function ($req, $res, $args) {
		$clase='producto';

		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode( $this->model->$clase->getCategoriaRubroProducto($args['categoria'],$args['rubro'] )  ) 
 					);
    });




   $this->get('get/{id}', function ($req, $res, $args) {
		$clase='producto';

		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode( $this->model->$clase->getProducto($args['id'] )  ) 
 					);
    });



   $this->get('getSabores/{id}', function ($req, $res, $args) {
		$clase='producto';

		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode( $this->model->$clase->getProductoSabores($args['id'] )  ) 
 					);
    });


   $this->get('getToppings/{id}', function ($req, $res, $args) {
		$clase='producto';

		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode( $this->model->$clase->getProductoToppings($args['id'] )  ) 
 					);
    });



   $this->get('destacado', function ($req, $res, $args) {
		$clase='producto';

		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode( $this->model->$clase->getProductoDestacado( )  ) 
 					);
    });


   $this->get('masVendidos', function ($req, $res, $args) {
		$clase='producto';

		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode( $this->model->$clase->getProductoMasVendido( )  ) 
 					);
    });


   $this->get('masValorados', function ($req, $res, $args) {
		$clase='producto';

		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode( $this->model->$clase->getProductoMasValorados( )  ) 
 					);
    });


   $this->get('masNuevos', function ($req, $res, $args) {
		$clase='producto';

		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode( $this->model->$clase->getProductoMasNuevos( )  ) 
 					);
    });


   $this->get('comercios', function ($req, $res, $args) {
		$clase='producto';

		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode( $this->model->$clase->getComercios( )  ) 
 					);
    });


   $this->get('marcas', function ($req, $res, $args) {
		$clase='producto';

		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode( $this->model->$clase->getMarcas( )  ) 
 					);
    });



   $this->get('marcas/getProducto/{marca}', function ($req, $res, $args) {
		$clase='producto';

		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode( $this->model->$clase->getProductosMarca( $args['marca'] )  ) 
 					);
    });


   $this->get('comercios/getProducto/{comercio}', function ($req, $res, $args) {
		$clase='producto';

		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode( $this->model->$clase->getProductosComercio( $args['comercio'] )  ) 
 					);
    });




   $this->get('comercios/getProductoOferta/{comercio}', function ($req, $res, $args) {
		$clase='producto';

		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode( $this->model->$clase->getProductosComercioOferta( $args['comercio'] )  ) 
 					);
    });





});






