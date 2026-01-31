<?php 
require_once "../modelos/OrdenConsumision.php";

$orden=new Orden();

$idOrdenConsumision=isset($_POST["idOrdenConsumision"])? limpiarCadena($_POST["idOrdenConsumision"]):"";
$Empleado_idEmpleado=isset($_POST["Empleado_idEmpleado"])? limpiarCadena($_POST["Empleado_idEmpleado"]):"";
$fechaConsumision=isset($_POST["fechaConsumision"])? limpiarCadena($_POST["fechaConsumision"]):"";
$Cliente_idCliente=isset($_POST["Cliente_idCliente"])? limpiarCadena($_POST["Cliente_idCliente"]):"";
$lcliente=isset($_POST["lcliente"])? limpiarCadena($_POST["lcliente"]):"";
$lpaquete=isset($_POST["lpaquete"])? limpiarCadena($_POST["lpaquete"]):"";
// $codigo=isset($_POST["codigo"])? limpiarCadena($_POST["codigo"]):"";
// $codigoBarra=isset($_POST["codigoBarra"])? limpiarCadena($_POST["codigoBarra"]):"";
// $codigoAlternativo=isset($_POST["codigoAlternativo"])? limpiarCadena($_POST["codigoAlternativo"]):"";
// $tipoorden=isset($_POST["tipoorden"])? limpiarCadena($_POST["tipoorden"]):"";
// $Grupoorden_idGrupoorden=isset($_POST["Grupoorden_idGrupoorden"])? limpiarCadena($_POST["Grupoorden_idGrupoorden"]):"";
// $Categoria_idCategoria=isset($_POST["Categoria_idCategoria"])? limpiarCadena($_POST["Categoria_idCategoria"]):"";
// $TipoImpuesto_idTipoImpuesto=isset($_POST["TipoImpuesto_idTipoImpuesto"])? limpiarCadena($_POST["TipoImpuesto_idTipoImpuesto"]):"";
// $Unidad_idUnidad=isset($_POST["Unidad_idUnidad"])? limpiarCadena($_POST["Unidad_idUnidad"]):"";
// $precioVenta=isset($_POST["precioVenta"])? limpiarCadena($_POST["precioVenta"]):"";
// $usuarioInsercion=isset($_POST["usuarioInsercion"])? limpiarCadena($_POST["usuarioInsercion"]):"";
// $usuarioModificacion=isset($_POST["usuarioModificacion"])? limpiarCadena($_POST["usuarioModificacion"]):"";
// $imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";
// $comisiongs=isset($_POST["comisiongs"])? limpiarCadena($_POST["comisiongs"]):"";
// $comisionp=isset($_POST["comisionp"])? limpiarCadena($_POST["comisionp"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':

		if (empty($idorden)){
			$rspta=$orden->insertar($Empleado_idEmpleado, $fechaConsumision, $Cliente_idCliente, $_POST['idPaquete'], $_POST['idServicio'], $_POST['cantidad'], $_POST['cantidad_utilizada'], $_POST['idEmpleado'],$_POST['fi'],$_POST['ff'],$_POST['sala']);
			echo $rspta ? "Artículo registrado" : "Artículo no se pudo registrar";
		}
		/*else {
			$rspta=$orden->editar($idorden, $nombre,$descripcion,$codigo,$codigoBarra,$codigoAlternativo,$tipoorden,$Grupoorden_idGrupoorden,$Categoria_idCategoria,$TipoImpuesto_idTipoImpuesto,$Unidad_idUnidad,$precioVenta,$usuarioModificacion,$imagen);
			echo $rspta ? "Artículo actualizado" : "Artículo no se pudo actualizar";
		}*/
	break;

	case 'desactivar':
		$rspta=$orden->desactivar($idOrdenConsumision);
 		echo $rspta ? "Orden de consumision Desactivado" : "Orden de consumision no se puede desactivar";
	break;

	case 'activar':
		$rspta=$orden->activar($idorden);
 		echo $rspta ? "Artículo activado" : "Artículo no se puede activar";
	break;

	case 'mostrar':
		$rspta=$orden->mostrar($idorden);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listarDetalle':
		$id = $_REQUEST['id'];
		$rspta=$orden->listarDetalle($id);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>$reg->id,
 				"1"=>$reg->id2,
 				"2"=>$reg->paquete,
 				"3"=>$reg->servicio,
 				"4"=>$reg->ne,
 				"5"=>$reg->cantidad,
 				"6"=>$reg->cantidadUtilizada,
 				"7"=>$reg->fecha_inicial,
 				"8"=>$reg->fecha_final
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;




	case 'listar':
		$rspta=$orden->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->estado)?''.
 					' <button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->idOrdenConsumision.')"><i class="fa fa-close"></i></button>':
 					'',
 				"1"=>$reg->idOrdenConsumision,
 				"2"=>$reg->fechaConsumision,
 				"3"=>$reg->nc,
 				"4"=>$reg->usuarioIns,
 				"5"=>$reg->fechaInicial,
 				"6"=>(!$reg->estado)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>',
 				"7"=>'<button class="btn btn-primary" onclick="mostrarDetalle('.$reg->idOrdenConsumision.')">Ver detalle de orden <i class="fa fa-pencil"></i></button>',
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
		require_once "../modelos/Categoria.php";
		$categoria = new Categoria();

		$rspta = $categoria->select();

		while ($reg = $rspta->fetchObject())
				{
					echo '<option value=' . $reg->idCategoria . '>' . $reg->nombre . '</option>';
				}
	break;

	case "selectGrupo":
		require_once "../modelos/Grupoorden.php";
		$grupo = new Grupoorden();

		$rspta = $grupo->select();

		while ($reg = $rspta->fetchObject())
				{
					echo '<option value=' . $reg->idGrupoorden . '>' . $reg->nombre . '</option>';
				}
	break;

	case 'selectEmpleado':
		require_once "../modelos/Empleado.php";
		$empleado = new Empleado();

		$rspta = $empleado->listarActivos();
		
		echo '<option value="000">Seleccione una opcion</option>';

		while ($reg = $rspta->fetchObject())
		{
			echo '<option value=' . $reg->idEmpleado . '>' . $reg->razonSocial . ' </option>';
		}
	break;

	case 'selectServicio':
		require_once "../modelos/OrdenConsumision.php";
		$oc = new Orden();

		$rspta = $oc->listarServicios();

		while ($reg = $rspta->fetchObject())
				{

				echo '<option value=' . $reg->id . '>' . $reg->SERVICIO . ' ' . $reg->cantidad  . '</option>';
				}
	break;

	case 'selectServicioCliente':
		require_once "../modelos/OrdenConsumision.php";
		$oc = new Orden();
		echo '<option value="0">Seleccione una opcion</option>';

		$rspta = $oc->listarServiciosCliente($lcliente);

		while ($reg = $rspta->fetchObject())
				{
				echo '<option value=' . $reg->idclientedetalle . '>' . $reg->NS . ' ' . $reg->cantidad  .'</option>';
				}
	break;


	case 'selectServicioClientePaquete':
		require_once "../modelos/OrdenConsumision.php";
		$oc = new Orden();
		echo '<option value="0">Seleccione una opcion</option>';

		$rspta = $oc->listarServiciosClientePaquete($lcliente,$lpaquete);

		while ($reg = $rspta->fetchObject())
				{
				echo '<option value=' . $reg->idclientedetalle . '> ' . $reg->NNN . ' Disponible: ' . $reg->cantidad  .'</option>';
				}
	break;



	case 'selectPaquete':
		require_once "../modelos/OrdenConsumision.php";
		$oc = new Orden();

		$rspta = $oc->listarPaquetes();

		while ($reg = $rspta->fetchObject())
				{
				echo '<option value=' . $reg->Articulo_idArticulo . '>' . $reg->PAQUETE .'</option>';
				}
	break;

	case 'selectPaqueteCliente':
		require_once "../modelos/OrdenConsumision.php";
		$oc = new Orden();
		echo '<option value="0">Seleccione una opcion</option>';

		$rspta = $oc->listarPaquetesCliente($lcliente);

		while ($reg = $rspta->fetchObject())
				{
				echo '<option value=' . $reg->Articulo_idArticulo . '>' . $reg->PAQUETE   . '</option>';
				}
	break;


	case 'calendario':

		$fi=$_REQUEST["fi"];
		$ff=$_REQUEST["ff"];
		$sala=$_REQUEST["sala"];
		
		$rspta=$orden->calendario($fi,$ff,$sala);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>$reg->OrdenConsumision_idOrdenConsumision,
 				"1"=>$reg->idOrdenConsumisionDetalle,
 				"2"=>$reg->nc,
 				"3"=>$reg->fecha_inicial,
 				"4"=>$reg->fecha_final,
 				"5"=>$reg->sala,
 				"6"=>$reg->na,
 				"7"=>$reg->ns,
 				"8"=>$reg->cantidad,
 				"9"=>$reg->cantidadUtilizada,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

}
?>