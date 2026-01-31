<?php



/*****  CONFIGURACIÓN Y DEPENDENCIAS  *****/
include 'plantillaArqueo2.php';
require_once "../modelos/Consultas.php";

$fi = $_GET['fecha_inicio'] ?? date('Y-m-d');
$ff = $_GET['fecha_fin']   ?? date('Y-m-d');
$rpt = new Consultas();

/*****  HELPERS  *****/
function headerTable($pdf,$h,$w){$pdf->SetFillColor(220,220,220);
 $pdf->SetFont('Arial','B',6);foreach($h as $i=>$txt)$pdf->Cell($w[$i],5,$txt,1,0,'C',true);
 $pdf->Ln();$pdf->SetFont('Arial','',6);}
function rowTable($pdf,$v,$w,$a){foreach($v as $i=>$val)$pdf->Cell($w[$i],5,$val,1,0,$a[$i]);$pdf->Ln();}

/*****  CABECERA PDF  *****/
$pdf=new PDF('P','mm','A4');
$pdf->AliasNbPages();$pdf->AddPage();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,8,'ARQUEO DE CAJA - GLOBAL',0,1,'C');
$pdf->SetFont('Arial','',9);
$pdf->Cell(0,6,'Desde: '.date('d/m/Y',strtotime($fi)).'  Hasta: '.date('d/m/Y',strtotime($ff)),0,1,'C');

/****************************************************************
 * 1.  MOVIMIENTOS INGRESOS / EGRESOS                            *
 ****************************************************************/
$sections=[['INGRESO',$rpt->rpt_aruqeo_caja_movimiento_ingreso_fechas($fi,$ff)],
           ['EGRESO', $rpt->rpt_aruqeo_caja_movimiento_egreso_fechas($fi,$ff)]];
$w=[20,40,60,30,30]; $tot=[0,0]; $resume=[[],[]];

foreach($sections as $idx=>$sec){
  [$tit,$rs]=$sec; $pdf->Ln(1);$pdf->SetFont('Arial','B',7);
  $pdf->Cell(0,6,"MOVIMIENTOS DE {$tit}",0,1,'C');
  headerTable($pdf,['Usuario','CONCEPTO',utf8_decode('DESCRIPCIÓN'),'FORMA PAGO','TOTAL Gs'],$w);
  while($r=$rs->fetchObject()){
     $tot[$idx]+=$r->TotalGs;
     $fp=strtoupper(trim($r->formaPago));
     $resume[$idx][$fp]=($resume[$idx][$fp]??0)+$r->TotalGs;
     rowTable($pdf,[
        $r->usuario,
        utf8_decode($r->cliente),
        utf8_decode($r->md),
        $r->formaPago,
        number_format($r->TotalGs,0,',','.')
     ],$w,['C','L','L','C','R']);
  }
  $pdf->SetFont('Arial','B',6);
  $pdf->Cell(array_sum(array_slice($w,0,4)),5,"TOTAL {$tit}S Gs",1,0,'R');
  $pdf->Cell(end($w),5,number_format($tot[$idx],0,',','.'),1,1,'R');
}

/****************************************************************
 * 2.  RESÚMENES POR FORMA DE PAGO                               *
 ****************************************************************/
function resumenFP($pdf,$title,$arr){ if(!$arr)return 0;
  headerTable($pdf,['FORMA DE PAGO','TOTAL Gs'],[80,70]);
  $t=0; foreach($arr as $fp=>$m){$t+=$m;
    rowTable($pdf,[utf8_decode($fp),number_format($m,0,',','.')],[80,70],['L','R']);}
  $pdf->SetFont('Arial','B',6);
  $pdf->Cell(80,5,"TOTAL {$title} Gs",1,0,'R');
  $pdf->Cell(70,5,number_format($t,0,',','.'),1,1,'R'); return $t;
}

$pdf->Ln(1);$pdf->SetFont('Arial','B',7);
$pdf->Cell(0,6,'RESUMEN INGRESOS POR FORMA DE PAGO',0,1,'C');
$resumenIngTotal=resumenFP($pdf,'RESUMEN INGRESOS POR FORMA DE PAGO',$resume[0]);

$pdf->Ln(1);$pdf->SetFont('Arial','B',7);
$pdf->Cell(0,6,'RESUMEN EGRESOS POR FORMA DE PAGO',0,1,'C');
$resumenEgrTotal=resumenFP($pdf,'RESUMEN EGRESOS POR FORMA DE PAGO',$resume[1]);

$efIng     =$resume[0]['EFECTIVO']??0;
$efEgr     =$resume[1]['EFECTIVO']??0;

/****************************************************************
 * 3.  RESUMEN GLOBAL (rpt_arqueo_caja_fechas)                   *
 ****************************************************************/
/* ❶ La consulta debe exponer el alias ‘USUARIO’:
      SELECT …,  recibo.USUARIO AS USUARIO,  …
*/
$rsG = $rpt->rpt_arqueo_caja_fechas($fi, $ff);

$efGlobalGs = 0;
$totGlobal  = 0;

$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(
    0,
    6,
    'DETALLE DE COBROS A CLIENTES (CONTADO - A CUENTA) (GLOBAL)',
    0,
    1,
    'C'
);

/* ---------- Cabecera ---------- */
$anchos = [60, 60, 40, 30];                // USUARIO | FORMA DE PAGO | MONEDA | TOTAL
headerTable(
    $pdf,
    ['USUARIO', 'FORMA DE PAGO', 'MONEDA', 'TOTAL Gs'],
    $anchos
);

