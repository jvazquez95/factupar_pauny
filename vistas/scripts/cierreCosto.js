var tabla;
var tabla2;
var nombre = '';
var cantidad = 0;
var l_idHacerPedido = 0;
var l_idhacerpedidodetalle = 0;
var g_idcierre = 0;
var g_idCampo = 0;
//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	//listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

	//cargamos los items al select usuario
	$.post("../ajax/persona.php?op=selectProveedor", function(r){
		$("#Persona_idPersona").html(r);
		$("#Persona_idPersona").selectpicker('refresh');

		$("#proveedorD1").html(r);
		$("#proveedorD1").selectpicker('refresh');

	});



	$.post("../ajax/centroDeCostos.php?op=selectCentroDeCostos", function(r){
	            $("#CentroCosto_idCentroCostoD").html(r);
	            $('#CentroCosto_idCentroCostoD').selectpicker('refresh');

	            $("#CentroCosto_idCentroCosto").html(r);
	            $('#CentroCosto_idCentroCosto').selectpicker('refresh');

	});



	$.post("../ajax/compra.php?op=selectCompra", function(r){
	            $("#Compra_idCompraBuscador").html(r);
	            $('#Compra_idCompraBuscador').selectpicker('refresh');
	});



	$("#cabecera").show();
	$("#detalle").hide();
	$("#detalle3").hide();


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




function facturapormercaderia(x,id,valor){
	var x = x.value;


	cantidad = x.value;

	$.ajax({
    	type: "get",
    	url: '../ajax/hacerPedido.php?op=actualizarRadio',
    	data: {x:valor, idcierrecostodetalle:id},
		dataType:"json",
	})


}


function facturaporgastoparticular(x,id,valor){
var x = x.value;


	cantidad = x.value;

	$.ajax({
    	type: "get",
    	url: '../ajax/hacerPedido.php?op=actualizarRadio',
    	data: {x:valor, idcierrecostodetalle:id},
		dataType:"json",
	})

}


function facturaporgastogeneral(x,id,valor){
var x = x.value;


	cantidad = x.value;

	$.ajax({
    	type: "get",
    	url: '../ajax/hacerPedido.php?op=actualizarRadio',
    	data: {x:valor, idcierrecostodetalle:id},
		dataType:"json",
	})

}


function actualizarCompraAsignada(x, id){
var x = x.value;

	$.ajax({
    	type: "get",
    	url: '../ajax/hacerPedido.php?op=actualizarCompraAsignada',
    	data: {idCompraAsignada:x, idcierrecostodetalle:id},
		dataType:"json",
	})

}


function actualizarCompraAsignada2(x, id){

	$.ajax({
    	type: "get",
    	url: '../ajax/hacerPedido.php?op=actualizarCompraAsignada',
    	data: {idCompraAsignada:x, idcierrecostodetalle:id},
		dataType:"json",
	})

}


function actualizarComentario(x, id){
var x = x.value;


	cantidad = x.value;

	$.ajax({
    	type: "get",
    	url: '../ajax/hacerPedido.php?op=actualizarComentario',
    	data: {comentario:x, idcierrecostodetalle:id},
		dataType:"json",
	})

}





function actualizarCantidadCaja(x,Articulo_idArticulo){


	cantidad = x.value;

	$.ajax({
    	type: "get",
    	url: '../ajax/hacerPedido.php?op=actualizarCantidadCaja',
    	data: {cantidad:cantidad, Articulo_idArticulo:Articulo_idArticulo},
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


function actualizarMargen(Articulo_idArticulo, Sucursal_idSucursal ,margen){


	//cantidad = x.value;

	$.ajax({
    	type: "get",
    	url: '../ajax/hacerPedido.php?op=actualizarMargen',
    	data: {Articulo_idArticulo:Articulo_idArticulo, Sucursal_idSucursal:Sucursal_idSucursal, margen:margen},
		dataType:"json",
	})

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



function buscarFactura(x, id){
	g_idCampo = x.id;
	g_idcierre = id;
	$("#modalBuscarFactura").show();
}


function asignarFacturaCampo(){
	$("#modalBuscarFactura").hide();
  	var idFactura = $("#Compra_idCompraBuscador option:selected").val();
  	$("#" + g_idCampo ).val( idFactura );
  	actualizarCompraAsignada2(idFactura, g_idcierre);
}


//Función Listar
function filtrar()
{

	var CentroCosto_idCentroCosto = $('#CentroCosto_idCentroCosto').val();



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
					url: '../ajax/hacerPedido.php?op=listarCierreCosto',
					type : "get",
					data : { CentroCosto_idCentroCosto:CentroCosto_idCentroCosto},
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


	var CentroCosto_idCentroCostoD = $('#CentroCosto_idCentroCostoD').val();


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
					url: '../ajax/hacerPedido.php?op=listarCierreCosto',
					type : "get",
					data : { CentroCosto_idCentroCosto:CentroCosto_idCentroCostoD },
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

/*	//$('#modalHacerPedidoProveedor').modal('show');

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
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
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

*/
}


function mostrarMenu(){
	$("#cabecera").show();
	$("#detalle").hide();
	$("#detalle3").hide();

}


function generarOc(){

swal({
	  title: 'Esta seguro de cerrar la asignacion de costos?',
	  text: "",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Si, cerrar!'
	}).then((result) => {
	  if (result.value) {
	

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
					url: '../ajax/hacerPedido.php?op=mostrarDetalleProrrateo',
					type : "get",
					data : { id:l_idhacerpedidodetalle },
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


	  	$("#cabecera").hide();
		$("#detalle").hide();
		$("#detalle3").show();



	  }
	})




}


function salir(){

	  	$("#cabecera").show();
		$("#detalle").hide();
		$("#detalle3").hide();

}


//Función Listar
function mostrarDetalle(id)
{

	l_idhacerpedidodetalle = id;

	$("#cabecera").hide();
	$("#detalle").show();


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
					url: '../ajax/hacerPedido.php?op=mostrarDetalleCierreCosto',
					type : "get",
					data : { id:id },
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy":true,
        "scrollY":        "380px",
        "scrollCollapse": true,
        "paging":         false,
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();

    $('#tbllistadoDetalle tbody').on('click', 'tr', function () {
        var data = tabla.row( this ).data();
        var l_idProveedor = data[3];
        var l_sucursal = data[4];
        verDetalleProveedor(l_idProveedor, l_sucursal);
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

	var CentroCosto_idCentroCostoD = $('#CentroCosto_idCentroCostoD').val();
	
    $.ajax({
        url: "../ajax/hacerPedido.php?op=generarCierreCosto",
        type: "GET",
        data: { CentroCosto_idCentroCosto:CentroCosto_idCentroCostoD },
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