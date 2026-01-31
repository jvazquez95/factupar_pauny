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

        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Artículo <button class="btn btn-success btn-xs" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button> <button class="btn btn-success btn-xs" id="btnagregar" onclick="crud('marca');"><i class="fa fa-plus-circle"></i> Nueva Marca</button> <button class="btn btn-success btn-xs" id="btnagregar" onclick="crud('categoria');"><i class="fa fa-plus-circle"></i> Nueva Categoria</button> <button class="btn btn-success btn-xs" id="btnagregar" onclick="crud('grupoArticulo');"><i class="fa fa-plus-circle"></i> Nuevo Grupo</button> <button class="btn btn-success btn-xs" id="btnagregar" onclick="crud('persona');"><i class="fa fa-plus-circle"></i> Nuevo Proveedor</button> <a href="../reportes/rptarticulos.php" target="_blank"><button class="btn btn-info btn-xs">Reporte</button></a></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>

                <div id="buscador" class="form-group col-lg-3 col-md-3 col-sm-4 col-xs-12">
                        <label>Buscar articulo:</label>
                        <input type="text" onblur="listarOriginal();" class="form-control" name="buscar_art" id="buscar_art" >
                        <button id="btnNada" type="button" class="btn btn-primary btn-block btn-xs"> <span class="fa fa-refresh"></span></button>
                  </div>


                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-sm table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Id - PK</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Proveedor</th>
                            <th>Marca</th>
                            <th>Grupo de Articulo</th>
                            <th>Codigo de barras</th>
                            <th>Codigo Interno</th>
                            <th>Codigo Sap</th>
                            <th>Tipo</th>
                            <th>Unidad de Compra</th>
                            <th>Unidad de Venta</th>
                            <th>Comision Gs.</th>
                            <th>Comision %</th>
                            <th>Impuesto</th>
                            <th>Precio venta Promedio</th>
                            <th>Stock</th>
                            <th>usuario que cargo</th>
                            <th>Imagen</th>
                            <th>Descontinuado</th>
                            <th>Estado</th>
                          </thead>

                          <tfoot>
                            <th>Opciones</th>
                            <th>Id - PK</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Proveedor</th>
                            <th>Marca</th>
                            <th>Grupo de Articulo</th>
                            <th>Codigo de barras</th>
                            <th>Codigo Interno</th>
                            <th>Codigo Sap</th>
                            <th>Tipo</th>
                            <th>Unidad de Compra</th>
                            <th>Unidad de Venta</th>
                            <th>Comision Gs.</th>
                            <th>Comision %</th>
                            <th>Impuesto</th>
                            <th>Precio venta</th>
                            <th>Stock</th>
                            <th>usuario que cargo</th>
                            <th>Imagen</th>
                            <th>Descontinuado</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label class=" input-sm">Nombre(*):</label>
                            <input type="hidden" name="idArticulo" id="idArticulo">
                            <input type="hidden" onkeyup="separadorMilesOnKey(event, this);" class="form-control input-sm" name="precioVenta" id="precioVenta" value="0">
                            <input type="text" class="form-control input-sm" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label class=" input-sm">Descripcion:</label>
                            <input type="text" class="form-control input-sm" name="descripcion" id="descripcion" maxlength="100" placeholder="Descripcion" required>
                          </div>


                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label class=" input-sm">Proveedor:</label>
                            <select id="Persona_idPersona" name="Persona_idPersona" class="form-control input-sm selectpicker" data-live-search="true" required></select>
                          </div>


                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label class=" input-sm">Marca:</label>
                            <select id="Marca_idMarca" name="Marca_idMarca" class="form-control input-sm selectpicker" data-live-search="true" required></select>
                          </div>


                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label class=" input-sm">Grupo:</label>
                            <select id="GrupoArticulo_idGrupoArticulo" name="GrupoArticulo_idGrupoArticulo" class="form-control input-sm selectpicker" data-live-search="true" required></select>
                          </div>


