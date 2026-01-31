<?php

	include 'plantillaComisionesEmpleado.php';
	require_once "../modelos/Consultas.php";


	
	$pdf = new PDF('L','mm','A4');
	$pdf->AliasNbPages();
	$pdf->AddPage();

	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(25,6,'Fecha - Hora',1,0,'C',1);
	$pdf->Cell(30,6,'Cliente',1,0,'C',1);
	$pdf->Cell(60,6,'Paquete',1,0,'C',1);
	$pdf->Cell(35,6,'Servicio',1,0,'C',1);
	$pdf->Cell(20,6,'CREDITOS',1,0,'C',1);
	$pdf->Cell(20,6,'DEBITOS',1,0,'C',1);
	$pdf->Cell(20,6,'TOTAL',1,1,'C',1);

	
	$pdf->SetFont('Arial','',6);
	$rpt = new Consultas();

	$rspta = $rpt->rpt_empleado_comisiones($_GET['empleado']);
	$total = 0;
	while($row = $rspta->fetchObject())
	{
		if ($row->tipoMovimiento == 'I') {
			$tipo = 'INGRESO';
			$montoi = $row->importe;
			$montoe = 0;
		}else{
			$tipo = 'EGRESO';
			$montoe = $row->importe;
			$montoi = 0;
		}

		if ($row->paquete == '') {
			$paquete = 'SIN PAQUETE';
		}else{
			$paquete = $row->paquete;
		}


		$pdf->Cell(25,6,utf8_decode($row->fechaMovimiento),1,0,'C');
		$pdf->Cell(30,6,utf8_decode($row->nc),1,0,'C');
		$pdf->Cell(60,6,utf8_decode($paquete),1,0,'C');			
		$pdf->Cell(35,6,utf8_decode($row->servicio),1,0,'C');			
		$pdf->Cell(20,6,utf8_decode(number_format($montoi, 0, ',', '.')),1,0,'C');						
		$pdf->Cell(20,6,utf8_decode(number_format($montoe, 0, ',', '.')),1,0,'C');						
		$pdf->Cell(20,6,utf8_decode(number_format($total = $total + ($montoi - $montoe), 0, ',', '.')),1,1,'C');						
	}


	$pdf->Output();
?>