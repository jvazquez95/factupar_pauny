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
                          <h1 class="box-title">Salario <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
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
                            <th>Tipo de Salario</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Monto</th>
                            <th>Moneda</th>
                            <th>Autorizado</th>
                            <th>Autorizado por</th>
                            <th>Usuario Ins</th>
                            <th>Fecha Ins</th>
                            <th>Usuario Modificacion</th>
                            <th>Fecha Modificacion</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Legajo</th>
                            <th>Tipo de Salario</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Monto</th>
                            <th>Moneda</th>
                            <th>Autorizado</th>
                            <th>Autorizado por</th>
                            <th>Usuario Ins</th>
                            <th>Fecha Ins</th>
                            <th>Usuario Modificacion</th>
                            <th>Fecha Modificacion</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">

                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                             <input type="hidden" name="idSalario" id="idSalario">
                            <label>Legajo:</label>
                            <select class="form-control select-picker" name="Legajo_idLegajo" id="Legajo_idLegajo" >
                            </select>
                          </div>



                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Tipo de salario:</label>
                            <select class="form-control select-picker" name="TipoSalario_idTipoSalario" id="TipoSalario_idTipoSalario" >
                            </select>
                          </div>



                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Fecha inicio:</label>
                            <input type="date" class="form-control" name="fechaInicio" id="fechaInicio" value="<?php echo date("Y-m-d"); ?>" placeholder="fechaNacimiento">
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Fecha fin:</label>
                            <input type="date" class="form-control" name="fechaFin" id="fechaFin" value="<?php echo date("Y-m-d"); ?>" placeholder="fechaNacimiento">
                          </div>



                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Monto:</label>
                            <input type="number" class="form-control" name="monto" id="monto" maxlength="20" value="0" placeholder="monto" required>
                          </div> 

                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Moneda:</label>
                            <select class="form-control select-picker" name="Moneda_idMoneda" id="Moneda_idMoneda" >
                            </select>
                          </div>


                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Autorizado:</label>
                            <input type="text" class="form-control" name="autorizado" id="autorizado" maxlength="20" placeholder="" required>
                          </div> 

                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Autorizado por:</label>
                            <input type="text" class="form-control" name="autorizadoPorUsuario" id="autorizadoPorUsuario" maxlength="20" placeholder="" required>
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
<script type="text/javascript" src="scripts/salario.js"></script>
<?php 
}
ob_end_flush();
?>


