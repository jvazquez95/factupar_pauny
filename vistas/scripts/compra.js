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
//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();
	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	});

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




	//Cargamos los items al select cliente
	$.post("../ajax/compra.php?op=selectOC", function(r){
	            $("#OrdenCompra_idOrdenCompra").html(r);
	            $('#OrdenCompra_idOrdenCompra').selectpicker('refresh');
	});


	$.post("../ajax/centroDeCostos.php?op=selectCentroDeCostos", function(r){
	            $("#CentroCosto_idCentroCosto").html(r);
	            $('#CentroCosto_idCentroCosto').selectpicker('refresh');
	});

	//Cargamos los items al select cliente
	//$.post("../ajax/persona.php?op=selectProveedor", function(r){
	//            $("#Proveedor_idProveedor").html(r);
	//            $('#Proveedor_idProveedor').selectpicker('refresh');
	//});	


	//Cargamos los items al select cliente
	$.post("../ajax/terminoPago.php?op=selectTerminoPago", function(r){
	            $("#TerminoPago_idTerminoPago").html(r);
	            $('#TerminoPago_idTerminoPago').selectpicker('refresh');
	});	


	//Cargamos los items al select cliente
	$.post("../ajax/formaPago.php?op=selectFormaPago", function(r){
	            $("#TerminoPago_idTerminoPagoDetalle").html(r);
	            $('#TerminoPago_idTerminoPagoDetalle').selectpicker('refresh');
	});	

	//habilitacion factura
	$.post("../ajax/compra.php?op=habilitacion", function(data, status)
		{

			data = JSON.parse(data);
			if (data.idhabilitacion) {
				$('#Habilitacion_idHabilitacion').val(data.idhabilitacion);
				$('#Habilitacion_idHabilitacion1').val(data.idhabilitacion);
				serie = data.serie;
				fra = data.a;
			}else{
				swal({
				  position: 'top-end',
				  type: 'danger',
				  title: 'Caja no habilitada.',
				  showConfirmButton: false,
				  timer: 1500
				 })	
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


	var costo = document.getElementsByName("costo[]");
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


	vcosto = document.getElementsByName("costo[]");
	vl_tasaCambio = $("#tasaCambio").val();
	vl_tasacambiobase = $("#tasaCambioBases").val();
	vmoneda = moneda;
	entro = 1;


   	modificarSubototales();

}

function irAnularCompra(id, datos){
	window.open("../vistas/anularCompra.php?id="+id+"&datos="+datos , "Anular Compra" , "width=120,height=300,scrollbars=NO")
}

function cargarComprasPorCentroDeCosto(x){


	var id = x.value;

	$.post("../ajax/compra.php?op=selectCompraPorCentroDeCosto",{ id:id }, function(r){
	            $("#Compra_idCompraAsignada").html(r);
	            $('#Compra_idCompraAsignada').selectpicker('refresh');
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



function listarTimbradoA(x){

	$.post("../ajax/proveedorTimbrado.php?op=selectTimbradoProveedor",{ Proveedor_idProveedor: x }, function(r){
	            $("#timbrado").html(r);
	            $('#timbrado').selectpicker('refresh');


			cargarVencimientoA($("#timbrado").val());



	});		

}

function listarTimbrado(x){

	$.post("../ajax/proveedorTimbrado.php?op=selectTimbradoProveedor",{ Proveedor_idProveedor: x.value }, function(r){
	            $("#timbrado").html(r);
	            $('#timbrado').selectpicker('refresh');

			cargarVencimientoA($("#timbrado").val());

	            
	});		

}

function cargarVencimientoA(x){

	$.post("../ajax/proveedorTimbrado.php?op=vencimientoTimbrado", { idProveedorTimbrado: x } , function(data, status)
		{

			data = JSON.parse(data);		
			$('#vtoTimbrado').val(data.vtoTimbrado);
	 });	


}

function cargarVencimiento(x){

	$.post("../ajax/proveedorTimbrado.php?op=vencimientoTimbrado", { idProveedorTimbrado: x.value } , function(data, status)
		{

			data = JSON.parse(data);		
			$('#vtoTimbrado').val(data.vtoTimbrado);
	 });	


}


function crud(ventana){
	window.open("../vistas/"+ ventana +".php", "Diseño Web", "width=600, height=600");
}


function crud(ventana) {
    var ventanawo = window.open("../vistas/"+ ventana +".php", "PYVENTAS"+ventana, "width=600, height=600");
    var interval = setInterval(function(){
        if(ventanawo.closed !== false) {

          window.clearInterval(interval)
          

		      if (ventana == "centroDeCostos") {
		      $.post("../ajax/centroDeCostos.php?op=selectCentroDeCostos", function(r){
		                  $("#CentroCosto_idCentroCosto").html(r);
		                  $('#CentroCosto_idCentroCosto').selectpicker('refresh');
		      });
		      }

          
			

			if (ventana == "proveedorTimbrado") {

	        	var l_proveedor =  $("#Proveedor_idProveedor").val();
				$.post("../ajax/proveedorTimbrado.php?op=selectTimbradoProveedor",{ Proveedor_idProveedor: l_proveedor }, function(r){
		            $("#timbrado").html(r);
		            $('#timbrado').selectpicker('refresh');

				});
			}

			else if(ventana == "persona"){
			$.post("../ajax/persona.php?op=selectProveedor", function(r){
			            $("#Persona_idPersona").html(r);
			            $('#Persona_idPersona').selectpicker('refresh');

			});
			}
			else if(ventana == "marca"){
			$.post("../ajax/marca.php?op=selectMarca", function(r){
			            $("#Marca_idMarca").html(r);
			            $('#Marca_idMarca').selectpicker('refresh');

			});
			}
			else if(ventana == "categoria"){
			$.post("../ajax/articulo.php?op=selectCategoria", function(r){
			            $("#Categoria_idCategoria").html(r);
			            $('#Categoria_idCategoria').selectpicker('refresh');
			            $("#Categoria_idCategoriaD").html(r);
			            $('#Categoria_idCategoriaD').selectpicker('refresh');

			});
			}


        } 


    },1000)
    
  
}



function cargarOC(x){


	//habilitacion factura
	$.post("../ajax/compra.php?op=datosOC&id="+x.value, function(data, status)
		{

			data = JSON.parse(data);



			g_idCliente = data.Persona_idPersona;

		    $.ajax({
		    type: "POST",
		    url: "../ajax/persona.php?op=selectClienteLimit",
		    data:{keyword: g_idCliente, tipoPersona: 2},
		    success: function(datas){
		      $("select.selector_persona ").html(datas);
		      $("select.selector_persona").selectpicker("refresh");
		    

      			$("#Proveedor_idProveedor").val(g_idCliente);
				$("#Proveedor_idProveedor").selectpicker("refresh");

		    },
		    error: function(datas){
		        console.log("NO se pudo enviar");
		    }
		    });


			$("#Proveedor_idProveedor").val(g_idCliente);
			$("#Proveedor_idProveedor").selectpicker("refresh");








		    

			$("#nroFactura").val(data.nroCompra);

			$("#Moneda_idMoneda").val(data.Moneda_idMoneda);
			$("#Moneda_idMoneda").selectpicker('refresh');



			$("#Proveedor_idProveedor").val(data.Persona_idPersona);
			$("#Proveedor_idProveedor").selectpicker('refresh');


			$("#TerminoPago_idTerminoPago").val(data.TerminoPago_idTerminoPago);
			$("#TerminoPago_idTerminoPago").selectpicker('refresh');

			$("#HacerPedido_idHacerPedido").val(data.HacerPedido_idHacerPedido);

			moneda_inicial = data.Moneda_idMoneda;


			listarTimbradoA(data.Persona_idPersona);


	 });


 	$.post("../ajax/compra.php?op=listarDetalleOrdenCompra&id="+x.value,function(r){
	        $("#detalles").html(r);
	      	$("#btnGuardar").show();
	      //	detalle = 
  			var cant = document.getElementsByName("cantidad[]");
	      	//alert(cant.length);
	      	cont = cant.length;
	      	detalles = cant.length;
    		modificarSubototales();
			cargarTasaInicial( moneda_inicial );
			cambiarMoneda( moneda_inicial )


	});	



}


function mostrarDetalleFacturaCompra(idCompra){
	window.open('../reportes/rptCompra.php?idCompra=' + idCompra);
}



function mostrarDetalleCompra(idCompra){
	$('#modal_detalle').modal('show');
	$("#detalle").val(idCompra);
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
					url: '../ajax/consultas.php?op=rpt_compras_detalle',
					data:{idCompra:idCompra},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
  			"columnDefs": [
            {
                "targets": [ 0,1,4,5,6 ],
                "visible": true	,  
                "searchable": true,
                "className": 'text-right' 
            }], 
            "language": {
            "decimal": ".",
            "thousands": ","
        },
	    "responsive": true,

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
                .column( 7, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return parseFloat(intVal(a)) + parseFloat(intVal(b));
                }, 0 );
 
            // Update footer
            $( api.column( 7 ).footer() ).html(
               formatNumber.new(pageTotal) 
            );
        }
    } );
} );
}




