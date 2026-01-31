var g_idCliente = 0;
var peticion = 0;
var veces = 0;
var limite_credito = 0;
var controlar_stock = 0; // 1 si - 0 No
var controlar_limite_credito = 0; // 1 si - 0 No
var tabla;
var tabla2;
var l_habilitacion;
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
	$('#mostrarCampo').hide();
	$('#nomostrar').hide();
	$('#nomostrar2').hide();

	mostrarform(true);
	$("#buscar_articulo").hide();
	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	});

	$("#formularioCliente").on("submit",function(e)
	{
		guardaryeditarCliente(e);	
	});


	//cargamos los items al select usuario
	$.post("../ajax/habilitacion.php?op=selectUsuario", function(r){
		$("#Persona_idPersona").html(r);
		$("#Persona_idPersona").selectpicker('refresh');

		$("#proveedorD1").html(r);
		$("#proveedorD1").selectpicker('refresh');

	//cargamos los items al select usuario
	$.post("../ajax/habilitacion.php?op=selectCaja", function(r){
		$("#Caja_idCaja").html(r);
		$("#Caja_idCaja").selectpicker('refresh');
	});


	});
	$.post("../ajax/moneda.php?op=selectMoneda", 
		 function(r){
	            $("#CtaCte").html(r);
	            $('#CtaCte').selectpicker('refresh'); 
	});	
 
	//Cargamos los items al select cliente
	$.post("../ajax/moneda.php?op=selectMoneda", function(r){
	            $("#Moneda_idMoneda").html(r);
	            $('#Moneda_idMoneda').selectpicker('refresh');
	});	
 
	//Cargamos los items al select cliente
	$.post("../ajax/formaPago.php?op=selectFormaPago", function(r){
	            $("#FormaPago_idFormaPago").html(r);
	            $('#FormaPago_idFormaPago').selectpicker('refresh');
	});	


	//Cargamos los items al select cliente
	$.post("../ajax/terminoPago.php?op=selectTerminoPago", function(r){
	            $("#TerminoPago_idTerminoPago").html(r);
	            $('#TerminoPago_idTerminoPago').selectpicker('refresh');
	});	



	//Cargamos los items al select cliente
	$.post("../ajax/venta.php?op=selectBanco", function(r){
	            $("#Banco_idBanco").html(r);
	            $('#Banco_idBanco').selectpicker('refresh');
	});	

	//Cargamos los items al select cliente
	$.post("../ajax/deposito.php?op=selectDeposito", function(r){
	            $("#Deposito_idDeposito").html(r);
	            $('#Deposito_idDeposito').selectpicker('refresh');
	});	

 
	$.post("../ajax/cotizacionDiaria.php?op=ultimaCotizacion", { Moneda_idMoneda: 2 } , function(data, status)
	{
		data = JSON.parse(data);
		$("#tasaCambioBases").val(data.cotizacionCompra);
	});
		

	$.post("../ajax/cotizacionDiaria.php?op=ultimaCotizacion", { Moneda_idMoneda: 1} , function(data, status)
	{
		data = JSON.parse(data);
		$("#tasaCambio").val(data.cotizacionCompra);
	 });

