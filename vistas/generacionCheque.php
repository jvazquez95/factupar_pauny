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
                          <h1 class="box-title">Generacion de Cheque <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Generar Nuevo</button></h1>
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


                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Banco:</label>
                            <select name="Banco_idBancoCh" id="Banco_idBancoCh" class="form-control selectpicker" onchange="filtrarCC(this)" required="">
                            </select>
                          </div>


                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Cuenta Corriente:</label>
                            <select name="CuentaCorriente_idCuentaCorriente" id="CuentaCorriente_idCuentaCorriente" class="form-control selectpicker" required="">
                            </select>
                          </div>
                    

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Tipo de cheque:</label>
                            <select name="tipoCheque" id="tipoCheque" class="form-control selectpicker" required="">
                              <option value="1">Al dia</option>
                              <option value="2">Diferido</option>
                            </select>
                          </div>

                   
                    	  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Numero inicial:</label>
                            <input type="number" class="form-control" name="inicio" id="inicio">
                          </div>
                    
                    
                    	  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Numero Final:</label>
                            <input type="number" class="form-control" name="fin" id="fin">
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
<script type="text/javascript" src="scripts/generarCheque.js"></script>
<?php 
}
ob_end_flush();
?>


