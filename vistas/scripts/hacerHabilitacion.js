var tabla;
var tabla2;
var nombre = '';
var cantidad = 0;
var l_idHacerPedido = 0;
var g_idHacerPedido = 0;
var l_idhacerpedidodetalle = 0;
//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	//listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

	//cargamos los items al select usuario
	$.post("../ajax/habilitacion.php?op=selectUsuario", function(r){
		$("#Persona_idPersona").html(r);
		$("#Persona_idPersona").selectpicker('refresh');

		$("#proveedorD1").html(r);
		$("#proveedorD1").selectpicker('refresh');



	});


	//cargamos los items al select usuario
	$.post("../ajax/habilitacion.php?op=selectCaja", function(r){
		$("#Caja_idCaja").html(r);
		$("#Caja_idCaja").selectpicker('refresh');
	});

	//cargamos los items al select usuario
	$.post("../ajax/moneda.php?op=selectMonedaTodos", function(r){
		$("#Moneda_idMoneda").html(r);
		$("#Moneda_idMoneda").selectpicker('refresh');

		$("#Moneda_idMonedaD1").html(r);
		$("#Moneda_idMonedaD1").selectpicker('refresh');

		$("#Moneda_idMonedaD2").html(r);
		$("#Moneda_idMonedaD2").selectpicker('refresh');


	});


	$("#cabecera").show();
	$("#detalle").hide();


}

//Función mostrar formulario
function actualizaform()
{
	limpiar();
 	window.location = ("../vistas/cargaHabilitacion.php") ;
}



function actualizarMontoCierre(x,item,item2){

	montoCierre = x.value;

	$.ajax({
    	type: "get",
    	url: '../ajax/consultas.php?op=actualizarMontoCierre',
    	data: {item:item, montoCierre:montoCierre},
		dataType:"json",
	})

}


