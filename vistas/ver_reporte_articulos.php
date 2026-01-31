<?php
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
  exit;
}
if ($_SESSION['almacen'] != 1) {
  header("Location: noacceso.php");
  exit;
}

require 'header.php';
requierePermisoVista(basename(__FILE__, '.php'));
?>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-file-pdf-o"></i> Reporte de Artículos</h3>
          <div class="box-tools pull-right">
            <a href="articuloDuplicado.php" class="btn btn-default btn-xs"><i class="fa fa-arrow-left"></i> Volver a Artículos</a>
            <a href="../reportes/rptarticulosMejorado.php" target="_blank" class="btn btn-info btn-xs"><i class="fa fa-external-link"></i> Abrir en nueva pestaña</a>
          </div>
        </div>
        <div class="box-body" style="padding:0;">
          <iframe src="../reportes/rptarticulosMejorado.php" style="width:100%; height:85vh; border:0;" title="Reporte de Artículos"></iframe>
        </div>
      </div>
    </div>
  </div>
</section>
<?php require 'footer.php'; ?>
