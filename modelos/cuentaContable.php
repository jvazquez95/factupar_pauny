<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class cuentaContable
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
 
	//Implementamos un método para insertar registros
	public function insertar($Proceso_idProceso,$CentroCosto_idCentroCosto,$nroCuentaContable,$descripcion,$tipoCuenta,$nivel,$debitoAnterior,$creditoAnterior,$debitoEnero,$debitoFebrero,$debitoMarzo,$debitoAbril,$debitoMayo,$debitoJunio,$debitoJulio,$debitoAgosto,$debitoSetiembre,$debitoOctubre,$debitoNoviembre,$debitoDiciembre,$creditoEnero,$creditoFebrero,$creditoMarzo,$creditoAbril,$creditoMayo,$creditoJunio,$creditoJulio,$creditoAgosto,$creditoSetiembre,$creditoOctubre,$creditoNoviembre,$creditoDiciembre,$CuentaContable_idCuentaContablePadre)  
	{
		session_start();
		$usuario = $_SESSION['login'];
		$sql="INSERT INTO cuentacontable (`Proceso_idProceso`,`CentroCosto_idCentroCosto`,`nroCuentaContable`,`descripcion`,`tipoCuenta`,`nivel`,`debitoAnterior`,`creditoAnterior`,`debitoEnero`,`debitoFebrero`,`debitoMarzo`,`debitoAbril`,`debitoMayo`,`debitoJunio`,`debitoJulio`,`debitoAgosto`,`debitoSetiembre`,`debitoOctubre`,`debitoNoviembre`,`debitoDiciembre`,`creditoEnero`,`creditoFebrero`,`creditoMarzo`,`creditoAbril`,`creditoMayo`,`creditoJunio`,`creditoJulio`,`creditoAgosto`,`creditoSetiembre`,`creditoOctubre`,`creditoNoviembre`,`creditoDiciembre`,`CuentaContable_idCuentaContablePadre`,`usuarioInsercion`,`fechaInsercion`,`inactivo`) VALUES ('$Proceso_idProceso','$CentroCosto_idCentroCosto','$nroCuentaContable','$descripcion','$tipoCuenta','$nivel','$debitoAnterior','$creditoAnterior','$debitoEnero','$debitoFebrero','$debitoMarzo','$debitoAbril','$debitoMayo','$debitoJunio','$debitoJulio','$debitoAgosto','$debitoSetiembre','$debitoOctubre','$debitoNoviembre','$debitoDiciembre','$creditoEnero','$creditoFebrero','$creditoMarzo','$creditoAbril','$creditoMayo','$creditoJunio','$creditoJulio','$creditoAgosto','$creditoSetiembre','$creditoOctubre','$creditoNoviembre','$creditoDiciembre','$CuentaContable_idCuentaContablePadre','$usuario',now(),0)";
		return ejecutarConsulta($sql);         
	}

	//Implementamos un método para editar registros
	public function editar($idCuentaContable,$Proceso_idProceso,$CentroCosto_idCentroCosto,$nroCuentaContable,$descripcion,$tipoCuenta,$nivel,$debitoAnterior,$creditoAnterior,$debitoEnero,$debitoFebrero,$debitoMarzo,$debitoAbril,$debitoMayo,$debitoJunio,$debitoJulio,$debitoAgosto,$debitoSetiembre,$debitoOctubre,$debitoNoviembre,$debitoDiciembre,$creditoEnero,$creditoFebrero,$creditoMarzo,$creditoAbril,$creditoMayo,$creditoJunio,$creditoJulio,$creditoAgosto,$creditoSetiembre,$creditoOctubre,$creditoNoviembre,$creditoDiciembre,$CuentaContable_idCuentaContablePadre) 
	{ 
		session_start(); 
		$usuario = $_SESSION['login']; 
		$sql="UPDATE `cuentacontable` SET Proceso_idProceso = '$Proceso_idProceso', CentroCosto_idCentroCosto = '$CentroCosto_idCentroCosto', nroCuentaContable = '$nroCuentaContable', descripcion = '$descripcion', tipoCuenta = '$tipoCuenta', nivel = '$nivel', debitoAnterior = '$debitoAnterior', creditoAnterior = '$creditoAnterior', debitoEnero = '$debitoEnero', debitoFebrero = '$debitoFebrero', debitoMarzo = '$debitoMarzo', debitoAbril = '$debitoAbril', debitoMayo = '$debitoMayo', debitoJunio = '$debitoJunio', debitoJulio = '$debitoJulio', debitoAgosto = '$debitoAgosto', debitoSetiembre = '$debitoSetiembre', debitoOctubre = '$debitoOctubre', debitoNoviembre = '$debitoNoviembre', debitoDiciembre = '$debitoDiciembre', creditoEnero = '$creditoEnero', creditoFebrero = '$creditoFebrero', creditoMarzo = '$creditoMarzo', creditoAbril = '$creditoAbril', creditoMayo = '$creditoMayo', creditoJunio = '$creditoJunio', creditoJulio = '$creditoJulio', creditoAgosto = '$creditoAgosto', creditoSetiembre = '$creditoSetiembre', creditoOctubre = '$creditoOctubre', creditoNoviembre = '$creditoNoviembre', creditoDiciembre = '$creditoDiciembre' , CuentaContable_idCuentaContablePadre = '$CuentaContable_idCuentaContablePadre' , usuarioModificacion = '$usuario' , fechaModificacion= now() WHERE idCuentaContable='$idCuentaContable'"; 
		return ejecutarConsulta($sql);    
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idCuentaContable)
	{
		$sql="UPDATE cuentacontable SET inactivo=1 WHERE idCuentaContable='$idCuentaContable'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idCuentaContable)
	{
		$sql="UPDATE cuentacontable SET inactivo=0 WHERE idCuentaContable='$idCuentaContable'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idCuentaContable)
	{
		$sql="SELECT * FROM cuentacontable WHERE idCuentaContable='$idCuentaContable'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT a.idCuentaContable,a.nroCuentaContable,a.descripcion,b.ano as Proceso, c.descripcion as centroCosto,
			(CASE a.tipoCuenta
			 WHEN 'AC' then 'ACTIVO'
			 WHEN 'PA' then 'PASIVO'
		     WHEN 'PT' then 'PATRIMONIO'
          	 WHEN 'GA' then 'GANANCIA'
             WHEN 'PE' then 'PERDIDAS'
             WHEN 'OT' then 'OTROS' END) as tipoCuenta
          ,a.nivel,d.descripcion as descripcionPadre,a.inactivo
			  FROM cuentacontable a 
			  			 left outer join proceso b 			on a.Proceso_idProceso=b.idProceso 
						 left outer join centrocosto c   	on  a.CentroCosto_idCentroCosto=c.idCentroCosto 
						 left outer join cuentacontable d 	on a.CuentaContable_idCuentaContablePadre = d.idCuentaContable";
		return ejecutarConsulta($sql);	 	 
	}



	public function listarFiltro($filtro)
	{
		$sql="SELECT a.idCuentaContable,a.nroCuentaContable,a.descripcion,b.ano as Proceso, c.descripcion as centroCosto,
			(CASE a.tipoCuenta
			 WHEN 'AC' then 'ACTIVO'
			 WHEN 'PA' then 'PASIVO'
		     WHEN 'PT' then 'PATRIMONIO'
          	 WHEN 'GA' then 'GANANCIA'
             WHEN 'PE' then 'PERDIDAS'
             WHEN 'OT' then 'OTROS' END) as tipoCuenta
          ,a.nivel,d.descripcion as descripcionPadre,a.inactivo
			  FROM cuentacontable a 
			  			 left outer join proceso b 			on a.Proceso_idProceso=b.idProceso 
						 left outer join centrocosto c   	on  a.CentroCosto_idCentroCosto=c.idCentroCosto 
						 left outer join cuentacontable d 	on a.CuentaContable_idCuentaContablePadre = d.idCuentaContable WHERE a.tipoCuenta = 'PE' ";
		return ejecutarConsulta($sql);	 	 
	}

	//Implementar un método para listar los registros y mostrar en el select    
	public function selectCuentaContable()
	{
		$sql="SELECT * FROM cuentacontable where inactivo=0";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros
	public function listarparaLibroDiario() 
	{ 
		$sql="SELECT a.idCuentaContable,concat(a.nroCuentaContable,'-',a.descripcion) as descripcion,b.ano as Proceso, c.descripcion as centroCosto,a.tipoCuenta,a.nivel,d.descripcion as descripcionPadre,a.inactivo
			  FROM cuentacontable a 
			  			 left outer join proceso b 			on a.Proceso_idProceso=b.idProceso 
						 left outer join centrocosto c   	on  a.CentroCosto_idCentroCosto=c.idCentroCosto 
						 left outer join cuentacontable d 	on a.CuentaContable_idCuentaContablePadre = d.idCuentaContable
			 order by a.idCuentaContable";
		return ejecutarConsulta($sql);	 	 
	}

}

?>