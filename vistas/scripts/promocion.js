var tabla;
var contPrecioPorPack = 0;
var contPrecioPorPunto = 0;
var contPromocionFormaPago = 0;
var contPromocionDescuento = 0;
var contPuntos = 0;
var contPrecioPorTiempoLimitado = 0;
var detallePuntos = 0;
var detallesPromocionFormaPago = 0;
var detallesPromocionDescuento = 0;
var detallesPPrecioPorTiempoLimitado = 0;
var detallePrecioPorPunto = 0;
var detallePrecioPorPack = 0;
//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})




	//cargamos los items al select usuario
/*	$.post("../ajax/venta.php?op=selectArticulosVenta", function(r){
		
		$("#Articulo_idArticuloDescuento_l").html(r);
		$("#Articulo_idArticuloDescuento_l").selectpicker('refresh');
		
		$("#Articulo_idArticuloPunto_l").html(r);
		$("#Articulo_idArticuloPunto_l").selectpicker('refresh');

		$("#Articulo_idArticulo_l").html(r);
		$("#Articulo_idArticulo_l").selectpicker('refresh');

		$("#Articulo_idArticuloDescuentoPrecioTiempoLimitado_l").html(r);
		$("#Articulo_idArticuloDescuentoPrecioTiempoLimitado_l").selectpicker('refresh');

		$("#Articulo_idArticuloPrecioPuntos_l").html(r);
		$("#Articulo_idArticuloPrecioPuntos_l").selectpicker('refresh');




	}); */


	//cargamos los items al select usuario 
	$.post("../ajax/sucursal.php?op=selectSucursalTodos", function(r){

		$("#sucursalD1").html(r);
		$("#sucursalD1").selectpicker('refresh');

		$("#Sucursal_idSucursalD1").html(r);
		$("#Sucursal_idSucursalD1").selectpicker('refresh');

		$("#Sucursal_idSucursalD2").html(r);
		$("#Sucursal_idSucursalD2").selectpicker('refresh');

		$("#Sucursal_idSucursalD3").html(r);
		$("#Sucursal_idSucursalD3").selectpicker('refresh');

		$("#Sucursal_idSucursalD4").html(r);
		$("#Sucursal_idSucursalD4").selectpicker('refresh');

		$("#Sucursal_idSucursalD5").html(r);
		$("#Sucursal_idSucursalD5").selectpicker('refresh');

		$("#Sucursal_idSucursalD6").html(r);
		$("#Sucursal_idSucursalD6").selectpicker('refresh');		

	});


	//cargamos los items al select usuario
	$.post("../ajax/terminoPago.php?op=selectTerminoPago", function(r){
		
		$("#FormaPago_idFormaPago_lD3").html(r);
		$("#FormaPago_idFormaPago_lD3").selectpicker('refresh');
	
		$("#FormaPago_idFormaPago_l").html(r);
		$("#FormaPago_idFormaPago_l").selectpicker('refresh');

		

	});


	//cargamos los items al select usuario
	$.post("../ajax/persona.php?op=selectProveedorTodos", function(r){
 
		$("#proveedorD1").html(r);
		$("#proveedorD1").selectpicker('refresh');

		$("#proveedorD2").html(r);
		$("#proveedorD2").selectpicker('refresh');

		$("#proveedorD3").html(r);
		$("#proveedorD3").selectpicker('refresh');

		$("#proveedorD4").html(r);
		$("#proveedorD4").selectpicker('refresh');

		$("#proveedorD5").html(r);
		$("#proveedorD5").selectpicker('refresh');

		$("#proveedorD6").html(r);
		$("#proveedorD6").selectpicker('refresh');


	});

	//Cargamos los items al select grupo
	$.post("../ajax/marca.php?op=selectMarca", function(r){

	            $("#marcaD1").html(r);
	            $('#marcaD1').selectpicker('refresh');

	            $("#marcaD2").html(r);
	            $('#marcaD2').selectpicker('refresh');

	            $("#marcaD3").html(r);
	            $('#marcaD3').selectpicker('refresh');

	            $("#marcaD4").html(r);
	            $('#marcaD4').selectpicker('refresh');

	            $("#marcaD5").html(r);
	            $('#marcaD5').selectpicker('refresh');

	            $("#marcaD6").html(r);
	            $('#marcaD6').selectpicker('refresh');	            

	});

	//Cargamos los items al select grupo
	$.post("../ajax/articulo.php?op=selectGrupoTodos", function(r){
	            $("#grupoD1").html(r);
	            $('#grupoD1').selectpicker('refresh');

	            $("#grupoD2").html(r);
	            $('#grupoD2').selectpicker('refresh'); 

	            $("#grupoD3").html(r);
	            $('#grupoD3').selectpicker('refresh'); 

	            $("#grupoD4").html(r);
	            $('#grupoD4').selectpicker('refresh');

	            $("#grupoD5").html(r);
	            $('#grupoD5').selectpicker('refresh');

	            $("#grupoD6").html(r);
	            $('#grupoD6').selectpicker('refresh');	            

	});


	//Cargamos los items al select categoria
	$.post("../ajax/articulo.php?op=selectCategoriaTodos", function(r){

	            $("#categoriaD1").html(r);
	            $('#categoriaD1').selectpicker('refresh');
		
	            $("#categoriaD2").html(r);
	            $('#categoriaD2').selectpicker('refresh');		

	            $("#categoriaD3").html(r);
	            $('#categoriaD3').selectpicker('refresh');

	            $("#categoriaD4").html(r);
	            $('#categoriaD4').selectpicker('refresh');

	            $("#categoriaD5").html(r);
	            $('#categoriaD5').selectpicker('refresh');
 
	            $("#categoriaD6").html(r);
	            $('#categoriaD6').selectpicker('refresh');
 
	});
 


	//cargamos los items al select usuario
	$.post("../ajax/banco.php?op=selectBanco", function(r){
		
		$("#Banco_idBanco_lD3").html(r);
		$("#Banco_idBanco_lD3").selectpicker('refresh');
	
		$("#Banco_idBanco_l").html(r);
		$("#Banco_idBanco_l").selectpicker('refresh');


	});



	$("#divPromocionDescuento").hide();
	$("#divPromocionPuntos").hide();
	$("#divPromocionFormaPago").hide();
	$("#divPrecioPorTiempoLimitado").hide();
	$("#divFiltro").hide();
	$("#divPrecioPorPuntos").hide();
	$("#divPrecioPorPack").hide();

}

