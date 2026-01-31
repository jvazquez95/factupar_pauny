<?php 
require_once "../modelos/Precio.php";

$Precio=new Precio();

$idPrecio=isset($_POST["idPrecio"])? limpiarCadena($_POST["idPrecio"]):"";
$Articulo_idArticulo=isset($_POST["Articulo_idArticulo"])? limpiarCadena($_POST["Articulo_idArticulo"]):"";
$CategoriaCliente_idCategoriaCliente=isset($_POST["CategoriaCliente_idCategoriaCliente"])? limpiarCadena($_POST["CategoriaCliente_idCategoriaCliente"]):"";
$precio=isset($_POST["precio"])? limpiarCadena($_POST["precio"]):"";


switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idPrecio)){
			$rspta=$Precio->insertar($Articulo_idArticulo,$CategoriaCliente_idCategoriaCliente,$precio);
			echo $rspta ? "Precio registrada" : "Precio no se pudo registrar";
		}
		else {
			$rspta=$Precio->editar($idPrecio,$Articulo_idArticulo,$CategoriaCliente_idCategoriaCliente,$precio);
			echo $rspta ? "Precio actualizada" : "Precio no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$Precio->desactivar($idPrecio);
 		echo $rspta ? "Precio Desactivada" : "Precio no se puede desactivar";
	break;

	case 'activar':
		$rspta=$Precio->activar($idPrecio);
 		echo $rspta ? "Precio activada" : "Precio no se puede activar";
	break;

	case 'mostrar':
		$rspta=$Precio->mostrar($idPrecio);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$Precio->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->i)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idPrecio.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idPrecio.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idPrecio.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idPrecio.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->na,
 				"2"=>$reg->cd,
 				"3"=>$reg->precio,
 				"4"=>(!$reg->i)?'<span class="label bg-green">Activado</span>':
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


	case "selectArticulo":
		require_once "../modelos/Articulo.php";
		$articulo = new Articulo();

		$rspta = $articulo->listarActivos();

		while ($reg = $rspta->fetchObject())
				{
					echo '<option value=' . $reg->idArticulo . '>' . $reg->nombre . '</option>';
				}
	break;

	case "selectCategoriaCliente":
		require_once "../modelos/CategoriaCliente.php";
		$a = new CategoriaCliente();

		$rspta = $a->select();

		while ($reg = $rspta->fetchObject())
				{
					echo '<option value=' . $reg->idCategoriaCliente . '>' . $reg->descripcion . '</option>';
				}
	break;


}
?>