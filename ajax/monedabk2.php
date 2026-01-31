<?php 
require_once "../modelos/Moneda.php";

$moneda=new Moneda();

$idMoneda=isset($_POST["idMoneda"])? limpiarCadena($_POST["idMoneda"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idMoneda)){
			$rspta=$moneda->insertar($descripcion);
			echo $rspta ? "Moneda registrada" : "Moneda no se pudo registrar";
		}
		else {
			$rspta=$moneda->editar($idMoneda,$descripcion);
			echo $rspta ? "Moneda actualizada" : "Moneda no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$moneda->desactivar($idMoneda);
 		echo $rspta ? "Moneda Desactivada" : "Moneda no se puede desactivar";
	break;

	case 'activar':
		$rspta=$moneda->activar($idMoneda);
 		echo $rspta ? "Moneda activada" : "Moneda no se puede activar";
	break;

	case 'mostrar':
		$rspta=$moneda->mostrar($idMoneda);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$moneda->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){   
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idMoneda.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idMoneda.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idMoneda.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idMoneda.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->descripcion,
 				"2"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
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

	case 'selectMoneda':

		$rspta = $moneda->listar();

		while ($reg = $rspta->fetchObject())
				{
				echo '<option value=' . $reg->idMoneda . '>' . $reg->descripcion . '</option>';
				}
	break;

	case 'selectMoneda2':

		$rspta = $moneda->listar();

		while ($reg = $rspta->fetchObject())
				{
				echo $reg->idMoneda ;
				}
	break;

}
?>