var g_idCliente = 0;
var peticion = 0;
var veces = 0;
var tabla;
var tabla2;
var l_habilitacion;
var f4 = 0;
var monedaAgregada = 0;
var origen = 0;

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


	$("#buscar_cliente").focus();
	$(".loader").hide();
	$("#ocultarInputs").hide();
	$("#pagar").hide();
	$("#agregarProductos").show();
	$('#mostrarCampo').hide();
	mostrarform(true);
	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	});

	$("#formularioCliente").on("submit",function(e)
	{
		guardaryeditarCliente(e);	
	});
	//Cargamos los items al select cliente
/*	$.post("../ajax/ordenConsumision.php?op=selectEmpleado", function(r){
	            $("#Empleado_idEmpleado").html(r);
	            $('#Empleado_idEmpleado').selectpicker('refresh');
	});	
*/


	//Cargamos los items al select cliente
	$.post("../ajax/moneda.php?op=selectMoneda", function(r){
	            $("#Moneda_idMoneda").html(r);
	            $('#Moneda_idMoneda').selectpicker('refresh');

	            $("#Moneda_idMoneda2").html(r);
	            $('#Moneda_idMoneda2').selectpicker('refresh');

	            $('#Moneda_idMoneda2').val(2);
	            $('#Moneda_idMoneda2').selectpicker('refresh');

	});	

	//$.post("../ajax/persona.php?op=selectCliente", function(r){
	//            $("#Cliente_idCliente").html(r);
	//            $('#Cliente_idCliente').selectpicker('refresh');
	//});

	//Cargamos los items al select cliente
	$.post("../ajax/formaPago.php?op=selectFormaPago", function(r){
	            $("#FormaPago_idFormaPago").html(r);
	            $('#FormaPago_idFormaPago').selectpicker('refresh');

	            $("#FormaPago_idFormaPago").val(5);
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
		$("#tasaCambioBases2").val(data.cotizacionCompra);
	});
		

	$.post("../ajax/cotizacionDiaria.php?op=ultimaCotizacion", { Moneda_idMoneda: 1} , function(data, status)
	{
		data = JSON.parse(data);
		$("#tasaCambio").val(data.cotizacionCompra);
		$("#tasaCambio2").val(data.cotizacionCompra);
	 });



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
	
			
			if ($('#Habilitacion_idHabilitacion').val() == '') {
				alert('No cuenta con una habilitacion activa.');	
				location.href ="habilitacion.php";
			}
			else
			{
				if( hoy != $("#fechaFactura").val())
				{
					if(usuario_ins == 1){
						listar($('#Habilitacion_idHabilitacion').val());	
						listarFacturados($('#Habilitacion_idHabilitacion').val());

					}else{
						alert('Su habilitacion no coincide con la fecha.');	
						location.href ="habilitacion.php";				
					}				
				}else{
					listar($('#Habilitacion_idHabilitacion').val());
					listarFacturados($('#Habilitacion_idHabilitacion').val());
				}
			}
			

	 });



	//Habilitacion ticket
	$.post("../ajax/venta.php?op=ultimo", function(data, status)
		{

			data = JSON.parse(data);
			if (data.maximo == null) {
				nroTicket = 1;
			}else{
				nroTicket = data.maximo;
			}

			//agregarDetallesMoneda();

	 });


}



var vcosto;
var moneda_inicial;
var vl_tasaCambio;
var vl_tasacambiobase;
var vmoneda;
var entro = 0;
function cambiarMoneda2(moneda){


	var costo = document.getElementsByName("costo[]");
	var l_tasaCambio = $("#tasaCambio2").val();
	var l_tasacambiobase = $("#tasaCambioBases2").val();

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
	   	



	// vcosto = document.getElementsByName("costo[]");
	// vl_tasaCambio = $("#tasaCambio").val();
	// vl_tasacambiobase = $("#tasaCambioBases").val();
	// vmoneda = moneda;
	// entro = 1;


//   	modificarSubototales();

}


// $(function() {
//     $(document).on('keydown', 'body', function(event) {
//         if(event.keyCode==13){ //F1
//         	alert($("#articulo_codigobarras").val())
//          }
//      });
//  });




