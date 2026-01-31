<?php

	include 'plantillaArticulosFecha.php';
	require_once "../modelos/Consultas.php";


	
	$pdf = new PDF('P','mm','A4');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(0,10, 'Total de articulos por fecha',0,1,'C');
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(120,6,'Nombre articulo',1,0,'C',1);
	$pdf->Cell(50,6,'Cantidad',1,1,'C',1);
	$pdf->SetFont('Arial','',7);
	$rpt = new Consultas();

	$rspta = $rpt->articulos_vendidos_fecha($_GET['fi'],$_GET['ff']);
	while($row = $rspta->fetchObject())
	{
		$pdf->Cell(120,6,utf8_decode($row->na),1,0,'C');
		$pdf->Cell(50,6,utf8_decode($row->cantidad),1,1,'C');
	}

	$pdf->Output();
?>