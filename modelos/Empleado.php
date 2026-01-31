<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Empleado
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($razonSocial,$nombreComercial,$tipoDocumento,$nroDocumento,$nacimiento,$direccion,$telefono,$celular,$mail,$moneda,$sitioWeb,$idCategoriaCliente,$terminoPago,$terminoPagoHabilitado)
	{
		$sql="INSERT INTO 
		`empleado`(`razonSocial`, `nombreComercial`, `tipoDocumento`, `nroDocumento`,`nacimiento`, `direccion`, `telefono`, `celular`, `mail`, `moneda`, `sitioWeb`, `idCategoriaCliente`, `terminoPago`, `terminoPagoHabilitado`) 
		VALUES ('$razonSocial','$nombreComercial','$tipoDocumento','$nroDocumento','$nacimiento','$direccion','$telefono','$celular','$mail','$moneda','$sitioWeb','$idCategoriaCliente','$terminoPago','$terminoPagoHabilitado')";


		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idEmpleado,$razonSocial,$nombreComercial,$tipoDocumento,$nroDocumento,$nacimiento,$direccion,$telefono,$celular,$mail,$moneda,$sitioWeb,$idCategoriaCliente,$terminoPago,$terminoPagoHabilitado)
	{ 
		$sql="UPDATE `empleado` SET `razonSocial`='$razonSocial',`nombreComercial`='$nombreComercial',`tipoDocumento`='$tipoDocumento',`nroDocumento`='$nroDocumento',`nacimiento`='$nacimiento',`direccion`='$direccion',`telefono`='$telefono',`celular`='$celular',`mail`='$mail',`moneda`='$moneda',`sitioWeb`='$sitioWeb',`idCategoriaCliente`='$idCategoriaCliente',`terminoPago`='$terminoPago',`terminoPagoHabilitado`='$terminoPagoHabilitado' WHERE idEmpleado = '$idEmpleado'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($idEmpleado)
	{
		$sql="UPDATE empleado SET inactivo='1' WHERE idEmpleado='$idEmpleado'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($idEmpleado)
	{
		$sql="UPDATE empleado SET inactivo='0' WHERE idEmpleado='$idEmpleado'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idEmpleado)
	{
		$sql="SELECT * FROM empleado WHERE idEmpleado='$idEmpleado'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM empleado";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros
/*	public function listar_reporte()
	{
		$sql="SELECT *,articulo.nombre as na, categoria.nombre as nc FROM stock,articulo, categoria where articulo.Categoria_idCategoria = categoria.Categoria_idCategoria and stock.Articulo_idArticulo = articulo.idArticulo";
		return ejecutarConsulta($sql);		
	}*/

	//Implementar un método para listar los registros activos
	public function listarActivos()
	{
		$sql="SELECT * FROM empleado WHERE inactivo=0";
		return ejecutarConsulta($sql);		
	}

}

?>