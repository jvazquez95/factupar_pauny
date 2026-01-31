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
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Recibo <button class="btn btn-success"  id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                          <button class="btn btn-success"  id="btnimprimir" onclick="imprimirArqueo();"><i class="fa fa-print"></i> Imprimir Arqueo de caja</button>
                            <a href="movimiento.php"><span class="label bg-green">Ir a movimientos de caja</span></a>
                            <a href="#"><span class="label bg-green">Ir a cobros</span></a>
                        </div>
                    </div>

                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Nro. recibo</th>
                            <th>Habilitacion</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Usuario</th>
                            <th>Total</th>
                            <th>Ver detalle de cobro</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Nro. recibo</th>
                            <th>Habilitacion</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Usuario</th>
                            <th>Total</th>
                            <th>Ver detalle de cobro</th>
                            <th>Estado</th>
                            
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">                      
                        <form name="formulario" id="formulario" method="POST">
                      <div class="row">    
                          <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                            <label>Nro. Hab.:</label>
							              <input type="text" class="form-control" name="Habilitacion_idHabilitacion1" id="Habilitacion_idHabilitacion1" disabled>
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Fecha. Recibo.:</label>
							              <input type="text" class="form-control" name="FECHARECIBO1" id="FECHARECIBO1" disabled>
                            <input type="hidden" class="form-control" name="FECHARECIBO" id="FECHARECIBO" required>
                          </div>

                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Usuario:</label>
							              <input type="text" class="form-control" name="usuario1" id="usuario1" value="<?php echo 'Usuario: ' .$_SESSION['login'].' Nombre completo: '.$_SESSION['nombre'] ?>" disabled>
                          </div>
                      </div>    
                      <div class="row">
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Cliente(*):</label>
                            <input type="hidden" name="IDRECIBO" id="IDRECIBO">
                            <input type="hidden" class="form-control" name="usuario" id="usuario" value="<?php echo $_SESSION['login'] ?>">
                         	<input type="hidden" class="form-control" name="Habilitacion_idHabilitacion" id="Habilitacion_idHabilitacion">
                            <input type="hidden" class="form-control" name="NRORECIBO" id="NRORECIBO" value="1">
                            <input type="hidden" class="form-control" name="total" id="total">
                            <input type="hidden" class="form-control" name="subTotal" id="subTotal">
                            <input type="hidden" class="form-control" name="inactivo" id="inactivo" value="0">
                        <!--    <select onchange="cargarFC();" id="Cliente_idCliente" name="Cliente_idCliente" class="form-control selectpicker" data-live-search="true" required> -->


                            <select   title="Selecciona Articulo" onchange="cargarFC();" class="selectpicker selector_persona form-control" data-style="btn-warning" name="Cliente_idCliente" id="Cliente_idCliente"  data-live-search="true"></select>


                            </select>                          
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Moneda(*):</label>
                            <select name="Moneda_idMoneda" id="Moneda_idMoneda" onchange="cargarTasa(this)" class="form-control selectpicker"  data-live-search="true" required>
                            </select>
                          </div>

                          <div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-12">
                            <label>Tasa cambio:</label>
                            <input type="text" class="form-control" name="tasaCambio" id="tasaCambio" required>
                            <span id="labelCambioMoneda" class="text-muted small"></span>
                          </div>
                          <div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-12">
                            <label>Tasa Base 2:</label>
                            <input type="text" class="form-control" name="tasaCambioBases" id="tasaCambioBases" readonly>
                          </div>

                        </div>

                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Seleccione venta:</label>
                            <select onchange="cargarCV();" id="Venta_idVenta" name="Venta_idVenta" class="form-control selectpicker" data-live-search="true" required>
                            </select>                          
                          </div>

                              <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                           <label>Seleccione cuota:</label>
                           <select onchange="montoCuota();" id="nroCuota" name="nroCuota" class="form-control selectpicker" data-live-search="true" required>
                            </select>                          
                          </div> 

                        <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Ingrese importe a pagar:</label>
                            <input type="text" onkeyup="separadorMilesOnKey(event, this);" class="form-control" name="monto" id="monto">
                          </div>

