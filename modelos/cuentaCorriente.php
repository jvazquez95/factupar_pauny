<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class cuentaCorriente
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
 
	//Implementamos un método para insertar registros
	public function insertar($Proceso_idProceso,$CuentaContable_idCuentaContable,$descripcion,$debitoAnterior,$creditoAnterior,$debitoEnero,$debitoFebrero,$debitoMarzo,$debitoAbril,$debitoMayo,$debitoJunio,$debitoJulio,$debitoAgosto,$debitoSetiembre,$debitoOctubre,$debitoNoviembre,$debitoDiciembre,$creditoEnero,$creditoFebrero,$creditoMarzo,$creditoAbril,$creditoMayo,$creditoJunio,$creditoJulio,$creditoAgosto,$creditoSetiembre,$creditoOctubre,$creditoNoviembre,$creditoDiciembre)  
	{
		session_start();
		$usuario = $_SESSION['login'];
		$sql="INSERT INTO cuentacorriente (`Proceso_idProceso`,`CuentaContable_idCuentaContable`,`descripcion`,`debitoAnterior`,`creditoAnterior`,`debitoEnero`,`debitoFebrero`,`debitoMarzo`,`debitoAbril`,`debitoMayo`,`debitoJunio`,`debitoJulio`,`debitoAgosto`,`debitoSetiembre`,`debitoOctubre`,`debitoNoviembre`,`debitoDiciembre`,`creditoEnero`,`creditoFebrero`,`creditoMarzo`,`creditoAbril`,`creditoMayo`,`creditoJunio`,`creditoJulio`,`creditoAgosto`,`creditoSetiembre`,`creditoOctubre`,`creditoNoviembre`,`creditoDiciembre`,`usuarioInsercion`,`fechaInsercion`,`inactivo`) VALUES ('$Proceso_idProceso','$CuentaContable_idCuentaContable','$descripcion','$debitoAnterior','$creditoAnterior','$debitoEnero','$debitoFebrero','$debitoMarzo','$debitoAbril','$debitoMayo','$debitoJunio','$debitoJulio','$debitoAgosto','$debitoSetiembre','$debitoOctubre','$debitoNoviembre','$debitoDiciembre','$creditoEnero','$creditoFebrero','$creditoMarzo','$creditoAbril','$creditoMayo','$creditoJunio','$creditoJulio','$creditoAgosto','$creditoSetiembre','$creditoOctubre','$creditoNoviembre','$creditoDiciembre','$usuario',now(),0)";
		return ejecutarConsulta($sql);         
	}

	//Implementamos un método para editar registros
	public function editar($idCuentaCorriente,$Proceso_idProceso,$CuentaContable_idCuentaContable,$descripcion,$debitoAnterior,$creditoAnterior,$debitoEnero,$debitoFebrero,$debitoMarzo,$debitoAbril,$debitoMayo,$debitoJunio,$debitoJulio,$debitoAgosto,$debitoSetiembre,$debitoOctubre,$debitoNoviembre,$debitoDiciembre,$creditoEnero,$creditoFebrero,$creditoMarzo,$creditoAbril,$creditoMayo,$creditoJunio,$creditoJulio,$creditoAgosto,$creditoSetiembre,$creditoOctubre,$creditoNoviembre,$creditoDiciembre) 
	{ 
		session_start(); 
		$usuario = $_SESSION['login']; 
		$sql="UPDATE `cuentacorriente` SET  Proceso_idProceso = '$Proceso_idProceso', CuentaContable_idCuentaContable = '$CuentaContable_idCuentaContable', descripcion = '$descripcion', debitoAnterior = '$debitoAnterior', creditoAnterior = '$creditoAnterior', debitoEnero = '$debitoEnero', debitoFebrero = '$debitoFebrero', debitoMarzo = '$debitoMarzo', debitoAbril = '$debitoAbril', debitoMayo = '$debitoMayo', debitoJunio = '$debitoJunio', debitoJulio = '$debitoJulio', debitoAgosto = '$debitoAgosto', debitoSetiembre = '$debitoSetiembre', debitoOctubre = '$debitoOctubre', debitoNoviembre = '$debitoNoviembre', debitoDiciembre = '$debitoDiciembre', creditoEnero = '$creditoEnero', creditoFebrero = '$creditoFebrero', creditoMarzo = '$creditoMarzo', creditoAbril = '$creditoAbril', creditoMayo = '$creditoMayo', creditoJunio = '$creditoJunio', creditoJulio = '$creditoJulio', creditoAgosto = '$creditoAgosto', creditoSetiembre = '$creditoSetiembre', creditoOctubre = '$creditoOctubre', creditoNoviembre = '$creditoNoviembre', creditoDiciembre = '$creditoDiciembre' , usuarioModificacion = '$usuario' , fechaModificacion= now() WHERE idCuentaCorriente='$idCuentaCorriente'"; 
		return ejecutarConsulta($sql);    
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idCuentaCorriente)
	{
		$sql="UPDATE cuentacorriente SET inactivo=1 WHERE idCuentaCorriente='$idCuentaCorriente'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idCuentaCorriente)
	{
		$sql="UPDATE cuentacorriente SET inactivo=0 WHERE idCuentaCorriente='$idCuentaCorriente'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idCuentaCorriente)
	{
		$sql="SELECT * FROM cuentacorriente WHERE idCuentaCorriente='$idCuentaCorriente'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT a.idCuentaCorriente,a.descripcion,b.ano as Proceso,d.descripcion as cuentaContable,a.inactivo
				FROM cuentacorriente a join proceso b 			on a.Proceso_idProceso=b.idProceso 
					   				   join cuentacontable d 	on a.CuentaContable_idCuentaContable = d.idCuentaContable"; 
		return ejecutarConsulta($sql);	 	 
	}
	//Implementar un método para listar los registros y mostrar en el select    
	public function select()
	{
		$sql="SELECT * FROM cuentacorriente where inactivo=0";
		return ejecutarConsulta($sql);		
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