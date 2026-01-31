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
if ($_SESSION['compras']==1)
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
                          <h1 class="box-title">Cierre de Recepcion de Mercaderias</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Orden #</th>
                            <th>Nro Compra</th>
                            <th>Fecha</th>
                            <th>Proveedor</th>
                            <th>Sucursal</th>
                            <th>Deposito</th>
                            <th>Termino de Pago</th>
                            <th>Total Impuesto</th>
                            <th>Sub Total</th>
                            <th>Total</th>
                            <th>Usuario Ins</th>
                            <th>Usuario Mod</th>
                            <th>Detalles</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Orden #</th>
                            <th>Nro Compra</th>
                            <th>Fecha</th>
                            <th>Proveedor</th>
                            <th>Sucursal</th>
                            <th>Deposito</th>
                            <th>Termino de Pago</th>
                            <th>Total Impuesto</th>
                            <th>Sub Total</th>
                            <th>Total</th>
                            <th>Usuario Ins</th>
                            <th>Usuario Mod</th>
                            <th>Detalles</th>
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
<script type="text/javascript" src="scripts/cierreRecepcion.js"></script>
<?php 
}
ob_end_flush();
?>


