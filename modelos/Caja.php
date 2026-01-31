<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Caja
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre,$Sucursal_idSucursal)
	{
		$sql="INSERT INTO caja (nombre,Sucursal_idSucursal, inactivo)
		VALUES ('$nombre','$Sucursal_idSucursal', 0)";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idcaja,$nombre,$Sucursal_idSucursal)
	{
		$sql="UPDATE caja SET nombre='$nombre',Sucursal_idSucursal='$Sucursal_idSucursal' WHERE idcaja='$idcaja'";
		return ejecutarConsulta($sql);
	}

//Implementamos un método para desactivar registros
	public function desactivar($idcaja)
	{
		$sql="UPDATE caja SET inactivo='1' WHERE idcaja='$idcaja'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($idcaja)
	{
		$sql="UPDATE caja SET inactivo='0' WHERE idcaja='$idcaja'";
		return ejecutarConsulta($sql);
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idcaja)
	{
		$sql="SELECT * FROM caja WHERE idcaja='$idcaja'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT *, caja.inactivo as i ,caja.nombre as nc, sucursal.nombre as ns FROM caja, sucursal WHERE sucursal.idSucursal = caja.Sucursal_idSucursal ";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function selectCaja()
	{
		$sql="SELECT  c.idCaja,
        c.nombre,
        d.descripcion
FROM    caja      AS c
JOIN    deposito  AS d   ON d.idDeposito = c.Deposito_idDeposito
WHERE   NOT EXISTS (
          SELECT 1
          FROM   habilitacion AS h
          WHERE  h.Caja_idCaja = c.idCaja
            AND  h.estado      = 1
        );";
		return ejecutarConsulta($sql);		
	}
}

?>