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
                          <h1 class="box-title">Cuenta Corriente <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
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
                            <th>Proceso</th>
                            <th>Cuenta Contable</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Descripcion</th>
                            <th>Proceso</th>
                            <th>Cuenta Contable</th>
                            <th>Estado</th>   
                          </tfoot>
                        </table>
                    </div>

 
                    <div class="panel-body" style="height: 500px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-3 col-md-2 col-sm-6 col-xs-12">
                            <label>Descripcion:</label>
                            <input type="hidden" name="idCuentaCorriente" id="idCuentaCorriente">
                            <input type="text" class="form-control" name="descripcion" id="descripcion" maxlength="50" placeholder="Nombre" required>
                          </div>
                          <div class="form-group col-lg-4 col-md-2 col-sm-6 col-xs-12">
                            <label>Proceso:</label>
                            <select id="Proceso_idProceso" name="Proceso_idProceso" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>
                         <div class="form-group col-lg-4 col-md-2 col-sm-6 col-xs-12">
                            <label>Cuenta Contable:</label>                   
                            <select id="CuentaContable_idCuentaContable" name="CuentaContable_idCuentaContable" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>   
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">    
                            <label>Debito Anterior:</label>                    
                            <input type="text" class="form-control" name="debitoAnterior" id="debitoAnterior" maxlength="50" placeholder="Debito Anterior" required>     
                          </div>     
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">    
                            <label>Credito Anterior:</label>                    
                            <input type="text" class="form-control" name="creditoAnterior" id="creditoAnterior" maxlength="50" placeholder="Credito Anterior" required>     
                          </div>     
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">    
                            <label>Debito Enero:</label>                    
                            <input type="text" class="form-control" name="debitoEnero" id="debitoEnero" maxlength="50" placeholder="Debito Enero" required>     
                          </div>     
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">    
                            <label>Debito Febrero:</label>                    
                            <input type="text" class="form-control" name="debitoFebrero" id="debitoFebrero" maxlength="50" placeholder="Debito Febrero" required>     
                          </div>                              
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">    
                            <label>Debito Marzo:</label>                    
                            <input type="text" class="form-control" name="debitoMarzo" id="debitoMarzo" maxlength="50" placeholder="Debito Marzo" required>     
                          </div>                                                          
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">    
                            <label>Debito Abril:</label>                    
                            <input type="text" class="form-control" name="debitoAbril" id="debitoAbril" maxlength="50" placeholder="Debito Abril" required>     
                          </div>     
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">    
                            <label>Debito Mayo:</label>                    
                            <input type="text" class="form-control" name="debitoMayo" id="debitoMayo" maxlength="50" placeholder="Debito Mayo" required>     
                          </div>     
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">    
                            <label>Debito Junio:</label>                    
                            <input type="text" class="form-control" name="debitoJunio" id="debitoJunio" maxlength="50" placeholder="Debito Junio" required>     
                          </div>     
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">    
                            <label>Debito Julio:</label>                    
                            <input type="text" class="form-control" name="debitoJulio" id="debitoJulio" maxlength="50" placeholder="Debito Julio" required>     
                          </div>  
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">    
                            <label>Debito Agosto:</label>                    
                            <input type="text" class="form-control" name="debitoAgosto" id="debitoAgosto" maxlength="50" placeholder="Debito Agosto" required>     
                          </div> 
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">    
                            <label>Debito Setiembre:</label>                    
                            <input type="text" class="form-control" name="debitoSetiembre" id="debitoSetiembre" maxlength="50" placeholder="Debito Setiembre" required>     
                          </div> 
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">    
                            <label>Debito Octubre:</label>                    
                            <input type="text" class="form-control" name="debitoOctubre" id="debitoOctubre" maxlength="50" placeholder="Debito Octubre" required>     
                          </div> 
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">    
                            <label>Debito Noviembre:</label>                    
                            <input type="text" class="form-control" name="debitoNoviembre" id="debitoNoviembre" maxlength="50" placeholder="Debito Noviembre" required>     
                          </div> 
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">    
                            <label>Debito Diciembre:</label>                    
                            <input type="text" class="form-control" name="debitoDiciembre" id="debitoDiciembre" maxlength="50" placeholder="Debito Diciembre" required>     
                          </div>                                                                                                                                                              
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">    
                            <label>Credito Enero:</label>                    
                            <input type="text" class="form-control" name="creditoEnero" id="creditoEnero" maxlength="50" placeholder="Credito Enero" required>     
                          </div>     
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">    
                            <label>Credito Febrero:</label>                    
                            <input type="text" class="form-control" name="creditoFebrero" id="creditoFebrero" maxlength="50" placeholder="Credito Febrero" required>     
                          </div>                              
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">    
                            <label>Credito Marzo:</label>                    
                            <input type="text" class="form-control" name="creditoMarzo" id="creditoMarzo" maxlength="50" placeholder="Credito Marzo" required>     
                          </div>                                                          
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">    
                            <label>Credito Abril:</label>                    
                            <input type="text" class="form-control" name="creditoAbril" id="creditoAbril" maxlength="50" placeholder="Credito Abril" required>     
                          </div>     
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">    
                            <label>Credito Mayo:</label>                    
                            <input type="text" class="form-control" name="creditoMayo" id="creditoMayo" maxlength="50" placeholder="Credito Mayo" required>     
                          </div>     
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">    
                            <label>Credito Junio:</label>                    
                            <input type="text" class="form-control" name="creditoJunio" id="creditoJunio" maxlength="50" placeholder="Credito Junio" required>     
                          </div>     
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">    
                            <label>Credito Julio:</label>                    
                            <input type="text" class="form-control" name="creditoJulio" id="creditoJulio" maxlength="50" placeholder="Credito Julio" required>     
                          </div>  
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">    
                            <label>Credito Agosto:</label>                    
                            <input type="text" class="form-control" name="creditoAgosto" id="creditoAgosto" maxlength="50" placeholder="Credito Agosto" required>     
                          </div> 
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">    
                            <label>Credito Setiembre:</label>                    
                            <input type="text" class="form-control" name="creditoSetiembre" id="creditoSetiembre" maxlength="50" placeholder="Credito Setiembre" required>     
                          </div> 
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">    
                            <label>Credito Octubre:</label>                    
                            <input type="text" class="form-control" name="creditoOctubre" id="creditoOctubre" maxlength="50" placeholder="Credito Octubre" required>     
                          </div> 
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">    
                            <label>Credito Noviembre:</label>                    
                            <input type="text" class="form-control" name="creditoNoviembre" id="creditoNoviembre" maxlength="50" placeholder="Credito Noviembre" required>     
                          </div> 
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">    
                            <label>Credito Diciembre:</label>                    
                            <input type="text" class="form-control" name="creditoDiciembre" id="creditoDiciembre" maxlength="50" placeholder="Credito Diciembre" required>     
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
<script type="text/javascript" src="scripts/cuentaCorriente.js"></script>
<?php 
}
ob_end_flush();
?>


