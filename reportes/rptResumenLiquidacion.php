<?php

	include 'plantillaResumenLiquidacion.php';
	require_once "../modelos/Liquidacion.php";
	require_once "../modelos/Movimiento.php";

	$pdf = new PDF('P','mm','A4');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(0,6, 'RESUMEN',0,1,'C');
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',5);
	$pdf->Cell(8,5,'Codigo',1,0,'C',1);
	$pdf->Cell(20,5,'Cta. Cte. Bancaria',1,0,'C',1);
	$pdf->Cell(40,5,'Apellido y Nombre',1,0,'C',1);
	$pdf->Cell(23,5,'Clase',1,0,'C',1);
	$pdf->Cell(40,5,'Conceptos',1,0,'C',1);
	$pdf->Cell(13,5,'Dias',1,0,'C',1);
	$pdf->Cell(18,5,'Horas',1,0,'C',1);
	$pdf->Cell(18,5,'Importes',1,1,'C',1);

	$pdf->SetFont('Arial','',6);
	$rpt = new Liquidacion();

	$rspta = $rpt->rpt_salarios_resumido($_GET['id']);
	$t_dpc = 0;
	while($row = $rspta->fetchObject())
	{
	
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',5);
	$pdf->Cell(8,5,$row->Legajo_idLegajo,1,0,'C',1);
	$pdf->Cell(20,5,'0',1,0,'C',1);
	$pdf->Cell(40,5,$row->apellido.', '.$row->nombre,1,0,'C',1);
	$pdf->Cell(23,5,'',1,0,'C',1);
	$pdf->Cell(40,5,$row->descripcion,1,0,'C',1);
	$pdf->Cell(13,5,$row->dias,1,0,'C',1);
	$pdf->Cell(18,5,'00',1,0,'C',1);
	$pdf->Cell(18,5,number_format($row->total),1,1,'C',1);

	}
	$pdf->Output();
?>