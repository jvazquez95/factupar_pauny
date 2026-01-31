var tabla;
var tipopago = 0;
//var t1 = 0.0;
var restarEsto = 0.0;
var posicion = -1;
var l_gcheque = 0;
var t1_cheque = 0;
var formatNumber = {
 separador: ".", // separador para los miles
 sepDecimal: ',', // separador para los decimales
 formatear:function (num){
 num +='';
 var splitStr = num.split('.');
 var splitLeft = splitStr[0];
 var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
 var regx = /(\d+)(\d{3})/;
 while (regx.test(splitLeft)) {
 splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
 }
 return this.simbol + splitLeft +splitRight;
 },
 new:function(num, simbol){
 this.simbol = simbol ||'';
 return this.formatear(num);
 }
}
//Función que se ejecuta al inicio
function init(){
	$('#divCheque').hide();
	mostrarform(false);
	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	});

	$("#formularioCliente").on("submit",function(e)
	{
		guardaryeditarCliente(e);	
	});


	$("#formularioCheque").on("submit",function(e)
	{
		guardaryeditarCheque(e);	
	});


	//Cargamos los items al select cliente
	$.post("../ajax/cheque.php?op=selectChequesPendientes", { Banco_idBanco: 1 }, function(r){
	            $("#chequeaplicar").html(r);
	            $('#chequeaplicar').selectpicker('refresh');
	});	


	//Cargamos los items al select cliente
	$.post("../ajax/moneda.php?op=selectMoneda", function(r){
	            $("#Moneda_idMonedaCh").html(r);
	            $('#Moneda_idMonedaCh').selectpicker('refresh');

});	

$.post("../ajax/cotizacionDiaria.php?op=ultimaCotizacion", { Moneda_idMoneda: 2 } , function(data, status)
		{
			data = JSON.parse(data);
			$("#tasaCambioBases").val(data.cotizacionVenta);
		});
		
		$.post("../ajax/cotizacionDiaria.php?op=ultimaCotizacion", { Moneda_idMoneda: 1} , function(data, status)
			{
				data = JSON.parse(data);


				$("#tasaCambio").val(data.cotizacionVenta);
		 });


	//Cargamos los items al select cliente
	$.post("../ajax/moneda.php?op=selectMoneda", function(r){
	            $("#Moneda_idMoneda").html(r);
	            $('#Moneda_idMoneda').selectpicker('refresh');
	});	


	//Cargamos los items al select cliente
	$.post("../ajax/banco.php?op=selectBanco", function(r){
	            $("#Banco_idBancoCh").html(r);
	            $('#Banco_idBancoCh').selectpicker('refresh');

	            $("#Banco_idBancoFiltro").html(r);
	            $('#Banco_idBancoFiltro').selectpicker('refresh');

	});	

	//Cargamos los items al select cliente
	$.post("../ajax/persona.php?op=selectProveedor", function(r){
	            $("#Proveedor_idProveedor").html(r);
	            $('#Proveedor_idProveedor').selectpicker('refresh');
	});	

	// //Cargamos los items al select cliente
	 $.post("../ajax/formaPago.php?op=selectFormaPago", function(r){
	             $("#TerminoPago_idTerminoPagoDetalle").html(r);
	             $('#TerminoPago_idTerminoPagoDetalle').selectpicker('refresh');
	 });	

	//Cargamos los items al select cliente
	$.post("../ajax/venta.php?op=selectBanco", function(r){
	            $("#Banco_idBanco").html(r);
	            $('#Banco_idBanco').selectpicker('refresh');
	});	

	//habilitacion factura
	$.post("../ajax/venta.php?op=habilitacion", { tipoDocumento: 1 } ,function(data, status)
		{
			data = JSON.parse(data);
			if (data.idhabilitacion) {
			$('#Habilitacion_idHabilitacion').val(data.idhabilitacion);
			$('#Habilitacion_idHabilitacion1').val(data.idhabilitacion);
			$("#sucursal").val(data.sucursal);
			listar($('#Habilitacion_idHabilitacion').val());
			}else{
			alert('Caja no habilitada');
			location.href ="habilitacion.php";			
			}	

		 });


}




