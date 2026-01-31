<?php

	include 'plantillaArqueo.php';
	require_once "../modelos/Consultas.php";
	require_once "../modelos/Movimiento.php";


	
	$pdf = new PDF('P','mm','A4');
	$pdf->AliasNbPages();
	$pdf->AddPage();


	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(0,6, 'DETALLE DE PRODUCTOS COMPRADOS',0,1,'C');
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(20,5,'CANTIDAD',1,0,'C',1);
	$pdf->Cell(90,5,'ARTICULO',1,0,'C',1);
	$pdf->Cell(20,5,'MONEDA',1,0,'C',1);	
	$pdf->Cell(30,5,'TOTAL',1,0,'C',1);
	$pdf->Cell(30,5,'TOTAL GS',1,1,'C',1);
	
	$pdf->SetFont('Arial','',11);
	$rpt = new Consultas();




	$rspta = $rpt->rpt_aruqeo_caja_compra($_GET['habilitacion']);
	$t_dpc = 0;
	while($row = $rspta->fetchObject())
	{
		$t_dpc = $t_dpc + $row->TotalGs;
		$pdf->Cell(20,5,utf8_decode($row->Cantidad_X_Articulo),1,0,'C');
		$pdf->Cell(90,5,utf8_decode($row->descripcion),1,0,'C');
		$pdf->Cell(20,5,utf8_decode($row->moneda),1,0,'C');
		$pdf->Cell(30,5,number_format($row->Total,0,',','.'),1,0,'C');
		$pdf->Cell(30,5,number_format($row->TotalGs,0,',','.'),1,1,'C');			
	}
		$pdf->Cell(130,5,utf8_decode('***'),1,0,'C');
		$pdf->Cell(30,5,utf8_decode('TOTAL GS'),1,0,'C');
		$pdf->Cell(30,5,number_format($t_dpc,0,',','.'),1,1,'C');			



	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(0,6, 'DETALLE DE PRODUCTOS VENDIDOS',0,1,'C');
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(20,5,'CANTIDAD',1,0,'C',1);
	$pdf->Cell(90,5,'ARTICULO',1,0,'C',1);
	$pdf->Cell(20,5,'MONEDA',1,0,'C',1);
	$pdf->Cell(30,5,'TOTAL',1,0,'C',1);
	$pdf->Cell(30,5,'TOTAL GS',1,1,'C',1);
	
	$pdf->SetFont('Arial','',11);
	$rpt = new Consultas();

	$rspta = $rpt->rpt_aruqeo_caja_venta($_GET['habilitacion']);
	$t_dpc = 0;
	while($row = $rspta->fetchObject())
	{
		$usuario = $row->usuario;
		$t_dpc = $t_dpc + $row->TotalGs;
		$pdf->Cell(20,5,utf8_decode($row->Cantidad_X_Articulo),1,0,'C');
		$pdf->Cell(90,5,utf8_decode($row->descripcion),1,0,'C');
		$pdf->Cell(20,5,utf8_decode($row->moneda),1,0,'C');
		$pdf->Cell(30,5,number_format($row->Total,0,',','.'),1,0,'C');			
		$pdf->Cell(30,5,number_format($row->TotalGs,0,',','.'),1,1,'C');			
	
	}
		$pdf->Cell(130,5,utf8_decode('***'),1,0,'C');
		$pdf->Cell(30,5,utf8_decode('TOTAL GS'),1,0,'C');
		$pdf->Cell(30,5,number_format($t_dpc,0,',','.'),1,1,'C');			



	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(0,6, 'MOVIMIENTO DE INGRESOS',0,1,'C');
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(20,5,'NRO',1,0,'C',1);
	$pdf->Cell(30,5,'CONCEPTO',1,0,'C',1);
	$pdf->Cell(60,5,'DESRIPCION',1,0,'C',1);
	$pdf->Cell(20,5,'MONEDA',1,0,'C',1);
	$pdf->Cell(30,5,'TOTAL',1,0,'C',1);
	$pdf->Cell(30,5,'TOTAL GS',1,1,'C',1);
	
	$pdf->SetFont('Arial','',11);
	$rpt = new Consultas();

	$rspta = $rpt->rpt_aruqeo_caja_movimiento_ingreso($_GET['habilitacion']);
	$t_mi = 0;
	while($row = $rspta->fetchObject())
	{
		$t_mi = $t_mi + $row->TotalGs;

		$pdf->Cell(20,5,utf8_decode($row->idMovimiento),1,0,'C');
		$pdf->Cell(30,5,utf8_decode($row->Descripcion),1,0,'C');
		$pdf->Cell(60,5,utf8_decode($row->md),1,0,'C');
		$pdf->Cell(20,5,utf8_decode($row->moneda),1,0,'C');
		$pdf->Cell(30,5,number_format($row->Total,0,',','.'),1,0,'C');
		$pdf->Cell(30,5,number_format($row->TotalGs,0,',','.'),1,1,'C');			
	}

		$pdf->Cell(130,5,utf8_decode('***'),1,0,'C');
		$pdf->Cell(30,5,utf8_decode('TOTAL Gs'),1,0,'C');
		$pdf->Cell(30,5,number_format($t_mi,0,',','.'),1,1,'C');	


	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(0,6, 'MOVIMIENTO DE EGRESOS - GASTOS EXTRAORDINARIOS',0,1,'C');
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(20,5,'NRO',1,0,'C',1);
	$pdf->Cell(30,5,'CONCEPTO',1,0,'C',1);
	$pdf->Cell(60,5,'DESRIPCION',1,0,'C',1);
	$pdf->Cell(20,5,'MONEDA',1,0,'C',1);
	$pdf->Cell(30,5,'TOTAL',1,0,'C',1);
	$pdf->Cell(30,5,'TOTAL GS',1,1,'C',1);
	
	$pdf->SetFont('Arial','',11);
	$rpt = new Consultas();

	$rspta = $rpt->rpt_aruqeo_caja_movimiento_egreso($_GET['habilitacion']);
	$t_me = 0;
	while($row = $rspta->fetchObject())
	{
		$t_me = $t_me + $row->TotalGs;

		$pdf->Cell(20,5,utf8_decode($row->idMovimiento),1,0,'C');
		$pdf->Cell(30,5,utf8_decode($row->Descripcion),1,0,'C');
		$pdf->Cell(60,5,utf8_decode($row->md),1,0,'C');
		$pdf->Cell(20,5,utf8_decode($row->moneda),1,0,'C');	
		$pdf->Cell(30,5,number_format($row->Total,0,',','.'),1,0,'C');
		$pdf->Cell(30,5,number_format($row->TotalGs,0,',','.'),1,1,'C');			
	}

		$pdf->Cell(130,5,utf8_decode('***'),1,0,'C');
		$pdf->Cell(30,5,utf8_decode('TOTAL GS'),1,0,'C');
		$pdf->Cell(30,5,number_format($t_me,0,',','.'),1,1,'C');


	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(0,6, 'PAGOS A PROVEEDORES',0,1,'C');
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(20,5,'PAGOID.',1,0,'C',1);
	$pdf->Cell(25,5,'FECHA',1,0,'C',1);
	$pdf->Cell(65,5,'PROVEEDOR',1,0,'C',1);	
	$pdf->Cell(20,5,'MONEDA',1,0,'C',1);
	$pdf->Cell(30,5,'TOTAL',1,0,'C',1);
	$pdf->Cell(30,5,'TOTAL GS',1,1,'C',1);
	
	$pdf->SetFont('Arial','',11);
	$rpt = new Consultas();

	$rspta = $rpt->rpt_pagos_detalle($_GET['habilitacion']);
	$t_pd = 0;
	while($row = $rspta->fetchObject())
	{
		$t_pd = $t_pd + $row->TOTALGs;
		$pdf->Cell(20,5,utf8_decode($row->IDPAGO),1,0,'C');
		$pdf->Cell(25,5,utf8_decode($row->FECHAPAGO),1,0,'C');
		$pdf->Cell(65,5,utf8_decode($row->razonSocial),1,0,'C');
		$pdf->Cell(20,5,($row->dm),1,0,'C');
		$pdf->Cell(30,5,number_format($row->TOTAL),1,0,'C');
		$pdf->Cell(30,5,number_format($row->TOTALGs),1,1,'C');					
	}

	$pdf->Cell(130,5,utf8_decode('***'),1,0,'C');
	$pdf->Cell(30,5,utf8_decode('TOTAL GS'),1,0,'C');
	$pdf->Cell(30,5,number_format($t_pd,0,',','.'),1,1,'C');


	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(0,6, 'COBROS DEL DIA A CLIENTES( CONTADO - A CUENTA )',0,1,'C'); 
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(20,5,'RECIBOID',1,0,'C',1);
	$pdf->Cell(20,5,'FECHA',1,0,'C',1);
	$pdf->Cell(65,5,'CLIENTE',1,0,'C',1);
	$pdf->Cell(25,5,'MONEDA',1,0,'C',1);
	$pdf->Cell(30,5,'TOTAL',1,0,'C',1);
	$pdf->Cell(30,5,'TOTAL GS',1,1,'C',1);

	$pdf->SetFont('Arial','',11);
	$rpt = new Consultas();

	$rspta = $rpt->rpt_recibos_detalle($_GET['habilitacion']);
	$t_rd = 0;
	while($row = $rspta->fetchObject())
	{
		$date=date_create($row->FECHARECIBO);
		$fechanueva = date_format($date,"d-m-Y");
		$t_rd = $t_rd + $row->TOTALGS;
		$fecha_hab = $fechanueva;
		$pdf->Cell(20,5,utf8_decode($row->IDRECIBO),1,0,'C');
		$pdf->Cell(20,5,utf8_decode($fechanueva),1,0,'C');
		$pdf->Cell(65,5,utf8_decode($row->razonSocial),1,0,'C');
		$pdf->Cell(25,5,utf8_decode($row->moneda),1,0,'C');
		$pdf->Cell(30,5,number_format($row->TOTAL),1,0,'R');	
		$pdf->Cell(30,5,number_format($row->TOTALGS),1,1,'R');		
	}
	$pdf->SetFillColor(0,0,255);

	$pdf->Cell(130,5,utf8_decode('***'),1,0,'C');
	$pdf->Cell(30,5,utf8_decode('TOTAL GS'),1,0,'C'); 
	$pdf->Cell(30,5,number_format($t_rd,0,',','.'),1,1,'R');


	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(0,6, 'DETALLE DE PAGOS A PROVEEDORES',0,1,'C');
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(30,5,'TIPO DE PAGO',1,0,'C',1);
	$pdf->Cell(30,5,'MONEDA',1,0,'C',1);
	$pdf->Cell(30,5,'TOTAL',1,0,'C',1);
	$pdf->Cell(30,5,'TOTAL GS',1,0,'C',1);
	$pdf->Cell(30,5,'-',1,1,'C',1);
	
	$pdf->SetFont('Arial','',11);
	$rpt = new Consultas();


	$rspta = $rpt->rpt_arqueo_caja_pago($_GET['habilitacion']);
	$t_ace = 0;
	$total_efectivoe=0;

	while($row = $rspta->fetchObject())
	{
		$t_ace = $t_ace + $row->total;
		$pdf->Cell(30,5,$row->id.' - '.utf8_decode($row->descripcion),1,0,'C');
		$pdf->Cell(30,5,utf8_decode($row->moneda),1,0,'C');
		$pdf->Cell(30,5,number_format($row->total,0,',','.'),1,0,'C');
		$pdf->Cell(30,5,number_format($row->totalGs,0,',','.'),1,0,'C');
		$pdf->Cell(30,5,utf8_decode('-'),1,1,'C');	
		if ($row->id == '5') {
            $total_efectivoe = $total_efectivoe +  $row->total;
        }		
	}

