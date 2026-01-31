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
if ($_SESSION['almacen']==1)
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
    
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Nro de Factura</th>
                            <th>Proveedor</th>
                            <th>Fecha Transaccion</th>
                            <th>Deposito</th>
                            <th>Fecha factura</th>
                            <th>Total</th>
                            <th>Estado</th> 
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Nro de Factura</th>
                            <th>Proveedor</th>
                            <th>Fecha Transaccion</th>
                            <th>Deposito</th>
                            <th>Fecha factura</th>
                            <th>Total</th>
                            <th>Estado</th> 
                          </tfoot>
                        </table>
                    </div>

                    <div class="panel-body" style="height: 500px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-1 col-md-2 col-sm-6 col-xs-12">
                            <label>ID Compra:</label>
                            <input type="hidden" name="idCompra" id="idCompra"> 
                            <input type="text" class="form-control" name="idCompra2" id="idCompra2" maxlength="50" placeholder="Compra" required>
                          </div>    
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                           <label>Proveedor:</label>
                            <select id="Persona_idPersona" name="Persona_idPersona" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>    
                         <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Deposito:</label>                   
                            <select id="Deposito_idDeposito" name="Deposito_idDeposito" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>   
                         <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Termino de pago:</label>                   
                            <select id="TerminoPago_idTerminoPago" name="TerminoPago_idTerminoPago" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>   
                          <div class="form-group col-lg-1 col-md-3 col-sm-6 col-xs-12">
                            <label>Mercaderia o Gasto:</label>
                            <select name="tipoCompra" id="tipoCompra" class="form-control selectpicker" data-live-search="true">
                              <option value="1">Mercaderia</option>
                              <option value="2">Gasto</option>
                            </select>
                          </div>                             
                         <div class="form-group col-lg-1 col-md-2 col-sm-6 col-xs-12">    
                            <label>Tipo de Comprobante:</label>                    
                            <select id="tipo_comprobante" name="tipo_comprobante" class="form-control selectpicker" data-live-search="true" required>
                               <option value="1" selected>Factura</option>
                               <option value="2">Ticket</option>
                             </select>
                          </div>                                                                                                                       	
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Nro de Factura:</label>
                            <input type="text" class="form-control" name="nroFactura" id="nroFactura" maxlength="50" placeholder="Factura" required>
                          </div>  
                          <div class="form-group col-lg-1 col-md-2 col-sm-6 col-xs-12">    
                            <label>Fecha de Factura:</label>                    
                            <input type="date" class="form-control" name="fechaFactura" id="fechaFactura" maxlength="50" placeholder="Fecha" >     
                          </div> 
                          <div class="form-group col-lg-1 col-md-2 col-sm-6 col-xs-12">      
                            <label>Fecha de Vencimiento:</label>                    
                            <input type="datetime" class="form-control" name="fechaVencimiento" id="fechaVencimiento" maxlength="50" placeholder="Fecha Venc" >     
                          </div>      
                          <div class="form-group col-lg-1 col-md-2 col-sm-6 col-xs-12">    
                            <label>Timbrado:</label>                    
                            <input type="text" class="form-control" name="timbrado" id="timbrado" maxlength="50" placeholder="timbrado" >     
                          </div>     
                          <div class="form-group col-lg-1 col-md-2 col-sm-6 col-xs-12">    
                            <label>Vto de Timbrado:</label>                    
                            <input type="date" class="form-control" name="vtoTimbrado" id="vtoTimbrado" maxlength="50" placeholder="Venc de Timbrado" >     
                          </div>                                                              
                         <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Centro de Costo:</label>                   
                            <select id="CentroCosto_idCentroCosto" name="CentroCosto_idCentroCosto" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>                              
                         <div class="form-group col-lg-1 col-md-2 col-sm-6 col-xs-12">
                            <label>Moneda:</label>                   
                            <select id="Moneda_idMoneda" name="Moneda_idMoneda" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>                           
                          <div class="form-group col-lg-1 col-md-2 col-sm-6 col-xs-12">    
                            <label>Tasa de Cambio:</label>                    
                            <input type="number" class="form-control" name="tasaCambio" id="tasaCambio" maxlength="50" placeholder="tasa" >     
                          </div>
                          <div class="form-group col-lg-1 col-md-2 col-sm-6 col-xs-12">    
                            <label>Tasa de Base:</label>                    
                            <input type="number" class="form-control" name="tasaCambioBases" id="tasaCambioBases" maxlength="50" placeholder="tasa base" >     
                          </div>
                          <div class="form-group col-lg-1 col-md-2 col-sm-6 col-xs-12">    
                            <label>Total Impuesto:</label>                    
                            <input type="number" class="form-control" name="totalImpuesto" id="totalImpuesto" maxlength="50" placeholder="tasa base" >     
                          </div>    
                          <div class="form-group col-lg-1 col-md-2 col-sm-6 col-xs-12">    
                            <label>Total:</label>                    
                            <input type="number" class="form-control" name="total" id="total" maxlength="50" placeholder="total" >     
                          </div> 
                          <div class="form-group col-lg-1 col-md-2 col-sm-6 col-xs-12">    
                            <label>Total Neto:</label>                    
                            <input type="number" class="form-control" name="totalNeto" id="totalNeto" maxlength="50" placeholder="total neto" >     
                          </div>   
                          <div class="form-group col-lg-1 col-md-2 col-sm-6 col-xs-12">    
                            <label>Saldo:</label>                    
                            <input type="number" class="form-control" name="saldo" id="saldo" maxlength="50" placeholder="saldo" >     
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
<script type="text/javascript" src="scripts/cabeceraCompra.js"></script>
<?php 
}
ob_end_flush();
?>


