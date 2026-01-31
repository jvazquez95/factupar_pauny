<?php
//Activamos el almacenamiento en el buffer
ob_start();
setlocale(LC_MONETARY, 'en_US');

?>
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
$l_idVenta = $reg->idVenta;
$empresa = '';
$propietario = '';
$documento = "";
$direccion = '';
$telefono = '';
$email = '';
error_reporting(0);
$date = date_create($reg0->vencimiento);
$date1 = date_create($reg0->fechaFactura);
$autorizacion = $reg0->nroAutorizacion;


////////////////////////////////////////////////////////




//requir





//FIN DEL WHILE

///AUI












////////////////////////////////////////////////
function numtoletras($xcifra)
{
    $xarray = array(0 => "Cero",
        1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
        "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
        "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
        100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
    );
//
    $xcifra = trim($xcifra);
    $xlength = strlen($xcifra);
    $xpos_punto = strpos($xcifra, ".");
    $xaux_int = $xcifra;
    $xdecimales = "00";
    if (!($xpos_punto === false)) {
        if ($xpos_punto == 0) {
            $xcifra = "0" . $xcifra;
            $xpos_punto = strpos($xcifra, ".");
        }
        $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
        $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
    }

    $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
    $xcadena = "";
    for ($xz = 0; $xz < 3; $xz++) {
        $xaux = substr($XAUX, $xz * 6, 6);
        $xi = 0;
        $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
        $xexit = true; // bandera para controlar el ciclo del While
        while ($xexit) {
            if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                break; // termina el ciclo
            }

            $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
            $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
            for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                switch ($xy) {
                    case 1: // checa las centenas
                        if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas
                            
                        } else {
                            $key = (int) substr($xaux, 0, 3);
                            if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                if (substr($xaux, 0, 3) == 100)
                                    $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                            }
                            else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                $key = (int) substr($xaux, 0, 1) * 100;
                                $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                $xcadena = " " . $xcadena . " " . $xseek;
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 0, 3) < 100)
                        break;
                    case 2: // checa las decenas (con la misma lógica que las centenas)
                        if (substr($xaux, 1, 2) < 10) {
                            
                        } else {
                            $key = (int) substr($xaux, 1, 2);
                            if (TRUE === array_key_exists($key, $xarray)) {
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux);
                                if (substr($xaux, 1, 2) == 20)
                                    $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3;
                            }
                            else {
                                $key = (int) substr($xaux, 1, 1) * 10;
                                $xseek = $xarray[$key];
                                if (20 == substr($xaux, 1, 1) * 10)
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 1, 2) < 10)
                        break;
                    case 3: // checa las unidades
                        if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada
                            
                        } else {
                            $key = (int) substr($xaux, 2, 1);
                            $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                            $xsub = subfijo($xaux);
                            $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                        } // ENDIF (substr($xaux, 2, 1) < 1)
                        break;
                } // END SWITCH
            } // END FOR
            $xi = $xi + 3;
        } // ENDDO

        if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
            $xcadena.= " DE";

        if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
            $xcadena.= " DE";

        // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
        if (trim($xaux) != "") {
            switch ($xz) {
                case 0:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN BILLON ";
                    else
                        $xcadena.= " BILLONES ";
                    break;
                case 1:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN MILLON ";
                    else
                        $xcadena.= " MILLONES ";
                    break;
                case 2:
                    if ($xcifra < 1) {
                        $xcadena = "CERO GUARANIES ";
                    }
                    if ($xcifra >= 1 && $xcifra < 2) {
                        $xcadena = "UN GUARANI  ";
                    }
                    if ($xcifra >= 2) {
                        $xcadena.= " GUARANIES  "; //
                    }
                    break;
            } // endswitch ($xz)
        } // ENDIF (trim($xaux) != "")
        // ------------------      en este caso, para México se usa esta leyenda     ----------------
        $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
    } // ENDFOR ($xz)
    return trim($xcadena);
}

// END FUNCTION

function subfijo($xx)
{ // esta función regresa un subfijo para la cifra
    $xx = trim($xx);
    $xstrlen = strlen($xx);
    if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
        $xsub = "";
    //
    if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
        $xsub = "MIL";
    //
    return $xsub;
} 



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FACTURA</title>
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

