<?php
 	//  ini_set('display_errors', 'on');
 	//  error_reporting(E_ALL | E_STRICT);

	include 'plantillaArqueo2.php';
	require_once "../modelos/Consultas.php";
	require_once "../modelos/Movimiento.php";


	
	$pdf = new PDF('P','mm','A4');
	$pdf->AliasNbPages();
	$pdf->AddPage();

	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(0,6, 'Nro de Habilitacion: '.$_GET['habilitacion'] ,0,1,'L');


	$rpt = new Consultas();

	$rspta = $rpt->rpt_cabecera($_GET['habilitacion']);
	$t_dpc = 0;
	$t_dpc1 = 0;
	$t_dpc2 = 0;
	$t_credito = 0;
	while($row = $rspta->fetchObject())
	{
		$pdf->Cell(0,6, 'CAJA: '.$row->nombre ,0,1,'L');
		$pdf->Cell(0,6, 'DEPOSITO: '.$row->descripcion ,0,1,'L');
		$pdf->Cell(0,6, 'USUARIO: '.$row->login ,0,1,'L');			
		$pdf->Cell(0,6, 'Fecha: '.$row->fechaApertura ,0,1,'L');			
	}

  
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(0,6, 'DETALLE DE PRODUCTOS VENDIDOS CONTADO',0,1,'C');
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(20,5,'CANTIDAD',1,0,'R',1);
	$pdf->Cell(90,5,'ARTICULO',1,0,'L',1);
	$pdf->Cell(20,5,'MONEDA',1,0,'C',1);
	$pdf->Cell(30,5,'PRECIO UNIT',1,0,'R',1);
	$pdf->Cell(30,5,'TOTAL GS',1,1,'R',1);
	
	$pdf->SetFont('Arial','',8);
	$rpt = new Consultas();

	$rspta = $rpt->rpt_aruqeo_caja_venta_contado($_GET['habilitacion']);
	$t_dpc = 0;
	while($row = $rspta->fetchObject())
	{
		$usuario = $row->usuario;
		$t_dpc = $t_dpc + $row->TotalGs;
		$t_dpc1 = $t_dpc1 + $row->TotalGs;
		$pdf->Cell(20,5,utf8_decode($row->Cantidad_X_Articulo),1,0,'R');
		$pdf->Cell(90,5,utf8_decode($row->descripcion),1,0,'L');
		$pdf->Cell(20,5,utf8_decode($row->moneda),1,0,'C');
		$pdf->Cell(30,5,number_format($row->Total,0,',','.'),1,0,'R');			
		$pdf->Cell(30,5,number_format($row->TotalGs,0,',','.'),1,1,'R');			
	
	}
		$pdf->Cell(130,5,utf8_decode('***'),1,0,'C');
		$pdf->Cell(30,5,utf8_decode('TOTAL GS'),1,0,'C');
		$pdf->Cell(30,5,number_format($t_dpc,0,',','.'),1,1,'C');			

		$rpt = new Consultas();
		$rspta = $rpt->rpt_aruqeo_caja_venta_credito($_GET['habilitacion']);
		
		if ($rspta->rowCount() > 0) {
			$pdf->SetFont('Arial','B',6);
			$pdf->Cell(0,6, 'DETALLE DE PRODUCTOS VENDIDOS CREDITO',0,1,'C');
		
			$pdf->SetFillColor(232,232,232);
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(20,5,'CANTIDAD',1,0,'C',1);
			$pdf->Cell(90,5,'ARTICULO',1,0,'C',1);
			$pdf->Cell(20,5,'MONEDA',1,0,'C',1);
			$pdf->Cell(30,5,'PRECIO UNIT',1,0,'C',1);
			$pdf->Cell(30,5,'TOTAL GS',1,1,'C',1);
		
			$pdf->SetFont('Arial','',8);
			$t_dpc = 0;
			while($row = $rspta->fetchObject()) {
				$usuario = $row->usuario;
				$t_dpc += $row->TotalGs;
				$t_dpc2 += $row->TotalGs;
				
				$t_credito = $t_credito +$row->TotalGs;
				$pdf->Cell(20,5,utf8_decode($row->Cantidad_X_Articulo),1,0,'R');
				$pdf->Cell(90,5,utf8_decode($row->descripcion),1,0,'L');
				$pdf->Cell(20,5,utf8_decode($row->moneda),1,0,'C');
				$pdf->Cell(30,5,number_format($row->Total,0,',','.'),1,0,'R');
				$pdf->Cell(30,5,number_format($row->TotalGs,0,',','.'),1,1,'R');
			}
		
			$pdf->Cell(130,5,utf8_decode('***'),1,0,'C');
			$pdf->Cell(30,5,utf8_decode('TOTAL GS'),1,0,'R');
			$pdf->Cell(30,5,number_format($t_dpc,0,',','.'),1,1,'R');
			$t_credito = $t_dpc;
		} 
			

// Crear una nueva variable para el total general
$total_general_productos = $t_dpc2 + $t_dpc1;

// Espacio antes del total
$pdf->Ln(2); // Salto de línea

// Mostrar total general en una fila separada
$pdf->SetFont('Arial','B',7);
$pdf->Cell(160,6,utf8_decode('TOTAL GENERAL (CONTADO + CRÉDITO)'),1,0,'R');
$pdf->Cell(30,6,number_format($total_general_productos, 0, ',', '.'),1,1,'R');

		$rpt = new Consultas();
// =================== MOVIMIENTOS DE INGRESOS ===================
$rspta = $rpt->rpt_aruqeo_caja_movimiento_ingreso($_GET['habilitacion']);
if ($rspta->rowCount() > 0) {
    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(0,6, 'MOVIMIENTO DE INGRESOS',0,1,'C');
    $pdf->SetFillColor(232,232,232);
    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(20,5,'NRO',1,0,'C',1);
    $pdf->Cell(30,5,'CONCEPTO',1,0,'C',1);
    $pdf->Cell(60,5,'DESCRIPCION',1,0,'C',1);
    $pdf->Cell(20,5,'MONEDA',1,0,'C',1);
    $pdf->Cell(30,5,'FORMA DE PAGO',1,0,'C',1);
    $pdf->Cell(30,5,'TOTAL GS',1,1,'C',1);

    $pdf->SetFont('Arial','',6);

    $t_mi = 0;
    $resumenIngresos = [];
    while ($row = $rspta->fetchObject()) {
        $t_mi += $row->TotalGs;

        $pdf->Cell(20,5,utf8_decode($row->idMovimiento),1,0,'C');
        $pdf->Cell(30,5,utf8_decode($row->Descripcion),1,0,'C');
        $pdf->Cell(60,5,utf8_decode($row->cliente),1,0,'C');
        $pdf->Cell(20,5,utf8_decode($row->moneda),1,0,'C');
        $pdf->Cell(30,5,utf8_decode($row->formaPago),1,0,'C');
        $pdf->Cell(30,5,number_format($row->TotalGs,0,',','.'),1,1,'C');

        // Agrupar por forma de pago
        if (!isset($resumenIngresos[$row->formaPago])) {
            $resumenIngresos[$row->formaPago] = 0;
        }
        $resumenIngresos[$row->formaPago] += $row->TotalGs;
    }

    $pdf->Cell(160,5,utf8_decode('TOTAL INGRESOS'),1,0,'R');
    $pdf->Cell(30,5,number_format($t_mi,0,',','.'),1,1,'C');

    // ===== RESUMEN DE INGRESOS POR FORMA DE PAGO =====
    $pdf->Ln(2);
    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(0,6, 'RESUMEN DE INGRESOS POR FORMA DE PAGO',0,1,'C');
    $pdf->SetFillColor(232,232,232);
    $pdf->Cell(60,5,'FORMA DE PAGO',1,0,'C',1);
    $pdf->Cell(40,5,'TOTAL INGRESOS',1,1,'C',1);
    $pdf->SetFont('Arial','',6);

    $total_ingresos_efectivo = 0;
    foreach ($resumenIngresos as $fp => $monto) {
        $pdf->Cell(60,5,utf8_decode($fp),1,0,'L');
        $pdf->Cell(40,5,number_format($monto,0,',','.'),1,1,'R');
        if (mb_strtolower($fp) == 'efectivo') {
            $total_ingresos_efectivo += $monto;
        }
    }
    // TOTAL GENERAL DE INGRESOS
    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(60,5,'TOTAL GENERAL INGRESOS',1,0,'R',1);
    $pdf->Cell(40,5,number_format(array_sum($resumenIngresos),0,',','.'),1,1,'R',1);
}

