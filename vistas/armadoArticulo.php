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
                          <h1 class="box-title">Armado Articulos <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th> 
                            <th>Fecha Transaccion</th>
                            <th>Nombre</th> 
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>          
                            <th>Opciones</th> 
                            <th>Fecha Transaccion</th>
                            <th>Nombre</th> 
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="row">
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <input type="hidden" name="idArmadoArticulo" id="idArmadoArticulo"> 
                                              
                              <label>Seleccione articulo:</label>

                              <select   title="Selecciona Articulo1" class="selectpicker selector_articulo1 form-control" data-style="btn-ligth" name="buscar_articulo1" id="buscar_articulo1"  data-live-search="true">
                              </select>
                                         
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Nombre:</label>
                            <input type="text" class="form-control" name="comentario" id="comentario" maxlength="50" placeholder="Nombre" required>
                          </div>  
                        
                        </div>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="box box-danger">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Detalle de Armado de articulo</h3>
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
                                           
                                                <select   title="Selecciona Articulo" class="selectpicker selector_articulo2 form-control" data-style="btn-ligth" name="buscar_articulo" id="buscar_articulo"  data-live-search="true">
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                              <label class=" input-sm">cantidad:</label>
                                                <input type="number" class="form-control input-sm " name="cantidad" id="cantidad" maxlength="12" placeholder="Cantidad">
                                            </div>                                            
                                                                    
                                            <button type="button" class="btn btn-info btn-block"  onclick="addDetalleArmadoArticulo()" ><i class="fa fa-plus-circle"></i> Agregar</button>
                                            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                              <table id="detalleArmadoArticulo" class="table table-ligth"> 
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
// AJAX call for autocomplete 
$(document).ready(function(){
  $('select.selector_articulo1').selectpicker();
    $(".bs-searchbox input").on('input', function() {

   var esto = this; 
    $.ajax({
    type: "POST",
    url: "../ajax/compra.php?op=listarproductos",
    data:'keyword='+$(this).val(),
    success: function(data){
       $("select.selector_articulo1").html(data);
      $("select.selector_articulo1").selectpicker("refresh");
    },
    error: function(data){
        console.log("NO se pudo enviar");
    }
    });


  });
 

    $("select.selector_articulo1").change(function(){
    });
});

$(document).ready(function(){
   

  $('select.selector_articulo2').selectpicker();
    $(".bs-searchbox input").on('input', function() {

   var esto = this; 
    $.ajax({
    type: "POST",
    url: "../ajax/compra.php?op=listarproductos2",
    data:'keyword='+$(this).val(),
    success: function(data){
       $("select.selector_articulo2 ").html(data);
      $("select.selector_articulo2").selectpicker("refresh");
    },
    error: function(data){
        console.log("NO se pudo enviar");
    }
    });
    
    
  });

    $("select.selector_articulo2").change(function(){
    });
});


</script>


<script type="text/javascript" src="scripts/armadoArticulo.js"></script>
<?php 
}
ob_end_flush();
?>