/*

	//habilitacion factura
	$.post("../ajax/venta.php?op=habilitacion", { tipoDocumento: 1 } ,function(data, status)
		{

		data = JSON.parse(data);		
		$('#Habilitacion_idHabilitacion').val(data.idhabilitacion);
		$('#Habilitacion_idHabilitacion1').val(data.idhabilitacion);
		l_habilitacion = data.habilitacion;
		l_nroActual = data.a;
		l_nroMax	= data.max;
		//$('#Deposito_idDeposito').val(data.dp);
		serie = data.serie;
		fra = data.a;
		$("#serie").val(serie); 
    	$("#serie1").val(serie); 
    	$("#nroFactura").val(fra); 
		$("#fechaFactura1").val(data.fecha);
		$("#fechaFactura").val(data.fecha);
		//$("#Deposito_idDeposito").val(data.dp);
		//$("#Deposito_idDeposito1").val(data.deposito);
		//$("#sucursal").val(data.sucursal);
		$("#timbrado").val(data.timbrado);
		$("#vtoTimbrado").val(data.fechaEntrega);
		

		var usuario_ins = data.usuario_ins;
		var d = new Date();

		var month = d.getMonth()+1;
		var day = d.getDate();

		var hoy = d.getFullYear() + '-' +
		    (month<10 ? '0' : '') + month + '-' +
		    (day<10 ? '0' : '') + day;
	
			
		if ($('#Habilitacion_idHabilitacion').val() == '') {
		//	alert('No cuenta con una habilitacion activa.');	
	    //		location.href ="habilitacion.php";
		}
		else
		{


			if( l_nroMax< l_nroActual)
			{
				 
			//	alert('No cuenta con facturas disponibles.');	
			//	location.href ="habilitacion.php"; 

			}else
			{
				if( hoy != $("#fechaFactura").val())
				{
					if(usuario_ins == 1){
						listar($('#Habilitacion_idHabilitacion').val());	
						listarFacturados($('#Habilitacion_idHabilitacion').val());

					}else{
						//alert('Su habilitacion no coincide con la fecha.');	
						//location.href ="habilitacion.php";				
					}				
				}else{
					listar($('#Habilitacion_idHabilitacion').val());
					listarFacturados($('#Habilitacion_idHabilitacion').val());
				}
			}	
		}
			

	 });


*/
	//Habilitacion ticket
	$.post("../ajax/venta.php?op=ultimo", function(data, status)
		{

			data = JSON.parse(data);
			if (data.maximo == null) {
				nroTicket = 1;
			}else{
				nroTicket = data.maximo;
			}
	 });


}




function buscar_articulo_cb(codigoBarras)
{
 
    separador = "+", // un espacio en blanco
    arregloDeSubCadenas = codigoBarras.split(separador);
    var cantidad = (arregloDeSubCadenas[0]);
    var codigoBarras_v2 = (arregloDeSubCadenas[1]);


    if (!codigoBarras_v2) {
      cantidad = 1;
    }else{
    	codigoBarras = codigoBarras_v2;
    }


	$.post("../ajax/articulo.php?op=buscar_articulo_cb",{codigoBarras : codigoBarras}, function(data, status)
	{
		data = JSON.parse(data);		
		if (!data) {
			alert('no se encontraron datos');
			$("#articulo_codigobarras").val('');
			$("#articulo_codigobarras").focus();
		}else{
			if (data.TipoImpuesto_idTipoImpuesto == 1) {
				var impuesto = 10;
			}

			if (data.TipoImpuesto_idTipoImpuesto == 2) {
				var impuesto = 5;
			}

			if (data.TipoImpuesto_idTipoImpuesto == 3) {
				var impuesto = 0;
			}

			agregarDetalle(data.idArticulo,data.nombre,data.precioLista,data.TipoImpuesto_idTipoImpuesto,impuesto, 0, 0, cantidad)

			$("#articulo_codigobarras").val('');
			$("#articulo_codigobarras").focus();


		}

	});
}
 

