<?php

	include 'plantillaOV.php';
	//require_once "../modelos/Consultas.php";
	//session_start();
	//$lidEmpleado = $_SESSION['idEmpleado'];

	
	$pdf = new PDF('P','mm','A4');
	$pdf->AliasNbPages();
	$pdf->AddPage();

	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(12,6,'Codigo',1,0,'C',1);
	$pdf->Cell(27,6,'Codigo de barras',1,0,'C',1);
	$pdf->Cell(27,6,'Codigo Alternativo',1,0,'C',1);
	$pdf->Cell(80,6,'Descripcion',1,0,'C',1);
	$pdf->Cell(12,6,'Cantidad',1,0,'C',1);
	$pdf->Cell(12,6,'Precio',1,0,'C',1);
	$pdf->Cell(12,6,'SubTotal',1,1,'C',1);

	
	$pdf->SetFont('Arial','',6);
	$rpt = new OrdenVenta();
	//$rspta = $rpt->rpt_oc_detalle($_GET['empleado'],$_GET['fi'],$_GET['ff']);
	$rspta = $rpt->rpt_ov_detalle($_GET['idOrdenVenta']);
	$total = 0;
	$fila1 = 0;
	$saldoInicial = 0;
	while($row = $rspta->fetchObject())
	{

		$pdf->Cell(12,6,utf8_decode($row->codigo),1,0,'C');
		$pdf->Cell(27,6,substr(utf8_decode($row->codigoBarra), 0, 20),1,0,'C');
		$pdf->Cell(27,6,substr(utf8_decode($row->codigoAlternativo), 0, 58),1,0,'C');			
		$pdf->Cell(80,6,substr(utf8_decode($row->descripcion), 0, 58),1,0,'L');	
		$pdf->Cell(12,6,$row->cantidad,1,0,'R');	
		$pdf->Cell(12,6,number_format($row->precio, 0, ',', '.'),1,0,'R');						
		$pdf->Cell(12,6,number_format($row->l_subtotal, 0, ',', '.'),1,1,'R');
		$total = $total + $row->l_subtotal;	
	}



	$pdf->SetFont('Arial','B',8);

	$pdf->Cell(25,6,'Total Acumulado',1,0,'R',1);
	$pdf->Cell(25,6,number_format($total, 0, ',', '.').' Gs.',1,1,'C');



		//$pdf->Cell(27,6,'pruebapruebapruebapruebapruebapruebapruebapruebapruebapruebapruebapruebapruebapruebapruebapruebaprueba',1,1,'C');			




	$pdf->Output();
?>