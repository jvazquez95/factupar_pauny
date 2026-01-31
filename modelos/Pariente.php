<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Pariente
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($apellido,$nombre,$nacimiento,$sexo,$parentezco,$observaciones,$EstadoCivil_idEstadoCivil,$dependiente,$Profesion_idProfesion,$Actividad_idActividad,$Pais_idPais, $Legajo_idLegajo)
	{
		session_start();	
		$usuario = $_SESSION['login'];
		$sql="
				INSERT INTO `pariente`
				(
				`apellido`,
				`nombre`,
				`nacimiento`,
				`sexo`,
				`parentezco`,
				`observaciones`,
				`EstadoCivil_idEstadoCivil`,
				`dependiente`,
				`Profesion_idProfesion`,
				`Actividad_idActividad`,
				`Pais_idPais`,
				`inactivo`,
				`Legajo_idLegajo`)
				VALUES
				(
				'$apellido',
				'$nombre',
				'$nacimiento',
				'$sexo',
				'$parentezco',
				'$observaciones',
				'$EstadoCivil_idEstadoCivil',
				'$dependiente',
				'$Profesion_idProfesion',
				'$Actividad_idActividad',
				'$Pais_idPais',
				'0',
				'$Legajo_idLegajo');
				";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idPariente, $apellido,$nombre,$nacimiento,$sexo,$parentezco,$observaciones,$EstadoCivil_idEstadoCivil,$dependiente,$Profesion_idProfesion,$Actividad_idActividad,$Pais_idPais, $Legajo_idLegajo)
	{
		session_start();	
		$usuario = $_SESSION['login'];
		$sql="
UPDATE `pariente`
SET
`apellido` = '$apellido',
`nombre` = '$nombre',
`nacimiento` = '$nacimiento',
`sexo` = '$sexo',
`parentezco` = '$parentezco',
`observaciones` = '$observaciones',
`EstadoCivil_idEstadoCivil` = '$EstadoCivil_idEstadoCivil',
`dependiente` = '$dependiente',
`Profesion_idProfesion` = '$Profesion_idProfesion',
`Actividad_idActividad` = '$Actividad_idActividad',
`Pais_idPais` = '$Pais_idPais',
`inactivo` = '$inactivo',
`Legajo_idLegajo` = '$Legajo_idLegajo'
WHERE `idPariente` = '$idPariente'
		";

		return ejecutarConsulta($sql);
	}
 
	//Implementamos un método para desactivar categorías
	public function desactivar($idPariente)
	{
		$sql="UPDATE pariente SET inactivo=1 WHERE idPariente='$idPariente'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idPariente)
	{
		$sql="UPDATE pariente SET inactivo=0 WHERE idPariente='$idPariente'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idPariente)
	{
		$sql="SELECT * FROM pariente WHERE idPariente='$idPariente'";
		return ejecutarConsultaSimpleFila($sql); 
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT *, F_NOMBRE_PERSONA(Legajo_idLegajo) as nombreLegajo, 
F_NOMBRE_ECIVIL( EstadoCivil_idEstadoCivil ) as nombreEC, 
F_NOMBRE_PROFESION( Profesion_idProfesion ) AS nombreProfesion,
F_NOMBRE_PAIS( Pais_idPais ) as nombrePais
FROM pariente;
select * from pariente";
		return ejecutarConsulta($sql);		
	}


	//Implementar un método para listar los registros
	public function listar_x_legajo($Legajo_idLegajo)
	{
		$sql="SELECT *
		      FROM pariente where Legajo_idLegajo = '$Legajo_idLegajo'";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function selectPariente()
	{
		$sql="SELECT * FROM pariente where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>