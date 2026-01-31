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
                          <h1 class="box-title">Cambiar Persona GiftCard</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          <label>Ingrese numero de venta</label>
                          <input type="text" class="form-control" name="idVenta" id="idVenta">
                        </div>

                        <div class="form-group col-lg-2 col-md-4 col-sm-4 col-xs-12">
                            <label>Para(*):</label>
                            <select id="clienteGiftCard" name="clienteGiftCard" class="form-control selectpicker" data-live-search="true">
                            </select>
                          </div>
                        <br>
                        <br>
                        <br>
                        <br>
                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          <button class="btn btn-success" onclick="cambiarPersonaGiftCard()">Procesar</button>
                        </div>                          
                        </div>
                          <h1 class="box-title">Cambiar numero de GiftCard</h1>
                      
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          <label>Ingrese numero de venta</label>
                          <input type="text" class="form-control" name="idVenta2" id="idVenta2">
                        </div>

                        <div class="form-group col-lg-2 col-md-4 col-sm-4 col-xs-12">
                            <label>Ingrese numero de giftcard(*):</label>
                          		<input type="text" class="form-control" name="gift" id="gift">
                            </select>
                          </div>
                        <br>
                        <br>
                        <br>
                        <br>
                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          <button class="btn btn-success" onclick="cambiarNroGiftCard()">Procesar</button>
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
<script type="text/javascript" src="scripts/cambiarPersonaGiftCard.js"></script>
<?php 
}
ob_end_flush();
?>


