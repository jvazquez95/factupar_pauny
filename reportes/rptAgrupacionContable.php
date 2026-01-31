<?php

	include 'plantillaAgrupacionContable.php';

	$pdf = new PDF('P','mm','A4');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','',6); 

	$rpt = new Consultas();
	$rspta = $rpt->agrupacionCuentasContables($_GET['fi'],$_GET['ff'],$_GET['ci'],$_GET['cf']);
	$total = 0;
	$fila1 = 0;
	$saldo = 0;  
	$cantidad=0;  

	while($row = $rspta->fetchObject())   
	{
 
		$pdf->Cell(55,6,substr(utf8_decode($row->cuentaContableDesc), 0, 45),1,0,'C'); 
		$pdf->Cell(35,6,substr(utf8_decode($row->nroCuentaContable), 0, 25),1,0,'C'); 
		$pdf->Cell(12,6,number_format($row->nivel, 0, ',', '.'),1,0,'R');
 		$pdf->Cell(30,6,number_format($row->Debito, 0, ',', '.'),1,0,'R');
 		$pdf->Cell(30,6,number_format($row->Credito, 0, ',', '.'),1,1,'R'); 
 		$total = $total +  1;
 
	}
	$pdf->Cell(1,6,substr('', 0, 20),0,1,'C');
	$pdf->Cell(1,6,substr('', 0, 20),0,0,'C');

	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(32,6,'Cantidad de cuentas:',1,0,'R',0); 
	$pdf->Cell(7,6,number_format($total, 0, ',', '.').' ',1,1,'C');

	$pdf->Output();
?>