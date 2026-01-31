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
                          <h1 class="box-title">Actualizar Precios </h1>
                    </div>
					
						<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Lista de Precios</label>
                          <select id="GrupoPersona_idGrupoPersona" name="GrupoPersona_idGrupoPersona" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>
                        
						<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Sucursal</label>
                          <select id="Sucursal_idSucursal" name="Sucursal_idSucursal" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>
                        

                        <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                          <label>Proveedor</label>
                          <select id="Persona_idPersona" name="Persona_idPersona" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>
                        
                        <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                          <label>Grupo de Articulo</label>
						  <select id="GrupoArticulo_idGrupoArticulo" name="GrupoArticulo_idGrupoArticulo" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>
						
						<div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                          <label>Marca</label>
                          <select id="Marca_idMarca" name="Marca_idMarca" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>
						
						<div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                          <label>Categoria</label>
						  <select id="Categoria_idCategoria" name="Categoria_idCategoria" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>

                        <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
						<br>
						 <input type="button" class="btn btn-success" name="actualizar" id="actualizar"  value="Filtrar" >
                        </div>
						
						<div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                          <label>Ajuste %(Afecta solo las formulas visibles en el)</label>
                          <input type="text" class="form-control" name="ajuste" id="ajuste" value="0">
                        </div>
<!--
                          <div class="form-group col-lg-3 col-md-3 col-sm-4 col-xs-12">
                          <label>Tasa de cambio - Actual</label>
                          <input type="text" class="form-control" name="tasa1" id="tasa1" value="0" disabled>
                        </div>


                        <div class="form-group col-lg-3 col-md-3 col-sm-4 col-xs-12">
                          <label>Tasa de cambio(Afecta a todas las formulas de precios en USD)</label>
                          <input type="text" class="form-control" name="tasa" id="tasa" value="0">
                        </div>
-->
                        
						
						<div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                        <br>
						<br>
						  <input type="button" class="btn btn-warning" name="actualizar2" id="actualizar2"  value="Actualizar" >
						</div>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <form name="formulario" id="formulario" method="POST">

                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                              <thead>
                                    <th>Lista de Precios</th>
									<th>Codigo</th>
									<th>Articulo</th>
                                    <th>Margen Anterior</th>
                                    <th>Margen Nuevo</th>
                                    <th>Diferencia</th>
                                </thead>
                                <tfoot>
                                    <th>PROMEDIO</th>
                                    <th><h6 id="pv1">0.00</h4><input type="hidden" name="p1n" id="p1n"></th>
                                    <th><h6 id="pv2">0.00</h4><input type="hidden" name="p2n" id="p2n"></th>
                                    <th><h6 id="pv3">0.00</h4><input type="hidden" name="p3n" id="p3n"></th>
                                    <th><h6 id="pv4">0.00</h4><input type="hidden" name="p4n" id="p4n"></th>
                                    <th><h6 id="pv5">0.00</h4><input type="hidden" name="p5n" id="p5n"></th>
                                </tfoot>
                                <tbody>
                                </tbody>
                        </table>
                    </div>
                                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
											<button class="btn btn-danger" type="button" id="btnCancelar" onclick="listar()"><i class="fa fa-save"></i> Cancelar</button>
                   	</form>


                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    <!-- /.content-wrapper -->
  <!--Fin-Contenido-->

<?php
 }
 else
 {
   require 'noacceso.php';
 }

require 'footer.php';
?>
<script type="text/javascript" src="scripts/precios.js"></script>
<?php 
}
ob_end_flush();
?>


