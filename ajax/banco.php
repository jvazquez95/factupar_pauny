<?php 
require_once "../modelos/Banco.php";

$banco=new Banco();

$idBanco=isset($_POST["idBanco"])? limpiarCadena($_POST["idBanco"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$Moneda_idMoneda=isset($_POST["Moneda_idMoneda"])? limpiarCadena($_POST["Moneda_idMoneda"]):"";
$CuentaContable_idCuentaContable=isset($_POST["CuentaContable_idCuentaContable"])? limpiarCadena($_POST["CuentaContable_idCuentaContable"]):"";
$nroCuenta=isset($_POST["nroCuenta"])? limpiarCadena($_POST["nroCuenta"]):"";
$tipoCuenta=isset($_POST["tipoCuenta"])? limpiarCadena($_POST["tipoCuenta"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idBanco)){
			$rspta=$banco->insertar($descripcion,$Moneda_idMoneda,$CuentaContable_idCuentaContable,$nroCuenta,$tipoCuenta);
			echo $rspta ? "Banco registrado" : "Banco no se pudo registrar";  
		}
		else {
			$rspta=$banco->editar($idBanco,$descripcion,$Moneda_idMoneda,$CuentaContable_idCuentaContable,$nroCuenta,$tipoCuenta);
			echo $rspta ? "Banco actualizado" : "Banco no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$banco->desactivar($idBanco);
 		echo $rspta ? "Banco Desactivado" : "Banco no se puede desactivar";
	break;

	case 'activar':
		$rspta=$banco->activar($idBanco);
 		echo $rspta ? "Banco activado" : "Banco no se puede activar";
	break;

	case 'mostrar':
		$rspta=$banco->mostrar($idBanco);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$banco->listar();
 		//Vamos a declarar un array
 		$data= Array();
 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idBanco.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idBanco.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idBanco.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idBanco.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->descripcion,
 				"2"=>$reg->moneda,
 				"3"=>$reg->cuentacontable,    
 				"4"=>$reg->nroCuenta,  
 				"5"=>$reg->tipoCuenta,         
 				"6"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
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

	case 'selectMoneda':
		require_once "../modelos/Moneda.php"; 
		$idMoneda = new Moneda();
		$rspta = $idMoneda->listar();
				echo '<option value="">Seleccione una opcion</option>';

		while ($reg = $rspta->fetchObject())
				{
				echo '<option value=' . $reg->idMoneda . '>' . $reg->descripcion . '</option>';
				}
	break;
 

	case 'selectBanco':
		$rspta = $banco->selectBanco();
				echo '<option value="">Seleccione una opcion</option>';

		while ($reg = $rspta->fetchObject())
				{
				echo '<option value=' . $reg->idBanco . '>' . $reg->descripcion . '</option>';
				}
	break;

	case 'selectCuentaContable':  
		require_once "../modelos/cuentaContable.php";  
		$idCuentaContable = new cuentaContable();
		$rspta = $idCuentaContable->listar();
				echo '<option value="">Seleccione una opcion</option>';

		while ($reg = $rspta->fetchObject())  
				{
				echo '<option value=' . $reg->idCuentaContable . '>' . $reg->descripcion . '</option>';
				}
	break;

	case 'selectCuentaContableFiltro':  
		require_once "../modelos/cuentaContable.php";  
		$idCuentaContable = new cuentaContable();
		$rspta = $idCuentaContable->listarFiltro( $_POST['filtro'] );
				//echo '<option value="">Seleccione una opcion</option>';

		while ($reg = $rspta->fetchObject())  
				{
				echo '<option value=' . $reg->idCuentaContable . '>' . $reg->descripcion . '</option>';
				}
	break;



}
?>