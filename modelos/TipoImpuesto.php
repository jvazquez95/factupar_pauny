<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class TipoImpuesto
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($descripcion,$porcentajeImpuesto, $CuentaContable_mercaderiaId,$CuentaContable_ventasMercaderiasId, $CuentaContable_costoMercaderiaId,$CuentaContable_impuestoId,$CuentaContable_servicioId, $CuentaContable_notaCreditoId, $CuentaContable_comprasId)
	{
		$usuario = $_SESSION['login'];

		$sql="INSERT INTO tipoimpuesto (descripcion,porcentajeImpuesto,inactivo, usuarioIns, fechaIns, CuentaContable_mercaderiaId, CuentaContable_ventasMercaderiasId, CuentaContable_costoMercaderiaId, CuentaContable_ivaId, CuentaContable_servicioId)
		VALUES ('$descripcion','$porcentajeImpuesto', 0, '$usuario', now(), )";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idTipoImpuesto,$descripcion,$porcentajeImpuesto, $CuentaContable_mercaderiaId,$CuentaContable_ventasMercaderiasId, $CuentaContable_costoMercaderiaId,$CuentaContable_impuestoId,$CuentaContable_servicioId, $CuentaContable_notaCreditoId, $CuentaContable_comprasId)
	{
		$usuario = $_SESSION['login'];

		$sql="UPDATE tipoimpuesto SET 
		descripcion='$descripcion',
		porcentajeImpuesto='$porcentajeImpuesto', 
		CuentaContable_mercaderiaId='$CuentaContable_mercaderiaId', 
		CuentaContable_ventasMercaderiasId='$CuentaContable_ventasMercaderiasId', 
		CuentaContable_costoMercaderiaId='$CuentaContable_costoMercaderiaId',
		CuentaContable_ivaId='$CuentaContable_impuestoId',
		CuentaContable_servicioId='$CuentaContable_servicioId',
		CuentaContable_notaCreditoId='$CuentaContable_notaCreditoId',
		CuentaContable_comprasId='$CuentaContable_comprasId',
		usuarioMod='$usuario',
		fechaModificacion=now()
		WHERE idTipoImpuesto='$idTipoImpuesto'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idTipoImpuesto)
	{
		$sql="UPDATE tipoimpuesto SET inactivo=1 WHERE idTipoImpuesto='$idTipoImpuesto'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idTipoImpuesto)
	{
		$sql="UPDATE tipoimpuesto SET inactivo=0 WHERE idTipoImpuesto='$idTipoImpuesto'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idTipoImpuesto)
	{
		$sql="SELECT * FROM tipoimpuesto WHERE idTipoImpuesto='$idTipoImpuesto'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT *, 
			F_NOMBRE_CTACONTABLE( CuentaContable_mercaderiaId ) as ccMercaderias, 
			F_NOMBRE_CTACONTABLE( CuentaContable_costoMercaderiaId ) as cccostoMercaderias, 
			F_NOMBRE_CTACONTABLE( CuentaContable_ventasMercaderiasId ) as ccventasMercaderias, 
			F_NOMBRE_CTACONTABLE( CuentaContable_ivaId ) as cciva, 
			F_NOMBRE_CTACONTABLE( CuentaContable_servicioId ) as ccservicios, 
			F_NOMBRE_CTACONTABLE( CuentaContable_notaCreditoId ) as ccnc, 
			F_NOMBRE_CTACONTABLE( CuentaContable_comprasId ) as cccompras,
			F_NOMBRE_CTACONTABLE( CuentaContable_regimenTurismoId ) as ccrt 
			from tipoimpuesto;";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM tipoimpuesto where inactivo=0";
		return ejecutarConsulta($sql);		
	}
}

?>