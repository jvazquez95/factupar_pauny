<?php
	require_once "../modelos/Consultas.php";
	require_once __DIR__ . '/PDF_ReporteBase.php';
	if (strlen(session_id()) < 1) session_start();

	class PDF extends PDF_ReporteBase
	{
		function Header()
		{
			parent::Header();
			require_once "../modelos/Pago.php";
			$oc = new Pago();
			$rspta = $oc->rpt_op_cabecera(isset($_GET['idPago']) ? $_GET['idPago'] : 0);
			if (!$rspta) return;
			$reg0 = $rspta->fetchObject();
			if (!$reg0) return;
			date_default_timezone_set('America/Asuncion');
			$this->SetFont('Arial','B',10);
			$this->Cell(175,1, "Orden de Pago Nro.: " . (isset($reg0->idPago) ? $reg0->idPago : ''),0,1,'C');
			$this->SetFont('Arial','',10);
			$this->Ln(5);
			$this->Cell(100,1, 'Razon social: ' . (isset($reg0->razonSocial) ? $reg0->razonSocial : ''),0,1,'L');
			$this->Ln(10);
		}
	}
?>
