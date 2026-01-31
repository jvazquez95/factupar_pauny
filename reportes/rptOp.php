<?php

	include 'plantillaOrdenesPago.php';
	//require_once "../modelos/Consultas.php";
	//session_start();
	//$lidEmpleado = $_SESSION['idEmpleado'];

	
	$pdf = new PDF('P','mm','A4');
	$pdf->AliasNbPages();
	$pdf->AddPage();

	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(30,6,'Nro. de Factura',1,0,'C',1);
	$pdf->Cell(27,6,'Nro de Cuota',1,0,'C',1);
	$pdf->Cell(27,6,'Monto Aplicado',1,0,'C',1);
	$pdf->Cell(27,6,'Saldo',1,1,'C',1);


	
	$pdf->SetFont('Arial','',6);
	$rpt = new Pago();
	//$rspta = $rpt->rpt_oc_detalle($_GET['empleado'],$_GET['fi'],$_GET['ff']);
	$rspta = $rpt->rpt_op_detalle($_GET['idPago']);
	$total = 0;
	$fila1 = 0;
	$saldoInicial = 0;
	while($row = $rspta->fetchObject())
	{

		$pdf->Cell(30,6,utf8_decode($row->nroFactura),1,0,'C');
		$pdf->Cell(27,6,$row->CUOTA,1,0,'C');
		$pdf->Cell(27,6,number_format($row->MONTOAPLICADO, 0, ',', '.').' Gs.',1,0,'R');			
		$pdf->Cell(27,6,number_format($row->saldo, 0, ',', '.').' Gs.',1,1,'R');	
		$total = $total + $row->MONTOAPLICADO;	
	}

	$pdf->Ln(3);

	$pdf->SetFont('Arial','B',8);

	$pdf->Cell(25,6,'Total aplicado',1,0,'R',1);
	$pdf->Cell(25,6,number_format($total, 0, ',', '.').' Gs.',1,1,'C');

	$pdf->Ln(10);




	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(30,6,'Forma de Pago',1,0,'C',1);
	$pdf->Cell(20,6,'Banco',1,0,'C',1);
	$pdf->Cell(27,6,'Monto',1,0,'C',1);
	$pdf->Cell(40,6,'Nro de referencia / Cheque',1,0,'C',1);
	$pdf->Cell(35,6,'Paguese a la orden de:',1,0,'C',1);
	$pdf->Cell(27,6,'Vencimiento',1,1,'C',1);






	
	$pdf->SetFont('Arial','',6);
	$rpt = new Pago();
	//$rspta = $rpt->rpt_oc_detalle($_GET['empleado'],$_GET['fi'],$_GET['ff']);
	$rspta = $rpt->rpt_op_detalle_pago($_GET['idPago']);
	$total = 0;
	$fila1 = 0;
	$usuarioInsercion = '';
	$fechaIns = '';
	$saldoInicial = 0;
	while($row = $rspta->fetchObject())
	{

		$pdf->Cell(30,6,utf8_decode($row->descripcion),1,0,'C');
		$pdf->Cell(20,6,$row->descripcionbanco,1,0,'C');	
		$pdf->Cell(27,6,number_format($row->MONTO, 0, ',', '.').' Gs.',1,0,'C');
		$pdf->Cell(40,6,$row->NROCHEQUE .' - Cheque: '. $row->nroCheque,1,0,'R');			
		$pdf->Cell(35,6,$row->destinatario,1,0,'C');	
		$pdf->Cell(27,6,$row->fechaCobro,1,1,'C');	
		$total = $total + $row->MONTO;
		$usuarioInsercion = $row->usuario;
		$fechaIns = $row->fechaTransaccion;

	}

	$pdf->Ln(3);


	$pdf->SetFont('Arial','B',8);

	$pdf->Cell(25,6,'Total Pago',1,0,'R',1);
	$pdf->Cell(25,6,number_format($total, 0, ',', '.').' Gs.',1,1,'C');





	$pdf->Ln(15);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(27,6,'Entregado a: ');	
	$pdf->Ln(15);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(27,6,'Firma:_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ Aclaracion:_ _ _ _ _ _ _ _ _ _ _ _ _ _ __ _ _ _ _ _ _ _ _ _ _ _ _ _ _ C.I. Nro.:_ _ _ _ _ _ _ _ _ _ _ _ _ _ _');	
	$pdf->Ln(10);
	$pdf->Cell(27,6,'Fecha:_ _ /_ _/_ _ _ _');	



	$pdf->Ln(20);

	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(27,6,'Elaborado por: ');	
	$pdf->Ln(15);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(27,6,"Firma:_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ Aclaracion: $usuarioInsercion C.I. Nro.:_ _ _ _ _ _ _ _ _ _ _ _ _ _ _");	
	$pdf->Ln(10);
	$pdf->Cell(27,6,"Fecha: $fechaIns ");	





	$pdf->Ln(15);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(27,6,'Controlado por: ');	
	$pdf->Ln(15);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(27,6,'Firma:_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ Aclaracion:_ _ _ _ _ _ _ _ _ _ _ _ _ _ __ _ _ _ _ _ _ _ _ _ _ _ _ _ _ C.I. Nro.:_ _ _ _ _ _ _ _ _ _ _ _ _ _ _');	
	$pdf->Ln(10);
	$pdf->Cell(27,6,'Fecha:_ _ /_ _/_ _ _ _');	






	$pdf->Ln(20);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(27,6,'Contabilizado por: ');	
	$pdf->Ln(15);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(27,6,'Firma:_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ Aclaracion:_ _ _ _ _ _ _ _ _ _ _ _ _ _ __ _ _ _ _ _ _ _ _ _ _ _ _ _ _ C.I. Nro.:_ _ _ _ _ _ _ _ _ _ _ _ _ _ _');	
	$pdf->Ln(10);
	$pdf->Cell(27,6,'Fecha:_ _ /_ _/_ _ _ _');	



	$pdf->Output();
?>