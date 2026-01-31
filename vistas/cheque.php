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
                          <h1 class="box-title">Cheque <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Fecha Emision</th>
                            <th>Fecha Cobro</th>
                            <th>Banco</th>
                            <th>Moneda</th>
                            <th>Tipo Cheque</th>
                            <th>Nro Cheque</th>
                            <th>Firmante</th>
                            <th>Cliente</th>
                            <th>Monto</th>
                            <th>comentario</th>
                            <th>Fecha Confirmacion</th>
                            <th>Fecha Rechazo</th>
                            <th>Usuario Ins</th>
                            <th>Fecha Ins</th>
                            <th>Usuario Mod</th>
                            <th>Fecha Mod</th>
                            <th>Estado Cheque</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Fecha Emision</th>
                            <th>Fecha Cobro</th>
                            <th>Banco</th>
                            <th>Moneda</th>
                            <th>Tipo Cheque</th>
                            <th>Nro Cheque</th>
                            <th>Firmante</th>
                            <th>Cliente</th>
                            <th>Monto</th>
                            <th>comentario</th>
                            <th>Fecha Confirmacion</th>
                            <th>Fecha Rechazo</th>
                            <th>Usuario Ins</th>
                            <th>Fecha Ins</th>
                            <th>Usuario Mod</th>
                            <th>Fecha Mod</th>
                            <th>Estado Cheque</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Fecha Emision.:</label>
                            <input type="hidden" class="form-control" name="idCheque" id="idCheque">
                            <input type="date" class="form-control" name="fechaEmision" id="fechaEmision" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Fecha Cobro.:</label>
                            <input type="date" class="form-control" name="fechaCobro" id="fechaCobro" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Banco:</label>
                            <select id="Banco_idBanco" name="Banco_idBanco" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>


                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Moneda:</label>
                            <select id="Moneda_idMoneda" name="Moneda_idMoneda" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>


                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Tipo de Cheque:</label>
                            <select id="tipoCheque" name="tipoCheque" class="form-control selectpicker" data-live-search="true" required>
                              <option value="1">Del dia</option>
                              <option value="2">Pago Diferido</option>
                            </select>
                          </div>


                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Nro de Cheque:</label>
                            <input type="text" class="form-control" name="nroCheque" id="nroCheque" maxlength="50" placeholder="Numero de cheque" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Firmante:</label>
                            <input type="text" class="form-control" name="firmante" id="firmante" maxlength="50" placeholder="Firmante" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Cliente:</label>
                            <input type="text" class="form-control" name="cliente" id="cliente" maxlength="50" placeholder="cliente" required>
                          </div>


                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Monto:</label>
                            <input type="number" class="form-control" name="monto" id="monto" maxlength="50" placeholder="Monto" required>
                          </div>


                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Comnetario:</label>
                            <input type="text" class="form-control" name="comentario" id="comentario" maxlength="50" placeholder="Comentario" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Estado:</label>
                            <select id="estado" name="estado" class="form-control selectpicker" data-live-search="true" required>
                              <option value="1">Recibido</option>
                              <option value="2">Cobrado</option>
                              <option value="3">Rechazado</option>
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
<script type="text/javascript" src="scripts/cheque.js"></script>
<?php 
}
ob_end_flush();
?>