var vcosto;
var moneda_inicial;
var vl_tasaCambio;
var vl_tasacambiobase;
var vmoneda;
var entro = 0;
function cambiarMoneda(moneda){


	var costo = document.getElementsByName("montoAplicado[]");
	var l_tasaCambio = $("#tasaCambio").val();
	var l_tasacambiobase = $("#tasaCambioBases").val();
	if (entro == 0) {
	   	for (var i = 0; i < costo.length; i++) {
	   		if (moneda == 1) {
	   			costo[i].value = costo[i].value * l_tasaCambio;
	   		}else{	   	
	   			if (moneda_inicial == 1) {
	   				costo[i].value = costo[i].value / l_tasaCambio;
	   			}else{
	   				cambiarMoneda( 1 );
	   				cambiarMoneda( moneda );
	   			}
	   		}
	   	}
	}else{
	   	for (var i = 0; i < costo.length; i++) {
	   		if (moneda == 1) {
	   			costo[i].value = costo[i].value * vl_tasaCambio;
	   		}else{	   	
	   			if (vmoneda == 1) {	   			
	   				costo[i].value = costo[i].value / l_tasaCambio;
	   			}else{	   			
	   				cambiarMoneda( 1 );
	   				cambiarMoneda( moneda );
	   			}
	   		}
	   	}

	}

	vcosto = document.getElementsByName("montoAplicado[]");
	vl_tasaCambio = $("#tasaCambio").val();
	vl_tasacambiobase = $("#tasaCambioBases").val();
	vmoneda = moneda;
	entro = 1;


   	modificarSubototales();

}



function filtrarCheques( x ){


	var idMoneda = $("#Moneda_idMoneda").val();
	var idBanco = x.value;




	//Cargamos los items al select cliente
	$.post("../ajax/cheque.php?op=selectChequesPendientes", { Banco_idBanco: idBanco, Moneda_idMoneda:idMoneda }, function(r){
	            $("#chequeaplicar").html(r);
	            $('#chequeaplicar').selectpicker('refresh');
	});	





}


function cargarTasa(x){

	$.post("../ajax/cotizacionDiaria.php?op=ultimaCotizacion", { Moneda_idMoneda: x.value } , function(data, status)
		{
			data = JSON.parse(data);
			$("#tasaCambio").val(data.cotizacionVenta);

			 $.post("../ajax/cotizacionDiaria.php?op=ultimaCotizacion", { Moneda_idMoneda: 2 } , function(data, status)
				{
					data = JSON.parse(data);
					$("#tasaCambioBases").val(data.cotizacionVenta);


		 			cambiarMoneda(x.value);


			 });

	 });
	 

}

function mostrarDetalleCobro(idRecibo){
	$('#modal_detalle_cobro').modal('show');
	$("#detalle_pago").val(idRecibo); 
$(document).ready(function() {
    $('#tbllistado5').DataTable( {
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../ajax/consultas.php?op=rpt_cobros_detalle_pago',
					data:{idPago:idRecibo},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
 
  			"columnDefs": [
            {
                "targets": [ 0,1,3],
                "visible": true	,  
                "searchable": true,
                "className": 'text-right' 

            }],
            "language": {
            "decimal": ".",
            "thousands": ","
        },
		"bDestroy": true,
		"iDisplayLength": 20,//Paginación
	    "order": [[ 0, "desc" ],[ 0, "desc" ]],//Ordenar (columna,orden)

        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$.]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
             // Total over this page
            pageTotal = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return parseFloat(intVal(a)) + parseFloat(intVal(b));
                }, 0 );
 
            // Update footer
            $( api.column( 3 ).footer() ).html(
              'Total: ' + formatNumber.new(pageTotal) 
            );

        }
    } );
} );
}




function cargarFC(){

	var lProveedor = $('#Proveedor_idProveedor').val();
	//Cargamos los items al select cliente
	$.post("../ajax/pago.php?op=selectFacturasProveedor",{lProveedor:lProveedor}, function(r){
	            $("#Compra_idCompra").html(r);
	            $('#Compra_idCompra').selectpicker('refresh');
	});	

}


function isCheque(x){

	if (x.value == '4') {
		$('#divCheque').show();
		$('.noCheque').hide();
	    $("#nroCheque").attr("readonly","readonly");
	    $("#importe_detalle").attr("readonly","readonly");
		$('#cheque').modal('show');
		$("#destinatario").val( $("#Proveedor_idProveedor option:selected").text() );

	}else{
		$('#divCheque').hide();
		$('.noCheque').show();
		$("#nroCheque").removeAttr("readonly");
		$("#importe_detalle").removeAttr("readonly");

	}

}




