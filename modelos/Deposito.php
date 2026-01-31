<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Deposito
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($Sucursal_idSucursal,$descripcion)
	{
		$sql="INSERT INTO deposito (Sucursal_idSucursal, descripcion)
		VALUES ('$Sucursal_idSucursal', '$descripcion')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idDeposito,$Sucursal_idSucursal,$descripcion)
	{
		$sql="UPDATE deposito SET Sucursal_idSucursal='$Sucursal_idSucursal', descripcion = '$descripcion' WHERE idDeposito='$idDeposito'";
		return ejecutarConsulta($sql);
	}


	//Implementamos un método para desactivar categorías
	public function desactivar($idDeposito)
	{
		$sql="UPDATE deposito SET inactivo=0 WHERE idDeposito='$idDeposito'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idDeposito)
	{
		$sql="UPDATE deposito SET inactivo=0 WHERE idDeposito='$idDeposito'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idDeposito)
	{
		$sql="SELECT * FROM deposito WHERE idDeposito='$idDeposito'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT deposito.idDeposito,deposito.descripcion,sucursal.nombre,deposito.inactivo,concat(vehiculo.matricula,' ',marca.descripcion,' ',modelo.descripcion) as vehiculo FROM deposito join sucursal on deposito.Sucursal_idSucursal = sucursal.idSucursal
					   LEFT OUTER JOIN vehiculo on deposito.Vehiculo_idVehiculo = vehiculo.idVehiculo
					   left outer join marca on vehiculo.MarcaVehiculo_idMarcaVehiculo= marca.idMarca
					   left outer join modelo on vehiculo.MarcaVehiculo_idMarcaVehiculo = modelo.Marca_idMarca and modelo.idModelo = vehiculo.Modelo_idModelo";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	/*public function selectCaja()
	{
		$sql="SELECT * FROM sucursal";
		return ejecutarConsulta($sql);		
	}*/

	//Implementar un método para listar los registros y mostrar en el select
	public function selectDeposito()
	{
		$sql="SELECT * FROM deposito";
		return ejecutarConsulta($sql);		
	}

	public function selectVehiculo()
	{
		$sql="SELECT vehiculo.idVehiculo,concat(vehiculo.matricula,' ',marca.descripcion,' ',modelo.descripcion) as vehiculo
from vehiculo
left outer join marca on vehiculo.MarcaVehiculo_idMarcaVehiculo= marca.idMarca
left outer join modelo on vehiculo.MarcaVehiculo_idMarcaVehiculo = modelo.Marca_idMarca and modelo.idModelo = vehiculo.Modelo_idModelo";
		return ejecutarConsulta($sql);		
	}	

	//Implementar un método para mostrar los datos de un registro a modificar
	public function selectSucursalXDeposito($idDeposito)
	{ 
		$sql="SELECT b.idSucursal,b.nombre FROM deposito a, sucursal b WHERE   a.Sucursal_idSucursal=b.idSucursal and  a.idDeposito='$idDeposito' limit 1";
		return ejecutarConsultaSimpleFila($sql);
	}	
}

?>