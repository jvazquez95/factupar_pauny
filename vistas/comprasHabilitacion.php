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
                          <h1 class="box-title">Consulta de compras por habilitacion</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          <label>Ingrese numero de habilitacion</label>
                          <input type="text" class="form-control" name="habilitacion" id="habilitacion">
                        </div>
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
                            <th>Nro compra</th>
                            <th>Nro Habilitacion</th>
                            <th>Nro Proveedor</th>
                            <th>Razon Social</th>
                            <th>Nombre Comercial</th>
                            <th>Condicion</th>
                            <th>Total Impuesto</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Opciones</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Nro compra</th>
                            <th>Nro Habilitacion</th>
                            <th>Nro Proveedor</th>
                            <th>Razon Social</th>
                            <th>Nombre Comercial</th>
                            <th>Condicion</th>
                            <th>Total Impuesto</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Opciones</th>
                          </tfoot>
                        </table>
                    </div>
                    
                        <div class="container">
                           <style>
                          </style>
                          <!-- The Modal -->
                          <div class="modal fade" id="modal_detalle">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                              <div class="modal-content">
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <span>Detalle de compra:<input type="text" disabled name="detalle" id="detalle" /> </span>
                                <table id="tbllistado4" class="table table-striped table-bordered table-condensed table-hover">
                                  <thead>
                                    <th>Nro. compra</th>
                                    <th>Id. Articulo</th>
                                    <th>Nombre</th>
                                    <th>Descripcion</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Total</th>
                                  </thead>
                                  <tbody>                            
                                  </tbody>
                                  <tfoot>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Total</th>
                                    <th></th>
                                  </tfoot>
                                </table>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                              </div>
                            </div>
                          </div>
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
<script type="text/javascript" src="scripts/comprasHabilitacion.js"></script>
<?php 
}
ob_end_flush();
?>