//		$pdf->Cell(30,5,utf8_decode('Total'),1,0,'C');
//		$pdf->Cell(30,5,number_format($t_ace,0,',','.'),1,0,'C');
//		$pdf->Cell(30,5,utf8_decode('-'),1,1,'C');

	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(0,6, 'DETALLE DE COBROS A CLIENTES(CONTADO - A CUENTA)',0,1,'C');
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(30,5,'TIPO DE PAGO',1,0,'C',1);
	$pdf->Cell(30,5,'MONEDA',1,0,'C',1);
	$pdf->Cell(30,5,'TOTAL',1,0,'C',1);
	$pdf->Cell(30,5,'TOTAL Gs',1,1,'C',1);
	// $pdf->Cell(30,5,'-',1,1,'C',1);
	
	$pdf->SetFont('Arial','',11);
	$rpt = new Consultas();

	$rspta = $rpt->rpt_arqueo_caja($_GET['habilitacion']);
	$t_aci = 0;
	$total_efectivoi=0;
	while($row = $rspta->fetchObject())
	{
		$t_aci = $t_aci + $row->total;

		$pdf->Cell(30,5,$row->id.' - '.utf8_decode($row->descripcion),1,0,'C');
		$pdf->Cell(30,5,utf8_decode($row->moneda),1,0,'C');
		$pdf->Cell(30,5,number_format($row->total,0,',','.'),1,0,'C');
		$pdf->Cell(30,5,number_format($row->totalgs,0,',','.'),1,1,'C');
		// $pdf->Cell(30,5,utf8_decode('-'),1,1,'C');	
		 if ($row->id == '5') {
            $total_efectivoi = $total_efectivoi +  $row->totalgs;
        }				
	}


	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(0,6, 'DETALLE DE COBROS A CLIENTES APERTURA POR DENOMINACION',0,1,'C');
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(30,5,'MONEDA',1,0,'C',1);
	$pdf->Cell(30,5,'DENOMINACION',1,0,'C',1);
	$pdf->Cell(30,5,'CANTIDAD',1,0,'C',1);
	$pdf->Cell(30,5,'TOTAL',1,1,'C',1);
	// $pdf->Cell(30,5,'-',1,1,'C',1);
	
	$pdf->SetFont('Arial','',11);
	$rpt = new Consultas();

	$rspta = $rpt->rpt_arqueo_caja_denominacion($_GET['habilitacion']);
	$t_aci = 0;
	$total_efectivoid=0;
	while($row = $rspta->fetchObject())
	{
		$t_aci = $t_aci + $row->total;

		$pdf->Cell(30,5,utf8_decode($row->moneda),1,0,'C');
		$pdf->Cell(30,5,utf8_decode($row->denominacion),1,0,'C');
		$pdf->Cell(30,5,number_format($row->cantidad,0,',','.'),1,0,'C');
		$pdf->Cell(30,5,number_format($row->denominacion*$row->cantidad,0,',','.'),1,1,'C');
		// $pdf->Cell(30,5,utf8_decode('-'),1,1,'C');	
            $total_efectivoid = $total_efectivoid +  ($row->denominacion*$row->cantidad);
            
	}	
	$pdf->cell(0,7,"Total Apertura: " .number_format($total_efectivoid,0,',','.'),0,1,'C');
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(0,6, 'DETALLE DE COBROS A CLIENTES CIERRE POR DENOMINACION',0,1,'C');
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(30,5,'MONEDA',1,0,'C',1);
	$pdf->Cell(30,5,'DENOMINACION',1,0,'C',1);
	$pdf->Cell(30,5,'CANTIDAD',1,0,'C',1);
	$pdf->Cell(30,5,'TOTAL',1,1,'C',1);
	// $pdf->Cell(30,5,'-',1,1,'C',1);
	
	$pdf->SetFont('Arial','',11);
	$rpt = new Consultas();

	$rspta = $rpt->rpt_arqueo_caja_denominacion($_GET['habilitacion']);
	$t_aci = 0;
	$total_efectivoed=0;
	while($row = $rspta->fetchObject())
	{
		$t_aci = $t_aci + $row->total;

		$pdf->Cell(30,5,utf8_decode($row->moneda),1,0,'C');
		$pdf->Cell(30,5,utf8_decode($row->denominacion),1,0,'C');
		$pdf->Cell(30,5,number_format($row->cantidadCierre,0,',','.'),1,0,'C');
		$pdf->Cell(30,5,number_format($row->totalCierre,0,',','.'),1,1,'C');
		// $pdf->Cell(30,5,utf8_decode('-'),1,1,'C');	
            $total_efectivoed = $total_efectivoed +  ($row->denominacion*$row->cantidadCierre);;
        			
	}
	$pdf->cell(0,7,"Total Cierre: " .number_format($total_efectivoed,0,',','.'),0,1,'C');

	//	$pdf->Cell(30,5,utf8_decode('Total'),1,0,'C');
	//	$pdf->Cell(30,5,number_format($t_aci,0,',','.'),1,0,'C');
	//	$pdf->Cell(30,5,utf8_decode('-'),1,1,'C');	

 

	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(0,6, 'RESUMEN',0,1,'C');
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(130,5,'DESCRIPCION',1,0,'C',1);
	$pdf->Cell(30,5,'TOTAL',1,1,'C',1);
	
	$pdf->SetFont('Arial','',11);
	$rpt = new Consultas();

	$t_pagado = $t_ace;
	$t_cobrado = $t_aci;
	$t_general = ($t_aci + $t_mi) - ($t_ace + $t_me);
	$t_efectivo =  ($total_efectivoi+$total_efectivoid) - ( $total_efectivoe );
	$balance =  $total_efectivoed - $t_efectivo;



	// $pdf->Cell(130,5,utf8_decode('TOTAL PAGADO (PAGOS A PROVEEDORES - SUMATORIA DE TODOS LOS TIPOS DE PAGOS)'),1,0,'C');
	// $pdf->Cell(30,5,number_format($t_pagado,0,',','.'),1,1,'C');			

	// $pdf->Cell(130,5,utf8_decode('TOTAL COBRADO (COBROS A CLIENTES - SUMATORIA DE TODOS LOS TIPOS DE PAGOS)'),1,0,'C');
	// $pdf->Cell(30,5,number_format($t_cobrado,0,',','.'),1,1,'C');

	// $pdf->Cell(130,5,utf8_decode('TOTAL GENERAL ((TOTAL PAGOS + TOTAL EGRESOS) + (TOTAL RECIBOS + TOTAL INGRESOS))'),1,0,'C');
	// $pdf->Cell(30,5,number_format($t_general,0,',','.'),1,1,'C');

	$pdf->Cell(130,5,utf8_decode('TOTAL EN EFECTIVO '),1,0,'C');
	$pdf->Cell(30,5,number_format($t_efectivo,0,',','.'),1,1,'C'); 
	

	$pdf->Cell(130,5,utf8_decode('TOTAL CAJA CHICA CIERRE'),1,0,'C');
	$pdf->Cell(30,5,number_format($total_efectivoed,0,',','.'),1,1,'C'); 

	if ($total_efectivoed-$t_efectivo < 0) {
		$texto = 'Caja chica con faltante';
		$r = '250';
		$g = '0';
		$b = '0';
		$pdf->SetDrawColor(250,0,0);
		$pdf->setTextColor(250,0,0);
	}

	if ($total_efectivoed-$t_efectivo == 0) {
		$texto = 'Caja chica ha balanceado correctamente';
		$r = '0';
		$g = '100';
		$b = '0';
		$pdf->SetDrawColor(0,100,0);
		$pdf->setTextColor(0,100,0);
	}

	if ($total_efectivoed-$t_efectivo > 0) {
		$texto = 'Caja chica con sobrante';
		$r = '255';
		$g = '0';
		$b = '255';
		$pdf->SetDrawColor(255,0,255);
		$pdf->setTextColor(255,0,255);
	}




	$pdf->Cell(130,5,utf8_decode('RESULTADO FINAL DEL EJERCICIO'),1,0,'C');
	$pdf->Cell(30,5,number_format($total_efectivoed-$t_efectivo,0,',','.'),1,1,'C'); 
	$pdf->Cell(130,5,$texto,1,1,'C'); 
	$pdf->Cell(130,5,'Usuario: '.$usuario. ' - Habilitacion: '.$_GET['habilitacion']. ' Fecha Habilitacion: '.$fecha_hab,1,1,'C'); 

	$pdf->Output();
?>