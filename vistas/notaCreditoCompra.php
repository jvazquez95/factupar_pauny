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
if ($_SESSION['compras']==1)
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
                          <h1 class="box-title">Nota Credito Compra <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button><button class="btn btn-success" id="btnaticulo" onclick="crud('articulo')"><i class="fa fa-plus-circle"></i> Nuevo Articulo</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Acciones</th>
                            <th>Nro Compra</th>
                            <th>Nro Nota de Credito</th>
                            <th>Razon Social</th>
                            <th>Tipo de Comprobante</th>
                            <th>Fecha de Transaccion</th>
                            <th>Total</th>
                            <th>Opciones</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Acciones</th>
                            <th>Nro devolucion</th>
                            <th>Nro Factura</th>
                            <th>Razon Social</th>
                            <th>Tipo de Comprobante</th>
                            <th>Fecha de Transaccion</th>
                            <th>Total</th>
                            <th>Opciones</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>

                    <div class="panel-body" style="height: auto;" id="formularioregistros">
                    <button class="btn btn-success btn-xs" id="btnagregar" onclick="crud('proveedorTimbrado');"><i class="fa fa-plus-circle"></i> Nuevo Timbrado por proveedor</button>
                        <form name="formulario" id="formulario" method="POST">

                          			<div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                            			<label>Nro. Hab.:</label>
            							<input type="text" class="form-control" name="Habilitacion_idHabilitacion1" id="Habilitacion_idHabilitacion1" disabled>
                                      </div>
                                    
                                      <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>Deposito.:</label>
            							<input type="text" class="form-control" name="Deposito_idDeposito1" id="Deposito_idDeposito1" disabled>
                                      </div>

                                      <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>Sucursal.:</label>
            							<input type="text" class="form-control" name="sucursal" id="sucursal" disabled>
                                      </div>

                                      <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Usuario:</label>
            							<input type="text" class="form-control" name="usuario1" id="usuario1" value="<?php echo 'Usuario: ' .$_SESSION['login'].' Nombre completo: '.$_SESSION['nombre'] ?>" disabled>
                                      </div>


                                      <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Seleccione Compra:</label>
                                        <select data-style="btn-primary" onchange="cargarCompra(this);" name="Compra_idCompra" id="Compra_idCompra" class="form-control selectpicker" data-live-search="true"></select>
                                      </div>


                                      <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                      <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>Proveedor(*):</label>
                                        <input type="hidden" name="idcompra" id="idcompra">
                                        <input type="hidden" class="form-control" name="usuario" id="usuario" value="<?php echo $_SESSION['login'] ?>">
                                     	<input type="hidden" class="form-control" name="Habilitacion_idHabilitacion" id="Habilitacion_idHabilitacion">
                                        <input type="hidden" class="form-control" name="Deposito_idDeposito" id="Deposito_idDeposito" value="3">
                                        <!--<input type="hidden" class="form-control" name="tasaCambioBases" id="tasaCambioBases" value="0">-->
                                        <input type="hidden" class="form-control" name="totalImpuesto" id="totalImpuesto">
                                        <input type="hidden" class="form-control" name="total" id="total">
                                        <input type="hidden" class="form-control" name="subTotal" id="subTotal">
                                        <input type="hidden" class="form-control" name="fechaTransaccion" id="fechaTransaccion">
                                        <input type="hidden" class="form-control" name="fechaModificacion" id="fechaModificacion" value="2017-01-01">
                                        <input type="hidden" class="form-control" name="usuarioInsercion" id="usuarioInsercion" value="0">
                                        <input type="hidden" class="form-control" name="usuarioModificacion" id="usuarioModificacion" value="0">
                                        <input type="hidden" class="form-control" name="inactivo" id="inactivo" value="0">
                                        <!--<select id="Proveedor_idProveedor" name="Proveedor_idProveedor" onchange="listarTimbrado(this);" class="form-control selectpicker" data-live-search="true" required>
                                        </select>-->

                            <select   title="Selecciona Proveedor" onchange="listarTimbrado(this);" class="selectpicker selector_persona form-control person" data-style="btn-warning" name="Proveedor_idProveedor" id="Proveedor_idProveedor"  data-live-search="true"></select>


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


                         					  <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
        			                            <label>Imagen de Factura:</label>
        			                            <input type="file" class="form-control" name="imagen" id="imagen">
                                    			<input type="hidden" name="imagenactual" id="imagenactual">
        			                          </div>

                                     </div>
                 
                                      <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <select   title="Selecciona Articulo" class="selectpicker selector_articulo form-control" data-style="btn-warning" name="buscar_articulo" id="buscar_articulo"  data-live-search="true">
                                                    </select>
                                      </div>

                                      <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 table-responsive">
                                        <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                                          <thead style="background-color:#A9D0F5">
                                                <th>Opciones</th>
                                                <th>Artículo</th>
                                                <th>Cantidad</th>
                                                <th>Precio Compra</th>
                                                <th>Descuento</th>
                                                <th>Impuesto</th>
                                                <th>Total Neto</th>
                                                <th>Subtotal</th>
                                            </thead>
                                            <tbody>
                                              <tr>
                                                  <td></td>
                                                  <td>

                                                  </td>
                                                  <td class="cantidad"></td>
                                                  <td class="precioventa"></td>
                                                  <td class="descuento"></td>
                                                  <td class="impuesto"></td>
                                                  <td class="totalneto"></td>
                                                  <td class="subtotal"></td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th>TOTAL</th>
                                                <th><h4 id="total1">Gs. 0.00</h4><input type="hidden" name="total_compran" id="total_compran"></th>
                                                <th><h4 id="total2">Gs. 0.00</h4><input type="hidden" name="total_compra" id="total_compra"></th> 
                                            </tfoot>
                                            <tbody>

                                            </tbody>
                                        </table>
                                      </div>
