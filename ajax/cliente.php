<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
$Proveedor_idProveedor=isset($_POST["Proveedor_idProveedor"])? limpiarCadena($_POST["Proveedor_idProveedor"]):"";
$inactivo=isset($_POST["inactivo"])? limpiarCadena($_POST["inactivo"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idPersona)){
			$apellidos = isset($_POST["apellidos"]) ? limpiarCadena($_POST["apellidos"]) : "";
			$nombres = isset($_POST["nombres"]) ? limpiarCadena($_POST["nombres"]) : "";
			$nombreFantasia = isset($_POST["nombreFantasia"]) ? limpiarCadena($_POST["nombreFantasia"]) : "";
			$tercerizado = isset($_POST["tercerizado"]) ? limpiarCadena($_POST["tercerizado"]) : "";
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


				$_POST['Dia_idDia_persona'],
				$_POST['cantidad_persona']

			);
			echo $rspta ? "Persona registrada" : "Persona no se pudo registrar";
		}
		else {
			$apellidos = isset($_POST["apellidos"]) ? limpiarCadena($_POST["apellidos"]) : "";
			$nombres = isset($_POST["nombres"]) ? limpiarCadena($_POST["nombres"]) : "";
			$nombreFantasia = isset($_POST["nombreFantasia"]) ? limpiarCadena($_POST["nombreFantasia"]) : "";
			$tercerizado = isset($_POST["tercerizado"]) ? limpiarCadena($_POST["tercerizado"]) : "";
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


				$_POST['idPersonaDia'],
				$_POST['Dia_idDia_persona'],
				$_POST['cantidad_persona']


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

	


	case 'listarDetalleTipoPersona':
		//Recibimos el idingreso
		$idPersona=$_GET['idPersona'];

				$rspta = $persona->listarDetalleTipoPersona($idPersona);
						echo '<thead style="background-color:#A9D0F5">
													<th>Opciones</th>
				                              		<th>Tipo Persona</th>
				                                    <th>Termino de Pago Habilitado</th>
				                                    <th>Grupo</th>
				                                    <th>Cuenta a Pagar</th>
				                                    <th>Cuenta anticipo</th>
				                                    <th>Comision</th>
				                                    <th>Salario</th>
				                                </thead>';
				        $contTP = 0;
						while ($reg = $rspta->fetchObject())
								{
									echo '<tr class="filasTP" id="filaTP'.$contTP.'">
										<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleTipoPersona(\''.$contTP.'\',\''.$reg->idPersonaTipoPersona.'\')">X</button>
										</td><td><input type="hidden" name="TipoPersona_idTipoPersona[]" id="TipoPersona_idTipoPersonao[]" value="'.$reg->TipoPersona_idTipoPersona.'">'.$reg->tpdd.'</td>
										</td><td><input type="text" onclick="cambiarTerminoPago(this)" name="terminoPago[]" id="terminoPago'.$contTP.'" value="'.$reg->terminoPago.'">'.$reg->tpd.'</td>
										</td><td><input type="hidden" name="GrupoPersona_idGrupoPersona[]" id="GrupoPersona_idGrupoPersona[]" value="'.$reg->GrupoPersona_idGrupoPersona.'">'.$reg->gpd.'</td>
										</td><td><input type="text" name="cuentaAPagar[]" id="cuentaAPagar[]" value="'.$reg->cp.'"></td>
										</td><td><input type="text" name="cuentaAnticipo[]" id="cuentaAnticipo[]" value="'.$reg->ca.'"></td>
										</td><td><input type="text" name="comision[]" id="comision[]" value="'.$reg->comision.'"></td>
										</td><td><input type="text" name="salario[]" id="salario[]" value="'.$reg->salario.'"></td>
										</td><td><input type="hidden" data-dbexistente-tp="1" name="idPersonaTipoPersona[]" id="idPersonaTipoPersona[]" value="'.$reg->idPersonaTipoPersona.'"></td>';


									$contTP++;
									
								}
						echo '<tfoot>
													<th>Opciones</th>
				                              		<th>Tipo Persona</th>
				                                    <th>Termino de Pago Habilitado</th>
				                                    <th>Grupo</th>
				                                    <th>Cuenta a Pagar</th>
				                                    <th>Cuenta anticipo</th>
				                                    <th>Comision</th>
				                                    <th>Salario</th>
				                                </tfoot>';

	break;




	case 'listarDetalleDireccion':
		//Recibimos el idingreso
		$idPersona=$_GET['idPersona'];

				$rspta = $persona->listarDetalleDireccion($idPersona);
						echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Tipo de Direccion</th>
                                    <th>Ciudad</th>
                                    <th>Barrio</th>
                                    <th>Calle Principal</th>
                                    <th>Calle Transversal</th>
                                    <th>Nro. de casa</th>
                                    <th>Latitud</th>
                                    <th>Longitud</th>
				                                </thead>';
				        $contD = 0;
						while ($reg = $rspta->fetchObject())
								{
									echo '<tr class="filasD" id="filaD'.$contD.'">
<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleDireccion(\''.$contD.'\',\''.$reg->idDireccion.'\')">X</button>
</td><td><input type="hidden" name="TipoDireccion_Telefono_idTipoDireccion_Telefono[]" id="TipoDireccion_Telefono_idTipoDireccion_Telefono[]" value="'.$reg->TipoDireccion_Telefono_idTipoDireccion_Telefono.'">'.$reg->dt.'</td>
</td><td><input type="hidden" name="Ciudad_idCiudad[]" id="Ciudad_idCiudad[]" value="'.$reg->Ciudad_idCiudad.'">'.$reg->dc.'</td>
</td><td><input type="hidden" name="Barrio_idBarrio[]" id="Barrio_idBarrio[]" value="'.$reg->Barrio_idBarrio.'">'.$reg->db.'</td>
</td><td><input type="text" name="callePrincipal[]" id="callePrincipal[]" value="'.$reg->callePrincipal.'"></td>
</td><td><input type="text" name="calleTransversal[]" id="calleTransversal[]" value="'.$reg->calleTransversal.'"></td>
</td><td><input type="text" name="nroCasa[]" id="nroCasa[]" value="'.$reg->nroCasa.'"></td>
</td><td><input type="text" name="latitud[]" id="latitud[]" value="'.$reg->latitud.'"></td>
</td><td><input type="text" name="longitud[]" id="longitud[]" value="'.$reg->longitud.'"></td>
</td><td><input type="hidden" name="idDireccion[]" id="idDireccion[]" value="'.$reg->idDireccion.'"></td>';
$contD++;															}
					echo 	'<tfoot>
                                    <th>Opciones</th>
                                    <th>Tipo de Direccion</th>
                                    <th>Ciudad</th>
                                    <th>Barrio</th>
                                    <th>Calle Principal</th>
                                    <th>Calle Transversal</th>
                                    <th>Nro. de casa</th>
                                    <th>Latitud</th>
                                    <th>Longitud</th>
				             </tfoot>';

	break;



	case 'listarDetalleTelefono':
		//Recibimos el idingreso
		$idPersona=$_GET['idPersona'];

				$rspta = $persona->listarDetalleTelefono($idPersona);
						echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Tipo de Telefono</th>
                                    <th>Nro</th>
				                </thead>';
				        $contT = 0;
						while ($reg = $rspta->fetchObject())
								{
									echo '<tr class="filasT" id="filaT'.$contT.'">
									<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleTelefono(\''.$contT.'\',\''.$reg->idTelefono.'\')">X</button>
									</td><td><input type="hidden" name="TipoDireccion_Telefono_idTipoDireccion_Telefono_tel[]"  value="'.$reg->TipoDireccion_Telefono_idTipoDireccion_Telefono.'">'.$reg->dt.'</td>
									</td><td><input type="text" name="telefono[]"  value="'.$reg->telefono.'"></td>
									</td><td><input type="hidden" data-dbexistente="1" name="idTelefono[]"  value="'.$reg->idTelefono.'"></td>';
									$contT++;															}
					echo 	'<tfoot>
                                    <th>Opciones</th>
                                    <th>Tipo de Telefono</th>
                                    <th>Telefono</th>
                                </tfoot>';

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
		//Recibimos el idingreso
		$idPersona=$_GET['idPersona'];

				$rspta = $persona->listarDetallePersonaContacto($idPersona);
						echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Nombre y Apellido</th>
                                    <th>Cargo</th>
                                    <th>Email</th>
                                    <th>Telefono</th>
				                </thead>';
				        $contT = 0;
						while ($reg = $rspta->fetchObject())
								{
									echo '<tr class="filasContacto" id="filaContacto'.$contT.'">
									<td><button type="button" class="btn btn-danger" onclick="eliminarDetallePersonaContacto(\''.$contT.'\',\''.$reg->idPersonaContacto.'\')">X</button>
									</td><td><input type="text" name="nya[]"  value="'.$reg->nya.'"></td>
									</td><td><input type="hidden" name="Cargo_idCargo[]"  value="'.$reg->Cargo_idCargo.'">'.$reg->nc.'</td>
									</td><td><input type="text" name="email_2[]"  value="'.$reg->email.'"></td>
									</td><td><input type="text" name="telefono_2[]"  value="'.$reg->telefono.'"></td>
									</td><td><input type="hidden" data-dbexistente="1" name="idPersonaContacto[]"  value="'.$reg->idPersonaContacto.'"></td>';
									$contT++;															}
					echo 	'<tfoot>
                                    <th>Opciones</th>
                                    <th>Nombre y Apellido</th>
                                    <th>Cargo</th>
                                    <th>Email</th>
                                    <th>Telefono</th>
                                </tfoot>';

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

			if(!empty($_POST["keyword"])) {
			
			
			$query ="SELECT * from ciudad2
							WHERE
							  (descripcion like '%".$_POST["keyword"]."%' )
							LIMIT 0,1000";
			$result = $conexion->query($query); 
			
			
			if(!empty($result)) {
			$dataArray = Array();
			foreach($result as $p) { ?>
			<option onclick="listarArticulos()" d-razonSocial="<?php echo $p["descripcion"]?>" d-nombreComercial="<?php echo $p["descripcion"]?>"  d-idPersona="<?php echo $p["code"]?>" value="<?php echo $p["code"]; ?>">
				<?php echo $p["descripcion"]; ?>
				<?php echo $p["code"]; ?>
			</option>
			
			<?php 
			}// foreach
			
			}//if
			}//keyword
			
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


	case 'verificarRuc':
		$rspta=$persona->verificarRuc($_POST['codigo']);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;



	case 'listarVehiculos':
		$rspta = $persona->listarVehiculos();
		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idVehiculo. '>' .$reg->descripcion. '</option>';
		}
	break;
	

	case 'asignarVehiculo':
		$idDireccion = $_POST["idDireccion"];
		$vehiculo = $_POST["vehiculo"];
	
		// Realiza el UPDATE en la BD
		$sql = "UPDATE direccion
				SET Vehiculo_idVehiculo = :vehiculo
				WHERE idDireccion = :idDireccion";
		
		$stmt = $conexion->prepare($sql);
		$stmt->bindParam(':vehiculo', $vehiculo);
		$stmt->bindParam(':idDireccion', $idDireccion, PDO::PARAM_INT);
	
		if($stmt->execute()){
			echo "OK";
		} else {
			echo "Error al actualizar vehículo";
		}
	break;
	

}
?>