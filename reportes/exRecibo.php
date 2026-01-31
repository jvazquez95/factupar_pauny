<?php
ob_start();
setlocale(LC_MONETARY, 'en_US');

if (strlen(session_id()) < 1) session_start();
if (!isset($_SESSION["nombre"])) { echo 'Debe ingresar al sistema correctamente para visualizar el reporte'; exit; }
if ($_SESSION['ventas'] != 1) { echo 'No tiene permiso para visualizar el reporte'; exit; }

require_once "../modelos/Recibo.php";
require_once "../modelos/Moneda.php";

$conf_empresa = null;
if (file_exists(dirname(__DIR__) . "/modelos/ConfiguracionEmpresa.php")) {
  require_once "../modelos/ConfiguracionEmpresa.php";
  try { $config = new ConfiguracionEmpresa(); $conf_empresa = $config->obtener(); } catch (Exception $e) { }
}

if (empty($_GET['idRecibo'])) { echo 'Falta el número de recibo'; exit; }

$oc = new Recibo();
$moneda_model = new Moneda();
$rspta = $oc->rpt_recibo_cabecera($_GET['idRecibo']);
if (!$rspta) { echo 'Error al obtener el recibo'; exit; }
$reg0 = $rspta->fetchObject();
if (!$reg0) { echo 'Recibo no encontrado'; exit; }

$_SESSION["nroDoc"] = isset($reg0->nroDocumento) ? $reg0->nroDocumento : '';
$_SESSION["razonSocial"] = isset($reg0->razonSocial) ? $reg0->razonSocial : '';
date_default_timezone_set('America/Asuncion');

$monedaId = $reg0->MONEDA_IDMONEDA ?? ($reg0->Moneda_idMoneda ?? null);
$currencyCode = null;
if ((string)$monedaId === '2') $currencyCode = 'USD';
if ((string)$monedaId === '1') $currencyCode = 'PYG';
if (!$currencyCode) $currencyCode = 'PYG';

function money_fmt_recibo($amount, $currencyCode) {
  $n = (float)$amount;
  if ($currencyCode === 'USD') return 'US$ ' . number_format($n, 2, ',', '.');
  return 'Gs. ' . number_format($n, 0, ',', '.');
}
function currency_label_recibo($currencyCode) {
  return $currencyCode === 'USD' ? 'Dólares (USD)' : 'Guaraníes (PYG)';
}

$nombre_empresa = ($conf_empresa && !empty($conf_empresa['nombre_empresa'])) ? $conf_empresa['nombre_empresa'] : 'Mi Empresa';
$ruc_empresa = ($conf_empresa && !empty($conf_empresa['ruc'])) ? $conf_empresa['ruc'] : '';
$direccion = isset($reg0->direccionSucursal) ? $reg0->direccionSucursal : (isset($reg0->direccion) ? $reg0->direccion : '');
$telefono = isset($reg0->telefonoSucursal) ? $reg0->telefonoSucursal : (isset($reg0->telefono) ? $reg0->telefono : '');
$email = isset($reg0->correo) ? $reg0->correo : '';
$logo_ruta = ($conf_empresa && !empty($conf_empresa['logo_ruta'])) ? '../' . $conf_empresa['logo_ruta'] : 'logo.png';
$color_primario = ($conf_empresa && !empty($conf_empresa['color_primario'])) ? $conf_empresa['color_primario'] : '#333';
$date = isset($reg0->FECHARECIBO) ? date_create($reg0->FECHARECIBO) : null;
$cajero = isset($reg0->cajero) ? $reg0->cajero : '';

$rsptad = $oc->rpt_recibo_detalle($_GET["idRecibo"]);
$detalle_facturas = array();
$total2 = 0;
if ($rsptad) {
  while ($regd = $rsptad->fetchObject()) {
    $detalle_facturas[] = $regd;
    $total2 += (float)(isset($regd->MONTOAPLICADO) ? $regd->MONTOAPLICADO : 0);
  }
}

