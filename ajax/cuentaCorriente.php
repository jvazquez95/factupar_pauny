<?php 
require_once "../modelos/cuentaCorriente.php";

$cuentaCorriente=new cuentaCorriente();

$idCuentaCorriente=isset($_POST["idCuentaCorriente"])? limpiarCadena($_POST["idCuentaCorriente"]):"";
$Proceso_idProceso=isset($_POST["Proceso_idProceso"])? limpiarCadena($_POST["Proceso_idProceso"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$debitoAnterior=isset($_POST["debitoAnterior"])? limpiarCadena($_POST["debitoAnterior"]):"";
$creditoAnterior=isset($_POST["creditoAnterior"])? limpiarCadena($_POST["creditoAnterior"]):"";
$debitoEnero=isset($_POST["debitoEnero"])? limpiarCadena($_POST["debitoEnero"]):"";
$debitoFebrero=isset($_POST["debitoFebrero"])? limpiarCadena($_POST["debitoFebrero"]):"";
$debitoMarzo=isset($_POST["debitoMarzo"])? limpiarCadena($_POST["debitoMarzo"]):"";
$debitoAbril=isset($_POST["debitoAbril"])? limpiarCadena($_POST["debitoAbril"]):"";
$debitoMayo=isset($_POST["debitoMayo"])? limpiarCadena($_POST["debitoMayo"]):"";
$debitoJunio=isset($_POST["debitoJunio"])? limpiarCadena($_POST["debitoJunio"]):"";
$debitoJulio=isset($_POST["debitoJulio"])? limpiarCadena($_POST["debitoJulio"]):"";
$debitoAgosto=isset($_POST["debitoAgosto"])? limpiarCadena($_POST["debitoAgosto"]):"";
$debitoSetiembre=isset($_POST["debitoSetiembre"])? limpiarCadena($_POST["debitoSetiembre"]):"";
$debitoOctubre=isset($_POST["debitoOctubre"])? limpiarCadena($_POST["debitoOctubre"]):"";
$debitoNoviembre=isset($_POST["debitoNoviembre"])? limpiarCadena($_POST["debitoNoviembre"]):"";
$debitoDiciembre=isset($_POST["debitoDiciembre"])? limpiarCadena($_POST["debitoDiciembre"]):"";
$creditoEnero=isset($_POST["creditoEnero"])? limpiarCadena($_POST["creditoEnero"]):"";
$creditoFebrero=isset($_POST["creditoFebrero"])? limpiarCadena($_POST["creditoFebrero"]):"";
$creditoMarzo=isset($_POST["creditoMarzo"])? limpiarCadena($_POST["creditoMarzo"]):"";
$creditoAbril=isset($_POST["creditoAbril"])? limpiarCadena($_POST["creditoAbril"]):"";
$creditoMayo=isset($_POST["creditoMayo"])? limpiarCadena($_POST["creditoMayo"]):"";
$creditoJunio=isset($_POST["creditoJunio"])? limpiarCadena($_POST["creditoJunio"]):"";
$creditoJulio=isset($_POST["creditoJulio"])? limpiarCadena($_POST["creditoJulio"]):"";
$creditoAgosto=isset($_POST["creditoAgosto"])? limpiarCadena($_POST["creditoAgosto"]):"";
$creditoSetiembre=isset($_POST["creditoSetiembre"])? limpiarCadena($_POST["creditoSetiembre"]):"";
$creditoOctubre=isset($_POST["creditoOctubre"])? limpiarCadena($_POST["creditoOctubre"]):"";
$creditoNoviembre=isset($_POST["creditoNoviembre"])? limpiarCadena($_POST["creditoNoviembre"]):"";
$creditoDiciembre=isset($_POST["creditoDiciembre"])? limpiarCadena($_POST["creditoDiciembre"]):"";
$CuentaContable_idCuentaContable=isset($_POST["CuentaContable_idCuentaContable"])? limpiarCadena($_POST["CuentaContable_idCuentaContable"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':   
		if (empty($idCuentaCorriente)){
			$rspta=$cuentaCorriente->insertar($Proceso_idProceso,$CuentaContable_idCuentaContable,$descripcion,$debitoAnterior,$creditoAnterior,$debitoEnero,$debitoFebrero,$debitoMarzo,$debitoAbril,$debitoMayo,$debitoJunio,$debitoJulio,$debitoAgosto,$debitoSetiembre,$debitoOctubre,$debitoNoviembre,$debitoDiciembre,$creditoEnero,$creditoFebrero,$creditoMarzo,$creditoAbril,$creditoMayo,$creditoJunio,$creditoJulio,$creditoAgosto,$creditoSetiembre,$creditoOctubre,$creditoNoviembre,$creditoDiciembre); 
			echo $rspta ? "Cuenta corriente registrada" : "Cuenta corriente no se pudo registrar";  
		}
		else {
			$rspta=$cuentaCorriente->editar($idCuentaCorriente,$Proceso_idProceso,$CuentaContable_idCuentaContable,$descripcion,$debitoAnterior,$creditoAnterior,$debitoEnero,$debitoFebrero,$debitoMarzo,$debitoAbril,$debitoMayo,$debitoJunio,$debitoJulio,$debitoAgosto,$debitoSetiembre,$debitoOctubre,$debitoNoviembre,$debitoDiciembre,$creditoEnero,$creditoFebrero,$creditoMarzo,$creditoAbril,$creditoMayo,$creditoJunio,$creditoJulio,$creditoAgosto,$creditoSetiembre,$creditoOctubre,$creditoNoviembre,$creditoDiciembre); 
			echo $rspta ? "Cuenta corriente actualizada" : "Cuenta corriente no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$cuentaCorriente->desactivar($idCuentaCorriente);
 		echo $rspta ? "Cuenta corriente Desactivada" : "Cuenta corriente no se puede desactivar";
	break;

	case 'activar':
		$rspta=$cuentaCorriente->activar($idCuentaCorriente);
 		echo $rspta ? "Cuenta corriente activada" : "Cuenta corriente no se puede activar";
	break;

	case 'mostrar':
		$rspta=$cuentaCorriente->mostrar($idCuentaCorriente);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$cuentaCorriente->listar();
 		//Vamos a declarar un array
 		$data= Array();
 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idCuentaCorriente.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idCuentaCorriente.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idCuentaCorriente.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idCuentaCorriente.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->descripcion,
 				"2"=>$reg->Proceso,
 				"3"=>$reg->cuentaContable,          
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

	case 'selectProceso':
		require_once "../modelos/Proceso.php"; 
		$idProceso = new Proceso();
		$rspta = $idProceso->listar();

		while ($reg = $rspta->fetchObject())
				{
				echo '<option value=' . $reg->idProceso . '>' . $reg->ano . '</option>';
				}  
	break;

	case 'selectCuentaContable':  
		require_once "../modelos/cuentaContable.php";  
		$idCuentaContable = new cuentaContable();
		$rspta = $idCuentaContable->listar();

		while ($reg = $rspta->fetchObject())  
				{
				echo '<option value=' . $reg->idCuentaContable . '>' . $reg->descripcion . '</option>';
				} 
	break;


	case 'selectCuentaCorriente':  
		$rspta = $cuentaCorriente->selectCuentaCorriente();

		while ($reg = $rspta->fetchObject())  
				{
				echo '<option value=' . $reg->idCuentaCorriente . '>' . $reg->descripcion . '</option>';
				} 
	break;



	case 'selectCuentaCorrienteBanco':  
		$rspta = $cuentaCorriente->selectCuentaCorriente();

		while ($reg = $rspta->fetchObject())  
				{
				echo '<option value=' . $reg->idCuentaCorriente . '>' . $reg->descripcion . '</option>';
				} 
	break;



}
?>