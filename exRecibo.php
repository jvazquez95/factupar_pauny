<?php
/**
 * Puente de compatibilidad.
 *
 * Este archivo en la raíz (`pauny/exRecibo.php`) se mantiene solo para rutas
 * antiguas. El reporte real vive en `pauny/reportes/exRecibo.php`.
 */
$reportDir = __DIR__ . '/reportes';
$reportFile = $reportDir . '/exRecibo.php';
if (is_file($reportFile)) {
  $prevCwd = getcwd();
  @chdir($reportDir);
  require $reportFile;
  @chdir($prevCwd);
} else {
  echo 'Reporte no encontrado: reportes/exRecibo.php';
}
if (function_exists('ob_end_flush')) { @ob_end_flush(); }
exit;

//Activamos el almacenamiento en el buffer
ob_start();
setlocale(LC_MONETARY, 'es_PY');

if (strlen(session_id()) < 1)
  session_start();

function moneda_from_id_recibo($monedaId) {
  if ((string)$monedaId === '1') return 'PYG';
  if ((string)$monedaId === '2') return 'USD';
  return null;
}

function money_fmt_recibo($amount, $currencyCode) {
  $n = (float)$amount;
  if ($currencyCode === 'USD') return 'US$ ' . number_format($n, 2, ',', '.');
  return 'Gs. ' . number_format($n, 0, ',', '.');
}

function currency_label_recibo($currencyCode) {
  return $currencyCode === 'USD' ? 'Dólares (USD)' : 'Guaraníes (PYG)';
}

