<?php
// Formato (logo a la izquierda + datos a la derecha) como los archivos de referencia.
ob_start();
setlocale(LC_MONETARY, 'es_PY');

if (strlen(session_id()) < 1)
  session_start();

// Misma comprobación que en vistas: sesión válida = nombre o login
$logueado = isset($_SESSION["nombre"]) || isset($_SESSION["login"]);
if (!$logueado) {
  echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
  ob_end_flush();
  exit;
}
if (empty($_SESSION['ventas']) || (int)$_SESSION['ventas'] !== 1) {
  echo 'No tiene permiso para visualizar el reporte';
  ob_end_flush();
  exit;
}

require_once "../modelos/Venta.php";
require_once "../modelos/ConfiguracionEmpresa.php";
require_once "../modelos/Moneda.php";

$venta = new Venta();
$config = new ConfiguracionEmpresa();
$moneda_model = new Moneda();
$conf_empresa = $config->obtener();

function moneda_from_id($monedaId) {
  if ((string)$monedaId === '1') return 'PYG';
  if ((string)$monedaId === '2') return 'USD';
  return null;
}
function money_fmt($amount, $currencyCode) {
  $n = (float)$amount;
  if ($currencyCode === 'USD') return 'US$ ' . number_format($n, 2, ',', '.');
  return 'Gs. ' . number_format($n, 0, ',', '.');
}
function currency_label($currencyCode) {
  return $currencyCode === 'USD' ? 'Dólares (USD)' : 'Guaraníes (PYG)';
}

$rspta = $venta->cabeceraWeb($_GET["id"]);
$reg0 = $rspta ? $rspta->fetchObject() : null;

$rspta = $venta->ventacabeceraWeb($_GET["id"]);
$reg = $rspta ? $rspta->fetchObject() : null;
if (!$reg) {
  echo 'Venta no encontrada';
  ob_end_flush();
  exit;
}

// Moneda
$forced = isset($_GET['currency']) ? strtoupper(trim($_GET['currency'])) : null;
if (!$forced && isset($_GET['force_currency'])) $forced = strtoupper(trim($_GET['force_currency']));
$currencyCode = ($forced === 'USD' || $forced === 'PYG') ? $forced : moneda_from_id($reg->Moneda_idMoneda ?? null);
$currencyCode = $currencyCode ?: 'PYG';

// Empresa/sucursal (con config empresa + datos sucursal)
$nombre_empresa = ($conf_empresa && !empty($conf_empresa['nombre_empresa'])) ? $conf_empresa['nombre_empresa'] : ($reg0->nombre ?? 'Empresa');
$ruc_empresa = ($conf_empresa && !empty($conf_empresa['ruc'])) ? $conf_empresa['ruc'] : '';
$logo_ruta = ($conf_empresa && !empty($conf_empresa['logo_ruta'])) ? '../' . $conf_empresa['logo_ruta'] : 'logo.png';

$direccion = 'Dirección: ' . ($reg0->direccion ?? '');
$telefono = 'Tel.: ' . ($reg0->telefono ?? '');
$email = 'E-mail: ' . ($reg0->correo ?? '');
$documento = $ruc_empresa ? ('RUC: ' . $ruc_empresa) : '';

