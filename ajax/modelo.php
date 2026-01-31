<?php 
require_once "../modelos/Modelo.php";

$modelo=new Modelo();

$idModelo=isset($_POST["idModelo"])? limpiarCadena($_POST["idModelo"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$Marca_idMarca=isset($_POST["Marca_idMarca"])? limpiarCadena($_POST["Marca_idMarca"]):"";
 
switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idModelo)){
			$rspta=$modelo->insertar($descripcion,$Marca_idMarca);
			echo $rspta ? "modelo registrada" : "modelo no se pudo registrar";
		}
		else {
			$rspta=$modelo->editar($idModelo,$descripcion,$Marca_idMarca);
			echo $rspta ? "modelo actualizada" : "modelo no se pudo actualizar";
		}
	break;

	case 'mostrar':
		$rspta=$modelo->mostrar($idModelo);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'desactivar':
		$rspta=$modelo->desactivar($idModelo);
 		echo $rspta ? "modelo Desactivado" : "modelo no se puede desactivar";
	break;

	case 'activar':
		$rspta=$modelo->activar($idModelo);
 		echo $rspta ? "modelo activado" : "modelo no se puede activar";
	break;


	case 'listar':
		$rspta=$modelo->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idModelo.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idModelo.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idModelo.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idModelo.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->descripcion,
 				"2"=>$reg->Marca_idMarca,
 				"3"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
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

	case "selectModelo":

		$rspta = $modelo->selectModelo();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idModelo. '>' .$reg->descripcion. '</option>';
		}

		break;

	case 'selectMarcaVehiculo':
		require_once "../modelos/Marca.php"; 
		$idMarca = new Marca();
		$rspta = $idMarca->listarMarcaVehiculo();
				echo '<option value="">Seleccione una opcion</option>';

		while ($reg = $rspta->fetchObject())
				{
				echo '<option value=' . $reg->idMarca . '>' . $reg->descripcion . '</option>';
				} 
	break;		

}
?>