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
if ($_SESSION['stock']==1)
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
                          <h1 class="box-title">Comodato <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Deposito</th>
                            <th>Fecha Transaccion</th>
                            <th>Direccion</th> 
                            <th>Razon Social</th>
                            <th>Compromiso venta mensual</th>
                            <th>Confirmar</th> 
                            <th>Estado</th> 
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>          
                            <th>Opciones</th>
                            <th>Deposito</th>
                            <th>Fecha Transaccion</th>
                            <th>Direccion</th> 
                            <th>Razon Social</th>
                            <th>Compromiso venta mensual</th>
                            <th>Confirmar</th> 
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="row">
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Deposito:</label>
                            <input type="hidden" name="idAjusteStock" id="idAjusteStock"> 
                            <select id="Deposito_IdDeposito" name="Deposito_IdDeposito" class="form-control input-sm selectpicker" data-live-search="true" required></select>
                          </div>
                          <div class="form-group col-lg-1 col-md-2 col-sm-6 col-xs-12">
                            <label>Cliente:</label>
                            <select  title="Selecciona Persona" onchange="noCambiar(this);" class="selectpicker selector_persona form-control person" data-style="btn-warning" name="Cliente_idCliente" id="Cliente_idCliente"  data-live-search="true"></select>
                          </div>                           
                          <div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-12">
                            <label>Direccion(*):</label>
                            <select name="Direccion_idDireccion" id="Direccion_idDireccion" class="form-control selectpicker" >
                            </select>
                          </div>
                          <div class="form-group col-lg-1 col-md-2 col-sm-6 col-xs-12">
                            <label>Comentario:</label>
                            <input type="text" class="form-control" name="comentario" id="comentario" maxlength="50" placeholder="Comentario" required>
                          </div> 
						  <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Imagen:</label>
                            <input type="file" onchange="imagenTest(this);" class="form-control" name="imagen" id="imagen">
                            <input type="hidden" name="imagenactual" id="imagenactual">
                            <img src="" width="150px" height="120px" id="imagenmuestra">
                          </div>
                          <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                          <label class=" input-sm">Compromiso venta mensual:</label>
                           <input type="number" class="form-control input-sm " name="compromisoVenta" id="compromisoVenta" maxlength="12" placeholder="Cantidad venta mensual" required>
                         </div>                             
<!--                      
                          <div class="form-group col-lg-1 col-md-2 col-sm-6 col-xs-12">
                            <label>Cantidad Total:</label>
                            <input type="number" class="form-control" name="cantidadTotal" id="cantidadTotal" maxlength="20" placeholder="Cantidad Total" required>
                          </div>   

                          <div class="form-group col-lg-1 col-md-2 col-sm-6 col-xs-12">
                            <label>Costo Total:</label>
                            <input type="number" class="form-control" name="costoTotal" id="costoTotal" maxlength="20" placeholder="Costo Total" required>
                          </div>                                                        
 -->
                        
</div>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="box box-danger">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Detalle de Comodato</h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                      <div class="row">
                                        <div class="col-md-12">
                                          <div class="form-group">
                                            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                              <label class=" input-sm">Seleccione articulo:</label>
                                                <input type="hidden" class="form-control input-sm " name="costo" id="costo" maxlength="12" placeholder="Costo">
                                           
                                              <input type="hidden" class="form-control input-sm " name="subtotal" id="subtotal" maxlength="20" placeholder="Sub Total">
                                           
                                                <select   title="Selecciona Articulo" class="selectpicker selector_articulo form-control" data-style="btn-ligth" name="buscar_articulo" id="buscar_articulo"  data-live-search="true">
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                              <label class=" input-sm">cantidad:</label>
                                                <input type="number" class="form-control input-sm " name="cantidad" id="cantidad" maxlength="12" placeholder="Cantidad">
                                            </div>                                            
                                                                    
                                            <button type="button" class="btn btn-info btn-block"  onclick="addDetalleAjusteStock()" ><i class="fa fa-plus-circle"></i> Agregar</button>
                                            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                              <table id="detalleAjusteStock" class="table table-ligth"> 
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
<?php
}
else
{
  require 'noacceso.php';
}
require 'footer.php';
?>



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
    data:{keyword:$(this).val(), tipoPersona: 1},
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



// AJAX call for autocomplete 
$(document).ready(function(){
  $('select.selector_articulo').selectpicker();
    $(".bs-searchbox input").on('input', function() {

   var esto = this; 
    $.ajax({
    type: "POST",
    url: "../ajax/venta.php?op=listarproductos",
    data:{ keyword: $(this).val(), Persona_idPersona: $('#Cliente_idCliente').val(), terminoPago: $('#TerminoPago_idTerminoPago').val() },
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
        var idImpuesto = $(this).children("option:selected").attr("d-idImpuesto");
        var dinteres = $(this).children("option:selected").attr("d-interes");
        var dcapital = $(this).children("option:selected").attr("d-capital");
        var dstock = $(this).children("option:selected").attr("d-stock");
        var dnombre = $(this).children("option:selected").text();

       // agregarDetalle(idArticulo,dnombre,dprecio,idImpuesto,dimpuesto, dcapital, dinteres, dstock);
    });
});

</script> 


<script type="text/javascript" src="scripts/comodato.js"></script>
<?php 
}
ob_end_flush();
?>