<?php 
require_once "../modelos/Persona.php";

$persona=new Persona();

$idPersona=isset($_POST["idPersona"])? limpiarCadena($_POST["idPersona"]):"";
$nombreComercial=isset($_POST["nombreComercial"])? limpiarCadena($_POST["nombreComercial"]):"";
$razonSocial=isset($_POST["razonSocial"])? limpiarCadena($_POST["razonSocial"]):"";
$apellidos=isset($_POST["apellidos"])? limpiarCadena($_POST["apellidos"]):"";
$nombres=isset($_POST["nombres"])? limpiarCadena($_POST["nombres"]):"";
$nombreFantasia=isset($_POST["nombreFantasia"])? limpiarCadena($_POST["nombreFantasia"]):"";
$tipoDocumento=isset($_POST["tipoDocumento"])? limpiarCadena($_POST["tipoDocumento"]):"";
$nroDocumento=isset($_POST["nroDocumento"])? limpiarCadena($_POST["nroDocumento"]):"";
$mail=isset($_POST["mail"])? limpiarCadena($_POST["mail"]):"";
$correo=isset($_POST["correo"])? limpiarCadena($_POST["correo"]):"";
$celular=isset($_POST["celular"])? limpiarCadena($_POST["celular"]):"";
$fechaNacimiento=isset($_POST["fechaNacimiento"])? limpiarCadena($_POST["fechaNacimiento"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$regimenTurismo=isset($_POST["regimenTurismo"])? limpiarCadena($_POST["regimenTurismo"]):"";
$tipoEmpresa=isset($_POST["tipoEmpresa"])? limpiarCadena($_POST["tipoEmpresa"]):"";
$Proveedor_idProveedor=isset($_POST["Proveedor_idProveedor"])? limpiarCadena($_POST["Proveedor_idProveedor"]):"";
$tercerizado=isset($_POST["tercerizado"])? limpiarCadena($_POST["tercerizado"]):"";


switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idPersona)){
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
				$Proveedor_idProveedor,
				$tercerizado,
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

				$_POST["nya"],
				$_POST["Cargo_idCargo"],
				$_POST["email_2"],
				$_POST["telefono_2"],
				isset($_POST['Dia_idDia_persona']) ? $_POST['Dia_idDia_persona'] : array(),
				isset($_POST['cantidad_persona']) ? $_POST['cantidad_persona'] : array()
			);
			echo $rspta ? "Persona registrada" : "Persona no se pudo registrar";
		}
		else {
			$rspta=$persona->editar($idPersona,$razonSocial,$nombreComercial,$apellidos,$nombres,$nombreFantasia,$tipoDocumento,$nroDocumento,$mail,$fechaNacimiento, $regimenTurismo, $tipoEmpresa,$Proveedor_idProveedor,$tercerizado,
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
				$_POST["telefono"],

				$_POST["idPersonaContacto"],
				$_POST["nya"],
				$_POST["Cargo_idCargo"],
				$_POST["email_2"],
				$_POST["telefono_2"],
				isset($_POST['idPersonaDia']) ? $_POST['idPersonaDia'] : array(),
				isset($_POST['Dia_idDia_persona']) ? $_POST['Dia_idDia_persona'] : array(),
				isset($_POST['cantidad_persona']) ? $_POST['cantidad_persona'] : array()
			);


			echo $rspta ? "Persona actualizada" : "Persona no se pudo actualizar";
		}
	break;


	case 'guardar':

			$rspta=$persona->insertarr($razonSocial,$tipoDocumento,$nroDocumento,$celular,$correo,$fechaNacimiento, $direccion);
			echo json_encode($rspta);
	break;


	case 'desactivar':
		$rspta=$persona->desactivar($idPersona);
 		echo $rspta ? "Persona Desactivado" : "Persona no se puede desactivar";
	break;

	case 'activar':
		$rspta=$persona->activar($idPersona);
 		echo $rspta ? "Persona activado" : "Persona no se puede activar";
	break;

	case 'mostrar':
		$rspta = $persona->mostrar($idPersona);
		if (is_array($rspta)) {
			$rspta['apellidos'] = isset($rspta['apellidos']) ? $rspta['apellidos'] : (isset($rspta['Apellidos']) ? $rspta['Apellidos'] : '');
			$rspta['nombres'] = isset($rspta['nombres']) ? $rspta['nombres'] : (isset($rspta['Nombres']) ? $rspta['Nombres'] : '');
			$rspta['nombreFantasia'] = isset($rspta['nombreFantasia']) ? $rspta['nombreFantasia'] : (isset($rspta['NombreFantasia']) ? $rspta['NombreFantasia'] : '');
		}
		echo json_encode($rspta);
	break;

	case 'kpis':
		$kpis = $persona->listarKpis();
		echo json_encode($kpis);
	break;

	case 'detalleCompleto':
		$idP = isset($_GET['idPersona']) ? (int)$_GET['idPersona'] : 0;
		if ($idP <= 0) {
			echo json_encode(array('ok' => false, 'mensaje' => 'ID inválido'));
			break;
		}
		$datos = $persona->mostrar($idP);
		if ($datos === false || !$datos) {
			echo json_encode(array('ok' => false, 'mensaje' => 'Persona no encontrada'));
			break;
		}
		$tipos = array();
		$rsTipos = $persona->listarDetalleTipoPersona($idP);
		if ($rsTipos !== false) {
			while ($t = $rsTipos->fetchObject()) {
				$tipos[] = array(
					'tipo' => isset($t->tpdd) ? $t->tpdd : '',
					'terminoPago' => isset($t->tpd) ? $t->tpd : '',
					'grupo' => isset($t->gpd) ? $t->gpd : ''
				);
			}
		}
		$direcciones = array();
		$rsDir = $persona->listarDetalleDireccion($idP);
		if ($rsDir !== false) {
			while ($d = $rsDir->fetchObject()) {
				$direcciones[] = array(
					'tipo' => isset($d->dt) ? $d->dt : '',
					'ciudad' => isset($d->dc) ? $d->dc : '',
					'barrio' => isset($d->db) ? $d->db : '',
					'direccion' => isset($d->direccion) ? $d->direccion : ''
				);
			}
		}
		$telefonos = array();
		$rsTel = $persona->listarDetalleTelefono($idP);
		if ($rsTel !== false) {
			while ($tel = $rsTel->fetchObject()) {
				$telefonos[] = array(
					'tipo' => isset($tel->dt) ? $tel->dt : '',
					'numero' => isset($tel->telefono) ? $tel->telefono : ''
				);
			}
		}
		$contactos = array();
		$rsCont = $persona->listarDetallePersonaContacto($idP);
		if ($rsCont !== false) {
			while ($c = $rsCont->fetchObject()) {
				$contactos[] = array(
					'nya' => isset($c->contact_nya) ? $c->contact_nya : (isset($c->nya) ? $c->nya : ''),
					'email' => isset($c->contact_email) ? $c->contact_email : (isset($c->email) ? $c->email : ''),
					'telefono' => isset($c->contact_telefono) ? $c->contact_telefono : (isset($c->telefono) ? $c->telefono : '')
				);
			}
		}
		echo json_encode(array(
			'ok' => true,
			'persona' => $datos,
			'tipos' => $tipos,
			'direcciones' => $direcciones,
			'telefonos' => $telefonos,
			'contactos' => $contactos
		));
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
 				$tipoDocumento = 'S/N';
 			}


 			$data[]=array(
 				"0"=>'',
 				"1"=>(!$reg->inactivo)?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idPersona.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->idPersona.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idPersona.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary btn-xs" onclick="activar('.$reg->idPersona.')"><i class="fa fa-check"></i></button>',
 				"2"=>$reg->nombreComercial,
 				"3"=>$reg->razonSocial,
 				"4"=>$tipoDocumento,
 				"5"=>$reg->nroDocumento,
 				"6"=>$reg->mail,
 				"7"=>$reg->fechaNacimiento,
 				"8"=>$reg->usuarioInsercion,
 				"9"=>(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
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
 				"1"=>($reg->nombreComercial),
 				"2"=>($reg->razonSocial),
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
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			if ($reg->tipoDocumento == 1) {
 				$tipoDocumento = 'RUC';
 			} elseif ($reg->tipoDocumento == 2) {
 				$tipoDocumento = 'CEDULA';
 			} else {
 				$tipoDocumento = 'DOC. EXTRANJERO';
 			}
 			// Razón social / nombre a mostrar
 			$nf = isset($reg->nombreFantasia) ? trim($reg->nombreFantasia) : '';
 			$ap = isset($reg->apellidos) ? trim($reg->apellidos) : '';
 			$no = isset($reg->nombres) ? trim($reg->nombres) : '';
 			$nombreMostrar = isset($reg->razonSocial) ? $reg->razonSocial : (isset($reg->nombreComercial) ? $reg->nombreComercial : '');
 			$apellidosNombres = ($ap !== '' || $no !== '') ? trim($ap . ($ap && $no ? ', ' : '') . $no) : '-';
 			$tel = isset($reg->tel) ? $reg->tel : (isset($reg->telefono) ? $reg->telefono : '-');
 			$direccion = isset($reg->direccion) && $reg->direccion !== '' ? utf8_encode($reg->direccion) : '-';
 			$tipoEmpresa = isset($reg->tipoEmpresa) ? ($reg->tipoEmpresa == 1 ? 'Privada' : ($reg->tipoEmpresa == 2 ? 'Pública' : $reg->tipoEmpresa)) : '-';

 			$data[]=array(
 				"0"=>$reg->idPersona,
 				"1"=>(!$reg->inactivo)?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idPersona.')" title="Editar"><i class="fa fa-pencil"></i></button> '.
 					'<button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->idPersona.')" title="Desactivar"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idPersona.')" title="Editar"><i class="fa fa-pencil"></i></button> '.
 					'<button class="btn btn-primary btn-xs" onclick="activar('.$reg->idPersona.')" title="Activar"><i class="fa fa-check"></i></button>',
 				"2"=>'<strong>'.htmlspecialchars($nombreMostrar).'</strong>',
 				"3"=>htmlspecialchars($apellidosNombres),
 				"4"=>$tipoDocumento,
 				"5"=>$reg->nroDocumento,
 				"6"=>$tel,
 				"7"=>$direccion,
 				"8"=>$tipoEmpresa,
 				"9"=>$reg->usuarioInsercion,
 				"10"=>$reg->idPersona,
 				"11"=>(!$reg->inactivo)?'<span class="label label-success">Activo</span>':'<span class="label label-default">Inactivo</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1,
 			"iTotalRecords"=>count($data),
 			"iTotalDisplayRecords"=>count($data),
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'listarDetalleTipoPersona':
		$idPersona = isset($_GET['idPersona']) ? $_GET['idPersona'] : '';
		$rspta = $persona->listarDetalleTipoPersona($idPersona);
		require_once "../modelos/TipoPersona.php";
		require_once "../modelos/TerminoPago.php";
		require_once "../modelos/GrupoPersona.php";
		require_once "../modelos/cuentaContable.php";
		$tipoPersonaModel = new TipoPersona();
		$terminoPagoModel = new TerminoPago();
		$grupoPersonaModel = new GrupoPersona();
		$cuentaContableModel = new cuentaContable();
		$contTP = 0;
		$allTerminoPago = array();
		$opcionesTP = $terminoPagoModel->selectTerminoPago();
		if ($opcionesTP !== false) {
			while ($o = $opcionesTP->fetchObject()) {
				$allTerminoPago[] = array('id' => $o->idTerminoPago, 'desc' => $o->descripcion);
			}
		}
		$allGrupoPersona = array();
		$opcionesGP = $grupoPersonaModel->selectGrupoPersona();
		if ($opcionesGP !== false) {
			while ($o = $opcionesGP->fetchObject()) {
				$allGrupoPersona[] = array('id' => $o->idGrupoPersona, 'desc' => $o->descripcion);
			}
		}
		$allCuentaContable = array();
		$opcionesCC = $cuentaContableModel->selectCuentaContable();
		if ($opcionesCC !== false) {
			while ($o = $opcionesCC->fetchObject()) {
				$allCuentaContable[] = array('id' => $o->idCuentaContable, 'desc' => $o->descripcion);
			}
		}
		if ($rspta !== false) {
			while ($reg = $rspta->fetchObject()) {
				$optionsTPHtml = '';
				$opcionesTP = $tipoPersonaModel->selectTipoPersona();
				if ($opcionesTP !== false) {
					while ($opt = $opcionesTP->fetchObject()) {
						$sel = ($opt->idTipoPersona == $reg->TipoPersona_idTipoPersona) ? ' selected' : '';
						$optionsTPHtml .= '<option value="'.intval($opt->idTipoPersona).'"'.$sel.'>'.htmlspecialchars($opt->descripcion).'</option>';
					}
				}
				$optionsTerminoPago = '';
				foreach ($allTerminoPago as $opt) {
					$sel = ($opt['id'] == $reg->terminoPago) ? ' selected' : '';
					$optionsTerminoPago .= '<option value="'.intval($opt['id']).'"'.$sel.'>'.htmlspecialchars($opt['desc']).'</option>';
				}
				$optionsGrupoPersona = '';
				foreach ($allGrupoPersona as $opt) {
					$sel = ($opt['id'] == $reg->GrupoPersona_idGrupoPersona) ? ' selected' : '';
					$optionsGrupoPersona .= '<option value="'.intval($opt['id']).'"'.$sel.'>'.htmlspecialchars($opt['desc']).'</option>';
				}
				$idCP = isset($reg->cuentaAPagar) ? $reg->cuentaAPagar : (isset($reg->cp) ? $reg->cp : '');
				$idCA = isset($reg->cuentaAnticipo) ? $reg->cuentaAnticipo : (isset($reg->ca) ? $reg->ca : '');
				$optionsCuentaAPagar = '';
				$optionsCuentaAnticipo = '';
				foreach ($allCuentaContable as $opt) {
					$selCP = ($opt['id'] == $idCP) ? ' selected' : '';
					$selCA = ($opt['id'] == $idCA) ? ' selected' : '';
					$optionsCuentaAPagar .= '<option value="'.intval($opt['id']).'"'.$selCP.'>'.htmlspecialchars($opt['desc']).'</option>';
					$optionsCuentaAnticipo .= '<option value="'.intval($opt['id']).'"'.$selCA.'>'.htmlspecialchars($opt['desc']).'</option>';
				}
				echo '<tr class="filasTP" id="filaTP'.$contTP.'">';
				echo '<td><button type="button" class="btn btn-danger btn-xs" onclick="eliminarDetalleTipoPersona(\''.$contTP.'\',\''.$reg->idPersonaTipoPersona.'\')">X</button></td>';
				echo '<td><select name="TipoPersona_idTipoPersona[]" class="form-control input-sm">'.$optionsTPHtml.'</select></td>';
				echo '<td><select name="terminoPago[]" class="form-control input-sm">'.$optionsTerminoPago.'</select></td>';
				echo '<td><select name="GrupoPersona_idGrupoPersona[]" class="form-control input-sm">'.$optionsGrupoPersona.'</select></td>';
				echo '<td><select name="cuentaAPagar[]" class="form-control input-sm">'.$optionsCuentaAPagar.'</select></td>';
				echo '<td><select name="cuentaAnticipo[]" class="form-control input-sm">'.$optionsCuentaAnticipo.'</select></td>';
				echo '<td><input type="text" name="comision[]" class="form-control input-sm" value="'.htmlspecialchars($reg->comision ?? '').'" placeholder="Comisión"></td>';
				echo '<td><input type="text" name="salario[]" class="form-control input-sm" value="'.htmlspecialchars($reg->salario ?? '').'" placeholder="Salario"></td>';
				echo '<td><input type="hidden" name="idPersonaTipoPersona[]" value="'.$reg->idPersonaTipoPersona.'"></td>';
				echo '</tr>';
				$contTP++;
			}
		}
		if ($contTP == 0) {
			echo '<tr><td colspan="9" class="text-center text-muted">No hay tipos de persona registrados</td></tr>';
		}
	break;




	case 'listarDetalleDireccion':
		$idPersona = isset($_GET['idPersona']) ? $_GET['idPersona'] : '';
		$rspta = $persona->listarDetalleDireccion($idPersona);
		require_once "../modelos/TipoDireccionTelefono.php";
		require_once "../modelos/Ciudad.php";
		require_once "../modelos/Barrio.php";
		$tipoDT = new TipoDireccionTelefono();
		$ciudadModel = new Ciudad();
		$barrioModel = new Barrio();
		$allTipoDir = array();
		$opcionesTipoDir = $tipoDT->selectTipoDireccionTelefono();
		if ($opcionesTipoDir !== false) {
			while ($o = $opcionesTipoDir->fetchObject()) {
				$allTipoDir[] = array('id' => $o->idTipoDireccion_Telefono, 'desc' => $o->descripcion);
			}
		}
		$allCiudad = array();
		$opcionesCiudad = $ciudadModel->selectCiudad();
		if ($opcionesCiudad !== false) {
			while ($o = $opcionesCiudad->fetchObject()) {
				$allCiudad[] = array('id' => $o->idCiudad, 'desc' => $o->descripcion);
			}
		}
		$allBarrio = array();
		$opcionesBarrio = $barrioModel->selectBarrio();
		if ($opcionesBarrio !== false) {
			while ($o = $opcionesBarrio->fetchObject()) {
				$allBarrio[] = array('id' => $o->idBarrio, 'desc' => $o->descripcion);
			}
		}
		$contD = 0;
		if ($rspta !== false) {
			while ($reg = $rspta->fetchObject()) {
				$optionsTipoDir = '';
				foreach ($allTipoDir as $opt) {
					$sel = ($opt['id'] == $reg->TipoDireccion_Telefono_idTipoDireccion_Telefono) ? ' selected' : '';
					$optionsTipoDir .= '<option value="'.intval($opt['id']).'"'.$sel.'>'.htmlspecialchars($opt['desc']).'</option>';
				}
				$optionsCiudad = '';
				foreach ($allCiudad as $opt) {
					$sel = ($opt['id'] == $reg->Ciudad_idCiudad) ? ' selected' : '';
					$optionsCiudad .= '<option value="'.intval($opt['id']).'"'.$sel.'>'.htmlspecialchars($opt['desc']).'</option>';
				}
				$optionsBarrio = '';
				foreach ($allBarrio as $opt) {
					$sel = ($opt['id'] == $reg->Barrio_idBarrio) ? ' selected' : '';
					$optionsBarrio .= '<option value="'.intval($opt['id']).'"'.$sel.'>'.htmlspecialchars($opt['desc']).'</option>';
				}
				echo '<tr class="filasD" id="filaD'.$contD.'">';
				echo '<td><button type="button" class="btn btn-danger btn-xs" onclick="eliminarDetalleDireccion(\''.$contD.'\',\''.$reg->idDireccion.'\')">X</button><input type="hidden" name="idDireccion[]" value="'.$reg->idDireccion.'"></td>';
				echo '<td><select name="TipoDireccion_Telefono_idTipoDireccion_Telefono[]" class="form-control input-sm">'.$optionsTipoDir.'</select></td>';
				echo '<td><select name="Ciudad_idCiudad[]" class="form-control input-sm">'.$optionsCiudad.'</select></td>';
				echo '<td><select name="Barrio_idBarrio[]" class="form-control input-sm">'.$optionsBarrio.'</select></td>';
				echo '<td><input type="text" name="callePrincipal[]" class="form-control input-sm" value="'.htmlspecialchars($reg->callePrincipal ?? '').'" placeholder="Calle principal"></td>';
				echo '<td><input type="text" name="calleTransversal[]" class="form-control input-sm" value="'.htmlspecialchars($reg->calleTransversal ?? '').'" placeholder="Transversal"></td>';
				echo '<td><input type="text" name="nroCasa[]" class="form-control input-sm" value="'.htmlspecialchars($reg->nroCasa ?? '').'" placeholder="Nro"></td>';
				echo '<td><input type="text" name="latitud[]" class="form-control input-sm" value="'.htmlspecialchars($reg->latitud ?? '').'" placeholder="Lat"></td>';
				echo '<td><input type="text" name="longitud[]" class="form-control input-sm" value="'.htmlspecialchars($reg->longitud ?? '').'" placeholder="Lng"></td>';
				echo '</tr>';
				$contD++;
			}
		}
		if ($contD == 0) {
			echo '<tr><td colspan="9" class="text-center text-muted">No hay direcciones registradas</td></tr>';
		}
	break;



	case 'listarDetalleTelefono':
		$idPersona = isset($_GET['idPersona']) ? $_GET['idPersona'] : '';
		$rspta = $persona->listarDetalleTelefono($idPersona);
		require_once "../modelos/TipoDireccionTelefono.php";
		$tipoDT = new TipoDireccionTelefono();
		$opcionesTipoTel = $tipoDT->selectTipoDireccionTelefono();
		$allOptionsTipoTel = array();
		if ($opcionesTipoTel !== false) {
			while ($opt = $opcionesTipoTel->fetchObject()) {
				if (isset($opt->idTipoDireccion_Telefono) && isset($opt->descripcion)) {
					$allOptionsTipoTel[] = array('id' => $opt->idTipoDireccion_Telefono, 'desc' => $opt->descripcion);
				}
			}
		}
		$contT = 0;
		if ($rspta !== false) {
			while ($reg = $rspta->fetchObject()) {
				$optionsTipoTelRow = '';
				$idActual = isset($reg->TipoDireccion_Telefono_idTipoDireccion_Telefono) ? $reg->TipoDireccion_Telefono_idTipoDireccion_Telefono : '';
				foreach ($allOptionsTipoTel as $opt) {
					$sel = ( (int) $opt['id'] === (int) $idActual ) ? ' selected' : '';
					$optionsTipoTelRow .= '<option value="'.intval($opt['id']).'"'.$sel.'>'.htmlspecialchars($opt['desc']).'</option>';
				}
				echo '<tr class="filasT" id="filaT'.$contT.'">';
				echo '<td><button type="button" class="btn btn-danger btn-xs" onclick="eliminarDetalleTelefono(\''.$contT.'\',\''.$reg->idTelefono.'\')">X</button></td>';
				echo '<td><select name="TipoDireccion_Telefono_idTipoDireccion_Telefono_tel[]" class="form-control input-sm">'.$optionsTipoTelRow.'</select></td>';
				echo '<td><input type="text" name="telefono[]" class="form-control input-sm" value="'.htmlspecialchars(isset($reg->telefono) ? $reg->telefono : '').'" placeholder="Teléfono"></td>';
				echo '<td><input type="hidden" name="idTelefono[]" value="'.$reg->idTelefono.'"></td>';
				echo '</tr>';
				$contT++;
			}
		}
		if ($contT == 0) {
			echo '<tr><td colspan="4" class="text-center text-muted">No hay teléfonos registrados</td></tr>';
		}
	break;




	case 'listarDetalleDias':
		//Recibimos el idingreso
		$idPersona=$_GET['idPersona'];

				$rspta = $persona->listarDetalleDias($idPersona);
						echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Dia</th>
                                    <th>Cantidad</th>
				                </thead>';
				        $contVisita = 0;
						while ($reg = $rspta->fetchObject())
								{
									echo '<tr class="filasV" id="filaV'.$contVisita.'">
					<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleVisita(\''.$contVisita.'\',\''.$reg->idPersonaDia.'\')">X</button>
									</td><td><input type="hidden" name="Dia_idDia_persona[]"  value="'.$reg->iddias.'">'.$reg->descripcion.'</td>
									</td><td><input type="text" name="cantidad_persona[]"  value="'.$reg->cantidad.'"></td>
									</td><td><input type="hidden" data-idPersonaDia="1" name="idPersonaDia[]"  value="'.$reg->idPersonaDia.'"></td>';
									$contVisita++;															}
					echo 	'<tfoot>
                                    <th>Opciones</th>
                                    <th>Dia</th>
                                    <th>Cantidad</th>
                                </tfoot>';

	break;






	case 'listarDetallePersonaContacto':
		$idPersona = isset($_GET['idPersona']) ? $_GET['idPersona'] : '';
		$rspta = $persona->listarDetallePersonaContacto($idPersona);
		require_once "../modelos/Cargo.php";
		$cargoModel = new Cargo();
		$contC = 0;
		if ($rspta !== false) {
			while ($row = $rspta->fetch(PDO::FETCH_ASSOC)) {
				$optionsCargo = '';
				$opcionesCargo = $cargoModel->selectCargo();
				if ($opcionesCargo !== false) {
					while ($opt = $opcionesCargo->fetchObject()) {
						$sel = (isset($opt->idCargo) && (int)$opt->idCargo === (int)$cargoId) ? ' selected' : '';
						$optionsCargo .= '<option value="'.intval($opt->idCargo).'"'.$sel.'>'.htmlspecialchars(isset($opt->descripcion) ? $opt->descripcion : '').'</option>';
					}
				}
				$nya_val = '';
				$email_val = '';
				$telefono_val = '';
				$row_lower = array_change_key_case($row, CASE_LOWER);
				if (!empty($row_lower['contact_nya'])) { $nya_val = trim((string)$row_lower['contact_nya']); }
				elseif (!empty($row_lower['nya'])) { $nya_val = trim((string)$row_lower['nya']); }
				if (isset($row_lower['contact_email'])) { $email_val = trim((string)$row_lower['contact_email']); }
				elseif (isset($row_lower['email'])) { $email_val = trim((string)$row_lower['email']); }
				if (isset($row_lower['contact_telefono'])) { $telefono_val = trim((string)$row_lower['contact_telefono']); }
				elseif (isset($row_lower['telefono'])) { $telefono_val = trim((string)$row_lower['telefono']); }
				$idContacto = isset($row['idPersonaContacto']) ? (int)$row['idPersonaContacto'] : (isset($row_lower['idpersonacontacto']) ? (int)$row_lower['idpersonacontacto'] : 0);
				$cargoId = isset($row['Cargo_idCargo']) ? $row['Cargo_idCargo'] : (isset($row_lower['cargo_idcargo']) ? $row_lower['cargo_idcargo'] : 0);
				echo '<tr class="filasContacto" id="filaContacto'.$contC.'">';
				echo '<td><button type="button" class="btn btn-danger btn-xs" onclick="eliminarDetalleContacto(\''.$contC.'\',\''.$idContacto.'\')">X</button></td>';
				echo '<td><input type="text" name="nya[]" class="form-control input-sm" value="'.htmlspecialchars($nya_val).'" placeholder="Nombre y apellido"></td>';
				echo '<td><select name="Cargo_idCargo[]" class="form-control input-sm">'.$optionsCargo.'</select></td>';
				echo '<td><input type="text" name="email_2[]" class="form-control input-sm" value="'.htmlspecialchars($email_val).'" placeholder="Email"></td>';
				echo '<td><input type="text" name="telefono_2[]" class="form-control input-sm" value="'.htmlspecialchars($telefono_val).'" placeholder="Teléfono"></td>';
				echo '<td><input type="hidden" name="idPersonaContacto[]" value="'.$idContacto.'"></td>';
				echo '</tr>';
				$contC++;
			}
		}
		if ($contC == 0) {
			echo '<tr><td colspan="6" class="text-center text-muted">No hay contactos registrados</td></tr>';
		}
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

	case 'desactivarPersonaContacto':
		$rspta=$persona->desactivarPersonaContacto($_POST['idPersonaContacto']);
 		echo $rspta ? "Persona COntacto Desactivado" : "Persona Contacto no se puede desactivar";
	break;

	case 'desactivarVisita':
		$rspta=$persona->desactivarVisita($_POST['idPersonaDia']);
 		echo $rspta ? "Dia Desactivado" : "Dia no se puede desactivar";
	break;




	case 'buscar_persona_ruc':
		$rspta=$persona->buscar_persona_ruc($nroDocumento);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;




	case "selectProveedor":

		$rspta = $persona->selectProveedor();
			//echo '<option value="%%">Todos...</option>';

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idPersona. '>' .$reg->razonSocial. '</option>';
		}

		break;

 
	case "selectProveedorTodos":

		$rspta = $persona->selectProveedor();
			echo '<option value="%%">Todos...</option>';

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idPersona. '>' .$reg->razonSocial. '</option>';
		}

		break;


	case "selectCliente":

		$rspta = $persona->selectCliente();
			//echo '<option value="%%">Seleccione cliente</option>';

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idPersona. '>' .$reg->razonSocial. '</option>';
		}

		break;


		



		case 'selectCiudadLimit':
			if (!empty($_POST["keyword"])) {
				$query = "SELECT * from ciudad2
							WHERE descripcion LIKE '%" . $_POST["keyword"] . "%'
							ORDER BY descripcion DESC LIMIT 0,1000";
				$result = $conexion->query($query);
		
				if (!empty($result)) {
					$isFirstOption = true; // Variable para controlar la primera opción
		
					foreach ($result as $p) {
						// Si es la primera opción, añadir el atributo 'selected', luego asegurarse de que no se vuelva a marcar como selected
						$selected = $isFirstOption ? 'selected' : '';
						$isFirstOption = false; // Después de la primera iteración, ya no es la primera opción
		
						echo '<option d-razonSocial="' . htmlspecialchars($p["descripcion"]) . '" d-nombreComercial="' . htmlspecialchars($p["descripcion"]) . '" d-idPersona="' . htmlspecialchars($p["code"]) . '" value="' . htmlspecialchars($p["code"]) . '" ' . $selected . '>';
						echo htmlspecialchars($p["descripcion"]) . " " . htmlspecialchars($p["code"]);
						echo '</option>';
					} // foreach
				} //if result not empty
			} //if keyword not empty
			break;
		





	case 'selectClienteLimit':