function cambiarComprobante(tipoDocumento){
 
	//habilitacion factura
	$.post("../ajax/venta.php?op=habilitacion", { tipoDocumento: tipoDocumento } ,function(data, status)
		{

			data = JSON.parse(data);		
			$('#Habilitacion_idHabilitacion').val(data.idhabilitacion);
			$('#Habilitacion_idHabilitacion1').val(data.idhabilitacion);
			l_habilitacion = data.habilitacion;
			//$('#Deposito_idDeposito').val(data.dp);
			serie = data.serie;
			fra = data.a;
			$("#serie").val(serie); 
        	$("#serie1").val(serie); 
        	$("#nroFactura").val(fra); 
			$("#fechaFactura1").val(data.fecha);
			$("#fechaFactura").val(data.fecha);
			//$("#Deposito_idDeposito").val(data.dp);
			//$("#Deposito_idDeposito1").val(data.deposito);
			//$("#sucursal").val(data.sucursal);
			$("#timbrado").val(data.timbrado);
			$("#vtoTimbrado").val(data.fechaEntrega);
			


		  	var tipo_comprobante=$("#tipo_comprobante option:selected").text();
		  	if (tipo_comprobante=='Factura' || $("#tipo_comprobante").val() == 3)
		    {

		    	if (serie) {
					$("#serie").val(serie); 
		        	$("#serie1").val(serie); 
		        	$("#nroFactura").val(fra);
		    	}else{
		    		alert('Configure comprobante: ' + tipo_comprobante + '.');
		    		$("#tipo_comprobante").val(1);
		    		$('#tipo_comprobante').selectpicker('refresh');
		    		cambiarComprobante(1);
		    	} 
		    }
		    else
		    {
		        $("#nroFactura").val(nroTicket); 
		        $("#serie").val(''); 
		        $("#serie1").val(''); 
		    }
					

	 });
 

	// //Habilitacion ticket
	$.post("../ajax/venta.php?op=ultimo", function(data, status)
		{

			data = JSON.parse(data);
			if (data.maximo == null) {
				nroTicket = 1;
			}else{
				nroTicket = data.maximo;
			}
	 });


}

 

function cargarTasa(x){

	$.post("../ajax/cotizacionDiaria.php?op=ultimaCotizacion", { Moneda_idMoneda: x.value } , function(data, status)
		{

			data = JSON.parse(data);
			$("#tasaCambio").val(data.cotizacionCompra);
	 });
	 

	 $.post("../ajax/cotizacionDiaria.php?op=ultimaCotizacion", { Moneda_idMoneda: 2 } , function(data, status)
		{
			data = JSON.parse(data);
			$("#tasaCambioBases").val(data.cotizacionCompra);
	 });


}



function mostrarCampos(){
		
	 if ($("#giftCard").val() == 0 ) {
		$('#mostrarCampo').hide();
	 }else{
		$('#mostrarCampo').show();
	 }
}


//Separador de miles al momento de escribir
function separadorMilesOnKey(event,input){
	  if(event.which >= 37 && event.which <= 40){
		  event.preventDefault();
	  }
	  var $this = $(input);
	  var num = $this.val().replace(/[^\d]/g,'').split("").reverse().join("");
	  var num2 = RemoveRougeChar(num.replace(/(.{3})/g,"$1.").split("").reverse().join(""), ".");
	  return $this.val(num2);
}

function RemoveRougeChar(convertString, separa){
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


function mostrarDetalleVenta(idVenta){
	$('#modal_detalle').modal('show');
	$("#detalle").val(idVenta);
$(document).ready(function() {
    $('#tbllistado4').DataTable( {
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
					url: '../ajax/consultas.php?op=rpt_ventas_detalle',
					data:{idVenta:idVenta},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
  			"columnDefs": [
            {
                "targets": [ 4 ],
                "visible": true,
                "searchable": false
            }],

                    "language": {
            "decimal": ".",
            "thousands": ","
        },
		"bDestroy": true,
		"iDisplayLength": 20,//Paginación
	    "order": [[ 3, "desc" ],[ 3, "desc" ]],//Ordenar (columna,orden)

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
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return parseFloat(intVal(a)) + parseFloat(intVal(b));
                }, 0 );
 
            // Update footer
            $( api.column( 6 ).footer() ).html(
               formatNumber.new(pageTotal) 
            );
        }
    } );
} );
}


function mostrarDetalleCobro(idVenta){
	$('#modal_detalle_cobro').modal('show');
	$("#detalle_cobro").val(idVenta);
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
					url: '../ajax/consultas.php?op=rpt_cobros_detalle',
					data:{idVenta:idVenta},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
 

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
               formatNumber.new(pageTotal) 
            );

        }
    } );
} );
}



function imprimirArqueo(){
	window.open("../reportes/exArqueo.php?id="+ $("#Habilitacion_idHabilitacion").val());
}



