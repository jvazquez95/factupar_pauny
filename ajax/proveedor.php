<?php 


require_once "../modelos/Proveedor.php";

$proveedor=new Proveedor();
$idPersona=isset($_POST["idPersona"])? limpiarCadena($_POST["idPersona"]):"";
$idProveedor=isset($_POST["idProveedor"])? limpiarCadena($_POST["idProveedor"]):"";
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
$idCategoriaProveedor=isset($_POST["idCategoriaProveedor"])? limpiarCadena($_POST["idCategoriaProveedor"]):"";
$terminoPago=isset($_POST["terminoPago"])? limpiarCadena($_POST["terminoPago"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':

		if (empty($idProveedor)){
			$rspta=$proveedor->insertar($razonSocial,$nombreComercial,$tipoDocumento,$nroDocumento,$direccion,$telefono,$celular,$mail,$moneda,$sitioWeb,$idCategoriaProveedor,$terminoPago);
			echo $rspta ? "proveedor registrado" : "proveedor no se pudo registrar";
		}
		else {
			$rspta=$proveedor->editar($idProveedor,$razonSocial,$nombreComercial,$tipoDocumento,$nroDocumento,$direccion,$telefono,$celular,$mail,$moneda,$sitioWeb,$idCategoriaProveedor,$terminoPago);
			echo $rspta ? "proveedor actualizado" : "proveedor no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$proveedor->desactivar($idProveedor);
 		echo $rspta ? "proveedor Desactivado" : "proveedor no se puede desactivar";
	break;

	case 'activar':
		$rspta=$proveedor->activar($idProveedor);
 		echo $rspta ? "proveedor activado" : "proveedor no se puede activar";
	break;

	case 'mostrar':
		$rspta=$proveedor->mostrar($idProveedor);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$proveedor->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->$idPersona.')"><i class="fa fa-close"></i></button>':
 					' <button class="btn btn-primary" onclick="activar('.$reg->$idPersona.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->razonSocial,
 				"2"=>$reg->nombreComercial,
 				"3"=>$reg->nroDocumento,
 				"4"=>$reg->direccion,
 				"5"=>$reg->telefono,
 				"6"=>$reg->celular,
 				"7"=>$reg->mail,
 				//"8"=>$reg->idCategoriaProveedor,
 				//"9"=>$reg->terminoPago,
 				"8"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
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



	case 'listarpersonadireccion':

		$rspta = $proveedor->listarpersonadireccion();
	
		$data= Array();
	
		while ($reg = $rspta->fetchObject()) {
	
			// Descripción del tipo de documento
			if ($reg->td == 1) {
				$tipoDocumento = 'RUC';
			} else if ($reg->td == 2) {
				$tipoDocumento = 'CEDULA';
			} else {
				$tipoDocumento = 'Documento Extranjero';
			}
	
			// Para los días de la semana, mostramos algo más descriptivo 
			// Por ejemplo, "Visita" si es 1, "No" si es 0.
			// Puedes ajustar el texto a tu gusto: “Sí” / “No”, “Día de visita” / “Sin visita”, etc.
			$domingo    = $reg->domingo    ? "Visita" : "No";
			$lunes      = $reg->lunes      ? "Visita" : "No";
			$martes     = $reg->martes     ? "Visita" : "No";
			$miercoles  = $reg->miercoles  ? "Visita" : "No";
			$jueves     = $reg->jueves     ? "Visita" : "No";
			$viernes    = $reg->viernes    ? "Visita" : "No";
			$sabado     = $reg->sabado     ? "Visita" : "No";
	
			$data[]=array(
				"0"=> (!$reg->pi)
					? '<button class="btn btn-danger" onclick="desactivar('.$reg->idPersona.')"><i class="fa fa-close"></i></button>'
					: '<button class="btn btn-primary" onclick="activar('.$reg->idPersona.')"><i class="fa fa-check"></i></button>',
				"1"=> $reg->idPersona . ' - ' . $reg->razonSocial,
				"2"=> $reg->nombreComercial,
				"3"=> $reg->nroDocumento,
				"4"=> $tipoDocumento,
				"5"=> $reg->mail,
				"6"=> $reg->descripcion,
				"7"=> $reg->direccion,
				"8"=> $reg->latitud . ' - ' . $reg->longitud . '<br><br><a href="https://www.google.com/maps/?q='.$reg->latitud.','.$reg->longitud.'" target="_blank" class="btn btn-secondary">Navegar</a>' .  '<br><a href="https://www.mineraqua.com.py/mineraqua/files/direcciones/'.$reg->imagen.'" target="_blank" class="btn btn-primary">Ver Imagen</a>',
	
				// Ahora mostramos los días con la descripción "Visita" / "No"
				"9" =>  $domingo,
				"10" => $lunes,
				"11" => $martes,
				"12" => $miercoles,
				"13" => $jueves,
				"14" => $viernes,
				"15" => $sabado,
	
				"16"=>$reg->nombreReferencia,
				"17"=>$reg->ui,
				"18"=>$reg->fi,
				"19"=>$reg->um,
				"20"=>$reg->fm,
				"21"=> (!$reg->pi) 
					? '<span class="label bg-green">Activado</span>'
					: '<span class="label bg-red">Desactivado</span>'
			);
		}
	
		$results = array(
			"sEcho"=>1, //Información para el datatables
			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
			"aaData"=>$data
		);
		echo json_encode($results);
	
	break;
	


	case 'listarc':

 			
		$rspta=$proveedor->listarc();

 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

			if ($reg->td == 1) {
				$tipoDocumento = 'RUC';
			}else if( $reg->td == 2 ){
				$tipoDocumento = 'CEDULA';
			}else{
				$tipoDocumento = 'Documento Extranjero';
			}

 			$data[]=array(
 				"0"=>(!$reg->pi)?
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idPersona.')"><i class="fa fa-close"></i></button>':
 					' <button class="btn btn-primary" onclick="activar('.$reg->idPersona.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->idPersona . ' - ' .$reg->razonSocial,
 				"2"=>$reg->nombreComercial,
 				"3"=>$reg->nroDocumento,
 				"4"=>$tipoDocumento,
 				"5"=>$reg->mail,
 				"6"=>'<button class="btn btn-primary" onclick="mostrarDetalleDirecciones('.$reg->idPersona.')">Ver direcciones<i class="fa fa-pencil"></i></button><hr><button class="btn btn-primary" onclick="mostrarDetalleTelefono('.$reg->idPersona.')">Ver telefonos<i class="fa fa-pencil"></i></button>',
 				"7"=>'<button class="btn btn-primary" onclick="mostrarDetalleComodato('.$reg->idPersona.')">Ver detalle comodato<i class="fa fa-pencil"></i></button>',		
 				"8"=>$reg->ui,
 				"9"=>$reg->fi,
 				"10"=>$reg->um,
 				"11"=>$reg->fm,
 				"12"=>(!$reg->pi)?'<span class="label bg-green">Activado</span>':
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
		require_once "../modelos/CategoriaProveedor.php";
		$categoria = new CategoriaProveedor();

		$rspta = $categoria->select();

		while ($reg = $rspta->fetchObject())
				{
					echo '<option value=' . $reg->idCategoriaProveedor . '>' . $reg->descripcion . '</option>';
				}
	break;
/*
	case "selectGrupo":
		require_once "../modelos/Grupoproveedor.php";
		$grupo = new Grupoproveedor();

		$rspta = $grupo->select();

		while ($reg = $rspta->fetchObject())
				{
					echo '<option value=' . $reg->idGrupoproveedor . '>' . $reg->nombre . '</option>';
				}
	break;

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