<style>
    .contenedor_gral{
    border: solid 2px #000;
    margin-right: -15px;
    margin-left: -15px;
    padding-right: 15px;
    padding-left: 15px;
}

.height-100{
    min-height:300px;
}

@media (min-width: 1200px){

.container, .container-lg, .container-md, .container-sm, .container-xl {
    max-width: 1200px !important;
}	
}

@media (min-width: 768px)
{
	.container, .container-md, .container-sm {
    max-width: 860px !important;
}
}

#columna_impuestos p{
    margin:0px !important;
    text-align:right !important;
}

.text-aling-right{
	    text-align:right !important;

}

li{
    list-style:none;
}

.border_right{
    border-right:solid 2px;
}

#tabla_bajo_completa{
    border-top:2px solid;
/*    text-align:center;
*/    min-height:200px;
}

#caja_primera_derecha{
text-align:center;
font-weight:700;
list-style:none;
border-left:2px solid;
}


.caja_fecha{
    border-top:2px solid;
}
#cabecera_tabla1{
    border-top:solid 2px;
    border-right:solid 2px;
    height:100%;
/*  vertical-align:34px;
*/}

#caja_segunda{
    border-top:2px solid;
}

#caja_segunda div:first-child{
    border-right: 2px solid;
}

#cabecera_tabla1 div:first-child, #cabecera_tabla3_impuestos div:first-child{
    border-right:2px solid;
}
#cabecera_tabla1 div:last-child,#cabecera_tabla3_impuestos div:last-child{
    border-left:2px solid;
}

#cabecera_tabla1 p {
    margin:0px;
}

#cabecera_tabla2_ventas p{
    padding:0px;
    margin:0px;
}

#cabecera_tabla3_impuestos{
	text-align:center;
}

#cabecera_tabla3_impuestos p
{
padding:0px;
    margin:0px;
}

#cabecera_tabla3_impuestos,#cabecera_tabla2_ventas,#total_footer{
    border-top:solid 2px;
}

#tabla_pie_tabla,#footer_tabla_conimg{
    border-top:solid 2px;
}

.padding0{
    padding:0px;
}

.height_70px{
    min-height:70px;
}

#liquid_parcial{
    border-bottom:2px solid;
}

.textos_detalle p{
	text-align:left !important;
}

#lado_izq_tabla p{
margin:0px;
}


.padding_red{
padding:2px;
}


</style>

</head>
<body>
    <div class="container">
        <div class="contenedor_gral">
            <div class="row">
                <div class="col">
                    <img class="img-fluid" style="text-align:center;" src="https://robsa.com.py/gigante/files/logo/logoFactura.jpg" alt="">
                </div>
                <div class="col" id="caja_primera_derecha">
                    <ul>
                        <li>RUC: <?php echo $reg->fe; ?> </li>
                        <li>TIMBRADO:   <?php  echo $reg->timbrado  ?> </li>
                        <li>VENCIMIENTO HASTA EL: <?php echo date_format($date, 'd-m-Y') ?> </li>
                        <li>FACTURA Nro:  <?php  echo $reg->serie. " ". $reg->nroFactura   ?> </li>
                        <li>Fecha <?php echo date_format($date1, 'd-m-Y'); ?> Original</li>
                    </ul>
                </div>
            </div>
            <div class="row  caja_fecha ">
                <div class="col-12  d-flex justify-content-center">
                    <p>Fecha: 15-06-2020</p>
                </div>
            </div>

            <div class="row" id="caja_segunda">
                <div class="col-7">
                    <p>
                        Se&ntilde;or(es):   <?php echo $reg->nombreCliente ?>
                        R.U.C: <?php echo $reg->fe; ?> 
                    </p>
                </div>
                <div class="col-5">
                    <p>
                        Cajero: <?php echo  $reg->usuario; ?> <br>
 <?php
if ($reg->TerminoPago_idTerminoPago == 1) 
        {  
        	$condicionv = 'Contado'; 
        }else{ 
            $condicionv = 'Credito'; 
        }
?>                       
                        Condicion:  <?php echo  $condicionv; ?>
                    </p>
                </div>
            </div>


<?php 

//WHILE
$rsptad = $venta->ventadetalle($l_idVenta);
$cantidad=0;
$exentas=0;
$iva5=0;
$iva10=0;
$suma = 0;
$i=0;
$resultado = 0;
// for($i = 0; $i <= 100; $i++){
//   echo "i es $i y resultado es $resultado ...";  
  
