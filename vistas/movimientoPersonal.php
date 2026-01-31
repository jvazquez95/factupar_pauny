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
                          <h1 class="box-title">Movimiento Personal <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Legajo</th>
                            <th>Tipo de Movimiento</th>
                            <th>Fecha Transaccion</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Nro Comprobante</th>
                            <th>Es ingreso</th>
                            <th>Es salida</th>
                            <th>Es cambio datos</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Legajo</th>
                            <th>Tipo de Movimiento</th>
                            <th>Fecha Transaccion</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Nro Comprobante</th>
                            <th>Es ingreso</th>
                            <th>Es salida</th>
                            <th>Es cambio datos</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">


                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                             <input type="hidden" name="idMovimientoPersonal" id="idMovimientoPersonal">
                            <label>Legajo:</label>
                            <select class="form-control select-picker" name="Legajo_idLegajo" id="Legajo_idLegajo" >
                            </select>
                          </div>



                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Tipo de movimiento:</label>
                            <select class="form-control select-picker" name="TipoMovimiento_idTipoMovimiento" id="TipoMovimiento_idTipoMovimiento" >
                            </select>
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Fecha Transaccion:</label>
                            <input type="date" class="form-control" name="fechaTransaccion" id="fechaTransaccion" maxlength="50" placeholder="fechaNacimiento">
                          </div>


                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Fecha inicio:</label>
                            <input type="date" class="form-control" name="fechaInicio" id="fechaInicio" maxlength="50" placeholder="fechaNacimiento">
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Fecha fin:</label>
                            <input type="date" class="form-control" name="fechaFin" id="fechaFin" maxlength="50" placeholder="fechaNacimiento">
                          </div>



                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Nro de comprobante:</label>
                            <input type="text" class="form-control" name="nroComprobante" id="nroComprobante" maxlength="20" placeholder="Concepto" required>
                          </div> 

                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Es ingreso?</label>
                            <select class="form-control select-picker" name="esIngreso" id="esIngreso" >
                              <option value="1">Si</option>
                              <option value="0">No</option>
                            </select>
                          </div>


                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Es Salida?</label>
                            <select class="form-control select-picker" name="esSalida" id="esSalida" >
                              <option value="1">Si</option>
                              <option value="0">No</option>
                            </select>
                          </div>


                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Es cambio de datos?</label>
                            <select class="form-control select-picker" name="esCambioDato" id="esCambioDato" >
                              <option value="1">Si</option>
                              <option value="0">No</option>
                            </select>
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
<script type="text/javascript" src="scripts/movimientoPersonal.js"></script>
<?php 
}
ob_end_flush();
?>


