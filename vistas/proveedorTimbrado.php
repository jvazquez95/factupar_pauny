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
if ($_SESSION['compras']==1)
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
                          <h1 class="box-title">Proveedor Timbrado <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Proveedor</th>
                            <th>Timbrado</th>
                            <th>Vencimiento Timbrado</th>
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
                            <th>Proveedor</th>
                            <th>Timbrado</th>
                            <th>Vencimiento Timbrado</th>
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
                            <label>Proveedor:</label>
                            <select id="Persona_idPersona" name="Persona_idPersona" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>


                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Timbrado:</label>
                            <input type="hidden" name="idProveedorTimbrado" id="idProveedorTimbrado">
                            <input type="number" class="form-control" name="timbrado" id="timbrado" maxlength="50" placeholder="Timbrado" required>
                          </div>



                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Vto. Timbrado:</label>
                            <input type="date" class="form-control" name="vtoTimbrado" id="vtoTimbrado" maxlength="50" placeholder="Vencimiento Timbrado" required>
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
<script type="text/javascript" src="scripts/proveedorTimbrado.js"></script>
<?php 
}
ob_end_flush();
?>


