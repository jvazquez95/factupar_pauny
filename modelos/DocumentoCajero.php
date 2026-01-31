<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class DocumentoCajero
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($Documento_idTipoDocumento,$Usuario_idUsuario,$numeroInicial,$numeroFinal,$numeroActual,$fechaEntrega,$serie,$timbrado, $nroAutorizacion)
	{
		$sql="INSERT INTO `documentocajero` (
							`Documento_idTipoDocumento`,
							`Usuario_idUsuario`,
							`numeroInicial`,
							`numeroFinal`,
							`numeroActual`,
							`fechaEntrega`,
							`serie`,
							`nroAutorizacion`,
							`timbrado`,
							`inactivo`)
							VALUES
							(
							'$Documento_idTipoDocumento',
							'$Usuario_idUsuario',
							'$numeroInicial',
							'$numeroFinal',
							'$numeroActual',
							'$fechaEntrega',
							'$serie',
							'$nroAutorizacion',
							'$timbrado',
							0)";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idDocumentoCajero,$Documento_idTipoDocumento,$Usuario_idUsuario,$numeroInicial,$numeroFinal,$numeroActual,$fechaEntrega,$serie,$timbrado, $nroAutorizacion)
	{
		$sql="UPDATE `documentocajero`
							SET
							`Documento_idTipoDocumento` = '$Documento_idTipoDocumento',
							`Usuario_idUsuario` = '$Usuario_idUsuario',
							`numeroInicial` = '$numeroInicial',
							`numeroFinal` = '$numeroFinal',
							`numeroActual` = '$numeroActual',
							`fechaEntrega` = '$fechaEntrega',
							`serie` = '$serie',
							`nroAutorizacion` = '$nroAutorizacion',
							`timbrado` = '$timbrado'
							WHERE `idDocumentoCajero` = '$idDocumentoCajero'
";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idDocumentoCajero)
	{
		$sql="UPDATE documentocajero SET inactivo=1 WHERE idDocumentoCajero='$idDocumentoCajero'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idDocumentoCajero)
	{
		$sql="UPDATE documentocajero SET inactivo=0 WHERE idDocumentoCajero='$idDocumentoCajero'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idDocumentoCajero)
	{
		$sql="SELECT * FROM documentocajero WHERE idDocumentoCajero='$idDocumentoCajero'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT *, u.nombre as nu, t.descripcion as td, d.inactivo as i FROM documentocajero as d, usuario as u, tipodocumento as t where d.Documento_idTipoDocumento = t.idTipoDocumento and d.Usuario_idUsuario = u.idUsuario";

		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM documentoCajero where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>