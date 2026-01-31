<?php 
require_once "../modelos/Proceso.php";

$Proceso=new Proceso();

$idProceso=isset($_POST["idProceso"])? limpiarCadena($_POST["idProceso"]):"";
$Persona_idPersonaProveedor=isset($_POST["Persona_idPersonaProveedor"])? limpiarCadena($_POST["Persona_idPersonaProveedor"]):"";
$ano=isset($_POST["ano"])? limpiarCadena($_POST["ano"]):"";
$Persona_idPersonaDirectivo1=isset($_POST["Persona_idPersonaDirectivo1"])? limpiarCadena($_POST["Persona_idPersonaDirectivo1"]):"";
$cargo1=isset($_POST["cargo1"])? limpiarCadena($_POST["cargo1"]):"";
$Persona_idPersonaDirectivo2=isset($_POST["Persona_idPersonaDirectivo2"])? limpiarCadena($_POST["Persona_idPersonaDirectivo2"]):"";
$cargo2=isset($_POST["cargo2"])? limpiarCadena($_POST["cargo2"]):"";
$rucContador=isset($_POST["rucContador"])? limpiarCadena($_POST["rucContador"]):"";
$Proceso_idProcesoApertura=isset($_POST["Proceso_idProcesoApertura"])? limpiarCadena($_POST["Proceso_idProcesoApertura"]):"";
$fechaEjecucion=isset($_POST["fechaEjecucion"])? limpiarCadena($_POST["fechaEjecucion"]):"";
$Asiento_idAsientoCierre=isset($_POST["Asiento_idAsientoCierre"])? limpiarCadena($_POST["Asiento_idAsientoCierre"]):"";
$fechaCierre=isset($_POST["fechaCierre"])? limpiarCadena($_POST["fechaCierre"]):""; 

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idProceso)){
			$rspta=$Proceso->insertar($Persona_idPersonaProveedor,$ano,$Persona_idPersonaDirectivo1,$cargo1,$Persona_idPersonaDirectivo2,$cargo2,$rucContador,$Proceso_idProcesoApertura,$fechaEjecucion,$Asiento_idAsientoCierre,$fechaCierre);
			echo $rspta ? "Proceso registrado" : "Proceso no se pudo registrar";  
		}
		else {
			$rspta=$Proceso->editar($idProceso,$Persona_idPersonaProveedor,$ano,$Persona_idPersonaDirectivo1,$cargo1,$Persona_idPersonaDirectivo2,$cargo2,$rucContador,$Proceso_idProcesoApertura,$fechaEjecucion,$Asiento_idAsientoCierre,$fechaCierre);
			echo $rspta ? "Proceso actualizado" : "Proceso no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$Proceso->desactivar($idProceso);
 		echo $rspta ? "Proceso Desactivado" : "Proceso no se puede desactivar";
	break;

	case 'activar':
		$rspta=$Proceso->activar($idProceso);
 		echo $rspta ? "Proceso activado" : "Proceso no se puede activar";
	break;

	case 'mostrar':
		$rspta=$Proceso->mostrar($idProceso);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$Proceso->listar();
 		//Vamos a declarar un array
 		$data= Array();
 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idProceso.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idProceso.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idProceso.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idProceso.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->ano,
 				"2"=>$reg->rucContador,
 				"3"=>$reg->procesoApertura,    
 				"4"=>$reg->fechaCierre,  
 				"5"=>$reg->fechaEjecucion,   
 				"6"=>$reg->AsientoCierre,         
 				"7"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
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

	case 'selectProveedor': 
		require_once "../modelos/Persona.php"; 
		$idPersonaP = new Persona();
		$rspta = $idPersonaP->selectProveedor();  

		while ($reg = $rspta->fetchObject())
				{
				echo '<option value=' . $reg->idPersona . '>' . $reg->razonSocial . '</option>';
				}
	break;
 
 	case 'selectFuncionario':
		require_once "../modelos/Persona.php"; 
		$idPersonaF = new Persona();
		$rspta = $idPersonaF->selectFuncionario();

		while ($reg = $rspta->fetchObject())
				{
				echo '<option value=' . $reg->idPersona . '>' . $reg->razonSocial . '</option>';
				}
	break;
 
  	case 'selectFuncionario2':
		require_once "../modelos/Persona.php"; 
		$idPersonaD = new Persona();
		$rspta = $idPersonaD->selectFuncionario(); 

		while ($reg = $rspta->fetchObject())
				{
				echo '<option value=' . $reg->idPersona . '>' . $reg->razonSocial . '</option>';
				}
	break;

	case 'selectProceso': 
		require_once "../modelos/Proceso.php";    
		$idProcesoN = new Proceso();
		$rspta1 = $idProcesoN->listarActivos();

		while ($reg1 = $rspta1->fetchObject())
				{
				echo '<option value=' . $reg1->idProceso . '>' . $reg1->ano . '</option>';
				}
	break;
 
  
	case 'selectAsiento':
		require_once "../modelos/Asiento.php"; 
		$idAsiento = new Asiento();
		$rspta = $idAsiento->listar();

		while ($reg = $rspta->fetchObject())
				{
				echo '<option value=' . $reg->idAsiento . '>' . $reg->idAsiento . '</option>';
				}
	break;
 
 

}
?>