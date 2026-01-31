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
if ($_SESSION['ventas']==1)
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
                          <h1 class="box-title">Habilitacion <button class="btn btn-success" id="btnagregar" onclick="actualizaform()"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Nro. Hab</th>
                            <th>Caja</th>
                            <th>Cajero</th>
                            <th>Fecha Apertura</th>
                            <th>Fecha Cierre</th>
                            <th>Monto apertura</th>
                            <th>Monto cierre</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Nro. Hab</th>
                            <th>Caja</th>
                            <th>Cajero</th>
                            <th>Fecha Apertura</th>
                            <th>Fecha Cierre</th>
                            <th>Monto apertura</th>
                            <th>Monto cierre</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Caja:</label>
                            <input type="hidden" name="idhabilitacion" id="idhabilitacion">
                            <select id="Caja_idCaja" name="Caja_idCaja" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Cajero:</label>
                            <select id="Usuario_idUsuario" name="Usuario_idUsuario" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Fecha apertura:</label>
                            <input type="date" class="form-control" name="fechaApertura" id="fechaApertura" value="<?php echo date("Y-m-d");?>">
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Monto apertura:</label>
                            <input type="text" class="form-control" name="montoApertura" id="montoApertura" maxlength="256" placeholder="Monto apertura">
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Monto cierre:</label>
                            <input type="text" class="form-control" name="montoCierre" id="montoCierre" maxlength="256" placeholder="Monto cierre">
                          </div>
        <!-- 
                            <label>Fecha apertura:</label>
                            <span class="label label-default"><?php echo date('d-m-y : h-m-s'); ?></span>
                            <label>Fecha cierre:</label>
                            <span class="label label-default"><?php echo 'dd-mm-yyyy : h-m-s'; ?></span>
                            <label>Estado:</label>
                            <span id="estado" name="estado" class="label label-default">Habilitado</span>
                            
-->
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
                       <div class="container">
                           <style>
                          </style>
                          <!-- The Modal -->
                          <div class="modal" id="modal_detalle">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                              <div class="modal-content">
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <span>Detalle de Habilitacion:<input type="text" disabled name="detalle" id="detalle" /> </span>
                          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 table-responsive">
                                
                                <table id="tbllistado4" class="table table-striped table-bordered table-condensed table-hover">
                                  <thead>
                                    <th>Nro. Habilitacion</th>
                                    <th>Nro. Item</th>
                                    <th>Moneda</th>
                                    <th>Denominacion</th>
                                    <th>Monto Apertura</th>
                                    <th>Monto Cierre</th>
 
                                  </thead>
                                  <tbody>                            
                                  </tbody>
                                  <tfoot>
                                    <th>Nro. Habilitacion</th>
                                    <th>Nro. Item</th>
                                    <th>Moneda</th>
                                    <th>Denominacion</th>
                                    <th>Monto Apertura</th>
                                    <th>Monto Cierre</th>
 
                                  </tfoot>
                                </table>
                                </div>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
  <!--Fin-Contenido-->
<?php
}
else
{
  require 'noacceso.php';
}

require 'footer.php';
?>
<script type="text/javascript" src="scripts/habilitacion.js"></script>
<?php 
}
ob_end_flush();
?>


