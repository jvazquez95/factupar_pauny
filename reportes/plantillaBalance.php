<?php
	require_once "../modelos/Consultas.php";
	require_once __DIR__ . '/PDF_ReporteBase.php';
	if (strlen(session_id()) < 1) session_start();

	class PDF extends PDF_ReporteBase
	{
		function Header()
		{
			parent::Header();
			date_default_timezone_set('America/Asuncion');
			$this->SetFont('Arial','B',22);
			$this->Cell(180,1, "Balance Analitico",0,1,'C');
			$this->Ln(5);
			$this->SetFont('Arial','',10);
			$this->Cell(100,1, 'Usuario: ' . $_SESSION['login'],0,1,'');
			$this->Ln(3);
			$this->Cell(100,1, 'Rango de Fecha: ' . (isset($_GET['fi']) ? $_GET['fi'] : '') . ' a ' . (isset($_GET['ff']) ? $_GET['ff'] : ''),0,1,'');
			$this->Ln(3);
			$this->Cell(100,1, 'Rango de Cuenta: ' . (isset($_GET['ci']) ? $_GET['ci'] : '') . ' a ' . (isset($_GET['cf']) ? $_GET['cf'] : ''),0,1,'');
			$this->Ln(7);
			$this->SetFillColor(232,232,232);
			$this->SetFont('Arial','B',8);
			$this->Cell(60,6,'Cuenta Contable',1,0,'C',1);
			$this->Cell(24,6,'Nro Cuenta',1,0,'C',1);
			$this->Cell(24,6,'Saldo Anterior',1,0,'C',1);
			$this->Cell(24,6,'Saldo Actual',1,0,'C',1);
			$this->Cell(24,6,'Debito',1,0,'C',1);
			$this->Cell(24,6,'Credito',1,1,'C',1);
		}
	}
?>