/* ---------- Filas ---------- */
while ($g = $rsG->fetchObject()) {

    $totGlobal += $g->totalgs;
    if (strtoupper(trim($g->descripcion)) === 'EFECTIVO') {
        $efGlobalGs += $g->totalgs;
    }

    rowTable(
        $pdf,
        [
            utf8_decode($g->USUARIO),                      // USUARIO
            utf8_decode($g->descripcion),                 // FORMA DE PAGO
            $g->moneda,                                   // MONEDA
            number_format($g->totalgs, 0, ',', '.')       // TOTAL Gs
        ],
        $anchos,
        ['L', 'L', 'C', 'R']                              // alineaciones
    );
}

/* ---------- Total global ---------- */
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(
    $anchos[0] + $anchos[1] + $anchos[2],                // suma de las tres primeras columnas
    5,
    'TOTAL GLOBAL Gs',
    1,
    0,
    'R'
);
$pdf->Cell(
    $anchos[3],                                          // ancho de la última columna
    5,
    number_format($totGlobal, 0, ',', '.'),
    1,
    1,
    'R'
);




/****************************************************************
 * 4.  RESUMEN COBRANZAS + MOVIMIENTOS (rpt_arqueo_caja_cobranzas_movimientos_fechas)
 ****************************************************************/
$rsCM = $rpt->rpt_arqueo_caja_cobranzas_movimientos_fechas($fi, $ff);

$totCM = 0;

$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(
    0,
    6,
    'RESUMEN DE COBRANZAS Y MOVIMIENTOS DE CAJA (AGRUPADO POR USUARIO Y FORMA DE PAGO)',
    0,
    1,
    'C'
);

/* ---------- Cabecera ---------- */
$anchosCM = [70, 70, 40]; // USUARIO | FORMA DE PAGO | TOTAL Gs
headerTable(
    $pdf,
    ['USUARIO', 'FORMA DE PAGO', 'TOTAL Gs'],
    $anchosCM
);

/* ---------- Filas ---------- */
while ($row = $rsCM->fetchObject()) {
    $totCM += $row->total;

    rowTable(
        $pdf,
        [
            utf8_decode($row->usuario),
            utf8_decode($row->formaPago),
            number_format($row->total, 0, ',', '.')
        ],
        $anchosCM,
        ['L', 'L', 'R']
    );
}

/* ---------- Total general ---------- */
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(
    $anchosCM[0] + $anchosCM[1],
    5,
    'TOTAL GENERAL Gs',
    1,
    0,
    'R'
);
$pdf->Cell(
    $anchosCM[2],
    5,
    number_format($totCM, 0, ',', '.'),
    1,
    1,
    'R'
);






/****************************************************************
 * 4.  CIERRE POR DENOMINACIONES                                *
 ****************************************************************/
$rsDen=$rpt->rpt_arqueo_caja_denominacion_fechas($fi,$ff);
$pdf->Ln(1);$pdf->SetFont('Arial','B',7);
$pdf->Cell(0,6,'CIERRE POR DENOMINACIONES',0,1,'C');
headerTable($pdf,['MONEDA','DENOMINACIÓN','TOTAL CIERRE'],[30,40,40]);
$denArr=[];$totalCierre=0;
while($d=$rsDen->fetchObject()){
   $k=$d->moneda.'-'.$d->denominacion;
   $sub=$d->cantidadCierre*$d->denominacion;
   $denArr[$k]=($denArr[$k]??0)+$sub; $totalCierre+=$sub;
}
ksort($denArr); foreach($denArr as $k=>$v){[$m,$de]=explode('-',$k,2);
  rowTable($pdf,[$m,$de,number_format($v,0,',','.')],[30,40,40],['C','C','R']);}
$pdf->SetFont('Arial','B',6);
$pdf->Cell(70,5,'TOTAL EN CAJA',1,0,'R');
$pdf->Cell(40,5,number_format($totalCierre,0,',','.'),1,1,'R');

/****************************************************************
 * 5.  BALANCE FINAL + CONTROL EFECTIVO                          *
 ****************************************************************/
$efSistema = ($efIng - $efEgr) + $efGlobalGs;            // total efectivo sistema
$diffEf    = $totalCierre - $efSistema;                  // diferencia efectivo


$pdf->Ln(3);$pdf->SetFont('Arial','B',8);
$pdf->Cell(0,6,'CONTROL DE EFECTIVO',0,1,'C');
headerTable($pdf,['CONCEPTO','TOTAL Gs'],[100,30]);

rowTable($pdf,['EFECTIVO INGRESOS',number_format($efIng,0,',','.')],[100,30],['R','R']);
rowTable($pdf,['EFECTIVO EGRESOS',number_format($efEgr,0,',','.')],[100,30],['R','R']);
rowTable($pdf,['EFECTIVO (Cobros del dia)',number_format($efGlobalGs,0,',','.')],[100,30],['R','R']);
$pdf->SetFont('Arial','B',6);
rowTable($pdf,['TOTAL EFECTIVO SISTEMA',number_format($efSistema,0,',','.')],[100,30],['R','R']);
$pdf->SetFont('Arial','',6);
rowTable($pdf,['EFECTIVO EN CAJA',number_format($totalCierre,0,',','.')],[100,30],['R','R']);

/* ---------- COLOR PARA DIFERENCIA EFECTIVO ---------- */
if($diffEf>0)       $pdf->SetTextColor(255,128,0); // naranja
elseif($diffEf<0)   $pdf->SetTextColor(255,0,0);   // rojo
else                $pdf->SetTextColor(0,150,0);   // verde

rowTable($pdf,['DIFERENCIA EFECTIVO',number_format($diffEf,0,',','.')],[100,30],['R','R']);
$pdf->SetTextColor(0,0,0); // restablece a negro
/* ---------------------------------------------------- */

/***** SALIDA *****/
$pdf->Output();
?>
