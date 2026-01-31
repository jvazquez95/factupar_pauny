<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class TipoDocumento
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($descripcion,$CuentaContable_idCuentaContable,$Proceso_idProceso)  
	{
		session_start();
		$usuario = $_SESSION['login']; 	
		$sql="INSERT INTO `tipodocumento`(`descripcion`, `CuentaContable_idCuentaContable`, `Proceso_idProceso`, `usuarioInsercion`, `inactivo`, `fechaInsercion`) VALUES ('$descripcion','$CuentaContable_idCuentaContable','$Proceso_idProceso','$usuario',0, now())";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idTipoDocumento, $descripcion,$CuentaContable_idCuentaContable,$Proceso_idProceso)  
	{
		$sql="UPDATE `tipodocumento` SET `descripcion`='$descripcion', `CuentaContable_idCuentaContable`='$CuentaContable_idCuentaContable', `Proceso_idProceso`='$Proceso_idProceso',`fechaModificacion`= now() WHERE `idTipoDocumento`='$idTipoDocumento'";
		return ejecutarConsulta($sql); 
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idTipoDocumento)
	{
		$sql="UPDATE tipodocumento SET inactivo=1 WHERE idTipoDocumento='$idTipoDocumento'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idTipoDocumento)
	{
		$sql="UPDATE tipodocumento SET inactivo=0 WHERE idTipoDocumento='$idTipoDocumento'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idTipoDocumento)
	{
		$sql="SELECT * FROM tipodocumento WHERE idTipoDocumento='$idTipoDocumento'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT tipodocumento.idTipoDocumento,tipodocumento.descripcion,cuentacontable.descripcion as descripcionCuenta, proceso.ano,
				tipodocumento.inactivo
			FROM tipodocumento,cuentacontable,proceso
			where tipodocumento.Cuentacontable_idCuentaContable = cuentacontable.idCuentaContable and tipodocumento.Proceso_idProceso=proceso.idProceso"; 
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM tipodocumento where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>