$date1 = $reg0 && isset($reg0->fechaFactura) ? date_create($reg0->fechaFactura) : null;
$date = $reg0 && isset($reg0->vencimiento) ? date_create($reg0->vencimiento) : null;
$autorizacion = $reg0->nroAutorizacion ?? '';

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
  .box { border: 1px solid var(--line); border-radius: 10px; padding: 12px; background: #fff; }
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
  @media print {
    body { margin: 0; }
    .invoice { border: 0; border-radius: 0; margin: 0; max-width: none; }
  }
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
          <?php if (!empty($reg0->direccion)) echo htmlspecialchars($direccion) . '<br>'; ?>
          <?php if (!empty($reg0->telefono)) echo htmlspecialchars($telefono) . '<br>'; ?>
          <?php if (!empty($reg0->correo)) echo htmlspecialchars($email) . '<br>'; ?>
          <?php if ($documento) echo htmlspecialchars($documento); ?>
        </div>
      </div>
    </div>

    <div class="box" style="min-width: 260px;">
      <div class="k">Factura</div>
      <div class="v"><b><?php echo htmlspecialchars(($reg->serie ?? '') . '-' . ($reg->nroFactura ?? '')); ?></b></div>
      <div class="meta" style="margin-top:6px;">
        Fecha: <?php echo $date1 ? htmlspecialchars(date_format($date1, 'd-m-Y')) : ''; ?><br>
        Timbrado: <?php echo htmlspecialchars($reg->timbrado ?? ''); ?><br>
        Venc. timbrado: <?php echo $date ? htmlspecialchars(date_format($date, 'd-m-Y')) : ''; ?><br>
        Autorización: <?php echo htmlspecialchars($autorizacion); ?><br>
        Moneda: <?php echo htmlspecialchars(currency_label($currencyCode)); ?>
      </div>
    </div>
  </div>

  <div class="grid2">
    <div class="box">
      <div class="k">Cliente</div>
      <div class="v"><b><?php echo htmlspecialchars($reg->nombreCliente ?? ''); ?></b></div>
      <div class="meta">
        RUC/CI: <?php echo htmlspecialchars($reg->ruc ?? ''); ?><br>
        Dirección: <?php echo htmlspecialchars($reg->dir ?? ''); ?>
      </div>
    </div>
    <div class="box">
      <div class="k">Condición</div>
      <div class="v"><b><?php echo htmlspecialchars($reg->condicion ?? ''); ?></b></div>
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
    <?php
    $rsptad = $venta->ventadetalle($_GET["id"]);
    $cantidad = 0;
    $exentas = 0;
    $iva5Base = 0;
    $iva10Base = 0;
    while ($rsptad && ($regd = $rsptad->fetchObject())) {
        $cantidad += (float)$regd->cantidad;
        $precio = (float)$regd->precio;
        $descuento = isset($regd->descuento) ? (float)$regd->descuento : 0.0;
        $precioUnit = $precio - (($precio * $descuento) / 100);
        $totalItem = $precioUnit * (float)$regd->cantidad;

        if ((int)$regd->impuesto === 0) $exentas += $totalItem;
        if ((int)$regd->impuesto === 5) $iva5Base += $totalItem;
        if ((int)$regd->impuesto === 10) $iva10Base += $totalItem;
        ?>
        <tr>
          <td><?php echo htmlspecialchars($regd->cantidad); ?></td>
          <td><?php echo htmlspecialchars($regd->descripcionarticulo); ?></td>
          <td class="num"><?php echo htmlspecialchars($regd->impuesto); ?>%</td>
          <td class="num"><?php echo htmlspecialchars(money_fmt($precioUnit, $currencyCode)); ?></td>
          <td class="num"><b><?php echo htmlspecialchars(money_fmt($totalItem, $currencyCode)); ?></b></td>
        </tr>
        <?php
    }
    $iva10Tax = $iva10Base / 11;
    $iva5Tax = $iva5Base / 21;
    ?>
    </tbody>
  </table>

  <div class="summary">
    <div class="box">
      <div class="sumrow"><span>Total ítems</span><span><b><?php echo htmlspecialchars((string)$cantidad); ?></b></span></div>
      <div class="sumrow"><span>Exentas</span><span><?php echo htmlspecialchars(money_fmt($exentas, $currencyCode)); ?></span></div>
      <div class="sumrow"><span>IVA 5%</span><span><?php echo htmlspecialchars(money_fmt($iva5Tax, $currencyCode)); ?></span></div>
      <div class="sumrow"><span>IVA 10%</span><span><?php echo htmlspecialchars(money_fmt($iva10Tax, $currencyCode)); ?></span></div>
      <div class="sumrow total"><span>Total</span><span><?php echo htmlspecialchars(money_fmt($reg->total ?? 0, $currencyCode)); ?></span></div>
    </div>
  </div>

  <div class="footer">
    <div>Factupar Software · <?php echo htmlspecialchars(!empty($reg0->correo) ? $reg0->correo : 'factupar.com.py'); ?></div>
    <div>Paraguay</div>
  </div>
</div>
</body>
</html>
<?php
ob_end_flush();
?>
