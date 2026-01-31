<?php 
require_once "../modelos/Persona.php";

$persona=new Persona();

$idPersona=isset($_POST["idPersona"])? limpiarCadena($_POST["idPersona"]):"";
$nombreComercial=isset($_POST["nombreComercial"])? limpiarCadena($_POST["nombreComercial"]):"";
$razonSocial=isset($_POST["razonSocial"])? limpiarCadena($_POST["razonSocial"]):"";
$tipoDocumento=isset($_POST["tipoDocumento"])? limpiarCadena($_POST["tipoDocumento"]):"";
$nroDocumento=isset($_POST["nroDocumento"])? limpiarCadena($_POST["nroDocumento"]):"";
$mail=isset($_POST["mail"])? limpiarCadena($_POST["mail"]):"";
$correo=isset($_POST["correo"])? limpiarCadena($_POST["correo"]):"";
$celular=isset($_POST["celular"])? limpiarCadena($_POST["celular"]):"";
$fechaNacimiento=isset($_POST["fechaNacimiento"])? limpiarCadena($_POST["fechaNacimiento"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$regimenTurismo=isset($_POST["regimenTurismo"])? limpiarCadena($_POST["regimenTurismo"]):"";
$tipoEmpresa=isset($_POST["tipoEmpresa"])? limpiarCadena($_POST["tipoEmpresa"]):"";


switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idPersona)){
			$apellidos = isset($_POST["apellidos"]) ? limpiarCadena($_POST["apellidos"]) : "";
			$nombres = isset($_POST["nombres"]) ? limpiarCadena($_POST["nombres"]) : "";
			$nombreFantasia = isset($_POST["nombreFantasia"]) ? limpiarCadena($_POST["nombreFantasia"]) : "";
			$rspta=$persona->insertar(
				$razonSocial,
				$nombreComercial,
				$apellidos,
				$nombres,
				$nombreFantasia,
				$tipoDocumento,
				$nroDocumento,
				$mail,
				$fechaNacimiento,
				$regimenTurismo,
				$tipoEmpresa,
				isset($_POST["Proveedor_idProveedor"]) ? limpiarCadena($_POST["Proveedor_idProveedor"]) : "",
				isset($_POST["tercerizado"]) ? limpiarCadena($_POST["tercerizado"]) : "",

				$_POST["TipoPersona_idTipoPersona"],
				$_POST["terminoPago"],
				$_POST["GrupoPersona_idGrupoPersona"],
				$_POST["cuentaAPagar"],
				$_POST["cuentaAnticipo"],
				$_POST["comision"],
				$_POST["salario"],

				$_POST["TipoDireccion_Telefono_idTipoDireccion_Telefono"],
				$_POST["Ciudad_idCiudad"],
				$_POST["Barrio_idBarrio"],
				$_POST["callePrincipal"],
				$_POST["calleTransversal"],
				$_POST["nroCasa"],
				$_POST["longitud"],
				$_POST["latitud"],

				$_POST["TipoDireccion_Telefono_idTipoDireccion_Telefono_tel"],
				$_POST["telefono"],

				isset($_POST['nya']) ? $_POST['nya'] : array(),
				isset($_POST['Cargo_idCargo']) ? $_POST['Cargo_idCargo'] : array(),
				isset($_POST['email_2']) ? $_POST['email_2'] : array(),
				isset($_POST['telefono_2']) ? $_POST['telefono_2'] : array(),
				isset($_POST['Dia_idDia_persona']) ? $_POST['Dia_idDia_persona'] : array(),
				isset($_POST['cantidad_persona']) ? $_POST['cantidad_persona'] : array()
			);
			echo $rspta ? "Persona registrada" : "Persona no se pudo registrar";
		}
		else {
			$apellidos = isset($_POST["apellidos"]) ? limpiarCadena($_POST["apellidos"]) : "";
			$nombres = isset($_POST["nombres"]) ? limpiarCadena($_POST["nombres"]) : "";
			$nombreFantasia = isset($_POST["nombreFantasia"]) ? limpiarCadena($_POST["nombreFantasia"]) : "";
			$rspta=$persona->editar($idPersona,$razonSocial,$nombreComercial,$apellidos,$nombres,$nombreFantasia,$tipoDocumento,$nroDocumento,$mail,$fechaNacimiento, $regimenTurismo, $tipoEmpresa,
				isset($_POST["Proveedor_idProveedor"]) ? limpiarCadena($_POST["Proveedor_idProveedor"]) : "",
				isset($_POST["tercerizado"]) ? limpiarCadena($_POST["tercerizado"]) : "",
				$_POST["idPersonaTipoPersona"],
				$_POST["TipoPersona_idTipoPersona"],
				$_POST["terminoPago"],
				$_POST["GrupoPersona_idGrupoPersona"],
				$_POST["cuentaAPagar"],
				$_POST["cuentaAnticipo"],
				$_POST["comision"],
				$_POST["salario"],

				$_POST["idDireccion"],
				$_POST["TipoDireccion_Telefono_idTipoDireccion_Telefono"],
				$_POST["Ciudad_idCiudad"],
				$_POST["Barrio_idBarrio"],
				$_POST["callePrincipal"],
				$_POST["calleTransversal"],
				$_POST["nroCasa"],
				$_POST["longitud"],
				$_POST["latitud"],

				$_POST["idTelefono"],				
				$_POST["TipoDireccion_Telefono_idTipoDireccion_Telefono_tel"],
				$_POST["telefono"]);
			echo $rspta ? "Persona actualizada" : "Persona no se pudo actualizar";
		}
	break;


	case 'guardar':

			$rspta=$persona->insertarr($razonSocial,$tipoDocumento,$nroDocumento,$celular,$correo,$fechaNacimiento, $direccion);
			echo json_encode($rspta);
	break;


	case 'desactivar':
		$rspta=$persona->desactivar($idPersona);
 		echo $rspta ? "Artículo Desactivado" : "Artículo no se puede desactivar";
	break;

	case 'activar':
		$rspta=$persona->activar($idPersona);
 		echo $rspta ? "Artículo activado" : "Artículo no se puede activar";
	break;

	case 'mostrar':
		$rspta=$persona->mostrar($idPersona);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listarp':
		$rspta=$persona->listarp();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			if ($reg->tipoDocumento == 1) {
 				$tipoDocumento = 'RUC';
 			}else if( $reg->tipoDocumento == 2 ){
 				$tipoDocumento = 'CEDULA';
 			}else{
 				$tipoDocumento = 'Documento Extranjero';
 			}


 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idPersona.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->idPersona.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idPersona.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary btn-xs" onclick="activar('.$reg->idPersona.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombreComercial,
 				"2"=>$reg->razonSocial,
 				"3"=>$tipoDocumento,
 				"4"=>$reg->nroDocumento,
 				"5"=>$reg->mail,
 				"6"=>$reg->fechaNacimiento,
 				"7"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
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





	case 'listarConductores':
		$rspta=$persona->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			if ($reg->tipoDocumento == 1) {
 				$tipoDocumento = 'RUC';
 			}else if( $reg->tipoDocumento == 2 ){
 				$tipoDocumento = 'CEDULA';
 			}else{
 				$tipoDocumento = 'Documento Extranjero';
 			}



 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idPersona.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->idPersona.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idPersona.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary btn-xs" onclick="activar('.$reg->idPersona.')"><i class="fa fa-check"></i></button>',
 				"1"=>utf8_encode($reg->nombreComercial),
 				"2"=>utf8_encode($reg->razonSocial),
 				"3"=>$tipoDocumento,
 				"4"=>$reg->nroDocumento,
 				"5"=>$reg->mail,
 				"6"=>'Ver en detalle de direcciones',
 				"7"=>$reg->fechaNacimiento,
 				"8"=>'<button class="btn btn-primary" onclick="mostrarDetalleTelefonos('.$reg->idPersona.')">Ver telefonos <i class="fa fa-pencil"></i></button>',
				"9"=>'<button class="btn btn-primary" onclick="mostrarDetalleDirecciones('.$reg->idPersona.')">Ver direcciones <i class="fa fa-pencil"></i></button>',
 				"10"=>'<button class="btn btn-primary" onclick="mostrarDetalleVehiculos('.$reg->idPersona.')">Ver vehiculos <i class="fa fa-pencil"></i></button>',
				"11"=>'<button class="btn btn-primary"  onclick="mostrarDetalleDocumentosPersonales('.$reg->idPersona.')">Ver documentos personales <i class="fa fa-pencil"></i></button>',
 				"12"=>'No',
 				"13"=>'No',

 				"14"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
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





	case 'listar':
		$rspta=$persona->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){

 			if ($reg->tipoDocumento == 1) {
 				$tipoDocumento = 'RUC';
 			}else if( $reg->tipoDocumento == 2 ){
 				$tipoDocumento = 'CEDULA';
 			}else{
 				$tipoDocumento = 'Documento Extranjero';
 			}



 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idPersona.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->idPersona.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idPersona.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary btn-xs" onclick="activar('.$reg->idPersona.')"><i class="fa fa-check"></i></button>',
 				"1"=>utf8_encode($reg->nombreComercial),
 				"2"=>utf8_encode($reg->razonSocial),
 				"3"=>$tipoDocumento,
 				"4"=>$reg->nroDocumento,
 				"5"=>$reg->mail,
 				"6"=>$reg->fechaNacimiento,
				"7"=>$reg->tipoEmpresa,
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
 
  
	case 'desactivarTP':
		$rspta=$persona->desactivarTP($_POST['idTP']);
 		echo $rspta ? "TP Desactivado" : "TP no se puede desactivar";
	break;

	case 'desactivarDireccion':
		$rspta=$persona->desactivarDireccion($_POST['idDireccion']);
 		echo $rspta ? "Direccion Desactivado" : "Direccion no se puede desactivar";
	break;

	case 'desactivarTelefono':
		$rspta=$persona->desactivarTelefono($_POST['idTelefono']);
 		echo $rspta ? "Telefono Desactivado" : "Telefono no se puede desactivar";
	break;




	case "selectProveedor":

		$rspta = $persona->selectProveedor();
			echo '<option value="%%">Todos...</option>';

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idPersona. '>' .$reg->razonSocial. '</option>';
		}

		break;


	case "selectCliente":

		$rspta = $persona->selectCliente();
			echo '<option value="%%">Seleccione cliente</option>';

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idPersona. '>' .$reg->razonSocial. '</option>';
		}

		break;

	/*case 'selectClienteLimit':
		$query ="SELECT * from persona, persona_tipopersona,tipopersona
				where persona.idPersona = persona_tipopersona.Persona_idPersona and tipopersona.idTipoPersona = persona_tipopersona.TipoPersona_idTipoPersona and persona_tipopersona.inactivo = 0 and persona_tipopersona.TipoPersona_idTipoPersona = 1 order by razonSocial";
		$result = $conexion->query($query);
		if(!empty($result)) {
		?>
		<?php
		$dataArray = Array();
		foreach($result as $p) {
		?>


		<option d-precio="<?php echo $p["razonSocial"]?>" d-impuesto="<?php echo $p["nombreComercial"]?>" value="<?php echo $p["idPersona"]; ?>">
			<?php echo $p["razonSocial"]; ?>
			<?php echo $p["idPersona"]; ?>
		</option>

		<?php 
		}// foreach


		}//if
	break;
*/

	case 'selectClienteLimit':

