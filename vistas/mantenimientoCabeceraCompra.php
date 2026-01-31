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
                          <h1 class="box-title">Mantenimiento de compras</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          <label>Ingrese numero de compra</label>
                          <input type="text" class="form-control" onblur="mostrar(this);" name="idcompra" id="idcompra">
                        </div>

                       <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                          <label>Timbrado(*):</label>
                          <select name="timbrado" id="timbrado" onchange="cargarVencimiento(this);" class="form-control selectpicker"  data-live-search="true" required="">
                          </select>
                       </div>
                

                      <div class="form-group col-lg-2 col-md-4 col-sm-4 col-xs-12">
                          <label>Vencimiento Timbrado(*):</label>
                         <input type="date" class="form-control" name="vtoTimbrado" id="vtoTimbrado" required>
                      </div>


                      <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
                                    <label>Tipo Comprobante(*):</label>
                                        <select name="tipo_comprobante" id="tipo_comprobante" class="form-control selectpicker" required="">
                                           <option selected value="1">Factura</option>
                                           <option value="2">Ticket</option>
                                        </select>
                                      </div>

                                      <div class="form-group col-lg-2 col-md-4 col-sm-4 col-xs-12">
                                        <label>Nro. Comprobante(*):</label>
                                        <input type="text" class="form-control" name="nroFactura" id="nroFactura" required="">
                                      </div>
                                      <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                          <label>Fecha. Fact.:</label>
                                          <input type="date" class="form-control" name="fechaFactura" id="fechaFactura" value="<?php echo date("Y-m-d"); ?>" required>
                                      </div>
                  

                                      <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>Termino de pago(*):</label>
                                        <select name="TerminoPago_idTerminoPago" id="TerminoPago_idTerminoPago" class="form-control selectpicker"  data-live-search="true" required="">
                                           <option value="0">Contado</option>
                                         <!-- <option value="2">Cuotas</option> -->
                                        </select>
                                      </div>

                                      <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                        <label>Cant. de Cuotas:</label>
                                        <input type="number" class="form-control" name="cuotas" id="cuotas" value="0">
                                      </div>


                                      <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>Fecha vencimiento:</label>
                                        <input type="date" class="form-control" name="fechaVencimiento" id="fechaVencimiento" value="<?php echo date("Y-m-d"); ?>">
                                      </div>


                                      <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>Moneda(*):</label>
                                        <select name="Moneda_idMoneda"  onchange="cargarTasa(this)" id="Moneda_idMoneda" class="form-control selectpicker"  data-live-search="true" required="">
                                        </select>
                                      </div>

                                      <div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-12">
                                        <label>Tasa cambio:</label>
                                        <input type="text" class="form-control" name="tasaCambio" id="tasaCambio" required>
                                      </div>
                          

                                      <div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-12">
                                        <label>Tasa Base 2:</label>
                                        <input type="text" class="form-control" name="tasaCambioBases" id="tasaCambioBases" readonly> 
                                      </div>



                                      <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                        <label>Mercaderia o Gasto:</label>
                                        <select data-style="btn-primary" name="tipoCompra" id="tipoCompra" class="form-control selectpicker" data-live-search="true"><option value="1">Mercaderia</option><option value="2">Gasto</option></select>
                                      </div>


                                      <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                        <label>Centro de costos:</label>
                                        <select name="CentroCosto_idCentroCosto" onchange="cargarComprasPorCentroDeCosto(this);" id="CentroCosto_idCentroCosto" class="form-control selectpicker"  data-live-search="true" required="">
                                        </select>
                                      </div>


                                      <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-12">
                                        <label>Asignado a:</label>
                                        <select data-style="btn-primary" name="Compra_idCompraAsignada" id="Compra_idCompraAsignada" class="form-control selectpicker" data-live-search="true"></select>
                                      </div>






                                      <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                            <label>Imagen de Factura:</label>
                                            <input type="file" class="form-control" name="imagen" id="imagen">
                                            <input type="hidden" name="imagenactual" id="imagenactual">
                                          </div>

                                       </div>


                        <br>
                        <br>
                        <br>
                        <br>
                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          <button class="btn btn-success" onclick="mostrar()">Mostrar</button>
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
<script type="text/javascript" src="scripts/mantenimientoCompra.js"></script>
<?php 
}
ob_end_flush();
?>


