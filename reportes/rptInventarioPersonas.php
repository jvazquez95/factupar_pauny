<?php
ob_start();
if (strlen(session_id()) < 1)
  session_start();

if (!isset($_SESSION["nombre"])) {
  echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
  exit;
}
if (empty($_SESSION['personas'])) {
  echo 'No tiene permiso para visualizar el reporte';
  exit;
}

require(__DIR__ . '/PDF_ReporteBase.php');
require_once __DIR__ . '/../modelos/Persona.php';
require_once __DIR__ . '/../modelos/TipoPersona.php';

$idTipoPersona = isset($_GET['idTipoPersona']) ? (int)$_GET['idTipoPersona'] : 0;
$persona = new Persona();
$rspta = $persona->listarParaReporte($idTipoPersona);

$tituloTipo = '';
if ($idTipoPersona > 0) {
  $tp = new TipoPersona();
  $r = $tp->mostrar($idTipoPersona);
  $tituloTipo = isset($r['descripcion']) ? ' - Tipo: ' . $r['descripcion'] : '';
}

$pdf = new PDF_ReporteBase('L');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 8, utf8_decode('INVENTARIO DE PERSONAS' . $tituloTipo), 0, 1, 'C');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 5, 'Fecha: ' . date('d/m/Y H:i'), 0, 1, 'R');
$pdf->Ln(4);

$pdf->SetFillColor(232, 232, 232);
$pdf->SetFont('Arial', 'B', 8);
$w = array(12, 48, 42, 16, 26, 28, 40, 32, 14);
$pdf->SetWidths($w);
$pdf->SetAligns(array('C','L','L','C','C','L','L','L','C'));
$pdf->Row(array(
  utf8_decode('ID'),
  utf8_decode('Razón social'),
  utf8_decode('Apellidos, Nombres'),
  'Tipo doc.',
  'Nro. Doc.',
  utf8_decode('Teléfono'),
  'Email',
  'Tipo persona',
  'Estado'
));

$pdf->SetFont('Arial', '', 8);
$count = 0;
if ($rspta !== false) {
  while ($reg = $rspta->fetchObject()) {
    $tipoDoc = isset($reg->tipoDocumento) ? ($reg->tipoDocumento == 1 ? 'RUC' : ($reg->tipoDocumento == 2 ? 'Cédula' : 'Ext.')) : '-';
    $razonSocial = isset($reg->razonSocial) ? $reg->razonSocial : (isset($reg->nombreComercial) ? $reg->nombreComercial : '-');
    $ap = isset($reg->apellidos) ? trim($reg->apellidos) : '';
    $no = isset($reg->nombres) ? trim($reg->nombres) : '';
    $apellidosNombres = ($ap !== '' || $no !== '') ? trim($ap . ($ap && $no ? ', ' : '') . $no) : '-';
    $tel = isset($reg->tel) ? $reg->tel : (isset($reg->telefono) ? $reg->telefono : '-');
    $email = isset($reg->mail) ? $reg->mail : '-';
    $tipoPersonaDesc = isset($reg->tipoPersonaDesc) ? $reg->tipoPersonaDesc : '-';
    $estado = (isset($reg->inactivo) && $reg->inactivo == 1) ? 'Inactivo' : 'Activo';
    $pdf->Row(array(
      $reg->idPersona,
      utf8_decode($razonSocial),
      utf8_decode($apellidosNombres),
      $tipoDoc,
      isset($reg->nroDocumento) ? $reg->nroDocumento : '-',
      utf8_decode($tel),
      utf8_decode($email),
      utf8_decode($tipoPersonaDesc),
      $estado
    ));
    $count++;
  }
}

if ($count === 0) {
  $pdf->Cell(array_sum($w), 6, utf8_decode('No hay registros para el filtro seleccionado.'), 1, 1, 'C');
}

$pdf->Ln(4);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 5, 'Total: ' . $count . ' persona(s)', 0, 1, 'R');

$pdf->Output('I', 'InventarioPersonas_' . date('Y-m-d') . '.pdf');
ob_end_flush();
