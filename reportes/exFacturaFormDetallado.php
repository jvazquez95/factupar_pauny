<?php
ob_start();
setlocale(LC_MONETARY, 'en_US');

if (strlen(session_id()) < 1) session_start();
if (!isset($_SESSION["nombre"])) { echo 'Debe ingresar al sistema correctamente para visualizar el reporte'; exit; }
if ($_SESSION['ventas'] != 1) { echo 'No tiene permiso para visualizar el reporte'; exit; }

require_once "../modelos/Venta.php";
require_once "../modelos/Recibo.php";

$conf_empresa = null;
if (file_exists(dirname(__DIR__) . "/modelos/ConfiguracionEmpresa.php")) {
  require_once "../modelos/ConfiguracionEmpresa.php";
  try { $config = new ConfiguracionEmpresa(); $conf_empresa = $config->obtener(); } catch (Exception $e) { }
}

function formatearMoneda($monto, $idMoneda = 1) {
  $monto = (float) $monto;
  if (isset($idMoneda) && (int)$idMoneda === 2) return 'US$ ' . number_format($monto, 2, ',', '.');
  return number_format($monto, 0, '', '.') . ' Gs.';
}

if (empty($_GET["id"])) { echo 'Falta el número de factura'; exit; }

$venta = new Venta();
$nombre_empresa = ($conf_empresa && !empty($conf_empresa['nombre_empresa'])) ? $conf_empresa['nombre_empresa'] : 'Mi Empresa';
$ruc_empresa = ($conf_empresa && !empty($conf_empresa['ruc'])) ? $conf_empresa['ruc'] : '';
$logo_ruta = ($conf_empresa && !empty($conf_empresa['logo_ruta'])) ? '../' . $conf_empresa['logo_ruta'] : 'logo.png';
$color_primario = ($conf_empresa && !empty($conf_empresa['color_primario'])) ? $conf_empresa['color_primario'] : '#333';

$rspta = $venta->cabeceraWeb($_GET["id"]);
if (!$rspta) { echo 'Error al obtener la factura'; exit; }
$reg0 = $rspta->fetchObject();
if (!$reg0) { echo 'Factura no encontrada'; exit; }

$direccion_empresa = $reg0 ? (isset($reg0->direccion) ? $reg0->direccion : '') : '';
$telefono_empresa = $reg0 ? (isset($reg0->telefono) ? $reg0->telefono : '') : '';
$email_empresa = $reg0 ? (isset($reg0->correo) ? $reg0->correo : '') : '';

$rspta = $venta->sumarImpresiones($_GET["id"]);
$impresiones = $rspta->fetch();
$imp = ($impresiones && $impresiones[0] > 1) ? 'COPIA' : '';

$rspta = $venta->ventacabeceraWeb($_GET["id"]);
if (!$rspta) { echo 'Error al obtener datos de la factura'; exit; }
$reg = $rspta->fetchObject();
if (!$reg) { echo 'Datos de factura no encontrados'; exit; }

$idMoneda = isset($reg->Moneda_idMoneda) ? (int)$reg->Moneda_idMoneda : 1;
$simbolo = ($idMoneda === 2) ? 'US$' : 'Gs.';
$date1 = date_create($reg0->fechaFactura);
$autorizacion = $reg0->nroAutorizacion;
$date = date_create($reg0->vencimiento);

$detalle = [];
$cantidad = 0;
$rsptad = $venta->ventadetalle($_GET["id"]);
if ($rsptad) {
  while ($regd = $rsptad->fetchObject()) { $detalle[] = $regd; $cantidad += $regd->cantidad; }
}

