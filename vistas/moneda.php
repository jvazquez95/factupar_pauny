<?php
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
  exit();
}

require 'header.php';

requierePermisoVista(basename(__FILE__, '.php'));
if ($_SESSION['parametricas'] == 1) {
?>
<div class="content-wrapper">
  <section class="content-header" style="padding: 15px 15px 10px;">
    <h1 class="mb-0" style="font-size: 1.5rem; color: #374151;">Monedas</h1>
  </section>
  <section class="content" style="padding: 0 15px 20px;">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-default" style="background: #fff;">
          <div class="box-header with-border">
            <h3 class="box-title">Listado de monedas</h3>
            <div class="box-tools pull-right">
              <button class="btn btn-success btn-sm" id="btnagregar" onclick="mostrarform(true)">
                <i class="fa fa-plus-circle"></i> Agregar
              </button>
            </div>
          </div>
          <div class="panel-body table-responsive" id="listadoregistros">
            <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
              <thead>
                <tr>
                  <th>Opciones</th>
                  <th>Descripción</th>
                  <th>Estado</th>
                </tr>
              </thead>
              <tbody></tbody>
              <tfoot>
                <tr>
                  <th>Opciones</th>
                  <th>Descripción</th>
                  <th>Estado</th>
                </tr>
              </tfoot>
            </table>
          </div>
          <div class="panel-body" id="formularioregistros" style="display: none; padding: 20px;">
            <form name="formulario" id="formulario" method="POST">
              <input type="hidden" name="idMoneda" id="idMoneda">
              <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label>Descripción:</label>
                <input type="text" class="form-control" name="descripcion" id="descripcion" maxlength="50" placeholder="Ej: Guaraníes, Dólares" required>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" type="button" onclick="cancelarform()"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
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
<script type="text/javascript" src="scripts/moneda.js"></script>
<?php
ob_end_flush();
?>
