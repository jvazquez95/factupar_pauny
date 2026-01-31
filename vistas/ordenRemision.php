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
if ($_SESSION['ventas']==1)
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
                          <h1 class="box-title">Remisiones. </h1>
                        <div class="box-tools pull-right">
                          <button class="btn btn-success"  id="btnimprimir" onclick="imprimirArqueo();"><i class="fa fa-print"></i> Imprimir Arqueo de caja</button>
                            <a href="movimiento.php"><span class="label bg-green">Ir a movimientos de caja</span></a>
                            <a href="#"><span class="label bg-green">Ir a cobros</span></a>
                        </div>
                    </div>
 
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">

                    <p class="text-monospace">Pendientes de Remision<button class="btn btn-success"  id="btnimprimir" onclick="generarFactura();"><i class="fa fa-print"></i> Nueva Remision</button></p>

                    <div class="panel-body table-responsive">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Orden #</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Habilitacion</th>
                            <th>Deposito</th>
                            <th>Termino de Pago</th>
                            <th>Forma de Entrega</th>
                            <th>Fecha de Entrega</th>
                            <th>Total</th>
                            <th>Usuario Ins</th>
                            <th>Usuario Mod</th>
                            <th>Detalles</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Orden #</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Habilitacion</th>
                            <th>Deposito</th>
                            <th>Termino de Pago</th>
                            <th>Forma de Entrega</th>
                            <th>Fecha de Entrega</th>
                            <th>Total</th>
                            <th>Usuario Ins</th>
                            <th>Usuario Mod</th>
                            <th>Detalles</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                </div>
                    <div class="panel-body table-responsive" id="listadoregistrosfacturados">
                    <p class="text-monospace">Remitidos</p>

                        <table id="tbllistadoFacturados" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Orden #</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Habilitacion</th>
                            <th>Deposito</th>
                            <th>Termino de Pago</th>
                            <th>Forma de Entrega</th>
                            <th>Fecha de Entrega</th>
                            <th>Total</th>
                            <th>Usuario Ins</th>
                            <th>Usuario Mod</th>
                            <th>Detalles</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Orden #</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Habilitacion</th>
                            <th>Deposito</th>
                            <th>Termino de Pago</th>
                            <th>Forma de Entrega</th>
                            <th>Fecha de Entrega</th>
                            <th>Total</th>
                            <th>Usuario Ins</th>
                            <th>Usuario Mod</th>
                            <th>Detalles</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>



                        <div class="panel-body" style="height: 400px;" id="formularioregistros">                      
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                            <label>Nro. Hab.:</label>
                            <input type="text" class="form-control" name="Habilitacion_idHabilitacion1" id="Habilitacion_idHabilitacion1" disabled>
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Fecha:</label>
                            <input type="text" class="form-control" name="fechaFactura1" id="fechaFactura1" disabled>
                            <input type="hidden" class="form-control" name="fechaFactura" id="fechaFactura" required>
                          </div>
                        
                          <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
                            <label>Vendedor(*):</label>
                            <input type="text" class="form-control" name="Empleado_idEmpleado1" id="Empleado_idEmpleado1" readonly>  
                            </select>
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Sucursal.:</label>
                            <input type="text" class="form-control" name="sucursal" id="sucursal" disabled>
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Usuario:</label>
                            <input type="text" class="form-control" name="usuario1" id="usuario1" value="<?php echo 'Usuario: ' .$_SESSION['login'].' Nombre completo: '.$_SESSION['nombre'] ?>" disabled>
                          </div>

                          <div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-12">
                            <label>Gentileza:</label>
                            <select name="regalia" id="regalia"  class="form-control selectpicker" required="">
                               <!-- <option selected value="1">Factura</option> -->
                               <option selected value="S">Si</option>
                               <option selected value="N">No</option>
                              <!-- <option value="2">Ticket</option> -->
                            </select>
                          </div>

                          <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                            
                            <label>Registrar nuevo cliente(*):</label>
                            <button type="button" onclick="modalCliente();" class="btn btn-primary btn-xs btn-block"> + Registrar nuevo cliente</button>
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Cliente(*): </label>
                            <input type="hidden" name="idVenta" id="idVenta">
                            <input type="hidden" name="OrdenVenta_idOrdenVenta" id="OrdenVenta_idOrdenVenta">
                            <input type="hidden" class="form-control" name="usuario" id="usuario" value="<?php echo $_SESSION['login'] ?>">
                            <input type="hidden" class="form-control" name="Empleado_idEmpleado" id="Empleado_idEmpleado">
                          <input type="hidden" class="form-control" name="Habilitacion_idHabilitacion" id="Habilitacion_idHabilitacion">
                            <input type="hidden" class="form-control" name="totalImpuesto" id="totalImpuesto">
                            <input type="hidden" class="form-control" name="total" id="total">
                            <input type="hidden" class="form-control" name="subTotal" id="subTotal">
                            <input type="hidden" class="form-control" name="cantmaxremision" id="cantmaxremision">
                            <input type="hidden" class="form-control" name="fechaTransaccion" id="fechaTransaccion">
                            <input type="hidden" class="form-control" name="fechaModificacion" id="fechaModificacion" value="2017-01-01">
                            <input type="hidden" class="form-control" name="usuarioInsercion" id="usuarioInsercion" value="0">
                            <input type="hidden" class="form-control" name="usuarioModificacion" id="usuarioModificacion" value="0">
                            <input type="hidden" class="form-control" name="inactivo" id="inactivo" value="0">
                            <input type="hidden" class="form-control" name="timbrado" id="timbrado" value="0">
                            <input type="hidden" class="form-control" name="vtoTimbrado" id="vtoTimbrado" value="2017-01-01">
                            <input type="hidden" class="form-control" name="cuotas" id="cuotas" value="0">

                           <!-- <select id="Cliente_idCliente" name="Cliente_idCliente" onchange="noCambiar(this)" class="form-control selectpicker" data-live-search="true" required></select>   --> 
                            <select  title="Selecciona Persona" onchange="noCambiar(this);" class="selectpicker selector_persona form-control person" data-style="btn-warning" name="Cliente_idCliente" id="Cliente_idCliente"  data-live-search="true"></select>

                          </div>


                          <div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-12">
                            <label>Deposito(*):</label>
                            <select name="Deposito_idDeposito" id="Deposito_idDeposito" class="form-control selectpicker" required="">
                            </select>
                          </div>

                          <div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-12">
                            <label>Tipo Comprobante(*):</label>
                            <select name="tipo_comprobante" id="tipo_comprobante"  class="form-control selectpicker" required="">
                               <!-- <option selected value="1">Factura</option> -->
                               <option selected value="3">Nota de Remision</option>
                              <!-- <option value="2">Ticket</option> -->
                            </select>
                          </div>

                          <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                            <label>Serie(*):</label>
                            <input type="hidden" class="form-control" name="serie" id="serie" required="">
                            <input type="text" class="form-control" name="serie1" id="serie1" disabled>
                          </div>

                          <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                            <label>Nro. Comprobante(*):</label>
                            <input type="text" class="form-control" name="nroFactura" id="nroFactura" required="" readonly>
                          </div>

                          <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                            <label>Termino de pago(*):</label>
                            <select name="TerminoPago_idTerminoPago" id="TerminoPago_idTerminoPago" onchange="detallePago(this);" class="form-control selectpicker" required=""></select>
                          </div>