function guardaryeditarCliente(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioCliente")[0]);

	//habilitacion factura
	$.post("../ajax/venta.php?op=habilitacion", { tipoDocumento: 1 } ,function(data, status)
		{

			data = JSON.parse(data);		
			$('#Habilitacion_idHabilitacion').val(data.idhabilitacion);
			$('#Habilitacion_idHabilitacion1').val(data.idhabilitacion);
			l_habilitacion = data.habilitacion;
			//$('#Deposito_idDeposito').val(data.dp);
			serie = data.serie;
			fra = data.a;
			$("#serie").val(serie); 
        	$("#serie1").val(serie); 
        	$("#nroFactura").val(fra); 
			$("#fechaFactura1").val(data.fecha);
			$("#fechaFactura").val(data.fecha);
			//$("#Deposito_idDeposito").val(data.dp);
			//$("#Deposito_idDeposito1").val(data.deposito);
			//$("#sucursal").val(data.sucursal);
			$("#timbrado").val(data.timbrado);
			$("#vtoTimbrado").val(data.fechaEntrega);
			

			var usuario_ins = data.usuario_ins;
			var d = new Date();

			var month = d.getMonth()+1;
			var day = d.getDate();

			var hoy = d.getFullYear() + '-' +
			    (month<10 ? '0' : '') + month + '-' +
			    (day<10 ? '0' : '') + day;
	
			
			$.ajax({
				url: "../ajax/persona.php?op=guardar",
			    type: "POST",
			    data: formData,
			    contentType: false,
			    processData: false,

			    success: function(datos)
			    {                    
					data = JSON.parse(datos);		
					$.post("../ajax/persona.php?op=selectCliente", function(r){
					            $("#Cliente_idCliente").html(r);
					            $('#Cliente_idCliente').selectpicker('refresh');

								$("#Cliente_idCliente").val(data.Persona_idPersona);
								$("#Cliente_idCliente").selectpicker('refresh');
					});

					$.post("../ajax/persona.php?op=selectCliente", function(r){
						        $("#clienteGiftCard").html(r);
						        $('#clienteGiftCard').selectpicker('refresh');
						});		

			    },
			    complete: function(datos){
					$('#cliente').modal('hide');

					limpiarCliente();	

			    }

			});
			

	 });

}


function modalCliente(){
	$('#cliente').modal('show');
}

//Función limpiar
function limpiar()
{
	$("#tipo_comprobante").val("");
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
	$("#entregado").val(0);
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
	$("#cuotas").val(0);

}

//Función limpiar
function limpiarCliente()
{
	$("#razonSocial").val("");
	$("#tipoDocumento").val("");
	$("#nroDocumento").val("");
	$("#celular").val("");
	$("#nacimiento").val("");
}

function vuelto(){
    
    $dif = $("#idvuelto").val() - $("#total_venta").val();
    $("#idtotalVenta").val($("#total_venta").val());
    $("#iddiferencia").val($dif);
}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#listadoregistrosfacturados").hide();
		$("#formularioregistros").show();
		//$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
		//listarArticulos();

		$("#btnGuardar").show();
		$("#btnCancelar").show();
		$("#btnAgregarArt").show();
		detalles=0;
		detalles2=0;
	}
	else
	{
 

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
	window.location = ("../vistas/hacerHabilitacion.php") ;
}


function detallePago(x){
	//consulta si el termino de pago es al contado
	$.post("../ajax/terminoPago.php?op=contado",{ idTerminoPago: x.value }, function(data, status)
		{

			data = JSON.parse(data);
			if (data.contado == 1) {
				$("#pagoDetalle").show();		
			}else{
				$("#pagoDetalle").hide();
			}
	 });


}


