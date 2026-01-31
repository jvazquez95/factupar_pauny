<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["contabilidad"]))
{
  header("Location: login.html");
}
else
{
require 'header.php';
requierePermisoVista(basename(__FILE__, '.php'));
if ($_SESSION['contabilidad']==1)
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
                          <h1 class="box-title">Proceso <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Ano</th>
                            <th>RUC Contador</th>
                            <th>Proceso Apertura</th>
                            <th>Fecha Ejecucion</th>
                            <th>Asiento Cierre</th>
                            <th>Fecha Cierre</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Ano</th>
                            <th>RUC Contador</th>
                            <th>Proceso Apertura</th>
                            <th>Fecha Ejecucion</th>
                            <th>Asiento Cierre</th>
                            <th>Fecha Cierre</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Proveedor:</label>     
                            <input type="hidden" name="idProceso" id="idProceso">               
                            <select id="Persona_idPersonaProveedor" name="Persona_idPersonaProveedor" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>
                          
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Ano:</label>
                            <input type="text" class="form-control" name="ano" id="ano" maxlength="250" placeholder="Ano">
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Directivo 1:</label>
                            <select class="form-control select-picker" name="Persona_idPersonaDirectivo1" id="Persona_idPersonaDirectivo1" required></select> 
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Cargo 1:</label>
                            <input type="text" class="form-control" name="cargo1" id="cargo1" maxlength="20" placeholder="Cargo 1">
                          </div>


                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Directivo 2:</label>
                            <select class="form-control select-picker" name="Persona_idPersonaDirectivo2" id="Persona_idPersonaDirectivo2" required></select> 
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Cargo 2:</label>
                            <input type="text" class="form-control" name="cargo2" id="cargo2" maxlength="70" placeholder="Cargo 2">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>RUC Contador:</label>
                            <input type="text" class="form-control" name="rucContador" id="rucContador" maxlength="20" placeholder="RUC Contador">
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Proceso Apertura:</label>
                            <select class="form-control select-picker" name="Proceso_idProcesoApertura" id="Proceso_idProcesoApertura" required></select> 
                          </div>   

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Fecha Ejecucion:</label>
                            <input type="date" class="form-control" name="fechaEjecucion" id="fechaEjecucion" maxlength="50" placeholder="Fecha de Ejecucion">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Asiento de Cierre:</label>
                            <select class="form-control select-picker" name="Asiento_idAsientoCierre" id="Asiento_idAsientoCierre" required></select> 
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Fecha de Cierre:</label>
                            <input type="date" class="form-control" name="fechaCierre" id="fechaCierre" maxlength="20" placeholder="Fecha de Cierre">
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
<script type="text/javascript" src="scripts/proceso.js"></script>
<?php 
}
ob_end_flush();
?>