<?php 
require_once "../modelos/PersonaAgenda.php";

$personaAgenda=new PersonaAgenda();

$idPersonaAgenda=isset($_POST["idPersonaAgenda"])? limpiarCadena($_POST["idPersonaAgenda"]):"";
$Persona_idPersona=isset($_POST["Persona_idPersona"])? limpiarCadena($_POST["Persona_idPersona"]):"";
$fechaVisita=isset($_POST["fechaVisita"])? limpiarCadena($_POST["fechaVisita"]):"";
$cantidad=isset($_POST["cantidad"])? limpiarCadena($_POST["cantidad"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idPersonaAgenda)){
			$rspta=$personaAgenda->insertar($Persona_idPersona, $fechaVisita, $cantidad);
			echo $rspta ? "Agenda asiganda" : "Agenda no fue posible asignar";
		}
		else {
			$rspta=$personaAgenda->editar($idPersonaAgenda,$Persona_idPersona, $fechaVisita, $cantidad);
			echo $rspta ? "Agenda actualizado" : "Agendao no se pudo actualizar";
		}
	break;

	case 'mostrar':
		$rspta=$personaAgenda->mostrar($idPersonaAgenda);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'desactivar':
		$rspta=$personaAgenda->desactivar($idPersonaAgenda);
 		echo $rspta ? "personaAgenda Desactivado" : "personaAgenda no se puede desactivar";
	break;

	case 'activar':
		$rspta=$personaAgenda->activar($idPersonaAgenda);
 		echo $rspta ? "personaAgenda activado" : "personaAgenda no se puede activar";
	break;


	case 'listar':
		$rspta=$personaAgenda->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idPersonaAgenda.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idPersonaAgenda.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idPersonaAgenda.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idPersonaAgenda.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->np,
 				"2"=>$reg->fechaVisita,
 				"3"=>$reg->cantidad,
 				"4"=>$reg->usuarioIns,
 				"5"=>$reg->fechaIns,
 				"6"=>$reg->usuarioMod,
 				"7"=>$reg->fechaMod,
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

		$rspta = $personaAgenda->selectTimbradoProveedor($_POST['Proveedor_idProveedor']);
			echo '<option value="999">Seleccione una opcion</option>';
		$i=0;
		while ($reg = $rspta->fetchObject()) {

			if ($i==0) {
			$i=1;
			echo '<option selected value=' .$reg->idPersonaAgenda. '>' .$reg->timbrado. '</option>';
			}else{
			echo '<option value=' .$reg->idPersonaAgenda. '>' .$reg->timbrado. '</option>';
			}
		}

		break;


	case "selectpersonaAgenda":

		$rspta = $personaAgenda->selectpersonaAgenda();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idPersonaAgenda. '>' .$reg->descripcion. '</option>';
		}

		break;

	case 'vencimientoTimbrado':
		$rspta=$personaAgenda->vencimientoTimbrado($_POST['idPersonaAgenda']);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;


}
?>