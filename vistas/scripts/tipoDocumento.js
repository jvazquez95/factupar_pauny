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
	$.post("../ajax/tipoDocumento.php?op=selectCuentaContable", function(r){
	            $("#CuentaContable_idCuentaContable").html(r);
	            $('#CuentaContable_idCuentaContable').selectpicker('refresh');

	}); 
 
	//Cargamos los items al select grupo
	$.post("../ajax/tipoDocumento.php?op=selectProceso", function(r){
	            $("#Proceso_idProceso").html(r);
	            $('#Proceso_idProceso').selectpicker('refresh');

	}); 	


}

//Función limpiar
function limpiar()
{
	$("#idTipoDocumento").val("");
	$("#descripcion").val("");

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
					url: '../ajax/tipoDocumento.php?op=listar',
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
		url: "../ajax/tipoDocumento.php?op=guardaryeditar",
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

function mostrar(idTipoDocumento)
{
	$.post("../ajax/tipoDocumento.php?op=mostrar",{idTipoDocumento : idTipoDocumento}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

	$("#descripcion").val(data.descripcion);
	$("#idTipoDocumento").val(data.idTipoDocumento);

 	})
}

//Función para desactivar registros
function desactivar(idTipoDocumento)
{
	bootbox.confirm("¿Está Seguro de desactivar el Tipo Documento?", function(result){
		if(result)
        {
        	$.post("../ajax/tipoDocumento.php?op=desactivar", {idTipoDocumento : idTipoDocumento}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(idTipoDocumento)
{
	bootbox.confirm("¿Está Seguro de activar el Tipo Documento?", function(result){
		if(result)
        {
        	$.post("../ajax/tipoDocumento.php?op=activar", {idTipoDocumento : idTipoDocumento}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//función para generar el código de barras
function generarbarcode()
{
	codigo=$("#codigoBarra").val();
	JsBarcode("#barcode", codigo);
	$("#print").show();
}

//Función para imprimir el Código de barras
function imprimir()
{
	$("#print").printArea();
}

init();