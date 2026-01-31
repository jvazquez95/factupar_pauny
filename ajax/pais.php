<?php 
require_once "../modelos/Pais.php";

$pais=new Pais();

$idPais=isset($_POST["idPais"])? limpiarCadena($_POST["idPais"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$bandera=isset($_POST["bandera"])? limpiarCadena($_POST["bandera"]):"";
$codCelular=isset($_POST["codCelular"])? limpiarCadena($_POST["codCelular"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idPais)){
			$rspta=$pais->insertar($nombre,$bandera,$codCelular);
			echo $rspta ? "Pais registrado" : "Pais no se pudo registrar";  
		}
		else {
			$rspta=$pais->editar($idPais,$nombre,$bandera,$codCelular);
			echo $rspta ? "Pais actualizado" : "Pais no se pudo actualizar";
		} 
	break;

	case 'desactivar':
		$rspta=$pais->desactivar($idPais);
 		echo $rspta ? "Pais Desactivado" : "Pais no se puede desactivar";
	break;

	case 'activar': 
		$rspta=$pais->activar($idPais);
 		echo $rspta ? "Pais activado" : "Pais no se puede activar";
	break;

	case 'mostrar':
		$rspta=$pais->mostrar($idPais);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$pais->listar();
 		//Vamos a declarar un array
 		$data= Array();
 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idPais.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idPais.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idPais.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idPais.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->bandera,
 				"3"=>$reg->codCelular,         
 				"4"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
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

case "selectPais":

	$rspta = $pais->selectPais();
		echo '<option value="999">Seleccione pais</option>';
	while ($reg = $rspta->fetchObject()) {
		echo '<option value=' .$reg->idPais. '>' .$reg->descripcion. '</option>';
	}
break;


	case 'selectMoneda':
		require_once "../modelos/Moneda.php"; 
		$idMoneda = new Moneda();
		$rspta = $idMoneda->listar();
				echo '<option value="">Seleccione una opcion...</option>';

		while ($reg = $rspta->fetchObject())
				{
				echo '<option value=' . $reg->idMoneda . '>' . $reg->nombre . '</option>';
				}
	break;
 

}
?>