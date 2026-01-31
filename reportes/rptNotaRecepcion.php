<?php

	include 'plantillaNotaRecepcion.php';
	//require_once "../modelos/Consultas.php";
	//session_start();
	//$lidEmpleado = $_SESSION['idEmpleado'];

	
	$pdf = new PDF('L','mm','Legal');
	$pdf->AliasNbPages();
	$pdf->AddPage();

	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(10,6,'Id',1,0,'C',1);
	$pdf->Cell(20,6,'Id Articulo',1,0,'C',1);
	$pdf->Cell(80,6,'Descripcion',1,0,'C',1);
	$pdf->Cell(20,6,'Precio',1,0,'C',1);
	$pdf->Cell(20,6,'Descuento',1,0,'C',1);
	$pdf->Cell(25,6,'Cant. Solicitada',1,0,'C',1);
	$pdf->Cell(25,6,'Cant. Recibida',1,0,'C',1);
	$pdf->Cell(25,6,'Cant. Faltante',1,0,'C',1);
	$pdf->Cell(25,6,'Cant. Devuelta',1,0,'C',1);
	$pdf->Cell(50,6,'Comentario',1,0,'C',1);
	$pdf->Cell(20,6,'Total',1,1,'C',1);


	
	$pdf->SetFont('Arial','',6);
	$rpt = new RecepcionMercaderias();
	//$rspta = $rpt->rpt_oc_detalle($_GET['empleado'],$_GET['fi'],$_GET['ff']);
	$rspta = $rpt->rpt_notarecepcion_detalle($_GET['id']);
	$total = 0;
	$fila1 = 0;
	$saldoInicial = 0;
	while($row = $rspta->fetchObject())
	{
		$pdf->Cell(10,6,utf8_decode($row->idDetalleOrdenCompra),1,0,'C');
		$pdf->Cell(20,6,utf8_decode($row->Articulo_idArticulo),1,0,'C');
		$pdf->Cell(80,6,utf8_decode($row->descripcion),1,0,'L');
		$pdf->Cell(20,6,number_format($row->precio, 0, ',', '.').' Gs.',1,0,'R');			
		$pdf->Cell(20,6,number_format($row->Descuento, 0, ',', '.').' Gs.',1,0,'R');			
		$pdf->Cell(25,6,number_format($row->cantidadSolicitada, 0, ',', '.').'',1,0,'R');	
		$pdf->Cell(25,6,number_format($row->cantidadRecibida, 0, ',', '.').'',1,0,'R');	
		$pdf->Cell(25,6,number_format($row->cantidadFaltante, 0, ',', '.').'',1,0,'R');	
		$pdf->Cell(25,6,number_format($row->devuelta, 0, ',', '.').'',1,0,'R');	
		$pdf->Cell(50,6,utf8_decode($row->comentario),1,0,'L');
		$pdf->Cell(20,6,number_format($row->cantidadRecibida*($row->precio-$row->Descuento), 0, ',', '.').' Gs.',1,1,'R');	
		$total = $total + ($row->cantidadRecibida*($row->precio-$row->Descuento));	
	}

	$pdf->Ln(3);

	$pdf->SetFont('Arial','B',8);

	$pdf->Cell(25,6,'Total aplicado',1,0,'R',1);
	$pdf->Cell(25,6,number_format($total, 0, ',', '.').' Gs.',1,1,'C');

	$pdf->Ln(10);





/*
	
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

*/



	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(27,6,'Entregador: ');	
	$pdf->Ln(15);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(27,6,'Firma:_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ Aclaracion:_ _ _ _ _ _ _ _ _ _ _ _ _ _ __ _ _ _ _ _ _ _ _ _ _ _ _ _ _ C.I. Nro.:_ _ _ _ _ _ _ _ _ _ _ _ _ _ _');	


	$pdf->Ln(10);

	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(27,6,'Jefe deposito: ');	
	$pdf->Ln(15);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(27,6,"Firma:_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ Aclaracion:_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _  $usuarioInsercion C.I. Nro.:_ _ _ _ _ _ _ _ _ _ _ _ _ _ _");	
	



	$pdf->Output();
?>