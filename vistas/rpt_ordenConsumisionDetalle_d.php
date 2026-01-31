

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
if ($_SESSION['consultav']==1)
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
                          <h1 class="box-title">Consulta de ordenes de consumision con detalle.</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                          <label>Ingrese rango de fechas</label>

                    <div class="panel-body table-responsive" id="listadoregistros">

                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Cliente:</label>
                            <select onchange="cargarPS();" id="Cliente_idCliente" name="Cliente_idCliente" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>

                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Paquete:</label>
                            <select onchange="cargarS();" id="idPaquete" name="idPaquete" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>

                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Servicio:</label>
                            <select id="idServicio" name="idServicio" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>

                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          <input type="date" class="form-control" name="fi" id="fi" value="<?php echo date("Y-m-d"); ?>">
                        </div>

                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          <input type="date" class="form-control" name="ff" id="ff" value="<?php echo date("Y-m-d"); ?>">
                        </div>

                        <br>
                        <br>
                        <br>
                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          <button class="btn btn-success" onclick="listar()">Mostrar</button>
                        </div>                          
                        </div>
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Nro de orden</th>
                            <th>Nro de detalle de orden</th>
                            <th>Fecha de carga</th>
                            <th>Cliente</th>
                            <th>Paquete</th>
                            <th>Servicio</th>
                            <th>Cantidad</th>
                            <th>Estado</th>
                            <th>Fecha inicio</th>
                            <th>Fecha fin</th>
                            <th>Atiende</th>
                            <th>Usuario de carga</th>
                            <th>Nro. venta</th>
                            <th>Saldo</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Nro de orden</th>
                            <th>Nro de detalle de orden</th>
                            <th>Fecha de carga</th>
                            <th>Cliente</th>
                            <th>Paquete</th>
                            <th>Servicio</th>
                            <th>Cantidad</th>
                            <th>Estado</th>
                            <th>Fecha inicio</th>
                            <th>Fecha fin</th>
                            <th>Atiende</th>
                            <th>Usuario de carga</th>
                            <th>Nro. venta</th>
                            <th>Saldo</th>
                          </tfoot>
                        </table>
                    </div>
                    
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
<?php
}
else
{
  require 'noacceso.php';
}

require 'footer.php';
?>
<script type="text/javascript" src="scripts/rpt_ordenConsumisionDetalle_d.js"></script>
<?php 
}
ob_end_flush();
?>