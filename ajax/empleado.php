<?php 
require_once "../modelos/Empleado.php";

$empleado=new Empleado();

$idEmpleado=isset($_POST["idEmpleado"])? limpiarCadena($_POST["idEmpleado"]):"";
$razonSocial=isset($_POST["razonSocial"])? limpiarCadena($_POST["razonSocial"]):"";
$nombreComercial=isset($_POST["nombreComercial"])? limpiarCadena($_POST["nombreComercial"]):"";
$tipoDocumento=isset($_POST["tipoDocumento"])? limpiarCadena($_POST["tipoDocumento"]):"";
$nroDocumento=isset($_POST["nroDocumento"])? limpiarCadena($_POST["nroDocumento"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$celular=isset($_POST["celular"])? limpiarCadena($_POST["celular"]):"";
$mail=isset($_POST["mail"])? limpiarCadena($_POST["mail"]):"";
$moneda=isset($_POST["moneda"])? limpiarCadena($_POST["moneda"]):"";
$sitioWeb=isset($_POST["sitioWeb"])? limpiarCadena($_POST["sitioWeb"]):"";
$idCategoriaCliente=isset($_POST["idCategoriaCliente"])? limpiarCadena($_POST["idCategoriaCliente"]):"";
$terminoPago=isset($_POST["terminoPago"])? limpiarCadena($_POST["terminoPago"]):"";
$terminoPagoHabilitado=isset($_POST["terminoPagoHabilitado"])? limpiarCadena($_POST["terminoPagoHabilitado"]):"";
$nacimiento=isset($_POST["nacimiento"])? limpiarCadena($_POST["nacimiento"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':

		if (empty($idEmpleado)){
			$rspta=$empleado->insertar($razonSocial,$nombreComercial,$tipoDocumento,$nroDocumento,$nacimiento,$direccion,$telefono,$celular,$mail,$moneda,$sitioWeb,$idCategoriaCliente,$terminoPago,$terminoPagoHabilitado);
			echo $rspta ? "empleado registrado" : "empleado no se pudo registrar";
		}
		else {
			$rspta=$empleado->editar($idEmpleado,$razonSocial,$nombreComercial,$tipoDocumento,$nroDocumento,$nacimiento,$direccion,$telefono,$celular,$mail,$moneda,$sitioWeb,$idCategoriaCliente,$terminoPago,$terminoPagoHabilitado);
			echo $rspta ? "empleado actualizado" : "empleado no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$empleado->desactivar($idEmpleado);
 		echo $rspta ? "empleado Desactivado" : "empleado no se puede desactivar";
	break;

	case 'activar':
		$rspta=$empleado->activar($idEmpleado);
 		echo $rspta ? "empleado activado" : "empleado no se puede activar";
	break;

	case 'mostrar':
		$rspta=$empleado->mostrar($idEmpleado);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$empleado->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idEmpleado.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idEmpleado.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idEmpleado.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idEmpleado.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->razonSocial,
 				"2"=>$reg->nombreComercial,
 				"3"=>$reg->nroDocumento,
 				"4"=>$reg->nacimiento,
 				"5"=>$reg->direccion,
 				"6"=>$reg->telefono,
 				"7"=>$reg->celular,
 				"8"=>$reg->mail,
 				"9"=>$reg->idCategoriaCliente,
 				"10"=>$reg->terminoPagoHabilitado,
 				"11"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
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

	case "selectCategoria":
		require_once "../modelos/Categoriaempleado.php";
		$categoria = new Categoriaempleado();

		$rspta = $categoria->select();

		while ($reg = $rspta->fetchObject())
				{
					echo '<option value=' . $reg->idCategoriaCliente . '>' . $reg->descripcion . '</option>';
				}
	break;

	case "selectEmpleado":
		require_once "../modelos/Empleado.php";
		$empleado = new Empleado();

		$rspta = $empleado->listarActivos();

		while ($reg = $rspta->fetchObject())
				{
					echo '<option value=' . $reg->idEmpleado . '>' . $reg->razonSocial . '</option>';
				}
	break;

	case "selectEmpleadoTodos":
		require_once "../modelos/Empleado.php";
		$empleado = new Empleado();
		echo '<option value="%%">Todos...</option>';
		
		$rspta = $empleado->listarActivos();

		while ($reg = $rspta->fetchObject())
				{
					echo '<option value=' . $reg->idEmpleado . '>' . $reg->razonSocial . '</option>';
				}
	break;	
/*
	case "selectImpuesto":
		require_once "../modelos/TipoImpuesto.php";
		$impuesto = new TipoImpuesto();

		$rspta = $impuesto->select();

		while ($reg = $rspta->fetchObject())
				{
					echo '<option value=' . $reg->idTipoImpuesto . '>' . $reg->descripcion . '</option>';
				}
	break;

	case "selectUnidad":
		require_once "../modelos/Unidad.php";
		$unidad = new Unidad();

		$rspta = $unidad->select();

		while ($reg = $rspta->fetchObject())
				{
					echo '<option value=' . $reg->idUnidad . '>' . $reg->descripcion . '</option>';
				}
	break;*/
}
?>