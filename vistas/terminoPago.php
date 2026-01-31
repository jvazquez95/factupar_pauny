<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"]))
{
  header("Location: login.html");
}
else
{
require 'header.php';

requierePermisoVista(basename(__FILE__, '.php'));
if ($_SESSION['parametricas']==1)
{
?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Termino de pago <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Descripcion</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Descripcion</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Descripcion:</label>
                            <input type="hidden" name="idTerminoPago" id="idTerminoPago">
                            <input type="text" class="form-control" name="descripcion" id="descripcion" maxlength="50" placeholder="Nombre" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Tipo:</label>
                            <select id="tipo" name="tipo" class="form-control input-sm selectpicker" data-live-search="true" required>
                              <option value="0" selected>INGRESA COMO DINERO</option>
                              <option value="1">NO INGRESA COMO DINERO</option>
                            </select>
                          </div>
						  <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Dias de Vencimiento:</label>
                            <input type="text" class="form-control" name="diasVencimiento" id="diasVencimiento" maxlength="50" placeholder="Dias de vencimiento" required>
                          </div>
						  <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Cantidad de cuotas:</label>
                            <input type="text" class="form-control" name="cantidadCuotas" id="cantidadCuotas" maxlength="50" placeholder="Cantidad de cuotas" required>
                          </div>
						  <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Dia primera cuota:</label>
                            <input type="text" class="form-control" name="diaPrimeraCuota" id="diaPrimeraCuota" maxlength="50" placeholder="Dia de primera cuotas" required>
                          </div>
						  <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Porcentaje de interes:</label>
                            <input type="text" class="form-control" name="porcentajeInteres" id="porcentajeInteres" maxlength="50" placeholder="Porcentaje de Interes" required>
                          </div>
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

  <!--Fin-Contenido-->
<?php
}
else
{
  require 'noacceso.php';
}

require 'footer.php';
?>
<script type="text/javascript" src="scripts/terminoPago.js"></script>
<?php 
}
ob_end_flush();
?>


