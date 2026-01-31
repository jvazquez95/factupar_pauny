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
$rspta = $venta->cabeceraWeb($_GET["id"]);
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




//require('../fpdf/fpdf.php');
// require('../fpdf181/fpdf.php');
require('../fpdf181/rotation.php');
class PDF extends PDF_Rotate
{
function Header()
{
    //Put the watermark
    $this->SetFont('Arial','B',50);
    $this->SetTextColor(255,192,203);
    $this->RotatedText(35,190,'W a t e r m a r k   d e m o',45);
}

function RotatedText($x, $y, $txt, $angle)
{
    //Text rotated around its origin
    $this->Rotate($angle,$x,$y);
    $this->Text($x,$y,$txt);
    $this->Rotate(0);
}
}



$pdf=new FPDF();
$pdf->AddPage('P', 'Legal');
$pdf->SetFont('Arial','B',7);


$pdf->SetY(8);
$pdf->SetX(10);
$pdf->Image('../files/logo/logoFactura.jpg',10,15,-500);
$pdf->MultiCell(90,10.5,$empresa . "\n" .$propietario. "\n" . $documento. "\n" .$direccion. "\n" .$email,1,'L');

// $pdf->SetY(10);

// $pdf->Cell(10,10,'Estamos viendo',1,1,'C');
$pdf->SetFont('Arial','B',10);
$pdf->SetY(8);
$pdf->SetX(100);
$pdf->MultiCell(100,7, "\n RUC: " .$reg->fe .  "\n Timbrado: " . $reg->timbrado . "\nVencimiento hasta el: " .date_format($date, 'd-m-Y'). " \n Factura Nro.:".$reg->serie."-".$reg->nroFactura."\n Fecha " .date_format($date1, 'd-m-Y').  "    Original" ,1,'C');



function data_text($data, $tipus=1){
    if ($data != '' && $tipus == 0 || $tipus == 1){
            $setmana = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
            $mes = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
            if ($tipus == 1){
                preg_match('([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})', $data, $data);
                $data = mktime(0,0,0,$data[2],$data[1],$data[3]);
            }
            return $setmana[date('w', $data)].', '.date('d', $data).' '.$mes[date('m',$data)-1].' de '.date('Y', $data);
    }else{
        return 0;
    }
}





$pdf->SetFont('Arial',"",8);

$pdf->Cell(190,6,utf8_decode("Fecha :")  . date_format($date1, 'd-m-Y'), 1,0,'C');

$pdf->SetY(56);
$pdf->SetX(10);

$pdf->MultiCell(130,4, utf8_decode("Señor(es):") .utf8_decode($reg->nombreCliente)."\n R.U.C: " .utf8_encode($reg->ruc)."\n\n\n\n",1,'L');

//$pdf->Cell(160,17, "Cliente:" .$reg->nombreCliente,1,'L');

$pdf->SetY(56);
$pdf->SetX(140);

if ($reg->TerminoPago_idTerminoPago == 1) 
        {  $condicionv = 'Contado'; 
        }else{ 
            $condicionv = 'Credito'; 
        }
      
$pdf->MultiCell(60,6.5, "\nCajero: ".utf8_decode($reg->usuario). "\nCondicion: ".$condicionv,1,'L');

//CABECERA CANTIDAD DESCRIPCION ETC
$pdf->SetY(76);
$pdf->SetX(10);

$pdf->Cell(20,6,"Cantidad", 1,0,'C');
$pdf->Cell(70,6,utf8_decode("Descripción"), 1,0,'C');
$pdf->Cell(20,6,"Importe", 1,0,'C');
$pdf->Cell(80,3,"Ventas", 1,0,'C');


//SUBCABECERA DE VENTAS CONTIENE EXCENTAS| IVAS 5% |ETC
$pdf->SetY(79);
$pdf->SetX(120);

$pdf->Cell(26,3,"Exentas", 1,0,'C');
$pdf->Cell(26,3,"IVA 5%", 1,0,'C');
$pdf->Cell(28,3,"IVA 10%", 1,0,'C');



