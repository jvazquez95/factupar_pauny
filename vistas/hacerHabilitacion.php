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
if ($_SESSION['parametricas']>=0)    // ==1 
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
                          <h1 class="box-title">Cargar habilitacion</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <div id="cabecera">
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Caja:</label>
                          <select id="Caja_idCaja" name="Caja_idCaja" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>                      
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Usuario:</label>
                          <select id="Persona_idPersona" name="Persona_idPersona" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>

                       <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          <label>Fecha Inicio</label>
                          <input type="date" class="form-control" name="fi" id="fi" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          <label>Fecha Fin</label>
                          <input type="date" class="form-control" name="ff" id="ff" value="<?php echo date("Y-m-d"); ?>">
                        </div>                        

                        <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                          <label>Moneda:</label>
                          <select id="Moneda_idMoneda" name="Moneda_idMoneda" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>


                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Estado(*):</label>
                            <select name="tipo_comprobante" id="tipo_comprobante" class="form-control selectpicker" required="">
                               <option selected value="1">Todos</option>
                               <option value="2">Abiertos</option>
                               <option value="3">Cerrados</option>
                               <option value="4">Inactivos</option>
                            </select>
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="button" id="btnFiltrar" onclick="filtrar()"><i class="fa fa-save"></i> Filtrar</button>
                            <button class="btn btn-success" onclick="actualizaform()" type="button"><i class="fa fa-arrow-circle-left"></i> Nueva Habilitacion</button>
                          </div>

                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Nro. Habilitacion</th>
                            <th>Caja</th>
                            <th>Cajero</th>
                            <th>Fecha Apertura</th>
                            <th>Fecha Cierre</th>
                            <th>Total apertura</th>
                            <th>Total Cierre</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Nro. Habilitacion</th>
                            <th>Caja</th>
                            <th>Cajero</th>
                            <th>Fecha Apertura</th>
                            <th>Fecha Cierre</th>
                            <th>Total apertura</th>
                            <th>Total Cierre</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                  
                  </div>
                  <div id="detalle">
                    <button class="btn btn-danger" id="btnvolver" onclick="mostrarMenu()"><i class="fa fa-caret-square-o-left"></i> Volver</button>
                    <button class="btn btn-success" id="btngenerarOrdenCompra" onclick="generarOc()"><i class="fa fa-caret-square-o-left"></i> Generar orden de compra</button>
                    <button class="btn btn-success" id="btngenerarOrdenCompra" onclick="crud('articulo')"><i class="fa fa-caret-square-o-left"></i> Crear Nuevo Articulo</button>

                    <button class="btn btn-success" id="btnNuevoArticuloDetalle" onclick="addProductoDetalle()"><i class="fa fa-caret-square-o-left"></i> Insertar nuevo articulo al detalle</button>

                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistadoDetalle" class="display compact responsive" style="width:auto">
                          <thead>
                            <th>Nro. Pedido Detalle</th>
                            <th>Categoria</th>
                            <th>Grupo Articulo</th>
                            <th>Id Articulo</th>
                            <th>Id Sucursal</th>
                            <th>Codigo de Barras.</th>
                            <th>Codigo Sap</th>
                            <th>Sucursal</th>
                            <th>Descontinuar?</th>
                            <th>Articulo</th>
                            <th>Cantidad por Caja</th>
                            <th>Margen %</th>
                            <th>En transito</th>
                            <th>Pedido</th>
                            <th>Promedio por mes</th>
                            <th>Stock</th>
                            <th>Stock Minimo</th>
                            <th>Stock Maxmo</th>
                            <th>Costo Ultima Compra</th>
                            <th>Costo</th>
                            <th>Precio Venta</th>
                            <th>Precio Promedio</th>
                            <th>Margen</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Categoria</th>
                            <th>Grupo Articulo</th>
                            <th>Id Articulo</th>
                            <th>Id Sucursal</th>
                            <th>Codigo de Barras.</th>
                            <th>Codigo Sap</th>
                            <th>Sucursal</th>
                            <th>Descontinuar?</th>
                            <th>Articulo</th>
                            <th>Cantidad por Caja</th>
                            <th>En transito</th>
                            <th>Pedido</th>
                            <th>Promedio por mes</th>
                            <th>Stock</th>
                            <th>Stock Minimo</th>
                            <th>Stock Maxmo</th>
                            <th>Costo Ultima Compra</th>
                            <th>Costo</th>
                            <th>Precio Venta</th>
                            <th>Precio Promedio</th>
                            <th>Margen</th>
                          </tfoot>
                        </table>
                    </div>

                                  <div class="panel-body table-responsive form-group col-lg-4 col-md-4 col-sm-4 col-xs-12" id="listadoregistros">
                                      <table id="tbllistadoDetalleProveedor" class="table table-striped table-bordered table-condensed table-hover">
                                        <thead>
                                          <th>Periodo</th>
                                          <th>Total ventas</th>
                                          <th>Total devoluciones</th>
                                          <th>Costo</th>
                                        </thead>
                                        <tbody>                            
                                        </tbody>
                                        <tfoot>
                                          <th>Periodo</th>
                                          <th>Total ventas</th>
                                          <th>Total devoluciones</th>
                                          <th>Costo</th>
                                        </tfoot>
                                      </table>
                                  </div>

                                  <div class="panel-body table-responsive form-group col-lg-4 col-md-4 col-sm-4 col-xs-12" id="listadoregistros">
                                      <table id="tbllistadoDetalle2" class="table table-striped table-bordered table-condensed table-hover">
                                        <thead>
                                          <th>Usuario Modificacion</th>
                                          <th>Precio anterior</th>
                                          <th>Precio nuevo</th>
                                          <th>Fecha Modificacion</th>
                                        </thead>
                                        <tbody>                            
                                        </tbody>
                                        <tfoot>
                                          <th>Usuario Modificacion</th>
                                          <th>Precio anterior</th>
                                          <th>Precio nuevo</th>
                                          <th>Fecha Modificacion</th>  
                                        </tfoot>
                                      </table>
                                  </div>

                                  <div class="panel-body table-responsive form-group col-lg-4 col-md-4 col-sm-4 col-xs-12" id="listadoregistros">
                                      <table id="tbllistadoDetalle3" class="table table-striped table-bordered table-condensed table-hover">
                                        <thead>
                                          <th>Fecha Registro</th>
                                          <th>Fecha Documento</th>
                                          <th>Num. Factura</th>
                                          <th>Sucursal</th>
                                          <th>Cantidad Comprada</th>
                                          <th>Cantidad Devuelta</th>
                                          <th>Precio Costo</th>
                                          <th>Descuento</th>
                                          <th>Sub - Total</th>
                                        </thead>
                                        <tbody>                            
                                        </tbody>
                                        <tfoot>
                                          <th>Fecha Registro</th>
                                          <th>Fecha Documento</th>
                                          <th>Num. Factura</th>
                                          <th>Sucursal</th>
                                          <th>Cantidad Comprada</th>
                                          <th>Cantidad Devuelta</th>
                                          <th>Precio Costo</th>
                                          <th>Descuento</th>
                                          <th>Sub - Total</th>
                                        </tfoot>
                                      </table>
                                  </div>



                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

  <!--Fin-Contenido-->


                    <div class="container">
                           <style>
                          </style>
                          <!-- The Modal -->
                          <div class="modal fade" id="modalHacerPedidoProveedor">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <span>Nueva habilitacion< /span>
                              
                              <div class="modal-content">
                                <!-- Modal body -->

                                <div class="modal-body">
                                  <div class="panel-body table-responsive" id="listadoregistros">
                                      <table id="tbllistadoDetalleProveedor" class="table table-striped table-bordered table-condensed table-hover">
                                        <thead>
                                          <th>Periodo</th>
                                          <th>Mes</th>
                                          <th>Articulo</th>
                                          <th>Total ventas</th>
                                          <th>Total devoluciones</th>
                                        </thead>
                                        <tbody>                            
                                        </tbody>
                                        <tfoot>
                                          <th>Periodo</th>
                                          <th>Mes</th>
                                          <th>Articulo</th>
                                          <th>Total ventas</th>
                                          <th>Total devoluciones</th>
                                        </tfoot>
                                      </table>
                                  </div>
                                </div>                               

                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                </div>
                              </div>
                            </div>
                          </div>



                    <div class="container">
                           <style>
                          </style>
                          <!-- The Modal -->
                          <div class="modal" id="modalHacerPedidoDetalleArticulo">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <span>Agregar detalle al Analisis</span>
                              
                              <div class="modal-content">
                                <!-- Modal body -->

                                <div class="modal-body">



                                      <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <select   title="Selecciona Articulo" class="selectpicker selector_articulo form-control" data-style="btn-warning" name="buscar_articulo" id="buscar_articulo"  data-live-search="true">
                                                    </select>
                                      </div>



                                                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                      <label class=" input-sm">Seleccione Moneda:</label>
                                                        <select id="Moneda_idMonedaD2" name="Moneda_idMonedaD2" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                                    </div>





                                					<div align="center" id="espereArticulo"></div>


                                                      <button type="button" id="btnGenerarArticulo" class="btn btn-success btn-block"  onclick="generarPedidoArticulo()" ><i class="fa fa-plus-circle"></i> Agregar</button>
                                                    </div>                               

                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                </div>
                              </div>
                            </div>
                          </div>


                       <div class="container">
                           <style>
                          </style>
                          <!-- The Modal -->
                          <div class="modal" id="modal_detalle">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                              <div class="modal-content">
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <span>Detalle de Habilitacion:<input type="text" disabled name="detalle" id="detalle" /> </span>
                          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 table-responsive">
                                
                                <table id="tbllistado4" class="table table-striped table-bordered table-condensed table-hover">
                                  <thead>
                                    <th>Nro. Habilitacion</th>
                                    <th>Nro. Item</th>
                                    <th>Moneda</th>
                                    <th>Denominacion</th>
                                    <th>Monto Apertura</th>
                                    <th>Monto Cierre</th>
 
                                  </thead>
                                  <tbody>                            
                                  </tbody>
                                  <tfoot>
                                    <th>Nro. Habilitacion</th>
                                    <th>Nro. Item</th>
                                    <th>Moneda</th>
                                    <th>Denominacion</th>
                                    <th>Monto Apertura</th>
                                    <th>Monto Cierre</th>
 
                                  </tfoot>
                                </table>
                                </div>
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
                          <div class="modal" id="modalHacerPedidoDetalle">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <span>Habilitacion nueva</span>
                              
                              <div class="modal-content">
                                <!-- Modal body -->

                                <div class="modal-body">
                                                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                      <label class=" input-sm">Seleccione Cajero:</label>
                                                        <select id="proveedorD1" name="proveedorD1" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                                    </div>

                                                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                      <label class=" input-sm">Seleccione Moneda:</label>
                                                        <select onchange="noCambiar(this);" id="Moneda_idMonedaD1" name="Moneda_idMonedaD1" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                                    </div>

                                                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                      <label class=" input-sm">Seleccione Denominacion:</label>
                                                        <select id="Denominacion_idDenominacionD1" name="Denominacion_idDenominacionD1" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                                    </div>

                                                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                      <label class=" input-sm">Cantidad:</label>
                                                      <input type="number" class="form-control" name="cantidad" id="cantidad"  > 
                                                    </div>


                                					<div align="center" id="espere"></div>


                                                      <button type="button" id="btnGenerar" class="btn btn-success btn-block"  onclick="generarPedido()" ><i class="fa fa-plus-circle"></i> Generar nuevo registro de habilitacion</button>
                                                    </div>                               

                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
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
<script type="text/javascript" src="scripts/hacerHabilitacion.js"></script>
<script type="text/javascript" src="scripts/generales.js"></script>

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
    data:{keyword:$(this).val(), tipoPersona: 3},
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
    });
});









// AJAX - Articulo
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
        var didImpuesto = $(this).children("option:selected").attr("d-idImpuesto");
        var dnombre = $(this).children("option:selected").text();

        agregarDetalle(idArticulo,dnombre,dprecio,didImpuesto, dimpuesto);
    });
});






</script>


<?php 
}
ob_end_flush();
?>


