<?php
	require_once "../modelos/Consultas.php";
	require_once __DIR__ . '/PDF_ReporteBase.php';
	if (strlen(session_id()) < 1) session_start();

	class PDF extends PDF_ReporteBase
	{
		function Header()
		{
			parent::Header();
			require_once "../modelos/OrdenVenta.php";
			$ov = new OrdenVenta();
			$rspta = $ov->rpt_ov_cabecera(isset($_GET['idOrdenVenta']) ? $_GET['idOrdenVenta'] : 0);
			if (!$rspta) return;
			$reg0 = $rspta->fetchObject();
			if (!$reg0) return;
			$this->SetFont('Arial','B',10);
			$this->Cell(190,1, "Presupuesto de venta Nro. " . (isset($reg0->idOrdenVenta) ? $reg0->idOrdenVenta : ''),0,1,'C');
			$this->SetFont('Arial','',10);
			$this->Ln(5);
			$this->Cell(100,1, 'Direccion: ' . (isset($reg0->direccion) ? $reg0->direccion : ''),0,1,'');
			$this->Cell(100,1, 'Tel: ' . (isset($reg0->telefono) ? $reg0->telefono : ''),0,1,'L');
			$this->Cell(100,1, 'Razon social: ' . (isset($reg0->rs) ? $reg0->rs : ''),0,1,'L');
			$this->Cell(100,1, 'RUC: ' . (isset($reg0->ruc) ? $reg0->ruc : ''),0,1,'L');
			$this->Cell(100,1, 'Vendedor: ' . (isset($reg0->vendedor) ? utf8_decode($reg0->vendedor) : ''),0,1,'L');
			$this->Cell(100,1, 'Termino de pago: ' . (isset($reg0->tpd) ? $reg0->tpd : ''),0,1,'L');
			$this->Ln(10);
		}
	}
?>
