<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Obligacion
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($NroObligacion,$Persona_idPersona,$Moneda_idMoneda,$TipoDocumento_idTipoDocumento,$nroDocumento,$fechaDocumento,$fechaVencimiento,$fechaPosiblePago,$fechadePago,$Pago_idPago,$importe,$saldo)
	{
		session_start();
		$usuario = $_SESSION['login'];
		$sql="INSERT INTO obligacion (NroObligacion,Persona_idPersona,Moneda_idMoneda,TipoDocumento_idTipoDocumento,nroDocumento,fechaDocumento,fechaVencimiento,fechaPosiblePago,fechadePago,Pago_idPago,importe,saldo,usuarioInsercion,inactivo,fechaInsercion) VALUES ('$NroObligacion','$Persona_idPersona','$Moneda_idMoneda','$TipoDocumento_idTipoDocumento','$nroDocumento','$fechaDocumento','$fechaVencimiento','$fechaPosiblePago','$fechadePago','$Pago_idPago','$importe','$saldo','$usuario',0,now())";
		return ejecutarConsulta($sql);        
	}

	//Implementamos un método para editar registros
	public function editar($idObligacion, $NroObligacion,$Persona_idPersona,$Moneda_idMoneda,$TipoDocumento_idTipoDocumento,$nroDocumento,$fechaDocumento,$fechaVencimiento,$fechaPosiblePago,$fechadePago,$Pago_idPago,$importe,$saldo) 
	{
		session_start();
		$usuario = $_SESSION['login']; 
		$sql="UPDATE `obligacion` SET NroObligacion='$NroObligacion', Persona_idPersona = '$Persona_idPersona' , Moneda_idMoneda= '$Moneda_idMoneda' , TipoDocumento_idTipoDocumento= '$TipoDocumento_idTipoDocumento', nroDocumento= '$nroDocumento', fechaDocumento= '$fechaDocumento', fechaVencimiento= '$fechaVencimiento', fechaPosiblePago= '$fechaPosiblePago', fechadePago= '$fechadePago', Pago_idPago= '$Pago_idPago', importe= '$importe', saldo= '$saldo',fechaModificacion= now(), usuarioModificacion = '$usuario' WHERE idObligacion='$idObligacion'";
		return ejecutarConsulta($sql);   
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idObligacion)
	{
		$sql="UPDATE obligacion SET inactivo=1 WHERE idObligacion='$idObligacion'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idObligacion)
	{
		$sql="UPDATE obligacion SET inactivo=0 WHERE idObligacion='$idObligacion'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar   
	public function mostrar($idObligacion)
	{
		$sql="SELECT * FROM obligacion WHERE idObligacion='$idObligacion'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT obligacion.idObligacion,obligacion.NroObligacion,persona.razonSocial,moneda.descripcion as moneda,tipodocumento.descripcion as tipodocumento,fechaVencimiento,obligacion.fechaPosiblePago,obligacion.fechadePago,obligacion.inactivo
			  FROM obligacion, moneda, persona,tipodocumento
			  where obligacion.Moneda_idMoneda = moneda.idMoneda and obligacion.Persona_idPersona = persona.idPersona and obligacion.TipoDocumento_idTipoDocumento=tipodocumento.idTipoDocumento";
		return ejecutarConsulta($sql);	 	 
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM obligacion where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>