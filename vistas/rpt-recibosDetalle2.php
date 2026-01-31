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
if ($_SESSION['ventas']==1)
{
?> 
  </head>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
	   <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
     
                    <div class="box-header with-border">
                          <h1 class="box-title">Lista de Recibos Detallado</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label>Ingrese periodo principal</label>
                                <input type="hidden" name="impresion" id="impresion"><br>
                                <input type="date" class="form-control" name="f_i" id="f_i" value="<?php $month = date('m'); $year = date('Y'); echo date('Y-m-d', mktime(0,0,0, $month, 1, $year)); ?>"><br>
                                <input type="date" class="form-control" name="f_f" id="f_f" value="<?php $month = date('m'); $year = date('Y'); $day = date("d", mktime(0,0,0, $month+1, 0, $year)); echo date('Y-m-d', mktime(0,0,0, $month, $day, $year)); ?>"><br>
                
                    
              </div>
			  
			  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Cliente</label>
<!--                               <select id="cliente" name="cliente" class="form-control selectpicker" data-live-search="true" required></select>
 -->
                            <select  title="Seleccione Cliente" class="selectpicker selector_persona form-control person" data-style="btn-warning" name="cliente" id="cliente"  data-live-search="true"></select>



                        </div>
						<input type="button" class="btn btn-primary" name="actualizar" id="actualizar" onclick="listar();" value="Mostrar">
                    <!-- Esta porcin de codigo nos ayuda para evitar el salto de linea por campo en el datatable -->
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                                                                    <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                              <th>Id</th>
                               <th>Cliente</th>
                              <th>RUC o Documento</th>
                              <th>Nro de Habilitacion</th>
                               <th>Fecha de Recibo</th>
                              <th>Fecha de Factura</th>
                              <th>Fecha de Venc. Cuota</th>
                              <th>Nro Cuota</th>
                              <th>Monto Cuota</th>
                              <th>Monto Pagado</th>
                              <th>Dias de Atraso</th>
                              <th>Termino de Pago</th>
                              <th>Nro de Factura</th>
                              <th>Usuario</th>
                              <th>Forma Pago</th> 
                          </thead>
                            <tbody>       
                            </tbody>
                            <tfoot>
                <th>Id</th>
                <th>Cliente</th>
                <th>RUC o Documento</th>
                <th>Nro de Habilitacion</th>
                <th>Fecha de Recibo</th>
                <th>Fecha de Factura</th>
                <th>Fecha de Venc. Cuota</th>
                <th>Nro Cuota</th>
                <th>Monto Cuota</th>
                <th>Monto Pagado</th>
                <th>Dias de Atraso</th>
                <th>Termino de Pago</th>
                <th>Nro de Factura</th>
                <th>Usuario</th>                       
                <th>Forma Pago</th>                
							</tfoot>
                          </table>
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
<script type="text/javascript" src="../public/js/JsBarcode.all.min.js"></script>
<script type="text/javascript" src="../public/js/jquery.PrintArea.js"></script>
<script type="text/javascript" src="scripts/rpt-recibosDetalle2.js"></script>

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




</script>

<?php 
}
ob_end_flush();
?>