$(function() {
    $(document).on('keydown', 'body', function(event) {
        if(event.keyCode==116){ //F4

        	if (f4 == 0) {
        	irPagos();
        	f4 =1;
        	}else{
        	if (monedaAgregada == 0) {
        		agregarDetallesMoneda();
        		monedaAgregada = 1;
        	}
        	f4=0;
        	}
        }
      });
});





   
$(function() {
    $(document).on('keydown', 'body', function(event) {
        if(event.keyCode==115){ //F4

        	if (f4 == 0) {
        	irPagos();
        	f4 =1;
        	}else{
        	irPrincipal();
        	f4=0;
        	}
        }
      });
});

function irPagos(){

	$("#pagar").show();
	$("#agregarProductos").hide();

}


function irPrincipal(){

	$("#pagar").hide();
	$("#agregarProductos").show();

}



$(document).ready(function(){     
      $("#buscar_cliente").keypress(function(e) {
        if(e.which == 13) {
         	// buscar_articulo_cb($("#articulo_codigobarras").val());
        	buscar_cliente( $("#buscar_cliente").val() );
        }
      });
});



$(document).ready(function(){     
      $("#articulo_codigobarras").keypress(function(e) {
        if(e.which == 13) {
         	buscar_articulo_cb($("#articulo_codigobarras").val());
        }
      });
});






function buscar_cliente(Cliente_idCliente)
{

    if (!Cliente_idCliente) {
      return;
    }


	$.post("../ajax/persona.php?op=buscar_persona_ruc",{nroDocumento : Cliente_idCliente}, function(data, status)
	{

		data = JSON.parse(data);		
		if (!data) {
			//alert('no se encontraron datos');
			$('#cliente').modal('show');
			$('#razonSocial').focus();
			
			$("#buscar_cliente").val('');
			$("#buscar_cliente").focus();
			$("#NombreCliente").html( '' );
			$("#NombreCliente").hide();
		}else{

			$("#Cliente_idCliente").val( data.Cliente_idCliente );
			$("#NombreCliente").html( data.razonSocial );
			$("#NombreCliente").show();
			$("#articulo_codigobarras").focus();


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




$(function() {
    $(document).on('keydown', 'body', function(event) {
        if(event.keyCode==113){ //F1
			$("#buscar_cliente").val('');
			$("#buscar_cliente").focus();
         }
     });
 });




$(function() {
    $(document).on('keydown', 'body', function(event) {
        if(event.keyCode==17){ //F1
			$("#Cliente_idCliente").focus();
         }
     });
 });




$(function() {
    $(document).on('keydown', 'body', function(event) {
        if(event.keyCode==111){ //F1
        	irPrincipal();
         }
     });
 });



// $(function() {
//     $(document).on('keydown', 'body', function(event) {
//         if(event.keyCode==112){ //F2
//             if (origen == 0) {
//             	irPagos();
//             	origen = 1;
//             }else if(origen == 1){
//             	origen = 2;
//             	guardarConfirmacion();
//             }else if(origen == 2){
//             	guardarConfirmacion();
//             }
//          }
//      });
//  });








function guardarConfirmacion(){

}


function ultimoNumero(){


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
	
			
			if ($('#Habilitacion_idHabilitacion').val() == '') {
				alert('No cuenta con una habilitacion activa.');	
				location.href ="habilitacion.php";
			}
			else
			{
				if( hoy != $("#fechaFactura").val())
				{
					if(usuario_ins == 1){
						listar($('#Habilitacion_idHabilitacion').val());	
						listarFacturados($('#Habilitacion_idHabilitacion').val());

					}else{
						alert('Su habilitacion no coincide con la fecha.');	
						location.href ="habilitacion.php";				
					}				
				}else{
					listar($('#Habilitacion_idHabilitacion').val());
					listarFacturados($('#Habilitacion_idHabilitacion').val());
				}
			}
			

	 });


}


function agregarDetallesMoneda(){


	$.post("../ajax/cotizacionDiaria.php?op=ultimaCotizacion", { Moneda_idMoneda: 1 } , function(data, status)
		{

			$("#Moneda_idMoneda2").val(1);
			$('#Moneda_idMoneda2').selectpicker('refresh');
			data = JSON.parse(data);
			$("#tasaCambio2").val(data.cotizacionCompra);
			agregarDetallePago();
	 });
	 




	$.post("../ajax/cotizacionDiaria.php?op=ultimaCotizacion", { Moneda_idMoneda: 2 } , function(data, status)
		{
			$("#Moneda_idMoneda2").val(2);
			$('#Moneda_idMoneda2').selectpicker('refresh');
			data = JSON.parse(data);
			$("#tasaCambio2").val(data.cotizacionCompra);
			agregarDetallePago();
	 });
	 





	$.post("../ajax/cotizacionDiaria.php?op=ultimaCotizacion", { Moneda_idMoneda: 3 } , function(data, status)
		{
			$("#Moneda_idMoneda2").val(3);
			$('#Moneda_idMoneda2').selectpicker('refresh');
			data = JSON.parse(data);
			$("#tasaCambio2").val(data.cotizacionCompra);
			agregarDetallePago();
	 });
	 


}




function cargarTasa(x){

	$.post("../ajax/cotizacionDiaria.php?op=ultimaCotizacion", { Moneda_idMoneda: x.value } , function(data, status)
		{

			data = JSON.parse(data);
			$("#tasaCambio").val(data.cotizacionCompra);
			cambiarMoneda2(x.value);
	 });
	 

	 $.post("../ajax/cotizacionDiaria.php?op=ultimaCotizacion", { Moneda_idMoneda: 2 } , function(data, status)
		{
			data = JSON.parse(data);
			$("#tasaCambioBases").val(data.cotizacionCompra);
			cambiarMoneda2(2);
	 });


}



function cargarTasa2(x){

	$.post("../ajax/cotizacionDiaria.php?op=ultimaCotizacion", { Moneda_idMoneda: x.value } , function(data, status)
		{

			data = JSON.parse(data);
			$("#tasaCambio2").val(data.cotizacionCompra);
	 });
	 

	 $.post("../ajax/cotizacionDiaria.php?op=ultimaCotizacion", { Moneda_idMoneda: 2 } , function(data, status)
		{
			data = JSON.parse(data);
			$("#tasaCambioBases2").val(data.cotizacionCompra);
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
	

	    },
	    complete: function(datos){
			$('#cliente').modal('hide');

			limpiarCliente();	

	    }

	});
}


function modalCliente(){
	$('#cliente').modal('show');
	$('#razonSocial').focus();

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
	$("#totalGrande").html("0");
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
	$("#importe_detalle").val(0);
	$("#nroCheque").val(0);
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
		$("#nuevaVenta").hide();
		$("#cancelarVenta").show();
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
		$("#nuevaVenta").show();
		$("#cancelarVenta").hide();
		$("#listadoregistros").show();
		$("#listadoregistrosfacturados").show();

		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}


$(function() {
    $(document).on('keydown', 'body', function(event) {
        if(event.keyCode==112){ //F1
            modalCliente();
         }
     });
 });



$(function() {
    $(document).on('keydown', 'body', function(event) {
        if(event.keyCode==113){ //F1
            guardaryeditar();
         }
     });
 });



//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
	$("#btnTipoPago").hide();
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


function noCambiar(){

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
 	    "order": [[ 1, "asc" ]]//Ordenar (columna,orden)
	}).DataTable();
}



