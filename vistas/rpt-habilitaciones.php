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
    <!--Contenido-->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h1 class="box-title">Lista de Habilitaciones</h1>
                </div>

                <!-- Formulario de Fechas -->
                <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <form id="form-fechas">
                        <label for="f_i">Ingrese periodo</label>
                        <input type="hidden" name="impresion" id="impresion">
                        
                        <div class="form-group">
                            <input type="date" class="form-control" name="f_i" id="f_i" 
                                value="<?php echo date('Y-m-d'); ?>">
                        </div>

                        <div class="form-group">
                            <input type="date" class="form-control" name="f_f" id="f_f" 
                                value="<?php echo date('Y-m-d'); ?>">
                        </div>

                        <div class="form-group">
                            <input type="button" class="btn btn-primary" name="actualizar" id="actualizar" onclick="listar();" value="Mostrar">
                        </div>


                        <div class="form-group">
                            <input type="button" class="btn btn-success" name="generar" id="generar" onclick="abrirArqueoFechasPDF();" value="Generar Arqueo General">
                        </div>

                    </form>
                </div>

                <!-- Tabla de Listado -->
                <div class="panel-body table-responsive" id="listadoregistros">
                    <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Nro. Hab</th>
                                <th>Caja</th>
                                <th>Cajero</th>
                                <th>Fecha Apertura</th>
                                <th>Fecha Cierre</th>
                                <th>Monto apertura</th>
                                <th>Monto cierre</th>
                                <th>Ayudante</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Datos dinámicos -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Opciones</th>
                                <th>Nro. Hab</th>
                                <th>Caja</th>
                                <th>Cajero</th>
                                <th>Fecha Apertura</th>
                                <th>Fecha Cierre</th>
                                <th>Monto apertura</th>
                                <th>Monto cierre</th>
                                <th>Ayudante</th>
                                <th>Estado</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- Fin del Centro -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->



<!-- =========================================================
     Modal: Asignar Acompañante a la Habilitación seleccionada
========================================================= -->
<div class="modal" id="modal_asignar_ayudante" tabindex="-1" role="dialog" aria-labelledby="lblAsignar" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered" role="document">
    <div class="modal-content">
      <!-- ---------- CABECERA ---------- -->
      <div class="modal-header bg-info">
        <h4 class="modal-title" id="lblAsignar">
          Asignar acompañante · Habilitación <span id="hab_num" class="text-bold"></span>
        </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- ---------- CUERPO ---------- -->
      <div class="modal-body">
        <input type="hidden" id="idHabAsignacion"><!-- se setea en JS -->

        <div class="form-group">
          <label for="ayudante">Seleccione el acompañante</label>
          <select name="ayudante" id="ayudante"
                  class="form-control selectpicker"
                  data-live-search="true" required>
            <!-- opciones cargadas por Ajax -->
          </select>
        </div>
      </div>

      <!-- ---------- PIE ---------- -->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btnProcesarAsignacion">
          Procesar&nbsp;<i class="fa fa-check"></i>
        </button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">
          Cancelar
        </button>
      </div>
    </div>
  </div>
</div>




<div class="container">
                           <style>
                          </style>
                          <!-- The Modal -->
                          <div class="modal" id="modal_detalle">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                              <div class="modal-content">
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <span>Detalle de Habilitacion:<input type="text" disabled name="detalle" id="detalle" /> </span>
                          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 table-responsive">
                                
                                <table id="tbllistado4" class="table table-striped table-bordered table-condensed table-hover">
                                  <thead>
                                    <th>Nro. Habilitacion</th>
                                    <th>Nro. Item</th>
                                    <th>Moneda</th>
                                    <th>Denominacion</th>
                                    <th>Monto Apertura</th>
                                    <th>Monto Cierre</th>
 
                                  </thead>
                                  <tbody>                            
                                  </tbody>
                                  <tfoot>
                                    <th>Nro. Habilitacion</th>
                                    <th>Nro. Item</th>
                                    <th>Moneda</th>
                                    <th>Denominacion</th>
                                    <th>Monto Apertura</th>
                                    <th>Monto Cierre</th>
 
                                  </tfoot>
                                </table>
                                </div>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>







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
<script type="text/javascript" src="scripts/rpt-habilitaciones.js"></script>
<?php 
}
ob_end_flush();
?>