// =================== MOVIMIENTOS DE EGRESOS ===================
$rspta = $rpt->rpt_aruqeo_caja_movimiento_egreso($_GET['habilitacion']);
if ($rspta->rowCount() > 0) {
    $pdf->Ln(4);
    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(0,6, 'MOVIMIENTO DE EGRESOS',0,1,'C');
    $pdf->SetFillColor(232,232,232);
    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(20,5,'NRO',1,0,'C',1);
    $pdf->Cell(30,5,'CONCEPTO',1,0,'C',1);
    $pdf->Cell(60,5,'DESCRIPCION',1,0,'C',1);
    $pdf->Cell(20,5,'MONEDA',1,0,'C',1);
    $pdf->Cell(30,5,'FORMA DE PAGO',1,0,'C',1);
    $pdf->Cell(30,5,'TOTAL GS',1,1,'C',1);

    $pdf->SetFont('Arial','',6);

    $t_me = 0;
    $resumenEgresos = [];
    while ($row = $rspta->fetchObject()) {
        $t_me += $row->TotalGs;

        $pdf->Cell(20,5,utf8_decode($row->idMovimiento),1,0,'C');
        $pdf->Cell(30,5,utf8_decode($row->Descripcion),1,0,'C');
        $pdf->Cell(60,5,utf8_decode($row->md),1,0,'C');
        $pdf->Cell(20,5,utf8_decode($row->moneda),1,0,'C');
        $pdf->Cell(30,5,utf8_decode($row->formaPago),1,0,'C');
        $pdf->Cell(30,5,number_format($row->TotalGs,0,',','.'),1,1,'C');

        // Agrupar por forma de pago
        if (!isset($resumenEgresos[$row->formaPago])) {
            $resumenEgresos[$row->formaPago] = 0;
        }
        $resumenEgresos[$row->formaPago] += $row->TotalGs;
    }

    $pdf->Cell(160,5,utf8_decode('TOTAL EGRESOS'),1,0,'R');
    $pdf->Cell(30,5,number_format($t_me,0,',','.'),1,1,'C');

    // ===== RESUMEN DE EGRESOS POR FORMA DE PAGO =====
    $pdf->Ln(2);
    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(0,6, 'RESUMEN DE EGRESOS POR FORMA DE PAGO',0,1,'C');
    $pdf->SetFillColor(232,232,232);
    $pdf->Cell(60,5,'FORMA DE PAGO',1,0,'C',1);
    $pdf->Cell(40,5,'TOTAL EGRESOS',1,1,'C',1);
    $pdf->SetFont('Arial','',6);

    $total_egresos_efectivo = 0;
    foreach ($resumenEgresos as $fp => $monto) {
        $pdf->Cell(60,5,utf8_decode($fp),1,0,'L');
        $pdf->Cell(40,5,number_format($monto,0,',','.'),1,1,'R');
        if (mb_strtolower($fp) == 'efectivo') {
            $total_egresos_efectivo += $monto;
        }
    }
    // TOTAL GENERAL DE EGRESOS
    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(60,5,'TOTAL GENERAL EGRESOS',1,0,'R',1);
    $pdf->Cell(40,5,number_format(array_sum($resumenEgresos),0,',','.'),1,1,'R',1);
}

