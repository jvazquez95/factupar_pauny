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
                          <h1 class="box-title">Documentos por Cajero <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>ID</th>
                            <th>Tipo de documento</th>
                            <th>Cajero</th>
                            <th>Numero inicial</th>
                            <th>Numero final</th>
                            <th>Numero actual</th>
                            <th>Fecha de entrega</th>
                            <th>Serie</th>
                            <th>Timbrado</th>
                            <th>Nro de autorizacion</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>ID</th>
                            <th>Tipo de documento</th>
                            <th>Cajero</th>
                            <th>Numero inicial</th>
                            <th>Numero final</th>
                            <th>Numero actual</th>
                            <th>Fecha de entrega</th>
                            <th>Serie</th>
                            <th>Timbrado</th>
                            <th>Nro de autorizacion</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Tipo de Documento:</label>
                            <input type="hidden" name="idDocumentoCajero" id="idDocumentoCajero">
                             <select class="form-control select-picker" name="Documento_idTipoDocumento" id="Documento_idTipoDocumento" data-live-search="true" required>
                            </select>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Cajero:</label>
                             <select class="form-control select-picker" name="Usuario_idUsuario" id="Usuario_idUsuario" data-live-search="true" required>
                            </select>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Numero inicial:</label>
                            <input type="text" class="form-control" name="numeroInicial" id="numeroInicial" maxlength="256" placeholder="">
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Numero final:</label>
                            <input type="text" class="form-control" name="numeroFinal" id="numeroFinal" maxlength="256" placeholder="">
                          </div>


                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Numero actual:</label>
                            <input type="text" class="form-control" name="numeroActual" id="numeroActual" maxlength="256" placeholder="">
                          </div>


                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Fecha de entrega:</label>
                            <input type="date" class="form-control" name="fechaEntrega" id="fechaEntrega" maxlength="256" placeholder="">
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Serie:</label>
                            <input type="text" class="form-control" name="serie" id="serie" maxlength="256" placeholder="">
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Timbrado:</label>
                            <input type="text" class="form-control" name="timbrado" id="timbrado" maxlength="256" placeholder="">
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Nro. de Autorizacion:</label>
                            <input type="text" class="form-control" name="nroAutorizacion" id="nroAutorizacion" maxlength="256" placeholder="">
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
<script type="text/javascript" src="scripts/documentoCajero.js"></script>
<?php 
}
ob_end_flush();
?>


