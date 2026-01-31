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
if ($_SESSION['acceso']==1)
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
                          <h1 class="box-title">Ajuste de Servicios/Paquete por Cliente</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                        <div class="form-group col-lg-2 col-md-4 col-sm-4 col-xs-12">
                            <label>Cliente(*):</label>
                            <select id="Cliente_idCliente" name="Cliente_idCliente" class="form-control selectpicker" data-live-search="true">
                            </select>
                          </div>
                          <br>
                          <br>
                          <br>
                          <br>
                          <br>
                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          <button class="btn btn-success" onclick="listar()">Mostrar</button>
                        </div>                          
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Id</th>
                            <th>Id Venta</th>
                            <th>Fecha venta</th>
                            <th>Nombre Cliente</th>
                            <th>Paquete</th>
                            <th>Servicio</th>
                            <th>Cantidad</th>
                            <th>Cantidad - Editar</th>
                            <th>GiftCard</th>
                            <th>Saldo</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Id</th>
                            <th>Id Venta</th>
                            <th>Fecha venta</th>
                            <th>Nombre Cliente</th>
                            <th>Paquete</th>
                            <th>Servicio</th>
                            <th>Cantidad</th>
                            <th>Cantidad - Editar</th>
                            <th>GiftCard</th>
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
<script type="text/javascript" src="scripts/rpt_clienteDetalle_ajuste.js"></script>
<?php 
}
ob_end_flush();
?>


