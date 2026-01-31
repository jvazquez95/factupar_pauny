<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Liquidacion
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($periodo,$fechaInicioPeriodo,$fechaFinPeriodo,$fechaApertura,$TipoLiquidacion_idTipoLiquidacion,$Moneda_idMoneda)
	{
		session_start();	
		$usuario = $_SESSION['login'];
		$sql="
			
			INSERT INTO `liquidacion`
			(
			`periodo`,
			`fechaInicioPeriodo`,
			`fechaFinPeriodo`,
			`fechaApertura`,
			`TipoLiquidacion_idTipoLiquidacion`,
			`Moneda_idMoneda`,
			`total`,
			`usuarioInsercion`,
			`fechaInsercion`,
			`inactivo`)
			VALUES
			(
			'$periodo',
			'$fechaInicioPeriodo',
			'$fechaFinPeriodo',
			'$fechaApertura',
			'$TipoLiquidacion_idTipoLiquidacion',
			'$Moneda_idMoneda',
			'0',
			'$usuario',
			now(),
			'0'
			)
			";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idLiquidacion,$periodo,$fechaInicioPeriodo,$fechaFinPeriodo,$fechaApertura,$TipoLiquidacion_idTipoLiquidacion,$Moneda_idMoneda)
	{
		session_start();	
		$usuario = $_SESSION['login'];
		$sql="
		UPDATE `liquidacion`
			SET
			`periodo` = '$periodo',
			`fechaInicioPeriodo` = '$fechaInicioPeriodo',
			`fechaFinPeriodo` = '$fechaFinPeriodo',
			`fechaApertura` = '$fechaApertura',
			`TipoLiquidacion_idTipoLiquidacion` = '$TipoLiquidacion_idTipoLiquidacion',
			`Moneda_idMoneda` = '$Moneda_idMoneda',
			`usuarioModificacion` = '$usuario',
			`fechaModificacion` = now()
			WHERE `idLiquidacion` = '$idLiquidacion'
		";

		return ejecutarConsulta($sql);
	}
 
	//Implementamos un método para desactivar categorías
	public function desactivar($idLiquidacion)
	{
		$sql="UPDATE liquidacion SET inactivo=1 WHERE idLiquidacion='$idLiquidacion'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idLiquidacion)
	{
		$sql="UPDATE liquidacion SET inactivo=0 WHERE idLiquidacion='$idLiquidacion'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idLiquidacion)
	{
		$sql="SELECT * FROM liquidacion WHERE idLiquidacion='$idLiquidacion'";
		return ejecutarConsultaSimpleFila($sql); 
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function liquidacionCabecera($idLiquidacion)
	{
		$sql="SELECT *,persona.razonSocial as nombreCliente, persona.nroDocumento as ruc, persona.direccion as cd,  '80028600-6' as fe, entrega from venta, persona WHERE  persona.idPersona = venta.Cliente_idCliente and idVenta  = '$idLiquidacion'";
		return ejecutarConsultaSimpleFila($sql); 
	}


	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT *, F_NOMBRE_TIPOLIQUIDACION( TipoLiquidacion_idTipoLiquidacion ) as nombreTipoLiquidacion, F_NOMBRE_MONEDA( Moneda_idMoneda ) as nombreMoneda FROM liquidacion where inactivo = 0";
		return ejecutarConsulta($sql);		
	}



	//Implementar un método para listar los registros
	public function listarCierre()
	{
		$sql="SELECT *, F_NOMBRE_TIPOLIQUIDACION( TipoLiquidacion_idTipoLiquidacion ) as nombreTipoLiquidacion, F_NOMBRE_MONEDA( Moneda_idMoneda ) as nombreMoneda FROM liquidacion where cerrado=0";
		return ejecutarConsulta($sql);		
	}


	public function autorizarCierre($id)
	{
		$usuario = $_SESSION['login'];

		$sql="UPDATE liquidacion SET cerrado=1, aprobadoPor='$usuario', fechaAprobacion = now() WHERE idLiquidacion='$id'";

		return ejecutarConsulta($sql);
	}



	public function mostrarDetalle($idLiquidacion)
	{
		$sql="CALL SP_GenerarDetalleLiquidacion('$idLiquidacion')";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function selectLiquidacion()
	{
		$sql="SELECT *, F_NOMBRE_TIPOLIQUIDACION( TipoLiquidacion_idTipoLiquidacion ) as nombreTipoLiquidacion, F_NOMBRE_MONEDA( Moneda_idMoneda ) as nombreMoneda FROM liquidacion where inactivo=0";
		return ejecutarConsulta($sql);		
	}


	public function rpt_salarios_detallado($id)
	{
		$sql="CALL SP_SalariosDetallado(1,202106)";
		return ejecutarConsulta($sql);		
	}

	public function rpt_salarios_resumido($id)
	{
		$sql="CALL SP_ResumenSalarios(1,202106)";
		return ejecutarConsulta($sql);		
	}

	public function rpt_legajo_liquidacion($id)
	{
		$sql="SELECT Liquidacion_IdLiquidacion, Legajo_idLegajo ,F_NOMBRE_PERSONA(Legajo_idLegajo) as nombreLegajo, liquidacion.fechaInicioPeriodo, 
			F_NOMBRE_MONEDA(Moneda_idMoneda) AS nombreMoneda, fechaFinPeriodo, periodo, 'ver' as diasTrabajado   from liquidaciondetalle, liquidacion where Liquidacion_IdLiquidacion = '$id' group by Legajo_idLegajo;";
		return ejecutarConsulta($sql);		
	}

	public function rpt_legajo_liquidacion_detalle($idLegajo, $idLiquidacion)
	{
		$sql="SELECT *, F_NOMBRE_TIPOSALARIO( TipoSalario_idTipoSalario) as nombreTipoSalario, F_CONCEPTOSALARIO_TIPO( ConceptoSalario_idConceptoSalario ) as tipo,
			F_NOMBRE_CONCEPTOSALARIO( ConceptoSalario_idConceptoSalario ) AS nombreConceptoSalario, 'ver' as dias, 'ver' as horas
			from liquidaciondetalle where Legajo_idLegajo = '$idLegajo' and Liquidacion_IdLiquidacion = '$idLiquidacion'";
		return ejecutarConsulta($sql);		
	}


	



}

?>