<?php

	include 'plantillaComisionesEmpleado.php';
	require_once "../modelos/Consultas.php";
	//session_start();
	$lidEmpleado = $_SESSION['idEmpleado'];

	
	$pdf = new PDF('L','mm','A4');
	$pdf->AliasNbPages();
	$pdf->AddPage();

	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(25,6,'Fecha - Hora',1,0,'C',1);
	$pdf->Cell(30,6,'Cliente',1,0,'C',1);
	$pdf->Cell(80,6,'Paquete',1,0,'C',1);
	$pdf->Cell(80,6,'Servicio',1,0,'C',1);
	$pdf->Cell(20,6,'CREDITOS',1,0,'C',1);
	$pdf->Cell(20,6,'DEBITOS',1,0,'C',1);
	$pdf->Cell(20,6,'TOTAL',1,1,'C',1);

	
	$pdf->SetFont('Arial','',6);
	$rpt = new Consultas();

	$rspta = $rpt->rpt_empleado_comisiones($lidEmpleado,$_GET['fi'],$_GET['ff']);
	$total = 0;
	$fila1 = 0;
	$saldoInicial = 0;
	while($row = $rspta->fetchObject())
	{
		if ($fila1 == 0) {
			$saldoInicial = $row->importe;
			$fila1++;
		}
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
		$pdf->Cell(30,6,substr(utf8_decode($row->nc), 0, 20),1,0,'C');
		$pdf->Cell(80,6,substr(utf8_decode($paquete), 0, 58),1,0,'C');			
		$pdf->Cell(80,6,substr(utf8_decode($row->servicio), 0, 58),1,0,'C');	
		$pdf->Cell(20,6,utf8_decode(number_format($montoi, 0, ',', '.')),1,0,'C');						
		$pdf->Cell(20,6,utf8_decode(number_format($montoe, 0, ',', '.')),1,0,'C');						
		$pdf->Cell(20,6,utf8_decode(number_format($total = $total + ($montoi - $montoe), 0, ',', '.')),1,1,'C');						
	}



	$pdf->SetFont('Arial','B',8);

	$pdf->Cell(25,6,'Total Acumulado',1,0,'C',1);
	$pdf->Cell(25,6,number_format($total, 0, ',', '.').' Gs.',1,0,'C');
	$pdf->Cell(25,6,'Total por fecha',1,0,'C',1);
	$pdf->Cell(25,6,number_format($total - $saldoInicial, 0, ',', '.').' Gs.',1,0,'C');



	$pdf->Output();
?>