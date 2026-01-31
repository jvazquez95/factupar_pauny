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
                          <h1 class="box-title">Orden de venta. <button class="btn btn-success"  id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                    
                            <a href="movimiento.php"><span class="label bg-green">Ir a movimientos de caja</span></a>
                            <a href="#"><span class="label bg-green">Ir a cobros</span></a>
                        </div>
                    </div>
					<div id="stock-supera">Cantidad supera stock.</div>
                    <div id="limite-supera">El total supera el limite establecido</div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
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
                            <th>Tipo</th>
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
                            <th>Tipo</th>
                            <th>Total</th>
                            <th>Usuario Ins</th>
                            <th>Usuario Mod</th>
                            <th>Detalles</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">   
                          <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                            
                            <label>Registrar nuevo cliente(*):</label>
                            <button type="button" onclick="modalCliente();" class="btn btn-primary btn-xs btn-block"> + Registrar nuevo cliente</button>
                          </div>


                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                            <label>Nro. Hab.:</label>
							              <input type="text" class="form-control" name="Habilitacion_idHabilitacion1" id="Habilitacion_idHabilitacion1" disabled>
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Fecha. Fact.:</label>
                            <input type="text" class="form-control" name="fecha1" id="fecha1" disabled>
                            <input type="hidden" class="form-control" name="fecha" id="fecha" required>
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Sucursal.:</label>
							              <input type="text" class="form-control" name="sucursal" id="sucursal" disabled>
                          </div>


                          <div class="form-group col-lg-3 col-md-3 col-sm-4 col-xs-12">
                            <label>Usuario:</label>
                            <input type="text" class="form-control" name="usuario1" id="usuario1" value="<?php echo 'Usuario: ' .$_SESSION['login'].' Nombre completo: '.$_SESSION['nombre'] ?>" disabled>
                          </div>
						  
						  <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-4">
                            <label>Linea Disponible:</label>
								<input type="text" class="form-control" name="lineaDisponible" id="lineaDisponible" readonly="">
                          </div>

                      <div class="my-3 p-3 bg-grey rounded shadow-sm row col-lg-12 col-md-12 col-sm-12 col-xs-12">

                          <div class="form-group col-lg-2s col-md-2 col-sm-2 col-xs-2">
                            <label>Seleccionar Cliente(*):</label>

                            <input type="hidden" name="idOrdenVenta" id="idOrdenVenta">
                            <input type="hidden" class="form-control" name="usuario" id="usuario" value="<?php echo $_SESSION['login'] ?>">
                         	  <input type="hidden" class="form-control" name="Habilitacion_idHabilitacion" id="Habilitacion_idHabilitacion">
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
                            <!--<select id="Persona_idPersona" name="Persona_idPersona" class="form-control selectpicker" data-live-search="true" required>
                            </select>  -->        
                            <select  onchange="filtroLimiteTerminoPago(this)" title="Selecciona Persona" class="selectpicker selector_persona form-control person" data-style="btn-warning" name="Persona_idPersona" id="Persona_idPersona"  data-live-search="true"></select>

                          </div>


                          <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-4">
                            <label>Deposito(*):</label>
                            <select name="Deposito_idDeposito" id="Deposito_idDeposito" class="form-control selectpicker" required="">
                            </select>
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-4">
                            <label>Termino de pago(*):</label>
                            <select name="TerminoPago_idTerminoPago" id="TerminoPago_idTerminoPago" onchange="cambiarTerminoSegundario(this);" class="form-control selectpicker" required="">
                            </select>
                          </div>
						  
						  <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-4">
                            <label>Tipo:</label>
                            <select name="tipo" id="tipo" class="form-control selectpicker" required>
								<option value="1" selected>Normal</option>
								<option value="2">Presupuesto</option>
                            </select>
                          </div>
						  
						  <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-4">
                            <label>Forma de Entrega:</label>
                            <select name="formaEntrega" id="formaEntrega" class="form-control selectpicker" required>
								<option value="1" selected>En el Local</option>
								<option value="2">Delivey</option>
                            </select>
                          </div>
						  
						  <div class="form-group row">
							  <label for="example-datetime-local-input" class="col-2 col-form-label">El dia</label>
							  <div class="col-10">
								<input class="form-control" type="datetime-local" value="<?php $month = date('m')-1; $year = date('Y'); echo date('Y-m-d H:i', mktime(0,0,0, $month, 1, $year));?>" id="fechaEntrega" name = "fechaEntrega">
							  </div>
							</div>
						  
						  
						  
                      </div>

                          <div class="my-3 p-3 bg-white rounded shadow-sm form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label>Buscar articulo:</label>
                      <select   title="Selecciona Articulo" class="selectpicker selector_articulo form-control arti" name="buscar_articulo" id="buscar_articulo"  data-live-search="true"></select>
                          </div>

                          <div class=" my-3 p-3 bg-white rounded shadow-sm form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <a data-toggle="modal" href="#myModal">
                            <label>Agregar Articulo:</label>        
                              <button id="btnAgregarArt" type="button" class="btn btn-primary btn-block btn-xs"> <span class="fa fa-plus"></span> Agregar Artículos</button>
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
						            <button onclick="listarArticulos()" id="btnNada" type="button" class="btn btn-primary btn-block btn-xs"> <span class="fa fa-refresh"></span></button>
                  </div>

                <div class="form-group col-lg-3 col-md-3 col-sm-4 col-xs-12">
                            <label>Termino de pago(*):</label>
                            <select name="TerminoPago_idTerminoPagoModal" id="TerminoPago_idTerminoPagoModal" onchange="cambiarTerminoPrincipal(this);" class="form-control selectpicker" required="">
                            </select>
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
                          <div class="modal " id="modal_detalle">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                              <div class="modal-content">
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <span>Detalle de Orden de Venta:<input type="text" disabled name="detalle" id="detalle" /> </span>
                                <table id="tbllistado4" class="table table-striped table-bordered table-condensed table-hover">
                                  <thead>
                                    <th>Nro. Orden de Venta</th>
                                    <th>Nro. Item</th>
                                    <th>Id. Articulo</th>
                                    <th>Nombre</th>
                                    <th>Descripcion</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Descuento</th>
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
    data:{ keyword: $(this).val(), Persona_idPersona: $('#Persona_idPersona').val(), terminoPago: $('#TerminoPago_idTerminoPago').val() },
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
        var dinteres = $(this).children("option:selected").attr("d-interes");
        var dcapital = $(this).children("option:selected").attr("d-capital");
        var dstock = $(this).children("option:selected").attr("d-stock");
        var ddescuento = $(this).children("option:selected").attr("d-descuento");
        var dnombre = $(this).children("option:selected").text();

        agregarDetalle(idArticulo,dnombre,dprecio,dimpuesto, dcapital, dinteres, dstock, ddescuento);
    });
});




</script>



<script type="text/javascript" src="scripts/ordenVenta.js"></script>
<?php 
}
ob_end_flush();
?>


