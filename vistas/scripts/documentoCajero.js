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
	$.post("../ajax/documentoCajero.php?op=selectUsuario", function(r){
	            $("#Usuario_idUsuario").html(r);
	            $('#Usuario_idUsuario').selectpicker('refresh');

	});

	//Cargamos los items al select categoria
	$.post("../ajax/documentoCajero.php?op=selectTipoDocumento", function(r){
	            $("#Documento_idTipoDocumento").html(r);
	            $('#Documento_idTipoDocumento').selectpicker('refresh');

	});
}

//Función limpiar
function limpiar()
{
	$("#idDocumentoCajero").val("");
	$("#Documento_idTipoDocumento").val("");
	$("#Usuario_idUsuario").val("");
	$("#numeroInicial").val("");
	$("#numeroFinal").val("");
	$("#numeroActual").val("");
	$("#fechaEntrega").val("");
	$("#serie").val("");
	$("#timbrado").val("");
	$("#nroAutorizacion").val("");
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
					url: '../ajax/documentoCajero.php?op=listar',
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
		url: "../ajax/documentoCajero.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
			swal({
			  position: 'top-end',
			  type: 'success',
			  title: datos,
			  showConfirmButton: false,
			  timer: 1500
			 })	          
	          mostrarform(false);
	          tabla.ajax.reload();
	    }

	});
	limpiar();
}

function mostrar(idDocumentoCajero)
{
	$.post("../ajax/documentoCajero.php?op=mostrar",{idDocumentoCajero : idDocumentoCajero}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#Documento_idTipoDocumento").val(data.Documento_idTipoDocumento);
		$("#Documento_idTipoDocumento").selectpicker('refresh');
		$("#Usuario_idUsuario").val(data.Usuario_idUsuario);
		$("#Usuario_idUsuario").selectpicker('refresh');
		$("#numeroInicial").val(data.numeroInicial);
		$("#numeroFinal").val(data.numeroFinal);
		$("#numeroActual").val(data.numeroActual);
		$("#fechaEntrega").val(data.fechaEntrega);
		$("#serie").val(data.serie);
		$("#timbrado").val(data.timbrado);
		$("#nroAutorizacion").val(data.nroAutorizacion);
		$("#idDocumentoCajero").val(data.idDocumentoCajero);
		

 	})
}


//Función para desactivar registros
function desactivar(idDocumentoCajero)
{

        	$.post("../ajax/documentoCajero.php?op=desactivar", {idDocumentoCajero : idDocumentoCajero}, function(e){
	            tabla.ajax.reload();
        	});	

}

//Función para activar registros
function activar(idDocumentoCajero)
{
	bootbox.confirm("¿Está Seguro de activar la Categoría?", function(result){
		if(result)
        {
        	$.post("../ajax/documentoCajero.php?op=activar", {idDocumentoCajero : idDocumentoCajero}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}


init();