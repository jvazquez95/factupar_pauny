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
                          <h1 class="box-title">Movimientos - Articulos a empleados - Ingresos o Egresos <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Nro</th>
                            <th>Empleado</th>
                            <th>Articulo</th>
                            <th>Deposito</th>
                            <th>Tipo</th>
                            <th>Cantidad</th>
                            <th>Fecha Transaccion</th>
                            <th>Usuario</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Nro</th>
                            <th>Empleado</th>
                            <th>Articulo</th>
                            <th>Deposito</th>
                            <th>Tipo</th>
                            <th>Cantidad</th>
                            <th>Fecha Transaccion</th>
                            <th>Usuario</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>


                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Seelccione empleado:</label>
                            <input type="hidden" name="idArticuloEmpleado" id="idArticuloEmpleado">
                            <select id="Empleado_idEmpleado" name="Empleado_idEmpleado" class="form-control selectpicker" data-live-search="true" required>
                            </select> 
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Seleccione Articulo:</label>
                            <select id="Articulo_idArticulo" onchange="mostrarExistencia();" name="Articulo_idArticulo" class="form-control selectpicker" data-live-search="true" required>
                            </select>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Seleccione deposito:</label>
                            <select id="Deposito_idDeposito"  onchange="mostrarExistencia();" name="Deposito_idDeposito" class="form-control selectpicker" data-live-search="true" required>
                            </select>
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label class=" input-sm">Tipo de transaccion:</label>
                            <select id="tipo" name="tipo" class="form-control input-sm selectpicker" data-live-search="true" required>
                              <option value="E" selected>Egreso</option>
                              <option value="I">Ingreso</option>
                            </select>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Cantidad:</label>
                            <input type="number" class="form-control" name="cantidad" id="cantidad" maxlength="256" placeholder="Cantidad">
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
<script type="text/javascript" src="scripts/articuloEmpleado.js"></script>
<?php 
}
ob_end_flush();
?>


