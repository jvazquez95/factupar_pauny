<?php

	include 'plantillaPaquetes.php';
	require_once "../modelos/Consultas.php";


	
	$pdf = new PDF('L','mm','A4');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(0,10, 'SERVICIOS',0,1,'C');
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(16,6,'ID VENTA',1,0,'C',1);
	$pdf->Cell(15,6,'GIFTCARD',1,0,'C',1);
	$pdf->Cell(60,6,'RAZON SOCIAL',1,0,'C',1);
	$pdf->Cell(35,6,'NRO DOCUMENTO',1,0,'C',1);
	$pdf->Cell(20,6,'CELULAR',1,0,'C',1);
	$pdf->Cell(60,6,'SERVICIO',1,0,'C',1);
	$pdf->Cell(60,6,'PAQUETE',1,0,'C',1);
	$pdf->Cell(13,6,'CANTIDAD',1,1,'C',1);
	
	$pdf->SetFont('Arial','',7);
	$rpt = new Consultas();

	$rspta = $rpt->rpt_clientes_servicios($_GET['cliente']);
	while($row = $rspta->fetchObject())
	{
		if ($row->giftcard == 1) {
			$gift = 'SI';
		}else{
			$gift = 'NO';
		}
		$pdf->Cell(16,6,utf8_decode($row->Venta_idVenta),1,0,'C');
		$pdf->Cell(15,6,utf8_decode($gift),1,0,'C');
		$pdf->Cell(60,6,utf8_decode($row->razonSocial),1,0,'C');
		$pdf->Cell(35,6,utf8_decode($row->nroDocumento),1,0,'C');			
		$pdf->Cell(20,6,utf8_decode($row->celular),1,0,'C');			
		$pdf->Cell(60,6,utf8_decode($row->SERVICIO),1,0,'C');			
		$pdf->Cell(60,6,utf8_decode('SIN PAQUETE'),1,0,'C');			
		$pdf->Cell(13,6,utf8_decode($row->cantidad),1,1,'C');			
	}


	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(0,10, 'PAQUETES',0,1,'C');


	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(16,6,'ID VENTA',1,0,'C',1);
	$pdf->Cell(15,6,'GIFTCARD',1,0,'C',1);
	$pdf->Cell(60,6,'RAZON SOCIAL',1,0,'C',1);
	$pdf->Cell(35,6,'NRO DOCUMENTO',1,0,'C',1);
	$pdf->Cell(20,6,'CELULAR',1,0,'C',1);
	$pdf->Cell(60,6,'SERVICIO',1,0,'C',1);
	$pdf->Cell(60,6,'PAQUETE',1,0,'C',1);
	$pdf->Cell(13,6,'CANTIDAD',1,1,'C',1);
	$pdf->SetFont('Arial','',7);

	$rspta = $rpt->rpt_clientes_paquetes($_GET['cliente']);

	while($row = $rspta->fetchObject())
	{
		if ($row->giftcard == 1) {
			$gift = 'SI';
		}else{
			$gift = 'NO';
		}
		$pdf->Cell(16,6,utf8_decode($row->Venta_idVenta),1,0,'C');
		$pdf->Cell(15,6,utf8_decode($gift),1,0,'C');
		$pdf->Cell(60,6,utf8_decode($row->razonSocial),1,0,'C');
		$pdf->Cell(35,6,utf8_decode($row->nroDocumento),1,0,'C');			
		$pdf->Cell(20,6,utf8_decode($row->celular),1,0,'C');			
		$pdf->Cell(60,6,utf8_decode($row->SERVICIO),1,0,'C');			
		$pdf->Cell(60,6,utf8_decode($row->PAQUETE),1,0,'C');			
		$pdf->Cell(13,6,utf8_decode($row->cantidad) .'/'.$row->cantidadTotal ,1,1,'C');			
	}

	$pdf->Output();
?>