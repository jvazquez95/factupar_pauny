<?php 
require_once "../modelos/Contrasena.php";

$Contrasena=new Contrasena();

$idContrasena=isset($_POST["idContrasena"])? limpiarCadena($_POST["idContrasena"]):"";
$prioridad=isset($_POST["prioridad"])? limpiarCadena($_POST["prioridad"]):"";
$contrasena=isset($_POST["contrasena"])? limpiarCadena($_POST["contrasena"]):"";
$Proceso_idProceso=isset($_POST["Proceso_idProceso"])? limpiarCadena($_POST["Proceso_idProceso"]):"";


switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idContrasena)){
			$rspta=$Contrasena->insertar($prioridad,$contrasena,$Proceso_idProceso);
			echo $rspta ? "Contrasena registrada" : "Contrasena no se pudo registrar";  
		}
		else {
			$rspta=$Contrasena->editar($idContrasena,$prioridad,$contrasena,$Proceso_idProceso);
			echo $rspta ? "Contrasena actualizada" : "Contrasena no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$Contrasena->desactivar($idContrasena);
 		echo $rspta ? "Contrasena Desactivada" : "Contrasena no se puede desactivar";
	break;

	case 'activar':
		$rspta=$Contrasena->activar($idContrasena);
 		echo $rspta ? "Contrasena activada" : "Contrasena no se puede activar";
	break;

	case 'mostrar':
		$rspta=$Contrasena->mostrar($idContrasena);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$Contrasena->listar();
 		//Vamos a declarar un array
 		$data= Array();
 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idContrasena.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idContrasena.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idContrasena.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idContrasena.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->Proceso,
 				"2"=>$reg->prioridad,      
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