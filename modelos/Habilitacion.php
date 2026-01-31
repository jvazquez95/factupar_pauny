<?php
require "../config/Conexion.php";

Class Habilitacion
{
	//implementamos nuestro constructor
	public function __contruct()
	{


	}

	public function insertar($Caja_idCaja, $Usuario_idUsuario,$fechaApertura,$montoApertura, $montoCierre)
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
					'$fechaApertura',
					'$montoApertura',
					'$montoCierre',
					1,
					'$usuario_ins'
				);";
		return ejecutarConsulta($sql);
	}

	public function generarPedido($idProveedor, $Denominacion_idDenominacion,$Moneda_idMoneda, $cantidad)
	{
		$usuario = $_SESSION['login'];

		$sql="CALL SP_HacerHabilitacion('$idProveedor', '$Denominacion_idDenominacion', '$usuario', '$Moneda_idMoneda', '$cantidad')";
		return ejecutarConsulta($sql);
	}	



	public function asignarAyudante($idhabilitacion, $idAyudante)
	{
		$usuario = $_SESSION['login'];

		$sql="UPDATE habilitacion SET Usuario_idAyudante = '$idAyudante' where idHabilitacion = '$idhabilitacion'";
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
		$sql="SELECT b.idDetalleMoneda as idDetalleMoneda,a.idMoneda,a.descripcion as moneda,b.idDetalleMoneda as idDenominacion,b.descripcion as denominacion  
		FROM moneda a, detallemoneda b where a.idMoneda = b.Moneda_idMoneda";
		return ejecutarConsulta($sql);
	}

	public function cerrar($idhabilitacion)
	{
		$sql="UPDATE `habilitacion`	SET	`fechaCierre` = now(),	`estado` = 0 WHERE `idhabilitacion` = '$idhabilitacion'";
		return ejecutarConsulta($sql);
	}


	public function listar()
	{
/*		session_start();
		$idUsuario = $_SESSION['idusuario'];
		if ($idUsuario == 1) {
			$sql = "SELECT *, usuario.nombre AS nu from habilitacion,usuario where usuario.idUsuario = habilitacion.Usuario_idUsuario";
		}else{
			$sql = "SELECT *, usuario.nombre AS nu from habilitacion,usuario where usuario.idUsuario = habilitacion.Usuario_idUsuario and usuario.idUsuario = '$idUsuario'";			
		}
*/
		$sql = "SELECT *, usuario.nombre AS nu, caja.nombre as nc from habilitacion,usuario, caja where idCaja = Caja_idCaja and usuario.idUsuario = habilitacion.Usuario_idUsuario";		

		return ejecutarConsulta($sql);
	}


	public function listar2($fecha_inicial, $fecha_final)
	{
			$sql = "SELECT
						h.*,                          -- todos los campos de habilitacion (sin cambios)
						u.nombre  AS nu,              -- cajero         (ALIAS sin cambios)
						c.nombre  AS nc,              -- caja           (ALIAS sin cambios)
						u2.nombre AS un               -- acompañante    (ALIAS sin cambios; NULL si no existe)
						FROM habilitacion AS h
						JOIN usuario AS u   ON u.idUsuario = h.Usuario_idUsuario   -- cajero (obligatorio)
						JOIN caja    AS c   ON c.idCaja    = h.Caja_idCaja         -- caja   (obligatorio)
						LEFT JOIN usuario AS u2 ON u2.idUsuario = h.Usuario_idAyudante  -- acompañante (opcional)
						WHERE DATE(h.fechaApertura) between '$fecha_inicial' and '$fecha_final'";			
	
		return ejecutarConsulta($sql);
	}


	public function listarHacerHabilitacion($idProveedor, $fi, $ff, $estado, $Moneda_idMoneda)
	{



		/*session_start();
		$idUsuario = $_SESSION['idusuario'];
		if ($Moneda_idMoneda =='%%'){
	 		if ($idUsuario == 1) {

				$sql = "SELECT a.idhabilitacion as idhabilitacion,a.Caja_idCaja as caja,c.nombre as np,a.fechaApertura,a.fechaCierre,
						d.descripcion as moneda, e.descripcion as denominacion,b.montoApertura as montoA, b.montoCierre as montoC
						from habilitacion a, detallehabilitacion b, usuario c, moneda d , detallemoneda e
						where a.idHabilitacion = b.Habilitacion_idHabilitacion and c.idUsuario = a.Usuario_idUsuario
						and b.Moneda_idMoneda=d.idMoneda and b.Denominacion_idDenominacion = e.idDetalleMoneda and a.fechaApertura between '$fi' and '$ff' ";
			}else{
				$sql = "SELECT a.idhabilitacion as idhabilitacion,a.Caja_idCaja as caja,c.nombre as np,a.fechaApertura,a.fechaCierre,d.descripcion as moneda,
						b.montoApertura as montoA, b.montoCierre as montoC
						from habilitacion a, detallehabilitacion b, usuario c, moneda d 
						where a.idHabilitacion = b.Habilitacion_idHabilitacion and c.idUsuario = a.Usuario_idUsuario and a.Usuario_idUsuario = '$idUsuario'
						and b.Moneda_idMoneda=d.idMoneda  and a.fechaApertura between '$fi' and '$ff'";			
			}	
		}else{
			if ($idUsuario == 1) {

				$sql = "SELECT a.idhabilitacion as idhabilitacion,a.Caja_idCaja as caja,c.nombre as np,a.fechaApertura,a.fechaCierre,
						d.descripcion as moneda, e.descripcion as denominacion,b.montoApertura as montoA, b.montoCierre as montoC
						from habilitacion a, detallehabilitacion b, usuario c, moneda d , detallemoneda e
						where a.idHabilitacion = b.Habilitacion_idHabilitacion and c.idUsuario = a.Usuario_idUsuario
						and b.Moneda_idMoneda=d.idMoneda and b.Denominacion_idDenominacion = e.idDetalleMoneda and a.fechaApertura between '$fi' and '$ff' 
						and b.Moneda_idMoneda='$Moneda_idMoneda' ";
			}else{
				$sql = "SELECT a.idhabilitacion as idhabilitacion,a.Caja_idCaja as caja,c.nombre as np,a.fechaApertura,a.fechaCierre,d.descripcion as moneda,
						b.montoApertura as montoA, b.montoCierre as montoC
						from habilitacion a, detallehabilitacion b, usuario c, moneda d 
						where a.idHabilitacion = b.Habilitacion_idHabilitacion and c.idUsuario = a.Usuario_idUsuario and a.Usuario_idUsuario = '$idUsuario'
						and b.Moneda_idMoneda=d.idMoneda  and a.fechaApertura between '$fi' and '$ff' and b.Moneda_idMoneda='$Moneda_idMoneda' ";			
			}	
		} */
					
	   //and b.Moneda_idMoneda = '$Moneda_idMoneda'   and a.fechaApertura = '$fi'
		session_start();
		$idUsuario = $_SESSION['idusuario'];
		if ($Moneda_idMoneda =='%%'){
	 		if ($idUsuario == 1) {

				$sql = "SELECT a.idhabilitacion as idhabilitacion,a.Caja_idCaja as caja,c.nombre as np,a.fechaApertura,a.fechaCierre 
						from habilitacion a,  usuario c  
						where c.idUsuario = a.Usuario_idUsuario
						and  a.fechaApertura between '$fi' and '$ff' ";
			}else{
				$sql = "SELECT a.idhabilitacion as idhabilitacion,a.Caja_idCaja as caja,c.nombre as np,a.fechaApertura,a.fechaCierre 
						from habilitacion a, detallehabilitacion b, usuario c, moneda d 
						where a.idHabilitacion = b.Habilitacion_idHabilitacion and c.idUsuario = a.Usuario_idUsuario and a.Usuario_idUsuario = '$idUsuario'
						and b.Moneda_idMoneda=d.idMoneda  and a.fechaApertura between '$fi' and '$ff'";			
			}	
		}else{
			if ($idUsuario == 1) {

				$sql = "SELECT a.idhabilitacion as idhabilitacion,a.Caja_idCaja as caja,c.nombre as np,a.fechaApertura,a.fechaCierre,
						d.descripcion as moneda, e.descripcion as denominacion,b.montoApertura as montoA, b.montoCierre as montoC
						from habilitacion a,   usuario c 
						where  c.idUsuario = a.Usuario_idUsuario
						and  a.fechaApertura between '$fi' and '$ff' 
						  ";
			}else{
				$sql = "SELECT a.idhabilitacion as idhabilitacion,a.Caja_idCaja as caja,c.nombre as np,a.fechaApertura,a.fechaCierre 
						from habilitacion a,  usuario c 
						where a.idHabilitacion = b.Habilitacion_idHabilitacion and c.idUsuario = a.Usuario_idUsuario and a.Usuario_idUsuario = '$idUsuario'
						  and a.fechaApertura between '$fi' and '$ff'   ";			
			}	
		}
		return ejecutarConsulta($sql);
	}
}	


?>