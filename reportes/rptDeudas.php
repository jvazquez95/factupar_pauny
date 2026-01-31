<?php

	include 'plantillaDeudas.php';
	require_once "../modelos/Consultas.php";


	
	$pdf = new PDF('L','mm','A4');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(0,10, 'DEUDAS A COBRAR',0,1,'C');
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(25,6,'FECHA FACTURA',1,0,'C',1);
	$pdf->Cell(30,6,'NRO HABILITACION',1,0,'C',1);
	$pdf->Cell(25,6,'USUARIO',1,0,'C',1);
	$pdf->Cell(60,6,'CLIENTE',1,0,'C',1);
	$pdf->Cell(30,6,'NRO. VENTA',1,0,'C',1);
	$pdf->Cell(30,6,'TOTAL VENTA',1,0,'C',1);
	$pdf->Cell(35,6,'SALDO PENDIENTE',1,0,'C',1);
	$pdf->Cell(35,6,'SALDO GENERAL-TOTAL',1,1,'C',1);
	
	$pdf->SetFont('Arial','',7);
	$rpt = new Consultas();

	$rspta = $rpt->rpt_deudas_cobrar();
	while($row = $rspta->fetchObject())
	{
		$pdf->Cell(25,6,utf8_decode($row->fechaFactura),1,0,'C');
		$pdf->Cell(30,6,utf8_decode($row->Habilitacion_idHabilitacion),1,0,'C');
		$pdf->Cell(25,6,utf8_decode($row->usuario),1,0,'C');			
		$pdf->Cell(60,6,utf8_decode($row->nombreComercial),1,0,'C');			
		$pdf->Cell(30,6,utf8_decode($row->Venta_idVenta),1,0,'C');			
		$pdf->Cell(30,6,utf8_decode(number_format($row->total, 0, ',', '.')),1,0,'C');			
		$pdf->Cell(35,6,utf8_decode(number_format($row->saldo, 0, ',', '.')),1,0,'C');			
		$pdf->Cell(35,6,utf8_decode(number_format($row->st, 0, ',', '.')),1,1,'C');			
	}


	$pdf->Output();
?>