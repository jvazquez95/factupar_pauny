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
                          <h1 class="box-title">Inventario de Stock</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <div id="cabecera">
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Proveedor:</label>
                          <select id="Persona_idPersona" name="Persona_idPersona" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Sucursal:</label>
                          <select id="Sucursal_idSucursal" name="Sucursal_idSucursal" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Deposito:</label>
                          <select id="Deposito_idDeposito" name="Deposito_idDeposito" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Marca:</label>
                          <select id="Marca_idMarca" name="Marca_idMarca" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Categoria:</label>
                          <select id="Categoria_idCategoria" name="Categoria_idCategoria" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>


                       <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          <label>Fecha Inicio</label>
                          <input type="date" class="form-control" name="fi" id="fi" value="<?php echo date("Y-m-01"); ?>">
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          <label>Fecha Fin</label>
                          <input type="date" class="form-control" name="ff" id="ff" value="<?php echo date("Y-m-d"); ?>">
                        </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Estado(*):</label>
                            <select name="estado" id="estado" class="form-control selectpicker" required="">
                               <option selected value="1">Todos</option>
                               <option value="2">Aprobados</option>
                               <option value="3">Abiertos</option>
                               <option value="4">Inactivos</option>
                            </select>
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="button" id="btnFiltrar" onclick="filtrarGenerado()"><i class="fa fa-save"></i> Filtrar</button>
                            <button class="btn btn-success" onclick="mostrarProveedor()" type="button"><i class="fa fa-arrow-circle-left"></i> Nuevo Inventario</button>
                          </div>

                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" >
                          <thead>
                          	<th>+</th>
                            <th>Opciones</th>
                            <th>Nro.</th>
                            <th>Nombre.</th>
                            <th>Deposito.</th>
                            <th>Cantidad Total.</th>
                            <th>Costo Total.</th>
                            <th>Usuario Insert.</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Cierre</th>
                            <th>Usuario Mod.</th>
                            <th>Fecha Mod</th>
                            <th>Estado</th>
                            <th>Ver detalle ---></th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>                            
                          	<th>+</th>
                            <th>Opciones</th>
                            <th>Nro.</th>
                            <th>Nombre.</th>
                            <th>Deposito.</th>
                            <th>Cantidad Total.</th>
                            <th>Costo Total.</th>
                            <th>Usuario Insert.</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Cierre</th>
                            <th>Usuario Mod.</th>
                            <th>Fecha Mod</th>
                            <th>Estado</th>
                            <th>Ver detalle ---></th>
                          </tfoot>
                        </table>
                    </div>
                  
                  </div>
                  <div id="detalle">
                    <button class="btn btn-danger" id="btnvolver" onclick="mostrarMenu()"><i class="fa fa-caret-square-o-left"></i> Volver</button>
                    <button class="btn btn-success" id="btngenerarOrdenCompra" onclick="nuevoArticulo()"><i class="fa fa-caret-square-o-left"></i> Crear Nuevo Articulo</button>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistadoDetalle" class="display compact" style="width:100%">
                          <thead>
                            <th>Detalle</th>
                            <th>Cantidad - Cantidad Contada</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Detalle</th>
                            <th>Cantidad - Cantidad Contada</th>
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
                                    <span>Nuevo Inventario</span>
                              
                              <div class="modal-content">
                                <!-- Modal body -->

                                <div class="modal-body">


                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                      <label class=" input-sm">Nombre:</label>
                                                      <input type="text" class="form-control input-sm" name="nombre" id="nombre" required>
                                                    </div>

                                                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                      <label class=" input-sm">Seleccione Proveedor:</label>
                                                        <select id="proveedorD1" name="proveedorD1" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                                    </div>

                                                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                      <label class=" input-sm">Seleccione Deposito:</label>
                                                        <select id="Deposito_idDepositoD1" name="Deposito_idDepositoD1" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                                    </div>


                                                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                      <label class=" input-sm">Seleccione Marca:</label>
                                                        <select id="Marca_idMarcaD1" name="Marca_idMarcaD1" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                                    </div>


                                                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                      <label class=" input-sm">Seleccione Categoria:</label>
                                                        <select id="Categoria_idCategoriaD1" name="Categoria_idCategoriaD1" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                                    </div>

                                					<div align="center" id="espere"></div>


                                                      <button type="button" id="btnGenerar" class="btn btn-success btn-block"  onclick="generarPedido()" ><i class="fa fa-plus-circle"></i> Generar nuevo inventario</button>
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
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>


<script type="text/javascript" src="scripts/inventario.js"></script>
<?php 
}
ob_end_flush();
?>