function noCambiar(x){

	//esta funcion solo se activa si la factura se genera desde una orden de venta.
	$.post("../ajax/moneda.php?op=selectMonedaDenominacion", { id:x.value }, function(r){
	            $("#Denominacion_idDenominacionD1").html(r);
	            $('#Denominacion_idDenominacionD1').selectpicker('refresh');
	});	

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

//Función limpiar
function limpiar()
{
	$("#idBarrio").val("");
	$("#descripcion").val("");
	$("#Ciudad_idCiudad").val("");
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


function mostrarProveedor(){
	$('#modalHacerPedidoDetalle').modal('show');
}


function addProductoDetalle(){
	$('#modalHacerPedidoDetalleArticulo').modal('show');
}


function actualizarMontoCierre(x,item,item2){

	montoCierre = x.value;

	$.ajax({
    	type: "get",
    	url: '../ajax/consultas.php?op=actualizarMontoCierre',
    	data: {item:item, montoCierre:montoCierre},
		dataType:"json",
	})

}


function actualizarNombreProducto(x,Articulo_idArticulo){


	nombre = x.value;

	$.ajax({
    	type: "get",
    	url: '../ajax/hacerPedido.php?op=actualizarNombreProducto',
    	data: {nombre:nombre, Articulo_idArticulo:Articulo_idArticulo},
		dataType:"json",
	})

}



function actualizarPedido(x,idHacerPedidoDetalle){


	cantidad = x.value;

	$.ajax({
    	type: "get",
    	url: '../ajax/hacerPedido.php?op=actualizarPedido',
    	data: {cantidad:cantidad, idHacerPedidoDetalle:idHacerPedidoDetalle},
		dataType:"json",
	})

}


function actualizarMargen(x, Articulo_idArticulo, Sucursal_idSucursal ,margenActual){


	margen = x.value;


	if (margen != margenActual) {


	$.ajax({
    	type: "get",
    	url: '../ajax/hacerPedido.php?op=actualizarMargen',
    	data: {Articulo_idArticulo:Articulo_idArticulo, Sucursal_idSucursal:Sucursal_idSucursal, margen:margen},
		dataType:"json",
	})
		
	}


	if (margen < margenActual) {
		var id = x.id;
		$("#" + id).css("color", "red");
	}else{
		var id = x.id;
		$("#" + id).css("color", "black");
	}


	

}



function descontinuar(x, idArticulo){
	var check = x.checked;
	$.ajax({
    	type: "get",
    	url: '../ajax/hacerPedido.php?op=descontinuar',
    	data: {check:check, idArticulo:idArticulo},
		dataType:"json",
	})	
}

//Función Listar
function filtrar()
{


	var idProveedor = $('#Persona_idPersona').val();
	var fi = $('#fi').val();
	var ff = $('#ff').val();
	var estado = $('#estado').val();
	var Moneda_idMoneda = $('#Moneda_idMoneda').val();



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
					url: '../ajax/habilitacion.php?op=listarHacerHabilitacion',
					type : "get",
					data : { idProveedor:idProveedor, fi:fi,ff:ff, estado:estado, Moneda_idMoneda:Moneda_idMoneda },
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


//Función Listar
function filtrarGenerado()
{


	var idProveedor = $('#proveedorD1').val();
	var fi = $('#fi').val();
	var ff = $('#ff').val();
	var estado = $('#estado').val();
	var Sucursal_idSucursal = $('#Sucursal_idSucursalD1').val();



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
					url: '../ajax/hacerPedido.php?op=listar',
					type : "get",
					data : { idProveedor:idProveedor, fi:fi,ff:ff, estado:estado, Sucursal_idSucursal:Sucursal_idSucursal },
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

//Función Listar
function verDetalleProveedor(idArticulo, idSucursal)
{

	//$('#modalHacerPedidoProveedor').modal('show');

	//TABLA 1
	tabla2=$('#tbllistadoDetalleProveedor').dataTable(
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
					url: '../ajax/hacerPedido.php?op=mostrarDetalleProveedor',
					type : "get",
					data : { idArticulo:idArticulo,idSucursal:idSucursal },
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"scrollY":        "380px",
        "scrollCollapse": true,
        "paging":         false,
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();


	//TABLA 2
	tabla2=$('#tbllistadoDetalle2').dataTable(
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
					url: '../ajax/hacerPedido.php?op=mostrarDetalle2',
					type : "get",
					data : { idArticulo:idArticulo,idSucursal:idSucursal },
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"scrollY":        "380px",
        "scrollCollapse": true,
        "paging":         false,
	    "order": [[ 3, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();

	//TABLA 3
	tabla2=$('#tbllistadoDetalle3').dataTable(
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
					url: '../ajax/hacerPedido.php?op=mostrarDetalle3',
					type : "get",
					data : { idArticulo:idArticulo,idSucursal:idSucursal },
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"scrollY":        "380px",
        "scrollCollapse": true,
        "paging":         false,
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();


}


function mostrarMenu(){
	$("#cabecera").show();
	$("#detalle").hide();

}


function generarOc(){

swal({
	  title: 'Esta seguro de generar la Orden de Compra?',
	  text: "",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Si, generar!'
	}).then((result) => {
	  if (result.value) {
			$.ajax({
    type: "get",
    url: '../ajax/hacerPedido.php?op=generarOc',
    data: {idHacerPedido:l_idhacerpedidodetalle},
	dataType:"json",

    complete: function(e)
	{	
			//data = JSON.parse(data);		
			//alert(e.responseText);


			var resp = e.responseText;
			resp = parseInt(resp);

			if (resp === 1 ) 
			{

			swal({
			  position: 'top-end',
			  type: 'success',
			  title: 'Generado correctamente',
			  showConfirmButton: false,
			  timer: 1500
			 })	

			}else{


			swal({
			  position: 'top-end',
			  type: 'warning',
			  title: 'Error al generar',
			  showConfirmButton: false,
			  timer: 1500
			 })	


			}

	
    //	listar();
    }

	});
	  }
	})




}



function mostrarDetalle(idHabilitacion){
	$('#modal_detalle').modal('show');
	$("#detalle").val(idHabilitacion);
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
					url: '../ajax/consultas.php?op=rpt_habilitacion_detalle',
					data:{idHabilitacion:idHabilitacion},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
  			"columnDefs": [
            {
                "targets": [ 0,1,2,3,4,5 ],
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
 
        }
    } );
} );
}





//Función para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/barrio.php?op=guardaryeditar",
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
function generarPedido()
{

	var idProveedor = $('#proveedorD1').val();
	var Denominacion_idDenominacion = $('#Denominacion_idDenominacionD1').val();
	var Moneda_idMoneda = $('#Moneda_idMonedaD1').val();
	var cantidad = $('#cantidad').val();

    $.ajax({
        url: "../ajax/habilitacion.php?op=generarPedido",
        type: "GET",
        data: { idProveedor:idProveedor, Denominacion_idDenominacion:Denominacion_idDenominacion, Moneda_idMoneda:Moneda_idMoneda,  cantidad:cantidad },
		dataType : "json",
		beforeSend: function() {
			$("#btnGenerar").prop("disabled",true);
			$('#espere').show();
			$('#espere').html("<img height='auto' width='300' src='../files/gif/tenor.gif' />");
    	},			
        complete: function(datos){
			$('#modalHacerPedidoDetalle').modal('hide');
			$('#espere').hide();
            filtrarGenerado();
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




//Función para desactivar registros
function generarPedidoArticulo()
{

	var idHacerPedido = g_idHacerPedido;
	var Moneda_idMoneda = $('#Moneda_idMonedaD2').val();
	var  Articulo_idArticulo = $('#buscar_articulo').val();



    $.ajax({
        url: "../ajax/hacerPedido.php?op=generarPedidoArticulo",
        type: "GET",
        data: { idHacerPedido:idHacerPedido, Moneda_idMoneda:Moneda_idMoneda, Articulo_idArticulo:Articulo_idArticulo },
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





//Función para desactivar registros
function desactivar(idBarrio)
{
	bootbox.confirm("¿Está Seguro de desactivar la barrio?", function(result){
		if(result)
        {
        	$.post("../ajax/barrio.php?op=desactivar", {idBarrio : idBarrio}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(idBarrio)
{
	bootbox.confirm("¿Está Seguro de activar la barrio?", function(result){
		if(result)
        {
        	$.post("../ajax/barrio.php?op=activar", {idBarrio : idBarrio}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

/*function mostrar(idHacerPedido)
{
	$.post("../ajax/hacerPedido.php?op=mostrar",{idHacerPedido : idHacerPedido}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#descripcion").val(data.descripcion);
		$("#Ciudad_idCiudad").val(data.Ciudad_idCiudad);
 		$("#idBarrio").val(data.idBarrio);

 	})
}*/



init();