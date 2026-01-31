<?php 
require_once "../modelos/Categoria.php";

$categoria=new Categoria();

$idCategoria=isset($_POST["idCategoria"])? limpiarCadena($_POST["idCategoria"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$Categoria_idCategoria=isset($_POST["Categoria_idCategoria"])? limpiarCadena($_POST["Categoria_idCategoria"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idCategoria)){
			$rspta=$categoria->insertar($nombre,$Categoria_idCategoria);
			echo $rspta ? "Categoría registrada" : "Categoría no se pudo registrar";
		}
		else {
			$rspta=$categoria->editar($idCategoria,$nombre,$Categoria_idCategoria);
			echo $rspta ? "Categoría actualizada" : "Categoría no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$categoria->desactivar($idCategoria);
 		echo $rspta ? "Categoría Desactivada" : "Categoría no se puede desactivar";
	break;

	case 'activar':
		$rspta=$categoria->activar($idCategoria);
 		echo $rspta ? "Categoría activada" : "Categoría no se puede activar";
	break;

	case 'mostrar':
		$rspta=$categoria->mostrar($idCategoria);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$categoria->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idCategoria.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idCategoria.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idCategoria.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idCategoria.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->Categoria_idCategoria,
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
	
	case "selectCategoria":

		$rspta = $categoria->select();
		echo '<option value="%%">Todos...</option>';
		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idCategoria. '>' .$reg->nombre. '</option>';
		}

	break;


	case "selectCategoriaTodos":

		$rspta = $categoria->select();
		echo '<option value="999">Todos...</option>';
		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idCategoria. '>' .$reg->nombre. '</option>';
		}

	break;



}
?>