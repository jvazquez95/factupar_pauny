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
                          <h1 class="box-title">Obligacion <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Nro de Obligacion</th>
                            <th>Persona</th>
                            <th>Moneda</th>
                            <th>Tipo de Documento</th>
                            <th>Fecha de Vencimiento</th>
                            <th>Fecha Posible de Pago</th>   
                            <th>Fecha de Pago</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Nro de Obligacion</th>
                            <th>Persona</th>
                            <th>Moneda</th>
                            <th>Tipo de Documento</th>
                            <th>Fecha de Vencimiento</th>
                            <th>Fecha Posible de Pago</th>    
                            <th>Fecha de Pago</th>                                                      
                            <th>Estado</th>   
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Nro de Obligacion:</label>
                            <input type="hidden" name="idObligacion" id="idObligacion">
                            <input type="text" class="form-control" name="NroObligacion" id="NroObligacion" maxlength="50" placeholder="Nro de Obligacion" required>
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Persona:</label>
                            <select id="Persona_idPersona" name="Persona_idPersona" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>
                         <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Moneda:</label>                   
                            <select id="Moneda_idMoneda" name="Moneda_idMoneda" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>
                         <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Tipo de Documento:</label>                   
                            <select id="TipoDocumento_idTipoDocumento" name="TipoDocumento_idTipoDocumento" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>                          
                         <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Fecha de Vencimiento:</label>                   
                            <input type="Date" class="form-control" name="fechaVencimiento" id="fechaVencimiento" maxlength="50" placeholder="Fecha de Vencimiento" required></input>
                          </div> 
                         <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Fecha de Posible Pago:</label>                   
                            <input type="Date" class="form-control" name="fechaPosiblePago" id="fechaPosiblePago" maxlength="50" placeholder="Fecha de Posible Pago"></input>
                          </div>                           
                         <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">      
                            <label>Fecha de Pago:</label>                    
                            <input type="Date" class="form-control" name="fechadePago" id="fechadePago" maxlength="1" placeholder="Fecha de Pago" ></input>   
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
<script type="text/javascript" src="scripts/obligacion.js"></script>
<?php 
}
ob_end_flush();
?>


