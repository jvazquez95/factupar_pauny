<?php 
require_once "../modelos/GrupoArticulo.php";

$GrupoArticulo=new GrupoArticulo();

$idGrupoArticulo=isset($_POST["idGrupoArticulo"])? limpiarCadena($_POST["idGrupoArticulo"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idGrupoArticulo)){
			$rspta=$GrupoArticulo->insertar($nombre);
			echo $rspta ? "Grupo articulo registrado" : "Grupo articulo no se pudo registrar";
		}
		else {
			$rspta=$GrupoArticulo->editar($idGrupoArticulo,$nombre);
			echo $rspta ? "grupo articulo actualizado" : "Grupo articulo no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$GrupoArticulo->desactivar($idGrupoArticulo);
 		echo $rspta ? "Grupo articulo Desactivado" : "Grupo articulo no se puede desactivar";
	break;

	case 'activar':
		$rspta=$GrupoArticulo->activar($idGrupoArticulo);
 		echo $rspta ? "Grupo articulo activado" : "Grupo articulo no se puede activar";
	break;

	case 'mostrar':
		$rspta=$GrupoArticulo->mostrar($idGrupoArticulo);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$GrupoArticulo->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idGrupoArticulo.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idGrupoArticulo.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idGrupoArticulo.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idGrupoArticulo.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombre,
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
	
	case "selectGrupoArticulo":

		$rspta = $GrupoArticulo->select();
		echo '<option value="%%">Todos...</option>';	
		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idGrupoArticulo. '>' .$reg->nombre. '</option>';
		}

	break;
}
?>