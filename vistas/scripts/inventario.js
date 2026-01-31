var tabla;
var tabla2;
var nombre = '';
var cantidad = 0;
var l_idHacerPedido = 0;
var l_idhacerpedidodetalle = 0;
//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	filtrarGenerado();

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


	//cargamos los items al select usuario
	$.post("../ajax/sucursal.php?op=selectSucursalTodos", function(r){
		$("#Sucursal_idSucursal").html(r);
		$("#Sucursal_idSucursal").selectpicker('refresh');

		$("#Sucursal_idSucursalD1").html(r);
		$("#Sucursal_idSucursalD1").selectpicker('refresh');

	});


	//cargamos los items al select usuario
	$.post("../ajax/deposito.php?op=selectDepositoTodos", function(r){
		$("#Deposito_idDeposito").html(r);
		$("#Deposito_idDeposito").selectpicker('refresh');

		$("#Deposito_idDepositoD1").html(r);
		$("#Deposito_idDepositoD1").selectpicker('refresh');

	});



	//cargamos los items al select usuario
	$.post("../ajax/marca.php?op=selectMarcaTodos", function(r){
		$("#Marca_idMarca").html(r);
		$("#Marca_idMarca").selectpicker('refresh');

		$("#Marca_idMarcaD1").html(r);
		$("#Marca_idMarcaD1").selectpicker('refresh');

	});


	//cargamos los items al select usuario
	$.post("../ajax/categoria.php?op=selectCategoriaTodos", function(r){
		$("#Categoria_idCategoria").html(r);
		$("#Categoria_idCategoria").selectpicker('refresh');

		$("#Categoria_idCategoriaD1").html(r);
		$("#Categoria_idCategoriaD1").selectpicker('refresh');

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
		"responsive": true,
		"bDestroy": true,
		"iDisplayLength": 50,//Paginación
	    "order": [[ 1, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}


//Función Listar
function filtrarGenerado()
{

	var Persona_idPersona = $('#Persona_idPersona').val();
	var Sucursal_idSucursal = $('#Sucursal_idSucursal').val();
	var Deposito_idDeposito = $('#Deposito_idDeposito').val();
	var Marca_idMarca = $('#Marca_idMarca').val();
	var Categoria_idCategoria = $('#Categoria_idCategoria').val();
	var fi = $('#fi').val();
	var ff = $('#ff').val();
	var estado = $('#estado').val();
	


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
					url: '../ajax/hacerPedido.php?op=listarInventario',
					type : "get",
					data : {Persona_idPersona:Persona_idPersona, Sucursal_idSucursal:Sucursal_idSucursal, Deposito_idDeposito:Deposito_idDeposito, Marca_idMarca:Marca_idMarca,Categoria_idCategoria:Categoria_idCategoria, fi:fi, ff:ff, estado:estado },
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
						"responsive": true,
		"bDestroy": true,
		"iDisplayLength": 50,//Paginación
	    "order": [[ 1, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}

//Función Listar
function verDetalleProveedor(idArticulo, idSucursal)
{

	//$('#modalHacerPedidoProveedor').modal('show');


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

    complete: function(data)
	{	
			swal({
			  position: 'top-end',
			  type: 'success',
			  title: 'complete',
			  showConfirmButton: false,
			  timer: 1500
			 })		
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
					url: '../ajax/hacerPedido.php?op=mostrarDetalleInventario',
					type : "get",
					data : { idInventario:idHacerPedido },
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

	var nombre = $('#nombre').val();
	var idProveedor = $('#proveedorD1').val();
	var idDeposito = $('#Deposito_idDepositoD1').val();
	var idMarca = $('#Marca_idMarcaD1').val();
	var idCategoria = $('#Categoria_idCategoriaD1').val();



    $.ajax({
        url: "../ajax/hacerPedido.php?op=generarInventario",
        type: "GET",
        data: { idProveedor:idProveedor, nombre:nombre, idDeposito:idDeposito, idMarca:idMarca, idCategoria:idCategoria },
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