<!--                         <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Ingrese importe a pagar:</label>
                            <input type="text" class="form-control" name="monto" id="monto">
                          </div> -->

                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                              <button id="btnDetalle" type="button" class="btn btn-primary" onclick="agregarDetalle();"> <span class="fa fa-plus"></span> Agregar detalle</button>
                          </div>


                          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                              <thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Nro. venta</th>
                                    <th>Nro. cuota</th>
                                    <th>Monto</th>
                                </thead>
                                <tfoot>
                                    <th></th>
                                    <th></th>
                                    <th>TOTAL</th>
                                    <th><h4 id="total1">Gs. </h4><input type="hidden" name="total_ventan" id="total_ventan"></th>
                                </tfoot>
                                <tbody>

                                </tbody>
                            </table>
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Tipo de pago(*):</label>
                            <select onchange="habilitarBoton();isCheque(this)" name="TerminoPago_idTerminoPagoDetalle" id="TerminoPago_idTerminoPagoDetalle" class="form-control selectpicker" required=""></select>
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Importe(*):</label>
                            <input type="text" class="form-control" name="importe_detalle" id="importe_detalle" required="">
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Nro. de referencia(*):</label>
                            <input type="text" class="form-control" name="nroCheque" id="nroCheque" required="">
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12 noCheque">
                            <label>Banco:</label>
                            <select  name="Banco_idBanco" id="Banco_idBanco" class="form-control selectpicker" required=""></select>
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                              <button id="btnTipoPago" type="button" class="btn btn-primary" onclick="agregarDetallePago();"> <span class="fa fa-plus"></span> Agregar pago</button>
                          </div>


                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <table id="detalles1" class="table table-striped table-bordered table-condensed table-hover">
                              <thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Tipo de Pago</th>
                                    <th>Importe</th>
                                    <th>Nro. de Referencia</th>
                                    <th>Banco</th>
                                </thead>
                                <tfoot>
                                    <th></th>
                                    <th>TOTAL</th>
                                    <th><h4 id="total_detalle"></h4><input type="hidden" name="t_detalle" id="t_detalle"></th>
                                    <th></th> 
                                    <th></th> 
                                </tfoot>
                                <tbody>
                                </tbody>
                            </table>
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>El cliente entrega:</label>
                            <input type="text" class="form-control" name="idvuelto" id="idvuelto" onkeyup="vuelto()">
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>La venta total es:</label>
                            <input type="text" class="form-control" name="idtotalVenta" id="idtotalVenta" disabled>
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>El vuelto es:</label>
                            <input type="text" class="form-control" name="iddiferencia" id="iddiferencia" disabled>
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
                                    <th>Nro. venta</th>
                                    <th>Id. Termino Pago</th>
                                    <th>Descripcion</th>
                                    <th>Monto</th>
                                  </thead>
                                  <tbody>                            
                                  </tbody>
                                  <tfoot>
                                    <th>Nro. venta</th>
                                    <th>Id. Termino Pago</th>
                                    <th>Total</th>
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






  <!-- Modal -->
  <div class="modal" id="cheque" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 100% !important;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Registrar nuevo cheque</h4>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Cheques pendientes de aplicacion:</label>
                            <select name="chequeaplicar" id="chequeaplicar" class="form-control selectpicker" onchange="obtenerDatos(this);" data-live-search="true">
                            </select>
                          </div>
        </div>
                <div class="modal-body" id="formularioregistros">
                        <form name="formularioCheque" id="formularioCheque" method="POST">



                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Emisor:</label>
                            <input type="text" class="form-control" name="emisor" id="emisor" placeholder="Emisor" required>
                          </div>


                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Nro de cheque:</label>
                            <input type="text" class="form-control" name="nroChequeCh" id="nroChequeCh" maxlength="250" placeholder="Numero de cheque" required>
                          </div>
                   

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Nro de Cuenta:</label>
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

<script type="text/javascript">
  
//Ajax - Cliente
// AJAX call for autocomplete 
$(document).ready(function(){
  $('select.selector_persona').selectpicker();
    $(".bs-searchbox input").on('input', function() {

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
else
{
  require 'noacceso.php';
}

require 'footer.php';
?>
<script type="text/javascript" src="scripts/recibo.js"></script>
<?php 
}
ob_end_flush();
?>


