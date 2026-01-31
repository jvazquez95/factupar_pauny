<?php
//Activamos el almacenamiento en el buffer
ob_start();
setlocale(LC_MONETARY, 'en_US');


?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="../public/css/ticket.css" rel="stylesheet" type="text/css">
</head>
<body onload="window.print();">
<?php

//Incluímos la clase Venta
require_once "../modelos/Recibo.php";
//Instanaciamos a la clase con el objeto venta
$oc = new Recibo();
//En el objeto $rspta Obtenemos los valores devueltos del método ventacabecera del modelo
$rspta = $oc->rpt_recibo_cabecera($_GET['idRecibo']);
//Recorremos todos los valores obtenidos
$reg0 = $rspta->fetchObject();
$_SESSION["nroDoc"]=$reg0->nroDocumento;
			$_SESSION["razonSocial"]=$reg0->razonSocial;

			date_default_timezone_set('America/Asuncion');
			$currentdate = date("d-m-Y h:i:s");
//Incluímos la clase Venta
//require_once "../modelos/Consultas.php";
//Instanaciamos a la clase con el objeto venta
//$consultas = new Consultas();
//En el objeto $rspta Obtenemos los valores devueltos del método ventacabecera del modelo
//$rspta = $consultas->recibo_cabecera($_GET["id"]);
//Recorremos todos los valores obtenidos
//$reg = $rspta->fetchObject();
//Establecemos los datos de la empresa
$empresa = 'de Maria Alexandra Alfonso Torres';
//$propietario = 'Timbrado: ' .$reg0->timbrado;
$documento = "RUC: 111111111-1";
$direccion = 'Callejón sin salida casi, Ypané 2660';
//$direccion = $reg0->direccion;
$telefono = ' Tel.: ' .$reg0->telefonoSucursal;
$email = 'E-mail: '.$reg0->correo;
//error_reporting(0);
$date = date_create($reg0->FECHARECIBO);
$date1 = date_create($reg0->vencimiento);
$cajero = $reg0->cajero;
$totall = $reg0->totall;
?>
<p ALIGN=center>     <img src="logo.png" height="200" width="200"/><br>
       
        <?php echo $documento."\n <br><br>"; ?>
        <?php echo $direccion."\n <br><br> ".$telefono."\n <br><br>"; ?>
        <?php echo $email."\n <br><br>"; ?>
        <?php echo "Cajero: ".$cajero."\n <br><br>"; ?>
 <?php
echo "Recibo Nro.: ".$reg0->IDRECIBO."\n <br><br> Fecha: ". date_format($date, 'd-m-Y');
        echo "\n <br><br>CUOTA &nbsp; FACTURA &nbsp; IMPORTE \n <br><br></b>";

        ?>
    __________________________________________<br><br>
    <?php
    $rsptad = $oc->rpt_recibo_detalle($_GET["idRecibo"]);
    $cantidad=0;
    $exentas=0;
    $iva5=0;
    $iva10=0;
	$total = 0;
    while ($regd = $rsptad->fetchObject()) {
        echo $regd->impCuota. "&nbsp;";
        echo $regd->nroOficial . "&nbsp;" . $formattedNum = number_format($regd->MONTOAPLICADO)." Gs. \n <br><br>";
		$total2 = $total2 + $regd->MONTOAPLICADO;
    }
    ?>__________________________________________<br><br>
<?php

        echo "\n <br><br>FORMA DE PAGO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MONTO \n <br><br></b>";

        ?>
    __________________________________________<br><br>
    <?php
    $rsptad = $oc->rpt_recibo_detalle_pago($_GET["idRecibo"]);
    $cantidad=0;
    $exentas=0;
    $iva5=0;
    $iva10=0;
	//$total = 0;
    while ($regd = $rsptad->fetchObject()) {
        echo $regd->descripcion. "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo "" . $formattedNum = number_format($regd->MONTO)." Gs. \n <br><br>";
		//$total = $total + $regd->MONTOAPLICADO;
    }
    ?>__________________________________________<br><br>

    <b>TOTAL RECIBO:</b>
    <?php echo $formattedNum = number_format($total2)."Gs."."\n <br><br>";  ?>
    

__________________________________________<br><br>

 <?php echo "Cliente:" .$reg0->razonSocial. "\n <br><br>"; ?>
 <?php echo "RUC/C.I: ".$reg0->nroDocumento ."\n <br><br><br><br>Firma:<br><br><br><br>"; ?>


    <?php
	

    $rsptad = $oc->rpt_recibo_detalle($_GET["idRecibo"]);
    $cantidad=0;
    $exentas=0;
    $iva5=0;
    $iva10=0;
	$total = 0;

    ?>__________________________________________<br><br>


    
      <?php echo "YPANE - Paraguay"?> 
      <?php echo "<center><br>Desarrollado por Factupar Software</center>"?> 

      <?php echo "\n <br><br></p>"?> 


<?php 


ob_end_flush();
?>