<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require "../config/Conexion.php";

Class Movimiento
{
	//implementamos nuestro constructor
	public function __contruct()
	{


	}

	public function insertar($descripcion, $monto,$idConcepto,$habilitacion,$Empleado_idEmpleado,$TerminoPago_idTerminoPago, $cantidad,$precioUnitario)
	{
		session_start();
		$usuario = $_SESSION['login'];
			$monto= str_replace('.','',$monto);
		
		$sql="INSERT INTO `movimiento`(`descripcion`, `monto`, `concepto`, `habilitacion`, `usuario`, `inactivo`, `Empleado_idEmpleado`,`fechaTransaccion`,`TerminoPago_idTerminoPago`,`cantidad`,`precioUnitario`) VALUES ('$descripcion', '$monto', '$idConcepto','$habilitacion', '$usuario',0,'$Empleado_idEmpleado',now(), '$TerminoPago_idTerminoPago','$cantidad','$precioUnitario')";
		return ejecutarConsulta($sql);
	}



	public function editar($idMovimiento,$descripcion, $monto,$idConcepto,$habilitacion, $cantidad, $precioUnitario){
		session_start();
		$usuario = $_SESSION['login'];
		$monto= str_replace('.','',$monto);
		
		$sql="UPDATE `movimiento` SET `descripcion`='$descripcion',`monto`='$monto',`concepto`='$idConcepto',`habilitacion`='$habilitacion',`usuarioModificacion`='$usuario' WHERE idMovimiento = '$idMovimiento'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($idMovimiento)
	{
		$sql="UPDATE movimiento SET inactivo='1' WHERE idMovimiento='$idMovimiento'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($idMovimiento)
	{
		$sql="UPDATE movimiento SET inactivo='0' WHERE idMovimiento='$idMovimiento'";
		return ejecutarConsulta($sql);
	}

	public function mostrar($idMovimiento)
	{
		$sql="SELECT * FROM movimiento m, formapago f  where m.TerminoPago_idTerminoPago = f.idFormaPago  WHERE idMovimiento = '$idMovimiento'";
		return ejecutarConsultaSimpleFila($sql);
	}


	public function listar($habilitacion)
	{
		$sql = "select *, f.descripcion as dfp, m.descripcion as md , c.descripcion as nc, m.inactivo as mi from movimiento m, concepto c, formapago f where m.TerminoPago_idTerminoPago = f.idFormaPago and m.concepto = c.idConcepto AND m.habilitacion = '$habilitacion'
		  ";
		return ejecutarConsulta($sql);
	}
}

?>