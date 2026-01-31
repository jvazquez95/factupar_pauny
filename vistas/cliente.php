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
                          <h1 class="box-title">Clientes <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <table id="tbllistado4" class="table table-sm table-bordered table-hover table-striped table-condensed">
                        <table id="tbllistado">
                          <thead>
                            <th>Opciones</th>
                            <th>Razon social</th>
                            <th>Nombre comercial</th>
                            <th>Tipo documento</th>
                            <th>Nro. Documento</th>
                            <th>mail</th>
                            <th>Direcciones</th>
                            <th>Ver comodato</th>
                            <th>Usuario Ins</th>
                            <th>fecha Ins</th>
                            <th>Usuario Mod</th>
                            <th>Fecha Mod</th>
                            <th>Estado</th>
                            
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>          
                            <th>Opciones</th>
                            <th>Razon social</th>
                            <th>Nombre comercial</th>
                            <th>Tipo documento</th>
                            <th>Nro. Documento</th>
                            <th>Mail</th>
                            <th>Direcciones</th>
                            <th>Ver comodato</th>
                            <th>Usuario Ins</th>
                            <th>fecha Ins</th>
                            <th>Usuario Mod</th>
                            <th>Fecha Mod</th>
                            <th>Estado</th>
                            
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Razon social:</label>
                            <input type="hidden" name="idPersona" id="idPersona">
                            <input type="text" class="form-control" name="razonSocial" id="razonSocial" maxlength="250" placeholder="Nombre del cliente" required>
                          </div>
                          
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Nombre comercial:</label>
                            <input type="text" class="form-control" name="nombreComercial" id="nombreComercial" maxlength="250" placeholder="Nombre comercial" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Tipo Documento:</label>
                            <select class="form-control select-picker" name="tipoDocumento" id="tipoDocumento" required>
                              <option value="1">RUC</option>
                              <option value="2">CEDULA</option>
                              <option value="3">DOCUMENTO EXTRANJERO</option>
                            </select>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Número Documento:</label>
                            <input type="text" class="form-control" name="nroDocumento" id="nroDocumento" maxlength="20" placeholder="Documento" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Email:</label>
                            <input type="email" class="form-control" name="mail" id="mail" maxlength="50" placeholder="Email">
                          </div>


                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Tipo de Persona:<button class="btn btn-success"  onclick="crud('tipoPersona')" ><i class="fa fa-plus-circle"></i> Agregar</button></label>
                            <select id="tipoPersona_idTipoPersona" name="tipoPersona_idTipoPersona" class="form-control input-sm selectpicker" data-live-search="true" required></select>
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


      <style>
        /* Aumentar ancho del modal */
        .modal-lg {
            max-width: 90% !important;
        }
    </style>
  <!--Fin-Contenido-->
 <div class="container"> 
         <style>
        </style>
        <!-- The Modal -->
        <div class="modal " id="modal_detalle"> 
          <div class="modal-dialog modal-lg ">
            <div class="modal-content">
              <!-- Modal body -->
              <div class="modal-body">
                  <span>Detalle Direcciones:<input type="text" disabled name="detalle4" id="detalle4" /> </span>
                    <table id="tbllistadoDireccion" class="table table-striped table-bordered table-condensed table-hover responsive">
                      <thead>
                        <th>Ciudad</th>
                        <th>Direcciones</th>
                        <th>Latitud</th>
                        <th>Longitud</th>
                        <th>L</th>
                        <th>M</th>
                        <th>X</th>
                        <th>J</th>
                        <th>V</th>
                        <th>S</th>
                        <th>D</th>
                        <th>Vehiculo</th>
                        <th>Opciones</th>
                      </thead>
                      <tbody>                            
                      </tbody>
                      <tfoot>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
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




      <div class="container"> 
         <style>
        </style>
        <!-- The Modal -->
        <div class="modal " id="modal_detalle_telefono"> 
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <!-- Modal body -->
              <div class="modal-body">
                  <span>Telefonos:<input type="text" disabled name="detalle5" id="detalle5" /> </span>
                    <table id="tbllistado5" class="table table-striped table-bordered table-condensed table-hover responsive">
                      <thead>
                        <th>Tipo</th>
                        <th>Telefono</th>
                        <th>Usuario Creacion</th>
                        <th>Fecha Creacion</th>
                      </thead>
                      <tbody>                            
                      </tbody>
                      <tfoot>
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

      <div class="container">
  <style>
    /* Pon aquí tus estilos si los necesitas */
  </style>

  <!-- Modal para cambiar vehículo -->
  <div class="modal" id="modalVehiculo">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <!-- Cuerpo del modal -->
        <div class="modal-body">
          <h5>Cambiar Vehículo</h5>
          <form id="formVehiculo">
            <!-- Input oculto donde guardaremos el idDireccion -->
            <input type="hidden" id="idDireccionVehiculo" name="idDireccionVehiculo">

            <div class="form-group">
              <label for="selectVehiculo">Seleccione vehículo</label>
              <select class="form-control" id="selectVehiculo" name="selectVehiculo">
                <!-- Opciones cargadas dinámicamente via AJAX -->
              </select>
            </div>
          </form>
        </div>
        
        <!-- Footer del modal -->
        <div class="modal-footer">
          <!-- Botón para cerrar -->
          <button type="button" class="btn btn-danger" data-dismiss="modal">
            Close
          </button>
          <!-- Botón para guardar -->
          <button type="button" class="btn btn-primary" onclick="guardarVehiculo()">
            Guardar
          </button>
        </div>
      </div>
    </div>
  </div>
</div>



       <div class="container"> 
         <style>
        </style>
        <!-- The Modal -->
        <div class="modal " id="modal_detalle2"> 
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
              <!-- Modal body -->
              <div class="modal-body">
                  <span>Detalle de Comodato por Persona:<input type="text" disabled name="detalle2" id="detalle2" /> </span>
                    <table id="tbllistado2" class="table table-striped table-bordered table-condensed table-hover">
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

<script type="text/javascript" src="scripts/cliente.js"></script>
<script type="text/javascript" src="scripts/generales.js"></script>

<?php 
}
ob_end_flush();
?>