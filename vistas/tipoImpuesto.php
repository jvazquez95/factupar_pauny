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
if ($_SESSION['parametricas']==1)
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
                          <h1 class="box-title">Tipo de impuestos <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Descripcion</th>
                            <th>Porcentaje de impuesto</th>
                            <th>Porcentaje de impuesto Reg. Turismo</th>
                            <th>CC Mercaderias</th>
                            <th>CC Costo Mercaderias</th>
                            <th>CC Ventas Mercaderias</th>
                            <th>CC IVA</th>
                            <th>CC Servicios</th>
                            <th>CC Nota de Credito</th>
                            <th>CC Compras</th>
                            <th>CC Regimen Turismo</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Descripcion</th>
                            <th>Porcentaje de impuesto</th>
                            <th>Porcentaje de impuesto Reg. Turismo</th>
                            <th>CC Mercaderias</th>
                            <th>CC Costo Mercaderias</th>
                            <th>CC Ventas Mercaderias</th>
                            <th>CC IVA</th>
                            <th>CC Servicios</th>
                            <th>CC Nota de Credito</th>
                            <th>CC Compras</th>
                            <th>CC Regimen Turismo</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Descripcion:</label>
                            <input type="hidden" name="idTipoImpuesto" id="idTipoImpuesto">
                            <input type="text" class="form-control" name="descripcion" id="descripcion" maxlength="50" placeholder="Nombre" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Porcentaje de impuesto:</label>
                            <input type="text" class="form-control" name="porcentajeImpuesto" id="porcentajeImpuesto" maxlength="256" placeholder="Descripción">
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-1 col-xs-12">
                             <label class=" input-sm">Cuenta Contable Mercaderias:</label>
                             <select id="CuentaContable_mercaderiaId" name="CuentaContable_mercaderiaId" class="form-control input-sm selectpicker" data-live-search="true" required></select>
                          </div>

                 		<div class="form-group col-lg-2 col-md-2 col-sm-1 col-xs-12">
                             <label class=" input-sm">Cuenta Contable Costo Mercaderias:</label>
                             <select id="CuentaContable_costoMercaderiaId" name="CuentaContable_costoMercaderiaId" class="form-control input-sm selectpicker" data-live-search="true" required></select>
                          </div> 


                          <div class="form-group col-lg-2 col-md-2 col-sm-1 col-xs-12">
                             <label class=" input-sm">Cuenta Contable Ventas Mercaderias:</label>
                             <select id="CuentaContable_ventasMercaderiasId" name="CuentaContable_ventasMercaderiasId" class="form-control input-sm selectpicker" data-live-search="true" required></select>
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-1 col-xs-12">
                            <label class=" input-sm">Cuenta Contable Impuestos:</label>
                            <select id="CuentaContable_impuestoId" name="CuentaContable_impuestoId" class="form-control input-sm selectpicker" data-live-search="true" required></select>
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-1 col-xs-12">
                            <label class=" input-sm">Cuenta Contable Servicios:</label>
                            <select id="CuentaContable_servicioId" name="CuentaContable_servicioId" class="form-control input-sm selectpicker" data-live-search="true" required></select>
                          </div>

                 <div class="form-group col-lg-2 col-md-2 col-sm-1 col-xs-12">
                            <label class=" input-sm">Cuenta Nota de Credito:</label>
                            <select id="CuentaContable_notaCreditoId" name="CuentaContable_notaCreditoId" class="form-control input-sm selectpicker" data-live-search="true" required></select>
                          </div>

                 <div class="form-group col-lg-2 col-md-2 col-sm-1 col-xs-12">
                            <label class=" input-sm">Cuenta Contable Compras:</label>
                            <select id="CuentaContable_comprasId" name="CuentaContable_comprasId" class="form-control input-sm selectpicker" data-live-search="true" required></select>
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
<script type="text/javascript" src="scripts/tipoImpuesto.js"></script>
<?php 
}
ob_end_flush();
?>