function cargarTasaInicial(x){

	$.post("../ajax/cotizacionDiaria.php?op=ultimaCotizacion", { Moneda_idMoneda: x } , function(data, status)
		{
			data = JSON.parse(data);
			$("#tasaCambio").val(data.cotizacionVenta);

		 $.post("../ajax/cotizacionDiaria.php?op=ultimaCotizacion", { Moneda_idMoneda: 2 } , function(data, status)
			{
				data = JSON.parse(data);
				$("#tasaCambioBases").val(data.cotizacionVenta);

	 			cambiarMoneda(x);

		 });

	 });
	
}



function cargarMoneda(x){

	$.post("../ajax/pago.php?op=cargarMoneda", { Compra_idCompra: x } , function(data, status)
	{
		data = JSON.parse(data);
		$("#Moneda_idMoneda").val(data.Moneda_idMoneda);
        $('#Moneda_idMoneda').selectpicker('refresh');

		$("#Moneda_idMonedaCh").val(data.Moneda_idMoneda);
        $('#Moneda_idMonedaCh').selectpicker('refresh');
        
        cargarTasaInicial ( data.Moneda_idMoneda );


 	});
}







function cargarCV(){

	var lidCompra = $('#Compra_idCompra').val();
	//Cargamos los items al select cliente
	$.post("../ajax/pago.php?op=selectCuotasCompra",{lidCompra:lidCompra}, function(r){
	            $("#nroCuota").html(r);
	            $('#nroCuota').selectpicker('refresh');


	            cargarMoneda( lidCompra );


	});	

}



function montoCuota(){
	var lidCompra = $('#Compra_idCompra').val();
	var lcuota = $('#nroCuota').val();

	$.post("../ajax/pago.php?op=montoCuota",{lidCompra:lidCompra, lcuota:lcuota}, function(data, status)
		{

			data = JSON.parse(data);
			$('#monto').val(data.saldo);


			agregarDetalle();

	 });

}



function imprimirArqueo(){
	window.open("../reportes/exArqueo.php?id="+ $("#Habilitacion_idHabilitacion").val());
}


function guardaryeditarCliente(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioCliente")[0]);

	$.ajax({
		url: "../ajax/cliente.php?op=guardar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
			swal({
			  position: 'top-end',
			  type: 'success',
			  title: datos,
			  showConfirmButton: false,
			  timer: 1500
			 })	         
	    },
	    complete: function(datos){
			$('#cliente').modal('hide');
			$.post("../ajax/venta.php?op=selectCliente", function(r){
			            $("#Cliente_idCliente").html(r);
			            $('#Cliente_idCliente').selectpicker('refresh');
			});
			limpiarCliente();	
			$("#Cliente_idCliente").val(datos.responseText);
			$("#Cliente_idCliente").selectpicker('refresh');			
	    }

	});
}





function guardaryeditarCheque(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioCheque")[0]);

	$.ajax({
		url: "../ajax/cheque.php?op=guardar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
			swal({
			  position: 'top-end',
			  type: 'success',
			  title: 'Cheque registrado con exito',
			  showConfirmButton: false,
			  timer: 1500
			 })	         
	    },
	    complete: function(datos){

			if (l_gcheque > 0) {
				l_gcheque = l_gcheque;				
			}else{
				l_gcheque = datos.responseText;
			}

			$('#cheque').modal('hide');
			$("#nroCheque").val(l_gcheque);
			$.post("../ajax/cheque.php?op=importe", {idCheque: l_gcheque} , function(data, status)
				{

					data = JSON.parse(data);
					
					$("#importe_detalle").val(data.monto);
					$("#ChequePropio_idChequePropio").val(l_gcheque);
			 });

	    

	    }

	});
}


function obtenerDatos(x){

	var nro = x.value;
	$("#nroCheque").val(nro);
		$.post("../ajax/cheque.php?op=importe", {idCheque: nro} , function(data, status)
		{
				data = JSON.parse(data);
				//var lm = Math.round(data.monto);
				

				//$("#destinatario").val(data.destinatario);
				$("#nroChequeCh").val(data.nroCheque);
				$("#nroCuenta").val(data.ccnc);
				$("#Banco_idBancoCh").val(data.Banco_idBanco);
				$("#Banco_idBancoCh").selectpicker('refresh');
				$("#Moneda_idMonedaCh").val(data.Moneda_idMoneda);
				$("#Moneda_idMonedaCh").selectpicker('refresh');
				$("#idChequeEmitido").val(data.idChequeEmitido);
				$("#tipoCheque").val(data.tipoCheque);
				$("#tipoCheque").selectpicker('refresh');
				var l_monto1 = $("#total_ventan").val();
				$("#montoCh").val(t1_cheque);
				l_gcheque = data.idChequeEmitido;
		});	




//$('#cheque').modal('hide');
}



