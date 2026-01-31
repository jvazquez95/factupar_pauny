<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Proveedor
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($razonSocial,$nombreComercial,$tipoDocumento,$nroDocumento,$direccion,$telefono,$celular,$mail,$sitioWeb,$terminoPago,$moneda,$idCategoriaProveedor)
	{
		$sql="INSERT INTO `proveedor`(`razonSocial`, `nombreComercial`, `tipoDocumento`, `nroDocumento`, `direccion`, `telefono`, `celular`, `mail`, `sitioWeb`, `terminoPago`, `moneda`, `idCategoriaProveedor`) 

		VALUES ('$razonSocial','$nombreComercial','$tipoDocumento','$nroDocumento','$direccion','$telefono','$celular','$mail','$sitioWeb','$terminoPago','$moneda','$idCategoriaProveedor')";


		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idProveedor,$razonSocial,$nombreComercial,$tipoDocumento,$nroDocumento,$direccion,$telefono,$celular,$mail,$sitioWeb,$terminoPago,$moneda,$idCategoriaProveedor)
	{ 
		$sql="UPDATE `proveedor` SET `razonSocial`='$razonSocial',`nombreComercial`='$nombreComercial',`tipoDocumento`='$tipoDocumento',`nroDocumento`='$nroDocumento',`direccion`='$direccion',`telefono`='$telefono',`celular`='$celular',`mail`='$mail',`sitioWeb`='$sitioWeb',`terminoPago`='$terminoPago',`moneda`='$moneda',`idCategoriaProveedor`='$idCategoriaProveedor' WHERE idProveedor = '$idProveedor'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($idProveedor)
	{
		$sql="UPDATE proveedor SET inactivo='1' WHERE idProveedor='$idProveedor'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($idProveedor)
	{
		$sql="UPDATE proveedor SET inactivo='0' WHERE idProveedor='$idProveedor'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idProveedor)
	{
		$sql="SELECT * FROM proveedor WHERE idProveedor='$idProveedor'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM persona p JOIN persona_tipopersona pt on p.idPersona = pt.Persona_idPersona 
		where pt.TipoPersona_idTipoPersona = 2 group by p.idPersona";
		return ejecutarConsulta($sql);		
	}
	public function listarc()
	{
		$sql="SELECT *, p.inactivo as pi, p.tipoDocumento as td, p.usuarioModificacion as um, p.fechaModificacion as fm, p.usuarioInsercion as ui, p.fechaInsercion fi FROM persona p JOIN persona_tipopersona pt on p.idPersona = pt.Persona_idPersona 
		where pt.TipoPersona_idTipoPersona = 1 group by p.idPersona";
		return ejecutarConsulta($sql);	
	}


	public function listarpersonadireccion()
	{
		$sql="SELECT
				d.imagen,
				p.idPersona,
				p.razonSocial,
				p.nombreComercial,
				p.tipoDocumento,
				p.nroDocumento,
				p.telefono,
				p.mail,
				c.descripcion AS ciudad,
				d.direccion,
				d.latitud,
				d.longitud,
				p.inactivo AS pi,
				d.usuarioInsercion AS ui,
				d.fechaInsercion AS fi,
				da.diaSemana,
				v.nombreReferencia AS vehiculo
				FROM persona p
				JOIN persona_tipopersona pt 
				ON pt.Persona_idPersona = p.idPersona
				AND pt.TipoPersona_idTipoPersona = 1
				JOIN direccion d 
				ON d.Persona_idPersona = p.idPersona
				JOIN ciudad2 c 
				ON c.code = d.Ciudad_idCiudad
				JOIN direccion_asignacion_ruta da 
				ON da.Direccion_idDireccion = d.idDireccion
				JOIN vehiculo v
				ON v.idVehiculo = da.Vehiculo_idVehiculo
				WHERE p.inactivo = 0 group by p.idPersona";
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
		$sql="SELECT * FROM proveedor ";
		return ejecutarConsulta($sql);		
	}

}

?>