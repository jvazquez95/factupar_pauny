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
                          <h1 class="box-title">Parientes <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
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
                            <th>Apellido y Nombre</th>
                            <th>Nacimiento</th>
                            <th>Sexo</th>
                            <th>Parentezco</th>
                            <th>Observaciones</th>
                            <th>Estado civil</th>
                            <th>Dependiente</th>
                            <th>Profesion</th>
                            <th>Actividad</th>
                            <th>Pais</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Legajo</th>
                            <th>Apellido y Nombre</th>
                            <th>Nacimiento</th>
                            <th>Sexo</th>
                            <th>Parentezco</th>
                            <th>Observaciones</th>
                            <th>Estado civil</th>
                            <th>Dependiente</th>
                            <th>Profesion</th>
                            <th>Actividad</th>
                            <th>Pais</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">


                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                             <input type="hidden" name="idPariente" id="idPariente">
                            <label>Legajo:</label>
                            <select class="form-control select-picker" name="Legajo_idLegajo" id="Legajo_idLegajo" >
                            </select>
                          </div>


                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Nombre:</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" maxlength="20" placeholder="Concepto" required>
                          </div> 

                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Apellido:</label>
                            <input type="text" class="form-control" name="apellido" id="apellido" maxlength="20" placeholder="Concepto" required>
                          </div> 


                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Fecha de Nacimiento:</label>
                            <input type="date" class="form-control" name="nacimiento" id="nacimiento" maxlength="20" placeholder="Concepto" required>
                          </div> 

                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Genero:</label>
                            <select class="form-control select-picker" name="sexo" id="sexo" >
                              <option value="1">Masculino</option>
                              <option value="2">Femenino</option>
                            </select>
                          </div> 


                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Parentezco:</label>
                            <select class="form-control select-picker" name="parentezco" id="parentezco">
                              <option value="1">Padre</option>
                              <option value="2">Madre</option>
                              <option value="3">Conyuge</option>
                              <option value="4">Hijo</option>
                              <option value="5">Otro</option>
                            </select>
                          </div>


                         <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Observaciones:</label>
                            <input type="text" class="form-control" name="observaciones" id="observaciones" maxlength="200" placeholder="Concepto" required>
                          </div> 


                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Estado civil:</label>
                            <select class="form-control select-picker" name="EstadoCivil_idEstadoCivil" id="EstadoCivil_idEstadoCivil" >
                            </select>
                          </div>


                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Dependiente:</label>
                            <select class="form-control select-picker" name="dependiente" id="dependiente" >
                              <option value="0">No</option>
                              <option value="1">Si</option>
                            </select>
                          </div>


                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Profesion:</label>
                            <select class="form-control select-picker" name="Profesion_idProfesion" id="Profesion_idProfesion" >
                            </select>
                          </div>


<!--                           <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Actividad:</label>
                            <select class="form-control select-picker" name="Actividad_idActividad" id="Actividad_idActividad" >
                            </select>
                          </div> -->


                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Pais:</label>
                            <select class="form-control select-picker" name="Pais_idPais" id="Pais_idPais" >
                            </select>
                          </div>
<!-- 
                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Concepto:</label>
                            <input type="text" class="form-control" name="concepto" id="concepto" maxlength="20" placeholder="Concepto" required>
                          </div>  -->
<!-- 
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Imagen:</label>
                            <input type="file" class="form-control" name="imagen" id="imagen">
                            <input type="hidden" name="imagenactual" id="imagenactual">
                            <img src="" width="150px" height="120px" id="imagenmuestra">
                          </div> -->
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
<script type="text/javascript" src="scripts/pariente.js"></script>
<?php 
}
ob_end_flush();
?>