if(!empty($_POST["keyword"])) {


$query ="		SELECT * FROM persona p 
				JOIN persona_tipopersona ptp ON p.idPersona = ptp.Persona_idPersona
				JOIN tipopersona tp ON tp.idTipoPersona = ptp.TipoPersona_idTipoPersona
				WHERE
				ptp.inactivo = 0 
				and ptp.TipoPersona_idTipoPersona = ".$_POST['tipoPersona']."
				and  (razonSocial like '%".$_POST["keyword"]."%' OR nombreComercial LIKE '%".$_POST["keyword"]."%' or nroDocumento like '%".$_POST["keyword"]."%' or idPersona like '%".$_POST["keyword"]."%' )
				LIMIT 0,6";
$result = $conexion->query($query); 






if(!empty($result)) {
?>
<?php
$dataArray = Array();
foreach($result as $p) {
?>


<option onclick="listarArticulos()" d-razonSocial="<?php echo $p["razonSocial"]?>" d-nombreComercial="<?php echo $p["nombreComercial"]?>"  d-idPersona="<?php echo $p["idPersona"]?>" value="<?php echo $p["idPersona"]; ?>">
	<?php echo $p["razonSocial"]; ?>
	<?php echo $p["nombreComercial"]; ?>
	<?php echo $p["nroDocumento"]; ?>
	<?php echo $p["idPersona"]; ?>
</option>

<?php 
}// foreach


}//if

}//keyword

	break;




