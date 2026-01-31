<?php
	require_once "../modelos/Consultas.php";
	require_once __DIR__ . '/PDF_ReporteBase.php';
	if (strlen(session_id()) < 1) session_start();

	class PDF extends PDF_ReporteBase
	{
		function Header()
		{
			parent::Header();
			require_once "../modelos/Recibo.php";
			$oc = new Recibo();
			$rspta = $oc->rpt_recibo_cabecera(isset($_GET['idRecibo']) ? $_GET['idRecibo'] : 0);
			if (!$rspta) return;
			$reg0 = $rspta->fetchObject();
			if (!$reg0) return;
			$_SESSION["nroDoc"] = isset($reg0->nroDocumento) ? $reg0->nroDocumento : '';
			$_SESSION["razonSocial"] = isset($reg0->razonSocial) ? $reg0->razonSocial : '';
			$this->SetFont('Arial','B',10);
			$this->Cell(175,1, "Recibo Nro.: " . (isset($reg0->IDRECIBO) ? $reg0->IDRECIBO : (isset($reg0->idRecibo) ? $reg0->idRecibo : '')),0,1,'C');
			$this->SetFont('Arial','',10);
			$this->Ln(5);
			$this->Cell(100,1, utf8_decode('Dirección: ') . (isset($reg0->direccionSucursal) ? $reg0->direccionSucursal : ''),0,1,'');
			$this->Cell(100,1, 'Tel: ' . (isset($reg0->telefonoSucursal) ? $reg0->telefonoSucursal : ''),0,1,'L');
			$this->Cell(100,1, 'Razon social: ' . (isset($reg0->razonSocial) ? $reg0->razonSocial : ''),0,1,'L');
			$this->Cell(100,1, 'Cobrador: ' . (isset($reg0->cajero) ? utf8_decode($reg0->cajero) : ''),0,1,'L');
			$this->Cell(100,1, 'Lugar de cobro: ' . (isset($reg0->sucursal) ? $reg0->sucursal : ''),0,1,'L');
			$this->Ln(10);
		}
	}
?>