function mostrarDetalleAsiento(idCompra){
	$('#modal_detalle').modal('show');
	$("#detalle4").val(idCompra);  
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
					url: '../ajax/consultas.php?op=rpt_asiento_detalle_vista',
					data:{idCompra:idCompra},   
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
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return parseFloat(intVal(a)) + parseFloat(intVal(b));
                }, 0 );
 
            // Update footer
            $( api.column( 4 ).footer() ).html(
               formatNumber.new(pageTotal) 
            );

            // Total over this page
            pageTotal = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return parseFloat(intVal(a)) + parseFloat(intVal(b));
                }, 0 );

            // Update footer
            $( api.column( 5 ).footer() ).html(
               formatNumber.new(pageTotal) 
            );            
        }
    } );
} );
}






function mostrarDetallePago(idCompra){
	$('#modal_detalle_cobro').modal('show');
	$("#detalle_cobro").val(idCompra);
$(document).ready(function() {
    $('#tbllistado5').DataTable( {
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    fixedColumns: false,
	    buttons: [		          
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../ajax/consultas.php?op=rpt_pagos_detalle_todos',
					data:{idCompra:idCompra},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
 
  			"columnDefs": [
            {
                "targets": [ 0,1,3,4 ],
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
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return parseFloat(intVal(a)) + parseFloat(intVal(b));
                }, 0 );
 
            // Update footer
            $( api.column( 4 ).footer() ).html(
                  formatNumber.new(pageTotal)   
             );
        }
    } );
} );
}