//CAJAS VACIAS DENTRO DE LA SUBCABECERADEVENTAS

$pdf->SetY(86);
$pdf->SetX(120);

$pdf->Cell(26,60,"", 1,0,'C');
$pdf->Cell(26,60,"", 1,0,'C');
$pdf->Cell(28,60,"", 1,0,'C');

//CAJA GENERAL DENTRO DE IMPORTE Y VENTAS

$pdf->SetY(86);
$pdf->SetX(100);
$pdf->Cell(100,70,"", 1,0,'C');

//CAJA VACIA PARA DESCRIPCION 

$pdf->SetY(86);
$pdf->SetX(30);
$pdf->Cell(70,50,"", 1,0,'C');



//CANTIDAD | DESCRIPCION

$pdf->SetY(86);
$pdf->SetX(10);
//cuadro general 
$pdf->Cell(190,80,"", 1,0,'C');


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
        /*CANTIDAD*/
        $pdf->SetXY(10,$valordey);
        $pdf->MultiCell(20,5,$regd->cantidad,0,"C");

        /*DESCRIPCION DEL PRODUCTO*/
        $pdf->SetXY(30,$valordey);
        $pdf->MultiCell(70,5,$regd->descripcionarticulo,0,"L");

        /*IMPORTE*/
        $formattedNum = number_format(($regd->precio-($regd->precio*$regd->descuento/100)));
        $pdf->SetXY(100,$valordey);
        $pdf->MultiCell(20,5,$formattedNum,0,"R");

        /*EXENTAS*/ 
        $pdf->SetXY(120,$valordey);
        $pdf->MultiCell(26,5, number_format($exentas), 0,"R");

        /*iva 5%*/
        $pdf->SetXY(146,$valordey);
        $pdf->MultiCell(26,5,number_format($gc = $iva5/21),0,"R" );
         

        /*IVA 10%*/
        $pdf->SetXY(172,$valordey);     
        $pdf->MultiCell(28,5, $formattedNum = number_format(($regd->precio-($regd->precio*$regd->descuento/100))*$regd->cantidad)."Gs.",0,"R" );





        $suma= $suma+4;

}
//FIN DEL WHILE

///AUI






$pdf->SetFont('Arial',"",8);
$pdf->SetTextColor(0, 0, 0);

$pdf->SetY(136);
$pdf->SetX(10);
$pdf->MultiCell(190,10,"", 1,'L');
$pdf->SetFont('Arial',"",5);



$pdf->SetY(138);
$pdf->SetX(10);
$pdf->MultiCell(100,4,"TOTAL A PAGAR: \n" . numtoletras($reg->total), 0,'L');
$pdf->SetFont('Arial',"",8);
$pdf->text(125,139, $formattedNum = number_format($exentas)."Gs." );

$pdf->text(149,139, $formattedNum = number_format($c=$iva5/1.05)."Gs." );

$pdf->text(177,139, $formattedNum = number_format($iva10)."Gs.");




//PIE DE FACTURA
$pdf->SetY(146);
$pdf->SetX(100);
$pdf->MultiCell(100,6.6,"\n\n TOTAL " .$formattedNum = number_format($reg->total)."Gs.", 1,'R');



$pdf->SetY(146);
$pdf->SetX(100);
$pdf->Cell(20,10,"", 1,0,'R');
$pdf->Cell(26,10,"", 1,0,'R');
$pdf->Cell(26,10,"", 1,0,'R');











$pdf->SetY(150);
$pdf->SetX(10);
$pdf->Image('../files/logo/pieFactura.jpg',11,147,-500);

//$pdf->text(102,148,"");

$pdf->text(122,150,$formattedNum = number_format($exentas)."Gs.");

$pdf->text(150,150,$formattedNum = number_format($gc = $iva5/21)."Gs.");

$pdf->text(175,150,$formattedNum = number_format($iva10/11)."Gs.");

