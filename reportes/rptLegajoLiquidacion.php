<?php

	include 'plantillaLegajoLiquidacion.php';
	require_once "../modelos/Liquidacion.php";
	require_once "../modelos/Movimiento.php";
	


	$rpt = new Liquidacion();
	$pdf = new PDF('P','mm','A4');
	$pdf->AliasNbPages();
	

	$rspta = $rpt->rpt_legajo_liquidacion($_GET['id']);
	
	while($row0 = $rspta->fetchObject())
	{

			$pdf->AddPage();
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(0,3, 'VICEMINISTERIO DE TRABAJO',0,1,'C');
			$pdf->Cell(0,3, 'DIRECCION DE REGISTRO OBRERO PATRONAL',0,1,'C');
			$pdf->Cell(0,3, 'NRO. LIQUIDACION: '. $row0->Liquidacion_IdLiquidacion,0,1,'L');
			$pdf->Cell(0,3, 'PERSONA: '. $row0->nombreLegajo,0,1,'L');
			$pdf->Cell(0,3, 'MONEDA:'. $row0->nombreMoneda,0,1,'L');
			$pdf->Cell(0,3, 'PERIODO: '. $row0->periodo,0,1,'L');
			$pdf->Cell(0,3, 'DIAS TRABAJADOS: '. $row0->diasTrabajado,0,1,'L');
			$pdf->Cell(0,3, 'FECHA PAGO:'.$row0->fechaFinPeriodo,0,1,'L');
			$pdf->Cell(0,3, 'PATRONAL NRO: ver',0,1,'L');
			$pdf->Cell(0,3, 'ORIGINAL',0,1,'L');
			



			$pdf->SetFillColor(232,232,232);
			$pdf->SetFont('Arial','B',5);
			$pdf->Ln(10);
			$pdf->Cell(40,5,'CONCEPTOS',1,0,'C',1);
			$pdf->Cell(10,5,'DIAS',1,0,'C',1);
			$pdf->Cell(10,5,'HORAS',1,0,'C',1);
			$pdf->Cell(20,5,'INGRESOS',1,0,'C',1);
			$pdf->Cell(20,5,'EGRESOS',1,1,'C',1);

			$pdf->SetFont('Arial','',6);
			
			$rspta1 = $rpt->rpt_legajo_liquidacion_detalle($row0->Legajo_idLegajo,$row0->Liquidacion_IdLiquidacion);

			$montoIT = 0;
			$montoET = 0;
			$montoI = 0;
			$montoE = 0;

			while($row = $rspta1->fetchObject())
			{

			if ($row->tipo == 'Ingreso') {
				$montoE = 0;
				$montoI = $row->monto;
				$montoIT = $montoIT + $montoI;
			}

			if ($row->tipo == 'Egreso') {
				$montoI = 0;		
				$montoE = $row->monto;
				$montoET = $montoET + $montoE;

			}

			if ($row->monto == 0) {
				$montoE = 0;
				$montoI = 0;
			}	

			// if ($row->monto == 0) {
			// 	$montoE = 0;
			// 	$montoI = 0;
			// }	



			$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','B',5);
			$pdf->Cell(40,5,$row->nombreConceptoSalario,1,0,'C',1);
			$pdf->Cell(10,5,$row->dias,1,0,'C',1);
			$pdf->Cell(10,5,$row->horas,1,0,'C',1);
			$pdf->Cell(20,5,number_format($montoI),1,0,'C',1);
			$pdf->Cell(20,5,number_format($montoE),1,1,'C',1);
			

			}
			$pdf->Ln(5);
			$pdf->SetFillColor(232,232,232);
			$pdf->SetFont('Arial','B',5);
			$pdf->Cell(60,10,'SUB-TOTAL',1,0,'C',1);
			$pdf->Cell(20,10,number_format($montoIT),1,0,'C',1);
			$pdf->Cell(20,10,number_format($montoET),1,0,'C',1);
			$pdf->Cell(20,10,number_format($montoIT-$montoET),1,1,'C',1);

			$pdf->Ln(3);
			$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','B',5);
			$pdf->Cell(100,10,numtoletras($montoIT-$montoET),0,1,'C',1);
			
			$pdf->Ln(5);
			$pdf->Cell(0,3, '_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ ',0,1,'C');
			$pdf->Cell(0,3, 'RECIBI CONFORME',0,1,'C');

			$pdf->Ln(15);

			$pdf->Cell(0,3, '------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------',0,1,'C');

			$montoET = 0;
			$montoIT = 0;
			$montoI = 0;
			$montoE = 0;

			$pdf->SetFont('Arial','B',8);
			$pdf->Ln(10);
			date_default_timezone_set('America/Asuncion');
			$currentdate = date("d-m-Y h:i:s");
			$pdf->Image('../files/logo/logo.jpg', 5, 5, 10 );
			$pdf->Cell(0,3, 'VICEMINISTERIO DE TRABAJO',0,1,'C');
			$pdf->Cell(0,3, 'DIRECCION DE REGISTRO OBRERO PATRONAL',0,1,'C');
			$pdf->Cell(0,3, 'NRO. LIQUIDACION: '. $row0->Liquidacion_IdLiquidacion,0,1,'L');
			$pdf->Cell(0,3, 'PERSONA: '. $row0->nombreLegajo,0,1,'L');
			$pdf->Cell(0,3, 'MONEDA:'. $row0->nombreMoneda,0,1,'L');
			$pdf->Cell(0,3, 'PERIODO: '. $row0->periodo,0,1,'L');
			$pdf->Cell(0,3, 'DIAS TRABAJADOS: '. $row0->diasTrabajado,0,1,'L');
			$pdf->Cell(0,3, 'FECHA PAGO:'.$row0->fechaFinPeriodo,0,1,'L');
			$pdf->Cell(0,3, 'PATRONAL NRO: ver',0,1,'L');
			$pdf->Cell(0,3, 'DUPLICADO',0,1,'L');

			$pdf->Ln(10);

			$pdf->SetFillColor(232,232,232);
			$pdf->SetFont('Arial','B',5);
			$pdf->Cell(40,5,'CONCEPTOS',1,0,'C',1);
			$pdf->Cell(10,5,'DIAS',1,0,'C',1);
			$pdf->Cell(10,5,'HORAS',1,0,'C',1);
			$pdf->Cell(20,5,'INGRESOS',1,0,'C',1);
			$pdf->Cell(20,5,'EGRESOS',1,1,'C',1);

			$pdf->SetFont('Arial','',6);
			
			$rspta1 = $rpt->rpt_legajo_liquidacion_detalle($row0->Legajo_idLegajo,$row0->Liquidacion_IdLiquidacion);
			while($row = $rspta1->fetchObject())
			{

			if ($row->tipo == 'Ingreso') {
				$montoE = 0;
				$montoI = $row->monto;
				$montoIT = $montoIT + $montoI;
			}

			if ($row->tipo == 'Egreso') {
				$montoI = 0;		
				$montoE = $row->monto;
				$montoET = $montoET + $montoE;

			}

			if ($row->monto == 0) {
				$montoE = 0;
				$montoI = 0;
			}	


			$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','B',5);
			$pdf->Cell(40,5,$row->nombreConceptoSalario,1,0,'C',1);
			$pdf->Cell(10,5,$row->dias,1,0,'C',1);
			$pdf->Cell(10,5,$row->horas,1,0,'C',1);
			$pdf->Cell(20,5,number_format($montoI),1,0,'C',1);
			$pdf->Cell(20,5,number_format($montoE),1,1,'C',1);
			

			}


			$pdf->Ln(5);
			$pdf->SetFont('Arial','B',5);
			$pdf->SetFillColor(232,232,232);
			$pdf->SetFont('Arial','B',5);
			$pdf->Cell(60,10,'SUB-TOTAL',1,0,'C',1);
			$pdf->Cell(20,10,number_format($montoIT),1,0,'C',1);
			$pdf->Cell(20,10,number_format($montoET),1,0,'C',1);
			$pdf->Cell(20,10,number_format($montoIT-$montoET),1,1,'C',1);

			$pdf->Ln(3);
			$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','B',5);
			$pdf->Cell(100,10,numtoletras($montoIT-$montoET),0,1,'C',1);


			$pdf->Ln(5);
			$pdf->Cell(0,3, '_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ ',0,1,'C');
			$pdf->Cell(0,3, 'RECIBI CONFORME',0,1,'C');
			$montoET = 0;
			$montoIT = 0;
			$montoI = 0;
			$montoE = 0;

}
$rspta = 0;

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




	$pdf->Output();
?>