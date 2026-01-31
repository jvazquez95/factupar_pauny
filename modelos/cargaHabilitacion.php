<?php
require "../config/Conexion.php";

Class Habilitacion
{
	//implementamos nuestro constructor
	public function __contruct()
	{


	}

	public function insertar($Caja_idCaja, $Usuario_idUsuario,$fechaApertura,$montoApertura, $montoCierre, $cantidad, $idDetalleMoneda, $moneda)
	{
		session_start();
		$usuario_ins = $_SESSION['idusuario'];
		$sql="INSERT INTO `habilitacion`
				(
				`Caja_idCaja`,
				`Usuario_idUsuario`,
				`fechaApertura`,
				`montoApertura`,
				`montoCierre`,
				`estado`,
				`usuario_ins`)
				VALUES
				(
					'$Caja_idCaja',
					'$Usuario_idUsuario',
					curdate(),
					'$montoApertura',
					'$montoCierre',
					1,
					'$usuario_ins'
				);"; 

		$idhabilitacionnew=ejecutarConsulta_retornarID($sql);

		$num_elementos=0;
		$sw=true;
		$ultimo = count($idDetalleMoneda) - 1;
		
 
		while ($num_elementos < count($idDetalleMoneda))
		{ 
  
			if ($num_elementos == $ultimo) {
				 
			$sql_detalle = "INSERT INTO `detallehabilitacion`
							(
							`Habilitacion_idHabilitacion`,
							`Moneda_idMoneda`,
							`Denominacion_idDenominacion`,
							`montoApertura`,
							`montoCierre`, 
							`estado`
							)
							VALUES
							(
							'$idhabilitacionnew',
							'$moneda[$num_elementos]',
							'$idDetalleMoneda[$num_elementos]',
							'$cantidad[$num_elementos]',
							0,
							0
							)";


			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;

			}else{

				 
			$sql_detalle = "INSERT INTO `detallehabilitacion`
							(
							`Habilitacion_idHabilitacion`,
							`Moneda_idMoneda`,
							`Denominacion_idDenominacion`,
							`montoApertura`,
							`montoCierre`, 
							`estado`
							)
							VALUES
							(
							'$idhabilitacionnew',
							'$moneda[$num_elementos]',
							'$idDetalleMoneda[$num_elementos]',
							'$cantidad[$num_elementos]',
							0,
							0
							)";

			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;

			}

		}
		
		return $sw;		

	}

	public function generarPedido($idProveedor, $Denominacion_idDenominacion,$Moneda_idMoneda, $cantidad)
	{
		$usuario = $_SESSION['login'];

		$sql="CALL SP_HacerHabilitacion('$idProveedor', '$Denominacion_idDenominacion', '$usuario', '$Moneda_idMoneda', '$cantidad')";
		return ejecutarConsulta($sql);
	}	



	public function editar($idhabilitacion,$Caja_idCaja,$Usuario_idUsuario, $montoApertura, $montoCierre ){
		session_start();
		$usuario_ins = $_SESSION['idusuario'];
		$sql="UPDATE `habilitacion`
		SET
		`Caja_idCaja` = '$Caja_idCaja',
		`Usuario_idUsuario` = '$Usuario_idUsuario',
		`montoApertura` = '$montoApertura',
		`montoCierre` = '$montoCierre',
		`usuario_ins` = '$usuario_ins'
		WHERE `idhabilitacion` = '$idhabilitacion'
		";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para anular la venta
	public function habilitar($idhabilitacion)
	{
		session_start();
		$usuario_ins = $_SESSION['idusuario'];
		$sql="UPDATE habilitacion SET estado='1', `usuario_ins` = '$usuario_ins' WHERE idhabilitacion='$idhabilitacion'";
		return ejecutarConsulta($sql);
	}


	public function mostrar($idhabilitacion)
	{
		$sql="SELECT * FROM habilitacion WHERE idhabilitacion = '$idhabilitacion'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function selectDenominacion($idMoneda)
	{

		if ($idMoneda == 4) {	
			$sql="SELECT b.idDetalleMoneda as idDetalleMoneda,a.idMoneda,a.descripcion as moneda,b.idDetalleMoneda as idDenominacion,b.descripcion as denominacion  
			FROM moneda a, detallemoneda b where a.idMoneda = b.Moneda_idMoneda  ";
			return ejecutarConsulta($sql);
		}else{
			$sql="SELECT b.idDetalleMoneda as idDetalleMoneda,a.idMoneda,a.descripcion as moneda,b.idDetalleMoneda as idDenominacion,b.descripcion as denominacion  
			FROM moneda a, detallemoneda b where a.idMoneda = b.Moneda_idMoneda and a.idMoneda='$idMoneda' ";
			return ejecutarConsulta($sql);
		}
				
	}

	public function cerrar($idhabilitacion)
	{
		$sql="UPDATE `habilitacion`	SET	`fechaCierre` = now(),	`estado` = 0 WHERE `idhabilitacion` = '$idhabilitacion'";
		return ejecutarConsulta($sql);
	}


	public function listar()
	{
		session_start();
		$idUsuario = $_SESSION['idusuario'];
		if ($idUsuario == 1) {
			$sql = "SELECT *, usuario.nombre AS nu from habilitacion,usuario where usuario.idUsuario = habilitacion.Usuario_idUsuario";
		}else{
			$sql = "SELECT *, usuario.nombre AS nu from habilitacion,usuario where usuario.idUsuario = habilitacion.Usuario_idUsuario and usuario.idUsuario = '$idUsuario'";			
		}

		return ejecutarConsulta($sql);
	}


	public function listarHacerHabilitacion($idProveedor, $fi, $ff, $estado, $Moneda_idMoneda)
	{
		session_start();
		$idUsuario = $_SESSION['idusuario'];
 		if ($idUsuario == 1) {

			$sql = "SELECT a.idhabilitacion as idhabilitacion,a.Caja_idCaja as caja,c.nombre as np,a.fechaApertura,a.fechaCierre,
					d.descripcion as moneda, e.descripcion as denominacion,b.montoApertura as montoA, b.montoCierre as montoC
					from habilitacion a, detallehabilitacion b, usuario c, moneda d , detallemoneda e
					where a.idHabilitacion = b.Habilitacion_idHabilitacion and c.idUsuario = a.Caja_idCaja
					and b.Moneda_idMoneda=d.idMoneda and b.Denominacion_idDenominacion = e.idDetalleMoneda ";
		}else{
			$sql = "SELECT a.idhabilitacion as idhabilitacion,a.Caja_idCaja as caja,c.nombre as np,a.fechaApertura,a.fechaCierre,d.descripcion as moneda,
					b.montoApertura as montoA, b.montoCierre as montoC
					from habilitacion a, detallehabilitacion b, usuario c, moneda d 
					where a.idHabilitacion = b.Habilitacion_idHabilitacion and c.idUsuario = a.Caja_idCaja and a.Usuario_idUsuario = '$idUsuario'
					and b.Moneda_idMoneda=d.idMoneda ";			
		}			
	   //and b.Moneda_idMoneda = '$Moneda_idMoneda'   and a.fechaApertura = '$fi'

		return ejecutarConsulta($sql);
	}
}	


?>