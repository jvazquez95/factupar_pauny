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
	$.post("../ajax/copia.php?op=selectProceso", function(r){
	            $("#Proceso_idProceso").html(r);
	            $('#Proceso_idProceso').selectpicker('refresh');

	}); 	

}

//Función limpiar
function limpiar()
{
	$("#idCopia").val("");
	$("#descripcion").val("");
	$("#Proceso_idProceso").val("");
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
					url: '../ajax/copia.php?op=listar',
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
		url: "../ajax/copia.php?op=guardaryeditar",
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

function mostrar(idCopia)
{
	$.post("../ajax/copia.php?op=mostrar",{idCopia : idCopia}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

	    $("#idCopia").val(data.idCopia);
		$("#descripcion").val(data.descripcion);
 		$("#Proceso_idProceso").val(data.Proceso_idProceso);
 		
 	}) 
}

//Función para desactivar registros
function desactivar(idCopia)
{
	bootbox.confirm("¿Está Seguro de desactivar la copia?", function(result){
		if(result)
        {
        	$.post("../ajax/copia.php?op=desactivar", {idCopia : idCopia}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(idCopia)
{
	bootbox.confirm("¿Está Seguro de activar la copia?", function(result){
		if(result)
        {
        	$.post("../ajax/copia.php?op=activar", {idCopia : idCopia}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

 
init();