<!--                           <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <label class=" input-sm">Codigo de barras::</label> <button class="btn btn-success btn-xs" type="button " onclick="generarbarcode()">Generar</button>
                            <button class="btn btn-info btn-xs" type="button" onclick="imprimir()">Imprimir</button>
                            <input type="text" class="form-control input-sm" name="codigoBarra" id="codigoBarra" placeholder="Código Barras">
                           
                            <div id="print">
                              <svg id="barcode"></svg>
                            </div>
                          </div> -->

                          <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <label class=" input-sm">Codigo interno:</label>
                            <input type="text" class="form-control input-sm" name="codigo" id="codigo" maxlength="100" placeholder="Codigo" onblur="validarCodigo(this)" required>
                          </div>

                          <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <label class=" input-sm">Codigo Sap:</label>
                            <input type="text" class="form-control input-sm" name="codigoAlternativo" id="codigoAlternativo" maxlength="256" placeholder="Codigo alternativo">
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                            <label class=" input-sm">Categoria:</label>
                            <select id="Categoria_idCategoria" name="Categoria_idCategoria" class="form-control selectpicker  input-sm" data-live-search="true" required></select>
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label class=" input-sm">Sub-Categoria:</label>
                            <select id="Categoria_idCategoriaD" name="Categoria_idCategoriaD" class="form-control selectpicker  input-sm" data-live-search="true" required></select>
                          </div>

                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label class=" input-sm">Tipo:</label>
                            <select id="tipoArticulo" name="tipoArticulo" onchange="evaluar();" class="form-control input-sm selectpicker" data-live-search="true" required>
                              <option value="PRODUCTO" selected>Producto</option>
                              <option value="PRODUCTO_INTERNO">Producto Interno</option>
                              <option value="SERVICIO">Servicio</option>
                            </select>
                          </div>

                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label class=" input-sm">Cuenta Contable - Gasto:</label>
                            <select id="CuentaContable_idCuentaContable" name="CuentaContable_idCuentaContable" class="form-control input-sm selectpicker" data-live-search="true" required></select>
                          </div>

                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label class=" input-sm">Tipo de Impuestos:</label>
                            <select id="TipoImpuesto_idTipoImpuesto" name="TipoImpuesto_idTipoImpuesto" class="form-control input-sm selectpicker" data-live-search="true" required></select>
                          </div>

<!--                       <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                            <label class=" input-sm">Unidad de medida - Compra:</label>
                            <select id="Unidad_idUnidadCompra" name="Unidad_idUnidadCompra" class="form-control input-sm selectpicker" data-live-search="true" required></select>
                          </div>

                          <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                            <label class=" input-sm">Unidad de medida - Venta:</label>
                            <select id="Unidad_idUnidad" name="Unidad_idUnidad" class="form-control input-sm selectpicker" data-live-search="true" required></select>
                          </div> -->

<div id = "cosas" name "cosas">
                          <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                            <label class=" input-sm" >Cantidad Palet:</label>
                            <input type="number" value="1" class="form-control input-sm" name="cantidadPalet" id="cantidadPalet" maxlength="256" placeholder="Cantidad por palet.">
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                            <label class=" input-sm">Cantidad Piso:</label>
                            <input type="number" value="1" class="form-control input-sm" name="cantidadPiso" id="cantidadPiso" maxlength="256" placeholder="Cantidad por piso">
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                            <label class=" input-sm">Cantidad Caja:</label>
                            <input type="number" value="1" class="form-control input-sm" name="cantidadCaja" id="cantidadCaja" maxlength="256">
                          </div>


                          <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                            <label class=" input-sm">Peso Bruto:</label>
                            <input type="text" value="0" class="form-control input-sm" name="pesoBruto" id="pesoBruto" >
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label class=" input-sm">Peso Liquido:</label>
                            <input type="text" value="0" class="form-control input-sm" name="pesoLiquido" id="pesoLiquido" maxlength="256">
                          </div>


                          <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                            <label class=" input-sm">Costo:</label>
                            <input type="text" onkeyup="separadorMilesOnKey(event, this);" class="form-control input-sm" name="costo" id="costo" maxlength="256" placeholder="Costo." readonly>
                          </div>


