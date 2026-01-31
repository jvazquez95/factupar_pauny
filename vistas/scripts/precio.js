var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

	//Cargamos los items al select grupo
	$.post("../ajax/precio.php?op=selectArticulo", function(r){
	            $("#Articulo_idArticulo").html(r);
	            $('#Articulo_idArticulo').selectpicker('refresh');

	});

	$.post("../ajax/precio.php?op=selectCategoriaCliente", function(r){
	            $("#CategoriaCliente_idCategoriaCliente").html(r);
	            $('#CategoriaCliente_idCategoriaCliente').selectpicker('refresh');

	});

}

//Función limpiar
function limpiar()
{
	$("#Articulo_idArticulo").val("");
	$("#CategoriaCliente_idCategoriaCliente").val("");
	$("#precio").val("");
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
					url: '../ajax/precio.php?op=listar',
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
		url: "../ajax/precio.php?op=guardaryeditar",
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




function mostrar(idPrecio)
{
	$.post("../ajax/precio.php?op=mostrar",{idPrecio : idPrecio},function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

	 	$("#Articulo_idArticulo").val(data.Articulo_idArticulo);
		$("#CategoriaCliente_idCategoriaCliente").val(data.CategoriaCliente_idCategoriaCliente);
		$("#precio").val(data.precio);
		$("#idPrecio").val(data.idPrecio);

 	})
}

//Función para desactivar registros
function desactivar(idPrecio)
{
	bootbox.confirm("¿Está Seguro de desactivar el precio?", function(result){
		if(result)
        {
        	$.post("../ajax/precio.php?op=desactivar", {idPrecio : idPrecio}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(idPrecio)
{
	bootbox.confirm("¿Está Seguro de activar el precio?", function(result){
		if(result)
        {
        	$.post("../ajax/precio.php?op=activar", {idPrecio : idPrecio}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}


init();