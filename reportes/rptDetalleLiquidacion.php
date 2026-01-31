<?php

	include 'plantillaDetalleLiquidacion.php';
	require_once "../modelos/Liquidacion.php";
	require_once "../modelos/Movimiento.php";


	$pdf = new PDF('L','mm','Legal');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(0,6, 'DETALLES',0,1,'C');
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',5);
	$pdf->Cell(8,5,'Legajo',1,0,'C',1);
	$pdf->Cell(45,5,'Apellido y Nombre',1,0,'C',1);
	$pdf->Cell(10,5,'Dias Trab',1,0,'C',1);
	$pdf->Cell(23,5,'Salarios Honorarios',1,0,'C',1);
	$pdf->Cell(13,5,'Horas Extras',1,0,'C',1);
	$pdf->Cell(13,5,'Comisiones',1,0,'C',1);
	$pdf->Cell(18,5,'Otros Ingresos',1,0,'C',1);
	$pdf->Cell(18,5,'Vacaciones',1,0,'C',1);
	$pdf->Cell(18,5,'Bonif. Familiar',1,0,'C',1);
	$pdf->Cell(18,5,'IVA Profesional',1,0,'C',1);
	$pdf->Cell(18,5,'Total Ingresos',1,0,'C',1);
	$pdf->Cell(18,5,'Adelantos',1,0,'C',1);
	$pdf->Cell(29,5,'Ausencias-LL. Tardias',1,0,'C',1);
	$pdf->Cell(10,5,'Reposo',1,0,'C',1);
	$pdf->Cell(13,5,'Otros.Dctos',1,0,'C',1);
	$pdf->Cell(13,5,'Desc.IPS',1,0,'C',1);
	$pdf->Cell(13,5,'Total Egresos',1,0,'C',1);
	$pdf->Cell(13,5,'A Percibir',1,0,'C',1);
	$pdf->Cell(13,5,'Total',1,1,'C',1);

	$pdf->SetFont('Arial','',5);
	$rpt = new Liquidacion();
	$pdf->SetFillColor(255,255,255);

	$rspta = $rpt->rpt_salarios_detallado($_GET['id']);
	$t_dpc = 0;
	while($row = $rspta->fetchObject())
	{
	
		$pdf->Cell(8,5,$row->Legajo_idLegajo,1,0,'C',1);
		$pdf->Cell(45,5,$row->apellido.', '.$row->nombre,1,0,'C',1);
		$pdf->Cell(10,5,$row->dias,1,0,'C',1);
		$pdf->Cell(23,5,$row->Legajo_idLegajo,1,0,'C',1);
		$pdf->Cell(13,5,$row->Legajo_idLegajo,1,0,'C',1);
		$pdf->Cell(13,5,$row->Legajo_idLegajo,1,0,'C',1);
		$pdf->Cell(18,5,$row->Legajo_idLegajo,1,0,'C',1);
		$pdf->Cell(18,5,$row->Legajo_idLegajo,1,0,'C',1);
		$pdf->Cell(18,5,$row->Legajo_idLegajo,1,0,'C',1);
		$pdf->Cell(18,5,$row->Legajo_idLegajo,1,0,'C',1);
		$pdf->Cell(18,5,$row->Legajo_idLegajo,1,0,'C',1);
		$pdf->Cell(18,5,$row->Legajo_idLegajo,1,0,'C',1);
		$pdf->Cell(29,5,$row->Legajo_idLegajo,1,0,'C',1);
		$pdf->Cell(10,5,$row->Legajo_idLegajo,1,0,'C',1);
		$pdf->Cell(13,5,$row->Legajo_idLegajo,1,0,'C',1);
		$pdf->Cell(13,5,$row->Legajo_idLegajo,1,0,'C',1);
		$pdf->Cell(13,5,$row->egresos,1,0,'C',1);
		$pdf->Cell(13,5,$row->ingresos,1,0,'C',1);
		$pdf->Cell(13,5,$row->total,1,1,'C',1);
	}

	$pdf->Output();

?>