// function listar(habilitacion)
// {
// 	//tabla = '';//$('#tbllistado').DataTable();

// 	tabla=$('#tbllistado').dataTable(
// 	{
// 		"fnRowCallback": function( nRow, aaData, iDisplayIndex, iDisplayIndexFull ) {
// 		  if ( aaData[13] != '<span class="label bg-green">Aceptado</span>' )
// 		  {
// 			$('td', nRow).css('background-color', '#f2dede' );
// 		  }
// 		},
// 		"aProcessing": true,//Activamos el procesamiento del datatables
// 	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
// 	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
// 	    buttons: [		          
// 		            'copyHtml5',
// 		            'excelHtml5',
// 		            'csvHtml5',
// 		            'pdf'
// 		        ],
// 		"ajax":
// 				{
// 					url: '../ajax/ordenVenta.php?op=listarAFacturar',
// 					data:{habilitacion:habilitacion},
// 					type : "get",
// 					dataType : "json",						
// 					error: function(e){

// 						console.log(e.responseText);	
// 					}
// 				},
// 		"scrollY":        "300px",
//         "scrollCollapse": true,
//         "paging":         false,
// 	    "order": [[ 1, "asc" ]]//Ordenar (columna,orden)
// 	}).DataTable();
// }






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
					url: '../ajax/ordenVenta.php?op=listarFacturadosDirecta',
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
 	    "order": [[ 1, "asc" ]]//Ordenar (columna,orden)

	}).DataTable();
}



