<?php 
require_once "../modelos/ComunicacionPersonal.php";

$comunicacionPersonal=new ComunicacionPersonal();

$idComunicacionPersonal=isset($_POST["idComunicacionPersonal"])? limpiarCadena($_POST["idComunicacionPersonal"]):"";
$Legajo_idLegajo=isset($_POST["Legajo_idLegajo"])? limpiarCadena($_POST["Legajo_idLegajo"]):"";
$TipoComunicacion_idTipoComunicacion=isset($_POST["TipoComunicacion_idTipoComunicacion"])? limpiarCadena($_POST["TipoComunicacion_idTipoComunicacion"]):"";
$fechaComunicacion=isset($_POST["fechaComunicacion"])? limpiarCadena($_POST["fechaComunicacion"]):"";
$concepto=isset($_POST["concepto"])? limpiarCadena($_POST["concepto"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";

 
switch ($_GET["op"]){
	case 'guardaryeditar':

		if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
		{
			$imagen=$_POST["imagenactual"];
		}
		else 
		{
			$ext = explode(".", $_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
			{
				$imagen = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/comunicacionPersonal/" . $imagen);
			}
		}

		if (empty($idComunicacionPersonal)){
			$rspta=$comunicacionPersonal->insertar($Legajo_idLegajo,$TipoComunicacion_idTipoComunicacion,$fechaComunicacion,$concepto,$imagen);
			echo $rspta ? "comunicacionPersonal registrado" : "comunicacionPersonal no se pudo registrar";
		}
		else {
			$rspta=$comunicacionPersonal->editar($idComunicacionPersonal,$Legajo_idLegajo,$TipoComunicacion_idTipoComunicacion,$fechaComunicacion,$concepto,$imagen);
			echo $rspta ? "comunicacionPersonal actualizado" : "comunicacionPersonal no se pudo actualizar";
		}
	break;

	case 'mostrar':
		$rspta=$comunicacionPersonal->mostrar($idComunicacionPersonal);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'desactivar':
		$rspta=$comunicacionPersonal->desactivar($idComunicacionPersonal);
 		echo $rspta ? "comunicacionPersonal Desactivado" : "comunicacionPersonal no se puede desactivar";
	break;

	case 'activar':
		$rspta=$comunicacionPersonal->activar($idComunicacionPersonal);
 		echo $rspta ? "comunicacionPersonal activado" : "comunicacionPersonal no se puede activar";
	break;


	case 'listar':
		$rspta=$comunicacionPersonal->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idComunicacionPersonal.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idComunicacionPersonal.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idComunicacionPersonal.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idComunicacionPersonal.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombreLegajo,
 				"2"=>$reg->nombreTipoComunicacion,
 				"3"=>$reg->fechaComunicacion,
 				"4"=>$reg->concepto,
 				"5"=>"<img src='../files/comunicacionPersonal/".$reg->imagen."' height='50px' width='50px' >",
 				"6"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
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

	case "selectComunicacionPersonal":

		$rspta = $comunicacionPersonal->selectComunicacionPersonal();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idComunicacionPersonal. '>' .$reg->descripcion. '</option>';
		}

		break;
	

}
?>