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
if (($_SESSION['personas'] ?? 0) == 1 || tienePermisoVista('persona'))
{
?>
<!--Contenido-->
      <!-- Overlay de carga mientras hay peticiones a servicios -->
      <div id="loadingPersonaOverlay" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(255,255,255,0.85); z-index:9999; justify-content:center; align-items:center; flex-direction:column; pointer-events:auto;">
        <div style="text-align:center;">
          <i class="fa fa-spinner fa-spin fa-4x text-primary"></i>
          <p class="text-muted" style="margin-top:12px; font-size:16px;">Cargando...</p>
        </div>
      </div>
      <style>
        #loadingPersonaOverlay.loading-active { display: flex !important; }
      </style>
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Personas <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button>
                            <select id="filtroTipoPersona" class="form-control" style="display:inline-block; width:auto; margin-left:10px;">
                              <option value="">Todos los tipos</option>
                            </select>
                            <a id="btnReportePersonasPdf" href="../reportes/rptInventarioPersonas.php" target="_blank" class="btn btn-info btn-sm" style="margin-left:8px;"><i class="fa fa-file-pdf-o"></i> Inventario PDF</a>
                          </h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- KPIs -->
                    <div class="row" id="kpisPersonas" style="padding: 10px 15px;">
                      <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="info-box bg-aqua">
                          <span class="info-box-icon"><i class="fa fa-users"></i></span>
                          <div class="info-box-content">
                            <span class="info-box-text">Total personas</span>
                            <span class="info-box-number" id="kpiTotal">0</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="info-box bg-green">
                          <span class="info-box-icon"><i class="fa fa-check-circle"></i></span>
                          <div class="info-box-content">
                            <span class="info-box-text">Activos</span>
                            <span class="info-box-number" id="kpiActivos">0</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="info-box bg-gray">
                          <span class="info-box-icon"><i class="fa fa-minus-circle"></i></span>
                          <div class="info-box-content">
                            <span class="info-box-text">Inactivos</span>
                            <span class="info-box-number" id="kpiInactivos">0</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="info-box bg-yellow">
                          <span class="info-box-icon"><i class="fa fa-tags"></i></span>
                          <div class="info-box-content">
                            <span class="info-box-text">Por tipo</span>
                            <span class="info-box-number" id="kpiPorTipo">-</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado">
                          <thead>
                            <th>ID</th>
                            <th>Opciones</th>
                            <th>Razón social</th>
                            <th>Apellidos, Nombres</th>
                            <th>Tipo doc.</th>
                            <th>Nro. Documento</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Tipo Empresa</th>
                            <th>Registrado por</th>
                            <th>Ficha del cliente</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>          
                            <th>ID</th>
                            <th>Opciones</th>
                            <th>Razón social</th>
                            <th>Apellidos, Nombres</th>
                            <th>Tipo doc.</th>
                            <th>Nro. Documento</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Tipo Empresa</th>
                            <th>Registrado por</th>
                            <th>Ficha del cliente</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros" style="display:none;">
                        <form name="formulario" id="formulario" method="POST">
                          <input type="hidden" name="idPersona" id="idPersona">
                          <input type="hidden" name="razonSocial" id="razonSocial" value="">
                          <input type="hidden" name="nombreComercial" id="nombreComercial" value="">
                          <!-- Número primero; tipo se selecciona solo: con guion = RUC, sin guion = Cédula -->
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Número Documento:</label>
                            <input type="text" class="form-control" name="nroDocumento" id="nroDocumento" onblur="onBlurNroDocumento(this)" maxlength="20" placeholder="Ej. 4831750 (cédula) o 4831750-1 (RUC). Al salir se cargan datos" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Tipo Documento:</label>
                            <select class="form-control select-picker" name="tipoDocumento" id="tipoDocumento" required>
                              <option value="1">RUC</option>
                              <option value="2">CEDULA</option>
                              <option value="3">DOCUMENTO EXTRANJERO</option>
                            </select>
                            <small class="text-muted">Se selecciona automáticamente: con guion = RUC, sin guion = Cédula</small>
                          </div>

                          <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <label>Apellidos:</label>
                            <input type="text" class="form-control" name="apellidos" id="apellidos" maxlength="250" placeholder="Apellidos (persona) o , (empresa)" required>
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <label>Nombres:</label>
                            <input type="text" class="form-control" name="nombres" id="nombres" maxlength="250" placeholder="Nombres o razón social (empresa)" required>
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <label>Nombre fantasía:</label>
                            <input type="text" class="form-control" name="nombreFantasia" id="nombreFantasia" maxlength="250" placeholder="Opcional; en empresa = mismo que Nombres">
                          </div> 

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Email:</label>
                            <input type="email" class="form-control" name="mail" id="mail" maxlength="50" placeholder="Email">
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Nacimiento:</label>
                            <input type="date" class="form-control" name="fechaNacimiento" id="fechaNacimiento" maxlength="50" placeholder="fechaNacimiento">
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Regimen de Turismo:</label>
                            <select class="form-control select-picker" name="regimenTurismo" id="regimenTurismo" required>
                              <option value="2">No</option>
                              <option value="1">Si</option>
                            </select>
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Tipo de Empresa:</label>
                            <select class="form-control select-picker" name="tipoEmpresa" id="tipoEmpresa" required>
                              <option value="1">Privada</option>
                              <option value="2">Pública</option>
                            </select>
                          </div>
                                

                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12" style="display:none;">
                            <label>Proveedor Relacionado</label>
                            <select title="Selecciona Articulo" class="selectpicker selector_persona form-control person" data-style="btn-warning" name="Proveedor_idProveedor" id="Proveedor_idProveedor" data-live-search="true"><option value="0">Ninguno</option></select>
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12" style="display:none;">
                            <label>Proveedor Tercerizado</label>
                            <select class="form-control select-picker" name="tercerizado" id="tercerizado" required>
                              <option value="0">No</option>
                              <option value="1">Si</option>
                            </select>
                          </div>

                          <hr>

                          <!-- Pestañas al estilo Artículos: Tipo de Persona, Direcciones, Teléfonos, etc. -->
                          <div class="col-md-12">
                            <div class="nav-tabs-custom">
                              <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab_tipo_persona" data-toggle="tab"><i class="fa fa-user"></i> Tipo de Persona</a></li>
                                <li><a href="#tab_direcciones" data-toggle="tab"><i class="fa fa-map-marker"></i> Direcciones</a></li>
                                <li><a href="#tab_telefonos" data-toggle="tab"><i class="fa fa-phone"></i> Teléfonos</a></li>
                                <li><a href="#tab_contactos" data-toggle="tab"><i class="fa fa-address-book"></i> Contactos</a></li>
                              </ul>
                              <div class="tab-content">
                                <!-- Pestaña: Tipo de Persona -->
                                <div class="tab-pane active" id="tab_tipo_persona">
                                  <div class="box box-primary">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">Tipo de Persona</h3>
                                      <button type="button" class="btn btn-primary btn-xs" onclick="crud('grupoPersona')"><i class="fa fa-pagelines"></i> Nuevo Grupo Persona</button>
                                    </div>
                                    <div class="box-body">
                                      <div class="row">
                                        <div class="col-md-12">
                                          <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                            <label class="input-sm">Tipo de Persona:</label>
                                            <select id="TipoPersona_idTipoPersona_l" onchange="personalizar(this);" name="TipoPersona_idTipoPersona_l" class="form-control input-sm selectpicker" data-live-search="true"><option value="1">Cliente</option><option value="2">Proveedora</option></select>
                                          </div>
                                          <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                            <label class="input-sm">Termino de Pago Habilitado:</label>
                                            <select id="terminoPago_l" name="terminoPago_l" class="form-control input-sm selectpicker" data-live-search="true" required></select>
                                          </div>
                                          <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                            <label class="input-sm">Grupo Persona</label>
                                            <select id="GrupoPersona_idGrupoPersona_l" name="GrupoPersona_idGrupoPersona_l" class="form-control input-sm selectpicker" data-live-search="true"></select>
                                          </div>
                                          <div id="divone">
                                            <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                              <label class="input-sm">Cuenta a Pagar:</label>
                                              <select id="cuentaAPagar_l" name="cuentaAPagar_l" class="form-control input-sm selectpicker" data-live-search="true"></select>
                                            </div>
                                            <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                              <label class="input-sm">Cuenta anticipo:</label>
                                              <select id="cuentaAnticipo_l" name="cuentaAnticipo_l" class="form-control input-sm selectpicker" data-live-search="true"></select>
                                            </div>
                                          </div>
                                          <div id="divtwo">
                                            <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                              <label class="input-sm">Comision:</label>
                                              <input type="text" class="form-control input-sm" name="comision_l" id="comision_l">
                                            </div>
                                            <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                              <label class="input-sm">Salario:</label>
                                              <input type="text" class="form-control input-sm" name="salario_l" id="salario_l" maxlength="256" placeholder="">
                                            </div>
                                          </div>
                                          <button type="button" class="btn btn-info btn-block btn-xs" onclick="addDetalleTipoPersona()"><i class="fa fa-plus-circle"></i> Agregar</button>
                                          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 table-responsive">
                                            <table id="detalleTipoPersona" class="table table-bordered table-striped table-hover display compact">
                                              <thead style="background-color:#3c8dbc; color:white;">
                                                <tr><th>Opciones</th><th>Tipo de Persona</th><th>Término Pago</th><th>Grupo</th><th>Cuenta a Pagar</th><th>Cuenta Anticipo</th><th>Comisión</th><th>Salario</th><th style="width:1px;"></th></tr>
                                              </thead>
                                              <tfoot><tr><th>Opciones</th><th>Tipo de Persona</th><th>Término Pago</th><th>Grupo</th><th>Cuenta a Pagar</th><th>Cuenta Anticipo</th><th>Comisión</th><th>Salario</th><th></th></tr></tfoot>
                                              <tbody></tbody>
                                            </table>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- Pestaña: Direcciones -->
                                <div class="tab-pane" id="tab_direcciones">
                                  <div class="box box-primary">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">Direcciones</h3>
                                      <button type="button" class="btn btn-primary btn-xs" onclick="crud('tipoDireccionTelefono')"><i class="fa fa-pagelines"></i> Nuevo Tipo Dirección</button>
                                      <button type="button" class="btn btn-primary btn-xs" onclick="crud('ciudad')"><i class="fa fa-pagelines"></i> Nueva Ciudad</button>
                                      <button type="button" class="btn btn-primary btn-xs" onclick="crud('barrio')"><i class="fa fa-pagelines"></i> Nuevo Barrio</button>
                                    </div>
                                    <div class="box-body">
                                      <div class="row">
                                        <div class="col-md-12">
                                          <p class="text-muted small"><strong>Orden:</strong> 1) Ciudad, 2) Calle principal, 3) Calle transversal, 4) Nro. casa, 5) Ubicación en mapa (lat/lng).</p>
                                          <div class="form-group">
                                                <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                  <label class="input-sm">Ciudad:</label>
                                                  <select id="Ciudad_idCiudad_l" name="Ciudad_idCiudad_l" class="form-control input-sm selectpicker" data-live-search="true" required><option value="">Seleccione ciudad</option></select>
                                                </div>
                                                <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                  <label class="input-sm">Calle Principal:</label>
                                                  <input type="text" class="form-control input-sm" name="callePrincipal_l" id="callePrincipal_l" maxlength="256" placeholder="Calle principal">
                                                </div>
                                                <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                  <label class="input-sm">Calle Transversal:</label>
                                                  <input type="text" class="form-control input-sm" name="calleTransversal_l" id="calleTransversal_l" maxlength="256" placeholder="Calle transversal">
                                                </div>
                                                <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                  <label class="input-sm">Nro. de casa:</label>
                                                  <input type="text" class="form-control input-sm" name="nroCasa_l" id="nroCasa_l" maxlength="256" placeholder="Número">
                                                </div>
                                                <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                  <label class="input-sm">Tipo dirección:</label>
                                                  <select id="TipoDireccion_Telefono_idTipoDireccion_Telefono_l" name="TipoDireccion_Telefono_idTipoDireccion_Telefono_l" class="form-control input-sm selectpicker" data-live-search="true"><option value="1">Particular</option><option value="2">Laboral</option></select>
                                                </div>
                                                <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                  <label class="input-sm">Barrio:</label>
                                                  <select id="Barrio_idBarrio_l" name="Barrio_idBarrio_l" class="form-control input-sm selectpicker" data-live-search="true"><option value="">Opcional</option></select>
                                                </div>
                                                <div class="form-group col-lg-1 col-md-1 col-sm-2 col-xs-12">
                                                  <label class="input-sm">Lat:</label>
                                                  <input type="text" class="form-control input-sm search_latitude" name="latitud_l" id="latitud_l" maxlength="32" placeholder="Mapa">
                                                </div>
                                                <div class="form-group col-lg-1 col-md-1 col-sm-2 col-xs-12">
                                                  <label class="input-sm">Lng:</label>
                                                  <input type="text" class="form-control input-sm search_longitude" name="longitud_l" id="longitud_l" maxlength="32" placeholder="Mapa">
                                                </div>
                                                     
 
                                                        <form class="formulario_467784">
                                                          <div class="form-group input-group">
                                                          <input type="hidden" id="search_location" class="form-control input-sm" value=" Asunción, Paraguay" placeholder="Agregar dirección completa">
                                                          </div>
                                                          <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                                          <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#exampleModal">Seleccionar ubicación</button>
                                                     

                                                            <!-- Modal SELECCIONAR UBICACION -->
                                                            <div class="modal " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                              <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                  <div class="modal-header">
                                                                    <h4 class="modal-title" id="exampleModalLabel">Seleccionar ubicación</h4>
                                                                    <p>Selecciona la ubicación en el mapa de abajo</p>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                      <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                  </div>
                                                                  <div class="modal-body">
                                                                            <div id="map" style="height:400px !important; width:100% !important;"></div>

                                                                  </div>
                                                                  <div class="modal-footer">
                                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                                                            <!--         <button type="button" class="btn btn-primary">Guardar cambios</button>
                                                             -->      </div>
                                                                </div>
                                                              </div>
                                                            </div>

                                                      </div>






