<?php 
require_once "../modelos/Ciudad.php";

$ciudad=new Ciudad();

$idCiudad=isset($_POST["idCiudad"])? limpiarCadena($_POST["idCiudad"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$Pais_idPais=isset($_POST["Pais_idPais"])? limpiarCadena($_POST["Pais_idPais"]):"";
 
switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idCiudad)){
			$rspta=$ciudad->insertar($descripcion,$Pais_idPais);
			echo $rspta ? "ciudad registrada" : "ciudad no se pudo registrar";
		}
		else {
			$rspta=$ciudad->editar($idCiudad,$descripcion,$Pais_idPais);
			echo $rspta ? "ciudad actualizada" : "ciudad no se pudo actualizar";
		}
	break;

	case 'mostrar':
		$rspta=$ciudad->mostrar($idCiudad);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'desactivar':
		$rspta=$ciudad->desactivar($idCiudad);
 		echo $rspta ? "ciudad Desactivado" : "ciudad no se puede desactivar";
	break;

	case 'activar':
		$rspta=$ciudad->activar($idCiudad);
 		echo $rspta ? "ciudad activado" : "ciudad no se puede activar";
	break;


	case 'listar':
		$rspta=$ciudad->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idCiudad.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idCiudad.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idCiudad.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idCiudad.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->descripcion,
 				"2"=>$reg->Pais_idPais,
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

	case "selectCiudad":

		$rspta = $ciudad->selectCiudad();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idCiudad. '>' .$reg->descripcion. '</option>';
		}

		break;

	case 'selectPais':
		require_once "../modelos/Pais.php"; 
		$idPais = new Pais();
		$rspta = $idPais->listar();
				echo '<option value="">Seleccione una opcion</option>';

		while ($reg = $rspta->fetchObject())
				{
				echo '<option value=' . $reg->idPais . '>' . $reg->nombre . '</option>';
				} 
	break;		

}
?>