// ============= SALDO FINAL DE EFECTIVO =============
$pdf->Ln(3);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(60,7,'EFECTIVO EN CAJA (INGRESOS - EGRESOS):',1,0,'L',1);
$pdf->Cell(40,7,number_format($total_ingresos_efectivo - $total_egresos_efectivo,0,',','.'),1,1,'R',1);

		$total_general_efectivo_movimientos = $total_ingresos_efectivo - $total_egresos_efectivo;

		// PAGOS A PROVEEDORES DE ESTE DIA
		$rspta = $rpt->rpt_pagos_detalle_dia($_GET['habilitacion']);
		if ($rspta->rowCount() > 0) {
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(0,6, 'PAGOS A PROVEEDORES DE ESTE DIA',0,1,'C');
			
			$pdf->SetFillColor(232,232,232);
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(20,5,'PAGOID.',1,0,'C',1);
			$pdf->Cell(25,5,'FECHA',1,0,'C',1);
			$pdf->Cell(65,5,'PROVEEDOR',1,0,'C',1);	
			$pdf->Cell(20,5,'MONEDA',1,0,'C',1);
			$pdf->Cell(30,5,'TOTAL',1,0,'C',1);
			$pdf->Cell(30,5,'TOTAL GS',1,1,'C',1);
			
			$pdf->SetFont('Arial','',6);
			$t_pd = 0;
			while ($row = $rspta->fetchObject()) {
				$date = date_create($row->FECHAPAGO);
				$fechanueva = date_format($date, "d-m-Y");
				$t_pd += $row->TOTALGs;
				$pdf->Cell(20,5,utf8_decode($row->IDPAGO),1,0,'C');
				$pdf->Cell(25,5,utf8_decode($fechanueva),1,0,'C');
				$pdf->Cell(65,5,utf8_decode($row->razonSocial),1,0,'C');
				$pdf->Cell(20,5,($row->dm),1,0,'C');
				$pdf->Cell(30,5,number_format($row->TOTAL),1,0,'C');
				$pdf->Cell(30,5,number_format($row->TOTALGs),1,1,'C');
			}
			$pdf->Cell(130,5,utf8_decode('***'),1,0,'C');
			$pdf->Cell(30,5,utf8_decode('TOTAL GS'),1,0,'C');
			$pdf->Cell(30,5,number_format($t_pd,0,',','.'),1,1,'C');
		}
		
		// PAGOS A PROVEEDORES FUERA DE FECHA
		$rspta = $rpt->rpt_pagos_detalle_otro_dia($_GET['habilitacion']);
		if ($rspta->rowCount() > 0) {
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(0,6, 'PAGOS A PROVEEDORES FUERA DE FECHA',0,1,'C');
			
			$pdf->SetFillColor(232,232,232);
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(20,5,'PAGOID.',1,0,'C',1);
			$pdf->Cell(25,5,'FECHA',1,0,'C',1);
			$pdf->Cell(65,5,'PROVEEDOR',1,0,'C',1);	
			$pdf->Cell(20,5,'MONEDA',1,0,'C',1);
			$pdf->Cell(30,5,'TOTAL',1,0,'C',1);
			$pdf->Cell(30,5,'TOTAL GS',1,1,'C',1);
			
			$pdf->SetFont('Arial','',6);
			$t_pd = 0;
			while ($row = $rspta->fetchObject()) {
				$date = date_create($row->FECHAPAGO);
				$fechanueva = date_format($date, "d-m-Y");
				$t_pd += $row->TOTALGs;
				$pdf->Cell(20,5,utf8_decode($row->IDPAGO),1,0,'C');
				$pdf->Cell(25,5,utf8_decode($fechanueva),1,0,'C');
				$pdf->Cell(65,5,utf8_decode($row->razonSocial),1,0,'C');
				$pdf->Cell(20,5,($row->dm),1,0,'C');
				$pdf->Cell(30,5,number_format($row->TOTAL),1,0,'C');
				$pdf->Cell(30,5,number_format($row->TOTALGs),1,1,'C');
			}
			$pdf->Cell(130,5,utf8_decode('***'),1,0,'C');
			$pdf->Cell(30,5,utf8_decode('TOTAL GS'),1,0,'C');
			$pdf->Cell(30,5,number_format($t_pd,0,',','.'),1,1,'C');
		}
		
		// COBROS DEL DIA A CLIENTES (VENTAS A CREDITO)
		$rspta = $rpt->rpt_recibos_detalle_dia_credito($_GET['habilitacion']);
		if ($rspta->rowCount() > 0) {
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(0,6, 'COBROS DEL DIA A CLIENTES( VENTAS A CREDITO - PAGOS PARCIALES O TOTALES) DEL DIA',0,1,'C');
			
			$pdf->SetFillColor(232,232,232);
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(20,5,'RECIBOID',1,0,'C',1);
			$pdf->Cell(20,5,'FECHA',1,0,'C',1);
			$pdf->Cell(65,5,'CLIENTE',1,0,'C',1);
			$pdf->Cell(25,5,'MONEDA',1,0,'C',1);
			$pdf->Cell(30,5,'TOTAL',1,0,'C',1);
			$pdf->Cell(30,5,'TOTAL GS',1,1,'C',1);
		
			$pdf->SetFont('Arial','',6);
			$t_rd = 0;
			while ($row = $rspta->fetchObject()) {
				$date = date_create($row->FECHARECIBO);
				$fechanueva = date_format($date, "d-m-Y");
				$t_rd += $row->TOTALGS;
				$fecha_hab = $fechanueva;
				$pdf->Cell(20,5,utf8_decode($row->IDRECIBO),1,0,'C');
				$pdf->Cell(20,5,utf8_decode($fechanueva),1,0,'C');
				$pdf->Cell(65,5,utf8_decode($row->razonSocial),1,0,'C');
				$pdf->Cell(25,5,utf8_decode($row->moneda),1,0,'C');
				$pdf->Cell(30,5,number_format($row->TOTAL),1,0,'R');	
				$pdf->Cell(30,5,number_format($row->TOTALGS),1,1,'R');
			}
			$pdf->SetFillColor(0,0,255);
		
			$pdf->Cell(130,5,utf8_decode('***'),1,0,'C');
			$pdf->Cell(30,5,utf8_decode('TOTAL GS'),1,0,'C'); 
			$pdf->Cell(30,5,number_format($t_rd,0,',','.'),1,1,'R');
		}
		
		// COBROS DEL DIA A CLIENTES (CONTADO - A CUENTA)
		$rspta = $rpt->rpt_recibos_detalle_otra_fecha($_GET['habilitacion']);
		if ($rspta->rowCount() > 0) {
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(0,6, 'COBROS DEL DIA A CLIENTES( A CREDITO ) FUERA DE FECHA',0,1,'C');
			
			$pdf->SetFillColor(232,232,232);
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(20,5,'RECIBOID',1,0,'C',1);
			$pdf->Cell(20,5,'FECHA',1,0,'C',1);
			$pdf->Cell(65,5,'CLIENTE',1,0,'C',1);
			$pdf->Cell(25,5,'MONEDA',1,0,'C',1);
			$pdf->Cell(30,5,'TOTAL',1,0,'C',1);
			$pdf->Cell(30,5,'TOTAL GS',1,1,'C',1);
		
			$pdf->SetFont('Arial','',6);
			$t_rd = 0;
			while ($row = $rspta->fetchObject()) {
				$date = date_create($row->FECHARECIBO);
				$fechanueva = date_format($date, "d-m-Y");
				$t_rd += $row->TOTALGS;
				$fecha_hab = $fechanueva;
				$pdf->Cell(20,5,utf8_decode($row->IDRECIBO),1,0,'C');
				$pdf->Cell(20,5,utf8_decode($fechanueva),1,0,'C');
				$pdf->Cell(65,5,utf8_decode($row->razonSocial),1,0,'C');
				$pdf->Cell(25,5,utf8_decode($row->moneda),1,0,'C');
				$pdf->Cell(30,5,number_format($row->TOTAL),1,0,'R');	
				$pdf->Cell(30,5,number_format($row->TOTALGS),1,1,'R');
			}
			$pdf->SetFillColor(0,0,255);
		
			$pdf->Cell(130,5,utf8_decode('***'),1,0,'C');
			$pdf->Cell(30,5,utf8_decode('TOTAL GS'),1,0,'C'); 
			$pdf->Cell(30,5,number_format($t_rd,0,',','.'),1,1,'R');
		}



