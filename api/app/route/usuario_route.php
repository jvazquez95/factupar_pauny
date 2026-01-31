<?php

use App\Lib\Auth,
    App\Lib\Response,
    App\Validation\TestValidation,
    App\Middleware\AuthMiddleware;

$app->group('/usuario/', function () {
	
	


	$this->post('venta_reimprimir', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->venta_reimprimir($req->getParsedBody()))
					);
    });


	$this->post('agregarDireccion', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->agregarDireccion($req->getParsedBody()))
					);
    });


	$this->post('verificarDocumento', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->verificarDocumento($req->getParsedBody()))
					);
    });

	$this->post('ajustar_stock_tercerizado', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->ajustar_stock_tercerizado($req->getParsedBody()))
					);
    });


	$this->post('orden_venta_crear_impresion', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->orden_venta_crear_impresion($req->getParsedBody()))
					);
    });



	$this->post('preventas_fecha_anulados', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->preventas_fecha_anulados($req->getParsedBody()))
					);
    });



	$this->post('preventas_fecha', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->preventas_fecha($req->getParsedBody()))
					);
    });


	$this->post('orden_venta_crear', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->orden_venta_crear($req->getParsedBody()))
					);
    });



	$this->post('finishOrder', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->finishOrder($req->getParsedBody()))
					);
    });
	

	$this->post('getOVPending', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->getOVPending($req->getParsedBody()))
					);
    });

	$this->post('reporte_hr_por_habilitacion', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->reporte_hr_por_habilitacion($req->getParsedBody()))
					);
    });




	$this->post('insertCompraImagen', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->insertCompraImagen($req->getParsedBody()))
					);
    });
	


	$this->post('getComprasImagenes', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->getComprasImagenes($req->getParsedBody()))
					);
    });


	$this->post('reporte_hr', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->reporte_hr($req->getParsedBody()))
					);
    });


	$this->post('reporte_vehiculos', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->reporte_vehiculos($req->getParsedBody()))
					);
    });


	$this->post('reporte_seguimiento', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->reporte_seguimiento($req->getParsedBody()))
					);
    });


	$this->post('verificar_habilitacion', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->verificar_habilitacion($req->getParsedBody()))
					);
    });
	

	$this->post('listadoArticulosSincronizar', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->listadoArticulosSincronizar($req->getParsedBody()))
					);
    });


	$this->post('listadoClientesSincronizar', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->listadoClientesSincronizar($req->getParsedBody()))
					);
    });



	$this->post('listadoClientes', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->listadoClientes($req->getParsedBody()))
					);
    });


	$this->post('listarCuotasVenta', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->listarCuotasVenta($req->getParsedBody()))
					);
    });


	$this->post('selectRecibosPersona', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->selectRecibosPersona($req->getParsedBody()))
					);
    });



	// --------------------------------------------------------------------
	/*$this->post('CargarDireccion', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->CargarDireccion($req->getParsedBody()))
					);
    });

    $this->post('CrearTelefono', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->CrearTelefono($req->getParsedBody()))
					);
    });

    $this->post('ActualizarTelefono', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->ActualizarTelefono($req->getParsedBody()))
					);
    });

    $this->post('ActualizarDireccion', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->ActualizarDireccion($req->getParsedBody()))
					);
  	 });*/
    // --------------------------------------------------------------------

	$this->post('ventas_fecha_anulados', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->ventas_fecha_anulados($req->getParsedBody()))
					);
    });


	$this->post('ventas_fecha', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->ventas_fecha($req->getParsedBody()))
					);
    });


	$this->post('selectBancos', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->selectBancos($req->getParsedBody()))
					);
    });


	$this->post('crear_visita_sinventa', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->crear_visita_sinventa($req->getParsedBody()))
					);
    });

	$this->post('selectDireccionesPersona', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->selectDireccionesPersona($req->getParsedBody()))
					);
    });

	$this->post('recibo_crear', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->recibo_crear($req->getParsedBody()))
					);
    });


	$this->post('venta_crear', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->venta_crear($req->getParsedBody()))
					);
    });

	$this->post('selectFormasPagos', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->selectFormasPagos($req->getParsedBody()))
					);
    });

	$this->post('listadoArticulos', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->listadoArticulos($req->getParsedBody()))
					);
    });

	$this->post('selectTerminosPagos', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->selectTerminosPagos($req->getParsedBody()))
					);
    });

	$this->post('misHabilitaciones', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->misHabilitaciones($req->getParsedBody()))
					);
    });

	
	$this->post('crear_gasto', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->crear_gasto($req->getParsedBody()))
					);
    });
	

	$this->post('crear_comodato', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->crear_comodato($req->getParsedBody()))
					);
    });


	$this->post('buscarClientesPorPalabraClave', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->buscarClientesPorPalabraClave($req->getParsedBody()))
					);
    });


	$this->post('buscarArticulosPorPalabraClave', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->buscarArticulosPorPalabraClave($req->getParsedBody()))
					);
    });


	$this->post('cerrar_habilitacion', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->cerrar_habilitacion($req->getParsedBody()))
					);
    });

	$this->post('datosCuenta', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->datosCuenta($req->getParsedBody()))
					);
    });

	$this->get('selectCajas', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->selectCajas($req->getParsedBody()))
					);
    });

	$this->post('editar_habilitacion', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->editar_habilitacion($req->getParsedBody()))
					);
    });

	$this->post('crear_habilitacion', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->crear_habilitacion($req->getParsedBody()))
					);
    });

	$this->post('clientes_usuarios', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->clientes_usuarios($req->getParsedBody()))
					);
    });
	
	$this->post('insertar_app', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->insertar_app($req->getParsedBody()))
					);
    });

	$this->post('insertar_web', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->insertar_web($req->getParsedBody()))
					);
    });

	$this->post('test', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->test($req->getParsedBody()))
					);
    });

	$this->post('envio_correo_recuperacion_contrasena', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->envio_correo_recuperacion_contrasena($req->getParsedBody()))
					);
    });

	$this->get('envio_correo', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->envio_correo($req->getParsedBody()))
					);
    });

	$this->get('envio_correo_asuncion', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->envio_correo_asuncion($req->getParsedBody()))
					);
    });

	$this->post('autos', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->autos($req->getParsedBody()))
					);
    });



	$this->post('cancelarViajeEnCurso', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->cancelarViajeEnCurso($req->getParsedBody()))
					);
    });


	$this->post('push', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->push($req->getParsedBody()))
					);
    });


	$this->post('historialViajes', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->historialViajes($req->getParsedBody()))
					);
    });



	$this->post('calificar', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->calificar($req->getParsedBody()))
					);
    });




	$this->post('cancelarViajeAcepto', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->cancelarViajeAcepto($req->getParsedBody()))
					);
    });



	$this->post('consulta', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->consulta($req->getParsedBody()))
					);
    });
	

	$this->post('editarPerfil', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->editarPerfil($req->getParsedBody()))
					);
    });


	$this->post('cancelarViaje', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->cancelarViaje($req->getParsedBody()))
					);
    });


	$this->post('pasajero_enViaje', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->pasajero_enViaje($req->getParsedBody()))
					);
    });



	$this->post('pasajero_enViajeMultiple', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->pasajero_enViajeMultiple($req->getParsedBody()))
					);
    });


	$this->post('perfilToken', function ($req, $res, $args) {
		$clase='usuario';
		
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->perfilToken($req->getParsedBody()))
					);
    });




