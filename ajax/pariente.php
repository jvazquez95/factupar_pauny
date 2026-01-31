<?php 
require_once "../modelos/Pariente.php";

$pariente=new Pariente();

$idPariente=isset($_POST["idPariente"])? limpiarCadena($_POST["idPariente"]):"";
$apellido=isset($_POST["apellido"])? limpiarCadena($_POST["apellido"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$nacimiento=isset($_POST["nacimiento"])? limpiarCadena($_POST["nacimiento"]):"";
$sexo=isset($_POST["sexo"])? limpiarCadena($_POST["sexo"]):"";
$parentezco=isset($_POST["parentezco"])? limpiarCadena($_POST["parentezco"]):"";
$observaciones=isset($_POST["observaciones"])? limpiarCadena($_POST["observaciones"]):"";
$EstadoCivil_idEstadoCivil=isset($_POST["EstadoCivil_idEstadoCivil"])? limpiarCadena($_POST["EstadoCivil_idEstadoCivil"]):"";
$dependiente=isset($_POST["dependiente"])? limpiarCadena($_POST["dependiente"]):"";
$Profesion_idProfesion=isset($_POST["Profesion_idProfesion"])? limpiarCadena($_POST["Profesion_idProfesion"]):"";
$Actividad_idActividad=isset($_POST["Actividad_idActividad"])? limpiarCadena($_POST["Actividad_idActividad"]):"";
$Pais_idPais=isset($_POST["Pais_idPais"])? limpiarCadena($_POST["Pais_idPais"]):"";
$Legajo_idLegajo=isset($_POST["Legajo_idLegajo"])? limpiarCadena($_POST["Legajo_idLegajo"]):"";

 
switch ($_GET["op"]){
	case 'guardaryeditar':

		if (empty($idPariente)){
			$rspta=$pariente->insertar($apellido,$nombre,$nacimiento,$sexo,$parentezco,$observaciones,$EstadoCivil_idEstadoCivil,$dependiente,$Profesion_idProfesion,$Actividad_idActividad,$Pais_idPais, $Legajo_idLegajo);
			echo $rspta ? "pariente registrado" : "pariente no se pudo registrar";
		}
		else {
			$rspta=$pariente->editar($idPariente,$apellido,$nombre,$nacimiento,$sexo,$parentezco,$observaciones,$EstadoCivil_idEstadoCivil,$dependiente,$Profesion_idProfesion,$Actividad_idActividad,$Pais_idPais, $Legajo_idLegajo);
			echo $rspta ? "pariente actualizado" : "pariente no se pudo actualizar";
		}
	break;

	case 'mostrar':
		$rspta=$pariente->mostrar($idPariente);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'desactivar':
		$rspta=$pariente->desactivar($idPariente);
 		echo $rspta ? "pariente Desactivado" : "pariente no se puede desactivar";
	break;

	case 'activar':
		$rspta=$pariente->activar($idPariente);
 		echo $rspta ? "pariente activado" : "pariente no se puede activar";
	break;


	case 'listar':
		$rspta=$pariente->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			if ($reg->sexo == 1) {
 				$sexo = 'Masculino';
 			}else{
 				$sexo = 'Femenino';
 			}


 			if ($reg->parentezco == 1) {
 				$parentezco = 'Padre';
 			}elseif ($reg->parentezco == 2) {
 				$parentezco = 'Madre';
 				
 			}elseif ($reg->parentezco == 3) {
 				$parentezco = 'Conyuge';
 				
 			}elseif ($reg->parentezco == 4) {
 				$parentezco = 'Hijo';
 			}elseif ($reg->parentezco == 5) {
 				$parentezco = 'Otro';
 			}


 			if ($reg->dependiente == 1) {
 				$dependiente = 'Si';
 			}else{
 				$dependiente = 'No';
 			}

 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idPariente.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idPariente.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idPariente.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idPariente.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombreLegajo,
 				"2"=>$reg->apellido .', '. $reg->nombre,
 				"3"=>$reg->nacimiento,
 				"4"=>$sexo,
 				"5"=>$parentezco,
 				"6"=>$reg->observaciones,
 				"7"=>$reg->nombreEC,
 				"8"=>$dependiente,
 				"9"=>$reg->nombreProfesion,
 				"10"=>$reg->Actividad_idActividad,
 				"11"=>$reg->nombrePais,
 				"12"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
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




	case 'listar_x_legajo':
		$rspta=$pariente->listar_x_legajo($Legajo_idLegajo);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idPariente.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idPariente.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idPariente.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idPariente.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->Legajo_idLegajo,
 				"2"=>$reg->apellido .', '. $reg->nombre,
 				"3"=>$reg->nacimiento,
 				"4"=>$reg->sexo,
 				"5"=>$reg->parentezco,
 				"6"=>$reg->observaciones,
 				"7"=>$reg->EstadoCivil_idEstadoCivil,
 				"8"=>$reg->dependiente,
 				"9"=>$reg->Profesion_idProfesion,
 				"10"=>$reg->Actividad_idActividad,
 				"11"=>$reg->Pais_idPais,
 				"12"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
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




	case "selectPariente":

		$rspta = $pariente->selectPariente();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idPariente. '>' .$reg->parentezco. '</option>';
		}

		break;
	

}
?>