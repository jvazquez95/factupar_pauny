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
if ($_SESSION['personas']==1)
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
                          <h1 class="box-title">Asientos <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Usuario</th>
                            <th>Imagen</th>
                            <th>Cargo</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>          
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Usuario</th>
                            <th>Imagen</th>
                            <th>Cargo</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Proceso:</label>
                            <input type="hidden" name="idAsiento" id="idAsiento"> 
                            <select id="Proceso_idProceso" name="Proceso_idProceso" class="form-control input-sm selectpicker" data-live-search="true" required></select>
                          </div>
                            
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Moneda:</label>
                            <select id="Moneda_idMoneda" name="Moneda_idMoneda" class="form-control input-sm selectpicker" data-live-search="true" required></select>
                          </div>
 
                          <div class="form-group col-lg-1 col-md-2 col-sm-6 col-xs-12">
                            <label>Fecha Asiento:</label>
                            <input type="date" class="form-control" name="fechaAsiento" id="fechaAsiento" maxlength="20" placeholder="Fecha Asiento" required>
                          </div> 

                          <div class="form-group col-lg-1 col-md-2 col-sm-6 col-xs-12">
                            <label>Fecha Planilla:</label>
                            <input type="date" class="form-control" name="fechaPlanilla" id="fechaPlanilla" maxlength="20" placeholder="Fecha Planilla" required>
                          </div> 

                          <div class="form-group col-lg-1 col-md-2 col-sm-6 col-xs-12">
                            <label>Transaccion Origen:</label>
                            <select id="transaccionOrigen" name="transaccionOrigen" class="form-control input-sm selectpicker"  data-live-search="true" required>  
                              <option value="Compra">Compra</option>
                              <option value="Venta">Venta</option>
                              <option value="Manual">Manual</option>
                            </select>
                          </div> 

                          <div class="form-group col-lg-1 col-md-2 col-sm-6 col-xs-12">
                            <label>Nro de Origen:</label>
                            <input type="number" class="form-control" name="nroOrigen" id="nroOrigen" maxlength="12" placeholder="Nro Origen" required>
                          </div>   

                          <div class="form-group col-lg-4 col-md-2 col-sm-6 col-xs-12">
                            <label>Comentario:</label>
                            <input type="text" class="form-control" name="comentario" id="comentario" maxlength="100" placeholder="Comentario">
                          </div>                                                       
 
                          <br>
                          <br>
                          <br>
                          <br>
                          <br>

                          <div class="row">
                            <div class="col-md-12">
                              <div class="box box-danger">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Detalle de Asiento</h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                      <div class="row">
                                        <div class="col-md-12">
                                          <div class="form-group">
                                            <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                              <label class=" input-sm">Tipo de Mov:</label>
                                              <select id="tipoMovimiento" name="tipoMovimiento" class="form-control input-sm selectpicker"  data-live-search="true" required>  
                                              <option value="1">Debito</option><option value="2">Credito</option></select>
                                            </div>
                                            <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                              <label class=" input-sm">Importe:</label>
                                              <input type="number" class="form-control input-sm " name="importe" id="importe" maxlength="15" placeholder="Importe">
                                            </div>    
                                            <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                              <label class=" input-sm">Concepto:</label>
                                              <input type="text" class="form-control input-sm " name="concepto" id="concepto" maxlength="100" placeholder="Concepto">
                                            </div>                                            
                                            <div class="form-group col-lg-0.5 col-md-1 col-sm-1 col-xs-12">
                                              <label class=" input-sm">Tasa de Cambio:</label>
                                              <input type="number" class="form-control input-sm" name="tasaCambio" id="tasaCambio" maxlength="15" placeholder="Tasa de Cambio">
                                            </div>
                                            <div class="form-group col-lg-0.5 col-md-1 col-sm-1 col-xs-12">
                                              <label class=" input-sm">Tasa Base:</label>
                                              <input type="number" class="form-control input-sm" name="tasaCambioBases" id="tasaCambioBases" maxlength="15" placeholder="Tasa Base">
                                            </div>       
                                            <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                              <label class=" input-sm">Nro de Cheque:</label>
                                              <input type="text" class="form-control input-sm " name="nroCheque" id="nroCheque" maxlength="20" placeholder="Cheque">
                                            </div>                                                                                     
                                            <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                              <label class=" input-sm">Cuenta Contable:</label>
                                              <select id="CuentaContable_idCuentaContable" name="CuentaContable_idCuentaContable" class="form-control input-sm selectpicker" data-live-search="true" required></select>
                                            </div>
                                            <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                              <label class=" input-sm">Cuenta Corriente:</label>
                                              <select id="CuentaCorriente_idCuentaCorriente" name="CuentaCorriente_idCuentaCorriente" class="form-control input-sm selectpicker" data-live-search="true"></select>
                                            </div>                                            
                                            <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                              <label class=" input-sm">Centro de Costo:</label>
                                              <select id="CentroCosto_idCentroCosto" name="CentroCosto_idCentroCosto" class="form-control input-sm selectpicker" data-live-search="true"></select>
                                            </div> 
                                            <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                              <label class=" input-sm">Banco:</label>
                                              <select id="Banco_idBanco" name="Banco_idBanco" class="form-control input-sm selectpicker" data-live-search="true"></select>
                                            </div>        
                                            <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                              <label class=" input-sm">Tipo Comprobante:</label>
                                              <input type="number" class="form-control input-sm " name="tipoComprobante" id="tipoComprobante" maxlength="12" placeholder="Tipo de Comprobante">
                                            </div> 
                                            <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                              <label class=" input-sm">Nro Comprobante:</label>
                                              <input type="text" class="form-control input-sm " name="nroComprobante" id="nroComprobante" maxlength="10" placeholder="Nro de Comprobante">
                                            </div>
                                                                                                                                                                                         
                                            <button type="button" class="btn btn-info btn-block"  onclick="addDetalleAsiento()" ><i class="fa fa-plus-circle"></i> Agregar</button>
                                            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                              <table id="detalle" class="table table"> 
                                                <thead >
                                                      <th>Opciones</th>
                                                      <th>Item</th>
                                                      <th>Cuenta Contable</th>
                                                      <th>Cuenta Corriente</th>
                                                      <th>Tipo Movimiento</th>
                                                      <th>Centro de Costo</th>
                                                      <th>importe Debito</th>
                                                      <th>importe Credito</th>
                                                      <th>Banco</th>
                                                      <th>Nro de Cheque</th>
                                                      <th>Tasa de Cambio</th>
                                                      <th>Base de Cambio</th>
                                                      <th>Concepto</th>
                                                      <th>Nro de Comprobante</th>    
                                                      <th>Tipo de Comprobante</th>                                                                                                                       
                                                  </thead>
                                                  <tfoot>
                                                      <th>Opciones</th>
                                                      <th>Item</th>
                                                      <th>Cuenta Contable</th>
                                                      <th>Cuenta Corriente</th>
                                                      <th>Tipo Movimiento</th>
                                                      <th>Centro de Costo</th>
                                                      <th><h4 id="total1">Gs. </h4><input type="hidden" name="total_ventan" id="total_ventan"></th>
                                                      <th><h4 id="total1C">Gs. </h4><input type="hidden" name="total_ventanC" id="total_ventanC"></th>
                                                      <th>Banco</th>
                                                      <th>Nro de Cheque</th>
                                                      <th>Tasa de Cambio</th>
                                                      <th>Base de Cambio</th>
                                                      <th>Concepto</th>
                                                      <th>Nro de Comprobante</th>    
                                                      <th>Tipo de Comprobante</th>     
                                                  </tfoot>
                                                  <tbody> 

                                                  </tbody>
                                              </table>
                                            </div>
                                          </div>
                                        </div>
                                        <!-- /.col -->
                                      </div>
                                      <!-- /.row -->
                                    </div>
                                  </div>
                                  <!-- /.box-default -->
                              </div>
                          <div class="row">
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
    </div><!-- /.content-wrapper -->      
  <!--Fin-Contenido-->
     <div class="container">
         <style>
        </style>
        <!-- The Modal -->
        <div class="modal " id="modal_detalle">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
              <!-- Modal body -->
              <div class="modal-body">
                  <span>Detalle de Orden de Venta:<input type="text" disabled name="detalle4" id="detalle4" /> </span>
              <table id="tbllistado4" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                  <th>Proceso</th>
                  <th>Cuenta Contable</th>
                  <th>Cuenta Corriente</th>
                  <th>Tipo de Movimiento</th>
                  <th>Importe Debito</th>
                  <th>Importe Credito</th>
                  <th>Nro de Cheque</th>
                  <th>Nro de Comprobante</th>
                  <th>Concepto</th>

                </thead>
                <tbody>                            
                </tbody>
                <tfoot>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                </tfoot>
              </table>
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
}
else
{
  require 'noacceso.php';
}
require 'footer.php';
?>
<script type="text/javascript" src="scripts/asiento.js"></script>
<?php 
}
ob_end_flush();
?>