if(!empty($_POST["keyword"])) {


$query ="		SELECT * FROM persona p 
				JOIN persona_tipopersona ptp ON p.idPersona = ptp.Persona_idPersona
				JOIN tipopersona tp ON tp.idTipoPersona = ptp.TipoPersona_idTipoPersona
				WHERE
				ptp.inactivo = 0 and p.inactivo = 0
				and ptp.TipoPersona_idTipoPersona = ".$_POST['tipoPersona']."
				and  (razonSocial like '%".$_POST["keyword"]."%' OR nombreComercial LIKE '%".$_POST["keyword"]."%' or nroDocumento like '%".$_POST["keyword"]."%' or idPersona like '%".$_POST["keyword"]."%' )
				LIMIT 0,1000";
$result = $conexion->query($query); 


if(!empty($result)) {
$dataArray = Array();
foreach($result as $p) { ?>
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





case "selectDirecciones":

	$rspta = $persona->selectDirecciones($_POST['idPersona']);
	while ($reg = $rspta->fetchObject()) {
		echo '<option value=' .$reg->idDireccion. '>' .$reg->direccion. '</option>';
	}
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


	case 'consultarRucApi':
		$ruc = isset($_GET['ruc']) ? trim($_GET['ruc']) : '';
		$ruc = preg_replace('/[^0-9]/', '', $ruc);
		if ($ruc === '') {
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode(array('success' => false, 'search' => array('found' => false)));
			break;
		}
		$url = 'https://factupar.com.py/ruc/search.php?ruc=' . urlencode($ruc);
		$ctx = stream_context_create(array('http' => array('timeout' => 5)));
		$raw = @file_get_contents($url, false, $ctx);
		if ($raw === false) {
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode(array('success' => false, 'search' => array('found' => false)));
			break;
		}
		header('Content-Type: application/json; charset=utf-8');
		echo $raw;
	break;

	case 'verificarRuc':
		$codigo = isset($_POST['codigo']) ? $_POST['codigo'] : '';
		$idPersona = isset($_POST['idPersona']) ? $_POST['idPersona'] : '';
		$rspta = $persona->verificarRuc($codigo, $idPersona);
		if ($rspta === false) {
			$rspta = array('cantidad' => 0, 'idPersona' => null);
		}
		if (!isset($rspta['idPersona'])) {
			$rspta['idPersona'] = null;
		}
		echo json_encode($rspta);
	break;




/* ------------------------------------------------------------------
   GUARDAR ASIGNACIÓN + LAT/LNG + (opcional) IMAGEN
   ------------------------------------------------------------------ */
/* ================================================================
   GUARDAR ASIGNACIÓN + COORDENADAS + (opcional) IMAGEN
   ================================================================ */
case 'guardarAsignacionRuta':

    /* ---------- 0. Datos del request ---------- */
    $idDireccion = $_POST['idDireccion'] ?? 0;
    $vehiculo    = $_POST['vehiculo']    ?? '';
    $dias        = json_decode($_POST['dias'] ?? '[]', true);
    $latitud     = $_POST['latitud']     ?? null;
    $longitud    = $_POST['longitud']    ?? null;

    /* ---------- 1. Procesar imagen (si viene) ---------- */
    $nombreImg = null;

    if (isset($_FILES['imagen']) && is_uploaded_file($_FILES['imagen']['tmp_name'])) {

        /* 1.1 Validar extensión */
        $permitidas = ['jpg','jpeg','png','webp','gif'];
        $ext        = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $permitidas)) {
            echo json_encode(['success'=>false,'msg'=>'Formato de imagen no permitido.']); exit;
        }

        /* 1.2 Definir carpeta destino (ruta absoluta) */
        //   .../public_html/mineraqua/ajax  → dirname(__DIR__)  → .../public_html/mineraqua
        $uploadDir = dirname(__DIR__).'/files/direcciones/';

        // Crear carpeta si no existe
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0775, true)) {
                echo json_encode(['success'=>false,'msg'=>'No se pudo crear '.$uploadDir]); exit;
            }
        }

        // Revisar permisos de escritura
        if (!is_writable($uploadDir)) {
            echo json_encode(['success'=>false,'msg'=>'La carpeta no es escribible: '.$uploadDir]); exit;
        }

        /* 1.3 Nombre único y mover archivo */
        $nombreImg = uniqid().'_'.date('Ymd').'.'.$ext;
        $destino   = $uploadDir.$nombreImg;

        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $destino)) {
            echo json_encode([
                'success'=>false,
                'msg'    =>'No se pudo mover el archivo a '.$destino,
                'err'    => $_FILES['imagen']['error']   // 0=OK, 1/2=tamaño, etc.
            ]);
            exit;
        }
    }

    /* ---------- 2. Actualizar lat/lng (+ imagen si llega) ---------- */
    $ok = $persona->actualizarLatLongDireccion($idDireccion, $latitud, $longitud, $nombreImg);

    /* ---------- 3. Re-grabar asignaciones ---------- */
    if ($ok && is_array($dias)) {
        foreach ($dias as $dia) {
            $persona->eliminarAsignacionDia($idDireccion, $dia);
            $persona->insertarAsignacion($idDireccion, $vehiculo, $dia);
        }
    }

    /* ---------- 4. Respuesta ---------- */
    echo json_encode([
        'success' => $ok,
        'msg'     => $ok
                      ? 'Asignación guardada'.($nombreImg ? ' y foto actualizada.' : '.')
                      : 'Error al guardar datos.'
    ]);