function generarFactura(idOrdenVenta, Deposito_idDeposito, idTerminoPago, usuario, idPersona, contado){

	if (contado == 1) {
		$("#pagoDetalle").show();
	}else{
		$("#pagoDetalle").hide();
	}

	mostrarform(true);

	g_idCliente = idPersona;


	//Cargamos los items al select cliente
	$.post("../ajax/terminoPago.php?op=selectTerminoPagoPersona", { idPersona: g_idCliente } , function(r){
	            $("#TerminoPago_idTerminoPago").html(r);
				$("#TerminoPago_idTerminoPago").val(idTerminoPago);
	            $('#TerminoPago_idTerminoPago').selectpicker('refresh');
	});	


    $.ajax({
    type: "POST",
    url: "../ajax/persona.php?op=selectClienteLimit",
    data:{keyword:idPersona, tipoPersona: 1},
    success: function(data){
      $("select.selector_persona ").html(data);
      $("select.selector_persona").selectpicker("refresh");
    
		$("#Cliente_idCliente").val(idPersona);
		$("#Cliente_idCliente").selectpicker('refresh');

    },
    error: function(data){
        console.log("NO se pudo enviar");
    }
    });

	$("#Cliente_idCliente").val(idPersona);
	$("#Cliente_idCliente").selectpicker('refresh');
	$("#TerminoPago_idTerminoPago").val(idTerminoPago);
	$("#TerminoPago_idTerminoPago").selectpicker('refresh');



    $("#OrdenVenta_idOrdenVenta").val(idOrdenVenta);
    $("#Empleado_idEmpleado1").val(usuario);
    $("#Empleado_idEmpleado").val(usuario);

    $("#Deposito_idDeposito").val(Deposito_idDeposito);
	$("#Deposito_idDeposito").selectpicker('refresh');

 	$.post("../ajax/venta.php?op=listarDetalleOrdenVenta&id="+idOrdenVenta,function(r){
	        $("#detalles").html(r);
    		modificarSubototales();
	});	

	//listarArticulos(idPersona);
	peticion = 1;
}


function noCambiar(x){

	//esta funcion solo se activa si la factura se genera desde una orden de venta.




	if (g_idCliente > 0) {

    $.ajax({
    type: "POST",
    url: "../ajax/persona.php?op=selectClienteLimit",
    data:{keyword:idPersona, tipoPersona: 1},
    success: function(data){
      $("select.selector_persona ").html(data);
      $("select.selector_persona").selectpicker("refresh");
    
		$("#Cliente_idCliente").val(idPersona);
		$("#Cliente_idCliente").selectpicker('refresh');


    },
    error: function(data){
        console.log("NO se pudo enviar");
    }
    });


	$("#Cliente_idCliente").val(g_idCliente);
	$("#Cliente_idCliente").selectpicker('refresh');


	}


}



function selectPeriodo(x){

	//esta funcion solo se activa si la factura se genera desde una orden de venta.
	$.post("../ajax/persona.php?op=selectPeriodo", { id:x.value }, function(r){
	            $("#periodo").html(r);
	            $('#periodo').selectpicker('refresh');
	});	
	

}


function addArticuloSaldo(){

var periodo= 0;
periodo = $("#CtaCte").val();
 
if (periodo > 0) {
	$.post("../ajax/cargaHabilitacion.php?op=selectDenominacion", { id: periodo   }, function(data,status){


 
			$("#detalles").html(data);
			/*data = JSON.parse(data);

			console.log(data);

	        var idMoneda = data.idMoneda; 
	        var dmoneda = data.moneda; 
	        var ddenominacion =	data.denominacion; 
	        var e = document.getElementById("CtaCte");
	        var text = e.options[e.selectedIndex].text;
	        var dnombre = (data.denominacion +' - ' + text); 

	        agregarDetalle(idMoneda,dmoneda,ddenominacion,dnombre);*/
 

	});	


}


}




function mostrarDetalleordenVenta(OrdenVenta_idOrdenVenta){
	$('#modal_detalle').modal('show');
	$("#detalle").val(OrdenVenta_idOrdenVenta);
$(document).ready(function() {
    $('#tbllistado4').DataTable( {
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
					url: '../ajax/consultas.php?op=rpt_ordenVentas_detalle',
					//url: '../ajax/consultas.php?op=rpt_ventas_detalle',
					data:{OrdenVenta_idOrdenVenta:OrdenVenta_idOrdenVenta},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
  			"columnDefs": [
            {
                "targets": [ 4 ],
                "visible": true,
                "searchable": false
            }],

                    "language": {
            "decimal": ".",
            "thousands": ","
        },
		"bDestroy": true,
		"iDisplayLength": 20,//Paginación
	    "order": [[ 3, "desc" ],[ 3, "desc" ]],//Ordenar (columna,orden)

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
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return parseFloat(intVal(a)) + parseFloat(intVal(b));
                }, 0 );
 
            // Update footer
            $( api.column( 6 ).footer() ).html(
               formatNumber.new(pageTotal) 
            );
        }
    } );
} );
}