$logueado = isset($_SESSION["nombre"]) || isset($_SESSION["login"]);
if (!$logueado) {
  echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
} else if (empty($_SESSION['ventas']) || (int)$_SESSION['ventas'] !== 1) {
  echo 'No tiene permiso para visualizar el reporte';
} else {

require_once "../modelos/Recibo.php";
$oc = new Recibo();
$rspta = $oc->rpt_recibo_cabecera($_GET['idRecibo']);
$reg0 = $rspta->fetchObject();

if (!$reg0) {
  echo 'Recibo no encontrado';
  ob_end_flush();
  exit;
}

$_SESSION["nroDoc"] = $reg0->nroDocumento ?? null;
$_SESSION["razonSocial"] = $reg0->razonSocial ?? null;
date_default_timezone_set('America/Asuncion');

$monedaId = $reg0->Moneda_idMoneda ?? $reg0->MONEDA_IDMONEDA ?? null;
$forced = isset($_GET['currency']) ? strtoupper(trim($_GET['currency'])) : null;
if (isset($_GET['force_currency'])) $forced = strtoupper(trim($_GET['force_currency']));
$currencyCode = ($forced === 'USD' || $forced === 'PYG') ? $forced : moneda_from_id_recibo($monedaId);
$currencyCode = $currencyCode ?: 'PYG';

$empresa = $reg0->sucursal ?? 'Factupar';
$documento = "RUC: " . ($reg0->nroDocumento ?? '4831750-0');
$direccion = $reg0->direccionSucursal ?? '';
$telefono = $reg0->telefonoSucursal ?? '';
$email = 'E-mail: ' . ($reg0->correo ?? 'junior.vazquez@factupar.com.py');
$date = date_create($reg0->FECHARECIBO);
$cajero = $reg0->cajero ?? '';

$rsptad = $oc->rpt_recibo_detalle($_GET["idRecibo"]);
$totalRecibo = 0;
while ($regd = $rsptad->fetchObject()) { $totalRecibo += (float)$regd->MONTOAPLICADO; }
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
  :root { --fg:#111827; --muted:#6b7280; --line:#e5e7eb; }
  body { background: #fff !important; margin: 0; padding: 0; color: var(--fg); font-family: Arial, sans-serif; }
  .recibo { max-width: 720px; margin: 24px auto; padding: 24px; border: 1px solid var(--line); border-radius: 12px; }
  .row { display:flex; gap:16px; justify-content:space-between; align-items:flex-start; flex-wrap: wrap; }
  .brand { display:flex; gap:16px; align-items:center; }
  .brand img { max-height: 64px; width: auto; object-fit: contain; }
  .h1 { font-size: 18px; font-weight: 700; margin: 0; }
  .meta { font-size: 12px; color: var(--muted); line-height: 1.5; }
  .box { border: 1px solid var(--line); border-radius: 10px; padding: 12px; }
  .k { font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: .04em; }
  .v { font-size: 13px; margin-top: 2px; }
  table { width:100%; border-collapse: collapse; margin-top: 12px; }
  th, td { border-bottom: 1px solid var(--line); padding: 10px 8px; font-size: 12px; text-align: left; }
  th { color: var(--muted); font-weight: 700; }
  td.num, th.num { text-align: right; white-space: nowrap; }
  .total-row { font-weight: 700; font-size: 14px; }
  .footer { margin-top: 18px; font-size: 11px; color: var(--muted); display:flex; justify-content:space-between; gap:12px; flex-wrap:wrap; }
  @media print { body { margin: 0; } .recibo { border: 0; border-radius: 0; margin: 0; max-width: none; } }
</style>
</head>
<body onload="window.print();">
<div class="recibo">
  <div class="row">
    <div class="brand">
      <img src="logo.png" alt="Logo">
      <div>
        <p class="h1"><?php echo htmlspecialchars($empresa); ?></p>
        <div class="meta">
          <?php if ($direccion) echo htmlspecialchars($direccion) . '<br>'; ?>
          <?php if ($telefono) echo htmlspecialchars($telefono) . '<br>'; ?>
          <?php echo htmlspecialchars($email); ?><br>
          <?php echo htmlspecialchars($documento); ?>
        </div>
      </div>
    </div>
    <div class="box" style="min-width: 220px;">
      <div class="k">Recibo</div>
      <div class="v"><b>Nº <?php echo htmlspecialchars($reg0->IDRECIBO ?? $reg0->idRecibo); ?></b></div>
      <div class="meta" style="margin-top:6px;">
        Fecha: <?php echo htmlspecialchars(date_format($date, 'd-m-Y')); ?><br>
        Cajero: <?php echo htmlspecialchars($cajero); ?><br>
        Moneda: <?php echo htmlspecialchars(currency_label_recibo($currencyCode)); ?>
      </div>
    </div>
  </div>
  <div class="box" style="margin-top: 14px;">
    <div class="k">Cliente</div>
    <div class="v"><b><?php echo htmlspecialchars($reg0->razonSocial ?? ''); ?></b></div>
    <div class="meta">RUC/C.I: <?php echo htmlspecialchars($reg0->nroDocumento ?? ''); ?></div>
  </div>
  <table>
    <thead><tr><th style="width:80px;">Cuota</th><th>Factura</th><th class="num" style="width:140px;">Importe</th></tr></thead>
    <tbody>
    <?php
    $rsptad = $oc->rpt_recibo_detalle($_GET["idRecibo"]);
    while ($regd = $rsptad->fetchObject()) {
      echo '<tr><td>' . htmlspecialchars($regd->impCuota ?? '') . '</td><td>' . htmlspecialchars($regd->nroOficial ?? '') . '</td><td class="num">' . htmlspecialchars(money_fmt_recibo($regd->MONTOAPLICADO, $currencyCode)) . '</td></tr>';
    }
    ?>
    </tbody>
  </table>
  <table>
    <thead><tr><th>Forma de pago</th><th class="num" style="width:140px;">Monto</th></tr></thead>
    <tbody>
    <?php
    $rsptad = $oc->rpt_recibo_detalle_pago($_GET["idRecibo"]);
    while ($regd = $rsptad->fetchObject()) {
      echo '<tr><td>' . htmlspecialchars($regd->descripcion ?? '') . '</td><td class="num">' . htmlspecialchars(money_fmt_recibo($regd->MONTO, $currencyCode)) . '</td></tr>';
    }
    ?>
    </tbody>
  </table>
  <div class="box" style="margin-top: 14px; display: flex; justify-content: flex-end;">
    <div style="min-width: 260px;">
      <div style="display:flex; justify-content:space-between; padding: 8px 0; border-bottom: 1px dashed var(--line);">
        <span><b>Total recibo</b></span>
        <span class="total-row"><?php echo htmlspecialchars(money_fmt_recibo($totalRecibo, $currencyCode)); ?></span>
      </div>
    </div>
  </div>
  <div class="footer" style="margin-top: 24px;">
    <div>Factupar Software · junior.vazquez@factupar.com.py</div>
    <div>Paraguay</div>
  </div>
</div>
</body>
</html>
<?php
}
ob_end_flush();
?>