// function listarFacturados(habilitacion)
// {
// 	tabla2=$('#tbllistadoFacturados').dataTable(
// 	{
// 		"fnRowCallback": function( nRow, aaData, iDisplayIndex, iDisplayIndexFull ) {
// 		  if ( aaData[13] != '<span class="label bg-green">Aceptado</span>' )
// 		  {
// 			$('td', nRow).css('background-color', '#f2dede' );
// 		  }
// 		},
// 		"aProcessing": true,//Activamos el procesamiento del datatables
// 	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
// 	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
// 	    buttons: [		          
// 		        ],
// 		"ajax":
// 				{
// 					url: '../ajax/ordenVenta.php?op=listarFacturados',
// 					data:{habilitacion:habilitacion},
// 					type : "get",
// 					dataType : "json",						
// 					error: function(e){
// 						console.log(e.responseText);	
// 					}
// 				},
// 		"scrollY":        "300px",
//         "scrollCollapse": true,
//         "paging":         false,
// 	    "order": [[ 1, "asc" ]]//Ordenar (columna,orden)
// 	}).DataTable();
// }




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


//Función para guardar o editar

function guardaryeditar()
{
	
	if (cont2 == 0) {
		agregarDetallePago();		
	}
	
	//e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);


	$.ajax({
		url: "../ajax/venta.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,
        beforeSend: function(){
			 $(".loader").fadeIn();      
        },
	    success: function(datos)
	    {                    
			swal({
			  position: 'top-end',
			  type: 'success',
			  title: datos,
			  showConfirmButton: false,
			  timer: 1500
			 })
			 ultimoNumero();	        
	          mostrarform(false);
			limpiar();
	    },
	    complete: function(e){
	    	location.reload();

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

function agregarDetalle(idarticulo,articulo,precioVenta,idImpuesto,impuesto, capital, interes, cantidad)
  {
  	var cantidad=cantidad;
    var descuento=0;
	var precioVentan;
	peticion = 0;

	if (document.getElementsByName("cantidad[]")) {
		cont = document.getElementsByName("cantidad[]");
		cont = cont.length;
		detalles = cont;
	}



    if (idarticulo!="")
    {
	    var calculoImpuesto = ((precioVenta * impuesto) / 100);
	    var totalN = (precioVenta - calculoImpuesto);    	
    	var subtotal=cantidad*precioVenta;
    	var fila='<tr class="filas" id="fila'+cont+'">'+
    	'<td><input type="hidden" name="interes[]" id="interes[]" value="'+interes+'">'+
    	'<input type="hidden" name="capital[]" id="capital[]" value="'+capital+'">'+
    	'<button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button></td>'+
    	'<td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td>'+
    	'<input type="hidden" name="descripcion[]" value="'+articulo+'">'+
    	'<td><input type="number" name="cantidad[]" onblur="modificarSubototales()" id="cantidad[]" value="'+cantidad+'"></td>'+
    	'<td><input type="number" name="precioVenta[]" onblur="modificarSubototales()"  id="precioVenta[]" value="'+precioVenta+'"></td>'+
    	'<td><input type="number" name="descuento[]" onblur="modificarSubototales()"  value="'+descuento+'"></td>'+
    	'<input type="hidden" name="impuesto[]" onblur="modificarSubototales()" value="'+impuesto+'">'+
    	'<input type="hidden" name="TipoImpuesto_idTipoImpuesto[]" value="'+idImpuesto+'">'+

    	'<td><span name="subtotal" id="subtotal'+cont+'">'+subtotal+'</span></td>'+
    	'<td><button type="button" onclick="modificarSubototales()" class="btn btn-info"><i class="fa fa-refresh"></i></button></td>'+
    	'</tr>';
    	cont++;
    	detalles=detalles+1;
    	$('#detalles').append(fila);
    	modificarSubototales();
    }
    else
    {
    	alert("Error al ingresar el detalle, revisar los datos del artículo");
    }
  }



  function modificarSubototales()
  {
  	var cant = document.getElementsByName("cantidad[]");
    var prec = document.getElementsByName("precioVenta[]");
    var desc = document.getElementsByName("descuento[]");
    var desI = document.getElementsByName("impuesto[]");
    var sub = document.getElementsByName("subtotal");
    //var neto = document.getElementsByName("totalN");
    for (var i = 0; i <cant.length; i++) {
    	var inpC=cant[i];
    	var inpP=prec[i];
    	var inpD=desc[i];
    	var inpI=desI[i];
    	var inpS=sub[i];
    	//var inpN=neto[i];

    	var a = inpC.value * inpP.value;
    	var ci = ((a * inpI.value) / 100);
    	//inpN.value=a - ci;
    	//inpS.value=(inpC.value * inpP.value)-inpD.value;
    	inpS.value= (inpC.value * inpP.value) - (inpC.value * inpP.value)*inpD.value/100;


    	document.getElementsByName("subtotal")[i].innerHTML = inpS.value;
    	//document.getElementsByName("totalN")[i].innerHTML = inpN.value;

    }
    calcularTotales();

  }
  function calcularTotales(){
  	var sub = document.getElementsByName("subtotal");
  	//var neto = document.getElementsByName("totalN");
  	var total = 0.0;
  	var t1 = 0.0;
  	var impuestov = 0.0;



  	for (var i = 0; i <sub.length; i++) {
		total += document.getElementsByName("subtotal")[i].value;
		//t1 += document.getElementsByName("totalN")[i].value;
	}

 //  	for (var i = 0; i <neto.length; i++) {
	// }
	//impuestov = total - t1;
	$("#total2").html("Gs. " + total);
	$("#totalGrande").html("Gs. " + formatNumber.new(total)  );
	$("#totalGrandePagos").html("Gs. " + formatNumber.new(total)  );
    $("#total_venta").val(total);
	//$("#total1").html("Gs. " + t1);
    $("#total_ventan").val(t1);
    //$("#totalImpuesto").val(impuestov);
    $("#importe_detalle").val(total);
	$("#nroCheque").val(0);
	$("#idtotalVenta").val(total);

    evaluar();
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

function agregarDetallePago()
{


	var tipopagon= $("#FormaPago_idFormaPago option:selected").val();
  	var tipopagot = $("#FormaPago_idFormaPago option:selected").text();

	var monedan= $("#Moneda_idMoneda2 option:selected").val();
  	var monedat = $("#Moneda_idMoneda2 option:selected").text();

  	var tasacambiodetalle = $("#tasaCambio2").val();
  	var importe_detalle = $("#importe_detalle").val();
  	var nroReferencia = $("#nroCheque").val();


   	var fila2='<tr class="filas" id="fila2'+cont2+'">'+
   	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleDetalle('+cont2+')">X</button></td>'+
   	'<td><input type="hidden" name="tipopago[]" id="tipopago[]" value="'+tipopagon+'">'+tipopagot+'</td>'+
   	'<td><input type="hidden" name="moneda[]" id="moneda[]" value="'+monedan+'">'+monedat+'</td>'+
   	'<td><input type="hidden" name="tasa[]" id="tasa[]" value="'+tasacambiodetalle+'">'+tasacambiodetalle+'</td>'+
   	'<td><input type="number" name="importe_detalle[]" id="importe_detalle[]" value="'+importe_detalle+'" readonly></td>'+
   	'<td><input type="number" name="importe_detalle_edit[]" id="importe_detalle_edit[]" value="'+importe_detalle+'"></td>'+
   	'<td><input type="text" name="nroReferencia[]" id="nroReferencia[]" value="'+nroReferencia+'"></td>'+
   	'<td><span name="subtotalDetalle" id="subtotalDetalle'+cont2+'">'+importe_detalle+'</span></td>'+
   	'<td><button type="button" onclick="modificarSubototalesDetalle()" class="btn btn-info"><i class="fa fa-refresh"></i></button></td>'+
   	'</tr>';



   	cont2++;
   	detalles2=detalles2+1;


   	$('#detalles1').append(fila2);
   	

   	modificarSubototalesDetalle();

  	//$("#FormaPago_idFormaPago").val(1);
    //$('#FormaPago_idFormaPago').selectpicker('refresh');

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
    	$("#t_detalle2").val(total);
    	$("#t_detalle3").val(total);


    	//verificar();


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
