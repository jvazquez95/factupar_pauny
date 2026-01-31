<?php
	require_once "../modelos/Venta.php";
	require_once __DIR__ . '/PDF_ReporteBase.php';
	if (strlen(session_id()) < 1) session_start();

	class PDF extends PDF_ReporteBase
	{
		function Header()
		{
			parent::Header();
			$ov = new Venta();
			date_default_timezone_set('America/Asuncion');
			$currentdate = date("d-m-Y h:i:s");
			$this->SetFont('Arial','B',22);
			$this->Cell(180,1, "Extracto General",0,1,'C');
			$this->Ln(5);
			$this->SetFont('Arial','',10);
			$this->Cell(100,1, 'Usuario: ' . $_SESSION['login'],0,1,'');
			$this->Ln(3);
			$this->Cell(100,1, 'Rango de Fecha: ' . (isset($_GET['fechai']) ? $_GET['fechai'] : '') . ' a ' . (isset($_GET['fechaf']) ? $_GET['fechaf'] : ''),0,1,'');
			$this->Ln(3);
			$this->Cell(100,1, 'Cliente: ' . (isset($_GET['cliente']) ? $_GET['cliente'] : ''),0,1,'');
			$this->Ln(7);
		}
	}
?>
