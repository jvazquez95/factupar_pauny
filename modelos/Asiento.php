<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Asiento
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar(
		$Proceso_idProceso,
		$Moneda_idMoneda,
		$fechaAsiento,
		$fechaPlanilla,
		$transaccionOrigen,
		$nroOrigen,
		$comentario,

		$item,
		$CuentaContable_idCuentaContable,
		$CuentaCorriente_idCuentaCorriente,
		$tipoMovimiento,
		$CentroCosto_idCentroCosto,
		$importe, 
		$tasaCambio,
		$tasaCambioBases,
		$Concepto_idConcepto,
		$tipoComprobante,
		$nroComprobante,
		$Banco_idBanco,
		$nroCheque){
		session_start();
		$usuario = $_SESSION['login'];

		$sql="
			INSERT INTO `asiento`
			(`Proceso_idProceso`,
			`Moneda_idMoneda`,
			`fechaAsiento`,
			`fechaPlanilla`,
			`transaccionOrigen`,
			`nroOrigen`,
			`comentario`,
			`usuarioInsercion`,
			`fechaInsercion`,
			`inactivo`) 
			VALUES
			(
			'$Proceso_idProceso',
			'$Moneda_idMoneda',
			'$fechaAsiento',
			'$fechaPlanilla',
			'$transaccionOrigen',
			'$nroOrigen',
			'$comentario',
			'$usuario',
			now(),
			0
			)";


		$nuevoId = ejecutarConsulta_retornarID($sql);
	
		$num_elementosTipoPersona=0;
		$sw=true;
		
		while ($num_elementosTipoPersona < count($item))
		{


			$sql_detalle = "  INSERT INTO `asientodetalle`
			(`Proceso_idProceso`,
			`Asiento_idAsiento`,
			`item`,
			`CuentaContable_idCuentaContable`,
			`CuentaCorriente_idCuentaCorriente`,
			`tipoMovimiento`,
			`CentroCosto_idCentroCosto`,
			`importe`,
			`tasaCambio`,
			`tasaCambioBases`,
			`Concepto_idConcepto`,
			`tipoComprobante`,
			`nroComprobante`,
			`Banco_idBanco`,
			`nroCheque`,
			`usuarioInsercion`,
			`fechaInsercion`,
			`inactivo`)
			VALUES
			(
			'$Proceso_idProceso',
			'$nuevoId',
			'$item[$num_elementosTipoPersona]',
			'$CuentaContable_idCuentaContable[$num_elementosTipoPersona]',
			'$CuentaCorriente_idCuentaCorriente[$num_elementosTipoPersona]',
			'$tipoMovimiento[$num_elementosTipoPersona]',
			'$CentroCosto_idCentroCosto[$num_elementosTipoPersona]', 
			'$importe[$num_elementosTipoPersona]',
			'$tasaCambio[$num_elementosTipoPersona]',
			'$tasaCambioBases[$num_elementosTipoPersona]',
			'$Concepto_idConcepto[$num_elementosTipoPersona]',
			'$tipoComprobante[$num_elementosTipoPersona]',
			'$nroComprobante[$num_elementosTipoPersona]',
			'$Banco_idBanco[$num_elementosTipoPersona]',
			'$nroCheque[$num_elementosTipoPersona]',
			'$usuario',
			now(),
			0
			)";


			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementosTipoPersona=$num_elementosTipoPersona + 1;
		}
 
		return $sw;

	}

	//Implementamos un método para editar registros
	public function editar($idAsiento,$Proceso_idProceso,
		$Moneda_idMoneda,
		$fechaAsiento,
		$fechaPlanilla,
		$transaccionOrigen,
		$nroOrigen,
		$comentario,

		$item,
		$CuentaContable_idCuentaContable,
		$CuentaCorriente_idCuentaCorriente,
		$tipoMovimiento,
		$CentroCosto_idCentroCosto,
		$importe,
		$tasaCambio,
		$tasaCambioBases,
		$Concepto_idConcepto,
		$tipoComprobante,
		$nroComprobante,
		$Banco_idBanco,
		$nroCheque,
		$idAsientoDetalle)
	{
		$sw=true;
		$sql="UPDATE asiento SET  Proceso_idProceso='$Proceso_idProceso', Moneda_idMoneda='$Moneda_idMoneda',fechaAsiento='$fechaAsiento',fechaPlanilla='$fechaPlanilla',transaccionOrigen='$transaccionOrigen',nroOrigen='$nroOrigen',comentario='$comentario', fechaModificacion = now() WHERE idAsiento='$idAsiento'";
		ejecutarConsulta($sql) or $sw = false;

		$num_elementos=0;
		//$sw=true;
		if ($sw == true) {
				
					while ($num_elementos < count($item))
					{
						if ($idAsientoDetalle[$num_elementos] == 0) {

							$sql_detalle = "INSERT INTO `asientodetalle`
							(`Proceso_idProceso`,
							`Asiento_idAsiento`,
							`item`,
							`CuentaContable_idCuentaContable`,
							`CuentaCorriente_idCuentaCorriente`,
							`tipoMovimiento`,
							`CentroCosto_idCentroCosto`,
							`importe`,
							`tasaCambio`,
							`tasaCambioBases`,
							`Concepto_idConcepto`,
							`tipoComprobante`,
							`nroComprobante`,
							`Banco_idBanco`,
							`nroCheque`,
							`usuarioInsercion`,
							`fechaInsercion`,
							`inactivo`)
							VALUES
							(
							'$Proceso_idProceso',
							'$idAsiento',
							'$item[$num_elementos]',
							'$CuentaContable_idCuentaContable[$num_elementos]',
							'$CuentaCorriente_idCuentaCorriente[$num_elementos]',
							'$tipoMovimiento[$num_elementos]',
							'$CentroCosto_idCentroCosto[$num_elementos]',
							'$importe[$num_elementos]',
							'$tasaCambio[$num_elementos]',
							'$tasaCambioBases[$num_elementos]',
							'$Concepto_idConcepto[$num_elementos]',
							'$tipoComprobante[$num_elementos]',
							'$nroComprobante[$num_elementos]',
							'$Banco_idBanco[$num_elementos]',
							'$nroCheque[$num_elementos]',
							'$usuario',
							now(),
							0
							)"; 
							ejecutarConsulta($sql_detalle) or $sw = false;
							$num_elementos=$num_elementos + 1;

						}else{

				/*			$sql_detalle = "UPDATE `asientodetalle`	SET
												`Proceso_idProceso` = '$Proceso_idProceso',`item` = '$item[$num_elementos]',`CuentaContable_idCuentaContable` = '$CuentaContable_idCuentaContable[$num_elementos]', `CuentaCorriente_idCuentaCorriente` = '$CuentaCorriente_idCuentaCorriente[$num_elementos]', `tipoMovimiento` = '$tipoMovimiento[$num_elementos]', `CentroCosto_idCentroCosto` = '$CentroCosto_idCentroCosto[$num_elementos]', `importe` = '$importeDebito[$num_elementos]+$importeCredito[$num_elementos]' ,`tasaCambio` = '$tasaCambio[$num_elementos]', `tasaCambioBases` = '$tasaCambioBases[$num_elementos]', `concepto` = '$concepto[$num_elementos]', `tipoComprobante` = '$tipoComprobante[$num_elementos]' ,`nroComprobante` = '$nroComprobante[$num_elementos]',`Banco_idBanco` = '$Banco_idBanco[$num_elementos]',`nroCheque` = '$nroCheque[$num_elementos]'   
												WHERE `idAsientoDetalle` = '$idAsientoDetalle[$num_elementos]' and `Asiento_idAsiento` = '$idAsiento'";
							ejecutarConsulta($sql_detalle) or $sw = false;	*/			
							$num_elementos=$num_elementos + 1;
						}
					}
		}
		
		return $sw;		 
	}

	//Implementamos un método para eliminar categorías
	public function activar($idAsiento)
	{
		$sql="UPDATE asiento set inactivo = 0 WHERE idAsiento='$idAsiento'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para eliminar categorías
	public function desactivar($idAsiento)
	{
		$sql="UPDATE asiento set inactivo = 1 WHERE idAsiento='$idAsiento'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idAsiento)
	{
		$sql="SELECT * FROM asiento WHERE idAsiento='$idAsiento'";
		return ejecutarConsultaSimpleFila($sql);
	}
	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT a.idAsiento,b.ano,c.descripcion,a.fechaAsiento,a.fechaPlanilla,a.transaccionOrigen,a.nroOrigen,a.inactivo
			  from asiento a, proceso b, moneda c
			  where a.Proceso_idProceso=b.idProceso and a.Moneda_idMoneda=c.idMoneda";
		return ejecutarConsulta($sql);		
	}

 	//Implementar un método para reporte de Asiento
	public function rpt_asiento_cabecera($fi,$ff)
	{
		$sql="SELECT a.idAsiento,b.ano,c.descripcion,a.fechaAsiento,a.fechaPlanilla,a.transaccionOrigen,a.nroOrigen,a.inactivo
			  from asiento a, proceso b, moneda c
			  where a.Proceso_idProceso=b.idProceso and a.Moneda_idMoneda=c.idMoneda and a.idAsiento='$idAsiento'";
		return ejecutarConsulta($sql);		
	} 
    
	public function listarDetalleAsiento($idAsiento) 
	{
		$sql="SELECT a.idAsientoDetalle,a.item,b.descripcion as CuentaContableDesc,c.idCuentaCorriente,c.descripcion as CuentaCorrienteDesc,a.tipoMovimiento,(CASE tipoMovimiento
         WHEN 1 THEN 'Debito'
         ELSE 'Credito'
      END) as tipoMovimientoDesc,d.idCentroCosto,d.descripcion as CentroCostoDesc,
      (CASE tipoMovimiento
			         WHEN 1 THEN importe
			         ELSE 0 
			      	 END) as importeDebito,
        (CASE tipoMovimiento
			         WHEN 2 THEN importe
			         ELSE 0 
			      	 END) as importeCredito, 
		e.idBanco,e.descripcion as Banco_idBancoDesc,a.nroCheque,a.tasaCambio,a.tasaCambioBases,a.Concepto_idConcepto,f.descripcion as Concepto_idConceptoDesc,a.nroComprobante,a.tipoComprobante,
		 (select sum(importe) from asientodetalle  where  Asiento_idAsiento=a.Asiento_idAsiento and  tipoMovimiento=1 and inactivo=0) as totalDebito ,
         (select sum(importe) from asientodetalle  where  Asiento_idAsiento=a.Asiento_idAsiento and  tipoMovimiento=2 and inactivo=0) as totalCredito 
		from asientodetalle a 
        left outer join cuentacontable b on a.CuentaContable_idCuentaContable = b.idCuentaContable 
		left outer join cuentacorriente c on  a.CuentaCorriente_idCuentaCorriente=c.idCuentaCorriente
        left outer join centrocosto d on  a.CentroCosto_idCentroCosto=d.idCentroCosto    
		left outer join banco e on a.Banco_idBanco=e.idBanco
		left outer join concepto f on a.Concepto_idConcepto=f.idConcepto	
		where a.Asiento_idAsiento = '$idAsiento' and a.inactivo = 0  ";
		return ejecutarConsulta($sql);	 	
	}	


	public function rpt_asiento_detalleDiario($fi,$ff,$ci,$cf)    
	{
		if ($ci == 'null' && $cf == 'null'){	
			$sql="SELECT e.fechaAsiento,a.Asiento_idAsiento,a.item,c.idCuentaContable,c.descripcion as CuentaContableDesc,comentario,(CASE tipoMovimiento
			         WHEN 1 THEN importe
			         ELSE 0
			      	 END) as Debito,
			      	(CASE tipoMovimiento
			         WHEN 2 THEN importe
			         ELSE 0
			      	 END) as Credito
				from asientodetalle a
				join asiento e on a.Asiento_idAsiento=e.idAsiento and e.inactivo=0
				left outer join proceso b on a.Proceso_idProceso=b.idProceso
				left outer join cuentacontable c on a.CuentaContable_idCuentaContable=c.idCuentaContable
				left outer join cuentacorriente d on a.CuentaCorriente_idCuentaCorriente=d.idCuentaCorriente
				where e.fechaAsiento between '$fi' and '$ff' and a.inactivo=0";	
				return ejecutarConsulta($sql);
		}else{
				$sql="SELECT e.fechaAsiento,a.Asiento_idAsiento,a.item,c.idCuentaContable,c.descripcion as CuentaContableDesc,comentario,(CASE tipoMovimiento
			         WHEN 1 THEN importe
			         ELSE 0
			      	 END) as Debito,
			      	(CASE tipoMovimiento
			         WHEN 2 THEN importe
			         ELSE 0
			      	 END) as Credito
				from asientodetalle a
				join asiento e on a.Asiento_idAsiento=e.idAsiento and e.inactivo=0
				left outer join proceso b on a.Proceso_idProceso=b.idProceso
				left outer join cuentacontable c on a.CuentaContable_idCuentaContable=c.idCuentaContable
				left outer join cuentacorriente d on a.CuentaCorriente_idCuentaCorriente=d.idCuentaCorriente
				where e.fechaAsiento between '$fi' and '$ff' and a.inactivo=0 and c.idCuentaContable between '$ci' and '$cf' ";	
				return ejecutarConsulta($sql);	
		}	 	
	}	

	public function rpt_asiento_detalleMayor($fi,$ff,$ci,$cf)   
	{
		if ($ci == 'null' && $cf == 'null'){	
			$sql="SELECT c.idCuentaContable,e.fechaAsiento,e.idAsiento,concat(c.idCuentaContable,'-',c.descripcion) as CuentaContableDesc,comentario,SUM(CASE tipoMovimiento
			         WHEN 1 THEN importe
			         ELSE 0
			      	 END) as Debito,
			      	SUM(CASE tipoMovimiento
			         WHEN 2 THEN importe
			         ELSE 0 
			      	 END) as Credito
				from asientodetalle a
				join asiento e on a.Asiento_idAsiento=e.idAsiento and e.inactivo=0
				join cuentacontable c on a.CuentaContable_idCuentaContable=c.idCuentaContable
				where e.fechaAsiento between '$fi' and '$ff' and a.inactivo=0
                group by c.idCuentaContable,e.fechaAsiento,e.idAsiento,concat(c.idCuentaContable,'-',c.descripcion),comentario
                order by c.idCuentaContable,e.fechaAsiento,e.idAsiento,concat(c.idCuentaContable,'-',c.descripcion),comentario";	
				return ejecutarConsulta($sql);
		}else{
				$sql="SELECT c.idCuentaContable,e.fechaAsiento,e.idAsiento,concat(c.idCuentaContable,'-',c.descripcion) as CuentaContableDesc,comentario,SUM(CASE tipoMovimiento
			         WHEN 1 THEN importe
			         ELSE 0
			      	 END) as Debito,
			      	SUM(CASE tipoMovimiento
			         WHEN 2 THEN importe
			         ELSE 0
			      	 END) as Credito
				from asientodetalle a
				join asiento e on a.Asiento_idAsiento=e.idAsiento and e.inactivo=0
				join cuentacontable c on a.CuentaContable_idCuentaContable=c.idCuentaContable
				where e.fechaAsiento between '$fi' and '$ff' and a.inactivo=0 and c.idCuentaContable between '$ci' and '$cf'
                group by c.idCuentaContable,e.fechaAsiento,e.idAsiento,concat(c.idCuentaContable,'-',c.descripcion),comentario
                order by c.idCuentaContable,e.fechaAsiento,e.idAsiento,concat(c.idCuentaContable,'-',c.descripcion),comentario ";	
				return ejecutarConsulta($sql);	
		} 	
	}	

	//Implementar un método para listar los registros 
	public function listarc()
	{
		$sql="SELECT * FROM asiento ";
		return ejecutarConsulta($sql);		
	}

	public function selectCuentaCorriente()
	{
		$sql="SELECT * from cuentacorriente"; 
		return ejecutarConsulta($sql);		
	}

	//Implementamos un método para desactivar registros
	public function desactivarDetalleAsiento($idAsientoDetalle)
	{
		$sql="UPDATE asientodetalle SET inactivo = 1 WHERE idAsientoDetalle='$idAsientoDetalle'";
		return ejecutarConsulta($sql);
	}

}

?>