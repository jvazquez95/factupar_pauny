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

                    <div id="irPrincipal" style="background-color: #B5B4B7">
                      <div class="panel-body table-responsive" style="height: 800px;" id="formularioregistros">                      
                        <form name="formulario" id="formulario" method="POST">
<!--                           <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                            <label>Nro. Hab.:</label> -->
                            <?php

                              $idPanelCliente = $_GET['idPanelCliente'];
                              
                              if ($idPanelCliente <= 0) {
                                $idPanelCliente = 0;
                              }

                            ?>
                        <div id="agregarProductos">

                        <div style="background-color: grey" class="col-lg-7 col-md-7 col-sm-7 col-xs-7">

                            <button class="btn btn-primary" type="button" id="btnPagos"><i class="fa fa-save"></i>Pagar / F4</button>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h2>Buscar Cliente / F2: <button type="button" onclick="modalCliente();" class="btn btn-primary"> Nuevo cliente ( F1 )</button></h2>
                            <input type="hidden" class="form-control" name="Habilitacion_idHabilitacion1" id="Habilitacion_idHabilitacion1" disabled>
                            <input type="hidden" class="form-control" name="idPanelCliente" id="idPanelCliente" value=" <?php echo $idPanelCliente  ?> ">
                            <input type="hidden" class="form-control" name="fechaFactura1" id="fechaFactura1" disabled>
                            <input type="hidden" class="form-control" name="fechaFactura" id="fechaFactura" required>
                            <input type="hidden" class="form-control" name="Empleado_idEmpleado1" id="Empleado_idEmpleado1" readonly>  
                            <input type="hidden" class="form-control" name="sucursal" id="sucursal" disabled>
                            <input type="hidden" class="form-control" name="serie" id="serie" required="">
                            <input type="hidden" class="form-control" name="serie1" id="serie1" disabled>
                            <input type="hidden" class="form-control" name="nroFactura" id="nroFactura" required="" readonly>
                            <input type="hidden" name="idVenta" id="idVenta">
                            <input type="hidden" name="OrdenVenta_idOrdenVenta" id="OrdenVenta_idOrdenVenta">
                            <input type="hidden" class="form-control" name="usuario" id="usuario" value="<?php echo $_SESSION['login'] ?>">
                            <input type="hidden" class="form-control" name="Empleado_idEmpleado" id="Empleado_idEmpleado">
                          	<input type="hidden" class="form-control" name="Habilitacion_idHabilitacion" id="Habilitacion_idHabilitacion">
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
                            <input type="hidden" class="form-control" name="cuotas" id="cuotas" value="0">
                           <!-- <select id="Cliente_idCliente" name="Cliente_idCliente" onchange="noCambiar(this)" class="form-control selectpicker" data-live-search="true" required></select>   --> 
							<!--                             <select  title="Buscar Cliente" onchange="noCambiar(this);" class="selectpicker selector_persona form-control person" data-style="btn-warning" name="Cliente_idCliente" id="Cliente_idCliente"  data-live-search="true"></select> -->
                            
                      
                            <input type="hidden" class="form-control" name="Cliente_idCliente" id="Cliente_idCliente">

                            <input type="text" class="form-control" name="buscar_cliente" id="buscar_cliente" value="">
                            <h1 id="NombreCliente" style="color: white;"></h1>


                          </div>


                      <div id="ocultarInputs">
                            <select name="TerminoPago_idTerminoPago" id="TerminoPago_idTerminoPago" onchange="detallePago(this);" class="form-control selectpicker" required=""></select>
                            <select name="Deposito_idDeposito" id="Deposito_idDeposito" class="form-control selectpicker" required="">
                            </select>
                            <select name="tipo_comprobante" id="tipo_comprobante" class="form-control selectpicker" required="">
                               <option selected value="1">Factura</option>
                            </select>
                          <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                            <label>Cant. de Cuotas:</label>
                            <input type="number" class="form-control" name="cuotas" id="cuotas" value="0">
                          </div>
                            <input type="hidden" class="form-control" name="fechaVencimiento" id="fechaVencimiento" value="<?php echo date("Y-m-d"); ?>">
                            <input type="hidden" class="form-control" name="entrega" id="entrega" value="0">
                            <select name="Moneda_idMoneda" id="Moneda_idMoneda" onchange="cargarTasa(this)" class="form-control selectpicker"  data-live-search="true" required>
                            </select>
                            <input type="hidden" class="form-control" name="tasaCambio" id="tasaCambio" required>
                            <input type="hidden" class="form-control" name="tasaCambioBases" id="tasaCambioBases" readonly>
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
        			  </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h2>Buscar por nombre:</h2>
            					      <select title="Seleccion Articulo" class="selectpicker selector_articulo form-control arti" name="buscar_articulo" id="buscar_articulo"  data-live-search="true"></select>
                          </div>