//Función limpiar
function limpiar()
{
	$("#idPromocion").val("");
	$("#descripcion").val("");
	//$("#fechaInicio").val("");
	//$("#fechaFin").val("");
}


function mostrarDiv() {

	var tipo = $("#tipoPromocion").val();

	if (tipo=='0') {
		ocultarTodo();
	}

	if (tipo=='promocionPorDescuento') {
		divPromocionDescuento();
	}

	if (tipo=='promocionPorPuntos') {
		divPromocionPuntos();
	}

	if (tipo=='promocionPorFormaPago') {
		divPromocionFormaPago()
	}

	if (tipo=='promocionPorTiempoLimitado') {
		divPrecioPorTiempoLimitado();		
	}

	if (tipo=='promocionPorPrecioPunto') {
		divPrecioPorPuntos();		
	}

	if (tipo=='promocionPorPrecioPack') {
		divPrecioPorPack();		
	}	


}

function ocultarTodo(){

	$("#divPromocionPuntos").hide();
	$("#divPromocionFormaPago").hide();
	$("#divPrecioPorTiempoLimitado").hide();
	$("#divPrecioPorPuntos").hide();
	$("#divPromocionDescuento").hide();
	$("#divPrecioPorPack").hide();
	$("#divFiltro").hide();


}

function divPromocionDescuento(){

	$("#divPromocionPuntos").hide();
	$("#divPromocionFormaPago").hide();
	$("#divPrecioPorTiempoLimitado").hide();
	$("#divPrecioPorPuntos").hide();
	$("#divPromocionDescuento").show();
	$("#divFiltro").show();


}

function divPromocionPuntos(){

	$("#divPromocionDescuento").hide();
	$("#divPromocionFormaPago").hide();
	$("#divPrecioPorTiempoLimitado").hide();
	$("#divPrecioPorPuntos").hide();
	$("#divPromocionPuntos").show();
	$("#divFiltro").show();

	
}

function divPromocionFormaPago(){

	$("#divPromocionDescuento").hide();
	$("#divPromocionPuntos").hide();
	$("#divPrecioPorTiempoLimitado").hide();
	$("#divPrecioPorPuntos").hide();
	$("#divPromocionFormaPago").show();
	$("#divFiltro").show();

}

function divPrecioPorTiempoLimitado(){
	$("#divPromocionDescuento").hide();
	$("#divPromocionPuntos").hide();
	$("#divPromocionFormaPago").hide();
	$("#divPrecioPorPuntos").hide();
	$("#divPrecioPorTiempoLimitado").show();
	$("#divFiltro").show();

	
}



function divPrecioPorPuntos(){
	$("#divPromocionDescuento").hide();
	$("#divPromocionPuntos").hide();
	$("#divPromocionFormaPago").hide();
	$("#divPrecioPorTiempoLimitado").hide();
	$("#divFiltro").show();
	$("#divPrecioPorPuntos").show();

	
}

function divPrecioPorPack(){
	$("#divPromocionDescuento").hide();
	$("#divPromocionPuntos").hide();
	$("#divPromocionFormaPago").hide();
	$("#divPrecioPorTiempoLimitado").hide();
	$("#divFiltro").show();
	$("#divPrecioPorPuntos").hide();
	$("#divPrecioPorPack").show(); 

}

function modalFiltroPromocionPorDescuento(){
	$('#modalFiltroPromocionPorDescuento').modal('show');


}





function modalFiltroPromocionPunto(){
	$('#modalFiltroPromocionPunto').modal('show');
}

function modalFiltroPromocionFormaPago(){
	$('#modalFiltroPromocionFormaPago').modal('show');
}

function modalFiltroPrecioPorTiempoLimitado(){
	$('#modalFiltroPrecioPorTiempoLimitado').modal('show');
}


function modalFiltroPrecioPorPunto(){
	$('#modalFiltroPrecioPorPunto').modal('show');
}

function modalFiltroPrecioPorPack(){
	$('#modalFiltroPrecioPorPack').modal('show');
}

