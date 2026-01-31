<?php 
require_once "../modelos/cuentaContable.php";

$cuentaContable=new cuentaContable();
$idCuentaContable=isset($_POST["idCuentaContable"])? limpiarCadena($_POST["idCuentaContable"]):"";
$Proceso_idProceso=isset($_POST["Proceso_idProceso"])? limpiarCadena($_POST["Proceso_idProceso"]):"";
$CentroCosto_idCentroCosto=isset($_POST["CentroCosto_idCentroCosto"])? limpiarCadena($_POST["CentroCosto_idCentroCosto"]):"";
$nroCuentaContable=isset($_POST["nroCuentaContable"])? limpiarCadena($_POST["nroCuentaContable"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$tipoCuenta=isset($_POST["tipoCuenta"])? limpiarCadena($_POST["tipoCuenta"]):"";
$nivel=isset($_POST["nivel"])? limpiarCadena($_POST["nivel"]):"";
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
$CuentaContable_idCuentaContablePadre=isset($_POST["CuentaContable_idCuentaContablePadre"])? limpiarCadena($_POST["CuentaContable_idCuentaContablePadre"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar': 
		if (empty($idCuentaContable)){
			$rspta=$cuentaContable->insertar($Proceso_idProceso,$CentroCosto_idCentroCosto,$nroCuentaContable,$descripcion,$tipoCuenta,$nivel,$debitoAnterior,$creditoAnterior,$debitoEnero,$debitoFebrero,$debitoMarzo,$debitoAbril,$debitoMayo,$debitoJunio,$debitoJulio,$debitoAgosto,$debitoSetiembre,$debitoOctubre,$debitoNoviembre,$debitoDiciembre,$creditoEnero,$creditoFebrero,$creditoMarzo,$creditoAbril,$creditoMayo,$creditoJunio,$creditoJulio,$creditoAgosto,$creditoSetiembre,$creditoOctubre,$creditoNoviembre,$creditoDiciembre,$CuentaContable_idCuentaContablePadre); 
			echo $rspta ? "Cuenta contable registrada" : "Cuenta contable no se pudo registrar";  
		}
		else {
			$rspta=$cuentaContable->editar($idCuentaContable,$Proceso_idProceso,$CentroCosto_idCentroCosto,$nroCuentaContable,$descripcion,$tipoCuenta,$nivel,$debitoAnterior,$creditoAnterior,$debitoEnero,$debitoFebrero,$debitoMarzo,$debitoAbril,$debitoMayo,$debitoJunio,$debitoJulio,$debitoAgosto,$debitoSetiembre,$debitoOctubre,$debitoNoviembre,$debitoDiciembre,$creditoEnero,$creditoFebrero,$creditoMarzo,$creditoAbril,$creditoMayo,$creditoJunio,$creditoJulio,$creditoAgosto,$creditoSetiembre,$creditoOctubre,$creditoNoviembre,$creditoDiciembre,$CuentaContable_idCuentaContablePadre); 
			echo $rspta ? "Cuenta contable actualizada" : "Cuenta contable no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$cuentaContable->desactivar($idCuentaContable);
 		echo $rspta ? "Cuenta contable Desactivada" : "Cuenta contable no se puede desactivar";
	break;

	case 'activar':
		$rspta=$cuentaContable->activar($idCuentaContable);
 		echo $rspta ? "Cuenta contable activada" : "Cuenta contable no se puede activar";
	break;

	case 'mostrar':

		$rspta=$cuentaContable->mostrar($idCuentaContable);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$cuentaContable->listar();
 		//Vamos a declarar un array
 		$data= Array();
 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idCuentaContable.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idCuentaContable.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idCuentaContable.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idCuentaContable.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nroCuentaContable,
 				"2"=>$reg->descripcion,
 				"3"=>$reg->Proceso,
 				"4"=>$reg->centroCosto,
 				"5"=>$reg->tipoCuenta,    
 				"6"=>$reg->nivel,  
 				"7"=>$reg->descripcionPadre,          
 				"8"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
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

	case 'selectCentroCosto':	
		require_once "../modelos/centroDeCostos.php"; 
		$idCentroCosto = new CentroDeCostos();
		$rspta = $idCentroCosto->listar();

		while ($reg = $rspta->fetchObject())
				{
				echo '<option value=' . $reg->idCentroCosto . '>' . $reg->descripcion . '</option>';
				}
	break;
 
	case 'selectCuentaContablePadre':  
		require_once "../modelos/cuentaContable.php";  
		$idCuentaContable = new cuentaContable();
		$rspta = $idCuentaContable->listar();

		while ($reg = $rspta->fetchObject())  
				{
				echo '<option value=' . $reg->idCuentaContable . '>' . $reg->descripcion . '</option>';
				} 
	break;


	case 'selectCuentaContable':  
		$rspta = $cuentaContable->selectCuentaContable();

		while ($reg = $rspta->fetchObject())  
				{
				echo '<option value=' . $reg->idCuentaContable . '>' . $reg->descripcion . '</option>';
				} 
	break;

	


}
?>