<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class ConceptoSalario
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($TipoLiquidacion_idTipoLiquidacion,$porcentaje,$esSalario,$descripcion,$TipoSalario_idTipoSalario,$tipo)
	{
		session_start();	
		$usuario = $_SESSION['login'];
		$sql="
			INSERT INTO `conceptosalario`
			(
			`TipoLiquidacion_idTipoLiquidacion`,
			`porcentaje`,
			`esSalario`,
			`descripcion`,
			`fechaInsercion`,
			`usuarioInsercion`,
			`inactivo`,
			`TipoSalario_idTipoSalario`,
			`tipo`
			)
			VALUES
			(
			'$TipoLiquidacion_idTipoLiquidacion',
			'$porcentaje',
			'$esSalario',
			'$descripcion',
			'$usuarioInsercion',
			now(),
			'0',
			'$TipoSalario_idTipoSalario',
			'$tipo'
			)";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idConceptoSalario,$TipoLiquidacion_idTipoLiquidacion,$porcentaje,$esSalario,$descripcion,$TipoSalario_idTipoSalario,$tipo)
	{
		session_start();	
		$usuario = $_SESSION['login'];
		$sql="
		UPDATE `conceptosalario`
		SET
		`TipoLiquidacion_idTipoLiquidacion` = '$TipoLiquidacion_idTipoLiquidacion',
		`porcentaje` = '$porcentaje',
		`esSalario` = '$esSalario',
		`descripcion` = '$descripcion',
		`fechaModificacion` = now(),
		`usuarioModificacion` = '$usuario',
		`tipo` = '$tipo',
		`TipoSalario_idTipoSalario` = '$TipoSalario_idTipoSalario'
			WHERE `idConceptoSalario` = '$idConceptoSalario'

		";

		return ejecutarConsulta($sql);
	}
 
	//Implementamos un método para desactivar categorías
	public function desactivar($idConceptoSalario)
	{
		$sql="UPDATE conceptosalario SET inactivo=1 WHERE idConceptoSalario='$idConceptoSalario'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idConceptoSalario)
	{
		$sql="UPDATE conceptosalario SET inactivo=0 WHERE idConceptoSalario='$idConceptoSalario'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idConceptoSalario)
	{
		$sql="SELECT * FROM conceptosalario WHERE idConceptoSalario='$idConceptoSalario'";
		return ejecutarConsultaSimpleFila($sql); 
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT *, F_NOMBRE_TIPOLIQUIDACION( TipoLiquidacion_idTipoLiquidacion ) AS nombreTipoLiquidacion, F_NOMBRE_TIPOSALARIO( TipoSalario_idTipoSalario ) AS nombreTipoSalario
		      FROM conceptosalario";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function selectConceptoSalario()
	{
		$sql="SELECT * FROM conceptosalario where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>