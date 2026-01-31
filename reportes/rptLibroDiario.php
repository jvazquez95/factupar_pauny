<?php

	include 'plantillaLibroDiario.php';

	$pdf = new PDF('P','mm','A4');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','',6);  

	$rpt = new Asiento();  
	$rspta = $rpt->rpt_asiento_detalleDiario($_GET['fi'],$_GET['ff'],$_GET['ci'],$_GET['cf']); 
	$total = 0;
	$fila1 = 0;
	$saldoInicial = 0;
	while($row = $rspta->fetchObject()) 
	{
		
		$idAsiento=$row->Asiento_idAsiento;   
		if ($idAsiento!=$idAsientoAnterior)   
		{
			$pdf->Cell(12,6,substr(utf8_decode($row->fechaAsiento), 0, 20),0,0,'C');
			$pdf->Cell(12,6,number_format($row->Asiento_idAsiento, 0, ',', '.'),0,0,'R');
			$total = $total + 1;	
		}else{
			$pdf->Cell(12,6,'',0,0,'L');
			$pdf->Cell(12,6,'',0,0,'L');
		}
		$idAsientoAnterior=$row->Asiento_idAsiento;
		$pdf->Cell(10,6,number_format($row->item, 0, ',', '.'),0,0,'R');
		$pdf->Cell(25,6,number_format($row->idCuentaContable, 0, ',', '.'),0,0,'R');
		$pdf->Cell(37,6,substr(utf8_decode($row->CuentaContableDesc), 0, 20),0,0,'C');
		$pdf->Cell(37,6,substr(utf8_decode($row->comentario), 0, 20),0,0,'C'); 
 		$pdf->Cell(27,6,substr(utf8_decode($row->Debito), 0, 20),0,0,'R');
 		$pdf->Cell(27,6,substr(utf8_decode($row->Credito), 0, 20),0,1,'R');
		
	}


	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(17,6,'Cantidad:',1,0,'R',0); 
	$pdf->Cell(27,6,number_format($total, 0, ',', '.').' Asientos',1,1,'C');

	$pdf->Output();
?>