// VENTAS DEL DIA A CLIENTES rpt_ventas_detallado
// Obtener el reporte detallado de ventas
$rspta = $rpt->rpt_ventas_detallado($_GET['habilitacion']);
if ($rspta->rowCount() > 0) {
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(0,8, 'VENTAS DEL DIA A CLIENTES - DETALLADO',0,1,'C');
    $pdf->Ln(2);

    $t_rd = 0;
    $currentVenta = null;
    $subtotalProductos = 0;
    $subtotalPagos = 0;

    while ($row = $rspta->fetchObject()) {
        $date = date_create($row->FECHARECIBO);
        $fechanueva = date_format($date, "d-m-Y");

        if ($currentVenta != $row->idVenta) {
            if ($currentVenta != null) {
                $pdf->SetFont('Arial','B',7);
                $pdf->Cell(140,5,'SUBTOTAL PRODUCTOS',0,0,'R');
                $pdf->Cell(30,5,number_format($subtotalProductos,0,',','.'),0,1,'R');
                $subtotalProductos = 0;

                $rspta_aplicados = $rpt->rpt_ventas_detallado_aplicados($currentVenta);
                if ($rspta_aplicados->rowCount() > 0) {
                    $pdf->Ln(2);
                    $pdf->SetFont('Arial','B',7);
                    $pdf->Cell(0,6,'DETALLE DE PAGOS',0,1,'C');

                    $pdf->Cell(50,6,'RECIBO',0,0,'L');
                    $pdf->Cell(70,6,'FORMA DE PAGO',0,0,'L');
                    $pdf->Cell(50,6,'MONTO APLICADO',0,1,'R');

                    $pdf->SetFont('Arial','',6);
                    $subtotalPagos = 0;
                    while ($row_aplicado = $rspta_aplicados->fetchObject()) {
                        $pdf->Cell(50,6,utf8_decode($row_aplicado->RECIBO_IDRECIBO),0,0,'L');
                        $pdf->Cell(70,6,utf8_decode($row_aplicado->descripcion),0,0,'L');
                        $pdf->Cell(50,6,number_format($row_aplicado->MONTO, 0, ',', '.'),0,1,'R');
                        $subtotalPagos += $row_aplicado->MONTO;
                    }

                    $pdf->SetFont('Arial','B',7);
                    $pdf->Cell(120,5,'SUBTOTAL PAGOS',0,0,'R');
                    $pdf->Cell(50,5,number_format($subtotalPagos,0,',','.'),0,1,'R');
                }

                $pdf->Ln(3);
                $pdf->Line(5, $pdf->GetY(), 205, $pdf->GetY());
                $pdf->Ln(1);
            }

            $t_rd += $row->TOTALGS;

            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(15,6,'ID',0,0,'L');
            $pdf->Cell(25,6,'FECHA',0,0,'L');
            $pdf->Cell(60,6,'CLIENTE',0,0,'L');
            $pdf->Cell(20,6,'CONDICION',0,0,'L');
            $pdf->Cell(25,6,'TOTAL',0,0,'L');
            $pdf->Cell(20,6,'SALDO',0,1,'L');

            $pdf->SetFont('Arial','',6);
            $pdf->Cell(15,6,utf8_decode($row->idVenta),0,0,'L');
            $pdf->Cell(25,6,utf8_decode($fechanueva),0,0,'L');
            $pdf->Cell(60,6,substr(utf8_decode($row->razonSocial), 0, 30),0,0,'L');
            $pdf->Cell(20,6,utf8_decode($row->descripcion),0,0,'L');
            $pdf->Cell(25,6,number_format($row->TOTAL),0,0,'L');
            $pdf->Cell(20,6,number_format($row->saldo),0,1,'L');

            $pdf->SetFont('Arial','B',6);
            $pdf->Cell(90,6,'Producto','LR',0,'L');
            $pdf->Cell(20,6,'Cantidad','LR',0,'R');
            $pdf->Cell(30,6,'Precio Unitario','LR',0,'R');
            $pdf->Cell(30,6,'Total','LR',1,'R');

            $currentVenta = $row->idVenta;
        }

        $pdf->SetFont('Arial','',6);
        $pdf->Cell(90,5,utf8_decode($row->producto),'LR',0,'L');
        $pdf->Cell(20,5,$row->cantidad,'LR',0,'R');
        $pdf->Cell(30,5,number_format($row->precio),'LR',0,'R');
        $pdf->Cell(30,5,number_format($row->totalProducto),'LR',1,'R');

        $subtotalProductos += $row->totalProducto;
    }

    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(140,5,'SUBTOTAL PRODUCTOS',0,0,'R');
    $pdf->Cell(30,5,number_format($subtotalProductos,0,',','.'),0,1,'R');

    $rspta_aplicados = $rpt->rpt_ventas_detallado_aplicados($currentVenta);
    if ($rspta_aplicados->rowCount() > 0) {
        $pdf->Ln(2);
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(0,6,'DETALLE DE PAGOS',0,1,'C');
        $pdf->Cell(50,6,'RECIBO',0,0,'L');
        $pdf->Cell(70,6,'FORMA DE PAGO',0,0,'L');
        $pdf->Cell(50,6,'MONTO APLICADO',0,1,'R');

        $pdf->SetFont('Arial','',6);
        $subtotalPagos = 0;
        while ($row_aplicado = $rspta_aplicados->fetchObject()) {
            $pdf->Cell(50,6,utf8_decode($row_aplicado->RECIBO_IDRECIBO),0,0,'L');
            $pdf->Cell(70,6,utf8_decode($row_aplicado->descripcion),0,0,'L');
            $pdf->Cell(50,6,number_format($row_aplicado->MONTO, 0, ',', '.'),0,1,'R');
            $subtotalPagos += $row_aplicado->MONTO;
        }

        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(120,5,'SUBTOTAL PAGOS',0,0,'R');
        $pdf->Cell(50,5,number_format($subtotalPagos,0,',','.'),0,1,'R');
    }

    $pdf->SetFont('Arial','B',7);
    $pdf->Ln(2);
    $pdf->Cell(130,6,utf8_decode('***'),0,0,'C');
    $pdf->Cell(30,6,utf8_decode('TOTAL GS'),0,0,'C'); 
    $pdf->Cell(30,6,number_format($t_rd,0,',','.'),0,1,'R');
}






		// VENTAS DEL DIA A CLIENTES (CONTADO) SIN REMISION
		$rspta = $rpt->rpt_ventas_contado_sin_remision($_GET['habilitacion']);
		if ($rspta->rowCount() > 0) {
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(0,6, 'VENTAS DEL DIA A CLIENTES( CONTADO ) SIN REMISION',0,1,'C');
			
			$pdf->SetFillColor(232,232,232);
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(20,5,'ID VENTA',1,0,'C',1);
			$pdf->Cell(20,5,'FECHA',1,0,'C',1);
			$pdf->Cell(65,5,'CLIENTE',1,0,'C',1);
			$pdf->Cell(25,5,'MONEDA',1,0,'C',1);
			$pdf->Cell(30,5,'TOTAL',1,0,'C',1);
			$pdf->Cell(30,5,'Saldo',1,1,'C',1);
		
			$pdf->SetFont('Arial','',7);
			$t_rd = 0;
			while ($row = $rspta->fetchObject()) {
				$date = date_create($row->FECHARECIBO);
				$fechanueva = date_format($date, "d-m-Y");
				$t_rd += $row->TOTALGS;
				$fecha_hab = $fechanueva;
				$pdf->Cell(20,5,utf8_decode($row->idVenta),1,0,'C');
				$pdf->Cell(20,5,utf8_decode($fechanueva),1,0,'C');
				$pdf->Cell(65,5,substr(utf8_decode($row->razonSocial), 0, 25),1,0,'C');
				$pdf->Cell(25,5,utf8_decode($row->moneda),1,0,'C');
				$pdf->Cell(30,5,number_format($row->TOTAL),1,0,'R');	
				$pdf->Cell(30,5,number_format($row->saldo),1,1,'R');
			}
			$pdf->SetFillColor(0,0,255);
		
			$pdf->Cell(130,5,utf8_decode('***'),1,0,'C');
			$pdf->Cell(30,5,utf8_decode('TOTAL GS'),1,0,'C'); 
			$pdf->Cell(30,5,number_format($t_rd,0,',','.'),1,1,'R');
		}
		
		// VENTAS DEL DIA A CLIENTES (CONTADO) CON REMISION
		$rspta = $rpt->rpt_ventas_contado_con_remision($_GET['habilitacion']);
		if ($rspta->rowCount() > 0) {
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(0,6, 'VENTAS DEL DIA A CLIENTES( CONTADO ) CON REMISION',0,1,'C');
			
			$pdf->SetFillColor(232,232,232);
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(20,5,'ID VENTA',1,0,'C',1);
			$pdf->Cell(20,5,'FECHA',1,0,'C',1);
			$pdf->Cell(65,5,'CLIENTE',1,0,'C',1);
			$pdf->Cell(25,5,'MONEDA',1,0,'C',1);
			$pdf->Cell(30,5,'TOTAL',1,0,'C',1);
			$pdf->Cell(30,5,'TOTAL GS',1,1,'C',1);
		
			$pdf->SetFont('Arial','',6);
			$t_rd = 0;
			while ($row = $rspta->fetchObject()) {
				$date = date_create($row->fechaTransaccion);
				$fechanueva = date_format($date, "d-m-Y");
				$t_rd += $row->TOTALGS;
				$fecha_hab = $fechanueva;
				$pdf->Cell(20,5,utf8_decode($row->idVenta),1,0,'C');
				$pdf->Cell(20,5,utf8_decode($fechanueva),1,0,'C');
				$pdf->Cell(65,5,utf8_decode($row->razonSocial),1,0,'C');
				$pdf->Cell(25,5,utf8_decode($row->moneda),1,0,'C');
				$pdf->Cell(30,5,number_format($row->TOTAL),1,0,'R');	
				$pdf->Cell(30,5,number_format($row->TOTALGS),1,1,'R');
			}
			$pdf->SetFillColor(0,0,255);
		
			$pdf->Cell(130,5,utf8_decode('***'),1,0,'C');
			$pdf->Cell(30,5,utf8_decode('TOTAL GS'),1,0,'C'); 
			$pdf->Cell(30,5,number_format($t_rd,0,',','.'),1,1,'R');
		}
		
		// VENTAS DEL DIA A CLIENTES (CREDITO) SIN REMISION
		$rspta = $rpt->rpt_ventas_credito_sin_remision($_GET['habilitacion']);
		if ($rspta->rowCount() > 0) {
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(0,6, 'VENTAS DEL DIA A CLIENTES( CREDITO ) SIN REMISION',0,1,'C');
			
			$pdf->SetFillColor(232,232,232);
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(20,5,'ID VENTA',1,0,'C',1);
			$pdf->Cell(20,5,'FECHA',1,0,'C',1);
			$pdf->Cell(65,5,'CLIENTE',1,0,'C',1);
			$pdf->Cell(25,5,'MONEDA',1,0,'C',1);
			$pdf->Cell(30,5,'TOTAL',1,0,'C',1);
			$pdf->Cell(30,5,'TOTAL GS',1,1,'C',1);
		
			$pdf->SetFont('Arial','',6);
			$t_rd = 0;
			while ($row = $rspta->fetchObject()) {
				$date = date_create($row->fechaTransaccion);
				$fechanueva = date_format($date, "d-m-Y");
				$t_rd += $row->TOTALGS;
				$fecha_hab = $fechanueva;
				$pdf->Cell(20,5,utf8_decode($row->idVenta),1,0,'C');
				$pdf->Cell(20,5,utf8_decode($fechanueva),1,0,'C');
				$pdf->Cell(65,5,utf8_decode($row->razonSocial),1,0,'C');
				$pdf->Cell(25,5,utf8_decode($row->moneda),1,0,'C');
				$pdf->Cell(30,5,number_format($row->TOTAL),1,0,'R');	
				$pdf->Cell(30,5,number_format($row->TOTALGS),1,1,'R');
			}
			$pdf->SetFillColor(0,0,255);
		
			$pdf->Cell(130,5,utf8_decode('***'),1,0,'C');
			$pdf->Cell(30,5,utf8_decode('TOTAL GS'),1,0,'C'); 
			$pdf->Cell(30,5,number_format($t_rd,0,',','.'),1,1,'R');
		}
		
		// VENTAS DEL DIA A CLIENTES (CREDITO) CON REMISION
		$rspta = $rpt->rpt_ventas_credito_con_remision($_GET['habilitacion']);
		if ($rspta->rowCount() > 0) {
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(0,6, 'VENTAS DEL DIA A CLIENTES( CREDITO ) CON REMISION',0,1,'C');
			
			$pdf->SetFillColor(232,232,232);
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(20,5,'ID VENTA',1,0,'C',1);
			$pdf->Cell(20,5,'FECHA',1,0,'C',1);
			$pdf->Cell(65,5,'CLIENTE',1,0,'C',1);
			$pdf->Cell(25,5,'MONEDA',1,0,'C',1);
			$pdf->Cell(30,5,'TOTAL',1,0,'C',1);
			$pdf->Cell(30,5,'TOTAL GS',1,1,'C',1);
		
			$pdf->SetFont('Arial','',6);
			$t_rd = 0;
			while ($row = $rspta->fetchObject()) {
				$date = date_create($row->fechaTransaccion);
				$fechanueva = date_format($date, "d-m-Y");
				$t_rd += $row->TOTALGS;
				$fecha_hab = $fechanueva;
				$pdf->Cell(20,5,utf8_decode($row->idVenta),1,0,'C');
				$pdf->Cell(20,5,utf8_decode($fechanueva),1,0,'C');
				$pdf->Cell(65,5,utf8_decode($row->razonSocial),1,0,'C');
				$pdf->Cell(25,5,utf8_decode($row->moneda),1,0,'C');
				$pdf->Cell(30,5,number_format($row->TOTAL),1,0,'R');	
				$pdf->Cell(30,5,number_format($row->TOTALGS),1,1,'R');
			}
			$pdf->SetFillColor(0,0,255);
		
			$pdf->Cell(130,5,utf8_decode('***'),1,0,'C');
			$pdf->Cell(30,5,utf8_decode('TOTAL GS'),1,0,'C'); 
			$pdf->Cell(30,5,number_format($t_rd,0,',','.'),1,1,'R');
		}
		
		// REMISION A CLIENTES SIN FACTURAS SIN GENTILEZA
		$rspta = $rpt->rpt_remision_sin_factura_sin_regalias($_GET['habilitacion']);
		if ($rspta->rowCount() > 0) {
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(0,6, 'REMISION A CLIENTES SIN FACTURAS SIN GENTILEZA',0,1,'C');
			
			$pdf->SetFillColor(232,232,232);
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(17,5,'ID',1,0,'C',1);
			$pdf->Cell(20,5,'FECHA',1,0,'C',1);
			$pdf->Cell(65,5,'CLIENTE',1,0,'C',1);
			//$pdf->Cell(25,5,'MONEDA',1,0,'C',1);
			$pdf->Cell(55,5,'ARTICULO',1,0,'C',1);
			$pdf->Cell(18,5,'REGALIA',1,0,'C',1);
			$pdf->Cell(15,5,'CANT',1,1,'C',1);
		
			$pdf->SetFont('Arial','',6);
			$t_rd = 0;
			while ($row = $rspta->fetchObject()) {
				$date = date_create($row->fechaTransaccion);
				$fechanueva = date_format($date, "d-m-Y");
				$t_rd += $row->TOTALGS;
				$fecha_hab = $fechanueva;
				$pdf->Cell(17,5,utf8_decode($row->idRemision),1,0,'C');
				$pdf->Cell(20,5,utf8_decode($fechanueva),1,0,'C');
				$pdf->Cell(65,5,utf8_decode($row->razonSocial),1,0,'C');
				//$pdf->Cell(25,5,utf8_decode($row->moneda),1,0,'C');
				$pdf->Cell(55,5,utf8_decode($row->nombre),1,0,'C');	
				$pdf->Cell(18,5,utf8_decode($row->regalia),1,0,'C');	
				$pdf->Cell(15,5,number_format($row->cantidad),1,1,'R');
			}
			$pdf->SetFillColor(0,0,255);
		
			$pdf->Cell(130,5,utf8_decode('***'),1,0,'C');
			$pdf->Cell(30,5,utf8_decode('TOTAL GS'),1,0,'C'); 
			$pdf->Cell(30,5,number_format($t_rd,0,',','.'),1,1,'R');
		}
		
		// REMISION A CLIENTES SIN FACTURAS CON GENTILEZA
		$rspta = $rpt->rpt_remision_sin_factura_con_regalias($_GET['habilitacion']);
		if ($rspta->rowCount() > 0) {
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(0,6, 'REMISION A CLIENTES SIN FACTURAS CON GENTILEZA',0,1,'C');
			
			$pdf->SetFillColor(232,232,232);
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(17,5,'ID',1,0,'C',1);
			$pdf->Cell(20,5,'FECHA',1,0,'C',1);
			$pdf->Cell(65,5,'CLIENTE',1,0,'C',1);
			//$pdf->Cell(25,5,'MONEDA',1,0,'C',1);
			$pdf->Cell(55,5,'ARTICULO',1,0,'C',1);
			$pdf->Cell(18,5,'REGALIA',1,0,'C',1);
			$pdf->Cell(15,5,'CANT',1,1,'C',1);
		
			$pdf->SetFont('Arial','',6);
			$t_rd = 0;
			while ($row = $rspta->fetchObject()) {
				$date = date_create($row->fechaTransaccion);
				$fechanueva = date_format($date, "d-m-Y");
				$t_rd += $row->TOTALGS;
				$fecha_hab = $fechanueva;
				$pdf->Cell(17,5,utf8_decode($row->idRemision),1,0,'C');
				$pdf->Cell(20,5,utf8_decode($fechanueva),1,0,'C');
				$pdf->Cell(65,5,utf8_decode($row->razonSocial),1,0,'C');
				//$pdf->Cell(25,5,utf8_decode($row->moneda),1,0,'C');
				$pdf->Cell(55,5,utf8_decode($row->nombre),1,0,'C');	
				$pdf->Cell(18,5,utf8_decode($row->regalia),1,0,'C');	
				$pdf->Cell(15,5,number_format($row->cantidad),1,1,'R');
			}
			$pdf->SetFillColor(0,0,255);
		
			$pdf->Cell(130,5,utf8_decode('***'),1,0,'C');
			$pdf->Cell(30,5,utf8_decode('TOTAL GS'),1,0,'C'); 
			$pdf->Cell(30,5,number_format($t_rd,0,',','.'),1,1,'R');
		}
		
		// REMISION A CLIENTES CON FACTURAS SIN GENTILEZA
		$rspta = $rpt->rpt_remision_con_factura_sin_regalias($_GET['habilitacion']);
		if ($rspta->rowCount() > 0) {
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(0,6, 'REMISION A CLIENTES CON FACTURAS SIN GENTILEZA',0,1,'C');
			
			$pdf->SetFillColor(232,232,232);
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(17,5,'ID',1,0,'C',1);
			$pdf->Cell(20,5,'FECHA',1,0,'C',1);
			$pdf->Cell(65,5,'CLIENTE',1,0,'C',1);
			//$pdf->Cell(25,5,'MONEDA',1,0,'C',1);
			$pdf->Cell(55,5,'ARTICULO',1,0,'C',1);
			$pdf->Cell(18,5,'REGALIA',1,0,'C',1);
			$pdf->Cell(15,5,'CANT',1,1,'C',1);
		
			$pdf->SetFont('Arial','',6);
			$t_rd = 0;
			while ($row = $rspta->fetchObject()) {
				$date = date_create($row->fechaTransaccion);
				$fechanueva = date_format($date, "d-m-Y");
				$t_rd += $row->TOTALGS;
				$fecha_hab = $fechanueva;
				$pdf->Cell(17,5,utf8_decode($row->idRemision),1,0,'C');
				$pdf->Cell(20,5,utf8_decode($fechanueva),1,0,'C');
				$pdf->Cell(65,5,utf8_decode($row->razonSocial),1,0,'C');
				//$pdf->Cell(25,5,utf8_decode($row->moneda),1,0,'C');
				$pdf->Cell(55,5,utf8_decode($row->nombre),1,0,'C');	
				$pdf->Cell(18,5,utf8_decode($row->regalia),1,0,'C');	
				$pdf->Cell(15,5,number_format($row->cantidad),1,1,'R');
			}
			$pdf->SetFillColor(0,0,255);
		
			$pdf->Cell(130,5,utf8_decode('***'),1,0,'C');
			$pdf->Cell(30,5,utf8_decode('TOTAL GS'),1,0,'C'); 
			$pdf->Cell(30,5,number_format($t_rd,0,',','.'),1,1,'R');
		}
		
		// REMISION A CLIENTES CON FACTURAS CON GENTILEZA
		$rspta = $rpt->rpt_remision_con_factura_con_regalias($_GET['habilitacion']);
		if ($rspta->rowCount() > 0) {
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(0,6, 'REMISION A CLIENTES CON FACTURAS CON GENTILEZA',0,1,'C');
			
			$pdf->SetFillColor(232,232,232);
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(17,5,'ID',1,0,'C',1);
			$pdf->Cell(20,5,'FECHA',1,0,'C',1);
			$pdf->Cell(65,5,'CLIENTE',1,0,'C',1);
			//$pdf->Cell(25,5,'MONEDA',1,0,'C',1);
			$pdf->Cell(55,5,'ARTICULO',1,0,'C',1);
			$pdf->Cell(18,5,'REGALIA',1,0,'C',1);
			$pdf->Cell(15,5,'CANT',1,1,'C',1);
		
			$pdf->SetFont('Arial','',6);
			$t_rd = 0;
			while ($row = $rspta->fetchObject()) {
				$date = date_create($row->fechaTransaccion);
				$fechanueva = date_format($date, "d-m-Y");
				$t_rd += $row->TOTALGS;
				$fecha_hab = $fechanueva;
				$pdf->Cell(17,5,utf8_decode($row->idRemision),1,0,'C');
				$pdf->Cell(20,5,utf8_decode($fechanueva),1,0,'C');
				$pdf->Cell(65,5,utf8_decode($row->razonSocial),1,0,'C');
				//$pdf->Cell(25,5,utf8_decode($row->moneda),1,0,'C');
				$pdf->Cell(55,5,utf8_decode($row->nombre),1,0,'C');	
				$pdf->Cell(18,5,utf8_decode($row->regalia),1,0,'C');	
				$pdf->Cell(15,5,number_format($row->cantidad),1,1,'R');
			}
			$pdf->SetFillColor(0,0,255);
		
			$pdf->Cell(130,5,utf8_decode('***'),1,0,'C');
			$pdf->Cell(30,5,utf8_decode('TOTAL GS'),1,0,'C'); 
			$pdf->Cell(30,5,number_format($t_rd,0,',','.'),1,1,'R');
		}
		

	$pdf->SetFont('Arial','B',7);		

	$pdf->Cell(0,6, 'DETALLE DE PAGOS A PROVEEDORES',0,1,'C');
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(30,5,'TIPO DE PAGO',1,0,'C',1);
	$pdf->Cell(30,5,'MONEDA',1,0,'C',1);
	$pdf->Cell(30,5,'TOTAL',1,0,'C',1);
	$pdf->Cell(30,5,'TOTAL GS',1,0,'C',1);
	$pdf->Cell(30,5,'-',1,1,'C',1);
	
	$pdf->SetFont('Arial','',6);
	$rpt = new Consultas();

	$rspta = $rpt->rpt_arqueo_caja_pago($_GET['habilitacion']);
	$t_ace = 0;
	$total_efectivoe=0;

	while($row = $rspta->fetchObject())
	{
		$t_ace = $t_ace + $row->total;
		$pdf->Cell(30,5,$row->id.' - '.utf8_decode($row->descripcion),1,0,'C');
		$pdf->Cell(30,5,utf8_decode($row->moneda),1,0,'C');
		$pdf->Cell(30,5,number_format($row->total,0,',','.'),1,0,'C');
		$pdf->Cell(30,5,number_format($row->totalGs,0,',','.'),1,0,'C');
		$pdf->Cell(30,5,utf8_decode('-'),1,1,'C');	
		if ($row->id == '5') {
            $total_efectivoe = $total_efectivoe +  $row->total;
        }		
	}
 
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(0,6, 'DETALLE DE COBROS A CLIENTES (CONTADO - A CUENTA)',0,1,'C');
	$pdf->Ln(2); // Añadir un pequeño espacio debajo del título
	
	// Ajustar la cabecera
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(60,5,'TIPO DE PAGO',1,0,'C',1); // Más espacio para la descripción
	$pdf->Cell(30,5,'MONEDA',1,0,'C',1);
	$pdf->Cell(40,5,'TOTAL Gs',1,1,'C',1);
	
	$pdf->SetFont('Arial','',6);
	$rpt = new Consultas();
	
	$rspta = $rpt->rpt_arqueo_caja($_GET['habilitacion']);
	$t_aci = 0;
	$total_efectivoi = 0;
	
	while($row = $rspta->fetchObject()) {
		// Acumular total general
		$t_aci += $row->totalgs;
	
		// Imprimir cada fila de detalle
		$pdf->Cell(60,5,$row->id.' - '.utf8_decode($row->descripcion),1,0,'L'); // Justificar a la izquierda y más espacio
		$pdf->Cell(30,5,utf8_decode($row->moneda),1,0,'C');
		$pdf->Cell(40,5,number_format($row->totalgs,0,',','.'),1,1,'R'); // Justificar a la derecha para números
	
		// Calcular el total en efectivo si es tipo de pago '5'
		if ($row->id == '5') {
			$total_efectivoi += $row->totalgs;
		}				
	}
	
