<?php 
require_once "../modelos/cuentaBancaria.php";

$cuentaBancaria=new cuentaBancaria();

$idCuentaBancaria=isset($_POST["idCuentaBancaria"])? limpiarCadena($_POST["idCuentaBancaria"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$Moneda_idMoneda=isset($_POST["Moneda_idMoneda"])? limpiarCadena($_POST["Moneda_idMoneda"]):"";
$Banco_idBanco=isset($_POST["Banco_idBanco"])? limpiarCadena($_POST["Banco_idBanco"]):"";
$CuentaContable_idCuentaContable=isset($_POST["CuentaContable_idCuentaContable"])? limpiarCadena($_POST["CuentaContable_idCuentaContable"]):"";
$nroCuenta=isset($_POST["nroCuenta"])? limpiarCadena($_POST["nroCuenta"]):"";
$tipoCuenta=isset($_POST["tipoCuenta"])? limpiarCadena($_POST["tipoCuenta"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':   
		if (empty($idCuentaBancaria)){
			$rspta=$cuentaBancaria->insertar($Moneda_idMoneda,$Banco_idBanco,$descripcion,$tipoCuenta,$CuentaContable_idCuentaContable);
			echo $rspta ? "Cuenta bancaria registrada" : "Cuenta bancaria no se pudo registrar";  
		}
		else {
			$rspta=$cuentaBancaria->editar($idCuentaBancaria,$Moneda_idMoneda,$Banco_idBanco,$descripcion,$tipoCuenta,$CuentaContable_idCuentaContable);
			echo $rspta ? "Cuenta bancaria actualizada" : "Cuenta bancaria no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$cuentaBancaria->desactivar($idCuentaBancaria);
 		echo $rspta ? "Cuenta bancaria Desactivada" : "Cuenta bancaria no se puede desactivar";
	break;

	case 'activar':
		$rspta=$cuentaBancaria->activar($idCuentaBancaria);
 		echo $rspta ? "Cuenta bancaria activada" : "Cuenta bancaria no se puede activar";
	break;

	case 'mostrar':
		$rspta=$cuentaBancaria->mostrar($idCuentaBancaria);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$cuentaBancaria->listar();
 		//Vamos a declarar un array
 		$data= Array();
 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idCuentaBancaria.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idCuentaBancaria.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idCuentaBancaria.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idCuentaBancaria.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->descripcion,
 				"2"=>$reg->moneda,
 				"3"=>$reg->cuentacontable,    
 				"4"=>$reg->banco,  
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

		while ($reg = $rspta->fetchObject())
				{
				echo '<option value=' . $reg->idMoneda . '>' . $reg->descripcion . '</option>';
				}  
	break;

	case 'selectBanco':
		require_once "../modelos/Banco.php"; 
		$idBanco = new Banco();
		$rspta = $idBanco->listar();

		while ($reg = $rspta->fetchObject())
				{
				echo '<option value=' . $reg->idBanco . '>' . $reg->descripcion . '</option>';
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


}
?>