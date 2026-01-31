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
<div id="area">
<?php

//Incluímos la clase Venta
require_once "../modelos/Venta.php";
//Instanaciamos a la clase con el objeto venta
$venta = new Venta();
//En el objeto $rspta Obtenemos los valores devueltos del método ventacabecera del modelo
$rspta = $venta->habilitacioncabecera($_GET["id"]);
//Recorremos todos los valores obtenidos
$reg = $rspta->fetchObject();

//Establecemos los datos de la empresa
$empresa = "AQUA - SPA";
$propietario = "Timbrado Nro.> 12691745";
$documento = "80100378-4";
$direccion = " - ASUNCION";
$telefono = "(0981) 000 000 ";
$email = "aqua@gmail.com";

?>

        .:: <?php echo $empresa; ?>::.<br>
         <?php echo "Usuario: ". $reg->nombre ?><br>
         <?php echo "Fecha apertura: ". $reg->fechaApertura ?><br>
         <?php echo "Fecha cierre: ". $reg->fechaCierre ?><br>
         <?php echo "Habilitacion: ". $reg->idhabilitacion ?><br>
         <?php echo "&nbsp;ARQUEO DE CAJA" ?><br>

 <?php
        echo "<br>VENTAS<br>CANT &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DESCRIPCION &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TOTAL <br></b>";
        ?>
    ========================================<br>
    
    <?php
    require_once "../modelos/Consultas.php";
//Instanaciamos a la clase con el objeto venta
    $arqueo = new Consultas();
    $rsptad = $arqueo->rpt_aruqeo_caja_venta($_GET["id"]);
    $cantidad=0;
    $exentas=0;
    $iva5=0;
    $iva10=0;
    $TG=0;
    $agrupacion_total=0;
    while ($regd = $rsptad->fetchObject()) {
 echo $regd->Cantidad_X_Articulo. "&nbsp;&nbsp;&nbsp;";
        echo $regd->descripcion."&nbsp;".$formattedNum = number_format($regd->Total)."Gs.<br>";
        $agrupacion_total = $agrupacion_total + $regd->Total;
        //$TG = $TG + $regd->Total;
    }
    ?>----------------------------------------<br>
   
    TOTAL VENTA:</b>
    <?php echo $formattedNum = number_format($agrupacion_total)."Gs."."\n <br>";  ?>
========================================

 <?php   echo "<br>MOVIMIENTOS - INGRESOS<br>DESCRIPCION &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   TOTAL <br></b>";
        ?>
    ========================================<br>
    ----------------------------------------<br>
    <?php
    require_once "../modelos/Consultas.php";
//Instanaciamos a la clase con el objeto venta
    $arqueo = new Consultas();
    $rsptad = $arqueo->rpt_aruqeo_caja_movimiento_ingreso($_GET["id"]);
    $cantidad=0;
    $exentas=0;
    $iva5=0;
    $iva10=0;
    $Ti=0;
    $agrupacion_total=0;
    while ($regd = $rsptad->fetchObject()) {
        echo $regd->Descripcion."&nbsp; ". $regd->md .'&nbsp;'.$formattedNum = number_format($regd->Total)."Gs.<br>";
        $agrupacion_total = $agrupacion_total + $regd->Total;
        $TG = $TG + $regd->Total;
        $Ti = $Ti + $regd->Total;

    }
    ?>----------------------------------------<br>
   
    TOTAL INGRESOS:</b>
    <?php echo $formattedNum = number_format($agrupacion_total)."Gs."."\n <br>";  ?>
========================================
 <?php
        echo "<br>MOVIMIENTOS - EGRESOS<br>DESCRIPCION &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   TOTAL <br></b>";

        ?>
    ========================================<br>
    ----------------------------------------<br>
    <?php
    require_once "../modelos/Consultas.php";
//Instanaciamos a la clase con el objeto venta
    $arqueo = new Consultas();
    $rsptad = $arqueo->rpt_aruqeo_caja_movimiento_egreso($_GET["id"]);
    $cantidad=0;
    $exentas=0;
    $iva5=0;
    $iva10=0;
    $Te=0;
    $Te2=0;
    //$agrupacion_total=0;
    while ($regd = $rsptad->fetchObject()) {
        echo $regd->Descripcion."&nbsp; ". $regd->md .'&nbsp;'.$formattedNum = number_format($regd->Total)."Gs.<br>";
        $agrupacion_total = $agrupacion_total - $regd->Total;
        $TG = $TG - $regd->Total;
        $Te = $Te - $regd->Total;
        $Te2 = $Te2 + $regd->Total;

    }
    ?>----------------------------------------<br>
   
    TOTAL EGRESOS:</b>
    <?php echo $formattedNum = number_format($Te2)."Gs."."\n <br>";  ?>
========================================
 <?php
        echo "<br>RESUMEN POR TIPO DE PAGO - TOTAL DE INGRESOS RECIBIDOS<br>DESCRIPCION &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   TOTAL <br></b>";

        ?>
    ========================================<br>
    ----------------------------------------<br>
    <?php
    require_once "../modelos/Consultas.php";
//Instanaciamos a la clase con el objeto venta
    $arqueo = new Consultas();
    $rsptad = $arqueo->rpt_arqueo_caja($_GET["id"]);
    $cantidad=0;
    $exentas=0;
    $iva5=0;
    $iva10=0;
    $TOTALINGRESOS=0;
    $total_efectivo=0;
    $agrupacion_total1=$agrupacion_total;
    while ($regd = $rsptad->fetchObject()) {

        echo $regd->descripcion."&nbsp;".$formattedNum = number_format($regd->total)."Gs.<br>";
        $agrupacion_total1 = $agrupacion_total1 + $regd->total;
        $TOTALINGRESOS = $TOTALINGRESOS + $regd->total;
        if ($regd->id == '1') {
            $total_efectivo = $total_efectivo +  $regd->total;
        }
    }
    ?>----------------------------------------<br>

    TOTAL COBRADO(Sumatoria de todos los tipos de pagos):</b>
    <?php echo $formattedNum = number_format($TOTALINGRESOS)."Gs."."\n <br>";  ?>
   
    TOTAL GENERAL(Total Cobrado + Ingresos - Egresos): </b>
    <?php echo $formattedNum = number_format($agrupacion_total1)."Gs."."\n <br>";  ?>

    TOTAL FINAL EN EFECTIVO(Efectivo + Ingresos - Egresos):</b>
    <?php echo $formattedNum = number_format($total_efectivo + $Ti + $Te)."Gs."."\n <br>";  ?>
========================================<br>

Ventas<br>

========================================<br>

    <?php
     $detalleventa = $venta->detalleventahabilitacion($_GET["id"]);
     $i = 0;
     while ($regdetalleventa = $detalleventa->fetchObject()) {

        echo $regdetalleventa->nc."&nbsp; Total: ".$formattedNum = number_format($regdetalleventa->totalVenta)."Gs. Saldo: ".$formattedNum = number_format($regdetalleventa->saldo)."&nbsp;". $regdetalleventa->descripcion. "&nbsp; Precio unitario: ". $formattedNum = number_format($regdetalleventa->precio). "&nbsp; Cantidad: ". $regdetalleventa->cantidad. "&nbsp; Total Item: ". $formattedNum = number_format($regdetalleventa->totalItem)."<br>";
     
     }


     ?>

</div>
<?php 

}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}
ob_end_flush();
?>