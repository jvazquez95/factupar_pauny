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
	$.post("../ajax/obligacion.php?op=selectPersona", function(r){
	            $("#Persona_idPersona").html(r);
	            $('#Persona_idPersona').selectpicker('refresh');

	}); 

	//Cargamos los items al select grupo
	$.post("../ajax/obligacion.php?op=selectMoneda", function(r){
	            $("#Moneda_idMoneda").html(r);
	            $('#Moneda_idMoneda').selectpicker('refresh');

	}); 	

	//Cargamos los items al select grupo
	$.post("../ajax/obligacion.php?op=selectTipoDocumento", function(r){
	            $("#TipoDocumento_idTipoDocumento").html(r);
	            $('#TipoDocumento_idTipoDocumento').selectpicker('refresh');

	});

	//Cargamos los items al select grupo
	$.post("../ajax/obligacion.php?op=selectPago", function(r){
	            $("#Pago_idPago").html(r);
	            $('#Pago_idPago').selectpicker('refresh');

	}); 


}

//Función limpiar
function limpiar()
{
	$("#idObligacion").val("");
	$("#NroObligacion").val("");
	$("#nroDocumento").val("");
	$("#importe").val("");
	$("#saldo").val(""); 
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
					url: '../ajax/obligacion.php?op=listar',
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
		url: "../ajax/obligacion.php?op=guardaryeditar",
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

function mostrar(idObligacion)
{
	$.post("../ajax/obligacion.php?op=mostrar",{idObligacion : idObligacion}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

	    $("#idObligacion").val(data.idObligacion);
		$("#NroObligacion").val(data.NroObligacion);
 		$("#Persona_idPersona").val(data.Persona_idPersona);
 		$("#Moneda_idMoneda").val(data.Moneda_idMoneda);
 		$("#TipoDocumento_idTipoDocumento").val(data.TipoDocumento_idTipoDocumento);
 		$("#nroDocumento").val(data.nroDocumento); 
 		$("#fechaDocumento").val(data.fechaDocumento); 
 		$("#fechaVencimiento").val(data.fechaVencimiento); 
 		$("#fechaPosiblePago").val(data.fechaPosiblePago); 
 		$("#fechadePago").val(data.fechadePago); 
 		$("#Pago_idPago").val(data.Pago_idPago); 
 		$("#importe").val(data.importe);
 		$("#saldo").val(data.saldo);  
 	}) 
}

//Función para desactivar registros
function desactivar(idObligacion)
{
	bootbox.confirm("¿Está Seguro de desactivar la obligacion?", function(result){
		if(result)
        {
        	$.post("../ajax/obligacion.php?op=desactivar", {idObligacion : idObligacion}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(idObligacion)
{
	bootbox.confirm("¿Está Seguro de activar la obligacion?", function(result){
		if(result)
        {
        	$.post("../ajax/obligacion.php?op=activar", {idObligacion : idObligacion}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

 
init();