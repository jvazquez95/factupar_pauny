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
if ($_SESSION['ordenes']==1)
{
?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->

        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Orden de consumision</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <div class="form-inline col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Empleado</label>
                          <select name="idEmpleado" id="idEmpleado" class="form-control selectpicker" data-live-search="true" required>                         	
                          </select>     
                        <br>               
                        <br>               
                        <button class="btn btn-success" onclick="listar()">Mostrar</button>
                        <br>               
                        <br>               
                        </div>
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>ID</th>
                            <th>Nombre Cliente</th>
                            <th>Nombre empleado</th>
                            <th>Fecha Inicial</th>
                            <th>Fecha Final</th>
                            <th>Paquete</th>
                            <th>Servicio</th>
                            <th>Comision</th>
                            <th>COD. CATEGORIA</th>
                            <th>COD SERVICIO</th>
                            <th>Cantidad Asignada</th>
                            <th>Cantidad Restante</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>ID</th>
                            <th>Nombre Cliente</th>
                            <th>Nombre empleado</th>
                            <th>Fecha Inicial</th>
                            <th>Fecha Final</th>
                            <th>Paquete</th>
                            <th>Servicio</th>
                            <th>Comision</th>
                            <th>Comision</th>
                            <th>Comision</th>
                            <th>Cantidad Asignada</th>
                            <th>Cantidad Restante</th>
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
}
else
{
  require 'noacceso.php';
}

require 'footer.php';
?>
<script type="text/javascript" src="scripts/consumirOrden.js"></script>
<?php 
}
ob_end_flush();
?>


