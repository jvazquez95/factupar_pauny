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

	$("#formularioArticulo").on("submit",function(e)
	{
		guardaryeditarArticulo(e);	
	});


	//cargamos los items al select usuario
	$.post("../ajax/persona.php?op=selectProveedor", function(r){
		$("#Persona_idPersona").html(r);
		$("#Persona_idPersona").selectpicker('refresh');

		$("#proveedorD1").html(r);
		$("#proveedorD1").selectpicker('refresh');

	});


	//cargamos los items al select usuario
	$.post("../ajax/sucursal.php?op=selectSucursalTodos", function(r){
		$("#Sucursal_idSucursal").html(r);
		$("#Sucursal_idSucursal").selectpicker('refresh');

		$("#Sucursal_idSucursalD1").html(r);
		$("#Sucursal_idSucursalD1").selectpicker('refresh');

		$("#Sucursal_idSucursalD2").html(r);
		$("#Sucursal_idSucursalD2").selectpicker('refresh');


	});


	$("#cabecera").show();
	$("#detalle").hide();


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
	var Sucursal_idSucursal = $('#Sucursal_idSucursal').val();



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


//Función Listar
function mostrarDetalle(idHacerPedido)
{

	l_idhacerpedidodetalle = idHacerPedido;
	g_idHacerPedido = idHacerPedido;
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
					url: '../ajax/hacerPedido.php?op=mostrarDetalle',
					type : "get",
					data : { idHacerPedido:idHacerPedido },
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"columnDefs": [
        {
            "targets": [ 0,3,4,12,13,14,15,16,17,18,19,20,21,22],
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

	var idProveedor = $('#proveedorD1').val();
	var meses = $('#meses').val();
	var Sucursal_idSucursal = $('#Sucursal_idSucursalD1').val();
	var tipo = $('#tipo').val();

    $.ajax({
        url: "../ajax/hacerPedido.php?op=generarPedido",
        type: "GET",
        data: { idProveedor:idProveedor, meses:meses, Sucursal_idSucursal:Sucursal_idSucursal,  tipo:tipo },
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
	var Sucursal_idSucursal = $('#Sucursal_idSucursalD2').val();
	var  Articulo_idArticulo = $('#buscar_articulo').val();



    $.ajax({
        url: "../ajax/hacerPedido.php?op=generarPedidoArticulo",
        type: "GET",
        data: { idHacerPedido:idHacerPedido, Sucursal_idSucursal:Sucursal_idSucursal, Articulo_idArticulo:Articulo_idArticulo },
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
function editarNombre(idArticulo, descripcion)
{
	$('#editarNombre').modal('show');
 	$('#idArticulo').val(idArticulo);
	$('#nombreArticulo').val(descripcion);
}

function guardaryeditarArticulo(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioArticulo")[0]);

	$.ajax({
		url: "../ajax/articulo.php?op=guardarNombre",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
			swal({
			  position: 'top-end',
			  type: 'success',
			  title: 'Nombre Actualizado, F5 para ver cambios!.',
			  showConfirmButton: false,
			  timer: 3000
			 })		
	    },
	    complete: function(datos){
			$('#editarNombre').modal('hide');
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