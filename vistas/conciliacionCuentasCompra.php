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
if ($_SESSION['compras']==1)
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
                          <h1 class="box-title">Conciliacion de Cuentas - Compras <button class="btn btn-success"  id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                            <a href="#"><span class="label bg-green">Ir a cobros</span></a>
                        </div>
                    </div>

                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Proveedor</th>
                            <th>Compra</th>
                            <th>Total Compra</th>
                            <th>Cuota</th>
                            <th>Nota de Credito</th>
                            <th>Total Nota de Credito</th>
                            <th>Monto Aplicado</th>
                            <th>Saldo Actual</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Proveedor</th>
                            <th>Compra</th>
                            <th>Total Compra</th>
                            <th>Cuota</th>
                            <th>Nota de Credito</th>
                            <th>Total Nota de Credito</th>
                            <th>Monto Aplicado</th>
                            <th>Saldo Actual</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">                      
                        <form name="formulario" id="formulario" method="POST">
                        	<div class="row">
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Fecha.:</label>
							              <input type="text" class="form-control" name="FECHARECIBO1" id="FECHARECIBO1" disabled value="<?php echo date("Y-m-d"); ?>">
                            <input type="hidden" class="form-control" name="FECHARECIBO" id="FECHARECIBO" required value="<?php echo date("Y-m-d"); ?>">
                          </div>

                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Usuario:</label>
							              <input type="text" class="form-control" name="usuario1" id="usuario1" value="<?php echo 'Usuario: ' .$_SESSION['login'].' Nombre completo: '.$_SESSION['nombre'] ?>" disabled>
                          </div>
						</div>
						<div class="row">
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Proveedor(*):</label>
                            <input type="hidden" name="IDRECIBO" id="IDRECIBO">
                            <input type="hidden" class="form-control" name="usuario" id="usuario" value="<?php echo $_SESSION['login'] ?>">
                         	<input type="hidden" class="form-control" name="Habilitacion_idHabilitacion" id="Habilitacion_idHabilitacion">
                            <input type="hidden" class="form-control" name="NRORECIBO" id="NRORECIBO" value="1">
                            <input type="hidden" class="form-control" name="total" id="total">
                            <input type="hidden" class="form-control" name="subTotal" id="subTotal">
                            <input type="hidden" class="form-control" name="inactivo" id="inactivo" value="0">
                            <select onchange="cargarFC();" id="Proveedor_idProveedor" name="Proveedor_idProveedor" class="form-control selectpicker" data-live-search="true" required>
                            </select>                          
                          </div>


                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Seleccione factura:</label>
                            <select onchange="cargarCV();" id="Compra_idCompra" name="Compra_idCompra" class="form-control selectpicker" data-live-search="true" required>
                            </select>                          
                          </div>

                         <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                           <label>Seleccione cuota:</label>
                           <select onchange="montoCuota();" id="nroCuota" name="nroCuota" class="form-control selectpicker" data-live-search="true" required>
                            </select>                          
                          </div>

                        <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Ingrese importe cuota:</label>
                            <input type="text" class="form-control" name="monto" id="monto">
                          </div>


                         <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                           <label>Seleccione Nota de Credito:</label>
                           <select onchange="montoCuotaNC();" id="NotaCredito_idNotaCredito" name="NotaCredito_idNotaCredito" class="form-control selectpicker" data-live-search="true" required>
                            </select>                          
                          </div>

                        <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Ingrese importe a aplicar:</label>
                            <input type="text" class="form-control" name="montoAplicar" id="montoAplicar">
                          </div>



