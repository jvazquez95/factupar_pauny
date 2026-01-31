<?php
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
  exit();
}

require 'header.php';

requierePermisoVista(basename(__FILE__, '.php'));
$config_inicial = null;
if ($_SESSION['parametricas'] == 1 && file_exists(__DIR__ . '/../modelos/ConfiguracionEmpresa.php')) {
  require_once __DIR__ . '/../modelos/ConfiguracionEmpresa.php';
  try {
    $conf = new ConfiguracionEmpresa();
    $config_inicial = $conf->obtener();
    if ($config_inicial === false) $config_inicial = null;
  } catch (Throwable $e) { }
}

if ($_SESSION['parametricas'] == 1) {
?>
<script>var CONFIG_EMPRESA_INICIAL = <?php echo (is_array($config_inicial) && !empty($config_inicial)) ? json_encode($config_inicial) : 'null'; ?>;</script>
<div class="content-wrapper">
  <section class="content-header" style="padding: 15px 15px 10px;">
    <h1 class="mb-0" style="font-size: 1.5rem; color: #374151;">Configuracion de la Empresa</h1>
  </section>
  <section class="content" style="padding: 0 15px 20px;">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-default" style="background: #fff;">
          <div class="box-header with-border">
            <h3 class="box-title">Nombre, RUC, logo y color del sistema (datos por sucursal en Parametricas &rarr; Sucursales)</h3>
          </div>
          <div class="panel-body" id="formularioregistros" style="padding: 20px;">
            <form name="formulario" id="formulario" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="id" id="id" value="1">
              <input type="hidden" name="logo_actual" id="logo_actual">
              <div class="row">
                <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  <label>Nombre de la empresa:</label>
                  <input type="text" class="form-control" name="nombre_empresa" id="nombre_empresa" maxlength="200" placeholder="Nombre que se muestra en facturas, menu, recibos" value="<?php echo (is_array($config_inicial) && isset($config_inicial['nombre_empresa'])) ? htmlspecialchars($config_inicial['nombre_empresa']) : ''; ?>">
                </div>
                <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  <label>RUC:</label>
                  <input type="text" class="form-control" name="ruc" id="ruc" maxlength="50" placeholder="RUC de la empresa" value="<?php echo (is_array($config_inicial) && isset($config_inicial['ruc'])) ? htmlspecialchars($config_inicial['ruc']) : ''; ?>">
                </div>
              </div>
              <div class="row">
                <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  <label>Color primario del sistema:</label>
                  <input type="color" class="form-control" name="color_primario" id="color_primario" value="<?php echo (is_array($config_inicial) && !empty($config_inicial['color_primario'])) ? htmlspecialchars($config_inicial['color_primario']) : '#007bff'; ?>" style="height: 38px; padding: 2px;">
                  <input type="text" class="form-control" id="color_primario_hex" maxlength="7" placeholder="#007bff" value="<?php echo (is_array($config_inicial) && !empty($config_inicial['color_primario'])) ? htmlspecialchars($config_inicial['color_primario']) : '#007bff'; ?>" style="margin-top: 5px;">
                </div>
                <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  <label>Logo (facturas, menu, recibos):</label>
                  <input type="file" class="form-control" name="logo" id="logo" accept="image/jpeg,image/jpg,image/png,image/gif">
                  <div id="preview_logo" style="margin-top: 10px;"><?php if (is_array($config_inicial) && !empty($config_inicial['logo_ruta'])) { ?><img src="../<?php echo htmlspecialchars($config_inicial['logo_ruta']); ?>?t=<?php echo time(); ?>" style="max-width: 200px; max-height: 80px;" alt="Logo"><?php } ?></div>
                </div>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php
} else {
  require 'noacceso.php';
}

require 'footer.php';
?>
<script type="text/javascript" src="scripts/configuracionEmpresa.js"></script>
<?php
ob_end_flush();
?>
