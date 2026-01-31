<?php
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
  exit();
}

require 'header.php';

requierePermisoVista(basename(__FILE__, '.php'));
if (($_SESSION['escritorio'] ?? 0) == 1 || tienePermisoVista('escritorio')) {
?>

<div class="content-wrapper">
  <section class="content-header" style="padding: 15px 15px 10px;">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
      <h1 class="mb-0" style="font-size: 1.5rem; color: #374151;">Escritorio</h1>
      <div class="text-muted small">
        <i class="fa fa-user"></i> <?php echo htmlspecialchars($_SESSION["nombre"]); ?>
      </div>
    </div>
  </section>

  <section class="content" style="padding: 0 15px 20px;">
    <div class="row">

      <!-- Tarjeta bienvenida + usuario -->
      <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 4px solid #e5a00d !important;">
          <div class="card-body p-4">
            <div class="row align-items-center">
              <div class="col-auto">
                <img src="<?php echo isset($logo_sistema) ? htmlspecialchars($logo_sistema) : '../files/logo/logo.jpg'; ?>" alt="Logo" class="rounded" style="width: 70px; height: 70px; object-fit: cover;" onerror="this.src='../files/logo/logo.jpg'">
              </div>
              <div class="col">
                <h4 class="mb-1" style="color: #1f2937;">Bienvenido, <?php echo htmlspecialchars($_SESSION["nombre"]); ?></h4>
                <p class="text-muted mb-0 small">Sistema de Gestión <?php echo isset($nombre_sistema) ? htmlspecialchars($nombre_sistema) : 'Pauny'; ?></p>
              </div>
              <div class="col-auto">
                <a href="cambiarPass.php" class="btn btn-outline-warning btn-sm mr-1"><i class="fa fa-lock"></i> Cambiar contraseña</a>
                <a href="../ajax/usuario.php?op=salir" class="btn btn-outline-danger btn-sm"><i class="fa fa-sign-out"></i> Cerrar sesión</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Módulos -->
      <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
        <a href="persona.php" class="text-decoration-none">
          <div class="card border-0 shadow-sm h-100 escritorio-card" style="border-radius: 12px; transition: transform 0.2s, box-shadow 0.2s;">
            <div class="card-body text-center p-4">
              <div class="mb-2" style="color: #0ea5e9;"><i class="fa fa-user-plus" style="font-size: 2.5rem;"></i></div>
              <h5 class="card-title mb-1" style="color: #1f2937;">Clientes y Proveedores</h5>
              <p class="card-text small text-muted mb-0">Registro de personas</p>
            </div>
            <div class="card-footer bg-transparent border-0 py-2 text-center">
              <span class="small text-primary">Ir al módulo <i class="fa fa-arrow-circle-right"></i></span>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
        <a href="dashboard.php" class="text-decoration-none">
          <div class="card border-0 shadow-sm h-100 escritorio-card" style="border-radius: 12px; transition: transform 0.2s, box-shadow 0.2s;">
            <div class="card-body text-center p-4">
              <div class="mb-2" style="color: #dc2626;"><i class="fa fa-bar-chart" style="font-size: 2.5rem;"></i></div>
              <h5 class="card-title mb-1" style="color: #1f2937;">Dashboard</h5>
              <p class="card-text small text-muted mb-0">Estadísticas</p>
            </div>
            <div class="card-footer bg-transparent border-0 py-2 text-center">
              <span class="small text-primary">Ver dashboard <i class="fa fa-arrow-circle-right"></i></span>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
        <a href="compraDirecta.php" class="text-decoration-none">
          <div class="card border-0 shadow-sm h-100 escritorio-card" style="border-radius: 12px; transition: transform 0.2s, box-shadow 0.2s;">
            <div class="card-body text-center p-4">
              <div class="mb-2" style="color: #7c3aed;"><i class="fa fa-shopping-cart" style="font-size: 2.5rem;"></i></div>
              <h5 class="card-title mb-1" style="color: #1f2937;">Compras</h5>
              <p class="card-text small text-muted mb-0">Gestión de compras</p>
            </div>
            <div class="card-footer bg-transparent border-0 py-2 text-center">
              <span class="small text-primary">Ir a compras <i class="fa fa-arrow-circle-right"></i></span>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
        <a href="ordenVentaAFacturar.php" class="text-decoration-none">
          <div class="card border-0 shadow-sm h-100 escritorio-card" style="border-radius: 12px; transition: transform 0.2s, box-shadow 0.2s;">
            <div class="card-body text-center p-4">
              <div class="mb-2" style="color: #059669;"><i class="fa fa-credit-card" style="font-size: 2.5rem;"></i></div>
              <h5 class="card-title mb-1" style="color: #1f2937;">Ventas</h5>
              <p class="card-text small text-muted mb-0">Gestión de ventas</p>
            </div>
            <div class="card-footer bg-transparent border-0 py-2 text-center">
              <span class="small text-primary">Ir a ventas <i class="fa fa-arrow-circle-right"></i></span>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
        <a href="usuario.php" class="text-decoration-none">
          <div class="card border-0 shadow-sm h-100 escritorio-card" style="border-radius: 12px; transition: transform 0.2s, box-shadow 0.2s;">
            <div class="card-body text-center p-4">
              <div class="mb-2" style="color: #e5a00d;"><i class="fa fa-users" style="font-size: 2.5rem;"></i></div>
              <h5 class="card-title mb-1" style="color: #1f2937;">Accesos</h5>
              <p class="card-text small text-muted mb-0">Usuarios y permisos</p>
            </div>
            <div class="card-footer bg-transparent border-0 py-2 text-center">
              <span class="small text-primary">Ver usuarios <i class="fa fa-arrow-circle-right"></i></span>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
        <a href="inventarioDeposito.php" class="text-decoration-none">
          <div class="card border-0 shadow-sm h-100 escritorio-card" style="border-radius: 12px; transition: transform 0.2s, box-shadow 0.2s;">
            <div class="card-body text-center p-4">
              <div class="mb-2" style="color: #2563eb;"><i class="fa fa-cubes" style="font-size: 2.5rem;"></i></div>
              <h5 class="card-title mb-1" style="color: #1f2937;">Stock</h5>
              <p class="card-text small text-muted mb-0">Inventario por depósito</p>
            </div>
            <div class="card-footer bg-transparent border-0 py-2 text-center">
              <span class="small text-primary">Ver stock <i class="fa fa-arrow-circle-right"></i></span>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
        <a href="ordenRemision.php" class="text-decoration-none">
          <div class="card border-0 shadow-sm h-100 escritorio-card" style="border-radius: 12px; transition: transform 0.2s, box-shadow 0.2s;">
            <div class="card-body text-center p-4">
              <div class="mb-2" style="color: #0d9488;"><i class="fa fa-truck" style="font-size: 2.5rem;"></i></div>
              <h5 class="card-title mb-1" style="color: #1f2937;">Remisiones</h5>
              <p class="card-text small text-muted mb-0">Control de remisiones</p>
            </div>
            <div class="card-footer bg-transparent border-0 py-2 text-center">
              <span class="small text-primary">Ver remisiones <i class="fa fa-arrow-circle-right"></i></span>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
        <a href="https://factupar.com.py/pauny/app.apk" class="text-decoration-none" target="_blank" rel="noopener">
          <div class="card border-0 shadow-sm h-100 escritorio-card" style="border-radius: 12px; background: linear-gradient(135deg, #1f2937 0%, #374151 100%); color: #fff; transition: transform 0.2s, box-shadow 0.2s;">
            <div class="card-body text-center p-4">
              <div class="mb-2"><i class="fa fa-mobile" style="font-size: 2.5rem; color: #e5a00d;"></i></div>
              <h5 class="card-title mb-1">App móvil</h5>
              <p class="card-text small mb-0" style="opacity: 0.9;">Descargar aplicación</p>
            </div>
            <div class="card-footer bg-transparent border-0 py-2 text-center">
              <span class="small"><i class="fa fa-download"></i> Descargar</span>
            </div>
          </div>
        </a>
      </div>

      <!-- Cambio del día por moneda (compacto, al final) -->
      <div class="col-12 mt-2 mb-4">
        <div class="card border-0 shadow-sm escritorio-cotizaciones-card" style="border-radius: 10px; border-left: 3px solid #e5a00d;">
          <div class="card-body py-2 px-3 cursor-pointer" id="cotizaciones-toggle" style="cursor: pointer;">
            <span class="text-muted small"><i class="fa fa-exchange"></i> Cambio del día por moneda</span>
            <span class="float-right text-muted small"><i class="fa fa-chevron-down" id="cotizaciones-chevron"></i></span>
          </div>
          <div id="cotizaciones-body" style="display: none;">
            <div class="card-body pt-0 px-3 pb-3">
              <div id="cotizaciones-escritorio" class="table-responsive">
                <table class="table table-sm table-bordered mb-0" style="font-size: 0.85rem;">
                  <thead><tr><th>Moneda</th><th>Fecha</th><th>Venta (Gs.)</th><th>Compra (Gs.)</th></tr></thead>
                  <tbody></tbody>
                </table>
              </div>
              <p class="text-muted small mb-0 mt-2" id="cotizaciones-msg">Cargando...</p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

<style>
  .escritorio-card:hover { transform: translateY(-4px); box-shadow: 0 8px 20px rgba(0,0,0,0.1) !important; }
  .escritorio-cotizaciones-card .card-body.py-2 { user-select: none; }
  .escritorio-cotizaciones-card .card-body.py-2:hover { background: #fafafa; }
</style>

<?php
} else {
  require 'noacceso.php';
}

require 'footer.php';
?>

<script type="text/javascript" src="scripts/categoria.js"></script>
<script src="../public/js/chart.min.js"></script>
<script src="../public/js/Chart.bundle.min.js"></script>
<script>
$(function(){
  $.get("../ajax/cotizacionDiaria.php?op=listarUltimasPorMoneda", function(data){
    var d = typeof data === 'string' ? JSON.parse(data) : data;
    var tbody = $("#cotizaciones-escritorio tbody");
    tbody.empty();
    if (d && d.length) {
      $.each(d, function(i, r){
        var f = '-';
        if (r.fecha) {
          var s = r.fecha.substring(0, 10);
          var parts = s.split('-');
          if (parts.length === 3) f = parts[2] + '-' + parts[1] + '-' + parts[0];
          else f = s;
        }
        tbody.append('<tr><td>'+ (r.descripcion||'') +'</td><td>'+ f +'</td><td>'+ (r.cotizacionVenta != null ? Number(r.cotizacionVenta).toLocaleString() : '-') +'</td><td>'+ (r.cotizacionCompra != null ? Number(r.cotizacionCompra).toLocaleString() : '-') +'</td></tr>');
      });
      $("#cotizaciones-msg").text("Última cotización registrada por moneda.");
    } else {
      $("#cotizaciones-msg").text("No hay cotizaciones cargadas. Configure en Contabilidad → Cotización Diaria.");
    }
  }).fail(function(){ $("#cotizaciones-msg").text("Error al cargar cotizaciones."); });

  // Expandir/colapsar cotizaciones (sin Bootstrap collapse para evitar doble toggle)
  $("#cotizaciones-toggle").on("click", function(e){
    e.preventDefault();
    e.stopPropagation();
    var $body = $("#cotizaciones-body");
    var $chevron = $("#cotizaciones-chevron");
    if ($body.is(":visible")) {
      $body.slideUp(200);
      $chevron.removeClass("fa-chevron-up").addClass("fa-chevron-down");
    } else {
      $body.slideDown(200);
      $chevron.removeClass("fa-chevron-down").addClass("fa-chevron-up");
    }
  });
});
</script>

<?php
ob_end_flush();
?>
