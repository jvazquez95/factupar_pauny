<?php 
require_once "../modelos/TiposDocumentos.php";

$tipoDocumento=new TipoDocumento();  

$idTipoDocumento=isset($_POST["idTipoDocumento"])? limpiarCadena($_POST["idTipoDocumento"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$CuentaContable_idCuentaContable=isset($_POST["CuentaContable_idCuentaContable"])? limpiarCadena($_POST["CuentaContable_idCuentaContable"]):"";
$Proceso_idProceso=isset($_POST["Proceso_idProceso"])? limpiarCadena($_POST["Proceso_idProceso"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idTipoDocumento)){
			$rspta=$tipoDocumento->insertar($descripcion,$CuentaContable_idCuentaContable,$Proceso_idProceso);
			echo $rspta ? "Tipo documento registrado" : "Tipo documento no se pudo registrar";
		}
		else {
			$rspta=$tipoDocumento->editar($idTipoDocumento,$descripcion,$CuentaContable_idCuentaContable,$Proceso_idProceso);
			echo $rspta ? "Tipo documento actualizado" : "Tipo documento no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$tipoDocumento->desactivar($idTipoDocumento);
 		echo $rspta ? "Tipo Documento Desactivado" : "Tipo Documento no se puede desactivar";
	break;

	case 'activar':
		$rspta=$tipoDocumento->activar($idTipoDocumento);
 		echo $rspta ? "Tipo Documento activado" : "Tipo Documento no se puede activar";
	break;

	case 'mostrar':
		$rspta=$tipoDocumento->mostrar($idTipoDocumento);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$tipoDocumento->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idTipoDocumento.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idTipoDocumento.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idTipoDocumento.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idTipoDocumento.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->descripcion,
 				"2"=>$reg->descripcionCuenta,
 				"3"=>$reg->ano,
 				"4"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
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


	case 'selectCuentaContable':
		require_once "../modelos/cuentaContable.php"; 
		$idCuentaContable = new cuentaContable();
		$rspta = $idCuentaContable->listar();

		while ($reg = $rspta->fetchObject())
				{
				echo '<option value=' . $reg->idCuentaContable . '>' . $reg->descripcion . '</option>';
				}
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

}
?>