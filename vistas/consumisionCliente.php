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
                          <h1 class="box-title">Consumisiones por cliente</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Cliente:</label>
                            <select id="idCliente" name="idCliente" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>
                          <br>
                          <br>
                          <br>
                          <br>
                          <br>
                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          <button class="btn btn-success" onclick="listar()">Mostrar</button>
                        </div>                          
                        </div>
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Id</th>
                            <th>Nombre Cliente</th>
                            <th>Nombre Paquete</th>
                            <th>Nombre Servicio</th>
                            <th>Nro. Venta</th>
                            <th>Fecha factura</th>
                            <th>Fecha Inicial</th>
                            <th>Fecha Final</th>
                            <th>Atendio</th>
                            <th>Cantidad</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Id</th>
                            <th>Nombre Cliente</th>
                            <th>Nombre Paquete</th>
                            <th>Nombre Servicio</th>
                            <th>Nro. Venta</th>
                            <th>Fecha factura</th>
                            <th>Fecha Inicial</th>
                            <th>Fecha Final</th>
                            <th>Atendio</th>
                            <th>Cantidad</th>                          
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
<script type="text/javascript" src="scripts/consumisionCliente.js"></script>
<?php 
}
ob_end_flush();
?>


