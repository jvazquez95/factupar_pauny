<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class MovimientoSalarial
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($Legajo_idLegajo,$ConceptoSalario_idConceptoSalario,$TipoSalario_idTipoSalario,$descripcion,$monto,$fechaMovimientoSalarial)
	{
		session_start();	
		$usuario = $_SESSION['login'];
		$sql="
			INSERT INTO `movimientosalarial`
			(
			`Legajo_idLegajo`,
			`ConceptoSalario_idConceptoSalario`,
			`TipoSalario_idTipoSalario`,
			`descripcion`,
			`monto`,
			`fechaInsercion`,
			`usuarioInsercion`,
			`inactivo`,
			`fechaMovimientoSalarial`
			)
			VALUES
			(
			'$Legajo_idLegajo',
			'$ConceptoSalario_idConceptoSalario',
			'$TipoSalario_idTipoSalario',
			'$descripcion',
			'$monto',
			now(),
			'$usuario',
			'0',
			'$fechaMovimientoSalarial');

		";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idMovimientoSalarial,$Legajo_idLegajo,$ConceptoSalario_idConceptoSalario,$TipoSalario_idTipoSalario,$descripcion,$monto,$fechaMovimientoSalarial)
	{
		session_start();	
		$usuario = $_SESSION['login'];
		$sql="
			UPDATE `movimientosalarial`
			SET
			`Legajo_idLegajo` = '$Legajo_idLegajo',
			`ConceptoSalario_idConceptoSalario` = '$ConceptoSalario_idConceptoSalario',
			`TipoSalario_idTipoSalario` = '$TipoSalario_idTipoSalario',
			`descripcion` = '$descripcion',
			`monto` = '$monto',
			`fechaModificacion` = '$fechaModificacion',
			`usuarioModificacion` = '$usuario'
			`fechaMovimientoSalarial` = '$fechaMovimientoSalarial'
			WHERE `idMovimientoSalarial` = '$idMovimientoSalarial';


		";

		return ejecutarConsulta($sql);
	}
 
	//Implementamos un método para desactivar categorías
	public function desactivar($idMovimientoSalarial)
	{
		$sql="UPDATE movimientosalarial SET inactivo=1 WHERE idMovimientoSalarial='$idMovimientoSalarial'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idMovimientoSalarial)
	{
		$sql="UPDATE movimientosalarial SET inactivo=0 WHERE idMovimientoSalarial='$idMovimientoSalarial'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idMovimientoSalarial)
	{
		$sql="SELECT * FROM movimientosalarial WHERE idMovimientoSalarial='$idMovimientoSalarial'";
		return ejecutarConsultaSimpleFila($sql); 
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT *, F_NOMBRE_CONCEPTOSALARIO( ConceptoSalario_idConceptoSalario ) as nombreConceptoSalario, F_NOMBRE_PERSONA( Legajo_idLegajo ) as nombreLegajo, F_NOMBRE_TIPOSALARIO( TipoSalario_idTipoSalario ) as nombreTipoSalario
		      FROM movimientosalarial";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function selectMovimientoSalarial()
	{
		$sql="SELECT * FROM movimientosalarial where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>