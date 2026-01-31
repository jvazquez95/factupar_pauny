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
                          <h1 class="box-title"> Movimientos de Stock con Habilitacion asociada <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->

                    <div id="cabecera">

                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Deposito Origen:</label>
                          <select id="Deposito_idDeposito_Origen" name="Deposito_idDeposito_Origen" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Deposito Destino:</label>
                          <select id="Deposito_idDeposito_Destino" name="Deposito_idDeposito_Destino" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>


                       <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          <label>Fecha Inicio</label>
                          <input type="date" class="form-control" name="fi" id="fi" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          <label>Fecha Fin</label>
                          <input type="date" class="form-control" name="ff" id="ff" value="<?php echo date("Y-m-d"); ?>">
                        </div>
 

                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Estado(*):</label>
                            <select name="estado" id="estado" class="form-control selectpicker" required="">
                               <option selected value="999">Todos</option>
                               <option value="1">Ingresado</option>
                               <option value="2">En transito</option>
                               <option value="3">Aprobado</option>
                               <option value="4">Anulado</option>
                            </select>
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="button" id="btnFiltrar" onclick="filtrar()"><i class="fa fa-save"></i> Filtrar</button>                           
                          </div>                    
                          <div class="panel-body table-responsive" id="listadoregistros">
                              <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                                <thead>
                                  <th>Opciones</th>
                                  <th>Aprobar</th>
                                  <th>Deposito Origen</th>
                                  <th>Deposito Destino</th>
                                  <th>Fecha</th>
                                  <th>Cantidad</th>
                                  <th>Monto</th>
                                  <th>Enviar</th>
                                  <th>Detalles</th>
                                  <th>Estado</th>
                                </thead>
                                <tbody>                            
                                </tbody>
                                <tfoot>          
                                  <th>Opciones</th>
                                  <th>Aprobar</th>
                                  <th>Deposito Origen</th>
                                  <th>Deposito Destino</th>
                                  <th>Fecha</th>
                                  <th>Cantidad</th>
                                  <th>Monto</th>
                                  <th>Enviar</th>
                                  <th>Detalles</th>
                                  <th>Estado</th>
                                </tfoot>
                              </table>
                          </div>
                    </div>    
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Deposito Origen:</label>
                            <input type="hidden" name="idMovimientoStock" id="idMovimientoStock">
                            <select id="Deposito_idDepositoOrigen" name="Deposito_idDepositoOrigen" class="form-control input-sm selectpicker" data-live-search="true" required></select>
                          </div>
                            
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Deposito Destino:</label>
                            <select id="Deposito_idDepositoDestino" name="Deposito_idDepositoDestino" class="form-control input-sm selectpicker" data-live-search="true" required></select>
                          </div>
 
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>comentario:</label>
                            <input type="text" class="form-control" name="comentario" id="comentario" maxlength="100" placeholder="Comentario" required>
                          </div>                                                       
 
                          <br>
                          <br>
                          <br>
                          <br>
                          <br>
                          <br>
                          <br>


                          <div class="row">
                            <div class="col-md-12">
                              <div class="box box-danger">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Detalle de Movimiento de Stock</h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                      <div class="row">
                                        <div class="col-md-12">
                                          <div class="form-group">                           
                                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <select   title="Selecciona Articulo" class="selectpicker selector_articulo form-control" data-style="btn-warning" name="buscar_articulo" id="buscar_articulo"  data-live-search="true">
                                                        </select>
                                          </div>
                                            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12"> 
                                              <table id="detalle" class="table table-striped table-condensed"> 
                                                <thead >
                                                      <th>Opciones</th>
                                                      <th>Articulo</th>
                                                      <th>Cantidad</th>
                                                                                   
                                                  </thead>
                                                  <tfoot>
                                                      <th>Opciones</th>
                                                      <th>Articulo</th>
                                                      <th>Cantidad</th>
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
                          <div class="row">
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
        <!-- The Modal -->
        <div class="modal " id="modal_detalle"> 
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
              <!-- Modal body -->
              <div class="modal-body">
                  <span>Detalle de Movimiento Stock:<input type="text" disabled name="detalle4" id="detalle4" /> </span>
                    <table id="tbllistado4" class="table table-striped table-bordered table-condensed table-hover">
                      <thead>
                        <th>Articulo</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
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


<?php
}
else
{
  require 'noacceso.php';
}
require 'footer.php';
?>


<script type="text/javascript">
// AJAX call for autocomplete 
$(document).ready(function(){
  $('select.selector_articulo').selectpicker();
    $(".bs-searchbox input").keyup(function(){

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
        var dprecio = 0;//$(this).children("option:selected").attr("d-precio");
        var dimpuesto = 0;//= $(this).children("option:selected").attr("d-impuesto");
        var dnombre = $(this).children("option:selected").text();

        agregarDetalle(idArticulo,dnombre);
    });
});
 

</script>


<script type="text/javascript" src="scripts/movimientoStockHabilitacion.js"></script>
<?php 
}
ob_end_flush();
?>