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
if ($_SESSION['consultac']==1)
{
?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div>        
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Libro ventas por fecha</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                          <label>Fecha Inicial</label>
                          <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                          <label>Fecha Final</label>

                          <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" value="<?php echo date("Y-m-d"); ?>">

                         </div>
                         <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                          <label>Perido</label>

                          <input type="number" class="form-control" name="proceso" id="proceso" value="10">

                        </div>
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>A</th>
                            <th>AA</th>
                            <th>RUC</th>
                            <th>Razon Social</th>
                            <th>Tipo</th>
                            <th>Fecha</th>
                            <th>Timbrado</th>
                            <th>Nro Comprobante</th>                   
                            <th>Gravada 10</th>
                            <th>Gravada 5</th>
                            <th>Exento</th>
                            <th>Total</th>   
                            <th>Cond</th> 
                            <th>Ext</th>                          
                            <th>Imputa al IVA</th>
                            <th>Imputa al IRE</th>
                            <th>Imputa al IRP</th>
                            <th>No Imputa</th> 
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>A</th>
                            <th>AA</th>
                            <th>RUC</th>
                            <th>Razon Social</th>
                            <th>Tipo</th>
                            <th>Fecha</th>
                            <th>Timbrado</th>
                            <th>Nro Comprobante</th>                   
                            <th>Gravada 10</th>
                            <th>Gravada 5</th>
                            <th>Exento</th>
                            <th>Total</th>   
                            <th>Cond</th> 
                            <th>Ext</th>                          
                            <th>Imputa al IVA</th>
                            <th>Imputa al IRE</th>
                            <th>Imputa al IRP</th>
                            <th>No Imputa</th>                         
                          </tfoot>
                        </table>
                    </div>
                    
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

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
<script type="text/javascript" src="scripts/rpt_libro_ventas_avanzado1.js"></script>
<?php 
}
ob_end_flush();
?>


