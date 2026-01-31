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
                          <h1 class="box-title">Comunicacion Personal <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
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
                            <th>Tipo de comunicacion</th>
                            <th>Fecha de comunicacion</th>
                            <th>Concepto</th>
                            <th>Imagen</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Legajo</th>
                            <th>Tipo de comunicacion</th>
                            <th>Fecha de comunicacion</th>
                            <th>Concepto</th>
                            <th>Imagen</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">


                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                             <input type="hidden" name="idComunicacionPersonal" id="idComunicacionPersonal">
                            <label>Legajo:</label>
                            <select class="form-control select-picker" name="Legajo_idLegajo" id="Legajo_idLegajo" >
                            </select>
                          </div>



                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Tipo de comunicacion:</label>
                            <select class="form-control select-picker" name="TipoComunicacion_idTipoComunicacion" id="TipoComunicacion_idTipoComunicacion" >
                            </select>
                          </div>


                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Fecha de comunicacion:</label>
                            <input type="date" class="form-control" name="fechaComunicacion" id="fechaComunicacion" value="<?php echo date("Y-m-d"); ?>" placeholder="fechaNacimiento">
                          </div>


                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Concepto:</label>
                            <input type="text" class="form-control" name="concepto" id="concepto" maxlength="20" placeholder="Concepto" required>
                          </div> 


                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Imagen:</label>
                            <input type="file" class="form-control" name="imagen" id="imagen">
                            <input type="hidden" name="imagenactual" id="imagenactual">
                            <img src="" width="150px" height="120px" id="imagenmuestra">
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
<script type="text/javascript" src="scripts/comunicacionPersonal.js"></script>
<?php 
}
ob_end_flush();
?>


