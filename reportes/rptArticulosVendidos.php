<?php

	include 'plantillaArticulosVendidos.php';
	require_once "../modelos/Consultas.php";


	
	$pdf = new PDF('P','mm','A4');
	$pdf->AliasNbPages();
	$pdf->AddPage();

	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(25,6,'Id articulo',1,0,'C',1);
	$pdf->Cell(100,6,'Descripcion',1,0,'C',1);
	$pdf->Cell(60,6,'Cantidad vendida',1,1,'C',1);

	
	$pdf->SetFont('Arial','',6);
	$rpt = new Consultas();

	$rspta = $rpt->articulos_vendidos();
	while($row = $rspta->fetchObject())
	{

		$pdf->Cell(25,6,utf8_decode($row->Articulo_idArticulo),1,0,'C');
		$pdf->Cell(100,6,utf8_decode($row->n),1,0,'C');
		$pdf->Cell(60,6,utf8_decode($row->cantidad),1,1,'C');

	}
	$pdf->Output();
?>