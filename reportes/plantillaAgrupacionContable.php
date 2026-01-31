<?php
	require_once "../modelos/Consultas.php";
	require_once __DIR__ . '/PDF_ReporteBase.php';
	if (strlen(session_id()) < 1) session_start();

	class PDF extends PDF_ReporteBase
	{
		function Header()
		{
			parent::Header();
			$this->SetFont('Arial','B',16);
			$this->Cell(130,6, "Agrupacion de Cuentas Contables por periodo",1,1,'C');
			$this->Ln(5);
			$this->SetFont('Arial','',10);
			$this->Cell(100,1, 'Usuario: ' . $_SESSION['login'],0,1,'');
			$this->Ln(3);
			$this->Cell(100,1, 'Rango del periodo: ' . (isset($_GET['fi']) ? $_GET['fi'] : '') . ' a ' . (isset($_GET['ff']) ? $_GET['ff'] : ''),0,1,'');
			$this->Ln(3);
			$this->Cell(100,1, 'Rango de Cuenta: ' . (isset($_GET['ci']) ? $_GET['ci'] : '') . ' a ' . (isset($_GET['cf']) ? $_GET['cf'] : ''),0,1,'');
			$this->Ln(7);
			$this->SetFillColor(232,232,232);
			$this->SetFont('Arial','B',8);
			$this->Cell(55,6,'Cuenta Contable',1,0,'C',1);
			$this->Cell(35,6,'Nro Cuenta',1,0,'C',1);
			$this->Cell(12,6,'Nivel',1,0,'C',1);
			$this->Cell(30,6,'Debito',1,0,'C',1);
			$this->Cell(30,6,'Credito',1,1,'C',1);
		}
	}
?>
