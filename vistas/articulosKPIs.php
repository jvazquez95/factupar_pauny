<?php
ob_start();
session_start();
if (!isset($_SESSION["nombre"])) {
  header('Location: login.html');
  exit;
}
require 'header.php';
requierePermisoVista(basename(__FILE__, '.php'));
if (empty($_SESSION['almacen']) || $_SESSION['almacen'] != 1) {
  require 'noacceso.php';
  exit;
}
?>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h1 class="box-title"><i class="fa fa-bar-chart"></i> Dashboard KPIs - Artículos</h1>
          <div class="box-tools pull-right">
            <a href="articuloDuplicado.php" class="btn btn-default btn-xs"><i class="fa fa-arrow-left"></i> Volver</a>
            <a href="../reportes/rptarticulosMejorado.php" target="_blank" class="btn btn-info btn-xs"><i class="fa fa-file-pdf-o"></i> Reporte PDF</a>
          </div>
        </div>
        <div class="box-body">
          <!-- KPIs -->
          <div class="row">
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3 id="kpi_total">-</h3>
                  <p>Total Artículos</p>
                </div>
                <div class="icon"><i class="fa fa-cubes"></i></div>
                <a href="articuloDuplicado.php" class="small-box-footer">Ver listado <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-green">
                <div class="inner">
                  <h3 id="kpi_activos">-</h3>
                  <p>Activos</p>
                </div>
                <div class="icon"><i class="fa fa-check-circle"></i></div>
                <a href="articuloDuplicado.php" class="small-box-footer">Ver listado <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3 id="kpi_stock">-</h3>
                  <p>Stock total</p>
                </div>
                <div class="icon"><i class="fa fa-archive"></i></div>
                <a href="#" class="small-box-footer">Unidades</a>
              </div>
            </div>
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-red">
                <div class="inner">
                  <h3 id="kpi_sin_stock">-</h3>
                  <p>Sin stock</p>
                </div>
                <div class="icon"><i class="fa fa-exclamation-triangle"></i></div>
                <a href="#" class="small-box-footer">Artículos</a>
              </div>
            </div>
          </div>
          <!-- Gráficos -->
          <div class="row">
            <div class="col-md-6">
              <div class="box box-success">
                <div class="box-header with-border"><h3 class="box-title"><i class="fa fa-pie-chart"></i> Por categoría</h3></div>
                <div class="box-body">
                  <div style="height:300px;position:relative;">
                    <canvas id="chartCategorias"></canvas>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="box box-info">
                <div class="box-header with-border"><h3 class="box-title"><i class="fa fa-trophy"></i> Top 10 vendidos (30 días)</h3></div>
                <div class="box-body">
                  <div style="height:300px;position:relative;">
                    <canvas id="chartTopVendidos"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border"><h3 class="box-title"><i class="fa fa-line-chart"></i> Ventas por día (30 días)</h3></div>
                <div class="box-body">
                  <div style="height:350px;position:relative;">
                    <canvas id="chartVentasDia"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Tablas -->
          <div class="row">
            <div class="col-md-6">
              <div class="box box-warning">
                <div class="box-header with-border"><h3 class="box-title"><i class="fa fa-exclamation-circle"></i> Bajo stock</h3></div>
                <div class="box-body table-responsive">
                  <table class="table table-bordered table-striped">
                    <thead><tr><th>Artículo</th><th>Stock</th><th>Estado</th></tr></thead>
                    <tbody id="tbodyBajoStock">
                      <tr><td colspan="3" class="text-center text-muted">Cargando...</td></tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="box box-danger">
                <div class="box-header with-border"><h3 class="box-title"><i class="fa fa-clock-o"></i> Sin movimiento (90 días)</h3></div>
                <div class="box-body table-responsive">
                  <table class="table table-bordered table-striped">
                    <thead><tr><th>Artículo</th><th>Precio</th><th>Stock</th></tr></thead>
                    <tbody id="tbodySinMovimiento">
                      <tr><td colspan="3" class="text-center text-muted">Cargando...</td></tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function() {
  var BASE = '../ajax';
  var chartCategorias = null, chartTopVendidos = null, chartVentasDia = null;

  function num(n) { return n != null && n !== '' ? Number(n) : 0; }
  function fmtNum(x) { return num(x).toLocaleString('es-PY'); }

  function loadResumen() {
    $.get(BASE + '/articulo.php', { op: 'kpisResumen' })
      .done(function(json) {
        try {
          var d = typeof json === 'string' ? JSON.parse(json) : json;
          $('#kpi_total').text(fmtNum(d.total_articulos));
          $('#kpi_activos').text(fmtNum(d.total_activos));
          $('#kpi_stock').text(fmtNum(d.stock_total));
          $('#kpi_sin_stock').text(fmtNum(d.sin_stock));
        } catch (e) {
          $('#kpi_total, #kpi_activos, #kpi_stock, #kpi_sin_stock').text('Error');
        }
      })
      .fail(function() {
        $('#kpi_total, #kpi_activos, #kpi_stock, #kpi_sin_stock').text('—');
      });
  }

  function loadCategorias() {
    $.get(BASE + '/articulo.php', { op: 'kpisCategorias' })
      .done(function(json) {
        try {
          var d = typeof json === 'string' ? JSON.parse(json) : json;
          var labels = d.labels || [];
          var data = d.data || [];
          if (labels.length === 0) labels = ['Sin datos'];
          if (data.length === 0) data = [1];
          var ctx = document.getElementById('chartCategorias');
          if (!ctx || typeof Chart === 'undefined') return;
          if (chartCategorias) chartCategorias.destroy();
          chartCategorias = new Chart(ctx.getContext('2d'), {
            type: 'doughnut',
            data: {
              labels: labels,
              datasets: [{ data: data, backgroundColor: ['#3c8dbc','#00a65a','#f39c12','#dd4b39','#00c0ef','#3d9970','#ff851b','#605ca8'], borderWidth: 2 }]
            },
            options: { responsive: true, maintainAspectRatio: false }
          });
        } catch (e) {}
      });
  }

  function loadVentas() {
    var hasta = new Date().toISOString().split('T')[0];
    var desde = new Date();
    desde.setDate(desde.getDate() - 30);
    desde = desde.toISOString().split('T')[0];
    $.get(BASE + '/articulo.php', { op: 'kpisVentas', desde: desde, hasta: hasta })
      .done(function(json) {
        try {
          var d = typeof json === 'string' ? JSON.parse(json) : json;
          var topL = d.top_labels || [], topC = d.top_cantidad || [];
          var diaL = d.dia_labels || [], diaC = d.dia_cantidad || [], diaT = d.dia_total || [];
          if (topL.length === 0) topL = ['Sin ventas'];
          if (topC.length === 0) topC = [0];
          if (diaL.length === 0) diaL = ['Sin datos'];
          if (diaC.length === 0) diaC = [0];
          if (diaT.length === 0) diaT = [0];
          var ctx1 = document.getElementById('chartTopVendidos');
          var ctx2 = document.getElementById('chartVentasDia');
          if (typeof Chart === 'undefined') return;
          if (ctx1) {
            if (chartTopVendidos) chartTopVendidos.destroy();
            chartTopVendidos = new Chart(ctx1.getContext('2d'), {
              type: 'bar',
              data: { labels: topL, datasets: [{ label: 'Cantidad', data: topC, backgroundColor: '#3c8dbc' }] },
              options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
            });
          }
          if (ctx2) {
            if (chartVentasDia) chartVentasDia.destroy();
            chartVentasDia = new Chart(ctx2.getContext('2d'), {
              type: 'line',
              data: {
                labels: diaL,
                datasets: [
                  { label: 'Cantidad', data: diaC, borderColor: '#3c8dbc', fill: true, tension: 0.3 },
                  { label: 'Total (Gs)', data: diaT, borderColor: '#00a65a', fill: true, tension: 0.3, yAxisID: 'y1' }
                ]
              },
              options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true }, y1: { beginAtZero: true, position: 'right', grid: { drawOnChartArea: false } } }
              }
            });
          }
        } catch (e) {}
      });
  }

  function loadBajoStock() {
    $.get(BASE + '/articulo.php', { op: 'kpisBajoStock' })
      .done(function(html) {
        $('#tbodyBajoStock').html(html && html.trim() ? html : '<tr><td colspan="3" class="text-center text-muted">Sin datos</td></tr>');
      })
      .fail(function() {
        $('#tbodyBajoStock').html('<tr><td colspan="3" class="text-center text-danger">Error al cargar</td></tr>');
      });
  }

  function loadSinMovimiento() {
    $.get(BASE + '/articulo.php', { op: 'kpisSinMovimiento' })
      .done(function(html) {
        $('#tbodySinMovimiento').html(html && html.trim() ? html : '<tr><td colspan="3" class="text-center text-muted">Sin datos</td></tr>');
      })
      .fail(function() {
        $('#tbodySinMovimiento').html('<tr><td colspan="3" class="text-center text-danger">Error al cargar</td></tr>');
      });
  }

  $(document).ready(function() {
    loadResumen();
    loadCategorias();
    loadVentas();
    loadBajoStock();
    loadSinMovimiento();
  });
})();
</script>
<?php require 'footer.php'; ob_end_flush(); ?>
