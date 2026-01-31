<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class ComunicacionPersonal
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($Legajo_idLegajo,$TipoComunicacion_idTipoComunicacion,$fechaComunicacion,$concepto,$imagen)
	{
		session_start();	
		$usuario = $_SESSION['login'];
		$sql="
			INSERT INTO `comunicacionPersonal`
				(
				`Legajo_idLegajo`,
				`TipoComunicacion_idTipoComunicacion`,
				`fechaComunicacion`,
				`fechaTransaccion`,
				`concepto`,
				`imagen`,
				`usuarioInsercion`,
				`fechaInsercion`,
				`inactivo`)
				VALUES
				(
				'$Legajo_idLegajo',
				'$TipoComunicacion_idTipoComunicacion',
				'$fechaComunicacion',
				now(),
				'$concepto',
				'$imagen',
				'$usuario',
				now(),
				'0')
		";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idComunicacionPersonal,$Legajo_idLegajo,$TipoComunicacion_idTipoComunicacion,$fechaComunicacion,$concepto,$imagen)
	{
		session_start();	
		$usuario = $_SESSION['login'];
		$sql="
			UPDATE `comunicacionPersonal`
				SET
				`Legajo_idLegajo` = '$Legajo_idLegajo' ,
				`TipoComunicacion_idTipoComunicacion` = '$TipoComunicacion_idTipoComunicacion' ,
				`fechaComunicacion` = '$fechaComunicacion' ,
				`fechaTransaccion` = now() ,
				`concepto` = '$concepto' ,
				`imagen` = '$imagen' ,
				`usuarioModificacion` = '$usuario' ,
				`fechaModificacion` = now() ,
				`inactivo` = 0
			WHERE `idComunicacionPersonal` = '$idComunicacionPersonal'

		";

		return ejecutarConsulta($sql);
	}
 
	//Implementamos un método para desactivar categorías
	public function desactivar($idComunicacionPersonal)
	{
		$sql="UPDATE comunicacionPersonal SET inactivo=1 WHERE idComunicacionPersonal='$idComunicacionPersonal'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idComunicacionPersonal)
	{
		$sql="UPDATE comunicacionPersonal SET inactivo=0 WHERE idComunicacionPersonal='$idComunicacionPersonal'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idComunicacionPersonal)
	{
		$sql="SELECT * FROM comunicacionPersonal WHERE idComunicacionPersonal='$idComunicacionPersonal'";
		return ejecutarConsultaSimpleFila($sql); 
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT *, F_NOMBRE_PERSONA(Legajo_idLegajo) as nombreLegajo, F_NOMBRE_TIPOCOMUNICACION( TipoComunicacion_idTipoComunicacion ) as nombreTipoComunicacion
		      FROM comunicacionPersonal";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function selectcomunicacionPersonal()
	{
		$sql="SELECT * FROM comunicacionPersonal where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>