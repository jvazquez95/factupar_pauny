<?php

	include 'plantillaPagare.php';
	require_once "../modelos/Consultas.php";
	require_once "../modelos/Movimiento.php";


	
	$pdf = new PDF('P','mm','A4');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(0,6, 'El dia ---estirar-fecha--- ',0,1,'C');
	$pdf->Cell(160,5,utf8_decode('Pagaré a FULL OFFICE S.R.L o a su orden la suma de guaranies '),1,0,'C');

	
	$html = 'Ahora puede imprimir fácilmente texto mezclando diferentes estilos: <b>negrita</b>, <i>itálica</i>,
<u>subrayado</u>, o ¡ <b><i><u>todos a la vez</u></i></b>!<br><br>También puede incluir enlaces en el
texto, como <a href="http://www.fpdf.org">www.fpdf.org</a>, o en una imagen: pulse en el logotipo.';

	$pdf->MultiCell($html);

	$pdf->Cell(160,5,utf8_decode('TOTAL COBRADO (COBROS A CLIENTES - SUMATORIA DE TODOS LOS TIPOS DE PAGOS)'),1,0,'C');

	$pdf->Cell(160,5,utf8_decode('TOTAL GENERAL ((TOTAL PAGOS + TOTAL EGRESOS) + (TOTAL RECIBOS + TOTAL INGRESOS))'),1,0,'C');

	$pdf->Cell(160,5,utf8_decode('TOTAL EN EFECTIVO ((TOTAL PAGOS + TOTAL EGRESOS) + (TOTAL RECIBOS + TOTAL INGRESOS))'),1,0,'C');
	$pdf->Cell(30,5,number_format($t_efectivo,0,',','.'),1,1,'C');
	
	$pdf->Output();
?>