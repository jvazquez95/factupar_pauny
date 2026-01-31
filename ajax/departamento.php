<?php 
require_once "../modelos/Departamento.php";

$departamento=new Departamento();

$idDepartamento=isset($_POST["idDepartamento"])? limpiarCadena($_POST["idDepartamento"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

 
switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idDepartamento)){
			$rspta=$departamento->insertar($descripcion);
			echo $rspta ? "Departamento registrada" : "Departamento no se pudo registrar";
		}
		else {
			$rspta=$departamento->editar($idDepartamento,$descripcion);
			echo $rspta ? "Departamento actualizada" : "Departamento no se pudo actualizar";
		}
	break;

	case 'mostrar':
		$rspta=$departamento->mostrar($idDepartamento);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'desactivar':
		$rspta=$departamento->desactivar($idDepartamento);
 		echo $rspta ? "Departamento Desactivado" : "Departamento no se puede desactivar";
	break;

	case 'activar':
		$rspta=$departamento->activar($idDepartamento);
 		echo $rspta ? "Departamento activado" : "Departamento no se puede activar";
	break;


	case 'listar':
		$rspta=$departamento->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idDepartamento.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idDepartamento.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idDepartamento.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idDepartamento.')"><i class="fa fa-check"></i></button>',
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

	case "selectDepartamento":

		$rspta = $departamento->selectDepartamento();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idDepartamento. '>' .$reg->descripcion. '</option>';
		}

		break;
	

}
?>