// Línea de separación (opcional)
$pdf->Ln(2); // Salto de línea


// Mostrar total acumulado general
$pdf->SetFont('Arial', 'B', 10); // Negrita para el total
$pdf->Cell(90,5,'TOTAL GENERAL:',1,0,'R'); // Unificar celdas anteriores
$pdf->Cell(40,5,number_format($t_aci,0,',','.'),1,1,'R');

$pdf->Ln(2); // Salto de línea

$pdf->SetFont('Arial','B',7);
$pdf->Cell(0,6, 'RESUMEN POR USUARIO Y FORMA DE PAGO (COBRANZAS + MOVIMIENTOS)', 0, 1, 'C');
$pdf->Ln(2); // Espacio debajo del título

// Cabecera
$pdf->SetFillColor(232,232,232);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(60,5,'USUARIO',1,0,'C',1);
$pdf->Cell(70,5,'FORMA DE PAGO',1,0,'C',1);
$pdf->Cell(40,5,'TOTAL Gs',1,1,'C',1);

$pdf->SetFont('Arial','',6);
$rsptaCM = $rpt->rpt_arqueo_caja_cobranzas_movimientos($_GET['habilitacion']);

$totalCM = 0;

while($row = $rsptaCM->fetchObject()) {
    $totalCM += $row->total;

    $pdf->Cell(60,5, utf8_decode($row->usuario), 1, 0, 'L');
    $pdf->Cell(70,5, utf8_decode($row->formaPago), 1, 0, 'L');
    $pdf->Cell(40,5, number_format($row->total, 0, ',', '.'), 1, 1, 'R');
}

