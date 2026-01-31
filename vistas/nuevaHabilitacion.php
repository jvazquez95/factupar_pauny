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
if ($_SESSION['parametricas']>=0)    // ==1 
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
                        <h1 class="box-title">Cargar habilitacion</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <div class="box-header with-border">
                          <h1 class="box-title">Marcas <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <div id="buscador">
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Caja:</label>
                          <select id="Caja_idCaja" name="Caja_idCaja" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>                      
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Usuario:</label>
                          <select id="Persona_idPersona" name="Persona_idPersona" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>

                       <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          <label>Fecha Inicio</label>
                          <input type="date" class="form-control" name="fi" id="fi" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          <label>Fecha Fin</label>
                          <input type="date" class="form-control" name="ff" id="ff" value="<?php echo date("Y-m-d"); ?>">
                        </div>                        

                        <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                          <label>Moneda:</label>
                          <select id="Moneda_idMoneda" name="Moneda_idMoneda" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>

                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          <label>Estado(*):</label>
                          <select name="tipo_comprobante" id="tipo_comprobante" class="form-control selectpicker" required="">
                             <option selected value="1">Todos</option>
                             <option value="2">Abiertos</option>
                             <option value="3">Cerrados</option>
                             <option value="4">Inactivos</option>
                          </select>
                        </div>

                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <button class="btn btn-primary" type="button" id="btnFiltrar" onclick="filtrar()"><i class="fa fa-save"></i> Filtrar</button>
                          <button class="btn btn-success" onclick="mostrarProveedor()" type="button"><i class="fa fa-arrow-circle-left"></i> Nueva Habilitacion</button>
                        </div>
                    </div>      
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Nro. Habilitacion</th>
                            <th>Caja</th>
                            <th>Cajero</th>
                            <th>Fecha Apertura</th>
                            <th>Fecha Cierre</th> 
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Nro. Habilitacion</th>
                            <th>Caja</th>
                            <th>Cajero</th>
                            <th>Fecha Apertura</th>
                            <th>Fecha Cierre</th> 
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Caja:</label>
                            <select id="Caja_idCajaD1" name="Caja_idCajaD1" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Usuario:</label>
                            <select id="Persona_idPersonaD1" name="Persona_idPersonaD1" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Moneda:</label>
                            <select onchange="verDetalleProveedor(this);" id="Moneda_idMonedaD1" name="Moneda_idMonedaD1" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>                          
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Denominacion:</label>
                            <input type="text" class="form-control" name="imagen" id="imagen" maxlength="50" placeholder="imagen" required>
                          </div>                          
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button> 
                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
                    </div>
 
                  <!-- /.box -->
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
                                    <span>Detalle de Habilitacion:<input type="text" disabled name="detalle" id="detalle" /> </span>
                                <table id="tbllistado4" class="table table-striped table-bordered table-condensed table-hover">
                                  <thead>
                                    <th>Nro. Habilitacion</th>
                                    <th>Nro. Item</th>
                                    <th>Moneda</th>
                                    <th>Denominacion</th>
                                    <th>Monto Apertura</th>
                                    <th>Monto Cierre</th>
 
                                  </thead>
                                  <tbody>                            
                                  </tbody>
                                  <tfoot>
                                    <th>Nro. Habilitacion</th>
                                    <th>Nro. Item</th>
                                    <th>Moneda</th>
                                    <th>Denominacion</th>
                                    <th>Monto Apertura</th>
                                    <th>Monto Cierre</th>
 
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
<script type="text/javascript" src="scripts/nuevaHabilitacion.js"></script>
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
    data:{keyword:$(this).val(), tipoPersona: 3},
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
    });
});









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
        var dprecio = $(this).children("option:selected").attr("d-precio");
        var dimpuesto = $(this).children("option:selected").attr("d-impuesto");
        var didImpuesto = $(this).children("option:selected").attr("d-idImpuesto");
        var dnombre = $(this).children("option:selected").text();

        agregarDetalle(idArticulo,dnombre,dprecio,didImpuesto, dimpuesto);
    });
});






</script>


<?php 
}
ob_end_flush();
?>


