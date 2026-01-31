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
$rspta = $venta->cabeceraWeb($_GET["id"]);
//Recorremos todos los valores obtenidos
$reg0 = $rspta->fetchObject();



//Incluímos la clase Venta
require_once "../modelos/Venta.php";
//Instanaciamos a la clase con el objeto venta
$venta = new Venta();
//En el objeto $rspta Obtenemos los valores devueltos del método ventacabecera del modelo
$rspta = $venta->ventacabeceraWeb($_GET["id"]);
//Recorremos todos los valores obtenidos
$reg = $rspta->fetchObject();

//Establecemos los datos de la empresa
$empresa = 'LA RECOLECTORA S.A.';
$propietario = 'Timbrado: ' .$reg0->timbrado;
$documento = "RUC: 1567190-9"; 
$direccion = "Direccion: ".$reg0->direccion;
$telefono = "Tel.:". $reg0->telefono;
$email = 'E-mail: '.$reg0->correo;
$date1 = date_create($reg0->fechaFactura);
$autorizacion = $reg0->nroAutorizacion;
$date = date_create($reg0->vencimiento);

?>
       
       <p ALIGN=center>     <img src="logo.png" height="100" width="200"/><br><br><br>

        <?php echo "de Maria Alexandra Alfonso Torres<br>" .$direccion .' <br> '.$telefono; ?><br>
        <?php echo $email."<br>"; ?>
        ___________________________________<br>

        <?php echo "<br>".$documento ?><br>
         <?php echo "Timbrado: ".$reg->timbrado .' <br>  '."  Venc de Timbrado:".date_format($date, 'd-m-Y'); ?><br>
        <?php echo "Factura Nro: ".$reg->serie."- 0".$reg->nroFactura .' <br>  '."  Fecha:".date_format($date1, 'd-m-Y'); ?><br> 
        <?php echo "<b>CONDICIÓN: ".$reg->condicion."</b>"; ?><br> 
        <?php echo "<b>ORIGINAL : CLIENTE</b>"; ?><br> 
        <?php echo "<b>NRO DE AUTORIZACION: ".$autorizacion."</b>"; ?><br> 
        <?php echo "<b>NRO DE REMISION: 001-001-0001035</b>"; ?><br> 
       
        ___________________________________<br><br>
        <?php echo utf8_encode("<b>Se&ntildeor(es):".$reg->nombreCliente)."</b>" ?><br> 
        <?php echo "RUC:".$reg->ruc ?><br> 
        <?php echo utf8_encode("Direccion:".$reg->dir) ?>
        <br>___________________________________<br>
    

 <?php
        echo "<br><br>CANT &nbsp;&nbsp;&nbsp;&nbsp; DESCRIPCION &nbsp;&nbsp;&nbsp;&nbsp;   IMPORTE <br>";

        ?>
            ___________________________________<br>

    <?php
    $rsptad = $venta->ventadetalle($_GET["id"]);
    $cantidad=0;
    $exentas=0;
    $iva5=0;
    $iva10=0;
    while ($regd = $rsptad->fetchObject()) {
        echo $regd->cantidad. "&nbsp;&nbsp;&nbsp;";
        echo $regd->descripcionarticulo." ".$regd->impuesto."% &nbsp;&nbsp;&nbsp;".$formattedNum = number_format($regd->precio)."Gs.<br><br>";
        echo "Total item: ".$formattedNum = number_format($regd->precio*$regd->cantidad)." Gs.<br><br>";
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
    ?>        ___________________________________<br><br>

   
    <preg>TOTAL:                </preg>
    <?php echo $formattedNum = number_format($reg->total)." Gs."."\n <br><br>";  ?>
    I.V.A 10%:
    <?php echo $formattedNum = number_format($reg->total/11)." Gs."."\n <br><br>";  ?>
        ___________________________________


     <br><br> Total productos/servicios: <?php echo $cantidad . "<br><br>"; ?>
       
      <?php echo "Villa Elisa - Paraguay"?><br><small>Desarrollado por Factupar Software</small> <p> 
<?php 
}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}
ob_end_flush();
?>