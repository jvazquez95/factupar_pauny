<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Salario
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($Legajo_idLegajo,$TipoSalario_idTipoSalario,$fechaInicio,$fechaFin,$monto,$Moneda_idMoneda,$autorizado,$autorizadoPorUsuario)
	{
		session_start();	
		$usuario = $_SESSION['login'];
		$sql="
			INSERT INTO `salario`
						(
						`Legajo_idLegajo`,
						`TipoSalario_idTipoSalario`,
						`fechaInicio`,
						`fechaFin`,
						`monto`,
						`Moneda_idMoneda`,
						`usuarioInsercion`,
						`fechaInsercion`,
						`inactivo`,
						`autorizado`,
						`autorizadoPorUsuario`)
						VALUES
						(
						'$Legajo_idLegajo',
						'$TipoSalario_idTipoSalario',
						'$fechaInicio',
						'$fechaFin',
						'$monto',
						'$Moneda_idMoneda',
						'$usuario',
						now(),
						'0',
						'$autorizado',
						'$autorizadoPorUsuario');

		";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idSalario,$Legajo_idLegajo,$TipoSalario_idTipoSalario,$fechaInicio,$fechaFin,$monto,$Moneda_idMoneda,$autorizado,$autorizadoPorUsuario)
	{
		session_start();	
		$usuario = $_SESSION['login'];
		$sql="
			UPDATE `salario`
			SET
			`Legajo_idLegajo` = '$Legajo_idLegajo',
			`TipoSalario_idTipoSalario` = '$TipoSalario_idTipoSalario',
			`fechaInicio` = '$fechaInicio',
			`fechaFin` = '$fechaFin',
			`monto` = '$monto',
			`Moneda_idMoneda` = '$Moneda_idMoneda',
			`usuarioModificacion` = '$usuario',
			`fechaModificacion` =now() ,
			`autorizado` = '$autorizado',
			`autorizadoPorUsuario` = '$autorizadoPorUsuario'
			WHERE `idSalario` = '$idSalario'

		";

		return ejecutarConsulta($sql);
	}
 
	//Implementamos un método para desactivar categorías
	public function desactivar($idSalario)
	{
		$sql="UPDATE salario SET inactivo=1 WHERE idSalario='$idSalario'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idSalario)
	{
		$sql="UPDATE salario SET inactivo=0 WHERE idSalario='$idSalario'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idSalario)
	{
		$sql="SELECT * FROM salario WHERE idSalario='$idSalario'";
		return ejecutarConsultaSimpleFila($sql); 
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT *, F_NOMBRE_PERSONA(Legajo_idLegajo) as nombreLegajo, F_NOMBRE_TIPOSALARIO(TipoSalario_idTipoSalario) as nombreSalario, F_NOMBRE_MONEDA( Moneda_idMoneda ) AS nombreMoneda
		      FROM salario";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function selectSalario()
	{
		$sql="SELECT * FROM salario where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>