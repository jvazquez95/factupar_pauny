<?php
	require_once "../modelos/Consultas.php";
	require_once __DIR__ . '/PDF_ReporteBase.php';
	if (strlen(session_id()) < 1) session_start();

	class PDF extends PDF_ReporteBase
	{
		function Header()
		{
			parent::Header();
			require_once "../modelos/RecepcionMercaderias.php";
			$oc = new RecepcionMercaderias();
			$rspta = $oc->rpt_notarecepcion_cabecera(isset($_GET['id']) ? $_GET['id'] : 0);
			if (!$rspta) return;
			$reg0 = $rspta->fetchObject();
			if (!$reg0) return;
			$this->SetFont('Arial','B',10);
			$this->Cell(175,1, "Nota Recepcion Nro.: " . (isset($reg0->idOrdenCompra) ? $reg0->idOrdenCompra : ''),0,1,'C');
			$this->SetFont('Arial','',10);
			$this->Ln(5);
			$this->Cell(100,1, 'Razon social: ' . (isset($reg0->np) ? $reg0->np : ''),0,1,'L');
			$this->Ln(10);
		}
	}
?>
