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
if ($_SESSION['cargarorden']==1)
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
                          <h1 class="box-title">Orden de consumision <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Nro de Orden</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Usuario Carga</th>
                            <th>Fecha detalle</th>
                            <th>Estado</th>
                            <th>Ver detalles</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Nro de Orden</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Usuario Carga</th>
                            <th>Fecha detalle</th>
                            <th>Estado</th>
                            <th>Ver detalles</th>
                          </tfoot>
                        </table>
                    </div>

                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Fecha. Orden.:</label>
							              <input type="text" class="form-control" name="fechaConsumision1" id="fechaConsumision1" value="<?php echo date("Y-m-d"); ?>" disabled>
                            <input type="hidden" class="form-control" name="fechaConsumision" id="fechaConsumision" value="<?php echo date("Y-m-d"); ?>" required>
                          </div>

                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Usuario:</label>
							              <input type="text" class="form-control" name="usuario" id="usuario" value="<?php echo 'Usuario: ' .$_SESSION['login'].' Nombre completo: '.$_SESSION['nombre'] ?>" disabled>
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-8 col-xs-12">
                            <label>Cliente(*):</label>
                            <input type="hidden" name="idOrdenConsumision" id="idOrdenConsumision">
                            <input type="hidden" class="form-control" name="usuario" id="usuario" value="<?php echo $_SESSION['login'] ?>">
                            <input type="hidden" class="form-control" name="inactivo" id="inactivo" value="0">
                            <select onchange="cargarPS();" id="Cliente_idCliente" name="Cliente_idCliente" class="form-control selectpicker" data-live-search="true" required>
                            </select>
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Paquete:</label>
                            <select onchange="cargarS();" name="Articulo_idArticulo" id="Articulo_idArticulo" class="form-control selectpicker" data-live-search="true"></select>
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-12">
                            <label>Servicio(*):</label>
                            <select  name="Articulo_idArticulo_Servicio" id="Articulo_idArticulo_Servicio" class="form-control selectpicker" data-live-search="true" required=""></select>
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-12">
                          <label>Cantidad(*):</label>
                          <input type="number" class="form-control" name="cantidad" id="cantidad" required="">
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-12">
                          <label>Atiende(*):</label>
                            <select  name="Empleado_idEmpleado" id="Empleado_idEmpleado" class="form-control selectpicker" required=""></select>
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-12">
                          <label>Fecha - Hora - Inicio(*):</label>
                          <input type="datetime-local" class="form-control" name="fi" id="fi" required="">
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-12">
                          <label>Fecha - Hora - Fin(*):</label>
                          <input type="datetime-local" class="form-control" name="ff" id="ff" required="">
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-12">
                          <label>Sala(*):</label>
                            <select  name="sala" id="sala" class="form-control selectpicker" required="">
                              <option value="s1">Sala 1</option>
                              <option value="s2">Sala 2</option>
                              <option value="s3">Sala 3</option>
                              <option value="s4">Sala 4</option>

                              <option value="s5">Sala 5</option>
                              <option value="s6">Sala 6</option>

                            </select>
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                              <button id="btnDetalle" type="button" class="btn btn-primary" onclick="agregarDetalle();"> <span class="fa fa-plus"></span> Agregar detalle</button>
                          </div>
                          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                              <thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Paquete</th>
                                    <th>Servicio</th>
                                    <th>Cantidad</th>
                                    <th>Cantidad utilizada</th>
                                    <th>Atiende</th>
                                    <th>Terminado</th>
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Fin</th>
                                    <th>Sala</th>
                                </thead>
                                <tfoot>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Total servicios</th>                                    
                             	    <th><h4 id="totals">0</h4><input type="hidden" name="totalss" id="totalss"></th> 
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tfoot>
                                <tbody>

                                </tbody>
                            </table>
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->

  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 65% !important;">
      <div class="modal-content">
        <div class="modal-body">
          <table id="tbldetalle" class="table table-striped table-bordered table-condensed table-hover">
            <thead>
                <th>Id 1</th>
                <th>Id 2</th>
                <th>Paquete</th>
                <th>Servicio</th>
                <th>Empleado</th>
                <th>Cantidad</th>
                <th>Cantidad Utilizada</th>
                <th>Fecha inicial</th>
                <th>Fecha final</th>
            </thead>
            <tbody>
              
            </tbody>
            <tfoot>                
                <th>Id 1</th>
                <th>Id 2</th>
                <th>Paquete</th>
                <th>Servicio</th>
                <th>Empleado</th>
                <th>Cantidad</th>
                <th>Cantidad Utilizada</th>
                <th>Fecha inicial</th>
                <th>Fecha final</th>
            </tfoot>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>        
      </div>
    </div>
  </div>  
  <!-- Fin modal -->

  <!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="vuelto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Ventana de vuelto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
  <!-- Fin modal -->


<?php
}
else
{
  require 'noacceso.php';
}

require 'footer.php';
?>
<script type="text/javascript" src="scripts/ordenConsumision.js"></script>
<?php 
}
ob_end_flush();
?>