function volver(x){
	$("#buscar_articulo").focus();
	$("#buscar_articulo").val('a');
$('buscar_articulo option').remove();
	
}




//Función limpiar
function limpiar()
{
	//$("#TerminoPago_idTerminoPago").val("");
	$("#tipo_comprobante").val("");
	//$("#Moneda_idMoneda").val("");
	$("#fechaTransaccion").val("");
	$("#totalImpuesto").val("");
	$("#total").val("");
	$("#subTotal").val("");
	$("#fechaModificacion").val("");
	$("#usuarioInsercion").val("");
	$("#usuarioModificacion").val("");
	$("#inactivo").val("");
	$("#total_cabecera").val("");
	$("#imagen").val("");
	$("#nroFactura").val("");
	$("#timbrado").val("");
	$("#tipo_comprobante").selectpicker('refresh');

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
}



function autorizarCompra(idCompra){

	var idCompra = idCompra;



swal({
	  title: 'Esta seguro de confirmar la compra?',
	  text: "",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Si, confirmar!'
	}).then((result) => {
	  if (result.value) {


$.ajax({
    	type: "get",
    	url: '../ajax/compra.php?op=autorizarCompra',
    	data: {idCompra:idCompra},
		dataType:"json",
	    success: function(datos)
	    {                    
			swal({
			  position: 'top-end',
			  type: 'success',
			  title: 'Compra confirmada.',
			  showConfirmButton: false,
			  timer: 1500
			 })		          
	    },
	    complete: function(datos){
	    				swal({
			  position: 'top-end',
			  type: 'success',
			  title: 'Compra confirmada.',
			  showConfirmButton: false,
			  timer: 1500
			 })	
		}


	});
	  }
	})


	$("#cabecera").show();
	$("#detalle").hide();

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
}

