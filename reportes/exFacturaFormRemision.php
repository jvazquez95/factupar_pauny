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
require_once "../modelos/VentaRemision.php";
//Instanaciamos a la clase con el objeto venta
$venta = new VentaRemision();
//En el objeto $rspta Obtenemos los valores devueltos del método ventacabecera del modelo
$rspta = $venta->cabeceraWeb($_GET["id"]);
//Recorremos todos los valores obtenidos
$reg0 = $rspta->fetchObject(); 



//Incluímos la clase Venta
require_once "../modelos/VentaRemision.php";
//Instanaciamos a la clase con el objeto venta
$venta = new VentaRemision();
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
$regalia = $reg->regalia;
$matricula = $reg->matricula;
$date = date_create($reg0->vencimiento);
?>
       
       <p ALIGN=center>     <img src="logo.png" height="100" width="200"/><br><br><br>

        <?php echo "de Maria Alexandra Alfonso Torres<br>" .$direccion .' <br> '.$telefono; ?><br>
        <?php echo $email."<br>"; ?>
        ___________________________________<br>

        <?php echo "<br>".$documento ?><br>
         <?php echo "Timbrado: ".$reg->timbrado .' <br>  '."  Venc de Timbrado:".date_format($date, 'd-m-Y'); ?><br>
        <?php echo "Nota de Remision Nro: ".$reg->serie."- 0".$reg->nroFactura .' <br>  '."  Fecha:".date_format($date1, 'd-m-Y'); ?><br> 
        <?php //echo "Condicion: ".$reg->condicion; ?><br> 
        <?php echo "<b>Original: Cliente"; ?><br> 
        <?php echo "Nro de autorizacion:".$autorizacion; ?><br> 
       <?php echo "Regalia:".$regalia."</b>"; ?><br> 
        ___________________________________<br><br>
        <?php echo utf8_encode("<b>Se&ntildeor(es):".$reg->nombreCliente)."</b>" ?><br> 
        <?php echo "RUC:".$reg->ruc ?><br> 
        <?php echo utf8_encode("Direccion:".$reg->direccion) ?>
        <br>___________________________________<br>
    

 <?php
        echo "<br><br>CANT &nbsp;&nbsp;&nbsp;&nbsp; DESCRIPCION &nbsp;&nbsp;&nbsp;&nbsp;    <br>";

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
        echo $regd->descripcionarticulo."&nbsp;&nbsp;&nbsp; <br><br>";
      //  echo "Total item: ".$formattedNum = number_format($regd->precio*$regd->cantidad)." Gs.<br><br>";
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

        echo "Saldo disponible: ". $regd->saldoCantidad."<br><br>";

    }
    ?>        ___________________________________<br><br>
    <br><br> Vehiculo matricula: <?php echo $matricula . "<br><br>"; ?>
    <br> Vehiculo marca: <?php echo $reg->marcaVehiculo . "<br><br>"; ?>
    <br> Vehiculo modelo: <?php echo $reg->modeloVehiculo . "<br><br>"; ?>
    <br> Vehiculo chofer: <?php echo $reg->nombreChofer . "<br><br>"; ?>
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
