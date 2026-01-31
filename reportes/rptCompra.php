<?php

	include 'plantillaCompra.php';
	
	$pdf = new PDF('P','mm','A4');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(0,6, 'DETALLE DE COMPRA',0,1,'C');
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(15,6,'Id Art.',1,0,'C',1);
	$pdf->Cell(45,6,'Nombre',1,0,'C',1);
	$pdf->Cell(45,6,'Descripcion',1,0,'C',1);
	$pdf->Cell(18,6,'Precio',1,0,'C',1);
	$pdf->Cell(18,6,'Cantidad',1,0,'C',1);
	$pdf->Cell(18,6,'Descuento',1,0,'C',1);
	$pdf->Cell(18,6,'Total',1,1,'C',1);

	
    $pdf->SetFont('Arial','',6);
    $rpt = new Consultas();
	$rspta = $rpt->rpt_compras_detalle($_GET['idCompra']);
	// $rspta = $rpt->rpt_oc_detalle($_GET['idCompra']);
	// $total = 0;
	// $fila1 = 0;
	// $saldoInicial = 0;

	 while($row = $rspta->fetchObject())
	 {

		$pdf->Cell(15,6,utf8_decode($row->Articulo_idArticulo),1,0,'R');
		$pdf->Cell(45,6,substr(utf8_decode($row->nombre), 0, 20),1,0,'L');
		$pdf->Cell(45,6,substr(utf8_decode($row->descripcion), 0, 58),1,0,'L');			
		$pdf->Cell(18,6,number_format($row->precio, 0, ',', '.'),1,0,'R');	
		$pdf->Cell(18,6,$row->cantidad,1,0,'R');	
		$pdf->Cell(18,6,number_format($row->descuento, 0, ',', '.'),1,0,'R');						
		$pdf->Cell(18,6,number_format($row->total, 0, ',', '.'),1,1,'R');
		//$total = $total + $row->l_subtotal;	
	}



	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(0,6, 'DETALLE DE ASIENTO',0,1,'C');
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(60,6,'Cta. Contable',1,0,'C',1);
	$pdf->Cell(30,6,'Tipo. Movimiento',1,0,'C',1);
	$pdf->Cell(22,6,'Importe Debito',1,0,'C',1);
	$pdf->Cell(22,6,'Importe Credito',1,1,'C',1);

	
	$pdf->SetFont('Arial','',5);
	$rpt = new Consultas();

	$rspta = $rpt->rpt_asiento_detalle_vista($_GET['idCompra']);
	$t_mi = 0;
	while($row = $rspta->fetchObject())
	{

		$pdf->Cell(60,6,($row->cuentaContableDesc),1,0,'C');
		$pdf->Cell(30,6,($row->tipoMovimiento),1,0,'C');
		$pdf->Cell(22,6,number_format($row->Debito, 0, ',', '.'),1,0,'C');
		$pdf->Cell(22,6,number_format($row->Credito, 0, ',', '.'),1,1,'C');	
	}
	

	$pdf->Output();
?>