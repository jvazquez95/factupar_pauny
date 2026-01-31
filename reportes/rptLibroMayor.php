<?php

	include 'plantillaLibroMayor.php';

	$pdf = new PDF('P','mm','A4');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','',6); 

	$rpt = new Asiento();
	$rspta = $rpt->rpt_asiento_detalleMayor($_GET['fi'],$_GET['ff'],$_GET['ci'],$_GET['cf']);
	$total = 0;
	$fila1 = 0;
	$saldo = 0;  
	$idCuentaContableAnterior=0;  

	while($row = $rspta->fetchObject())   
	{
		$idCuentaContable=$row->idCuentaContable;
		if ($idCuentaContable!=$idCuentaContableAnterior)
		{
			if ($idCuentaContableAnterior!=0){
				$pdf->Cell(141,6,substr(' ', 0, 20),0,0,'C'); 	
				$pdf->Cell(27,6,number_format($saldo, 0, ',', '.'),1,1,'R');
				$saldo=0; 
				$pdf->AddPage(); 
			}
			$pdf->Cell(40,6,substr(utf8_decode($row->CuentaContableDesc), 0, 40),1,1,'L');
			$pdf->Cell(40,6,'',0,0,'L');
			$total = $total + 1;	
		}else{
			$pdf->Cell(40,6,'',0,0,'L');
		}
		
		
		$saldo = $saldo + ( $row->Debito - $row->Credito );	
		$pdf->Cell(12,6,substr(utf8_decode($row->fechaAsiento), 0, 20),0,0,'C');
		$pdf->Cell(12,6,number_format($row->idAsiento, 0, ',', '.'),0,0,'R');
		$pdf->Cell(37,6,substr(utf8_decode($row->comentario), 0, 37),0,0,'C'); 
 		$pdf->Cell(20,6,number_format($row->Debito, 0, ',', '.'),0,0,'R');
 		$pdf->Cell(20,6,number_format($row->Credito, 0, ',', '.'),0,0,'R'); 
		$pdf->Cell(27,6,number_format($saldo, 0, ',', '.'),0,1,'R');
		$idCuentaContableAnterior=$row->idCuentaContable; 	
 
	}
	$pdf->Cell(141,6,substr(' ', 0, 20),0,0,'C');
	$pdf->Cell(27,6,number_format($saldo, 0, ',', '.'),1,1,'R');
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(17,6,'Cantidad:',1,0,'R',0); 
	$pdf->Cell(37,6,number_format($total, 0, ',', '.').' Cuentas Contables',1,1,'C');

	$pdf->Output();
?>