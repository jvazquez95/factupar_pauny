<?php
require_once "../modelos/Habilitacion.php";


$habilitacion = new Habilitacion();

$idhabilitacion=isset($_POST['idhabilitacion'])?limpiarCadena($_POST['idhabilitacion']):"";
$Caja_idCaja=isset($_POST['Caja_idCaja'])?limpiarCadena($_POST['Caja_idCaja']):"";
$Usuario_idUsuario=isset($_POST['Usuario_idUsuario'])?limpiarCadena($_POST['Usuario_idUsuario']):"";
$fechaApertura=isset($_POST['fechaApertura'])?limpiarCadena($_POST['fechaApertura']):"";
$montoApertura=isset($_POST['montoApertura'])?limpiarCadena($_POST['montoApertura']):"";
$montoCierre=isset($_POST['montoCierre'])?limpiarCadena($_POST['montoCierre']):"";
 



switch ($_GET['op']) {
	case 'guardaryeditar':
		if (empty($idhabilitacion)) {
			$rspta=$habilitacion->insertar($Caja_idCaja, $Usuario_idUsuario, $fechaApertura, $montoApertura, $montoCierre);
			echo $rspta ? "habilitacion registrada" : "habilitacion no se pudo registrar";
		}
		else
		{
			$rspta=$habilitacion->editar($idhabilitacion,$Caja_idCaja,$Usuario_idUsuario, $montoApertura, $montoCierre );
			echo $rspta ? "habilitacion actualizada" : "habilitacion no se pudo editar";

		}
		break;
	
	case 'mostrar':
		$rspta=$habilitacion->mostrar($idhabilitacion);
		//codificar el resultado utilizando json
		echo json_encode($rspta);
		break;
	
	case 'cerrar':

		$rspta=$habilitacion->cerrar($idhabilitacion);
		//codificar el resultado utilizando json
		echo $rspta ? "habilitacion cerrada" : "habilitacion no se pudo cerrar";
		break;

	case 'habilitar':
		$rspta=$habilitacion->habilitar($idhabilitacion);
 		echo $rspta ? "Habilitado" : "No se puede habilitar";
	break;


	case 'listar':
	
		$rspta=$habilitacion->listar();
		$data = Array();
		while ($reg=$rspta->fetchObject()) {
			$data[]=array(
 				"0"=>($reg->estado)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idhabilitacion.')">Editar <i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="cerrar('.$reg->idhabilitacion.')">Cerrar <i class="fa fa-sign-out"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar1('.$reg->idhabilitacion.')">Ver  <i class="fa fa-eye"></i></button>',
 				"1"=>$reg->idhabilitacion,
				"2"=>$reg->nc,
				"3"=>$reg->nu,
				"4"=>$reg->fechaApertura,
				"5"=>$reg->fechaCierre,
				"6"=>$reg->montoApertura,
				"7"=>$reg->montoCierre,
				"8"=>($reg->estado)?'<span class="label bg-green">Habilitado</span>':
 				'<span class="label bg-red">Cerrado</span>'
			);

		}
		$result = array(
			"sEcho"=>1,
			"iTotalRecords"=>count($data),
			"iTotalDisplayRecords"=>count($data),
			"aaData"=>$data
		);

		echo json_encode($result);

		break;




		case 'listar2':
	
			$f_f=$_REQUEST["f_f"];
			$f_i=$_REQUEST["f_i"];

			$rspta=$habilitacion->listar2($f_i, $f_f);
			$data = Array();



			while ($reg=$rspta->fetchObject()) {
				$data[]=array(
				"0"=>($reg->estado)
					? '<div class="btn-group">
						<button class="btn btn-primary" onclick="mostrarDetalle('.$reg->idhabilitacion.',\''.$reg->tipo.'\')">Ver detalle <i class="fa fa-pencil"></i></button>
						<button class="btn btn-danger ml-2" onclick="cerrar('.$reg->idhabilitacion.')">Cerrar <i class="fa fa-sign-out"></i></button>
						<button class="btn btn-warning ml-2" onclick="abrirHabilitacion('.$reg->idhabilitacion.')">Ver Arqueo <i class="fa fa-eye"></i></button>
						<button class="btn btn-info ml-2" onclick="abrirAjusteInventario('.$reg->idhabilitacion.')">Inventario por Deposito ( Vehiculos ) <i class="fa fa-car"></i></button>
						<button class="btn btn-secondary ml-2" onclick="asignarAyudante('.$reg->idhabilitacion.')">Asignar Acompañante <i class="fa fa-car"></i></button>
					</div>'
					: '<div class="btn-group">
						<button class="btn btn-warning" onclick="mostrar1('.$reg->idhabilitacion.')">Ver <i class="fa fa-eye"></i></button>
						<button class="btn btn-warning ml-2" onclick="abrirHabilitacion('.$reg->idhabilitacion.')">Ver Arqueo <i class="fa fa-eye"></i></button>
						<button class="btn btn-info ml-2" onclick="abrirAjusteInventario('.$reg->idhabilitacion.')">Inventario por Deposito ( Vehiculos ) <i class="fa fa-car"></i></button>
					</div>',
					 "1"=>$reg->idhabilitacion,
					"2"=>$reg->nc,
					"3"=>$reg->nu,
					"4"=>$reg->fechaApertura,
					"5"=>$reg->fechaCierre,
					"6"=>$reg->montoApertura,
					"7"=>$reg->montoCierre,
					"8"=>$reg->un,
					"9"=>($reg->estado)?'<span class="label bg-green">Habilitado</span>':
					 '<span class="label bg-red">Cerrado</span>'
				);
	
			}
			$result = array(
				"sEcho"=>1,
				"iTotalRecords"=>count($data),
				"iTotalDisplayRecords"=>count($data),
				"aaData"=>$data
			);


		echo json_encode($result);

		break;






	case 'asignarAyudante':
		$idhabilitacion=$_REQUEST["idhabilitacion"];
		$idAyudante=$_REQUEST["idAyudante"];

		
		$rspta=$habilitacion->asignarAyudante($idhabilitacion, $idAyudante);
 		
 		echo $rspta ? "Procesado" : "Error al generar, intente nuevamente";

	break;	



	case 'generarPedido':
		$idProveedor=$_REQUEST["idProveedor"];
		$Denominacion_Denominacion=$_REQUEST["Denominacion_DenominacionD1"];
		$Moneda_idMoneda=$_REQUEST["Moneda_idMoneda"];
		$cantidad=$_REQUEST["fi"];
		
		$rspta=$habilitacion->generarPedido($idProveedor, $Denominacion_Denominacion, $Moneda_idMoneda, $cantidad);
 		
 		echo $rspta ? "Habilitacion Generada" : "Error al generar, intente nuevamente";

	break;		


case 'mostrarDetalleMoneda':

		require_once "../modelos/Moneda.php";
		$moneda = new Moneda();
		$monedaD1=$_GET["id"];
 

		$rspta=$moneda->mostrarDetalleMoneda($monedaD1);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

		 			$data[]=array(

		 				"0"=>$reg->moneda,
		 				"1"=>$reg->denominacion,
		 				"2"=>"<input type='number' name='cantidad[]' id='cantidad[]' value='0' >"
		 				);
		} 
		 
		 $results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;



	case 'listarHacerHabilitacion':
		$idProveedor=$_REQUEST["idProveedor"];
		$fi=$_REQUEST["fi"];
		$ff=$_REQUEST["ff"];
		$estado=$_REQUEST["estado"];
		$Moneda_idMoneda=$_REQUEST["Moneda_idMoneda"];
		$rspta=$habilitacion->listarHacerHabilitacion($idProveedor, $fi, $ff, $estado, $Moneda_idMoneda);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 		$url='../reportes/exTicket.php?id=';
 			$data[]=array(
 				"0"=>((!$reg->hpi)?'<button class="btn btn-primary" onclick="mostrarDetalle('.$reg->idhabilitacion.',\''.$reg->tipo.'\')">Ver detalle <i class="fa fa-pencil"></i></button>':
 					''),

				"0"=>($reg->estado)?'<button class="btn btn-primary" onclick="mostrarDetalle('.$reg->idhabilitacion.',\''.$reg->tipo.'\')">Ver detalle <i class="fa fa-pencil"></i></button><button class="btn btn-warning" onclick="mostrar('.$reg->idhabilitacion.')">Editar <i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="cerrar('.$reg->idhabilitacion.')">Cerrar <i class="fa fa-sign-out"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrarDetalle('.$reg->idhabilitacion.',\''.$reg->tipo.'\')">Ver  <i class="fa fa-eye"></i></button>',


 				"1"=>$reg->idhabilitacion,
 				"2"=>$reg->caja,	
 				"3"=>utf8_encode($reg->np),
 				"4"=>$reg->fechaApertura,
 				"5"=>$reg->fechaCierre, 
 				"6"=>number_format($reg->montoApertura, 0, ',', '.'),
 				"7"=>number_format($reg->montoCierre, 0, ',', '.'),
 				"8"=>(!$reg->hpi)?'<span class="label bg-green">Abierto</span>':
 				'<span class="label bg-red">Cerrado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;	

	case "selectUsuario":
		require_once "../modelos/Usuario.php";
		$usuario = new Usuario();

		$rspta = $usuario->selectUsuario();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idusuario. '>' .$reg->nombre. '</option>';
		}

		break;

	case "selectCaja":
		require_once "../modelos/Caja.php";
		$caja = new Caja();

		$rspta = $caja->selectCaja();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idCaja. '>' .$reg->nombre.' - '. $reg->descripcion .'</option>';
		}

		break;

	case "selectDeposito":
		require_once "../modelos/Deposito.php";
		$caja = new Deposito();

		$rspta = $caja->selectDeposito();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idDeposito. '>' .$reg->descripcion .'</option>';
		}

		break;
}


?>