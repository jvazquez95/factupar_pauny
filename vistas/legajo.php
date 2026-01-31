<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["almacen"]))
{
  header("Location: login.html");
}
else
{
require 'header.php';
requierePermisoVista(basename(__FILE__, '.php'));
if ($_SESSION['personas']==1)
{
?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
        <!-- Main content -->
        <section class="content" style="background-color: #B5B4B7">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Legajo <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado">
                          <thead>
                           <th>Opciones</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Tipo documento</th>
                            <th>Nro. Documento</th>
                            <th>mail</th>
                            <th>Nacimiento</th>
                            <th>Tipo Empresa</th>
                            <th>Estado Civil</th>
                            <th>Sexo</th>
                            <th>Profesion</th>
                            <th>Departamento</th>
                            <th>Sucursal</th>
                            <th>Cargo</th>
                            <th>Clase</th>
                            <th>Medio de Cobro</th>
                            <th>Banco</th>
                            <th>Nro. de Cuenta</th>
                            <th>Tipo de Salario</th>
                            <th>Tipo de Contrato</th>
                            <th>Nro. Seguro Social</th>
                            <th>Nro. Contrato</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>          
                            <th>Opciones</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Tipo documento</th>
                            <th>Nro. Documento</th>
                            <th>mail</th>
                            <th>Nacimiento</th>
                            <th>Tipo Empresa</th>
                            <th>Estado Civil</th>
                            <th>Sexo</th>
                            <th>Profesion</th>
                            <th>Departamento</th>
                            <th>Sucursal</th>
                            <th>Cargo</th>
                            <th>Clase</th>
                            <th>Medio de Cobro</th>
                            <th>Banco</th>
                            <th>Nro. de Cuenta</th>
                            <th>Tipo de Salario</th>
                            <th>Tipo de Contrato</th>
                            <th>Nro. Seguro Social</th>
                            <th>Nro. Contrato</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>

                    <div class="panel-body" style="background-color: #B5B4B7" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">

                          <div class="row">
                                  <div class="col-md-12">

                                    <div class="box box-primary">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">Datos Personales</h3>
                                      <div class="box-tools pull-right">
                                        <span id="alEditar">
                                        <button type="button" class="btn btn-success btn-md" onclick="crudV2('salario')"><i class="fa fa-pagelines">Salario</i></button>
                                        <button type="button" class="btn btn-success btn-md" onclick="crudV2('movimientoPersonal')"><i class="fa fa-pagelines">Movimiento Personal</i></button>
                                        <button type="button" class="btn btn-success btn-md" onclick="crudV2('comunicacionPersonal')"><i class="fa fa-pagelines">Comunicacion Personal</i></button>
                                        <button type="button" class="btn btn-success btn-md" onclick="crudV2('pariente')"><i class="fa fa-pagelines">Parientes</i></button>
                                        </span>
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button type="button" class="btn btn-primary btn-xs" onclick="crud('departamento')"><i class="fa fa-pagelines">Departamento</i></button>
                                        <button type="button" class="btn btn-primary btn-xs" onclick="crud('cargo')"><i class="fa fa-pagelines">Cargo</i></button>
                                        <button type="button" class="btn btn-primary btn-xs" onclick="crud('estadoCivil')"><i class="fa fa-pagelines">Estado Civil</i></button>
                                        <button type="button" class="btn btn-primary btn-xs" onclick="crud('profesion')"><i class="fa fa-pagelines">Profesion</i></button>
                                        <button type="button" class="btn btn-primary btn-xs" onclick="crud('clase')"><i class="fa fa-pagelines">Clase</i></button>
                                        <button type="button" class="btn btn-primary btn-xs" onclick="crud('tipoSalario')"><i class="fa fa-pagelines">Tipo de Salario</i></button>
                                        <button type="button" class="btn btn-primary btn-xs" onclick="crud('medioCobro')"><i class="fa fa-pagelines">Medio de Cobro</i></button>
                                        <button type="button" class="btn btn-primary btn-xs" onclick="crud('tipoContrato')"><i class="fa fa-pagelines">Tipo de Contrato</i></button>
                                      </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                      <div class="row">
                                        <div class="col-md-12">
                                          <div class="form-group">

                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Nombres:</label>
                            <input type="hidden" name="idPersona" id="idPersona">
                            <input type="text" class="form-control" name="razonSocial" id="razonSocial" maxlength="250" placeholder="Nombre del cliente" required>
                          </div>
                          
                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Apellidos:</label>
                            <input type="text" class="form-control" name="nombreComercial" id="nombreComercial" maxlength="250" placeholder="Nombre comercial" required>
                          </div>

                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Tipo Documento:</label>
                            <select class="form-control select-picker" name="tipoDocumento" id="tipoDocumento" required>
                              <!-- <option value="1">RUC</option> -->
                              <option value="2">CEDULA</option>
                              <!-- <option value="3">DOCUMENTO EXTRANJERO</option> -->
                            </select>
                          </div>

                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Número Documento:</label>
                            <input type="text" class="form-control" name="nroDocumento" id="nroDocumento" maxlength="20" placeholder="Documento" required>
                          </div> 

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Email:</label>
                            <input type="email" class="form-control" name="mail" id="mail" maxlength="50" placeholder="Email">
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Nacimiento:</label>
                            <input type="date" class="form-control" name="fechaNacimiento" id="fechaNacimiento" maxlength="50" placeholder="fechaNacimiento">
                          </div>

  <!--                         <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Regimen de Turismo:</label>
                            <select class="form-control select-picker" name="regimenTurismo" id="regimenTurismo" required>
                              <option value="2">No</option>
                              <option value="1">Si</option>
                            </select>
                          </div> -->

<!--                           <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Tipo de Empresa:</label>
                            <select class="form-control select-picker" name="tipoEmpresa" id="tipoEmpresa" required>
                              <option value="1">Privada</option>
                              <option value="2">Pública</option>
                            </select>
                          </div> -->
                            

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Estado Civil:</label>
                            <select class="form-control select-picker" name="EstadoCivil_idEstadoCivil" id="EstadoCivil_idEstadoCivil" required>
                            </select>
                          </div>


                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Genero:</label>
                            <select class="form-control select-picker" name="sexo" id="sexo" required>
                              <option value="M">Masculino</option>
                              <option value="F">Femenino</option>
                            </select>
                          </div>


                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Profesion:</label>
                            <select class="form-control select-picker" name="Profesion_idProfesion" id="Profesion_idProfesion" required>
                            </select>
                          </div>


                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Departamento:</label>
                            <select class="form-control select-picker" name="Departamento_idDepartamento" id="Departamento_idDepartamento" required>
                            </select>
                          </div>


                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Sucursal:</label>
                            <select class="form-control select-picker" name="Sucursal_idSucursal" id="Sucursal_idSucursal" required>
                            </select>
                          </div>


                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Cargo:</label>
                            <select class="form-control select-picker" name="Cargo_idCargo" id="Cargo_idCargo" required>
                            </select>
                          </div>


                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Clase:</label>
                            <select class="form-control select-picker" name="Clase_idClase" id="Clase_idClase" required>
                            </select>
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Medio de Cobro:</label>
                            <select class="form-control select-picker" name="MedioCobro_idMedioCobro" id="MedioCobro_idMedioCobro" required>
                            </select>
                          </div>


                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Banco:</label>
                            <select class="form-control select-picker" name="Banco_idBanco" id="Banco_idBanco" required>
                            </select>
                          </div>


                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Número de Cuenta:</label>
                            <input type="text" class="form-control" name="nroCuenta" id="nroCuenta" maxlength="20" placeholder="Documento" required>
                          </div> 

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Tipo de Salario:</label>
                            <select class="form-control select-picker" name="TipoSalario_idTipoSalario" id="TipoSalario_idTipoSalario" required>
                            </select>
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Tipo de Contrato:</label>
                            <select class="form-control select-picker" name="TipoContrato_idTipoContrato" id="TipoContrato_idTipoContrato" required>
                            </select>
                          </div>

                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Nro. Seguro Social:</label>
                            <input type="text" class="form-control" name="nroSeguroSocial" id="nroSeguroSocial" maxlength="20" placeholder="Documento" required>
                          </div> 


                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Nro. Contrato:</label>
                            <input type="text" class="form-control" name="nroContrato" id="nroContrato" maxlength="20" placeholder="Documento" required>
                          </div> 

                        </div>
                      </div>
                    </div>
                  </div>
                </div>

<?php

/*
                          <div class="row">
                                  <div class="col-md-12">

                                    <div class="box box-primary">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">Tipo de Persona</h3><button type="button" class="btn btn-primary btn-xs" onclick="crud('grupoPersona')"><i class="fa fa-pagelines">Nuevo Grupo Persona</i></button>
                                      <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                      </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                      <div class="row">
                                        <div class="col-md-12">
                                          <div class="form-group">

                                                <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                                    <label class=" input-sm">Tipo de Persona:</label>
                                                        <select id="TipoPersona_idTipoPersona_l" onchange="personalizar(this);" name="TipoPersona_idTipoPersona_l" class="form-control input-sm selectpicker" data-live-search="true" required><option value="1">Cliente</option><option value="1">Proveedora</option></select>
                                                      </div>


                                                      <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                                        <label class=" input-sm">Termino de Pago Habilitado:</label>
                                                         <select id="terminoPago_l" name="terminoPago_l" class="form-control input-sm selectpicker" data-live-search="true" required></select>
                                                      </div>


                                                      <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                                        <label class=" input-sm">Grupo Persona</label>
                                                        <select id="GrupoPersona_idGrupoPersona_l" name="GrupoPersona_idGrupoPersona_l" class="form-control input-sm selectpicker" data-live-search="true" required><option value="1">San Vicente</option><option value="1">San Juan</option><option value="1">Sajonia</option></select>
                                                      </div>

                                                      <div id="divone">
                                                        <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                          <label class=" input-sm">Cuenta a Pagar:</label>
                                                          <input type="text" class="form-control input-sm " name="cuentaAPagar_l" id="cuentaAPagar_l" maxlength="256" placeholder="" required="">
                                                        </div>

                                                        <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                          <label class=" input-sm">Cuenta anticipo:</label>
                                                          <input type="text" class="form-control input-sm " name="cuentaAnticipo_l" id="cuentaAnticipo_l" maxlength="256" placeholder="" required="">
                                                        </div>
                                                      </div>
                                                      
                                                      <div id="divtwo">

                                                        <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                          <label class=" input-sm">Comision:</label>
                                                          <input type="text" class="form-control input-sm" name="comision_l" id="comision_l">
                                                        </div>

                                                        <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                          <label class=" input-sm">Salario:</label>
                                                          <input type="text" class="form-control input-sm " name="salario_l" id="salario_l" maxlength="256" placeholder="">
                                                        </div>
                                                      </div>

                                                      <button type="button" class="btn btn-success btn-block btn-xs"  onclick="addDetalleTipoPersona()" ><i class="fa fa-plus-circle"></i> Agregar</button>

                                                      <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12  table-responsive" >
                                                        <table id="detalleTipoPersona" class="table display compact responsive">
                                                          <thead >
                                                                <th>Opciones</th>
                                                                <th>Tipo de Persona</th>
                                                                <th>Termino de Pago</th>
                                                                <th>Grupo</th>
                                                                <th>Cuenta a Pagar</th>
                                                                <th>Cuenta Anticipo</th>
                                                                <th>Comision</th>
                                                                <th>Salario</th>
                                                            </thead>
                                                            <tfoot>
                                                                <th>Opciones</th>
                                                                <th>Tipo de Persona</th>
                                                                <th>Termino de Pago</th>
                                                                <th>Grupo</th>
                                                                <th>Cuenta a Pagar</th>
                                                                <th>Cuenta Anticipo</th>
                                                                <th>Comision</th>
                                                                <th>Salario</th>
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
*/

?>

                          <div class="row" >
                                  <div class="col-md-12">

                                    <div class="box box-primary">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">Direcciones</h3><button type="button" class="btn btn-primary btn-xs" onclick="crud('tipoDireccionTelefono')"><i class="fa fa-pagelines">Nuevo Tipo de Direccion</i></button><button type="button" class="btn btn-primary btn-xs" onclick="crud('ciudad')"><i class="fa fa-pagelines">Nueva Ciudad </i></button><button type="button" class="btn btn-primary btn-xs" onclick="crud('barrio')"><i class="fa fa-pagelines">Nuevo Barrio</i></button>
                                      <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                      </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                      <div class="row">
                                        <div class="col-md-12">
                                          <div class="form-group">

                                                <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                                    <label class=" input-sm">Tipo de Direccion:</label>
                                                        <select id="TipoDireccion_Telefono_idTipoDireccion_Telefono_l" name="TipoDireccion_Telefono_idTipoDireccion_Telefono_l" class="form-control input-sm selectpicker" data-live-search="true" required><option value="1">Particular</option><option value="2">Laboral</option></select>
                                                      </div>


                                                      <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                                        <label class=" input-sm">Ciudad:</label>
                                                        <select id="Ciudad_idCiudad_l" name="Ciudad_idCiudad_l" class="form-control input-sm selectpicker" data-live-search="true" required><option value="1">PJC</option><option value="2">Asuncion</option><option value="3">Luque</option></select>

                                                      </div>


                                                      <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                                        <label class=" input-sm">Barrio:</label>
                                                        <select id="Barrio_idBarrio_l" name="Barrio_idBarrio_l" class="form-control input-sm selectpicker" data-live-search="true" required><option value="1">San Vicente</option><option value="2">San Juan</option><option value="3">Sajonia</option></select>
                                        
                                                      </div>

                                                      <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                        <label class=" input-sm">Calle Principal/Email:</label>
                                                        <input type="text" class="form-control input-sm" name="callePrincipal_l" id="callePrincipal_l" maxlength="256" placeholder="">
                                                      </div>

                                                      <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                        <label class=" input-sm">Calle Transversal:</label>
                                                        <input type="text" class="form-control input-sm" name="calleTransversal_l" id="calleTransversal_l" maxlength="256" placeholder="">
                                                      </div>

                                                      <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                        <label class=" input-sm">Nro. de casa:</label>
                                                        <input type="text" class="form-control input-sm" name="nroCasa_l" id="nroCasa_l" maxlength="256" placeholder="">
                                                      </div>

                                                      <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                                        <label class=" input-sm">Latitud:</label>
                                                        <input type="text" class="form-control input-sm search_latitude" name="longitud_l" id="longitud_l" maxlength="256" placeholder="">
                                                      </div>

                                                      <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                                        <label class=" input-sm">Longitud:</label>
                                                        <input type="text" class="form-control input-sm search_longitude" name="latitud_l" id="latitud_l" maxlength="256" placeholder="">
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


                                                      <button type="button" class="btn btn-success btn-block btn-xs"  onclick="addDetalleDireccion()" ><i class="fa fa-plus-circle"></i> Agregar</button>


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
                                        <!-- /.col -->
                                      </div>
                                      <!-- /.row -->
                                    </div>
                                  </div>
                                  <!-- /.box-default -->
                              </div>
                              </div>

                               <div class="row">
                                  <div class="col-md-12">

                                    <div class="box box-primary">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">Telefonos</h3><button type="button" class="btn btn-primary btn-xs" onclick="addDireccion()"><i class="fa fa-pagelines">Nuevo Tipo de Direccion</i></button><button type="button" class="btn btn-primary btn-xs" onclick="addDireccion()"><i class="fa fa-pagelines">Nueva Ciudad </i></button><button type="button" class="btn btn-primary btn-xs" onclick="addDireccion()"><i class="fa fa-pagelines">Nuevo Barrio</i></button>
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
                                                    <label class=" input-sm">Tipo de Telefono:</label>
                                                        <select id="TipoDireccion_Telefono_idTipoDireccion_Telefono_tel_l" name="TipoDireccion_Telefono_idTipoDireccion_Telefono_tel_l" class="form-control input-sm selectpicker" data-live-search="true" required><option>Particular</option><option>Laboral</option></select>
                                                      </div>

                                                      <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                        <label class=" input-sm">Telefono:</label>
                                                        <input type="text" class="form-control input-sm" name="telefono_l" id="telefono_l" maxlength="256" placeholder="">
                                                      </div>

                                                      <button type="button" class="btn btn-success btn-block"  onclick="addDetalleTelefono()" ><i class="fa fa-plus-circle"></i> Agregar</button>


                                                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 table-responsive">
                                                      <table id="detalleTelefono" class="table display compact">
                                                        <thead >
                                                              <th>Opciones</th>
                                                              <th>Tipo Telefono</th>
                                                              <th>Nro de Telefono</th>
                                                          </thead>
                                                          <tfoot>
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
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA0-PDFVLZN75GpsCirzkuCd5SICkZFrsw"></script>
<script type="text/javascript" src="scripts/legajo.js"></script>
<script type="text/javascript" src="scripts/generales.js"></script>


<?php 
}
ob_end_flush();
?>