<!--
                          <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                            <label>Cant. de Cuotas:</label>
                            <input type="number" class="form-control" name="cuotas" id="cuotas" value="0">
                          </div>
-->
                          <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                            <label>Fecha vencimiento:</label>
                            <input type="date" class="form-control" name="fechaVencimiento" id="fechaVencimiento" value="<?php echo date("Y-m-d"); ?>">
                          </div>


                          <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                            <label>Entrega:</label>
                            <input type="number" class="form-control" name="entrega" id="entrega" value="0">
                          </div>


                          <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                            <label>Moneda(*):</label>
                            <select name="Moneda_idMoneda" id="Moneda_idMoneda" onchange="cargarTasa(this)" class="form-control selectpicker"  data-live-search="true" required>
                            </select>
                          </div>

                          <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                            <label>Tasa cambio:</label>
                            <input type="text" class="form-control" name="tasaCambio" id="tasaCambio" required>

                            <input type="hidden" class="form-control" name="tasaCambioBases2" id="tasaCambioBases2" value="1">

                          </div>
              
                          <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                            <label>Tasa Base 2:</label>
                            <input type="text" class="form-control" name="tasaCambioBases" id="tasaCambioBases" readonly>
                          </div>



                          <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label>Buscar articulo:</label>
            					<select   title="Selecciona Articulo" class="selectpicker selector_articulo form-control arti" name="buscar_articulo" id="buscar_articulo"  data-live-search="true"></select>
                          </div>
                         

                          <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <a data-toggle="modal" href="#myModal">
                            <label>Agregar Articulo:</label>        
                              <button id="btnAgregarArt" type="button" class="btn btn-primary btn-block btn-xs"> <span class="fa fa-plus"></span> Agregar Artículos</button>
                            </a>
                          </div>


                          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 table-responsive">
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
                                    <th><h4 id="total1"> 0.00</h4><input type="hidden" name="total_ventan" id="total_ventan"></th>
                                    <th><h4 id="total2"> 0.00</h4><input type="hidden" name="total_venta" id="total_venta"></th> 
                                </tfoot>
                                <tbody>

                                </tbody>
                            </table>
                          </div>


                      <div id="pagoDetalle">

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <!--      <label>Forma de pago(*):</label> -->
                           <!--   <select onchange="habilitarBoton();" name="FormaPago_idFormaPago" id="FormaPago_idFormaPago" class="form-control selectpicker" type="hidden" required=""></select> -->
                          </div> 

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <!-- <label>Importe(*):</label>  -->
                            <input type="hidden" class="form-control" name="importe_detalle" id="importe_detalle">
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                             <!--  <label>Nro. de referencia(*):</label>  -->
                            <input type="hidden" class="form-control" name="nroCheque" id="nroCheque" required="">
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                              <!-- <label>Banco:</label>  -->
                          <!--   <select  name="Banco_idBanco" type="hidden" id="Banco_idBanco" class="form-control selectpicker" required=""></select> -->
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                              <button id="btnTipoPago"   type="hidden" class="btn btn-primary" onclick="agregarDetallePago();"> <span class="fa fa-plus"></span> Agregar pago</button>
                          </div>


                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 table-responsive">
                            <!-- <table id="detalles1" class="table table-striped table-bordered table-condensed table-hover">
                              <thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Tipo de Pago</th>
                                    <th>Importe</th>
                                    <th>Nro. de Referencia</th>
                                    <th>Banco</th>
                                </thead>
                                <tfoot>
                                    <th></th>
                                    <th>TOTAL</th>
                                    <th><h4 id="total_detalle"></h4><input type="hidden" name="t_detalle" id="t_detalle"></th>
                                    <th></th> 
                                    <th></th> 
                                </tfoot>
                                <tbody>
                                </tbody>
                            </table> -->
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <!--<label>El cliente entrega:</label>-->
                            <input type="hidden" class="form-control" name="idvuelto" id="idvuelto" onkeyup="vuelto()">
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <!--<label>La venta total es:</label>--> 
                            <input type="hidden" class="form-control" name="idtotalVenta" id="idtotalVenta" disabled>
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <!--<label>El vuelto es:</label>-->
                            <input type="hidden" class="form-control" name="iddiferencia" id="iddiferencia" disabled>
                          </div>

                </div><!-- Fin div del detalle -->
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                            
                            <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->

  <!-- Modal -->
  <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-xl" style="width: 65% !important;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
          <h4 class="modal-title">Buscar Artículo</h4>
        <div class="modal-body">
                <div class="form-group col-lg-3 col-md-3 col-sm-4 col-xs-12">
                        <label>Buscar articulo:</label>
                        <input type="text" onblur="listarArticulos();" class="form-control" name="buscar_art" id="buscar_art" >
            <button id="btnNada" type="button" class="btn btn-primary btn-block btn-xs"> <span class="fa fa-refresh"></span></button>
                  </div>
          <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover">
            <thead>
              <th>Opciones</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Código de barras</th>
                <th>Precio Total</th>
                <th>Monto cuota</th>
                <th>Stock</th>
                <th>Cantidad de cuotas</th>
                <th>Imagen</th>
            </thead>
            <tbody>
              
            </tbody>
            <tfoot>
              <th>Opciones</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Código de barras</th>
                <th>Precio Total</th>
                <th>Monto cuota</th>
                <th>Stock</th>
                <th>Cantidad de cuotas</th>
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
  <div class="modal" id="cliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 65% !important;">
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
                            <label>Direccion:</label>
                            <input type="text" class="form-control" name="direccion" id="direccion" >
                          </div>


                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Celular:</label>
                            <input type="text" class="form-control" name="celular" id="celular" placeholder="Celular">
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Correo:</label>
                            <input type="email" class="form-control" name="correo" id="correo" >
                          </div>
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Fecha Nacimiento:</label>
                            <input type="date" class="form-control" name="fechaNacimiento" id="fechaNacimiento" >
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
                          <div class="modal fade" id="modal_detalle_cobro">
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


