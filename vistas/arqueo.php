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
if ($_SESSION['acceso']==1)
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
                          <h1 class="box-title">Consultar arqueo por numero de habilitacion</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          <label>Ingrese numero de habilitacion</label>
                          <input type="text" class="form-control" name="idHabilitacion" id="idHabilitacion">
                        </div>
                        <br>
                        <br>
                        <br>
                        <br>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <button class="btn btn-success" onclick="arqueoDetalle()">Consultar arqueo - Detalle</button>
                          <label> ............... 	</label>
                          <button class="btn btn-success" onclick="arqueoDetalle2()">Consultar arqueo - Actualizado</button>
                        </div>        

                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          
                        </div>                   
                        </div>
                      
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
<?php
}
else
{
  require 'noacceso.php';
}

require 'footer.php';
?>
<script type="text/javascript" src="scripts/anularVenta.js"></script>
<?php 
}
ob_end_flush();
?>


