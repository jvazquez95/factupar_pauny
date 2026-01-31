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
if ($_SESSION['acceso']==1)
{
?>
<!--Contenido-->
      <style>
        .permisos-toolbar { margin-bottom: 10px; }
        .permisos-toolbar .btn { margin-right: 8px; }
        .permisos-container { max-height: 420px; overflow-y: auto; border: 1px solid #ddd; border-radius: 4px; padding: 10px; background: #fafafa; }
        .permiso-categoria-panel { margin-bottom: 12px; }
        .permiso-categoria-panel .panel-heading-permiso { padding: 8px 12px; font-size: 13px; background: #f5f5f5; }
        .permiso-categoria-panel .panel-body { padding: 10px 12px; }
        .permiso-cat-title { font-weight: 600; color: #333; margin-right: 10px; }
        .permiso-link { font-size: 12px; margin-right: 4px; }
        .permiso-list { margin-bottom: 0; column-count: 2; column-gap: 20px; }
        @media (max-width: 768px) { .permiso-list { column-count: 1; } }
        .permiso-item { break-inside: avoid; margin-bottom: 6px; }
        .permiso-label { font-weight: normal; cursor: pointer; display: block; }
        .permiso-label:hover { background: #f0f8ff; }
        .permiso-check { margin-right: 6px; vertical-align: middle; }
      </style>
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Usuario <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Documento</th>
                            <th>Número</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Login</th>
                            <th>Foto</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Documento</th>
                            <th>Número</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Login</th>
                            <th>Foto</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST" enctype="multipart/form-data">
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Nombre(*):</label>
                            <input type="hidden" name="idusuario" id="idusuario">
                            <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Tipo Documento(*):</label>
                            <select class="form-control select-picker" name="tipo_documento" id="tipo_documento" required>
                              <option value="DNI">DNI</option>
                              <option value="RUC">RUC</option>
                              <option value="CEDULA">CEDULA</option>
                            </select>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Número(*):</label>
                            <input type="text" class="form-control" name="num_documento" id="num_documento" maxlength="20" placeholder="Documento" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Dirección:</label>
                            <input type="text" class="form-control" name="direccion" id="direccion" placeholder="Dirección" maxlength="70">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Teléfono:</label>
                            <input type="text" class="form-control" name="telefono" id="telefono" maxlength="20" placeholder="Teléfono">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Email:</label>
                            <input type="email" class="form-control" name="email" id="email" maxlength="50" placeholder="Email">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Cargo:</label>
                            <input type="text" class="form-control" name="cargo" id="cargo" maxlength="20" placeholder="Cargo">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Login (*):</label>
                            <input type="text" class="form-control" name="login" id="login" maxlength="20" placeholder="Login" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Clave:</label>
                            <input type="password" class="form-control" name="clave" id="clave" maxlength="64" placeholder="Obligatoria al crear; en edición dejar en blanco para no cambiar">
                          </div>


                          <div class="form-group col-lg-12 col-md-12 col-sm-4 col-xs-12">
                          <label>Seleccione empleado (opcional, para comisiones):</label>
                            <select name="Empleado_idEmpleado" id="Empleado_idEmpleado" class="form-control selectpicker"></select>
                          </div>


                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Aplicar rol (selección rápida):</label>
                            <select id="selRol" class="form-control" style="max-width:320px;">
                              <option value="">-- Sin aplicar rol (desmarca todos) --</option>
                            </select>
                            <small class="text-muted">Al elegir un rol se marcan solo sus permisos; al elegir "Sin aplicar" se desmarcan todos. Luego puede marcar/desmarcar uno a uno.</small>
                          </div>
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Permisos (por categoría):</label>
                            <div class="permisos-toolbar">
                              <a href="#" id="permisosMarcarTodos" class="btn btn-default btn-xs"><i class="fa fa-check-square-o"></i> Marcar todos</a>
                              <a href="#" id="permisosDesmarcarTodos" class="btn btn-default btn-xs"><i class="fa fa-square-o"></i> Desmarcar todos</a>
                            </div>
                            <div id="permisos" class="permisos-container">
                              <p class="text-muted">Cargando...</p>
                            </div>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Imagen:</label>
                            <input type="file" class="form-control" name="imagen" id="imagen">
                            <input type="hidden" name="imagenactual" id="imagenactual">
                            <img src="" width="150px" height="120px" id="imagenmuestra">
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

<script type="text/javascript" src="scripts/usuario.js"></script>
<?php 
}
ob_end_flush();
?>