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
                          <h1 class="box-title">Notas de Creditos de Compras <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Nro de Devolucion</th>
                            <th>Nro de Factura</th>
                            <th>Razon Social</th>
                            <th>Tipo de Comprobante</th>
                            <th>Fecha de Transaccion</th>
                            <th>Total</th>
                            <th>Detalles</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>          
                            <th>Opciones</th>
                            <th>Nro de Devolucion</th>
                            <th>Nro de Factura</th>
                            <th>Razon Social</th>
                            <th>Tipo de Comprobante</th>
                            <th>Fecha de Transaccion</th>
                            <th>Total</th>
                            <th>Detalles</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Compra:</label>
                            <input type="hidden" name="idNotaCreditoCompra" id="idNotaCreditoCompra"> 
                            <select id="Compra_idCompra" name="Compra_idCompra" class="form-control input-sm selectpicker" data-live-search="true" required></select>
                          </div>
                            
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Persona:</label> 
                            <select id="Persona_idPersona" name="Persona_idPersona" class="form-control input-sm selectpicker" data-live-search="true" required></select>
                          </div>

                          <div class="form-group col-lg-1 col-md-2 col-sm-6 col-xs-12">
                            <label>Nro de Factura:</label>
                            <input type="text" class="form-control" name="nroFactura" id="nroFactura" maxlength="50" placeholder="Nro de Factura" required>
                          </div>                           
<!--
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Fecha Transaccion:</label>
                            <input type="date" class="form-control" name="fechaTransaccion" id="fechaTransaccion" maxlength="10" placeholder="Fecha Transaccion" required>
                          </div> 
-->
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Fecha de Vencimiento:</label>
                            <input type="date" class="form-control" name="fechaVencimiento" id="fechaVencimiento" maxlength="10" placeholder="Fecha de Vencimiento" required>
                          </div> 

                          <div class="form-group col-lg-1 col-md-2 col-sm-6 col-xs-12">
                            <label>Timbrado:</label>
                            <input type="text" class="form-control" name="timbrado" id="timbrado" maxlength="50" placeholder="Timbrado" required>
                          </div> 

                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Vencimiento de Timbrado:</label>
                            <input type="date" class="form-control" name="vtoTimbrado" id="vtoTimbrado" maxlength="10" placeholder="Vencimiento de Timbrado" required>
                          </div>
<!--
                          <div class="form-group col-lg-1 col-md-2 col-sm-6 col-xs-12">
                            <label>Total Impuesto:</label>
                            <input type="number" class="form-control" name="totalImpuesto" id="totalImpuesto" maxlength="20" placeholder="Total de Impuesto" required>
                          </div>   

                          <div class="form-group col-lg-1 col-md-2 col-sm-6 col-xs-12">
                            <label>Sub Total:</label>
                            <input type="number" class="form-control" name="subTotal" id="subTotal" maxlength="20" placeholder="Sub Total" required>
                          </div>   

                          <div class="form-group col-lg-1 col-md-2 col-sm-6 col-xs-12">
                            <label>Total:</label>
                            <input type="number" class="form-control" name="totalC" id="totalC" maxlength="20" placeholder="Total" required>
                          </div>                                                        
 -->
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>


                          <div class="row">
                            <div class="col-md-12">
                              <div class="box box-danger">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Detalle de Nota de Credito Compra</h3>
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
                                            <button type="button" class="btn btn-info btn-block"  onclick="addDetalleNotaCreditoCompra()" ><i class="fa fa-plus-circle"></i> Agregar</button>
                                            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                              <table id="detalle" class="table"> 
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
         <!-- The Modal -->
        <div class="modal" id="modal_detalle">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
              <!-- Modal body -->
              <div class="modal-body">
                  <span>Detalle de Nota de Credito compra:<input type="text" disabled name="detalle4" id="detalle4" /> </span>
              <table id="tbllistado4" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                  <th>Articulo</th>
                  <th>Cantidad</th>
                  <th>Devuelve</th>
                  <th>Total Neto</th>
                  <th>Total</th>
                </thead>
                <tbody>                            
                </tbody>
                <tfoot>
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
        var cantidad = 0;//$(this).children("option:selected").val();
        //var dprecio = $(this).children("option:selected").attr("d-precio");
        //var dimpuesto = $(this).children("option:selected").attr("d-impuesto");
        var dnombre = $(this).children("option:selected").text();

       addDetalleNotaCreditoCompra(idArticulo,dnombre,cantidad);
    });
});





</script>

<script type="text/javascript" src="scripts/notaCreditoCompra.js"></script>
<?php 
}
ob_end_flush();
?>