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
if ($_SESSION['almacen']==1)
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
                          <h1 class="box-title">Promocion <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Descripcion</th>
                            <th>Fecha de Inicio</th>
                            <th>Fecha de Fin</th>
                            <th>Tipo de Promocion</th>
                            <th>Usuario Ins</th>
                            <th>Fecha Ins</th>
                            <th>Usuario Mod.</th>
                            <th>Fecha Mod</th>
                            <th>Opciones</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Descripcion</th>
                            <th>Fecha de Inicio</th>
                            <th>Fecha de Fin</th>
                            <th>Tipo de Promocion</th>
                            <th>Usuario Ins</th>
                            <th>Fecha Ins</th>
                            <th>Usuario Mod.</th>
                            <th>Fecha Mod</th>
                            <th>Opciones</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Descripcion:</label>
                            <input type="hidden" name="idPromocion" id="idPromocion">
                            <input type="hidden" class="form-control" name="auxSuc" id="auxSuc" disabled>
                            <input type="text" class="form-control" name="descripcion" id="descripcion" maxlength="50" placeholder="Descripcion" >
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Fecha Inicio:</label>
                            <input type="date" name="fechaInicio" id="fechaInicio" class="form-control" value="<?php echo date("Y-m-d"); ?>">
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Fecha Final:</label>
                            <input type="date" name="fechaFin" id="fechaFin" class="form-control" value="<?php echo date("Y-m-d"); ?>">
                          </div>


                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Tipo de Promocion:</label>
                            <select id="tipoPromocion" name="tipoPromocion" class="form-control selectpicker" data-live-search="true" onchange="mostrarDiv();" >
                              <option value="0">Seleccione una opcion</option>
                              <option value="promocionPorDescuento">Promocion por Descuento</option>
                              <option value="promocionPorPuntos">Promocion por Puntos</option>
                              <option value="promocionPorFormaPago">Promocion por Forma de Pago</option>
                              <option value="promocionPorTiempoLimitado">Promocion por Tiempo Limitado</option>
                              <option value="promocionPorPrecioPunto">Promocion por Monto por Puntos</option>
                              <option value="promocionPorPrecioPack">Promocion por Pack</option> 
                            </select>
                          </div>

                          <div class="row" id="divPromocionDescuento">
                                  <div class="col-md-12">

                                    <div class="box box-danger">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">Promocion por Descuentos</h3><button type="button" class="btn btn-primary btn-xs" onclick="modalFiltroPromocionPorDescuento()"><i class="fa fa-pagelines">Agregar detalle masivamente</i></button>
                                      <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                      </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                      <div class="row">
                                        <div class="col-md-12">
                                          <div class="form-group">
                                                <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                    <label class=" input-sm">Tipo de Descuento:</label>
                                                        <select id="tipoDescuento_l" name="tipoDescuento_l" class="form-control input-sm selectpicker" data-live-search="true" >
                                                          <option value="CANTIDAD">Cantidad</option>
                                                          <option value="MONTO">Monto</option>
                                                        </select>
                                                      </div>

                                                      <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <label class=" input-sm">Articulo:</label>
                                                        <select id="Articulo_idArticuloDescuento_l" 
                                                        		name="Articulo_idArticuloDescuento_l" 
                                                        		class="selectpicker selector_articulo form-control" 
                                                        		data-live-search="true" >
                                                        </select>
                                                      </div>

                                                      <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <label class=" input-sm">Sucursal(*):</label>
                                                        <select id="Sucursal_idSucursalD1" name="Sucursal_idSucursalD1"  class="form-control selectpicker" data-live-search="true" required></select> 
                                                      </div>         

                                                      <div class="form-group col-lg-1 col-md-2 col-sm-3 col-xs-12">
                                                        <label class=" input-sm">Desde:</label>
                                                        <input type="text" class="form-control input-sm" name="desde_l" id="desde_l" maxlength="256" placeholder="">
                                                      </div>

                                                      <div class="form-group col-lg-1 col-md-2 col-sm-3 col-xs-12">
                                                        <label class=" input-sm">Hasta:</label>
                                                        <input type="text" class="form-control input-sm" name="hasta_l" id="hasta_l" maxlength="256" placeholder="">
                                                      </div>


                                                      <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                        <label class=" input-sm">Descuento %.:</label>
                                                        <input type="text" class="form-control input-sm" name="descuentoPorcentualDescuento_l" id="descuentoPorcentualDescuento_l" maxlength="256" placeholder="">
                                                      </div>

                                                      <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                        <label class=" input-sm">Descuento GS:</label>
                                                        <input type="text" class="form-control input-sm" name="descuentoGsDescuento_l" id="descuentoGsDescuento_l" maxlength="256" placeholder="">
                                                      </div>


                                                      <button type="button" class="btn btn-info btn-block"  onclick="addPromociondescuento()" ><i class="fa fa-plus-circle"></i> Agregar</button>

                                                      <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                                        <table id="detalleTipoDescuento" class="table">
                                                          <thead>
                                                                <th>Opciones</th>
                                                                <th>Tipo de Descuento</th>
                                                                <th>Articulo</th>
                                                                <th>Sucursal</th>
                                                                <th>Desde</th>
                                                                <th>Hasta</th>
                                                                <th>Descuento %</th>
                                                                <th>Descuento GS</th>
                                                            </thead>
                                                            <tfoot>
                                                                <th>Opciones</th>
                                                                <th>Tipo de Descuento</th>
                                                                <th>Articulo</th>
                                                                <th>Sucursal</th>
                                                                <th>Desde</th>
                                                                <th>Hasta</th>
                                                                <th>Descuento %</th>
                                                                <th>Descuento GS</th>
                                                            </tfoot>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                      </div>
                                                    </div>
                                                    </div>
                                                    <!-- /.col -->
                                                  </div>
                                                  <!-- /.row -->
                                                </div>
                                              </div>
                                              <!-- /.box-default -->
                                          </div>
                                      </div>



                          <div class="row" id="divPromocionPuntos">
                                  <div class="col-md-12">

                                    <div class="box box-danger">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">Promocion por puntos</h3><button type="button" class="btn btn-primary btn-xs" onclick="modalFiltroPromocionPunto()"><i class="fa fa-pagelines">Agregar detalle masivamente</i></button>
                                      <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                      </div>
                                    </div>
                                    <!-- /.box-header -->
                                   <div class="box-body">
                                      <div class="row">
                                        <div class="col-md-12">
                                          <div class="form-group">
                                                <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                    <label class=" input-sm">Articulo</label>
                                                        <select id="Articulo_idArticuloPunto_l" name="Articulo_idArticuloPunto_l" class="selectpicker selector_articulo form-control"  data-live-search="true" ></select>
                                                      </div>

                                                      <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <label class=" input-sm">Sucursal(*):</label>
                                                        <select id="Sucursal_idSucursalD2" name="Sucursal_idSucursalD2"  class="form-control selectpicker" data-live-search="true" required></select> 
                                                      </div>                                                        

                                                      <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                        <label class=" input-sm">Puntos:</label>
                                                        <input type="text" class="form-control input-sm" name="cantidadPuntos_l" id="cantidadPuntos_l" maxlength="256" placeholder="">
                                                      </div>

                                                      <button type="button" class="btn btn-info btn-block"  onclick="addDetallePuntos()" ><i class="fa fa-plus-circle"></i> Agregar</button>

                                                      <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                                        <table id="detallePromocionPorPuntos" class="table">
                                                          <thead>
                                                                <th>Opciones</th>
                                                                <th>Articulo</th>
                                                                <th>Sucursal</th>
                                                                <th>Cantidad de Puntos</th>
                                                            </thead>
                                                            <tfoot>
                                                                <th>Opciones</th>
                                                                <th>Articulo</th>
                                                                <th>Sucursal</th>
                                                                <th>Cantidad de Puntos</th>
                                                            </tfoot>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                      </div>
                                                    </div>
                                                    </div>
                                                    <!-- /.col -->
                                                  </div>
                                                  <!-- /.row -->
                                                </div>
                                              </div>
                                              <!-- /.box-default -->
                                         </div>
                                          </div>

   
                          <div class="row" id="divPromocionFormaPago">
                                  <div class="col-md-12">

                                    <div class="box box-danger">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">Promocion por Forma de Pago</h3><button type="button" class="btn btn-primary btn-xs" onclick="modalFiltroPromocionFormaPago()"><i class="fa fa-pagelines">Agregar detalle masivamente</i></button>
                                      <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                      </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                      <div class="row">
                                        <div class="col-md-12">
                                          <div class="form-group">


                                                    <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label class=" input-sm">Articulo:</label>
                                                        <select id="Articulo_idArticulo_l" name="Articulo_idArticulo_l" class="form-control selectpicker selector_articulo" data-live-search="true" >
                                                        </select>
                                                      </div>


                                                    <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <label class=" input-sm">Forma de Pago:</label>
                                                        <select id="FormaPago_idFormaPago_l" name="FormaPago_idFormaPago_l" class="form-control selectpicker" data-live-search="true" >
                                                        </select>
                                                      </div>

                                                      <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <label class=" input-sm">Sucursal(*):</label>
                                                        <select id="Sucursal_idSucursalD3" name="Sucursal_idSucursalD3"  class="form-control selectpicker" data-live-search="true" required></select> 
                                                      </div>                                                        

                                                    <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <label class=" input-sm">Banco:</label>
                                                        <select id="Banco_idBanco_l" name="Banco_idBanco_l" class="form-control selectpicker" data-live-search="true" >
                                                        </select>
                                                      </div>


                                                      <div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-12">
                                                        <label class=" input-sm">Decuento Porcentual:</label>
                                                        <input type="text" class="form-control input-sm" name="descuentoPorcentual_l" id="descuentoPorcentual_l" maxlength="256" placeholder="">
                                                      </div>


                                                      <div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-12">
                                                        <label class=" input-sm">Descuento GS:</label>
                                                        <input type="text" class="form-control input-sm" name="descuentoGs_l" id="descuentoGs_l" maxlength="256" placeholder="">
                                                      </div>

                                                      <button type="button" class="btn btn-info btn-block" onclick="addDetallePromocionFormaPago();" ><i class="fa fa-plus-circle"></i> Agregar</button>

                                                      <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                                        <table id="detallePromocionFormaPago" class="table">
                                                          <thead>
                                                                <th>Opciones</th>
                                                                <th>Articulo</th>
                                                                <th>Sucursal</th>
                                                                <th>Forma de Pago</th>
                                                                <th>Banco</th>
                                                                <th>Descuento %</th>
                                                                <th>Descuento GS</th>
                                                            </thead>
                                                            <tfoot>
                                                                <th>Opciones</th>
                                                                <th>Articulo</th>
                                                                <th>Sucursal</th>
                                                                <th>Grupo Articulo</th>
                                                                <th>Forma de Pago</th>
                                                                <th>Descuento %</th>
                                                                <th>Descuento GS</th>
                                                            </tfoot>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                      </div>
                                                    </div>
                                                    </div>
                                                    <!-- /.col -->
                                                  </div>
                                                  <!-- /.row -->
                                                </div>
                                              </div>
                                              <!-- /.box-default -->
                                          </div>
                            </div>
                      

                          <div class="row" id="divPrecioPorTiempoLimitado">
                                  <div class="col-md-12">

                                    <div class="box box-danger">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">Precio por tiempo limitado</h3><button type="button" class="btn btn-primary btn-xs" onclick="modalFiltroPrecioPorTiempoLimitado()"><i class="fa fa-pagelines">Agregar detalle masivamente</i></button>
                                      <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                      </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                      <div class="row">
                                        <div class="col-md-12">
                                          <div class="form-group">


                                                    <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label class=" input-sm">Articulo:</label>
                                                        <select id="Articulo_idArticuloDescuentoPrecioTiempoLimitado_l" name="Articulo_idArticuloDescuentoPrecioTiempoLimitado_l" class="selectpicker selector_articulo form-control"  data-live-search="true" >
                                                        </select>
                                                      </div>

                                                      <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <label class=" input-sm">Sucursal(*):</label>
                                                        <select id="Sucursal_idSucursalD4" name="Sucursal_idSucursalD4"  class="form-control selectpicker" data-live-search="true" required></select> 
                                                      </div>        

                                                      <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                        <label class=" input-sm">Precio GS:</label>
                                                        <input type="text" class="form-control input-sm" name="precioGs_l" id="precioGs_l" maxlength="256" placeholder="">
                                                      </div>


                                                      <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                        <label class=" input-sm">Venta Maxima:</label>
                                                        <input type="text" class="form-control input-sm" name="ventaMaxima_l" id="ventaMaxima_l" maxlength="256" placeholder="">
                                                      </div>

                                                      <button type="button" class="btn btn-info btn-block" onclick="addDetallePrecioPorTiempoLimitado();" ><i class="fa fa-plus-circle"></i> Agregar</button>

                                                      <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                                        <table id="detallePrecioTiempoLimitado" class="table ">
                                                          <thead>
                                                                <th>Opciones</th>
                                                                <th>Articulo</th>
                                                                <th>Sucursal</th>
                                                                <th>Precio Gs</th>
                                                                <th>Venta Maxima</th>
                                                            </thead>
                                                            <tfoot>
                                                                <th>Opciones</th>
                                                                <th>Articulo</th>
                                                                <th>Sucursal</th>
                                                                <th>Precio Gs</th>
                                                                <th>Venta Maxima</th>
                                                            </tfoot>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                      </div>
                                                    </div>
                                                    </div>
                                                    <!-- /.col -->
                                                  </div>
                                                  <!-- /.row -->
                                                </div>
                                              </div>
                                              <!-- /.box-default -->
                                          </div>
                            </div>
               
                          <div class="row" id="divPrecioPorPuntos">
                                  <div class="col-md-12">

                                    <div class="box box-danger">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">Precio por tiempo limitado</h3><button type="button" class="btn btn-primary btn-xs" onclick="modalFiltroPrecioPorPunto()"><i class="fa fa-pagelines">Agregar detalle masivamente</i></button>
                                      <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                      </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                      <div class="row">
                                        <div class="col-md-12">
                                          <div class="form-group">


                                                    <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label class=" input-sm">Articulo:</label>
                                                        <select id="Articulo_idArticuloPrecioPuntos_l" name="Articulo_idArticuloPrecioPuntos_l" class="selectpicker selector_articulo form-control"  data-live-search="true" >
                                                        </select>
                                                      </div>

                                                      <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <label class=" input-sm">Sucursal(*):</label>
                                                        <select id="Sucursal_idSucursalD5" name="Sucursal_idSucursalD5"  class="form-control selectpicker" data-live-search="true" required></select> 
                                                      </div>        

                                                      <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                        <label class=" input-sm">Precio GS:</label>
                                                        <input type="text" class="form-control input-sm" name="precioGsPrecio_l" id="precioGsPrecio_l" maxlength="256" placeholder="">
                                                      </div>


                                                      <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                        <label class=" input-sm">Puntos:</label>
                                                        <input type="text" class="form-control input-sm" name="puntos_l" id="puntos_l" maxlength="256" placeholder="">
                                                      </div>

                                                      <button type="button" class="btn btn-info btn-block" onclick="addDetallePrecioPorPunto();" ><i class="fa fa-plus-circle"></i> Agregar</button>

                                                      <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                                        <table id="detallesPrecioPorPunto" class="table ">
                                                          <thead>
                                                                <th>Opciones</th>
                                                                <th>Articulo</th>
                                                                <th>Sucursal</th>
                                                                <th>Precio Gs</th>
                                                                <th>Puntos</th>
                                                            </thead>
                                                            <tfoot>
                                                                <th>Opciones</th>
                                                                <th>Articulo</th>
                                                                <th>Sucursal</th>
                                                                <th>Precio Gs</th>
                                                                <th>Puntos</th>
                                                            </tfoot>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                      </div>
                                                    </div>
                                                    </div>
                                                    <!-- /.col -->
                                                  </div>
                                                  <!-- /.row -->
                                                </div>
                                              </div>
                                              <!-- /.box-default -->
                                          </div>
                            </div>               

                          <div class="row" id="divPrecioPorPack">
                                  <div class="col-md-12">

                                    <div class="box box-danger">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">Precio por pack</h3><button type="button" class="btn btn-primary btn-xs" onclick="modalFiltroPrecioPorPack()"><i class="fa fa-pagelines">Agregar detalle masivamente</i></button>
                                      <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                      </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                      <div class="row">
                                        <div class="col-md-12">
                                          <div class="form-group">


                                                    <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label class=" input-sm">Articulo:</label>
                                                        <select id="Articulo_idArticuloPrecioPack_l" name="Articulo_idArticuloPrecioPack_l" class="selectpicker selector_articulo form-control"  data-live-search="true" >
                                                        </select>
                                                      </div>

                                                      <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <label class=" input-sm">Sucursal(*):</label>
                                                        <select id="Sucursal_idSucursalD6" name="Sucursal_idSucursalD6"  class="form-control selectpicker" data-live-search="true" required></select> 
                                                      </div>        

                                                      <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                        <label class=" input-sm">Precio GS:</label>
                                                        <input type="text" class="form-control input-sm" name="precioGsPrecio_l6" id="precioGsPrecio_l6" maxlength="256" placeholder="">
                                                      </div>


                                                      <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                        <label class=" input-sm">Cantidad:</label>
                                                        <input type="text" class="form-control input-sm" name="puntos_l6" id="puntos_l6" maxlength="256" placeholder="">
                                                      </div>


                                                      <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                        <label class=" input-sm">Porcentaje:</label>
                                                        <input type="text" class="form-control input-sm" name="porcentaje_l6" id="porcentaje_l6" maxlength="256" placeholder="">
                                                      </div> 

                                                      <button type="button" class="btn btn-info btn-block" onclick="addDetallePrecioPorPack();" ><i class="fa fa-plus-circle"></i> Agregar</button>

                                                      <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                                        <table id="detallesPrecioPorPack" class="table ">
                                                          <thead>
                                                                <th>Opciones</th>
                                                                <th>Articulo</th>
                                                                <th>Sucursal</th>
                                                                <th>Precio Gs</th>
                                                                <th>Cantidad</th>
                                                                <th>Porcentaje</th>
                                                            </thead>
                                                            <tfoot>
                                                                <th>Opciones</th>
                                                                <th>Articulo</th>
                                                                <th>Sucursal</th>
                                                                <th>Precio Gs</th>
                                                                <th>Cantidad</th>
                                                                <th>Porcentaje</th>  
                                                            </tfoot>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                      </div>
                                                    </div>
                                                    </div>
                                                    <!-- /.col -->
                                                  </div>
                                                  <!-- /.row -->
                                                </div>
                                              </div>
                                              <!-- /.box-default -->
                                          </div>
                            </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
      </section><!-- /.content -->

  <!--Fin-Contenido-->


                    <div class="container">
                           <style>
                          </style>
                          <!-- The Modal -->
                          <div class="modal" id="modalFiltroPromocionPorDescuento">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <span>Filtro para detalle</span>
                              
                              <div class="modal-content">
                                <!-- Modal body -->

                                <div class="modal-body">
                                				<div class="row">
                                                 	<div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                    	<label class=" input-sm">Proveedor:</label>
                                                        <select id="proveedorD1" name="proveedorD1" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                                    </div>

                                                	
                                                	<div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                    	<label class=" input-sm">Marca:</label>
                                                        <select id="marcaD1" name="marcaD1" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                                    </div>

                                                	<div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                    	<label class=" input-sm">Grupo:</label>
                                                        <select id="grupoD1" name="grupoD1" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                                    </div>


                                                	<div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                    	<label class=" input-sm">Categoria:</label>
                                                        <select id="categoriaD1" name="categoriaD1" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                                    </div>

                                                  <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                      <label class=" input-sm">Sucursal:</label>
                                                        <select id="sucursalD1" name="sucursalD1" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                                    </div>

                                                 </div>
                                				<div class="row">
                                                    
                                                	<div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                    	<label class=" input-sm">Tipo de Descuento:</label>
                                                        <select id="tipoDescuento_lD1" name="tipoDescuento_lD1" class="form-control input-sm selectpicker" data-live-search="true" >
                                                          <option value="CANTIDAD">Cantidad</option>
                                                          <option value="MONTO">Monto</option>
                                                        </select>          
                                                      </div>

                                                      <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                        <label class=" input-sm">Desde:</label>
                                                        <input type="text" class="form-control input-sm" name="desde_lD1" id="desde_lD1" maxlength="256" placeholder="">
                                                      </div>

                                                      <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                        <label class=" input-sm">Hasta:</label>
                                                        <input type="text" class="form-control input-sm" name="hasta_lD1" id="hasta_lD1" maxlength="256" placeholder="">
                                                      </div>


                                                      <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                        <label class=" input-sm">Descuento %.:</label>
                                                        <input type="text" class="form-control input-sm" name="descuentoPorcentualDescuento_lD1" id="descuentoPorcentualDescuento_lD1" maxlength="256" placeholder="">
                                                      </div>

                                                      <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                        <label class=" input-sm">Descuento GS:</label>
                                                        <input type="text" class="form-control input-sm" name="descuentoGsDescuento_lD1" id="descuentoGsDescuento_lD1" maxlength="256" placeholder="">
                                                      </div>

                                                     </div>
 

                                                      <button type="button" class="btn btn-success btn-block"  onclick="filtrarDetallePromocionPorDescuento()" ><i class="fa fa-plus-circle"></i> Generar</button>
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
                          <div class="modal" id="modalFiltroPromocionPunto">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <span>Filtro para detalle</span>
                              
                              <div class="modal-content">
                                <!-- Modal body -->

                                <div class="modal-body">
                                				<div class="row">
                                                 	<div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                    	<label class=" input-sm">Proveedor:</label>
                                                        <select id="proveedorD2" name="proveedorD2" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                                    </div>

                                                	
                                                	<div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                    	<label class=" input-sm">Marca:</label>
                                                        <select id="marcaD2" name="marcaD2" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                                    </div>

                                                	<div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                    	<label class=" input-sm">Grupo:</label>
                                                        <select id="grupoD2" name="grupoD2" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                                    </div>


                                                	<div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                    	<label class=" input-sm">Categoria:</label>
                                                        <select id="categoriaD2" name="categoriaD2" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                                    </div>
                                                 </div>
                                				<div class="row">

                                                      <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                        <label class=" input-sm">Puntos:</label>
                                                        <input type="text" class="form-control input-sm" name="cantidadPuntos_lD2" id="cantidadPuntos_lD2" maxlength="256" placeholder="">
                                                      </div>
                                                     </div>

                                                      <button type="button" class="btn btn-success btn-block"  onclick="filtrarDetallePromocionPunto()" ><i class="fa fa-plus-circle"></i> Generar</button>
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
                          <div class="modal" id="modalFiltroPromocionFormaPago">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <span>Filtro para detalle</span>
                              
                              <div class="modal-content">
                                <!-- Modal body -->

                                <div class="modal-body">
                                				<div class="row">
                                                 	<div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                    	<label class=" input-sm">Proveedor:</label>
                                                        <select id="proveedorD3" name="proveedorD3" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                                    </div>

                                                	
                                                	<div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                    	<label class=" input-sm">Marca:</label>
                                                        <select id="marcaD3" name="marcaD3" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                                    </div>

                                                	<div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                    	<label class=" input-sm">Grupo:</label>
                                                        <select id="grupoD3" name="grupoD3" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                                    </div>


                                                	<div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                    	<label class=" input-sm">Categoria:</label>
                                                        <select id="categoriaD3" name="categoriaD3" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                                    </div>
                                                 </div>
                                				<div class="row">


                                                    <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <label class=" input-sm">Forma de Pago:</label>
                                                        <select id="FormaPago_idFormaPago_lD3" name="FormaPago_idFormaPago_lD3" class="form-control selectpicker" data-live-search="true" >
                                                        </select>
                                                      </div>

                                                    <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <label class=" input-sm">Banco:</label>
                                                        <select id="Banco_idBanco_lD3" name="Banco_idBanco_lD3" class="form-control selectpicker" data-live-search="true" >
                                                        </select>
                                                      </div>


                                                      <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <label class=" input-sm">Decuento Porcentual:</label>
                                                        <input type="text" class="form-control input-sm" name="descuentoPorcentual_lD3" id="descuentoPorcentual_lD3" maxlength="256" placeholder="">
                                                      </div>


                                                      <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <label class=" input-sm">Descuento GS:</label>
                                                        <input type="text" class="form-control input-sm" name="descuentoGs_lD3" id="descuentoGs_lD3" maxlength="256" placeholder="">
                                                      </div>


                                                </div>

                                                      <button type="button" class="btn btn-success btn-block"  onclick="filtrarDetallePromocionFormaPago()" ><i class="fa fa-plus-circle"></i> Generar</button>
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
                          <div class="modal" id="modalFiltroPrecioPorTiempoLimitado">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <span>Filtro para detalle</span>
                              
                              <div class="modal-content">
                                <!-- Modal body -->

                                <div class="modal-body">
                                				<div class="row">
                                             	<div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                	<label class=" input-sm">Proveedor:</label>
                                                    <select id="proveedorD4" name="proveedorD4" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                              </div>

                                            	
                                            	<div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                	<label class=" input-sm">Marca:</label>
                                                    <select id="marcaD4" name="marcaD4" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                              </div>

                                            	<div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                	<label class=" input-sm">Grupo:</label>
                                                    <select id="grupoD4" name="grupoD4" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                              </div>


                                            	<div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                	<label class=" input-sm">Categoria:</label>
                                                    <select id="categoriaD4" name="categoriaD4" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                              </div>

                                              <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                  <label class=" input-sm">Precio GS:</label>
                                                  <input type="number" class="form-control input-sm" name="precioD4" id="precioD4"   placeholder="">
                                              </div>


                                              <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                  <label class=" input-sm">Venta Maxima:</label> 
                                                  <input type="number" class="form-control input-sm" name="ventamaxD4" id="ventamaxD4" placeholder="">
                                              </div>
                                          </div>

                                				  <div class="row">
      
                                          </div>

                                          <button type="button" class="btn btn-success btn-block"  onclick="filtrarDetallePrecioPorTiempoLimitado()" ><i class="fa fa-plus-circle"></i> Generar</button>
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
                          <div class="modal" id="modalFiltroPrecioPorPunto">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <span>Filtro para detalle</span>
                              
                              <div class="modal-content">
                                <!-- Modal body -->

                                <div class="modal-body">
                                				<div class="row">
                                                 	<div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                    	<label class=" input-sm">Proveedor:</label>
                                                        <select id="proveedorD5" name="proveedorD5" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                                    </div>

                                                	
                                                	<div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                    	<label class=" input-sm">Marca:</label>
                                                        <select id="marcaD5" name="marcaD5" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                                    </div>

                                                	<div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                    	<label class=" input-sm">Grupo:</label>
                                                        <select id="grupoD5" name="grupoD5" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                                    </div>


                                                	<div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                    	<label class=" input-sm">Categoria:</label>
                                                        <select id="categoriaD5" name="categoriaD5" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                                    </div>
                                                 </div>
                                				<div class="row">


                                                      <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                        <label class=" input-sm">Precio GS:</label>
                                                        <input type="text" class="form-control input-sm" name="precioGsPrecio_lD5" id="precioGsPrecio_lD5" maxlength="256" placeholder="">
                                                      </div>


                                                      <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                        <label class=" input-sm">Puntos:</label>
                                                        <input type="text" class="form-control input-sm" name="puntos_lD5" id="puntos_lD5" maxlength="256" placeholder="">
                                                      </div>


                                                </div>

                                                      <button type="button" class="btn btn-success btn-block"  onclick="filtrarDetallePromocionPrecioPunto()" ><i class="fa fa-plus-circle"></i> Generar</button>
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
                          <div class="modal" id="modalFiltroPrecioPorPack">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <span>Filtro para detalle</span>
                              
                              <div class="modal-content">
                                <!-- Modal body -->

                                <div class="modal-body">
                                        <div class="row">
                                                  <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                      <label class=" input-sm">Proveedor:</label>
                                                        <select id="proveedorD6" name="proveedorD6" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                                    </div>

                                                  
                                                  <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                      <label class=" input-sm">Marca:</label>
                                                        <select id="marcaD6" name="marcaD6" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                                    </div>

                                                  <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                      <label class=" input-sm">Grupo:</label>
                                                        <select id="grupoD6" name="grupoD6" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                                    </div>


                                                  <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                      <label class=" input-sm">Categoria:</label>
                                                        <select id="categoriaD6" name="categoriaD6" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                                    </div>
                                                 </div>
                                                  <div class="row">


                                                      <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                        <label class=" input-sm">Precio GS:</label>
                                                        <input type="text" class="form-control input-sm" name="precioGsPrecio_lD6" id="precioGsPrecio_lD6" maxlength="256" placeholder="">
                                                      </div>


                                                      <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                        <label class=" input-sm">Puntos:</label>
                                                        <input type="text" class="form-control input-sm" name="puntos_lD6" id="puntos_lD6" maxlength="256" placeholder="">
                                                      </div>


                                                </div>

                                                      <button type="button" class="btn btn-success btn-block"  onclick="filtrarDetallePrecioPack()" ><i class="fa fa-plus-circle"></i> Generar</button>
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

<script type="text/javascript">

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
	    }); 
	}); 
 

</script>

<script type="text/javascript" src="scripts/promocion.js"></script>
<?php 
}
ob_end_flush();
?>


