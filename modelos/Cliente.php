<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Cliente
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($razonSocial,$nombreComercial,$tipoDocumento,$nroDocumento,$direccion,$telefono,$celular,$mail,$moneda,$sitioWeb,$idCategoriaCliente,$terminoPago,$terminoPagoHabilitado,$nacimiento)
	{
		$sql="INSERT INTO 
		`cliente`(`razonSocial`, `nombreComercial`, `tipoDocumento`, `nroDocumento`, `direccion`, `telefono`, `celular`, `mail`, `moneda`, `sitioWeb`, `idCategoriaCliente`, `terminoPago`, `terminoPagoHabilitado`,`nacimiento`) 
		VALUES (UPPER('$razonSocial'),UPPER('$nombreComercial'),'$tipoDocumento','$nroDocumento',UPPER('$direccion'),'$telefono','$celular','$mail','$moneda','$sitioWeb','$idCategoriaCliente','$terminoPago','$terminoPagoHabilitado','$nacimiento')";


		return ejecutarConsulta($sql);
	}

	//Implementamos un método para insertar registros
	public function insertarr($razonSocial,$tipoDocumento,$nroDocumento,$celular,$nacimiento)
	{
		$sql="INSERT INTO 
		`cliente`(`razonSocial`, `nombreComercial`, `tipoDocumento`, `nroDocumento`,`celular`,`nacimiento`) 
		VALUES (UPPER('$razonSocial'),UPPER('$razonSocial'),'$tipoDocumento','$nroDocumento','$celular','$nacimiento')";


		return ejecutarConsulta_retornarID($sql);
	}
	//Implementamos un método para editar registros
	public function editar($idCliente,$razonSocial,$nombreComercial,$tipoDocumento,$nroDocumento,$direccion,$telefono,$celular,$mail,$moneda,$sitioWeb,$idCategoriaCliente,$terminoPago,$terminoPagoHabilitado,$nacimiento)
	{ 
		$sql="UPDATE `cliente` SET `razonSocial`=UPPER('$razonSocial'),`nombreComercial`=UPPER('$nombreComercial'),`tipoDocumento`='$tipoDocumento',`nroDocumento`='$nroDocumento',`direccion`=UPPER('$direccion'),`telefono`='$telefono',`celular`='$celular',`mail`='$mail',`moneda`='$moneda',`sitioWeb`='$sitioWeb',`idCategoriaCliente`='$idCategoriaCliente',`terminoPago`='$terminoPago',`terminoPagoHabilitado`='$terminoPagoHabilitado',`nacimiento`='$nacimiento' WHERE idCliente = '$idCliente'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($idCliente)
	{
		$sql="UPDATE cliente SET inactivo='1' WHERE idCliente='$idCliente'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($idCliente)
	{
		$sql="UPDATE cliente SET inactivo='0' WHERE idCliente='$idCliente'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idCliente)
	{
		$sql="SELECT * FROM cliente WHERE idCliente='$idCliente'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM cliente";
		return ejecutarConsulta($sql);		
	}

	public function listarVehiculos()
	{
		$sql="SELECT idVehiculo, nombreReferencia as descripcion FROM vehiculo";
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
		$sql="SELECT * FROM cliente WHERE inactivo=0";
		return ejecutarConsulta($sql);		
	}

}

?>