<!-- <p>Dirección: <input type="text" class="search_addr" size="45"></p>
 --><div id="geomap"></div>


                                                      <button type="button" class="btn btn-info btn-block btn-xs"  onclick="addDetalleDireccion()" ><i class="fa fa-plus-circle"></i> Agregar</button>


                          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 table-responsive">
                            <table id="detalleDireccion" class="table display compact">
                              <thead>
                                    <th>Opciones</th>
                                    <th>Tipo de Direccion</th>
                                    <th>Ciudad</th>
                                    <th>Barrio</th>
                                    <th>Calle Principal</th>
                                    <th>Calle Transversal</th>
                                    <th>Nro. de casa</th>
                                    <th>Latitud</th>
                                    <th>Longitud</th>
                                </thead>
                                <tfoot>
                                    <th>Opciones</th>
                                    <th>Tipo de Direccion</th>
                                    <th>Ciudad</th>
                                    <th>Barrio</th>
                                    <th>Calle Principal</th>
                                    <th>Calle Transversal</th>
                                    <th>Nro. de casa</th>
                                    <th>Latitud</th>
                                    <th>Longitud</th>
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
                                </div>
                                <!-- Pestaña: Teléfonos -->
                                <div class="tab-pane" id="tab_telefonos">
                                  <div class="box box-primary">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">Teléfonos</h3>
                                      <button type="button" class="btn btn-primary btn-xs" onclick="crud('tipoDireccionTelefono')"><i class="fa fa-pagelines"></i> Nuevo Tipo</button>
                                    </div>
                                    <div class="box-body">
                                      <div class="row">
                                        <div class="col-md-12">
                                          <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                            <label class="input-sm">Tipo de Telefono:</label>
                                            <select id="TipoDireccion_Telefono_idTipoDireccion_Telefono_tel_l" name="TipoDireccion_Telefono_idTipoDireccion_Telefono_tel_l" class="form-control input-sm selectpicker" data-live-search="true"><option>Particular</option><option>Laboral</option></select>
                                          </div>
                                          <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                            <label class="input-sm">Telefono:</label>
                                            <input type="text" class="form-control input-sm" name="telefono_l" id="telefono_l" maxlength="256" placeholder="">
                                          </div>
                                          <button type="button" class="btn btn-info btn-block" onclick="addDetalleTelefono()"><i class="fa fa-plus-circle"></i> Agregar</button>
                                          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 table-responsive">
                                            <table id="detalleTelefono" class="table table-bordered table-striped table-hover display compact">
                                              <thead style="background-color:#3c8dbc; color:white;">
                                                <tr><th>Opciones</th><th>Tipo</th><th>Teléfono</th><th style="width:1px;"></th></tr>
                                              </thead>
                                              <tfoot><tr><th>Opciones</th><th>Tipo</th><th>Teléfono</th><th></th></tr></tfoot>
                                              <tbody></tbody>
                                            </table>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- Pestaña: Contactos -->
                                <div class="tab-pane" id="tab_contactos">
                                  <div class="box box-primary">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">Contactos</h3>
                                      <button type="button" class="btn btn-primary btn-xs" onclick="crud('cargo')"><i class="fa fa-pagelines"></i> Nuevo Cargo</button>
                                    </div>
                                    <div class="box-body">
                                      <div class="row">
                                        <div class="col-md-12">
                                          <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                            <label class="input-sm">Nombre y Apellido:</label>
                                            <input type="text" class="form-control input-sm" name="nya_l" id="nya_l" maxlength="256" placeholder="">
                                          </div>
                                          <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                            <label class="input-sm">Cargo:</label>
                                            <select id="Cargo_idCargo_l" name="Cargo_idCargo_l" class="form-control input-sm selectpicker" data-live-search="true"></select>
                                          </div>
                                          <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                            <label class="input-sm">Email:</label>
                                            <input type="email" class="form-control input-sm" name="email_l" id="email_l" maxlength="256" placeholder="">
                                          </div>
                                          <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                            <label class="input-sm">Telefono:</label>
                                            <input type="text" class="form-control input-sm" name="telefono_l2" id="telefono_l2" maxlength="256" placeholder="">
                                          </div>
                                          <button type="button" class="btn btn-info btn-block" onclick="addDetalleContacto()"><i class="fa fa-plus-circle"></i> Agregar</button>
                                          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 table-responsive">
                                            <table id="detalleContacto" class="table table-bordered table-striped table-hover display compact">
                                              <thead style="background-color:#3c8dbc; color:white;">
                                                <tr><th>Opciones</th><th>Nombre y Apellido</th><th>Cargo</th><th>Email</th><th>Teléfono</th><th style="width:1px;"></th></tr>
                                              </thead>
                                              <tfoot><tr><th>Opciones</th><th>Nombre y Apellido</th><th>Cargo</th><th>Email</th><th>Teléfono</th><th></th></tr></tfoot>
                                              <tbody></tbody>
                                            </table>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
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
        <!-- Modal Detalle completo persona -->
        <div class="modal" id="modal_detalle_completo" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-user"></i> Ficha del cliente</h4>
              </div>
              <div class="modal-body" id="modal_detalle_completo_body">
                <div class="text-center"><i class="fa fa-spinner fa-spin"></i> Cargando...</div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-warning" id="btnEditarDesdeDetalle"><i class="fa fa-pencil"></i> Editar</button>
              </div>
            </div>
          </div>
        </div>
        <!-- The Modal Comodato -->
        <div class="modal " id="modal_detalle"> 
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
              <!-- Modal body -->
              <div class="modal-body">
                  <span>Detalle de Comodato por Persona:<input type="text" disabled name="detalle4" id="detalle4" /> </span>
                    <table id="tbllistado4" class="table table-striped table-bordered table-condensed table-hover">
                      <thead>
                        <th>Articulo</th>
                        <th>Deposito</th>
                        <th>Cantidad</th>
                      </thead>
                      <tbody>                            
                      </tbody>
                      <tfoot>
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
<?php
}
else
{
  require 'noacceso.php';
}
require 'footer.php';
?>

<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<!-- AGREGAR SCRIPT GOOGLE APIS -->
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVbCmKkfBfmcsC5zjkk70WttiFIcxdWHI"></script>
<script type="text/javascript" src="scripts/persona.js"></script>
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
        //var razonSocial = $(this).children("option:selected").attr("d-precio");
        //var nroDocumento = $(this).children("option:selected").attr("d-impuesto");
        //var didImpuesto = $(this).children("option:selected").attr("d-idImpuesto");
        //var dnombre = $(this).children("option:selected").text();

        //agregarDetalle(idPersona,dnombre,dprecio,didImpuesto, dimpuesto);
    });
});
</script>

<?php 
}
ob_end_flush();
?>