function modalCliente(){
	$('#cliente').modal('show');
}

//Función limpiar
function limpiar()
{
	//$("#tipo_comprobante").val("");
	//$("#Moneda_idMoneda").val("");
	$("#fechaTransaccion").val("");
	//$("#tasaCambio").val("");
	//$("#tasaCambioBases").val("");
	$("#totalImpuesto").val("");
	$("#total").val("");
	$("#subTotal").val("");
	$("#fechaModificacion").val("");
	$("#usuarioInsercion").val("");
	$("#usuarioModificacion").val("");
	$("#inactivo").val("");
	$("#total_venta").val("");
	$(".filas").remove();
	$("#total2").html("0");
	//Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    //Marcamos el primer tipo_documento
    $("#tipo_comprobante").val("Factura");
	$("#tipo_comprobante").selectpicker('refresh');
	$("#btnTipoPago").hide();
	$("#TerminoPago_idTerminoPagoDetalle").val(1);
	$("#TerminoPago_idTerminoPagoCabecera").val(0);
	$("#TerminoPago_idTerminoPagoCabecera").selectpicker('refresh');
	$("#tipo_comprobante").selectpicker('refresh');
	$("#importe_detalle").val("");
	$("#nroCheque").val("");
	$("#idtotalVenta").val("");
	$("#total_ventan").val("");
	$("#total_venta").val("");
	$("#total1").val("");
	$("#total2").val("");
	$("#cuotas").val("");

}

//Función limpiar
function limpiarCliente()
{
	$("#razonSocial").val("");
	$("#tipoDocumento").val("");
	$("#nroDocumento").val("");
}



//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		//$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
		//listarArticulos();

		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		$("#btnAgregarArt").show();
		detalles=0;
		detalles2=0;
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
	$("#btnTipoPago").hide();
}

