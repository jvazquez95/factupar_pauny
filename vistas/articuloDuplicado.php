<?php
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
  exit;
}
else
{
require 'header.php';
requierePermisoVista(basename(__FILE__, '.php'));
if ($_SESSION['almacen']==1)
{
?>

        <section class="content articulos-listado">
            <style>
              /* UX: ocultar campos avanzados por defecto */
              .articulo-avanzado { display: none; }

              /* Evitar que la tabla sobrepase el ancho de la pantalla */
              .articulos-listado { max-width: 100%; overflow-x: hidden; }
              .articulos-listado .row { max-width: 100%; }
              .articulos-listado .box { min-width: 0; max-width: 100%; }
              .articulos-listado .col-md-12 { min-width: 0; max-width: 100%; }
              .articulos-listado #listadoregistros {
                width: 100%;
                max-width: 100%;
                overflow-x: auto !important;
                -webkit-overflow-scrolling: touch;
                display: block;
              }
              .articulos-listado #listadoregistros .dataTables_wrapper { min-width: 0; }
              #tbllistado { width: 100% !important; table-layout: auto; }
              /* Contenedor de imagen */
              .articulo-imagen-container {
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 5px;
              }

              .articulo-imagen {
                max-width: 80px;
                max-height: 80px;
                width: auto;
                height: auto;
                border-radius: 4px;
                border: 2px solid #ddd;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                object-fit: cover;
                transition: transform 0.2s;
              }

              .articulo-imagen:hover {
                transform: scale(1.1);
                box-shadow: 0 4px 8px rgba(0,0,0,0.2);
                cursor: pointer;
              }

              /* Botones mejorados */
              .btn-group-vertical {
                display: flex;
                flex-direction: column;
                gap: 3px;
              }

              .btn-group-vertical .btn {
                width: 100%;
                min-width: 35px;
              }

              /* Botón de precios */
              .btn-info.btn-block {
                font-weight: 600;
                padding: 6px 12px;
              }

              /* Labels y badges mejorados */
              .label {
                font-size: 11px;
                padding: 4px 8px;
                font-weight: 600;
              }

              .badge {
                font-size: 11px;
                padding: 4px 8px;
              }

              /* Códigos con estilo */
              code {
                background-color: #f4f4f4;
                padding: 2px 6px;
                border-radius: 3px;
                font-size: 11px;
                color: #333;
                border: 1px solid #ddd;
              }

              /* Responsive: igual que persona.php */
              table.dataTable.dtr-inline.collapsed > tbody > tr > td.child,
              table.dataTable.dtr-inline.collapsed > tbody > tr > th.child,
              table.dataTable.dtr-column > tbody > tr > td.control,
              table.dataTable.dtr-column > tbody > tr > th.control {
                position: relative;
                padding-left: 30px;
                cursor: pointer;
              }

              table.dataTable.dtr-inline.collapsed > tbody > tr > td:first-child:before,
              table.dataTable.dtr-inline.collapsed > tbody > tr > th:first-child:before {
                top: 50%;
                left: 4px;
                height: 16px;
                width: 16px;
                margin-top: -10px;
                display: block;
                position: absolute;
                color: white;
                border: 2px solid white;
                border-radius: 2px;
                box-shadow: 0 0 3px rgba(0, 0, 0, 0.3);
                box-sizing: content-box;
                text-align: center;
                text-indent: 0 !important;
                line-height: 14px;
                content: '+';
                background-color: #3c8dbc;
              }

              table.dataTable.dtr-inline.collapsed > tbody > tr.parent > td:first-child:before,
              table.dataTable.dtr-inline.collapsed > tbody > tr.parent > th:first-child:before {
                content: '-';
                background-color: #d33333;
              }

              /* Input de orden */
              #tbllistado input.form-control {
                font-size: 11px;
                padding: 3px 6px;
              }

              /* Texto fuerte para nombres y precios */
              #tbllistado strong {
                color: #333;
                font-weight: 600;
              }

              .text-success {
                color: #28a745 !important;
                font-weight: 600;
              }
            </style>
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Artículo 
                            <button class="btn btn-success btn-xs" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button> 
                            <button class="btn btn-success btn-xs" id="btnagregar" onclick="crud('marca');"><i class="fa fa-plus-circle"></i> Nueva Marca</button> 
                            <button class="btn btn-success btn-xs" id="btnagregar" onclick="crud('categoria');"><i class="fa fa-plus-circle"></i> Nueva Categoria</button> 
                            <button class="btn btn-success btn-xs" id="btnagregar" onclick="crud('grupoArticulo');"><i class="fa fa-plus-circle"></i> Nuevo Grupo</button> 
                            <button class="btn btn-success btn-xs" id="btnagregar" onclick="crud('persona');"><i class="fa fa-plus-circle"></i> Nuevo Proveedor</button> 
                            <a href="../reportes/rptarticulosMejorado.php" target="_blank"><button class="btn btn-info btn-xs" type="button"><i class="fa fa-file-pdf-o"></i> Reporte PDF</button></a>
                            <a href="articulosKPIs.php"><button class="btn btn-primary btn-xs" type="button"><i class="fa fa-bar-chart"></i> KPIs Avanzados</button></a>
                          </h1>
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
                            <th><i class="fa fa-cog"></i> Acciones</th>
                            <th><i class="fa fa-hashtag"></i> ID</th>
                            <th><i class="fa fa-tag"></i> Nombre</th>
                            <th><i class="fa fa-align-left"></i> Descripción</th>
                            <th><i class="fa fa-dollar-sign"></i> Precios</th>
                            <th><i class="fa fa-truck"></i> Proveedor</th>
                            <th><i class="fa fa-industry"></i> Marca</th>
                            <th><i class="fa fa-folder"></i> Grupo</th>
                            <th><i class="fa fa-barcode"></i> Cód. Barras</th>
                            <th><i class="fa fa-code"></i> Cód. Interno</th>
                            <th><i class="fa fa-code"></i> Cód. SAP</th>
                            <th><i class="fa fa-cube"></i> Tipo</th>
                            <th><i class="fa fa-shopping-cart"></i> U. Compra</th>
                            <th><i class="fa fa-shopping-bag"></i> U. Venta</th>
                            <th><i class="fa fa-money"></i> Comisión Gs.</th>
                            <th><i class="fa fa-percent"></i> Comisión %</th>
                            <th><i class="fa fa-file-text"></i> Impuesto</th>
                            <th><i class="fa fa-dollar"></i> Precio Venta</th>
                            <th><i class="fa fa-archive"></i> Stock</th>
                            <th><i class="fa fa-user"></i> Usuario</th>
                            <th><i class="fa fa-image"></i> Imagen</th>
                            <th><i class="fa fa-ban"></i> Descontinuado</th>
                            <th><i class="fa fa-check-circle"></i> Estado</th>
                          </thead>

                          <tfoot>
                            <th>Acciones</th>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Precios</th>
                            <th>Proveedor</th>
                            <th>Marca</th>
                            <th>Grupo</th>
                            <th>Cód. Barras</th>
                            <th>Cód. Interno</th>
                            <th>Cód. SAP</th>
                            <th>Tipo</th>
                            <th>U. Compra</th>
                            <th>U. Venta</th>
                            <th>Comisión Gs.</th>
                            <th>Comisión %</th>
                            <th>Impuesto</th>
                            <th>Precio Venta</th>
                            <th>Stock</th>
                            <th>Usuario</th>
                            <th>Imagen</th>
                            <th>Descontinuado</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros" style="display:none;">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="col-12" style="margin-bottom:10px;">
                            <button type="button" id="btnToggleAvanzadoArticulo" class="btn btn-default btn-xs">
                              Mostrar/Ocultar avanzado
                            </button>
                            <span class="text-muted small" style="margin-left:8px;">Dejá solo lo necesario visible y ocultá campos avanzados.</span>
                          </div>
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
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12 articulo-avanzado">
                            <label class=" input-sm">Rubro:</label>
                            <select id="Rubro_idRubro" name="Rubro_idRubro" class="form-control selectpicker  input-sm" data-live-search="true"></select>
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12 articulo-avanzado">
                            <label class=" input-sm">Cuenta Contable - Gasto:</label>
                            <select id="CuentaContable_idCuentaContable" name="CuentaContable_idCuentaContable" class="form-control input-sm selectpicker" data-live-search="true"></select>
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