$this->post('creditoFavor', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->creditoFavor($req->getParsedBody()))
					);
    });


		$this->post('importeViaje', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->importeViaje($req->getParsedBody()))
					);
    });


		$this->post('importeViajePorTipo', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->importeViajePorTipo($req->getParsedBody()))
					);
    });




		$this->post('pedirViaje', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->pedirViaje($req->getParsedBody()))
					);
    });


		$this->post('pedirViaje2', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->pedirViaje2($req->getParsedBody()))
					);
    });



		$this->post('ubicacionRider', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->ubicacionRider($req->getParsedBody()))
					);
    });


	$this->post('validarActivacion', function ($req, $res, $args) {
		$clase='usuario';
		
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->validarActivacion($req->getParsedBody()))
					);
    });



		$this->post('pagoZimple', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->pagoZimple($req->getParsedBody()))
					);
    });



		$this->post('listarTarjeta', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->listarTarjeta($req->getParsedBody()))
					);
    });



		$this->post('nuevaTarjeta', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->nuevaTarjeta($req->getParsedBody()))
					);
    });


		$this->post('pagoTarjetaToken', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->pagoTarjetaToken($req->getParsedBody()))
					);
    });



		$this->post('consultarCompra', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->consultarCompra($req->getParsedBody()))
					);
    });


		$this->post('reversoPago', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->reversoPago($req->getParsedBody()))
					);
    });






		$this->post('eliminarTarjeta', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->eliminarTarjeta($req->getParsedBody()))
					);
    });








		$this->post('nuevoRuc', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->nuevoRuc($req->getParsedBody()))
					);
    });



		$this->post('listarRuc', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->listarRuc($req->getParsedBody()))
					);
    });


		$this->post('recuperarPasswordInterno', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->recuperarPasswordInterno($req->getParsedBody()))
					);
    });



		$this->post('recuperarPassword', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->recuperarPassword($req->getParsedBody()))
					);
    });


		$this->post('contactar', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->contacto($req->getParsedBody()))
					);
    });


		$this->post('insertar', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->insertar($req->getParsedBody()))
					);
    });


		$this->post('actualizar', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->actualizar($req->getParsedBody()))
					);
    });



		$this->post('consultarPaquetes', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->consultarPaquetes($req->getParsedBody()))
					);
    });


		$this->post('comprobantes', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->comprobantes($req->getParsedBody()))
					);
    });


		


		$this->post('consultarPaquetesTracking', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->consultarPaquetesTracking($req->getParsedBody()))
					);
    });



		$this->post('updateTokenPushOneSignal', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->updateTokenPushOneSignal($req->getParsedBody()))
					);
    });

		$this->post('updateTokenPush', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->updateTokenPush($req->getParsedBody()))
					);
    });


		$this->post('crearVehiculo', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->crearVehiculo($req->getParsedBody()))
					);
    });


		$this->post('crearDocumentoPersonal', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->crearDocumentoPersonal($req->getParsedBody()))
					);
    });



		$this->post('actualizarAntecedentePolicial', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write( 
					json_encode($this->model->$clase->actualizarAntecedentePolicial($req->getParsedBody()))
					);   
    });

		$this->post('actualizarCiFrontal', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write( 
					json_encode($this->model->$clase->actualizarCiFrontal($req->getParsedBody()))
					);   
    });

		$this->post('actualizarCiReverso', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write( 
					json_encode($this->model->$clase->actualizarCiReverso($req->getParsedBody()))
					);   
    });

		$this->post('actualizarConstanciaRuc', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write( 
					json_encode($this->model->$clase->actualizarConstanciaRuc($req->getParsedBody()))
					);   
    });  

		$this->post('actualizarFotoPerfil', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write( 
					json_encode($this->model->$clase->actualizarFotoPerfil($req->getParsedBody()))
					);   
    });

		$this->post('actualizarHabilitacionFrontal', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write( 
					json_encode($this->model->$clase->actualizarHabilitacionFrontal($req->getParsedBody()))
					);      
    });             

		$this->post('actualizarHabilitacionReverso', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write( 
					json_encode($this->model->$clase->actualizarHabilitacionReverso($req->getParsedBody()))
					);      
    });

		$this->post('actualizarLicenciaConducirFrontal', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write( 
					json_encode($this->model->$clase->actualizarLicenciaConducirFrontal($req->getParsedBody()))
					);      
    });     

		$this->post('actualizarLicenciaConducirReverso', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write( 
					json_encode($this->model->$clase->actualizarLicenciaConducirReverso($req->getParsedBody()))
					);      
    });      
       
		$this->post('actualizarSeguro', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write( 
					json_encode($this->model->$clase->actualizarSeguro($req->getParsedBody()))
					);      
    });   

		$this->post('borrar', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write(
					json_encode($this->model->$clase->borrar($req->getParsedBody()))
					);
    });


		$this->post('verificarCedula', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write( 
					json_encode($this->model->$clase->verificarCedula($req->getParsedBody()))
					);      
    });     


		$this->post('verificarEmail', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write( 
					json_encode($this->model->$clase->verificarEmail($req->getParsedBody()))
					);      
    });     


		$this->post('verificarCelular', function ($req, $res, $args) {
		$clase='usuario';
		return $res->withHeader('Content-type', 'application/json')
				->write( 
					json_encode($this->model->$clase->verificarCelular($req->getParsedBody()))
					);      
    });     




   $this->get('auth/validate', function ($req, $res, $args) {
        $res->write(true);
    })->add(new AuthMiddleware($this));
		

});