//Función Listar
function listar()
{
	tabla=$('#tbllistado').dataTable(
	{
		"fnRowCallback": function( nRow, aaData, iDisplayIndex, iDisplayIndexFull ) {
		  if ( aaData[19] != '<span class="label bg-green">Aceptado</span>' )
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
					url: '../ajax/compra.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"scrollY":        "500px",
        "scrollCollapse": true,
        "paging":         false,
	    "responsive": true,
		"bDestroy": true,
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
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
					url: '../ajax/compra.php?op=listarArticulosCompra',
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
		url: "../ajax/compra.php?op=guardaryeditar",
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
	          listar();
			limpiar();
			init();
	    }/*,
	    complete: function(e){
			
	    	alert(e);

			swal({
			  position: 'top-end',
			  type: 'success',
			  title: 'Compra confirmada.',
			  showConfirmButton: false,
			  timer: 1500
			 })	          

	    	cont2 = 0;
	    	modificarSubototales();
	    	modificarSubototalesDetalle();
			limpiar();
	    	mostrarform(true);
	    }*/

	});
	limpiar();
}

function mostrar(idcompra)
{
	$.post("../ajax/compra.php?op=mostrar",{idcompra : idcompra}, function(data, status)
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
function anular(idcompra)
{
	bootbox.confirm("¿Está Seguro de anular la venta?", function(result){
		if(result)
        {
        	$.post("../ajax/compra.php?op=anular", {idcompra : idcompra}, function(e){
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
  	/*if (tipo_comprobante=='Factura')
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
    }*/
  }

function agregarDetalle(idarticulo,articulo,costo,idImpuesto,impuesto)
  {
  	var cantidad=1;
    var descuento=0;
    if (idarticulo!="")
    {


    	if (impuesto == 10) {
	    var calculoImpuesto = costo  / 1.1;
    	}else if (impuesto == 5) {
	    var calculoImpuesto = costo  / 1.05;	
    	}else{
   	    var calculoImpuesto = ((costo * impuesto) / 100);
    	}

	    var totalN = (calculoImpuesto);    	
    	var subtotal=cantidad*costo;
    	var fila='<tr class="filas" id="fila'+cont+'">'+
    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button></td>'+
    	'<td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td>'+
    	'<input type="hidden" name="descripcion[]" value="'+articulo+'">'+
    	'<td><input type="hidden" name="devolver[]" id="devolver[]" value="0"><input type="text" onblur="modificarSubototales()" name="cantidad[]" id="cantidad[]" value="'+cantidad+'"></td>'+
    	'<td><input type="text onblur="modificarSubototales()"" name="costo[]" id="costo[]" value="'+costo+'"></td>'+
    	'<td><input type="text" onblur="modificarSubototales()" id="descuento[]" name="descuento[]" value="'+descuento+'"></td>'+
    	'<td><input type="hidden" onblur="modificarSubototales()" name="impuesto[]" value="'+impuesto+'">'+impuesto+' %</td>'+
    	'<input type="hidden" name="TipoImpuesto_idTipoImpuesto[]" value="'+idImpuesto+'">'+
    	'<td><span name="totalN" id="totalN'+cont+'">'+totalN+'</span></td>'+
    	'<td><span name="subtotal" id="subtotal'+cont+'">'+subtotal+'</span></td>'+
    	'<td><button type="button" onclick="modificarSubototales()" class="btn btn-info"><i class="fa fa-refresh"></i></button></td>'+
    	'</tr>';
    	cont++;
    	detalles=detalles+1;
    	$('#detalles').append(fila);
    	modificarSubototales();
    }else{
    	alert("Error al ingresar el detalle, revisar los datos del artículo");
    }
  }



  function modificarSubototales()
  {
  	var cant = document.getElementsByName("cantidad[]");
    var prec = document.getElementsByName("costo[]");
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

    	//AQUI SE CALCULA EL DESCUENTO EN %
    	inpS.value= (inpC.value * inpP.value) - (inpC.value * inpP.value)*inpD.value/100;

    	if (inpI.value == 10) {
    		inpN.value = inpS.value / 11; 
    	}else if( inpI == 5 ){
    		inpN.value = inpS.value / 21; 	
    	}else{
    		inpN.value = inpS.value; 	
    	}


    	document.getElementsByName("subtotal")[i].innerHTML = (inpS.value).toFixed(2);
    	document.getElementsByName("totalN")[i].innerHTML = inpN.value.toFixed(2);

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
	$("#total2").html(" " + total.toFixed(2));
    $("#total_compra").val(total.toFixed(2));
	$("#total1").html(" " + t1.toFixed(2));
    $("#total_compran").val(t1.toFixed(2));
    $("#totalImpuesto").val(impuestov.toFixed(2));
    $("#importe_detalle").val(total.toFixed(2));
	$("#nroCheque").val(0);
	//$("#idtotalVenta").val(total);
	comparar();
    evaluar();
  }

  function evaluar(){



  	if (detalles>0)
    {


    	if ( $("#diferencia").val() != 0 ) {
	      $("#btnGuardar").hide();
    	}else{
	      $("#btnGuardar").show();	
    	}
    }
    else
    {


      $("#btnGuardar").hide(); 
      cont=0;
	  cont=0;

    }
  }


function comparar2(){

	var cabecera = $("#total_cabecera").val();
	var total = $("#total_compra").val()


	$("#diferencia").val( cabecera - total );


	evaluar();
	

}


function comparar(){

	var cabecera = $("#total_cabecera").val();
	var total = $("#total_compra").val()


	$("#diferencia").val( cabecera - total );




}


  function eliminarDetalle(indice){



  	$("#fila" + indice).remove();
  	calcularTotales();
  	detalles=detalles-1;
  	evaluar()
  }

function agregarDetallePago()
  {
  	var tipopago=   $("#TerminoPago_idTerminoPagoDetalle option:selected").val();
  	var tipopagot=   $("#TerminoPago_idTerminoPagoDetalle option:selected").text();
  	var importe_detalle =   $("#importe_detalle").val();
  	var nroReferencia=   $("#nroCheque").val();


    	var fila='<tr class="filas" id="fila'+cont2+'">'+
    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont2+')">X</button></td>'+
    	'<td><input type="hidden" name="tipopago[]" value="'+tipopago+'">'+tipopagot+'</td>'+
    	'<td><input type="number" name="importe_detalle[]" id="importe_detalle[]" value="'+importe_detalle+'"></td>'+
    	'<td><input type="text" name="nroReferencia[]" id="nroReferencia[]" value="'+nroReferencia+'"></td>'+
    	'<td><span name="subtotalDetalle" id="subtotalDetalle'+cont+'">'+importe_detalle+'</span></td>'+
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
  	$("#fila" + indice).remove();
  	calcularTotalesDetalle();
  	detalles=detalles-1;
  	evaluar()
  }

function verificar(){
	var v1 = document.getElementById('t_detalle').value;
	var v2 = document.getElementById('total_compra').value;

	if (v1 != v2) {
      $("#btnGuardar").hide(); 

  }else{
      $("#btnGuardar").show(); 

  }
}

init();