case "selectFuncionario":

	$rspta = $persona->selectFuncionario();
		echo '<option value="999">Seleccione Funcionario</option>';
	while ($reg = $rspta->fetchObject()) {
		echo '<option value=' .$reg->idPersona. '>' .$reg->razonSocial. '</option>';
	}
break;


case 'SelectPersonaSearch':

		if(!empty($_POST["keyword"])) {


		$query ="
				SELECT * FROM persona p 
				JOIN persona_tipopersona ptp ON p.idPersona = ptp.Persona_idPersona
				JOIN tipopersona tp ON tp.idTipoPersona = ptp.TipoPersona_idTipoPersona
				WHERE
				ptp.inactivo = 0 
				and ptp.TipoPersona_idTipoPersona = 1
				and  (razonSocial like '%'".$_POST["keyword"]."'%' OR nombreComercial LIKE '%'".$_POST["keyword"]."'%' OR idPersona LIKE '%'".$_POST["keyword"]."'%')
				LIMIT 0,6
		";
		$result = $conexion->query($query); 


		if(!empty($result)) {
		?>
		<?php
		$dataArray = Array();
		foreach($result as $p) {
		?>


		<option onclick="agregarDetalle(<?php echo $p["idArticulo"]; ?>,<?php echo $p["nombre"]; ?>,
										<?php echo $p["precioVenta"]; ?>,
										<?php echo $p["TipoImpuesto_idTipoImpuesto"]?>,
										<?php echo $p["porcentajeImpuesto"]; ?>	)" d-precio="<?php echo $p["precioVenta"]?>" d-impuesto="<?php echo $p["porcentajeImpuesto"]?>" d-idImpuesto="<?php echo $p["TipoImpuesto_idTipoImpuesto"]?>" value="<?php echo $p["idArticulo"]; ?>">
			<?php echo $p["nombre"]; ?>
			<?php echo $p["idArticulo"]; ?>
			<?php echo $p["codigoBarra"]; ?>
		</option>

		<?php 
		}// foreach


		}//if

		}//keyword

break;



	case 'limiteCredito':
		$rspta=$persona->limiteCredito($_POST['idPersona']);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;




}
?>