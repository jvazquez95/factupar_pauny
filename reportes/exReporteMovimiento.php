<?php
// Activamos el almacenamiento en el buffer y configuramos locale
ob_start();
setlocale(LC_MONETARY, 'en_US');

// Iniciamos sesión si no existe
if (strlen(session_id()) < 1) {
    session_start();
}

// Verificamos login y permisos
if (!isset($_SESSION["ventas"])) {
    echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
    exit;
}

if ($_SESSION['ventas'] != 1) {
    echo 'No tiene permiso para visualizar el reporte';
    exit;
}

// Incluimos y usamos el modelo para obtener datos de cabecera
require_once "../modelos/Venta.php";
$venta = new Venta();
$rspta0 = $venta->cabeceraWeb($_GET["id"]);
$reg0   = $rspta0->fetchObject();

// Incluimos y usamos el modelo para obtener datos del movimiento
$rspta = $venta->rpt_movimiento($_GET["id"]);
$reg   = $rspta->fetchObject();

// Datos de la empresa
$empresa   = 'RUGAR S.A - MINERAQUA';
$direccion = 'Dirección: ' . $reg0->direccion;
$telefono  = 'Tel.: ' . $reg0->telefono;
$email     = 'E-mail: ' . $reg0->correo;
$timbrado  = $reg0->timbrado;

// Campos del movimiento
$tipo       = $reg->tipo;               // 'I' o 'E'
$cliente    = $reg->razonSocial;
$docCliente = $reg->nroDocumento;
$fecha      = $reg->fecha;              // date(fechaApertura)
$cantidad      = number_format($reg->cantidad, 0, '.', ',');
$precioUnitario      = number_format($reg->precioUnitario, 0, '.', ',');
$monto      = number_format($reg->monto, 0, '.', ',');
$concepto   = $reg->descripcion;
$mes        = $reg->mes;
$anho       = $reg->anho;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link href="../public/css/ticket.css" rel="stylesheet" type="text/css">
</head>
<body onload="window.print();">

  <!-- Cabecera común -->
  <div align="center">
    <img src="../files/logo/logo.png" height="100" width="200"/><br><br>
    <strong style="font-size:1.2em"><?= $empresa ?></strong><br>
    Timb.: <?= $timbrado ?><br>
    <?= $direccion ?><br>
    <?= $telefono ?><br>
    <?= $email ?><br>
  </div>
  <hr>

  <!-- Contenido según tipo -->
  <?php if ($tipo === 'I'): ?>
    <!-- INGRESO -->
    <h3 align="center">RECIBO DE DINERO</h3>
    <p>
      Recibido de: <strong><?= $cliente ?></strong><br>
      Cédula / RUC: <strong><?= $docCliente ?></strong><br>
      Cantidad. <strong><?= $cantidad ?></strong><br>
      Precio Unitario. Gs. <strong><?= $precioUnitario ?></strong><br>
      La suma de Gs. <strong><?= $monto ?></strong><br>
      Por concepto de: <strong><?= $concepto ?></strong><br>
      Fecha: <strong><?= $fecha ?></strong><br>
      Periodo: <?= $mes ?>/<?= $anho ?>
    </p>
    <p align="right" style="margin-top:40px">
      ___________________________<br>
      Firma del Cliente
    </p>

  <?php else: ?>
    <!-- EGRESO -->
    <h3 align="center">RECIBÍ CONFORME</h3>
    <p>
      Yo, <strong><?= $cliente ?></strong><br>
      Cédula / RUC: <strong><?= $docCliente ?></strong><br>
      Recibí de <strong><?= $empresa ?></strong> la suma de Gs. <strong><?= $monto ?></strong><br>
      Por concepto de: <strong><?= $concepto ?></strong><br>
      Fecha: <strong><?= $fecha ?></strong><br>
      Periodo: <?= $mes ?>/<?= $anho ?>
    </p>
    <p align="right" style="margin-top:40px">
      ___________________________<br>
      Firma Responsable
    </p>
  <?php endif; ?>

</body>
</html>
<?php
ob_end_flush();
?>