<!--                           <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                            <label class=" input-sm">Comision Servicio Tecnico %:</label>
                            <input type="text" onkeyup="separadorMilesOnKey(event, this);" class="form-control input-sm" name="comisiongs" id="comisiongs" maxlength="256" placeholder="Comision servicio Tecnico %.">
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label class=" input-sm">Comision Venta %:</label>
                            <input type="text" class="form-control input-sm" name="comisionp" id="comisionp" maxlength="256" placeholder="Comisio por venta %">
                          </div> -->



                          <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                            <label class=" input-sm">Regimen de Turismo:</label>
                            <select id="regimenTurismo" name="regimenTurismo" class="form-control input-sm selectpicker" data-live-search="true" required>
                              <option value="0" selected>No</option>
                              <option value="1">Si</option>
                            </select>
                          </div>




                          <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                            <label class=" input-sm">Balanza:</label>
                            <select id="balanza" name="balanza" class="form-control input-sm selectpicker" data-live-search="true" required>
                              <option value="0" selected>No</option>
                              <option value="1">Si</option>
                            </select>
                          </div>


                          <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                            <label class=" input-sm">Ventas por Kl:</label>
                            <select id="ventasKl" name="ventasKl" class="form-control input-sm selectpicker" data-live-search="true" required>
                              <option value="0" selected>No</option>
                              <option value="1">Si</option>
                            </select>
                          </div>

              </div>

						  <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Imagen:</label>
                            <input type="file" onchange="imagenTest(this);" class="form-control" name="imagen" id="imagen">
                            <input type="hidden" name="imagenactual" id="imagenactual">
                            <img src="" width="150px" height="120px" id="imagenmuestra">
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label class=" input-sm">Usuario insercion:</label>
                            <input type="hidden" class="form-control input-sm" name="usuarioInsercion" id="usuarioInsercion" maxlength="256">
                            <input type="text" class="form-control input-sm" name="usuarioInserscion1" id="usuarioInsercion1" maxlength="256" disabled value="<?php echo $_SESSION['login']; ?>">
                          </div>



                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                               
                                  <div class="col-md-12">

                                    <div class="box box-danger">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">Codigo de Barras</h3><button type="button" class="btn btn-primary btn-xs" onclick="crud('unidad')"><i class="fa fa-pagelines">Nueva unidad de medida</i></button>
                                      <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                      </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                      <div class="row">
                                        <div class="col-md-12">
                                          <div class="form-group">
                                                 <div class="col">


												 <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
						                            <label class=" input-sm">Unidades de Medidas y Codigos de Barras:</label>
						                            <select id="Unidad_idUnidad_l" name="Unidad_idUnidad_l" class="form-control input-sm selectpicker" data-live-search="true" required></select>
						                          </div>


                                                  <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                    <label class=" input-sm">Descripcion:</label>
                                                    <input type="text" class="form-control input-sm" name="descripcionCodigoBarra_l" id="descripcionCodigoBarra_l" maxlength="256" placeholder="Descripcion codigo">
                                                  </div>

                                                  <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                    <label class=" input-sm">Codigo de Barras:</label>
                                                    <input type="text" class="form-control input-sm" name="codigoBarra_l" onblur="validarCodigoBarra(this)"  id="codigoBarra_l" maxlength="256" placeholder="Codigo de Barras">
                                                  </div>

                                                  <button type="button" class="btn btn-info btn-block"  onclick="addDetalleCodigoBarra()" ><i class="fa fa-plus-circle"></i> Agregar</button>

                                                </div>
                                                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 table-responsive">
                                                      <table id="detalleCodigoBarra" class="table">
                                                        <thead >
                                                              <th>Opciones</th>
                                                              <th>Unidad de Medida</th>
                                                              <th>Cantidad</th>
                                                              <th>Descripcion</th>
                                                              <th>Codigo de Barras</th>
                                                          </thead>
                                                          <tfoot>
                                                              <th></th>
                                                              <th></th>
                                                              <th></th>
                                                              <th></th>
                                                              <th></th>
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
                               
                                  <div class="col-md-12">

                                    <div class="box box-danger">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">Lista de Precio</h3><button type="button" class="btn btn-primary btn-xs" onclick="crud('sucursal')"><i class="fa fa-pagelines">Nueva Sucursal</i></button><button type="button" class="btn btn-primary btn-xs" onclick="crud('grupoPersona')"><i class="fa fa-pagelines">Nuevo Grupo Persona </i></button>
                                      <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                      </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                      <div class="row">
                                        <div class="col-md-12">
                                          <div class="form-group">
                                                 <div class="col">


                                                  <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                    <label class=" input-sm">Sucursal:</label>
                                                    <select id="Sucursal_idSucursal_l" name="Sucursal_idSucursal_;" class="form-control input-sm selectpicker" data-live-search="true" required></select>
                                                  </div>


                                                  <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                    <label class=" input-sm">Grupo Persona:</label>
                                                    <select id="GrupoPersona_idGrupoPersona_l" name="GrupoPersona_idGrupoPersona_l" class="form-control input-sm selectpicker" data-live-search="true" required><option>Particular</option><option>Laboral</option></select>
                                                  </div>

                                                  <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                    <label class=" input-sm">Margen:</label>
                                                    <input type="number" onblur="calcularPrecioVenta();" class="form-control input-sm" name="margen_l" id="margen_l" maxlength="256" placeholder="">
                                                  </div>

                                                  <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                    <label class=" input-sm">Precio Venta:</label>
                                                    <input type="number" onblur="calcularMargen();" class="form-control input-sm" name="precio_l" id="precio_l" maxlength="256" placeholder="">
                                                  </div>

                                                  <button type="button" class="btn btn-info btn-block"  onclick="addDetallePrecio()" ><i class="fa fa-plus-circle"></i> Agregar</button>

                                                </div>
                                                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 table-responsive">
                                                      <table id="detalle" class="table">
                                                        <thead >
                                                              <th>Opciones</th>
                                                              <th>Grupo Persona</th>
                                                              <th>Sucursal</th>
                                                              <th>Margen</th>
                                                              <th>Precio venta</th>
                                                          </thead>
                                                          <tfoot>
                                                              <th></th>
                                                              <th></th>
                                                              <th></th>
                                                              <th></th>
                                                              <th></th>
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
                               
                                  <div class="col-md-12">

                                    <div class="box box-danger">
                                    <div class="box-header with-border"> 
                                      <h3 class="box-title">Lista de Materia prima</h3><button type="button" class="btn btn-primary btn-xs" onclick="crud('sucursal')"><i class="fa fa-pagelines">Nuevo articulo</i></button>
                                      <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                      </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                      <div class="row">
                                        <div class="col-md-12">
                                          <div class="form-group">
                                                 <div class="col">


                                                  <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                    <label class=" input-sm">Articulo:</label>
                                                    <select id="Articulo_idArticulo_lp" name="Articulo_idArticulo_lp" class="form-control input-sm selectpicker" data-live-search="true" ></select>
                                                  </div>


                                                  <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                    <label class=" input-sm">Canje:</label>
                                                    <select id="Canje_l" name="Canje_l" class="form-control input-sm selectpicker" data-live-search="true" > 
                                                      <option>Devuelve</option>
                                                      <option>Sin Devolucion</option>
                                                    </select>
                                                  </div>

                                                  <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                    <label class=" input-sm">Cantidad:</label>
                                                    <input type="number" class="form-control input-sm" name="cantidad_l" id="cantidad_l" maxlength="256" placeholder="">
                                                  </div>
                                                   <!--<div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                    <label class=" input-sm">Compra:</label>
                                                    <select id="Canje_l" name="Canje_l" class="form-control input-sm selectpicker" data-live-search="true" > 
                                                      <option>SI</option>
                                                      <option>NO</option>
                                                    </select>
                                                  </div>
                                                  <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                    <label class=" input-sm">Venta:</label>
                                                    <select id="Canje_l" name="Canje_l" class="form-control input-sm selectpicker" data-live-search="true" > 
                                                      <option>SI</option>
                                                      <option>NO</option>
                                                    </select>
                                                  </div>-->
                                                  <button type="button" class="btn btn-info btn-block"  onclick="addDetalleMateriaPrima()" ><i class="fa fa-plus-circle"></i> Agregar</button>

                                                </div>
                                                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 table-responsive">
                                                      <table id="detalleMateriaPrima" class="table">
                                                        <thead >
                                                              <th>Opciones</th>
                                                              <th>Articulo</th>
                                                              <th>Canje</th>
                                                              <th>Cantidad</th>
                                                              <!--<th>Compra</th>
                                                              <th>Venta</th>-->
                                                          </thead>
                                                          <tfoot>
                                                              <th></th>
                                                              <th></th>
                                                              <th></th>
                                                              <th></th>
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
                                                          

