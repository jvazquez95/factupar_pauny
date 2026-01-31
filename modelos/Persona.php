<?php 


require "../config/Conexion.php";

Class Persona
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar(
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

		$TipoPersona_idTipoPersona,
		$terminoPago,
		$GrupoPersona_idGrupoPersona,
		$cuentaAPagar,
		$cuentaAnticipo,
		$comision,
		$salario,

		$TipoDireccion_Telefono_idTipoDireccion_Telefono,
		$Ciudad_idCiudad,
		$Barrio_idBarrio,
		$callePrincipal,
		$calleTransversal,
		$nroCasa,
		$longitud,
		$latitud,
		
		$TipoDireccion_Telefono_idTipoDireccion_Telefono_tel,
		$telefono,

		$nya,
		$Cargo_idCargo,
		$email_2,
		$telefono_2,

		$Dia_idDia,
		$cantidad


	){
		session_start();
		$usuario = $_SESSION['login'];

		$ap = trim($apellidos);
		$no = trim($nombres);
		$nf_input = trim($nombreFantasia);
		$concatenado = ($ap !== '' && $no !== '') ? ($ap . ', ' . $no) : ($ap . $no);
		// Columnas viejas: solo el concatenado derivado (nombreFantasia si existe, si no apellidos, nombres)
		$valorRazonYComercial = ($nf_input !== '') ? $nf_input : $concatenado;
		$razonSocial = strtoupper(addslashes($valorRazonYComercial));
		$nombreComercial = strtoupper(addslashes($valorRazonYComercial));
		$apellidos = addslashes($ap);
		$nombres = addslashes($no);
		$nombreFantasia = addslashes($nf_input);

		$sql="
			INSERT INTO `persona`
			(
			`razonSocial`,
			`nombreComercial`,
			`apellidos`,
			`nombres`,
			`nombreFantasia`,
			`tipoDocumento`,
			`nroDocumento`,
			`mail`,
			`regimenTurismo`,
			`inactivo`,
			`usuarioInsercion`,
			`fechaInsercion`,
			`tipoEmpresa`,
			`fechaNacimiento`,
			`Referencia_idPersona`,
			`tercerizado`
			)
			VALUES
			(
			'$razonSocial',
			'$nombreComercial',
			'$apellidos',
			'$nombres',
			'$nombreFantasia',
			'$tipoDocumento',
			'$nroDocumento',
			'$mail',
			'$regimenTurismo',
			0,
			'$usuario',
			now(),
			'$tipoEmpresa',
			'$fechaNacimiento',
			'$Proveedor_idProveedor',
			'$tercerizado'
			)";


		$nuevoId = ejecutarConsulta_retornarID($sql);
	
		$num_elementosTipoPersona=0;
		$sw=true;


if ( is_array( $TipoPersona_idTipoPersona )) {


		while ($num_elementosTipoPersona < count($TipoPersona_idTipoPersona))
		{

			//$comisiongsp[$num_elementos]= str_replace('.','',$comisiongsp[$num_elementos]);
			//$comision_a_gs = ($comisionp[$num_elementos] * ) / $precioVenta[$num_elementos];
			//$netov = ( $totalv * $impuesto[$num_elementos] ) / 100;
			$sql_detalle = "INSERT INTO `persona_tipopersona`
							(
							`TipoPersona_idTipoPersona`,
							`Persona_idPersona`,
							`terminoPago`,
							`GrupoPersona_idGrupoPersona`,
							`cuentaAPagar`,
							`cuentaAnticipo`,
							`comision`,
							`salario`,			
							`inactivo`,
							`usuarioInsercion`,
							`fechaInsercion`
							)
							VALUES
							(
							'$TipoPersona_idTipoPersona[$num_elementosTipoPersona]',
							'$nuevoId',
							'$terminoPago[$num_elementosTipoPersona]',
							'$GrupoPersona_idGrupoPersona[$num_elementosTipoPersona]',
							'$cuentaAPagar[$num_elementosTipoPersona]',
							'$cuentaAnticipo[$num_elementosTipoPersona]',
							'$comision[$num_elementosTipoPersona]',
							'$salario[$num_elementosTipoPersona]',
							0,
							'$usuario',
							now()
							)";


			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementosTipoPersona=$num_elementosTipoPersona + 1;
		}

}


		$num_elementosDireccion=0;
		$sw=true;


if ( is_array( $TipoDireccion_Telefono_idTipoDireccion_Telefono )) {


		while ($num_elementosDireccion < count($TipoDireccion_Telefono_idTipoDireccion_Telefono))
		{
			$cp = isset($callePrincipal[$num_elementosDireccion]) ? trim($callePrincipal[$num_elementosDireccion]) : '';
			$ct = isset($calleTransversal[$num_elementosDireccion]) ? trim($calleTransversal[$num_elementosDireccion]) : '';
			$nc = isset($nroCasa[$num_elementosDireccion]) ? trim($nroCasa[$num_elementosDireccion]) : '';
			$direccion_completa = trim($cp . ' ' . $ct . ' ' . $nc);
			if ($direccion_completa === '') { $direccion_completa = $cp; }
			$direccion_completa = addslashes($direccion_completa);
			$cp = addslashes($cp);
			$ct = addslashes($ct);
			$nc = addslashes($nc);

			$sql_detalle = "INSERT INTO `direccion`
							(
							`Persona_idPersona`,
							`direccion`,
							`callePrincipal`,
							`calleTransversal`,
							`nroCasa`,
							`TipoDireccion_Telefono_idTipoDireccion_Telefono`,
							`Barrio_idBarrio`,
							`Ciudad_idCiudad`,			
							`latitud`,			
							`longitud`,			
							`inactivo`,
							`usuarioInsercion`,
							`fechaInsercion`
							)
							VALUES
							(
							'$nuevoId',
							'$direccion_completa',
							'$cp',
							'$ct',
							'$nc',
							'$TipoDireccion_Telefono_idTipoDireccion_Telefono[$num_elementosDireccion]',
							'$Barrio_idBarrio[$num_elementosDireccion]',
							'$Ciudad_idCiudad[$num_elementosDireccion]',
							'$latitud[$num_elementosDireccion]',
							'$longitud[$num_elementosDireccion]',
							0,
							'$usuario',
							now()
							)";


			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementosDireccion=$num_elementosDireccion + 1;
		}


}




		$num_elementosTelefono=0;
		$sw=true;

if ( is_array( $TipoDireccion_Telefono_idTipoDireccion_Telefono_tel )) {



	while ($num_elementosTelefono < count($TipoDireccion_Telefono_idTipoDireccion_Telefono_tel))
		{
			$val_telefono = addslashes(trim($telefono[$num_elementosTelefono]));
			$val_tipo_tel = $TipoDireccion_Telefono_idTipoDireccion_Telefono_tel[$num_elementosTelefono];

			$sql_detalle = "INSERT INTO `telefono`
							(
							`Persona_idPersona`,
							`telefono`,
							`TipoDireccion_Telefono_idTipoDireccion_Telefono`,
							`inactivo`,
							`usuarioInsercion`,
							`fechaInsercion`
							)
							VALUES
							(
							'$nuevoId',
							'$val_telefono',
							'$val_tipo_tel',
							0,
							'$usuario',
							now()
							)";


			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementosTelefono=$num_elementosTelefono + 1;
		}


}





		$num_elementosPersonaContacto=0;
		$sw=true;

	
if ($TipoPersona_idTipoPersona == 2) {
	if ( is_array( $nya )) {



		while ($num_elementosPersonaContacto < count($nya))
			{
				$val_nya = addslashes(trim($nya[$num_elementosPersonaContacto]));
				$val_cargo = $Cargo_idCargo[$num_elementosPersonaContacto];
				$val_email = addslashes(trim($email_2[$num_elementosPersonaContacto]));
				$val_telefono = addslashes(trim($telefono_2[$num_elementosPersonaContacto]));

				$sql_detalle = "INSERT INTO `personaContacto`
								(
								`Persona_idPersona`,
								`nya`,
								`Cargo_idCargo`,
								`email`,
								`telefono`
								)
								VALUES
								(
								'$nuevoId',
								'$val_nya',
								'$val_cargo',
								'$val_email',
								'$val_telefono'
								)";


				ejecutarConsulta($sql_detalle) or $sw = false;
				$num_elementosPersonaContacto=$num_elementosPersonaContacto + 1;
			}


	}
}



$num_elementosDias=0;
if ( is_array( $Dia_idDia )) {



	while ($num_elementosDias < count($Dia_idDia))
		{

			$sql_detalle = "INSERT INTO `personasDias`
							(
							`Dia_idDia`,
							`cantidad`,
							`Persona_idPersona`,
							`inactivo`,
							`usuarioIns`,
							`fechaIns`
							)
							VALUES
							(
							'$Dia_idDia[$num_elementosDias]',
							'$cantidad[$num_elementosDias]',
							'$nuevoId',
							0,
							'$usuario',
							now()
							)";


			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementosDias=$num_elementosDias + 1;
		}


}




		return $sw;

	}



	//Implementamos un método para insertar registros
	public function insertarr($razonSocial,$tipoDocumento,$nroDocumento,$celular,$correo, $fechaNacimiento, $direccion)
	{
		session_start();
		$usuario = $_SESSION['login'];
		$sql="CALL SP_CrearCliente('$razonSocial', '$tipoDocumento', '$nroDocumento', '$celular', '$correo', '$fechaNacimiento', '$direccion', '$usuario') ";


		return ejecutarConsultaSimpleFila($sql);
	
	}



	//Implementamos un método para editar registros
	public function editar($idPersona,$razonSocial,$nombreComercial,$apellidos,$nombres,$nombreFantasia,$tipoDocumento,$nroDocumento,$mail,$fechaNacimiento, $regimenTurismo, $tipoEmpresa, $Proveedor_idProveedor,$tercerizado,
		$idPersonaTipoPersona,
		$TipoPersona_idTipoPersona,
		$terminoPago,
		$GrupoPersona_idGrupoPersona,
		$cuentaAPagar,
		$cuentaAnticipo,
		$comision,
		$salario,

		$idDireccion,
		$TipoDireccion_Telefono_idTipoDireccion_Telefono,
		$Ciudad_idCiudad,
		$Barrio_idBarrio,
		$callePrincipal,
		$calleTransversal,
		$nroCasa,
		$longitud,
		$latitud,
		
		$idTelefono,
		$TipoDireccion_Telefono_idTipoDireccion_Telefono_tel,
		$telefono,

		$idPersonaContacto,
		$nya,
		$Cargo_idCargo,
		$email_2,
		$telefono_2,

		$idPersonaDia,
		$Dia_idDia,
		$cantidad

	)
	

	{
		$sw=true;
		session_start();
		$usuario = $_SESSION['login'];

		$ap = trim($apellidos);
		$no = trim($nombres);
		$nf_input = trim($nombreFantasia);
		$concatenado = ($ap !== '' && $no !== '') ? ($ap . ', ' . $no) : ($ap . $no);
		// Columnas viejas: solo el concatenado derivado (nombreFantasia si existe, si no apellidos, nombres)
		$valorRazonYComercial = ($nf_input !== '') ? $nf_input : $concatenado;
		$razonSocial = strtoupper(addslashes($valorRazonYComercial));
		$nombreComercial = strtoupper(addslashes($valorRazonYComercial));
		$apellidos = addslashes($ap);
		$nombres = addslashes($no);
		$nombreFantasia = addslashes($nf_input);
		
		$sql="UPDATE persona SET 
		razonSocial= '$razonSocial',
		nombreComercial= '$nombreComercial',
		apellidos= '$apellidos',
		nombres= '$nombres',
		nombreFantasia= '$nombreFantasia',
		tipoDocumento='$tipoDocumento',
		nroDocumento='$nroDocumento',
		regimenTurismo='$regimenTurismo',
		tercerizado='$tercerizado',
		mail='$mail',
		tipoEmpresa='$tipoEmpresa',
		fechaNacimiento='$fechaNacimiento',
		usuarioModificacion='$usuario', 
		fechaModificacion = now(),
		Referencia_idPersona = '$Proveedor_idProveedor'
		WHERE idPersona='$idPersona'";

		$sw = (ejecutarConsulta($sql) !== false);
		if (!$sw) {
			$sql_fallback = "UPDATE persona SET 
		razonSocial= '$razonSocial',
		nombreComercial= '$nombreComercial',
		tipoDocumento='$tipoDocumento',
		nroDocumento='$nroDocumento',
		regimenTurismo='$regimenTurismo',
		tercerizado='$tercerizado',
		mail='$mail',
		tipoEmpresa='$tipoEmpresa',
		fechaNacimiento='$fechaNacimiento',
		usuarioModificacion='$usuario', 
		fechaModificacion = now(),
		Referencia_idPersona = '$Proveedor_idProveedor'
		WHERE idPersona='$idPersona'";
			$sw = (ejecutarConsulta($sql_fallback) !== false);
		}


		$num_elementosTipoPersona=0;
		//$sw=true;
		if ($sw == true) {
			if ( is_array( $idPersonaTipoPersona )) {
				
					while ($num_elementosTipoPersona < count($idPersonaTipoPersona))
					{


						echo "<script>console.log('Debug Objects: " . $idPersonaTipoPersona[$num_elementosTipoPersona] . "' );</script>";

						if ($idPersonaTipoPersona[$num_elementosTipoPersona] == 0) {
							$sql_detalle = "INSERT INTO `persona_tipopersona`
											(
											`TipoPersona_idTipoPersona`,
											`Persona_idPersona`,
											`terminoPago`,
											`GrupoPersona_idGrupoPersona`,
											`cuentaAPagar`,
											`cuentaAnticipo`,
											`comision`,
											`salario`,			
											`inactivo`,
											`usuarioInsercion`,
											`fechaInsercion`
											)
											VALUES
											(
											'$TipoPersona_idTipoPersona[$num_elementosTipoPersona]',
											'$idPersona',
											'$terminoPago[$num_elementosTipoPersona]',
											'$GrupoPersona_idGrupoPersona[$num_elementosTipoPersona]',
											'$cuentaAPagar[$num_elementosTipoPersona]',
											'$cuentaAnticipo[$num_elementosTipoPersona]',
											'$comision[$num_elementosTipoPersona]',
											'$salario[$num_elementosTipoPersona]',
											0,
											'$usuario',
											now()
											)";


							ejecutarConsulta($sql_detalle) or $sw = false;
							$num_elementosTipoPersona=$num_elementosTipoPersona + 1;
				
						}else{

							$sql_detalle = "UPDATE `persona_tipopersona` SET
												`TipoPersona_idTipoPersona` = '$TipoPersona_idTipoPersona[$num_elementosTipoPersona]',
												`Persona_idPersona` = '$idPersona',
												`terminoPago` = '$terminoPago[$num_elementosTipoPersona]',
												`GrupoPersona_idGrupoPersona` = '$GrupoPersona_idGrupoPersona[$num_elementosTipoPersona]',
												`cuentaAPagar` = '$cuentaAPagar[$num_elementosTipoPersona]',
												`cuentaAnticipo` = '$cuentaAnticipo[$num_elementosTipoPersona]',
												`comision` = '$comision[$num_elementosTipoPersona]',
												`salario` = '$salario[$num_elementosTipoPersona]',
												`inactivo` = 0,
												`usuarioModificacion` = '$usuario',
												`fechaModificacion` = now()
												WHERE `idPersonaTipoPersona` = '$idPersonaTipoPersona[$num_elementosTipoPersona]'";
							ejecutarConsulta($sql_detalle) or $sw = false;
				

							$num_elementosTipoPersona=$num_elementosTipoPersona + 1;
						}
					}
			}
		}




		$num_elementosDireccion=0;
		//$sw=true;
		if ($sw == true) {


			if ( is_array( $idDireccion )) {



					while ($num_elementosDireccion < count($idDireccion)){
						
						if ($idDireccion[$num_elementosDireccion] == 0) {
							$cp = isset($callePrincipal[$num_elementosDireccion]) ? trim($callePrincipal[$num_elementosDireccion]) : '';
							$ct = isset($calleTransversal[$num_elementosDireccion]) ? trim($calleTransversal[$num_elementosDireccion]) : '';
							$nc = isset($nroCasa[$num_elementosDireccion]) ? trim($nroCasa[$num_elementosDireccion]) : '';
							$direccion_completa = trim($cp . ' ' . $ct . ' ' . $nc);
							if ($direccion_completa === '') { $direccion_completa = $cp; }
							$direccion_completa = addslashes($direccion_completa);
							$cp = addslashes($cp);
							$ct = addslashes($ct);
							$nc = addslashes($nc);

							$sql_detalle = "INSERT INTO `direccion`
											(
											`Persona_idPersona`,
											`direccion`,
											`callePrincipal`,
											`calleTransversal`,
											`nroCasa`,
											`TipoDireccion_Telefono_idTipoDireccion_Telefono`,
											`Barrio_idBarrio`,
											`Ciudad_idCiudad`,			
											`latitud`,			
											`longitud`,			
											`inactivo`,
											`usuarioInsercion`,
											`fechaInsercion`
											)
											VALUES
											(
											'$idPersona',
											'$direccion_completa',
											'$cp',
											'$ct',
											'$nc',
											'$TipoDireccion_Telefono_idTipoDireccion_Telefono[$num_elementosDireccion]',
											'$Barrio_idBarrio[$num_elementosDireccion]',
											'$Ciudad_idCiudad[$num_elementosDireccion]',
											'$latitud[$num_elementosDireccion]',
											'$longitud[$num_elementosDireccion]',
											0,
											'$usuario',
											now()
											)";

							ejecutarConsulta($sql_detalle) or $sw = false;
							 $num_elementosDireccion=$num_elementosDireccion + 1;

				
						}else{
							$cp = isset($callePrincipal[$num_elementosDireccion]) ? trim($callePrincipal[$num_elementosDireccion]) : '';
							$ct = isset($calleTransversal[$num_elementosDireccion]) ? trim($calleTransversal[$num_elementosDireccion]) : '';
							$nc = isset($nroCasa[$num_elementosDireccion]) ? trim($nroCasa[$num_elementosDireccion]) : '';
							$direccion_completa = trim($cp . ' ' . $ct . ' ' . $nc);
							if ($direccion_completa === '') { $direccion_completa = $cp; }
							$direccion_completa = addslashes($direccion_completa);
							$cp = addslashes($cp);
							$ct = addslashes($ct);
							$nc = addslashes($nc);

							$sql_detalle = "UPDATE `direccion` SET
												`Persona_idPersona` = '$idPersona',
												`direccion` = '$direccion_completa',
												`callePrincipal` = '$cp',
												`calleTransversal` = '$ct',
												`nroCasa` = '$nc',
												`TipoDireccion_Telefono_idTipoDireccion_Telefono` = '$TipoDireccion_Telefono_idTipoDireccion_Telefono[$num_elementosDireccion]',
												`Barrio_idBarrio` = '$Barrio_idBarrio[$num_elementosDireccion]',
												`Ciudad_idCiudad` = '$Ciudad_idCiudad[$num_elementosDireccion]',
												`latitud` = '$latitud[$num_elementosDireccion]',
												`longitud` = '$longitud[$num_elementosDireccion]',
												`usuarioModificacion` = '$usuario',
												`fechaModificacion` = now()
												WHERE `idDireccion` = '$idDireccion[$num_elementosDireccion]'";
							ejecutarConsulta($sql_detalle) or $sw = false;
				

							 $num_elementosDireccion=$num_elementosDireccion + 1;
						}
					}
			}
		}
	





		$num_elementosTelefono=0;
		//$sw=true;
		if ($sw == true) {


			if ( is_array( $idTelefono )) {


					while ($num_elementosTelefono < count($idTelefono))
					{
				

						if ($idTelefono[$num_elementosTelefono] == 0) {

							$val_telefono = addslashes(trim($telefono[$num_elementosTelefono]));
							$val_tipo_tel = $TipoDireccion_Telefono_idTipoDireccion_Telefono_tel[$num_elementosTelefono];

							$sql_detalle = "INSERT INTO `telefono`
											(
											`Persona_idPersona`,
											`telefono`,
											`TipoDireccion_Telefono_idTipoDireccion_Telefono`,
											`inactivo`,
											`usuarioInsercion`,
											`fechaInsercion`
											)
											VALUES
											(
											'$idPersona',
											'$val_telefono',
											'$val_tipo_tel',
											0,
											'$usuario',
											now()
											)";


							ejecutarConsulta($sql_detalle) or $sw = false;
							 $num_elementosTelefono=$num_elementosTelefono + 1;
				
						}else{

							$val_telefono = addslashes(trim($telefono[$num_elementosTelefono]));
							$val_tipo_tel = $TipoDireccion_Telefono_idTipoDireccion_Telefono_tel[$num_elementosTelefono];
							$val_id_tel = $idTelefono[$num_elementosTelefono];

							$sql_detalle = "UPDATE `telefono` SET
												`Persona_idPersona` = '$idPersona',
												`telefono` = '$val_telefono',
												`TipoDireccion_Telefono_idTipoDireccion_Telefono` = '$val_tipo_tel',
												`usuarioModificacion` = '$usuario',
												`fechaModificacion` = now()
												WHERE `idTelefono` = '$val_id_tel'";
							ejecutarConsulta($sql_detalle) or $sw = false;
				

							 $num_elementosTelefono=$num_elementosTelefono + 1;
						}
					}
			}
		}



$num_elementosDias=0;
if ( is_array( $Dia_idDia )) {


	while ($num_elementosDias < count($Dia_idDia))
		{

			if ($idPersonaDia[$num_elementosDias] == 0) {

				$sql_detalle = "INSERT INTO `personasDias`
								(
								`Dia_idDia`,
								`cantidad`,
								`Persona_idPersona`,
								`inactivo`,
								`usuarioIns`,
								`fechaIns`
								)
								VALUES
								(
								'$Dia_idDia[$num_elementosDias]',
								'$cantidad[$num_elementosDias]',
								'$idPersona',
								0,
								'$usuario',
								now()
								)";


				// ejecutarConsulta($sql_detalle) or $sw = false;
				 $num_elementosDias=$num_elementosDias + 1;
			}else{
							$sql_detalle = "UPDATE `personasDias` SET
												`Persona_idPersona` = '$idPersona',
												`Dia_idDia` = '$Dia_idDia[$num_elementosDias]',
												`cantidad` = '$cantidad[$num_elementosDias]',
												`usuarioMod` = '$usuario',
												`fechaMod` = now()
												WHERE `idPersonaDia` = '$idPersonaDia[$num_elementosDias]'";
							// ejecutarConsulta($sql_detalle) or $sw = false;
				

							 $num_elementosDias=$num_elementosDias + 1;
			}
		}


}
		
		$num_elementosPersonaContacto=0;
		//$sw=true;
		if ($sw == true) {

			if ( is_array( $nya )) {

					while ($num_elementosPersonaContacto < count($nya))
					{
				

						if ($idPersonaContacto[$num_elementosPersonaContacto] == 0) {

							$val_nya = addslashes(trim($nya[$num_elementosPersonaContacto]));
							$val_cargo = $Cargo_idCargo[$num_elementosPersonaContacto];
							$val_email = addslashes(trim($email_2[$num_elementosPersonaContacto]));
							$val_telefono = addslashes(trim($telefono_2[$num_elementosPersonaContacto]));

							$sql_detalle = "INSERT INTO `personaContacto`
								(
								`Persona_idPersona`,
								`nya`,
								`Cargo_idCargo`,
								`email`,
								`telefono`
								)
								VALUES
								(
								'$idPersona',
								'$val_nya',
								'$val_cargo',
								'$val_email',
								'$val_telefono'
								)";


							ejecutarConsulta($sql_detalle) or $sw = false;
							 $num_elementosPersonaContacto=$num_elementosPersonaContacto + 1;
				
						}else{

							$val_nya = addslashes(trim($nya[$num_elementosPersonaContacto]));
							$val_cargo = $Cargo_idCargo[$num_elementosPersonaContacto];
							$val_email = addslashes(trim($email_2[$num_elementosPersonaContacto]));
							$val_telefono = addslashes(trim($telefono_2[$num_elementosPersonaContacto]));
							$val_id_contacto = $idPersonaContacto[$num_elementosPersonaContacto];

							$sql_detalle = "UPDATE `personaContacto` SET
												`Persona_idPersona` = '$idPersona',
												`telefono` = '$val_telefono',
												`Cargo_idCargo` = '$val_cargo',
												`nya` = '$val_nya',
												`email` = '$val_email'
												WHERE `idPersonaContacto` = '$val_id_contacto'";

											
							ejecutarConsulta($sql_detalle) or $sw = false;
							 $num_elementosPersonaContacto=$num_elementosPersonaContacto + 1;
						}
					}
			}
		}









		return $sw;




	}

	//Implementamos un método para eliminar categorías
	public function activar($idPersona)
	{

		session_start();
		$usuario = $_SESSION['login'];

		$sql="UPDATE persona set inactivo = 0, fechaModificacion = now(), usuarioModificacion = '$usuario' WHERE idPersona='$idPersona'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para eliminar categorías
	public function desactivar($idPersona)
	{

		session_start();
		$usuario = $_SESSION['login'];

		$sql="UPDATE persona set inactivo = 1, fechaModificacion = now(), usuarioModificacion = '$usuario' WHERE idPersona='$idPersona'";
		return ejecutarConsulta($sql);
	}


	//Implementamos un método para eliminar categorías
	public function desactivarTP($id)
	{
		$sql="DELETE FROM persona_tipopersona WHERE idPersonaTipoPersona='$id'";
		return ejecutarConsulta($sql);
	}


	//Implementamos un método para eliminar categorías
	public function desactivarDireccion($id)
	{
		$sql="DELETE FROM direccion WHERE idDireccion='$id'";
		return ejecutarConsulta($sql);
	}


	//Implementamos un método para eliminar categorías
	public function desactivarTelefono($id)
	{
		$sql="DELETE FROM telefono WHERE idTelefono='$id'";
		return ejecutarConsulta($sql);
	}


	//Implementamos un método para eliminar categorías
	public function desactivarPersonaContacto($id)
	{
		$sql="DELETE FROM personaContacto WHERE idPersonaContacto='$id'";
		return ejecutarConsulta($sql);
	}

	public function desactivarVisita($id)
	{
		$sql="DELETE FROM personasDias WHERE idPersonaDia='$id'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idPersona)
	{
		$sql="SELECT * FROM persona WHERE idPersona='$idPersona'";
		return ejecutarConsultaSimpleFila($sql);
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function buscar_persona_ruc($nroDocumento)
	{
		$sql="SELECT * FROM persona where nroDocumento = '$nroDocumento'";
		return ejecutarConsultaSimpleFila($sql);
	}




	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT *, UPPER(F_NOMBRE_PERSONA( Referencia_idPersona )) empresaReferencia, F_PERSONA_TELEFONO(idPersona) tel, usuarioInsercion FROM persona;";
		return ejecutarConsulta($sql);		
	}

	/**
	 * KPIs de personas: total, por tipo, activos, inactivos.
	 */
	public function listarKpis()
	{
		$total = ejecutarConsultaSimpleFila("SELECT COUNT(*) as total FROM persona");
		$activos = ejecutarConsultaSimpleFila("SELECT COUNT(*) as total FROM persona WHERE inactivo = 0");
		$inactivos = ejecutarConsultaSimpleFila("SELECT COUNT(*) as total FROM persona WHERE inactivo = 1");
		$porTipo = array();
		$rs = ejecutarConsulta("SELECT tp.idTipoPersona, tp.descripcion, COUNT(DISTINCT pt.Persona_idPersona) as cantidad FROM tipopersona tp LEFT JOIN persona_tipopersona pt ON tp.idTipoPersona = pt.TipoPersona_idTipoPersona AND pt.inactivo = 0 GROUP BY tp.idTipoPersona, tp.descripcion ORDER BY tp.descripcion");
		if ($rs !== false) {
			while ($r = $rs->fetchObject()) {
				$porTipo[] = array('idTipoPersona' => (int)$r->idTipoPersona, 'descripcion' => $r->descripcion, 'cantidad' => (int)$r->cantidad);
			}
		}
		return array(
			'total' => isset($total['total']) ? (int)$total['total'] : 0,
			'activos' => isset($activos['total']) ? (int)$activos['total'] : 0,
			'inactivos' => isset($inactivos['total']) ? (int)$inactivos['total'] : 0,
			'porTipo' => $porTipo
		);
	}

	/**
	 * Listar personas para reporte PDF (inventario). Opcional filtro por idTipoPersona.
	 */
	public function listarParaReporte($idTipoPersona = null)
	{
		$idTipoPersona = $idTipoPersona ? (int)$idTipoPersona : 0;
		if ($idTipoPersona > 0) {
			$sql = "SELECT DISTINCT p.*, F_PERSONA_TELEFONO(p.idPersona) as tel, tp.descripcion as tipoPersonaDesc 
				FROM persona p 
				INNER JOIN persona_tipopersona pt ON p.idPersona = pt.Persona_idPersona AND pt.inactivo = 0 AND pt.TipoPersona_idTipoPersona = '$idTipoPersona'
				INNER JOIN tipopersona tp ON tp.idTipoPersona = pt.TipoPersona_idTipoPersona
				ORDER BY p.razonSocial";
		} else {
			$sql = "SELECT p.*, F_PERSONA_TELEFONO(p.idPersona) as tel,
				(SELECT GROUP_CONCAT(tp2.descripcion SEPARATOR ', ') FROM persona_tipopersona pt2 JOIN tipopersona tp2 ON tp2.idTipoPersona = pt2.TipoPersona_idTipoPersona WHERE pt2.Persona_idPersona = p.idPersona AND pt2.inactivo = 0) as tipoPersonaDesc
				FROM persona p
				ORDER BY p.razonSocial";
		}
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros 
	public function listarc()
	{
		$sql="SELECT * FROM persona p JOIN persona_tipopersona pt on p.idPersona = pt.Persona_idPersona 
		where pt.TipoPersona_idTipoPersona = 1";
		return ejecutarConsulta($sql);	
	}


	public function listarDetalleTipoPersona($idPersona)
	{
	

		$sql="SELECT *, tipopersona.descripcion as tpdd, grupopersona.descripcion as gpd, terminopago.descripcion as tpd, persona_tipopersona.cuentaAnticipo as ca, persona_tipopersona.cuentaAPagar as cp from persona_tipopersona, tipopersona, grupopersona, terminopago
where persona_tipopersona.TipoPersona_idTipoPersona =  tipopersona.idTipoPersona and Persona_idPersona = '$idPersona' and persona_tipopersona.inactivo = 0 and grupopersona.idGrupoPersona = persona_tipopersona.GrupoPersona_idGrupoPersona and terminopago.idTerminoPago = persona_tipopersona.terminoPago";
		return ejecutarConsulta($sql);		
	}

	public function listarDetalleDireccion($idPersona)
	{
		$sql="SELECT *, F_NOMBRE_TIPODIRECCION_TELEFONO(TipoDireccion_Telefono_idTipoDireccion_Telefono) as dt, F_NOMBRE_CIUDAD( Ciudad_idCiudad ) as dc, F_NOMBRE_BARRIO( Barrio_idBarrio ) as db FROM direccion where Persona_idPersona = '$idPersona' and inactivo = 0";
		return ejecutarConsulta($sql);		
	}

	public function listarDetalleTelefono($idPersona)
	{
		$sql="SELECT *, F_NOMBRE_TIPODIRECCION_TELEFONO(TipoDireccion_Telefono_idTipoDireccion_Telefono) as dt FROM telefono where Persona_idPersona = '$idPersona' and inactivo = 0";
		return ejecutarConsulta($sql);		
	}

	public function listarDetalleDias($idPersona)
	{
		$sql="SELECT idPersonaDia, descripcion, iddias, cantidad from personasDias, dias where iddias = Dia_idDia and personasDias.inactivo = 0 and Persona_idPersona = '$idPersona'";
		return ejecutarConsulta($sql);		
	}



	public function listarDetallePersonaContacto($idPersona)
	{
		$sql="SELECT idPersonaContacto, Persona_idPersona, nya AS contact_nya, Cargo_idCargo, email AS contact_email, telefono AS contact_telefono, F_NOMBRE_CARGO(Cargo_idCargo) AS nc FROM personaContacto WHERE Persona_idPersona = '$idPersona' AND inactivo = 0";
		return ejecutarConsulta($sql);		
	}



	public function selectCliente()
	{
		$sql="SELECT * from persona, persona_tipopersona,tipopersona
				where persona.idPersona = persona_tipopersona.Persona_idPersona and tipopersona.idTipoPersona = persona_tipopersona.TipoPersona_idTipoPersona and persona_tipopersona.inactivo = 0 and persona_tipopersona.TipoPersona_idTipoPersona = 1";
		return ejecutarConsulta($sql);		
	}

	public function selectClienteLimit()
	{
		$sql="SELECT * from persona, persona_tipopersona,tipopersona
				where persona.idPersona = persona_tipopersona.Persona_idPersona and tipopersona.idTipoPersona = persona_tipopersona.TipoPersona_idTipoPersona and persona_tipopersona.inactivo = 0 and persona_tipopersona.TipoPersona_idTipoPersona = 1 limit 10";
		return ejecutarConsulta($sql);		
	}

	public function selectProveedor() 
	{
		$sql="SELECT * from persona, persona_tipopersona,tipopersona 
				where persona.idPersona = persona_tipopersona.Persona_idPersona and tipopersona.idTipoPersona = persona_tipopersona.TipoPersona_idTipoPersona and persona_tipopersona.inactivo = 0 and persona_tipopersona.TipoPersona_idTipoPersona = 2";
		return ejecutarConsulta($sql);		
	}

	public function selectFuncionario()
	{
		$sql="SELECT * from persona, persona_tipopersona,tipopersona
				where persona.idPersona = persona_tipopersona.Persona_idPersona and tipopersona.idTipoPersona = persona_tipopersona.TipoPersona_idTipoPersona and persona_tipopersona.inactivo = 0 and persona_tipopersona.TipoPersona_idTipoPersona = 3";
		return ejecutarConsulta($sql);		
	}

	public function selectDirecciones($idPersona)
	{
		$sql="SELECT idDireccion, direccion from direccion where  Persona_idPersona = '$idPersona'";
		return ejecutarConsulta($sql);		
	}


	public function limiteCredito($idPersona)
	{
		$sql="SELECT max(lineaAprobada) as lineaAprobada from limitecredito where Persona_idPersona = '$idPersona' and inactivo = 0";
		return ejecutarConsultaSimpleFila($sql);
	}

	/**
	 * Normaliza número de documento: solo la parte antes del guion (ej: 4831750-0 → 4831750).
	 * En ambos lados (entrada y BD) se usa la misma limpieza para comparar.
	 */
	public static function normalizarDocumento($numero) {
		$numero = trim((string) $numero);
		if ($numero === '') return '';
		$parte = explode('-', $numero);
		return trim($parte[0]);
	}

	public function verificarRuc($codigo, $idPersonaExcluir = '')
	{
		$codigo_limpio = self::normalizarDocumento($codigo);
		if ($codigo_limpio === '') {
			return array('cantidad' => 0, 'idPersona' => null);
		}
		$codigo_limpio = addslashes($codigo_limpio);
		$idPersonaExcluir = addslashes(trim($idPersonaExcluir));
		$and_excluir = ($idPersonaExcluir !== '') ? " AND idPersona != '$idPersonaExcluir'" : '';
		$sql = "SELECT COUNT(*) as cantidad, MIN(idPersona) as idPersona FROM persona 
			WHERE TRIM(SUBSTRING_INDEX(TRIM(CONCAT(nroDocumento,'')), '-', 1)) = '$codigo_limpio' 
			AND inactivo = 0" . $and_excluir;
		$r = ejecutarConsultaSimpleFila($sql);
		if ($r === false) {
			return array('cantidad' => 0, 'idPersona' => null);
		}
		$r['idPersona'] = isset($r['idPersona']) ? $r['idPersona'] : null;
		return $r;
	}


	public function listarVehiculos()
	{
		$sql="SELECT idVehiculo, nombreReferencia as descripcion FROM vehiculo";
		return ejecutarConsulta($sql);		
	}



public function getAsignacion($idDireccion)
{
    $sql = "SELECT Vehiculo_idVehiculo, diaSemana 
            FROM direccion_asignacion_ruta 
            WHERE Direccion_idDireccion = '$idDireccion'";
    return ejecutarConsulta($sql);
}



public function actualizarDireccion($idDireccion, $direccion, $latitud, $longitud, $idCiudad = null) {
    $sql = "UPDATE direccion SET 
                direccion = '$direccion',
                latitud = '$latitud',
                longitud = '$longitud'";

    if (!is_null($idCiudad)) {
        $sql .= ", Ciudad_idCiudad = '$idCiudad'";
    }

    $sql .= " WHERE idDireccion = '$idDireccion'";

    return ejecutarConsulta($sql);
}


  /* ==========================================================
       ACTUALIZAR latitud / longitud y, opcionalmente, la imagen
       ========================================================== */
    public function actualizarLatLongDireccion($idDireccion, $latitud, $longitud, $imagen = null)
    {
        // Sanitiza / escapa según tu helper o PDO; aquí con sprintf ↓
        if ($imagen) {
            $sql = sprintf(
                "UPDATE direccion
                    SET latitud = '%s',
                        longitud = '%s',
                        imagen = '%s'
                  WHERE idDireccion = '%d'",
                $latitud, $longitud, $imagen, $idDireccion
            );
        } else {
            $sql = sprintf(
                "UPDATE direccion
                    SET latitud = '%s',
                        longitud = '%s'
                  WHERE idDireccion = '%d'",
                $latitud, $longitud, $idDireccion
            );
        }

        return ejecutarConsulta($sql);  // tu helper habitual
    }



    /* ==========================================================
       ELIMINAR asignación para un día
       ========================================================== */
    public function eliminarAsignacionDia($idDireccion, $dia)
    {
        $sql = "DELETE FROM direccion_asignacion_ruta
                WHERE Direccion_idDireccion = '$idDireccion'
                  AND diaSemana = '$dia'";
        return ejecutarConsulta($sql);
    }

    /* ==========================================================
       INSERTAR asignación
       ========================================================== */
    public function insertarAsignacion($idDireccion, $vehiculo, $dia)
    {
        $sql = "INSERT INTO direccion_asignacion_ruta
                  (Direccion_idDireccion, Vehiculo_idVehiculo, diaSemana)
                VALUES ('$idDireccion', '$vehiculo', '$dia')";
        return ejecutarConsulta($sql);
    }


}

?>