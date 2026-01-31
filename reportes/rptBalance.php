<?php

	include 'plantillaBalance.php';

	$pdf = new PDF('P','mm','A4');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','',6); 

	$rpt = new Consultas();
	$rspta = $rpt->balanceReporte($_GET['ci'],$_GET['cf'],$_GET['fi'],$_GET['ff']);
	$total = 0;
	$fila1 = 0;
	$saldo = 0;  
	$idCuentaContableAnterior=0;  
	$marca=0;
	while($row = $rspta->fetchObject())   
	{
		 
		$saldo = $saldo + ( $row->Debito - $row->Credito );	
		if ($row->nivel==0) {
			$pdf->SetFont('Arial','B',8);
			$marca=1;
		}else{
			if ($row->nivel==1) {
				$pdf->SetFont('Arial','B',7);
				$marca=0;
			}else{
				$pdf->SetFont('Arial','',6); 
				$marca=0;
			}
		}
		$pdf->Cell(60,6,substr(utf8_decode($row->cuentaContableDesc), 0, 60),$marca,0,'L');
		$pdf->SetFont('Arial','',6); 
		$pdf->Cell(24,6,substr(utf8_decode($row->nroCuentaContable), 0, 24),0,0,'C');
		$pdf->Cell(24,6,number_format($row->saldoAnterior, 0, ',', '.'),0,0,'R');
 		$pdf->Cell(24,6,number_format($row->saldoActual, 0, ',', '.'),0,0,'R');
 		$pdf->Cell(24,6,number_format($row->debito, 0, ',', '.'),0,0,'R'); 
		$pdf->Cell(24,6,number_format($credito, 0, ',', '.'),0,1,'R');
		$idCuentaContableAnterior=$row->idCuentaContable; 	
 
	}
	$pdf->Cell(141,6,substr(' ', 0, 20),0,0,'C');
	$pdf->Cell(27,6,number_format($saldo, 0, ',', '.'),1,1,'R');
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(17,6,'Cantidad:',1,0,'R',0); 
	$pdf->Cell(37,6,number_format($total, 0, ',', '.').' Cuentas Contables',1,1,'C');

	$pdf->Output();
?>