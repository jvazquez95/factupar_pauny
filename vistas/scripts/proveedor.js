var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})


	//Cargamos los items al select categoria
	$.post("../ajax/proveedor.php?op=selectCategoria", function(r){
	            $("#idCategoriaProveedor").html(r);
	            $('#idCategoriaProveedor').selectpicker('refresh');

	});

	$("#imagenmuestra").hide();
}

//Función limpiar
function limpiar()
{
	$("#idProveedor").val("");
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
	$("#idCategoriaProveedor").val("");
	$("#terminoPago").val("");
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
					url: '../ajax/proveedor.php?op=listar',
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
		url: "../ajax/proveedor.php?op=guardaryeditar",
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

function mostrar(idProveedor)
{
	$.post("../ajax/proveedor.php?op=mostrar",{idProveedor : idProveedor}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

	$("#razonSocial").val(data.razonSocial);
	$("#nombreComercial").val(data.nombreComercial);
	$("#tipoDocumento").val(data.tipoDocumento);
	$("#tipoDocumento").selectpicker('refresh');
	$("#nroDocumento").val(data.nroDocumento);
	$("#direccion").val(data.direccion);
	$("#telefono").val(data.telefono);
	$("#celular").val(data.celular);
	$("#mail").val(data.mail);
	$("#moneda").val(data.moneda);
	$("#sitioWeb").val(data.sitioWeb);
	$("#idCategoriaProveedor").val(data.idCategoriaProveedor);
	$("#idCategoriaProveedor").selectpicker('refresh');
	$("#terminoPago").val(data.terminoPago);
	$("#idProveedor").val(data.idProveedor);

 	})
}

//Función para desactivar registros
function desactivar(idProveedor)
{
	bootbox.confirm("¿Está Seguro de desactivar el proveedor?", function(result){
		if(result)
        {
        	$.post("../ajax/proveedor.php?op=desactivar", {idProveedor : idProveedor}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(idProveedor)
{
	bootbox.confirm("¿Está Seguro de activar el proveedor?", function(result){
		if(result)
        {
        	$.post("../ajax/proveedor.php?op=activar", {idProveedor : idProveedor}, function(e){
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