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
//if ($_SESSION['almacen']==1)
//{
?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
	   <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
     
                    <div class="box-header with-border">
                          <h1 class="box-title">Lista de Pagos</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label>Ingrese periodo principal</label>
                                <input type="hidden" name="impresion" id="impresion"><br>
                                <input type="date" class="form-control" name="f_i" id="f_i" value="<?php $month = date('m')-1; $year = date('Y'); echo date('Y-m-d', mktime(0,0,0, $month, 1, $year)); ?>"><br>
                                <input type="date" class="form-control" name="f_f" id="f_f" value="<?php $month = date('m')-1; $year = date('Y'); $day = date("d", mktime(0,0,0, $month+1, 0, $year)); echo date('Y-m-d', mktime(0,0,0, $month, $day, $year)); ?>"><br>
                
                    <input type="button" class="btn btn-primary" name="actualizar" id="actualizar" onclick="listar();" value="Mostrar">
              </div>
                    <!-- Esta porcin de codigo nos ayuda para evitar el salto de linea por campo en el datatable -->
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                                                                    <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                              <th>Id</th>
                              <th>Cliente</th>
                              <th>RUC o Documento</th>
                              <th>Nro de Habilitacion</th>
                              <th>Fecha de Transaccion</th>
                              <th>Total</th>
                              <th>Usuario</th>
                          </thead>
                            <tbody>       
                            </tbody>
                            <tfoot>
							  <th>Id</th>
                              <th>Cliente</th>
                              <th>RUC o Documento</th>
                              <th>Nro de Habilitacion</th>
                              <th>Fecha de Transaccion</th>
                              <th>Total</th>
                              <th>Usuario</th>                        
							</tfoot>
                          </table>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->
  <!--Fin-Contenido-->
<?php
//}
//else
//{
  //require 'noacceso.php';
//}
require 'footer.php';
?>
<script type="text/javascript" src="../public/js/JsBarcode.all.min.js"></script>
<script type="text/javascript" src="../public/js/jquery.PrintArea.js"></script>
<script type="text/javascript" src="scripts/rpt-pagos.js"></script>
<?php 
}
ob_end_flush();
?>