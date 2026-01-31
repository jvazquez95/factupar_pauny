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
if ($_SESSION['ventas']>=0)
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
                          <h1 class="box-title">Venta <button class="btn btn-success"  id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                          <button class="btn btn-success"  id="btnimprimir" onclick="imprimirArqueo();"><i class="fa fa-print"></i> Imprimir Arqueo de caja</button>
                            <a href="movimiento.php"><span class="label bg-green">Ir a movimientos de caja</span></a>
                            <a href="#"><span class="label bg-green">Ir a cobros</span></a>
                        </div>
                    </div>


                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Nro. Venta</th>
                            <th>Nro. Habilitacion</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Usuario</th>
                            <th>Documento</th>
                            <th>Número</th>
                            <th>Condicion de venta</th>
                            <th>Detalle de venta</th>
                            <th>Detalle de pago</th>
                            <th>Total Venta</th>
                            <th>Saldo</th>
                            <th>Cantidad de cuotas</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Nro. Venta</th>
                            <th>Nro. Habilitacion</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Usuario</th>
                            <th>Documento</th>
                            <th>Número</th>
                            <th>Condicion de venta</th>
                            <th>Detalle de venta</th>
                            <th>Detalle de pago</th>
                            <th>Total Venta</th>
                            <th>Saldo</th>
                            <th>Cantidad de cuotas</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
            
                    
                    <div class="panel-body" style="height: auto;" id="formularioregistros">                      
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                            <label>Nro. Hab.:</label>
							              <input type="text" class="form-control" name="Habilitacion_idHabilitacion1" id="Habilitacion_idHabilitacion1" disabled>
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Fecha. Fact.:</label>
							              <input type="text" class="form-control" name="fechaFactura1" id="fechaFactura1" disabled>
                            <input type="hidden" class="form-control" name="fechaFactura" id="fechaFactura" required>
                          </div>
                        
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Depostio.:</label>
							              <input type="text" class="form-control" name="Deposito_idDeposito1" id="Deposito_idDeposito1" disabled>
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Sucursal.:</label>
							              <input type="text" class="form-control" name="sucursal" id="sucursal" disabled>
                          </div>

                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Usuario:</label>
							              <input type="text" class="form-control" name="usuario1" id="usuario1" value="<?php echo 'Usuario: ' .$_SESSION['login'].' Nombre completo: '.$_SESSION['nombre'] ?>" disabled>
                          </div>

                          <div class="form-group col-lg-3 col-md-2 col-sm-2 col-xs-12">
                            <label>Cliente(*):</label>
                            <input type="hidden" name="idVenta" id="idVenta">
                            <input type="hidden" class="form-control" name="usuario" id="usuario" value="<?php echo $_SESSION['login'] ?>">
                         	<input type="hidden" class="form-control" name="Habilitacion_idHabilitacion" id="Habilitacion_idHabilitacion">
                            <input type="hidden" class="form-control" name="Deposito_idDeposito" id="Deposito_idDeposito" value="1">
                            <input type="hidden" class="form-control" name="tasaCambioBases" id="tasaCambioBases" value="0">
                            <input type="hidden" class="form-control" name="totalImpuesto" id="totalImpuesto">
                            <input type="hidden" class="form-control" name="total" id="total">
                            <input type="hidden" class="form-control" name="subTotal" id="subTotal">
                            <input type="hidden" class="form-control" name="fechaTransaccion" id="fechaTransaccion">
                            <input type="hidden" class="form-control" name="fechaModificacion" id="fechaModificacion" value="2017-01-01">
                            <input type="hidden" class="form-control" name="usuarioInsercion" id="usuarioInsercion" value="0">
                            <input type="hidden" class="form-control" name="usuarioModificacion" id="usuarioModificacion" value="0">
                            <input type="hidden" class="form-control" name="inactivo" id="inactivo" value="0">
                            <input type="hidden" class="form-control" name="timbrado" id="timbrado" value="0">
                            <input type="hidden" class="form-control" name="vtoTimbrado" id="vtoTimbrado" value="2017-01-01">
                            <input type="hidden" class="form-control" name="Moneda_idMoneda" id="Moneda_idMoneda" value="0">
                            <input type="hidden" class="form-control" name="tasaCambio" id="tasaCambio" required="">
                            <select id="Cliente_idCliente" name="Cliente_idCliente" class="form-control selectpicker" data-live-search="true" required>
                            </select>                          
                          </div>
                          <div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-2">
                            <label></label>

                          <button type="button" onclick="modalCliente();" class="btn btn-info btn-flat">Registrar nuevo cliente</button>
                          </div>

                          <div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-12">
                            <label>Vendedor(*):</label>
                            <select name="Empleado_idEmpleado" id="Empleado_idEmpleado" class="form-control selectpicker" required="">
                               
                            </select>
                          </div>



                          <div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-12">
                            <label>Tipo Comprobante(*):</label>
                            <select name="tipo_comprobante" id="tipo_comprobante" class="form-control selectpicker" required="">
                               <option selected value="1">Factura</option>
                              <!-- <option value="2">Ticket</option> -->
                            </select>
                          </div>

                          <div class="form-group col-lg-1 col-md-1 col-sm-2 col-xs-12">
                            <label>Serie(*):</label>
                            <input type="hidden" class="form-control" name="serie" id="serie" required="">
                            <input type="text" class="form-control" name="serie1" id="serie1" disabled>
                          </div>

                          <div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-12">
                            <label>Nro. Comprobante(*):</label>
                            <input type="text" class="form-control" name="nroFactura" id="nroFactura" required="">
                          </div>

                          <div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-12">
                            <label>Termino de pago(*):</label>
                            <select name="TerminoPago_idTerminoPagoCabecera" id="TerminoPago_idTerminoPagoCabecera" class="form-control selectpicker" required="">
                               <option value="0">Contado</option>
                               <option value="2">Cuotas</option>
                            </select>
                          </div>


                          <div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-12">
                            <label>Cant. de Cuotas:</label>
                            <input type="number" class="form-control" name="cuotas" id="cuotas" value="0">
                          </div>

                          <div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-12">
                            <label>Fecha vencimiento:</label>
                            <input type="date" class="form-control" name="fechaVencimiento" id="fechaVencimiento" value="<?php echo date("Y-m-d"); ?>">
                          </div>

                          <div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-12">
                            <label>Gift Card(*):</label>
                            <select name="giftCard" id="giftCard" onchange="mostrarCampos();" class="form-control selectpicker" required="">
                               <option value="0">No</option>
                               <option value="1">Si</option>
                            </select>
                          </div>

                          <div id="mostrarCampo">
                          	<div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-12">
                            <label>Nro. Gift Card(*):</label>
                            <input type="text" class="form-control" name="nroGiftCard" id="nroGiftCard">
                          </div>


                          <div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-12">
                            <label>Para(*):</label>
                            <select id="clienteGiftCard" name="clienteGiftCard" class="form-control selectpicker" data-live-search="true">
                            </select>
                          </div>
                          </div>  
                         
                          <div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-12">
                            <a data-toggle="modal" href="#myModal">           
                              <button id="btnAgregarArt" type="button" class="btn btn-primary"> <span class="fa fa-plus"></span> Agregar Artículos</button>
                            </a>
                          </div>


                          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                              <thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio Venta</th>
                                    <th>Descuento</th>
                                    <th>Impuesto</th>
                                    <th>Total Neto</th>
                                    <th>Subtotal</th>
                                </thead>
                                <tfoot>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>TOTAL</th>
                                    <th><h4 id="total1">Gs. 0.00</h4><input type="hidden" name="total_ventan" id="total_ventan"></th>
                                    <th><h4 id="total2">Gs. 0.00</h4><input type="hidden" name="total_venta" id="total_venta"></th> 
                                </tfoot>
                                <tbody>

                                </tbody>
                            </table>
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Tipo de pago(*):</label>
                            <select onchange="habilitarBoton();" name="TerminoPago_idTerminoPagoDetalle" id="TerminoPago_idTerminoPagoDetalle" class="form-control selectpicker" required=""></select>
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Importe(*):</label>
                            <input type="number" class="form-control" name="importe_detalle" id="importe_detalle" required="">
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Nro. de referencia(*):</label>
                            <input type="text" class="form-control" name="nroCheque" id="nroCheque" required="">
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Banco:</label>
                            <select  name="Banco_idBanco" id="Banco_idBanco" class="form-control selectpicker" required=""></select>
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                              <button id="btnTipoPago" type="button" class="btn btn-primary" onclick="agregarDetallePago();"> <span class="fa fa-plus"></span> Agregar pago</button>
                          </div>


                            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                              <table id="detalles1" class="table table-striped table-bordered table-condensed table-hover">
                                <thead style="background-color:#A9D0F5">
                                      <th>Opciones</th>
                                      <th>Tipo de Pago</th>
                                      <th>Importe</th>
                                      <th>Nro. de Referencia</th>
                                  </thead>
                                  <tfoot>
                                      <th></th>
                                      <th>TOTAL</th>
                                      <th><h4 id="total_detalle"></h4><input type="hidden" name="t_detalle" id="t_detalle"></th>
                                      <th></th> 
                                  </tfoot>
                                  <tbody>
                                  </tbody>
                              </table>
                            </div>

                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                              <label>El cliente entrega:</label>
                              <input type="text" class="form-control" name="idvuelto" id="idvuelto" onkeyup="vuelto()">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                              <label>La venta total es:</label>
                              <input type="text" class="form-control" name="idtotalVenta" id="idtotalVenta" disabled>
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                              <label>El vuelto es:</label>
                              <input type="text" class="form-control" name="iddiferencia" id="iddiferencia" disabled>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                              
                              <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                            </div>

                        </form>
                    <!--Fin centro -->
                  </div><!-- /.box -->
                  </div><!-- /.box -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->

  <!-- Modal -->
  <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Seleccione un Artículo</h4>
        </div>
        <div class="modal-body">
          <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover">
            <thead>
                <th>Opciones</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Categoría</th>
                <th>Código de barras</th>
                <th>Precio Venta</th>
                <th>Imagen</th>
            </thead>
            <tbody>
              
            </tbody>
            <tfoot>
              <th>Opciones</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Código de barras</th>
                <th>Precio Venta</th>
                <th>Imagen</th>
            </tfoot>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>        
      </div>
    </div>
  </div>  
  <!-- Fin modal -->

  <!-- Modal -->
  <div class="modal " id="cliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Registrar a un nuevo cliente</h4>
        </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formularioCliente" id="formularioCliente" method="POST">
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Razon social:</label>
                            <input type="text" class="form-control" name="razonSocial" id="razonSocial" maxlength="250" placeholder="Nombre del cliente" required>
                          </div>
                          

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Tipo Documento:</label>
                            <select class="form-control select-picker" name="tipoDocumento" id="tipoDocumento" required>
                              <option value="1">RUC</option>
                              <option value="2">CEDULA</option>
                            </select>
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Número Documento:</label>
                            <input type="text" class="form-control" name="nroDocumento" id="nroDocumento" maxlength="20" placeholder="Documento">
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Celular:</label>
                            <input type="text" class="form-control" name="celular" id="celular" placeholder="Celular">
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Fecha de nacimiento:</label>
                            <input type="date" class="form-control" name="nacimiento" id="nacimiento" >
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardarCliente"><i class="fa fa-save"></i> Guardar</button>
                          </div>
                        </form>
                    </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>        
      </div>
    </div>
  </div>  
  <!-- Fin modal -->

                        <div class="container">
                           <style>
                          </style>
                          <!-- The Modal -->
                          <div class="modal" id="modal_detalle">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                              <div class="modal-content">
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <span>Detalle de venta:<input type="text" disabled name="detalle" id="detalle" /> </span>
                                <table id="tbllistado4" class="table table-striped table-bordered table-condensed table-hover">
                                  <thead>
                                    <th>Nro. venta</th>
                                    <th>Id. Articulo</th>
                                    <th>Nombre</th>
                                    <th>Descripcion</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Total</th>
                                  </thead>
                                  <tbody>                            
                                  </tbody>
                                  <tfoot>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Total</th>
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


                        <div class="container">
                           <style>
                          </style>
                          <!-- The Modal -->
                          <div class="modal " id="modal_detalle_cobro">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                              <div class="modal-content">
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <span>Detalle de venta:<input type="text" disabled name="detalle_pago" id="detalle_pago" /> </span>
                                <table id="tbllistado5" class="table table-striped table-bordered table-condensed table-hover">
                                  <thead>
                                    <th>Nro. venta</th>
                                    <th>Id. Termino Pago</th>
                                    <th>Descripcion</th>
                                    <th>Monto</th>
                                    <th>Fecha</th>
                                  </thead>
                                  <tbody>                            
                                  </tbody>
                                  <tfoot>
                                    <th>Nro. venta</th>
                                    <th>Id. Termino Pago</th>
                                    <th>Total</th>
                                    <th></th>
                                    <th>Fecha</th>

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
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="scripts/venta.js"></script>
<?php 
}
ob_end_flush();
?>


