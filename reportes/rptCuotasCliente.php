<?php

	include 'plantillaCuotasCliente.php';
	require_once "../modelos/Consultas.php";


	
	$pdf = new PDF('P','mm','A4');
	$pdf->AliasNbPages();
	$pdf->AddPage();

	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(40,6,'Nombre',1,0,'C',1);
	$pdf->Cell(18,6,'Habilitacion',1,0,'C',1);
	$pdf->Cell(18,6,'Usuario',1,0,'C',1);
	$pdf->Cell(20,6,'Nro. Venta',1,0,'C',1);
	$pdf->Cell(20,6,'Nro. Recibo',1,0,'C',1);
	$pdf->Cell(20,6,'Fecha',1,0,'C',1);
	$pdf->Cell(18,6,'Cuota',1,0,'C',1);
	$pdf->Cell(20,6,'Monto',1,0,'C',1);
	$pdf->Cell(20,6,'Saldo',1,1,'C',1);
	
	$pdf->SetFont('Arial','',7);
	$rpt = new Consultas();

	$rspta = $rpt->rpt_extracto_cuotas_cliente_venta($_GET['cliente'], $_GET['venta']);

	while($row = $rspta->fetchObject())
	{

		$pdf->Cell(40,6,utf8_decode($row->nombreComercial),1,0,'C');
		$pdf->Cell(18,6,utf8_decode($row->HABILITACION_IDHABILITACION),1,0,'C');
		$pdf->Cell(18,6,utf8_decode($row->USUARIOINSERCION),1,0,'C');			
		$pdf->Cell(20,6,utf8_decode($row->VENTA_IDVENTA),1,0,'C');			
		$pdf->Cell(20,6,utf8_decode($row->IDRECIBO),1,0,'C');			
		$pdf->Cell(20,6,utf8_decode($row->FECHARECIBO),1,0,'C');			
		$pdf->Cell(18,6,utf8_decode($row->CUOTA),1,0,'C');			
		$pdf->Cell(20,6,utf8_decode(number_format($row->ma, 0, ',', '.')),1,0,'C');			
		$pdf->Cell(20,6,utf8_decode(number_format($row->saldo, 0, ',', '.')),1,1,'C');			
	}


	$pdf->Output();
?>