$rsptad = $oc->rpt_recibo_detalle_pago($_GET["idRecibo"]);
$detalle_pagos = array();
if ($rsptad) {
  while ($regd = $rsptad->fetchObject()) $detalle_pagos[] = $regd;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="../public/css/ticket.css" rel="stylesheet" type="text/css">
<style>
  :root { --fg:#111827; --muted:#6b7280; --line:#e5e7eb; }
  body { background: #fff !important; margin: 0; padding: 0; color: var(--fg); font-family: Arial, sans-serif; }
  .recibo { max-width: 720px; margin: 24px auto; padding: 24px; border: 1px solid var(--line); border-radius: 12px; }
  .row { display:flex; gap:16px; justify-content:space-between; align-items:flex-start; flex-wrap: wrap; }
  .brand { display:flex; gap:16px; align-items:center; }
  .brand img { max-height: 64px; width: auto; object-fit: contain; }
  .h1 { font-size: 18px; font-weight: 700; margin: 0; }
  .meta { font-size: 12px; color: var(--muted); line-height: 1.5; }
  .box { border: 1px solid var(--line); border-radius: 10px; padding: 12px; background:#fff; }
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
      <img src="<?php echo htmlspecialchars($logo_ruta); ?>" alt="Logo" onerror="this.style.display='none'">
      <div>
        <p class="h1"><?php echo htmlspecialchars($nombre_empresa); ?></p>
        <div class="meta">
          <?php if ($direccion) echo htmlspecialchars($direccion) . '<br>'; ?>
          <?php if ($telefono) echo 'Tel.: ' . htmlspecialchars($telefono) . '<br>'; ?>
          <?php if ($email) echo 'E-mail: ' . htmlspecialchars($email) . '<br>'; ?>
          <?php if ($ruc_empresa) echo 'RUC: ' . htmlspecialchars($ruc_empresa); ?>
        </div>
      </div>
    </div>
    <div class="box" style="min-width: 220px;">
      <div class="k">Recibo</div>
      <div class="v"><b>Nº <?php echo htmlspecialchars($reg0->IDRECIBO ?? ($reg0->idRecibo ?? '')); ?></b></div>
      <div class="meta" style="margin-top:6px;">
        Fecha: <?php echo $date ? htmlspecialchars(date_format($date, 'd-m-Y')) : ''; ?><br>
        Cajero: <?php echo htmlspecialchars($cajero); ?>
        <br>Moneda: <?php echo htmlspecialchars(currency_label_recibo($currencyCode)); ?>
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
<?php foreach ($detalle_facturas as $regd): ?>
      <tr>
        <td><?php echo htmlspecialchars($regd->impCuota ?? ''); ?></td>
        <td><?php echo htmlspecialchars($regd->nroOficial ?? ''); ?></td>
        <td class="num"><?php echo htmlspecialchars(money_fmt_recibo((float)($regd->MONTOAPLICADO ?? 0), $currencyCode)); ?></td>
      </tr>
<?php endforeach; ?>
    </tbody>
  </table>

  <table>
    <thead><tr><th>Forma de pago</th><th class="num" style="width:140px;">Monto</th></tr></thead>
    <tbody>
<?php foreach ($detalle_pagos as $regd):
  $desc = $regd->descripcion ?? ($regd->DESCRIPCION ?? 'Pago');
  $monto = $regd->MONTO ?? 0; ?>
      <tr>
        <td><?php echo htmlspecialchars($desc); ?></td>
        <td class="num"><?php echo htmlspecialchars(money_fmt_recibo((float)$monto, $currencyCode)); ?></td>
      </tr>
<?php endforeach; ?>
    </tbody>
  </table>

  <div class="box" style="margin-top: 14px; display: flex; justify-content: flex-end;">
    <div style="min-width: 260px;">
      <div style="display:flex; justify-content:space-between; padding: 8px 0; border-bottom: 1px dashed var(--line);">
        <span><b>Total recibo</b></span>
        <span class="total-row"><?php echo htmlspecialchars(money_fmt_recibo((float)$total2, $currencyCode)); ?></span>
      </div>
    </div>
  </div>

  <div class="footer" style="margin-top: 24px;">
    <div>Factupar Software · <?php echo htmlspecialchars($email ? $email : 'factupar.com.py'); ?></div>
    <div>Paraguay</div>
  </div>
</div>
</body>
</html>
<?php ob_end_flush(); ?>
