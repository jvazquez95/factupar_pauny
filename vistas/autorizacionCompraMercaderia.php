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
                          <h1 class="box-title">Analisis de compras - Mercaderias</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <div id="cabecera">
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Acciones</th>
                            <th>Nro Compra</th>
                            <th>Nro Habilitacion</th>
                            <th>Fecha</th>
                            <th>Proveedor</th>
                            <th>Usuario</th>
                            <th>Documento</th>
                            <th>Número</th>
                            <th>Total Compra</th>
                            <th>Ver detalle de compra</th>
                            <th>Ver detalle de pago</th>
                            <th>Estado</th>
                            <th>Imagen</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Acciones</th>
                            <th>Nro Compra</th>
                            <th>Nro Habilitacion</th>
                            <th>Fecha</th>
                            <th>Proveedor</th>
                            <th>Usuario</th>
                            <th>Documento</th>
                            <th>Número</th>
                            <th>Total Compra</th>
                            <th>Ver detalle de compra</th>
                            <th>Ver detalle de pago</th>
                            <th>Estado</th>
                            <th>Imagen</th>
                          </tfoot>
                        </table>
                    </div>
                  
                  </div>
                  <div id="detalle">

                  	<div>
                  		<button class="btn btn-danger" id="btnvolver" onclick="mostrarMenu()"><i class="fa fa-caret-square-o-left"></i> Volver</button>
                  	</div>
                    


                                  <div class="panel-body table-responsive form-group col-lg-4 col-md-4 col-sm-4 col-xs-12" id="listadoregistros">

	                    			<h4>Orden de compra</h6>
	                                      <table id="tbllistadoDetalle1" class="table table-striped table-bordered table-condensed table-hover compact">
	                                        <thead>
	                                          <th>id Articulo</th>
	                                          <th>Descripcion</th>
	                                          <th>Cantidad Recibida</th>
	                                          <th>Cantidad Devuelta</th>
	                                          <th>Precio</th>
	                                        </thead>
	                                        <tbody>                            
	                                        </tbody>
	                                        <tfoot>
	                                          <th>id Articulo</th>
	                                          <th>Descripcion</th>
	                                          <th>Cantidad Recibida</th>
	                                          <th>Cantidad Devuelta</th>
	                                          <th>Precio</th>
	                                        </tfoot>
	                                      </table>
                                  </div>

                                  <div class="panel-body table-responsive form-group col-lg-4 col-md-4 col-sm-4 col-xs-12" id="listadoregistros">
                    					<h4>Factura de compra</h6>

                                      <table id="tbllistadoDetalle2" class="table table-striped table-bordered table-condensed table-hover compact">
                                        <thead>
                                          <th>id Articulo</th>
                                          <th>Descripcion</th>
                                          <th>Cantidad</th>
                                          <th>Precio</th>
                                        </thead>
                                        <tbody>                            
                                        </tbody>
                                        <tfoot>
                                          <th>id Articulo</th>
                                          <th>Descripcion</th>
                                          <th>Cantidad</th>
                                          <th>Precio</th>
                                        </tfoot>
                                      </table>
                                  </div>


                            <div class="panel-body table-responsive form-group col-lg-4 col-md-4 col-sm-4 col-xs-12" id="listadoregistros">
                              <h4>Nota de Credito</h6>

                                      <table id="tbllistadoDetalleNC" class="table table-striped table-bordered table-condensed table-hover compact">
                                        <thead>
                                          <th>id Articulo</th>
                                          <th>Descripcion</th>
                                          <th>Cantidad</th>
                                          <th>Precio</th>
                                        </thead>
                                        <tbody>                            
                                        </tbody>
                                        <tfoot>
                                          <th>id Articulo</th>
                                          <th>Descripcion</th>
                                          <th>Cantidad</th>
                                          <th>Precio</th>
                                        </tfoot>
                                      </table>
                                  </div>



                                  <div class="panel-body table-responsive form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" id="listadoregistros">
                    					<h4>Imagen Factura</h6>

                                      <table id="tbllistadoDetalle3" class="table table-striped table-bordered table-condensed table-hover compact">
                                        <thead>
                                          <th>Imagen</th>
                                        </thead>
                                        <tbody>                            
                                        </tbody>
                                        <tfoot>
                                          <th>Imagen</th>
                                        </tfoot>
                                      </table>
                                  </div>


                                  <div class="panel-body table-responsive form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" id="listadoregistros">
                    					<h4>Imagen Nota de Credito</h6>

                                      <table id="tbllistadoDetalle4" class="table table-striped table-bordered table-condensed table-hover compact">
                                        <thead>
                                          <th>Imagen</th>
                                        </thead>
                                        <tbody>                            
                                        </tbody>
                                        <tfoot>
                                          <th>Imagen</th>
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
                          <div class="modal" id="modal_detalle">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                              <div class="modal-content">
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <span>Detalle de compra:<input type="text" disabled name="detalle" id="detalle" /> </span>
                                <table id="tbllistado4" class="table table-striped table-bordered table-condensed table-hover">
                                  <thead>
                                    <th>Nro. compra</th>
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
<script type="text/javascript" src="scripts/autorizacionComprasMercaderia.js"></script>
<?php 
}
ob_end_flush();
?>


