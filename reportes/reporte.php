
<?php
include 'plantillaArqueo2.php';
require_once "../modelos/Consultas.php";
require_once "../modelos/Movimiento.php";

class PDF extends FPDF {
    // Encabezado
    function Header() {
        $this->SetFont('Arial','B',12);
        $this->Cell(0,10,'Reporte de Caja',0,1,'C');
        $this->Ln(5);
    }

    // Pie de página
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,6, 'Nro de Habilitacion: '.$_GET['habilitacion'] ,0,1,'L');

// Información general
$rpt = new Consultas();
$rspta = $rpt->rpt_cabecera($_GET['habilitacion']);
while($row = $rspta->fetchObject()) {
    $pdf->Cell(0,6, 'CAJA: '.$row->nombre ,0,1,'L');
    $pdf->Cell(0,6, 'DEPOSITO: '.$row->descripcion ,0,1,'L');
    $pdf->Cell(0,6, 'USUARIO: '.$row->login ,0,1,'L');			
}

function createSection($pdf, $title, $columns, $data, $totals, $convertDate = false) {
    if ($data->rowCount() > 0) {
        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(0,6, $title,0,1,'C');
        $pdf->SetFillColor(232,232,232);
        foreach ($columns as $col) {
            $pdf->Cell($col['width'], 5, $col['title'], 1, 0, 'C', 1);
        }
        $pdf->Ln();
        
        $pdf->SetFont('Arial','',11);
        $total = 0;
        while ($row = $data->fetchObject()) {
            foreach ($columns as $col) {
                $value = $row->{$col['field']};
                if ($convertDate && $col['convertDate']) {
                    $date = date_create($value);
                    $value = date_format($date, "d-m-Y");
                }
                $pdf->Cell($col['width'], 5, utf8_decode($value), 1, 0, $col['align']);
            }
            $pdf->Ln();
            $total += $row->{$totals['field']};
        }
        $pdf->SetFillColor(0,0,255);
        $pdf->Cell(array_sum(array_column($columns, 'width')) - $totals['width'], 5, utf8_decode('TOTAL GS'), 1, 0, 'C');
        $pdf->Cell($totals['width'], 5, number_format($total, 0, ',', '.'), 1, 1, 'R');
    }
}

// Secciones de reporte
createSection($pdf, 'DETALLE DE PRODUCTOS VENDIDOS CONTADO', [
    ['width' => 20, 'title' => 'CANTIDAD', 'field' => 'Cantidad_X_Articulo', 'align' => 'C'],
    ['width' => 90, 'title' => 'ARTICULO', 'field' => 'descripcion', 'align' => 'C'],
    ['width' => 20, 'title' => 'MONEDA', 'field' => 'moneda', 'align' => 'C'],
    ['width' => 30, 'title' => 'TOTAL', 'field' => 'Total', 'align' => 'C'],
    ['width' => 30, 'title' => 'TOTAL GS', 'field' => 'TotalGs', 'align' => 'C']
], $rpt->rpt_aruqeo_caja_venta_contado($_GET['habilitacion']), ['field' => 'TotalGs', 'width' => 30]);


?>
