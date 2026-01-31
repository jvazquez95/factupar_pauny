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

          <div id="cabecera">

            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Liquidacion RRHH <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Periodo</th>
                            <th>Fecha Inicio Periodo</th>
                            <th>Fecha Fin Periodo</th>
                            <th>Fecha Apertura</th>
                            <th>Tipo de Liquidacion</th>
                            <th>Moneda</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Periodo</th>
                            <th>Fecha Inicio Periodo</th>
                            <th>Fecha Fin Periodo</th>
                            <th>Fecha Apertura</th>
                            <th>Tipo de Liquidacion</th>
                            <th>Moneda</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">


                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Periodo:</label>
                            <input type="month" class="form-control" name="periodo" id="periodo" value="<?php $month = date('m')-1; $year = date('Y'); echo date('Y-m-d', mktime(0,0,0, $month, 1, $year)); ?>" required>
                          </div> 


                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Fecha Inicio:</label>
                            <input type="date" class="form-control" name="fechaInicioPeriodo" id="fechaInicioPeriodo" value="<?php $month = date('m')-1; $year = date('Y'); echo date('Y-m-d', mktime(0,0,0, $month, 1, $year)); ?>" required>
                          </div> 

                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Fecha Fin:</label>
                            <input type="date" class="form-control" name="fechaFinPeriodo" id="fechaFinPeriodo" value="<?php $month = date('m')-1; $year = date('Y'); $day = date("d", mktime(0,0,0, $month+1, 0, $year)); echo date('Y-m-d', mktime(0,0,0, $month, $day, $year)); ?>" required>
                          </div> 


                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Fecha Apertura:</label>
                            <input type="date" class="form-control" name="fechaApertura" id="fechaApertura" maxlength="20" placeholder="Periodo" required>
                          </div> 



                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Tipo de Liquidacion:</label>
                            <select class="form-control select-picker" name="TipoLiquidacion_idTipoLiquidacion" id="TipoLiquidacion_idTipoLiquidacion" >
                            </select>
                          </div>


                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Moneda:</label>
                            <select class="form-control select-picker" name="Moneda_idMoneda" id="Moneda_idMoneda" >
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


        </div>

        <div id="detalle">  
                <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Detalle Liquidacion RRHH<button class="btn btn-success" id="btnagregar" onclick="volver()"><i class="fa fa-plus-circle"></i> Volver</button> <button class="btn btn-success" id="btnagregar" onclick="generarLiquidacionDetallado()"><i class="fa fa-plus-circle"></i> Generar Liquidacion Detallado</button> <button class="btn btn-success" id="btnagregar" onclick="generarLiquidacionResumido()"><i class="fa fa-plus-circle"></i> Generar Liquidacion Resumido</button>
<button class="btn btn-success" id="btnagregar" onclick="generarLegajoLiquidacion()"><i class="fa fa-plus-circle"></i> Recibos</button>
                           </h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistadoDetalle" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Legajo</th>
                            <th>Concepto Salario</th>
                            <th>Tipo Salario</th>
                            <th>Monto</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Legajo</th>
                            <th>Concepto Salario</th>
                            <th>Tipo Salario</th>
                            <th>Monto</th>
                          </tfoot>
                        </table>
                    </div>
        </div>


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
<script type="text/javascript" src="scripts/liquidacion.js"></script>
<?php 
}
ob_end_flush();
?>


