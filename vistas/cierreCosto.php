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
                          <h1 class="box-title">Analisis de Costo</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <div id="cabecera">
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Centro de costo:</label>
                          <select id="CentroCosto_idCentroCosto" name="CentroCosto_idCentroCosto" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="button" id="btnFiltrar" onclick="filtrar()"><i class="fa fa-save"></i> Filtrar</button>
                            <button class="btn btn-success" onclick="mostrarProveedor()" type="button"><i class="fa fa-arrow-circle-left"></i> Nuevo Analisis de Costo</button>
                          </div>

                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Nro.</th>
                            <th>Centro de costo</th>
                            <th>Fecha Transaccion</th>
                            <th>Usuario Ins.</th>
                            <th>Fecha Mod</th>
                            <th>Usuario Mod.</th>
                            <th>Opciones</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Nro.</th>
                            <th>Centro de costo</th>
                            <th>Fecha Transaccion</th>
                            <th>Usuario Ins.</th>
                            <th>Fecha Mod</th>
                            <th>Usuario Mod.</th>
                            <th>Opciones</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                  tbllistadoDetalle3
                  </div>
                  <div id="detalle">
                    <button class="btn btn-danger" id="btnvolver" onclick="mostrarMenu()"><i class="fa fa-caret-square-o-left"></i> Volver</button>
                    <button class="btn btn-success" id="btngenerarOrdenCompra" onclick="generarOc()"><i class="fa fa-caret-square-o-left"></i> Generar</button>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistadoDetalle" class="display compact" style="width:100%">
                          <thead>
                            <th>Nro detalle.</th>
                            <th>Fecha Factura</th>
                            <th>Nro. Compra</th>
                            <th>Proveedor</th>
                            <th>Nro. Factura</th>
                            <th>Total</th>
                            <th>Tipo</th>
                            <th>Asignado a Nro. Compra</th>
                            <th>Comentario</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>              
                            <th>Nro detalle.</th>
                            <th>Fecha Factura</th>
                            <th>Nro. Compra</th>
                            <th>Proveedor</th>
                            <th>Nro. Factura</th>
                            <th>Total</th>
                            <th>Tipo</th>
                            <th>Asignado a Nro. Compra</th>
                            <th>Comentario</th>
                          </tfoot>
                        </table>
                    </div>

                    <!--Fin centro -->
                  </div><!-- /.box -->


                  <div id="detalle3">
                    <button class="btn btn-success" id="btngenerarOrdenCompra" onclick="salir()"><i class="fa fa-caret-square-o-left"></i> Salir</button>
                  	
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistadoDetalle3" class="display compact" style="width:100%">
                          <thead>
                            <th>Nombre Comercial.</th>
                            <th>Id Compra</th>
                            <th>Nro Factura</th>
                            <th>Total Factura</th>
                            <th>Total Mercaderia Proveedor</th>
                            <th>Gastos Compartidos</th>
                            <th>Gastos por Proveedor</th>
                            <th>Costo Global</th>
                            <th>Costo Particular</th>
                            <th>Costo Prorrateado</th>
                            <th>Porcentaje Prorrateo</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot> 
                            <th>Nombre Comercial.</th>
                            <th>Id Compra</th>
                            <th>Nro Factura</th>
                            <th>Total Factura</th>
                            <th>Total Mercaderia Proveedor</th>
                            <th>Gastos Compartidos</th>
                            <th>Gastos por Proveedor</th>
                            <th>Costo Global</th>
                            <th>Costo Particular</th>
                            <th>Costo Prorrateado</th>
                            <th>Porcentaje Prorrateo</th>                        	
                          </tfoot>
                        </table>
                    </div>




                  </div>



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
                                    <span>Nuevo Analisis de Pedido</span>
                              
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
                          <div class="modal" id="modalHacerPedidoDetalle">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <span>Ventas por Proveedor por Mes</span>
                              
                              <div class="modal-content">
                                <!-- Modal body -->

                                <div class="modal-body">
                                                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                      <label class=" input-sm">Seleccione Centro de costo:</label>
                                                        <select id="CentroCosto_idCentroCostoD" name="CentroCosto_idCentroCostoD" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                                    </div>


                                					<div align="center" id="espere"></div>


                                                      <button type="button" id="btnGenerar" class="btn btn-success btn-block"  onclick="generarPedido()" ><i class="fa fa-plus-circle"></i> Generar nuevo analisis de pedido</button>
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
                          <div class="modal" id="modalBuscarFactura">
                            <div class="modal-dialog modal-lg modal-dialog-centered">                              
                              <div class="modal-content">
                                <!-- Modal body -->
                                <div class="modal-body">
                                      <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <label class=" input-sm">Seleccione factura:</label>
                                            <select id="Compra_idCompraBuscador" onchange="asignarFacturaCampo()" name="Compra_idCompraBuscador" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                      </div>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
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
<script type="text/javascript" src="scripts/cierreCosto.js"></script>
<?php 
}
ob_end_flush();
?>