//   echo "resultado actual: $resultado\n";      
// }  


while ($regd = $rsptad->fetchObject()) {

    $resultado += $iva10;
    $valordey = 85.5+$suma;
    $cantidad+=$regd->cantidad;
         if ($regd->impuesto == 0) {
            $exentas += (($regd->precio-($regd->precio*$regd->descuento/100)))*$regd->cantidad;
        }
        if ($regd->impuesto == 5) {
            $iva5 += ($regd->precio-($regd->precio*$regd->descuento/100))*$regd->cantidad;
        }

        if ($regd->impuesto == 10) {
            $iva10 += ($regd->precio-($regd->precio*$regd->descuento/100))*$regd->cantidad;
        }


}


 ?>


            <div class="row">
                <div class="col-7">
                    <div class="row text-center " id="cabecera_tabla1">
                        <div class="col-2" style="    padding: 2px;">
                            <p>Cantidad</p>
                        </div>
                        <div class="col-8">
                            <p>
                                Descripci&oacute;n
                            </p>
                        </div>
                        <div class="col-2">
                            <p>Importe</p>
                        </div>
                    </div>
                </div>
                <div class="col-5">
                    <div class="row text-center" id="cabecera_tabla2_ventas">
                        <div class="col">
                            <p>VENTAS</p>
                        </div>
                    </div>
                    <div class="row" id="cabecera_tabla3_impuestos">
                        <div class="col">
                            <p>EXCENTAS</p>
                        </div>
                        <div class="col">
                            <p>IVA 5%</p>
                        </div>
                        <div class="col">   
                            <p>IVA 10%</p>
                        </div>
                    </div>
                    
                </div>
            </div>
            

            <div class="row" id="tabla_bajo_completa">
                <div class="col-7 ">
                    <div class="row" id="lado_izq_tabla">
                        <div  class=" text-aling-right col-2 padding_red border_right height-100">
<?php 


//WHILE
$rsptad = $venta->ventadetalle($l_idVenta);
$cantidad=0;
$exentas=0;
$iva5=0;
$iva10=0;
$suma = 0;
$i=0;
$resultado = 0;
while ($regd = $rsptad->fetchObject()) {

    $resultado += $iva10;
    $valordey = 85.5+$suma;
    $cantidad+=$regd->cantidad;
         if ($regd->impuesto == 0) {
            $exentas += (($regd->precio-($regd->precio*$regd->descuento/100)))*$regd->cantidad;
        }
        if ($regd->impuesto == 5) {
            $iva5 += ($regd->precio-($regd->precio*$regd->descuento/100))*$regd->cantidad;
        }

        if ($regd->impuesto == 10) {
            $iva10 += ($regd->precio-($regd->precio*$regd->descuento/100))*$regd->cantidad;
        }
echo "<p>".$regd->cantidad. "</p>";

}

 ?>

                        </div>
                        <div id="textos_detalle" class="col-8 border_right height-100" >
<?php 

$rsptad = $venta->ventadetalle($l_idVenta);
while ($regd = $rsptad->fetchObject()) {

echo "<p style='font-size:14px;'>".$regd->descripcionarticulo. "</p>";
}

 ?>
                        </div>
                        <div style="padding:2px;" class="col-2 height-100 border_right text-aling-right">
<?php 

$rsptad = $venta->ventadetalle($l_idVenta);
$cantidad=0;
$exentas=0;
$iva5=0;
$iva10=0;
$suma = 0;
$i=0;
$resultado = 0;
while ($regd = $rsptad->fetchObject()) {

echo "<p style='font-size:14px;'>". number_format(($regd->precio-($regd->precio*$regd->descuento/100))). " Gs. </p>";
}

 ?>
                        </div>
                    </div>
                </div>
                <div class="col" id="columna_impuestos">
                    <div class="row">
                        <div class="col border_right height-100 padding_red">

<?php 

$rsptad = $venta->ventadetalle($l_idVenta);
$cantidad=0;
$exentas=0;
$iva5=0;
$iva10=0;
$suma = 0;
$i=0;
$resultado = 0;
while ($regd = $rsptad->fetchObject()) {

echo "<p>".number_format($exentas). " Gs. </p>";
}

 ?>

                        </div>
                        <div class="col border_right height-100 padding_red">
