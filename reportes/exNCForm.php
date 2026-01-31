<?php
// Nota de crédito con el mismo diseño de exFacturaForm.php (logo izquierda + caja derecha).
ob_start();
setlocale(LC_MONETARY, 'es_PY');

if (strlen(session_id()) < 1) session_start();
if (!isset($_SESSION["nombre"])) { echo 'Debe ingresar al sistema correctamente para visualizar el reporte'; exit; }
if ($_SESSION['ventas'] != 1) { echo 'No tiene permiso para visualizar el reporte'; exit; }

require_once "../modelos/Venta.php";
require_once "../modelos/ConfiguracionEmpresa.php";

if (empty($_GET["id"])) { echo 'Falta el número de nota de crédito'; exit; }

$conf_empresa = null;
if (file_exists(dirname(__DIR__) . "/modelos/ConfiguracionEmpresa.php")) {
  require_once "../modelos/ConfiguracionEmpresa.php";
  try { $config = new ConfiguracionEmpresa(); $conf_empresa = $config->obtener(); } catch (Exception $e) { }
}

$venta = new Venta();
$nombre_empresa = ($conf_empresa && !empty($conf_empresa['nombre_empresa'])) ? $conf_empresa['nombre_empresa'] : 'Mi Empresa';
$ruc_empresa = ($conf_empresa && !empty($conf_empresa['ruc'])) ? $conf_empresa['ruc'] : '';
$logo_ruta = ($conf_empresa && !empty($conf_empresa['logo_ruta'])) ? '../' . $conf_empresa['logo_ruta'] : 'logo.png';
$color_primario = ($conf_empresa && !empty($conf_empresa['color_primario'])) ? $conf_empresa['color_primario'] : '#1e3a5f';

$rspta = $venta->ventacabeceraWebNC($_GET["id"]);
if (!$rspta) { echo 'Error al obtener la nota de crédito'; exit; }
$reg = $rspta->fetchObject();
if (!$reg) { echo 'Nota de crédito no encontrada'; exit; }

$id_venta = isset($reg->venta_idVenta) ? $reg->venta_idVenta : (isset($reg->Venta_idVenta) ? $reg->Venta_idVenta : null);
$reg0 = null;
$nombre_sucursal = 'Sucursal';
$direccion_empresa = '';
$telefono_empresa = '';
$email_empresa = '';
$ciudad_sucursal = '';
$autorizacion = '';
$vencimiento_timbrado = '';

if ($id_venta) {
  $rspta0 = $venta->cabeceraWeb($id_venta);
  if ($rspta0) {
    $reg0 = $rspta0->fetchObject();
    if ($reg0) {
      $nombre_sucursal = isset($reg0->nombre) ? $reg0->nombre : 'Sucursal';
      $direccion_empresa = isset($reg0->direccion) ? $reg0->direccion : '';
      $telefono_empresa = isset($reg0->telefono) ? $reg0->telefono : '';
      $email_empresa = isset($reg0->correo) ? $reg0->correo : '';
      $ciudad_sucursal = isset($reg0->ciudad) ? $reg0->ciudad : '';
      $autorizacion = isset($reg0->nroAutorizacion) ? $reg0->nroAutorizacion : '';
      $vencimiento_timbrado = isset($reg0->vencimiento) ? $reg0->vencimiento : '';
    }
  }
}
if (!$reg0 && isset($reg->timbrado)) {
  $autorizacion = isset($reg->nroAutorizacion) ? $reg->nroAutorizacion : '';
  $vencimiento_timbrado = isset($reg->vtoTimbrado) ? $reg->vtoTimbrado : '';
}

$fecha_factura = isset($reg->fecha) ? $reg->fecha : (isset($reg->fechaFactura) ? $reg->fechaFactura : (isset($reg->fechaTransaccion) ? $reg->fechaTransaccion : date('Y-m-d')));
$date1 = date_create($fecha_factura);
$date = $vencimiento_timbrado ? date_create($vencimiento_timbrado) : null;

function moneda_from_id_nc($monedaId) {
  if ((string)$monedaId === '1') return 'PYG';
  if ((string)$monedaId === '2') return 'USD';
  return null;
}
function money_fmt_nc($amount, $currencyCode) {
  $n = (float)$amount;
  if ($currencyCode === 'USD') return 'US$ ' . number_format($n, 2, ',', '.');
  return 'Gs. ' . number_format($n, 0, ',', '.');
}
function currency_label_nc($currencyCode) {
  return $currencyCode === 'USD' ? 'Dólares (USD)' : 'Guaraníes (PYG)';
}