<div id="cosas" name="cosas" class="articulo-avanzado">
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



                          <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12 articulo-avanzado">
                            <label class=" input-sm">Regimen de Turismo:</label>
                            <select id="regimenTurismo" name="regimenTurismo" class="form-control input-sm selectpicker" data-live-search="true">
                              <option value="0" selected>No</option>
                              <option value="1">Si</option>
                            </select>
                          </div>




                          <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12 articulo-avanzado">
                            <label class=" input-sm">Balanza:</label>
                            <select id="balanza" name="balanza" class="form-control input-sm selectpicker" data-live-search="true">
                              <option value="0" selected>No</option>
                              <option value="1">Si</option>
                            </select>
                          </div>


                          <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12 articulo-avanzado">
                            <label class=" input-sm">Ventas por Kl:</label>
                            <select id="ventasKl" name="ventasKl" class="form-control input-sm selectpicker" data-live-search="true">
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



                          <!-- Sistema de Pestañas para Detalles Opcionales -->
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="nav-tabs-custom">
                              <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab_codigos_barras" data-toggle="tab"><i class="fa fa-barcode"></i> Códigos de Barras</a></li>
                                <li><a href="#tab_info_basica" data-toggle="tab" style="display:none;"><i class="fa fa-info-circle"></i> Información Básica</a></li>
                              </ul>
                              <div class="tab-content">
                                <!-- Pestaña: Códigos de Barras -->
                                <div class="tab-pane active" id="tab_codigos_barras">
                                  <div class="box box-primary">
                                    <div class="box-header with-border">
                                      <h3 class="box-title"><i class="fa fa-barcode"></i> Gestión de Códigos de Barras</h3>
                                      <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-primary btn-xs" onclick="crud('unidad')">
                                          <i class="fa fa-plus"></i> Nueva Unidad de Medida
                                        </button>
                                      </div>
                                    </div>
                                    <div class="box-body">
                                      <div class="row">
                                        <div class="col-md-12">
                                          <div class="alert alert-info">
                                            <i class="fa fa-info-circle"></i> <strong>Opcional:</strong> Puede agregar múltiples códigos de barras para diferentes unidades de medida.
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label class="input-sm">Unidad de Medida:</label>
                                            <select id="Unidad_idUnidad_l" name="Unidad_idUnidad_l" class="form-control input-sm selectpicker" data-live-search="true"></select>
                                          </div>
                                          <div class="form-group">
                                            <label class="input-sm">Descripción:</label>
                                            <input type="text" class="form-control input-sm" name="descripcionCodigoBarra_l" id="descripcionCodigoBarra_l" maxlength="256" placeholder="Descripción del código">
                                          </div>
                                          <div class="form-group">
                                            <label class="input-sm">Código de Barras:</label>
                                            <input type="text" class="form-control input-sm" name="codigoBarra_l" onblur="validarCodigoBarra(this)" id="codigoBarra_l" maxlength="256" placeholder="Código de Barras">
                                          </div>
                                          <button type="button" class="btn btn-success btn-block" onclick="addDetalleCodigoBarra()">
                                            <i class="fa fa-plus-circle"></i> Agregar Código de Barras
                                          </button>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="table-responsive">
                                            <table id="detalleCodigoBarra" class="table table-bordered table-striped table-hover">
                                              <thead style="background-color: #3c8dbc; color: white;">
                                                <tr>
                                                  <th width="10%">Acciones</th>
                                                  <th width="25%">Unidad</th>
                                                  <th width="15%">Cantidad</th>
                                                  <th width="25%">Descripción</th>
                                                  <th width="25%">Código</th>
                                                </tr>
                                              </thead>
                                              <tfoot>
                                                <tr>
                                                  <th></th>
                                                  <th></th>
                                                  <th></th>
                                                  <th></th>
                                                  <th></th>
                                                </tr>
                                              </tfoot>
                                              <tbody>
                                              </tbody>
                                            </table>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- Fin Pestaña Códigos de Barras -->
                              </div>
                            </div>
                          </div>

                               <!-- Sección deshabilitada: Materia prima (no se usa actualmente) -->
                               <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" style="display:none;">
                               
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

