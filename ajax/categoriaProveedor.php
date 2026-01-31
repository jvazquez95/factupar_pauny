<?php 
require_once "../modelos/categoriaProveedor.php";

$categoriaProveedor=new CategoriaProveedor();

$idCategoriaProveedor=isset($_POST["idCategoriaProveedor"])? limpiarCadena($_POST["idCategoriaProveedor"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$CuentaContable_idCuentaContable=isset($_POST["CuentaContable_idCuentaContable"])? limpiarCadena($_POST["CuentaContable_idCuentaContable"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idCategoriaProveedor)){
			$rspta=$categoriaProveedor->insertar($descripcion,$CuentaContable_idCuentaContable);
			echo $rspta ? "Categoría registrada" : "Categoría no se pudo registrar";
		}
		else {
			$rspta=$categoriaProveedor->editar($idCategoriaProveedor,$descripcion,$CuentaContable_idCuentaContable);
			echo $rspta ? "Categoría actualizada" : "Categoría no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$categoriaProveedor->desactivar($idCategoriaProveedor);
 		echo $rspta ? "Categoría Desactivada" : "Categoría no se puede desactivar";
	break;

	case 'activar':
		$rspta=$categoriaProveedor->activar($idCategoriaProveedor);
 		echo $rspta ? "Categoría activada" : "Categoría no se puede activar";
	break;

	case 'mostrar':
		$rspta=$categoriaProveedor->mostrar($idCategoriaProveedor);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$categoriaProveedor->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idCategoriaProveedor.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idCategoriaProveedor.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idCategoriaProveedor.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idCategoriaProveedor.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->descripcion,
 				"2"=>$reg->CuentaContable_idCuentaContable,
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
}
?>