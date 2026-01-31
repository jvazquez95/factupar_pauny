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
                          <h1 class="box-title">Agendar Visita <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Confirmar Visita</th>
                            <th>Cliente</th>
                            <th>Fecha - Hora Visita</th>
                            <th>Cantidad de bidones</th>
                            <th>Usuario Ins</th>
                            <th>Fecha Ins</th>
                            <th>Usuario Mod</th>
                            <th>Fecha MOd</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Confirmar Visita</th> 
                            <th>Cliente</th>
                            <th>Fecha - Hora Visita</th>
                            <th>Cantidad de bidones</th>
                            <th>Usuario Ins</th>
                            <th>Fecha Ins</th>
                            <th>Usuario Mod</th>
                            <th>Fecha MOd</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Cliente:</label>
                            <input type="hidden" name="idPersonaAgenda" id="idPersonaAgenda">
                            <input type="hidden" name="latitud" id="latitud">
                            <input type="hidden" name="longitud" id="longitud"> 
                            <select id="Persona_idPersona" name="Persona_idPersona" onchange="noCambiar()" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>  

                          <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                            <label class=" input-sm">Seleccionar Dia de Visita:</label>
                                <select id="Dia_idDia" name="Dia_idDia" class="form-control input-sm selectpicker" data-live-search="true" >
                                  <option value="1">Domingo</option>
                                  <option value="2">Lunes</option>
                                  <option value="3">Martes</option>
                                  <option value="4">Miercoles</option>
                                  <option value="5">Jueves</option>
                                  <option value="6">Viernes</option>
                                  <option value="7">Sabado</option>
                                </select>
                              </div>                          
                          
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Direccion:</label> 
                            <select id="Direccion_idDireccion" name="Direccion_idDireccion" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Sucursal:</label>   
                            <select id="Sucursal_idSucursal" name="Sucursal_idSucursal" onchange="noCambiar2()" class="form-control selectpicker" data-live-search="true" required></select>  
                          </div>
 

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
                            <label>Deposito:</label> 
                            <select id="Deposito_idDeposito" name="Deposito_idDeposito" onchange="noCambiar3()"  class="form-control selectpicker" data-live-search="true" required></select>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Camion:</label> 
                            <select id="Vehiculo_idVehiculo" name="Vehiculo_idVehiculo" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>


                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Fecha Visita:</label>
                            <input type="datetime-local" class="form-control" name="fechaVisita" id="fechaVisita" maxlength="50" placeholder="" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Cantidad de bidones:</label>
                            <input type="number" class="form-control" name="cantidad" id="cantidad" maxlength="50" placeholder="Cantidad de bidones" required>
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
<script type="text/javascript" src="scripts/personaAgenda.js"></script>
<?php 
}
ob_end_flush();
?>


