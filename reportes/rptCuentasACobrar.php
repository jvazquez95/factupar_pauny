<?php

	include 'plantillaCuentasACobrar.php';

	$pdf = new PDF('P','mm','A4');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','',6);  

	$rpt = new Venta();  
	$rspta = $rpt->rpt_cuentas_a_cobrar($_GET['fechai'],$_GET['fechaf'],$_GET['cliente'],$_GET['orden']); 
	$total = 0;
	$fila1 = 0;
	$saldoInicial = 0; 
	$pdf->SetFont('Arial','',14);  
	$pdf->Cell(10,10,"Facturas a credito");
	while($row = $rspta->fetchObject())  
	{
		
		$idPersona=$row->razonSocial;   
		if ($idPersona!=$idPersonaAnterior)   
		{

			if ($total>0){
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(25,6,'Saldo Total:',1,0,'R',0); 
				$pdf->Cell(25,6,number_format($totalM, 0, ',', '.').' Gs',1,0,'C');
				$pdf->Cell(17,6,'Cantidad:',1,0,'R',0); 
				$pdf->Cell(21,6,number_format($total, 0, ',', '.').' Cuotas',1,0,'C');
				$pdf->Ln(8);
				$pdf->AddPage();								
			} 

			$pdf->Ln(8);
			$pdf->SetFillColor(232,232,232);	
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(50,6,'Razon Social',1,0,'C',1);
			$pdf->Cell(38,6,'Documento',1,1,'C',1); 			
			$pdf->Cell(50,6,substr(utf8_decode($row->razonSocial), 0, 20),1,0,'C');	
			$pdf->Cell(38,6,($row->nroDocumento),1,1,'C');
			$pdf->SetFillColor(232,232,232);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(25,6,'Fecha de Factura',1,0,'C',1);
			$pdf->Cell(25,6,'Fecha Venc',1,0,'C',1); 
			$pdf->Cell(38,6,'Nro Factura',1,0,'C',1); 
			$pdf->Cell(10,6,'Cuota',1,0,'C',1);
			$pdf->Cell(25,6,'Monto',1,0,'C',1);
			$pdf->Cell(25,6,'Saldo',1,1,'C',1); 	  	 

		} 
		$total = $total + 1;
		$totalM = $totalM + $row->saldo; 
		$pdf->SetFont('Arial','',8);
		$date=date_create($row->fechaFactura);
		$fechanueva = date_format($date,"d-m-Y");

		$date=date_create($row->fvc);
		$fechanueva2 = date_format($date,"d-m-Y");

		$pdf->Cell(25,6,substr(utf8_decode($fechanueva), 0, 20),0,0,'C');
		$pdf->Cell(25,6,substr(utf8_decode($fechanueva2), 0, 20),0,0,'C');
		$pdf->Cell(38,6,$row->serie."-".substr(utf8_decode($row->nroFactura), 0, 20),0,0,'C');
		$pdf->Cell(10,6,number_format($row->nroCuota, 0, ',', '.'),0,0,'R');
		$pdf->Cell(25,6,number_format($row->monto, 0, ',', '.'),0,0,'R');
		$pdf->Cell(25,6,number_format($row->saldo, 0, ',', '.'),0,1,'R');
		
		$idPersonaAnterior=$row->razonSocial;    
	}
 
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(25,6,'Saldo Total:',1,0,'R',0); 
	$pdf->Cell(25,6,number_format($totalM, 0, ',', '.').' Gs',1,0,'C');
	// $pdf->Cell(17,6,'Cantidad:',1,0,'R',0); 
	// $pdf->Cell(21,6,number_format($total, 0, ',', '.').' Cuotas',1,1,'C');	 

	$rpt = new Venta();  
	$rspta = $rpt->rpt_remisiones_pendientes($_GET['fechai'],$_GET['fechaf'],$_GET['cliente'],$_GET['orden']); 
	$total = 0;
	$fila1 = 0;
	$saldoInicial = 0; 

	// $pdf->SetFont('Arial','',14);  
	// $pdf->Cell(40,10,"Facturas con Remisiones Pendientes");

	// while($row = $rspta->fetchObject())  
	// {
		
	// 	$idPersona=$row->razonSocial;   
	// 	if ($idPersona!=$idPersonaAnterior)   
	// 	{

	// 		if ($total>0){
	// 			$pdf->SetFont('Arial','B',8);
	// 			$pdf->Cell(25,6,'Saldo Total:',1,0,'R',0); 
	// 			$pdf->Cell(25,6,number_format($totalM, 0, ',', '.').' Gs',1,0,'C');
	// 			$pdf->Cell(17,6,'Cantidad:',1,0,'R',0); 
	// 			$pdf->Cell(21,6,number_format($total, 0, ',', '.').' Cuotas',1,0,'C');
	// 			$pdf->Ln(8);
	// 			$pdf->AddPage();								
	// 		} 

	// 		$pdf->Ln(8);
	// 		$pdf->SetFillColor(232,232,232);	
	// 		$pdf->SetFont('Arial','B',8);
	// 		// $pdf->Cell(50,6,'Razon Social',1,0,'C',1);
	// 		// $pdf->Cell(38,6,'Documento',1,1,'C',1); 			
	// 		// $pdf->Cell(50,6,substr(utf8_decode($row->razonSocial), 0, 20),1,0,'C');	
	// 		// $pdf->Cell(38,6,number_format($row->nroDocumento, 0, ',', '.'),1,1,'C');
	// 		$pdf->SetFillColor(232,232,232);
	// 		$pdf->SetFont('Arial','B',8);
	// 		$pdf->Cell(25,6,'Fecha de Factura',1,0,'C',1);
	// 		$pdf->Cell(38,6,'Nro Factura',1,0,'C',1); 
	// 		$pdf->Cell(50,6,'Item',1,0,'C',1);
	// 		$pdf->Cell(30,6,'Cantidad Adquirida',1,0,'C',1);
	// 		$pdf->Cell(50,6,'Cantidad Pendiente de Remision',1,1,'C',1); 	  	 

	// 	} 
	// 	$total = $total + 1;
	// 	$totalM = $totalM + $row->saldo; 
	// 	$pdf->SetFont('Arial','',8);
	// 	$date=date_create($row->fechaFactura);
	// 	$fechanueva2 = date_format($date,"d-m-Y");
	// 	$pdf->Cell(25,6,substr(utf8_decode($fechanueva2), 0, 20),0,0,'C');
	// 	$pdf->Cell(38,6,$row->serie."-".substr(utf8_decode($row->nroFactura), 0, 20),0,0,'C');
	// 	$pdf->Cell(50,6,utf8_decode($row->descripcion),0,0,'R');
	// 	$pdf->Cell(30,6,number_format($row->cantidad, 0, ',', '.'),0,0,'R');
	// 	$pdf->Cell(25,6,number_format($row->cantidadRemision, 0, ',', '.'),0,1,'R');
		
	// 	$idPersonaAnterior=$row->razonSocial;    
	// }
 
	// // $pdf->SetFont('Arial','B',8);
	// // $pdf->Cell(25,6,'Saldo Total:',1,0,'R',0); 
	// // $pdf->Cell(25,6,number_format($totalM, 0, ',', '.').' Gs',1,0,'C');
	// // $pdf->Cell(17,6,'Cantidad:',1,0,'R',0); 
	// // $pdf->Cell(21,6,number_format($total, 0, ',', '.').' Cuotas',1,0,'C');	



	$pdf->Output(); 
?>