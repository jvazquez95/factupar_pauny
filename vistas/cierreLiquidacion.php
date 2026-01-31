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
                          <h1 class="box-title">Cierre de Liquidacion</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Periodo</th>
                            <th>Fecha Inicio Periodo</th>
                            <th>Fecha Fin Periodo</th>
                            <th>Fecha Apertura</th>
                            <th>Tipo de Liquidacion</th>
                            <th>Moneda</th>
                            <th>Total</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Periodo</th>
                            <th>Fecha Inicio Periodo</th>
                            <th>Fecha Fin Periodo</th>
                            <th>Fecha Apertura</th>
                            <th>Tipo de Liquidacion</th>
                            <th>Moneda</th>
                            <th>Total</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>

                  </div>



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
<script type="text/javascript" src="scripts/cierreLiquidacion.js"></script>
<?php 
}
ob_end_flush();
?>


