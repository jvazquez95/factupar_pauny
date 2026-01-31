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
if ($_SESSION['contabilidad']==1)
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
                          <h1 class="box-title">Movimiento Bancario <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Ano</th>
                            <th>Mes</th>
                            <th>Moneda</th>
                            <th>Nro de Cuenta</th>
                            <th>Banco</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Ano</th>
                            <th>Mes</th>
                            <th>Moneda</th>
                            <th>Nro de Cuenta</th>
                            <th>Banco</th>                                                   
                            <th>Estado</th>   
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Ano:</label>
                            <input type="hidden" name="idMovimientoBancario" id="idMovimientoBancario">
                            <input type="number" class="form-control" name="ano" id="ano" maxlength="4" placeholder="Ano" required>
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Mes:</label>
                            <input type="number" class="form-control" name="mes" id="mes" maxlength="2" placeholder="Mes" required>
                          </div>
                         <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Moneda:</label>                   
                            <select id="Moneda_idMoneda" name="Moneda_idMoneda" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>
                         <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Nro de Cuenta:</label>                   
                            <input type="text" class="form-control" name="nroCuenta" id="nroCuenta" maxlength="20" placeholder="Nro de Cuenta" required></input>    
                          </div>                              
                         <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">     
                            <label>Banco:</label>                    
                            <select id="Banco_idBanco" name="Banco_idBanco" class="form-control selectpicker" data-live-search="true" required></select>  
                          </div>   
                         <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Nro de Secuencia:</label>                   
                            <input type="number" class="form-control" name="nroSecuencia" id="nroSecuencia" maxlength="12" placeholder="Nro de Secuencia" required></input>    
                          </div>      
                         <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Fecha de Movimiento:</label>                   
                            <input type="date" class="form-control" name="fechaMovimiento" id="fechaMovimiento"  placeholder="Fecha de Movimiento" required></input>    
                          </div>      
                         <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Nro de Orden:</label>                   
                            <input type="number" class="form-control" name="nroOrden" id="nroOrden" maxlength="12" placeholder="Nro de Orden" required></input>    
                          </div>      
                         <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Beneficiario:</label>                   
                            <input type="text" class="form-control" name="beneficiario" id="beneficiario" maxlength="120" placeholder="Beneficiario" required></input>    
                          </div>      
                         <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Importe:</label>                   
                            <input type="number" class="form-control" name="Importe" id="Importe" maxlength="18" placeholder="Importe" required></input>    
                          </div>      
                         <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Tipo de Movimiento:</label>                   
                            <select id="tipoMovimiento" name="tipoMovimiento" class="form-control input-sm selectpicker" data-live-search="true" required>
                              <option value="0" selected>Ingreso</option>
                              <option value="1">Egreso</option>
                            </select>  
                          </div>      
                         <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Concepto:</label>                   
                            <input type="text" class="form-control" name="concepto" id="concepto" maxlength="60" placeholder="Concepto" required></input>    
                          </div>      
                         <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Nro de Documento:</label>                   
                            <input type="number" class="form-control" name="nroDocumento" id="nroDocumento" maxlength="15" placeholder="Nro de Documento" required></input>    
                          </div>
                         <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Fecha de Cobro:</label>                   
                            <input type="date" class="form-control" name="fechaCobro" id="fechaCobro" maxlength="15" placeholder="Fecha de Cobro" required></input>    
                          </div>     
                         <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Fecha Emision:</label>                   
                            <input type="date" class="form-control" name="fechaEmision" id="fechaEmision" maxlength="15" placeholder="Fecha de Emision" required></input>    
                          </div>    
                         <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Fecha Anulacion:</label>                   
                            <input type="date" class="form-control" name="fechaAnulacion" id="fechaAnulacion" maxlength="15" placeholder="Fecha de Anulacion" required></input>    
                          </div>    
                         <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Situacion:</label>                   
                            <input type="number" class="form-control" name="situacion" id="situacion" maxlength="12" placeholder="Situacion" required></input>    
                          </div>                                                                                                                                                         
                         <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">     
                            <label>Persona:</label>                    
                            <select id="Persona_idPersonaPersonal" name="Persona_idPersonaPersonal" class="form-control selectpicker" data-live-search="true" required></select>  
                          </div>  
                         <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Cargo:</label>                   
                            <input type="text" class="form-control" name="cargo" id="cargo" maxlength="10" placeholder="Cargo" required></input>    
                          </div>
                         <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">     
                            <label>Centro de Costo:</label>                    
                            <select id="CentroCosto_idCentroCosto" name="CentroCosto_idCentroCosto" class="form-control selectpicker" data-live-search="true" required></select>  
                          </div>                               
                         <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Indicador de Sueldo:</label>                   
                            <input type="number" class="form-control" name="indicadorSueldo" id="indicadorSueldo" maxlength="12" placeholder="Indicador de Sueldo" required></input>    
                          </div>
                         <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12"> 
                            <label>Mes Sueldo:</label>                   
                            <input type="number" class="form-control" name="mesSueldo" id="mesSueldo" maxlength="12" placeholder="Mes de Sueldo" required></input>    
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
<script type="text/javascript" src="scripts/movimientoBancario.js"></script>
<?php 
}
ob_end_flush();
?>