<!--
                                      <div class="form-group col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                        <label>Tipo de pago(*):</label>
                                        <select name="TerminoPago_idTerminoPagoDetalle" onchange="isCheque(this);habilitarBoton();" id="TerminoPago_idTerminoPagoDetalle" class="form-control selectpicker" required=""></select>
                                      </div>

                                      <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <label>Importe(*):</label>
                                        <input type="number" class="form-control" name="importe_detalle" id="importe_detalle" required="">
                                      </div>
                                      
                                      <div id="divCheque" class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                      <button class="btn btn-success btn-xs" id="btnagregar" onclick="crud('cheque');"><i class="fa fa-plus-circle"></i> Nuevo Cheque</button>
                                      </div>


                                      <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <label>Nro. de referencia(*):</label>
                                        <input type="text" class="form-control" name="nroCheque" id="nroCheque" required="">

                                      </div>

                                      <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                          <button id="" type="button" class="btn btn-primary" onclick="agregarDetallePago();"> <span class="fa fa-plus"></span> Agregar pago</button>
                                      </div>


                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 table-responsive">
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
-->
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
                    <!--Fin centro -->
                  </div><!-- /.box -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->

  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 65% !important;">
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



                        <div class="container">
                           <style>
                          </style>
                          <!-- The Modal -->
                          <div class="modal" id="modal_detalle">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                              <div class="modal-content">
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <span>Detalle de NC:<input type="text" disabled name="detalle" id="detalle" /> </span>
                                <table id="tbllistado4" class="table table-striped table-bordered table-condensed table-hover">
                                  <thead>
                                    <th>Id. Item</th>
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
                                    <span>Detalle de pago:<input type="text" disabled name="detalle_pago" id="detalle_pago" /> </span>
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
// AJAX call for autocomplete 
$(document).ready(function(){
  $('select.selector_articulo').selectpicker();
    $(".bs-searchbox input").on('input', function() {

   var esto = this; 
    $.ajax({
    type: "POST",
    url: "../ajax/compra.php?op=listarproductos",
    data:'keyword='+$(this).val(),
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
        var dnombre = $(this).children("option:selected").text();

        agregarDetalle(idArticulo,dnombre,dprecio,dimpuesto);
    });
});





//Ajax - Cliente
// AJAX call for autocomplete 
$(document).ready(function(){
  $('select.selector_persona').selectpicker();
    $(".person input").on('input', function() {

   var esto = this; 
    $.ajax({
    type: "POST",
    url: "../ajax/persona.php?op=selectClienteLimit",
    data:{keyword:$(this).val(), tipoPersona: 2},
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




</script>


<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>

<script type="text/javascript" src="scripts/notaCreditoCompra.js"></script>
<?php 
}
ob_end_flush();
?>


