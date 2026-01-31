<?php 
require_once "../modelos/cotizacionDiaria.php";

$cotizacionDiaria=new cotizacionDiaria();

$idCotizacionDiaria=isset($_POST["idCotizacionDiaria"])? limpiarCadena($_POST["idCotizacionDiaria"]):"";
$Moneda_idMoneda=isset($_POST["Moneda_idMoneda"])? limpiarCadena($_POST["Moneda_idMoneda"]):"";
$fecha=isset($_POST["fecha"])? limpiarCadena($_POST["fecha"]):"";
$cotizacionVenta=isset($_POST["cotizacionVenta"])? limpiarCadena($_POST["cotizacionVenta"]):"";
$cotizacionCompra=isset($_POST["cotizacionCompra"])? limpiarCadena($_POST["cotizacionCompra"]):"";
$monedan=0;
switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idCotizacionDiaria)){
			$rspta=$cotizacionDiaria->insertar($Moneda_idMoneda,$fecha,$cotizacionVenta,$cotizacionCompra);
			echo $rspta ? "Cotizacion registrada" : "Cotizacion no se pudo registrar";
		}
		else {
			$rspta=$cotizacionDiaria->editar($idCotizacionDiaria,$Moneda_idMoneda,$fecha,$cotizacionVenta,$cotizacionCompra);
			echo $rspta ? "Cotizacion actualizada" : "Cotizacion no se pudo actualizar";
		}
	break;
 
	case 'desactivar':
		$rspta=$cotizacionDiaria->desactivar($idCotizacionDiaria);
 		echo $rspta ? "Cotizacion Desactivada" : "Cotizacion no se puede desactivar";
	break;

	case 'activar':
		$rspta=$cotizacionDiaria->activar($idCotizacionDiaria);
 		echo $rspta ? "Cotizacion activada" : "Cotizacion no se puede activar";
	break;

	case 'mostrar':
		$rspta=$cotizacionDiaria->mostrar($idCotizacionDiaria);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$cotizacionDiaria->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idCotizacionDiaria.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idCotizacionDiaria.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idCotizacionDiaria.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idCotizacionDiaria.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->descripcion,
 				"2"=>$reg->fecha,
 				"3"=>$reg->cotizacionVenta,
 				"4"=>$reg->cotizacionCompra,
 				"5"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case "selectMoneda":
		require_once "../modelos/Moneda.php"; 
		$moneda = new Moneda();

		$rspta = $moneda->select();

		while ($reg = $rspta->fetchObject())
				{
					echo '<option value=' . $reg->idMoneda . '>' . $reg->descripcion . '</option>';
				}
	break;



	case 'ultimaCotizacion':
		$rspta=$cotizacionDiaria->ultimaCotizacion($_POST['Moneda_idMoneda']);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case "selectCotizacionPorMoneda":

		$rspta = $cotizacionDiaria->selectCotizacionPorMoneda($_POST['valorMoneda']);

		echo json_encode($rspta);

	break;

	case 'listarUltimasPorMoneda':
		$rspta = $cotizacionDiaria->listarUltimasPorMoneda();
		$data = array();
		while ($reg = $rspta->fetchObject()) {
			$data[] = array(
				'idMoneda' => $reg->idMoneda,
				'descripcion' => $reg->descripcion,
				'fecha' => $reg->fecha,
				'cotizacionVenta' => $reg->cotizacionVenta,
				'cotizacionCompra' => $reg->cotizacionCompra
			);
		}
		echo json_encode($data);
		break;

}
?>