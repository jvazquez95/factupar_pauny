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
<div class="row justify-content-center d-flex">
  <div class="col-12 ct_6675 col-md-4">
    <h1 class="box-title">Venta <button class="btn btn-success"  id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
  </div>

  <div class="col-12 ct_6675 col-md-4">
    <div class="box-tools">
                          <button class="btn btn-success"  id="btnimprimir" onclick="imprimirArqueo();"><i class="fa fa-print"></i> Imprimir Arqueo de caja</button>
                            
    </div>
  </div>

  <div class="col-12 ct_6675 col-md-4">
<a href="movimiento.php"><span class="label bg-green">Ir a movimientos de caja</span></a>
                            <a href="#"><span class="label bg-green">Ir a cobros</span></a>
  </div>
</div>


                          
                        
                    </div>

                    <!-- /.box-header -->
                    <!-- centro -->
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
                            <th>
                              
                            </th> 
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
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">                      
                        <form name="formulario" id="formulario" method="POST">
<p>
  <a class="btn btn-primary" data-toggle="collapse" href="#7577667" role="button" aria-expanded="false" aria-controls="7577667">
    Mostrar datos por defecto  
  </a>
</p>
<div class="collapse" id="7577667">
  <div class="card card-body">
<div class="form-group cuadro_deshabilitado_575">
                            <span>Nro. Hab.: <input type="text" class="form-control" name="Habilitacion_idHabilitacion1" id="Habilitacion_idHabilitacion1" disabled></span>
                            <span>Fecha. Fact.:  <input type="text" class="form-control" name="fechaFactura1" id="fechaFactura1" disabled>
                            <input type="hidden" class="form-control" name="fechaFactura" id="fechaFactura" required></span>
                            <span>Deposito.:<input type="text" class="form-control" name="Deposito_idDeposito1" id="Deposito_idDeposito1" disabled></span>
                            <span>Sucursal.:<input type="text" class="form-control" name="sucursal" id="sucursal" disabled></span>
                            <span>Usuario.: <input type="text" class="form-control" name="usuario1" id="usuario1" value="<?php echo 'Usuario: ' .$_SESSION['login'].' Nombre completo: '.$_SESSION['nombre'] ?>" disabled></span>
                          </div>
  </div>
</div>

                          



                          <div class="form-group col-lg-3 col-md-3 col-xs-12">
                          <label>Cliente(*):</label>
                          <div class="input-group">
                          <select  id="Cliente_idCliente" placeholder="selecciona" name="Cliente_idCliente" class="form-control selectpicker zindex46" data-live-search="true" required>
                           </select>
                             <div class="input-group-append">
<span class="input-group-btn">
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

                            <input type="hidden" class="form-control" name="TerminoPago_idTerminoPagoCabecera" id="TerminoPago_idTerminoPagoCabecera" value='0'>
                            <input type="hidden" class="form-control" name="cuotas" id="cuotas" value="0">
                            <input type="hidden" class="form-control" name="fechaVencimiento" id="fechaVencimiento" value="<?php echo date("Y-m-d"); ?>">
                            <input type="hidden" class="form-control" name="giftCard" id="giftCard" value="0">
                            <input type="hidden" class="form-control" name="nroGiftCard" id="nroGiftCard" value='0'>
                            <input type="hidden" class="form-control" name="clienteGiftCard" id="clienteGiftCard" value='0'>
                            <input type="hidden" class="form-control" name="nroCheque" id="nroCheque" value='0'>
                            <input type="hidden" class="form-control" name="Banco_idBanco" id="Banco_idBanco" value='0'>


                            
                           <button type="button" onclick="modalCliente();" class="btn btn-info btn-flat zindex0"><i class="fa fa-user"></i> <i class="fa fa-plus"></i></button>
                          </span>  							 </div>
                          </div>
                          </div>


                          <div class="form-group col-lg-3 col-md-3 col-xs-12">
                            <label>Tipo Comprobante(*):</label>
                          <select name="tipo_comprobante" id="tipo_comprobante" class="form-control selectpicker" required="">
                               <option selected value="1">Factura</option>
                               <option value="2">Ticket</option>
                            </select>
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-xs-12">
                            <label>Serie(*):</label>

                            <input type="hidden" class="form-control" name="serie" id="serie" required="">
                            <input type="text" class="form-control" name="serie1" id="serie1" disabled>
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-xs-12">

                            <label>Nro. Comprobante(*):</label>
                            <input type="text" class="form-control" name="nroFactura" id="nroFactura" required="">
                          </div>




 
                          <div class="row">
<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
  <div class="table-responsive">
                            <table id="detalles" class="table100 table100 table tablesaw tablesaw-stack">
                              <thead style="background-color:#A9D0F5">
                                    <th class="title" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Opciones</th>
                                    <th  scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="1">Artículo</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Precio Venta</th>
                                    <th scope="col">Descuento</th>
                                    <th scope="col">Impuesto</th>
                                    <th scope="col">Total Neto</th>
                                    <th scope="col">Subtotal</th>
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
                                	<th></th>
                            		<th>Servicio de transporte</th>
                            		<th><input type="text" value="1" class="form-control"></th> 
                            		<th><input type="text" value="11500" class="form-control"></th>                          
                            		<th><input type="text" value="0" class="form-control"></th>  
                            		<th>10%</th>
                            		<th>10350</th> 
                            		<th>11500</th>                          

                                </tbody>
                            </table>
</div>
                          </div>
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
                              <button id="btnTipoPago" type="button" class="btn btn-primary" onclick="agregarDetallePago();"> <span class="fa fa-plus"></span> Agregar pago</button>
                          </div>



                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                      <div class="table-responsive  text-nowrap ">
                            <table id="detalles1" class="table100 table tablesaw tablesaw-stack" data-tablesaw-mode="stack">
                              <thead style="background-color:#A9D0F5">
                                    <th  scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Opciones</th>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Tipo de Pago</th>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Importe</th>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Nro. de Referencia</th>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1"></th>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1"></th>
                                </thead><tbody>
                                </tbody>
                                <tfoot class="hide_5456">
                                    <th> </th>
                                    <th>TOTAL</th>
                                    <th><h4 id="total_detalle"></h4><input type="hidden" name="t_detalle" id="t_detalle"></th>
                                    <th></th> 
                                </tfoot>
                                
                            </table>

                          </div>
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
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->

  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style=" margin:0 auto;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Seleccione un Artículo</h4>
        </div>
        <div class="modal-body">


          <div class="table-responsive">
          <table  id="tblarticulos" class="tabla678788  tablesaw "  data-tablesaw-mode="stack" data-tablesaw-mode-switch data-tablesaw-minimap>
            <thead>
                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="">Opciones</th>
                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Nombre</th>
                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2" >Descripcion</th>
                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Categoría</th>
                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Código de barras</th>
                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Precio Venta</th>
                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6">Imagen</th>
            </thead>
      <tbody>

        
       
       
      </tbody>
<!--             <tfoot>
              <th>Opciones</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Código de barras</th>
                <th>Precio Venta</th>
                <th>Imagen</th>
            </tfoot> -->
          </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>        
      </div>
    </div>
  </div>  
  <!-- Fin modal -->

  <!-- Modal -->
<div class="modal" id="cliente" tabindex="-1" role="dialog">
  <div class="modal-dialog" style="width: 90% !important; margin:0 auto;" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Registrar a un nuevo cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
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
                          <div class="modal fade" id="modal_detalle">
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
<script type="text/javascript" src="scripts/venta.js"></script>
<?php 
}
ob_end_flush();
?>


