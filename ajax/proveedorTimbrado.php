<?php 
require_once "../modelos/ProveedorTimbrado.php";

$proveedortimbrado=new ProveedorTimbrado();

$idProveedorTimbrado=isset($_POST["idProveedorTimbrado"])? limpiarCadena($_POST["idProveedorTimbrado"]):"";
$Persona_idPersona=isset($_POST["Persona_idPersona"])? limpiarCadena($_POST["Persona_idPersona"]):"";
$timbrado=isset($_POST["timbrado"])? limpiarCadena($_POST["timbrado"]):"";
$vtoTimbrado=isset($_POST["vtoTimbrado"])? limpiarCadena($_POST["vtoTimbrado"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idProveedorTimbrado)){
			$rspta=$proveedortimbrado->insertar($Persona_idPersona, $timbrado, $vtoTimbrado);
			echo $rspta ? "Proveedor timbrado registrado" : "Proveedor timbrado no se pudo registrar";
		}
		else {
			$rspta=$proveedortimbrado->editar($idProveedorTimbrado,$Persona_idPersona, $timbrado, $vtoTimbrado);
			echo $rspta ? "Proveedor timbrado actualizado" : "Proveedor timbrado no se pudo actualizar";
		}
	break;

	case 'mostrar':
		$rspta=$proveedortimbrado->mostrar($idProveedorTimbrado);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'desactivar':
		$rspta=$proveedortimbrado->desactivar($idProveedorTimbrado);
 		echo $rspta ? "proveedortimbrado Desactivado" : "proveedortimbrado no se puede desactivar";
	break;

	case 'activar':
		$rspta=$proveedortimbrado->activar($idProveedorTimbrado);
 		echo $rspta ? "proveedortimbrado activado" : "proveedortimbrado no se puede activar";
	break;


	case 'listar':
		$rspta=$proveedortimbrado->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idProveedorTimbrado.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idProveedorTimbrado.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idProveedorTimbrado.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idProveedorTimbrado.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->np,
 				"2"=>$reg->timbrado,
 				"3"=>$reg->vtoTimbrado,
 				"4"=>$reg->usuarioInsercion,
 				"5"=>$reg->fechaInsercion,
 				"6"=>$reg->uusarioModificacion,
 				"7"=>$reg->fechaModificacion,
 				"8"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
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

	case "selectTimbradoProveedor":

		$rspta = $proveedortimbrado->selectTimbradoProveedor($_POST['Proveedor_idProveedor']);
			echo '<option value="999">Seleccione una opcion</option>';
		$i=0;
		while ($reg = $rspta->fetchObject()) {

			if ($i==0) {
			$i=1;
			echo '<option selected value=' .$reg->idProveedorTimbrado. '>' .$reg->timbrado. '</option>';
			}else{
			echo '<option value=' .$reg->idProveedorTimbrado. '>' .$reg->timbrado. '</option>';
			}
		}

		break;


	case "selectproveedortimbrado":

		$rspta = $proveedortimbrado->selectproveedortimbrado();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idProveedorTimbrado. '>' .$reg->descripcion. '</option>';
		}

		break;

	case 'vencimientoTimbrado':
		$rspta=$proveedortimbrado->vencimientoTimbrado($_POST['idProveedorTimbrado']);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;


}
?>