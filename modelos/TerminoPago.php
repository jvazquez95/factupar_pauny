<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class TerminoPago
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($descripcion, $tipo,$diasVencimiento,$cantidadCuotas,$diaPrimeraCuota,$porcentajeInteres)
	{
		$sql="INSERT INTO `terminopago`(`descripcion`, `tipo`, `inactivo`, diasVencimiento, cantidadCuotas, diaPrimeraCuota, porcentajeInteres) VALUES ('$descripcion', '$tipo', 0, '$diasVencimiento', '$cantidadCuotas' , '$diaPrimeraCuota', '$porcentajeInteres')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idTerminoPago,$descripcion,$tipo,$diasVencimiento,$cantidadCuotas,$diaPrimeraCuota,$porcentajeInteres)
	{
		$sql="UPDATE terminopago SET descripcion='$descripcion',tipo='$tipo', fechaModificacion = now(),diasVencimiento='$diasVencimiento', cantidadCuotas = '$cantidadCuotas', diaPrimeraCuota = '$diaPrimeraCuota', porcentajeInteres = '$porcentajeInteres'  WHERE idTerminoPago='$idTerminoPago'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idTerminoPago)
	{
		$sql="UPDATE terminopago SET inactivo=1 WHERE idTerminoPago='$idTerminoPago'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idTerminoPago)
	{
		$sql="UPDATE terminopago SET inactivo=0 WHERE idTerminoPago='$idTerminoPago'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idTerminoPago)
	{
		$sql="SELECT * FROM terminopago WHERE idTerminoPago='$idTerminoPago'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM terminopago";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function selectTerminoPago()
	{
		$sql="SELECT * FROM terminopago where inactivo=0";
		return ejecutarConsulta($sql);		
	}


	//Implementar un método para listar los registros y mostrar en el select
	public function selectTerminoPagoPersona($idPersona)
	{
		$sql="SELECT terminopago.* from terminopago where cantidadCuotas <= (select cantidadCuotas from persona_tipopersona, terminopago where persona_tipopersona.terminoPago = terminopago.idTerminoPago and Persona_idPersona = '$idPersona' and TipoPersona_idTipoPersona = 1 and terminopago.inactivo = 0 order by persona_tipopersona.idPersonaTipoPersona desc limit 1);
";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function contado($id)
	{
		$sql="    SELECT contado
		 FROM terminopago
		 WHERE idTerminoPago = '$id'";
		return ejecutarConsultaSimpleFila($sql);
	}

}

?>