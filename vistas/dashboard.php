<?php
/* ============================================================================
   dashboard.php — Dashboard con filtros:
   ▸ Artículo(s) ▸ Vendedor(es) (usuarios + tercerizados) ▸ Rango de fechas
   ▸ Bootstrap 5.3 + Chart.js 4.4
   ▸ Máx. 2 gráficos por fila – Tablas totalizadas y KPI sin cambiar
============================================================================ */
session_start();
if (!isset($_SESSION['nombre'])) { header('Location: login.html'); exit; }

require_once "../config/Conexion.php";            // ejecutarConsulta()

/* ════════════════════════════════════════════════════════════════════════ */
/* 0.  Catálogos para los selectores                                        */
/* ════════════════════════════════════════════════════════════════════════ */
/* 0.A Artículos ---------------------------------------------------------- */
$articuloRows = ejecutarConsulta("
  SELECT idArticulo, nombre
  FROM   articulo
  WHERE  inactivo = 0
  ORDER  BY nombre")->fetchAll(PDO::FETCH_OBJ);

/* 0.B Vendedores (internos + tercerizados) ------------------------------ */
$vendorRows = ejecutarConsulta("
  SELECT CONCAT('U_',u.login) AS vid, u.login AS nombre
  FROM   usuario u
  UNION ALL
  SELECT CONCAT('T_',p.idPersona) AS vid, p.nombreComercial
  FROM   persona p
  WHERE  p.tercerizado = 1
  ORDER  BY nombre")->fetchAll(PDO::FETCH_OBJ);

/* ════════════════════════════════════════════════════════════════════════ */
/* 0.1  Leer filtros GET                                                   */
$selArt  = isset($_GET['articulo']) ? array_map('intval', $_GET['articulo']) : [];
$selVend = isset($_GET['vendedor']) ? $_GET['vendedor'] : [];              // strings 'U_x' / 'T_y'
$dateFrom = $_GET['desde'] ?? date('Y-m-01');
$dateTo   = $_GET['hasta'] ?? date('Y-m-d');

/* 0.2  Armar cláusulas dinámicas ---------------------------------------- */
$filterArt  = empty($selArt)  ? '' : ' AND dv.Articulo_idArticulo IN (' . implode(',',$selArt) . ')';

$vendInternos = $vendTerc = [];
foreach ($selVend as $v) {
  if (str_starts_with($v,'U_')) $vendInternos[] = substr($v,2);      // login
  elseif (str_starts_with($v,'T_')) $vendTerc[] = (int)substr($v,2); // idPersona
}
$filterInt = empty($vendInternos) ? '' : " AND u.login IN ('" . implode("','",$vendInternos) . "')";
$filterTer = empty($vendTerc)     ? '' : ' AND p.idPersona IN ('      . implode(',',$vendTerc) . ')';

/* Date rango */
$filterDate = " AND DATE(v.fechaFactura) BETWEEN '$dateFrom' AND '$dateTo'";

/* ════════════════════════════════════════════════════════════════════════ */
/* 1.  SQL  (Totales Gs por vendedor)                                     */
/* ════════════════════════════════════════════════════════════════════════ */
$sqlTot = "
SELECT u.idusuario, u.login AS nombre,
       SUM(IF(DATE(v.fechaFactura)>=DATE('$dateFrom') AND DATE(v.fechaFactura)<=DATE('$dateTo'), v.total,0)) total_rango
FROM   venta v JOIN usuario u ON u.login = v.usuarioInsercion
WHERE  v.inactivo = 0 $filterDate $filterInt
GROUP  BY u.login
UNION ALL
SELECT p.idPersona, p.nombreComercial nombre,
       SUM(IF(DATE(v.fechaFactura)>=DATE('$dateFrom') AND DATE(v.fechaFactura)<=DATE('$dateTo'), v.total,0))
FROM   venta v JOIN persona p ON v.Cliente_idCliente = p.idPersona
WHERE  p.tercerizado = 1 AND v.inactivo = 0 $filterDate $filterTer
GROUP  BY p.idPersona
ORDER  BY nombre";
$totRows = ejecutarConsulta($sqlTot)->fetchAll(PDO::FETCH_OBJ);

/* 2.  SQL  (Reposiciones filtro artículo + vendedor + fechas) ----------- */
$sqlRepos = "
/* Internos */
SELECT u.idusuario idPersona,u.login nombre,
       dv.Articulo_idArticulo prod_id,dv.descripcion prod_nom,
       SUM(IF(DATE(v.fechaFactura)>=DATE('$dateFrom') AND DATE(v.fechaFactura)<=DATE('$dateTo'), dv.cantidad,0)) cant
FROM   venta v
JOIN   usuario u      ON u.login = v.usuarioInsercion
JOIN   detalleventa dv ON v.idVenta = dv.Venta_idVenta
WHERE  v.inactivo=0 $filterDate $filterArt $filterInt
GROUP  BY u.idusuario
UNION ALL
/* Tercerizados */
SELECT p.idPersona idPersona,p.nombreComercial nombre,
       dv.Articulo_idArticulo prod_id,dv.descripcion prod_nom,
       SUM(IF(DATE(v.fechaFactura)>=DATE('$dateFrom') AND DATE(v.fechaFactura)<=DATE('$dateTo'), dv.cantidad,0)) cant
FROM   venta v
JOIN   detalleventa dv ON v.idVenta = dv.Venta_idVenta
JOIN   persona p       ON v.Cliente_idCliente = p.idPersona
WHERE  p.tercerizado=1 AND v.inactivo=0 $filterDate $filterArt $filterTer
GROUP  BY p.idPersona
ORDER  BY nombre, prod_nom";
$reposRows = ejecutarConsulta($sqlRepos)->fetchAll(PDO::FETCH_OBJ);

/* 3.  Serie mensual (últimos 12 meses – no filtra) ---------------------- */
$sqlMes = "
SELECT DATE_FORMAT(v.fechaFactura,'%Y-%m') periodo,
       SUM(v.total) total_mes
FROM   venta v WHERE v.inactivo = 0
GROUP  BY periodo ORDER BY periodo DESC LIMIT 12";
$mesRows = array_reverse(ejecutarConsulta($sqlMes)->fetchAll(PDO::FETCH_OBJ));

/* 4. KPI HOY (sin filtros) --------------------------------------------- */
require_once "../modelos/Venta.php"; require_once "../modelos/Compra.php";
$v = ($_SESSION['login']=='admin') ? (new Venta())->cantidadHoyA()
                                   : (new Venta())->cantidadHoy($_SESSION['login']);
$v=$v->fetchObject();
$c=(new Compra())->cantidadHoy()->fetchObject();
$kpi=[
 'Ventas Hoy (Gs)' => number_format((float)($v->total??0),0,',','.'),
 'Facturas Hoy'    => (int)($v->cantidad??0),
 'Compras Hoy (Gs)'=> number_format((float)($c->total??0),0,',','.'),
 'OC Hoy'          => (int)($c->cantidad??0)
];

/* 5. Arrays para Chart.js + totales ------------------------------------ */
$labVend=$totVend=[]; foreach($totRows as $t){$labVend[]=$t->nombre;$totVend[]=(float)$t->total_rango;}
$totGlobal=array_sum($totVend);

$labRepos=$cantRepos=[]; foreach($reposRows as $r){$labRepos[]=$r->nombre; $cantRepos[]=(float)$r->cant;}
$reposGlobal=array_sum($cantRepos);

$labProd=[];$datProd=[]; /* distribución por producto */ 
foreach($reposRows as $r){ $labProd[$r->prod_nom]=($labProd[$r->prod_nom]??0)+(float)$r->cant; }
$labelsProd=array_keys($labProd); $dataProd=array_values($labProd);

$labMes=$dataMes=[]; foreach($mesRows as $m){$labMes[]=$m->periodo;$dataMes[]=(float)$m->total_mes;}
?>
<!DOCTYPE html><html lang="es"><head><meta charset="utf-8">
<title>Dashboard Analítico</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
 body{background:#f4f6fb;font-family:system-ui,Segoe UI,Roboto,Arial,sans-serif}
 .kpi-card{background:#fff;border-radius:12px;padding:1.2rem;box-shadow:0 2px 6px rgba(0,0,0,.06)}
 .kpi-val{font-size:1.25rem;font-weight:700;color:#0d6efd}.kpi-lbl{font-size:.85rem;color:#555}
 .report-card{background:#fff;border-radius:12px;padding:1rem;box-shadow:0 2px 6px rgba(0,0,0,.06)}
 .chart-box{background:#fff;border-radius:12px;padding:1rem;box-shadow:0 2px 6px rgba(0,0,0,.06);height:320px}
 .chart-lg{height:420px}
</style>

<!-- ENCABEZADO -->
<header class="d-flex justify-content-between align-items-center bg-white rounded shadow-sm px-4 py-3 mb-4">
  <div class="d-flex align-items-center">
    <img src="../files/logo/logo.jpg" width="60" height="60" class="me-3 rounded-circle shadow-sm" alt="Logo Factupar">
    <div>
      <h4 class="mb-0 fw-bold text-primary">Dashboard Analítico – Factupar</h4>
      <small class="text-muted">Sistema Financiero Integrado desarrollado por <strong>FACTUPAR</strong></small>
    </div>
  </div>
  <a href="escritorio.php" class="btn btn-outline-primary">
    <i class="bi bi-arrow-left-circle me-1"></i> Volver al Escritorio
  </a>
</header>


</head><body class="container-fluid py-3">

<!-- =========================== FILTROS ================================== -->
<form method="get" class="row g-3 align-items-end mb-4">
  <!-- Artículos -->
  <div class="col-lg-4">
    <label class="form-label fw-semibold">Artículo(s)</label>
    <select name="articulo[]" class="form-select" multiple size="6">
      <?php foreach($articuloRows as $a):?>
        <option value="<?=$a->idArticulo?>" <?=in_array($a->idArticulo,$selArt)?'selected':''?>>
          <?=htmlspecialchars($a->nombre)?>
        </option>
      <?php endforeach;?>
    </select>
  </div>
  <!-- Vendedores -->
  <div class="col-lg-4">
    <label class="form-label fw-semibold">Vendedor(es)</label>
    <select name="vendedor[]" class="form-select" multiple size="6">
      <?php foreach($vendorRows as $vRow):?>
        <option value="<?=$vRow->vid?>" <?=in_array($vRow->vid,$selVend)?'selected':''?>>
          <?=htmlspecialchars($vRow->nombre)?>
        </option>
      <?php endforeach;?>
    </select>
  </div>
  <!-- Fechas -->
  <div class="col-lg-2">
    <label class="form-label fw-semibold">Desde</label>
    <input type="date" name="desde" value="<?=$dateFrom?>" class="form-control">
  </div>
  <div class="col-lg-2">
    <label class="form-label fw-semibold">Hasta</label>
    <input type="date" name="hasta" value="<?=$dateTo?>" class="form-control">
  </div>
  <div class="col-auto">
    <button class="btn btn-primary">Aplicar filtro</button>
  </div>
</form>

<!-- ================= KPI CARDS ========================================= -->
<div class="row g-4 text-center mb-4">
  <?php foreach($kpi as $lbl=>$val):?>
  <div class="col-6 col-lg-3"><div class="kpi-card">
     <div class="kpi-val"><?=$val?></div><div class="kpi-lbl"><?=$lbl?></div></div></div>
  <?php endforeach;?>
</div>

<!-- ================= TABLAS ============================================ -->
<div class="row g-4 mb-4">
  <div class="col-lg-6">
    <div class="report-card">
      <h6>Totales Gs (<?=$dateFrom?> → <?=$dateTo?>)</h6>
      <table class="table table-sm table-striped align-middle">
        <thead class="table-light"><tr><th>Vendedor</th><th class="text-end">Total</th></tr></thead>
        <tbody><?php foreach($totRows as $t):?>
          <tr><td><?=htmlspecialchars($t->nombre)?></td>
              <td class="text-end"><?=number_format($t->total_rango,0,',','.')?></td></tr>
        <?php endforeach;?></tbody>
        <tfoot class="table-light fw-semibold"><tr>
          <td>Total</td><td class="text-end"><?=number_format($totGlobal,0,',','.')?></td></tr></tfoot>
      </table>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="report-card">
      <h6>Reposiciones (u) (<?=$dateFrom?> → <?=$dateTo?>)</h6>
      <table class="table table-sm table-striped align-middle">
        <thead class="table-light"><tr><th>Vendedor</th><th class="text-end">Cantidad</th></tr></thead>
        <tbody><?php foreach($reposRows as $r):?>
          <tr><td><?=htmlspecialchars($r->nombre)?></td>
              <td class="text-end"><?=number_format($r->cant,0,',','.')?></td></tr>
        <?php endforeach;?></tbody>
        <tfoot class="table-light fw-semibold"><tr>
          <td>Total</td><td class="text-end"><?=number_format($reposGlobal,0,',','.')?></td></tr></tfoot>
      </table>
    </div>
  </div>
</div>

<!-- ================= GRÁFICOS ========================================== -->
<div class="row g-4">
  <div class="col-md-6"><div class="chart-box"><canvas id="barVend"></canvas></div></div>
  <div class="col-md-6"><div class="chart-box"><canvas id="pieVend"></canvas></div></div>
  <div class="col-md-6"><div class="chart-box"><canvas id="barRepo"></canvas></div></div>
  <div class="col-md-6"><div class="chart-box"><canvas id="pieProd"></canvas></div></div>
  <div class="col-12"><div class="chart-box chart-lg"><canvas id="lineMes"></canvas></div></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
<script>
const pal=n=>Array.from({length:n},(_,i)=>`hsl(${i*360/n},70%,60%)`);
document.addEventListener('DOMContentLoaded',()=>{

new Chart('barVend',{type:'bar',
  data:{labels:<?=json_encode($labVend)?>,
        datasets:[{label:'Total Gs',data:<?=json_encode($totVend)?>,backgroundColor:'#0d6efd'}]},
  options:{responsive:true,plugins:{title:{display:true,text:'Totales Gs por Vendedor'},legend:{display:false}},
    scales:{y:{beginAtZero:true,ticks:{callback:v=>v.toLocaleString('es-ES')}}}}});

new Chart('pieVend',{type:'pie',
  data:{labels:<?=json_encode($labVend)?>,
        datasets:[{data:<?=json_encode($totVend)?>,backgroundColor:pal(<?=count($labVend)?>)}]},
  options:{plugins:{title:{display:true,text:'Participación Ventas'},legend:{position:'bottom'}},responsive:true}});

new Chart('barRepo',{type:'bar',
  data:{labels:<?=json_encode($labRepos)?>,
        datasets:[{label:'Cantidad',data:<?=json_encode($cantRepos)?>,backgroundColor:'#ffc107'}]},
  options:{plugins:{title:{display:true,text:'Reposiciones (u)'}},responsive:true,
    scales:{y:{beginAtZero:true}}}});

new Chart('pieProd',{type:'doughnut',
  data:{labels:<?=json_encode($labelsProd)?>,
        datasets:[{data:<?=json_encode($dataProd)?>,backgroundColor:pal(<?=count($labelsProd)?>)}]},
  options:{plugins:{title:{display:true,text:'Distribución por Producto'},legend:{position:'bottom'}},responsive:true}});

new Chart('lineMes',{type:'line',
  data:{labels:<?=json_encode($labMes)?>,
        datasets:[{label:'Ventas Gs',data:<?=json_encode($dataMes)?>,borderColor:'#6f42c1',fill:false,tension:.3}]},
  options:{plugins:{title:{display:true,text:'Ventas Totales – Últimos 12 Meses'},legend:{display:false}},
    responsive:true,scales:{y:{beginAtZero:true,ticks:{callback:v=>v.toLocaleString('es-ES')}}}}});
});
</script>
</body></html>
