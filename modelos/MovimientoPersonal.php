<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class MovimientoPersonal
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($Legajo_idLegajo,$TipoMovimiento_idTipoMovimiento,$fechaTransaccion,$fechaInicio,$fechaFin,$nroComprobante,$esIngreso,$esSalida,$esCambioDato)
	{
		session_start();	
		$usuario = $_SESSION['login'];
		$sql="
			INSERT INTO `movimientoPersonal`
			(
			`Legajo_idLegajo`,
			`TipoMovimiento_idTipoMovimiento`,
			`fechaTransaccion`,
			`fechaInicio`,
			`fechaFin`,
			`nroComprobante`,
			`esIngreso`,
			`esSalida`,
			`esCambioDato`,
			`usuarioInsercion`,
			`fechaInsercion`,
			`inactivo`)
			VALUES
			(
			'$Legajo_idLegajo',
			'$TipoMovimiento_idTipoMovimiento',
			now(),
			'$fechaInicio',
			'$fechaFin',
			'$nroComprobante',
			'$esIngreso',
			'$esSalida',
			'$esCambioDato',
			'$usuario',
			now(),
			0)
		";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idMovimientoPersonal,$Legajo_idLegajo,$TipoMovimiento_idTipoMovimiento,$fechaTransaccion,$fechaInicio,$fechaFin,$nroComprobante,$esIngreso,$esSalida,$esCambioDato)
	{
		session_start();	
		$usuario = $_SESSION['login'];
		$sql="
			UPDATE `movimientoPersonal`
			SET
			`Legajo_idLegajo` = '$Legajo_idLegajo',
			`TipoMovimiento_idTipoMovimiento` = '$TipoMovimiento_idTipoMovimiento',
			`fechaTransaccion` = '$fechaTransaccion',
			`fechaInicio` = '$fechaInicio',
			`fechaFin` = '$fechaFin',
			`nroComprobante` = '$nroComprobante',
			`esIngreso` = '$esIngreso',
			`esSalida` = '$esSalida',
			`esCambioDato` = '$esCambioDato',
			`usuarioModificacion` = '$usuario',
			`fechaModificacion` = now()
			WHERE `idMovimientoPersonal` = '$idMovimientoPersonal'

		";

		return ejecutarConsulta($sql);
	}
 
	//Implementamos un método para desactivar categorías
	public function desactivar($idMovimientoPersonal)
	{
		$sql="UPDATE movimientoPersonal SET inactivo=1 WHERE idMovimientoPersonal='$idMovimientoPersonal'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idMovimientoPersonal)
	{
		$sql="UPDATE movimientoPersonal SET inactivo=0 WHERE idMovimientoPersonal='$idMovimientoPersonal'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idMovimientoPersonal)
	{
		$sql="SELECT * FROM movimientoPersonal WHERE idMovimientoPersonal='$idMovimientoPersonal'";
		return ejecutarConsultaSimpleFila($sql); 
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT *, F_NOMBRE_PERSONA(Legajo_idLegajo) as nombreLegajo, F_NOMBRE_TIPOMOVIMIENTO( TipoMovimiento_idTipoMovimiento ) as nombreTipoMovimiento
		      FROM movimientoPersonal";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function selectMovimientoPersonal()
	{
		$sql="SELECT * FROM movimientoPersonal where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>