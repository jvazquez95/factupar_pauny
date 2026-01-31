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
                        <h1 class="box-title">Balance</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div> 
                    <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                      <label>Ingresar Rango de Fecha</label>
                      <input type="hidden" name="impresion" id="impresion"><br>
                      <input type="date" class="form-control" name="f_i" id="f_i" value="<?php $month = date('m')-1; $year = date('Y'); echo date('Y-m-d', mktime(0,0,0, $month, 1, $year)); ?>"><br>
                      <input type="date" class="form-control" name="f_f" id="f_f" value="<?php $month = date('m')-1; $year = date('Y'); $day = date("d", mktime(0,0,0, $month+1, 0, $year)); echo date('Y-m-d', mktime(0,0,0, $month, $day, $year)); ?>"><br>
                      <input type="button" class="btn btn-primary" name="actualizar" id="actualizar" onclick="listar();" value="Generar Balance provisorio"> 
					            <input type="button" style="margin-left: 5px" class="btn btn-primary" name="generar" id="generar" onclick="generar();" value="Generar Balance Analitico">
                    </div>

                    <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                      <label>Rango de Cuenta Contable:</label>                   
                      <select id="c_i" name="c_i" class="form-control selectpicker" data-live-search="true" required>   
                      </select><br>
                      <select id="c_f" name="c_f" class="form-control selectpicker" data-live-search="true" required></select><br>
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
                              <th>Cuenta Contable</th>
                              <th>Nro Cuenta Contable</th>
                              <th>Rubro</th>
                              <th>Saldo Anterior</th>
                              <th>Saldo Actual</th>
                              <th>Debito Acumulado</th>
                              <th>Credito Acumulado</th>
                              <th>Debito</th>
                              <th>Credito</th>
                          </thead>
                          <tbody>       
                          </tbody>
                          <tfoot>
                              <th>Cuenta Contable</th>
                              <th>Nro Cuenta Contable</th>
                              <th>Rubro</th>
                              <th>Saldo Anterior</th>
                              <th>Saldo Actual</th>
                              <th>Debito Acumulado</th>
                              <th>Credito Acumulado</th>
                              <th>Debito</th>
                              <th>Credito</th>
                          </tfoot>
                      </table>
                    </div>
                    <!--Fin centro -->
                    <div class="container">
                           <div class="modal fade" id="modal">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                              <div class="modal-content">
                                <!-- Modal body -->
                                <div class="modal-body">
						  					       <div class="panel-body table-responsive" id="listadoregistros">
						                        <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
						                          <label>Ingrese periodo principal</label>
						                          <input type="date" class="form-control" name="f_i" id="f_i" value="<?php $month = date('m')-6; $year = date('Y'); echo date('Y-m-d', mktime(0,0,0, $month, 1, $year)); ?>"><br>
						          				  <input type="date" class="form-control" name="f_f" id="f_f" value="<?php $month = date('m')-1; $year = date('Y'); $day = date("d", mktime(0,0,0, $month+1, 0, $year)); echo date('Y-m-d', mktime(0,0,0, $month, $day, $year)); ?>">
						                        </div>

						                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
						                          <input type="button" class="btn btn-primary" name="generar" id="generar" onclick="listar();" value="Generar">
						                   		</div>
                                </div>
                                <div align="center" id="espere"></div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        </div>
						
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
<script type="text/javascript" src="scripts/balance.js"></script>
<?php 
}
ob_end_flush();
?>