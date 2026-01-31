<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";



Class cotizacionDiaria
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}


	//Implementamos un método para insertar registros
	public function insertar($Moneda_idMoneda,$fecha,$cotizacionVenta,$cotizacionCompra)
	{
		session_start();
		$usuario = $_SESSION['login'];
		$sql="INSERT INTO cotizaciondiaria (Moneda_idMoneda, fecha, cotizacionVenta, cotizacionCompra, usuarioInsercion, inactivo, fechaInsercion)
		VALUES ('$Moneda_idMoneda', '$fecha', '$cotizacionVenta', '$cotizacionCompra', '$usuario', 0,now())";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idCotizacionDiaria,$Moneda_idMoneda,$fecha,$cotizacionVenta,$cotizacionCompra)
	{		
		session_start();
		$usuario = $_SESSION['login'];		
		$sql="UPDATE cotizaciondiaria SET Moneda_idMoneda='$Moneda_idMoneda', fecha = '$fecha', cotizacionVenta = '$cotizacionVenta' , cotizacionCompra = '$cotizacionCompra',`fechaModificacion`=now(), usuarioModificacion = '$usuario'  WHERE idCotizacionDiaria='$idCotizacionDiaria'";
		return ejecutarConsulta($sql);  
	}


	//Implementamos un método para desactivar categorías
	public function desactivar($idCotizacionDiaria) 
	{
		$sql="UPDATE cotizaciondiaria SET inactivo=1 WHERE idCotizacionDiaria='$idCotizacionDiaria'";
		return ejecutarConsulta($sql); 
	}

	//Implementamos un método para activar categorías
	public function activar($idCotizacionDiaria)
	{
		$sql="UPDATE cotizaciondiaria SET inactivo=0 WHERE idCotizacionDiaria='$idCotizacionDiaria'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idCotizacionDiaria)
	{
		$sql="SELECT * FROM cotizaciondiaria WHERE idCotizacionDiaria='$idCotizacionDiaria'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql=	"SELECT cotizaciondiaria.idCotizacionDiaria,cotizaciondiaria.fecha,cotizaciondiaria.cotizacionVenta,
					cotizaciondiaria.cotizacionCompra,cotizaciondiaria.inactivo,moneda.descripcion
				 FROM cotizaciondiaria ,moneda 
				 WHERE cotizaciondiaria.Moneda_idMoneda = moneda.idMoneda";
		return ejecutarConsulta($sql);		 
	}
	//Implementar un método para listar los registros y mostrar en el select
	/*public function selectCaja()
	{
		$sql="SELECT * FROM sucursal";
		return ejecutarConsulta($sql);		
	}*/

	//Implementar un método para listar los registros y mostrar en el select
	public function selectCotizacionDiaria()
	{
		$sql="SELECT * FROM cotizaciondiaria where inactivo = 0";
		return ejecutarConsulta($sql);		
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function ultimaCotizacion($Moneda_idMoneda)
	{
		$sql="SELECT cotizacionVenta, cotizacionCompra FROM cotizaciondiaria where inactivo = 0 and Moneda_idMoneda = '$Moneda_idMoneda' order by idCotizacionDiaria desc limit 1";

		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function selectCotizacionPorMoneda($monedan)
	{
		$sql="SELECT cotizacionCompra FROM cotizaciondiaria where inactivo = 0 and Moneda_idMoneda = '$monedan' order by idCotizacionDiaria desc limit 1";
 

		return ejecutarConsultaSimpleFila($sql);
	}

}

?>