<?php
require "../config/Conexion.php";

Class ArticuloEmpleado
{
	//implementamos nuestro constructor
	public function __contruct()
	{


	}

	public function insertar($Empleado_idEmpleado, $Articulo_idArticulo,$Deposito_idDeposito,$tipo,$cantidad)
	{
		session_start();
		$usuario = $_SESSION['login'];
		
		$sql="INSERT INTO `articuloempleados`
				(
				`Empleado_idEmpleado`,
				`Articulo_idArticulo`,
				`Deposito_idDeposito`,
				`tipo`,
				`cantidad`,
				`UsuarioIns`,
				`inactivo`)
				VALUES
				('$Empleado_idEmpleado',
				'$Articulo_idArticulo',
				'$Deposito_idDeposito',
				'$tipo',
				'$cantidad',
				'$usuario',
				0)";
		return ejecutarConsulta($sql);
	}



// 	public function editar($idArticuloEmpleado,$Empleado_idEmpleado, $Articulo_idArticulo,$Deposito_idDeposito,$tipo,$cantidad){
// 		session_start();
// 		$usuario = $_SESSION['login'];
// 		$monto= str_replace('.','',$monto);
		
// 		$sql="UPDATE `spa`.`articuloempleados`
// SET
// `idArticuloEmpleado` = idArticuloEmpleado,
// `Empleado_idEmpleado` = Empleado_idEmpleado,
// `Articulo_idArticulo` = Articulo_idArticulo,
// `Deposito_idDeposito` = Deposito_idDeposito,
// `tipo` = <{tipo: }>,
// `cantidad` = <{cantidad,
// WHERE `idArticuloEmpleado` = <{expr}>;
// ";
// 		return ejecutarConsulta($sql);
// 	}

	//Implementamos un método para desactivar registros
	public function desactivar($idArticuloEmpleado)
	{
		$sql="UPDATE articuloempleados SET inactivo='1' WHERE idArticuloEmpleado='$idArticuloEmpleado'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($idArticuloEmpleado)
	{
		$sql="UPDATE articuloempleados SET inactivo='0' WHERE idArticuloEmpleado='$idArticuloEmpleado'";
		return ejecutarConsulta($sql);
	}

	public function mostrar($idArticuloEmpleado)
	{
		$sql="SELECT * FROM articuloempleados WHERE idArticuloEmpleado = '$idArticuloEmpleado'";
		return ejecutarConsultaSimpleFila($sql);
	}


	public function listar()
	{
		$sql = "SELECT *, F_NOMBRE_ARTICULO(Articulo_idArticulo) as na,empleado.razonSocial as ne, deposito.descripcion as nd, articuloempleados.inactivo as aei from articuloempleados, deposito,empleado where articuloempleados.Deposito_idDeposito = deposito.idDeposito and empleado.idEmpleado = articuloempleados.Empleado_idEmpleado";
		return ejecutarConsulta($sql);
	}
}

?>