function filtrarDetallePromocionPorDescuento(){

	var idProveedor = $('#proveedorD1').val();
	var marca = $('#marcaD1').val();
	var grupo = $('#grupoD1').val();
	var categoria = $('#categoriaD1').val();
	var tipoDescuento = $('#tipoDescuento_lD1').val();
	var desde1 = $('#desde_lD1').val(); 
	var hasta1 = $('#hasta_lD1').val(); 
	var descuentoPorcentaje = $('#descuentoPorcentualDescuento_lD1').val(); 
	var descuentoMonto = $('#descuentoGsDescuento_lD1').val(); 

    $.ajax({
        url: "../ajax/promocion.php?op=generarPedido", 
        type: "GET",
        data: { idProveedor:idProveedor, marca:marca, grupo:grupo,  categoria:categoria, tipoDescuento:tipoDescuento, 
        		desde1:desde1, hasta1:hasta1, descuentoPorcentaje:descuentoPorcentaje, descuentoMonto:descuentoMonto },
		dataType : "json",
		beforeSend: function() {
			$("#btnGenerar").prop("disabled",true);
			$('#espere').show();
			$('#espere').html("<img height='auto' width='300' src='../files/gif/tenor.gif' />");
    	},			
        complete: function(datos){
			$('#modalFiltroPromocionPorDescuento').modal('hide');
			$('#espere').hide();
            filtrarGenerado1();
			$("#btnGenerar").prop("disabled",false);

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


//Función Listar
function filtrarGenerado1()
{

	var idProveedor = $('#proveedorD1').val();
	var marca = $('#marcaD1').val();
	var grupo = $('#grupoD1').val();
	var categoria = $('#categoriaD1').val();
	var tipoDescuento = $('#tipoDescuento_lD1').val();
	var desde1 = $('#desde_lD1').val(); 
	var hasta1 = $('#hasta_lD1').val(); 
	var descuentoPorcentaje = $('#descuentoPorcentualDescuento_lD1').val(); 
	var descuentoMonto = $('#descuentoGsDescuento_lD1').val(); 
	var sucursal = $('#sucursalD1').val(); 

	console.log(idProveedor);

	tabla=$('#detalleTipoDescuento').dataTable(
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
					url: '../ajax/promocion.php?op=listarFiltrado1',
					type : "get",
					data : { idProveedor:idProveedor, marca:marca,grupo:grupo, categoria:categoria, tipoDescuento:tipoDescuento, 
							 desde1:desde1, hasta1:hasta1, descuentoPorcentaje:descuentoPorcentaje, descuentoMonto:descuentoMonto, sucursal:sucursal },
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 50,//Paginación
	    "order": [[ 1, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}

function filtrarDetallePromocionPunto(){

	var idProveedor = $('#proveedorD2').val();
	var marca = $('#marcaD2').val();
	var grupo = $('#grupoD2').val();
	var categoria = $('#categoriaD2').val();
	var cantidadPuntos = $('#cantidadPuntos_lD2').val(); 
	 
    $.ajax({
        url: "../ajax/promocion.php?op=generarPedido", 
        type: "GET",
        data: { idProveedor:idProveedor, marca:marca, grupo:grupo,  categoria:categoria, cantidadPuntos:cantidadPuntos  },
		dataType : "json",
		beforeSend: function() {
			$("#btnGenerar").prop("disabled",true);
			$('#espere').show();
			$('#espere').html("<img height='auto' width='300' src='../files/gif/tenor.gif' />");
    	},			
        complete: function(datos){
			$('#modalFiltroPromocionPunto').modal('hide'); 
			$('#espere').hide();
            filtrarGenerado2();
			$("#btnGenerar").prop("disabled",false);

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


//Función Listar
function filtrarGenerado2()
{

	var idProveedor = $('#proveedorD2').val();
	var marca = $('#marcaD2').val();
	var grupo = $('#grupoD2').val();
	var categoria = $('#categoriaD2').val();
	var cantidadPuntos = $('#cantidadPuntos_lD2').val(); 
	var sucursal = $('#sucursalD2').val(); 
	console.log(idProveedor);

	tabla=$('#detallePromocionPorPuntos').dataTable(
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
					url: '../ajax/promocion.php?op=listarFiltrado2',
					type : "get",
					data : { idProveedor:idProveedor, marca:marca, grupo:grupo,  categoria:categoria, cantidadPuntos:cantidadPuntos, sucursal:sucursal },
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 50,//Paginación
	    "order": [[ 1, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}

  

function filtrarDetallePromocionFormaPago(){

	var idProveedor = $('#proveedorD3').val();
	var marca = $('#marcaD3').val();
	var grupo = $('#grupoD3').val();
	var categoria = $('#categoriaD3').val();
	var formaPago = $('#FormaPago_idFormaPago_lD3').val(); 
	var banco = $('#Banco_idBanco_lD3').val();
	var descuentoPorcentual = $('#descuentoPorcentual_lD3').val(); 
	var descuentoMonto = $('#descuentoGs_lD3').val();
 

    $.ajax({
        url: "../ajax/promocion.php?op=generarPedido", 
        type: "GET",
        data: { idProveedor:idProveedor, marca:marca, grupo:grupo,  categoria:categoria, formaPago:formaPago, 
        		banco:banco, descuentoPorcentual:descuentoPorcentual, descuentoMonto:descuentoMonto  },
		dataType : "json",
		beforeSend: function() {
			$("#btnGenerar").prop("disabled",true);
			$('#espere').show();
			$('#espere').html("<img height='auto' width='300' src='../files/gif/tenor.gif' />");
    	},			
        complete: function(datos){
			$('#modalFiltroPromocionFormaPago').modal('hide'); 
			$('#espere').hide();
            filtrarGenerado3();
			$("#btnGenerar").prop("disabled",false);

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


//Función Listar
function filtrarGenerado3()
{

	var idProveedor = $('#proveedorD3').val();
	var marca = $('#marcaD3').val();
	var grupo = $('#grupoD3').val();
	var categoria = $('#categoriaD3').val();
	var formaPago = $('#FormaPago_idFormaPago_lD3').val(); 
	var banco = $('#Banco_idBanco_lD3').val();
	var descuentoPorcentual = $('#descuentoPorcentual_lD3').val(); 
	var descuentoMonto = $('#descuentoGs_lD3').val();
	var sucursal = $('#sucursalD3').val(); 	

	tabla=$('#detallePromocionFormaPago').dataTable(
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
					url: '../ajax/promocion.php?op=listarFiltrado3',
					type : "get",
        			data : { idProveedor:idProveedor, marca:marca, grupo:grupo,  categoria:categoria, formaPago:formaPago, 
        					banco:banco, descuentoPorcentual:descuentoPorcentual, descuentoMonto:descuentoMonto , sucursal:sucursal},
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 50,//Paginación
	    "order": [[ 1, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}



function filtrarDetallePromocionPrecioPunto(){

	var idProveedor = $('#proveedorD5').val();
	var marca = $('#marcaD5').val();
	var grupo = $('#grupoD5').val();
	var categoria = $('#categoriaD5').val();
	var precioD5 = $('#precioGsPrecio_lD5').val(); 
	var puntoD5 = $('#puntos_lD5').val();
	 
    $.ajax({
        url: "../ajax/promocion.php?op=generarPedido", 
        type: "GET",
        data: { idProveedor:idProveedor, marca:marca, grupo:grupo,  categoria:categoria, precioD5:precioD5, puntoD5:puntoD5 },
		dataType : "json",
		beforeSend: function() {
			$("#btnGenerar").prop("disabled",true);
			$('#espere').show();
			$('#espere').html("<img height='auto' width='300' src='../files/gif/tenor.gif' />");
    	},			
        complete: function(datos){
			$('#modalFiltroPrecioPorPunto').modal('hide'); 
			$('#espere').hide();
            filtrarGenerado5();
			$("#btnGenerar").prop("disabled",false);

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


//Función Listar
function filtrarGenerado5()
{

	var idProveedor = $('#proveedorD5').val();
	var marca = $('#marcaD5').val();
	var grupo = $('#grupoD5').val();
	var categoria = $('#categoriaD5').val();
	var precioD5 = $('#precioGsPrecio_lD5').val(); 
	var puntoD5 = $('#puntos_lD5').val();
	var sucursal = $('#sucursalD5').val();

	tabla=$('#detallesPrecioPorPunto').dataTable(
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
					url: '../ajax/promocion.php?op=listarFiltrado5',
					type : "get",
        			data : { idProveedor:idProveedor, marca:marca, grupo:grupo,  categoria:categoria, precioD5:precioD5, 
        					puntoD5:puntoD5 , sucursal:sucursal },
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 50,//Paginación
	    "order": [[ 1, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}


function filtrarDetallePrecioPorTiempoLimitado(){

	var idProveedor = $('#proveedorD4').val();
	var marca = $('#marcaD4').val();
	var grupo = $('#grupoD4').val();
	var categoria = $('#categoriaD4').val();
	var precio = $('#precioD4').val();
	var ventamax = $('#ventamaxD4').val(); 

    $.ajax({
        url: "../ajax/promocion.php?op=generarPedido",
        type: "GET",
        data: { idProveedor:idProveedor, marca:marca, grupo:grupo,  categoria:categoria, precio:precio, ventamax:ventamax },
		dataType : "json",
		beforeSend: function() {
			$("#btnGenerar").prop("disabled",true);
			$('#espere').show();
			$('#espere').html("<img height='auto' width='300' src='../files/gif/tenor.gif' />");
    	},			
        complete: function(datos){
			$('#modalFiltroPrecioPorTiempoLimitado').modal('hide');
			$('#espere').hide();
            filtrarGenerado4();
			$("#btnGenerar").prop("disabled",false);

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


//Función Listar
function filtrarGenerado4()
{

	var idProveedor = $('#proveedorD4').val();
	var marca = $('#marcaD4').val();
	var grupo = $('#grupoD4').val();
	var categoria = $('#categoriaD4').val(); 
	var precio = $('#precioD4').val();
	var ventamax = $('#ventamaxD4').val(); 
	var sucursal = $('#sucursalD4').val(); 	
	console.log(ventamax);

	tabla=$('#detallePrecioTiempoLimitado').dataTable(
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
					url: '../ajax/promocion.php?op=listarFiltrado4',
					type : "get",
					data : { idProveedor:idProveedor, marca:marca,grupo:grupo, categoria:categoria, precio:precio, ventamax:ventamax, sucursal:sucursal },
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 50,//Paginación
	    "order": [[ 1, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}



function filtrarDetallePrecioPack(){

	var idProveedor = $('#proveedorD6').val();
	var marca = $('#marcaD6').val();
	var grupo = $('#grupoD6').val();
	var categoria = $('#categoriaD6').val();
	var precioD5 = $('#precioGsPrecio_lD6').val(); 
	var puntoD5 = $('#puntos_lD6').val();
	 
    $.ajax({
        url: "../ajax/promocion.php?op=generarPedido", 
        type: "GET",
        data: { idProveedor:idProveedor, marca:marca, grupo:grupo,  categoria:categoria, precioD5:precioD5, puntoD5:puntoD5 },
		dataType : "json",
		beforeSend: function() {
			$("#btnGenerar").prop("disabled",true);
			$('#espere').show();
			$('#espere').html("<img height='auto' width='300' src='../files/gif/tenor.gif' />");
    	},			
        complete: function(datos){
			$('#modalFiltroPrecioPorPack').modal('hide'); 
			$('#espere').hide();
            filtrarGenerado6();
			$("#btnGenerar").prop("disabled",false);

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


//Función Listar
function filtrarGenerado6()
{

	var idProveedor = $('#proveedorD6').val();
	var marca = $('#marcaD6').val();
	var grupo = $('#grupoD6').val();
	var categoria = $('#categoriaD6').val();
	var precioD6 = $('#precioGsPrecio_lD6').val(); 
	var puntoD6 = $('#puntos_lD6').val();
	var sucursal = $('#sucursalD6').val();

	tabla=$('#detallesPrecioPorPack').dataTable(
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
					url: '../ajax/promocion.php?op=listarFiltrado6',
					type : "get",
        			data : { idProveedor:idProveedor, marca:marca, grupo:grupo,  categoria:categoria, precioD6:precioD6, 
        					puntoD6:puntoD6 , sucursal:sucursal },
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 50,//Paginación
	    "order": [[ 1, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}

 





function addPromociondescuento()
  {
   	
	var tipoDescuento = $("#tipoDescuento_l option:selected").val();
  	var tipoDescuento_text = $("#tipoDescuento_l option:selected").text();

	var Articulo_idArticuloDescuento = $("#Articulo_idArticuloDescuento_l option:selected").val();
  	var Articulo_idArticuloDescuento_text = $("#Articulo_idArticuloDescuento_l option:selected").text();

	var desde = $("#desde_l").val();
	var hasta = $("#hasta_l").val();
	var descuentoPorcentualDescuento = $("#descuentoPorcentualDescuento_l").val();
	var descuentoGsDescuento = $("#descuentoGsDescuento_l").val();

	var sucursal = $("#Sucursal_idSucursalD1 option:selected").val();
	var sucursal_text = $("#Sucursal_idSucursalD1 option:selected").text(); 

	var y=document.getElementById("Sucursal_idSucursalD1").options;
 
	  
	if ( sucursal != '%%' ) {

    	var fila=
    	'<tr class="filaPromocionDescuento" id="filaPromocionDescuento'+contPromocionDescuento+'">'+
    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleTPromocionDescuento ('+contPromocionDescuento+')">X</button></td>'+
    	'<td><input type="hidden" name="tipoDescuento1[]" value="'+tipoDescuento+'">'+tipoDescuento_text+'</td>'+
    	'<td><input type="hidden" name="Articulo_idArticuloDescuento1[]" value="'+Articulo_idArticuloDescuento+'">'+Articulo_idArticuloDescuento_text+'</td>'+
    	'<td><input type="hidden" name="Sucursal_idSucursalD1[]" value="'+sucursal+'">'+sucursal_text+'</td>'+      	
    	'<td><input type="hidden" name="desde1[]" id="desde1[]" value="'+desde+'">'+desde+'</td>'+
    	'<td><input type="hidden" name="hasta1[]" id="hasta1[]" value="'+hasta+'">'+hasta+'</td>'+
    	'<td><input type="hidden" name="descuentoPorcentualDescuento1[]" id="descuentoPorcentualDescuento1[]" value="'+descuentoPorcentualDescuento+'">'+descuentoPorcentualDescuento+'</td>'+
    	'<td><input type="hidden" name="descuentoGsDescuento1[]" id="descuentoGsDescuento1[]" value="'+descuentoGsDescuento+'">'+descuentoGsDescuento+'</td>'+
    	'</tr>';
    	contPromocionDescuento++;
    	detallesPromocionDescuento=detallesPromocionDescuento+1;
    	$('#detalleTipoDescuento').append(fila);
    	//modificarSubototales();

	}else{
		for(var i=1;i<y.length;i++)
		{

		var fila=
    	'<tr class="filaPromocionDescuento" id="filaPromocionDescuento'+contPromocionDescuento+'">'+
    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleTPromocionDescuento ('+contPromocionDescuento+')">X</button></td>'+
    	'<td><input type="hidden" name="tipoDescuento1[]" value="'+tipoDescuento+'">'+tipoDescuento_text+'</td>'+
    	'<td><input type="hidden" name="Articulo_idArticuloDescuento1[]" value="'+Articulo_idArticuloDescuento+'">'+Articulo_idArticuloDescuento_text+'</td>'+
    	'<td><input type="hidden" name="Sucursal_idSucursalD1[]" value="'+y[i].value+'">'+y[i].text+'</td>'+      	
    	'<td><input type="hidden" name="desde1[]" id="desde1[]" value="'+desde+'">'+desde+'</td>'+
    	'<td><input type="hidden" name="hasta1[]" id="hasta1[]" value="'+hasta+'">'+hasta+'</td>'+
    	'<td><input type="hidden" name="descuentoPorcentualDescuento1[]" id="descuentoPorcentualDescuento1[]" value="'+descuentoPorcentualDescuento+'">'+descuentoPorcentualDescuento+'</td>'+
    	'<td><input type="hidden" name="descuentoGsDescuento1[]" id="descuentoGsDescuento1[]" value="'+descuentoGsDescuento+'">'+descuentoGsDescuento+'</td>'+
    	'</tr>';
    	contPromocionDescuento++;
    	detallesPromocionDescuento=detallesPromocionDescuento+1;
    	$('#detalleTipoDescuento').append(fila);
    	//modificarSubototales();					
		} 
	}
  }

  function eliminarDetalleTPromocionDescuento(indice){
  	$("#filaPromocionDescuento" + indice).remove();
  	detallesPromocionDescuento=detallesPromocionDescuento-1;
  }





function addDetallePuntos()
  {
   	
	var Articulo_idArticuloPunto = $("#Articulo_idArticuloPunto_l option:selected").val();
  	var Articulo_idArticuloPunto_text = $("#Articulo_idArticuloPunto_l option:selected").text();

	var sucursal = $("#Sucursal_idSucursalD2 option:selected").val();
	var sucursal_text = $("#Sucursal_idSucursalD2 option:selected").text(); 

	var cantidadPuntos = $("#cantidadPuntos_l").val();

	var y=document.getElementById("Sucursal_idSucursalD2").options;
 
	if ( sucursal != '%%' ) {

    	var fila=
    	'<tr class="filaPuntos" id="filaPuntos'+contPuntos+'">'+
    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetallePuntos('+contPuntos+')">X</button></td>'+
    	'<td><input type="hidden" name="Articulo_idArticuloPunto2[]" value="'+Articulo_idArticuloPunto+'">'+Articulo_idArticuloPunto+'</td>'+
    	'<td><input type="hidden" name="Sucursal_idSucursalD2[]" value="'+sucursal+'">'+sucursal_text+'</td>'+  
    	'<td><input type="hidden" name="cantidadPuntos2[]" value="'+cantidadPuntos+'">'+cantidadPuntos+'</td>'+
    	'</tr>';
    	contPuntos++;
    	detallePuntos=detallePuntos+1;
    	$('#detallePromocionPorPuntos').append(fila);

	}else{
		for(var i=1;i<y.length;i++)
		{
    	var fila=
	    	'<tr class="filaPuntos" id="filaPuntos'+contPuntos+'">'+
	    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetallePuntos('+contPuntos+')">X</button></td>'+
	    	'<td><input type="hidden" name="Articulo_idArticuloPunto2[]" value="'+Articulo_idArticuloPunto+'">'+Articulo_idArticuloPunto+'</td>'+
	    	'<td><input type="hidden" name="Sucursal_idSucursalD2[]" value="'+y[i].value+'">'+y[i].text+'</td>'+  
	    	'<td><input type="hidden" name="cantidadPuntos2[]" value="'+cantidadPuntos+'">'+cantidadPuntos+'</td>'+
	    	'</tr>';
	    	contPuntos++;
	    	detallePuntos=detallePuntos+1;
	    	$('#detallePromocionPorPuntos').append(fila);

    	} 
    }	
  }

  function eliminarDetallePuntos(indice){
  	$("#filaPuntos" + indice).remove();
  	detallePuntos=detallePuntos-1;
  }


function addDetallePromocionFormaPago()
  {
   	
	var Articulo_idArticulo = $("#Articulo_idArticulo_l option:selected").val();
  	var Articulo_idArticulo_text = $("#Articulo_idArticulo_l option:selected").text();

	var FormaPago_idFormaPago = $("#FormaPago_idFormaPago_l option:selected").val();
  	var FormaPago_idFormaPago_text = $("#FormaPago_idFormaPago_l option:selected").text();

	var Banco_idBanco = $("#Banco_idBanco_l option:selected").val();
  	var Banco_idBanco_text = $("#Banco_idBanco_l option:selected").text();

	var descuentoPorcentual = $("#descuentoPorcentual_l").val();
	var descuentoGs = $("#descuentoGs_l").val();

	var sucursal = $("#Sucursal_idSucursalD3 option:selected").val();
	var sucursal_text = $("#Sucursal_idSucursalD3 option:selected").text(); 

	var y=document.getElementById("Sucursal_idSucursalD3").options;
 	console.log(y);
	if ( sucursal != '%%' ) {

    	var fila=
    	'<tr class="filaPromocionFormaPago" id="filaPromocionFormaPago'+contPromocionFormaPago+'">'+
    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetallePromocionFormaPago('+contPromocionFormaPago+')">X</button></td>'+
    	'<td><input type="hidden" name="Articulo_idArticulo3[]" value="'+Articulo_idArticulo+'">'+Articulo_idArticulo_text+'</td>'+
    	'<td><input type="hidden" name="Sucursal_idSucursalD3[]" value="'+sucursal+'">'+sucursal_text+'</td>'+    	
    	'<td><input type="hidden" name="FormaPago_idFormaPago3[]" value="'+FormaPago_idFormaPago+'">'+FormaPago_idFormaPago_text+'</td>'+
    	'<td><input type="hidden" name="Banco_idBanco3[]" value="'+Banco_idBanco+'">'+Banco_idBanco_text+'</td>'+
    	'<td><input type="hidden" name="descuentoPorcentual3[]" id="descuentoPorcentual3[]" value="'+descuentoPorcentual+'">'+descuentoPorcentual+'</td>'+
    	'<td><input type="hidden" name="descuentoGs3[]" id="descuentoGs3[]" value="'+descuentoGs+'">'+descuentoGs+'</td>'+
    	'</tr>';
    	contPromocionFormaPago++;
    	detallesPromocionFormaPago=detallesPromocionFormaPago+1;
    	$('#detallePromocionFormaPago').append(fila);
     
	}else{
		for(var i=1;i<y.length;i++)
		{

    	var fila=
    	'<tr class="filaPromocionFormaPago" id="filaPromocionFormaPago'+contPromocionFormaPago+'">'+
    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetallePromocionFormaPago('+contPromocionFormaPago+')">X</button></td>'+
    	'<td><input type="hidden" name="Articulo_idArticulo3[]" value="'+Articulo_idArticulo+'">'+Articulo_idArticulo_text+'</td>'+
    	'<td><input type="hidden" name="Sucursal_idSucursalD3[]" value="'+y[i].value+'">'+y[i].text+'</td>'+     	
    	'<td><input type="hidden" name="FormaPago_idFormaPago3[]" value="'+FormaPago_idFormaPago+'">'+FormaPago_idFormaPago_text+'</td>'+
    	'<td><input type="hidden" name="Banco_idBanco3[]" value="'+Banco_idBanco+'">'+Banco_idBanco_text+'</td>'+
    	'<td><input type="hidden" name="descuentoPorcentual3[]" id="descuentoPorcentual3[]" value="'+descuentoPorcentual+'">'+descuentoPorcentual+'</td>'+
    	'<td><input type="hidden" name="descuentoGs3[]" id="descuentoGs3[]" value="'+descuentoGs+'">'+descuentoGs+'</td>'+
    	'</tr>';
    	contPromocionFormaPago++;
    	detallesPromocionFormaPago=detallesPromocionFormaPago+1;
    	$('#detallePromocionFormaPago').append(fila);
		}
	}    	
  }

  function eliminarDetallePromocionFormaPago(indice){
  	$("#filaPromocionFormaPago" + indice).remove();
  	detallesPromocionFormaPago=detallesPromocionFormaPago-1;
  }





function addDetallePrecioPorTiempoLimitado()
  {
   	
	var Articulo_idArticulo = $("#Articulo_idArticuloDescuentoPrecioTiempoLimitado_l option:selected").val();
  	var Articulo_idArticulo_text = $("#Articulo_idArticuloDescuentoPrecioTiempoLimitado_l option:selected").text();

	var precioGs = $("#precioGs_l").val();
	var ventaMaxima = $("#ventaMaxima_l").val();

	var sucursal = $("#Sucursal_idSucursalD4 option:selected").val();
	var sucursal_text = $("#Sucursal_idSucursalD4 option:selected").text(); 

	var y=document.getElementById("Sucursal_idSucursalD4").options;
 
	if ( sucursal != '%%' ) {
    	var fila=
    	'<tr class="filaPrecioPorTiempoLimitado" id="filaPrecioPorTiempoLimitado'+contPrecioPorTiempoLimitado+'">'+
    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetallePrecioPorTiempoLimitado('+contPrecioPorTiempoLimitado+')">X</button></td>'+
    	'<td><input type="hidden" name="Articulo_idArticulo4[]" value="'+Articulo_idArticulo+'">'+Articulo_idArticulo_text+'</td>'+
    	'<td><input type="hidden" name="Sucursal_idSucursalD4[]" value="'+sucursal+'">'+sucursal_text+'</td>'+
    	'<td><input type="hidden" name="precioGs4[]" id="precioGs4[]" value="'+precioGs+'">'+precioGs+'</td>'+
    	'<td><input type="hidden" name="ventaMaxima4[]" value="'+ventaMaxima+'">'+ventaMaxima+'</td>'+
    	'</tr>';
    	contPrecioPorTiempoLimitado++;
    	detallesPPrecioPorTiempoLimitado=detallesPPrecioPorTiempoLimitado+1;
    	$('#detallePrecioTiempoLimitado').append(fila);
	}else{
		for(var i=1;i<y.length;i++)
		{    	
	    	var fila=
	    	'<tr class="filaPrecioPorTiempoLimitado" id="filaPrecioPorTiempoLimitado'+contPrecioPorTiempoLimitado+'">'+
	    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetallePrecioPorTiempoLimitado('+contPrecioPorTiempoLimitado+')">X</button></td>'+
	    	'<td><input type="hidden" name="Articulo_idArticulo4[]" value="'+Articulo_idArticulo+'">'+Articulo_idArticulo_text+'</td>'+
	    	'<td><input type="hidden" name="Sucursal_idSucursalD4[]" value="'+y[i].value+'">'+y[i].text+'</td>'+  
	    	'<td><input type="hidden" name="precioGs4[]" id="precioGs4[]" value="'+precioGs+'">'+precioGs+'</td>'+
	    	'<td><input type="hidden" name="ventaMaxima4[]" value="'+ventaMaxima+'">'+ventaMaxima+'</td>'+
	    	'</tr>';
	    	contPrecioPorTiempoLimitado++;
	    	detallesPPrecioPorTiempoLimitado=detallesPPrecioPorTiempoLimitado+1;
	    	$('#detallePrecioTiempoLimitado').append(fila);    	
		}    	
  	}

  }

  function eliminarDetallePrecioPorTiempoLimitado(indice){
  	$("#filaPrecioPorTiempoLimitado" + indice).remove();
  	detallesPPrecioPorTiempoLimitado=detallesPPrecioPorTiempoLimitado-1;
  }


function addDetallePrecioPorPunto()
  {
   	
	var Articulo_idArticulo = $("#Articulo_idArticuloPrecioPuntos_l option:selected").val();
  	var Articulo_idArticulo_text = $("#Articulo_idArticuloPrecioPuntos_l option:selected").text();

	var precioGs = $("#precioGsPrecio_l").val();
	var puntos = $("#puntos_l").val();

	var sucursal = $("#Sucursal_idSucursalD5 option:selected").val();
	var sucursal_text = $("#Sucursal_idSucursalD5 option:selected").text(); 
	var y=document.getElementById("Sucursal_idSucursalD5").options;
 
	if ( sucursal != '%%' ) {
    	var fila=
    	'<tr class="filaPrecioPorPunto" id="filaPrecioPorPunto'+contPrecioPorPunto+'">'+
    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetallePrecioPorPunto('+contPrecioPorPunto+')">X</button></td>'+
    	'<td><input type="hidden" name="Articulo_idArticulo5[]" value="'+Articulo_idArticulo+'">'+Articulo_idArticulo_text+'</td>'+
    	'<td><input type="hidden" name="Sucursal_idSucursalD5[]" value="'+sucursal+'">'+sucursal_text+'</td>'+
    	'<td><input type="hidden" name="precioGsPrecio_l5[]" id="precioGsPrecio_l5[]" value="'+precioGsPrecio_l+'">'+precioGs+'</td>'+
    	'<td><input type="hidden" name="puntos5[]" value="'+puntos+'">'+puntos+'</td>'+
    	'</tr>';
    	contPrecioPorPunto++;
    	detallePrecioPorPunto=detallePrecioPorPunto+1;
    	$('#detallesPrecioPorPunto').append(fila);
	}else{
		for(var i=1;i<y.length;i++)
		{  
	    	var fila=
	    	'<tr class="filaPrecioPorPunto" id="filaPrecioPorPunto'+contPrecioPorPunto+'">'+
	    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetallePrecioPorPunto('+contPrecioPorPunto+')">X</button></td>'+
	    	'<td><input type="hidden" name="Articulo_idArticulo5[]" value="'+Articulo_idArticulo+'">'+Articulo_idArticulo_text+'</td>'+
	    	'<td><input type="hidden" name="Sucursal_idSucursalD5[]" value="'+y[i].value+'">'+y[i].text+'</td>'+ 
	    	'<td><input type="hidden" name="precioGsPrecio_l5[]" id="precioGsPrecio_l5[]" value="'+precioGsPrecio_l+'">'+precioGs+'</td>'+
	    	'<td><input type="hidden" name="puntos5[]" value="'+puntos+'">'+puntos+'</td>'+
	    	'</tr>';
	    	contPrecioPorPunto++;
	    	detallePrecioPorPunto=detallePrecioPorPunto+1;
	    	$('#detallesPrecioPorPunto').append(fila);			
		}
	}	
  }

  function eliminarDetallePrecioPorPunto(indice){
  	$("#filaPrecioPorPunto" + indice).remove();
  	detallePrecioPorPunto=detallePrecioPorPunto-1;
  }



function addDetallePrecioPorPack()
  {
   	
	var Articulo_idArticulo = $("#Articulo_idArticuloPrecioPack_l option:selected").val();
  	var Articulo_idArticulo_text = $("#Articulo_idArticuloPrecioPack_l option:selected").text();

	var precioGs = $("#precioGsPrecio_l6").val();
	var puntos = $("#puntos_l6").val();

	var sucursal = $("#Sucursal_idSucursalD6 option:selected").val();
	var sucursal_text = $("#Sucursal_idSucursalD6 option:selected").text(); 
	var porcentaje = $("#porcentaje_l6").val(); 

	var y=document.getElementById("Sucursal_idSucursalD6").options;
 	


	if ( sucursal != '%%' ) { 
    	var fila=
    	'<tr class="filaPrecioPorPack" id="filaPrecioPorPack'+contPrecioPorPack+'">'+
    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetallePrecioPorPack('+contPrecioPorPack+')">X</button></td>'+
    	'<td><input type="hidden" name="Articulo_idArticulo6[]" value="'+Articulo_idArticulo+'">'+Articulo_idArticulo_text+'</td>'+
    	'<td><input type="hidden" name="Sucursal_idSucursalD6[]" value="'+sucursal+'">'+sucursal_text+'</td>'+
    	'<td><input type="hidden" name="precioGsPrecio_D6[]" id="precioGsPrecio_D6[]" value="'+precioGsPrecio_l6+'">'+precioGs+'</td>'+
    	'<td><input type="hidden" name="puntos6[]" value="'+puntos+'">'+puntos+'</td>'+
    	'<td><input type="hidden" name="porcentaje6[]" value="'+porcentaje+'">'+porcentaje+'</td>'+
    	'</tr>';
    	contPrecioPorPack++;
    	detallePrecioPorPack=detallePrecioPorPack+1;
    	$('#detallesPrecioPorPack').append(fila); 
	}else{
		for(var i=1;i<y.length;i++)
		{  
	    	var fila=
	    	'<tr class="filaPrecioPorPack" id="filaPrecioPorPack'+contPrecioPorPack+'">'+
	    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetallePrecioPorPack('+contPrecioPorPack+')">X</button></td>'+
	    	'<td><input type="hidden" name="Articulo_idArticulo6[]" value="'+Articulo_idArticulo+'">'+Articulo_idArticulo_text+'</td>'+
	    	'<td><input type="hidden" name="Sucursal_idSucursalD6[]" value="'+y[i].value+'">'+y[i].text+'</td>'+ 
	    	'<td><input type="hidden" name="precioGsPrecio_D6[]" id="precioGsPrecio_D6[]" value="'+precioGsPrecio_l6+'">'+precioGs+'</td>'+
	    	'<td><input type="hidden" name="puntos6[]" value="'+puntos+'">'+puntos+'</td>'+ 
	    	'<td><input type="hidden" name="porcentaje6[]" value="'+porcentaje+'">'+porcentaje+'</td>'+
	    	'</tr>';
	    	contPrecioPorPack++;
	    	detallePrecioPorPack=detallePrecioPorPack+1;
	    	$('#detallesPrecioPorPack').append(fila);			
		}
	}	
  } 

  function eliminarDetallePrecioPorPack(indice){
  	$("#filaPrecioPorPack" + indice).remove();
  	detallePrecioPorPack=detallePrecioPorPack-1; 
  }





//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
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
					url: '../ajax/promocion.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
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
		url: "../ajax/promocion.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          bootbox.alert(datos);	          
	          mostrarform(false);
	          tabla.ajax.reload();
	    }

	});
	limpiar();
}


//Función para desactivar registros
function desactivar(idPromocion)
{
	bootbox.confirm("¿Está Seguro de desactivar la promocion?", function(result){
		if(result)
        {
        	$.post("../ajax/promocion.php?op=desactivar", {idPromocion : idPromocion}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(idPromocion)
{
	bootbox.confirm("¿Está Seguro de activar la promocion?", function(result){
		if(result)
        {
        	$.post("../ajax/promocion.php?op=activar", {idPromocion : idPromocion}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

function mostrar(idPromocion)
{
	$.post("../ajax/promocion.php?op=mostrar",{idPromocion : idPromocion}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#descripcion").val(data.descripcion);
		$("#fechaFin").val(data.fechaFin);
		$("#fechaInicio").val(data.fechaInicio);
 		$("#tipoPromocion").val(data.tipoPromocion);
 		$("#idPromocion").val(data.idPromocion);



 	})

 	$.post("../ajax/promocion.php?op=listarDetalle&idPromocion="+idPromocion,function(r){
	        $("#detalleTipoDescuento").html(r);
	        divPromocionDescuento();
	});	
}



init();