function listar(habilitacion)
{
	tabla=$('#tbllistado').dataTable(
	{

		"fnRowCallback": function( nRow, aaData, iDisplayIndex, iDisplayIndexFull ) {
		  if ( aaData[13] != '<span class="label bg-green">Aceptado</span>' )
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
					url: '../ajax/ordenVenta.php?op=listarAFacturar',
					data:{habilitacion:habilitacion},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
	    "responsive": true,
//
		"bDestroy": true,
//		"iDisplayLength":5,//Paginación
//	    "order": [[ 1, "desc" ]]//Ordenar (columna,orden)

 		"scrollY":        "300px",
        "scrollCollapse": true,
        "paging":         false,
 	    "order": [[ 1, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}




function listarFacturados(habilitacion)
{
	tabla=$('#tbllistadoFacturados').dataTable(
	{

		"fnRowCallback": function( nRow, aaData, iDisplayIndex, iDisplayIndexFull ) {
		  if ( aaData[13] != '<span class="label bg-green">Aceptado</span>' )
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
					url: '../ajax/ordenVenta.php?op=listarFacturados',
					data:{habilitacion:habilitacion},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
	    "responsive": true,
//
		"bDestroy": true,
//		"iDisplayLength":5,//Paginación
//	    "order": [[ 1, "desc" ]]//Ordenar (columna,orden)

 		"scrollY":        "300px",
        "scrollCollapse": true,
        "paging":         false,
 	    "order": [[ 1, "desc" ]]//Ordenar (columna,orden)

	}).DataTable();
}




//Función ListarArticulos
function listarArticulos(Persona_idPersona0)
{

	veces++;
    var Persona_idPersona = $("#Cliente_idCliente").val();
    var terminoPago = $("#TerminoPago_idTerminoPago").val();
    var buscar_art = $("#buscar_art").val();

	clienteAnterior = Persona_idPersona;


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
					data : { Persona_idPersona : Persona_idPersona, terminoPago: terminoPago, buscar_art:buscar_art },
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


//Función ListarArticulos
function listarArticulos2(Persona_idPersona0)
{

	veces++;
    var Persona_idPersona = $("#Cliente_idCliente").val();
    var terminoPago = $("#TerminoPago_idTerminoPago").val();
    var buscar_art = $("#buscar_art").val();

	clienteAnterior = Persona_idPersona;


	tabla=$('#tblarticulos').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            
		        ],
		"ajax":
				{
					url: '../ajax/venta.php?op=listarArticulosVenta2',
					data : { Persona_idPersona : Persona_idPersona, terminoPago: terminoPago, buscar_art:global_direccion },
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
	
 
	
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);


	$.ajax({
		url: "../ajax/cargaHabilitacion.php?op=guardaryeditar",
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
			 // window.open("../reportes/exFacturaForm.php?id="+datos, "_blank");
			  window.location = ("../vistas/hacerHabilitacion.php") ;
	          mostrarform(false); 
			limpiar();
	    },
	    complete: function(e){
	    	cont2 = 0; 
	    	//listarFacturados(l_habilitacion);    
			limpiar();
	    }

	});
	limpiar();
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
        		bootbox.alert(e);
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
$("#tipo_comprobante").change(marcarImpuesto);

function marcarImpuesto()
  {

  	serie = 0;
  	fra = 0;

  	cambiarComprobante($("#tipo_comprobante").val());

  }


function cantidadAdd( idArticulo, g_cantidad ){
	var cantidad = g_cantidad;
  	var cant = document.getElementsByName("cantidad[]");
  	var art = document.getElementsByName("idarticulo[]");

  	for (var i = 0; i < art.length; i++) {
    	var lart=art[i];
  		alert(lart.value);
  		//lart = lart.value;

    	var lcant = cant[i];
  		lcant = lcant.value;

  		if (lart == idArticulo) {
	  		cantidad = cantidad + lcant;
  		}
  	}

  	return cantidad;

}




function limiteAdd( v_precioVenta ){


	if (parseFloat(v_precioVenta) > parseFloat(limite_credito)) {
		return v_precioVenta;
	}else{


  	var cant = document.getElementsByName("cantidad[]");
  	var art = document.getElementsByName("idarticulo[]");
  	var precioVenta = document.getElementsByName("precioVenta[]");
  	var descuento = document.getElementsByName("descuento[]");
  	var tventa = 0;

  	for (var i = 0; i < art.length; i++) {

  		alert('valor i '+ i);

    	var lcant = cant[i];
  		cantidad = parseFloat(lcant.value);
  		alert('Cantidad '+cantidad);


    	var lprecioVenta = precioVenta[i];
  		vprecioVenta = parseFloat(lprecioVenta.value);
  		alert('precio venta '+vprecioVenta);


    	var ldescuento = descuento[i];
  		vdescuento = parseFloat(ldescuento.value);
  		alert('Descuento '+vdescuento);



  		var neto = (parseFloat(cantidad) * vprecioVenta) - ( ((cantidad * vprecioVenta) * vdescuento) / 100 )

  		alert('neto: '+neto)

	  	tventa = tventa + neto;
  		alert('acumulado: '+ tventa);

  	}

  	return parseFloat(tventa) + parseFloat(v_precioVenta);
  }

}



function agregarDetalle(idMoneda,dmoneda,denominacion,dnombre)
  {
  	var cantidad=1;
    var descuento=0;
    var impouesto=0;
	var precioVentan;
	peticion = 0;

 

	 var periodo = $("#periodo").val();

    if (idMoneda!="")
    { 
    	var fila='<tr class="filas" id="fila'+cont+'">'+
    	'<td><input type="hidden" name="ddd[]" id="denominacion[]" value="'+denominacion+'">'+
    	'<button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button></td>'+
    	'<td><input type="hidden" name="idMoneda[]" value="'+idMoneda+'">'+idMoneda+'</td>'+
    	'<td><input type="number" readonly name="cantidad[]" onblur="modificarSubototales()" id="cantidad[]" value="'+cantidad+'"></td>'+
    	'<td><input type="number" name="dnombre[]"  id="dnombre[]" value="'+dnombre+'">'+dnombre+'</td>'+
    	'<td><input type="number" readonly name="descuento[]" onblur="modificarSubototales()"  value="'+descuento+'" ></td>'+
    	'<td><input type="hidden" name="impuesto[]" onblur="modificarSubototales()" value="'+impuesto+'">'+impuesto+' %</td>'+
    	'<input type="hidden" name="TipoImpuesto_idTipoImpuesto[]" value="'+idMoneda+'">'+
    	'<td><span name="subtotal" id="subtotal'+cont+'">'+cont+'</span></td>'+
    	'<td><button type="button" onclick="modificarSubototales()" class="btn btn-info"><i class="fa fa-refresh"></i></button></td>'+
    	'</tr>';
    	cont++;
    	detalles=detalles+1;
    	$('#detalles').append(fila);
  
    }
    else
    {
    	alert("Error al ingresar el detalle, revisar los datos del artículo");
    }
  }


  

  function evaluar(){
  	if (detalles>0 || peticion == 1)
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
  	$("#fila" + indice).remove();
  	calcularTotales();
  	detalles=detalles-1;
  	evaluar()
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
  	$("#fila2" + indice).remove();
  	calcularTotalesDetalle();
  	detalles=detalles-1;
  	evaluar()
  }

function verificar(){


	var v1 = document.getElementById('t_detalle').value;
	var v2 = document.getElementById('total_venta').value;
	if (v1 != v2) {
      $("#btnGuardar").hide(); 

  }else{
      $("#btnGuardar").show(); 

  }
}

init();