<!-- ================= MODAL – DETALLE DE PRECIO ================= -->
<!-- 100 % listo para copiar-pegar; ancho 95 % en pantallas ≥ 992 px -->
<div class="modal " id="modal_detalle" tabindex="-1">
  <div class="modal-dialog modal-full modal-dialog-centered">
    <div class="modal-content">

      <!-- Cuerpo -->
      <div class="modal-body">
        <span>
          Detalle de Precio Venta:
          <input type="text" disabled name="detalle" id="detalle" />
        </span>

        <div class="table-responsive mt-3">
          <table id="tbllistado4" class="table table-striped table-bordered table-condensed table-hover">
            <thead>
              <tr>
                <th>Id Artículo</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Usuario Modificación</th>
                <th>Usuario Inserción</th>
                <th>Fecha Inserción</th>
                <th>Fecha Modificación</th>
              </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
              <tr>
                <th colspan="7"></th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>

      <!-- Pie -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>

    </div>
  </div>
</div>

<!-- ===== ESTILOS ESPECÍFICOS ===== -->
<style>
  /* Extiende modal-lg (≈900 px) a 95 % del viewport en Bootstrap 3/4 */
  @media (min-width: 992px) {
    .modal-dialog.modal-full {
      width: 95%;
      max-width: 95%;
      margin: auto;
    }
  }
</style>

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
<script type="text/javascript" src="scripts/articuloduplicado.js"></script>
<script type="text/javascript" src="scripts/generales.js"></script>
<?php 
}
ob_end_flush();
?>