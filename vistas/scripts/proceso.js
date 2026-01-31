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
	$.post("../ajax/proceso.php?op=selectProveedor", function(r){
	            $("#Persona_idPersonaProveedor").html(r);
	            $('#Persona_idPersonaProveedor').selectpicker('refresh');

	});

	//Cargamos los items al select grupo
	$.post("../ajax/proceso.php?op=selectFuncionario", function(r){
	            $("#Persona_idPersonaDirectivo1").html(r);
	            $('#Persona_idPersonaDirectivo1').selectpicker('refresh');

	});

	//Cargamos los items al select grupo
	$.post("../ajax/proceso.php?op=selectFuncionario2", function(r){
	            $("#Persona_idPersonaDirectivo2").html(r);
	            $('#Persona_idPersonaDirectivo2').selectpicker('refresh');

	});	

	//Cargamos los items al select grupo  
	$.post("../ajax/proceso.php?op=selectProceso", function(r){
	            $("#Proceso_idProcesoApertura").html(r);
	            $('#Proceso_idProcesoApertura').selectpicker('refresh');

	});		 

	//Cargamos los items al select grupo  
	$.post("../ajax/proceso.php?op=selectAsiento", function(r){
	            $("#Asiento_idAsientoCierre").html(r);
	            $('#Asiento_idAsientoCierre').selectpicker('refresh');

	});		 

	$("#imagenmuestra").hide();
}

//Función limpiar
function limpiar()
{
	$("#idProceso").val("");
	$("#ano").val("");
	$("#cargo1").val("");
	$("#cargo2").val("");
	$("#rucContador").val("");
	$("#fechaEjecucion").val("");
	$("#fechaCierre").val("");
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
					url: '../ajax/proceso.php?op=listar',
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
		url: "../ajax/proceso.php?op=guardaryeditar",
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

function mostrar(idProceso)
{
	$.post("../ajax/proceso.php?op=mostrar",{idProceso : idProceso}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

	$("#idProceso").val(data.idProceso); 
	$("#Persona_idPersonaProveedor").val(data.Persona_idPersonaProveedor); 
	$("#ano").val(data.ano); 
	$("#Persona_idPersonaDirectivo1").val(data.Persona_idPersonaDirectivo1); 
	$("#cargo1").val(data.cargo1);
	$("#Persona_idPersonaDirectivo2").val(data.Persona_idPersonaDirectivo2); 
	$("#cargo2").val(data.cargo2);
	$("#rucContador").val(data.rucContador);
	$("#Proceso_idProcesoApertura").val(data.Proceso_idProcesoApertura); 
	$("#fechaEjecucion").val(data.fechaEjecucion);
	$("#Asiento_idAsientoCierre").val(data.Asiento_idAsientoCierre); 
	$("#fechaCierre").val(data.fechaCierre);  
 	})
}

//Función para desactivar registros
function desactivar(idProceso)
{
	bootbox.confirm("¿Está Seguro de desactivar el Proceso?", function(result){
		if(result)
        {
        	$.post("../ajax/proceso.php?op=desactivar", {idProceso : idProceso}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(idProceso)
{
	bootbox.confirm("¿Está Seguro de activar el Proceso?", function(result){
		if(result)
        {
        	$.post("../ajax/proceso.php?op=activar", {idProceso : idProceso}, function(e){
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