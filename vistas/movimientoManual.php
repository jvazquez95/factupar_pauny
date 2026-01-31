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
                          <h1 class="box-title">Movimientos de caja <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                            <a href="venta.php"><span class="label bg-green">Ir a ventas</span></a>
                        </div>
                    </div>

                     
     
                            
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Nro. Movimiento</th>
                            <th>Nro. Habilitacion</th>
                            <th>Fecha</th>
                            <th>Descripcion</th>
                            <th>Concepto</th>
                            <th>Usuario</th>
                            <th>Monto</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Nro. Movimiento</th>
                            <th>Nro. Habilitacion</th>
                            <th>Fecha</th>
                            <th>Descripcion</th>
                            <th>Concepto</th>
                            <th>Usuario</th>
                            <th>Monto</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>


                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">


                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <label>Habilitacion:</label>
                            <input type="number" class="form-control" name="habilitacion" id="habilitacion" >
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Concepto:</label>
                            <input type="hidden" name="idMovimiento" id="idMovimiento">
                            <select id="idConcepto" name="idConcepto" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-4 col-xs-12">
                          <label>Seleccione empleado (En caso de que sea una acreditacion o pago de sueldo):</label>
                            <select  name="Empleado_idEmpleado" id="Empleado_idEmpleado" class="form-control selectpicker" required=""></select>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Descripcion:</label>
                            <input type="text" class="form-control" name="descripcion" id="descripcion" maxlength="256" placeholder="Descripcion">
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Monto:</label>
                            <input type="text" class="form-control" onkeyup="separadorMilesOnKey(event, this);" name="monto" id="monto" maxlength="256" placeholder="Monto">
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
<script type="text/javascript" src="scripts/movimientoManual.js"></script>
<?php 
}
ob_end_flush();
?>