//Función Listar
function listar(habilitacion)
{
	tabla=$('#tbllistado').dataTable(
	{		
		"fnRowCallback": function( nRow, aaData, iDisplayIndex, iDisplayIndexFull ) {
		  if ( aaData[8] != '<span class="label bg-green">Activado</span>' )
		  {
			$('td', nRow).css('background-color', '#f2dede' );
		  }
		},
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../ajax/pago.php?op=listar',
					data:{habilitacion:habilitacion},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5000,//Paginación
	    "order": [[ 1, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}

//Función ListarArticulos
function listarArticulos()
{
	tabla=$('#tblarticulos').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            
		        ],
		"ajax":
				{
					url: '../ajax/venta.php?op=listarArticulosVenta',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}
//Función para guardar o editar

function guardaryeditar(e)
{
	 if (cont2 == 0) {
	 	agregarDetallePago();		
	 }
	e.preventDefault(); //No se activará la acción predeterminada del evento
	//$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);
	$.ajax({
		url: "../ajax/pago.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {         
			swal({
			  position: 'top-end',
			  type: 'success',
			  title: datos,
			  showConfirmButton: false,
			  timer: 1500
			 })	      
	          mostrarform(false);
	          tabla.ajax.reload();
	    },
	     complete: function(e){
	     	cont2 = 0;
	     	modificarSubototales();
	     	modificarSubototalesDetalle();
		    limpiar();
	     	mostrarform(true);
	     }

	});
	//limpiar();
}

function habilitarBoton(){

	$("#btnTipoPago").show();
}

function mostrar(idVenta)
{
	$.post("../ajax/venta.php?op=mostrar",{idVenta : idVenta}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#idcliente").val(data.idcliente);
		$("#idcliente").selectpicker('refresh');
		$("#tipo_comprobante").val(data.tipo_comprobante);
		$("#tipo_comprobante").selectpicker('refresh');
		$("#serie_comprobante").val(data.serie_comprobante);
		$("#num_comprobante").val(data.num_comprobante);
		$("#fecha_hora").val(data.fecha);
		$("#impuesto").val(data.impuesto);
		$("#idventa").val(data.idventa);


		$("#Cliente_idCliente").val(data.Cliente_idCliente);
		$("#usuario").val(data.usuario);
		$("#Habilitacion_idHabilitacion").val(data.Habilitacion_idHabilitacion);
		$("#Deposito_idDeposito").val(data.Deposito_idDeposito);
		$("#TerminoPago_idTerminoPago").val(data.TerminoPago_idTerminoPago);
		$("#tipo_comprobante").val(data.tipo_comprobante);
		$("#nroFactura").val(data.nroFactura);
		$("#fechaTransaccion").val(data.fechaTransaccionh);
		$("#fechaFactura").val(data.fechaFactura);
		$("#fechaVencimiento").val(data.fechaVencimiento);
		$("#timbrado").val(data.timbrado);
		$("#vtoTimbrado").val(data.vtoTimbrado);
		$("#Moneda_idMoneda").val(data.Moneda_idMoneda);
		$("#tasaCambio").val(data.tasaCambio);
		$("#tasaCambioBases").val(data.tasaCambioBases);
		$("#totalImpuesto").val(data.totalImpuesto);
		$("#total").val(data.total);
		$("#subTotal").val(data.subTotal);
		$("#fechaModificacion").val(data.fechaModificacion);
		$("#usuarioInsercion").val(data.usuarioInsercion);
		$("#usuarioModificacion").val(data.usuarioModificacion);
		$("#inactivo").val(data.inactivo);
		$("#cuotas").val(data.cuotas);

	$("#total_venta").val("");
	$(".filas").remove();
	$("#total").html("0");

	//Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
	$("#fechaTransaccion").val(today);
	$("#fechaFactura").val(today);
	$("#fechaVencimiento").val(today);
    //Marcamos el primer tipo_documento
    $("#tipo_comprobante").val("Factura");
	$("#tipo_comprobante").selectpicker('refresh');


		//Ocultar y mostrar los botones
		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		$("#btnAgregarArt").hide();
 	});

 	$.post("../ajax/venta.php?op=listarDetalle&id="+idventa,function(r){
	        $("#detalles").html(r);
	});	
}

//Función para anular registros
function anular(idVenta)
{
	bootbox.confirm("¿Está Seguro de anular la venta?", function(result){
		if(result)
        {
        	$.post("../ajax/venta.php?op=anular", {idVenta : idVenta}, function(e){

	            tabla.ajax.reload();
        	});	
        }
	})
}

//Declaración de variables necesarias para trabajar con las compras y
//sus detalles
var impuesto=10;
var cont=0;
var cont2=0;
var detalles=0;
//$("#guardar").hide();
$("#btnGuardar").hide();
$("#tipo_comprobante").change(marcarImpuesto);

function marcarImpuesto()
  {
  	var tipo_comprobante=$("#tipo_comprobante option:selected").text();
  	if (tipo_comprobante=='Factura')
    {
        $("#serie").val(serie); 
        $("#serie1").val(serie); 
        $("#nroFactura").val(fra); 
    }
    else
    {
        $("#nroFactura").val(nroTicket); 
        $("#serie").val(''); 
        $("#serie1").val(''); 
    }
  }

function agregarDetalle(idarticulo,articulo,precioVenta,impuesto)
  {
   	
	var lCompra_idCompra = $("#Compra_idCompra option:selected").val();
  	var lfactura = $("#Compra_idCompra option:selected").text();

	var lnroCuota = $("#nroCuota option:selected").val();
  	//var lservicio_nombre = $("#Articulo_idArticulo_Servicio option:selected").text();

    tipopago = $("#Moneda_idMoneda option:selected").val();

  	if (tipopago == 1) {
	  	//var importe_detalle=$("#importe_detalle").val();
		var lmonto = $("#monto").val();		
  	}else{
	  	//var importe_detalle = $("#importe_detalle").val();
	  	//var importe_detalle = quitaSeparadorMilesPago($("#importe_detalle").val());
		var lmonto = $("#monto").val();
  	}


	var lmonto = $("#monto").val();



	//alert(lCompra_idCompra);

 	//lmonto = lmonto.replace(".", "");
	//var lempleado = $("#Empleado_idEmpleado option:selected").val();
	//var lempleado_nombre = $("#Empleado_idEmpleado option:selected").text();


    	var fila='<tr class="filas" id="fila'+cont+'">'+
    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button></td>'+
    	'<td><input type="hidden" name="Compra_idCompra[]" value="'+lCompra_idCompra+'">'+lfactura+'</td>'+
    	'<td><input type="hidden" name="nroCuota[]" value="'+lnroCuota+'">'+lnroCuota+'</td>'+
    	'<td><input type="text" name="montoAplicado[]" id="montoAplicado'+cont+'" value="'+lmonto+'">'+lmonto+'</td>'+
    	'<td><span Style="Display:none;" name="subtotal" id="subtotal'+cont+'">'+lmonto+'</span></td>'+
    	'<td><button type="button" onclick="modificarSubototales()" class="btn btn-info"><i class="fa fa-refresh"></i></button></td>'+
    	'</tr>';
    	cont++;
    	detalles=detalles+1;
    	$('#detalles').append(fila);
    	modificarSubototales();
  }



  function modificarSubototales()
  {
    var neto = document.getElementsByName("monto");
    for (var i = 0; i <neto.length; i++) {
    	var inpN=neto[i];
    	document.getElementsByName("monto")[i].innerHTML =  inpN.value ;

    }
    calcularTotales(0);

  }
  function calcularTotales(x){
  	var sub = document.getElementsByName("subTotal");
	var costo = document.getElementsByName("montoAplicado[]");
  	var total = 0.0;
  	var impuestov = 0.0;
  	var t1 = 0.00;
	if (x == 0) {


	  	for (var i = 0; i <costo.length; i++) {
			t1 = parseFloat(t1) + parseFloat( costo[i].value );
		}


	}else{

	  	for (var i = 0; i <costo.length; i++) {
			t1 = parseFloat(t1) + parseFloat( costo[i].value );
		}

	}

	t1_cheque = t1;
	$("#total1").html("Gs. " + t1);
	$("#monto").val(t1);
    $("#total_ventan").val(t1);
    $("#importe_detalle").val(t1);
	$("#nroCheque").val(0);
	$("#idtotalVenta").val(t1);

    evaluar();
  }

  function evaluar(){
  	if (detalles>0)
    {
      $("#btnGuardar").show();
    }
    else
    {
      $("#btnGuardar").hide(); 
      cont=0;
      cont2=0;
    }
  }

  function eliminarDetalle(indice){


  	posicion = indice;
  	restarEsto = parseFloat($("#montoAplicado" + posicion).val());

  	$("#fila" + indice).remove();
  	calcularTotales();
  	detalles=detalles-1;
  	evaluar()
  }

function vuelto(){
    
    $dif = parseFloat($("#idvuelto").val()) - parseFloat($("#total_ventan").val());
    $("#idtotalVenta").val($("#total_ventan").val());
    $("#iddiferencia").val($dif);
}

function agregarDetallePago()
{

	
    var l_tipopago= $("#TerminoPago_idTerminoPagoDetalle option:selected").val();
  	var tipopagot = $("#TerminoPago_idTerminoPagoDetalle option:selected").text();
  	


    tipopago= $("#Moneda_idMoneda option:selected").val();

  	if (tipopago == 1) {
  		//alert(tipopagot);
  		if (l_tipopago == 4) {
	  	var importe_detalle = $("#importe_detalle").val();
  		}else{
	  	var importe_detalle = $("#importe_detalle").val();

  		}


  	}else{
	  	//var importe_detalle = $("#importe_detalle").val();
	  	var importe_detalle=$("#importe_detalle").val();
  	}
  	

	  	var ChequePropio_idChequePropio=$("#ChequePropio_idChequePropio").val();



  	var nroReferencia = $("#nroCheque").val();

   	var fila1='<tr class="filas" id="fila1'+cont2+'">'+
   	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleDetalle('+cont2+')">X</button></td>'+
   	'<td><input type="hidden" name="ChequePropio_idChequePropio1[]" value="'+ChequePropio_idChequePropio+'"><input type="hidden" name="tipopago[]" value="'+l_tipopago+'">'+tipopagot+'</td>'+
   	'<td><input type="number" name="importe_detalle[]" id="importe_detalle[]" value="'+importe_detalle+'"></td>'+
   	'<td><input type="text" name="nroReferencia[]" id="nroReferencia[]" value="'+nroReferencia+'"></td>'+
   	'<td><span name="subtotalDetalle" id="subtotalDetalle'+cont2+'">'+importe_detalle+'</span></td>'+
   	'<td><button type="button" onclick="modificarSubototalesDetalle()" class="btn btn-info"><i class="fa fa-refresh"></i></button></td>'+
   	'</tr>';
   	cont2++;
   	detalles2=detalles2+1;
   	$('#detalles1').append(fila1);
   	modificarSubototalesDetalle();


	$("#TerminoPago_idTerminoPagoDetalle").val(1);
    $('#TerminoPago_idTerminoPagoDetalle').selectpicker('refresh');
   	

}

function modificarSubototalesDetalle()
  {
  	var tp = document.getElementsByName("tipopago[]");
    var imp = document.getElementsByName("importe_detalle[]");
    var ref = document.getElementsByName("nroReferencia[]");
    var sub = document.getElementsByName("subtotalDetalle");


    for (var i = 0; i <tp.length; i++) {
    	var inpT=tp[i];
    	var inpI=imp[i];
    	var inpR=ref[i];
    	var inpS=sub[i];

    	inpS.value = inpI.value;
    	document.getElementsByName("subtotalDetalle")[i].innerHTML = inpS.value;
    }
    calcularTotalesDetalle();

  }
  function calcularTotalesDetalle(){
  	var imp = document.getElementsByName("subtotalDetalle");
  	var total = 0.0;


  	for (var i = 0; i <imp.length; i++) {
		total += parseFloat(document.getElementsByName("subtotalDetalle")[i].value);
	}
	total = parseInt(total);
  	for (var i = 0; i <imp.length; i++) {
	}
		$("#total_detalle").html("Gs. " + total);
    	$("#t_detalle").val(total);
    	verificar();
    	evaluar();
  }

  function evaluarDetalle(){
  	if (detalles2>0)
    {
      $("#btnGuardar").show();
    }
    else
    {
      $("#btnGuardar").hide(); 
      cont2=0;
    }
  }

  function eliminarDetalleDetalle(indice){
  	$("#fila1" + indice).remove();
  	calcularTotalesDetalle();
  	detalles2=detalles2-1;
  	evaluar()
  }

function verificar(){
	var v1 = document.getElementById('t_detalle').value;
	var v2 = document.getElementById('total_ventan').value;

	if (v1 != v2) {

      $('#btnGuardar').attr("disabled", true);

  }else{

      $('#btnGuardar').attr("disabled", false);


  }
}


function alertDismissJS(msj, tipo){
	var salida;
	switch (tipo){
		case 'error':
			salida = "<div id='alerta' class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+
			"<span class='glyphicon glyphicon-exclamation-sign'>&nbsp;</span>"+msj+"</div>";
		break;
		
		case 'error_span':
			salida = "<span id='alerta' class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+
			"<span class='glyphicon glyphicon-exclamation-sign'>&nbsp;</span>"+msj+"</span>";
		break;
		
		case 'warning':
			salida = "<div id='alerta' class='alert alert-warning alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+
			"<span class='glyphicon glyphicon-exclamation-sign'>&nbsp;</span>"+msj+"</div>";
		break;
		
		case 'ok':
			salida = "<div id='alerta' class='alert alert-success alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+
			"<span class='glyphicon glyphicon-ok'>&nbsp;</span>"+msj+"</div>";
		break;
		
		case 'ok_span':
			salida = "<span id='alerta' class='alert alert-success alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+
			"<span class='glyphicon glyphicon-ok'>&nbsp;</span>"+msj+"</span>";
		break;
		
		case 'info':
			salida = "<div id='alerta' class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+
			"<span class='glyphicon glyphicon-exclamation-sign'>&nbsp;</span>"+msj+"</div>";
		break;
	}
	return salida; 
}

function fechaMYSQL(fecha){
	//Para el calendario de Jqwidgets
    var fechaArr = fecha.split("/");
    var salida = fechaArr[2]+","+fechaArr[1]+","+fechaArr[0];
	return salida;
}

function fechaLatina(fecha){
    var fechaArr = fecha.split("-");
    var salida = fechaArr[2]+"/"+fechaArr[1]+"/"+fechaArr[0];
	return salida;
}

//Permitir nÃºmeros y puntos (decimales)
function isNumberKey(evt){
	 // skip for arrow keys
    if(evt.which >= 37 && evt.which <= 40){
	   evt.preventDefault();
    }
	var charCode = (evt.which) ? evt.which : evt.keyCode
	if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
		return false;
	return true;
}

//Uso: onkeypress="return soloNumeros(event)"
function soloNumeros(event){
	var key = window.event ? event.keyCode : event.which;
	if (event.keyCode == 8 || event.keyCode == 46 ||  event.keyCode == 35  || event.keyCode == 36 || event.keyCode == 116
		|| event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 13 || event.keyCode == 16 || event.keyCode == 9) {
		return true;
	}
	else if ( key < 48 || key > 57 ) {
		return false;
	}
	else return true;
}

//Separador de miles al momento de escribir
function separadorMilesOnKeyPago(event,input){


	  if(event.which >= 37 && event.which <= 40){
		  event.preventDefault();
	  }
	  var $this = $(input);

	if ($('#Moneda_idMoneda').val() == 1 ) {

	  var num = $this.val().replace(/[^\d]/g,'').split("").reverse().join("");
	  var num2 = RemoveRougeChar(num.replace(/(.{3})/g,"$1.").split("").reverse().join(""), ".");
	  return $this.val(num2);
	}else{
		return $this.val();
	}
}

//Separacion de miles para guaranies y decimales para dolares
function separadorMilesDecimales(convertString, separa){
	if(convertString.substring(0,1) == separa){
		return convertString.substring(1, convertString.length)            
		}
	return convertString;
}

function separadorMiles(x) {
	if(x){
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
	}else{
		return 0;
	}
}

function quitaSeparadorMilesPago(valor){
	if(valor){
		if ($('#Moneda_idMoneda').val() == 1) {
			return parseInt(valor.replace(/\./g, ""));
		}else{
			return valor;
		}
	}else{
		return 0;
	}
}

//Enter desde el input hace click al button seleccionado
function enterClick(input, button){
	$("#"+input).keyup(function(event){
		if(event.keyCode == 13){
			$("#"+button).click();
			}
	});
}
//Quita todos los tags HTML
function htmlToText(x){
	return x.replace(/<[^>]*>/gi, ' - ');
}


function getDateTime() {
    var now     = new Date(); 
    var year    = now.getFullYear();
    var month   = now.getMonth()+1; 
    var day     = now.getDate();
    var hour    = now.getHours();
    var minute  = now.getMinutes();
    var second  = now.getSeconds(); 
    if(month.toString().length == 1) {
        var month = '0'+month;
    }
    if(day.toString().length == 1) {
        var day = '0'+day;
    }   
    if(hour.toString().length == 1) {
        var hour = '0'+hour;
    }
    if(minute.toString().length == 1) {
        var minute = '0'+minute;
    }
    if(second.toString().length == 1) {
        var second = '0'+second;
    }   
	//var dateTime = day+'/'+month+'/'+year+' '+hour+':'+minute+':'+second;   
    var dateTime = day+'/'+month+'/'+year+' '+hour+':'+minute+' hs';   
    return dateTime;
}

//Separacion de miles para guaranies y decimales para dolares
function RemoveRougeChar(convertString, separa){
	if(convertString.substring(0,1) == separa){
		return convertString.substring(1, convertString.length)            
		}
	return convertString;
}

function readImage(input, output, divFoto) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {
			$('#'+divFoto).css('display', 'inline');
			$('#'+output)
				.attr('src', e.target.result)
				.height(120);
			if (input.id == "foto1"){
				$('#borrarFot1').css('display', 'inline');
				$('#borrar_foto1').val('');
			}
			if (input.id == "foto2"){
				$('#borrarFot2').css('display', 'inline');
				$('#borrar_foto2').val('');
			}
			
			
			
		};

		reader.readAsDataURL(input.files[0]);
	}
}

function noSubmitForm(obj){
	$(obj).on('keyup keypress', function(e) {
	  var code = e.keyCode || e.which;
	  if (code == 13) { 
		e.preventDefault();
		return false;
	  }
	});
}


//Funcion que sirve para enviar variables por POST a un form en un popup. Esto evita que se vean las variables en la barra de direcciÃ³n del navegador
function OpenWindowWithPost(url, windowoption, name, params)
{
	var form = document.createElement("form");
	form.setAttribute("method", "post");
	form.setAttribute("action", url);
	form.setAttribute("target", name);
	for (var i in params) {
		if (params.hasOwnProperty(i)) {
			var input = document.createElement('input');
			input.type = 'hidden';
			input.name = i;
			input.value = params[i];
			form.appendChild(input);
		}
	}
	document.body.appendChild(form);
	window.open("", name, windowoption);
	form.submit();
	document.body.removeChild(form);
}

//Oculta div padre del alert al cerrar mensaje para que el efecto de fadein funcione
/*function ocultarMensaje(){
	$('#alerta').on('close.bs.alert', function () {
	  $('#alerta').parent().css("display","none");
	});
}*/


init();