// Línea final: total general
$pdf->SetFont('Arial','B',6);
$pdf->Cell(130,5,'TOTAL GENERAL Gs',1,0,'R');
$pdf->Cell(40,5,number_format($totalCM, 0, ',', '.'),1,1,'R');

$pdf->Ln(2); // Salto final




	// Si deseas imprimir los totales acumulados, puedes hacerlo aquí
	$pdf->Ln(5); // Espacio antes de los totales
	
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(60,5,'TOTAL EFECTIVO',1,0,'L',1);
	$pdf->Cell(110,5,number_format($total_efectivoi,0,',','.'),1,1,'R');
	$pdf->Cell(60,5,'TOTAL CREDITO',1,0,'L',1);
	$pdf->Cell(110,5,number_format($t_credito,0,',','.'),1,1,'R');

	$pdf->SetFont('Arial','B',7);
	// $pdf->Cell(0,6, 'DETALLE DE COBROS A CLIENTES APERTURA POR DENOMINACION',0,1,'C');
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',7);
	// $pdf->Cell(30,5,'MONEDA',1,0,'C',1);
	// $pdf->Cell(30,5,'DENOMINACION',1,0,'C',1);
	// $pdf->Cell(30,5,'CANTIDAD',1,0,'C',1);
	// $pdf->Cell(30,5,'TOTAL',1,1,'C',1);
	// $pdf->Cell(30,5,'-',1,1,'C',1);
	
	$pdf->SetFont('Arial','',6);
	$rpt = new Consultas();

	$rspta = $rpt->rpt_arqueo_caja_denominacion($_GET['habilitacion']);
	$t_aci = 0;
	$total_efectivoid=0;
	while($row = $rspta->fetchObject())
	{
		$t_aci = $t_aci + $row->total;

		// $pdf->Cell(30,5,utf8_decode($row->moneda),1,0,'C');
		// $pdf->Cell(30,5,utf8_decode($row->denominacion),1,0,'C');
		// $pdf->Cell(30,5,number_format($row->cantidad,0,',','.'),1,0,'C');
		// $pdf->Cell(30,5,number_format($row->denominacion*$row->cantidad,0,',','.'),1,1,'C');
		// $pdf->Cell(30,5,utf8_decode('-'),1,1,'C');	
            $total_efectivoid = $total_efectivoid +  ($row->denominacion*$row->cantidad);
            
	}	
	$pdf->cell(0,7,"Total Apertura: " .number_format($total_efectivoid,0,',','.'),0,1,'C');
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(0,6, 'CIERRE POR DENOMINACIONES',0,1,'C');
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(30,5,'MONEDA',1,0,'C',1);
	$pdf->Cell(30,5,'DENOMINACION',1,0,'C',1);
	$pdf->Cell(30,5,'CANTIDAD',1,0,'C',1);
	$pdf->Cell(30,5,'TOTAL',1,1,'C',1);
	// $pdf->Cell(30,5,'-',1,1,'C',1);
	
	$pdf->SetFont('Arial','',6);
	$rpt = new Consultas();

	$rspta = $rpt->rpt_arqueo_caja_denominacion($_GET['habilitacion']);
	$t_aci = 0;
	$total_efectivoed=0;
	while($row = $rspta->fetchObject())
	{
		$t_aci = $t_aci + $row->total;

		$pdf->Cell(30,5,utf8_decode($row->moneda),1,0,'C');
		$pdf->Cell(30,5,utf8_decode($row->denominacion),1,0,'C');
		$pdf->Cell(30,5,number_format($row->cantidadCierre,0,',','.'),1,0,'C');
		$pdf->Cell(30,5,number_format($row->totalCierre,0,',','.'),1,1,'C');
		// $pdf->Cell(30,5,utf8_decode('-'),1,1,'C');	
            $total_efectivoed = $total_efectivoed +  ($row->denominacion*$row->cantidadCierre);;
        			
	}
	$pdf->cell(0,7,"Total Cierre: " .number_format($total_efectivoed,0,',','.'),0,1,'C');
 

	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(0,6, 'RESUMEN',0,1,'C');
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(130,5,'DESCRIPCION',1,0,'C',1);
	$pdf->Cell(30,5,'TOTAL',1,1,'C',1);
	
	$pdf->SetFont('Arial','',6);
	$rpt = new Consultas();

	$t_pagado = $t_ace;
	$t_cobrado = $t_aci;
	$t_general = ($t_aci ) - ($t_ace );
	$t_efectivo =  ($total_efectivoi+$total_efectivoid + $total_efectivoefi) - ( $total_efectivoe + $total_efectivoef ) + $total_general_efectivo_movimientos;
	$balance =  $total_efectivoed - $t_efectivo;


 
	$pdf->Cell(130,5,utf8_decode('TOTAL EN EFECTIVO '),1,0,'C');
	$pdf->Cell(30,5,number_format($t_efectivo,0,',','.'),1,1,'C'); 
	

	$pdf->Cell(130,5,utf8_decode('TOTAL CAJA CHICA CIERRE'),1,0,'C');
	$pdf->Cell(30,5,number_format($total_efectivoed,0,',','.'),1,1,'C'); 

	if ($total_efectivoed-$t_efectivo < 0) {
		$texto = 'Caja chica con faltante';
		$r = '250';
		$g = '0';
		$b = '0';
		$pdf->SetDrawColor(250,0,0);
		$pdf->setTextColor(250,0,0);
	}

	if ($total_efectivoed-$t_efectivo == 0) {
		$texto = 'Caja chica ha balanceado correctamente';
		$r = '0';
		$g = '100';
		$b = '0';
		$pdf->SetDrawColor(0,100,0);
		$pdf->setTextColor(0,100,0);
	}

	if ($total_efectivoed-$t_efectivo > 0) {
		$texto = 'Caja chica con sobrante';
		$r = '255';
		$g = '0';
		$b = '255';
		$pdf->SetDrawColor(255,0,255);
		$pdf->setTextColor(255,0,255);
	}




	$pdf->Cell(130,5,utf8_decode('RESULTADO FINAL DEL EJERCICIO'),1,0,'C');
	$pdf->Cell(30,5,number_format($total_efectivoed-$t_efectivo,0,',','.'),1,1,'C'); 
	$pdf->Cell(130,5,$texto,1,1,'C'); 
	$pdf->Cell(130,5,'Usuario: '.$usuario. ' - Habilitacion: '.$_GET['habilitacion']. ' Fecha Habilitacion: '.$fecha_hab,1,1,'C'); 


	$pdf->SetDrawColor(0,0,0);
	$pdf->setTextColor(0,0,0);
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(0,6,' ',0,1,'C');

	$pdf->Cell(0,6, 'MOVIMIENTO DE STOCK - ENTRADA DE PRODUCTOS',0,1,'C'); 
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(11,5,'ID',1,0,'C',1);
	$pdf->Cell(70,5,'DEPOSITO',1,0,'C',1);
	$pdf->Cell(70,5,'ARTICULO',1,0,'C',1);
	$pdf->Cell(25,5,'STOCK INICIAL',1,0,'C',1);
	$pdf->Cell(15,5,'CANT VENDIDA',1,0,'C',1);
	$pdf->Cell(15,5,'STOCK ACTUAL',1,0,'C',1);
	$pdf->Cell(15,5,'TOTAL VENDIDO',1,1,'C',1);
	 

	$pdf->SetFont('Arial','',6);

	// $rpt = new InventarioAjuste();

	// $rspta = $rpt->mostrarDetalleArqueoAjuste($_GET['habilitacion']);
	// $t_rd = 0;
	// while($row = $rspta->fetchObject())
	// {
		 
	// 	// $pdf->Cell(11,5,utf8_decode($row->idAjusteStockDetalle),1,0,'C');
	// 	// $pdf->Cell(70,5,utf8_decode($row->ns),1,0,'C');
	// 	// $pdf->Cell(70,5,utf8_decode($row->productos),1,0,'C');
	// 	// $pdf->Cell(15,5,number_format($row->stockInicial),1,1,'R');	 	
	// 	// $pdf->Cell(15,5,number_format($row->totalVendido),1,1,'R');	 	
	// 	// $pdf->Cell(15,5,number_format($row->stockInicial - $row->totalVendido),1,1,'R');	 	
	// 	// $pdf->Cell(15,5,number_format($row->montoVendido),1,1,'R');	 	
	// }

	// $pdf->SetFillColor(0,0,255);
 

	$pdf->Output();
?>






