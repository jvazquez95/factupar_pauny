<?php
//Activamos el almacenamiento en el buffer
ob_start();
setlocale(LC_MONETARY, 'en_US');

if (strlen(session_id()) < 1) 
  session_start();

if (!isset($_SESSION["nombre"])) {
  echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
  exit;
}
if ($_SESSION['ventas']==1)
{
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="../public/css/ticket.css" rel="stylesheet" type="text/css">
</head>
<body onload="window.print();">
<?php

//Incluímos la clase Venta
require_once "../modelos/Venta.php";
//Instanaciamos a la clase con el objeto venta
$venta = new Venta();
//En el objeto $rspta Obtenemos los valores devueltos del método ventacabecera del modelo
$rspta = $venta->cabecera($_GET["id"]);
//Recorremos todos los valores obtenidos
$reg0 = $rspta->fetchObject();



//Incluímos la clase Venta
require_once "../modelos/Venta.php";
//Instanaciamos a la clase con el objeto venta
$venta = new Venta();
//En el objeto $rspta Obtenemos los valores devueltos del método ventacabecera del modelo
$rspta = $venta->ventacabecera($_GET["id"]);
//Recorremos todos los valores obtenidos
$reg = $rspta->fetchObject();

//Establecemos los datos de la empresa
$empresa = $reg0->nombre;
$propietario = 'Timbrado: ' .$reg0->timbrado;
$documento = "RUC: 80100378-4";
$direccion = $reg0->direccion;
$telefono = $reg0->telefono;
$email = $reg0->correo;
?>

       <preg> .:: <?php echo $empresa; ?>::.<br>

        <?php echo $direccion .' - '.$telefono; ?><br>
        <?php echo $email; ?><br>

 <?php
        echo "<br>CANT &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DESCRIPCION &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   IMPORTE <br></b>";

        ?>
    ========================================<br>
    <?php
    $rsptad = $venta->ventadetalle($_GET["id"]);
    $cantidad=0;
    $exentas=0;
    $iva5=0;
    $iva10=0;
    while ($regd = $rsptad->fetchObject()) {
        echo $regd->cantidad. "&nbsp;&nbsp;&nbsp;";
        echo $regd->descripcionarticulo." ".$regd->impuesto."% &nbsp;&nbsp;&nbsp;".$formattedNum = number_format($regd->precio)."Gs.<br>";
        echo "Total item: ".$formattedNum = number_format($regd->precio*$regd->cantidad)." Gs.<br>";
        $cantidad+=$regd->cantidad;
        if ($regd->impuesto == 0) {
            $exentas += $regd->precio*$regd->cantidad;
        }
        if ($regd->impuesto == 5) {
            $iva5 += $regd->precio*$regd->cantidad;
        }

        if ($regd->impuesto == 10) {
            $iva10 += $regd->precio*$regd->cantidad;
        }
    }
    ?>========================================<br>
   
    <preg>TOTAL:                </preg>
    <?php echo $formattedNum = number_format($reg->total)."Gs."."\n <br>";  ?>
========================================

      Total productos/servicios: <?php echo $cantidad . "<br>"; ?>
      Robert & Cia Sociedad Anonima
      <?php echo "<br>Luque - Paraguay<br><small>Desarrollado por Factupar Software</small>"?> 
<?php 
}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}
ob_end_flush();
?>