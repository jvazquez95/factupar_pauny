var veces = 0;
var clienteAnterior;
var tabla;
var limite_credito = 0;
var controlar_stock = 0; // 1 si - 0 No
var controlar_limite_credito = 1; // 1 si - 0 No
var stock = 0;
var temp_descuento = 0;
var temp_cantidad = 0;
var maxDescuento = 15;
var termino_anterior = null;
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
	mostrarform(false);
	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	});

	$("#formularioCliente").on("submit",function(e)
	{
		guardaryeditarCliente(e);	
	});


	//Cargamos los items al select cliente
	$.post("../ajax/ordenConsumision.php?op=selectEmpleado", function(r){
	            $("#Empleado_idEmpleado").html(r);
	            $('#Empleado_idEmpleado').selectpicker('refresh');

	});	

	$.post("../ajax/terminoPago.php?op=selectTerminoPago", function(r){
	            $("#TerminoPago_idTerminoPago").html(r);
	            $('#TerminoPago_idTerminoPago').selectpicker('refresh');

	            $("#TerminoPago_idTerminoPagoModal").html(r);
	            $('#TerminoPago_idTerminoPagoModal').selectpicker('refresh');
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

	//habilitacion factura
	$.post("../ajax/venta.php?op=habilitacion2", function(data, status)
		{

			data = JSON.parse(data);		
			$('#Habilitacion_idHabilitacion').val(data.idhabilitacion);
			$('#Habilitacion_idHabilitacion1').val(data.idhabilitacion);
			$('#Deposito_idDeposito').val(data.dp);
			serie = data.serie;
			fra = data.a;
			$("#serie").val(serie); 
        	$("#serie1").val(serie); 
        	$("#nroFactura").val(fra); 
			$("#fecha").val(data.fecha);
			$("#fecha1").val(data.fecha);
			$("#Deposito_idDeposito").val(data.dp);
			$("#Deposito_idDeposito1").val(data.deposito);
			$("#sucursal").val(data.sucursal);
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
			//alert('No cuenta con una habilitacion activa.');	
			//location.href ="habilitacion.php";
			listar($('#Habilitacion_idHabilitacion').val());		
		}
		else
		{
			listar($('#Habilitacion_idHabilitacion').val());
/*

			if( hoy != data.fecha)
			{
				if(usuario_ins == 1){
					listar($('#Habilitacion_idHabilitacion').val());				
				}else{

					alert('Su habilitacion no coincide con la fecha 1.');	
					location.href ="habilitacion.php";				
				}				
			}else{
				listar($('#Habilitacion_idHabilitacion').val());
			}
*/
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
	 });



}


function filtroLimiteTerminoPago(x){

	var idPersona = x.value;

	//aqui consultaremos el limite de credito del cliente.
	$.post("../ajax/persona.php?op=limiteCredito", { idPersona: idPersona } , function(data, status)
	{
		data = JSON.parse(data);
		limite_credito = data.lineaAprobada;
		$("#lineaDisponible").val(limite_credito);
	});
	
	
	
	



	//Cargamos los items al select cliente
	$.post("../ajax/terminoPago.php?op=selectTerminoPagoPersona", { idPersona: idPersona } , function(r){
	            $("#TerminoPago_idTerminoPago").html(r);
	            $('#TerminoPago_idTerminoPago').selectpicker('refresh');

	            $("#TerminoPago_idTerminoPagoModal").html(r);
	            $('#TerminoPago_idTerminoPagoModal').selectpicker('refresh');

	});	
}


function mostrarCampos(){
		
	 if ($("#giftCard").val() == 0 ) {
		$('#mostrarCampo').hide();
	 }else{
		$('#mostrarCampo').show();
	 }
}

function cambiarTerminoPrincipal(x){

	termino_anterior = $('#TerminoPago_idTerminoPago').val();


    $('#TerminoPago_idTerminoPago').val(x.value);
    $('#TerminoPago_idTerminoPago').selectpicker('refresh');

    actualizarPrecio(x.value);
	$('#btnNada').click();


}


function cambiarTerminoSegundario(x){
	

	termino_anterior = $('#TerminoPago_idTerminoPagoModal').val();

    $('#TerminoPago_idTerminoPagoModal').val(x.value);
    $('#TerminoPago_idTerminoPagoModal').selectpicker('refresh');

    actualizarPrecio(x.value);
	
}


function actualizarPrecio(terminoPago){
    var l_persona = $('#Persona_idPersona').val();

  	var cant = document.getElementsByName("cantidad[]");
    var prec = document.getElementsByName("precioVenta[]");
    var desc = document.getElementsByName("descuento[]");
	var art = document.getElementsByName("idarticulo[]");
    


    for (var i = 0; i < cant.length; i++) {
    	// alert( 'Precio: ' + prec[i].value );
    	// alert( 'Descuento: ' + desc[i].value );
    	// alert( 'Cantidad: ' + cant[i].value );
    	// alert( 'Cantidad: ' + art[i].value );
		
		var precio = prec[i];
		var idarticulo_l = art[i].value;
		var cantidad_l = cant[i].value;
		$.post("../ajax/venta.php?op=listarproductosCodigo", { idArticulo: art[i].value, Persona_idPersona: l_persona, terminoPago: terminoPago } , function(data, status)
			{

			data = JSON.parse(data);


			if (controlar_stock == 1) {
				if ( cantidadAdd(idarticulo_l, 1) > stock ) {
					alert('Cantidad supera stock!');

				    $('#TerminoPago_idTerminoPagoModal').val(termino_anterior);
				    $('#TerminoPago_idTerminoPagoModal').selectpicker('refresh');

				    $('#TerminoPago_idTerminoPago').val(termino_anterior);
				    $('#TerminoPago_idTerminoPago').selectpicker('refresh');

					actualizarPrecio(termino_anterior);
					return;
				}
			}

			stock_controlado = 1;

			//alert( limiteAdd( precioVenta ));

			if (controlar_limite_credito == 1) {
				var terminoPago = $("#TerminoPago_idTerminoPago").val();
				if (terminoPago != 1) {
					if (limiteAdd( data[67] * cantidad_l, 0 ) > limite_credito) {
						alert('Supera Limite de Credito!');
						
						$('#TerminoPago_idTerminoPagoModal').val(termino_anterior);
						$('#TerminoPago_idTerminoPagoModal').selectpicker('refresh');

						$('#TerminoPago_idTerminoPago').val(termino_anterior);
						$('#TerminoPago_idTerminoPago').selectpicker('refresh');

						actualizarPrecio(termino_anterior);
						return;
					}
				}
			}
			limite_controlado = 1;


			precio.value = data[67];


		 });
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
			            $("#Persona_idPersona").html(r);
			            $('#Persona_idPersona').selectpicker('refresh');

						$("#Persona_idPersona").val(data.Persona_idPersona);
						$("#Persona_idPersona").selectpicker('refresh');
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
}

function modalCliente(){
	$('#cliente').modal('show');
}

//Función limpiar
function limpiar()
{
	$("#tipo_comprobante").val("");
	$("#Moneda_idMoneda").val("");
	$("#fechaTransaccion").val("");
	$("#tasaCambio").val("");
	$("#tasaCambioBases").val("");
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
	$("#formaEntrega").val("");
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
		$("#formularioregistros").show();
		$("#btnagregar").hide();
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
					url: '../ajax/ordenVenta.php?op=listar',
					data:{habilitacion:habilitacion},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 50000,//Paginación
	    "order": [[ 1, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}

//Función ListarArticulos
function listarArticulos()
{
/*
if (veces > 0 && cont > 0 ) {
	
swal({
	  title: 'Esta seguro de cambiar el cliente?',
	  text: "Una vez cambiado los items agregados se eliminaran!",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Si, generar!'
	}).then((result) => {
	  if (result.value) {




	$(".filas").remove();

    var Persona_idPersona = $("#Persona_idPersona").val();
    var terminoPago = $("#TerminoPago_idTerminoPago").val();
    var buscar_art = $("#buscar_art").val();


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
	    "order": [[ 0, "desc" ]],//Ordenar (columna,orden)
		"columnDefs": [
            {
                "targets": [ 2 ],
                "visible": false,
                "searchable": true,
				"width": "20%",
            }]
	}).DataTable();


	  }else{

	  	$("#Persona_idPersona").val(clienteAnterior);
		$("#Persona_idPersona").selectpicker('refresh');
	  	

	  }
	})


	
}else{*/
	veces++;
    var Persona_idPersona = $("#Persona_idPersona").val();
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




//}



}
//Función para guardar o editar

function guardaryeditar(e)
{
	
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);
	$.ajax({
		url: "../ajax/ordenVenta.php?op=guardaryeditar",
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
	          listar($('#Habilitacion_idHabilitacion').val());
			  limpiar();
	    },
	    complete: function(e){
	    	cont2 = 0;
	    	modificarSubototales();
	    	modificarSubototalesDetalle();
			listar($('#Habilitacion_idHabilitacion').val());
			limpiar();
	    	mostrarform(true);
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




function cantidadAdd( idArticulo, g_cantidad ){
	var cantidad = g_cantidad;
  	var cant = document.getElementsByName("cantidad[]");
  	var art = document.getElementsByName("idarticulo[]");

  	for (var i = 0; i < art.length; i++) {
    	var lart=art[i];


    	var lcant = cant[i];
  		lcant = lcant.value;
  		if (lart == idArticulo) {
	  		cantidad = cantidad + lcant;
  		}
  	}

  	return parseFloat(cantidad);

}




function limiteAdd( v_precioVenta, sumaAlFinal ){


	if (parseFloat(v_precioVenta)  > parseFloat(limite_credito)) {
		return v_precioVenta;
	}else{


  	var cant = document.getElementsByName("cantidad[]");
  	var art = document.getElementsByName("idarticulo[]");
  	var precioVenta = document.getElementsByName("precioVenta[]");
  	var descuento = document.getElementsByName("descuento[]");
  	var tventa = 0;

  	for (var i = 0; i < art.length; i++) {


    	var lcant = cant[i];
  		cantidad = parseFloat(lcant.value);


    	var lprecioVenta = precioVenta[i];
  		vprecioVenta = parseFloat(lprecioVenta.value);


    	var ldescuento = descuento[i];
  		vdescuento = parseFloat(ldescuento.value);



  		var neto = (parseFloat(cantidad) * vprecioVenta) - ( ((cantidad * vprecioVenta) * vdescuento) / 100 )


	  	tventa = tventa + neto;

  	}
  	if (sumaAlFinal == 1) {
	  	return parseFloat(tventa) + parseFloat(v_precioVenta);
  	}else{
  		return parseFloat(tventa);
  	}
  }

}


function asignarCantidadTemporal( cantidad ){
	
	temp_cantidad = cantidad;
}


function asignarDescuentoTemporal( descuento ){
	temp_descuento = descuento;
}

stock_controlado = 0;
limite_controlado = 0;

function agregarDetalle(idarticulo,articulo,precioVenta,impuesto, capital, interes, v_stock, descuento)
  {
  	var cantidad=1;
    var descuento=descuento;
	var precioVentan;

	stock = parseFloat(v_stock);

	if (controlar_stock == 1) {
		if ( cantidadAdd(idarticulo, 1) > stock ) {
			alert('Cantidad supera stock!');
			return;
		}
	}
	stock_controlado = 1;

	//alert( limiteAdd( precioVenta ));

	 if (controlar_limite_credito == 1) {
		var terminoPago = $("#TerminoPago_idTerminoPago").val();
		if (terminoPago != 1) {
			if (limiteAdd( precioVenta * cantidad, 1 ) > limite_credito) {
				alert('Al agregar este articulo excede el limie de credito!');
				return;
			}
		} 
	 }
	limite_controlado = 1;


    if (idarticulo!="")
    {
	    var calculoImpuesto = ((precioVenta * impuesto) / 100);
	    var totalN = (precioVenta - calculoImpuesto);    	
    	var subtotal=cantidad*precioVenta;
    	var fila='<tr class="filas" id="fila'+cont+'">'+
    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button></td>'+
    	'<td><input type="hidden"  name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td>'+
    	'<td><input type="number" name="cantidad[]" onclick="asignarCantidadTemporal('+cantidad+')" onblur="controlar(this, '+ cantidad +', '+ idarticulo +', '+ precioVenta +', '+ cont +')" id="cantidad[]" value="'+cantidad+'">'+stock+'</td>'+
    	'<td><input type="hidden" name="stock[]" id="stock[]" value="'+stock+'"><input type="hidden" name="precioVenta[]" onblur="modificarSubototales()"  id="precioVenta[]" value="'+precioVenta+'">'+precioVenta+'</td>'+
    	'<td><input type="number" name="descuento[]" id="descuento[]" onclick="asignarDescuentoTemporal('+descuento+')" onblur="modificarSubototales()"  value="'+descuento+'"></td>'+
    	'<input type="hidden" name="interes[]" id="interes[]" onblur="modificarSubototales()" value="'+interes+'">'+
    	'<input type="hidden" name="capital[]" id="capital[]" onblur="modificarSubototales()" value="'+capital+'">'+
    	'<td><input type="hidden" name="impuesto[]" onblur="modificarSubototales()" value="'+impuesto+'">'+impuesto+' %</td>'+
    	'<td><span name="totalN" id="totalN'+cont+'">'+totalN+'</span></td>'+
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

function controlar(x, cantidad, idarticulo, precioVenta, posicion){
  	var cant = document.getElementsByName("cantidad[]");
  	var stk = document.getElementsByName("stock[]");
    var inpC=cant[posicion];
    var v_stk=stk[posicion];

	if (controlar_stock == 1) {

		//alert('Stock total' + parseFloat(v_stk.value)  );
		//alert('Stock input' + inpC.value) ;

		console.log( 'Stock total' + parseFloat(v_stk.value) );
		console.log( 'Stock input' + inpC.value );

		if (  parseFloat(inpC.value) > parseFloat(v_stk.value) ) {
			  var x = document.getElementById("stock-supera");
			  x.className = "show";
			  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
			inpC.style.color = "#ff0000";
			inpC.focus();
	 		return;
	 	}else{
			inpC.style.color = "black";
	 	}
	}


    if (controlar_limite_credito == 1) {
		console.log( 'limite de credito es: ' + limite_credito );
		var terminoPago = $("#TerminoPago_idTerminoPago").val();
		if (terminoPago != 1) {

			if (limiteAdd( precioVenta * cantidad, 0 ) > limite_credito) {
				var x = document.getElementById("limite-supera");
				  x.className = "show";
				  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
				inpC.style.color = "#ff0000";
				inpC.focus();
				return;
			}else{
				inpC.style.color = "black";
			}
		}	
	}

	modificarSubototales();

}


  function modificarSubototales()
  {
  	var art = document.getElementsByName("idarticulo[]");
  	var cant = document.getElementsByName("cantidad[]");
    var prec = document.getElementsByName("precioVenta[]");
    var desc = document.getElementsByName("descuento[]");
    var desI = document.getElementsByName("impuesto[]");
    var sub = document.getElementsByName("subtotal");
    var neto = document.getElementsByName("totalN");
    for (var i = 0; i <cant.length; i++) {
    	var inpart=art[i];
    	var inpC=cant[i];
    	var inpP=prec[i];
    	var inpD=desc[i];
    	var inpI=desI[i];
    	var inpS=sub[i];
    	var inpN=neto[i];


   //  	if (inpD.value > maxDescuento) {
   //  		alert('El descuento supera los: ' + maxDescuento + ' %');
			// inpD.value = 0;
			// modificarSubototales();
			// return;
   //  	}

		// if (controlar_stock == 1 && stock_controlado == 0) {
		// 	if ( cantidadAdd( inpart.value, inpC.value) > stock ) {
		// 		alert('Cantidad supera stock!');
		//  		alert('Cantidad temporal: ' + temp_cantidad);
		// 		inpC.value = temp_cantidad;
		// 		return;
		// 	}
		// }


		//  if (controlar_limite_credito == 1 && limite_controlado == 0) {
		//  	if (limiteAdd( inpP.value * inpC.value ) > limite_credito) {
		//  		//inpC.value = temp_cantidad;
		//  		//alert('Cantidad temporal: ' + temp_cantidad);
		//  		alert('Al agregar este articulo excede el limie de credito!');
		//  		return;
		//  	}
		//  }

		stock_controlado = 0;
	    limite_controlado = 0;

    	var a = inpC.value * inpP.value;
    	var ci = ((a * inpI.value) / 100);
    	inpN.value=a - ci;
    	inpS.value= (inpC.value * inpP.value) - (inpC.value * inpP.value)*inpD.value/100;

    	document.getElementsByName("subtotal")[i].innerHTML = inpS.value;
    	document.getElementsByName("totalN")[i].innerHTML = inpN.value;

    }
    calcularTotales();

  }
  function calcularTotales(){
  	var sub = document.getElementsByName("subtotal");
  	var neto = document.getElementsByName("totalN");
  	var total = 0.0;
  	var t1 = 0.0;
  	var impuestov = 0.0;



  	for (var i = 0; i <sub.length; i++) {
		total += document.getElementsByName("subtotal")[i].value;
		t1 += document.getElementsByName("totalN")[i].value;
	}

  	for (var i = 0; i <neto.length; i++) {
	}
	impuestov = total - t1;
	$("#total2").html("Gs. " + total);
    $("#total_venta").val(total);
	$("#total1").html("Gs. " + t1);
    $("#total_ventan").val(t1);
    $("#totalImpuesto").val(impuestov);
    $("#importe_detalle").val(total);
	$("#nroCheque").val(0);
	$("#idtotalVenta").val(total);

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
  	$("#fila" + indice).remove();
  	calcularTotales();
  	detalles=detalles-1;
  	evaluar()
  }

function agregarDetallePago()
{
	var tipopago= $("#TerminoPago_idTerminoPagoDetalle option:selected").val();
  	var tipopagot = $("#TerminoPago_idTerminoPagoDetalle option:selected").text();
  	var importe_detalle = $("#importe_detalle").val();
  	var nroReferencia = $("#nroCheque").val();

   	var fila='<tr class="filas" id="fila'+cont2+'">'+
   	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont2+')">X</button></td>'+
   	'<td><input type="hidden" name="tipopago[]" value="'+tipopago+'">'+tipopagot+'</td>'+
   	'<td><input type="number" name="importe_detalle[]" id="importe_detalle[]" value="'+importe_detalle+'"></td>'+
   	'<td><input type="text" name="nroReferencia[]" id="nroReferencia[]" value="'+nroReferencia+'"></td>'+
   	'<td><span name="subtotalDetalle" id="subtotalDetalle'+cont2+'">'+importe_detalle+'</span></td>'+
   	'<td><button type="button" onclick="modificarSubototalesDetalle()" class="btn btn-info"><i class="fa fa-refresh"></i></button></td>'+
   	'</tr>';
   	cont2++;
   	detalles2=detalles2+1;
   	$('#detalles1').append(fila);
   	modificarSubototalesDetalle();

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
  	$("#fila" + indice).remove();
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