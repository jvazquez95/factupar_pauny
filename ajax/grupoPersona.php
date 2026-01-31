<?php 
require_once "../modelos/GrupoPersona.php";

$grupoPersona=new GrupoPersona();

$idGrupoPersona=isset($_POST["idGrupoPersona"])? limpiarCadena($_POST["idGrupoPersona"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$cuentaAnticipo=isset($_POST["cuentaAnticipo"])? limpiarCadena($_POST["cuentaAnticipo"]):"";
$cuentaAPagar=isset($_POST["cuentaAPagar"])? limpiarCadena($_POST["cuentaAPagar"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idGrupoPersona)){
			$rspta=$grupoPersona->insertar($descripcion, $cuentaAnticipo, $cuentaAPagar, $inactivo);
			echo $rspta ? "grupoPersona registrada" : "grupoPersona no se pudo registrar";
		}
		else {
			$rspta=$grupoPersona->editar( $idGrupoPersona ,$descripcion, $cuentaAnticipo, $cuentaAPagar, $inactivo);
			echo $rspta ? "grupoPersona actualizada" : "grupoPersona no se pudo actualizar";
		}
	break;

	case 'mostrar':
		$rspta=$grupoPersona->mostrar($idGrupoPersona);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'desactivar':
		$rspta=$grupoPersona->desactivar($idGrupoPersona);
 		echo $rspta ? "grupoPersona Desactivado" : "grupoPersona no se puede desactivar";
	break;

	case 'activar':
		$rspta=$grupoPersona->activar($idGrupoPersona);
 		echo $rspta ? "grupoPersona activado" : "grupoPersona no se puede activar";
	break;


	case 'listar':
		$rspta=$grupoPersona->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idGrupoPersona.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idGrupoPersona.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idGrupoPersona.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idGrupoPersona.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->descripcion,
 				"2"=>$reg->cuentaAPagar,
 				"3"=>$reg->cuentaAnticipo,
 				"4"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
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

	case "selectGrupoPersona":

		$rspta = $grupoPersona->selectGrupoPersona();
		echo '<option value="%%">Todos...</option>';
		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idGrupoPersona. '>' .$reg->descripcion. '</option>';
		}

		break;

}
?>