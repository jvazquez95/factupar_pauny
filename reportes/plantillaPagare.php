<?php
	require_once __DIR__ . '/PDF_ReporteBase.php';
	if (strlen(session_id()) < 1) session_start();

	class PDF extends PDF_ReporteBase
	{
		// Cabecera y pie heredados de PDF_ReporteBase (logo empresa + Factupar)
	}
?>
