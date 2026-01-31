<?php 
require_once "../modelos/centroDeCostos.php";

$CentroDeCostos=new CentroDeCostos();

$idCentroCosto=isset($_POST["idCentroCosto"])? limpiarCadena($_POST["idCentroCosto"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idCentroCosto)){
			$rspta=$CentroDeCostos->insertar($descripcion);
			echo $rspta ? "Centro de Costos registrado" : "Centro de Costos no se pudo registrar";
		}
		else {
			$rspta=$CentroDeCostos->editar($idCentroCosto,$descripcion);
			echo $rspta ? "Centro de Costos actualizado" : "Centro de Costos no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$CentroDeCostos->desactivar($idCentroCosto);
 		echo $rspta ? "Centro de Costos Desactivado" : "Centro de Costos no se puede desactivar";
	break;

	case 'activar':
		$rspta=$CentroDeCostos->activar($idCentroCosto);
 		echo $rspta ? "Centro de Costos activado" : "Centro de Costos no se puede activar";
	break;

	case 'mostrar':
		$rspta=$CentroDeCostos->mostrar($idCentroCosto);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$CentroDeCostos->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idCentroCosto.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idCentroCosto.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idCentroCosto.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idCentroCosto.')"><i class="fa fa-check"></i></button>',
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

	case 'selectCentroDeCostos':

		$rspta = $CentroDeCostos->listar();
				echo '<option value="0">Seleccione una opcion...</option>';
		while ($reg = $rspta->fetchObject())  
				{
				echo '<option value=' . $reg->idCentroCosto . '>' . $reg->descripcion . '</option>';
				}
	break;



}
?>