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

	//Cargamos los items al select categoria
	$.post("../ajax/cliente.php?op=selectCategoria", function(r){
	            $("#idCategoriaCliente").html(r);
	            $('#idCategoriaCliente').selectpicker('refresh');

	});

	$("#imagenmuestra").hide();
}

//Función limpiar
function limpiar()
{
	$("#idEmpleado").val("");
	$("#razonSocial").val("");
	$("#nombreComercial").val("");
	$("#tipoDocumento").val("");
	$("#nroDocumento").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#celular").val("");
	$("#mail").val("");
	$("#moneda").val("");
	$("#sitioWeb").val("");
	$("#idCategoriaCliente").val("");
	$("#terminoPago").val("");
	$("#terminoPagoHabilitado").val("");
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
					url: '../ajax/empleado.php?op=listar',
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
		url: "../ajax/empleado.php?op=guardaryeditar",
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

function mostrar(idEmpleado)
{
	$.post("../ajax/empleado.php?op=mostrar",{idEmpleado : idEmpleado}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

	$("#razonSocial").val(data.razonSocial);
	$("#nombreComercial").val(data.nombreComercial);
	$("#tipoDocumento").val(data.tipoDocumento);
	$("#tipoDocumento").selectpicker('refresh');
	$("#nroDocumento").val(data.nroDocumento);
	$("#nacimiento").val(data.nacimiento);
	$("#direccion").val(data.direccion);
	$("#telefono").val(data.telefono);
	$("#celular").val(data.celular);
	$("#mail").val(data.mail);
	$("#moneda").val(data.moneda);
	$("#sitioWeb").val(data.sitioWeb);
	$("#idCategoriaCliente").val(data.idCategoriaCliente);
	$("#terminoPago").val(data.terminoPago);
	$("#terminoPagoHabilitado").val(data.terminoPagoHabilitado);
	$("#idEmpleado").val(data.idEmpleado);

 	})
}

//Función para desactivar registros
function desactivar(idEmpleado)
{

        	$.post("../ajax/empleado.php?op=desactivar", {idEmpleado : idEmpleado}, function(e){

	            tabla.ajax.reload();
        	});	

}

//Función para activar registros
function activar(idEmpleado)
{
	bootbox.confirm("¿Está Seguro de activar el empleado?", function(result){
		if(result)
        {
        	$.post("../ajax/empleado.php?op=activar", {idEmpleado : idEmpleado}, function(e){
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