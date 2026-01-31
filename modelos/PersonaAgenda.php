<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class PersonaAgenda
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($Persona_idPersona, $fechaVisita, $cantidad,$latitud,$longitud, $Direccion_idDireccion, $Sucursal_idSucursal, $Deposito_idDeposito, $Vehiculo_idVehiculo,$Dia_idDia)
	{

		session_start();
		$usuario = $_SESSION['login'];
		$sql="INSERT INTO `personaAgenda`
								(
								`Persona_idPersona`,
								`Direccion_idDireccion`,
								`Sucursal_idSucursal`,
								`Deposito_idDeposito`,
								`Vehiculo_idVehiculo`,
								`fechaVisita`,
								`cantidad`,
								`latitud`,
								`longitud`,
								`usuarioIns`,
								`Dias_idDias`,
								`fechaIns`,
								`inactivo`)
								VALUES
								(
									'$Persona_idPersona',
									'$Direccion_idDireccion',
									'$Sucursal_idSucursal',
									'$Deposito_idDeposito',
									'$Vehiculo_idVehiculo',
									'$fechaVisita', 
									'$cantidad',
									'$latitud',
									'$longitud',
									'$usuario',
									'$Dia_idDia',
									now(),
									0
								)";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idPersonaAgenda,$Persona_idPersona, $fechaVisita, $cantidad)
	{
		session_start();
		$usuario = $_SESSION['login'];
		$sql="UPDATE `aguasan`.`personaAgenda`
				SET
				`Persona_idPersona` = '$Persona_idPersona',
				`fechaVisita` = '$fechaVisita',
				`cantidad` = '$cantidad',
				`usuarioMod` = '$usuario',
				`fechaMod` = now()	
				WHERE `idPersonaAgenda` = '$idPersonaAgenda'
";
		return ejecutarConsulta($sql);
	}


	//Implementamos un método para desactivar categorías
	public function desactivar($idPersonaAgenda)
	{
		$sql="UPDATE personaAgenda SET inactivo=1 WHERE idPersonaAgenda='$idPersonaAgenda'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idPersonaAgenda)
	{
		$sql="UPDATE personaAgenda SET inactivo=0 WHERE idPersonaAgenda='$idPersonaAgenda'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idPersonaAgenda)
	{
		$sql="SELECT * FROM personaAgenda WHERE idPersonaAgenda='$idPersonaAgenda'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT *, F_NOMBRE_PERSONA(Persona_idPersona) AS np from personaAgenda where visitado is null";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function selectTimbradoProveedor($id)
	{
		$sql="SELECT * FROM personaAgenda where inactivo=0 and Persona_idPersona = '$id'";
		return ejecutarConsulta($sql);		
	}

	public function aprobar($idPersonaAgenda)
	{ 
		session_start();
		$usuario = $_SESSION['login'];
		$sql="UPDATE personaAgenda set visitado = 'SI', usuarioMod='$usuario' WHERE idPersonaAgenda='$idPersonaAgenda' and visitado is null and inactivo=0";
		return ejecutarConsulta($sql);  
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function selectpersonaAgenda()
	{
		$sql="SELECT * FROM personaAgenda where inactivo=0";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function vencimientoTimbrado($idPersonaAgenda)
	{
		$sql="SELECT  vtoTimbrado from personaAgenda where idPersonaAgenda = '$idPersonaAgenda'";


		return ejecutarConsultaSimpleFila($sql);
	}




}

?> 