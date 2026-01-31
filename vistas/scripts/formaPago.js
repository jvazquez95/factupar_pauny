var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})
	
	$.post("../ajax/cuentaContable.php?op=selectCuentaContable", function(r){
	            $("#CuentaContable_idCuentaContable").html(r);
	            $('#CuentaContable_idCuentaContable').selectpicker('refresh');

	}); 

}

//Función limpiar
function limpiar()
{
	$("#idFormaPago").val("");
	$("#descripcion").val("");
	$("#tipo").val("");
	$("#CuentaContable_idCuentaContable").val("");
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
					url: '../ajax/formaPago.php?op=listar',
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
		url: "../ajax/formaPago.php?op=guardaryeditar",
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
function desactivar(idFormaPago)
{

        	$.post("../ajax/formaPago.php?op=desactivar", {idFormaPago : idFormaPago}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	

}

//Función para activar registros
function activar(idFormaPago)
{
	bootbox.confirm("¿Está Seguro de activar la formaPago?", function(result){
		if(result)
        {
        	$.post("../ajax/formaPago.php?op=activar", {idFormaPago : idFormaPago}, function(e){
	            tabla.ajax.reload();
        	});	
        }
	})
}

function mostrar(idFormaPago)
{
	$.post("../ajax/formaPago.php?op=mostrar",{idFormaPago : idFormaPago}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#descripcion").val(data.descripcion);
		$("#tipo").val(data.tipo);
		$("#tipo").selectpicker('refresh');
 		$("#idFormaPago").val(data.idFormaPago);
		$("#CuentaContable_idCuentaContable").val(data.CuentaContable_idCuentaContable);
		$("#CuentaContable_idCuentaContable").selectpicker('refresh');

 	})
}



init();