$pdf->text(102,139,"Valor Parcial.");
$pdf->SetY(146);
$pdf->SetX(100);
$pdf->MultiCell(100,3,utf8_decode("Liquidación \nparcial."),0,"L");







$pdf->text(10, 172, "AUTORIZACION AUTOIMPRESOR: ".$autorizacion." \n",'L');


//////////////////////////////////////PAGINA DOS COPIA/////////////////////////////////////////////////////////////////
//AGREGAR OTRA PÁGINA


$pdf->SetY(175);
$pdf->SetX(10);
$pdf->Image('../files/logo/logoFactura.jpg',10,177,-500);
$pdf->MultiCell(90,10.5,$empresa . "\n" .$propietario. "\n" . $documento. "\n" .$direccion. "\n" .$email,1,'L');

$pdf->SetFont('Arial','B',10);
$pdf->SetY(175);
$pdf->SetX(100);
$pdf->MultiCell(100,7, "\n RUC: " .$reg->ruc .  "\n Timbrado: " . $reg->timbrado . "\nVencimiento hasta el: " .date_format($date, 'd-m-Y'). " \n Factura Nro.:".$reg->serie."-".$reg->nroFactura."\n Fecha " .date_format($date1, 'd-m-Y').  "    Duplicado"  ,1,'C');


$pdf->SetFont('Arial',"",8);

$pdf->Cell(190,6,utf8_decode("Fecha :")  . date_format($date1, 'd-m-Y'), 1,0,'C');

$pdf->SetY(223);
$pdf->SetX(10);

$pdf->MultiCell(130,4, utf8_decode("Señor(es):") .utf8_decode($reg->nombreCliente)."\n R.U.C: " .utf8_encode($reg->ruc)."\n\n\n\n",1,'L');


$pdf->SetY(223);
$pdf->SetX(140);

if ($reg->TerminoPago_idTerminoPago == 1) 
        {  $condicionv = 'Contado'; 
        }else{ 
            $condicionv = 'Credito'; 
        }
      
$pdf->MultiCell(60,6.5, "\nCajero: ".utf8_decode($reg->usuario). "\nCondicion: ".$condicionv,1,'L');

//CABECERA CANTIDAD DESCRIPCION ETC

$var_val_2 = 167;

$pdf->SetY(76+$var_val_2);
$pdf->SetX(10);

$pdf->Cell(20,6,"Cantidad", 1,0,'C');
$pdf->Cell(70,6,utf8_decode("Descripción"), 1,0,'C');
$pdf->Cell(20,6,"Importe", 1,0,'C');
$pdf->Cell(80,3,"Ventas", 1,0,'C');


//SUBCABECERA DE VENTAS CONTIENE EXCENTAS| IVAS 5% |ETC
$pdf->SetY(79+$var_val_2);
$pdf->SetX(120);

$pdf->Cell(26,3,"Exentas", 1,0,'C');
$pdf->Cell(26,3,"IVA 5%", 1,0,'C');
$pdf->Cell(28,3,"IVA 10%", 1,0,'C');



//CAJAS VACIAS DENTRO DE LA SUBCABECERADEVENTAS

$pdf->SetY(86+$var_val_2);
$pdf->SetX(120);

$pdf->Cell(26,60,"", 1,0,'C');
$pdf->Cell(26,60,"", 1,0,'C');
$pdf->Cell(28,60,"", 1,0,'C');

//CAJA GENERAL DENTRO DE IMPORTE Y VENTAS

$pdf->SetY(86+$var_val_2);
$pdf->SetX(100);
$pdf->Cell(100,70,"", 1,0,'C');

//CAJA VACIA PARA DESCRIPCION 

$pdf->SetY(86+$var_val_2);
$pdf->SetX(30);
$pdf->Cell(70,50,"", 1,0,'C');

//CANTIDAD | DESCRIPCION