$oc = new Recibo();
$pagos = [];
$totalPago = 0;
$rsptap = $oc->rpt_recibo_detalle_pago_factura($_GET["id"]);
if ($rsptap) {
  while ($regp = $rsptap->fetchObject()) {
    $pagos[] = $regp;
    $totalPago += (float)(isset($regp->MONTO) ? $regp->MONTO : (isset($regp->MONTOAPLICADO) ? $regp->MONTOAPLICADO : 0));
  }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="../public/css/ticket.css" rel="stylesheet" type="text/css">
<style>
.factura { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
.factura .encabezado { text-align: center; margin-bottom: 20px; border-bottom: 2px solid <?php echo htmlspecialchars($color_primario); ?>; padding-bottom: 15px; }
.factura .encabezado img { max-height: 90px; max-width: 220px; }
.factura .encabezado h1 { margin: 8px 0 4px; font-size: 1.4em; color: <?php echo htmlspecialchars($color_primario); ?>; }
.factura .datos-empresa { font-size: 0.9em; color: #555; line-height: 1.4; }
.factura .bloque-doc { margin: 15px 0; padding: 12px; background: #f8f8f8; border-radius: 6px; }
.factura .bloque-cliente { margin: 15px 0; padding: 12px; border: 1px solid #ddd; border-radius: 6px; }
.factura table.detalle { width: 100%; border-collapse: collapse; margin: 15px 0; }
.factura table.detalle th, .factura table.detalle td { border: 1px solid #ddd; padding: 8px; text-align: left; }
.factura table.detalle th { background: <?php echo htmlspecialchars($color_primario); ?>; color: #fff; font-size: 0.9em; }
.factura table.detalle th.num, .factura table.detalle td.num { text-align: right; }
.factura table.detalle tr:nth-child(even) { background: #f9f9f9; }
.factura .totales { text-align: right; margin-top: 15px; font-size: 1.05em; }
.factura .pie { margin-top: 25px; padding-top: 12px; border-top: 1px solid #ddd; text-align: center; font-size: 0.85em; color: #666; }
</style>
</head>
<body onload="window.print();">
<div class="factura">
  <div class="encabezado">
    <img src="<?php echo htmlspecialchars($logo_ruta); ?>" alt="<?php echo htmlspecialchars($nombre_empresa); ?>" onerror="this.style.display='none'">
    <h1><?php echo htmlspecialchars($nombre_empresa); ?></h1>
    <div class="datos-empresa">
      <?php if ($ruc_empresa) echo 'RUC: ' . htmlspecialchars($ruc_empresa) . '<br>'; ?>
      <?php if ($direccion_empresa) echo htmlspecialchars($direccion_empresa) . '<br>'; ?>
      <?php if ($telefono_empresa) echo 'Tel.: ' . htmlspecialchars($telefono_empresa) . '<br>'; ?>
      <?php if ($email_empresa) echo 'E-mail: ' . htmlspecialchars($email_empresa); ?>
    </div>
  </div>

  <div class="bloque-doc">
    <strong>Timbrado:</strong> <?php echo htmlspecialchars($reg->timbrado); ?> &nbsp;|&nbsp;
    <strong>Venc. Timbrado:</strong> <?php echo date_format($date, 'd-m-Y'); ?><br>
    <strong>Factura Nro:</strong> <?php echo htmlspecialchars($reg->serie); ?>-<?php echo htmlspecialchars($reg->nroFactura); ?> &nbsp;|&nbsp;
    <strong>Fecha:</strong> <?php echo date_format($date1, 'd-m-Y'); ?><br>
    <strong>Condición:</strong> <?php echo htmlspecialchars($reg->condicion); ?> &nbsp;|&nbsp;
    <strong>ORIGINAL : CLIENTE</strong><br>
    <strong>NRO DE AUTORIZACIÓN:</strong> <?php echo htmlspecialchars($autorizacion); ?>
    <?php if ($imp) echo '<br><strong>' . $imp . '</strong>'; ?>
  </div>

  <div class="bloque-cliente">
    <strong>Señor(es):</strong> <?php echo htmlspecialchars($reg->nombreCliente); ?><br>
    <strong>RUC:</strong> <?php echo htmlspecialchars($reg->ruc); ?><br>
    <strong>Dirección:</strong> <?php echo htmlspecialchars($reg->dir); ?>
  </div>

  <table class="detalle">
    <thead>
      <tr>
        <th>Cant.</th>
        <th>Descripción</th>
        <th class="num">P. Unit.</th>
        <th class="num">Importe</th>
      </tr>
    </thead>
    <tbody>
<?php foreach ($detalle as $regd):
  $totalItem = $regd->precio * $regd->cantidad; ?>
      <tr>
        <td><?php echo (int)$regd->cantidad; ?></td>
        <td><?php echo htmlspecialchars($regd->descripcionarticulo); ?> <?php echo (int)$regd->impuesto; ?>%</td>
        <td class="num"><?php echo formatearMoneda($regd->precio, $idMoneda); ?></td>
        <td class="num"><?php echo formatearMoneda($totalItem, $idMoneda); ?></td>
      </tr>
<?php endforeach; ?>
    </tbody>
  </table>

  <div class="totales">
    <strong>TOTAL:</strong> <?php echo formatearMoneda($reg->total, $idMoneda); ?><br>
    <strong>I.V.A 10%:</strong> <?php echo formatearMoneda($reg->total/11, $idMoneda); ?><br>
    Total productos/servicios: <?php echo $cantidad; ?>
  </div>

  <?php if (count($pagos) > 0): ?>
  <table class="detalle">
    <thead>
      <tr>
        <th>Forma de pago</th>
        <th class="num">Monto</th>
      </tr>
    </thead>
    <tbody>
<?php foreach ($pagos as $regp):
  $montoPagoItem = isset($regp->MONTO) ? $regp->MONTO : (isset($regp->MONTOAPLICADO) ? $regp->MONTOAPLICADO : 0);
  $descPago = isset($regp->descripcion) ? $regp->descripcion : (isset($regp->DESCRIPCION) ? $regp->DESCRIPCION : 'Pago'); ?>
      <tr>
        <td><?php echo htmlspecialchars($descPago); ?></td>
        <td class="num"><?php echo formatearMoneda($montoPagoItem, $idMoneda); ?></td>
      </tr>
<?php endforeach; ?>
    </tbody>
  </table>
  <div class="totales"><strong>Total cobrado:</strong> <?php echo formatearMoneda($totalPago, $idMoneda); ?></div>
  <?php endif; ?>

  <div class="pie">
    Desarrollado por Factupar Software
  </div>
</div>
</body>
</html>
<?php ob_end_flush(); ?>