<!--                           <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <h2>Cantidad:</h2>
							<input type="number" class="form-control" name="articulo_cantidad" id="articulo_cantidad">
							<input type="number" class="form-control" name="articulo_cantidad" id="articulo_cantidad" value="1">
                          </div> -->

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h2>Buscar por codigo de barras</h2>
							<!-- <input type="number" class="form-control" name="articulo_cantidad" id="articulo_cantidad"> -->
							<input type="text" class="form-control" name="articulo_codigobarras" id="articulo_codigobarras">
                          </div>


                          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 table-responsive">
                            <table id="detalles" class="display compact">
                              <thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio Venta</th>
                                    <th>Descuento</th>
                                    <th>Total</th>
                                </thead>
                                <tfoot>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>TOTAL</th>
                                    <th><h4 id="total2"> 0.00</h4><input type="hidden" name="total_ventan" id="total_ventan"></th>
                                </tfoot>
                                <tbody>

                                </tbody>
                            </table>

                          </div>
                         </div>


                        <div style="border:1px solid black;" class="col-lg-5 col-sm-5 col-md-5 col-xs-5 table-responsive">
                          <span style=" font-family: monospace; font-size: 8em; color:white;" id="totalGrande"> 0.00</span>
                        </div>

                     </div>

                     <div id="pagar">

                        <div class="col-md-12">


                        <div style="border:1px solid black;" class="col-lg-12 col-sm-12 col-md-12 col-xs-12 table-responsive">
                          <span style=" font-family: monospace; font-size: 8em; color:white;" id="totalGrandePagos"> 0.00</span>
                        </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                            <label>Forma de pago(*):</label>
                            <select onchange="habilitarBoton();" name="FormaPago_idFormaPago" id="FormaPago_idFormaPago" class="form-control selectpicker" required=""></select>
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                            <label>Moneda:</label>
                            <select  name="Moneda_idMoneda2" id="Moneda_idMoneda2" class="form-control selectpicker" onchange="cargarTasa2(this)" required=""></select>
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                            <label>Tasa de cambio:</label>
                            <input type="text" class="form-control" name="tasaCambio2" id="tasaCambio2" readonly>
                            <input type="hidden" class="form-control" name="tasaCambioBases2" id="tasaCambioBases2" required>
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                            <label>Importe(*):</label>
                            <input type="text" class="form-control" name="importe_detalle" id="importe_detalle" value="0">
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                            <label>Nro. de referencia(*):</label>
                            <input type="text" class="form-control" name="nroCheque" id="nroCheque" required="" value="0">
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                            <label>Banco:</label>
                            <select  name="Banco_idBanco" id="Banco_idBanco" class="form-control selectpicker" required=""></select>
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                              <button id="btnTipoPago" type="button" class="btn btn-primary" onclick="agregarDetallePago();"> <span class="fa fa-plus"></span> Agregar pago</button>
                          </div>


		                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 table-responsive">
		                            <table id="detalles1" class="table table-striped table-bordered table-condensed table-hover">
		                              <thead style="background-color:#A9D0F5">
		                                    <th>Opciones</th>
		                                    <th>Tipo de Pago</th>
		                                    <th>Moneda</th>
		                                    <th>Cambio</th>
		                                    <th>Pendiente</th>
		                                    <th>Saldo</th>
		                                    <th>Nro. de Referencia</th>
		                                </thead>

		                                <tfoot>
		                                    <th></th>
		                                    <th></th>
		                                    <th></th>
		                                    <th></th>
		                                    <th>Total</th>
		                                    <th><h4 id="total_detalle"></h4><input type="hidden" name="t_detalle" id="t_detalle"></th>
		                                    <th></th>
		                                </tfoot>
		                                <tbody>
		                                </tbody>
		                            </table>
		                          </div>




                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="button" onclick="guardaryeditar()" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                            
                            <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
</div>
                          
                        </form>
                    <!--Fin centro -->
                  </div><!-- /.box -->

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
    <div class="modal-dialog" style="width: auto !important;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Registrar nuevo cliente</h4>
        </div>
                    <div class="panel-body" style="height: auto;" id="formularioregistros">
                        <form name="formularioCliente" id="formularioCliente" method="POST">

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Tipo Documento:</label>
                            <select class="form-control select-picker" name="tipoDocumento" id="tipoDocumento" required>
                              <option value="1">RUC</option>
                              <option value="2">CEDULA</option>
                            </select>
                          </div>

                        	
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Razon social:</label>
                            <input type="text" class="form-control" name="razonSocial" id="razonSocial" maxlength="250" placeholder="Nombre del cliente" required>
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

                         <!--  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Usuario Marangatu:</label>
                            <input type="text" class="form-control" name="usuarioMarangatu" id="usuarioMarangatu" placeholder="Usuario Marangatu">
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Contraseña Marangatu:</label>
                            <input type="text" class="form-control" name="password" id="password" placeholder="Contraseña">
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Comentario:</label>
                            <input type="text" class="form-control" name="comentario" id="comentario" placeholder="Comentario">
                          </div>


                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label class=" input-sm">Tipo Cliente:</label>
                            <select id="tipoCliente" name="tipoCliente" class="form-control input-sm selectpicker" data-live-search="true" required>
                              <option value="ROBSA_CITYBEST" selected>Robsa - City Best</option>
                              <option value="ROBSA_FASTMER">Robsa - Fastmer</option>
                              <option value="ROBSA_EXTERNO">Robsa - Otros</option>
                            </select>
                          </div>


                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label class=" input-sm">Tipo Plan:</label>
                            <select id="tipoPlan" name="tipoPlan" class="form-control input-sm selectpicker" data-live-search="true" required>
                              <option value="12">12 MESES</option>
                              <option value="18">18 MESES</option>
                              <option value="24" selected>24 MESES</option>
                              <option value="36">36 MESES</option>
                            </select>
                          </div>
 -->

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


<div class="loader"></div>


<?php
}
else
{
  require 'noacceso.php';
}

require 'footer.php';
?>



<style type="text/css">
  

.loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('images/imagenLoader.gif') 50% 50% no-repeat rgb(249,249,249);
    opacity: .8;
}



</style>



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
    //$(".bs-searchbox input").on('input', function() {
      $(".arti input").on('input', function() {

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
        var dnombre = $(this).children("option:selected").text();

        agregarDetalle(idArticulo,dnombre,dprecio,idImpuesto,dimpuesto, dcapital, dinteres);
    });
});

</script>





<script type="text/javascript" src="scripts/ordenVentaDirecta.js"></script>
<?php 
}
ob_end_flush();
?>


