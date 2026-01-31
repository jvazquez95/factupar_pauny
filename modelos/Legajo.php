<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Legajo
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar(
		$razonSocial,
		$nombreComercial,
		$tipoDocumento,
		$nroDocumento,
		$mail,
		$fechaNacimiento,
		$regimenTurismo,
		$tipoEmpresa,	

		$EstadoCivil_idEstadoCivil,
		$sexo,
		$Profesion_idProfesion,
		$Departamento_idDepartamento,
		$Sucursal_idSucursal,
		$Cargo_idCargo,
		$Clase_idClase,
		$MedioCobro_idMedioCobro,
		$Banco_idBanco,
		$nroCuenta,
		$TipoSalario_idTipoSalario,
		$TipoContrato_idTipoContrato,
		$nroSeguroSocial,
		$nroContrato,

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
		$telefono){
		session_start();
		$usuario = $_SESSION['login'];

		$sql="
			INSERT INTO `persona`
			(
			`razonSocial`,
			`nombreComercial`,
			`tipoDocumento`,
			`nroDocumento`,
			`mail`,
			`regimenTurismo`,
			`inactivo`,
			`usuarioInsercion`,
			`fechaInsercion`,
			`tipoEmpresa`,
			`fechaNacimiento`,
			`EstadoCivil_idEstadoCivil`,
			`sexo`,
			`Profesion_idProfesion`,
			`Departamento_idDepartamento`,
			`Sucursal_idSucursal`,
			`Cargo_idCargo`,
			`Clase_idClase`,
			`MedioCobro_idMedioCobro`,
			`Banco_idBanco`,
			`nroCuenta`,
			`TipoSalario_idTipoSalario`,
			`TipoContrato_idTipoContrato`,
			`nroSeguroSocial`,
			`nroContrato`
			)
			VALUES
			(
			'$razonSocial',
			'$nombreComercial',
			'$tipoDocumento',
			'$nroDocumento',
			'$mail',
			'$regimenTurismo',
			0,
			'$usuario',
			now(),
			'$tipoEmpresa',
			'$fechaNacimiento',
			'$EstadoCivil_idEstadoCivil',
			'$sexo',
			'$Profesion_idProfesion',
			'$Departamento_idDepartamento',
			'$Sucursal_idSucursal',
			'$Cargo_idCargo',
			'$Clase_idClase',
			'$MedioCobro_idMedioCobro',
			'$Banco_idBanco',
			'$nroCuenta',
			'$TipoSalario_idTipoSalario',
			'$TipoContrato_idTipoContrato',
			'$nroSeguroSocial',
			'$nroContrato'
			)";


		$nuevoId = ejecutarConsulta_retornarID($sql);
		$sw=false;

if ($nuevoId > 0) {
		$sw = true;
		$num_elementosTipoPersona=0;


// if ( is_array( $TipoPersona_idTipoPersona )) {


// 		while ($num_elementosTipoPersona < count($TipoPersona_idTipoPersona))
// 		{

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
							'3',
							'$nuevoId',
							'1',
							'1',
							'0',
							'0',
							'0',
							'0',
							0,
							'$usuario',
							now()
							)";


			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementosTipoPersona=$num_elementosTipoPersona + 1;
// 		}

// }


		$num_elementosDireccion=0;
		$sw=true;


if ( is_array( $TipoDireccion_Telefono_idTipoDireccion_Telefono )) {


		while ($num_elementosDireccion < count($TipoDireccion_Telefono_idTipoDireccion_Telefono))
		{

			//$comisiongsp[$num_elementos]= str_replace('.','',$comisiongsp[$num_elementos]);
			//$comision_a_gs = ($comisionp[$num_elementos] * ) / $precioVenta[$num_elementos];
			//$netov = ( $totalv * $impuesto[$num_elementos] ) / 100;
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
							'$direccion[$num_elementosDireccion]',
							'$callePrincipal[$num_elementosDireccion]',
							'$calleTransversal[$num_elementosDireccion]',
							'$nroCasa[$num_elementosDireccion]',
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
							'$telefono[$num_elementosTelefono]',
							'$TipoDireccion_Telefono_idTipoDireccion_Telefono_tel[$num_elementosTelefono]',
							0,
							'$usuario',
							now()
							)";


			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementosTelefono=$num_elementosTelefono + 1;
		}


}

}	


		return $sw;

	}



	//Implementamos un método para insertar registros
	public function insertarr($razonSocial,$tipoDocumento,$nroDocumento,$celular,$correo, $fechaNacimiento, $direccion)
	{
		$sql="CALL SP_CrearCliente('$razonSocial', '$tipoDocumento', '$nroDocumento', '$celular', '$correo', '$fechaNacimiento', '$direccion') ";


		return ejecutarConsultaSimpleFila($sql);
	
	}



	//Implementamos un método para editar registros
	public function editar(
		$idPersona,
		$razonSocial,
		$nombreComercial,
		$tipoDocumento,
		$nroDocumento,
		$mail,
		$fechaNacimiento,
		$regimenTurismo,
		$tipoEmpresa,	

		$EstadoCivil_idEstadoCivil,
		$sexo,
		$Profesion_idProfesion,
		$Departamento_idDepartamento,
		$Sucursal_idSucursal,
		$Cargo_idCargo,
		$Clase_idClase,
		$MedioCobro_idMedioCobro,
		$Banco_idBanco,
		$nroCuenta,
		$TipoSalario_idTipoSalario,
		$TipoContrato_idTipoContrato,
		$nroSeguroSocial,
		$nroContrato,
		
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
		$telefono)
	

	{
		$sw=true;
		session_start();
		$usuario = $_SESSION['login'];

		$sql="UPDATE persona SET 
		razonSocial='$razonSocial',
		nombreComercial='$nombreComercial',
		tipoDocumento='$tipoDocumento',
		nroDocumento='$nroDocumento',
		regimenTurismo='$regimenTurismo',
		mail='$mail',
		tipoEmpresa='$tipoEmpresa',
		fechaNacimiento='$fechaNacimiento',
		EstadoCivil_idEstadoCivil	='$EstadoCivil_idEstadoCivil',
		sexo	='$sexo',
		Profesion_idProfesion	='$Profesion_idProfesion',
		Departamento_idDepartamento	='$Departamento_idDepartamento',
		Sucursal_idSucursal	='$Sucursal_idSucursal',
		Cargo_idCargo	='$Cargo_idCargo',
		Clase_idClase	='$Clase_idClase',
		MedioCobro_idMedioCobro	='$MedioCobro_idMedioCobro',
		Banco_idBanco	='$Banco_idBanco',
		nroCuenta	='$nroCuenta',
		TipoSalario_idTipoSalario	='$TipoSalario_idTipoSalario',
		TipoContrato_idTipoContrato	='$TipoContrato_idTipoContrato',
		nroSeguroSocial	='$nroSeguroSocial',
		nroContrato	='$nroContrato',
		usuarioModificacion='$usuario', 
		fechaModificacion = now() 
		WHERE idPersona='$idPersona'";


		ejecutarConsulta($sql) or $sw = false;


		$num_elementosTipoPersona=0;
		//$sw=true;
	    echo "<script>console.log('SW: " . $sw . "' );</script>";
		
		if ($sw == true) {
			if ( is_array( $idPersonaTipoPersona )) {
						
					while ($num_elementosTipoPersona < count($idPersonaTipoPersona))
					{

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
											'$direccion[$num_elementosDireccion]',
											'$callePrincipal[$num_elementosDireccion]',
											'$calleTransversal[$num_elementosDireccion]',
											'$nroCasa[$num_elementosDireccion]',
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

							$sql_detalle = "UPDATE `direccion` SET
												`Persona_idPersona` = '$idPersona',
												`direccion` = '$direccion[$num_elementosDireccion]',
												`callePrincipal` = '$callePrincipal[$num_elementosDireccion]',
												`calleTransversal` = '$calleTransversal[$num_elementosDireccion]',
												`nroCasa` = '$nroCasa[$num_elementosDireccion]',
												`TipoDireccion_Telefono_idTipoDireccion_Telefono` = '$TipoDireccion_Telefono_idTipoDireccion_Telefono[$num_elementosDireccion]',
												`Barrio_idBarrio` = '$Barrio_idBarrio[$num_elementosDireccion]',
												`Ciudad_idCiudad` = '$Barrio_idBarrio[$num_elementosDireccion]',
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
											'$telefono[$num_elementosTelefono]',
											'$TipoDireccion_Telefono_idTipoDireccion_Telefono_tel[$num_elementosTelefono]',
											0,
											'$usuario',
											now()
											)";


							ejecutarConsulta($sql_detalle) or $sw = false;
							$num_elementosTelefono=$num_elementosTelefono + 1;
				
						}else{

							$sql_detalle = "UPDATE `telefono` SET
												`Persona_idPersona` = '$idPersona',
												`telefono` = '$telefono[$num_elementosTelefono]',
												`TipoDireccion_Telefono_idTipoDireccion_Telefono` = '$TipoDireccion_Telefono_idTipoDireccion_Telefono_tel[$num_elementosTelefono]',
												`usuarioModificacion` = '$usuario',
												`fechaModificacion` = now()
												WHERE `idTelefono` = '$idTelefono[$num_elementosTelefono]'";
							ejecutarConsulta($sql_detalle) or $sw = false;
				

							$num_elementosTelefono=$num_elementosTelefono + 1;
						}
					}
			}
		}




		return $sw;




	}

	//Implementamos un método para eliminar categorías
	public function activar($idPersona)
	{
		$sql="UPDATE persona set inactivo = 0 WHERE idPersona='$idPersona'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para eliminar categorías
	public function desactivar($idPersona)
	{
		$sql="UPDATE persona set inactivo = 1 WHERE idPersona='$idPersona'";
		return ejecutarConsulta($sql);
	}


	//Implementamos un método para eliminar categorías
	public function desactivarTP($id)
	{
		$sql="UPDATE persona_tipopersona set inactivo = 1 WHERE idPersonaTipoPersona='$id'";
		return ejecutarConsulta($sql);
	}


	//Implementamos un método para eliminar categorías
	public function desactivarDireccion($id)
	{
		$sql="UPDATE direccion set inactivo = 1 WHERE idDireccion='$id'";
		return ejecutarConsulta($sql);
	}


	//Implementamos un método para eliminar categorías
	public function desactivarTelefono($id)
	{
		$sql="UPDATE telefono set inactivo = 1 WHERE idTelefono='$id'";
		return ejecutarConsulta($sql);
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idPersona)
	{
		$sql="SELECT * FROM persona WHERE idPersona='$idPersona'";
		return ejecutarConsultaSimpleFila($sql);
	}
	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT *, 
F_NOMBRE_ESTADOCIVIL(EstadoCivil_idEstadoCivil) AS descripcionEstadoCivil, 
F_NOMBRE_PROFESION(Profesion_idProfesion) AS descripcionProfesion, 
F_NOMBRE_DEPARTAMENTO(Departamento_idDepartamento) AS descripcionDepartamento, 
F_NOMBRE_SUCURSAL(Sucursal_idSucursal) AS descripcionSucursal, 
F_NOMBRE_CARGO(Cargo_idCargo) AS descripcionCargo, 
F_NOMBRE_CLASE(Clase_idClase) AS descripcionClase, 
F_NOMBRE_MEDIOCOBRO(MedioCobro_idMedioCobro) AS descripcionMedioCobro, 
F_NOMBRE_BANCO(Banco_idBanco) AS descripcionBanco,
F_NOMBRE_TIPOSALARIO(TipoSalario_idTipoSalario) AS descripcionTipoSalario,
F_NOMBRE_TIPOCONTRATO(TipoContrato_idTipoContrato) AS descripcionTipoContrato 
FROM persona, persona_tipopersona where idPersona = Persona_idPersona and TipoPersona_idTipoPersona = 3";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros 
	public function listarc()
	{
		$sql="SELECT * FROM persona WHERE tipo_persona='Cliente'";
		return ejecutarConsulta($sql);		
	}


	public function listarDetalleTipoPersona($idPersona)
	{
	

		$sql="SELECT *, tipopersona.descripcion as tpdd, grupopersona.descripcion as gpd, terminopago.descripcion as tpd, persona_tipopersona.cuentaAnticipo as ca, persona_tipopersona.cuentaAPagar as cp from persona_tipopersona, tipopersona, grupopersona, terminopago
where persona_tipopersona.TipoPersona_idTipoPersona =  tipopersona.idTipoPersona and Persona_idPersona = '$idPersona' and persona_tipopersona.inactivo = 0 and grupopersona.idGrupoPersona = persona_tipopersona.GrupoPersona_idGrupoPersona and terminopago.idTerminoPago = persona_tipopersona.terminoPago;";
		return ejecutarConsulta($sql);		
	}

	public function listarDetalleDireccion($idPersona)
	{
		$sql="SELECT * FROM direccion where Persona_idPersona = '$idPersona' and inactivo = 0";
		return ejecutarConsulta($sql);		
	}

	public function listarDetalleTelefono($idPersona)
	{
		$sql="SELECT * FROM telefono where Persona_idPersona = '$idPersona' and inactivo = 0";
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


	//Implementar un método para mostrar los datos de un registro a modificar
	public function limiteCredito($idPersona)
	{
		$sql="SELECT max(lineaAprobada) as lineaAprobada from limitecredito where Persona_idPersona = '$idPersona' and inactivo = 0";
		return ejecutarConsultaSimpleFila($sql);
	}






}

?>