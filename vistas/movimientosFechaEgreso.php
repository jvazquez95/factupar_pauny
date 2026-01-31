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
                          <h1 class="box-title">Consulta de movimientos por fecha y concepto</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                          <label>Ingrese rango de fechas</label>

                    <div class="panel-body table-responsive" id="listadoregistros">

                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          <input type="date" class="form-control" name="fi" id="fi" value="<?php echo date("Y-m-d"); ?>">
                        </div>

                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          <input type="date" class="form-control" name="ff" id="ff" value="<?php echo date("Y-m-d"); ?>">
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Concepto:</label>
                            <select id="idConcepto" name="idConcepto" class="form-control selectpicker" data-live-search="true" required></select>
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
                            <th>Nro movimiento</th>
                            <th>Nro Habilitacion</th>
                            <th>Usuario</th>
                            <th>Fecha</th>
                            <th>concepto</th>
                            <th>Descripcion del concepto</th>
                            <th>Tipo</th>
                            <th>Descipcion del movimiento</th>
                            <th>Monto</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Nro movimiento</th>
                            <th>Nro Habilitacion</th>
                            <th>Usuario</th>
                            <th>Fecha</th>
                            <th>concepto</th>
                            <th>Descripcion del concepto</th>
                            <th>Tipo</th>
                            <th>Descipcion del movimiento</th>
                            <th>Monto</th>
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
<script type="text/javascript" src="scripts/movimientoFechaEgresos.js"></script>
<?php 
}
ob_end_flush();
?>


