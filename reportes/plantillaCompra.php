<?php
	require_once "../modelos/Consultas.php";
	require_once __DIR__ . '/PDF_ReporteBase.php';
	if (strlen(session_id()) < 1) session_start();

	class PDF extends PDF_ReporteBase
	{
		function Header()
		{
			parent::Header();
			require_once "../modelos/Compra.php";
			$oc = new Compra();
			$rspta = $oc->listar(isset($_GET['idCompra']) ? $_GET['idCompra'] : 0);
			if (!$rspta) return;
			$reg0 = $rspta->fetchObject();
			if (!$reg0) return;
			$tipo = ($reg0->tipo_comprobante == 1) ? 'FACTURA' : 'TICKET';
			$tipo2 = ($reg0->tipoCompra == 1) ? 'Mercaderia' : 'Gasto';
			$this->SetFont('Arial','B',10);
			$this->Cell(175,1, "Compra Nro.: " . $reg0->idCompra,0,1,'C');
			$this->SetFont('Arial','',10);
			$this->Ln(3);
			$this->Cell(100,1, 'Razon social: ' . (isset($reg0->nombre) ? $reg0->nombre : ''),0,1,'L');
			$this->Cell(100,1, 'Deposito: ' . (isset($reg0->deposito) ? $reg0->deposito : ''),0,1,'L');
			$this->Cell(100,1, 'Termino Pago: ' . (isset($reg0->terminoPago) ? $reg0->terminoPago : ''),0,1,'L');
			$this->Cell(100,1, 'Fecha Factura: ' . (isset($reg0->fechaFactura) ? $reg0->fechaFactura : ''),0,1,'L');
			$this->Cell(100,1, 'Nro. Factura: ' . (isset($reg0->nroFactura) ? $reg0->nroFactura : ''),0,1,'L');
			$this->Cell(100,1, 'Timbrado: ' . (isset($reg0->timbrado) ? $reg0->timbrado : ''),0,1,'L');
			$this->Cell(100,1, 'Venc. timbrado: ' . (isset($reg0->vtoTimbrado) ? $reg0->vtoTimbrado : ''),0,1,'L');
			$this->Cell(100,1, 'Moneda: ' . (isset($reg0->moneda) ? $reg0->moneda : ''),0,1,'L');
			$this->Cell(100,1, 'Total: ' . (isset($reg0->total) ? $reg0->total : ''),0,1,'L');
			$this->Cell(100,1, 'Tipo: ' . $tipo2 . ' - ' . $tipo,0,1,'L');
			$this->Ln(10);
		}
	}
?>
