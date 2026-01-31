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
	$.post("../ajax/deposito.php?op=selectDepositoTodos", function(r){
		$("#Deposito_idDeposito").html(r);
		$("#Deposito_idDeposito").selectpicker('refresh');

		$("#depositoD1").html(r);
		$("#depositoD1").selectpicker('refresh');

	});

	//cargamos los items al select usuario
	$.post("../ajax/marca.php?op=selectMarca", function(r){
		$("#Marca_idMarca").html(r);
		$("#Marca_idMarca").selectpicker('refresh');

		$("#marcaD1").html(r);
		$("#marcaD1").selectpicker('refresh');

	});

	//cargamos los items al select usuario
	$.post("../ajax/persona.php?op=selectProveedorTodos", function(r){
		$("#Proveedor_idProveedor").html(r);
		$("#Proveedor_idProveedor").selectpicker('refresh');

		$("#proveedorD1").html(r);
		$("#proveedorD1").selectpicker('refresh');

	});	

	//cargamos los items al select usuario
	$.post("../ajax/categoria.php?op=selectCategoriaTodos", function(r){
		$("#Categoria_idCategoria").html(r);
		$("#Categoria_idCategoria").selectpicker('refresh');

		$("#categoriaD1").html(r);
		$("#categoriaD1").selectpicker('refresh');

	});	


	//cargamos los items al select usuario
	$.post("../ajax/sucursal.php?op=selectSucursalTodos", function(r){
		$("#Sucursal_idSucursal").html(r);
		$("#Sucursal_idSucursal").selectpicker('refresh');

		//$("#Sucursal_idSucursalD1").html(r);
		//$("#Sucursal_idSucursalD1").selectpicker('refresh');


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


function actualizarCantidadCaja(x, idArticulo , Deposito_idDeposito, cantidadActual, contPrecio){

 	 

	cantidad = x.value;
	 
	cantidadAct  =  parseInt(cantidadActual.value);
 
	var nuevo = 0;

	nuevo =  cantidadActual - cantidad ;

	var tp = document.getElementsByName("StockPromedio[]");

	var j = 0;

	j =  (tp.length - 1) - contPrecio;

	console.log(contPrecio);

	 
		document.getElementsByName("diferencia[]")[j].value = nuevo;
	 	

	$.ajax({
    	type: "get",
    	url: '../ajax/inventarioAjuste.php?op=actualizarCantidadCaja',
    	data: {cantidad:cantidad,  idArticulo: idArticulo, Deposito_idDeposito:Deposito_idDeposito},
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

function actualizarSucursal(x){

	$.post("../ajax/deposito.php?op=selectSucursalXDeposito", { depositoD1: x.value } , function(data, status)
		{

			data = JSON.parse(data);
			$("#Sucursal_idSucursalD1").val(data.nombre);
			$("#Sucursal_idSucursalD1").html(data.nombre);
			 
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


	var Deposito_idDeposito = $('#Deposito_idDeposito').val();
	var fi = $('#fi').val();
	var ff = $('#ff').val();
	var estado = $('#estado').val();
	var Sucursal_idSucursal = $('#Sucursal_idSucursal').val();
	var Categoria_idCategoria = $('#Categoria_idCategoria').val();


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
					url: '../ajax/inventarioAjuste.php?op=listar',
					type : "get",
					data : { Deposito_idDeposito:Deposito_idDeposito, fi:fi,ff:ff, estado:estado, Sucursal_idSucursal:Sucursal_idSucursal, Categoria_idCategoria:Categoria_idCategoria },
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 50,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}


//Función Listar
function filtrarGenerado()
{


	var Deposito_idDeposito = $('#depositoD1').val();
	var Categoria_idCategoria = $('#categoriaD1').val();
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
					url: '../ajax/inventarioAjuste.php?op=listar',
					type : "get",
					data :  { Deposito_idDeposito:Deposito_idDeposito, fi:fi,ff:ff, estado:estado, Sucursal_idSucursal:Sucursal_idSucursal,Categoria_idCategoria:Categoria_idCategoria },
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
function mostrarDetalle(idAjusteStock)
{

	l_idajustestockdetalle = idAjusteStock;
	g_idAjusteStock = idAjusteStock;
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
					url: '../ajax/inventarioAjuste.php?op=mostrarDetalle',
					type : "get",
					data : { idAjusteStock:idAjusteStock },
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"columnDefs": [
        {
            "targets": [ 0,3,4,5,7],
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
        //var data = tabla.row( this ).data();
        //var l_idProveedor = data[3];
        //var l_sucursal = data[4];
        //verDetalleProveedor(l_idProveedor, l_sucursal);
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

	var Deposito_idDeposito = $('#depositoD1').val();
	var Categoria_idCategoria = $('#categoriaD1').val();
	var Proveedor_idProveedor = $('#proveedorD1').val();
	var Marca_idMarca = $('#marcaD1').val();
	var Estado_idEstado = $('#estadoD1').val(); 

    $.ajax({
        url: "../ajax/inventarioAjuste.php?op=generarPedido",
        type: "GET",
        data: { Deposito_idDeposito:Deposito_idDeposito, Categoria_idCategoria:Categoria_idCategoria,Proveedor_idProveedor:Proveedor_idProveedor,Marca_idMarca:Marca_idMarca, Estado_idEstado:Estado_idEstado },
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