<?php  ?>



                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary btn-xs" type="submit" name="btnGuardar" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            <button class="btn btn-danger btn-xs" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->

  <!-- Modal -->
                        <div class="container">
                           <style>
                          </style>
                          <!-- The Modal -->
                          <div class="modal fade" id="modal_detalle">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                              <div class="modal-content">
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <span>Detalle de Paquete:<input type="text" disabled name="detalle" id="detalle" /> </span>
                                <table id="tbllistado4" class="table table-striped table-bordered table-condensed table-hover">
                              <thead style="background-color:#A9D0F5">
                                    <th>Nombre del servicio</th>
                                    <th>Cantidad</th>
                                    <th>Cantidad - EDITAR</th>
                                    <th>Comision Gs</th>
                                    <th>Comision Gs- EDITAR</th>
                                    <th>Comision %.</th>
                                    <th>Comision %. - EDITAR</th>
                                </thead>
                                <tfoot>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
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

                          <!-- Modal -->
						  <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
						    <div class="modal-dialog" style="width: 65% !important;">
						      <div class="modal-content">
						        <div class="modal-header">
						          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						          <h4 class="modal-title">Seleccione para agregar paquete</h4>
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
                            <th>Descripcion</th>
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
  <!-- Fin modal -->
<?php
}
else
{
  require 'noacceso.php';
}
require 'footer.php';
?>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="../public/js/JsBarcode.all.min.js"></script>
<script type="text/javascript" src="../public/js/jquery.PrintArea.js"></script>
<script type="text/javascript" src="scripts/articulo.js"></script>
<script type="text/javascript" src="scripts/generales.js"></script>
<?php 
}
ob_end_flush();
?>