$currencyCode = moneda_from_id_nc($reg->Moneda_idMoneda ?? null) ?: 'PYG';

$rsptad = $venta->ventadetalleNc($_GET["id"]);
$detalle_items = array();
$exentas = 0;
$iva5Base = 0;
$iva10Base = 0;
if ($rsptad) {
  while ($regd = $rsptad->fetchObject()) {
    $detalle_items[] = $regd;
    // En NC, el % IVA viene desde articulo->tipoimpuesto (ver Venta::ventadetalleNC)
    $impuesto_pct = isset($regd->impuesto) ? (float)$regd->impuesto : 0;
    $total_linea = isset($regd->total) ? (float)$regd->total : ($regd->precio * $regd->cantidad);
    if ($impuesto_pct == 0) $exentas += $total_linea;
    if ($impuesto_pct == 5) $iva5Base += $total_linea;
    if ($impuesto_pct == 10) $iva10Base += $total_linea;
  }
}
$total_nc = isset($reg->total) ? (float) $reg->total : 0;
$timbrado_nc = isset($reg->timbrado) ? $reg->timbrado : '';
$serie_nc = isset($reg->serie) ? $reg->serie : '';
$nro_factura_nc = isset($reg->nroFactura) ? $reg->nroFactura : '';
$dir_cliente = isset($reg->dir) ? $reg->dir : (isset($reg->cd) ? $reg->cd : '—');
$condicion_nc = isset($reg->condicion) ? $reg->condicion : '—';
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="../public/css/ticket.css" rel="stylesheet" type="text/css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
  :root { --fg:#111827; --muted:#6b7280; --line:#e5e7eb; }
  body { background: #fff !important; margin: 0; padding: 0; color: var(--fg); font-family: Arial, sans-serif; }
  .invoice { max-width: 820px; margin: 24px auto; padding: 24px; border: 1px solid var(--line); border-radius: 12px; }
  .row { display:flex; gap:16px; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; }
  .brand { display:flex; gap:16px; align-items:center; }
  .brand img { max-height: 64px; width: auto; object-fit: contain; }
  .h1 { font-size: 18px; font-weight: 700; margin: 0; }
  .meta { font-size: 12px; color: var(--muted); line-height: 1.45; }
  .box { border: 1px solid var(--line); border-radius: 10px; padding: 12px; background:#fff; }
  .grid2 { display:grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 12px; }
  .k { font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: .04em; }
  .v { font-size: 13px; margin-top: 2px; }
  table { width:100%; border-collapse: collapse; margin-top: 14px; }
  th, td { border-bottom: 1px solid var(--line); padding: 10px 8px; font-size: 12px; vertical-align: top; }
  th { text-align:left; color: var(--muted); font-weight: 700; }
  td.num, th.num { text-align:right; white-space: nowrap; }
  .summary { display:flex; justify-content:flex-end; margin-top: 14px; }
  .summary .box { min-width: 320px; }
  .sumrow { display:flex; justify-content:space-between; gap:12px; padding: 6px 0; border-bottom: 1px dashed var(--line); }
  .sumrow:last-child { border-bottom: 0; }
  .total { font-size: 14px; font-weight: 800; }
  .footer { margin-top: 18px; font-size: 11px; color: var(--muted); display:flex; justify-content:space-between; gap:12px; flex-wrap:wrap; }
  @media print { body { margin: 0; } .invoice { border: 0; border-radius: 0; margin: 0; max-width: none; } }
</style>
</head>
<body onload="window.print();">
<div class="invoice">
  <div class="row">
    <div class="brand">
      <img src="<?php echo htmlspecialchars($logo_ruta); ?>" alt="Logo" onerror="this.style.display='none'">
      <div>
        <p class="h1"><?php echo htmlspecialchars($nombre_empresa); ?></p>
        <div class="meta">
          <?php if ($direccion_empresa) echo htmlspecialchars('Dirección: ' . $direccion_empresa) . '<br>'; ?>
          <?php if ($telefono_empresa) echo htmlspecialchars('Tel.: ' . $telefono_empresa) . '<br>'; ?>
          <?php if ($email_empresa) echo htmlspecialchars('E-mail: ' . $email_empresa) . '<br>'; ?>
          <?php if ($ruc_empresa) echo htmlspecialchars('RUC: ' . $ruc_empresa); ?>
        </div>
      </div>
    </div>

    <div class="box" style="min-width: 260px;">
      <div class="k">Nota de crédito</div>
      <div class="v"><b><?php echo htmlspecialchars(($serie_nc ?? '') . '-' . ($nro_factura_nc ?? '')); ?></b></div>
      <div class="meta" style="margin-top:6px;">
        Fecha: <?php echo $date1 ? htmlspecialchars(date_format($date1, 'd-m-Y')) : ''; ?><br>
        Timbrado: <?php echo htmlspecialchars($timbrado_nc); ?><br>
        Venc. timbrado: <?php echo $date ? htmlspecialchars(date_format($date, 'd-m-Y')) : ''; ?><br>
        Autorización: <?php echo htmlspecialchars($autorizacion); ?><br>
        Moneda: <?php echo htmlspecialchars(currency_label_nc($currencyCode)); ?>
      </div>
    </div>
  </div>

  <div class="grid2">
    <div class="box">
      <div class="k">Cliente</div>
      <div class="v"><b><?php echo htmlspecialchars($reg->nombreCliente ?? ''); ?></b></div>
      <div class="meta">
        RUC/CI: <?php echo htmlspecialchars($reg->ruc ?? ''); ?><br>
        Dirección: <?php echo htmlspecialchars($dir_cliente); ?>
      </div>
    </div>
    <div class="box">
      <div class="k">Condición</div>
      <div class="v"><b><?php echo htmlspecialchars($condicion_nc); ?></b></div>
      <div class="meta">Original: Cliente</div>
    </div>
  </div>

  <table>
    <thead>
      <tr>
        <th style="width:60px;">Cant.</th>
        <th>Descripción</th>
        <th class="num" style="width:70px;">IVA</th>
        <th class="num" style="width:120px;">Precio unit.</th>
        <th class="num" style="width:120px;">Total</th>
      </tr>
    </thead>
    <tbody>
<?php foreach ($detalle_items as $regd):
  $importe = isset($regd->total) ? (float)$regd->total : ((float)$regd->precio * (float)$regd->cantidad);
  $impuesto_pct = isset($regd->impuesto) ? (int)$regd->impuesto : 0;
?>
      <tr>
        <td><?php echo htmlspecialchars($regd->cantidad); ?></td>
        <td><?php echo htmlspecialchars($regd->descripcionarticulo); ?></td>
        <td class="num"><?php echo $impuesto_pct; ?>%</td>
        <td class="num"><?php echo htmlspecialchars(money_fmt_nc($regd->precio, $currencyCode)); ?></td>
        <td class="num"><b><?php echo htmlspecialchars(money_fmt_nc($importe, $currencyCode)); ?></b></td>
      </tr>
<?php endforeach; ?>
    </tbody>
  </table>

<?php
  $iva10Tax = $iva10Base / 11;
  $iva5Tax = $iva5Base / 21;
?>
  <div class="summary">
    <div class="box">
      <div class="sumrow"><span>Total ítems</span><span><b><?php echo htmlspecialchars((string)count($detalle_items)); ?></b></span></div>
      <div class="sumrow"><span>Exentas</span><span><?php echo htmlspecialchars(money_fmt_nc($exentas, $currencyCode)); ?></span></div>
      <div class="sumrow"><span>IVA 5%</span><span><?php echo htmlspecialchars(money_fmt_nc($iva5Tax, $currencyCode)); ?></span></div>
      <div class="sumrow"><span>IVA 10%</span><span><?php echo htmlspecialchars(money_fmt_nc($iva10Tax, $currencyCode)); ?></span></div>
      <div class="sumrow total"><span>Total</span><span><?php echo htmlspecialchars(money_fmt_nc($total_nc, $currencyCode)); ?></span></div>
    </div>
  </div>

  <div class="footer">
    <div>Factupar Software · <?php echo htmlspecialchars($email_empresa ? $email_empresa : 'factupar.com.py'); ?></div>
    <div>Paraguay</div>
  </div>
</div>
</body>
</html>
<?php ob_end_flush(); ?>