$pdf->SetY(86+$var_val_2);
$pdf->SetX(10);
//cuadro general 
$pdf->Cell(190,80,"", 1,0,'C');

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
        /*CANTIDAD*/
        $pdf->SetXY(10,$valordey);
        $pdf->MultiCell(20,5,$regd->cantidad,0,"C");

        /*DESCRIPCION DEL PRODUCTO*/
        $pdf->SetXY(30,$valordey);
        $pdf->MultiCell(70,5,$regd->descripcionarticulo,0,"L");

        /*IMPORTE*/
        $formattedNum = number_format(($regd->precio-($regd->precio*$regd->descuento/100)));
        $pdf->SetXY(100,$valordey);
        $pdf->MultiCell(20,5,$formattedNum,0,"R");

        /*EXENTAS*/ 
        $pdf->SetXY(120,$valordey);
        $pdf->MultiCell(26,5, number_format($exentas), 0,"R");

        /*iva 5%*/
        $pdf->SetXY(146,$valordey);
        $pdf->MultiCell(26,5,number_format($gc = $iva5/21),0,"R" );
         

        /*IVA 10%*/
        $pdf->SetXY(172,$valordey);     
        $pdf->MultiCell(28,5, $formattedNum = number_format(($regd->precio-($regd->precio*$regd->descuento/100))*$regd->cantidad)."Gs.",0,"R" );





        $suma= $suma+4;

}


$pdf->SetFont('Arial',"",8);
$pdf->SetTextColor(0, 0, 0);


$var_val_3 = 167;

$pdf->SetY(136+$var_val_3);
$pdf->SetX(10);
$pdf->MultiCell(190,10,"", 1,'L');
$pdf->SetFont('Arial',"",5);



$pdf->SetY(138+$var_val_3);
$pdf->SetX(10);
$pdf->MultiCell(100,4,"TOTAL A PAGAR: \n" . numtoletras($reg->total), 0,'L');
$pdf->SetFont('Arial',"",8);
$pdf->text(125,139+$var_val_3, $formattedNum = number_format($exentas)."Gs." );

$pdf->text(149,139+$var_val_3, $formattedNum = number_format($c=$iva5/1.05)."Gs." );

$pdf->text(177,139+$var_val_3, $formattedNum = number_format($iva10)."Gs.");



//PIE DE FACTURA
$pdf->SetY(146+$var_val_3);
$pdf->SetX(100);
$pdf->MultiCell(100,6.6,"\n\n TOTAL " .$formattedNum = number_format($reg->total)."Gs.", 1,'R');



$pdf->SetY(146+$var_val_3);
$pdf->SetX(100);
$pdf->Cell(20,10,"", 1,0,'R');
$pdf->Cell(26,10,"", 1,0,'R');
$pdf->Cell(26,10,"", 1,0,'R');


$pdf->SetY(150+$var_val_3);
$pdf->SetX(10);
$pdf->Image('../files/logo/pieFactura.jpg',11,147+$var_val_3,-500);

//$pdf->text(102,148,"");

$pdf->text(122,150+$var_val_3,$formattedNum = number_format($exentas)."Gs.");

$pdf->text(150,150+$var_val_3,$formattedNum = number_format($gc = $iva5/21)."Gs.");

$pdf->text(175,150+$var_val_3,$formattedNum = number_format($iva10/11)."Gs.");

$pdf->text(102,139+$var_val_3,"Valor Parcial.");
$pdf->SetY(146+$var_val_3);
$pdf->SetX(100);
$pdf->MultiCell(100,3,utf8_decode("Liquidación \nparcial."),0,"L");

$pdf->text(10, 172+$var_val_3, "AUTORIZACION AUTOIMPRESOR: ".$autorizacion." \n",'L');

$pdf->text(10, 176+$var_val_3, "C O P I A",'L');

// $nombre = $_GET["id"];
   //// $pdf->Output(F,'pdfs/'.$nombre.'.pdf'); 
   $pdf->Output(); 

ob_end_flush();




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





?>
