<?php 
require_once "../modelos/Copia.php";

$Copia=new Copia();

$idCopia=isset($_POST["idCopia"])? limpiarCadena($_POST["idCopia"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$Proceso_idProceso=isset($_POST["Proceso_idProceso"])? limpiarCadena($_POST["Proceso_idProceso"]):"";


switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idCopia)){
			$rspta=$Copia->insertar($descripcion,$Proceso_idProceso);
			echo $rspta ? "Copia registrada" : "Copia no se pudo registrar";  
		}
		else {
			$rspta=$Copia->editar($idCopia,$descripcion,$Proceso_idProceso);
			echo $rspta ? "Copia actualizada" : "Copia no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$Copia->desactivar($idCopia);
 		echo $rspta ? "Copia Desactivada" : "Copia no se puede desactivar";
	break;

	case 'activar':
		$rspta=$Copia->activar($idCopia);
 		echo $rspta ? "Copia activada" : "Copia no se puede activar";
	break;

	case 'mostrar':
		$rspta=$Copia->mostrar($idCopia);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$Copia->listar();
 		//Vamos a declarar un array
 		$data= Array();
 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idCopia.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idCopia.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idCopia.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idCopia.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->descripcion,
 				"2"=>$reg->Proceso,      
 				"3"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		//var_dump($results);
 		echo json_encode($results);

	break;

	case 'selectProceso':
		require_once "../modelos/Proceso.php"; 
		$idProceso = new Proceso();
		$rspta = $idProceso->listar();

		while ($reg = $rspta->fetchObject())
				{
				echo '<option value=' . $reg->idProceso . '>' . $reg->ano . '</option>';
				}
	break;
 


}
?>