<script type="text/javascript">


//Ajax - Cliente
// AJAX call for autocomplete 
$(document).ready(function(){
  $('select.selector_persona').selectpicker();
    $(".person input").on('input', function() {

   var esto = this; 
    $.ajax({
    type: "POST",
    url: "../ajax/persona.php?op=selectClienteLimit",
    data:{keyword:$(this).val(), tipoPersona: 1},
    success: function(data){
       $("select.selector_persona ").html(data);
      $("select.selector_persona").selectpicker("refresh");
    },
    error: function(data){
        console.log("NO se pudo enviar");
    }
    });
  });
    $("select.selector_persona").change(function(){
        var idPersona = $(this).children("option:selected").val();
        //var razonSocial = $(this).children("option:selected").attr("d-precio");
        //var nroDocumento = $(this).children("option:selected").attr("d-impuesto");
        //var didImpuesto = $(this).children("option:selected").attr("d-idImpuesto");
        //var dnombre = $(this).children("option:selected").text();

        //agregarDetalle(idPersona,dnombre,dprecio,didImpuesto, dimpuesto);
    });
});



// AJAX call for autocomplete 
$(document).ready(function(){
  $('select.selector_articulo').selectpicker();
    $(".bs-searchbox input").on('input', function() {

   var esto = this; 
    $.ajax({
    type: "POST",
    url: "../ajax/venta.php?op=listarproductos",
    data:{ keyword: $(this).val(), Persona_idPersona: $('#Cliente_idCliente').val(), terminoPago: $('#TerminoPago_idTerminoPago').val() },
    success: function(data){
       $("select.selector_articulo ").html(data);
      $("select.selector_articulo").selectpicker("refresh");
    },
    error: function(data){
        console.log("NO se pudo enviar");
    }
    });
  });
    $("select.selector_articulo").change(function(){
        var idArticulo = $(this).children("option:selected").val();
        var dprecio = $(this).children("option:selected").attr("d-precio");
        var dimpuesto = $(this).children("option:selected").attr("d-impuesto");
        var idImpuesto = $(this).children("option:selected").attr("d-idImpuesto");
        var dinteres = $(this).children("option:selected").attr("d-interes");
        var dcapital = $(this).children("option:selected").attr("d-capital");
        var dstock = $(this).children("option:selected").attr("d-stock");
        var dnombre = $(this).children("option:selected").text();

        agregarDetalle(idArticulo,dnombre,dprecio,idImpuesto,dimpuesto, dcapital, dinteres, dstock);
    });
});

</script>

<script type="text/javascript" src="scripts/ordenRemision.js"></script>
<?php 
}
ob_end_flush();
?>


