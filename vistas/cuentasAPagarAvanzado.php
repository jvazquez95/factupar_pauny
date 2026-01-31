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
//if ($_SESSION['consultac']==1)
//{
?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
     <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Cuentas a pagar - Avanzado </h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Fecha Inicio</label>
                          <input type="date" class="form-control" name="fechai" id="fechai" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Fecha Fin</label>
                          <input type="date" class="form-control" name="fechaf" id="fechaf" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Proveedor</label>

                            <select  title="Seleccione Cliente" class="selectpicker selector_persona form-control person" data-style="btn-warning" name="proveedor" id="proveedor"  data-live-search="true"></select>

                        </div>
						<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Ordenar por:</label>
                              <select id="orden" name="orden" class="form-control selectpicker" data-live-search="true" required>
                                    <option value='0'>Fecha de Vencimiento</option>
                                    <option value='1'>Fecha de Emision</option>
                                    <option value='2'>Prioridad de Proveedor</option>
                              </select>
                        </div>
						
						<!--<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Ver Problemas de Stock</label>
                              <select id="problemas" name="problemas" class="form-control selectpicker" data-live-search="true" required>
                                    <option value='0'>No</option>
                                    <option value='1'>Si</option>
                              </select>
                        </div>
						
						
						<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Ver Costo de Transporte</label>
                              <select id="costobulto" name="costobulto" class="form-control selectpicker" data-live-search="true" required>
                                    <option value='0'>No</option>
                                    <option value='1'>Si</option>
                              </select>
                        </div>
						-->

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <input type="button" class="btn btn-primary" name="actualizar" id="actualizar" value="Actualizar">
                        </div>
            
            
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Nombre Comercial</th>
                            <th>Razon Social</th>
                            <th>RUC</th>
							<th>Fecha de Factura</th>
							<th>Fecha de Vencimiento</th>
							<th>Condicion de compra</th>
                            <th>Nro de Factura</th>
                            <th>Total de Factura</th>
                            <th>Saldo de Factura</th>
                            <th>Cuota</th>
							<th>Monto</th>
							<th>Saldo</th>
              <th>Dias vencido</th>
							<th>Origen</th>
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
							<th></th>
                          </tfoot>
                        </table>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
<?php
//}
//else
//{
//  require 'noacceso.php';
//}
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
    data:{keyword:$(this).val(), tipoPersona: 2},
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



<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="scripts/cuentasAPagarAvanzado.js"></script>
<?php 
}
ob_end_flush();
?>


