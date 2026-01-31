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
if ($_SESSION['parametricas']==1)
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
                          <h1 class="box-title">Litado de produccion</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <div id="cabecera">
 

                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Deposito:</label>
                          <select id="Deposito_idDeposito" name="Deposito_idDeposito" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>


                       <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          <label>Fecha Inicio</label>
                          <input type="date" class="form-control" name="fi" id="fi" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          <label>Fecha Fin</label>
                          <input type="date" class="form-control" name="ff" id="ff" value="<?php echo date("Y-m-d"); ?>">
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Articulo:</label>
                          <select id="Categoria_idCategoria" name="Categoria_idCategoria" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>


                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Estado(*):</label>
                            <select name="tipo_comprobante" id="tipo_comprobante" class="form-control selectpicker" required="">
                               <option selected value="999">Todos</option>
                               <option value="0">Abiertos</option>
                               <option value="1">Autorizados</option>
                            </select> 
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="button" id="btnFiltrar" onclick="filtrar()"><i class="fa fa-save"></i> Filtrar</button>
                           
                          </div>

                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Nro. Produccion</th>
                            <th>Fecha Produccion</th>
                            <th>Deposito</th>
                            <th>Articulo</th>
                            <th>Cantidad</th>  
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Nro. Produccion</th>
                            <th>Fecha Produccion</th>
                            <th>Deposito</th>
                            <th>Articulo</th>
                            <th>Cantidad</th>  
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
                        <table id="tbllistadoDetalle" class="display compact" style="width:auto">
                          <thead>
                            <th>Nro.</th>
                            <th>Categoria</th>
                            <th>Grupo Articulo</th>
                            <th>Id Articulo</th>
                            <th>Id Sucursal</th>
                            <th>Sucursal</th>
                            <th>Codigo de Barras.</th>
                            <th>Articulo</th>
                            <th>Stock</th>
                            <th>Stock real</th>
                            <th>Diferencia</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Nro.</th>
                            <th>Categoria</th>
                            <th>Grupo Articulo</th>
                            <th>Id Articulo</th>
                            <th>Id Sucursal</th>
                            <th>Sucursal</th>
                            <th>Codigo de Barras.</th>
                            <th>Articulo</th>
                            <th>Stock</th>
                            <th>Stock real</th>
                            <th>Diferencia</th>
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
                                    <span>Nuevo Analisis de Pedido< /span>
                              
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
                                                      <label class=" input-sm">Seleccione Sucursal:</label>
                                                        <select id="Sucursal_idSucursalD2" name="Sucursal_idSucursalD2" class="form-control input-sm selectpicker" data-live-search="true" ></select>
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
                          <div class="modal" id="modalHacerPedidoDetalle">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <span>Ventas por Deposito por Mes</span>
                              
                              <div class="modal-content">
                                <!-- Modal body -->

                                <div class="modal-body">
                                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label class=" input-sm">Seleccione Deposito:</label>
                                      <select id="depositoD1" name="depositoD1" class="form-control input-sm selectpicker" onchange="actualizarSucursal(this)" data-live-search="true" >
                                      </select>
                                  </div>

                                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <input type="text" class="form-control" name="Sucursal_idSucursalD1" id="Sucursal_idSucursalD1" readonly>  
                                  </div>

                                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                      <label class=" input-sm">Seleccione Proveedor:</label>
                                        <select id="proveedorD1" name="proveedorD1" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                    </div>                      

                                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                      <label class=" input-sm">Seleccione Marca:</label>
                                        <select id="marcaD1" name="marcaD1" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                  </div>   

                                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                      <label class=" input-sm">Seleccione Estado:</label>
			                            <select name="estadoD1" id="estadoD1" class="form-control selectpicker" required="">
			                               <option selected value="999">Todos</option>
			                               <option value="1">Activos</option>
			                               <option value="2">Inactivos</option>
			                               <option value="3">Descontinuados</option>
			                               <option value="4">Pesables</option>
			                            </select>
                                    </div>

                                   <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                      <label class=" input-sm">Seleccione Categoria:</label>
                                        <select id="categoriaD1" name="categoriaD1" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                    </div>  

                					<div align="center" id="espere"></div>
                                      <button type="button" id="btnGenerar" class="btn btn-success btn-block"  onclick="generarPedido()" ><i class="fa fa-plus-circle"></i> Generar nuevo inventario </button>
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
<script type="text/javascript" src="scripts/listadoProduccion.js"></script>
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


