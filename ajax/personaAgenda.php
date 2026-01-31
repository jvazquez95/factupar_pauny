<?php 
require_once "../modelos/PersonaAgenda.php";

$personaAgenda=new PersonaAgenda();

$idPersonaAgenda=isset($_POST["idPersonaAgenda"])? limpiarCadena($_POST["idPersonaAgenda"]):"";
$Persona_idPersona=isset($_POST["Persona_idPersona"])? limpiarCadena($_POST["Persona_idPersona"]):"";
$Direccion_idDireccion=isset($_POST["Direccion_idDireccion"])? limpiarCadena($_POST["Direccion_idDireccion"]):"";
$Sucursal_idSucursal=isset($_POST["Sucursal_idSucursal"])? limpiarCadena($_POST["Sucursal_idSucursal"]):"";
$Deposito_idDeposito=isset($_POST["Deposito_idDeposito"])? limpiarCadena($_POST["Deposito_idDeposito"]):"";
$Vehiculo_idVehiculo=isset($_POST["Vehiculo_idVehiculo"])? limpiarCadena($_POST["Vehiculo_idVehiculo"]):"";
$fechaVisita=isset($_POST["fechaVisita"])? limpiarCadena($_POST["fechaVisita"]):"";
$cantidad=isset($_POST["cantidad"])? limpiarCadena($_POST["cantidad"]):"";
$latitud=isset($_POST["latitud"])? limpiarCadena($_POST["latitud"]):"";
$longitud=isset($_POST["longitud"])? limpiarCadena($_POST["longitud"]):"";
$Dia_idDia=isset($_POST["Dia_idDia"])? limpiarCadena($_POST["Dia_idDia"]):""; 
switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idPersonaAgenda)){
			$rspta=$personaAgenda->insertar($Persona_idPersona, $fechaVisita, $cantidad,$latitud,$longitud, $Direccion_idDireccion, $Sucursal_idSucursal, $Deposito_idDeposito, $Vehiculo_idVehiculo,$Dia_idDia);
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
 				"1"=>'<button class="btn btn-primary" onclick="aprobar('.$reg->idPersonaAgenda.')">Confirmar<i class="fa fa-pencil"></i></button>',		
 				"2"=>$reg->np,
 				"3"=>$reg->fechaVisita,
 				"4"=>$reg->cantidad,
 				"5"=>$reg->usuarioIns,
 				"6"=>$reg->fechaIns,
 				"7"=>$reg->usuarioMod,
 				"8"=>$reg->fechaMod,
 				"9"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
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


	case 'aprobar':
		$rspta=$personaAgenda->aprobar($idPersonaAgenda);
 		echo $rspta ? "agenda confirmada" : "No se puede confirmar";
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