break;



case 'getAsignacion':

    $idDireccion = $_GET['idDireccion'];
    $vehiculo = $_GET['vehiculo'];

    $sql = "SELECT diaSemana 
            FROM direccion_asignacion_ruta 
            WHERE Direccion_idDireccion = '$idDireccion' AND Vehiculo_idVehiculo = '$vehiculo'";
    $rspta = ejecutarConsulta($sql);

    $dias = [];
    while ($row = $rspta->fetch(PDO::FETCH_ASSOC)) {
        $dias[] = $row['diaSemana'];
    }

    echo json_encode(['dias' => $dias]);

    break;

/* ------------------------------------------------------------------
   Obtener lat/lng + nombre de imagen de una dirección
   ------------------------------------------------------------------ */
case 'getDatosDireccion':

    $idDireccion = $_GET['idDireccion'];

    // Incluimos la columna imagen
    $sql = "SELECT latitud, longitud, imagen
              FROM direccion
             WHERE idDireccion = '$idDireccion'";

    $rspta = ejecutarConsultaSimpleFila($sql);

    if ($rspta) {
        echo json_encode([
            'latitud'  => $rspta['latitud']  ?? '',
            'longitud' => $rspta['longitud'] ?? '',
            'imagen'   => $rspta['imagen']   ?? ''   // ← se usará en el JS
        ]);
    } else {
        echo json_encode([
            'latitud'  => '',
            'longitud' => '',
            'imagen'   => ''
        ]);
    }

    break;




}
?>