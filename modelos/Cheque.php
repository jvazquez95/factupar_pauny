<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Cheque
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($fechaEmision ,$fechaCobro ,$Banco_idBanco ,$Moneda_idMoneda ,$tipoCheque ,$nroCheque ,$firmante ,$cliente ,$monto ,$comentario ,$fechaConfirmacion ,$fechaRechazo ,$nroCuenta,$estado)
	{

		session_start();
		$usuario = $_SESSION['login'];
		$sql="INSERT INTO `cheque`
				(
				`fechaEmision`,
				`fechaCobro`,
				`Banco_idBanco`,
				`Moneda_idMoneda`,
				`tipoCheque`,
				`nroCheque`,
				`firmante`,
				`cliente`,
				`monto`,
				`comentario`,
				`inactivo`,
				`fechaConfirmacion`,
				`fechaRechazo`,
				`nroCuenta`,
				`usuarioInsercion`,
				`fechaInsercion`,
				`estado`)
				VALUES
				(
				'$fechaEmision',
				'$fechaCobro',
				'$Banco_idBanco',
				'$Moneda_idMoneda',
				'$tipoCheque',
				'$nroCheque',
				'$firmante',
				'$cliente',
				'$monto',
				'$comentario',
				'0',
				'$fechaConfirmacion',
				'$fechaRechazo',
				'$nroCuenta',
				'$usuario',
				now(),
				'$estado'
				);";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idCheque, $fechaEmision ,$fechaCobro ,$Banco_idBanco ,$Moneda_idMoneda ,$tipoCheque ,$nroCheque ,$firmante ,$cliente ,$monto ,$comentario ,$fechaConfirmacion ,$fechaRechazo ,$nroCuenta,$estado)
	{
		session_start();
		$usuario = $_SESSION['login'];
		$sql="UPDATE `cheque`
		SET
		`fechaEmision` = '$fechaEmision',
		`fechaCobro` = '$fechaCobro',
		`Banco_idBanco` = '$Banco_idBanco',
		`Moneda_idMoneda` = '$Moneda_idMoneda',
		`tipoCheque` = '$tipoCheque',
		`nroCheque` = '$nroCheque',
		`firmante` = '$firmante',
		`cliente` = '$cliente',
		`monto` = '$monto',
		`comentario` = '$comentario',
		`fechaConfirmacion` = '$fechaConfirmacion',
		`fechaRechazo` = '$fechaRechazo',
		`nroCuenta` = '$nroCuenta',
		`usuarioModificacion` = '$usuario',
		`fechaModificacion` = now(),
		`estado` = '$estado'
		WHERE `idCheque` = '$idCheque';
";
		return ejecutarConsulta($sql);
	}


	//Implementamos un método para insertar registros
	public function insertarr($destinatario, $nroChequeCh, $nroCuenta, $Banco_idBancoCh, $Moneda_idMonedaCh, $monto, $fechaCobro, $tipoCheque, $comentario)
	{
		$sql="INSERT INTO 
		`chequepropio`(`nroCheque`, `monto`, `Moneda_idMoneda`, `Banco_idBanco`,`nroCuenta`,`destinatario`,`tipoCheque`,`fechaEmision`,`fechaCobro`,`comentario`, CuentaCorriente_idCuentaCorriente) 
		VALUES ('$nroChequeCh','$monto','$Moneda_idMonedaCh','$Banco_idBancoCh','$nroChequeCh','$destinatario','$tipoCheque',curDate(),'$fechaCobro','$comentario', 1)";

		return ejecutarConsulta_retornarID($sql);
	}



	//Implementamos un método para insertar registros
	public function generar($Banco_idBancoCh, $CuentaCorriente_idCuentaCorriente, $inicio, $fin, $tipoCheque)
	{
		$sw = true;
		session_start();
		$usuario = $_SESSION['login'];


		for ($i=$inicio; $i < $fin; $i++) { 
				
				$nroCheque = $i + 1;
				$sql="INSERT INTO 
				`chequepropio`(`Banco_idBanco`,`CuentaCorriente_idCuentaCorriente`,`usuarioInsercion`,`fechaInsercion`,`nroCheque`,`tipoCheque`) 
				VALUES ('$Banco_idBancoCh','$CuentaCorriente_idCuentaCorriente','$usuarioInsercion',now(), '$nroCheque', '$tipoCheque')";

			    ejecutarConsulta($sql) or $sw = false;	

		}

		return $sw;

	}


	//Implementamos un método para insertar registros
	public function insertarrr($emisor, $nroChequeCh, $nroCuenta, $Banco_idBancoCh, $Moneda_idMonedaCh, $monto, $fechaCobro, $tipoCheque, $comentario)
	{
		$sql="INSERT INTO 
		`chequetercero`(`nroCheque`, `monto`, `Moneda_idMoneda`, `Banco_idBanco`,`nroCuenta`,`emisor`,`tipoCheque`,`fechaEmision`,`fechaCobro`,`comentario`) 
		VALUES ('$nroChequeCh','$monto','$Moneda_idMonedaCh','$Banco_idBancoCh','$nroChequeCh','$emisor','$tipoCheque',curDate(),'$fechaCobro','$comentario')";

		return ejecutarConsulta_retornarID($sql);
	}




	//Implementamos un método para insertar registros
	public function editarrr($idChequeEmitido, $destinatario, $nroChequeCh, $nroCuenta, $Banco_idBancoCh, $Moneda_idMonedaCh, $monto, $fechaCobro, $tipoCheque, $comentario)
	{

		session_start();
		$usuario = $_SESSION['login'];

		$sql="UPDATE `chequepropio`
		SET
			`nroCheque` = '$nroChequeCh',
			`monto` = '$monto',
			`Moneda_idMoneda` = '$Moneda_idMonedaCh',
			`Banco_idBanco` = '$Banco_idBancoCh',
			`nroCuenta` = '$nroCuenta',
			`destinatario` = '$destinatario',
			`tipoCheque` = '$tipoCheque',
			`fechaCobro` = '$fechaCobro',
			`usuarioModificacion` = '$usuario',
			`fechaModificacion` = now(),
			`comentario` = '$comentario'
			WHERE `idChequeEmitido` = '$idChequeEmitido';
		";

		return ejecutarConsulta_retornarID($sql);
	}

	//Implementamos un método para desactivar categorías
	public function rechazar($idCheque)
	{
		$sql="UPDATE chequepropio SET inactivo=1 WHERE idChequeEmitido='$idCheque'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function confirmar($idCheque)
	{
		$sql="UPDATE chequepropio SET cobrado=1, fechaAcreditacion = now() WHERE idChequeEmitido='$idCheque'";
		return ejecutarConsulta($sql);
	}


	//Implementamos un método para desactivar categorías
	public function desactivar($idCheque)
	{
		$sql="UPDATE chequepropio SET inactivo=1 WHERE idChequeEmitido='$idCheque'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idCheque)
	{
		$sql="UPDATE chequepropio SET inactivo=0 WHERE idChequeEmitido='$idCheque'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idCheque)
	{
		$sql="SELECT * FROM cheque WHERE idCheque='$idCheque'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * from chequepropio order by idChequeEmitido desc";
		return ejecutarConsulta($sql);		
	}


	public function rpt_cheques_tipo( $fechaInicial, $fechaFinal, $tipoCheque, $tipoFecha ){

		if ($tipoFecha == 1) { //fecha emision

				$sql = "SELECT idChequeEmitido, 
				nroCheque, monto, 
				F_NOMBRE_MONEDA( Moneda_idMoneda ) as moneda, 
				F_NOMBRE_BANCO( Banco_idBanco ) as banco, 
				nroCuenta, 
				destinatario, 
				F_TIPO_CHEQUE( tipoCheque ) tipoCh, 
				fechaEmision, 
				fechaCobro, 
				fechaInsercion, 
				F_NOMBRE_CTACORRIENTE( CuentaCorriente_idCuentaCorriente ) cuentaCorriente, 
				cobrado, 
				comentario, 
				estado 
				from chequepropio 
				where tipoCheque = '$tipoCheque' and inactivo = 0 and fechaCobro >= '20220101' and 
                fechaCobro <=  '20221231'
				order by idChequeEmitido desc";

			
		}
		if ($tipoFecha == 2) { //fecha cobro
			
				$sql = "SELECT idChequeEmitido, 
				nroCheque, monto, 
				F_NOMBRE_MONEDA( Moneda_idMoneda ) as moneda, 
				F_NOMBRE_BANCO( Banco_idBanco ) as banco, 
				nroCuenta, 
				destinatario, 
				F_TIPO_CHEQUE( tipoCheque ) tipoCh, 
				fechaEmision, 
				fechaCobro, 
				fechaInsercion, 
				F_NOMBRE_CTACORRIENTE( CuentaCorriente_idCuentaCorriente ) cuentaCorriente, 
				cobrado, 
				comentario, 
				estado 
				from chequepropio 
				where tipoCheque = '$tipoCheque' and inactivo = 0 and fechaCobro >= '20220101' and 
                fechaCobro <=  '20221231'
				order by idChequeEmitido desc";


		}

		return ejecutarConsulta($sql);	

	}


	//Implementar un método para listar los registros y mostrar en el select
	public function selectcheque()
	{
		$sql="SELECT * FROM cheque where inactivo=0";
		return ejecutarConsulta($sql);		
	}


	//Implementar un método para listar los registros y mostrar en el select
	public function selectChequesPendientes($Banco_idBanco, $Moneda_idMoneda)
	{
		$sql="SELECT chequepropio.*, cuentacorriente.nroCuenta as ccnc , moneda.descripcion as nm
from chequepropio, cuentacorriente, moneda, banco 
where moneda.idMoneda = cuentacorriente.Moneda_idMoneda and banco.idBanco = Banco_idBanco and chequepropio.inactivo=0 and IFNULL(estado,0) = 0 and idCuentaCorriente = CuentaCorriente_idCuentaCorriente
and moneda.idMoneda = '$Moneda_idMoneda' and banco.idBanco = '$Banco_idBanco'
 order by idChequeEmitido asc;
";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function selectChequesPendientesRecibidos()
	{
		$sql="SELECT * from chequetercero where inactivo=0 and IFNULL(estado,0) = 0;";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function importe($idCheque)
	{	
		$sql="SELECT chequepropio.*, cuentacorriente.nroCuenta as ccnc from chequepropio, cuentacorriente where idCuentaCorriente = CuentaCorriente_idCuentaCorriente and idChequeEmitido = '$idCheque' ";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function importeRecibidos($idCheque)
	{	
		$sql="SELECT monto from chequetercero where idChequeTercero = '$idCheque'";
		return ejecutarConsultaSimpleFila($sql);
	}



	public function selectCuentaCorriente()
	{
		$sql="SELECT * FROM cuentacorriente where inactivo=0";
		return ejecutarConsulta($sql);		
	}


	public function selectCuentaCorrienteBanco($id)
	{
		$sql="SELECT * FROM cuentacorriente where inactivo=0";
		return ejecutarConsulta($sql);		
	}



}

?>