<!--                           <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Moneda(*):</label>
                            <select name="Moneda_idMoneda" id="Moneda_idMoneda" onchange="cargarTasa(this)" class="form-control selectpicker"  data-live-search="true" required>
                            </select>
                          </div>

                          <div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-12">
                            <label>Tasa cambio:</label>
                            <input type="text" class="form-control" name="tasaCambio" id="tasaCambio" required>
                          </div>
						  
                          <div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-12">
                            <label>Tasa Base 2:</label>
                            <input type="text" class="form-control" name="tasaCambioBases" id="tasaCambioBases" readonly>
                          </div> -->

                         
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                              <button id="btnDetalle" type="button" class="btn btn-primary" onclick="agregarDetalle();"> <span class="fa fa-plus"></span> Agregar detalle</button>
                          </div>
						</div>

                          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                              <thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Nro. compra</th>
                                    <th>Nro. cuota</th>
                                    <th>Monto</th>
                                    <th>Nro. Nota. Credito</th>
                                    <th>Monto a Aplicar</th>
                                </thead>
                                <tfoot>
                                    <th></th>
                                    <th></th>
                                    <th>Total Credito</th>
                                    <th></th>
                                    <th>Total Debito</th>
                                    <th><h4 id="total1">Gs. </h4><input type="hidden" name="total_ventan" id="total_ventan"></th>
                                </tfoot>
                                <tbody>

                                </tbody>
                            </table>
                          </div>


                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->



  <!-- Modal -->
  <div class="modal" id="cheque" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 100% !important;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Registrar nuevo cheque</h4>


                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <label>Banco:</label>
                            <select name="Banco_idBancoFiltro" id="Banco_idBancoFiltro" onchange="filtrarCheques(this);" class="form-control selectpicker" required="">
                            </select>
                          </div>


                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Cheques pendientes de aplicacion:</label>
                            <select name="chequeaplicar" id="chequeaplicar" class="form-control selectpicker" onchange="obtenerDatos(this);" data-live-search="true">
                            </select>
                          </div>
        </div>
                <div class="modal-body" id="formularioregistros">
                        <form name="formularioCheque" id="formularioCheque" method="POST">



                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Paguese a la orden de:</label>
                            <input type="text" class="form-control" name="destinatario" id="destinatario" placeholder="Destinatario" required>
                          </div>


                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Nro de cheque:</label>
                            <input type="hidden" class="form-control" name="idChequeEmitido" id="idChequeEmitido">
                            
                            <input type="text" class="form-control" name="nroChequeCh" id="nroChequeCh" maxlength="250" placeholder="Numero de cheque" required>
                          </div>
                   

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Nro de Cuenta / Cuenta Corriente:</label>
                            <input type="text" class="form-control" name="nroCuenta" id="nroCuenta" placeholder="Numero de cuenta" required>
                          </div>
                    
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Banco:</label>
                            <select name="Banco_idBancoCh" id="Banco_idBancoCh" class="form-control selectpicker" required="">
                            </select>
                          </div>
                          
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Moneda:</label>
                            <select name="Moneda_idMonedaCh" id="Moneda_idMonedaCh" class="form-control selectpicker" required="">
                            </select>
                          </div>


                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Monto:</label>
                            <input type="text" class="form-control" name="monto" id="monto" placeholder="Monto" required>
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Fecha Cobro:</label>
                            <input type="date" class="form-control" name="fechaCobro" id="fechaCobro" placeholder="Fecha de cobro" value="<?php echo date("Y-m-d"); ?>" required>
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Tipo de Cheque:</label>
                            <select class="form-control select-picker" name="tipoCheque" id="tipoCheque" required>
                              <option value="1">Del Dia</option>
                              <option value="2">Pago Diferido</option>
                            </select>
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Comentario:</label>
                            <input type="text" class="form-control" name="comentario" id="comentario" maxlength="250" placeholder="Comentario" required>
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardarCheque"><i class="fa fa-save"></i> Guardar</button>
                          </div>
                          
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </form>
                    </div>
      </div>
    </div>
  </div>  
  <!-- Fin modal -->





  <!-- Modal -->
  <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 65% !important;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Seleccione un Artículo</h4>
        </div>
        <div class="modal-body">
          <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover">
            <thead>
                <th>Opciones</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Categoría</th>
                <th>Código de barras</th>
                <th>Precio Venta</th>
                <th>Imagen</th>
            </thead>
            <tbody>
              
            </tbody>
            <tfoot>
              <th>Opciones</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Código de barras</th>
                <th>Precio Venta</th>
                <th>Imagen</th>
            </tfoot>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>        
      </div>
    </div>
  </div>  
  <!-- Fin modal -->

  <!-- Modal -->
  <div class="modal" id="cliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 65% !important;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Registrar a un nuevo cliente</h4>
        </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formularioCliente" id="formularioCliente" method="POST">
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Razon social:</label>
                            <input type="text" class="form-control" name="razonSocial" id="razonSocial" maxlength="250" placeholder="Nombre del cliente" required>
                          </div>
                          

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Tipo Documento:</label>
                            <select class="form-control select-picker" name="tipoDocumento" id="tipoDocumento" required>
                              <option value="1">RUC</option>
                              <option value="2">CEDULA</option>
                            </select>
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Número Documento:</label>
                            <input type="text" class="form-control" name="nroDocumento" id="nroDocumento" maxlength="20" placeholder="Documento">
                          </div>


                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardarCliente"><i class="fa fa-save"></i> Guardar</button>
                          </div>
                        </form>
                    </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>        
      </div>
    </div>
  </div>  
  <!-- Fin modal -->


                        <div class="container">
                           <style>
                          </style>
                          <!-- The Modal -->
                          <div class="modal" id="modal_detalle_cobro">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                              <div class="modal-content">
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <span>Detalle de cobro:<input type="text" disabled name="detalle_pago" id="detalle_pago" /> </span>
                                <table id="tbllistado5" class="table table-striped table-bordered table-condensed table-hover">
                                  <thead>
                                    <th>Nro. compra</th>
                                    <th>Id. Termino Pago</th>
                                    <th>Descripcion</th>
                                    <th>Monto</th>
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
<script type="text/javascript" src="scripts/conciliacionCuentasCompra.js"></script>
<script type="text/javascript" src="scripts/generales.js"></script>
<?php 
}
ob_end_flush();
?>


