<?php
	require_once "../modelos/Consultas.php";
	require_once __DIR__ . '/PDF_ReporteBase.php';
	if (strlen(session_id()) < 1) session_start();

	class PDF extends PDF_ReporteBase
	{
		function Header()
		{
			parent::Header();
			require_once "../modelos/MovimientoStock.php";
			$oc = new MovimientoStock();
			$rspta = $oc->rpt_op_cabecera(isset($_GET['id']) ? $_GET['id'] : 0);
			if (!$rspta) return;
			$reg0 = $rspta->fetchObject();
			if (!$reg0) return;
			$this->SetFont('Arial','B',10);
			$this->Cell(175,1, "Mov. Stock Nro.: " . (isset($reg0->idMovimientoStock) ? $reg0->idMovimientoStock : ''),0,1,'C');
			$this->SetFont('Arial','',10);
			$this->Ln(5);
			$this->Cell(100,1, 'Deposito Origen: ' . (isset($reg0->origen) ? $reg0->origen : ''),0,1,'L');
			$this->Cell(100,1, 'Deposito Destino: ' . (isset($reg0->destino) ? $reg0->destino : ''),0,1,'L');
			$this->Cell(100,1, 'Observacion: ' . (isset($reg0->comentario) ? $reg0->comentario : ''),0,1,'L');
			$this->Ln(10);
		}
	}
?>