<?php 

$rsptad = $venta->ventadetalle($l_idVenta);
$cantidad=0;
$exentas=0;
$iva5=0;
$iva10=0;
$suma = 0;
$i=0;
$resultado = 0;
while ($regd = $rsptad->fetchObject()) {

echo "<p>".number_format($gc = $iva5/21). " Gs. </p>";
}

 ?>
                        </div>
                        <div class="col padding_red">
<?php 

$rsptad = $venta->ventadetalle($l_idVenta);
$cantidad=0;
$exentas=0;
$iva5=0;
$iva10=0;
$suma = 0;
$i=0;
$resultado = 0;
while ($regd = $rsptad->fetchObject()) {

echo "<p>". number_format(($regd->precio-($regd->precio*$regd->descuento/100))*$regd->cantidad). " Gs. </p>";
}

 ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="tabla_pie_tabla">
                <div class="col-7">
                    <div class="row">
                        <div class="col-10  border_right height_70px">
                            
                            <p style="font-size:13px"> TOTAL A PAGAR: <?php echo numtoletras($reg->total) ?></p>
<!--                             <p style="font-size:13px"> Treinta mil guaranies:</p>
 -->
                        </div>
                        <div class="col-2 border_right height_70px">
                            <p>Valor Parcial</p>
                        </div>
                    </div>
                </div>
                <div class="col-5">
                    <div class="row">
                        

<?php 

$rsptad = $venta->ventadetalle($l_idVenta);
$cantidad=0;
$exentas=0;
$iva5=0;
$iva10=0;
$suma = 0;
$i=0;
$resultado = 0;


while ($regd = $rsptad->fetchObject()) {

    $resultado += $iva10;
    $valordey = 85.5+$var_val_2+$suma;
    $cantidad+=$regd->cantidad;
         if ($regd->impuesto == 0) {
            $exentas += (($regd->precio-($regd->precio*$regd->descuento/100)))*$regd->cantidad;
        }
        if ($regd->impuesto == 5) {
            $iva5 += ($regd->precio-($regd->precio*$regd->descuento/100))*$regd->cantidad;
        }

        if ($regd->impuesto == 10) {
            $iva10 += ($regd->precio-($regd->precio*$regd->descuento/100))*$regd->cantidad;
        }

}        
 ?>

                        <div class="col text-aling-right border_right  height_70px padding_red">
                          <p><?php echo  number_format($exentas)." Gs.";  ?></p>  
                        </div>
                        <div class="col text-aling-right border_right height_70px padding_red">
                            <p><?php echo number_format($c=$iva5/1.05)." Gs.";  ?></p>
                        </div>
                        <div class="col text-aling-right padding_red">
                           <p> <?php echo number_format($iva10)." Gs.";  ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="footer_tabla_conimg">
                <div class="col-7  border_right" >
                    <div class="row">
                        <div class="col-10 border_right">
                                                <img class="img-fluid" src="https://robsa.com.py/gigante/files/logo/pieFactura.jpg" alt="">
                        </div>
                        <div class="col-2" >
                            <div class="row " id="liquid_parcial">
                                <div class="col-12 height_70px" style="padding:2px;">
                                    <p class="text-center" style="font-size:15px;">Liquidaci&oacute;n Parcial</p>
                                </div>
                            </div>
                            <div style="height: 40px;" class="row">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-5 ">
                    <div class="row">
                        <!-- <div class="col-2 padding0 border_right" >
                            <p>
                                Liquidación Parcial
                            </p>
                        </div> -->
                        <div class="col border_right height_70px padding_red text-aling-right">
                           <?php echo  number_format($exentas)." Gs."; ?>
                        </div>
                        <div class="col border_right height_70px padding_red text-aling-right">
                            <?php  echo number_format($gc = $iva5/21)." Gs."; ?>
                        </div>
                        <div class="col text-aling-right padding_red">
                            <?php  echo number_format($iva10/11)." Gs." ?>
                        </div>
                    </div>
                    <div class="row" id="total_footer">
<div class="col-12">
    <p class="text-right"> TOTAL <?php echo number_format($reg->total) ?> Gs. </p>
</div>
                    </div>
                </div>
            </div>



        </div>      
    </div>
</body>
</html>