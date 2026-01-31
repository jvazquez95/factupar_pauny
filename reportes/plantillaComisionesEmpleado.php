<?php
	require_once "../modelos/Consultas.php";
	require_once __DIR__ . '/PDF_ReporteBase.php';
	if (strlen(session_id()) < 1) session_start();

	class PDF extends PDF_ReporteBase
	{
		function Header()
		{
			parent::Header();
			require_once "../modelos/OrdenCompra.php";
			$oc = new OrdenCompra();
			$rspta = $oc->rpt_oc_cabecera(isset($_GET['idOrdenCompra']) ? $_GET['idOrdenCompra'] : 0);
			if (!$rspta) return;
			$reg0 = $rspta->fetchObject();
			if (!$reg0) return;
			date_default_timezone_set('America/Asuncion');
			$this->SetFont('Arial','B',10);
			$this->Cell(190,1, (isset($reg0->ds) ? $reg0->ds : '') . ' - ' . (isset($reg0->dd) ? $reg0->dd : ''),0,1,'C');
			$this->SetFont('Arial','',10);
			$this->Ln(5);
			$this->Cell(100,1, 'Direccion: ' . (isset($reg0->direccion) ? $reg0->direccion : ''),0,1,'');
			$this->Cell(100,1, 'Tel: ' . (isset($reg0->telefono) ? $reg0->telefono : ''),0,1,'L');
			$this->Cell(100,1, 'Correo: ' . (isset($reg0->correo) ? $reg0->correo : ''),0,1,'L');
			$this->Cell(100,1, 'Ciudad: ' . (isset($reg0->ciudad) ? $reg0->ciudad : ''),0,1,'L');
			$this->Ln(5);
			$this->Cell(100,1, 'Razon social: ' . (isset($reg0->rs) ? $reg0->rs : ''),0,1,'L');
			$this->Cell(100,1, 'Termino de pago: ' . (isset($reg0->tpd) ? $reg0->tpd : ''),0,1,'L');
			$this->Ln(10);
		}
	}
?>
