var veces = 0;
var clienteAnterior;
var idOrdenCompra = 0;
var idHacerPedido = 0;
var tabla;
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

	//id="cantidadRecibida'.$reg->idDetalleOrdenCompra.'"
	function onKeyUpcantidadRecibida( evento, idDetalleOrdenCompra ){
		var keycode = evento.keyCode;
	    if(keycode == '13' || keycode == '40'){
	    	idDetalleOrdenCompra = parseInt(idDetalleOrdenCompra) +1;
			$('#cantidadRecibida'+idDetalleOrdenCompra).focus();		
		}
		
	    if(keycode == '38'){
	    	idDetalleOrdenCompra = parseInt(idDetalleOrdenCompra) - 1;
			$('#cantidadRecibida'+idDetalleOrdenCompra).focus();		
		}

	}


	function onKeyUpFaltante( evento, idDetalleOrdenCompra ){
		var keycode = evento.keyCode;
	    if(kkeycode == '13' || keycode == '40'){
	    	idDetalleOrdenCompra = parseInt(idDetalleOrdenCompra) +1;
			$('#faltante'+idDetalleOrdenCompra).focus();		
		}
	

	    if(keycode == '38'){
	    	idDetalleOrdenCompra = parseInt(idDetalleOrdenCompra) - 1;
			$('#faltante'+idDetalleOrdenCompra).focus();		
		}

	}


	function onKeyUpDevuelta( evento, idDetalleOrdenCompra ){
		var keycode = evento.keyCode;
	    if(keycode == '13' || keycode == '40'){
	    	idDetalleOrdenCompra = parseInt(idDetalleOrdenCompra) +1;
			$('#devuelta'+idDetalleOrdenCompra).focus();		
		}
	

	    if(keycode == '38'){
	    	idDetalleOrdenCompra = parseInt(idDetalleOrdenCompra) - 1;
			$('#devuelta'+idDetalleOrdenCompra).focus();		
		}


	}

	function onKeyUpComentario( evento, idDetalleOrdenCompra ){
		var keycode = evento.keyCode;
	    if(keycode == '13' || keycode == '40'){
	    	idDetalleOrdenCompra = parseInt(idDetalleOrdenCompra) +1;
			$('#comentario'+idDetalleOrdenCompra).focus();		
		}
	
	    if(keycode == '38'){
	    	idDetalleOrdenCompra = parseInt(idDetalleOrdenCompra) - 1;
			$('#comentario'+idDetalleOrdenCompra).focus();		
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

	$("#cabecera").show();
	$("#detalle").hide();

	//Cargamos los items al select cliente
	$.post("../ajax/moneda.php?op=selectMoneda", function(r){
	            $("#Moneda_idMoneda").html(r);
	            $('#Moneda_idMoneda').selectpicker('refresh');

	});	


		$.post("../ajax/cotizacionDiaria.php?op=ultimaCotizacion", { Moneda_idMoneda: 1} , function(data, status)
			{
				data = JSON.parse(data);


				$("#tasaCambio").val(data.cotizacionVenta);
		 });
		 
		$.post("../ajax/cotizacionDiaria.php?op=ultimaCotizacion", { Moneda_idMoneda: 2} , function(data, status)
			{
				data = JSON.parse(data);


				$("#tasaCambioBases").val(data.cotizacionVenta);
		 });



	$.post("../ajax/persona.php?op=selectCliente", function(r){
	            $("#Persona_idPersona").html(r);
	            $('#Persona_idPersona').selectpicker('refresh');
	});

	
			
		//if ($('#Habilitacion_idHabilitacion').val() == '') {
		//	alert('No cuenta con una habilitacion activa.');	
		//	location.href ="habilitacion.php";
		//}
		//else
		//{
		//	if( hoy != $("#fechaFactura").val())
		//	{
		//		if(usuario_ins == 1){
		//			listar($('#Habilitacion_idHabilitacion').val());				
		//		}else{
		//			alert('Su habilitacion no coincide con la fecha.');	
		//			location.href ="habilitacion.php";				
		//		}				
		//	}else{
				listar(0);
				listarRecibidos(0);
				listarTerminados(0);
		//	}
		//}
			


}


function addProductoDetalle(){
	$('#modalHacerPedidoDetalleArticulo').modal('show');
}



//Función para desactivar registros
function generarPedidoArticulo()
{

	var Articulo_idArticulo = $('#buscar_articulo').val();
	var l_idOrdenCompra = idOrdenCompra;

	alert(l_idOrdenCompra);
    $.ajax({
        url: "../ajax/hacerPedido.php?op=generarPedidoArticuloD2",
        type: "GET",
        data: { idOrdenCompra:l_idOrdenCompra, Articulo_idArticulo:Articulo_idArticulo },
		dataType : "json",
		beforeSend: function() {
			$("#btnGenerarArticulo").prop("disabled",true);
			$('#espereArticulo').show();
			$('#espereArticulo').html("<img height='auto' width='300' src='../files/gif/tenor.gif' />");
    	},			
        complete: function(datos){
			$('#modalHacerPedidoDetalleArticulo').modal('hide');
			$('#espereArticulo').hide();
            //filtrarGenerado();
			$("#btnGenerarArticulo").prop("disabled",false);

			swal({
			  position: 'top-end',
			  type: 'success',
			  title: 'Generacion Exitosa!.',
			  showConfirmButton: false,
			  timer: 1500
			 })		
			
        }
    });
} 




//Recibido
function actualizarCantidadRecibidaRecibido(x,idDetalleOrdenCompra){


	cantidadRecibida = x.value;

	$.ajax({
    	type: "get",
    	url: '../ajax/recepcionMercaderias.php?op=actualizarCantidadRecibidaRecibido',
    	data: {cantidadRecibida:cantidadRecibida, idDetalleOrdenCompra:idDetalleOrdenCompra},
		dataType:"json",
	})

}



function actualizarFaltanteRecibido(x,idDetalleOrdenCompra){


	faltante = x.value;

	$.ajax({
    	type: "get",
    	url: '../ajax/recepcionMercaderias.php?op=actualizarFaltanteRecibido',
    	data: {faltante:faltante, idDetalleOrdenCompra:idDetalleOrdenCompra},
		dataType:"json",
	})

}


function actualizarDevueltaRecibido(x,idDetalleOrdenCompra){


	devuelta = x.value;

	$.ajax({
    	type: "get",
    	url: '../ajax/recepcionMercaderias.php?op=actualizarDevueltaRecibido',
    	data: {devuelta:devuelta, idDetalleOrdenCompra:idDetalleOrdenCompra},
		dataType:"json",
	})

}


function actualizarComentarioRecibido(x,idDetalleOrdenCompra){


	comentario = x.value;

	$.ajax({
    	type: "get",
    	url: '../ajax/recepcionMercaderias.php?op=actualizarComentarioRecibido',
    	data: {comentario:comentario, idDetalleOrdenCompra:idDetalleOrdenCompra},
		dataType:"json",
	})

}




function autorizarCierre(x){

	$.ajax({
    	type: "get",
    	url: '../ajax/recepcionMercaderias.php?op=autorizarCierre',
    	data: {id:x},
		dataType:"json",
	})


	listar();

}





//Original
function cargarTasa(x){

	$.post("../ajax/cotizacionDiaria.php?op=ultimaCotizacion", { Moneda_idMoneda: x.value } , function(data, status)
		{
			data = JSON.parse(data);
			$("#tasaCambio").val(data.cotizacionVenta);
	 });
	 
	 $.post("../ajax/cotizacionDiaria.php?op=ultimaCotizacion", { Moneda_idMoneda: 2 } , function(data, status)
		{
			data = JSON.parse(data);
			$("#tasaCambioBases").val(data.cotizacionVenta);
	 });


}



function actualizarCantidadRecibida(x,idDetalleOrdenCompra, cantidadPendiente){
	var id = x.id;

	if (parseFloat(x.value) > parseFloat(cantidadPendiente)) {
		$('#'+id).css({'display': 'inline-block','background-color': '#ff0000', 'color': '#ffffff'});
	}else{
		$('#'+id).css({'display': 'inline-block','background-color': 'white', 'color': 'black'});		
	}




	cantidadRecibida = x.value;

	$.ajax({
    	type: "get",
    	url: '../ajax/recepcionMercaderias.php?op=actualizarCantidadRecibida',
    	data: {cantidadRecibida:cantidadRecibida, idDetalleOrdenCompra:idDetalleOrdenCompra},
		dataType:"json",
	})

}



function actualizarFaltante(x,idDetalleOrdenCompra){


	faltante = x.value;

	$.ajax({
    	type: "get",
    	url: '../ajax/recepcionMercaderias.php?op=actualizarFaltante',
    	data: {faltante:faltante, idDetalleOrdenCompra:idDetalleOrdenCompra},
		dataType:"json",
	})

}


function actualizarDevuelta(x,idDetalleOrdenCompra){


	devuelta = x.value;

	$.ajax({
    	type: "get",
    	url: '../ajax/recepcionMercaderias.php?op=actualizarDevuelta',
    	data: {devuelta:devuelta, idDetalleOrdenCompra:idDetalleOrdenCompra},
		dataType:"json",
	})

}


function actualizarComentario(x,idDetalleOrdenCompra){


	comentario = x.value;

	$.ajax({
    	type: "get",
    	url: '../ajax/recepcionMercaderias.php?op=actualizarComentario',
    	data: {comentario:comentario, idDetalleOrdenCompra:idDetalleOrdenCompra},
		dataType:"json",
	})

}







function confirmarRecepcionRecibido(){

	var l_idOrdenCompra = idOrdenCompra;
	var nroFacturaCompra = $('#nroFacturaCompra').val();
	var Moneda_idMoneda = $('#Moneda_idMoneda').val();
	var tasaCambio = $('#tasaCambio').val();
	var tasaCambioBases = $('#tasaCambioBases').val();

	if (nroFacturaCompra == '') {
		alert('Ingrese numero de factura de compra para finalizar');
		$('#nroFacturaCompra').focus();		
		return;
	}


	$.ajax({
    	type: "get",
    	url: '../ajax/recepcionMercaderias.php?op=confirmarRecepcionRecibido',
    	data: {idOrdenCompra:l_idOrdenCompra, nroFacturaCompra:nroFacturaCompra,Moneda_idMoneda:Moneda_idMoneda , tasaCambio: tasaCambio, tasaCambioBases:tasaCambioBases},
		dataType:"json",
	    success: function(datos)
	    {                    
			swal({
			  position: 'top-end',
			  type: 'success',
			  title: 'Recepcion de mercaderias confirmada.',
			  showConfirmButton: false,
			  timer: 1500
			 })		          
	    },
	    complete: function(datos){
	    				swal({
			  position: 'top-end',
			  type: 'success',
			  title: 'Recepcion de mercaderias confirmada.',
			  showConfirmButton: false,
			  timer: 1500
			 })

	    	listar(0);
			listarRecibidos(0);		

		}
});
	

	$("#cabecera").show();
	$("#detalle").hide();

}









function confirmarRecepcion(){

	var l_idOrdenCompra = idOrdenCompra;
	var nroFacturaCompra = $('#nroFacturaCompra').val();
	var Moneda_idMoneda = $('#Moneda_idMoneda').val();
	var tasaCambio = $('#tasaCambio').val();
	var tasaCambioBases = $('#tasaCambioBases').val();

	if (nroFacturaCompra == '') {
		alert('Ingrese numero de factura de compra para finalizar');
		$('#nroFacturaCompra').focus();		
		return;
	}



	$.ajax({
    	type: "get",
    	url: '../ajax/recepcionMercaderias.php?op=confirmarRecepcion',
    	data: {idOrdenCompra:l_idOrdenCompra, nroFacturaCompra:nroFacturaCompra,Moneda_idMoneda:Moneda_idMoneda , tasaCambio: tasaCambio, tasaCambioBases:tasaCambioBases},
		dataType:"json",
	    success: function(datos)
	    {                    
			swal({
			  position: 'top-end',
			  type: 'success',
			  title: 'Recepcion de mercaderias confirmada.',
			  showConfirmButton: false,
			  timer: 1500
			 })		          
	    },
	    complete: function(datos){
	    				swal({
			  position: 'top-end',
			  type: 'success',
			  title: 'Recepcion de mercaderias confirmada.',
			  showConfirmButton: false,
			  timer: 1500
			 })

	    	listar(0);
			listarRecibidos(0);		

		}
});
	

	$("#cabecera").show();
	$("#detalle").hide();

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
function mostrarMenu(){
	$("#cabecera").show();
	$("#detalle").hide();

}

//Función Listar
function mostrarDetalleOrdenCompra(OrdenCompra_idOrdenCompra, HacerPedido_idHacerPedido)
{



	idOrdenCompra = OrdenCompra_idOrdenCompra;
	idHacerPedido = HacerPedido_idHacerPedido;

	$("#cabecera").hide();
	$("#detalle").show();
	$("#guardarRecepcion").show();
	$("#actualizarRecepcion").hide();

	var OrdenCompra_idOrdenCompra = OrdenCompra_idOrdenCompra;
	tabla=$('#tbllistadoDetalle').dataTable(
	{
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
					url: '../ajax/recepcionMercaderias.php?op=mostrarDetalle',
					type : "get",
					data : { OrdenCompra_idOrdenCompra:OrdenCompra_idOrdenCompra },
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"columnDefs": [ 
		{
			"targets": [ 0,1,4,7,8,9,10,11],
			"visible": true	,  
			"searchable": true,
			"className": 'text-right' 

		}],				
		"bDestroy":true,
        "scrollY":        "380px",
        "scrollCollapse": true,
        "paging":         false,
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();

    /*$('#tbllistadoDetalle tbody').on('click', 'tr', function () {
        var data = tabla.row( this ).data();
        var l_idProveedor = data[3];
        var l_sucursal = data[4];
        verDetalleProveedor(l_idProveedor, l_sucursal);
    } );*/


}




//Función Listar
function mostrarDetalleOrdenCompraRecibido(OrdenCompra_idOrdenCompra)
{


	idOrdenCompra = OrdenCompra_idOrdenCompra;

	$("#cabecera").hide();
	$("#detalle").show();
	$("#guardarRecepcion").hide();
	$("#actualizarRecepcion").show();

	var OrdenCompra_idOrdenCompra = OrdenCompra_idOrdenCompra;
	tabla=$('#tbllistadoDetalle').dataTable(
	{
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
					url: '../ajax/recepcionMercaderias.php?op=mostrarDetalleRecibido',
					type : "get",
					data : { OrdenCompra_idOrdenCompra:OrdenCompra_idOrdenCompra },
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"columnDefs": [ 
		{
			"targets": [ 0,1,4,7],
			"visible": true	,  
			"searchable": true,
			"className": 'text-right' 

		}],						
		"bDestroy":true,
        "scrollY":        "380px",
        "scrollCollapse": true,
        "paging":         false,
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();

    /*$('#tbllistadoDetalle tbody').on('click', 'tr', function () {
        var data = tabla.row( this ).data();
        var l_idProveedor = data[3];
        var l_sucursal = data[4];
        verDetalleProveedor(l_idProveedor, l_sucursal);
    } );*/


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
		url: "../ajax/cliente.php?op=guardar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          bootbox.alert(datos);	          
	    },
	    complete: function(datos){
			$('#cliente').modal('hide');
			$.post("../ajax/venta.php?op=selectCliente", function(r){
			            $("#Cliente_idCliente").html(r);
			            $('#Cliente_idCliente').selectpicker('refresh');
			});
			limpiarCliente();	
			$("#Cliente_idCliente").val(datos);
			$("#Cliente_idCliente").selectpicker('refresh');	

			$.post("../ajax/venta.php?op=selectCliente", function(r){
	        $("#clienteGiftCard").html(r);
	        $('#clienteGiftCard').selectpicker('refresh');
	});		
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
		  if ( aaData[13] != '<span class="label bg-green">Aceptado</span>' )
		  {
			$('td', nRow).css('background-color', '#f2dede' );
		  }

		  if ( aaData[14] == 'NO' )
		  {
			$('td', nRow).css('background-color', 'yellow' );
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
					url: '../ajax/recepcionMercaderias.php?op=listar',
					data:{habilitacion:habilitacion},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 50000,//Paginación
	    "order": [[ 1, "asc" ]]//Ordenar (columna,orden)
	}).DataTable();
}




function listarTerminados(habilitacion)
{
	tabla=$('#tbllistadoTerminados').dataTable(
	{
		"fnRowCallback": function( nRow, aaData, iDisplayIndex, iDisplayIndexFull ) {
		  if ( aaData[13] != '<span class="label bg-green">Aceptado</span>' )
		  {
			$('td', nRow).css('background-color', '#f2dede' );
		  }

		  if ( aaData[14] == 'NO' )
		  {
			$('td', nRow).css('background-color', 'yellow' );
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
					url: '../ajax/recepcionMercaderias.php?op=listarTerminados',
					data:{habilitacion:habilitacion},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 50000,//Paginación
	    "order": [[ 1, "asc" ]]//Ordenar (columna,orden)
	}).DataTable();
}



//Función Listar
function listarCierre(habilitacion)
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
					url: '../ajax/recepcionMercaderias.php?op=listarCierre',
					data:{habilitacion:habilitacion},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 50000,//Paginación
	    "order": [[ 1, "asc" ]]//Ordenar (columna,orden)
	}).DataTable();
}


//Función Listar
function listarRecibidos(habilitacion)
{
	tabla=$('#tbllistadoRecibidos').dataTable(
	{
		"fnRowCallback": function( nRow, aaData, iDisplayIndex, iDisplayIndexFull ) {
		  if ( aaData[14] != '<span class="label bg-green">Aceptado</span>' )
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
					url: '../ajax/recepcionMercaderias.php?op=listarRecibidos',
					data:{habilitacion:habilitacion},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 50000,//Paginación
	    "order": [[ 1, "asc" ]]//Ordenar (columna,orden)
	}).DataTable();
}



//Función ListarArticulos
function listarArticulos()
{

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
					data : { Persona_idPersona : Persona_idPersona },
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


	  }else{

	  	$("#Persona_idPersona").val(clienteAnterior);
		$("#Persona_idPersona").selectpicker('refresh');
	  	

	  }
	})


	
}else{
	veces++;
    var Persona_idPersona = $("#Persona_idPersona").val();
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
					data : { Persona_idPersona : Persona_idPersona },
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
	    },
	    complete: function(e){
	    	cont2 = 0;
	    	modificarSubototales();
	    	modificarSubototalesDetalle();
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

function agregarDetalle(idarticulo,articulo,precioVenta,impuesto)
  {
  	var cantidad=1;
    var descuento=0;
	var precioVentan;


    if (idarticulo!="")
    {
	    var calculoImpuesto = ((precioVenta * impuesto) / 100);
	    var totalN = (precioVenta - calculoImpuesto);    	
    	var subtotal=cantidad*precioVenta;
    	var fila='<tr class="filas" id="fila'+cont+'">'+
    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button></td>'+
    	'<td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td>'+
    	'<td><input type="number" name="cantidad[]" onblur="modificarSubototales()" id="cantidad[]" value="'+cantidad+'"></td>'+
    	'<td><input type="text" name="precioVenta[]" onblur="modificarSubototales()"  id="precioVenta[]" value="'+precioVenta+'"></td>'+
    	'<td><input type="number" name="descuento[]" onblur="modificarSubototales()"  value="'+descuento+'"></td>'+
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



  function modificarSubototales()
  {
  	var cant = document.getElementsByName("cantidad[]");
    var prec = document.getElementsByName("precioVenta[]");
    var desc = document.getElementsByName("descuento[]");
    var desI = document.getElementsByName("impuesto[]");
    var sub = document.getElementsByName("subtotal");
    var neto = document.getElementsByName("totalN");
    for (var i = 0; i <cant.length; i++) {
    	var inpC=cant[i];
    	var inpP=prec[i];
    	var inpD=desc[i];
    	var inpI=desI[i];
    	var inpS=sub[i];
    	var inpN=neto[i];

    	var a = inpC.value * inpP.value;
    	var ci = ((a * inpI.value) / 100);
    	inpN.value=a - ci;
    	inpS.value=(inpC.value * inpP.value)-inpD.value;
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